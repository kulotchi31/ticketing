<x-provider>

@push('styles')
<style>
    .ticket-page {
        padding: 8px;
    }

    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
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
        color: white;
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
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 6px 16px rgba(37, 99, 235, .20);
        transition: all .2s ease;
    }

    .btn-add-ticket:hover {
        background: #1d4ed8;
        color: #fff;
        transform: translateY(-1px);
    }

    .ticket-card {
        background: #ffffff;
        border: 1px solid #e9edf3;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .02),
                    0 8px 24px rgba(16, 24, 40, .04);
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

    .ticket-search {
        position: relative;
    }

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

    .ticket-table tbody tr {
        transition: all .15s ease;
    }

    .ticket-table tbody tr:hover {
        background: #f8fbff;
    }

    .ticket-table tbody tr:last-child td {
        border-bottom: none !important;
    }

    .ticket-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 7px;
    }

    .dataTables_wrapper {
        padding: 0 !important;
    }

    .dataTables_filter,
    .dataTables_length {
        display: none !important;
    }

    .dataTables_info {
        padding: 18px 24px !important;
        font-size: 12px !important;
        color: #94a3b8 !important;
    }

    .dataTables_paginate {
        padding: 12px 20px !important;
    }

    .dataTables_paginate .paginate_button {
        min-width: 34px !important;
        height: 34px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 8px !important;
        margin-left: 4px !important;
        border: none !important;
        border-radius: 8px !important;
        background: transparent !important;
        color: #64748b !important;
        font-size: 13px !important;
    }

    .dataTables_paginate .paginate_button:hover {
        background: #f1f5f9 !important;
        color: #2563eb !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: #eff6ff !important;
        color: #2563eb !important;
        font-weight: 600 !important;
    }

    .dataTables_empty {
        padding: 60px !important;
        text-align: center !important;
        color: #94a3b8 !important;
    }

    @media (max-width: 768px) {
        .ticket-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 16px;
        }

        .btn-add-ticket {
            width: 100%;
            justify-content: center;
        }

        .ticket-toolbar {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .ticket-search,
        .ticket-search input {
            width: 100%;
        }
    }
</style>
@endpush


<div class="ticket-page">

    {{-- PAGE HEADER --}}
    <div class="ticket-header">

        <div class="ticket-header-left">

            <div class="ticket-header-icon">
                <i class="bi bi-ticket-perforated"></i>
            </div>

            <div>
                <h4 class="ticket-title">
                    University Service Request
                </h4>

                <p class="ticket-subtitle">
                    Submit and track your university service requests
                </p>
            </div>

        </div>

        <button
            type="button"
            class="btn-add-ticket"
            data-bs-toggle="modal"
            data-bs-target="#addTicketModal">

            <i class="bi bi-plus-lg"></i>
            Add Request

        </button>

    </div>


    {{-- TICKET DIRECTORY --}}
    <div class="ticket-card">

        <div class="ticket-toolbar">

            <div>
                <div class="ticket-toolbar-title">
                    Ticket Directory
                </div>

                <div class="ticket-toolbar-description">
                    View and manage all registered tickets
                </div>
            </div>

            <div class="ticket-search">
                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="ticketSearch"
                    placeholder="Search tickets...">
            </div>

        </div>

        <div class="table-responsive">

            <table id="ticketTable" class="ticket-table">

                <thead>
                    <tr>
                        <th>Classification</th>
                        <th>Service Provider</th>
                        <th>Remarks</th>
                        <th>Requested By</th>
                        <th>Category</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody></tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================
     ADD TICKET MODAL
========================================= --}}

