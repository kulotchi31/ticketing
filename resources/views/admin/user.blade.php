
<x-admin-layout>

    @push('styles')

    <style>

        /* =========================================
           PAGE
        ========================================= */

        .user-page {
            padding: 8px;
        }


        /* =========================================
           HEADER
        ========================================= */

        .user-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .user-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .user-header-icon {
            width: 50px;
            height: 50px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background: linear-gradient(
                135deg,
                #2563eb,
                #4f46e5
            );

            color: white;
            font-size: 22px;

            box-shadow: 0 8px 20px rgba(37, 99, 235, .18);
        }

        .user-title {
            margin: 0;

            font-size: 21px;
            font-weight: 700;

            color: #111827;

            letter-spacing: -.3px;
        }

        .user-subtitle {
            margin: 4px 0 0;

            font-size: 13px;

            color: #6b7280;
        }


        /* =========================================
           ADD BUTTON
        ========================================= */

        .btn-add-user {
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

        .btn-add-user:hover {
            background: #1d4ed8;
            color: #fff;

            transform: translateY(-1px);

            box-shadow: 0 10px 20px rgba(37, 99, 235, .25);
        }


        /* =========================================
           MAIN CARD
        ========================================= */

        .user-card {

            background: #ffffff;

            border: 1px solid #e9edf3;

            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 1px 2px rgba(16, 24, 40, .02),
                0 8px 24px rgba(16, 24, 40, .04);
        }


        /* =========================================
           CARD TOOLBAR
        ========================================= */

        .user-toolbar {

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 20px 24px;

            border-bottom: 1px solid #eef1f5;
        }

        .user-toolbar-title {
            font-size: 15px;
            font-weight: 700;

            color: #1f2937;

            margin-bottom: 2px;
        }

        .user-toolbar-description {
            font-size: 12px;
            color: #9ca3af;
        }


        /* =========================================
           SEARCH
        ========================================= */

        .user-search {
            position: relative;
        }

        .user-search i {
            position: absolute;

            top: 50%;
            left: 13px;

            transform: translateY(-50%);

            color: #9ca3af;

            font-size: 14px;
        }

        .user-search input {

            width: 240px;

            height: 38px;

            border: 1px solid #e5e7eb;

            border-radius: 9px;

            padding: 0 14px 0 38px;

            font-size: 13px;

            outline: none;

            transition: all .2s ease;
        }

        .user-search input::placeholder {
            color: #b0b7c3;
        }

        .user-search input:focus {

            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .10);
        }


        /* =========================================
           TABLE
        ========================================= */

        .user-table {
            width: 100% !important;

            border-collapse: collapse !important;

            margin: 0 !important;
        }


        /* TABLE HEADER */

        .user-table thead th {

            background: #f8fafc;

            color: #64748b;

            font-size: 11px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .6px;

            padding: 14px 24px !important;

            border-bottom: 1px solid #e9edf3 !important;

            white-space: nowrap;
        }


        /* TABLE BODY */

        .user-table tbody td {

            padding: 16px 24px !important;

            font-size: 14px;

            color: #334155;

            border-bottom: 1px solid #f0f2f5 !important;

            vertical-align: middle;
        }

        .user-table tbody tr {
            transition: all .15s ease;
        }

        .user-table tbody tr:hover {
            background: #f8fbff;
        }

        .user-table tbody tr:last-child td {
            border-bottom: none !important;
        }


        /* =========================================
           USER
        ========================================= */

        .user-name {
            display: flex;
            align-items: center;

            gap: 12px;

            font-weight: 600;

            color: #1f2937;
        }

        .user-avatar {

            width: 40px;
            height: 40px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #eff6ff;

            color: #2563eb;

            font-size: 17px;
        }

        .user-email {
            font-size: 12px;

            color: #94a3b8;

            margin-top: 2px;
        }


        /* =========================================
           BADGES
        ========================================= */

        .status-badge {

            display: inline-flex;

            align-items: center;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: 600;
        }

        .status-active {

            background: #ecfdf5;

            color: #059669;
        }

        .status-inactive {

            background: #fef2f2;

            color: #dc2626;
        }


        .type-badge {

            display: inline-flex;

            align-items: center;

            padding: 5px 10px;

            background: #f1f5f9;

            border-radius: 7px;

            font-size: 11px;

            font-weight: 600;

            color: #475569;

            text-transform: capitalize;
        }


        /* =========================================
           ACTION BUTTONS
        ========================================= */

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


        /* =========================================
           DATATABLES
        ========================================= */

        .dataTables_wrapper {
            padding: 0 !important;
        }

        .dataTables_filter {
            display: none !important;
        }

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


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 768px) {

            .user-header {

                align-items: flex-start;

                flex-direction: column;

                gap: 16px;
            }

            .btn-add-user {

                width: 100%;

                justify-content: center;
            }

            .user-toolbar {

                flex-direction: column;

                align-items: flex-start;

                gap: 15px;
            }

            .user-search,
            .user-search input {

                width: 100%;
            }

        }

    </style>

    @endpush



    <div class="user-page">


        <!-- =====================================
             PAGE HEADER
        ====================================== -->

        <div class="user-header">

            <div class="user-header-left">

                <div class="user-header-icon">
                    <i class="bi bi-people"></i>
                </div>


                <div>

                    <h4 class="user-title">
                        User Management
                    </h4>

                    <p class="user-subtitle">
                        Manage and organize system users
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="btn-add-user"
                data-bs-toggle="modal"
                data-bs-target="#addUserModal"
            >

                <i class="bi bi-person-plus"></i>

                Add User

            </button>

        </div>



        <!-- =====================================
             USER CARD
        ====================================== -->

        <div class="user-card">


            <!-- TOOLBAR -->

            <div class="user-toolbar">

                <div>

                    <div class="user-toolbar-title">
                        User Directory
                    </div>

                    <div class="user-toolbar-description">
                        View and manage all registered users
                    </div>

                </div>


                <!-- SEARCH -->

                <div class="user-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="userSearch"
                        placeholder="Search users..."
                    >

                </div>

            </div>



            <!-- TABLE -->

            <div class="table-responsive">

                <table
                    id="userTable"
                    class="user-table"
                >

                    <thead>

                        <tr>

                            <th>User</th>

                            <th>Campus</th>

                            <th>Department</th>

                            <th>User Type</th>

                            <th>Status</th>

                            <th class="text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody></tbody>

                </table>

            </div>


        </div>


    </div>



    <!-- =====================================
         ADD USER MODAL
    ====================================== -->

    <div
        class="modal fade"
        id="addUserModal"
        tabindex="-1"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">


                <!-- HEADER -->

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-person-plus me-2"></i>

                        Add User

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>



                <!-- FORM -->

                <form
                    id="addUserForm"
                    action="javascript:void(0);"
                    method="POST"
                >

                    @csrf


                    <!-- BODY -->

                    <div class="modal-body">


                        <!-- FULL NAME -->

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                placeholder="Enter full name"
                            >

                            <div
                                id="name_error"
                                class="invalid-feedback"
                                style="display:none;"
                            ></div>

                        </div>



                        <!-- EMAIL -->

                        <div class="mb-3">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Enter email address"
                            >

                            <div
                                id="email_error"
                                class="invalid-feedback"
                                style="display:none;"
                            ></div>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                User Type
                            </label>

                            <select
                                class="form-select"
                                id="type"
                                name="type"
                            >

                                <option value="">
                                    Select User Type
                                </option>

                                <option value="admin">
                                    Administrator
                                </option>

                                <option value="user">
                                    User
                                </option>

                                 <option value="worker">
                                    Worker
                                </option>

                            </select>

                            <!-- PROVIDER / STAFF: WORKER ONLY -->
                            <div
                                class="mt-3"
                                id="provider_container"
                                style="display:none;"
                            >
                                <label class="form-label">
                                    Provider / Staff
                                </label>

                                <select
                                    class="form-select"
                                    id="fk_provider_id"
                                    name="fk_provider_id"
                                >
                                    <option value="">
                                        Select Provider / Staff
                                    </option>

                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->provider_id }}">
                                            {{ $provider->provider_name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div
                                    id="fk_provider_id_error"
                                    class="invalid-feedback"
                                    style="display:none;"
                                ></div>
                            </div>

                        </div>





                                    <!-- CAMPUS -->

                                    <div style="display:none;"
                                    class="mb-3"
                                    id="campus_container"
                                    >

                                    <label class="form-label">
                                        Campus
                                    </label>

                                    <select
                                    class="form-select"
                                    id="campus_id"
                                    name="campus_id"
                                    >

                                    <option value="">
                                        Select Campus
                                    </option>

                                    @foreach($campuses as $campus)

                                    <option
                                    value="{{ $campus->campus_id }}"
                                    >

                                    {{ $campus->campus_name }}

                                </option>

                                @endforeach

                            </select>

                            <div
                            id="campus_error"
                            class="invalid-feedback"
                            style="display:none;"
                            ></div>

                        </div>


            <!-- DEPARTMENT -->

            <div  style="display:none;"
            class="mb-3"
            id="department_container"
            >

            <label class="form-label">
                Department
            </label>

            <select
            class="form-select"
            id="department_id"
            name="department_id"
            disabled
            >

            <option value="">
                Select Campus First
            </option>

            </select>

            <div
            id="department_error"
            class="invalid-feedback"
            style="display:none;"
            ></div>

            </div>


                        <!-- USER TYPE -->


                        <!-- PASSWORD -->

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Enter password"
                            >

                            <div
                                id="password_error"
                                class="invalid-feedback"
                                style="display:none;"
                            ></div>

                        </div>



                        <!-- STATUS -->

                        <div class="mb-3">

                            <label class="form-label">
                                Account Status
                            </label>

                            <select
                                class="form-select"
                                id="is_active"
                                name="is_active"
                            >

                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>

                            </select>

                        </div>


                    </div>



                    <!-- FOOTER -->

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-save me-1"></i>

                            Save User

                        </button>

                    </div>


                </form>


            </div>

        </div>

    </div>



    <!-- =====================================
         EDIT USER MODAL
    ====================================== -->

    <div
        class="modal fade"
        id="editUserModal"
        tabindex="-1"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">


                <!-- HEADER -->

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit User

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>



                <!-- FORM -->

                <form
                    id="updateUserForm"
                    action="javascript:void(0);"
                    method="POST"
                >

                    @csrf


                    <input
                        type="hidden"
                        id="edit_id"
                    >



                    <!-- BODY -->

                    <div class="modal-body">


                        <!-- FULL NAME -->

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="edit_name"
                            >

                        </div>



                        <!-- EMAIL -->

                        <div class="mb-3">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="edit_email"
                            >

                             <div
                                id="edit_email_error"
                                class="invalid-feedback"
                                style="display:none;"
                            ></div>



                        </div>



                            <!-- CAMPUS -->

                            <div
                            class="mb-3"
                            id="edit_campus_container"
                            >

                            <label class="form-label">
                                Campus
                            </label>

                            <select
                            class="form-select"
                            id="edit_campus_id"
                            >

                            <option value="">
                                Select Campus
                            </option>

                            @foreach($campuses as $campus)

                            <option
                            value="{{ $campus->campus_id }}"
                            >
                            {{ $campus->campus_name }}
                        </option>

                        @endforeach

                    </select>

                </div>


                    <!-- DEPARTMENT -->

                    <div
                    class="mb-3"
                    id="edit_department_container"
                    >

                    <label class="form-label">
                        Department
                    </label>

                    <select
                    class="form-select"
                    id="edit_department_id"
                    disabled
                    >

                    <option value="">
                        Select Campus First
                    </option>

                </select>

            </div>



                        <!-- USER TYPE -->

                        <div class="mb-3">

                            <label class="form-label">
                                User Type
                            </label>

                            <select
                                class="form-select"
                                id="edit_type"
                            >

                                <option value="admin">
                                    Administrator
                                </option>

                                <option value="user">
                                    User
                                </option>

                                 <option value="worker">
                                    Worker
                                </option>

                            </select>

                            <!-- PROVIDER / STAFF: WORKER ONLY -->
                            <div
                                class="mt-3"
                                id="edit_provider_container"
                                style="display:none;"
                            >
                                <label class="form-label">
                                    Provider / Staff
                                </label>

                                <select
                                    class="form-select"
                                    id="edit_fk_provider_id"
                                    name="fk_provider_id"
                                >
                                    <option value="">
                                        Select Provider / Staff
                                    </option>

                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->provider_id }}">
                                            {{ $provider->provider_name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div
                                    id="edit_fk_provider_id_error"
                                    class="invalid-feedback"
                                    style="display:none;"
                                ></div>
                            </div>

                        </div>



                        <!-- STATUS -->

                        <div class="mb-3">

                            <label class="form-label">
                                Account Status
                            </label>

                            <select
                                class="form-select"
                                id="edit_is_active"
                            >

                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>

                            </select>

                        </div>


                    </div>



                    <!-- FOOTER -->

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-check-lg me-1"></i>

                            Update User

                        </button>

                    </div>


                </form>


            </div>

        </div>

    </div>



    @push('scripts')

    <script>

        /*
        |--------------------------------------------------------------------------
        | PROVIDER / STAFF VISIBILITY
        |--------------------------------------------------------------------------
        */

        function toggleAddProvider() {
            const type = $('#type').val();

            if (type === 'worker') {
                $('#provider_container').show();
                $('#fk_provider_id').prop('required', true);
            } else {
                $('#provider_container').hide();

                $('#fk_provider_id')
                    .val('')
                    .prop('required', false)
                    .removeClass('is-invalid');

                $('#fk_provider_id_error')
                    .hide()
                    .html('');
            }
        }

        function toggleEditProvider() {
            const type = $('#edit_type').val();

            if (type === 'worker') {
                $('#edit_provider_container').show();
                $('#edit_fk_provider_id').prop('required', true);
            } else {
                $('#edit_provider_container').hide();

                $('#edit_fk_provider_id')
                    .val('')
                    .prop('required', false)
                    .removeClass('is-invalid');

                $('#edit_fk_provider_id_error')
                    .hide()
                    .html('');
            }
        }

        $(document).ready(function () {


            /* =====================================
               DATATABLE
            ====================================== */

            var table = $('#userTable').DataTable({

                processing: true,

                serverSide: false,

                paging: true,

                pageLength: 10,


                ajax: {

                    url: "{{ route('admin.user') }}",

                    type: "POST",

                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }

                },


                columns: [


                    /* USER */

                    {

                        data: "name",

                        render: function(data, type, row) {

                            return `

                                <div class="user-name">

                                    <div class="user-avatar">

                                        <i class="bi bi-person"></i>

                                    </div>


                                    <div>

                                        <div>
                                            ${data ?? ''}
                                        </div>

                                        <div class="user-email">
                                            ${row.email ?? ''}
                                        </div>

                                    </div>

                                </div>

                            `;

                        }

                    },


                    /* CAMPUS */

                    {

                        data: "department",

                        render: function(data) {

                            if (
                                data &&
                                data.campus
                            ) {

                                return data.campus.campus_name;

                            }

                            return 'N/A';

                        }

                    },


                    /* DEPARTMENT */

                    {

                        data: "department",

                        render: function(data) {

                            if (data) {

                                return data.department_name;

                            }

                            return 'N/A';

                        }

                    },


                    /* TYPE */

                    {

                        data: "type",

                        render: function(data) {

                            return `

                                <span class="type-badge">

                                    ${data ?? 'N/A'}

                                </span>

                            `;

                        }

                    },


                    /* STATUS */

                    {

                        data: "is_active",

                        render: function(data) {

                            if (data == 1) {

                                return `

                                    <span
                                        class="status-badge status-active"
                                    >

                                        Active

                                    </span>

                                `;

                            }


                            return `

                                <span
                                    class="status-badge status-inactive"
                                >

                                    Inactive

                                </span>

                            `;

                        }

                    },


                    /* ACTIONS */

                    {

                        data: "id",

                        orderable: false,

                        searchable: false,

                        className: "text-end",

                        render: function(data) {

                            return `

                                <div class="action-buttons">

                                    <button
                                        type="button"
                                        name="edit"
                                        class="action-btn edit"
                                        data-id="${data}"
                                        title="Edit User"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </button>


                                    <button
                                        type="button"
                                        name="delete"
                                        class="action-btn delete"
                                        data-id="${data}"
                                        title="Delete User"
                                    >

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </div>

                            `;

                        }

                    }

                ]

            });



            /* =====================================
               CUSTOM SEARCH
            ====================================== */

            $('#userSearch').on('keyup', function () {

                table.search(this.value).draw();

            });



            /* =====================================
               LOAD DEPARTMENTS - ADD USER
            ====================================== */

            $('#campus_id').on('change', function () {

                var campusId = $(this).val();
            

                $('#department_id')

                    .prop('disabled', true)

                    .html(`
                        <option value="">
                            Loading departments...
                        </option>
                    `);


                if (!campusId) {

                    $('#department_id')

                        .html(`
                            <option value="">
                                Select Campus First
                            </option>
                        `)

                        .prop('disabled', true);


                    return;

                }


                var route =
                    "{{ route('departments.by-campus', ':id') }}";


                route =
                    route.replace(':id', campusId);


                $.ajax({

                    url: route,

                    type: "GET",


                    success: function(departments) {

                        var options = `

                            <option value="">
                                Select Department
                            </option>

                        `;

                                if (departments.length === 0) {

                                    options = `
                <option value="">
                    No Department Available
                </option>
                                    `;

                                }


                        $.each(
                            departments,
                            function(index, department) {

                                options += `

                                    <option
                                        value="${department.department_id}"
                                    >

                                        ${department.department_name}

                                    </option>

                                `;

                            }
                        );


                        $('#department_id')

                            .html(options)

                            .prop('disabled', false);

                    },


                    error: function() {

                        $('#department_id')

                            .html(`

                                <option value="">
                                    Failed to load departments
                                </option>

                            `)

                            .prop('disabled', true);

                    }

                });

            });



            /* =====================================
               LOAD DEPARTMENTS - EDIT USER
            ====================================== */

            function loadEditDepartments(
                campusId,
                selectedDepartmentId = null
            ) {

                $('#edit_department_id')

                    .prop('disabled', true)

                    .html(`

                        <option value="">
                            Loading departments...
                        </option>

                    `);


                if (!campusId) {

                    $('#edit_department_id')

                        .html(`

                            <option value="">
                                Select Campus First
                            </option>

                        `)

                        .prop('disabled', true);


                    return;

                }


                var route =
                    "{{ route('departments.by-campus', ':id') }}";


                route =
                    route.replace(':id', campusId);


                $.ajax({

                    url: route,

                    type: "GET",


                    success: function(departments) {

                        var options = `

                            <option value="">
                                Select Department
                            </option>

                        `;


                        $.each(
                            departments,
                            function(index, department) {

                                var selected = '';


                                if (
                                    selectedDepartmentId &&
                                    department.id == selectedDepartmentId
                                ) {

                                    selected = 'selected';

                                }


                                options += `

                                    <option
                                        value="${department.department_id}"
                                        ${selected}
                                    >

                                        ${department.department_name}

                                    </option>

                                `;

                            }
                        );


                        $('#edit_department_id')

                            .html(options)

                            .prop('disabled', false);

                    }

                });

            }



            /* =====================================
               CHANGE CAMPUS - EDIT
            ====================================== */

            $('#edit_campus_id').on(
                'change',
                function() {

                    var campusId = $(this).val();


                    loadEditDepartments(campusId);

                }
            );



           $(document).on(
    'submit',
    '#addUserForm',
    function(e) {

        e.preventDefault();


        // Remove previous validation errors
        $('.is-invalid').removeClass('is-invalid');

        $('.invalid-feedback')
            .hide()
            .html('');


        var formData = new FormData();


        formData.append(
            '_token',
            $('meta[name="csrf-token"]').attr('content')
        );


        formData.append(
            'name',
            $('#name').val()
        );


        formData.append(
            'email',
            $('#email').val()
        );


        formData.append(
            'department_id',
            $('#department_id').val()
        );


        formData.append(
            'type',
            $('#type').val()
        );

        formData.append(
            'fk_provider_id',
            $('#type').val() === 'worker'
                ? ($('#fk_provider_id').val() || '')
                : ''
        );


        formData.append(
            'password',
            $('#password').val()
        );


        formData.append(
            'is_active',
            $('#is_active').val()
        );


        $.ajax({

            url: "{{ route('users.store') }}",

            method: 'POST',

            contentType: false,

            processData: false,

            data: formData,


            success: function(data) {


                if (data == true) {


                    Toast.fire({

                        icon: 'success',

                        title: 'User Added!'

                    });


                    $('#addUserModal')
                        .modal('hide');


                    $('#addUserForm')
                        .trigger('reset');

                    $('#provider_container').hide();

                    $('#fk_provider_id')
                        .val('')
                        .prop('required', false)
                        .removeClass('is-invalid');

                    $('#fk_provider_id_error')
                        .hide()
                        .html('');


                    $('#department_id')

                        .html(`

                            <option value="">
                                Select Campus First
                            </option>

                        `)

                        .prop(
                            'disabled',
                            true
                        );


                    table.ajax.reload();

                }

                else {


                    Toast.fire({

                        icon: 'error',

                        title: 'User Not Saved!'

                    });

                    var errors = data.errors;
                    $.each(
                        errors,
                        function(field, messages) {

                            console.log(field)
                            // Add red border to input
                            $('#' + field)
                                .addClass('is-invalid');


                            // Display error message
                            $('#' + field + '_error')

                                .html(messages[0])

                                .show();

                        }
                    );

                }

            },


            error: function(xhr) {


                // Laravel Validation Error (422)
                if (xhr.status === 422) {


                    var errors = xhr.responseJSON.errors;

                    console.log(errors);

                }

                else {


                    Toast.fire({

                        icon: 'error',

                        title: 'Something went wrong!'

                    });

                }

            }

        });

    }
);



            /* =====================================
               EDIT USER
            ====================================== */

            $(document).on(
                'click',
                "button[name='edit']",
                function() {

                    var id =$(this).data('id');
                    var route ="{{ route('users.edit', ':id') }}";
                    route = route.replace(':id', id);


                    $('#updateUserForm')
                    .find('.is-invalid')
                    .removeClass('is-invalid');


        // Hide and clear previous error messages
                    $('#updateUserForm')
                    .find('.invalid-feedback')
                    .hide()
                    .html('');


                    $.ajax({

                        url: route,

                                success: function(response) {


                                    var user =
                                    response.data;


                                    $('#edit_id')
                                    .val(user.id);


                                    $('#edit_name')
                                    .val(user.name);


                                    $('#edit_email')
                                    .val(user.email);


                                    $('#edit_type')
                                    .val(user.type);


                                    
                                    $('#edit_fk_provider_id')
                                    .val(user.fk_provider_id || '');

                                    toggleEditProvider();

                                    $('#edit_is_active')
                                    .val(user.is_active);


            /*
            |--------------------------------------------------------------------------
            | ADMIN
            |--------------------------------------------------------------------------
            */

                                    if (user.type === 'admin') {


                // Hide Campus
                                        $('#edit_campus_container')
                                        .hide();


                // Hide Department
                                        $('#edit_department_container')
                                        .hide();


                // Clear values
                                        $('#edit_campus_id')
                                        .val('');


                                        $('#edit_department_id')

                                        .html(`

                        <option value="">
                            Select Campus First
                        </option>

                                        `)

                                        .val('')

                                        .prop(
                                            'disabled',
                                            true
                                            );

                                    }


            /*
            |--------------------------------------------------------------------------
            | USER
            |--------------------------------------------------------------------------
            */

                                    else {


                // Show Campus
                                        $('#edit_campus_container')
                                        .show();


                // Show Department
                                        $('#edit_department_container')
                                        .show();


                                        if (
                                            user.department &&
                                            user.department.campus_id
                                            ) {


                                            var campusId =
                                        user.department.campus_id;


                                        $('#edit_campus_id')
                                        .val(campusId);


                                        loadEditDepartments(

                                            campusId,

                                            user.department_id

                                            );

                                    }

                                }


                                bootstrap.Modal

                                .getOrCreateInstance(

                                    document.getElementById(
                                        'editUserModal'
                                        )

                                    )

                                .show();

                            }

                    });

                }
            );




            /* =====================================
               DELETE USER
            ====================================== */

            $(document).on(
                'click',
                "button[name='delete']",
                function() {


                    var id =
                        $(this).data('id');


                    var route =
                        "{{ route('user.destroy', ':id') }}";


                    route =
                        route.replace(':id', id);


                    Swal.fire({

                        title: 'Are you sure?',

                        text:
                            'You are about to delete this user.',

                        icon: 'warning',

                        showCancelButton: true,

                        confirmButtonText:
                            'Delete',

                        cancelButtonText:
                            'Cancel'

                    }).then(function(result) {


                        if (result.isConfirmed) {


                            var formData =
                                new FormData();


                            formData.append(

                                '_token',

                                $('meta[name="csrf-token"]')
                                    .attr('content')

                            );


                            formData.append(
                                '_method',
                                'DELETE'
                            );


                            $.ajax({

                                url: route,

                                type: 'POST',

                                contentType: false,

                                processData: false,

                                data: formData,


                                success: function(data) {


                                    if (data == true) {


                                        Toast.fire({

                                            icon: 'success',

                                            title:
                                                'User Deleted!'

                                        });


                                        table.ajax.reload();

                                    }

                                }

                            });

                        }

                    });

                }
            );



            /* =====================================
               RESET ADD MODAL
            ====================================== */

            $('#addUserModal').on(
                'hidden.bs.modal',
                function () {

                    $('#addUserForm').trigger('reset');

        // Reset and disable department
                    $('#department_id')
                    .html(`
                <option value="">
                    Select Campus First
                </option>
                    `)
                    .prop('disabled', true);

        // Hide campus, department, and provider fields
                    $('#campus_container').hide();
                    $('#department_container').hide();
                    $('#provider_container').hide();

        // Clear provider field
                    $('#fk_provider_id')
                    .val('')
                    .prop('required', false)
                    .removeClass('is-invalid');

                    $('#fk_provider_id_error')
                    .hide()
                    .html('');

                }
                );


        });





        $('#type').on(
            'change',
            function() {

                var type = $(this).val();


                toggleAddProvider();


                if (type === 'admin') {


                    // Hide Campus and Department
                    $('#campus_container').hide();

                    $('#department_container').hide();


                    // Clear values
                    $('#campus_id').val('');

                    $('#department_id')

                    .val('')

                    .prop(
                        'disabled',
                        true
                        );


                    // Remove validation errors
                    $('#campus_id')
                    .removeClass('is-invalid');

                    $('#department_id')
                    .removeClass('is-invalid');


                    $('#campus_error')
                    .hide()
                    .html('');

                    $('#department_error')
                    .hide()
                    .html('');


                    // Remove required attribute
                    $('#campus_id')
                    .prop(
                        'required',
                        false
                        );

                    $('#department_id')
                    .prop(
                        'required',
                        false
                        );

                }


                else {


                    // Show Campus and Department
                    $('#campus_container').show();

                    $('#department_container').show();


                    // Make Campus required
                    $('#campus_id')
                    .prop(
                        'required',
                        true
                        );

                }

            }
            );


        /* =====================================
   EDIT USER TYPE CHANGE
====================================== */

$('#edit_type').on(
    'change',
    function() {

        var type = $(this).val();


     toggleEditProvider();


        if (type === 'admin') {


            // Hide Campus
            $('#edit_campus_container').hide();


            // Hide Department
            $('#edit_department_container').hide();


            // Clear Campus
            $('#edit_campus_id').val('');


            // Clear Department
            $('#edit_department_id')

                .val('')

                .prop(
                    'disabled',
                    true
                );


        }

        else {


            // Show Campus
            $('#edit_campus_container').show();


            // Show Department
            $('#edit_department_container').show();


            // Enable campus selection
            $('#edit_campus_id')
                .prop(
                    'disabled',
                    false
                );

        }

    }
);


    
    $(document).on(
    'submit',
    '#updateUserForm',
    function(e) {

        e.preventDefault();


        var id =
            $('#edit_id').val();


        var route =
            "{{ route('users.update', ':id') }}";


        route =
            route.replace(':id', id);


        var formData =
            new FormData();


        formData.append(
            '_token',
            $('meta[name="csrf-token"]')
                .attr('content')
        );


        formData.append(
            '_method',
            'PUT'
        );


        formData.append(
            'name',
            $('#edit_name').val()
        );


        formData.append(
            'email',
            $('#edit_email').val()
        );


        var userType =
            $('#edit_type').val();


        formData.append(
            'type',
            userType
        );


        /*
        |--------------------------------------------------------------------------
        | DEPARTMENT
        |--------------------------------------------------------------------------
        */

        if (userType === 'admin') {

            formData.append(
                'department_id',
                ''
            );

        }

        else {

            formData.append(
                'department_id',
                $('#edit_department_id').val()
            );

        }


        formData.append(
            'fk_provider_id',
            userType === 'worker'
                ? ($('#edit_fk_provider_id').val() || '')
                : ''
        );


        formData.append(
            'is_active',
            $('#edit_is_active').val()
        );


        $.ajax({

            url: route,

            method: 'POST',

            contentType: false,

            processData: false,

            data: formData,


            success: function(data) {


                if (data === true) {


                    Toast.fire({

                        icon: 'success',

                        title: 'User Updated!'

                    });


                    $('#editUserModal')
                        .modal('hide');


                        $('#userTable')
                        .DataTable()
                        .ajax
                        .reload(null, false);

                }


              


                else {


                    Toast.fire({

                        icon: 'error',

                        title: 'User Not Updated!'

                    });

                }

            },


            error: function(xhr) {


                console.log(
                    xhr.responseJSON.errors
                );

                 if ( xhr.responseJSON.errors) {


        

                    $.each(
                        xhr.responseJSON.errors,
                        function(field, messages) {

                            $('#edit_'+field)
                                .addClass('is-invalid');

                               // Display error message
                            $('#edit_' + field + '_error').html(messages[0]).show();

                        }
                    );



                }

                Toast.fire({

                    icon: 'error',

                    title: 'User not Updated!'

                });

            }

        });

    }
);

    </script>

    @endpush


</x-admin-layout>
