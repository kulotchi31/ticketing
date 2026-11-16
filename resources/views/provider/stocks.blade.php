<x-provider>

@push('styles')
<style>
    .stock-page { padding: 8px; }

    .stock-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .stock-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stock-header-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: white;
        font-size: 22px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .stock-title {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stock-subtitle {
        margin: 4px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    /* Summary Cards */
    .stat-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 12px rgba(16, 24, 40, .03);
    }

    .stat-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 4px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* Main Card & Toolbar */
    .stock-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(16, 24, 40, .04);
    }

    .stock-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #eef1f5;
        gap: 16px;
        flex-wrap: wrap;
    }

    .stock-toolbar-title {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
    }

    .stock-toolbar-description {
        font-size: 12px;
        color: #9ca3af;
    }

    .toolbar-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-wrapper {
        position: relative;
        width: 250px;
        max-width: 100%;
    }

    .search-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-wrapper input {
        padding-left: 36px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }

    .search-wrapper input:focus {
        background-color: #fff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* DataTable Overrides */
    .stock-table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }

    .stock-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        padding: 14px 20px !important;
        white-space: nowrap;
        border-bottom: 1px solid #e9edf3 !important;
    }

    .stock-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .stock-table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .stock-table tbody td {
        padding: 15px 20px !important;
        font-size: 13px;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .stock-table tbody tr:last-child td {
        border-bottom: none !important;
    }

    .dt-footer-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        background: #fafbfc;
        border-top: 1px solid #eef1f5;
        flex-wrap: wrap;
        gap: 12px;
    }

    .dataTables_info {
        font-size: 12px;
        color: #64748b;
        padding-top: 0 !important;
    }

    .dataTables_length label {
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .dataTables_length select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 4px 24px 4px 10px;
        font-size: 12px;
        color: #334155;
        background-color: #fff;
    }

    .dataTables_paginate .pagination {
        margin: 0;
        gap: 4px;
    }

    .dataTables_paginate .page-item .page-link {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 12px;
    }

    .dataTables_paginate .page-item.active .page-link {
        background-color: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }

    /* Cell Badges & Elements */
    .item-name {
        font-weight: 600;
        color: #0f172a;
        font-size: 13.5px;
    }

    .item-sku {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #475569;
        font-size: 12px;
        font-weight: 500;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .status-in-stock  { background: #ecfdf5; color: #059669; }
    .status-low-stock { background: #fffbeb; color: #d97706; }
    .status-out-stock { background: #fef2f2; color: #dc2626; }

    .type-in  { background: #ecfdf5; color: #059669; }
    .type-out { background: #fef2f2; color: #dc2626; }

    /* Buttons */
    .btn-primary-custom {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 16px;
        border: 0;
        border-radius: 10px;
        background: #2563eb;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }

    .btn-primary-custom:hover {
        background: #1d4ed8;
        color: white;
        transform: translateY(-1px);
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        font-size: 11.5px;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .btn-action:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    /* Modals & Timeline */
    .modal-content {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
    }

    .modal-header {
        background: #f8fafc;
        border-bottom: 1px solid #eef1f5;
        padding: 18px 22px;
    }

    .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    .modal-body { padding: 22px; }

    .modal-footer {
        border-top: 1px solid #eef1f5;
        padding: 15px 22px;
    }

    .form-label {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }

    .form-control, .form-select {
        font-size: 13px;
        border-radius: 8px;
        padding: 10px 12px;
    }

    .history-timeline {
        border-left: 2px solid #e2e8f0;
        margin-left: 8px;
        padding-left: 22px;
    }

    .history-item {
        position: relative;
        padding-bottom: 20px;
    }

    .history-item::before {
        content: '';
        position: absolute;
        left: -29px;
        top: 4px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #2563eb;
        border: 3px solid #dbeafe;
    }

    @media(max-width:768px) {
        .stock-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 15px;
        }
        .stock-header .btn-primary-custom,
        .search-wrapper {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@php
    $code = strtoupper($providerCode ?? '');
@endphp

<div class="stock-page">

    {{-- PAGE HEADER --}}
    <div class="stock-header">
        <div class="stock-header-left">
            <div class="stock-header-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <h4 class="stock-title">
                    Stocks Monitoring
                    @if($code !== '')
                        <span class="badge bg-primary-subtle text-primary fs-6">{{ $code }}</span>
                    @endif
                </h4>
                <p class="stock-subtitle">
                    {{ $code === 'MIS'
                        ? 'Track IT hardware, peripherals, and network supplies'
                        : 'Track general services, maintenance, and facility supplies' }}
                </p>
            </div>
        </div>

        <button type="button"
                class="btn-primary-custom"
                data-bs-toggle="modal"
                data-bs-target="#addStockModal">
            <i class="bi bi-plus-lg"></i>
            Add Stock Item
        </button>
    </div>

    {{-- SUMMARY STATS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div>
                    <div class="stat-label">Total Stock Items</div>
                    <div class="stat-value" id="statTotalItems">0</div>
                </div>
                <div class="stat-icon" style="background:#eff6ff; color:#2563eb;">
                    <i class="bi bi-boxes"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div>
                    <div class="stat-label">Low Stock Alerts</div>
                    <div class="stat-value text-warning" id="statLowStock">0</div>
                </div>
                <div class="stat-icon" style="background:#fffbeb; color:#d97706;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div>
                    <div class="stat-label">Out of Stock</div>
                    <div class="stat-value text-danger" id="statOutOfStock">0</div>
                </div>
                <div class="stat-icon" style="background:#fef2f2; color:#dc2626;">
                    <i class="bi bi-x-octagon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- STOCK DIRECTORY --}}
    <div class="stock-card">
        <div class="stock-toolbar">
            <div>
                <div class="stock-toolbar-title">
                    Inventory Directory
                </div>
                <div class="stock-toolbar-description">
                    Filter by status and log incoming/outgoing stock movements
                </div>
            </div>

            <div class="toolbar-controls">
                <select id="statusFilter" class="form-select" style="width: 155px; border-radius: 10px;">
                    <option value="">All Statuses</option>
                    <option value="In Stock">In Stock</option>
                    <option value="Low Stock">Low Stock</option>
                    <option value="Out of Stock">Out of Stock</option>
                </select>

                <div class="search-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text"
                           id="stockSearch"
                           class="form-control"
                           placeholder="Search item, SKU, category...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="stockTable" class="stock-table">
                <thead>
                    <tr>
                        <th>Item Name / SKU</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>Reorder Level</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

{{-- ADD STOCK ITEM MODAL --}}
<div class="modal fade" id="addStockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-square me-2"></i>
                    Add New Stock Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="addStockForm" action="javascript:void(0);" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="item_name"
                                   name="item_name"
                                   class="form-control"
                                   placeholder="{{ $code === 'MIS' ? 'e.g., Cat6 UTP Cable Box' : 'e.g., LED Tube Light 18W' }}"
                                   required>
                            <div id="item_name_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Item Code / SKU</label>
                            <input type="text"
                                   id="sku"
                                   name="sku"
                                   class="form-control"
                                   placeholder="{{ $code === 'MIS' ? 'e.g., MIS-001' : 'e.g., BMGS-001' }}">
                            <div id="sku_error" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="">Select category</option>
                                @if($code === 'MIS')
                                    <option value="Computer Hardware">Computer Hardware</option>
                                    <option value="Peripherals & Accessories">Peripherals & Accessories</option>
                                    <option value="Networking Equipment">Networking Equipment</option>
                                    <option value="Printers & Ink/Toner">Printers & Ink/Toner</option>
                                    <option value="Cables & Adapters">Cables & Adapters</option>
                                @else
                                    <option value="Electrical & Lighting">Electrical & Lighting</option>
                                    <option value="Plumbing & Sanitary">Plumbing & Sanitary</option>
                                    <option value="Carpentry & Hardware">Carpentry & Hardware</option>
                                    <option value="Cleaning & Janitorial">Cleaning & Janitorial</option>
                                    <option value="Office & General Supplies">Office & General Supplies</option>
                                @endif
                            </select>
                            <div id="category_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit of Measure <span class="text-danger">*</span></label>
                            <select id="unit" name="unit" class="form-select" required>
                                <option value="pcs">Pieces (pcs)</option>
                                <option value="boxes">Boxes</option>
                                <option value="reams">Reams</option>
                                <option value="packs">Packs</option>
                                <option value="liters">Liters</option>
                                <option value="sets">Sets</option>
                                <option value="meters">Meters</option>
                                <option value="rolls">Rolls</option>
                            </select>
                            <div id="unit_error" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Initial Quantity <span class="text-danger">*</span></label>
                            <input type="number" id="quantity" name="quantity" class="form-control" min="0" value="0" required>
                            <div id="quantity_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Reorder Alert Level <span class="text-danger">*</span></label>
                            <input type="number" id="reorder_level" name="reorder_level" class="form-control" min="0" value="10" required>
                            <div id="reorder_level_error" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveStock">
                        <i class="bi bi-save me-1"></i> Save Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT STOCK ITEM MODAL --}}
<div class="modal fade" id="editStockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Stock Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editStockForm" action="javascript:void(0);" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_stock_id">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit_item_name" name="item_name" class="form-control" required>
                            <div id="edit_item_name_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Item Code / SKU</label>
                            <input type="text" id="edit_sku" name="sku" class="form-control">
                            <div id="edit_sku_error" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select id="edit_category" name="category" class="form-select" required>
                                <option value="">Select category</option>
                                @if($code === 'MIS')
                                    <option value="Computer Hardware">Computer Hardware</option>
                                    <option value="Peripherals & Accessories">Peripherals & Accessories</option>
                                    <option value="Networking Equipment">Networking Equipment</option>
                                    <option value="Printers & Ink/Toner">Printers & Ink/Toner</option>
                                    <option value="Cables & Adapters">Cables & Adapters</option>
                                @else
                                    <option value="Electrical & Lighting">Electrical & Lighting</option>
                                    <option value="Plumbing & Sanitary">Plumbing & Sanitary</option>
                                    <option value="Carpentry & Hardware">Carpentry & Hardware</option>
                                    <option value="Cleaning & Janitorial">Cleaning & Janitorial</option>
                                    <option value="Office & General Supplies">Office & General Supplies</option>
                                @endif
                            </select>
                            <div id="edit_category_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit of Measure <span class="text-danger">*</span></label>
                            <select id="edit_unit" name="unit" class="form-select" required>
                                <option value="pcs">Pieces (pcs)</option>
                                <option value="boxes">Boxes</option>
                                <option value="reams">Reams</option>
                                <option value="packs">Packs</option>
                                <option value="liters">Liters</option>
                                <option value="sets">Sets</option>
                                <option value="meters">Meters</option>
                                <option value="rolls">Rolls</option>
                            </select>
                            <div id="edit_unit_error" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reorder Alert Level <span class="text-danger">*</span></label>
                        <input type="number" id="edit_reorder_level" name="reorder_level" class="form-control" min="0" required>
                        <div id="edit_reorder_level_error" class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnUpdateStock">
                        <i class="bi bi-save me-1"></i> Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- STOCK ADJUSTMENT (STOCK IN / STOCK OUT) MODAL --}}
<div class="modal fade" id="adjustStockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">
                        <i class="bi bi-arrow-left-right me-2"></i>
                        Adjust Stock Quantity
                    </h5>
                    <small class="text-muted">Record incoming restock or outgoing issuance</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="adjustStockForm" action="javascript:void(0);" method="POST">
                @csrf
                <input type="hidden" name="fk_stock_id" id="adjust_stock_id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Selected Item</label>
                        <input type="text" id="adjust_item_name" class="form-control" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Movement Type <span class="text-danger">*</span></label>
                            <select name="type" id="adjust_type" class="form-select" required>
                                <option value="in">Stock In (+ Add)</option>
                                <option value="out">Stock Out (- Deduct)</option>
                            </select>
                            <div id="type_error" class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="adjust_quantity" class="form-control" min="1" required>
                            <div id="quantity_error" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Transaction Date <span class="text-danger">*</span></label>
                        <input type="date"
                               name="transaction_date"
                               id="adjust_date"
                               class="form-control"
                               max="{{ date('Y-m-d') }}"
                               value="{{ date('Y-m-d') }}"
                               required>
                        <div id="transaction_date_error" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Remarks / Reference</label>
                        <textarea name="remarks"
                                  id="adjust_remarks"
                                  class="form-control"
                                  rows="3"
                                  placeholder="e.g., Delivered by supplier or Issued to Office/Dept..."></textarea>
                        <div id="remarks_error" class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveAdjustment">
                        <i class="bi bi-check2-circle me-1"></i> Confirm Movement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- STOCK MOVEMENT HISTORY MODALS CONTAINER --}}
<div id="stockHistoryModalsContainer"></div>

@push('scripts')
<script>
$(document).ready(function () {
    let allStocksData = [];

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const options = { year: 'numeric', month: 'short', day: '2-digit' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }

    function getStockStatus(qty, reorderLevel) {
        qty = Number(qty || 0);
        reorderLevel = Number(reorderLevel || 0);

        if (qty <= 0) {
            return {
                text: 'Out of Stock',
                html: '<span class="status-badge status-out-stock"><i class="bi bi-x-circle"></i> Out of Stock</span>'
            };
        }
        if (qty <= reorderLevel) {
            return {
                text: 'Low Stock',
                html: '<span class="status-badge status-low-stock"><i class="bi bi-exclamation-circle"></i> Low Stock</span>'
            };
        }
        return {
            text: 'In Stock',
            html: '<span class="status-badge status-in-stock"><i class="bi bi-check-circle"></i> In Stock</span>'
        };
    }

    /*
    |--------------------------------------------------------------------------
    | STOCKS DATATABLE (AJAX)
    |--------------------------------------------------------------------------
    */
    const stockTable = $('#stockTable').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        ordering: true,
        order: [],
        dom: 'rt<"dt-footer-wrapper"<"d-flex align-items-center gap-3"li>p>',
        ajax: {
            url: "{{ route('stock-provider.index') }}",
            type: 'GET',
            dataSrc: function (json) {
                allStocksData = json.data || [];
                updateSummaryCards(allStocksData);
                return allStocksData;
            }
        },
        columns: [
            {
                data: 'item_name',
                render: function (data, type, row) {
                    const skuHtml = row.sku ? `<div class="item-sku">SKU: ${escapeHtml(row.sku)}</div>` : '';
                    return `
                        <div class="item-name">${escapeHtml(data)}</div>
                        ${skuHtml}
                    `;
                }
            },
            {
                data: 'category',
                render: function (data) {
                    return `<span class="category-badge"><i class="bi bi-tag text-primary"></i> ${escapeHtml(data || 'Uncategorized')}</span>`;
                }
            },
            {
                data: 'quantity',
                render: function (data, type, row) {
                    const qty = Number(data || 0);
                    const colorClass = qty <= 0 ? 'text-danger' : (qty <= row.reorder_level ? 'text-warning' : 'text-dark');
                    return `<span class="fw-bold fs-6 ${colorClass}">${qty}</span> <small class="text-muted">${escapeHtml(row.unit || 'pcs')}</small>`;
                }
            },
            {
                data: 'reorder_level',
                render: function (data, type, row) {
                    return `<span class="text-muted">${Number(data || 0)} ${escapeHtml(row.unit || 'pcs')}</span>`;
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    const status = getStockStatus(row.quantity, row.reorder_level);
                    return type === 'filter' || type === 'sort' ? status.text : status.html;
                }
            },
            {
                data: 'updated_at',
                render: function (data) {
                    return `<span class="text-muted">${formatDate(data)}</span>`;
                }
            },
            {
                data: 'stock_id',
                orderable: false,
                searchable: false,
                className: 'text-end',
                render: function (data, type, row) {
                    const logsCount = (row.stock_movements || []).length;
                    const badge = logsCount > 0 ? `<span class="badge bg-secondary ms-1">${logsCount}</span>` : '';

                    return `
                        <div class="d-flex justify-content-end gap-1">
                            <button type="button"
                                    class="btn-action text-primary btn-adjust-stock"
                                    title="Stock In / Out"
                                    data-id="${row.stock_id}"
                                    data-name="${escapeHtml(row.item_name)} (${row.quantity} ${escapeHtml(row.unit || 'pcs')})"
                                    data-bs-toggle="modal"
                                    data-bs-target="#adjustStockModal">
                                <i class="bi bi-arrow-left-right"></i> Stock In/Out
                            </button>
                            <button type="button"
                                    class="btn-action text-secondary"
                                    title="Movement Logs"
                                    data-bs-toggle="modal"
                                    data-bs-target="#stockHistoryModal${row.stock_id}">
                                <i class="bi bi-clock-history"></i> Logs ${badge}
                            </button>
                            <button type="button"
                                    class="btn-action text-info btn-edit-stock"
                                    title="Edit Item"
                                    data-id="${row.stock_id}"
                                    data-name="${escapeHtml(row.item_name)}"
                                    data-sku="${escapeHtml(row.sku || '')}"
                                    data-category="${escapeHtml(row.category || '')}"
                                    data-unit="${escapeHtml(row.unit || 'pcs')}"
                                    data-reorder="${row.reorder_level ?? 0}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button"
                                    class="btn-action text-danger btn-delete-stock"
                                    title="Delete Item"
                                    data-id="${row.stock_id}"
                                    data-name="${escapeHtml(row.item_name)}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        drawCallback: function () {
            const api = this.api();
            $('#stockHistoryModalsContainer').empty();
            api.rows({ page: 'current' }).data().each(function (row) {
                buildStockHistoryModal(row);
            });
        },
        language: {
            emptyTable: '<div class="py-4 text-muted"><i class="bi bi-inbox d-block fs-3 mb-2"></i>No stock items added yet.</div>',
            zeroRecords: '<div class="py-4 text-muted"><i class="bi bi-search d-block fs-3 mb-2"></i>No matching items found.</div>',
            info: 'Showing _START_ to _END_ of _TOTAL_ items',
            infoEmpty: 'Showing 0 items',
            lengthMenu: 'Show _MENU_'
        }
    });

    // Update Summary Cards
    function updateSummaryCards(rows) {
        let low = 0;
        let out = 0;

        rows.forEach(item => {
            const qty = Number(item.quantity || 0);
            const reorder = Number(item.reorder_level || 0);
            if (qty <= 0) {
                out++;
            } else if (qty <= reorder) {
                low++;
            }
        });

        $('#statTotalItems').text(rows.length);
        $('#statLowStock').text(low);
        $('#statOutOfStock').text(out);
    }

    // Search & Status Filter (Status is column index 4)
    $('#stockSearch').on('keyup', function () {
        stockTable.search(this.value).draw();
    });

    $('#statusFilter').on('change', function () {
        stockTable.column(4).search(this.value).draw();
    });

    /*
    |--------------------------------------------------------------------------
    | DYNAMIC MOVEMENT HISTORY MODAL BUILDER
    |--------------------------------------------------------------------------
    */
    function buildStockHistoryModal(item) {
        const modalId = `stockHistoryModal${item.stock_id}`;
        if ($(`#${modalId}`).length) {
            $(`#${modalId}`).remove();
        }

        const movements = item.stock_movements || [];
        let contentHtml = '';

        if (movements.length > 0) {
            contentHtml += '<div class="history-timeline">';
            movements.forEach(function (log) {
                const isIncoming = log.type === 'in';
                const badgeClass = isIncoming ? 'type-in' : 'type-out';
                const sign = isIncoming ? '+' : '-';
                const label = isIncoming ? 'Stock In' : 'Stock Out';

                contentHtml += `
                    <div class="history-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="status-badge ${badgeClass} me-2">
                                    <i class="bi ${isIncoming ? 'bi-arrow-down-left' : 'bi-arrow-up-right'}"></i> ${label}
                                </span>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>${formatDate(log.transaction_date)}
                                </small>
                            </div>
                            <span class="fw-bold ${isIncoming ? 'text-success' : 'text-danger'}">
                                ${sign}${log.quantity} ${escapeHtml(item.unit || 'pcs')}
                            </span>
                        </div>
                        <p class="text-muted small mt-2 mb-0">
                            ${escapeHtml(log.remarks || 'No remarks recorded.')}
                        </p>
                    </div>
                `;
            });
            contentHtml += '</div>';
        } else {
            contentHtml = `
                <div class="text-center py-5">
                    <i class="bi bi-clock-history text-secondary" style="font-size:42px;"></i>
                    <h6 class="mt-3 fw-bold">No Movement Logs</h6>
                    <p class="text-muted small">No stock in or stock out activity recorded for this item yet.</p>
                </div>
            `;
        }

        const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title">
                                    <i class="bi bi-clock-history me-2"></i> Stock Movement Logs
                                </h5>
                                <small class="text-muted">${escapeHtml(item.item_name)}</small>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">${contentHtml}</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('#stockHistoryModalsContainer').append(modalHtml);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE NEW STOCK ITEM (AJAX)
    |--------------------------------------------------------------------------
    */
    $('#addStockForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        const formData = new FormData(this);
        const submitBtn = $('#btnSaveStock');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Saving...');

        $.ajax({
            url: "{{ route('stock-provider.store') }}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Stock Item Added!' });
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('addStockModal')).hide();
                    $('#addStockForm')[0].reset();
                    stockTable.ajax.reload(null, false);
                } else {
                    Toast.fire({ icon: 'error', title: response.message || 'Unable to save item.' });
                }
            },
            error: function (xhr) {
                handleValidationErrors(xhr, 'add');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Save Item');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | OPEN EDIT MODAL & UPDATE STOCK ITEM (AJAX)
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-edit-stock', function () {
        $('#edit_stock_id').val($(this).data('id'));
        $('#edit_item_name').val($(this).data('name'));
        $('#edit_sku').val($(this).data('sku'));
        $('#edit_category').val($(this).data('category'));
        $('#edit_unit').val($(this).data('unit'));
        $('#edit_reorder_level').val($(this).data('reorder'));

        clearValidationErrors();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('editStockModal')).show();
    });

    $('#editStockForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        const stockId = $('#edit_stock_id').val();
        const formData = new FormData(this);
        const submitBtn = $('#btnUpdateStock');
        const url = "{{ route('stock-provider.update', ':id') }}".replace(':id', stockId);

        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Updating...');

        $.ajax({
            url: url,
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Stock Item Updated!' });
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('editStockModal')).hide();
                    stockTable.ajax.reload(null, false);
                } else {
                    Toast.fire({ icon: 'error', title: response.message || 'Unable to update item.' });
                }
            },
            error: function (xhr) {
                handleValidationErrors(xhr, 'edit');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Update Item');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | STOCK IN / STOCK OUT ADJUSTMENT (AJAX)
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-adjust-stock', function () {
        $('#adjust_stock_id').val($(this).data('id'));
        $('#adjust_item_name').val($(this).data('name'));
    });

    $('#adjustStockForm').on('submit', function (e) {
        e.preventDefault();
        clearValidationErrors();

        const formData = new FormData(this);
        const submitBtn = $('#btnSaveAdjustment');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Processing...');

        $.ajax({
            url: "{{ route('stock-provider.adjust') }}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response === true || response.success === true) {
                    Toast.fire({ icon: 'success', title: 'Stock Movement Recorded!' });
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('adjustStockModal')).hide();
                    $('#adjustStockForm')[0].reset();
                    stockTable.ajax.reload(null, false);
                } else {
                    Toast.fire({ icon: 'error', title: response.message || 'Unable to adjust stock.' });
                }
            },
            error: function (xhr) {
                handleValidationErrors(xhr, 'adjust');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('<i class="bi bi-check2-circle me-1"></i> Confirm Movement');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | DELETE STOCK ITEM (AJAX)
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.btn-delete-stock', function () {
        const stockId = $(this).data('id');
        const itemName = $(this).data('name');

        Swal.fire({
            title: 'Delete Stock Item?',
            text: `Are you sure you want to delete "${itemName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = "{{ route('stock-provider.destroy', ':id') }}".replace(':id', stockId);

                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: { _token: $('meta[name="csrf-token"]').attr('content') },
                    success: function () {
                        Toast.fire({ icon: 'success', title: 'Stock Item Deleted!' });
                        stockTable.ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: xhr.responseJSON?.message || 'Unable to delete item.'
                        });
                    }
                });
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | VALIDATION & MODAL RESET HELPERS
    |--------------------------------------------------------------------------
    */
    function clearValidationErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();
    }

    function handleValidationErrors(xhr, context = '') {
        if (xhr.status !== 422) {
            Toast.fire({ icon: 'error', title: xhr.responseJSON?.message || 'Something went wrong.' });
            return;
        }
        const errors = xhr.responseJSON.errors || {};
        const prefix = context === 'edit' ? 'edit_' : '';

        $.each(errors, function (field, messages) {
            const targetInput = context === 'adjust' && field === 'quantity'
                ? $('#adjust_quantity')
                : $('#' + prefix + field);

            targetInput.addClass('is-invalid');
            targetInput.siblings('.invalid-feedback').text(messages[0]).show();
        });
    }

    $('#addStockModal').on('hidden.bs.modal', function () {
        $('#addStockForm')[0].reset();
        clearValidationErrors();
    });

    $('#editStockModal').on('hidden.bs.modal', function () {
        $('#editStockForm')[0].reset();
        clearValidationErrors();
    });

    $('#adjustStockModal').on('hidden.bs.modal', function () {
        $('#adjustStockForm')[0].reset();
        clearValidationErrors();
    });
});
</script>
@endpush

</x-provider>