<div
    class="modal fade"
    id="addTicketModal"
    tabindex="-1"
    aria-labelledby="addTicketModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="addTicketModalLabel">
                    <i class="bi bi-ticket-perforated me-2"></i>
                    Add Ticket
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <form
                id="addForm"
                action="javascript:void(0);"
                method="POST">

                @csrf

                <div class="modal-body">

                    <div class="row">

                        {{-- REQUESTED BY --}}
                        <div class="col-md-6 mb-3">

                            <label for="requested_by" class="form-label">
                                Requested By
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="requested_by"
                                name="requested_by"
                                placeholder="Enter requester name"
                                required>

                            <div
                                id="requested_by_error"
                                class="invalid-feedback">
                            </div>

                        </div>


                        {{-- SERVICE PROVIDER --}}
                        <div class="col-md-6 mb-3">

                            <label for="fk_provider_id" class="form-label">
                                Service Provider
                            </label>

                            <select
                                class="form-select"
                                id="fk_provider_id"
                                name="fk_provider_id"
                                required>

                                <option value="">
                                    Select service provider
                                </option>

                            </select>

                            <div
                                id="fk_provider_id_error"
                                class="invalid-feedback">
                            </div>

                        </div>


                        {{-- REQUEST TYPE --}}
                        <div class="col-md-6 mb-3">

                            <label for="fk_request_type_id" class="form-label">
                                Request Type
                            </label>

                            <select
                                class="form-select"
                                id="fk_request_type_id"
                                name="fk_request_type_id"
                                required
                                disabled>

                                <option value="">
                                    Select service provider first
                                </option>

                            </select>

                            <div
                                id="fk_request_type_id_error"
                                class="invalid-feedback">
                            </div>

                        </div>


                        {{-- CATEGORY --}}
                        <div class="col-md-6 mb-3">

                            <label for="fk_category_id" class="form-label">
                                Category
                            </label>

                            <select
                                class="form-select"
                                id="fk_category_id"
                                name="fk_category_id"
                                required
                                disabled>

                                <option value="">
                                    Select request type first
                                </option>

                            </select>

                            <div
                                id="fk_category_id_error"
                                class="invalid-feedback">
                            </div>

                        </div>


                        {{-- REMARKS --}}
                        <div class="col-12 mb-3">

                            <label for="remarks" class="form-label">
                                Remarks
                            </label>

                            <textarea
                                class="form-control"
                                id="remarks"
                                name="remarks"
                                rows="3"
                                placeholder="Enter ticket remarks"
                                required></textarea>

                            <div
                                id="remarks_error"
                                class="invalid-feedback">
                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="btnSaveTicket">

                        <i class="bi bi-save me-1"></i>
                        Save Ticket

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================
     APPROVE AND ASSIGN WORKER MODAL
========================================= --}}

<div
    class="modal fade"
    id="assignWorkerModal"
    tabindex="-1"
    aria-labelledby="assignWorkerModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="assignWorkerModalLabel">
                    <i class="bi bi-person-check me-2"></i>
                    Approve & Assign Worker
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <form id="assignWorkerForm">

                @csrf

                <input
                    type="hidden"
                    id="assign_ticket_id"
                    name="ticket_id">

                <div class="modal-body">

                    <p class="text-muted small">
                        Select an active worker assigned to the same
                        service provider and campus as this ticket.
                        Only matching workers will appear.
                    </p>

                    <div class="mb-3">

                        <label for="assign_to" class="form-label">
                            Assign Worker
                        </label>

                        <select
                            class="form-select"
                            id="assign_to"
                            name="assign_to"
                            required>

                            <option value="">
                                Select worker
                            </option>

                        </select>

                        <div
                            id="assign_to_error"
                            class="invalid-feedback">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="btnApproveAssign">

                        <i class="bi bi-check-circle me-1"></i>
                        Approve & Assign

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


@push('scripts')

