<?php

namespace App\Http\Controllers\provider;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacilityController extends Controller
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
     * Get a facility that belongs to the provider's campus.
     */
    private function getFacility(string $id)
    {
        $campus = $this->getProviderCampus();

        return Facility::where('fk_campus_id', $campus->campus_id)
            ->findOrFail($id);
    }

    /**
     * Provide form metadata and reference data for async modals.
     */
    public function createData(Request $request)
    {
        $campus = $this->getProviderCampus();

        return response()->json([
            'campuses' => [$campus],
            'user_campus_id' => $campus->campus_id,
        ]);
    }

    /**
     * Display facilities belonging to the provider's campus (supports AJAX/JSON).
     */
    public function index(Request $request)
    {
        $campus = $this->getProviderCampus();

        $facilities = Facility::with([
            'campus',
            'maintenanceHistories' => function ($query) {
                $query->latest('maintenance_date');
            }
        ])
        ->where('fk_campus_id', $campus->campus_id)
        ->orderBy('facility_name')
        ->get();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'data' => $facilities
            ]);
        }

        $campuses = collect([$campus]);

        return view('provider.facility', compact(
            'campuses',
            'facilities'
        ));
    }

    /**
     * Store a newly created facility (AJAX / JSON response).
     */
    public function store(Request $request)
    {
        $campus = $this->getProviderCampus();

        $validated = $request->validate([
            'facility_name' => [
                'required',
                'string',
                'max:255',
            ],
            'date_establish' => [
                'nullable',
                'date',
            ],
        ]);

        Facility::create([
            'facility_name' => $validated['facility_name'],
            'date_establish' => $validated['date_establish'] ?? null,
            'fk_campus_id' => $campus->campus_id,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Facility created successfully.'
            ]);
        }

        return redirect()
            ->route('facility.index')
            ->with('success', 'Facility created successfully.');
    }

    /**
     * Display a specific facility and its maintenance history.
     */
    public function show(string $id)
    {
        $facility = $this->getFacility($id);

        $facility->load([
            'campus',
            'maintenanceHistories' => function ($query) {
                $query->latest('maintenance_date');
            }
        ]);

        return view('provider.facility.show', compact('facility'));
    }

    /**
     * Show the facility editing form.
     */
    public function edit(string $id)
    {
        $facility = $this->getFacility($id);
        $campus = $this->getProviderCampus();

        return view('provider.facility.edit', compact(
            'facility',
            'campus'
        ));
    }

    /**
     * Update an existing facility.
     */
    public function update(Request $request, string $id)
    {
        $facility = $this->getFacility($id);

        $validated = $request->validate([
            'facility_name' => [
                'required',
                'string',
                'max:255',
            ],
            'date_establish' => [
                'nullable',
                'date',
            ],
        ]);

        $facility->update($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Facility updated successfully.'
            ]);
        }

        return redirect()
            ->route('facility.index')
            ->with('success', 'Facility updated successfully.');
    }

    /**
     * Delete a facility.
     */
    public function destroy(Request $request, string $id)
    {
        $facility = $this->getFacility($id);
        $facility->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Facility deleted successfully.'
            ]);
        }

        return redirect()
            ->route('facility.index')
            ->with('success', 'Facility deleted successfully.');
    }

    /**
     * Record completed maintenance for a facility (AJAX / JSON response).
     */
    public function storeMaintenance(Request $request)
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
}