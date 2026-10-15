<x-worker>

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

       {{--  <button
            type="button"
            class="btn-add-ticket"
            data-bs-toggle="modal"
            data-bs-target="#addTicketModal">

            <i class="bi bi-plus-lg"></i>
            Add Ticket
        </button> --}}
    </div>


    <!-- MAIN CARD -->
    <div class="ticket-card">

        <!-- TOOLBAR -->
        <div class="ticket-toolbar">
            <div>
                <div class="ticket-toolbar-title">
                    Work In Progress Ticket Directory
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
                        <th>Remarks</th>
                         <th>Classification</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody></tbody>
            </table>
        </div>

    </div>
</div>



<div
    class="modal fade"
    id="editTicketModal"
    tabindex="-1"
    aria-labelledby="editTicketModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- MODAL HEADER -->
            <div class="modal-header">
                <h5 class="modal-title" id="editTicketModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>
                    Update Ticket Status
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <!-- UPDATE FORM -->
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

                    <!-- STATUS -->
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">
                            Ticket Status
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            class="form-select"
                            id="edit_status"
                            name="status"
                            required>

                            <option value="">
                                Select status
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Work In Progress">
                                Work In Progress
                            </option>

                            <option value="Completed">
                                Completed
                            </option>
                        </select>

                        <div
                            id="edit_status_error"
                            class="invalid-feedback">
                        </div>
                    </div>

                    <!-- PENDING REMARKS -->
                    <div
                        class="mb-3 d-none"
                        id="pendingRemarksContainer">

                        <label
                            for="edit_pending_remarks"
                            class="form-label">

                            Pending Remarks
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            class="form-control"
                            id="edit_pending_remarks"
                            name="pending_remarks"
                            rows="4"
                            placeholder="Enter the reason why this ticket is pending...">
                        </textarea>

                        <div
                            id="edit_pending_remarks_error"
                            class="invalid-feedback">
                        </div>
                    </div>

                    <!-- ACTION TAKEN -->
                    <div
                        class="mb-3 d-none"
                        id="CompletedRemarksContainer">

                        <label
                            for="edit_action_taken"
                            class="form-label">
                            Action Taken
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            class="form-control"
                            id="edit_action_taken"
                            name="action_taken"
                            rows="4"
                            placeholder="Enter the action taken to resolve this ticket..."></textarea>

                        <div
                            id="edit_action_taken_error"
                            class="invalid-feedback">
                        </div>
                    </div>

                </div>

                <!-- MODAL FOOTER -->
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
                        Update Status
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


     

  

    
     


        var table = $('#ticketTable').DataTable({
            processing: true,
            serverSide: false,
            paging: true,
            pageLength: 10,

            ajax: {
                url: "{{ route('worker-wip-ticket') }}",
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
                    data: "remarks",
                    defaultContent: "-"
                },

                {
                    data: "classification",
                    defaultContent: "-"
                },
                {
                    data: "status",
                    defaultContent: "-"
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
        | EDIT TICKET
        |--------------------------------------------------------------------------
        */

        $(document).on("click", "button[name='edit']", function () {
            let id = $(this).data('id');

            let route = "{{ route('worker-ticket.edit', ':id') }}";
            route = route.replace(':id', id);

            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('editTicketModal')
            ).show();

            $.ajax({
                url: route,
                method: "GET",

                success: function (response) {
                    let data = response.data;

                    $("#edit_ticket_id").val(data.ticket_id);
                    $("#edit_ticket_number").val(data.ticket_number);
                    $("#edit_remarks").val(data.remarks);

                    $("#edit_status").val(data.status);
                    $("#edit_pending_remarks").val(data.pending_remarks ?? "");
                    $("#edit_action_taken").val(data.action_taken ?? "");

                    toggleTicketStatusFields();

               
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

            let route = "{{ route('worker-ticket.update', ':id') }}";
            route = route.replace(':id', id);

            let formData = new FormData(this);
            formData.append("_method", "PUT");

            $.ajax({
                url: route,
                method: "POST",
                contentType: false,
                processData: false,
                data: formData,

                success: function (data) {
                    if (data.success == true) {
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


        function toggleTicketStatusFields() {
            const status = $('#edit_status').val();

            const pendingContainer = $('#pendingRemarksContainer');
            const pendingInput = $('#edit_pending_remarks');

            const completedContainer = $('#CompletedRemarksContainer');
            const actionTakenInput = $('#edit_action_taken');

            // Pending Remarks
            if (status === 'Pending') {
                pendingContainer.removeClass('d-none');
                pendingInput.prop('required', true);
            } else {
                pendingContainer.addClass('d-none');
                pendingInput.prop('required', false);
                pendingInput.removeClass('is-invalid');
                $('#edit_pending_remarks_error').text('');
            }

            // Action Taken
            if (status === 'Completed') {
                completedContainer.removeClass('d-none');
                actionTakenInput.prop('required', true);
            } else {
                completedContainer.addClass('d-none');
                actionTakenInput.prop('required', false);
                actionTakenInput.removeClass('is-invalid');
                $('#edit_action_taken_error').text('');
            }
        }

        // Toggle conditional fields when status changes
        $('#edit_status').on('change', function () {
            toggleTicketStatusFields();
        });

        // Reset the form when the edit modal closes
        $('#editTicketModal').on('hidden.bs.modal', function () {
            $('#updateForm')[0].reset();

            $('#pendingRemarksContainer').addClass('d-none');
            $('#CompletedRemarksContainer').addClass('d-none');

            $('#edit_pending_remarks')
                .prop('required', false)
                .removeClass('is-invalid');

            $('#edit_action_taken')
                .prop('required', false)
                .removeClass('is-invalid');

            $('#edit_status').removeClass('is-invalid');

            $('#edit_status_error').text('');
            $('#edit_pending_remarks_error').text('');
            $('#edit_action_taken_error').text('');
        });




    });
</script>
@endpush

</x-worker>