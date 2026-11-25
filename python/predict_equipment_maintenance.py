import json
import sys
from datetime import date
import numpy as np

DEFAULT_ACTIONS = ["Preventive", "Corrective", "Adaptive"]


def compute_markov_distribution(
    training_rows: list[dict],
    last_type: str | None,
    candidate_actions: list[str],
    alpha: float = 0.5,
) -> tuple[dict[str, float], str]:
    row_counts = {a: alpha for a in candidate_actions}
    global_counts = {a: alpha for a in candidate_actions}
    matched_state = False

    for row in training_rows:
        next_t = str(row.get("next_type", "")).strip()
        if next_t not in global_counts:
            continue
        global_counts[next_t] += 1.0

        row_curr = str(row.get("curr_type", "")).strip()
        if last_type and row_curr == last_type:
            row_counts[next_t] += 1.0
            matched_state = True

    if last_type and matched_state:
        total = sum(row_counts.values())
        return {a: row_counts[a] / total for a in candidate_actions}, "markov_1st_order"

    total = sum(global_counts.values())
    return {a: global_counts[a] / total for a in candidate_actions}, "markov_stationary_prior"


def compute_similarity_distribution(
    training_rows: list[dict],
    target_history: list[dict],
    candidate_actions: list[str],
) -> dict[str, float]:
    last_type = None
    prev_type = "NONE"
    days_since_prev = 0
    curr_cost = 0.0

    if target_history:
        last_rec = target_history[-1]
        last_type = str(last_rec.get("maintenance_type", "")).strip() or None
        curr_cost = float(last_rec.get("maintenance_cost") or 0.0)

        if len(target_history) >= 2:
            prev_rec = target_history[-2]
            prev_type = str(prev_rec.get("maintenance_type", "")).strip() or "NONE"
            if prev_rec.get("maintenance_date") and last_rec.get("maintenance_date"):
                d1 = date.fromisoformat(str(prev_rec["maintenance_date"])[:10])
                d2 = date.fromisoformat(str(last_rec["maintenance_date"])[:10])
                days_since_prev = max(0, (d2 - d1).days)

    scores = {action: 0.1 for action in candidate_actions}

    for row in training_rows:
        next_t = str(row.get("next_type", "")).strip()
        if next_t not in scores:
            continue

        row_curr = str(row.get("curr_type", "")).strip()
        row_prev = str(row.get("prev_type", "NONE")).strip()
        row_days = float(row.get("days_since_prev") or 0.0)
        row_cost = float(row.get("curr_cost") or 0.0)

        weight = 0.25

        if last_type and row_curr == last_type:
            weight += 2.0

        if prev_type != "NONE" and row_prev == prev_type and (not last_type or row_curr == last_type):
            weight += 1.0

        if days_since_prev > 0 and row_days > 0:
            diff_ratio = abs(row_days - days_since_prev) / max(row_days, days_since_prev, 1.0)
            weight += max(0.0, 0.5 * (1.0 - min(diff_ratio, 1.0)))

        cost_diff = abs(np.log1p(max(0.0, row_cost)) - np.log1p(max(0.0, curr_cost)))
        weight += max(0.0, 0.25 * (1.0 - min(cost_diff / 5.0, 1.0)))

        scores[next_t] += weight

    total = sum(scores.values())
    return {a: scores[a] / total for a in candidate_actions}


def compute_probabilities(
    training_rows: list[dict],
    target_history: list[dict],
    markov_weight: float = 0.6,
) -> tuple[dict[str, float], str, dict[str, float]]:
    seen_actions = {
        str(r.get("next_type", "")).strip()
        for r in training_rows
        if str(r.get("next_type", "")).strip()
    }
    for rec in target_history:
        t = str(rec.get("maintenance_type", "")).strip()
        if t:
            seen_actions.add(t)

    candidate_actions = sorted(seen_actions) if seen_actions else list(DEFAULT_ACTIONS)

    if not training_rows and not target_history:
        raise ValueError("Not enough historical maintenance actions to predict the next action.")

    last_type = None
    if target_history:
        last_type = str(target_history[-1].get("maintenance_type", "")).strip() or None

    markov_probs, markov_method = compute_markov_distribution(
        training_rows=training_rows,
        last_type=last_type,
        candidate_actions=candidate_actions,
        alpha=0.5,
    )
    sim_probs = compute_similarity_distribution(
        training_rows=training_rows,
        target_history=target_history,
        candidate_actions=candidate_actions,
    )

    w_m = float(np.clip(markov_weight, 0.0, 1.0))
    w_s = 1.0 - w_m

    blended = {
        a: (w_m * markov_probs[a]) + (w_s * sim_probs[a])
        for a in candidate_actions
    }
    total = sum(blended.values())
    probs = {
        k: round(float(v / total), 4)
        for k, v in sorted(blended.items(), key=lambda item: item[1], reverse=True)
    }

    method = f"blended_{markov_method}_similarity"
    return probs, method, {k: round(float(v), 4) for k, v in markov_probs.items()}


def main():
    raw = sys.stdin.read()
    if not raw.strip():
        raise ValueError("No JSON payload received on stdin.")

    payload = json.loads(raw)
    training_rows = payload.get("training_rows", [])
    target_history = payload.get("target_history", [])
    markov_weight = float(payload.get("markov_weight", 0.6))

    last_type = None
    last_date = None
    if target_history:
        last_record = target_history[-1]
        last_type = str(last_record.get("maintenance_type", "")).strip() or None
        last_date = last_record.get("maintenance_date")

    probs, method, markov_probs = compute_probabilities(
        training_rows=training_rows,
        target_history=target_history,
        markov_weight=markov_weight,
    )
    predicted_action = next(iter(probs.keys()))
    confidence = probs[predicted_action]

    print(json.dumps({
        "last_maintenance_type": last_type,
        "last_maintenance_date": last_date,
        "predicted_next_action": predicted_action,
        "confidence": confidence,
        "probabilities": probs,
        "markov_probabilities": markov_probs,
        "model_used": method,
    }))


if __name__ == "__main__":
    try:
        main()
    except Exception as exc:
        print(json.dumps({"error": str(exc)}), file=sys.stderr)
        sys.exit(1)