<x-provider>

@push('styles')
<style>
    .equipment-page { padding: 8px; }

    .equipment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .equipment-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .equipment-header-icon {
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

    .equipment-title {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #111827;
    }

    .equipment-subtitle {
        margin: 4px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .equipment-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(16, 24, 40, .04);
    }

    .equipment-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #eef1f5;
        gap: 16px;
        flex-wrap: wrap;
    }

    .equipment-toolbar-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
    }

    .equipment-toolbar-description {
        font-size: 12px;
        color: #9ca3af;
    }

    /* Search & Filter Styling */
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
    .equipment-table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }

    .equipment-table thead th {
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

    .equipment-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .equipment-table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .equipment-table tbody td {
        padding: 15px 20px !important;
        font-size: 13px;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .equipment-table tbody tr:last-child td {
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
    .equipment-name {
        font-weight: 600;
        color: #0f172a;
        font-size: 13.5px;
    }

    .dept-badge {
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

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 8px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11.5px;
        font-weight: 600;
    }

    .status-badge,
    .maintenance-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .badge-operational       { background: #ecfdf5; color: #059669; }
    .badge-needs_maintenance { background: #fffbeb; color: #d97706; }
    .badge-under_repair      { background: #fef2f2; color: #dc2626; }
    .badge-retired           { background: #f1f5f9; color: #64748b; }

    .badge-preventive  { background: #ecfdf5; color: #059669; }
    .badge-corrective  { background: #fffbeb; color: #d97706; }
    .badge-adaptive    { background: #eff6ff; color: #2563eb; }
    .badge-default     { background: #f1f5f9; color: #475569; }

    .no-maintenance {
        color: #94a3b8;
        font-size: 12px;
        font-style: italic;
    }

    .prediction-meta {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 4px;
    }

    /* Buttons */
    .btn-equipment {
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

    .btn-equipment:hover {
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
        padding: 16px;
    }

    @media(max-width:768px) {
        .equipment-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 15px;
        }
        .equipment-header .btn-equipment,
        .search-wrapper {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

<div class="equipment-page">

    {{-- PAGE HEADER --}}
    <div class="equipment-header">
        <div class="equipment-header-left">
            <div class="equipment-header-icon">
                <i class="bi bi-pc-display"></i>
            </div>
            <div>
                <h4 class="equipment-title">Equipment Monitoring</h4>
                <p class="equipment-subtitle">
                    Monitor MIS equipment, operational status, maintenance history, and next-action predictions
                </p>
            </div>
        </div>

        <button type="button"
                class="btn-equipment"
                data-bs-toggle="modal"
                data-bs-target="#addEquipmentModal">
            <i class="bi bi-plus-lg"></i>
            Add Equipment
        </button>
    </div>

    {{-- EQUIPMENT DIRECTORY --}}
    <div class="equipment-card">
        <div class="equipment-toolbar">
            <div>
                <div class="equipment-toolbar-title">
                    Equipment Directory
                </div>
                <div class="equipment-toolbar-description">
                    View registered equipment, department assignments, status, maintenance logs, and predicted next actions
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <select id="categoryFilter" class="form-select form-select-sm" style="width: auto;">
                    <option value="">All Categories</option>
                    <option value="Network">Network</option>
                    <option value="Computer Equipment">Computer Equipment</option>
                    <option value="Printing Equipment">Printing Equipment</option>
                    <option value="Multimedia Equipment">Multimedia Equipment</option>
                    <option value="Server and Storage">Server and Storage</option>
                    <option value="Power and Accessories">Power and Accessories</option>
                </select>

                <select id="statusFilter" class="form-select form-select-sm" style="width: auto;">
                    <option value="">All Statuses</option>
                    <option value="operational">Operational</option>
                    <option value="needs_maintenance">Needs Maintenance</option>
                    <option value="under_repair">Under Repair</option>
                    <option value="retired">Retired</option>
                </select>

                <div class="search-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text"
                           id="equipmentSearch"
                           class="form-control"
                           placeholder="Search equipment, serial, dept...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="equipmentTable" class="equipment-table">
                <thead>
                    <tr>
                        <th>Equipment</th>
                        <th>Category</th>
                        <th>Serial Number</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Date Acquired</th>
                        <th>Last Maintenance</th>
                        <th>Predicted Next Action</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

{{-- ADD EQUIPMENT MODAL --}}
<div class="modal fade"
     id="addEquipmentModal"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pc-display-horizontal me-2"></i>
                    Add Equipment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="addEquipmentForm" action="javascript:void(0);" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Equipment Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="equipment_name"
                                   name="equipment_name"
                                   class="form-control"
                                   placeholder="e.g., Cisco Catalyst Switch, Dell OptiPlex"
                                   required>
                            <div id="equipment_name_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>
                            <select id="category"
                                    name="category"
                                    class="form-select"
                                    required>
                                <option value="">Select category</option>
                                <option value="Network">Network</option>
                                <option value="Computer Equipment">Computer Equipment</option>
                                <option value="Printing Equipment">Printing Equipment</option>
                                <option value="Multimedia Equipment">Multimedia Equipment</option>
                                <option value="Server and Storage">Server and Storage</option>
                                <option value="Power and Accessories">Power and Accessories</option>
                            </select>
                            <div id="category_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Serial Number
                            </label>
                            <input type="text"
                                   id="serial_number"
                                   name="serial_number"
                                   class="form-control"
                                   placeholder="Enter serial number">
                            <div id="serial_number_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Department <span class="text-danger">*</span>
                            </label>
                            <select id="fk_department_id"
                                    name="fk_department_id"
                                    class="form-select"
                                    required>
                                <option value="">Select department</option>
                            </select>
                            <div id="fk_department_id_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select id="status"
                                    name="status"
                                    class="form-select"
                                    required>
                                <option value="operational">Operational</option>
                                <option value="needs_maintenance">Needs Maintenance</option>
                                <option value="under_repair">Under Repair</option>
                                <option value="retired">Retired</option>
                            </select>
                            <div id="status_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Date Acquired
                            </label>
                            <input type="date"
                                   id="date_acquired"
                                   name="date_acquired"
                                   class="form-control"
                                   max="{{ date('Y-m-d') }}">
                            <div id="date_acquired_error" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveEquipment">
                        <i class="bi bi-save me-1"></i> Save Equipment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT EQUIPMENT MODAL --}}
<div class="modal fade"
     id="editEquipmentModal"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Equipment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editEquipmentForm" action="javascript:void(0);" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_equipment_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Equipment Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="edit_equipment_name"
                                   name="equipment_name"
                                   class="form-control"
                                   required>
                            <div id="edit_equipment_name_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>
                            <select id="edit_category"
                                    name="category"
                                    class="form-select"
                                    required>
                                <option value="">Select category</option>
                                <option value="Network">Network</option>
                                <option value="Computer Equipment">Computer Equipment</option>
                                <option value="Printing Equipment">Printing Equipment</option>
                                <option value="Multimedia Equipment">Multimedia Equipment</option>
                                <option value="Server and Storage">Server and Storage</option>
                                <option value="Power and Accessories">Power and Accessories</option>
                            </select>
                            <div id="edit_category_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Serial Number
                            </label>
                            <input type="text"
                                   id="edit_serial_number"
                                   name="serial_number"
                                   class="form-control">
                            <div id="edit_serial_number_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Department <span class="text-danger">*</span>
                            </label>
                            <select id="edit_fk_department_id"
                                    name="fk_department_id"
                                    class="form-select"
                                    required>
                                <option value="">Select department</option>
                            </select>
                            <div id="edit_fk_department_id_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select id="edit_status"
                                    name="status"
                                    class="form-select"
                                    required>
                                <option value="operational">Operational</option>
                                <option value="needs_maintenance">Needs Maintenance</option>
                                <option value="under_repair">Under Repair</option>
                                <option value="retired">Retired</option>
                            </select>
                            <div id="edit_status_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Date Acquired
                            </label>
                            <input type="date"
                                   id="edit_date_acquired"
                                   name="date_acquired"
                                   class="form-control"
                                   max="{{ date('Y-m-d') }}">
                            <div id="edit_date_acquired_error" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnUpdateEquipment">
                        <i class="bi bi-save me-1"></i> Update Equipment
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
                        Record a maintenance activity for this equipment
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="maintenanceForm" action="javascript:void(0);" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="fk_equipment_id" id="maintenance_equipment_id">

                    <div class="mb-3">
                        <label class="form-label">Selected Equipment</label>
                        <input type="text" id="maintenance_equipment_name" class="form-control" readonly>
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
                                <option value="Preventive">Preventive</option>
                                <option value="Corrective">Corrective</option>
                                <option value="Adaptive">Adaptive</option>
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
                <input type="hidden" name="fk_equipment_id" id="edit_maintenance_equipment_id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Selected Equipment</label>
                        <input type="text" id="edit_maintenance_equipment_name" class="form-control" readonly>
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
                                <option value="Preventive">Preventive</option>
                                <option value="Corrective">Corrective</option>
                                <option value="Adaptive">Adaptive</option>
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

{{-- NEXT MAINTENANCE PREDICTION MODAL --}}
<div class="modal fade"
     id="predictionModal"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">
                        <i class="bi bi-cpu me-2"></i>
                        Next Maintenance Prediction
                    </h5>
                    <small class="text-muted" id="predictionEquipmentSubtitle">Equipment</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="predictionModalBody">
                <div class="text-center py-4 text-muted">
                    <span class="spinner-border spinner-border-sm me-2"></span>Loading prediction...
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-primary" id="btnRerunPrediction" data-id="">
                    <i class="bi bi-arrow-clockwise me-1"></i> Re-run Prediction
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- VIEW HISTORY MODAL CONTAINER --}}
<div id="historyModalsContainer"></div>

@push('scripts')
<script>
$(document).ready(function () {
    $.fn.dataTable.ext.errMode = 'none';

    let departments = [];
    let activePredictionEquipmentId = null;
    let activePredictionEquipmentName = '';

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const cleanDate = String(dateString).split('T')[0];
        const parts = cleanDate.split('-');
        const dateObj = parts.length === 3
            ? new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]))
            : new Date(dateString);
        if (isNaN(dateObj.getTime())) return 'N/A';
        const options = { year: 'numeric', month: 'short', day: '2-digit' };
        return dateObj.toLocaleDateString('en-US', options);
    }

    function formatConfidence(value) {
        const num = Number(value);
        if (isNaN(num)) return 'N/A';
        const pct = num <= 1 ? (num * 100) : num;
        return `${pct.toFixed(1)}%`;
    }

    function getHistories(row) {
        return row?.maintenance_histories ?? row?.maintenanceHistories ?? [];
    }

    function getPrediction(row) {
        return row?.next_prediction ?? row?.nextPrediction ?? null;
    }

    function getStatusBadge(status) {
        const statuses = {
            'operational':       { label: 'Operational',       class: 'badge-operational',       icon: 'bi-check-circle' },
            'needs_maintenance': { label: 'Needs Maintenance', class: 'badge-needs_maintenance', icon: 'bi-exclamation-triangle' },
            'under_repair':      { label: 'Under Repair',      class: 'badge-under_repair',      icon: 'bi-tools' },
            'retired':           { label: 'Retired',           class: 'badge-retired',           icon: 'bi-archive' }
        };
        const item = statuses[status] || { label: status || 'Unknown', class: 'badge-default', icon: 'bi-tag' };
        return `<span class="status-badge ${item.class}"><i class="bi ${item.icon}"></i> ${escapeHtml(item.label)}</span>`;
    }

    function getMaintenanceBadge(type) {
        const badges = {
            'Preventive': { class: 'badge-preventive', icon: 'bi-shield-check' },
            'Corrective': { class: 'badge-corrective', icon: 'bi-tools' },
            'Adaptive':   { class: 'badge-adaptive',   icon: 'bi-arrow-repeat' }
        };
        const badge = badges[type] || { class: 'badge-default', icon: 'bi-tag' };
        return `<span class="maintenance-badge ${badge.class}"><i class="bi ${badge.icon}"></i> ${escapeHtml(type)}</span>`;
    }

    function renderProbabilityRows(title, probMap) {
        if (!probMap || typeof probMap !== 'object' || !Object.keys(probMap).length) {
            return `<div class="text-muted small">No ${escapeHtml(title)} available.</div>`;
        }

        let html = `<div class="mb-3"><div class="form-label mb-2">${escapeHtml(title)}</div>`;
        Object.entries(probMap).forEach(function ([action, prob]) {
            const num = Number(prob) || 0;
            const pct = num <= 1 ? (num * 100) : num;
            const clamped = Math.max(0, Math.min(100, pct));

            html += `
                <div class="mb-2">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="fw-semibold text-dark">${escapeHtml(action)}</span>
                        <span class="text-muted">${clamped.toFixed(1)}%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: ${clamped.toFixed(1)}%;"></div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        return html;
    }

    function renderPredictionModalContent(pred, errorMessage = null) {
        if (errorMessage) {
            $('#predictionModalBody').html(`
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    ${escapeHtml(errorMessage)}
                </div>
            `);
            return;
        }

        if (!pred) {
            $('#predictionModalBody').html(`
                <div class="text-center py-4 text-muted">
                    No prediction available yet. Click <strong>Re-run Prediction</strong> to generate one.
                </div>
            `);
            return;
        }

        const probs = pred.probabilities || {};
        const markovProbs = pred.markov_probabilities || {};

        $('#predictionModalBody').html(`
            <div class="prediction-summary-box mb-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                    <div>
                        <span class="text-muted small d-block">Predicted Next Action</span>
                        <div class="mt-1">${getMaintenanceBadge(pred.predicted_next_action)}</div>
                    </div>
                    <div class="text-end">
                        <span class="text-muted small d-block">Confidence</span>
                        <span class="fw-bold text-dark fs-6">${formatConfidence(pred.confidence)}</span>
                    </div>
                </div>
                <div class="row g-2 mt-2 pt-2 border-top small text-muted">
                    <div class="col-sm-6">
                        <strong>Est. Next Date:</strong> ${formatDate(pred.predicted_date)}
                    </div>
                    <div class="col-sm-6">
                        <strong>Last Maintenance:</strong> ${escapeHtml(pred.last_maintenance_type || 'N/A')} (${formatDate(pred.last_maintenance_date)})
                    </div>
                    <div class="col-12">
                        <strong>Model:</strong> <code>${escapeHtml(pred.model_used || 'markov')}</code>
                    </div>
                </div>
            </div>

            ${renderProbabilityRows('Blended Action Probabilities', probs)}
            ${renderProbabilityRows('Markov Transition Probabilities', markovProbs)}
        `);
    }

    function loadPredictionModal(equipmentId, equipmentName, rerun = false) {
        activePredictionEquipmentId = equipmentId;
        activePredictionEquipmentName = equipmentName;

        $('#predictionEquipmentSubtitle').text(equipmentName);
        $('#btnRerunPrediction').data('id', equipmentId).prop('disabled', true);
        $('#predictionModalBody').html(`
            <div class="text-center py-4 text-muted">
                <span class="spinner-border spinner-border-sm me-2"></span>
                ${rerun ? 'Running Markov prediction...' : 'Loading prediction...'}
            </div>
        `);

        bootstrap.Modal.getOrCreateInstance(document.getElementById('predictionModal')).show();

        const url = rerun
            ? "{{ route('equipment-provider.next-action.predict', ':id') }}".replace(':id', equipmentId)
            : "{{ route('equipment-provider.next-action', ':id') }}".replace(':id', equipmentId);

        $.ajax({
            url: url,
            type: rerun ? 'POST' : 'GET',
            data: rerun ? { _token: $('meta[name="csrf-token"]').attr('content') } : {},
            success: function (response) {
                if (response.success && response.data) {
                    renderPredictionModalContent(response.data);
                    if (rerun) {
                        equipmentTable.ajax.reload(null, false);
                        Toast.fire({ icon: 'success', title: response.message || 'Prediction updated!' });
                    }
                } else {
                    renderPredictionModalContent(null, response.message || 'Unable to load prediction.');
                }
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || 'Unable to generate prediction for this equipment.';
                renderPredictionModalContent(null, msg);
            },
            complete: function () {
                $('#btnRerunPrediction').prop('disabled', false);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD FORM DATA (DEPARTMENTS)
    |--------------------------------------------------------------------------
    */
    function loadFormData() {
        $.ajax({
            url: "{{ route('equipment-provider.createData') }}",
            type: 'GET',
            success: function (response) {
                departments = response.departments || [];
                let options = '<option value="">Select department</option>';
                departments.forEach(function (dept) {
                    const deptId = dept.department_id ?? dept.id;
                    const deptName = dept.department_name ?? dept.name;
                    options += `<option value="${escapeHtml(deptId)}">${escapeHtml(deptName)}</option>`;
                });
                $('#fk_department_id, #edit_fk_department_id').html(options);
            },
            error: function (xhr) {
                console.error('Failed to load departments:', xhr.status, xhr.responseJSON || xhr.responseText);
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON?.message || 'Unable to load department options.'
                });
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | EQUIPMENT DATATABLE (AJAX)
    |--------------------------------------------------------------------------
    */
    const equipmentTable = $('#equipmentTable').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        ordering: true,
        order: [],
        dom: 'rt<"dt-footer-wrapper"<"d-flex align-items-center gap-3"li>p>',
        ajax: {
            url: "{{ route('equipment-provider.index') }}",
            type: 'GET',
            data: function (d) {
                d.category = $('#categoryFilter').val();
                d.status = $('#statusFilter').val();
            },
            dataSrc: function (json) {
                if (Array.isArray(json)) return json;
                return json.data || [];
            },
            error: function (xhr, thrown, err) {
                console.error('Equipment DataTable Ajax Error:', xhr.status, xhr.responseJSON || xhr.responseText);
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON?.message || `Failed to load equipment (${xhr.status}).`
                });
            }
        },
        columns: [
            {
                data: 'equipment_name',
                defaultContent: '',
                render: function (data) {
                    return `<div class="equipment-name">${escapeHtml(data)}</div>`;
                }
            },
            {
                data: 'category',
                defaultContent: '',
                render: function (data) {
                    return `<span class="category-badge">${escapeHtml(data)}</span>`;
                }
            },
            {
                data: 'serial_number',
                defaultContent: null,
                render: function (data) {
                    return data
                        ? `<span class="text-dark">${escapeHtml(data)}</span>`
                        : '<span class="text-muted">—</span>';
                }
            },
            {
                data: 'department.department_name',
                defaultContent: 'N/A',
                render: function (data) {
                    return `<span class="dept-badge"><i class="bi bi-diagram-3 text-primary"></i> ${escapeHtml(data)}</span>`;
                }
            },
            {
                data: 'status',
                defaultContent: '',
                render: function (data) {
                    return getStatusBadge(data);
                }
            },
            {
                data: 'date_acquired',
                defaultContent: null,
                render: function (data) {
                    return `<span class="text-muted">${formatDate(data)}</span>`;
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    const histories = getHistories(row);
                    if (!histories.length) {
                        return '<span class="no-maintenance">No maintenance recorded</span>';
                    }
                    const sorted = [...histories].sort((a, b) => new Date(b.maintenance_date) - new Date(a.maintenance_date));
                    return `
                        <div>
                            <div class="fw-semibold text-dark">${formatDate(sorted[0].maintenance_date)}</div>
                            <div class="mt-1">${getMaintenanceBadge(sorted[0].maintenance_type)}</div>
                        </div>
                    `;
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    const pred = getPrediction(row);
                    if (!pred || !pred.predicted_next_action) {
                        return '<span class="no-maintenance">Pending prediction</span>';
                    }
                    return `
                        <div>
                            <div>${getMaintenanceBadge(pred.predicted_next_action)}</div>
                            <div class="prediction-meta">
                                ${formatConfidence(pred.confidence)} &middot; ${formatDate(pred.predicted_date)}
                            </div>
                        </div>
                    `;
                }
            },
            {
                data: 'equipment_id',
                orderable: false,
                searchable: false,
                className: 'text-end',
                render: function (data, type, row) {
                    const histories = getHistories(row);
                    const count = histories.length;
                    const countBadge = count > 0 ? `<span class="badge bg-secondary ms-1">${count}</span>` : '';
                    const rawAcquired = row.date_acquired ? String(row.date_acquired).split('T')[0] : '';

                    return `
                        <div class="d-flex justify-content-end gap-1 flex-wrap">
                            <button type="button"
                                    class="btn-action text-primary btn-record-maintenance"
                                    title="Record Maintenance"
                                    data-id="${row.equipment_id}"
                                    data-name="${escapeHtml(row.equipment_name)}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#maintenanceModal">
                                <i class="bi bi-wrench-adjustable"></i> Record
                            </button>
                            <button type="button"
                                    class="btn-action text-indigo btn-view-prediction"
                                    style="color:#4338ca;"
                                    title="Next Maintenance Prediction"
                                    data-id="${row.equipment_id}"
                                    data-name="${escapeHtml(row.equipment_name)}">
                                <i class="bi bi-cpu"></i> Next Action
                            </button>
                            <button type="button"
                                    class="btn-action text-secondary"
                                    title="View History"
                                    data-bs-toggle="modal"
                                    data-bs-target="#historyModal${row.equipment_id}">
                                <i class="bi bi-clock-history"></i> History ${countBadge}
                            </button>
                            <button type="button"
                                    class="btn-action text-info btn-edit-equipment"
                                    title="Edit Equipment"
                                    data-id="${row.equipment_id}"
                                    data-name="${escapeHtml(row.equipment_name)}"
                                    data-category="${escapeHtml(row.category || '')}"
                                    data-serial="${escapeHtml(row.serial_number || '')}"
                                    data-department-id="${escapeHtml(row.fk_department_id || '')}"
                                    data-status="${escapeHtml(row.status || 'operational')}"
                                    data-acquired="${escapeHtml(rawAcquired)}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button"
                                    class="btn-action text-danger btn-delete-equipment"
                                    title="Delete Equipment"
                                    data-id="${row.equipment_id}"
                                    data-name="${escapeHtml(row.equipment_name)}">
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
            emptyTable: '<div class="py-4 text-muted"><i class="bi bi-pc-display d-block fs-3 mb-2"></i>No equipment registered yet.</div>',
            zeroRecords: '<div class="py-4 text-muted"><i class="bi bi-search d-block fs-3 mb-2"></i>No matching equipment found.</div>',
            info: 'Showing _START_ to _END_ of _TOTAL_ equipment',
            infoEmpty: 'Showing 0 equipment',
            lengthMenu: 'Show _MENU_'
        }
    });

    // Custom Search & Dropdown Filters
    $('#equipmentSearch').on('keyup', function () {
        equipmentTable.search(this.value).draw();
    });

    $('#categoryFilter, #statusFilter').on('change', function () {
        equipmentTable.ajax.reload();
    });

    /*
    |--------------------------------------------------------------------------
    | PREDICTION MODAL TRIGGERS
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-view-prediction', function () {
        const equipmentId = $(this).data('id');
        const equipmentName = $(this).data('name');
        loadPredictionModal(equipmentId, equipmentName, false);
    });

    $('#btnRerunPrediction').on('click', function () {
        if (!activePredictionEquipmentId) return;
        loadPredictionModal(activePredictionEquipmentId, activePredictionEquipmentName, true);
    });

    /*
    |--------------------------------------------------------------------------
    | DYNAMIC HISTORY MODAL BUILDER (WITH EDIT & DELETE)
    |--------------------------------------------------------------------------
    */
    function buildHistoryModal(equipment) {
        const modalId = `historyModal${equipment.equipment_id}`;
        if ($(`#${modalId}`).length) {
            $(`#${modalId}`).remove();
        }

        const histories = getHistories(equipment);
        let historyContent = '';

        if (histories.length > 0) {
            const sorted = [...histories].sort((a, b) => new Date(b.maintenance_date) - new Date(a.maintenance_date));
            historyContent += '<div class="history-timeline">';
            sorted.forEach(function (history) {
                const recordId = history.maintenance_id ?? history.id;
                const rawDate = history.maintenance_date ? String(history.maintenance_date).split('T')[0] : '';

                historyContent += `
                    <div class="history-item">
                        <div class="d-flex justify-content-between align-items-start gap-2 flex-wrap">
                            <div>
                                <div class="mb-1">${getMaintenanceBadge(history.maintenance_type)}</div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    ${formatDate(history.maintenance_date)}
                                </small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button"
                                        class="btn-action text-info btn-edit-history"
                                        data-id="${recordId}"
                                        data-equipment-id="${equipment.equipment_id}"
                                        data-equipment-name="${escapeHtml(equipment.equipment_name)}"
                                        data-date="${escapeHtml(rawDate)}"
                                        data-type="${escapeHtml(history.maintenance_type)}"
                                        data-description="${escapeHtml(history.maintenance_description || '')}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button type="button"
                                        class="btn-action text-danger btn-delete-history"
                                        data-id="${recordId}"
                                        data-equipment-id="${equipment.equipment_id}">
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
                    <p class="text-muted small">No maintenance records have been added for this equipment yet.</p>
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
                                <small class="text-muted">${escapeHtml(equipment.equipment_name)}</small>
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
    | SELECT EQUIPMENT FOR MAINTENANCE RECORDING
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-record-maintenance', function () {
        const equipmentId = $(this).data('id');
        const equipmentName = $(this).data('name');
        $('#maintenance_equipment_id').val(equipmentId);
        $('#maintenance_equipment_name').val(equipmentName);
    });

    /*
    |--------------------------------------------------------------------------
    | STORE NEW EQUIPMENT (AJAX)
    |--------------------------------------------------------------------------
    */
    $('#addEquipmentForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        const formData = new FormData(this);
        const submitBtn = $('#btnSaveEquipment');

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Saving...');

        $.ajax({
            url: "{{ route('equipment-provider.store') }}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Equipment Added!' });
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('addEquipmentModal')).hide();
                    $('#addEquipmentForm')[0].reset();
                    equipmentTable.ajax.reload(null, false);
                } else {
                    Toast.fire({ icon: 'error', title: response.message || 'Unable to save equipment.' });
                }
            },
            error: function (xhr) {
                handleValidationErrors(xhr, 'add');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Save Equipment');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | OPEN EDIT MODAL & POPULATE DATA
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-edit-equipment', function () {
        $('#edit_equipment_id').val($(this).data('id'));
        $('#edit_equipment_name').val($(this).data('name'));
        $('#edit_category').val($(this).data('category'));
        $('#edit_serial_number').val($(this).data('serial'));
        $('#edit_fk_department_id').val($(this).data('department-id'));
        $('#edit_status').val($(this).data('status'));
        $('#edit_date_acquired').val($(this).data('acquired'));

        clearValidationErrors();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('editEquipmentModal')).show();
    });

    /*
    |--------------------------------------------------------------------------
    | UPDATE EQUIPMENT (AJAX)
    |--------------------------------------------------------------------------
    */
    $('#editEquipmentForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        const equipmentId = $('#edit_equipment_id').val();
        const formData = new FormData(this);
        const submitBtn = $('#btnUpdateEquipment');

        const url = "{{ route('equipment-provider.update', ':id') }}".replace(':id', equipmentId);

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Updating...');

        $.ajax({
            url: url,
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Equipment Updated!' });
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('editEquipmentModal')).hide();
                    equipmentTable.ajax.reload(null, false);
                } else {
                    Toast.fire({ icon: 'error', title: response.message || 'Unable to update equipment.' });
                }
            },
            error: function (xhr) {
                handleValidationErrors(xhr, 'edit');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Update Equipment');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | DELETE EQUIPMENT (AJAX)
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-delete-equipment', function () {
        const equipmentId = $(this).data('id');
        const equipmentName = $(this).data('name');

        Swal.fire({
            title: 'Delete Equipment?',
            text: `Are you sure you want to delete "${equipmentName}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = "{{ route('equipment-provider.destroy', ':id') }}".replace(':id', equipmentId);

                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Toast.fire({ icon: 'success', title: 'Equipment Deleted!' });
                        equipmentTable.ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON?.message || 'Unable to delete equipment.'
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
            url: "{{ route('equipment-maintenance-provider.store') }}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Maintenance Record Saved!' });
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('maintenanceModal')).hide();
                    $('#maintenanceForm')[0].reset();
                    equipmentTable.ajax.reload(null, false);
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
        const equipmentId = $(this).data('equipment-id');
        const equipmentName = $(this).data('equipment-name');

        const historyModalEl = document.getElementById(`historyModal${equipmentId}`);
        if (historyModalEl) {
            bootstrap.Modal.getOrCreateInstance(historyModalEl).hide();
        }

        $('#edit_maintenance_id').val(recordId);
        $('#edit_maintenance_equipment_id').val(equipmentId);
        $('#edit_maintenance_equipment_name').val(equipmentName);
        $('#edit_maintenance_date').val($(this).data('date'));
        $('#edit_maintenance_type').val($(this).data('type'));
        $('#edit_maintenance_description').val($(this).data('description'));

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

        const url = "{{ route('equipment-maintenance-provider.update', ':id') }}".replace(':id', recordId);

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
                    equipmentTable.ajax.reload(null, false);
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
        const equipmentId = $(this).data('equipment-id');

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
                const url = "{{ route('equipment-maintenance-provider.destroy', ':id') }}".replace(':id', recordId);

                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Toast.fire({ icon: 'success', title: 'Maintenance Record Deleted!' });

                        const historyModalEl = document.getElementById(`historyModal${equipmentId}`);
                        if (historyModalEl) {
                            bootstrap.Modal.getOrCreateInstance(historyModalEl).hide();
                        }

                        equipmentTable.ajax.reload(null, false);
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

    $('#addEquipmentModal').on('hidden.bs.modal', function () {
        $('#addEquipmentForm')[0].reset();
        clearValidationErrors();
    });

    $('#editEquipmentModal').on('hidden.bs.modal', function () {
        $('#editEquipmentForm')[0].reset();
        clearValidationErrors();
    });

    $('#maintenanceModal').on('hidden.bs.modal', function () {
        $('#maintenanceForm')[0].reset();
        $('#maintenance_equipment_id').val('');
        $('#maintenance_equipment_name').val('');
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