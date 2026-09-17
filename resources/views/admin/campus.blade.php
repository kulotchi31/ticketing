<x-admin-layout>

@push('styles')
<style>

        /* =========================================
           PAGE
        ========================================= */

        .campus-page {
            padding: 8px;
        }


        /* =========================================
           HEADER
        ========================================= */

        .campus-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .campus-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .campus-header-icon {
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

        .campus-title {
            margin: 0;

            font-size: 21px;
            font-weight: 700;

            color: #111827;

            letter-spacing: -.3px;
        }

        .campus-subtitle {
            margin: 4px 0 0;

            font-size: 13px;

            color: #6b7280;
        }


        /* =========================================
           ADD BUTTON
        ========================================= */

        .btn-add-campus {
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

        .btn-add-campus:hover {
            background: #1d4ed8;
            color: #fff;

            transform: translateY(-1px);

            box-shadow: 0 10px 20px rgba(37, 99, 235, .25);
        }


        /* =========================================
           MAIN CARD
        ========================================= */

        .campus-card {

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

        .campus-toolbar {

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 20px 24px;

            border-bottom: 1px solid #eef1f5;
        }

        .campus-toolbar-title {
            font-size: 15px;
            font-weight: 700;

            color: #1f2937;

            margin-bottom: 2px;
        }

        .campus-toolbar-description {
            font-size: 12px;
            color: #9ca3af;
        }


        /* =========================================
           CUSTOM SEARCH
        ========================================= */

        .campus-search {
            position: relative;
        }

        .campus-search i {
            position: absolute;

            top: 50%;
            left: 13px;

            transform: translateY(-50%);

            color: #9ca3af;

            font-size: 14px;
        }

        .campus-search input {

            width: 240px;

            height: 38px;

            border: 1px solid #e5e7eb;

            border-radius: 9px;

            padding: 0 14px 0 38px;

            font-size: 13px;

            outline: none;

            transition: all .2s ease;
        }

        .campus-search input::placeholder {
            color: #b0b7c3;
        }

        .campus-search input:focus {

            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .10);
        }


        /* =========================================
           TABLE
        ========================================= */

        .campus-table {
            width: 100% !important;

            border-collapse: collapse !important;

            margin: 0 !important;
        }


        /* HEADER */

        .campus-table thead th {

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


        /* BODY */

        .campus-table tbody td {

            padding: 16px 24px !important;

            font-size: 14px;

            color: #334155;

            border-bottom: 1px solid #f0f2f5 !important;

            vertical-align: middle;
        }


        .campus-table tbody tr {

            transition: all .15s ease;
        }


        .campus-table tbody tr:hover {

            background: #f8fbff;
        }


        .campus-table tbody tr:last-child td {

            border-bottom: none !important;
        }


        /* =========================================
           CAMPUS NAME
        ========================================= */

        .campus-name {

            display: flex;
            align-items: center;

            gap: 12px;

            font-weight: 600;

            color: #1f2937;
        }

        .campus-avatar {

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
           CAMPUS CODE
        ========================================= */

        .campus-code {

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
           DATATABLES CUSTOMIZATION
        ========================================= */

        .dataTables_wrapper {

            padding: 0 !important;
        }


        /* Hide Default Search */

        .dataTables_filter {
            display: none !important;
        }


        /* Hide Default Length */

        .dataTables_length {
            display: none !important;
        }


        /* Bottom Area */

        .dataTables_info {

            padding: 18px 24px !important;

            font-size: 12px !important;

            color: #94a3b8 !important;
        }


        .dataTables_paginate {

            padding: 12px 20px !important;
        }


        /* Pagination Buttons */

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
           EMPTY TABLE
        ========================================= */

        .dataTables_empty {

            padding: 60px !important;

            text-align: center !important;

            color: #94a3b8 !important;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 768px) {

            .campus-header {

                align-items: flex-start;

                flex-direction: column;

                gap: 16px;
            }


            .btn-add-campus {

                width: 100%;

                justify-content: center;
            }


            .campus-toolbar {

                flex-direction: column;

                align-items: flex-start;

                gap: 15px;
            }


            .campus-search input {

                width: 100%;
            }


            .campus-search {

                width: 100%;
            }

        }

</style>
@endpush


<div class="campus-page">

    <!-- =====================================
         PAGE HEADER
    ====================================== -->

    <div class="campus-header">

        <div class="campus-header-left">

            <div class="campus-header-icon">
                <i class="bi bi-bank"></i>
            </div>

            <div>
                <h4 class="campus-title">
                    Campus Management
                </h4>

                <p class="campus-subtitle">
                    Manage and organize university campuses
                </p>
            </div>

        </div>


        <!-- ADD CAMPUS BUTTON -->
        <button
            type="button"
            class="btn-add-campus"
            id="btnAddCampus"
            data-bs-toggle="modal"
            data-bs-target="#addCampusModal"
        >

            <i class="bi bi-plus-lg"></i>

            Add Campus

        </button>

    </div>



    <!-- =====================================
         CAMPUS CARD
    ====================================== -->

    <div class="campus-card">


        <!-- TOOLBAR -->

        <div class="campus-toolbar">

            <div>

                <div class="campus-toolbar-title">
                    Campus Directory
                </div>

                <div class="campus-toolbar-description">
                    View and manage all registered campuses
                </div>

            </div>


            <!-- CUSTOM SEARCH -->

            <div class="campus-search">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="campusSearch"
                    placeholder="Search campus..."
                >

            </div>

        </div>



        <!-- TABLE -->

        <div class="table-responsive">

            <table
                id="campusTable"
                class="campus-table">

                <thead>

                    <tr>

                        <th>
                            Campus Name
                        </th>

                        <th>
                            Campus Code
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




<!-- ADD CAMPUS MODAL -->
<div
    class="modal fade"
    id="addCampusModal"
    tabindex="-1"
    aria-labelledby="addCampusModalLabel"
    aria-hidden="true"
>

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">


                    <!-- MODAL HEADER -->
                    <div class="modal-header">

                        <h5
                            class="modal-title"
                            id="addCampusModalLabel"
                        >

                            <i class="bi bi-bank me-2"></i>

                            Add Campus

                        </h5>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>

        <form
            id="addForm"
            action="javascript:void(0);"
            method="POST"
        >

            @csrf


            <!-- MODAL BODY -->
            <div class="modal-body">


                <!-- CAMPUS NAME -->
                <div class="mb-3">

                    <label
                        for="campus_name"
                        class="form-label"
                    >
                        Campus Name
                    </label>


                    <input
                        type="text"
                        class="form-control"
                        id="campus_name"
                        name="campus_name"
                        placeholder="Enter campus name"
                        required
                    >


                    <div
                        id="campus_name_error"
                        class="invalid-feedback"
                        style="display: none;"
                    ></div>

                </div>


                <!-- CAMPUS CODE -->
                <div class="mb-3">

                    <label
                        for="campus_code"
                        class="form-label"
                    >
                        Campus Code
                    </label>


                    <input
                        type="text"
                        class="form-control"
                        id="campus_code"
                        name="campus_code"
                        placeholder="Enter campus code"
                        required
                    >


                    <div
                        id="campus_code_error"
                        class="invalid-feedback"
                        style="display: none;"
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
                    id="btnSaveCampus"
                >

                    <i class="bi bi-save me-1"></i>

                    Save Campus

                </button>

            </div>


        </form>


                </div>

            </div>

</div>




<!-- EDIT CAMPUS MODAL -->
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

                    Edit Campus

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
            >

                @csrf


                <!-- HIDDEN CAMPUS ID -->
                <input
                    type="hidden"
                    id="id"
                    name="id"
                >


                <!-- MODAL BODY -->
                <div class="modal-body">


                    <!-- CAMPUS NAME -->
                    <div class="mb-3">

                        <label
                            for="campus_name_edit"
                            class="form-label"
                        >
                            Campus Name
                        </label>


                        <input
                            type="text"
                            class="form-control"
                            id="campus_name_edit"
                            name="campus_name"
                            placeholder="Enter campus name"
                            required
                        >


                        <!-- VALIDATION ERROR -->
                        <div
                            id="campus_editname_error"
                            class="invalid-feedback"
                            style="display: none;"
                        ></div>

                    </div>



                    <!-- CAMPUS CODE -->
                    <div class="mb-3">

                        <label
                            for="campus_code_edit"
                            class="form-label"
                        >
                            Campus Code
                        </label>


                        <input
                            type="text"
                            class="form-control"
                            id="campus_code_edit"
                            name="campus_code"
                            placeholder="Enter campus code"
                            required
                        >


                        <!-- VALIDATION ERROR -->
                        <div
                            id="campus_editcode_error"
                            class="invalid-feedback"
                            style="display: none;"
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
                        id="btnUpdateCampus"
                    >

                        <i class="bi bi-check-lg me-1"></i>

                        Update Campus

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

    var table = $('#campusTable').DataTable({

        processing: true,

        serverSide: false,

        paging: true,

        pageLength: 10,


        ajax: {

            url: "{{ route('admin.campus') }}",

            type: "POST",

            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            }

        },


        columns: [

            {

                data: "campus_name",

                render: function(data) {

                    return `

                        <div class="campus-name">

                            <div class="campus-avatar">

                                <i class="bi bi-bank"></i>

                            </div>

                            <span>${data}</span>

                        </div>

                    `;

                }

            },


            {

                data: "campus_code",

                render: function(data) {

                    return `

                        <span class="campus-code">

                            ${data}

                        </span>

                    `;

                }

            },


            {

                data: "campus_id",

                orderable: false,

                searchable: false,

                className: "text-end",

                render: function(data) {

                    return `

                        <div class="action-buttons">

                            <button
                                type="button" name="edit"
                                class="action-btn edit"
                                data-id="${data}"
                                title="Edit Campus">

                                <i class="bi bi-pencil"></i>

                            </button>


                            <button
                                type="button"
                                class="action-btn" name="delete"
                                data-id="${data}"
                                title="Delete Campus">

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

    $('#campusSearch').on('keyup', function () {

        table.search(this.value).draw();

    });



    /* =====================================
       RESET ADD FORM WHEN MODAL CLOSES
    ====================================== */

    $('#addCampusModal').on('hidden.bs.modal', function () {

        $('#addCampusForm')[0].reset();

    });



        $(document).on("submit", "#addForm", function () {

        const modalElement = document.getElementById('addCampusModal');

        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);





         var campus_name = $("#campus_name").val();
         var campus_code = $("#campus_code").val();




         var formData = new FormData();
         formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
         formData.append("campus_name", campus_name);
         formData.append("campus_code", campus_code);



         $.ajax({
            url: "{{ route('campus.store') }}",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {

                if (data == true) {



                    Toast.fire({
                        icon: 'success',
                        title: 'Campus Added!',
                    });

                    modal.hide();
                    $("#campus_name_error").text(""),
                    $('#campus_name_error').hide(), 
                    $('#campus_name').removeClass('is-invalid') 
                    $("#campus_code_error").text(""),
                    $('#campus_code_error').hide(), 
                    $('#campus_code').removeClass('is-invalid') 

                    $("#addForm").trigger("reset");
                    table.ajax.reload();

                }

                else if(data == 3)
                {

                  $('#addModal').modal('hide');
                  Toast.fire({
                    icon: 'error',
                    title: 'Campus Not Saved!',
                });


              }

              else if(data == 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'Campus Not Saved!',
                });

            }

            else {

                var campusNameError = data.errors && data.errors.campus_name && data.errors.campus_name[0];
                var campusCodeError = data.errors && data.errors.campus_code && data.errors.campus_code[0];

                campusNameError ?    (
                    $("#campus_name_error").text(data.errors.campus_name[0]),
                    $('#campus_name_error').show(), 
                    $('#campus_name').addClass('is-invalid') 
                    )  
                : 
                (
                    $("#campus_name_error").text(""),
                    $('#campus_name_error').hide(), 
                    $('#campus_name').removeClass('is-invalid') 
                    )

                campusCodeError ? 
                (
                    $("#campus_code_error").text(data.errors.campus_code[0]),
                    $('#campus_code_error').show(), 
                    $('#campus_code').addClass('is-invalid') 
                    )  
                :
                (
                    $("#campus_code_error").text(""),
                    $('#campus_code_error').hide(), 
                    $('#campus_code').removeClass('is-invalid') 
                    )

            }
        }
    })
     })



         $(document).on("click", "button[name='edit']", function () {

          

            var id = $(this).data('id');
            var route = "{{ route('campus.edit', ':id')}}";
            route = route.replace(':id', id);



            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('exampleEditModal')
                ).show();


            $.ajax({
                url: route,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {



                    $("#id").val(data.data[0]["campus_id"]);


                    $("#campus_name_edit").val(data.data[0]["campus_name"]);
                    $("#campus_code_edit").val(data.data[0]["campus_code"]);
              

                    
                }
            })
        }),
        $(document).on("submit", "#updateForm", function () {


            var id = $("#id").val();
            var campus_name = $("#campus_name_edit").val();
            var campus_code = $("#campus_code_edit").val();
     

            var route = "{{ route('campus.update', ':id')}}";
            route = route.replace(':id', id);



            var formData = new FormData();
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("campus_name",campus_name);
            formData.append("campus_code",campus_code); 
            formData.append("_method", 'PUT');


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
                            title: 'Campus Updated!',
                        });


                        


                        table.ajax.reload();
                        $('#exampleEditModal').modal('hide');

                    } else if (data == '3') {

                        Toast.fire({
                            icon: 'error',
                            title: 'Campus Not Updated!',
                        });


                    }

                    else if(data == 0) {
                        Toast.fire({
                            icon: 'error',
                            title: 'No Changes Founds!',
                        });

                    }

                 else {
                   

                            
                        var campusNameError = data.errors && data.errors.campus_name && data.errors.campus_name[0];
                        var campusCodeError = data.errors && data.errors.campus_code && data.errors.campus_code[0];

                        campusNameError ?    (
                            $("#campus_editname_error").text(data.errors.campus_name[0]),
                            $('#campus_editname_error').show(), 
                            $('#campus_name_edit').addClass('is-invalid') 
                        )  
                        : 
                        (
                            $("#campus_editname_error").text(""),
                            $('#campus_editname_error').hide(), 
                            $('#campus_name_edit').removeClass('is-invalid') 
                        )
                 
                        campusCodeError ? 
                        (
                            $("#campus_editcode_error").text(data.errors.campus_code[0]),
                            $('#campus_editcode_error').show(), 
                            $('#campus_code_edit').addClass('is-invalid') 
                        )  
                        :
                        (
                            $("#campus_editcode_error").text(""),
                            $('#campus_editcode_error').hide(), 
                            $('#campus_code_edit').removeClass('is-invalid') 
                        )


                    }

                }
            })

        });




        $(document).on("click", "button[name='delete']", function () {


             var id = $(this).data('id');

            var route = "{{ route('campus.destroy', ':id')}}";
            route = route.replace(':id', id);

            var formData = new FormData();
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("_method", 'DELETE');

            Swal.fire({
                title: 'Are you sure you?',
                showDenyButton: true,

                confirmButtonText: 'Delete',
                denyButtonText: `Don't Delete`,
            }).then((result) => {

                if (result.isConfirmed) {


                    $.ajax({

                        url: route,
                        contentType: false,
                        processData: false,
                        type: "POST",
                        data: formData,
                        success: function (data) {
                            if (data == 1) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Campus Deleted!'
                                })


                                table.ajax.reload();
                            }

                        }



                    })

                }

                else if (result.isDenied) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Not Deleted!'
                    })

                }







            });

        });


        $('#exampleEditModal').on('hidden.bs.modal', function (e) {

            $("#campus_editname_error").text(""),
            $('#campus_editname_error').hide(), 
            $('#campus_name_edit').removeClass('is-invalid') 
            $("#campus_editcode_error").text(""),
            $('#campus_editcode_error').hide(), 
            $('#campus_code_edit').removeClass('is-invalid') 



        });





});

</script>

@endpush

</x-admin-layout>