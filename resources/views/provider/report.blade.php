<x-provider>

@push('styles')
<style>
    .report-page { padding: 8px; }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .report-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .report-header-icon {
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

    .report-title {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #111827;
        letter-spacing: -.3px;
    }

    .report-subtitle {
        margin: 4px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .report-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .02), 0 8px 24px rgba(16, 24, 40, .04);
        margin-bottom: 20px;
    }

    .filter-panel {
        padding: 20px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #eef1f5;
    }

    .report-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid #eef1f5;
        flex-wrap: wrap;
        gap: 12px;
    }

    .report-toolbar-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .report-toolbar-description {
        font-size: 12px;
        color: #9ca3af;
    }

    .report-search { position: relative; }

    .report-search i {
        position: absolute;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 14px;
    }

    .report-search input {
        width: 260px;
        height: 38px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        padding: 0 14px 0 38px;
        font-size: 13px;
        outline: none;
        transition: all .2s ease;
    }

    .report-search input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .report-table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }

    .report-table thead th {
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

    .report-table tbody td {
        padding: 16px 20px !important;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f0f2f5 !important;
        vertical-align: middle;
    }

    .report-table tbody tr:hover { background: #f8fbff; }
    .report-table tbody tr:last-child td { border-bottom: none !important; }

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
        .report-search, .report-search input { width: 100%; }
    }
</style>
@endpush

<div class="report-page">
    <!-- PAGE HEADER -->
    <div class="report-header">
        <div class="report-header-left">
            <div class="report-header-icon">
                <i class="bi bi-file-earmark-bar-graph"></i>
            </div>
            <div>
                <h4 class="report-title">Service Ticket Reports</h4>
                <p class="report-subtitle">Generate and filter service request reports by date range, status, and worker</p>
            </div>
        </div>

        <button type="button" class="btn btn-danger btn-sm" id="btnExportPdf" disabled>
            <i class="bi bi-file-earmark-pdf me-1"></i> Generate PDF
        </button>
    </div>

    <!-- MAIN CARD -->
    <div class="report-card">
        <!-- FILTER FORM -->
        <div class="filter-panel">
            <form id="reportFilterForm" novalidate>
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label for="date_from" class="form-label fw-semibold small text-secondary">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" max="{{ now()->format('Y-m-d') }}">
                        <div id="date_from_error" class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-2">
                        <label for="date_to" class="form-label fw-semibold small text-secondary">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" max="{{ now()->format('Y-m-d') }}">
                        <div id="date_to_error" class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label fw-semibold small text-secondary">Ticket Status</label>
                        <select class="form-select" id="status" name="status">
                            @foreach ($statuses as $statusOption)
                                <option value="{{ $statusOption }}">
                                    {{ $statusOption === 'All' ? 'All Statuses' : $statusOption }}
                                </option>
                            @endforeach
                        </select>
                        <div id="status_error" class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-3">
                        <label for="worker_id" class="form-label fw-semibold small text-secondary">Worker</label>
                        <select class="form-select" id="worker_id" name="worker_id">
                            <option value="">All Workers</option>
                            @foreach ($workers as $worker)
                                <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                            @endforeach
                        </select>
                        <div id="worker_id_error" class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1" id="btnFilterReport">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        <button type="button" class="btn btn-light border" id="btnResetReport" title="Reset Filters">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- TOOLBAR -->
        <div class="report-toolbar">
            <div>
                <div class="report-toolbar-title">
                    Report Results
                    <span class="badge bg-primary-subtle text-primary ms-2" id="totalTicketsBadge">0 tickets</span>
                </div>
                <div class="report-toolbar-description" id="filterSummaryText">Select filters above and click Filter to generate report</div>
            </div>

            <div class="report-search">
                <i class="bi bi-search"></i>
                <input type="text" id="reportSearch" placeholder="Search in results..." disabled>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table id="reportTable" class="report-table">
                <thead>
                    <tr>
                        <th>Ticket Number</th>
                        <th>Date Created</th>
                        <th>Campus</th>
                        <th>Department</th>
                        <th>Requested By</th>
                        <th>Category</th>
                        <th>Classification</th>
                        <th>Remarks</th>
                        <th>Assigned To</th>
                        <th>Action Taken</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    let hasFiltered = false;
    let currentFilteredCount = 0;

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function clearFilterErrors() {
        $('#date_from, #date_to, #status, #worker_id').removeClass('is-invalid');
        $('#date_from_error, #date_to_error, #status_error, #worker_id_error').text('').hide();
    }

    function validateDateRange() {
        clearFilterErrors();

        const dateFrom = $('#date_from').val();
        const dateTo   = $('#date_to').val();
        const today    = new Date().toISOString().split('T')[0];
        let isValid    = true;

        if (dateFrom && dateFrom > today) {
            $('#date_from').addClass('is-invalid');
            $('#date_from_error').text('Start date cannot be in the future.').show();
            isValid = false;
        }

        if (dateFrom && dateTo && dateTo < dateFrom) {
            $('#date_to').addClass('is-invalid');
            $('#date_to_error').text('End date must be on or after the start date.').show();
            isValid = false;
        }

        return isValid;
    }

    // Keep date_to min attribute synced with date_from
    $('#date_from').on('change', function () {
        const fromVal = $(this).val();
        if (fromVal) {
            $('#date_to').attr('min', fromVal);
        } else {
            $('#date_to').removeAttr('min');
        }
        validateDateRange();
    });

    $('#date_to').on('change', validateDateRange);

    // Disable PDF export whenever filter inputs change until user clicks Filter again
    $('#date_from, #date_to, #status, #worker_id').on('change', function () {
        hasFiltered = false;
        currentFilteredCount = 0;
        $('#btnExportPdf').prop('disabled', true);
    });

    function updateSummaryText() {
        const dateFrom   = $('#date_from').val();
        const dateTo     = $('#date_to').val();
        const status     = $('#status').val();
        const workerVal  = $('#worker_id').val();
        const workerText = $('#worker_id option:selected').text();

        let parts = [];
        parts.push(status === 'All' ? 'Status: All' : `Status: ${status}`);
        parts.push(workerVal ? `Worker: ${workerText}` : 'Worker: All');

        if (dateFrom && dateTo) {
            parts.push(`From ${dateFrom} to ${dateTo}`);
        } else if (dateFrom) {
            parts.push(`From ${dateFrom} onwards`);
        } else if (dateTo) {
            parts.push(`Up to ${dateTo}`);
        } else {
            parts.push('All dates');
        }

        $('#filterSummaryText').text(parts.join(' • '));
    }

    // Initialize DataTable with deferLoading: 0 so nothing is fetched on page load
    const table = $('#reportTable').DataTable({
        processing: true,
        serverSide: true,
        deferLoading: 0,
        paging: true,
        pageLength: 15,
        order: [],
        language: {
            emptyTable: 'No report generated yet. Select filters above and click Filter.'
        },
        ajax: {
            url: "{{ route('report-provider.data') }}",
            type: 'GET',
            data: function (d) {
                d.date_from = $('#date_from').val();
                d.date_to   = $('#date_to').val();
                d.status    = $('#status').val();
                d.worker_id = $('#worker_id').val();
            },
            dataSrc: function (json) {
                const total = json.recordsFiltered ?? 0;
                currentFilteredCount = total;

                $('#totalTicketsBadge').text(`${total} ${total === 1 ? 'ticket' : 'tickets'}`);
                $('#btnExportPdf').prop('disabled', total === 0);

                return json.data || [];
            },
            error: function (xhr) {
                currentFilteredCount = 0;
                $('#btnExportPdf').prop('disabled', true);

                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + '_error').text(messages[0]).show();
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message || 'Unable to load report data.'
                    });
                }
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row) {
                    return escapeHtml(row.ticket_number || ('#' + row.ticket_id));
                }
            },
            {
                data: 'created_at',
                defaultContent: '-',
                render: function (data) {
                    if (!data) return '-';
                    return escapeHtml(String(data).substring(0, 10));
                }
            },
            { data: 'department.campus.campus_name', defaultContent: '-', orderable: false },
            { data: 'department.department_name', defaultContent: '-', orderable: false },
            { data: 'requested_by', defaultContent: '-' },
            { data: 'category.category_name', defaultContent: '-', orderable: false },
            { data: 'classification', defaultContent: '-' },
            { data: 'remarks', defaultContent: '-' },
            {
                data: 'assignee.name',
                defaultContent: 'Not assigned',
                orderable: false,
                render: function (data) {
                    return escapeHtml(data || 'Not assigned');
                }
            },
            {
                data: 'action_taken',
                defaultContent: '-',
                render: function (data) {
                    return escapeHtml(data || '-');
                }
            },
            { data: 'status', defaultContent: '-' }
        ]
    });

    // Debounced Server-Side Search (active once a filter has been submitted)
    let searchTimer;
    $('#reportSearch').on('keyup', function () {
        if (!hasFiltered) return;

        const query = this.value;
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            table.search(query).draw();
        }, 350);
    });

    // Submit Filter
    $('#reportFilterForm').on('submit', function (e) {
        e.preventDefault();

        if (!validateDateRange()) {
            return;
        }

        hasFiltered = true;
        $('#reportSearch').prop('disabled', false);
        updateSummaryText();
        table.ajax.reload();
    });

    // Reset Filter
    $('#btnResetReport').on('click', function () {
        $('#reportFilterForm')[0].reset();
        $('#date_to').removeAttr('min');
        $('#reportSearch').val('').prop('disabled', true);
        $('#btnExportPdf').prop('disabled', true);
        clearFilterErrors();

        hasFiltered = false;
        currentFilteredCount = 0;
        $('#totalTicketsBadge').text('0 tickets');
        $('#filterSummaryText').text('Select filters above and click Filter to generate report');
        table.search('').clear().draw();
    });

    // Generate PDF
    $('#btnExportPdf').on('click', function () {
        if (!hasFiltered || currentFilteredCount === 0 || !validateDateRange()) {
            return;
        }

        const params = $.param({
            date_from: $('#date_from').val(),
            date_to:   $('#date_to').val(),
            status:    $('#status').val(),
            worker_id: $('#worker_id').val()
        });

        window.open("{{ route('report-provider.pdf') }}?" + params, '_blank');
    });
});
</script>
@endpush

</x-provider>