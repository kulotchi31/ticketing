<x-provider>

@push('styles')
<style>
    .ticket-page { padding: 8px; }

    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .ticket-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .ticket-header-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: #fff;
        font-size: 22px;
        box-shadow: 0 8px 20px rgba(37, 99, 235, .18);
    }

    .ticket-title {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #111827;
        letter-spacing: -.3px;
    }

    .ticket-subtitle {
        margin: 4px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .btn-add-ticket {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border: 0;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        background: #2563eb;
        color: #fff;
        box-shadow: 0 6px 16px rgba(37, 99, 235, .20);
        transition: all .2s ease;
    }

    .btn-add-ticket:hover {
        background: #1d4ed8;
        color: #fff;
        transform: translateY(-1px);
    }

    /* Filter Tabs */
    .ticket-tabs-wrapper {
        margin-bottom: 18px;
    }

    .ticket-tabs {
        display: inline-flex;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 10px;
        gap: 4px;
        flex-wrap: wrap;
    }

    .ticket-tab-btn {
        border: none;
        background: transparent;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all .2s ease;
    }

    .ticket-tab-btn:hover {
        color: #1e293b;
    }

    .ticket-tab-btn.active {
        background: #ffffff;
        color: #2563eb;
        box-shadow: 0 2px 6px rgba(15, 23, 42, .06);
    }

    .ticket-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .02), 0 8px 24px rgba(16, 24, 40, .04);
    }

    .ticket-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #eef1f5;
    }

    .ticket-toolbar-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .ticket-toolbar-description {
        font-size: 12px;
        color: #9ca3af;
    }

    .ticket-search { position: relative; }

    .ticket-search i {
        position: absolute;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 14px;
    }

    .ticket-search input {
        width: 260px;
        height: 38px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        padding: 0 14px 0 38px;
        font-size: 13px;
        outline: none;
        transition: all .2s ease;
    }

    .ticket-search input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .ticket-table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }

    .ticket-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        padding: 14px 20px !important;
        border-bottom: 1px solid #e9edf3 !important;
        white-space: nowrap;
    }

    .ticket-table tbody td {
        padding: 16px 20px !important;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f0f2f5 !important;
        vertical-align: middle;
    }

    .ticket-table tbody tr { transition: all .15s ease; }
    .ticket-table tbody tr:hover { background: #f8fbff; }
    .ticket-table tbody tr:last-child td { border-bottom: none !important; }

    .ticket-number {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #1f2937;
    }

    .ticket-avatar {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 15px;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 7px;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #64748b;
        font-size: 14px;
        cursor: pointer;
        transition: all .18s ease;
        text-decoration: none;
    }

    .action-btn.print:hover {
        color: #dc2626;
        border-color: #fecaca;
        background: #fef2f2;
    }

    .dataTables_wrapper { padding: 0 !important; }
    .dataTables_filter, .dataTables_length { display: none !important; }
    .dataTables_info { padding: 18px 24px !important; font-size: 12px !important; color: #94a3b8 !important; }
    .dataTables_paginate { padding: 12px 20px !important; }
    .dataTables_paginate .paginate_button {
        min-width: 34px !important;
        height: 34px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 8px !important;
        margin-left: 4px !important;
        border: 0 !important;
        border-radius: 8px !important;
        background: transparent !important;
        color: #64748b !important;
        font-size: 13px !important;
    }
    .dataTables_paginate .paginate_button:hover { background: #f1f5f9 !important; color: #2563eb !important; }
    .dataTables_paginate .paginate_button.current {
        background: #eff6ff !important;
        color: #2563eb !important;
        font-weight: 600 !important;
    }
    .dataTables_empty { padding: 60px !important; text-align: center !important; color: #94a3b8 !important; }

    @media (max-width: 768px) {
        .ticket-header, .ticket-toolbar {
            align-items: flex-start;
            flex-direction: column;
            gap: 15px;
        }
        .btn-add-ticket { width: 100%; justify-content: center; }
        .ticket-tabs, .ticket-search, .ticket-search input { width: 100%; }
        .ticket-tab-btn { flex: 1; text-align: center; }
    }
</style>
@endpush

<div class="ticket-page">
    <!-- PAGE HEADER -->
    <div class="ticket-header">
        <div class="ticket-header-left">
            <div class="ticket-header-icon"><i class="bi bi-ticket-perforated"></i></div>
            <div>
                <h4 class="ticket-title">University Service Request</h4>
                <p class="ticket-subtitle">Submit, approve, and monitor university service requests</p>
            </div>
        </div>

        <button type="button" class="btn-add-ticket" data-bs-toggle="modal" data-bs-target="#addTicketModal">
            <i class="bi bi-plus-lg"></i> Add Request
        </button>
    </div>

    <!-- STATUS FILTER TABS -->
    <div class="ticket-tabs-wrapper">
        <div class="ticket-tabs" role="tablist">
            <button type="button"
                class="ticket-tab-btn active"
                data-url="{{ route('provider.ticket') }}"
                data-title="For Approval Ticket Directory"
                data-show-pending="false"
                data-show-completed="false"
                data-is-acknowledge="false">
                For Approval
            </button>

            <button type="button"
                class="ticket-tab-btn"
                data-url="{{ route('provider.accepted-ticket') }}"
                data-title="Assigned Ticket Directory"
                data-show-pending="false"
                data-show-completed="false"
                data-is-acknowledge="false">
                Assigned
            </button>

            <button type="button"
                class="ticket-tab-btn"
                data-url="{{ route('provider.wip-ticket') }}"
                data-title="Work In Progress Ticket Directory"
                data-show-pending="false"
                data-show-completed="false"
                data-is-acknowledge="false">
                Work In Progress
            </button>

            <button type="button"
                class="ticket-tab-btn"
                data-url="{{ route('provider.pending-ticket') }}"
                data-title="Pending Ticket Directory"
                data-show-pending="true"
                data-show-completed="false"
                data-is-acknowledge="false">
                Pending
            </button>

            <button type="button"
                class="ticket-tab-btn"
                data-url="{{ route('provider.completed-ticket') }}"
                data-title="Completed Ticket Directory"
                data-show-pending="false"
                data-show-completed="true"
                data-is-acknowledge="false">
                Completed
            </button>

            <button type="button"
                class="ticket-tab-btn"
                data-url="{{ route('provider.acknowledged-ticket') }}"
                data-title="Acknowledged Ticket Directory"
                data-show-pending="false"
                data-show-completed="true"
                data-is-acknowledge="true">
                Acknowledged
            </button>
        </div>
    </div>

    <!-- MAIN CARD -->
    <div class="ticket-card">
        <div class="ticket-toolbar">
            <div>
                <div class="ticket-toolbar-title" id="directoryTitle">For Approval Ticket Directory</div>
                <div class="ticket-toolbar-description">View and manage all registered tickets</div>
            </div>
            <div class="ticket-search">
                <i class="bi bi-search"></i>
                <input type="text" id="ticketSearch" placeholder="Search tickets...">
            </div>
        </div>

        <div class="table-responsive">
            <table id="ticketTable" class="ticket-table">
                <thead>
                    <tr>
                        <th>Ticket Number</th>
                        <th>Classification</th>
                        <th>Campus</th>
                        <th>Department</th>
                        <th>Service Provider</th>
                        <th>Remarks</th>
                        <th>Requested By</th>
                        <th>Category</th>
                        <th>Assigned To</th>
                        <th>Pending Remarks</th>
                        <th>Action Taken</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

{{-- ADD TICKET MODAL --}}
<div class="modal fade" id="addTicketModal" tabindex="-1" aria-labelledby="addTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTicketModalLabel">
                    <i class="bi bi-ticket-perforated me-2"></i> Add Ticket
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addForm" action="javascript:void(0);" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="requested_by" class="form-label">Requested By</label>
                            <input type="text" class="form-control" id="requested_by" name="requested_by"
                                   placeholder="Enter requester name" required>
                            <div id="requested_by_error" class="invalid-feedback"></div>
                        </div>

                        {{-- CAMPUS: automatically populated and locked to the logged-in user's campus --}}
                        <div class="col-md-6 mb-3">
                            <label for="fk_campus_id" class="form-label">Campus</label>
                            <select class="form-select" id="fk_campus_id" disabled>
                                <option value="">Loading campus...</option>
                            </select>
                            <input type="hidden" id="submitted_campus_id" name="fk_campus_id">
                            <div id="fk_campus_id_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fk_department_id" class="form-label">Department</label>
                            <select class="form-select" id="fk_department_id" name="fk_department_id" required disabled>
                                <option value="">Loading department...</option>
                            </select>
                            <div id="fk_department_id_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fk_provider_id" class="form-label">Service Provider</label>
                            <select class="form-select" id="fk_provider_id" name="fk_provider_id" required>
                                <option value="">Select service provider</option>
                            </select>
                            <div id="fk_provider_id_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fk_request_type_id" class="form-label">Request Type</label>
                            <select class="form-select" id="fk_request_type_id" name="fk_request_type_id" required disabled>
                                <option value="">Select service provider first</option>
                            </select>
                            <div id="fk_request_type_id_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fk_category_id" class="form-label">Category</label>
                            <select class="form-select" id="fk_category_id" name="fk_category_id" required disabled>
                                <option value="">Select request type first</option>
                            </select>
                            <div id="fk_category_id_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3"
                                      placeholder="Enter ticket remarks" required></textarea>
                            <div id="remarks_error" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveTicket">
                        <i class="bi bi-save me-1"></i> Save Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- APPROVE AND ASSIGN WORKER MODAL --}}
<div class="modal fade" id="assignWorkerModal" tabindex="-1" aria-labelledby="assignWorkerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignWorkerModalLabel">
                    <i class="bi bi-person-check me-2"></i> Approve & Assign Worker
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="assignWorkerForm">
                @csrf
                <input type="hidden" id="assign_ticket_id" name="ticket_id">

                <div class="modal-body">
                    <p class="text-muted small">
                        Select an active worker assigned to the same service provider and campus as this ticket.
                        Only matching workers will appear.
                    </p>

                    <div class="mb-3">
                        <label for="assign_to" class="form-label">Assign Worker</label>
                        <select class="form-select" id="assign_to" name="assign_to" required>
                            <option value="">Select worker</option>
                        </select>
                        <div id="assign_to_error" class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnApproveAssign">
                        <i class="bi bi-check-circle me-1"></i> Approve & Assign
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    let campuses = [];
    let departments = [];
    let providers = [];
    let requestTypes = [];
    let categories = [];
    let users = [];

    let userCampusId = null;
    let userDepartmentId = null;
    let isAcknowledgeTab = false;

    const printPdfRouteTemplate = "{{ route('provider.ticket.print', ':id') }}";

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    /*
    |--------------------------------------------------------------------------
    | CAMPUS AND DEPARTMENT
    |--------------------------------------------------------------------------
    */

    function populateLockedCampus() {
        const campus = campuses.find(function (item) {
            return String(item.campus_id) === String(userCampusId);
        });

        if (!campus) {
            $('#fk_campus_id')
                .html('<option value="">Campus not assigned</option>')
                .prop('disabled', true);

            $('#submitted_campus_id').val('');
            return;
        }

        $('#fk_campus_id')
            .html(`<option value="${campus.campus_id}" selected>${escapeHtml(campus.campus_name)}</option>`)
            .prop('disabled', true);

        $('#submitted_campus_id').val(campus.campus_id);
    }

    function populateDepartments(campusId, selectedDepartmentId = null) {
        let options = '<option value="">Select department</option>';

        if (!campusId) {
            $('#fk_department_id')
                .html('<option value="">Campus not assigned</option>')
                .prop('disabled', true);
            return;
        }

        const filteredDepartments = departments.filter(function (department) {
            return String(department.fk_campus_id) === String(campusId);
        });

        if (!filteredDepartments.length) {
            $('#fk_department_id')
                .html('<option value="">No departments available for this campus</option>')
                .prop('disabled', true);
            return;
        }

        filteredDepartments.forEach(function (department) {
            options += `
                <option value="${department.department_id}">
                    ${escapeHtml(department.department_name)}
                </option>
            `;
        });

        $('#fk_department_id')
            .html(options)
            .prop('disabled', false);
    }

    /*
    |--------------------------------------------------------------------------
    | PROVIDER / REQUEST TYPE / CATEGORY DROPDOWNS
    |--------------------------------------------------------------------------
    */

    function populateProviders() {
        let options = '<option value="">Select service provider</option>';

        providers.forEach(function (provider) {
            options += `<option value="${provider.provider_id}">${escapeHtml(provider.provider_name)}</option>`;
        });

        $('#fk_provider_id').html(options);
    }

    function populateRequestTypes(providerId) {
        let options = '<option value="">Select request type</option>';

        if (!providerId) {
            $('#fk_request_type_id')
                .html('<option value="">Select service provider first</option>')
                .prop('disabled', true);
            return;
        }

        const filtered = requestTypes.filter(function (item) {
            return String(item.fk_provider_id) === String(providerId);
        });

        if (!filtered.length) {
            options = '<option value="">No request types available</option>';
        } else {
            filtered.forEach(function (item) {
                options += `<option value="${item.request_type_id}">${escapeHtml(item.rt_name)}</option>`;
            });
        }

        $('#fk_request_type_id').html(options).prop('disabled', false);
    }

    function populateCategories(requestTypeId) {
        let options = '<option value="">Select category</option>';

        if (!requestTypeId) {
            $('#fk_category_id')
                .html('<option value="">Select request type first</option>')
                .prop('disabled', true);
            return;
        }

        const filtered = categories.filter(function (item) {
            return String(item.fk_request_type_id) === String(requestTypeId);
        });

        if (!filtered.length) {
            options = '<option value="">No categories available</option>';
        } else {
            filtered.forEach(function (item) {
                options += `<option value="${item.category_id}">${escapeHtml(item.category_name)}</option>`;
            });
        }

        $('#fk_category_id').html(options).prop('disabled', false);
    }

    $('#fk_provider_id').on('change', function () {
        populateRequestTypes($(this).val());

        $('#fk_category_id')
            .html('<option value="">Select request type first</option>')
            .prop('disabled', true);
    });

    $('#fk_request_type_id').on('change', function () {
        populateCategories($(this).val());
    });

    /*
    |--------------------------------------------------------------------------
    | LOAD FORM DATA
    |--------------------------------------------------------------------------
    */

    function loadFormData() {
        $.ajax({
            url: "{{ route('provider.createData') }}",
            type: 'GET',
            success: function (response) {
                campuses = response.campuses || [];
                departments = response.departments || [];
                providers = response.providers || [];
                requestTypes = response.request_types || [];
                categories = response.categories || [];
                users = response.users || [];

                userCampusId = response.user_campus_id || null;
                userDepartmentId = response.user_department_id || null;

                populateLockedCampus();
                populateDepartments(userCampusId, userDepartmentId);
                populateProviders();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Toast.fire({
                    icon: 'error',
                    title: xhr.responseJSON?.message || 'Unable to load form data.'
                });
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | DATATABLE
    |--------------------------------------------------------------------------
    */

    const table = $('#ticketTable').DataTable({
        processing: true,
        serverSide: false,
        paging: true,
        pageLength: 10,
        order: [],
        ajax: {
            url: "{{ route('provider.ticket') }}",
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            {
                data: null,
                name: 'ticket_number',
                render: function (data, type, row) {
                    const ticketNo = row.ticket_number || row.ticket_no || ('#' + row.ticket_id);
                    return `
                        <div class="ticket-number">
                            <div class="ticket-avatar">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>
                            <span>${escapeHtml(ticketNo)}</span>
                        </div>
                    `;
                }
            },
            { data: 'classification', defaultContent: '-' },
            { data: 'department.campus.campus_name', defaultContent: '-' },
            { data: 'department.department_name', defaultContent: '-' },
            { data: 'category.request_type.provider.provider_name', defaultContent: '-' },
            { data: 'remarks', defaultContent: '-' },
            { data: 'requested_by', defaultContent: '-' },
            { data: 'category.category_name', defaultContent: '-' },
            {
                data: 'assignee.name',
                defaultContent: 'Not assigned',
                render: function (data) {
                    return data || 'Not assigned';
                }
            },
            {
                data: 'pending_remarks',
                defaultContent: '-',
                visible: false
            },
            {
                data: 'action_taken',
                defaultContent: '-',
                visible: false
            },
            { data: 'status', defaultContent: '-' },
            {
                data: 'ticket_id',
                orderable: false,
                searchable: false,
                className: 'text-end',
                render: function (data, type, row) {
                    if (isAcknowledgeTab) {
                        const pdfUrl = printPdfRouteTemplate.replace(':id', data);
                        return `
                            <div class="action-buttons">
                                <a href="${pdfUrl}" target="_blank" class="action-btn print" title="Print Service Order Slip (PDF)">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                        `;
                    }

                    if (row.status === 'For Approval') {
                        return `
                            <button type="button"
                                    class="btn btn-sm btn-primary btn-assign-worker"
                                    data-id="${data}">
                                <i class="bi bi-person-check me-1"></i>
                                Approve & Assign
                            </button>
                        `;
                    }

                    return '<span class="text-muted">No action required</span>';
                }
            }
        ]
    });

    /*
    |--------------------------------------------------------------------------
    | TAB SWITCHING & SEARCH
    |--------------------------------------------------------------------------
    */

    $('.ticket-tab-btn').on('click', function () {
        if ($(this).hasClass('active')) return;

        $('.ticket-tab-btn').removeClass('active');
        $(this).addClass('active');

        const url = $(this).data('url');
        const title = $(this).data('title');
        const showPendingCol = $(this).data('show-pending') === true;
        const showCompletedCol = $(this).data('show-completed') === true;
        isAcknowledgeTab = $(this).data('is-acknowledge') === true;

        $('#directoryTitle').text(title);
        table.column(9).visible(showPendingCol);
        table.column(10).visible(showCompletedCol);
        table.ajax.url(url).load();
    });

    $('#ticketSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    /*
    |--------------------------------------------------------------------------
    | ADD TICKET
    |--------------------------------------------------------------------------
    */

    $('#addForm').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        clearValidationErrors();

        $('#btnSaveTicket')
            .prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm me-1"></span>Saving...');

        $.ajax({
            url: "{{ route('ticket-provider.store') }}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Request Added!' });

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('addTicketModal')
                    ).hide();

                    $('#addForm')[0].reset();
                    resetAddDropdowns();
                    table.ajax.reload(null, false);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message || 'Unable to save ticket.'
                    });
                }
            },
            error: function (xhr) {
                handleValidationErrors(xhr);
            },
            complete: function () {
                $('#btnSaveTicket')
                    .prop('disabled', false)
                    .html('<i class="bi bi-save me-1"></i> Save Ticket');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | CAMPUS HELPERS FOR WORKER ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    function getTicketCampus(ticket) {
        return ticket.department?.fk_campus_id ??
               ticket.department?.campus?.campus_id ??
               null;
    }

    function getWorkerCampus(worker) {
        return worker.department?.fk_campus_id ??
               worker.department?.campus?.campus_id ??
               null;
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE AND ASSIGN WORKER
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.btn-assign-worker', function () {
        const ticketId = $(this).data('id');
        const ticket = table.row($(this).closest('tr')).data();

        if (!ticket) {
            Toast.fire({ icon: 'error', title: 'Unable to retrieve ticket information.' });
            return;
        }

        const providerId = ticket.category?.request_type?.fk_provider_id;
        const campusId = getTicketCampus(ticket);

        if (!providerId || !campusId) {
            console.error('Ticket information:', ticket);
            Toast.fire({
                icon: 'error',
                title: 'Ticket provider or campus information is missing.'
            });
            return;
        }

        $('#assign_ticket_id').val(ticketId);
        $('#assign_to')
            .removeClass('is-invalid')
            .html('<option value="">Select worker</option>');

        $('#assign_to_error').text('').hide();

        const filteredWorkers = users.filter(function (worker) {
            return (
                worker.type === 'worker' &&
                worker.is_active == 1 &&
                String(worker.fk_provider_id) === String(providerId) &&
                String(getWorkerCampus(worker)) === String(campusId)
            );
        });

        let options = '<option value="">Select worker</option>';

        if (!filteredWorkers.length) {
            options = '<option value="">No active workers available for this provider and campus</option>';
        } else {
            filteredWorkers.forEach(function (worker) {
                options += `<option value="${worker.id}">${escapeHtml(worker.name)}</option>`;
            });
        }

        $('#assign_to').html(options);
        $('#btnApproveAssign').prop('disabled', filteredWorkers.length === 0);

        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('assignWorkerModal')
        ).show();
    });

    /*
    |--------------------------------------------------------------------------
    | SUBMIT APPROVE AND ASSIGN
    |--------------------------------------------------------------------------
    */

    $('#assignWorkerForm').on('submit', function (e) {
        e.preventDefault();

        const ticketId = $('#assign_ticket_id').val();
        const workerId = $('#assign_to').val();

        if (!workerId) {
            $('#assign_to').addClass('is-invalid');
            $('#assign_to_error').text('Please select a worker.').show();
            return;
        }

        const url = "{{ route('provider.tickets.approve', ':id') }}"
            .replace(':id', ticketId);

        $('#btnApproveAssign')
            .prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm me-1"></span>Processing...');

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: $('input[name="_token"]', '#assignWorkerForm').val(),
                assign_to: workerId
            },
            success: function (response) {
                if (response.success) {
                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('assignWorkerModal')
                    ).hide();

                    Toast.fire({
                        icon: 'success',
                        title: response.message || 'Ticket approved and assigned!'
                    });

                    table.ajax.reload(null, false);
                    $('#assignWorkerForm')[0].reset();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message || 'Unable to assign worker.'
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors?.assign_to) {
                    $('#assign_to').addClass('is-invalid');
                    $('#assign_to_error')
                        .text(xhr.responseJSON.errors.assign_to[0])
                        .show();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message ||
                               'Unable to approve and assign ticket.'
                    });
                    console.error(xhr.responseText);
                }
            },
            complete: function () {
                $('#btnApproveAssign')
                    .prop('disabled', false)
                    .html('<i class="bi bi-check-circle me-1"></i> Approve & Assign');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | VALIDATION HELPERS & MODAL RESETS
    |--------------------------------------------------------------------------
    */

    function clearValidationErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();
    }

    function handleValidationErrors(xhr) {
        if (xhr.status !== 422) {
            console.error(xhr.responseText);
            Toast.fire({
                icon: 'error',
                title: xhr.responseJSON?.message || 'Something went wrong.'
            });
            return;
        }

        const errors = xhr.responseJSON.errors || {};

        $.each(errors, function (field, messages) {
            $('#' + field).addClass('is-invalid');
            $('#' + field + '_error').text(messages[0]).show();
        });
    }

    function resetAddDropdowns() {
        populateLockedCampus();
        populateDepartments(userCampusId, userDepartmentId);

        $('#fk_provider_id').val('');

        $('#fk_request_type_id')
            .html('<option value="">Select service provider first</option>')
            .prop('disabled', true);

        $('#fk_category_id')
            .html('<option value="">Select request type first</option>')
            .prop('disabled', true);
    }

    $('#addTicketModal').on('hidden.bs.modal', function () {
        $('#addForm')[0].reset();
        resetAddDropdowns();
        clearValidationErrors();
    });

    $('#assignWorkerModal').on('hidden.bs.modal', function () {
        $('#assignWorkerForm')[0].reset();

        $('#assign_to')
            .removeClass('is-invalid')
            .html('<option value="">Select worker</option>');

        $('#assign_to_error').text('').hide();

        $('#btnApproveAssign')
            .prop('disabled', false)
            .html('<i class="bi bi-check-circle me-1"></i> Approve & Assign');
    });

    loadFormData();
});
</script>
@endpush

</x-provider>