<x-provider>

@push('styles')
<style>
    .facility-page { padding: 8px; }

    .facility-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .facility-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .facility-header-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: white;
        font-size: 22px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .facility-title {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #111827;
    }

    .facility-subtitle {
        margin: 4px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .facility-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(16, 24, 40, .04);
    }

    .facility-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #eef1f5;
        gap: 16px;
        flex-wrap: wrap;
    }

    .facility-toolbar-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
    }

    .facility-toolbar-description {
        font-size: 12px;
        color: #9ca3af;
    }

    /* Search Input Styling */
    .search-wrapper {
        position: relative;
        width: 280px;
        max-width: 100%;
    }

    .search-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-wrapper input {
        padding-left: 36px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }

    .search-wrapper input:focus {
        background-color: #fff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* DataTable Overrides */
    .facility-table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }

    .facility-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        padding: 14px 20px !important;
        white-space: nowrap;
        border-bottom: 1px solid #e9edf3 !important;
    }

    .facility-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .facility-table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .facility-table tbody td {
        padding: 15px 20px !important;
        font-size: 13px;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .facility-table tbody tr:last-child td {
        border-bottom: none !important;
    }

    /* DataTables Footer / Pagination Styling */
    .dt-footer-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        background: #fafbfc;
        border-top: 1px solid #eef1f5;
        flex-wrap: wrap;
        gap: 12px;
    }

    .dataTables_info {
        font-size: 12px;
        color: #64748b;
        padding-top: 0 !important;
    }

    .dataTables_length label {
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .dataTables_length select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 4px 24px 4px 10px;
        font-size: 12px;
        color: #334155;
        background-color: #fff;
    }

    .dataTables_paginate .pagination {
        margin: 0;
        gap: 4px;
    }

    .dataTables_paginate .page-item .page-link {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 12px;
        transition: all 0.15s ease;
    }

    .dataTables_paginate .page-item.active .page-link {
        background-color: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }

    .dataTables_paginate .page-item.disabled .page-link {
        background-color: #f8fafc;
        color: #cbd5e1;
    }

    /* Cell Elements */
    .facility-name {
        font-weight: 600;
        color: #0f172a;
        font-size: 13.5px;
    }

    .campus-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #475569;
        font-size: 12px;
        font-weight: 500;
    }

    .maintenance-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .confidence-pill {
        display: inline-block;
        margin-left: 6px;
        font-size: 10.5px;
        font-weight: 600;
        color: #475569;
        background: #f1f5f9;
        padding: 2px 7px;
        border-radius: 12px;
    }

    .badge-preventive { background: #ecfdf5; color: #059669; }
    .badge-corrective { background: #fffbeb; color: #d97706; }
    .badge-emergency  { background: #fef2f2; color: #dc2626; }
    .badge-improvement{ background: #eff6ff; color: #2563eb; }
    .badge-default    { background: #f1f5f9; color: #475569; }

    .no-maintenance {
        color: #94a3b8;
        font-size: 12px;
        font-style: italic;
    }

    /* Buttons */
    .btn-facility {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 16px;
        border: 0;
        border-radius: 10px;
        background: #2563eb;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }

    .btn-facility:hover {
        background: #1d4ed8;
        color: white;
        transform: translateY(-1px);
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        font-size: 11.5px;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .btn-action:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    /* Modals & Timeline */
    .modal-content {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
    }

    .modal-header {
        background: #f8fafc;
        border-bottom: 1px solid #eef1f5;
        padding: 18px 22px;
    }

    .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    .modal-body { padding: 22px; }

    .modal-footer {
        border-top: 1px solid #eef1f5;
        padding: 15px 22px;
    }

    .form-label {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }

    .form-control, .form-select {
        font-size: 13px;
        border-radius: 8px;
        padding: 10px 12px;
    }

    .history-timeline {
        border-left: 2px solid #e2e8f0;
        margin-left: 8px;
        padding-left: 22px;
    }

    .history-item {
        position: relative;
        padding-bottom: 22px;
    }

    .history-item::before {
        content: '';
        position: absolute;
        left: -29px;
        top: 4px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #2563eb;
        border: 3px solid #dbeafe;
    }

    .prediction-summary-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 20px;
    }

    @media(max-width:768px) {
        .facility-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 15px;
        }
        .facility-header .btn-facility,
        .search-wrapper {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

<div class="facility-page">

    {{-- PAGE HEADER --}}
    <div class="facility-header">
        <div class="facility-header-left">
            <div class="facility-header-icon">
                <i class="bi bi-buildings"></i>
            </div>
            <div>
                <h4 class="facility-title">Facility Management</h4>
                <p class="facility-subtitle">
                    Manage university facilities, maintenance records, and predicted next actions
                </p>
            </div>
        </div>

        <button type="button"
                class="btn-facility"
                data-bs-toggle="modal"
                data-bs-target="#addFacilityModal">
            <i class="bi bi-plus-lg"></i>
            Add Facility
        </button>
    </div>

    {{-- FACILITY DIRECTORY --}}
    <div class="facility-card">
        <div class="facility-toolbar">
            <div>
                <div class="facility-toolbar-title">
                    Facility Directory
                </div>
                <div class="facility-toolbar-description">
                    View registered facilities, latest maintenance, and predicted next action
                </div>
            </div>

            <div class="search-wrapper">
                <i class="bi bi-search"></i>
                <input type="text"
                       id="facilitySearch"
                       class="form-control"
                       placeholder="Search facilities or campuses...">
            </div>
        </div>

        <div class="table-responsive">
            <table id="facilityTable" class="facility-table">
                <thead>
                    <tr>
                        <th>Facility</th>
                        <th>Campus</th>
                        <th>Date Established</th>
                        <th>Last Maintenance</th>
                        <th>Maintenance Type</th>
                        <th>Predicted Next Action</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

{{-- ADD FACILITY MODAL --}}
<div class="modal fade"
     id="addFacilityModal"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-building-add me-2"></i>
                    Register New Facility
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="addFacilityForm" action="javascript:void(0);" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Facility Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="facility_name"
                               name="facility_name"
                               class="form-control"
                               placeholder="Enter facility name"
                               required>
                        <div id="facility_name_error" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Campus <span class="text-danger">*</span>
                        </label>
                        <select id="fk_campus_id"
                                name="fk_campus_id"
                                class="form-select"
                                required>
                            <option value="">Select campus</option>
                        </select>
                        <div id="fk_campus_id_error" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Date Established
                        </label>
                        <input type="date"
                               id="date_establish"
                               name="date_establish"
                               class="form-control">
                        <div id="date_establish_error" class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveFacility">
                        <i class="bi bi-save me-1"></i> Save Facility
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT FACILITY MODAL --}}
<div class="modal fade"
     id="editFacilityModal"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Facility
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editFacilityForm" action="javascript:void(0);" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_facility_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Facility Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="edit_facility_name"
                               name="facility_name"
                               class="form-control"
                               placeholder="Enter facility name"
                               required>
                        <div id="edit_facility_name_error" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Campus <span class="text-danger">*</span>
                        </label>
                        <select id="edit_fk_campus_id"
                                name="fk_campus_id"
                                class="form-select"
                                required>
                            <option value="">Select campus</option>
                        </select>
                        <div id="edit_fk_campus_id_error" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Date Established
                        </label>
                        <input type="date"
                               id="edit_date_establish"
                               name="date_establish"
                               class="form-control">
                        <div id="edit_date_establish_error" class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnUpdateFacility">
                        <i class="bi bi-save me-1"></i> Update Facility
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- RECORD MAINTENANCE MODAL --}}
<div class="modal fade"
     id="maintenanceModal"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">
                        <i class="bi bi-wrench-adjustable me-2"></i>
                        Record Maintenance
                    </h5>
                    <small class="text-muted">
                        Record a completed maintenance activity
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="maintenanceForm" action="javascript:void(0);" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="fk_facility_id" id="maintenance_facility_id">

                    <div class="mb-3">
                        <label class="form-label">Selected Facility</label>
                        <input type="text" id="maintenance_facility_name" class="form-control" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Maintenance Date <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="maintenance_date"
                                   id="maintenance_date"
                                   class="form-control"
                                   max="{{ date('Y-m-d') }}"
                                   value="{{ date('Y-m-d') }}"
                                   required>
                            <div id="maintenance_date_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Maintenance Type <span class="text-danger">*</span>
                            </label>
                            <select name="maintenance_type"
                                    id="maintenance_type"
                                    class="form-select"
                                    required>
                                <option value="">Select maintenance type</option>
                                <option value="Preventive">Preventive Maintenance</option>
                                <option value="Corrective">Corrective Maintenance</option>
                                <option value="Emergency">Emergency Maintenance</option>
                                <option value="Improvement">Improvement / Upgrade</option>
                            </select>
                            <div id="maintenance_type_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Maintenance Description</label>
                            <textarea name="maintenance_description"
                                      id="maintenance_description"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Describe the maintenance work performed..."></textarea>
                            <div id="maintenance_description_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Maintenance Cost (₱)</label>
                            <input type="number"
                                   name="maintenance_cost"
                                   id="maintenance_cost"
                                   class="form-control"
                                   placeholder="0.00"
                                   min="0"
                                   step="0.01">
                            <div id="maintenance_cost_error" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Saving a maintenance record automatically updates the predicted next action for this facility.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveMaintenance">
                        <i class="bi bi-save me-1"></i> Save Maintenance Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT MAINTENANCE MODAL --}}
<div class="modal fade"
     id="editMaintenanceModal"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Maintenance Record
                    </h5>
                    <small class="text-muted">
                        Update details of this maintenance activity
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editMaintenanceForm" action="javascript:void(0);" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_maintenance_id">
                <input type="hidden" name="fk_facility_id" id="edit_maintenance_facility_id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Selected Facility</label>
                        <input type="text" id="edit_maintenance_facility_name" class="form-control" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Maintenance Date <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="maintenance_date"
                                   id="edit_maintenance_date"
                                   class="form-control"
                                   max="{{ date('Y-m-d') }}"
                                   required>
                            <div id="edit_maintenance_date_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Maintenance Type <span class="text-danger">*</span>
                            </label>
                            <select name="maintenance_type"
                                    id="edit_maintenance_type"
                                    class="form-select"
                                    required>
                                <option value="">Select maintenance type</option>
                                <option value="Preventive">Preventive Maintenance</option>
                                <option value="Corrective">Corrective Maintenance</option>
                                <option value="Emergency">Emergency Maintenance</option>
                                <option value="Improvement">Improvement / Upgrade</option>
                            </select>
                            <div id="edit_maintenance_type_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Maintenance Description</label>
                            <textarea name="maintenance_description"
                                      id="edit_maintenance_description"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Describe the maintenance work performed..."></textarea>
                            <div id="edit_maintenance_description_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Maintenance Cost (₱)</label>
                            <input type="number"
                                   name="maintenance_cost"
                                   id="edit_maintenance_cost"
                                   class="form-control"
                                   placeholder="0.00"
                                   min="0"
                                   step="0.01">
                            <div id="edit_maintenance_cost_error" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnUpdateMaintenance">
                        <i class="bi bi-save me-1"></i> Update Maintenance Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- VIEW HISTORY MODAL CONTAINER --}}
