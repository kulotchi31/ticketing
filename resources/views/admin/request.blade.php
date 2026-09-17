<x-admin-layout>

    @push('styles')

    <style>
        /* =========================================
           PAGE
        ========================================= */

        .request-type-page {
            padding: 8px;
        }


        /* =========================================
           HEADER
        ========================================= */

        .request-type-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .request-type-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .request-type-header-icon {
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

        .request-type-title {
            margin: 0;

            font-size: 21px;
            font-weight: 700;

            color: #111827;
            letter-spacing: -.3px;
        }

        .request-type-subtitle {
            margin: 4px 0 0;

            font-size: 13px;
            color: #6b7280;
        }


        /* =========================================
           ADD BUTTON
        ========================================= */

        .btn-add-request-type {
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

        .btn-add-request-type:hover {
            background: #1d4ed8;
            color: #fff;

            transform: translateY(-1px);

            box-shadow: 0 10px 20px rgba(37, 99, 235, .25);
        }


        /* =========================================
           MAIN CARD
        ========================================= */

        .request-type-card {
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

        .request-type-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 20px 24px;

            border-bottom: 1px solid #eef1f5;
        }

        .request-type-toolbar-title {
            font-size: 15px;
            font-weight: 700;

            color: #1f2937;

            margin-bottom: 2px;
        }

        .request-type-toolbar-description {
            font-size: 12px;
            color: #9ca3af;
        }


        /* =========================================
           SEARCH
        ========================================= */

        .request-type-search {
            position: relative;
        }

        .request-type-search i {
            position: absolute;

            top: 50%;
            left: 13px;

            transform: translateY(-50%);

            color: #9ca3af;
            font-size: 14px;
        }

        .request-type-search input {
            width: 240px;
            height: 38px;

            border: 1px solid #e5e7eb;

            border-radius: 9px;

            padding: 0 14px 0 38px;

            font-size: 13px;

            outline: none;

            transition: all .2s ease;
        }

        .request-type-search input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .10);
        }


        /* =========================================
           TABLE
        ========================================= */

        .request-type-table {
            width: 100% !important;

            border-collapse: collapse !important;

            margin: 0 !important;
        }

        .request-type-table thead th {
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

        .request-type-table tbody td {
            padding: 16px 24px !important;

            font-size: 14px;

            color: #334155;

            border-bottom: 1px solid #f0f2f5 !important;

            vertical-align: middle;
        }

        .request-type-table tbody tr:hover {
            background: #f8fbff;
        }


        /* =========================================
           REQUEST TYPE NAME
        ========================================= */

        .request-type-name {
            display: flex;
            align-items: center;

            gap: 12px;

            font-weight: 600;

            color: #1f2937;
        }

        .request-type-avatar {
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
           CODE
        ========================================= */

        .request-type-code {
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
           DATATABLE
        ========================================= */

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


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 768px) {

            .request-type-header {
                align-items: flex-start;

                flex-direction: column;

                gap: 16px;
            }

            .btn-add-request-type {
                width: 100%;

                justify-content: center;
            }

            .request-type-toolbar {
                flex-direction: column;

                align-items: flex-start;

                gap: 15px;
            }

            .request-type-search {
                width: 100%;
            }

            .request-type-search input {
                width: 100%;
            }

        }
    </style>

    @endpush


    <div class="request-type-page">

        <!-- =====================================
             PAGE HEADER
        ====================================== -->

        <div class="request-type-header">

            <div class="request-type-header-left">

                <div class="request-type-header-icon">
                    <i class="bi bi-list-check"></i>
                </div>

                <div>

                    <h4 class="request-type-title">
                        Request Type Management
                    </h4>

                    <p class="request-type-subtitle">
                        Manage and organize provider request types
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="btn-add-request-type"
                id="btnAddRequestType"
                data-bs-toggle="modal"
                data-bs-target="#addRequestTypeModal"
            >

                <i class="bi bi-plus-lg"></i>

                Add Request Type

            </button>

        </div>


        <!-- =====================================
             REQUEST TYPE CARD
        ====================================== -->

        <div class="request-type-card">

            <!-- TOOLBAR -->

            <div class="request-type-toolbar">

                <div>

                    <div class="request-type-toolbar-title">
                        Request Type Directory
                    </div>

                    <div class="request-type-toolbar-description">
                        View and manage all registered request types
                    </div>

                </div>


                <!-- SEARCH -->

                <div class="request-type-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="requestTypeSearch"
                        placeholder="Search request type..."
                    >

                </div>

            </div>


            <!-- TABLE -->

            <div class="table-responsive">

                <table
                    id="requestTypeTable"
                    class="request-type-table"
                >

                    <thead>

                        <tr>

                            <th>Request Type Name</th>

                            <th>Request Type Code</th>

                            <th>Provider</th>

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
         ADD REQUEST TYPE MODAL
    ====================================== -->

    <div
        class="modal fade"
        id="addRequestTypeModal"
        tabindex="-1"
        aria-labelledby="addRequestTypeModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <!-- HEADER -->

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="addRequestTypeModalLabel"
                    >

                        <i class="bi bi-list-check me-2"></i>

                        Add Request Type

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <!-- FORM -->

                <form
                    id="addRequestTypeForm"
                    action="javascript:void(0);"
                    method="POST"
                >

                    @csrf

                    <div class="modal-body">

                        <!-- REQUEST TYPE NAME -->

                        <div class="mb-3">

                            <label
                                for="rt_name"
                                class="form-label"
                            >
                                Request Type Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="rt_name"
                                name="rt_name"
                                placeholder="Enter request type name"
                                required
                            >

                        </div>


                        <!-- REQUEST TYPE CODE -->

                        <div class="mb-3">

                            <label
                                for="rt_code"
                                class="form-label"
                            >
                                Request Type Code
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="rt_code"
                                name="rt_code"
                                placeholder="Enter request type code"
                                required
                            >

                        </div>


                        <!-- PROVIDER -->

                        <div class="mb-3">

                            <label
                                for="fk_provider_id"
                                class="form-label"
                            >
                                Provider
                            </label>

                            <select
                                class="form-select"
                                id="fk_provider_id"
                                name="fk_provider_id"
                                required
                            >

                                <option value="">
                                    Select Provider
                                </option>

                                @foreach($providers as $provider)

                                    <option value="{{ $provider->provider_id }}">
                                        {{ $provider->provider_name }}
                                    </option>

                                @endforeach

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

                            Save Request Type

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- =====================================
         EDIT REQUEST TYPE MODAL
    ====================================== -->

    <div
        class="modal fade"
        id="editRequestTypeModal"
        tabindex="-1"
        aria-labelledby="editRequestTypeModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <!-- HEADER -->

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="editRequestTypeModalLabel"
                    >

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Request Type

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <!-- FORM -->

                <form
                    id="updateRequestTypeForm"
                    action="javascript:void(0);"
                    method="POST"
                >

                    @csrf

                    <input
                        type="hidden"
                        id="request_type_id"
                        name="request_type_id"
                    >

                    <div class="modal-body">

                        <!-- REQUEST TYPE NAME -->

                        <div class="mb-3">

                            <label
                                for="rt_name_edit"
                                class="form-label"
                            >
                                Request Type Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="rt_name_edit"
                                name="rt_name"
                                required
                            >

                        </div>


                        <!-- REQUEST TYPE CODE -->

                        <div class="mb-3">

                            <label
                                for="rt_code_edit"
                                class="form-label"
                            >
                                Request Type Code
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="rt_code_edit"
                                name="rt_code"
                                required
                            >

                        </div>


                        <!-- PROVIDER -->

                        <div class="mb-3">

                            <label
                                for="fk_provider_id_edit"
                                class="form-label"
                            >
                                Provider
                            </label>

                            <select
                                class="form-select"
                                id="fk_provider_id_edit"
                                name="fk_provider_id"
                                required
                            >

                                <option value="">
                                    Select Provider
                                </option>

                                @foreach($providers as $provider)

                                    <option value="{{ $provider->provider_id }}">
                                        {{ $provider->provider_name }}
                                    </option>

                                @endforeach

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

                            Update Request Type

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
               DATATABLE
            ====================================== */

            var table = $('#requestTypeTable').DataTable({

                processing: true,

                serverSide: false,

                paging: true,

                pageLength: 10,

                ajax: {

                    url: "{{ route('admin.request-type') }}",

                    type: "POST",

                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }

                },

                columns: [

                    /*
                    INDEX 0 - REQUEST TYPE NAME
                    */

                    {
                        data: "rt_name",

                        render: function (data) {

                            return `

                                <div class="request-type-name">

                                    <div class="request-type-avatar">
                                        <i class="bi bi-list-check"></i>
                                    </div>

                                    <span>${data}</span>

                                </div>

                            `;

                        }

                    },


                    /*
                    INDEX 1 - REQUEST TYPE CODE
                    */

                    {
                        data: "rt_code",

                        render: function (data) {

                            return `

                                <span class="request-type-code">
                                    ${data}
                                </span>

                            `;

                        }

                    },


                    /*
                    INDEX 2 - PROVIDER NAME
                    */

                    {
                        data: "provider.provider_name"
                    },


                    /*
                    INDEX 3 - ACTIONS / REQUEST TYPE ID
                    */

                    {
                        data: "request_type_id",

                        targets: 3,

                        orderable: false,

                        searchable: false,

                        className: "text-end",

                        render: function (data) {

                            return `

                                <div class="action-buttons">

                                    <button
                                        type="button"
                                        class="action-btn edit"
                                        data-id="${data}"
                                        title="Edit Request Type"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="action-btn delete"
                                        data-id="${data}"
                                        title="Delete Request Type"
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
               SEARCH
            ====================================== */

            $('#requestTypeSearch').on('keyup', function () {

                table.search(this.value).draw();

            });


            /* =====================================
               ADD REQUEST TYPE
            ====================================== */

            $(document).on(
                'submit',
                '#addRequestTypeForm',
                function (e) {

                    e.preventDefault();

                    var rt_name = $('#rt_name').val();

                    var rt_code = $('#rt_code').val();

                    var fk_provider_id = $('#fk_provider_id').val();


                    var formData = new FormData();

                    formData.append(
                        '_token',
                        $('meta[name="csrf-token"]').attr('content')
                    );

                    formData.append(
                        'rt_name',
                        rt_name
                    );

                    formData.append(
                        'rt_code',
                        rt_code
                    );

                    formData.append(
                        'fk_provider_id',
                        fk_provider_id
                    );


                    $.ajax({

                        url: "{{ route('request.store') }}",

                        method: "POST",

                        contentType: false,

                        processData: false,

                        data: formData,


                        success: function (data) {

                            /*
                            SUCCESS
                            */

                            if (data == true) {

                                Toast.fire({

                                    icon: 'success',

                                    title: 'Request Type Added!'

                                });


                                bootstrap.Modal.getOrCreateInstance(
                                    document.getElementById('addRequestTypeModal')
                                ).hide();


                                $('#addRequestTypeForm').trigger('reset');


                                table.ajax.reload(null, false);

                            }


                            /*
                            ALREADY EXISTS
                            */

                            else if (data == 0) {

                                Toast.fire({

                                    icon: 'error',

                                    title: 'Request Type Already Exists!'

                                });

                            }


                            /*
                            ERROR
                            */

                            else {

                                Toast.fire({

                                    icon: 'error',

                                    title: 'Request Type Not Saved!'

                                });

                            }

                        },


                        error: function () {

                            Toast.fire({

                                icon: 'error',

                                title: 'Something went wrong!'

                            });

                        }

                    });

                }

            );


            /* =====================================
               EDIT REQUEST TYPE
            ====================================== */

            $(document).on(
                'click',
                '.edit',
                function () {

                    var id = $(this).data('id');


                    $.ajax({

                        url: "{{ route('request.edit', ':id') }}"
                            .replace(':id', id),

                        type: "GET",


                        success: function (data) {

                            if (data == false) {

                                Toast.fire({

                                    icon: 'error',

                                    title: 'Request Type not found!'

                                });

                                return;

                            }


                            /*
                            SET FORM VALUES
                            */

                            $('#request_type_id').val(
                                data.request_type_id
                            );

                            $('#rt_name_edit').val(
                                data.rt_name
                            );

                            $('#rt_code_edit').val(
                                data.rt_code
                            );

                            $('#fk_provider_id_edit').val(
                                data.fk_provider_id
                            );


                            /*
                            OPEN MODAL
                            */

                            bootstrap.Modal.getOrCreateInstance(
                                document.getElementById('editRequestTypeModal')
                            ).show();

                        },


                        error: function () {

                            Toast.fire({

                                icon: 'error',

                                title: 'Unable to load request type!'

                            });

                        }

                    });

                }

            );


            /* =====================================
               UPDATE REQUEST TYPE
            ====================================== */

            $(document).on(
                'submit',
                '#updateRequestTypeForm',
                function (e) {

                    e.preventDefault();

                    var id = $('#request_type_id').val();


                    var route = "{{ route('request.update', ':id') }}";

                    route = route.replace(':id', id);


                    var formData = new FormData();

                    formData.append(
                        '_token',
                        $('meta[name="csrf-token"]').attr('content')
                    );

                    formData.append(
                        'rt_name',
                        $('#rt_name_edit').val()
                    );

                    formData.append(
                        'rt_code',
                        $('#rt_code_edit').val()
                    );

                    formData.append(
                        'fk_provider_id',
                        $('#fk_provider_id_edit').val()
                    );

                    formData.append(
                        '_method',
                        'PUT'
                    );


                    $.ajax({

                        url: route,

                        method: 'POST',

                        contentType: false,

                        processData: false,

                        data: formData,


                        success: function (data) {

                            /*
                            UPDATED SUCCESSFULLY
                            */

                            if (data == true) {

                                Toast.fire({

                                    icon: 'success',

                                    title: 'Request Type Updated!'

                                });


                                bootstrap.Modal.getOrCreateInstance(
                                    document.getElementById('editRequestTypeModal')
                                ).hide();


                                table.ajax.reload(null, false);

                            }


                            /*
                            NO CHANGES
                            */

                            else if (data == 0) {

                                Toast.fire({

                                    icon: 'warning',

                                    title: 'No Changes Found!'

                                });

                            }


                            /*
                            ERROR
                            */

                            else {

                                Toast.fire({

                                    icon: 'error',

                                    title: 'Request Type Not Updated!'

                                });

                            }

                        },


                        error: function () {

                            Toast.fire({

                                icon: 'error',

                                title: 'Something went wrong!'

                            });

                        }

                    });

                }

            );


            /* =====================================
               DELETE REQUEST TYPE
            ====================================== */

            $(document).on(
                'click',
                '.delete',
                function () {

                    var id = $(this).data('id');


                    Swal.fire({

                        title: 'Are you sure you?',

                        showDenyButton: true,

                        confirmButtonText: 'Delete',

                        denyButtonText: `Don't Delete`,

                    }).then((result) => {

                        if (result.isConfirmed) {

                            var route = "{{ route('request.destroy', ':id') }}";

                            route = route.replace(':id', id);


                            $.ajax({

                                url: route,

                                method: 'POST',

                                data: {

                                    _token:
                                        $('meta[name="csrf-token"]').attr('content'),

                                    _method: 'DELETE'

                                },


                                success: function (data) {

                                    /*
                                    SUCCESS
                                    */

                                    if (data == true) {

                                        Toast.fire({

                                            icon: 'success',

                                            title: 'Request Type Deleted!'

                                        });

                                        table.ajax.reload(null, false);

                                    }


                                    /*
                                    DELETE FAILED
                                    */

                                    else {

                                        Toast.fire({

                                            icon: 'error',

                                            title: 'Request Type Not Deleted!'

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

                    });

                }

            );

        });

    </script>

    @endpush

</x-admin-layout>