<x-admin-layout>

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
            box-shadow:
                0 1px 2px rgba(16, 24, 40, .02),
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

        .ticket-badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-walkin {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .badge-appointment {
            background: #f1f5f9;
            color: #64748b;
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
        }

        .action-btn.edit:hover {
            color: #2563eb;
            border-color: #bfdbfe;
            background: #eff6ff;
        }

        .action-btn.delete:hover {
            color: #dc2626;
            border-color: #fecaca;
            background: #fef2f2;
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

        <!-- PAGE HEADER -->
        <div class="ticket-header">
            <div class="ticket-header-left">
                <div class="ticket-header-icon">
                    <i class="bi bi-ticket-perforated"></i>
                </div>

                <div>
                    <h4 class="ticket-title">Ticket Management</h4>
                    <p class="ticket-subtitle">
                        Manage and monitor university service tickets
                    </p>
                </div>
            </div>

            <button
                type="button"
                class="btn-add-ticket"
                data-bs-toggle="modal"
                data-bs-target="#addTicketModal">

                <i class="bi bi-plus-lg"></i>
                Add Ticket
            </button>
        </div>


        <!-- MAIN CARD -->
        <div class="ticket-card">

            <!-- TOOLBAR -->
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


            <!-- TABLE -->
            <div class="table-responsive">
                <table id="ticketTable" class="ticket-table">
                    <thead>
                        <tr>
                            <th>Ticket Number</th>
                            <th>Campus</th>
                            <th>Department</th>
                            <th>Service Provider</th>
                            <th>Request Type</th>
                            <th>Category</th>
                            <th>Assigned To</th>
                            <th>Ticket Type</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>
            </div>

        </div>
    </div>


    <!-- =====================================
         ADD TICKET MODAL
    ====================================== -->

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
                        aria-label="Close"></button>
                </div>


                <form
                    id="addForm"
                    action="javascript:void(0);"
                    method="POST">

                    @csrf

                    <div class="modal-body">
                        <div class="row">

                            <!-- TICKET NUMBER -->
                            <div class="col-md-6 mb-3">
                                <label for="ticket_number" class="form-label">
                                    Ticket Number
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="ticket_number"
                                    name="ticket_number"
                                    placeholder="Enter ticket number"
                                    required>

                                <div
                                    id="ticket_number_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- CAMPUS -->
                            <div class="col-md-6 mb-3">
                                <label for="fk_campus_id" class="form-label">
                                    Campus
                                </label>

                                <select
                                    class="form-select"
                                    id="fk_campus_id"
                                    name="fk_campus_id"
                                    required>

                                    <option value="">Select campus</option>
                                </select>

                                <div
                                    id="fk_campus_id_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- DEPARTMENT -->
                            <div class="col-md-6 mb-3">
                                <label for="fk_department_id" class="form-label">
                                    Department
                                </label>

                                <select
                                    class="form-select"
                                    id="fk_department_id"
                                    name="fk_department_id"
                                    required
                                    disabled>

                                    <option value="">
                                        Select campus first
                                    </option>
                                </select>

                                <div
                                    id="fk_department_id_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- SERVICE PROVIDER -->
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
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- REQUEST TYPE -->
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
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- CATEGORY -->
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
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- ASSIGN TO -->
                            <div class="col-md-6 mb-3">
                                <label for="assign_to" class="form-label">
                                    Assign To <span class="text-danger">*</span>
                                </label>

                                <select
                                    class="form-select"
                                    id="assign_to"
                                    name="assign_to"
                                    required>

                                    <option value="">
                                        Select personnel
                                    </option>
                                </select>

                                <div
                                    id="assign_to_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- TICKET TYPE -->
                            <div class="col-md-6 mb-3">
                                <label for="is_walk_in" class="form-label">
                                    Ticket Type
                                </label>

                                <select
                                    class="form-select"
                                    id="is_walk_in"
                                    name="is_walk_in">

                                    <option value="">Select type</option>
                                    <option value="1">Walk-in</option>
                                    <option value="0">Appointment</option>
                                </select>

                                <div
                                    id="is_walk_in_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- REMARKS -->
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
                                    class="invalid-feedback"></div>
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


    <!-- =====================================
         EDIT TICKET MODAL
    ====================================== -->

    <div
        class="modal fade"
        id="editTicketModal"
        tabindex="-1"
        aria-labelledby="editTicketModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="editTicketModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Ticket
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>


                <form
                    id="updateForm"
                    action="javascript:void(0);"
                    method="POST">

                    @csrf

                    <input
                        type="hidden"
                        id="edit_ticket_id"
                        name="ticket_id">

                    <div class="modal-body">
                        <div class="row">

                            <!-- TICKET NUMBER -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_ticket_number" class="form-label">
                                    Ticket Number
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="edit_ticket_number"
                                    name="ticket_number"
                                    required>

                                <div
                                    id="edit_ticket_number_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- CAMPUS -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_fk_campus_id" class="form-label">
                                    Campus
                                </label>

                                <select
                                    class="form-select"
                                    id="edit_fk_campus_id"
                                    name="fk_campus_id"
                                    required>

                                    <option value="">Select campus</option>
                                </select>

                                <div
                                    id="edit_fk_campus_id_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- DEPARTMENT -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_fk_department_id" class="form-label">
                                    Department
                                </label>

                                <select
                                    class="form-select"
                                    id="edit_fk_department_id"
                                    name="fk_department_id"
                                    required
                                    disabled>

                                    <option value="">
                                        Select campus first
                                    </option>
                                </select>

                                <div
                                    id="edit_fk_department_id_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- SERVICE PROVIDER -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_fk_provider_id" class="form-label">
                                    Service Provider
                                </label>

                                <select
                                    class="form-select"
                                    id="edit_fk_provider_id"
                                    name="fk_provider_id"
                                    required>

                                    <option value="">
                                        Select service provider
                                    </option>
                                </select>

                                <div
                                    id="edit_fk_provider_id_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- REQUEST TYPE -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_fk_request_type_id" class="form-label">
                                    Request Type
                                </label>

                                <select
                                    class="form-select"
                                    id="edit_fk_request_type_id"
                                    name="fk_request_type_id"
                                    required
                                    disabled>

                                    <option value="">
                                        Select service provider first
                                    </option>
                                </select>

                                <div
                                    id="edit_fk_request_type_id_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- CATEGORY -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_fk_category_id" class="form-label">
                                    Category
                                </label>

                                <select
                                    class="form-select"
                                    id="edit_fk_category_id"
                                    name="fk_category_id"
                                    required
                                    disabled>

                                    <option value="">
                                        Select request type first
                                    </option>
                                </select>

                                <div
                                    id="edit_fk_category_id_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- ASSIGN TO -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_assign_to" class="form-label">
                                    Assign To <span class="text-danger">*</span>
                                </label>

                                <select
                                    class="form-select"
                                    id="edit_assign_to"
                                    name="assign_to"
                                    required>

                                    <option value="">
                                        Select personnel
                                    </option>
                                </select>

                                <div
                                    id="edit_assign_to_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- TICKET TYPE -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_is_walk_in" class="form-label">
                                    Ticket Type
                                </label>

                                <select
                                    class="form-select"
                                    id="edit_is_walk_in"
                                    name="is_walk_in">

                                    <option value="">Select type</option>
                                    <option value="1">Walk-in</option>
                                    <option value="0">Appointment</option>
                                </select>

                                <div
                                    id="edit_is_walk_in_error"
                                    class="invalid-feedback"></div>
                            </div>


                            <!-- REMARKS -->
                            <div class="col-12 mb-3">
                                <label for="edit_remarks" class="form-label">
                                    Remarks
                                </label>

                                <textarea
                                    class="form-control"
                                    id="edit_remarks"
                                    name="remarks"
                                    rows="3"
                                    required></textarea>

                                <div
                                    id="edit_remarks_error"
                                    class="invalid-feedback"></div>
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
                            id="btnUpdateTicket">

                            <i class="bi bi-check-lg me-1"></i>
                            Update Ticket
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


            /*
            |--------------------------------------------------------------------------
            | LOAD FORM DATA
            |--------------------------------------------------------------------------
            */

            function loadFormData() {
                $.ajax({
                    url: "{{ route('ticket.createData') }}",
                    method: "GET",

                    success: function (data) {
                        campuses = data.campuses || [];
                        departments = data.departments || [];
                        providers = data.providers || [];
                        requestTypes = data.request_types || [];
                        categories = data.categories || [];
                        users = data.users || [];

                        populateCampuses();
                        populateProviders();
                        populateAssignTo();
                    },

                    error: function (xhr) {
                        console.error(
                            'Failed to load ticket form data:',
                            xhr.responseText
                        );
                    }
                });
            }


            /*
            |--------------------------------------------------------------------------
            | POPULATE CAMPUSES
            |--------------------------------------------------------------------------
            */

            function populateCampuses() {
                let options = `
                    <option value="">Select campus</option>
                `;

                campuses.forEach(function (campus) {
                    options += `
                        <option value="${campus.campus_id}">
                            ${campus.campus_name}
                        </option>
                    `;
                });

                $('#fk_campus_id, #edit_fk_campus_id').html(options);
            }


            /*
            |--------------------------------------------------------------------------
            | POPULATE DEPARTMENTS BY CAMPUS
            |--------------------------------------------------------------------------
            */

            function populateDepartments(campusId, targetId, selectedId = '') {
                let options = `
                    <option value="">Select department</option>
                `;

                if (!campusId) {
                    $('#' + targetId)
                        .html('<option value="">Select campus first</option>')
                        .prop('disabled', true);

                    return;
                }

                let filteredDepartments = departments.filter(function (department) {
                    return String(department.fk_campus_id) === String(campusId);
                });

                if (filteredDepartments.length === 0) {
                    options = `
                        <option value="">No departments available</option>
                    `;
                } else {
                    filteredDepartments.forEach(function (department) {
                        options += `
                            <option
                                value="${department.department_id}"
                                ${String(department.department_id) === String(selectedId) ? 'selected' : ''}>
                                ${department.department_name}
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
                            ${provider.provider_name}
                        </option>
                    `;
                });

                $('#fk_provider_id, #edit_fk_provider_id').html(options);
            }


            /*
            |--------------------------------------------------------------------------
            | POPULATE REQUEST TYPES BY PROVIDER
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

                let filteredRequestTypes = requestTypes.filter(function (requestType) {
                    return String(requestType.fk_provider_id) === String(providerId);
                });

                if (filteredRequestTypes.length === 0) {
                    options = `
                        <option value="">No request types available</option>
                    `;
                } else {
                    filteredRequestTypes.forEach(function (requestType) {
                        options += `
                            <option
                                value="${requestType.request_type_id}"
                                ${String(requestType.request_type_id) === String(selectedId) ? 'selected' : ''}>
                                ${requestType.rt_name}
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
            | POPULATE CATEGORIES BY REQUEST TYPE
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

                let filteredCategories = categories.filter(function (category) {
                    return String(category.fk_request_type_id) === String(requestTypeId);
                });

                if (filteredCategories.length === 0) {
                    options = `
                        <option value="">No categories available</option>
                    `;
                } else {
                    filteredCategories.forEach(function (category) {
                        options += `
                            <option
                                value="${category.category_id}"
                                ${String(category.category_id) === String(selectedId) ? 'selected' : ''}>
                                ${category.category_name}
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
            | POPULATE ASSIGN TO
            |--------------------------------------------------------------------------
            */

            function populateAssignTo(selectedId = '') {
                let options = `
                    <option value="">Select personnel</option>
                `;

                users.forEach(function (user) {
                    options += `
                        <option
                            value="${user.id}"
                            ${String(user.id) === String(selectedId) ? 'selected' : ''}>
                            ${user.name}
                        </option>
                    `;
                });

                $('#assign_to, #edit_assign_to').html(options);
            }


            /*
            |--------------------------------------------------------------------------
            | ADD CASCADING DROPDOWNS
            |--------------------------------------------------------------------------
            */

            $('#fk_campus_id').on('change', function () {
                populateDepartments(
                    $(this).val(),
                    'fk_department_id'
                );
            });

            $('#fk_provider_id').on('change', function () {
                populateRequestTypes(
                    $(this).val(),
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
            | EDIT CASCADING DROPDOWNS
            |--------------------------------------------------------------------------
            */

            $('#edit_fk_campus_id').on('change', function () {
                populateDepartments(
                    $(this).val(),
                    'edit_fk_department_id'
                );
            });

            $('#edit_fk_provider_id').on('change', function () {
                populateRequestTypes(
                    $(this).val(),
                    'edit_fk_request_type_id'
                );

                $('#edit_fk_category_id')
                    .html('<option value="">Select request type first</option>')
                    .prop('disabled', true);
            });

            $('#edit_fk_request_type_id').on('change', function () {
                populateCategories(
                    $(this).val(),
                    'edit_fk_category_id'
                );
            });


            /*
            |--------------------------------------------------------------------------
            | DATATABLE
            |--------------------------------------------------------------------------
            */

            var table = $('#ticketTable').DataTable({
                processing: true,
                serverSide: false,
                paging: true,
                pageLength: 10,

                ajax: {
                    url: "{{ route('admin.ticket') }}",
                    type: "GET",
                    dataSrc: 'data'
                },

                columns: [
                    {
                        data: "ticket_number",

                        render: function (data) {
                            return `
                                <div class="ticket-number">
                                    <div class="ticket-avatar">
                                        <i class="bi bi-ticket-perforated"></i>
                                    </div>

                                    <span>${data ?? ''}</span>
                                </div>
                            `;
                        }
                    },

                    {
                        data: "department.campus.campus_name",
                        defaultContent: "-"
                    },

                    {
                        data: "department.department_name",
                        defaultContent: "-"
                    },

                    {
                        data: "category.request_type.provider.provider_name",
                        defaultContent: "-"
                    },

                    {
                        data: "category.request_type.rt_name",
                        defaultContent: "-"
                    },

                    {
                        data: "category.category_name",
                        defaultContent: "-"
                    },

                    {
                        data: "assignee.name",
                        defaultContent: "Not assigned",

                        render: function (data) {
                            return data || 'Not assigned';
                        }
                    },

                    {
                        data: "is_walk_in",

                        render: function (data) {
                            if (data === null || data === '') {
                                return '-';
                            }

                            let isWalkIn = String(data) === '1';

                            return `
                                <span class="ticket-badge ${
                                    isWalkIn
                                        ? 'badge-walkin'
                                        : 'badge-appointment'
                                }">
                                    ${isWalkIn ? 'Walk-in' : 'Appointment'}
                                </span>
                            `;
                        }
                    },

                    {
                        data: "ticket_id",
                        orderable: false,
                        searchable: false,
                        className: "text-end",

                        render: function (data) {
                            return `
                                <div class="action-buttons">

                                    <button
                                        type="button"
                                        name="edit"
                                        class="action-btn edit"
                                        data-id="${data}"
                                        title="Edit Ticket">

                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button
                                        type="button"
                                        name="delete"
                                        class="action-btn delete"
                                        data-id="${data}"
                                        title="Delete Ticket">

                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>
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

            $(document).on("submit", "#addForm", function (e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                clearValidationErrors();

                $.ajax({
                    url: "{{ route('ticket.store') }}",
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,

                    success: function (data) {
                        if (data == true) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Ticket Added!'
                            });

                            bootstrap.Modal.getOrCreateInstance(
                                document.getElementById('addTicketModal')
                            ).hide();

                            $("#addForm").trigger("reset");
                            resetAddDropdowns();

                            table.ajax.reload(null, false);
                        }
                    },

                    error: function (xhr) {
                        handleValidationErrors(xhr, false);
                    }
                });
            });


            /*
            |--------------------------------------------------------------------------
            | EDIT TICKET
            |--------------------------------------------------------------------------
            */

            $(document).on("click", "button[name='edit']", function () {
                let id = $(this).data('id');

                let route = "{{ route('ticket.edit', ':id') }}";
                route = route.replace(':id', id);

                clearValidationErrors();

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('editTicketModal')
                ).show();

                $.ajax({
                    url: route,
                    method: "GET",

                    success: function (response) {
                        let data = response.data;

                        let campusId = data.department
                            ? data.department.fk_campus_id
                            : '';

                        let providerId = data.category &&
                            data.category.request_type
                            ? data.category.request_type.fk_provider_id
                            : '';

                        let requestTypeId = data.category
                            ? data.category.fk_request_type_id
                            : '';

                        $("#edit_ticket_id").val(data.ticket_id);
                        $("#edit_ticket_number").val(data.ticket_number);
                        $("#edit_remarks").val(data.remarks);
                        $("#edit_is_walk_in").val(data.is_walk_in);

                        /*
                        | Campus and Department
                        */
                        $("#edit_fk_campus_id").val(campusId);

                        populateDepartments(
                            campusId,
                            'edit_fk_department_id',
                            data.fk_department_id
                        );

                        /*
                        | Provider and Request Type
                        */
                        populateProviders(providerId);

                        populateRequestTypes(
                            providerId,
                            'edit_fk_request_type_id',
                            requestTypeId
                        );

                        /*
                        | Category
                        */
                        populateCategories(
                            requestTypeId,
                            'edit_fk_category_id',
                            data.fk_category_id
                        );

                        /*
                        | Assign To
                        */
                        populateAssignTo(data.assign_to);
                    },

                    error: function (xhr) {
                        console.error(
                            'Failed to load ticket:',
                            xhr.responseText
                        );
                    }
                });
            });


            /*
            |--------------------------------------------------------------------------
            | UPDATE TICKET
            |--------------------------------------------------------------------------
            */

            $(document).on("submit", "#updateForm", function (e) {
                e.preventDefault();

                let id = $("#edit_ticket_id").val();

                let route = "{{ route('ticket.update', ':id') }}";
                route = route.replace(':id', id);

                let formData = new FormData(this);
                formData.append("_method", "PUT");

                clearValidationErrors();

                $.ajax({
                    url: route,
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,

                    success: function (data) {
                        if (data == true) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Ticket Updated!'
                            });

                            bootstrap.Modal.getOrCreateInstance(
                                document.getElementById('editTicketModal')
                            ).hide();

                            table.ajax.reload(null, false);
                        }
                    },

                    error: function (xhr) {
                        handleValidationErrors(xhr, true);
                    }
                });
            });


            /*
            |--------------------------------------------------------------------------
            | DELETE TICKET
            |--------------------------------------------------------------------------
            */

            $(document).on("click", "button[name='delete']", function () {
                let id = $(this).data('id');

                let route = "{{ route('ticket.destroy', ':id') }}";
                route = route.replace(':id', id);

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This ticket will be deleted.',
                    icon: 'warning',
                    showDenyButton: true,
                    confirmButtonText: 'Delete',
                    denyButtonText: "Don't Delete"
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            url: route,
                            method: "POST",

                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                _method: "DELETE"
                            },

                            success: function (data) {
                                if (data == 1) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Ticket Deleted!'
                                    });

                                    table.ajax.reload(null, false);
                                }
                            },

                            error: function (xhr) {
                                console.error(
                                    'Failed to delete ticket:',
                                    xhr.responseText
                                );
                            }
                        });
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
                $('.invalid-feedback').text('').hide();
            }

            function handleValidationErrors(xhr, isEdit) {
                if (xhr.status !== 422) {
                    console.error(xhr.responseText);
                    return;
                }

                let errors = xhr.responseJSON.errors || {};
                let prefix = isEdit ? 'edit_' : '';

                $.each(errors, function (field, messages) {
                    let inputId = '#' + prefix + field;
                    let errorId = '#' + prefix + field + '_error';

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
                $('#fk_campus_id').val('');

                $('#fk_department_id')
                    .html('<option value="">Select campus first</option>')
                    .prop('disabled', true);

                $('#fk_provider_id').val('');

                $('#fk_request_type_id')
                    .html('<option value="">Select service provider first</option>')
                    .prop('disabled', true);

                $('#fk_category_id')
                    .html('<option value="">Select request type first</option>')
                    .prop('disabled', true);

                populateAssignTo();
            }


            /*
            |--------------------------------------------------------------------------
            | RESET EDIT DROPDOWNS
            |--------------------------------------------------------------------------
            */

            function resetEditDropdowns() {
                $('#edit_fk_campus_id').val('');

                $('#edit_fk_department_id')
                    .html('<option value="">Select campus first</option>')
                    .prop('disabled', true);

                $('#edit_fk_provider_id').val('');

                $('#edit_fk_request_type_id')
                    .html('<option value="">Select service provider first</option>')
                    .prop('disabled', true);

                $('#edit_fk_category_id')
                    .html('<option value="">Select request type first</option>')
                    .prop('disabled', true);

                populateAssignTo();
            }


            /*
            |--------------------------------------------------------------------------
            | MODAL RESET
            |--------------------------------------------------------------------------
            */

            $('#addTicketModal').on('hidden.bs.modal', function () {
                $("#addForm").trigger("reset");
                resetAddDropdowns();
                clearValidationErrors();
            });

            $('#editTicketModal').on('hidden.bs.modal', function () {
                $("#updateForm").trigger("reset");
                resetEditDropdowns();
                clearValidationErrors();
            });


            loadFormData();

        });
    </script>
    @endpush

</x-admin-layout>