<script>
$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | GLOBAL DATA
    |--------------------------------------------------------------------------
    */

    let providers = [];
    let requestTypes = [];
    let categories = [];
    let users = [];


    /*
    |--------------------------------------------------------------------------
    | LOAD FORM DATA
    |--------------------------------------------------------------------------
    */

    function loadFormData() {

        $.ajax({

            url: "{{ route('provider.createData') }}",
            method: "GET",

            success: function (data) {

                providers = data.providers || [];
                requestTypes = data.request_types || [];
                categories = data.categories || [];
                users = data.users || [];

                populateProviders();

                console.log('Loaded form data:', data);

            },

            error: function (xhr) {

                console.error(xhr.responseText);

                Toast.fire({
                    icon: 'error',
                    title: 'Unable to load form data.'
                });

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | POPULATE PROVIDERS
    |--------------------------------------------------------------------------
    */

    function populateProviders(selectedId = '') {

        let options = `
            <option value="">Select service provider</option>
        `;

        providers.forEach(function (provider) {

            options += `
                <option
                    value="${provider.provider_id}"
                    ${String(provider.provider_id) === String(selectedId) ? 'selected' : ''}>
                    ${$('<div>').text(provider.provider_name).html()}
                </option>
            `;

        });

        $('#fk_provider_id').html(options);

    }


    /*
    |--------------------------------------------------------------------------
    | POPULATE REQUEST TYPES
    |--------------------------------------------------------------------------
    */

    function populateRequestTypes(
        providerId,
        targetId,
        selectedId = ''
    ) {

        let options = `
            <option value="">Select request type</option>
        `;

        if (!providerId) {

            $('#' + targetId)
                .html('<option value="">Select service provider first</option>')
                .prop('disabled', true);

            return;

        }

        const filteredRequestTypes = requestTypes.filter(function (item) {

            return String(item.fk_provider_id) === String(providerId);

        });

        if (filteredRequestTypes.length === 0) {

            options = `
                <option value="">No request types available</option>
            `;

        } else {

            filteredRequestTypes.forEach(function (item) {

                options += `
                    <option
                        value="${item.request_type_id}"
                        ${String(item.request_type_id) === String(selectedId) ? 'selected' : ''}>
                        ${$('<div>').text(item.rt_name).html()}
                    </option>
                `;

            });

        }

        $('#' + targetId)
            .html(options)
            .prop('disabled', false);

    }


    /*
    |--------------------------------------------------------------------------
    | POPULATE CATEGORIES
    |--------------------------------------------------------------------------
    */

    function populateCategories(
        requestTypeId,
        targetId,
        selectedId = ''
    ) {

        let options = `
            <option value="">Select category</option>
        `;

        if (!requestTypeId) {

            $('#' + targetId)
                .html('<option value="">Select request type first</option>')
                .prop('disabled', true);

            return;

        }

        const filteredCategories = categories.filter(function (item) {

            return String(item.fk_request_type_id) === String(requestTypeId);

        });

        if (filteredCategories.length === 0) {

            options = `
                <option value="">No categories available</option>
            `;

        } else {

            filteredCategories.forEach(function (item) {

                options += `
                    <option
                        value="${item.category_id}"
                        ${String(item.category_id) === String(selectedId) ? 'selected' : ''}>
                        ${$('<div>').text(item.category_name).html()}
                    </option>
                `;

            });

        }

        $('#' + targetId)
            .html(options)
            .prop('disabled', false);

    }


    /*
    |--------------------------------------------------------------------------
    | CASCADING DROPDOWNS
    |--------------------------------------------------------------------------
    */

    $('#fk_provider_id').on('change', function () {

        const providerId = $(this).val();

        populateRequestTypes(
            providerId,
            'fk_request_type_id'
        );

        $('#fk_category_id')
            .html('<option value="">Select request type first</option>')
            .prop('disabled', true);

    });


    $('#fk_request_type_id').on('change', function () {

        populateCategories(
            $(this).val(),
            'fk_category_id'
        );

    });


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

        ajax: {

            url: "{{ route('provider.ticket') }}",
            type: "GET",
            dataSrc: 'data'

        },

        columns: [

            {
                data: 'classification',
                defaultContent: '-'
            },

            {
                data: 'category.request_type.provider.provider_name',
                defaultContent: '-'
            },

            {
                data: 'remarks',
                defaultContent: '-'
            },

            {
                data: 'requested_by',
                defaultContent: '-'
            },

            {
                data: 'category.category_name',
                defaultContent: '-'
            },

            {
                data: 'assignee.name',
                defaultContent: 'Not assigned',

                render: function (data) {
                    return data || 'Not assigned';
                }
            },

            {
                data: 'status',
                defaultContent: '-'
            },

            {
                data: 'ticket_id',
                orderable: false,
                searchable: false,
                className: 'text-end',

                render: function (data, type, row) {

                    if (row.status !== 'For Approval') {

                        return `
                            <span class="text-muted">
                                No action required
                            </span>
                        `;

                    }

                    return `
                        <button
                            type="button"
                            class="btn btn-sm btn-primary btn-assign-worker"
                            data-id="${data}">

                            <i class="bi bi-person-check me-1"></i>
                            Approve & Assign

                        </button>
                    `;

                }

            }

        ]

    });


    /*
    |--------------------------------------------------------------------------
    | CUSTOM SEARCH
    |--------------------------------------------------------------------------
    */

    $('#ticketSearch').on('keyup', function () {

        table.search(this.value).draw();

    });


    /*
    |--------------------------------------------------------------------------
    | ADD TICKET
    |--------------------------------------------------------------------------
    */

    $(document).on('submit', '#addForm', function (e) {

        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        clearValidationErrors();

        $('#btnSaveTicket')
            .prop('disabled', true)
            .html(`
                <span class="spinner-border spinner-border-sm me-1"></span>
                Saving...
            `);

        $.ajax({

            url: "{{ route('ticket-provider.store') }}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,

            success: function (data) {

                if (data == true || data.success === true) {

                    Toast.fire({
                        icon: 'success',
                        title: 'Request Added!'
                    });

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('addTicketModal')
                    ).hide();

                    $('#addForm')[0].reset();

                    resetAddDropdowns();

                    table.ajax.reload(null, false);

                } else {

                    Toast.fire({
                        icon: 'error',
                        title: data.message || 'Unable to save ticket.'
                    });

                }

            },

            error: function (xhr) {

                handleValidationErrors(xhr, false);

            },

            complete: function () {

                $('#btnSaveTicket')
                    .prop('disabled', false)
                    .html(`
                        <i class="bi bi-save me-1"></i>
                        Save Ticket
                    `);

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | GET TICKET CAMPUS
    |--------------------------------------------------------------------------
    */

    function getTicketCampus(ticket) {

        return ticket.department?.fk_campus_id ??
               ticket.department?.campus?.campus_id ??
               null;

    }


    /*
    |--------------------------------------------------------------------------
    | GET WORKER CAMPUS
    |--------------------------------------------------------------------------
    */

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

        const ticket = table
            .row($(this).closest('tr'))
            .data();

        if (!ticket) {

            Toast.fire({
                icon: 'error',
                title: 'Unable to retrieve ticket information.'
            });

            return;

        }

        // Ticket service provider
        const providerId =
            ticket.category?.request_type?.fk_provider_id;

        // Ticket campus
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

        $('#assign_to_error')
            .text('')
            .hide();


        /*
        |--------------------------------------------------------------------------
        | FILTER WORKERS
        |--------------------------------------------------------------------------
        |
        | Conditions:
        | 1. User type must be worker.
        | 2. Worker must be active.
        | 3. Worker provider must match ticket provider.
        | 4. Worker campus must match ticket campus.
        |
        */

        const filteredWorkers = users.filter(function (worker) {

            const workerProviderId = worker.fk_provider_id;

            const workerCampusId = getWorkerCampus(worker);

            return (

                worker.type === 'worker' &&

                worker.is_active == 1 &&

                String(workerProviderId) === String(providerId) &&

                String(workerCampusId) === String(campusId)

            );

        });


        /*
        |--------------------------------------------------------------------------
        | POPULATE WORKER DROPDOWN
        |--------------------------------------------------------------------------
        */

        let options = `
            <option value="">Select worker</option>
        `;

        if (filteredWorkers.length === 0) {

            options = `
                <option value="">
                    No active workers available for this provider and campus
                </option>
            `;

        } else {

            filteredWorkers.forEach(function (worker) {

                options += `
                    <option value="${worker.id}">
                        ${$('<div>').text(worker.name).html()}
                    </option>
                `;

            });

        }

        $('#assign_to').html(options);

        $('#btnApproveAssign').prop(
            'disabled',
            filteredWorkers.length === 0
        );

        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('assignWorkerModal')
        ).show();


        // DEBUG INFORMATION
        console.log('Ticket ID:', ticketId);
        console.log('Ticket Provider:', providerId);
        console.log('Ticket Campus:', campusId);
        console.log('Filtered Workers:', filteredWorkers);

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

            $('#assign_to_error')
                .text('Please select a worker.')
                .show();

            return;

        }

        const url = "{{ route('provider.tickets.approve', ':id') }}"
            .replace(':id', ticketId);

        $('#btnApproveAssign')
            .prop('disabled', true)
            .html(`
                <span class="spinner-border spinner-border-sm me-1"></span>
                Processing...
            `);

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

                if (
                    xhr.status === 422 &&
                    xhr.responseJSON?.errors?.assign_to
                ) {

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
                    .html(`
                        <i class="bi bi-check-circle me-1"></i>
                        Approve & Assign
                    `);

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | VALIDATION ERRORS
    |--------------------------------------------------------------------------
    */

    function clearValidationErrors() {

        $('.is-invalid').removeClass('is-invalid');

        $('.invalid-feedback')
            .text('')
            .hide();

    }


    function handleValidationErrors(xhr, isEdit) {

        if (xhr.status !== 422) {

            console.error(xhr.responseText);

            Toast.fire({
                icon: 'error',
                title: xhr.responseJSON?.message || 'Something went wrong.'
            });

            return;

        }

        const errors = xhr.responseJSON.errors || {};

        const prefix = isEdit ? 'edit_' : '';

        $.each(errors, function (field, messages) {

            const inputId = '#' + prefix + field;

            const errorId = '#' + prefix + field + '_error';

            $(inputId).addClass('is-invalid');

            $(errorId)
                .text(messages[0])
                .show();

        });

    }


    /*
    |--------------------------------------------------------------------------
    | RESET ADD DROPDOWNS
    |--------------------------------------------------------------------------
    */

    function resetAddDropdowns() {

        $('#fk_provider_id').val('');

        $('#fk_request_type_id')
            .html('<option value="">Select service provider first</option>')
            .prop('disabled', true);

        $('#fk_category_id')
            .html('<option value="">Select request type first</option>')
            .prop('disabled', true);

    }


    /*
    |--------------------------------------------------------------------------
    | ADD MODAL RESET
    |--------------------------------------------------------------------------
    */

    $('#addTicketModal').on('hidden.bs.modal', function () {

        $('#addForm')[0].reset();

        resetAddDropdowns();

        clearValidationErrors();

    });


    /*
    |--------------------------------------------------------------------------
    | ASSIGN MODAL RESET
    |--------------------------------------------------------------------------
    */

    $('#assignWorkerModal').on('hidden.bs.modal', function () {

        $('#assignWorkerForm')[0].reset();

        $('#assign_to')
            .removeClass('is-invalid')
            .html('<option value="">Select worker</option>');

        $('#assign_to_error')
            .text('')
            .hide();

        $('#btnApproveAssign')
            .prop('disabled', false)
            .html(`
                <i class="bi bi-check-circle me-1"></i>
                Approve & Assign
            `);

    });


    /*
    |--------------------------------------------------------------------------
    | INITIALIZE
    |--------------------------------------------------------------------------
    */

    loadFormData();

});
</script>

@endpush

</x-provider>
