<?php

namespace App\Http\Controllers\provider;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    /**
     * Get the logged-in provider's campus.
     */
    private function getProviderCampus()
    {
        $user = Auth::user();

        $user->loadMissing('department.campus');

        if (!$user->department) {
            abort(403, 'Your account is not assigned to a department.');
        }

        $campus = $user->department->campus;

        if (!$campus || !is_object($campus)) {
            abort(403, 'Your department is not assigned to a valid campus.');
        }

        return $campus;
    }

    /**
     * Get a maintenance record ensuring its facility belongs to the provider's campus.
     */
    private function getMaintenanceRecord(string $id)
    {
        $campus = $this->getProviderCampus();

        return FacilityMaintenance::whereHas('facility', function ($query) use ($campus) {
            $query->where('fk_campus_id', $campus->campus_id);
        })->findOrFail($id);
    }

    /**
     * Display a listing of maintenance records (Supports JSON/AJAX).
     */
    public function index(Request $request)
    {
        $campus = $this->getProviderCampus();

        $maintenanceRecords = FacilityMaintenance::with(['facility.campus'])
            ->whereHas('facility', function ($query) use ($campus) {
                $query->where('fk_campus_id', $campus->campus_id);
            })
            ->latest('maintenance_date')
            ->get();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'data' => $maintenanceRecords
            ]);
        }

        return view('provider.maintenance.index', compact('maintenanceRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $campus = $this->getProviderCampus();
        $facilities = Facility::where('fk_campus_id', $campus->campus_id)->orderBy('facility_name')->get();

        return view('provider.maintenance.create', compact('facilities'));
    }

    /**
     * Store a newly created maintenance record in storage (AJAX / JSON response).
     */
    public function store(Request $request)
    {
        $campus = $this->getProviderCampus();

        $validated = $request->validate([
            'fk_facility_id' => [
                'required',
                'exists:facility_table,facility_id',
            ],
            'maintenance_date' => [
                'required',
                'date',
            ],
            'maintenance_type' => [
                'required',
                'in:Preventive,Corrective,Emergency,Improvement',
            ],
            'maintenance_description' => [
                'nullable',
                'string',
            ],
            'maintenance_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        // Ensure the selected facility belongs to this provider's campus.
        $facility = Facility::where('fk_campus_id', $campus->campus_id)
            ->findOrFail($validated['fk_facility_id']);

        FacilityMaintenance::create([
            'fk_facility_id' => $facility->facility_id,
            'maintenance_date' => $validated['maintenance_date'],
            'maintenance_type' => $validated['maintenance_type'],
            'maintenance_description' => $validated['maintenance_description'] ?? null,
            'maintenance_cost' => $validated['maintenance_cost'] ?? null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Maintenance record saved successfully.'
            ]);
        }

        return redirect()
            ->route('facility.index')
            ->with('success', 'Maintenance record saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maintenance = $this->getMaintenanceRecord($id);
        $maintenance->load('facility.campus');

        return view('provider.maintenance.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maintenance = $this->getMaintenanceRecord($id);
        $campus = $this->getProviderCampus();
        $facilities = Facility::where('fk_campus_id', $campus->campus_id)->orderBy('facility_name')->get();

        return view('provider.maintenance.edit', compact('maintenance', 'facilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $maintenance = $this->getMaintenanceRecord($id);
        $campus = $this->getProviderCampus();

        $validated = $request->validate([
            'fk_facility_id' => [
                'required',
                'exists:facility_table,facility_id',
            ],
            'maintenance_date' => [
                'required',
                'date',
            ],
            'maintenance_type' => [
                'required',
                'in:Preventive,Corrective,Emergency,Improvement',
            ],
            'maintenance_description' => [
                'nullable',
                'string',
            ],
            'maintenance_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        // Ensure the updated facility still belongs to the provider's campus.
        $facility = Facility::where('fk_campus_id', $campus->campus_id)
            ->findOrFail($validated['fk_facility_id']);

        $maintenance->update([
            'fk_facility_id' => $facility->facility_id,
            'maintenance_date' => $validated['maintenance_date'],
            'maintenance_type' => $validated['maintenance_type'],
            'maintenance_description' => $validated['maintenance_description'] ?? null,
            'maintenance_cost' => $validated['maintenance_cost'] ?? null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Maintenance record updated successfully.'
            ]);
        }

        return redirect()
            ->route('facility.index')
            ->with('success', 'Maintenance record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $maintenance = $this->getMaintenanceRecord($id);
        $maintenance->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Maintenance record deleted successfully.'
            ]);
        }

        return redirect()
            ->route('facility.index')
            ->with('success', 'Maintenance record deleted successfully.');
    }
}