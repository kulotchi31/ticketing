<?php

namespace App\Services;

use App\Models\Facility;
use App\Models\FacilityMaintenance;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MaintenanceSequenceBuilder
{
    /**
     * Build training transition rows across facilities + target facility's history.
     *
     * @return array{training_rows: array<int, array<string, mixed>>, target_history: array<int, array<string, mixed>>}
     */
    public function buildDatasetForFacility(int $targetFacilityId): array
    {
        $allRecords = FacilityMaintenance::query()
            ->with('facility:facility_id,fk_campus_id,date_establish')
            ->whereNotNull('maintenance_type')
            ->where('maintenance_type', '!=', '')
            ->orderBy('fk_facility_id')
            ->orderBy('maintenance_date')
            ->orderBy('maintenance_id')
            ->get()
            ->groupBy('fk_facility_id');

        $trainingRows = [];
        $targetHistory = [];

        foreach ($allRecords as $facilityId => $records) {
            /** @var Collection<int, FacilityMaintenance> $records */
            $records = $records->values();
            $facilityRows = $this->recordsToTransitions($records);

            if ((int) $facilityId === $targetFacilityId) {
                $targetHistory = $records->map(fn (FacilityMaintenance $r) => [
                    'maintenance_id' => $r->maintenance_id,
                    'maintenance_date' => Carbon::parse($r->maintenance_date)->toDateString(),
                    'maintenance_type' => trim((string) $r->maintenance_type),
                    'maintenance_cost' => (float) $r->maintenance_cost,
                ])->all();
            } else {
                foreach ($facilityRows as $row) {
                    $trainingRows[] = $row;
                }
            }
        }

        // Also include transitions from the target facility itself (except its final record which has no "next" yet)
        if ($allRecords->has($targetFacilityId)) {
            $targetTransitions = $this->recordsToTransitions($allRecords->get($targetFacilityId)->values());
            foreach ($targetTransitions as $row) {
                $trainingRows[] = $row;
            }
        }

        return [
            'training_rows' => $trainingRows,
            'target_history' => $targetHistory,
        ];
    }

    /**
     * Convert a single facility's ordered maintenance logs into (state -> next_action) pairs.
     *
     * @param Collection<int, FacilityMaintenance> $records
     * @return array<int, array<string, mixed>>
     */
    private function recordsToTransitions(Collection $records): array
    {
        $rows = [];
        $count = $records->count();

        if ($count < 2) {
            return $rows;
        }

        $firstDate = Carbon::parse($records[0]->maintenance_date);
        $establishedAt = $records[0]->facility?->date_establish
            ? Carbon::parse($records[0]->facility->date_establish)
            : $firstDate;

        for ($i = 0; $i < $count - 1; $i++) {
            $current = $records[$i];
            $next = $records[$i + 1];

            $currDate = Carbon::parse($current->maintenance_date);
            $nextDate = Carbon::parse($next->maintenance_date);

            $prevType = $i > 0
                ? trim((string) $records[$i - 1]->maintenance_type)
                : 'NONE';

            $daysSincePrev = $i > 0
                ? max(0, Carbon::parse($records[$i - 1]->maintenance_date)->diffInDays($currDate))
                : 0;

            $daysBetweenCurrentAndNext = max(0, $currDate->diffInDays($nextDate));
            $facilityAgeYears = round(max(0, $establishedAt->diffInDays($currDate)) / 365.25, 2);

            $rows[] = [
                'prev_type' => $prevType,
                'curr_type' => trim((string) $current->maintenance_type),
                'step_index' => $i + 1,
                'days_since_prev' => $daysSincePrev,
                'days_to_next' => $daysBetweenCurrentAndNext,
                'facility_age_years' => $facilityAgeYears,
                'curr_cost' => (float) $current->maintenance_cost,
                'next_type' => trim((string) $next->maintenance_type),
            ];
        }

        return $rows;
    }
}