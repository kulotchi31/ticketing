<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentMaintenance;
use App\Models\NextEquipmentMaintenancePrediction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Process;
use RuntimeException;

class NextEquipmentMaintenanceActionService
{
    private const CATEGORY_INTERVAL_DAYS = [
        'Server and Storage'    => 30,
        'Network'               => 45,
        'Computer Equipment'    => 90,
        'Printing Equipment'    => 60,
        'Multimedia Equipment'  => 90,
        'Power and Accessories' => 60,
    ];

    public function predictForEquipment(int $equipmentId, bool $save = true): NextEquipmentMaintenancePrediction
    {
        $equipment = Equipment::with(['department', 'maintenanceHistories' => function ($q) {
            $q->orderBy('maintenance_date')->orderBy('maintenance_id');
        }])->findOrFail($equipmentId);

        $targetHistory = $equipment->maintenanceHistories->map(function (EquipmentMaintenance $rec) {
            return [
                'maintenance_date' => optional($rec->maintenance_date)->toDateString(),
                'maintenance_type' => (string) $rec->maintenance_type,
                'maintenance_cost' => 0.0,
            ];
        })->values()->all();

        $trainingRows = $this->buildTrainingRows($equipment);

        // Seed synthetic baseline transitions if no historical transition pairs exist yet
        if (empty($trainingRows) && !empty($targetHistory)) {
            $trainingRows = [
                ['prev_type' => 'NONE',       'curr_type' => 'Preventive', 'next_type' => 'Preventive', 'days_since_prev' => 60, 'curr_cost' => 0.0],
                ['prev_type' => 'Preventive', 'curr_type' => 'Preventive', 'next_type' => 'Corrective', 'days_since_prev' => 60, 'curr_cost' => 0.0],
                ['prev_type' => 'Preventive', 'curr_type' => 'Corrective', 'next_type' => 'Adaptive',   'days_since_prev' => 30, 'curr_cost' => 0.0],
                ['prev_type' => 'Corrective', 'curr_type' => 'Adaptive',   'next_type' => 'Preventive', 'days_since_prev' => 30, 'curr_cost' => 0.0],
            ];
        }

        $scriptPath = base_path('python/predict_equipment_maintenance.py');

        $payload = json_encode([
            'training_rows'  => $trainingRows,
            'target_history' => $targetHistory,
            'markov_weight'  => (float) config('services.equipment_prediction.markov_weight', 0.6),
        ], JSON_THROW_ON_ERROR);

        $output = $this->runPythonScript($scriptPath, $payload);

        $predictedAction = (string) $output['predicted_next_action'];
        $lastRec = $equipment->maintenanceHistories->last();
        $predictedDate = $this->estimateNextDate($equipment, $lastRec, $predictedAction);

        $attributes = [
            'last_maintenance_type' => $output['last_maintenance_type'] ?? null,
            'last_maintenance_date' => !empty($output['last_maintenance_date'])
                ? Carbon::parse($output['last_maintenance_date'])->toDateString()
                : null,
            'predicted_next_action' => $predictedAction,
            'confidence'            => (float) ($output['confidence'] ?? 0),
            'predicted_date'        => $predictedDate->toDateString(),
            'probabilities'         => $output['probabilities'] ?? [],
            'markov_probabilities'  => $output['markov_probabilities'] ?? [],
            'model_used'            => $output['model_used'] ?? 'blended_markov_1st_order_similarity',
            'predicted_at'          => now(),
        ];

        if (!$save) {
            return new NextEquipmentMaintenancePrediction(array_merge($attributes, [
                'fk_equipment_id' => $equipment->equipment_id,
            ]));
        }

        return NextEquipmentMaintenancePrediction::updateOrCreate(
            ['fk_equipment_id' => $equipment->equipment_id],
            $attributes
        );
    }

    private function resolvePythonCandidates(): array
    {
        $configured = config('services.python.bin') ?: env('PYTHON_BIN');
        $candidates = [];

        if (!empty($configured)) {
            $candidates[] = [(string) $configured];
        }

        if (DIRECTORY_SEPARATOR === '\\') {
            $candidates[] = ['python'];
            $candidates[] = ['py', '-3'];
            $candidates[] = ['py'];
            $candidates[] = ['python3'];

            $localAppData = getenv('LOCALAPPDATA') ?: '';
            $programFiles = getenv('ProgramFiles') ?: 'C:\\Program Files';
            $programFilesX86 = getenv('ProgramFiles(x86)') ?: 'C:\\Program Files (x86)';

            foreach ([$localAppData . '\\Programs\\Python', $programFiles, $programFilesX86] as $baseDir) {
                if (!empty($baseDir) && is_dir($baseDir)) {
                    foreach (glob(rtrim($baseDir, '\\/') . '\\Python*\\python.exe') ?: [] as $exe) {
                        $candidates[] = [$exe];
                    }
                }
            }
        } else {
            $candidates[] = ['python3'];
            $candidates[] = ['python'];
        }

        // Deduplicate preserving order
        $unique = [];
        $seen = [];
        foreach ($candidates as $cmd) {
            $key = implode("\0", $cmd);
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $unique[] = $cmd;
            }
        }