<div id="historyModalsContainer"></div>

@push('scripts')
<script>
$(document).ready(function () {
    let campuses = [];

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const options = { year: 'numeric', month: 'short', day: '2-digit' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }

    function formatCurrency(amount) {
        return Number(amount || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function getMaintenanceBadge(type) {
        const badges = {
            'Preventive':  { class: 'badge-preventive',  icon: 'bi-shield-check' },
            'Corrective':  { class: 'badge-corrective',  icon: 'bi-tools' },
            'Emergency':   { class: 'badge-emergency',   icon: 'bi-exclamation-triangle' },
            'Improvement': { class: 'badge-improvement', icon: 'bi-arrow-up-circle' }
        };
        const badge = badges[type] || { class: 'badge-default', icon: 'bi-tag' };
        return `<span class="maintenance-badge ${badge.class}"><i class="bi ${badge.icon}"></i> ${escapeHtml(type)}</span>`;
    }

    function renderNextActionCell(prediction) {
        if (!prediction || !prediction.predicted_next_action) {
            return '<span class="no-maintenance">Not predicted yet</span>';
        }
        const pct = prediction.confidence !== undefined && prediction.confidence !== null
            ? `<span class="confidence-pill">${(Number(prediction.confidence) * 100).toFixed(1)}%</span>`
            : '';
        return `<div>${getMaintenanceBadge(prediction.predicted_next_action)}${pct}</div>`;
    }

    function buildPredictionBoxHtml(prediction) {
        if (!prediction || !prediction.predicted_next_action) {
            return `
                <div class="prediction-summary-box">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted">No next-action prediction available yet.</span>
                    </div>
                </div>
            `;
        }

        const probs = prediction.probabilities || {};
        const probBadges = Object.entries(probs)
            .map(([action, score]) => {
                const percent = (Number(score) * 100).toFixed(1);
                return `<span class="badge bg-light text-dark border me-1 mb-1">${escapeHtml(action)}: ${percent}%</span>`;
            })
            .join('');

        return `
            <div class="prediction-summary-box">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                    <div>
                        <span class="small fw-bold text-secondary text-uppercase me-2">Predicted Next Action:</span>
                        ${getMaintenanceBadge(prediction.predicted_next_action)}
                        <span class="confidence-pill">${(Number(prediction.confidence || 0) * 100).toFixed(1)}% confidence</span>
                    </div>
                    <small class="text-muted">Model: ${escapeHtml(prediction.model_used || 'sequence')}</small>
                </div>
                <div>${probBadges}</div>
            </div>
        `;
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD FORM DATA (CAMPUSES)
    |--------------------------------------------------------------------------
    */
    function loadFormData() {
        $.ajax({
            url: "{{ route('facility-provider.createData') }}",
            type: 'GET',
            success: function (response) {
                campuses = response.campuses || [];
                let options = '<option value="">Select campus</option>';
                campuses.forEach(function (campus) {
                    options += `<option value="${escapeHtml(campus.campus_name)}">${escapeHtml(campus.campus_name)}</option>`;
                });
                $('#fk_campus_id, #edit_fk_campus_id').html(options);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON?.message || 'Unable to load campus options.'
                });
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FACILITY DATATABLE (AJAX)
    |--------------------------------------------------------------------------
    */
    const facilityTable = $('#facilityTable').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        ordering: true,
        order: [],
        dom: 'rt<"dt-footer-wrapper"<"d-flex align-items-center gap-3"li>p>',
        ajax: {
            url: "{{ route('facility-provider.index') }}",
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            {
                data: 'facility_name',
                render: function (data) {
                    return `<div class="facility-name">${escapeHtml(data)}</div>`;
                }
            },
            {
                data: 'campus.campus_name',
                defaultContent: 'N/A',
                render: function (data) {
                    return `<span class="campus-badge"><i class="bi bi-geo-alt text-primary"></i> ${escapeHtml(data)}</span>`;
                }
            },
            {
                data: 'date_establish',
                render: function (data) {
                    return `<span class="text-muted">${formatDate(data)}</span>`;
                }
            },
            {
                data: 'maintenance_histories',
                render: function (data) {
                    const histories = data || [];
                    if (!histories.length) {
                        return '<span class="no-maintenance">No maintenance recorded</span>';
                    }
                    const sorted = [...histories].sort((a, b) => new Date(b.maintenance_date) - new Date(a.maintenance_date));
                    return `<span class="fw-semibold text-dark">${formatDate(sorted[0].maintenance_date)}</span>`;
                }
            },
            {
                data: 'maintenance_histories',
                render: function (data) {
                    const histories = data || [];
                    if (!histories.length) {
                        return '<span class="text-muted">—</span>';
                    }
                    const sorted = [...histories].sort((a, b) => new Date(b.maintenance_date) - new Date(a.maintenance_date));
                    return getMaintenanceBadge(sorted[0].maintenance_type);
                }
            },
            {
                data: 'next_prediction',
                render: function (data) {
                    return renderNextActionCell(data);
                }
            },
            {
                data: 'facility_id',
                orderable: false,
                searchable: false,
                className: 'text-end',
                render: function (data, type, row) {
                    const count = (row.maintenance_histories || []).length;
                    const countBadge = count > 0 ? `<span class="badge bg-secondary ms-1">${count}</span>` : '';

                    return `
                        <div class="d-flex justify-content-end gap-1 flex-wrap">
                            <button type="button"
                                    class="btn-action text-primary btn-record-maintenance"
                                    title="Record Maintenance"
                                    data-id="${row.facility_id}"
                                    data-name="${escapeHtml(row.facility_name)}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#maintenanceModal">
                                <i class="bi bi-wrench-adjustable"></i> Record
                            </button>
                            <button type="button"
                                    class="btn-action text-indigo btn-predict-next"
                                    title="Predict / Refresh Next Action"
                                    data-id="${row.facility_id}"
                                    data-name="${escapeHtml(row.facility_name)}">
                                <i class="bi bi-cpu"></i> Predict
                            </button>
                            <button type="button"
                                    class="btn-action text-secondary"
                                    title="View History"
                                    data-bs-toggle="modal"
                                    data-bs-target="#historyModal${row.facility_id}">
                                <i class="bi bi-clock-history"></i> History ${countBadge}
                            </button>
                            <button type="button"
                                    class="btn-action text-info btn-edit-facility"
                                    title="Edit Facility"
                                    data-id="${row.facility_id}"
                                    data-name="${escapeHtml(row.facility_name)}"
                                    data-campus="${escapeHtml(row.campus?.campus_name || '')}"
                                    data-established="${escapeHtml(row.date_establish || '')}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button"
                                    class="btn-action text-danger btn-delete-facility"
                                    title="Delete Facility"
                                    data-id="${row.facility_id}"
                                    data-name="${escapeHtml(row.facility_name)}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        drawCallback: function () {
            const api = this.api();
            $('#historyModalsContainer').empty();
            api.rows({ page: 'current' }).data().each(function (row) {
                buildHistoryModal(row);
            });
        },
        language: {
            emptyTable: '<div class="py-4 text-muted"><i class="bi bi-building-slash d-block fs-3 mb-2"></i>No facilities registered yet.</div>',
            zeroRecords: '<div class="py-4 text-muted"><i class="bi bi-search d-block fs-3 mb-2"></i>No matching facilities found.</div>',
            info: 'Showing _START_ to _END_ of _TOTAL_ facilities',
            infoEmpty: 'Showing 0 facilities',
            lengthMenu: 'Show _MENU_'
        }
    });

    // Custom Search Filter
    $('#facilitySearch').on('keyup', function () {
        facilityTable.search(this.value).draw();
    });

    /*
    |--------------------------------------------------------------------------
    | PREDICT / REFRESH NEXT MAINTENANCE ACTION (AJAX)
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-predict-next', function () {
        const btn = $(this);
        const facilityId = btn.data('id');
        const originalHtml = btn.html();

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        const url = "{{ route('facility-provider.next-action.predict', ':id') }}".replace(':id', facilityId);

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success && response.data) {
                    Toast.fire({
                        icon: 'success',
                        title: `Next Action: ${response.data.predicted_next_action}`
                    });
                    facilityTable.ajax.reload(null, false);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message || 'Unable to predict next action.'
                    });
                }
            },
            error: function (xhr) {
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON?.message || 'Unable to predict next action.'
                });
            },
            complete: function () {
                btn.prop('disabled', false).html(originalHtml);
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | DYNAMIC HISTORY MODAL BUILDER (WITH PREDICTION SUMMARY + EDIT & DELETE)
    |--------------------------------------------------------------------------
    */
    function buildHistoryModal(facility) {
        const modalId = `historyModal${facility.facility_id}`;
        if ($(`#${modalId}`).length) {
            $(`#${modalId}`).remove();
        }

        const histories = facility.maintenance_histories || [];
        let historyContent = buildPredictionBoxHtml(facility.next_prediction);

        if (histories.length > 0) {
            const sorted = [...histories].sort((a, b) => new Date(b.maintenance_date) - new Date(a.maintenance_date));
            historyContent += '<div class="history-timeline">';
            sorted.forEach(function (history) {
                const recordId = history.maintenance_id ?? history.id;
                const rawDate = history.maintenance_date ? history.maintenance_date.split('T')[0] : '';

                historyContent += `
                    <div class="history-item">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="mb-1">${getMaintenanceBadge(history.maintenance_type)}</div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    ${formatDate(history.maintenance_date)}
                                </small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-semibold text-success me-2">
                                    ₱${formatCurrency(history.maintenance_cost)}
                                </span>
                                <button type="button"
                                        class="btn-action text-info btn-edit-history"
                                        data-id="${recordId}"
                                        data-facility-id="${facility.facility_id}"
                                        data-facility-name="${escapeHtml(facility.facility_name)}"
                                        data-date="${escapeHtml(rawDate)}"
                                        data-type="${escapeHtml(history.maintenance_type)}"
                                        data-description="${escapeHtml(history.maintenance_description || '')}"
                                        data-cost="${history.maintenance_cost ?? ''}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button type="button"
                                        class="btn-action text-danger btn-delete-history"
                                        data-id="${recordId}"
                                        data-facility-id="${facility.facility_id}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                        <p class="text-muted small mt-2 mb-0">
                            ${escapeHtml(history.maintenance_description || 'No description provided.')}
                        </p>
                    </div>
                `;
            });
            historyContent += '</div>';
        } else {
            historyContent += `
                <div class="text-center py-5">
                    <i class="bi bi-clipboard-x text-secondary" style="font-size:42px;"></i>
                    <h6 class="mt-3 fw-bold">No Maintenance History</h6>
                    <p class="text-muted small">No maintenance records have been added for this facility yet.</p>
                </div>
            `;
        }

        const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title">
                                    <i class="bi bi-clock-history me-2"></i> Maintenance History
                                </h5>
                                <small class="text-muted">${escapeHtml(facility.facility_name)}</small>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            ${historyContent}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('#historyModalsContainer').append(modalHtml);
    }

    /*
    |--------------------------------------------------------------------------
    | SELECT FACILITY FOR MAINTENANCE RECORDING
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-record-maintenance', function () {
        const facilityId = $(this).data('id');
        const facilityName = $(this).data('name');
        $('#maintenance_facility_id').val(facilityId);
        $('#maintenance_facility_name').val(facilityName);
    });

    /*
    |--------------------------------------------------------------------------
    | STORE NEW FACILITY (AJAX)
    |--------------------------------------------------------------------------
    */
    $('#addFacilityForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        const formData = new FormData(this);
        const submitBtn = $('#btnSaveFacility');

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Saving...');

        $.ajax({
            url: "{{ route('facility-provider.store') }}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Facility Registered!' });
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('addFacilityModal')).hide();
                    $('#addFacilityForm')[0].reset();
                    facilityTable.ajax.reload(null, false);
                } else {
                    Toast.fire({ icon: 'error', title: response.message || 'Unable to save facility.' });
                }
            },
            error: function (xhr) {
                handleValidationErrors(xhr, 'add');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Save Facility');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | OPEN EDIT MODAL & POPULATE DATA
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-edit-facility', function () {
        const facilityId = $(this).data('id');
        const facilityName = $(this).data('name');
        const campusName = $(this).data('campus');
        const dateEstablished = $(this).data('established');

        $('#edit_facility_id').val(facilityId);
        $('#edit_facility_name').val(facilityName);
        $('#edit_fk_campus_id').val(campusName);
        $('#edit_date_establish').val(dateEstablished);

        clearValidationErrors();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('editFacilityModal')).show();
    });

    /*
    |--------------------------------------------------------------------------
    | UPDATE FACILITY (AJAX)
    |--------------------------------------------------------------------------
    */
    $('#editFacilityForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        const facilityId = $('#edit_facility_id').val();
        const formData = new FormData(this);
        const submitBtn = $('#btnUpdateFacility');

        const url = "{{ route('facility-provider.update', ':id') }}".replace(':id', facilityId);

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Updating...');

        $.ajax({
            url: url,
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Facility Updated!' });
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('editFacilityModal')).hide();
                    facilityTable.ajax.reload(null, false);
                } else {
                    Toast.fire({ icon: 'error', title: response.message || 'Unable to update facility.' });
                }
            },
            error: function (xhr) {
                handleValidationErrors(xhr, 'edit');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Update Facility');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | DELETE FACILITY (AJAX)
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-delete-facility', function () {
        const facilityId = $(this).data('id');
        const facilityName = $(this).data('name');

        Swal.fire({
            title: 'Delete Facility?',
            text: `Are you sure you want to delete "${facilityName}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = "{{ route('facility-provider.destroy', ':id') }}".replace(':id', facilityId);

                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Toast.fire({ icon: 'success', title: 'Facility Deleted!' });
                        facilityTable.ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON?.message || 'Unable to delete facility.'
                        });
                    }
                });
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | STORE MAINTENANCE RECORD (AJAX)
    |--------------------------------------------------------------------------
    */
    $('#maintenanceForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        const formData = new FormData(this);
        const submitBtn = $('#btnSaveMaintenance');

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Processing...');

        $.ajax({
            url: "{{ route('maintenance-provider.store') }}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Maintenance Record Saved!' });
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('maintenanceModal')).hide();
                    $('#maintenanceForm')[0].reset();
                    facilityTable.ajax.reload(null, false);
                } else {
                    Toast.fire({ icon: 'error', title: response.message || 'Unable to save maintenance record.' });
                }
            },
            error: function (xhr) {
                handleValidationErrors(xhr, 'maintenance');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Save Maintenance Record');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | OPEN EDIT MAINTENANCE MODAL
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-edit-history', function () {
        const recordId = $(this).data('id');
        const facilityId = $(this).data('facility-id');
        const facilityName = $(this).data('facility-name');

        const historyModalEl = document.getElementById(`historyModal${facilityId}`);
        if (historyModalEl) {
            bootstrap.Modal.getOrCreateInstance(historyModalEl).hide();
        }

        $('#edit_maintenance_id').val(recordId);
        $('#edit_maintenance_facility_id').val(facilityId);
        $('#edit_maintenance_facility_name').val(facilityName);
        $('#edit_maintenance_date').val($(this).data('date'));
        $('#edit_maintenance_type').val($(this).data('type'));
        $('#edit_maintenance_description').val($(this).data('description'));
        $('#edit_maintenance_cost').val($(this).data('cost'));

        clearValidationErrors();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('editMaintenanceModal')).show();
    });

    /*
    |--------------------------------------------------------------------------
    | UPDATE MAINTENANCE RECORD (AJAX)
    |--------------------------------------------------------------------------
    */
    $('#editMaintenanceForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        const recordId = $('#edit_maintenance_id').val();
        const formData = new FormData(this);
        const submitBtn = $('#btnUpdateMaintenance');

        const url = "{{ route('maintenance-provider.update', ':id') }}".replace(':id', recordId);

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Updating...');

        $.ajax({
            url: url,
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Maintenance Record Updated!' });
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('editMaintenanceModal')).hide();
                    facilityTable.ajax.reload(null, false);
                } else {
                    Toast.fire({ icon: 'error', title: response.message || 'Unable to update maintenance record.' });
                }
            },
            error: function (xhr) {
                handleValidationErrors(xhr, 'edit');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Update Maintenance Record');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | DELETE MAINTENANCE RECORD (AJAX)
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-delete-history', function () {
        const recordId = $(this).data('id');
        const facilityId = $(this).data('facility-id');

        Swal.fire({
            title: 'Delete Maintenance Record?',
            text: 'Are you sure you want to delete this maintenance history entry?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = "{{ route('maintenance-provider.destroy', ':id') }}".replace(':id', recordId);

                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Toast.fire({ icon: 'success', title: 'Maintenance Record Deleted!' });

                        const historyModalEl = document.getElementById(`historyModal${facilityId}`);
                        if (historyModalEl) {
                            bootstrap.Modal.getOrCreateInstance(historyModalEl).hide();
                        }

                        facilityTable.ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON?.message || 'Unable to delete maintenance record.'
                        });
                    }
                });
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | VALIDATION & MODAL RESET HELPERS
    |--------------------------------------------------------------------------
    */
    function clearValidationErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();
    }

    function handleValidationErrors(xhr, context = '') {
        if (xhr.status !== 422) {
            console.error(xhr.responseText);
            Toast.fire({ icon: 'error', title: xhr.responseJSON?.message || 'Something went wrong.' });
            return;
        }

        const errors = xhr.responseJSON.errors || {};
        const prefix = context === 'edit' ? 'edit_' : '';

        $.each(errors, function (field, messages) {
            $('#' + prefix + field).addClass('is-invalid');
            $('#' + prefix + field + '_error').text(messages[0]).show();
        });
    }

    $('#addFacilityModal').on('hidden.bs.modal', function () {
        $('#addFacilityForm')[0].reset();
        clearValidationErrors();
    });

    $('#editFacilityModal').on('hidden.bs.modal', function () {
        $('#editFacilityForm')[0].reset();
        clearValidationErrors();
    });

    $('#maintenanceModal').on('hidden.bs.modal', function () {
        $('#maintenanceForm')[0].reset();
        $('#maintenance_facility_id').val('');
        $('#maintenance_facility_name').val('');
        clearValidationErrors();
    });

    $('#editMaintenanceModal').on('hidden.bs.modal', function () {
        $('#editMaintenanceForm')[0].reset();
        clearValidationErrors();
    });

    // Initial Data Load
    loadFormData();
});
</script>
@endpush

</x-provider>