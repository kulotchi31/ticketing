import json
import sys
from datetime import date
import numpy as np


def compute_probabilities(training_rows: list[dict], target_history: list[dict]) -> tuple[dict[str, float], str]:
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

    all_actions = sorted({
        str(r.get("next_type", "")).strip()
        for r in training_rows
        if str(r.get("next_type", "")).strip()
    })

    if not all_actions:
        raise ValueError("Not enough historical maintenance actions to predict the next action.")

    # Small Laplace smoothing baseline across candidate actions
    scores = {action: 0.1 for action in all_actions}
    used_transition = False

    for row in training_rows:
        next_t = str(row.get("next_type", "")).strip()
        if next_t not in scores:
            continue

        row_curr = str(row.get("curr_type", "")).strip()
        row_prev = str(row.get("prev_type", "NONE")).strip()
        row_days = float(row.get("days_since_prev") or 0.0)
        row_cost = float(row.get("curr_cost") or 0.0)

        weight = 0.25

        # Primary transition signal: what typically follows the current maintenance_type
        if last_type and row_curr == last_type:
            weight += 2.0
            used_transition = True

        # Secondary 2-step sequence signal
        if prev_type != "NONE" and row_prev == prev_type and (not last_type or row_curr == last_type):
            weight += 1.0

        # Interval similarity in days
        if days_since_prev > 0 and row_days > 0:
            diff_ratio = abs(row_days - days_since_prev) / max(row_days, days_since_prev, 1.0)
            weight += max(0.0, 0.5 * (1.0 - min(diff_ratio, 1.0)))

        # Cost scale similarity (log-scaled via numpy)
        cost_diff = abs(np.log1p(max(0.0, row_cost)) - np.log1p(max(0.0, curr_cost)))
        weight += max(0.0, 0.25 * (1.0 - min(cost_diff / 5.0, 1.0)))

        scores[next_t] += weight

    total = sum(scores.values())
    probs = {
        k: round(float(v / total), 4)
        for k, v in sorted(scores.items(), key=lambda item: item[1], reverse=True)
    }

    method = "weighted_markov_sequence" if used_transition else "weighted_historical_prior"
    return probs, method


def main():
    raw = sys.stdin.read()
    if not raw.strip():
        raise ValueError("No JSON payload received on stdin.")

    payload = json.loads(raw)
    training_rows = payload.get("training_rows", [])
    target_history = payload.get("target_history", [])

    last_type = None
    last_date = None
    if target_history:
        last_record = target_history[-1]
        last_type = str(last_record.get("maintenance_type", "")).strip() or None
        last_date = last_record.get("maintenance_date")

    probs, method = compute_probabilities(training_rows, target_history)
    predicted_action = next(iter(probs.keys()))
    confidence = probs[predicted_action]

    print(json.dumps({
        "last_maintenance_type": last_type,
        "last_maintenance_date": last_date,
        "predicted_next_action": predicted_action,
        "confidence": confidence,
        "probabilities": probs,
        "model_used": method,
    }))


if __name__ == "__main__":
    try:
        main()
    except Exception as exc:
        print(json.dumps({"error": str(exc)}), file=sys.stderr)
        sys.exit(1)