        return $unique;
    }

    private function runPythonScript(string $scriptPath, string $payload): array
    {
        if (!is_file($scriptPath)) {
            throw new RuntimeException("Prediction script not found at: {$scriptPath}");
        }

        $lastError = 'Failed to execute equipment maintenance prediction script.';

        foreach ($this->resolvePythonCandidates() as $cmdPrefix) {
            $result = Process::input($payload)->run([...$cmdPrefix, $scriptPath]);

            if ($result->successful()) {
                $decoded = json_decode(trim($result->output()), true);
                if (is_array($decoded) && !empty($decoded['predicted_next_action'])) {
                    return $decoded;
                }
                throw new RuntimeException('Invalid response from equipment maintenance prediction script.');
            }

            $stderr = trim($result->errorOutput());
            $decodedErr = json_decode($stderr, true);
            $msg = $decodedErr['error'] ?? ($stderr ?: $lastError);
            $lastError = $msg;

            // If the binary itself was not found, try the next candidate; otherwise surface the error
            $notFound = str_contains(strtolower($msg), 'not recognized as an internal or external command')
                || str_contains(strtolower($msg), 'no such file or directory');

            if (!$notFound) {
                throw new RuntimeException($msg);
            }
        }

        throw new RuntimeException($lastError . ' (Set PYTHON_BIN in .env to your python.exe path.)');
    }

    private function buildTrainingRows(Equipment $targetEquipment): array
    {
        $campusId = $targetEquipment->department?->fk_campus_id;

        $query = Equipment::with(['maintenanceHistories' => function ($q) {
            $q->orderBy('maintenance_date')->orderBy('maintenance_id');
        }])->whereHas('maintenanceHistories');

        if ($campusId) {
            $query->whereHas('department', function ($q) use ($campusId) {
                $q->where('fk_campus_id', $campusId);
            });
        }

        $allEquipment = $query->get();

        // Prefer same category first; fall back to all campus equipment if few rows exist
        $sameCategory = $allEquipment->where('category', $targetEquipment->category);
        $sourcePool = $sameCategory->count() >= 2 ? $sameCategory : $allEquipment;

        $rows = [];
        foreach ($sourcePool as $item) {
            $history = $item->maintenanceHistories->values();
            if ($history->count() < 2) {
                continue;
            }

            for ($i = 0; $i < $history->count() - 1; $i++) {
                $curr = $history[$i];
                $next = $history[$i + 1];
                $prev = $i > 0 ? $history[$i - 1] : null;

                $daysSincePrev = 0;
                if ($prev && $prev->maintenance_date && $curr->maintenance_date) {
                    $daysSincePrev = max(0, Carbon::parse($prev->maintenance_date)->diffInDays(Carbon::parse($curr->maintenance_date)));
                }

                $rows[] = [
                    'prev_type'       => $prev ? (string) $prev->maintenance_type : 'NONE',
                    'curr_type'       => (string) $curr->maintenance_type,
                    'next_type'       => (string) $next->maintenance_type,
                    'days_since_prev' => $daysSincePrev,
                    'curr_cost'       => 0.0,
                ];
            }
        }

        return $rows;
    }

    private function estimateNextDate(
        Equipment $equipment,
        ?EquipmentMaintenance $lastRec,
        string $predictedAction
    ): Carbon {
        $today = Carbon::today();

        if ($equipment->status === 'under_repair') {
            return $today->copy()->addDays(3);
        }

        if ($equipment->status === 'needs_maintenance' || $predictedAction === 'Corrective') {
            return $today->copy()->addDays(7);
        }

        if ($predictedAction === 'Adaptive') {
            return $today->copy()->addDays(14);
        }

        $interval = self::CATEGORY_INTERVAL_DAYS[$equipment->category] ?? 90;
        $reference = $lastRec?->maintenance_date
            ? Carbon::parse($lastRec->maintenance_date)
            : ($equipment->date_acquired ? Carbon::parse($equipment->date_acquired) : $today);

        $nextDate = $reference->copy()->addDays($interval);
        return $nextDate->lt($today) ? $today->copy()->addDays(7) : $nextDate;
    }
}