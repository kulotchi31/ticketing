<x-admin-layout>

@push('styles')
<style>
    .provider-page {
        padding: 8px;
    }

    .provider-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .provider-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .provider-header-icon {
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

    .provider-title {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #111827;
        letter-spacing: -.3px;
    }

    .provider-subtitle {
        margin: 4px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .btn-add-provider {
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

    .btn-add-provider:hover {
        background: #1d4ed8;
        color: #fff;
        transform: translateY(-1px);
    }

    .provider-card {
        background: #ffffff;
        border: 1px solid #e9edf3;
        border-radius: 16px;
        overflow: hidden;
        box-shadow:
            0 1px 2px rgba(16, 24, 40, .02),
            0 8px 24px rgba(16, 24, 40, .04);
    }

    .provider-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #eef1f5;
    }

    .provider-toolbar-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .provider-toolbar-description {
        font-size: 12px;
        color: #9ca3af;
    }

    .provider-search {
        position: relative;
    }

    .provider-search i {
        position: absolute;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 14px;
    }

    .provider-search input {
        width: 240px;
        height: 38px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        padding: 0 14px 0 38px;
        font-size: 13px;
        outline: none;
        transition: all .2s ease;
    }

    .provider-search input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .provider-table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }

    .provider-table thead th {
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

    .provider-table tbody td {
        padding: 16px 24px !important;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f0f2f5 !important;
        vertical-align: middle;
    }

    .provider-table tbody tr {
        transition: all .15s ease;
    }

    .provider-table tbody tr:hover {
        background: #f8fbff;
    }

    .provider-table tbody tr:last-child td {
        border-bottom: none !important;
    }

    .provider-name {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        color: #1f2937;
    }

    .provider-avatar {
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

    .provider-code {
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
        .provider-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 16px;
        }

        .btn-add-provider {
            width: 100%;
            justify-content: center;
        }

        .provider-toolbar {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .provider-search,
        .provider-search input {
            width: 100%;
        }
    }
</style>
@endpush


<div class="provider-page">

    <!-- PAGE HEADER -->
    <div class="provider-header">

        <div class="provider-header-left">

            <div class="provider-header-icon">
                <i class="bi bi-person-badge"></i>
            </div>

            <div>
                <h4 class="provider-title">
                    Provider Management
                </h4>

                <p class="provider-subtitle">
                    Manage and organize registered providers
                </p>
            </div>

        </div>

        <!-- ADD PROVIDER BUTTON -->
        <button
            type="button"
            class="btn-add-provider"
            id="btnAddProvider"
            data-bs-toggle="modal"
            data-bs-target="#addProviderModal"
        >
            <i class="bi bi-plus-lg"></i>
            Add Provider
        </button>

    </div>


    <!-- PROVIDER CARD -->
    <div class="provider-card">

        <!-- TOOLBAR -->
        <div class="provider-toolbar">

            <div>
                <div class="provider-toolbar-title">
                    Provider Directory
                </div>

                <div class="provider-toolbar-description">
                    View and manage all registered providers
                </div>
            </div>

            <!-- CUSTOM SEARCH -->
            <div class="provider-search">
                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="providerSearch"
                    placeholder="Search provider..."
                >
            </div>

        </div>


        <!-- TABLE -->
        <div class="table-responsive">

            <table
                id="providerTable"
                class="provider-table"
            >

                <thead>
                    <tr>
                        <th>Provider Name</th>
                        <th>Provider Code</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody></tbody>

            </table>

        </div>

    </div>

</div>


<!-- ADD PROVIDER MODAL -->
<div
    class="modal fade"
    id="addProviderModal"
    tabindex="-1"
    aria-labelledby="addProviderModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <!-- MODAL HEADER -->
            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="addProviderModalLabel"
                >
                    <i class="bi bi-person-badge me-2"></i>
                    Add Provider
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

                    <!-- PROVIDER NAME -->
                    <div class="mb-3">

                        <label
                            for="provider_name"
                            class="form-label"
                        >
                            Provider Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="provider_name"
                            name="provider_name"
                            placeholder="Enter provider name"
                            required
                        >

                        <div
                            id="provider_name_error"
                            class="invalid-feedback"
                            style="display: none;"
                        ></div>

                    </div>


                    <!-- PROVIDER CODE -->
                    <div class="mb-3">

                        <label
                            for="provider_code"
                            class="form-label"
                        >
                            Provider Code
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="provider_code"
                            name="provider_code"
                            placeholder="Enter provider code"
                            required
                        >

                        <div
                            id="provider_code_error"
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
                        id="btnSaveProvider"
                    >
                        <i class="bi bi-save me-1"></i>
                        Save Provider
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>


<!-- EDIT PROVIDER MODAL -->
<div
    class="modal fade"
    id="editProviderModal"
    tabindex="-1"
    aria-labelledby="editProviderModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <!-- MODAL HEADER -->
            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="editProviderModalLabel"
                >
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Provider
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

                <!-- HIDDEN PROVIDER ID -->
                <input
                    type="hidden"
                    id="id"
                    name="id"
                >

                <!-- MODAL BODY -->
                <div class="modal-body">

                    <!-- PROVIDER NAME -->
                    <div class="mb-3">

                        <label
                            for="provider_name_edit"
                            class="form-label"
                        >
                            Provider Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="provider_name_edit"
                            name="provider_name"
                            placeholder="Enter provider name"
                            required
                        >

                        <div
                            id="provider_editname_error"
                            class="invalid-feedback"
                            style="display: none;"
                        ></div>

                    </div>


                    <!-- PROVIDER CODE -->
                    <div class="mb-3">

                        <label
                            for="provider_code_edit"
                            class="form-label"
                        >
                            Provider Code
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="provider_code_edit"
                            name="provider_code"
                            placeholder="Enter provider code"
                            required
                        >

                        <div
                            id="provider_editcode_error"
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
                        id="btnUpdateProvider"
                    >
                        <i class="bi bi-check-lg me-1"></i>
                        Update Provider
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

    var table = $('#providerTable').DataTable({

        processing: true,
        serverSide: false,
        paging: true,
        pageLength: 10,

        ajax: {
            url: "{{ route('admin.provider') }}",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            }
        },

        columns: [

            {
                data: "provider_name",

                render: function(data) {

                    return `
                        <div class="provider-name">

                            <div class="provider-avatar">
                                <i class="bi bi-person-badge"></i>
                            </div>

                            <span>${data}</span>

                        </div>
                    `;

                }
            },

            {
                data: "provider_code",

                render: function(data) {

                    return `
                        <span class="provider-code">
                            ${data}
                        </span>
                    `;

                }
            },

            {
                data: "provider_id",
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
                                title="Edit Provider"
                            >
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button
                                type="button"
                                name="delete"
                                class="action-btn delete"
                                data-id="${data}"
                                title="Delete Provider"
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

    $('#providerSearch').on('keyup', function () {

        table.search(this.value).draw();

    });


    /* =====================================
       RESET ADD FORM WHEN MODAL CLOSES
    ====================================== */

    $('#addProviderModal').on('hidden.bs.modal', function () {

        $('#addForm')[0].reset();

        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').hide().text('');

    });


    /* =====================================
       ADD PROVIDER
    ====================================== */

    $(document).on("submit", "#addForm", function () {

        const modalElement = document.getElementById('addProviderModal');

        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

        var provider_name = $("#provider_name").val();
        var provider_code = $("#provider_code").val();

        var formData = new FormData();

        formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
        formData.append("provider_name", provider_name);
        formData.append("provider_code", provider_code);


        $.ajax({

            url: "{{ route('provider.store') }}",

            method: "POST",

            contentType: false,
            processData: false,

            data: formData,

            success: function (data) {

                if (data == true) {

                    Toast.fire({
                        icon: 'success',
                        title: 'Provider Added!'
                    });

                    modal.hide();

                    $("#provider_name_error").text("");
                    $('#provider_name_error').hide();
                    $('#provider_name').removeClass('is-invalid');

                    $("#provider_code_error").text("");
                    $('#provider_code_error').hide();
                    $('#provider_code').removeClass('is-invalid');

                    $("#addForm").trigger("reset");

                    table.ajax.reload();

                }

                else if (data == 3) {

                    Toast.fire({
                        icon: 'error',
                        title: 'Provider Not Saved!'
                    });

                }

                else if (data == 0) {

                    Toast.fire({
                        icon: 'error',
                        title: 'Provider Not Saved!'
                    });

                }

                else {

                    var providerNameError =
                        data.errors &&
                        data.errors.provider_name &&
                        data.errors.provider_name[0];

                    var providerCodeError =
                        data.errors &&
                        data.errors.provider_code &&
                        data.errors.provider_code[0];


                    providerNameError
                        ? (
                            $("#provider_name_error").text(providerNameError),
                            $('#provider_name_error').show(),
                            $('#provider_name').addClass('is-invalid')
                        )
                        :
                        (
                            $("#provider_name_error").text(""),
                            $('#provider_name_error').hide(),
                            $('#provider_name').removeClass('is-invalid')
                        );


                    providerCodeError
                        ?
                        (
                            $("#provider_code_error").text(providerCodeError),
                            $('#provider_code_error').show(),
                            $('#provider_code').addClass('is-invalid')
                        )
                        :
                        (
                            $("#provider_code_error").text(""),
                            $('#provider_code_error').hide(),
                            $('#provider_code').removeClass('is-invalid')
                        );

                }

            }

        });

    });


    /* =====================================
       EDIT PROVIDER
    ====================================== */

    $(document).on("click", "button[name='edit']", function () {

        var id = $(this).data('id');

        var route = "{{ route('provider.edit', ':id') }}";

        route = route.replace(':id', id);


        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('editProviderModal')
        ).show();


        $.ajax({

            url: route,

            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            success: function (data) {

                $("#id").val(data.data[0]["provider_id"]);

                $("#provider_name_edit")
                    .val(data.data[0]["provider_name"]);

                $("#provider_code_edit")
                    .val(data.data[0]["provider_code"]);

            }

        });

    });


    /* =====================================
       UPDATE PROVIDER
    ====================================== */

    $(document).on("submit", "#updateForm", function () {

        var id = $("#id").val();

        var provider_name = $("#provider_name_edit").val();

        var provider_code = $("#provider_code_edit").val();


        var route = "{{ route('provider.update', ':id') }}";

        route = route.replace(':id', id);


        var formData = new FormData();

        formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

        formData.append("provider_name", provider_name);

        formData.append("provider_code", provider_code);

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
                        title: 'Provider Updated!'
                    });

                    table.ajax.reload();

                    $('#editProviderModal').modal('hide');

                }

                else if (data == '3') {

                    Toast.fire({
                        icon: 'error',
                        title: 'Provider Not Updated!'
                    });

                }

                else if (data == 0) {

                    Toast.fire({
                        icon: 'error',
                        title: 'No Changes Found!'
                    });

                }

                else {

                    var providerNameError =
                        data.errors &&
                        data.errors.provider_name &&
                        data.errors.provider_name[0];

                    var providerCodeError =
                        data.errors &&
                        data.errors.provider_code &&
                        data.errors.provider_code[0];


                    providerNameError
                        ?
                        (
                            $("#provider_editname_error").text(providerNameError),
                            $('#provider_editname_error').show(),
                            $('#provider_name_edit').addClass('is-invalid')
                        )
                        :
                        (
                            $("#provider_editname_error").text(""),
                            $('#provider_editname_error').hide(),
                            $('#provider_name_edit').removeClass('is-invalid')
                        );


                    providerCodeError
                        ?
                        (
                            $("#provider_editcode_error").text(providerCodeError),
                            $('#provider_editcode_error').show(),
                            $('#provider_code_edit').addClass('is-invalid')
                        )
                        :
                        (
                            $("#provider_editcode_error").text(""),
                            $('#provider_editcode_error').hide(),
                            $('#provider_code_edit').removeClass('is-invalid')
                        );

                }

            }

        });

    });


    /* =====================================
       DELETE PROVIDER
    ====================================== */

    $(document).on("click", "button[name='delete']", function () {

        var id = $(this).data('id');

        var route = "{{ route('provider.destroy', ':id') }}";

        route = route.replace(':id', id);


        var formData = new FormData();

        formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

        formData.append("_method", 'DELETE');


        Swal.fire({

            title: 'Are you sure you want to delete this provider?',

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

                        if (data == 1) {

                            Toast.fire({
                                icon: 'success',
                                title: 'Provider Deleted!'
                            });

                            table.ajax.reload();

                        }

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

    });


    /* =====================================
       RESET EDIT FORM WHEN MODAL CLOSES
    ====================================== */

    $('#editProviderModal').on('hidden.bs.modal', function () {

        $("#provider_editname_error").text("");
        $('#provider_editname_error').hide();
        $('#provider_name_edit').removeClass('is-invalid');

        $("#provider_editcode_error").text("");
        $('#provider_editcode_error').hide();
        $('#provider_code_edit').removeClass('is-invalid');

    });

});
</script>

@endpush

</x-admin-layout>