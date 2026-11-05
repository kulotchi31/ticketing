
<x-admin-layout>

    <div class="container-fluid py-4">

        <!-- PAGE HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-shield-check me-2"></i>
                    Audit Logs
                </h4>

                <p class="text-muted mb-0">
                    Monitor and review system activities and transactions.
                </p>
            </div>

            <button class="btn btn-outline-primary" id="refreshAudit">
                <i class="bi bi-arrow-clockwise me-1"></i>
                Refresh
            </button>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">Total Activities</div>
                        <h3 class="fw-bold mb-0" id="totalLogs">0</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">Create Actions</div>
                        <h3 class="fw-bold text-success mb-0" id="createLogs">0</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">Update Actions</div>
                        <h3 class="fw-bold text-primary mb-0" id="updateLogs">0</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">Delete Actions</div>
                        <h3 class="fw-bold text-danger mb-0" id="deleteLogs">0</h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- AUDIT TABLE -->
        <div class="card border-0 shadow-sm">

            <!-- SEARCH AND FILTER -->
            <div class="card-header bg-white py-3">
                <div class="row g-2 align-items-center">

                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                class="form-control"
                                id="searchAudit"
                                placeholder="Search user, action, target..."
                            >
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select class="form-select" id="filterAction">
                            <option value="">All Actions</option>
                            <option value="CREATE">Create</option>
                            <option value="UPDATE">Update</option>
                            <option value="DELETE">Delete</option>
                            <option value="LOGIN">Login</option>
                            <option value="LOGOUT">Logout</option>
                        </select>
                    </div>

                    <div class="col-md-4 text-md-end">
                        <span class="text-muted small">
                            Showing <span id="showingCount">0</span> records
                        </span>
                    </div>

                </div>
            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Action</th>
                            <th>Target ID</th>
                            <th>Transaction Date</th>
                            <th class="text-center">Details</th>
                        </tr>
                    </thead>

                    <tbody id="auditTableBody">
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="spinner-border text-primary"></div>
                                <p class="text-muted mt-2 mb-0">
                                    Loading audit logs...
                                </p>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

            <!-- PAGINATION -->
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">

                <small class="text-muted" id="paginationInfo"></small>

                <div class="btn-group">
                    <button
                        class="btn btn-outline-secondary btn-sm"
                        id="prevPage"
                    >
                        Previous
                    </button>

                    <button
                        class="btn btn-outline-secondary btn-sm"
                        id="nextPage"
                    >
                        Next
                    </button>
                </div>

            </div>

        </div>

    </div>

    <!-- AUDIT DETAILS MODAL -->
    <div class="modal fade" id="auditDetailsModal" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Audit Details
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>

                <div class="modal-body">

                    <div class="row g-3 mb-3">

                        <div class="col-md-6">
                            <small class="text-muted">User ID</small>
                            <h6 id="modalUser"></h6>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Action Type</small>
                            <h6 id="modalAction"></h6>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Target ID</small>
                            <h6 id="modalTarget"></h6>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Transaction Date</small>
                            <h6 id="modalDate"></h6>
                        </div>

                    </div>

                    <hr>

                    <h6 class="fw-bold">Payload / Changes</h6>

                    <pre
                        class="bg-light border rounded p-3"
                        id="modalPayload"
                        style="max-height:350px; overflow:auto; white-space:pre-wrap;"
                    ></pre>

                </div>

                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                </div>

            </div>

        </div>

    </div>

    @push('scripts')

    <script>

        let auditLogs = [];
        let currentPage = 1;
        const perPage = 10;

        // ==========================================
        // NORMALIZE ACTION TYPE
        // ==========================================

        function getActionGroup(action) {

            const type = String(action || '').trim().toUpperCase();

            if (type.startsWith('CREATE')) return 'CREATE';
            if (type.startsWith('UPDATE')) return 'UPDATE';
            if (type.startsWith('DELETE')) return 'DELETE';
            if (type.startsWith('LOGIN')) return 'LOGIN';
            if (type.startsWith('LOGOUT')) return 'LOGOUT';

            return type;
        }

        // ==========================================
        // ESCAPE HTML
        // ==========================================

        function escapeHtml(value) {

            return String(value ?? '').replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[char]);

        }

        // ==========================================
        // LOAD AUDIT LOGS
        // ==========================================

        function loadAuditLogs() {

            $('#auditTableBody').html(`
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="spinner-border text-primary"></div>
                        <p class="text-muted mt-2">
                            Loading audit logs...
                        </p>
                    </td>
                </tr>
            `);

            $.ajax({

                url: "{{ route('admin.audit') }}",
                type: "GET",
                dataType: "json",

                success: function(response) {

                    auditLogs = Array.isArray(response.data)
                        ? response.data
                        : [];

                    currentPage = 1;

                    updateSummary();
                    renderAuditTable();

                },

                error: function(xhr) {

                    console.error(
                        'Failed to load audit logs:',
                        xhr.responseText
                    );

                    $('#auditTableBody').html(`
                        <tr>
                            <td colspan="6" class="text-center text-danger py-5">
                                <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
                                Failed to load audit logs.
                            </td>
                        </tr>
                    `);

                }

            });

        }

        // ==========================================
        // UPDATE SUMMARY CARDS
        // ==========================================

        function updateSummary() {

            $('#totalLogs').text(auditLogs.length);

            $('#createLogs').text(
                auditLogs.filter(log =>
                    getActionGroup(log.action_type) === 'CREATE'
                ).length
            );

            $('#updateLogs').text(
                auditLogs.filter(log =>
                    getActionGroup(log.action_type) === 'UPDATE'
                ).length
            );

            $('#deleteLogs').text(
                auditLogs.filter(log =>
                    getActionGroup(log.action_type) === 'DELETE'
                ).length
            );

        }

        // ==========================================
        // ACTION BADGES
        // ==========================================

        function actionBadge(action) {

            const group = getActionGroup(action);

            const badges = {
                CREATE: 'success',
                UPDATE: 'primary',
                DELETE: 'danger',
                LOGIN: 'info',
                LOGOUT: 'secondary'
            };

            const color = badges[group] || 'dark';

            return `
                <span class="badge bg-${color}">
                    ${escapeHtml(action || 'UNKNOWN')}
                </span>
            `;

        }

        // ==========================================
        // RENDER AUDIT TABLE
        // ==========================================

        function renderAuditTable() {

            const search = String(
                $('#searchAudit').val() || ''
            ).toLowerCase();

            const action = $('#filterAction').val();

            const filtered = auditLogs.filter(log => {

                const payloadText = typeof log.payload === 'string'
                    ? log.payload
                    : JSON.stringify(log.payload ?? {});

                const searchable = [

                    log.id,
                    log.audit_id,
                    log.fk_user_id,
                    log.target_id,
                    log.action_type,
                    log.transaction_date,
                    payloadText

                ].join(' ').toLowerCase();

                const matchesSearch = searchable.includes(search);

                const matchesAction = !action ||
                    getActionGroup(log.action_type) === action;

                return matchesSearch && matchesAction;

            });

            // PAGINATION
            const totalPages = Math.max(
                1,
                Math.ceil(filtered.length / perPage)
            );

            currentPage = Math.min(currentPage, totalPages);

            const start = (currentPage - 1) * perPage;

            const paginated = filtered.slice(
                start,
                start + perPage
            );

            $('#showingCount').text(paginated.length);

            $('#paginationInfo').text(
                `Page ${currentPage} of ${totalPages}`
            );

            $('#prevPage').prop(
                'disabled',
                currentPage === 1
            );

            $('#nextPage').prop(
                'disabled',
                currentPage >= totalPages
            );

            // EMPTY RECORDS
            if (paginated.length === 0) {

                $('#auditTableBody').html(`
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            No audit logs found.
                        </td>
                    </tr>
                `);

                return;

            }

            // TABLE ROWS
            let rows = '';

            paginated.forEach(log => {

                const logIndex = auditLogs.indexOf(log);

                rows += `
                    <tr>

                        <td>
                            ${escapeHtml(log.id ?? log.audit_id ?? '-')}
                        </td>

                        <td>
                            ${escapeHtml(log.fk_user_id ?? '-')}
                        </td>

                        <td>
                            ${actionBadge(log.action_type)}
                        </td>

                        <td>
                            ${escapeHtml(log.target_id ?? '-')}
                        </td>

                        <td>
                            ${escapeHtml(log.transaction_date ?? '-')}
                        </td>

                        <td class="text-center">

                            <button
                                class="btn btn-sm btn-outline-primary viewAudit"
                                data-index="${logIndex}"
                            >
                                <i class="bi bi-eye"></i>
                                View
                            </button>

                        </td>

                    </tr>
                `;

            });

            $('#auditTableBody').html(rows);

        }

        // ==========================================
        // VIEW AUDIT DETAILS
        // ==========================================

        $(document).on('click', '.viewAudit', function() {

            const index = Number($(this).attr('data-index'));

            const log = auditLogs[index];

            if (!log) {
                console.error('Audit record not found.');
                return;
            }

            $('#modalUser').text(
                log.fk_user_id ?? '-'
            );

            $('#modalAction').html(
                actionBadge(log.action_type)
            );

            $('#modalTarget').text(
                log.target_id ?? '-'
            );

            $('#modalDate').text(
                log.transaction_date ?? '-'
            );

            let payload = log.payload;

            try {

                if (typeof payload === 'string') {
                    payload = JSON.parse(payload);
                }

                $('#modalPayload').text(
                    JSON.stringify(payload ?? {}, null, 4)
                );

            } catch (error) {

                $('#modalPayload').text(
                    typeof payload === 'string'
                        ? payload
                        : 'No payload available.'
                );

            }

            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('auditDetailsModal')
            ).show();

        });

        // ==========================================
        // SEARCH AND FILTER
        // ==========================================

        $('#searchAudit, #filterAction').on('input change', function() {

            currentPage = 1;

            renderAuditTable();

        });

        // ==========================================
        // PREVIOUS PAGE
        // ==========================================

        $('#prevPage').on('click', function() {

            if (currentPage > 1) {

                currentPage--;

                renderAuditTable();

            }

        });

        // ==========================================
        // NEXT PAGE
        // ==========================================

        $('#nextPage').on('click', function() {

            currentPage++;

            renderAuditTable();

        });

        // ==========================================
        // REFRESH
        // ==========================================

        $('#refreshAudit').on('click', function() {

            loadAuditLogs();

        });

        // ==========================================
        // INITIAL LOAD
        // ==========================================

        $(document).ready(function() {

            loadAuditLogs();

        });

    </script>

    @endpush

</x-admin-layout>
