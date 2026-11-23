<?php

namespace App\Console\Commands;

use App\Models\Facility;
use App\Services\NextMaintenanceActionService;
use Illuminate\Console\Command;
use Throwable;

class PredictNextMaintenanceAction extends Command
{
    protected $signature = 'maintenance:predict-next-action
                            {--facility= : Predict for a single facility_id}';

    protected $description = 'Predict the most likely next maintenance_type for facilities';

    public function handle(NextMaintenanceActionService $service): int
    {
        $facilityOption = $this->option('facility');

        if ($facilityOption !== null && $facilityOption !== '') {
            $id = (int) $facilityOption;
            $res = $service->predictForFacility($id, true);
            $this->info("Facility #{$id} -> {$res['predicted_next_action']} ({$res['confidence']})");
            return self::SUCCESS;
        }

        foreach (Facility::pluck('facility_id') as $facilityId) {
            try {
                $res = $service->predictForFacility((int) $facilityId, true);
                $this->line(" - Facility #{$facilityId}: {$res['predicted_next_action']} (" . round($res['confidence'] * 100, 1) . "%)");
            } catch (Throwable $e) {
                $this->warn(" - Facility #{$facilityId} skipped: " . $e->getMessage());
            }
        }

        return self::SUCCESS;
    }
}