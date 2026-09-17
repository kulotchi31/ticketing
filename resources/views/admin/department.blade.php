
<x-admin-layout>

@push('styles')

<style>

    /* =========================================
       PAGE
    ========================================= */

    .department-page {
        padding: 8px;
    }


    /* =========================================
       HEADER
    ========================================= */

    .department-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .department-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .department-header-icon {
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

    .department-title {
        margin: 0;

        font-size: 21px;
        font-weight: 700;

        color: #111827;
        letter-spacing: -.3px;
    }

    .department-subtitle {
        margin: 4px 0 0;

        font-size: 13px;
        color: #6b7280;
    }


    /* =========================================
       ADD BUTTON
    ========================================= */

    .btn-add-department {
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

    .btn-add-department:hover {
        background: #1d4ed8;
        color: #fff;

        transform: translateY(-1px);

        box-shadow: 0 10px 20px rgba(37, 99, 235, .25);
    }


    /* =========================================
       MAIN CARD
    ========================================= */

    .department-card {

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

    .department-toolbar {

        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 20px 24px;

        border-bottom: 1px solid #eef1f5;
    }

    .department-toolbar-title {
        font-size: 15px;
        font-weight: 700;

        color: #1f2937;

        margin-bottom: 2px;
    }

    .department-toolbar-description {
        font-size: 12px;
        color: #9ca3af;
    }


    /* =========================================
       SEARCH
    ========================================= */

    .department-search {
        position: relative;
    }

    .department-search i {
        position: absolute;

        top: 50%;
        left: 13px;

        transform: translateY(-50%);

        color: #9ca3af;
        font-size: 14px;
    }

    .department-search input {

        width: 240px;
        height: 38px;

        border: 1px solid #e5e7eb;

        border-radius: 9px;

        padding: 0 14px 0 38px;

        font-size: 13px;

        outline: none;

        transition: all .2s ease;
    }

    .department-search input:focus {

        border-color: #2563eb;

        box-shadow:
            0 0 0 3px rgba(37, 99, 235, .10);
    }


    /* =========================================
       TABLE
    ========================================= */

    .department-table {
        width: 100% !important;

        border-collapse: collapse !important;

        margin: 0 !important;
    }


    .department-table thead th {

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


    .department-table tbody td {

        padding: 16px 24px !important;

        font-size: 14px;

        color: #334155;

        border-bottom: 1px solid #f0f2f5 !important;

        vertical-align: middle;
    }


    .department-table tbody tr:hover {

        background: #f8fbff;
    }


    /* =========================================
       DEPARTMENT NAME
    ========================================= */

    .department-name {

        display: flex;
        align-items: center;

        gap: 12px;

        font-weight: 600;

        color: #1f2937;
    }

    .department-avatar {

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

    .department-code {

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

        .department-header {

            align-items: flex-start;

            flex-direction: column;

            gap: 16px;
        }


        .btn-add-department {

            width: 100%;

            justify-content: center;
        }


        .department-toolbar {

            flex-direction: column;

            align-items: flex-start;

            gap: 15px;
        }


        .department-search {

            width: 100%;
        }


        .department-search input {

            width: 100%;
        }

    }

</style>

@endpush



<div class="department-page">


    <!-- =====================================
         PAGE HEADER
    ====================================== -->

    <div class="department-header">

        <div class="department-header-left">

            <div class="department-header-icon">
                <i class="bi bi-building"></i>
            </div>


            <div>

                <h4 class="department-title">
                    Department Management
                </h4>

                <p class="department-subtitle">
                    Manage and organize university departments
                </p>

            </div>

        </div>


        <button
            type="button"
            class="btn-add-department"
            id="btnAddDepartment"
            data-bs-toggle="modal"
            data-bs-target="#addDepartmentModal"
        >

            <i class="bi bi-plus-lg"></i>

            Add Department

        </button>

    </div>



    <!-- =====================================
         DEPARTMENT CARD
    ====================================== -->

    <div class="department-card">


        <!-- TOOLBAR -->

        <div class="department-toolbar">

            <div>

                <div class="department-toolbar-title">
                    Department Directory
                </div>

                <div class="department-toolbar-description">
                    View and manage all registered departments
                </div>

            </div>


            <!-- SEARCH -->

            <div class="department-search">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="departmentSearch"
                    placeholder="Search department..."
                >

            </div>

        </div>



        <!-- TABLE -->

        <div class="table-responsive">

            <table
                id="departmentTable"
                class="department-table"
            >

                <thead>

                    <tr>

                        <th>Department Name</th>

                        <th>Department Code</th>

                        <th>Campus</th>

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
     ADD DEPARTMENT MODAL
====================================== -->

<div
    class="modal fade"
    id="addDepartmentModal"
    tabindex="-1"
    aria-labelledby="addDepartmentModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">


            <!-- HEADER -->

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="addDepartmentModalLabel"
                >

                    <i class="bi bi-building me-2"></i>

                    Add Department

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>



            <!-- FORM -->

            <form
                id="addDepartmentForm"
                action="javascript:void(0);"
                method="POST"
            >

                @csrf


                <div class="modal-body">


                    <!-- DEPARTMENT NAME -->

                    <div class="mb-3">

                        <label
                            for="department_name"
                            class="form-label"
                        >
                            Department Name
                        </label>


                        <input
                            type="text"
                            class="form-control"
                            id="department_name"
                            name="department_name"
                            placeholder="Enter department name"
                            required
                        >

                    </div>



                    <!-- DEPARTMENT CODE -->

                    <div class="mb-3">

                        <label
                            for="department_code"
                            class="form-label"
                        >
                            Department Code
                        </label>


                        <input
                            type="text"
                            class="form-control"
                            id="department_code"
                            name="department_code"
                            placeholder="Enter department code"
                            required
                        >

                    </div>



                    <!-- CAMPUS -->

                    <div class="mb-3">

                        <label
                            for="campus_id"
                            class="form-label"
                        >
                            Campus
                        </label>


                        <select
                            class="form-select"
                            id="campus_id"
                            name="campus_id"
                            required
                        >
                             


                            <option value="">
                                Select Campus
                            </option>


                               @foreach($campuses as $campus)
                                    <option value="{{ $campus->campus_id }}">
                                        {{ $campus->campus_name }}
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

                        Save Department

                    </button>

                </div>


            </form>


        </div>

    </div>

</div>



<!-- =====================================
     EDIT DEPARTMENT MODAL
====================================== -->

<div
    class="modal fade"
    id="editDepartmentModal"
    tabindex="-1"
    aria-labelledby="editDepartmentModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">


            <!-- HEADER -->

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="editDepartmentModalLabel"
                >

                    <i class="bi bi-pencil-square me-2"></i>

                    Edit Department

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>



            <!-- FORM -->

            <form
                id="updateDepartmentForm"
                action="javascript:void(0);"
                method="POST"
            >

                @csrf


                <input
                    type="hidden"
                    id="department_id"
                    name="department_id"
                >


                <div class="modal-body">


                    <!-- DEPARTMENT NAME -->

                    <div class="mb-3">

                        <label
                            for="department_name_edit"
                            class="form-label"
                        >
                            Department Name
                        </label>


                        <input
                            type="text"
                            class="form-control"
                            id="department_name_edit"
                            name="department_name"
                            required
                        >

                    </div>



                    <!-- DEPARTMENT CODE -->

                    <div class="mb-3">

                        <label
                            for="department_code_edit"
                            class="form-label"
                        >
                            Department Code
                        </label>


                        <input
                            type="text"
                            class="form-control"
                            id="department_code_edit"
                            name="department_code"
                            required
                        >

                    </div>



                    <!-- CAMPUS -->

                    <div class="mb-3">

                        <label
                            for="campus_id_edit"
                            class="form-label"
                        >
                            Campus
                        </label>


                        <select
                            class="form-select"
                            id="campus_id_edit"
                            name="campus_id"
                            required
                        >

                            <option value="">
                                Select Campus
                            </option>


                                 @foreach($campuses as $campus)
                                    <option value="{{ $campus->campus_id }}">
                                        {{ $campus->campus_name }}
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

                        Update Department

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

   var table = $('#departmentTable').DataTable({

    processing: true,

    serverSide: false,

    paging: true,

    pageLength: 10,


    ajax: {

        url: "{{ route('admin.department') }}",

        type: "POST",

        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        }

    },


    columns: [

        /*
        INDEX 0 - DEPARTMENT NAME
        */

        {
            data: "department_name",

            render: function (data) {

                return `

                    <div class="department-name">

                        <div class="department-avatar">
                            <i class="bi bi-building"></i>
                        </div>

                        <span>${data}</span>

                    </div>

                `;

            }

        },


        /*
        INDEX 1 - DEPARTMENT CODE
        */

        {
            data: "department_code",

            render: function (data) {

                return `

                    <span class="department-code">
                        ${data}
                    </span>

                `;

            }

        },


        /*
        INDEX 2 - CAMPUS NAME
        */

        {
            data: "campus.campus_name"
        },


        /*
        INDEX 3 - ACTIONS / DEPARTMENT ID
        */

        {
            data: "department_id",

            targets: 3,

            orderable: false,

            searchable: false,

            className: "text-end",

            render: function (data, type, row, meta) {

                return `

                    <div class="action-buttons">

                        <button
                            type="button"
                            class="action-btn edit"
                            data-id="${data}"
                            title="Edit Department"
                        >
                            <i class="bi bi-pencil"></i>
                        </button>


                        <button
                            type="button"
                            class="action-btn delete"
                            data-id="${data}"
                            title="Delete Department"
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

    $('#departmentSearch').on('keyup', function () {

        table.search(this.value).draw();

    });


      $(document).on(
        'submit',
        '#addDepartmentForm',
        function (e) {

            e.preventDefault();


            var department_name = $('#department_name').val();

            var department_code = $('#department_code').val();

            var campus_id = $('#campus_id').val();


            var formData = new FormData();


            formData.append(
                '_token',
                $('meta[name="csrf-token"]').attr('content')
            );


            formData.append(
                'department_name',
                department_name
            );


            formData.append(
                'department_code',
                department_code
            );


            formData.append(
                'campus_id',
                campus_id
            );


            $.ajax({

                url: "{{ route('department.store') }}",

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

                            title: 'Department Added!'

                        });


                        bootstrap.Modal.getOrCreateInstance(
                            document.getElementById('addDepartmentModal')
                        ).hide();


                        $('#addDepartmentForm').trigger('reset');


                        table.ajax.reload(null, false);

                    }


                    /*
                    ALREADY EXISTS
                    */

                    else if (data == 0) {


                        Toast.fire({

                            icon: 'error',

                            title: 'Department Already Exists!'

                        });

                    }


                    /*
                    ERROR
                    */

                    else {


                        Toast.fire({

                            icon: 'error',

                            title: 'Department Not Saved!'

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



    /*
    ============================================
    EDIT DEPARTMENT
    ============================================
    */

    $(document).on(
        'click',
        '.edit',
        function () {


            var id = $(this).data('id');


            $.ajax({

                url: "{{ route('department.edit', ':id') }}"
                    .replace(':id', id),

                type: "GET",


                success: function (data) {


                    if (data == false) {


                        Toast.fire({

                            icon: 'error',

                            title: 'Department not found!'

                        });


                        return;

                    }


                    /*
                    SET FORM VALUES
                    */

                    $('#department_id').val(
                        data.department_id
                    );


                    $('#department_name_edit').val(
                        data.department_name
                    );


                    $('#department_code_edit').val(
                        data.department_code
                    );


                    $('#campus_id_edit').val(
                        data.fk_campus_id
                    );


                    /*
                    OPEN MODAL
                    */

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('editDepartmentModal')
                    ).show();

                },


                error: function () {

                    Toast.fire({

                        icon: 'error',

                        title: 'Unable to load department!'

                    });

                }

            });

        }

    );



    /*
    ============================================
    UPDATE DEPARTMENT
    ============================================
    */

    $(document).on(
        'submit',
        '#updateDepartmentForm',
        function (e) {

            e.preventDefault();


            var id = $('#department_id').val();


            var route = "{{ route('department.update', ':id') }}";

            route = route.replace(':id', id);


            var formData = new FormData();


            formData.append(

                '_token',

                $('meta[name="csrf-token"]').attr('content')

            );


            formData.append(

                'department_name',

                $('#department_name_edit').val()

            );


            formData.append(

                'department_code',

                $('#department_code_edit').val()

            );


            formData.append(

                'campus_id',

                $('#campus_id_edit').val()

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

                            title: 'Department Updated!'

                        });


                        bootstrap.Modal.getOrCreateInstance(
                            document.getElementById('editDepartmentModal')
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

                            title: 'Department Not Updated!'

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



    /*
    ============================================
    DELETE DEPARTMENT
    ============================================
    */

$(document).on(
    'click',
    '.delete',
    function () {

        var id = $(this).data('id');


        /*
        ============================================
        SWEETALERT CONFIRMATION
        ============================================
        */

        Swal.fire({

           title: 'Are you sure you?',
           showDenyButton: true,

           confirmButtonText: 'Delete',
           denyButtonText: `Don't Delete`,

        }).then((result) => {


            /*
            ============================================
            CONFIRMED DELETE
            ============================================
            */

            if (result.isConfirmed) {


                var route = "{{ route('department.destroy', ':id') }}";

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
                                title: 'Department Deleted!'
                            })



                            table.ajax.reload(null, false);

                        }


                        /*
                        DELETE FAILED
                        */

                        else {


                             Toast.fire({
                        icon: 'error',
                        title: 'Department Deleted!'
                    })

                        }

                    },


                    /*
                    AJAX ERROR
                    */

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
