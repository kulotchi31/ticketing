<x-admin-layout>

    @push('styles')

    <style>

        /* =========================================
           PAGE
        ========================================= */

        .category-page {
            padding: 8px;
        }


        /* =========================================
           HEADER
        ========================================= */

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .category-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .category-header-icon {
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

        .category-title {
            margin: 0;

            font-size: 21px;
            font-weight: 700;

            color: #111827;

            letter-spacing: -.3px;
        }

        .category-subtitle {
            margin: 4px 0 0;

            font-size: 13px;

            color: #6b7280;
        }


        /* =========================================
           ADD BUTTON
        ========================================= */

        .btn-add-category {
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

        .btn-add-category:hover {
            background: #1d4ed8;
            color: #fff;

            transform: translateY(-1px);

            box-shadow: 0 10px 20px rgba(37, 99, 235, .25);
        }


        /* =========================================
           MAIN CARD
        ========================================= */

        .category-card {
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

        .category-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 20px 24px;

            border-bottom: 1px solid #eef1f5;
        }

        .category-toolbar-title {
            font-size: 15px;
            font-weight: 700;

            color: #1f2937;

            margin-bottom: 2px;
        }

        .category-toolbar-description {
            font-size: 12px;
            color: #9ca3af;
        }


        /* =========================================
           CUSTOM SEARCH
        ========================================= */

        .category-search {
            position: relative;
        }

        .category-search i {
            position: absolute;

            top: 50%;
            left: 13px;

            transform: translateY(-50%);

            color: #9ca3af;

            font-size: 14px;
        }

        .category-search input {
            width: 240px;

            height: 38px;

            border: 1px solid #e5e7eb;

            border-radius: 9px;

            padding: 0 14px 0 38px;

            font-size: 13px;

            outline: none;

            transition: all .2s ease;
        }

        .category-search input::placeholder {
            color: #b0b7c3;
        }

        .category-search input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .10);
        }


        /* =========================================
           TABLE
        ========================================= */

        .category-table {
            width: 100% !important;

            border-collapse: collapse !important;

            margin: 0 !important;
        }


        /* TABLE HEADER */

        .category-table thead th {
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

        .category-table tbody td {
            padding: 16px 24px !important;

            font-size: 14px;

            color: #334155;

            border-bottom: 1px solid #f0f2f5 !important;

            vertical-align: middle;
        }

        .category-table tbody tr {
            transition: all .15s ease;
        }

        .category-table tbody tr:hover {
            background: #f8fbff;
        }

        .category-table tbody tr:last-child td {
            border-bottom: none !important;
        }


        /* =========================================
           CATEGORY NAME
        ========================================= */

        .category-name {
            display: flex;
            align-items: center;

            gap: 12px;

            font-weight: 600;

            color: #1f2937;
        }

        .category-avatar {
            width: 38px;
            height: 38px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: #eff6ff;

            color: #2563eb;

            font-size: 17px;
        }


        /* =========================================
           CATEGORY CODE
        ========================================= */

        .category-code {
            display: inline-flex;

            align-items: center;

            padding: 5px 10px;

            background: #f1f5f9;

            border: 1px solid #e2e8f0;

            border-radius: 7px;

            font-family: monospace;

            font-size: 12px;

            font-weight: 700;

            color: #475569;

            letter-spacing: .3px;
        }


        /* =========================================
           REQUEST TYPE
        ========================================= */

        .request-type-badge {
            display: inline-flex;

            align-items: center;

            padding: 5px 10px;

            background: #f0fdf4;

            border: 1px solid #bbf7d0;

            border-radius: 7px;

            font-size: 12px;

            font-weight: 600;

            color: #15803d;
        }


        /* =========================================
           ACTIONS
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
           DATATABLES CUSTOMIZATION
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

        .dataTables_empty {
            padding: 60px !important;

            text-align: center !important;

            color: #94a3b8 !important;
        }


        /* =========================================
           VALIDATION
        ========================================= */

        .invalid-feedback {
            display: none;

            width: 100%;

            margin-top: 5px;

            font-size: 12px;

            color: #dc3545;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545 !important;
        }

        .form-control.is-invalid:focus,
        .form-select.is-invalid:focus {
            border-color: #dc3545 !important;

            box-shadow: 0 0 0 .25rem rgba(220, 53, 69, .15) !important;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 768px) {

            .category-header {
                align-items: flex-start;

                flex-direction: column;

                gap: 16px;
            }

            .btn-add-category {
                width: 100%;

                justify-content: center;
            }

            .category-toolbar {
                flex-direction: column;

                align-items: flex-start;

                gap: 15px;
            }

            .category-search input {
                width: 100%;
            }

            .category-search {
                width: 100%;
            }

        }

    </style>

    @endpush


    <div class="category-page">

        <!-- =====================================
             PAGE HEADER
        ====================================== -->

        <div class="category-header">

            <div class="category-header-left">

                <div class="category-header-icon">
                    <i class="bi bi-tags"></i>
                </div>

                <div>

                    <h4 class="category-title">
                        Category Management
                    </h4>

                    <p class="category-subtitle">
                        Manage and organize request categories
                    </p>

                </div>

            </div>


            <!-- ADD CATEGORY BUTTON -->

            <button
                type="button"
                class="btn-add-category"
                id="btnAddCategory"
                data-bs-toggle="modal"
                data-bs-target="#addCategoryModal"
            >

                <i class="bi bi-plus-lg"></i>

                Add Category

            </button>

        </div>


        <!-- =====================================
             CATEGORY CARD
        ====================================== -->

        <div class="category-card">

            <!-- TOOLBAR -->

            <div class="category-toolbar">

                <div>

                    <div class="category-toolbar-title">
                        Category Directory
                    </div>

                    <div class="category-toolbar-description">
                        View and manage all registered categories
                    </div>

                </div>


                <!-- CUSTOM SEARCH -->

                <div class="category-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="categorySearch"
                        placeholder="Search category..."
                    >

                </div>

            </div>


            <!-- TABLE -->

            <div class="table-responsive">

                <table
                    id="categoryTable"
                    class="category-table"
                >

                    <thead>

                        <tr>

                            <th>
                                Category Name
                            </th>

                            <th>
                                Category Code
                            </th>


                            <th>
                                Provider
                            </th>

                            <th>
                                Request Type
                            </th>


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
         ADD CATEGORY MODAL
    ====================================== -->

    <div
        class="modal fade"
        id="addCategoryModal"
        tabindex="-1"
        aria-labelledby="addCategoryModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <!-- MODAL HEADER -->

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="addCategoryModalLabel"
                    >

                        <i class="bi bi-tags me-2"></i>

                        Add Category

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <!-- ADD FORM -->

                <form
                    id="addForm"
                    action="javascript:void(0);"
                    method="POST"
                    novalidate
                >

                    @csrf

                    <!-- MODAL BODY -->

                    <div class="modal-body">

                        <!-- CATEGORY NAME -->

                        <div class="mb-3">

                            <label
                                for="category_name"
                                class="form-label"
                            >
                                Category Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="category_name"
                                name="category_name"
                                placeholder="Enter category name"
                                required
                            >

                            <div
                                id="category_name_error"
                                class="invalid-feedback"
                            ></div>

                        </div>


                        <!-- CATEGORY CODE -->

                        <div class="mb-3">

                            <label
                                for="category_code"
                                class="form-label"
                            >
                                Category Code
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="category_code"
                                name="category_code"
                                placeholder="Enter category code"
                                required
                            >

                            <div
                                id="category_code_error"
                                class="invalid-feedback"
                            ></div>

                        </div>


                        <!-- REQUEST TYPE -->

                        <div class="mb-3">

                            <label
                                for="fk_request_type_id"
                                class="form-label"
                            >
                                Request Type
                            </label>

                            <select
                                class="form-select"
                                id="fk_request_type_id"
                                name="fk_request_type_id"
                                required
                            >

                                <option value="">
                                    Select Request Type
                                </option>

                                @foreach($requestTypes as $requestType)

                                    <option
                                        value="{{ $requestType->request_type_id }}"
                                    >
                                        {{ $requestType->rt_name }}
                                    </option>

                                @endforeach

                            </select>

                            <div
                                id="fk_request_type_id_error"
                                class="invalid-feedback"
                            ></div>

                        </div>

                    </div>


                    <!-- MODAL FOOTER -->

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
                            id="btnSaveCategory"
                        >

                            <i class="bi bi-save me-1"></i>

                            Save Category

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- =====================================
         EDIT CATEGORY MODAL
    ====================================== -->

    <div
        class="modal fade"
        id="exampleEditModal"
        tabindex="-1"
        aria-labelledby="exampleEditModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <!-- MODAL HEADER -->

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="exampleEditModalLabel"
                    >

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Category

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <!-- UPDATE FORM -->

                <form
                    id="updateForm"
                    action="javascript:void(0);"
                    method="POST"
                    novalidate
                >

                    @csrf

                    <!-- HIDDEN CATEGORY ID -->

                    <input
                        type="hidden"
                        id="id"
                        name="id"
                    >


                    <!-- MODAL BODY -->

                    <div class="modal-body">

                        <!-- CATEGORY NAME -->

                        <div class="mb-3">

                            <label
                                for="category_name_edit"
                                class="form-label"
                            >
                                Category Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="category_name_edit"
                                name="category_name"
                                placeholder="Enter category name"
                                required
                            >

                            <div
                                id="category_editname_error"
                                class="invalid-feedback"
                            ></div>

                        </div>


                        <!-- CATEGORY CODE -->

                        <div class="mb-3">

                            <label
                                for="category_code_edit"
                                class="form-label"
                            >
                                Category Code
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="category_code_edit"
                                name="category_code"
                                placeholder="Enter category code"
                                required
                            >

                            <div
                                id="category_editcode_error"
                                class="invalid-feedback"
                            ></div>

                        </div>


                        <!-- REQUEST TYPE -->

                        <div class="mb-3">

                            <label
                                for="fk_request_type_id_edit"
                                class="form-label"
                            >
                                Request Type
                            </label>

                            <select
                                class="form-select"
                                id="fk_request_type_id_edit"
                                name="fk_request_type_id"
                                required
                            >

                                <option value="">
                                    Select Request Type
                                </option>

                                @foreach($requestTypes as $requestType)

                                    <option
                                        value="{{ $requestType->request_type_id }}"
                                    >
                                        {{ $requestType->rt_name }}
                                    </option>

                                @endforeach

                            </select>

                            <div
                                id="category_editrequesttype_error"
                                class="invalid-feedback"
                            ></div>

                        </div>

                    </div>


                    <!-- MODAL FOOTER -->

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
                            id="btnUpdateCategory"
                        >

                            <i class="bi bi-check-lg me-1"></i>

                            Update Category

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    @push('scripts')

    <script>

        $(document).ready(function () {


            /* =====================================
               VALIDATION FUNCTIONS
            ====================================== */

            function clearAddValidation() {

                $('#category_name')
                    .removeClass('is-invalid');

                $('#category_code')
                    .removeClass('is-invalid');

                $('#fk_request_type_id')
                    .removeClass('is-invalid');

                $('#category_name_error')
                    .text('')
                    .hide();

                $('#category_code_error')
                    .text('')
                    .hide();

                $('#fk_request_type_id_error')
                    .text('')
                    .hide();

            }


            function clearUpdateValidation() {

                $('#category_name_edit')
                    .removeClass('is-invalid');

                $('#category_code_edit')
                    .removeClass('is-invalid');

                $('#fk_request_type_id_edit')
                    .removeClass('is-invalid');

                $('#category_editname_error')
                    .text('')
                    .hide();

                $('#category_editcode_error')
                    .text('')
                    .hide();

                $('#category_editrequesttype_error')
                    .text('')
                    .hide();

            }


            function displayAddValidation(errors) {

                clearAddValidation();

                if (
                    errors.category_name &&
                    errors.category_name.length > 0
                ) {

                    $('#category_name')
                        .addClass('is-invalid');

                    $('#category_name_error')
                        .text(errors.category_name[0])
                        .show();

                }

                if (
                    errors.category_code &&
                    errors.category_code.length > 0
                ) {

                    $('#category_code')
                        .addClass('is-invalid');

                    $('#category_code_error')
                        .text(errors.category_code[0])
                        .show();

                }

                if (
                    errors.fk_request_type_id &&
                    errors.fk_request_type_id.length > 0
                ) {

                    $('#fk_request_type_id')
                        .addClass('is-invalid');

                    $('#fk_request_type_id_error')
                        .text(errors.fk_request_type_id[0])
                        .show();

                }

            }


            function displayUpdateValidation(errors) {

                clearUpdateValidation();

                if (
                    errors.category_name &&
                    errors.category_name.length > 0
                ) {

                    $('#category_name_edit')
                        .addClass('is-invalid');

                    $('#category_editname_error')
                        .text(errors.category_name[0])
                        .show();

                }

                if (
                    errors.category_code &&
                    errors.category_code.length > 0
                ) {

                    $('#category_code_edit')
                        .addClass('is-invalid');

                    $('#category_editcode_error')
                        .text(errors.category_code[0])
                        .show();

                }

                if (
                    errors.fk_request_type_id &&
                    errors.fk_request_type_id.length > 0
                ) {

                    $('#fk_request_type_id_edit')
                        .addClass('is-invalid');

                    $('#category_editrequesttype_error')
                        .text(errors.fk_request_type_id[0])
                        .show();

                }

            }


            /* =====================================
               DATATABLE
            ====================================== */

            var table = $('#categoryTable').DataTable({

                processing: true,

                serverSide: false,

                paging: true,

                pageLength: 10,

                ajax: {

                    url: "{{ route('admin.category') }}",

                    type: "POST",

                    data: {

                        _token: $('meta[name="csrf-token"]').attr('content')

                    }

                },

                columns: [

                    {

                        data: "category_name",

                        render: function (data) {

                            return `

                                <div class="category-name">

                                    <div class="category-avatar">

                                        <i class="bi bi-tags"></i>

                                    </div>

                                    <span>${data ?? ''}</span>

                                </div>

                            `;

                        }

                    },


                    {

                        data: "category_code",

                        render: function (data) {

                            return `

                                <span class="category-code">

                                    ${data ?? ''}

                                </span>

                            `;

                        }

                    },

                     {

                        data: "request_type.provider.provider_name",

                        defaultContent: '',

                        render: function (data) {

                            return data

                                ? `

                                    <span class="request-type-badge">

                                        ${data}

                                    </span>

                                `

                                : '';

                        }

                    },



                    {

                        data: "request_type.rt_name",

                        defaultContent: '',

                        render: function (data) {

                            return data

                                ? `

                                    <span class="request-type-badge">

                                        ${data}

                                    </span>

                                `

                                : '';

                        }

                    },

                     

                    {

                        data: "category_id",

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
                                        title="Edit Category"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </button>


                                    <button
                                        type="button"
                                        name="delete"
                                        class="action-btn delete"
                                        data-id="${data}"
                                        title="Delete Category"
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

            $('#categorySearch').on('keyup', function () {

                table.search(this.value).draw();

            });


            /* =====================================
               RESET ADD FORM
            ====================================== */

            $('#addCategoryModal').on('hidden.bs.modal', function () {

                $('#addForm')[0].reset();

                clearAddValidation();

            });


            $('#btnAddCategory').on('click', function () {

                $('#addForm')[0].reset();

                clearAddValidation();

            });


            /* =====================================
               ADD CATEGORY
            ====================================== */

            $(document).on("submit", "#addForm", function (e) {

                e.preventDefault();

                clearAddValidation();

                var category_name = $("#category_name").val().trim();

                var category_code = $("#category_code").val().trim();

                var fk_request_type_id = $("#fk_request_type_id").val();


                var formData = new FormData();

                formData.append(
                    "_token",
                    $('meta[name="csrf-token"]').attr('content')
                );

                formData.append(
                    "category_name",
                    category_name
                );

                formData.append(
                    "category_code",
                    category_code
                );

                formData.append(
                    "fk_request_type_id",
                    fk_request_type_id
                );


                $.ajax({

                    url: "{{ route('category.store') }}",

                    method: "POST",

                    contentType: false,

                    processData: false,

                    data: formData,

                    success: function (data) {

                        if (data == true) {

                            Toast.fire({

                                icon: 'success',

                                title: 'Category Added!'

                            });


                            const modalElement =
                                document.getElementById('addCategoryModal');

                            const modal =
                                bootstrap.Modal.getOrCreateInstance(modalElement);

                            modal.hide();


                            clearAddValidation();

                            $("#addForm").trigger("reset");

                            table.ajax.reload(null, false);

                        }

                        else if (data == 3) {


                            if (
                                data.errors &&
                                data.errors.category_name
                            ) {

                                $('#category_name')
                                    .addClass('is-invalid');

                                $('#category_name_error')
                                    .text(data.errors.category_name[0])
                                    .show();

                            }

                            if (
                                data.errors &&
                                data.errors.category_code
                            ) {

                                $('#category_code')
                                    .addClass('is-invalid');

                                $('#category_code_error')
                                    .text(data.errors.category_code[0])
                                    .show();

                            }

                            if (
                                data.errors &&
                                data.errors.fk_request_type_id
                            ) {

                                $('#fk_request_type_id')
                                    .addClass('is-invalid');

                                $('#fk_request_type_id_error')
                                    .text(data.errors.fk_request_type_id[0])
                                    .show();

                            }

                            Toast.fire({

                                icon: 'error',

                                title: 'Category Not Saved!'

                            });

                        }

                        else if (data == 0) {

                            Toast.fire({

                                icon: 'error',

                                title: 'Category Not Saved!'

                            });

                        }

                        else {

                            if (
                                data.errors &&
                                data.errors.category_name
                            ) {

                                $('#category_name')
                                    .addClass('is-invalid');

                                $('#category_name_error')
                                    .text(data.errors.category_name[0])
                                    .show();

                            }

                            if (
                                data.errors &&
                                data.errors.category_code
                            ) {

                                $('#category_code')
                                    .addClass('is-invalid');

                                $('#category_code_error')
                                    .text(data.errors.category_code[0])
                                    .show();

                            }

                            if (
                                data.errors &&
                                data.errors.fk_request_type_id
                            ) {

                                $('#fk_request_type_id')
                                    .addClass('is-invalid');

                                $('#fk_request_type_id_error')
                                    .text(data.errors.fk_request_type_id[0])
                                    .show();

                            }

                        }

                    },

                    error: function (xhr) {

                        if (
                            xhr.status === 422 &&
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {

                            displayAddValidation(
                                xhr.responseJSON.errors
                            );

                        }

                        else {

                            Toast.fire({

                                icon: 'error',

                                title: 'Something went wrong!'

                            });

                        }

                    }

                });

            });


            /* =====================================
               EDIT CATEGORY
            ====================================== */

            $(document).on(
                "click",
                "button[name='edit']",
                function () {

                    var id = $(this).data('id');

                    var route =
                        "{{ route('category.edit', ':id') }}";

                    route = route.replace(':id', id);


                    clearUpdateValidation();


                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('exampleEditModal')
                    ).show();


                    $.ajax({

                        url: route,

                        type: "GET",

                        data: {

                            _token:
                                $('meta[name="csrf-token"]').attr('content')

                        },

                        success: function (data) {

                            /*
                             * Supports the response format:
                             * { data: [ { ... } ] }
                             */

                            var category = data.data
                                ? data.data[0]
                                : data;


                            if (!category) {

                                Toast.fire({

                                    icon: 'error',

                                    title: 'Category not found!'

                                });

                                return;

                            }


                            $("#id").val(
                                category.category_id
                            );

                            $("#category_name_edit").val(
                                category.category_name
                            );

                            $("#category_code_edit").val(
                                category.category_code
                            );

                            $("#fk_request_type_id_edit").val(
                                category.fk_request_type_id
                            );

                        },

                        error: function () {

                            Toast.fire({

                                icon: 'error',

                                title: 'Unable to load category!'

                            });

                        }

                    });

                }

            );


            /* =====================================
               UPDATE CATEGORY
            ====================================== */

            $(document).on("submit", "#updateForm", function (e) {

                e.preventDefault();

                clearUpdateValidation();

                var id = $("#id").val();

                var category_name =
                    $("#category_name_edit").val().trim();

                var category_code =
                    $("#category_code_edit").val().trim();

                var fk_request_type_id =
                    $("#fk_request_type_id_edit").val();


                var route =
                    "{{ route('category.update', ':id') }}";

                route = route.replace(':id', id);


                var formData = new FormData();

                formData.append(
                    "_token",
                    $('meta[name="csrf-token"]').attr('content')
                );

                formData.append(
                    "category_name",
                    category_name
                );

                formData.append(
                    "category_code",
                    category_code
                );

                formData.append(
                    "fk_request_type_id",
                    fk_request_type_id
                );

                formData.append(
                    "_method",
                    "PUT"
                );


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

                                title: 'Category Updated!'

                            });


                            const modalElement =
                                document.getElementById('exampleEditModal');

                            const modal =
                                bootstrap.Modal.getOrCreateInstance(modalElement);

                            modal.hide();


                            clearUpdateValidation();

                            table.ajax.reload(null, false);

                        }

                        else if (data == 3) {

                            Toast.fire({

                                icon: 'error',

                                title: 'Category Not Updated!'

                            });

                        }

                        else if (data == 0) {

                            Toast.fire({

                                icon: 'error',

                                title: 'No Changes Found!'

                            });

                        }

                        else {

                            if (
                                data.errors &&
                                data.errors.category_name
                            ) {

                                $('#category_name_edit')
                                    .addClass('is-invalid');

                                $('#category_editname_error')
                                    .text(data.errors.category_name[0])
                                    .show();

                            }

                            if (
                                data.errors &&
                                data.errors.category_code
                            ) {

                                $('#category_code_edit')
                                    .addClass('is-invalid');

                                $('#category_editcode_error')
                                    .text(data.errors.category_code[0])
                                    .show();

                            }

                            if (
                                data.errors &&
                                data.errors.fk_request_type_id
                            ) {

                                $('#fk_request_type_id_edit')
                                    .addClass('is-invalid');

                                $('#category_editrequesttype_error')
                                    .text(data.errors.fk_request_type_id[0])
                                    .show();

                            }

                        }

                    },

                    error: function (xhr) {

                        if (
                            xhr.status === 422 &&
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {

                            displayUpdateValidation(
                                xhr.responseJSON.errors
                            );

                        }

                        else {

                            Toast.fire({

                                icon: 'error',

                                title: 'Something went wrong!'

                            });

                        }

                    }

                });

            });


            /* =====================================
               DELETE CATEGORY
            ====================================== */

            $(document).on(
                "click",
                "button[name='delete']",
                function () {

                    var id = $(this).data('id');

                    var route =
                        "{{ route('category.destroy', ':id') }}";

                    route = route.replace(':id', id);


                    var formData = new FormData();

                    formData.append(
                        "_token",
                        $('meta[name="csrf-token"]').attr('content')
                    );

                    formData.append(
                        "_method",
                        "DELETE"
                    );


                    Swal.fire({

                        title: 'Are you sure?',
                        showDenyButton: true,

                        confirmButtonText: 'Delete',

                        denyButtonText: `Don't Delete`

                    }).then((result) => {

                        if (result.isConfirmed) {

                            $.ajax({

                                url: route,

                                contentType: false,

                                processData: false,

                                type: "POST",

                                data: formData,

                                success: function (data) {

                                    if (data == true || data == 1) {

                                        Toast.fire({

                                            icon: 'success',

                                            title: 'Category Deleted!'

                                        });

                                        table.ajax.reload(null, false);

                                    }

                                    else {

                                        Toast.fire({

                                            icon: 'error',

                                            title: 'Category Not Deleted!'

                                        });

                                    }

                                },

                                error: function () {

                                    Swal.fire({

                                        icon: 'error',

                                        title: 'Error!',

                                        text: 'Something went wrong. Please try again.'

                                    });

                                }

                            });

                        }

                        else if (result.isDenied) {

                            Toast.fire({

                                icon: 'error',

                                title: 'Not Deleted!'

                            });

                        }

                    });

                }

            );


            /* =====================================
               CLEAR UPDATE VALIDATION ON CLOSE
            ====================================== */

            $('#exampleEditModal').on(
                'hidden.bs.modal',
                function () {

                    clearUpdateValidation();

                }

            );


            /* =====================================
               CLEAR VALIDATION WHEN TYPING
            ====================================== */

            $('#category_name').on('input', function () {

                $(this).removeClass('is-invalid');

                $('#category_name_error')
                    .text('')
                    .hide();

            });


            $('#category_code').on('input', function () {

                $(this).removeClass('is-invalid');

                $('#category_code_error')
                    .text('')
                    .hide();

            });


            $('#fk_request_type_id').on('change', function () {

                $(this).removeClass('is-invalid');

                $('#fk_request_type_id_error')
                    .text('')
                    .hide();

            });


            $('#category_name_edit').on('input', function () {

                $(this).removeClass('is-invalid');

                $('#category_editname_error')
                    .text('')
                    .hide();

            });


            $('#category_code_edit').on('input', function () {

                $(this).removeClass('is-invalid');

                $('#category_editcode_error')
                    .text('')
                    .hide();

            });


            $('#fk_request_type_id_edit').on('change', function () {

                $(this).removeClass('is-invalid');

                $('#category_editrequesttype_error')
                    .text('')
                    .hide();

            });


        });

    </script>

    @endpush

</x-admin-layout>