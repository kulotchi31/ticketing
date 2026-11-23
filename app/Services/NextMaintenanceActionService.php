<?php

namespace App\Services;

use App\Models\Facility;
use App\Models\NextMaintenancePrediction;
use RuntimeException;
use Symfony\Component\Process\Process;

class NextMaintenanceActionService
{
    public function __construct(
        private readonly MaintenanceSequenceBuilder $sequenceBuilder
    ) {}

    public function predictForFacility(int $facilityId, bool $persist = true): array
    {
        Facility::findOrFail($facilityId);

        $dataset = $this->sequenceBuilder->buildDatasetForFacility($facilityId);

        $pythonBinary = env('PYTHON_BINARY', 'python3');
        $scriptPath = base_path('python/predict_next_action.py');

        if (!is_file($scriptPath)) {
            throw new RuntimeException("Prediction script not found at [{$scriptPath}].");
        }

        $env = array_merge($_SERVER, $_ENV);
        if (empty($env['SystemRoot'])) {
            $env['SystemRoot'] = 'C:\\Windows';
        }

        $process = new Process([$pythonBinary, $scriptPath], base_path(), $env);
        $process->setInput(json_encode($dataset, JSON_THROW_ON_ERROR));
        $process->setTimeout(60);
        $process->run();

        if (!$process->isSuccessful()) {
            $error = trim($process->getErrorOutput() ?: $process->getOutput());
            throw new RuntimeException("Next-action prediction failed: {$error}");
        }

        $result = json_decode($process->getOutput(), true, 512, JSON_THROW_ON_ERROR);
        $generatedAt = now();

        if ($persist) {
            NextMaintenancePrediction::updateOrCreate(
                ['fk_facility_id' => $facilityId],
                [
                    'last_maintenance_type' => $result['last_maintenance_type'],
                    'last_maintenance_date' => $result['last_maintenance_date'],
                    'predicted_next_action' => $result['predicted_next_action'],
                    'confidence' => $result['confidence'],
                    'probabilities' => $result['probabilities'],
                    'model_used' => $result['model_used'],
                    'generated_at' => $generatedAt,
                ]
            );
        }

        return [
            'fk_facility_id' => $facilityId,
            'last_maintenance_type' => $result['last_maintenance_type'],
            'last_maintenance_date' => $result['last_maintenance_date'],
            'predicted_next_action' => $result['predicted_next_action'],
            'confidence' => $result['confidence'],
            'probabilities' => $result['probabilities'],
            'model_used' => $result['model_used'],
            'generated_at' => $generatedAt->toIso8601String(),
        ];
    }
}