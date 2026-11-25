<?php

namespace App\Http\Controllers\provider;

use App\Http\Controllers\Controller;
use App\Models\AuditLogs;
use App\Models\Equipment;
use App\Models\EquipmentMaintenance;
use App\Services\NextEquipmentMaintenanceActionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class EquipmentMaintenanceController extends Controller
{
    public function __construct(
        private readonly NextEquipmentMaintenanceActionService $predictionService
    ) {}

    /**
     * Ensure the authenticated user belongs to MIS and has an associated campus.
     *
     * @return int|string
     */
    private function authorizeMisScope(): int|string
    {
        $user = Auth::user();
        $campusId   = $user?->department?->fk_campus_id;
        $providerId = (int) ($user?->fk_provider_id ?? 0);

        $providerName = strtolower(trim((string) (
            $user?->provider?->provider_name
            ?? $user?->provider?->name
            ?? ''
        )));

        // Adjust `1` if MIS uses a different provider_id in your database
        $isMis = $providerId === 1 || str_contains($providerName, 'mis');

        if (!$campusId || !$isMis) {
            abort(403, 'Access to Equipment Maintenance is restricted to MIS.');
        }

        return $campusId;
    }

    /**
     * Base query for equipment belonging to the user's campus.
     */
    private function scopedEquipmentQuery(int|string $campusId)
    {
        return Equipment::query()
            ->whereHas('department', function ($q) use ($campusId) {
                $q->where('fk_campus_id', $campusId);
            });
    }

    /**
     * Base query for maintenance records belonging to equipment in the user's campus.
     */
    private function scopedMaintenanceQuery(int|string $campusId)
    {
        return EquipmentMaintenance::with('equipment.department')
            ->whereHas('equipment.department', function ($q) use ($campusId) {
                $q->where('fk_campus_id', $campusId);
            });
    }

    /**
     * Write an audit log entry matching your AuditLogs model format.
     */
    private function logAudit(int|string|null $targetId, string $actionType, array $payload): void
    {
        try {
            AuditLogs::create([
                'fk_user_id'       => Auth::id(),
                'target_id'        => $targetId,
                'action_type'      => $actionType,
                'payload'          => $payload,
                'transaction_date' => now(),
            ]);
        } catch (Throwable $e) {
            report($e);
        }
    }

    /**
     * Refresh next-action prediction for an equipment item without blocking on errors.
     */
    private function refreshPrediction(int $equipmentId): ?array
    {
        try {
            return $this->predictionService->predictForEquipment($equipmentId, true)->toArray();
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    /**
     * Display a listing of maintenance records for the user's campus.
     */
    public function index(Request $request)
    {
        $campusId = $this->authorizeMisScope();

        $query = $this->scopedMaintenanceQuery($campusId)
            ->orderByDesc('maintenance_date')
            ->orderByDesc('maintenance_id');

        if ($request->filled('equipment_id')) {
            $query->where('fk_equipment_id', $request->integer('equipment_id'));
        }

        if ($request->filled('maintenance_type')) {
            $query->where('maintenance_type', $request->string('maintenance_type'));
        }

        $records = $query->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'data' => $records,
            ]);
        }

        return response()->json([
            'data' => $records,
        ]);
    }

    /**
     * Show data for creating a maintenance record.
     */
    public function create()
    {
        $campusId = $this->authorizeMisScope();

        $equipment = $this->scopedEquipmentQuery($campusId)
            ->orderBy('equipment_name')
            ->get(['equipment_id', 'fk_department_id', 'equipment_name', 'category', 'serial_number', 'status']);

        return response()->json([
            'equipment'         => $equipment,
            'maintenance_types' => EquipmentMaintenance::MAINTENANCE_TYPES,
        ]);
    }

    /**
     * Store a newly created maintenance record in storage.
     */
    public function store(Request $request)
    {
        try {
            $campusId = $this->authorizeMisScope();

            $validator = Validator::make($request->all(), [
                'fk_equipment_id'         => ['required', 'integer'],
                'maintenance_date'        => ['required', 'date', 'before_or_equal:today'],
                'maintenance_type'        => ['required', Rule::in(EquipmentMaintenance::MAINTENANCE_TYPES)],
                'maintenance_description' => ['nullable', 'string', 'max:2000'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $equipment = $this->scopedEquipmentQuery($campusId)
                ->where('equipment_id', $request->fk_equipment_id)
                ->first();

            if (!$equipment) {
                return response()->json(['message' => 'Equipment not found in your campus.'], 404);
            }

            $record = new EquipmentMaintenance;
            $record->fk_equipment_id         = $equipment->equipment_id;
            $record->maintenance_date        = $request->maintenance_date;
            $record->maintenance_type        = $request->maintenance_type;
            $record->maintenance_description = $request->maintenance_description;
            $record->save();

            if ($record) {
                // AUDIT LOG - CREATE EQUIPMENT MAINTENANCE
                $this->logAudit($record->maintenance_id, 'Create Equipment Maintenance', [
                    'fk_equipment_id'         => $equipment->equipment_id,
                    'equipment_name'          => $equipment->equipment_name,
                    'maintenance_date'        => $request->maintenance_date,
                    'maintenance_type'        => $request->maintenance_type,
                    'maintenance_description' => $request->maintenance_description,
                ]);

                // REFRESH NEXT MAINTENANCE PREDICTION
                $this->refreshPrediction((int) $equipment->equipment_id);

                return response()->json(true);
            }

            return response()->json(false);
        } catch (Throwable $e) {
            report($e);

            return response()->json(['message' => 'Failed to save maintenance record.'], 500);
        }
    }

    /**
     * Display the specified maintenance record.
     */
    public function show(string $id)
    {
        $campusId = $this->authorizeMisScope();

        $record = $this->scopedMaintenanceQuery($campusId)
            ->where('maintenance_id', $id)
            ->firstOrFail();

        return response()->json([
            'data' => $record,
        ]);
    }

    /**
     * Show the form/data for editing the specified maintenance record.
     */
    public function edit(string $id)
    {
        $campusId = $this->authorizeMisScope();

        $record = $this->scopedMaintenanceQuery($campusId)
            ->where('maintenance_id', $id)
            ->firstOrFail();

        return response()->json([
            'data' => $record,
        ]);
    }

    /**
     * Update the specified maintenance record in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $campusId = $this->authorizeMisScope();

            $validator = Validator::make($request->all(), [
                'fk_equipment_id'         => ['nullable', 'integer'],
                'maintenance_date'        => ['required', 'date', 'before_or_equal:today'],
                'maintenance_type'        => ['required', Rule::in(EquipmentMaintenance::MAINTENANCE_TYPES)],
                'maintenance_description' => ['nullable', 'string', 'max:2000'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $oldData = $this->scopedMaintenanceQuery($campusId)
                ->where('maintenance_id', $id)
                ->first();

            if (!$oldData) {
                return response()->json(['message' => 'Maintenance record not found.'], 404);
            }

            $targetEquipmentId   = $oldData->fk_equipment_id;
            $targetEquipmentName = $oldData->equipment?->equipment_name;

            if (!empty($request->fk_equipment_id)) {
                $targetEquipment = $this->scopedEquipmentQuery($campusId)
                    ->where('equipment_id', $request->fk_equipment_id)
                    ->first();

                if (!$targetEquipment) {
                    return response()->json(['message' => 'Target equipment not found in your campus.'], 404);
                }

                $targetEquipmentId   = $targetEquipment->equipment_id;
                $targetEquipmentName = $targetEquipment->equipment_name;
            }

            $update = DB::table('equipment_maintenance_history_table')
                ->where('maintenance_id', $id)
                ->update([
                    'fk_equipment_id'         => $targetEquipmentId,
                    'maintenance_date'        => $request->maintenance_date,
                    'maintenance_type'        => $request->maintenance_type,
                    'maintenance_description' => $request->maintenance_description,
                    'updated_at'              => now(),
                ]);

            if ($update) {
                // AUDIT LOG - UPDATE EQUIPMENT MAINTENANCE
                $this->logAudit($id, 'Update Equipment Maintenance', [
                    'old' => [
                        'fk_equipment_id'         => $oldData->fk_equipment_id,
                        'equipment_name'          => $oldData->equipment?->equipment_name,
                        'maintenance_date'        => optional($oldData->maintenance_date)->toDateString(),
                        'maintenance_type'        => $oldData->maintenance_type,
                        'maintenance_description' => $oldData->maintenance_description,
                    ],
                    'new' => [
                        'fk_equipment_id'         => $targetEquipmentId,
                        'equipment_name'          => $targetEquipmentName,
                        'maintenance_date'        => $request->maintenance_date,
                        'maintenance_type'        => $request->maintenance_type,
                        'maintenance_description' => $request->maintenance_description,
                    ],
                ]);

                // REFRESH NEXT MAINTENANCE PREDICTION
                $this->refreshPrediction((int) $oldData->fk_equipment_id);
                if ((int) $targetEquipmentId !== (int) $oldData->fk_equipment_id) {
                    $this->refreshPrediction((int) $targetEquipmentId);
                }

                return response()->json(true);
            }

            return response()->json(false);
        } catch (Throwable $e) {
            report($e);

            return response()->json(['message' => 'Failed to update maintenance record.'], 500);
        }
    }

    /**
     * Remove the specified maintenance record from storage.
     */
    public function destroy(string $id)
    {
        try {
            $campusId = $this->authorizeMisScope();

            $oldData = $this->scopedMaintenanceQuery($campusId)
                ->where('maintenance_id', $id)
                ->first();

            if (!$oldData) {
                return response()->json(['message' => 'Maintenance record not found.'], 404);
            }

            $equipmentId = (int) $oldData->fk_equipment_id;

            $delete = DB::table('equipment_maintenance_history_table')
                ->where('maintenance_id', $id)
                ->delete();

            if ($delete != 0) {
                // AUDIT LOG - DELETE EQUIPMENT MAINTENANCE
                $this->logAudit($id, 'Delete Equipment Maintenance', [
                    'deleted_maintenance' => [
                        'fk_equipment_id'         => $oldData->fk_equipment_id,
                        'equipment_name'          => $oldData->equipment?->equipment_name,
                        'maintenance_date'        => optional($oldData->maintenance_date)->toDateString(),
                        'maintenance_type'        => $oldData->maintenance_type,
                        'maintenance_description' => $oldData->maintenance_description,
                    ],
                ]);

                // REFRESH NEXT MAINTENANCE PREDICTION
                $this->refreshPrediction($equipmentId);

                return response()->json(true);
            }

            return response()->json(false);
        } catch (Throwable $e) {
            report($e);

            return response()->json(false, 500);
        }
    }
}