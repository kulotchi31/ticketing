<?php

namespace App\Http\Controllers\provider;

use App\Http\Controllers\Controller;
use App\Models\AuditLogs;
use App\Models\Department;
use App\Models\Equipment;
use App\Models\EquipmentMaintenance;
use App\Models\NextEquipmentMaintenancePrediction;
use App\Services\NextEquipmentMaintenanceActionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class EquipmentController extends Controller
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
            abort(403, 'Access to Equipment Monitoring is restricted to MIS.');
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
     * Write an audit log entry matching CampusController's AuditLogs format.
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
     * Display equipment view or return JSON data for DataTables.
     */
    public function index(Request $request)
    {
        $campusId = $this->authorizeMisScope();

        if ($request->ajax() || $request->wantsJson()) {
            $query = $this->scopedEquipmentQuery($campusId)
                ->with(['department.campus', 'maintenanceHistories', 'nextPrediction']);

            if ($request->filled('category')) {
                $query->where('category', $request->string('category'));
            }

            if ($request->filled('status')) {
                $query->where('status', $request->string('status'));
            }

            if ($request->filled('department_id')) {
                $query->where('fk_department_id', $request->integer('department_id'));
            }

            $equipment = $query->orderByDesc('equipment_id')->get();

            return response()->json([
                'data' => $equipment,
            ]);
        }

        return view('provider.equipment');
    }

    /**
     * Return departments under the authenticated user's campus.
     */
    public function createData()
    {
        $campusId = $this->authorizeMisScope();

        $departments = Department::where('fk_campus_id', $campusId)
            ->orderBy('department_name')
            ->get(['department_id', 'department_name', 'fk_campus_id']);

        return response()->json([
            'departments' => $departments,
        ]);
    }

    /**
     * Store a newly created equipment record.
     */
    public function store(Request $request)
    {
        try {
            $campusId = $this->authorizeMisScope();

            $validator = Validator::make($request->all(), [
                'equipment_name'   => ['required', 'string', 'max:255'],
                'category'         => ['required', Rule::in(Equipment::CATEGORIES)],
                'serial_number'    => ['nullable', 'string', 'max:150'],
                'status'           => ['required', Rule::in(Equipment::STATUSES)],
                'fk_department_id' => [
                    'required',
                    Rule::exists('department_table', 'department_id')->where('fk_campus_id', $campusId),
                ],
                'date_acquired'    => ['nullable', 'date', 'before_or_equal:today'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $equipment = new Equipment;
            $equipment->equipment_name   = $request->equipment_name;
            $equipment->category         = $request->category;
            $equipment->serial_number    = $request->serial_number;
            $equipment->status           = $request->status;
            $equipment->fk_department_id = $request->fk_department_id;
            $equipment->date_acquired    = $request->date_acquired;
            $equipment->save();

            if ($equipment) {
                // AUDIT LOG - CREATE EQUIPMENT
                $this->logAudit($equipment->equipment_id, 'Create Equipment', [
                    'equipment_name'   => $request->equipment_name,
                    'category'         => $request->category,
                    'serial_number'    => $request->serial_number,
                    'status'           => $request->status,
                    'fk_department_id' => $request->fk_department_id,
                    'date_acquired'    => $request->date_acquired,
                ]);

                $this->refreshPrediction((int) $equipment->equipment_id);

                return response()->json(true);
            }

            return response()->json(false);
        } catch (Throwable $e) {
            report($e);

            return response()->json(['message' => 'Failed to create equipment.'], 500);
        }
    }

    /**
     * Display a single equipment item.
     */
    public function show(string $id)
    {
        $campusId = $this->authorizeMisScope();

        $equipment = $this->scopedEquipmentQuery($campusId)
            ->with(['department.campus', 'maintenanceHistories', 'nextPrediction'])
            ->findOrFail($id);

        return response()->json([
            'data' => $equipment,
        ]);
    }

    /**
     * Show data for editing a specific equipment record.
     */
    public function edit(string $id)
    {
        $campusId = $this->authorizeMisScope();

        $data = DB::table('equipment_table')
            ->join('department_table', 'equipment_table.fk_department_id', '=', 'department_table.department_id')
            ->select('equipment_table.*')
            ->where('equipment_table.equipment_id', $id)
            ->where('department_table.fk_campus_id', $campusId)
            ->get();

        return response()->json(['data' => $data]);
    }

    /**
     * Update an existing equipment record.
     */
    public function update(Request $request, string $id)
    {
        try {
            $campusId = $this->authorizeMisScope();

            $validator = Validator::make($request->all(), [
                'equipment_name'   => ['required', 'string', 'max:255'],
                'category'         => ['required', Rule::in(Equipment::CATEGORIES)],
                'serial_number'    => ['nullable', 'string', 'max:150'],
                'status'           => ['required', Rule::in(Equipment::STATUSES)],
                'fk_department_id' => [
                    'required',
                    Rule::exists('department_table', 'department_id')->where('fk_campus_id', $campusId),
                ],
                'date_acquired'    => ['nullable', 'date', 'before_or_equal:today'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $oldData = $this->scopedEquipmentQuery($campusId)
                ->where('equipment_id', $id)
                ->first();

            if (!$oldData) {
                return response()->json(['message' => 'Equipment not found.'], 404);
            }

            $update = DB::table('equipment_table')
                ->where('equipment_id', $id)
                ->update([
                    'equipment_name'   => $request->equipment_name,
                    'category'         => $request->category,
                    'serial_number'    => $request->serial_number,
                    'status'           => $request->status,
                    'fk_department_id' => $request->fk_department_id,
                    'date_acquired'    => $request->date_acquired,
                    'updated_at'       => now(),
                ]);

            if ($update) {
                // AUDIT LOG - UPDATE EQUIPMENT
                $this->logAudit($id, 'Update Equipment', [
                    'old' => [
                        'equipment_name'   => $oldData->equipment_name,
                        'category'         => $oldData->category,
                        'serial_number'    => $oldData->serial_number,
                        'status'           => $oldData->status,
                        'fk_department_id' => $oldData->fk_department_id,
                        'date_acquired'    => optional($oldData->date_acquired)->toDateString(),
                    ],
                    'new' => [
                        'equipment_name'   => $request->equipment_name,
                        'category'         => $request->category,
                        'serial_number'    => $request->serial_number,
                        'status'           => $request->status,
                        'fk_department_id' => $request->fk_department_id,
                        'date_acquired'    => $request->date_acquired,
                    ],
                ]);

                $this->refreshPrediction((int) $id);

                return response()->json(true);
            }

            return response()->json(false);
        } catch (Throwable $e) {
            report($e);

            return response()->json(['message' => 'Failed to update equipment.'], 500);
        }
    }

    /**
     * Remove the specified equipment record.
     */
    public function destroy(string $id)
    {
        try {
            $campusId = $this->authorizeMisScope();

            $oldData = $this->scopedEquipmentQuery($campusId)
                ->where('equipment_id', $id)
                ->first();

            if (!$oldData) {
                return response()->json(['message' => 'Equipment not found.'], 404);
            }

            $delete = DB::table('equipment_table')
                ->where('equipment_id', $id)
                ->delete();

            if ($delete != 0) {
                // AUDIT LOG - DELETE EQUIPMENT
                $this->logAudit($id, 'Delete Equipment', [
                    'deleted_equipment' => [
                        'equipment_name'   => $oldData->equipment_name,
                        'category'         => $oldData->category,
                        'serial_number'    => $oldData->serial_number,
                        'status'           => $oldData->status,
                        'fk_department_id' => $oldData->fk_department_id,
                        'date_acquired'    => optional($oldData->date_acquired)->toDateString(),
                    ],
                ]);

                return response()->json(true);
            }

            return response()->json(false);
        } catch (Throwable $e) {
            report($e);

            return response()->json(false, 500);
        }
    }

    /**
     * Get saved next-action prediction for an equipment item (or generate on demand).
     */
    public function getNextAction(string $id)
    {
        $campusId = $this->authorizeMisScope();
        $equipment = $this->scopedEquipmentQuery($campusId)->findOrFail($id);

        $prediction = NextEquipmentMaintenancePrediction::where('fk_equipment_id', $equipment->equipment_id)
            ->first();

        if (!$prediction) {
            try {
                $generated = $this->predictionService->predictForEquipment((int) $equipment->equipment_id, true);

                return response()->json([
                    'success' => true,
                    'data'    => $generated,
                ]);
            } catch (Throwable $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }
        }

        return response()->json([
            'success' => true,
            'data'    => $prediction,
        ]);
    }

    /**
     * Re-run and save next-action prediction for an equipment item.
     */
    public function predictNextAction(Request $request, string $id)
    {
        $campusId = $this->authorizeMisScope();
        $equipment = $this->scopedEquipmentQuery($campusId)->findOrFail($id);

        try {
            $result = $this->predictionService->predictForEquipment((int) $equipment->equipment_id, true);

            return response()->json([
                'success' => true,
                'message' => 'Next maintenance action predicted successfully.',
                'data'    => $result,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Store a new maintenance history entry.
     */
    public function storeMaintenance(Request $request)
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
                // AUDIT LOG - CREATE MAINTENANCE RECORD
                $this->logAudit($record->maintenance_id, 'Create Equipment Maintenance', [
                    'fk_equipment_id'         => $equipment->equipment_id,
                    'equipment_name'          => $equipment->equipment_name,
                    'maintenance_date'        => $request->maintenance_date,
                    'maintenance_type'        => $request->maintenance_type,
                    'maintenance_description' => $request->maintenance_description,
                ]);

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
     * Update an existing maintenance history entry.
     */
    public function updateMaintenance(Request $request, string $id)
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

            $oldData = EquipmentMaintenance::with('equipment')
                ->whereHas('equipment.department', function ($q) use ($campusId) {
                    $q->where('fk_campus_id', $campusId);
                })
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
                // AUDIT LOG - UPDATE MAINTENANCE RECORD
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
     * Delete a maintenance history entry.
     */
    public function destroyMaintenance(string $id)
    {
        try {
            $campusId = $this->authorizeMisScope();

            $oldData = EquipmentMaintenance::with('equipment')
                ->whereHas('equipment.department', function ($q) use ($campusId) {
                    $q->where('fk_campus_id', $campusId);
                })
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
                // AUDIT LOG - DELETE MAINTENANCE RECORD
                $this->logAudit($id, 'Delete Equipment Maintenance', [
                    'deleted_maintenance' => [
                        'fk_equipment_id'         => $oldData->fk_equipment_id,
                        'equipment_name'          => $oldData->equipment?->equipment_name,
                        'maintenance_date'        => optional($oldData->maintenance_date)->toDateString(),
                        'maintenance_type'        => $oldData->maintenance_type,
                        'maintenance_description' => $oldData->maintenance_description,
                    ],
                ]);

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