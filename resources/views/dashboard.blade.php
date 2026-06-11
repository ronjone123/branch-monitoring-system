<x-app-layout>
    <style>
        :root {
            --summary-blue: #1268f3;
            --summary-blue-dark: #0f172a;
            --summary-border: #dfe6f1;
            --summary-bg: #f5f7fb;
            --summary-card: #ffffff;
            --summary-text: #0f172a;
            --summary-muted: #64748b;
            --summary-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);

            --good-bg: #dff3e2;
            --good-text: #1f7a35;

            --warn-bg: #fff2c7;
            --warn-text: #a36a00;

            --danger-bg: #f9d6d6;
            --danger-text: #b42318;

            --info-bg: #d9ebff;
            --info-text: #0f3b78;
        }

        body {
            background:
                radial-gradient(circle at top right, rgba(18, 104, 243, 0.08), transparent 32rem),
                var(--summary-bg);
            color: var(--summary-text);
        }

        .summary-shell {
            max-width: 1780px;
            margin: 0 auto;
            padding-top: 4.75rem;
        }

        .summary-hero {
            background: linear-gradient(135deg, var(--summary-blue), var(--summary-blue-dark));
            color: #fff;
            border-radius: 1rem;
            border: 1px solid #244f92;
            overflow: hidden;
        }

        .summary-hero-title {
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .summary-date-box {
            background: rgba(255, 255, 255, 0.08);
            border-left: 1px solid rgba(255, 255, 255, 0.18);
            min-width: 240px;
        }

        .summary-date-label {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .summary-date-value {
            font-size: 1.15rem;
            font-weight: 700;
        }

        .summary-card {
            background: var(--summary-card);
            border: 1px solid var(--summary-border);
            border-radius: 0.95rem;
            box-shadow: var(--summary-shadow);
            overflow: hidden;
        }

        .summary-section-header {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            color: #0f172a;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: none;
        }

        .summary-section-header h5 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .summary-section-header p {
            margin: 0.25rem 0 0;
            color: #64748b;
            font-size: 0.88rem;
        }

        .summary-section-header .reporting-scope-pill,
        .reporting-detail-board-header .reporting-scope-pill {
            color: #1d4ed8;
            background: rgba(37, 99, 235, 0.10);
            border: 1px solid rgba(37, 99, 235, 0.20);
        }

        .summary-section-header.compact,
        .reporting-detail-board-header.compact {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .reporting-scope-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            border-radius: 999px;
            padding: 0.35rem 0.65rem;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #1d4ed8;
            background: rgba(37, 99, 235, 0.10);
            border: 1px solid rgba(37, 99, 235, 0.20);
        }

        .kpi-card {
            border-radius: 1rem;
            border: 2px solid transparent;
            height: 100%;
            box-shadow: 0 8px 24px rgba(15, 59, 120, 0.05);
        }

        .kpi-card.blue {
            background: #eef5ff;
            border-color: #99c2ff;
        }

        .kpi-card.green {
            background: #eefaf1;
            border-color: #9fd6ad;
        }

        .kpi-card.yellow {
            background: #fff8e7;
            border-color: #f1cf7a;
        }

        .kpi-card.purple {
            background: #f4efff;
            border-color: #b9a3f7;
        }

        .kpi-card.teal {
            background: #edf9fb;
            border-color: #8ed3e2;
        }

        .kpi-label {
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--summary-blue);
            letter-spacing: 0.02em;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--summary-text);
            line-height: 1.1;
        }

        .kpi-sub {
            font-size: 0.95rem;
            color: var(--summary-muted);
        }

        .report-table thead tr:first-child th {
            background: var(--summary-blue);
            color: #fff;
            border-color: #43689f;
            font-size: 0.86rem;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
        }

        .report-table thead tr:nth-child(2) th {
            background: #e9f0fb;
            color: var(--summary-blue-dark);
            border-color: #c7d6ee;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
            text-align: center;
        }

        .report-table td,
        .report-table th {
            padding: 0.8rem 0.9rem;
            vertical-align: middle;
            overflow-wrap: anywhere;
        }

        .report-table tbody tr:nth-child(even) {
            background: #fafcff;
        }

        .report-table tbody td {
            border-color: #dde6f3;
        }

        .report-table tfoot th,
        .report-table tfoot td {
            background: #eef4ff;
            font-weight: 800;
            border-color: #c7d6ee;
        }

        .branch-name {
            font-weight: 700;
            color: var(--summary-text);
        }

        .branch-code {
            font-size: 0.78rem;
            color: var(--summary-muted);
        }

        .amount-col,
        .count-col {
            text-align: right;
            white-space: nowrap;
        }

        .summary-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .summary-chip.good {
            background: var(--good-bg);
            color: var(--good-text);
        }

        .summary-chip.warn {
            background: var(--warn-bg);
            color: var(--warn-text);
        }

        .summary-chip.danger {
            background: var(--danger-bg);
            color: var(--danger-text);
        }

        .summary-chip.info {
            background: var(--info-bg);
            color: var(--info-text);
        }

        .dashboard-table th {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
            white-space: nowrap;
            padding: 0.9rem 1rem;
        }

        .dashboard-table td {
            padding: 0.95rem 1rem;
            vertical-align: middle;
        }

        .dashboard-filter-control {
            border-radius: 0.85rem;
            border: 1px solid var(--summary-border);
            min-height: 46px;
            box-shadow: none;
        }

        .dashboard-filter-control:focus {
            border-color: #7aa7e8;
            box-shadow: 0 0 0 0.2rem rgba(15, 59, 120, 0.08);
        }

        .reporting-filter-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .reporting-filter-mobile-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            padding: 0.9rem;
            margin-bottom: 0.85rem;
        }

        .reporting-filter-collapsible {
            display: none;
        }

        .reporting-filter-collapsible.is-open {
            display: block;
        }

        .reporting-filter-summary-label {
            display: block;
            color: #64748b;
            font-size: 0.7rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.15rem;
        }

        .reporting-filter-toggle {
            border: 1px solid rgba(37, 99, 235, 0.25);
            background: #2563eb;
            color: #ffffff;
            border-radius: 999px;
            padding: 0.55rem 0.8rem;
            font-size: 0.78rem;
            font-weight: 900;
            white-space: nowrap;
        }

        .reporting-filter-toggle:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #ffffff;
        }

        .reporting-filter-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 0.75rem;
            align-items: end;
        }

        .reporting-filter-field {
            min-width: 0;
        }

        .reporting-filter-field label {
            display: block;
            color: #475569;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.35rem;
        }

        .reporting-filter-field input,
        .reporting-filter-field select {
            width: 100%;
            border: 1px solid rgba(15, 23, 42, 0.12);
            border-radius: 0.75rem;
            padding: 0.55rem 0.7rem;
            color: #0f172a;
            background: #ffffff;
            font-size: 0.85rem;
            min-height: 44px;
            box-shadow: none;
        }

        .reporting-filter-field input:focus,
        .reporting-filter-field select:focus {
            border-color: var(--summary-blue);
            box-shadow: 0 0 0 0.18rem rgba(18, 104, 243, 0.10);
            outline: 0;
        }

        .reporting-filter-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .reporting-filter-actions .btn,
        .reporting-filter-actions a,
        .reporting-filter-actions button {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.55rem 1rem;
            font-size: 0.85rem;
            font-weight: 800;
            line-height: 1;
            text-decoration: none;
            white-space: nowrap;
        }

        .reporting-filter-actions .btn-dashboard-primary,
        .reporting-filter-actions button[type="submit"] {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }

        .reporting-filter-actions .btn-dashboard-primary:hover,
        .reporting-filter-actions button[type="submit"]:hover {
            background: #1e40af;
            border-color: #1e40af;
            color: #ffffff;
        }

        .reporting-filter-actions .btn-reset,
        .reporting-filter-actions a.btn-reset {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.14);
            color: #334155;
        }

        .reporting-filter-actions .btn-reset:hover,
        .reporting-filter-actions a.btn-reset:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: rgba(15, 23, 42, 0.2);
        }

        .dashboard-chip-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.55rem;
            margin-bottom: 1rem;
        }

        .dashboard-filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.42rem 0.75rem;
            border-radius: 999px;
            background: #eef4ff;
            border: 1px solid #c7d6ee;
            color: var(--summary-blue);
            font-size: 0.82rem;
            font-weight: 800;
        }

        .dashboard-filter-chip.muted {
            background: #f8fafc;
            color: #64748b;
            border-color: #e2e8f0;
        }

        .dashboard-preset-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0.85rem;
        }

        .dashboard-preset-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            border: 1px solid #c7d6ee;
            background: #fff;
            color: var(--summary-blue);
            font-size: 0.82rem;
            font-weight: 800;
            text-decoration: none;
        }

        .dashboard-preset-btn:hover {
            background: rgba(96, 165, 250, 0.14);
            color: #1d4ed8;
            border-color: rgba(37, 99, 235, 0.28);
        }

        .dashboard-preset-btn.active {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
        }

        .dashboard-preset-btn.active:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #ffffff;
        }

        .dashboard-empty-state {
            border: 1px dashed #b9c9e4;
            background: #f8fbff;
            border-radius: 1rem;
            padding: 1.25rem;
            color: var(--summary-text);
        }

        .dashboard-empty-state-title {
            font-weight: 800;
            color: var(--summary-blue);
            margin-bottom: 0.35rem;
        }

        .dashboard-empty-state-text {
            color: var(--summary-muted);
            margin: 0;
        }

        .btn-dashboard-primary {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
            border-radius: 999px;
            font-weight: 700;
            min-height: 46px;
            padding-inline: 1.1rem;
        }

        .btn-dashboard-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #fff;
        }

        .btn-dashboard-outline {
            border: 1px solid var(--summary-border);
            background: #fff;
            color: var(--summary-text);
            border-radius: 999px;
            font-weight: 700;
            min-height: 46px;
            padding-inline: 1.1rem;
        }

        .btn-dashboard-outline:hover {
            background: #f4f7fb;
            color: var(--summary-blue);
            border-color: #b9c9e4;
        }

        .dashboard-table .amount-col,
        .dashboard-table .count-col {
            text-align: right;
            white-space: nowrap;
        }

        .truncate-cell {
            max-width: 260px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .report-table {
            width: 100%;
            min-width: 760px;
            table-layout: auto;
            margin-bottom: 0;
        }

        .report-table th,
        .report-table td {
            overflow-wrap: anywhere;
        }

        .reporting-detail-pair-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.25rem;
            margin-top: 1rem;
            align-items: stretch;
        }

        .reporting-detail-board {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            padding: 1rem;
            min-width: 0;
        }

        .reporting-detail-board-full {
            grid-column: 1 / -1;
        }

        .reporting-detail-board-header {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 0.95rem;
            padding: 0.85rem 1rem;
            margin-bottom: 1rem;
            color: #0f172a;
            box-shadow: none;
        }

        .reporting-detail-board-header h3 {
            margin: 0;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
        }

        .executive-kpi-detail-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .executive-kpi-detail-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            padding: 1rem;
            min-width: 0;
        }

        .executive-kpi-detail-label {
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .executive-kpi-detail-value {
            display: block;
            color: #0f172a;
            font-size: 1.25rem;
            font-weight: 950;
            line-height: 1.25;
            margin-top: 0.55rem;
            word-break: break-word;
        }

        .executive-kpi-detail-meta {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 700;
            line-height: 1.45;
            margin-top: 0.35rem;
        }

        .executive-kpi-detail-link {
            display: inline-flex;
            align-items: center;
            margin-top: 0.8rem;
            color: #2563eb;
            font-size: 0.78rem;
            font-weight: 900;
            text-decoration: none;
        }

        .executive-kpi-detail-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .reporting-detail-board-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .reporting-detail-column-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 0.9rem;
            background: #f8fafc;
            padding: 0.85rem;
            min-height: 100%;
            min-width: 0;
        }

        .reporting-detail-column-card h4 {
            margin: 0 0 0.75rem;
            color: #334155;
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .reporting-detail-list {
            display: flex;
            flex-direction: column;
            gap: 0.55rem;
        }

        .reporting-detail-item {
            color: #0f172a;
            font-size: 0.88rem;
            font-weight: 700;
            line-height: 1.35;
            word-break: break-word;
            padding-bottom: 0.45rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        }

        .reporting-detail-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .reporting-detail-item.amount,
        .reporting-detail-item.count {
            text-align: right;
        }

        .reporting-detail-empty {
            border: 1px dashed rgba(15, 23, 42, 0.14);
            border-radius: 0.9rem;
            background: #f8fafc;
            color: var(--summary-muted);
            font-size: 0.88rem;
            font-weight: 700;
            padding: 1rem;
        }

        .product-sales-report-board,
        .customer-report-board {
            margin-top: 1rem;
        }

        .product-sales-report-board .reporting-detail-board-header {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 0.95rem;
            padding: 0.85rem 1rem;
            margin-bottom: 1rem;
            color: #0f172a;
            box-shadow: none;
        }

        .product-sales-report-board .reporting-detail-board-header h3 {
            color: #0f172a;
        }

        .product-sales-report-board .reporting-detail-board-header h3::before {
            content: "";
            display: inline-block;
            width: 0.55rem;
            height: 0.55rem;
            border-radius: 999px;
            background: #2563eb;
            margin-right: 0.45rem;
            vertical-align: middle;
        }

        .product-sales-report-board .reporting-detail-board-header p {
            color: #64748b;
        }

        .reporting-detail-board-header p {
            margin: 0.25rem 0 0;
            color: #64748b;
            font-size: 0.82rem;
        }

        .reporting-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .reporting-tab {
            border: 1px solid rgba(15, 23, 42, 0.12);
            background: #ffffff;
            color: #334155;
            border-radius: 999px;
            padding: 0.45rem 0.85rem;
            font-size: 0.8rem;
            font-weight: 800;
            cursor: pointer;
        }

        .reporting-tab.active {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
        }

        .reporting-tab:hover {
            background: rgba(96, 165, 250, 0.14);
            border-color: rgba(37, 99, 235, 0.28);
            color: #1d4ed8;
        }

        .reporting-tab.active:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #ffffff;
        }

        .reporting-tab-panel {
            display: none;
        }

        .reporting-tab-panel.active {
            display: block;
        }

        .reporting-item-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .reporting-item-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 0.9rem;
            background: #f8fafc;
            padding: 0.9rem;
            min-width: 0;
        }

        .reporting-item-title {
            color: #0f172a;
            font-size: 0.95rem;
            font-weight: 900;
            line-height: 1.35;
            word-break: break-word;
            margin-bottom: 0.75rem;
        }

        .reporting-item-meta {
            display: grid;
            gap: 0.45rem;
        }

        .reporting-item-row {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            align-items: baseline;
        }

        .reporting-item-label {
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .reporting-item-value {
            color: #0f172a;
            font-size: 0.86rem;
            font-weight: 900;
            text-align: right;
            word-break: break-word;
        }

        .report-desktop-table {
            display: block;
        }

        .report-mobile-cards {
            display: none;
        }

        .mobile-report-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            padding: 1rem;
        }

        .mobile-report-card.total {
            background: #f8fafc;
            border-color: rgba(37, 99, 235, 0.20);
        }

        .mobile-report-branch {
            color: #0f172a;
            font-weight: 900;
            font-size: 0.95rem;
        }

        .mobile-report-code {
            color: #64748b;
            font-size: 0.78rem;
            font-weight: 700;
            margin-top: 0.15rem;
        }

        .mobile-report-section {
            margin-top: 0.85rem;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        .mobile-report-section-title {
            color: #334155;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.5rem;
        }

        .mobile-report-row {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            align-items: baseline;
            margin-top: 0.35rem;
        }

        .mobile-report-label {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .mobile-report-value {
            color: #0f172a;
            font-size: 0.85rem;
            font-weight: 900;
            text-align: right;
        }

        .report-table-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            margin-bottom: 1.25rem;
        }

        .report-table-card .summary-section-header {
            padding: 1rem 1.1rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            color: #0f172a;
            box-shadow: none;
        }

        .report-table-card .summary-section-header h5 {
            margin: 0;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .report-table-card .summary-section-header p {
            margin: 0.25rem 0 0;
            color: #64748b;
            font-size: 0.82rem;
        }

        .report-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .report-premium-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
            min-width: 980px;
        }

        .report-premium-table thead tr:first-child th {
            background: #f3f4f6;
            color: #111827;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.85rem 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .report-premium-table thead tr:nth-child(2) th {
            background: #f9fafb;
            color: #374151;
            font-size: 0.68rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.7rem 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .report-premium-table th {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        .report-premium-table td {
            vertical-align: middle;
        }

        .report-premium-table tbody td {
            padding: 0.85rem 0.75rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .report-premium-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .report-premium-table tbody tr:hover td {
            background: #f3f4f6;
        }

        .report-premium-table .branch-name {
            font-weight: 900;
            color: #0f172a;
        }

        .report-premium-table .branch-code {
            display: block;
            margin-top: 0.15rem;
            color: #64748b;
            font-size: 0.74rem;
            font-weight: 700;
        }

        .report-premium-table .branch-cell {
            text-align: left;
            white-space: normal;
        }

        .report-premium-table .numeric {
            text-align: right;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .report-premium-table .group-header,
        .report-premium-table .sub-header {
            text-align: center;
        }

        .report-premium-table .count-col,
        .report-premium-table .amount-col {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        .report-premium-table .total-row th,
        .report-premium-table .total-row td {
            background: #f1f5f9 !important;
            color: #0f172a;
            font-weight: 900;
            border-top: 1px solid #d1d5db;
        }

        .report-matrix {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .report-matrix-row {
            display: grid;
            gap: 0;
            column-gap: 0;
            grid-template-columns:
                minmax(170px, 1.4fr)
                minmax(80px, 0.75fr)
                minmax(105px, 1fr)
                minmax(80px, 0.75fr)
                minmax(105px, 1fr)
                minmax(80px, 0.75fr)
                minmax(105px, 1fr)
                minmax(80px, 0.75fr)
                minmax(105px, 1fr)
                minmax(80px, 0.75fr)
                minmax(105px, 1fr);
            min-width: 1080px;
        }

        .report-matrix-cell {
            padding: 0.8rem 0.75rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            width: auto;
            min-width: 0;
            box-sizing: border-box;
        }

        .report-matrix-cell.group {
            justify-content: center;
            background: #f3f4f6;
            color: #111827;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 1px solid #e5e7eb;
        }

        .report-matrix-cell.sub {
            justify-content: center;
            background: #f9fafb;
            color: #374151;
            font-size: 0.68rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 1px solid #e5e7eb;
        }

        .report-matrix-cell.span-4 {
            grid-column: span 4;
        }

        .report-matrix-cell.span-2 {
            grid-column: span 2;
        }

        .report-matrix-branch-cell {
            justify-content: flex-start;
            flex-direction: column;
            align-items: flex-start;
            font-weight: 900;
            width: auto;
            max-width: none;
            min-width: 0;
        }

        .report-matrix-cell.numeric {
            justify-content: flex-end;
            text-align: right;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .report-matrix-body-row {
            background: #ffffff;
        }

        .report-matrix-body-row:nth-child(even) {
            background: #fafafa;
        }

        .report-matrix-body-row .report-matrix-cell {
            background: transparent;
        }

        .report-matrix-body-row:hover {
            background: #f3f4f6;
        }

        .report-matrix-total-row {
            background: #f1f5f9;
        }

        .report-matrix-total-row .report-matrix-cell {
            background: transparent;
            font-weight: 900;
            border-top: 1px solid #d1d5db;
        }

        .report-matrix-empty {
            margin: 1rem;
            min-width: 0;
        }

        .business-unit-table,
        .branch-sales-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
        }

        .business-unit-table th,
        .branch-sales-table th {
            background: #f3f4f6;
            color: #111827;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.8rem 0.75rem;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
            vertical-align: middle;
        }

        .business-unit-table td,
        .branch-sales-table td {
            padding: 0.85rem 0.75rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .business-unit-table tbody tr:nth-child(even) td,
        .branch-sales-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .business-unit-table .business-unit-name,
        .branch-sales-table .branch-name {
            text-align: left;
            font-weight: 900;
        }

        .business-unit-table .code-col {
            text-align: center;
            white-space: nowrap;
        }

        .business-unit-table .numeric {
            text-align: right;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .branch-sales-table .branch-code {
            display: block;
            margin-top: 0.15rem;
            color: #64748b;
            font-size: 0.74rem;
            font-weight: 700;
        }

        .branch-sales-table .numeric {
            text-align: right;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .latest-sales-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
        }

        .latest-sales-table th {
            background: #f3f4f6;
            color: #111827;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.8rem 0.75rem;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
            vertical-align: middle;
        }

        .latest-sales-table td {
            padding: 0.85rem 0.75rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .latest-sales-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .latest-sales-table .numeric {
            text-align: right;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .latest-sales-table .primary-text {
            color: #0f172a;
            font-weight: 900;
        }

        .latest-sales-table .muted-text {
            color: #64748b;
            font-size: 0.78rem;
            margin-top: 0.15rem;
        }

        .latest-sales-mobile-cards {
            display: none;
        }

        .latest-sales-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            padding: 1rem;
        }

        .latest-sales-card-title {
            color: #0f172a;
            font-size: 0.95rem;
            font-weight: 900;
            line-height: 1.35;
            word-break: break-word;
        }

        .latest-sales-card-date {
            color: #64748b;
            font-size: 0.78rem;
            font-weight: 700;
            margin-top: 0.2rem;
        }

        .latest-sales-card-details {
            margin-top: 0.85rem;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
            display: grid;
            gap: 0.45rem;
        }

        .latest-sales-card-row {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            align-items: baseline;
        }

        .latest-sales-card-label {
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .latest-sales-card-value {
            color: #0f172a;
            font-size: 0.86rem;
            font-weight: 900;
            text-align: right;
            word-break: break-word;
        }

        .branch-transaction-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
        }

        .branch-transaction-table th {
            background: #f3f4f6;
            color: #111827;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.8rem 0.75rem;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
            vertical-align: middle;
        }

        .branch-transaction-table td {
            padding: 0.85rem 0.75rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .branch-transaction-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .branch-transaction-table .branch-name {
            text-align: left;
            font-weight: 900;
        }

        .branch-transaction-table .branch-code {
            display: block;
            color: #64748b;
            font-size: 0.76rem;
            font-weight: 700;
            margin-top: 0.15rem;
        }

        .branch-transaction-table .numeric {
            text-align: right;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .branch-transaction-mobile-cards {
            display: none;
        }

        .latest-imports-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
        }

        .latest-imports-table th {
            background: #f3f4f6;
            color: #111827;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.8rem 0.75rem;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
            vertical-align: middle;
        }

        .latest-imports-table td {
            padding: 0.85rem 0.75rem;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .latest-imports-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .latest-imports-table .primary-text {
            color: #0f172a;
            font-weight: 900;
        }

        .latest-imports-table .muted-text {
            color: #64748b;
            font-size: 0.78rem;
            margin-top: 0.15rem;
        }

        .latest-imports-table .status-cell {
            text-align: center;
            white-space: nowrap;
        }

        .latest-imports-table .action-cell {
            text-align: right;
            white-space: nowrap;
        }

        .import-status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.3rem 0.6rem;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        .import-status-completed,
        .import-status-success,
        .import-status-processed {
            color: #166534;
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.25);
        }

        .import-status-pending,
        .import-status-processing {
            color: #92400e;
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .import-status-failed,
        .import-status-error {
            color: #991b1b;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .import-status-default {
            color: #475569;
            background: rgba(100, 116, 139, 0.12);
            border: 1px solid rgba(100, 116, 139, 0.22);
        }

        .latest-imports-mobile-cards {
            display: none;
        }

        .latest-import-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            padding: 1rem;
        }

        .latest-import-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .latest-import-card-title {
            color: #0f172a;
            font-size: 0.95rem;
            font-weight: 900;
            line-height: 1.35;
            word-break: break-word;
        }

        .latest-import-card-subtitle {
            color: #64748b;
            font-size: 0.78rem;
            font-weight: 700;
            margin-top: 0.2rem;
            word-break: break-word;
        }

        .latest-import-card-details {
            margin-top: 0.85rem;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
            display: grid;
            gap: 0.45rem;
        }

        .latest-import-card-row {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            align-items: baseline;
        }

        .latest-import-card-label {
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .latest-import-card-value {
            color: #0f172a;
            font-size: 0.86rem;
            font-weight: 900;
            text-align: right;
            word-break: break-word;
        }

        .latest-import-card-actions {
            margin-top: 0.85rem;
            display: flex;
            justify-content: flex-end;
        }


        .branch-cell {
            width: 160px;
            min-width: 160px;
        }

        html {
            scroll-behavior: smooth;
        }

        .report-fab {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 1050;
        }

        .report-fab .btn {
            border-radius: 999px;
            box-shadow: 0 10px 24px rgba(15, 59, 120, 0.18);
            padding: 0.8rem 1.1rem;
            font-weight: 700;
        }

        .report-menu {
        position: absolute;
        right: 0;
        bottom: 58px;
        width: 300px;
        max-height: 70vh;
        background: #fff;
        border: 1px solid var(--summary-border);
        border-radius: 1rem;
        box-shadow: 0 16px 32px rgba(15, 59, 120, 0.14);
        overflow: hidden;
        display: none;
    }

        .report-menu.show {
            display: block;
        }

        .report-menu-header {
            background: var(--summary-blue);
            color: #fff;
            padding: 0.9rem 1rem;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.03em;
        }

        .report-menu-body {
            padding: 0.6rem;
            max-height: calc(70vh - 48px);
            overflow-y: auto;
        }

        .report-menu-group {
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--summary-muted);
            text-transform: uppercase;
            margin: 0.5rem 0 0.35rem;
            padding: 0 0.5rem;
        }

        .report-menu a {
            display: block;
            text-decoration: none;
            color: var(--summary-text);
            padding: 0.7rem 0.8rem;
            border-radius: 0.7rem;
            font-weight: 600;
        }

        .report-menu a:hover {
            background: #eef4ff;
            color: var(--summary-blue);
        }

    .summary-highlight-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }

    .executive-card {
        background: #fff;
        border-radius: 0.95rem;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        min-height: 170px;
        overflow: hidden;
    }

    .executive-card-body {
        padding: 1.25rem 1.25rem 1.1rem;
    }

    .executive-card-top {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 0.9rem;
    }

    .executive-icon {
        width: 48px;
        height: 48px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        color: #fff;
        font-weight: 700;
        flex-shrink: 0;
    }

    .executive-title {
        font-size: 0.95rem;
        font-weight: 800;
        text-transform: uppercase;
        line-height: 1.25;
        margin-bottom: 0;
    }

    .executive-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.1;
        color: #111827;
        margin-bottom: 0.35rem;
    }

    .executive-subtext {
        color: #6b7280;
        font-size: 0.92rem;
        font-weight: 500;
    }

    .executive-code {
        color: #6b7280;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 0.35rem;
    }

    .executive-small-value {
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1.1;
        color: #111827;
    }

    .card-blue {
        background: #ffffff;
        border-top: 4px solid #1268f3;
    }
    .card-blue .executive-title {
        color: #114187;
    }
    .card-blue .executive-icon {
        background: #114187;
    }

    .card-green {
        background: #ffffff;
        border-top: 4px solid #20b26b;
    }
    .card-green .executive-title {
        color: #1d7c39;
    }
    .card-green .executive-icon {
        background: #1d7c39;
    }

    .card-yellow {
        background: #ffffff;
        border-top: 4px solid #f59e0b;
    }
    .card-yellow .executive-title {
        color: #b7791f;
    }
    .card-yellow .executive-icon {
        background: #d69e2e;
    }

    .card-purple {
        background: #ffffff;
        border-top: 4px solid #8b5cf6;
    }
    .card-purple .executive-title {
        color: #6d28d9;
    }
    .card-purple .executive-icon {
        background: #6d28d9;
    }

    .card-teal {
        background: #ffffff;
        border-top: 4px solid #14b8a6;
    }
    .card-teal .executive-title {
        color: #0f7890;
    }
    .card-teal .executive-icon {
        background: #0f7890;
    }

    .card-navy {
        background: #ffffff;
        border-top: 4px solid #0f172a;
    }
    .card-navy .executive-title {
        color: #103f86;
    }
    .card-navy .executive-icon {
        background: #103f86;
    }

    .card-cyan {
        background: #ffffff;
        border-top: 4px solid #0891b2;
    }
    .card-cyan .executive-title {
        color: #0b7285;
    }
    .card-cyan .executive-icon {
        background: #0b7285;
    }

    @media (max-width: 1400px) {
        .summary-highlight-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 992px) {
        .summary-highlight-grid {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    @media (max-width: 1199.98px) {
        .executive-kpi-detail-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .reporting-filter-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .summary-shell {
            padding-top: 4.25rem;
        }

        .reporting-filter-mobile-summary {
            align-items: center;
        }

        .reporting-filter-mobile-summary strong {
            color: #0f172a;
            font-size: 0.95rem;
            font-weight: 900;
        }

        .reporting-filter-mobile-summary p {
            margin: 0.15rem 0 0;
            color: #64748b;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .reporting-filter-collapsible {
            display: none;
        }

        .reporting-filter-collapsible.is-open {
            display: block;
        }

        .summary-card > .p-3,
        .summary-card > .p-md-4 {
            padding: 1rem !important;
        }

        .dashboard-preset-btn,
        .dashboard-filter-chip {
            width: 100%;
            justify-content: center;
            text-align: center;
        }

        .report-fab {
            right: 1rem;
            bottom: 1rem;
        }

        .report-menu {
            width: calc(100vw - 2rem);
            max-width: 340px;
        }

        .reporting-filter-grid {
            grid-template-columns: 1fr;
        }

        .reporting-filter-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .reporting-filter-actions .btn,
        .reporting-filter-actions a,
        .reporting-filter-actions button {
            width: 100%;
        }
    }

        @media (max-width: 1199.98px) {
            .reporting-detail-pair-grid {
                grid-template-columns: 1fr;
            }

            .reporting-item-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

    @media (max-width: 767.98px) {
        .reporting-detail-board-grid {
            grid-template-columns: 1fr;
        }

        .reporting-detail-item.amount,
        .reporting-detail-item.count {
            text-align: left;
        }
    }

        @media (max-width: 575.98px) {
            .executive-kpi-detail-grid {
                grid-template-columns: 1fr;
            }

            .reporting-item-grid {
                grid-template-columns: 1fr;
            }

            .summary-section-header.compact,
            .reporting-detail-board-header.compact {
                align-items: flex-start;
                flex-direction: column;
            }

            .reporting-item-row {
                align-items: flex-start;
                flex-direction: column;
            gap: 0.15rem;
        }

        .reporting-item-value {
            text-align: left;
        }
    }

        @media (max-width: 767.98px) {
            .report-desktop-table {
                display: none;
            }

            .report-mobile-cards {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.85rem;
            }

            .latest-sales-desktop-table {
                display: none;
            }

            .latest-sales-mobile-cards {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.85rem;
            }

            .latest-sales-card-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 0.15rem;
            }

            .latest-sales-card-value {
                text-align: left;
            }

            .branch-transaction-desktop-table {
                display: none;
            }

            .branch-transaction-mobile-cards {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.85rem;
            }

            .latest-imports-desktop-table {
                display: none;
            }

            .latest-imports-mobile-cards {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.85rem;
            }

            .latest-import-card-header {
                flex-direction: column;
            }

            .latest-import-card-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 0.15rem;
            }

            .latest-import-card-value {
                text-align: left;
            }

            .latest-import-card-actions {
                justify-content: stretch;
            }

            .latest-import-card-actions a,
            .latest-import-card-actions button {
                width: 100%;
                justify-content: center;
            }
        }

        @media (min-width: 768px) {
            .latest-sales-desktop-table {
                display: block;
            }

            .latest-sales-mobile-cards {
                display: none;
            }

            .branch-transaction-desktop-table {
                display: block;
            }

            .branch-transaction-mobile-cards {
                display: none;
            }

            .latest-imports-desktop-table {
                display: block;
            }

            .latest-imports-mobile-cards {
                display: none;
            }
        }

    @media (max-width: 380px) {
        .mobile-report-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.15rem;
        }

        .mobile-report-value {
            text-align: left;
        }
    }

        @media (max-width: 768px) {
            .summary-hero-title {
                font-size: 1.7rem;
            }

            .summary-date-box {
                min-width: 100%;
                border-left: 0;
                border-top: 1px solid rgba(255, 255, 255, 0.18);
            }

            .kpi-value {
                font-size: 1.6rem;
            }
        }
    </style>

    <div class="summary-shell px-3 px-md-4 pb-4">

    {{-- Dashboard Filters / Control Center --}}
@php
    $selectedBusinessUnitName = $businessUnits
        ->firstWhere('id', (int) $selectedBusinessUnitId)
        ?->name ?? 'All Business Units';

    $selectedBranchName = $branches
        ->firstWhere('id', (int) $selectedBranchId)
        ?->display_name ?? 'All Branches';

    $hasActiveFilters = $selectedBusinessUnitId || $selectedBranchId || $dateFrom || $dateTo;

    $presetToday = now()->toDateString();
    $presetMonthStart = now()->startOfMonth()->toDateString();
    $presetMonthEnd = now()->toDateString();
    $presetYearStart = now()->startOfYear()->toDateString();

    $hasDashboardData =
    ((float) $filteredTotalAmount > 0)
    || ((int) $filteredTransactionCount > 0)
    || ((float) $filteredCashAmount > 0)
    || ((int) $filteredBranchCount > 0)
    || $branchPerformanceSummary->count() > 0
    || $businessUnitTotals->count() > 0
    || $latestTransactions->count() > 0;
@endphp

<div class="mb-4">
    <div>
        <div class="reporting-filter-mobile-summary">
            <div>
                <span class="reporting-filter-summary-label">Showing</span>
                <strong>{{ $datePresetLabel ?? 'This Month' }}</strong>
                <p>{{ $selectedBranchName }} &bull; {{ $selectedBusinessUnitName }}</p>
            </div>

            <button type="button" class="reporting-filter-toggle" data-filter-toggle aria-expanded="false">
                Show Filters
            </button>
        </div>

        <div class="dashboard-preset-row">
            <a class="dashboard-preset-btn {{ ($datePreset ?? null) === 'today' ? 'active' : '' }}"
               href="{{ route('dashboard', ['date_preset' => 'today', 'date_from' => $presetToday, 'date_to' => $presetToday, 'business_unit_id' => $selectedBusinessUnitId, 'branch_id' => $selectedBranchId]) }}">
                Today
            </a>

            <a class="dashboard-preset-btn {{ ($datePreset ?? null) === 'this_month' ? 'active' : '' }}"
               href="{{ route('dashboard', ['date_preset' => 'this_month', 'date_from' => $presetMonthStart, 'date_to' => $presetMonthEnd, 'business_unit_id' => $selectedBusinessUnitId, 'branch_id' => $selectedBranchId]) }}">
                This Month
            </a>

            <a class="dashboard-preset-btn {{ ($datePreset ?? null) === 'year_to_date' ? 'active' : '' }}"
               href="{{ route('dashboard', ['date_preset' => 'year_to_date', 'date_from' => $presetYearStart, 'date_to' => $presetToday, 'business_unit_id' => $selectedBusinessUnitId, 'branch_id' => $selectedBranchId]) }}">
                Year to Date
            </a>

            <a class="dashboard-preset-btn {{ ($datePreset ?? null) === 'all_time' ? 'active' : '' }}"
               href="{{ route('dashboard', ['date_preset' => 'all_time', 'business_unit_id' => $selectedBusinessUnitId, 'branch_id' => $selectedBranchId]) }}">
                All Time
            </a>
        </div>

        <div class="reporting-filter-collapsible" data-filter-panel>
        <div class="dashboard-chip-row">
            <span class="dashboard-filter-chip">
                Period:
                {{ $dateFrom ?: 'All Start Dates' }}
                -
                {{ $dateTo ?: 'Latest' }}
            </span>

            <span class="dashboard-filter-chip {{ $selectedBusinessUnitId ? '' : 'muted' }}">
                Business Unit: {{ $selectedBusinessUnitName }}
            </span>

            <span class="dashboard-filter-chip {{ $selectedBranchId ? '' : 'muted' }}">
                Branch: {{ $selectedBranchName }}
            </span>

            <span class="dashboard-filter-chip {{ $hasActiveFilters ? '' : 'muted' }}">
                {{ $hasActiveFilters ? 'Filtered View Active' : 'Default Dashboard View' }}
            </span>
        </div>

        <form method="GET" action="{{ route('dashboard') }}" class="reporting-filter-card">
            <input type="hidden" name="date_preset" value="custom">
            <div class="reporting-filter-grid">
                <div class="reporting-filter-field">
                    <label for="business_unit_id">Business Unit</label>
                    <select name="business_unit_id" id="business_unit_id">
                        <option value="">All Business Units</option>
                        @foreach($businessUnits as $businessUnit)
                            <option value="{{ $businessUnit->id }}"
                                {{ (string) $selectedBusinessUnitId === (string) $businessUnit->id ? 'selected' : '' }}>
                                {{ $businessUnit->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="reporting-filter-field">
                    <label for="branch_id">Branch</label>
                    <select name="branch_id" id="branch_id">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ (string) $selectedBranchId === (string) $branch->id ? 'selected' : '' }}>
                                {{ $branch->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="reporting-filter-field">
                    <label for="date_from">Date From</label>
                    <input type="date" name="date_from" id="date_from" value="{{ $dateFrom }}">
                </div>

                <div class="reporting-filter-field">
                    <label for="date_to">Date To</label>
                    <input type="date" name="date_to" id="date_to" value="{{ $dateTo }}">
                </div>

                <div class="reporting-filter-actions">
                    <button type="submit" class="btn btn-dashboard-primary">Apply</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-reset">Reset</a>
                </div>
            </div>
        </form>

        </div>

        @if(! $hasDashboardData)
            <div class="dashboard-empty-state mt-3">
                <div class="dashboard-empty-state-title">
                    No dashboard activity found for this selected view.
                </div>

                <p class="dashboard-empty-state-text">
                    Try changing filters, clearing filters, or checking if recent branch files have already been imported.
                    @if($latestAvailableTransactionDate)
                        Latest matching transaction date:
                        <strong>{{ \Carbon\Carbon::parse($latestAvailableTransactionDate)->format('M d, Y') }}</strong>.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

        <div id="report-kpi-details" class="summary-card mb-4">
            <div class="p-3 p-md-4">
                <section class="reporting-detail-board executive-kpi-detail-reports">
                    <div class="reporting-detail-board-header compact">
                        <div>
                            <h3>Executive KPI Detail Reports</h3>
                            <p>Detailed report breakdowns behind the Executive Dashboard KPI overview.</p>
                        </div>
                        <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
                    </div>

                    @php
                        $pnSalesAmount = (float) ($filteredTotalAmount ?? 0);
                        $cashSalesAmount = (float) ($filteredCashAmount ?? 0);
                        $reportSalesAmount = (float) ($filteredSalesAmount ?? 0);
                    @endphp

                    <div class="executive-kpi-detail-grid">
                        <article class="executive-kpi-detail-card">
                            <div class="executive-kpi-detail-label">Total Sales Detail</div>
                            <span class="executive-kpi-detail-value">&#8369;{{ number_format($reportSalesAmount, 2) }}</span>
                            <div class="executive-kpi-detail-meta">
                                Total amount using the reporting dashboard amount standard.
                            </div>
                            <a href="#report-branch-sales" class="executive-kpi-detail-link">View Branch Sales Report</a>
                        </article>

                        <article class="executive-kpi-detail-card">
                            <div class="executive-kpi-detail-label">Cash Sales Detail</div>
                            <span class="executive-kpi-detail-value">&#8369;{{ number_format($cashSalesAmount, 2) }}</span>
                            <div class="executive-kpi-detail-meta">
                                Cash amount from matching sales transactions.
                            </div>
                            <a href="#combined-cash" class="executive-kpi-detail-link">View Cash Reports</a>
                        </article>

                        <article class="executive-kpi-detail-card">
                            <div class="executive-kpi-detail-label">PN / Installment Sales Detail</div>
                            <span class="executive-kpi-detail-value">&#8369;{{ number_format($pnSalesAmount, 2) }}</span>
                            <div class="executive-kpi-detail-meta">
                                PN / installment amount from matching sales transactions.
                            </div>
                            <a href="#combined-installment" class="executive-kpi-detail-link">View PN Reports</a>
                        </article>

                        <article class="executive-kpi-detail-card">
                            <div class="executive-kpi-detail-label">Transaction Count Detail</div>
                            <span class="executive-kpi-detail-value">{{ number_format((int) ($filteredTransactionCount ?? 0)) }}</span>
                            <div class="executive-kpi-detail-meta">
                                Transactions in the selected report period.
                            </div>
                            <a href="#report-latest-sales" class="executive-kpi-detail-link">View Latest Transactions</a>
                        </article>

                        <article class="executive-kpi-detail-card">
                            <div class="executive-kpi-detail-label">Branch Coverage Detail</div>
                            <span class="executive-kpi-detail-value">{{ number_format((int) ($filteredBranchCount ?? 0)) }}</span>
                            <div class="executive-kpi-detail-meta">
                                Branches with matching transaction activity.
                            </div>
                            <a href="#report-branch-sales" class="executive-kpi-detail-link">View Branch Sales Report</a>
                        </article>

                        <article class="executive-kpi-detail-card">
                            <div class="executive-kpi-detail-label">Latest Sales Summary Detail</div>
                            <span class="executive-kpi-detail-value">
                                @if($latestAvailableTransactionDate)
                                    {{ \Carbon\Carbon::parse($latestAvailableTransactionDate)->format('M d, Y') }}
                                @else
                                    No sales date
                                @endif
                            </span>
                            <div class="executive-kpi-detail-meta">
                                Latest matching transaction date for the selected filters.
                            </div>
                            <a href="#report-latest-sales" class="executive-kpi-detail-link">View Latest Transactions</a>
                        </article>
                    </div>
                </section>
            </div>
        </div>

        <div id="report-sales-mix-detail" class="summary-card mb-4">
            <div class="p-3 p-md-4">
                <section class="reporting-detail-board sales-mix-detail-report-board" data-sales-mix-report>
                    <div class="reporting-detail-board-header compact">
                        <div>
                            <h3>Sales Mix Detail Report</h3>
                            <p>Detailed breakdown behind the Executive Dashboard sales mix.</p>
                        </div>
                        <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
                    </div>

                    <div class="reporting-tabs" role="tablist" aria-label="Sales mix detail report tabs">
                        <button type="button" class="reporting-tab active" data-report-tab="sales-mix-payment" role="tab" aria-selected="true">Cash vs PN / Installment</button>
                        <button type="button" class="reporting-tab" data-report-tab="sales-mix-status" role="tab" aria-selected="false">Brand New vs Repo</button>
                        <button type="button" class="reporting-tab" data-report-tab="sales-mix-product-groups" role="tab" aria-selected="false">Product Groups</button>
                    </div>

                    <div class="reporting-tab-panel active" data-report-panel="sales-mix-payment" role="tabpanel">
                        @if(! empty($salesMixDetailReport['payment_mix'] ?? []))
                            <div class="reporting-item-grid">
                                @foreach($salesMixDetailReport['payment_mix'] as $item)
                                    <article class="reporting-item-card">
                                        <div class="reporting-item-title">{{ $item['label'] }}</div>
                                        <div class="reporting-item-meta">
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Transactions</span>
                                                <span class="reporting-item-value">{{ number_format((int) $item['transactions']) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Total Amount</span>
                                                <span class="reporting-item-value">&#8369;{{ number_format((float) $item['amount'], 2) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Share</span>
                                                <span class="reporting-item-value">{{ number_format((float) $item['share'], 1) }}%</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Top Branch</span>
                                                <span class="reporting-item-value">{{ $item['top_branch'] ?? '—' }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="reporting-detail-empty">
                                No sales mix payment details available for the selected filters.
                            </div>
                        @endif
                    </div>

                    <div class="reporting-tab-panel" data-report-panel="sales-mix-status" role="tabpanel">
                        @if(! empty($salesMixDetailReport['unit_status_mix'] ?? []))
                            <div class="reporting-item-grid">
                                @foreach($salesMixDetailReport['unit_status_mix'] as $item)
                                    <article class="reporting-item-card">
                                        <div class="reporting-item-title">{{ $item['label'] }}</div>
                                        <div class="reporting-item-meta">
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Transactions</span>
                                                <span class="reporting-item-value">{{ number_format((int) $item['transactions']) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Total Amount</span>
                                                <span class="reporting-item-value">&#8369;{{ number_format((float) $item['amount'], 2) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Share</span>
                                                <span class="reporting-item-value">{{ number_format((float) $item['share'], 1) }}%</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Top Brand</span>
                                                <span class="reporting-item-value">{{ $item['top_brand'] ?? '—' }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Top Product</span>
                                                <span class="reporting-item-value">{{ $item['top_product'] ?? '—' }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="reporting-detail-empty">
                                No brand new/repo details available for the selected filters.
                            </div>
                        @endif
                    </div>

                    <div class="reporting-tab-panel" data-report-panel="sales-mix-product-groups" role="tabpanel">
                        @if(! empty($salesMixDetailReport['product_group_mix'] ?? []))
                            <div class="reporting-item-grid">
                                @foreach($salesMixDetailReport['product_group_mix'] as $item)
                                    <article class="reporting-item-card">
                                        <div class="reporting-item-title">{{ $item['label'] }}</div>
                                        <div class="reporting-item-meta">
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Transactions</span>
                                                <span class="reporting-item-value">{{ number_format((int) $item['transactions']) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Total Amount</span>
                                                <span class="reporting-item-value">&#8369;{{ number_format((float) $item['amount'], 2) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Share</span>
                                                <span class="reporting-item-value">{{ number_format((float) $item['share'], 1) }}%</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Top Brand</span>
                                                <span class="reporting-item-value">{{ $item['top_brand'] ?? '—' }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Top Product</span>
                                                <span class="reporting-item-value">{{ $item['top_product'] ?? '—' }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="reporting-detail-empty">
                                No product group details available for the selected filters.
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>

        <div id="report-product-sales" class="summary-card mb-4">
            <div class="p-3 p-md-4">
                <section class="reporting-detail-board product-sales-report-board" data-product-sales-report>
                    <div class="reporting-detail-board-header compact">
                        <div>
                            <h3>Product & Sales Report</h3>
                            <p>Detailed brand, product, and term reports for the selected filters.</p>
                        </div>
                        <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
                    </div>

                    <div class="reporting-tabs" role="tablist" aria-label="Product and sales report tabs">
                        <button type="button" class="reporting-tab active" data-report-tab="brands" role="tab" aria-selected="true">Top Brands</button>
                        <button type="button" class="reporting-tab" data-report-tab="products" role="tab" aria-selected="false">Top Products</button>
                        <button type="button" class="reporting-tab" data-report-tab="terms" role="tab" aria-selected="false">Top Terms</button>
                    </div>

                    <div class="reporting-tab-panel active" data-report-panel="brands" role="tabpanel">
                        @if($topBrands->isNotEmpty())
                            <div class="reporting-item-grid">
                                @foreach($topBrands as $brand)
                                    <article class="reporting-item-card">
                                        <div class="reporting-item-title">{{ $brand->brand_name }}</div>
                                        <div class="reporting-item-meta">
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Transactions</span>
                                                <span class="reporting-item-value">{{ number_format((int) $brand->transaction_count) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Total Amount</span>
                                                <span class="reporting-item-value">&#8369;{{ number_format((float) $brand->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="reporting-detail-empty">No brand details available for the selected filters.</div>
                        @endif
                    </div>

                    <div class="reporting-tab-panel" data-report-panel="products" role="tabpanel">
                        @if($hotProducts->isNotEmpty())
                            <div class="reporting-item-grid">
                                @foreach($hotProducts as $product)
                                    <article class="reporting-item-card">
                                        <div class="reporting-item-title">{{ $product->product_name }}</div>
                                        <div class="reporting-item-meta">
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Transactions</span>
                                                <span class="reporting-item-value">{{ number_format((int) $product->transaction_count) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Total Amount</span>
                                                <span class="reporting-item-value">&#8369;{{ number_format((float) $product->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="reporting-detail-empty">No product details available for the selected filters.</div>
                        @endif
                    </div>

                    <div class="reporting-tab-panel" data-report-panel="terms" role="tabpanel">
                        @if($topTerms->isNotEmpty())
                            <div class="reporting-item-grid">
                                @foreach($topTerms as $term)
                                    <article class="reporting-item-card">
                                        <div class="reporting-item-title">{{ $term->terms }}</div>
                                        <div class="reporting-item-meta">
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Transactions</span>
                                                <span class="reporting-item-value">{{ number_format((int) $term->transaction_count) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Share</span>
                                                <span class="reporting-item-value">{{ number_format((float) $term->percentage, 2) }}%</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="reporting-detail-empty">No term details available for the selected filters.</div>
                        @endif
                    </div>
                </section>
            </div>
        </div>

        <div id="report-customer" class="summary-card mb-4">
            <div class="summary-section-header compact">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Customer Intelligence</h5>
                    <p class="mb-0">
                        Repeat buyers and highest PN customers based on real paid sales only.
                    </p>
                </div>
            </div>

            <div class="p-3 p-md-4">
                <section class="reporting-detail-board customer-report-board" data-customer-report>
                    <div class="reporting-detail-board-header compact">
                        <div>
                            <h3>Customer Report</h3>
                            <p>Repeat buyer and PN customer details for the selected filters.</p>
                        </div>
                        <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
                    </div>

                    <div class="reporting-tabs" role="tablist" aria-label="Customer report tabs">
                        <button type="button" class="reporting-tab active" data-report-tab="repeat-buyers" role="tab" aria-selected="true">Top Repeat Buyers</button>
                        <button type="button" class="reporting-tab" data-report-tab="pn-customers" role="tab" aria-selected="false">Highest PN Customers</button>
                        <button type="button" class="reporting-tab" data-report-tab="customer-details" role="tab" aria-selected="false">Repeat Buyers Customer Details</button>
                    </div>

                    <div class="reporting-tab-panel active" data-report-panel="repeat-buyers" role="tabpanel">
                        @if($topRepeatCustomers->isNotEmpty())
                            <div class="reporting-item-grid">
                                @foreach($topRepeatCustomers as $customer)
                                    <article class="reporting-item-card">
                                        <div class="reporting-item-title">
                                            <a href="{{ route('sales-transactions.show', $customer->latest_sales_transaction_id) }}" class="text-decoration-none text-dark">
                                                {{ $customer->customer_name }}
                                            </a>
                                        </div>
                                        <div class="reporting-item-meta">
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Contact</span>
                                                <span class="reporting-item-value">{{ $customer->contact_number ?? '-' }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Accounts</span>
                                                <span class="reporting-item-value">{{ number_format((int) $customer->account_count) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Transactions</span>
                                                <span class="reporting-item-value">{{ number_format((int) $customer->transaction_count) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Total Amount</span>
                                                <span class="reporting-item-value">&#8369;{{ number_format((float) $customer->total_sales_amount, 2) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Latest Purchase</span>
                                                <span class="reporting-item-value">{{ $customer->latest_purchase_date ? \Carbon\Carbon::parse($customer->latest_purchase_date)->format('M d, Y') : '-' }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="reporting-detail-empty">
                                No repeat buyer details available for the selected filters.
                            </div>
                        @endif
                    </div>

                    <div class="reporting-tab-panel" data-report-panel="pn-customers" role="tabpanel">
                        @if($topPnCustomers->isNotEmpty())
                            <div class="reporting-item-grid">
                                @foreach($topPnCustomers as $customer)
                                    <article class="reporting-item-card">
                                        <div class="reporting-item-title">
                                            <a href="{{ route('sales-transactions.show', $customer->sales_transaction_id) }}" class="text-decoration-none text-dark">
                                                {{ $customer->customer_name }}
                                            </a>
                                        </div>
                                        <div class="reporting-item-meta">
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Account</span>
                                                <span class="reporting-item-value">{{ $customer->account_number ?? '-' }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Receipt</span>
                                                <span class="reporting-item-value">{{ $customer->receipt_number ?? '-' }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Product</span>
                                                <span class="reporting-item-value">
                                                    {{ $customer->brand_name ?? '-' }}
                                                    {{ $customer->model ? '- ' . $customer->model : '' }}
                                                </span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">PN Amount</span>
                                                <span class="reporting-item-value">&#8369;{{ number_format((float) $customer->total_pn_amount, 2) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Latest Purchase</span>
                                                <span class="reporting-item-value">{{ $customer->latest_purchase_date ? \Carbon\Carbon::parse($customer->latest_purchase_date)->format('M d, Y') : '-' }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="reporting-detail-empty">
                                No PN customer details available for the selected filters.
                            </div>
                        @endif
                    </div>

                    <div class="reporting-tab-panel" data-report-panel="customer-details" role="tabpanel">
                        @if($latestRepeatCustomers->isNotEmpty())
                            <div class="reporting-item-grid">
                                @foreach($latestRepeatCustomers as $customer)
                                    <article class="reporting-item-card">
                                        <div class="reporting-item-title">
                                            <a href="{{ route('sales-transactions.show', $customer->latest_sales_transaction_id) }}" class="text-decoration-none text-dark">
                                                {{ $customer->customer_name }}
                                            </a>
                                        </div>
                                        <div class="reporting-item-meta">
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Contact</span>
                                                <span class="reporting-item-value">{{ $customer->contact_number ?? '-' }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Accounts</span>
                                                <span class="reporting-item-value">{{ number_format((int) $customer->account_count) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Transactions</span>
                                                <span class="reporting-item-value">{{ number_format((int) $customer->transaction_count) }}</span>
                                            </div>
                                            <div class="reporting-item-row">
                                                <span class="reporting-item-label">Latest Purchase</span>
                                                <span class="reporting-item-value">{{ $customer->latest_purchase_date ? \Carbon\Carbon::parse($customer->latest_purchase_date)->format('M d, Y') : '-' }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="reporting-detail-empty">
                                No customer details available for the selected filters.
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>

            <div id="report-cash-installment"></div>

            <div id="appliance-cash" class="summary-card report-table-card">
                <div class="summary-section-header compact">
                    <div>
                        <h5 class="mb-1 dashboard-card-title">Appliance Cash Transactions</h5>
                        <p class="mb-0">
                            Lucky 4 Appliances cash sales summary by branch.
                        </p>
                    </div>
                    <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
                </div>

                <div class="p-3 p-md-4">
                    <div class="report-matrix report-desktop-table">
                        <div class="report-matrix-row report-matrix-group-row">
                            <div class="report-matrix-cell group">Branch</div>
                            <div class="report-matrix-cell group span-4">Sales Today</div>
                            <div class="report-matrix-cell group span-4">Sales To Date</div>
                            <div class="report-matrix-cell group span-2">Total</div>
                        </div>
                        <div class="report-matrix-row report-matrix-subheader-row">
                            <div class="report-matrix-cell sub" aria-hidden="true"></div>
                            <div class="report-matrix-cell sub">BN Unit</div>
                            <div class="report-matrix-cell sub">BN COD</div>
                            <div class="report-matrix-cell sub">Repo Unit</div>
                            <div class="report-matrix-cell sub">Repo COD</div>
                            <div class="report-matrix-cell sub">BN Unit</div>
                            <div class="report-matrix-cell sub">BN COD</div>
                            <div class="report-matrix-cell sub">Repo Unit</div>
                            <div class="report-matrix-cell sub">Repo COD</div>
                            <div class="report-matrix-cell sub">Unit</div>
                            <div class="report-matrix-cell sub">COD</div>
                        </div>
                        @forelse($applianceCashSummary as $row)
                            <div class="report-matrix-row report-matrix-body-row">
                                <div class="report-matrix-cell report-matrix-branch-cell">
                                    <div class="branch-name">{{ $row->branch_name }}</div>
                                    <div class="branch-code">{{ $row->branch_code }}</div>
                                </div>
                                <div class="report-matrix-cell numeric">{{ $row->today_brand_new_units }}</div>
                                <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_brand_new_cod, 2) }}</div>
                                <div class="report-matrix-cell numeric">{{ $row->today_repo_units }}</div>
                                <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_repo_cod, 2) }}</div>
                                <div class="report-matrix-cell numeric">{{ $row->todate_brand_new_units }}</div>
                                <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_brand_new_cod, 2) }}</div>
                                <div class="report-matrix-cell numeric">{{ $row->todate_repo_units }}</div>
                                <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_repo_cod, 2) }}</div>
                                <div class="report-matrix-cell numeric fw-semibold">{{ $row->total_units }}</div>
                                <div class="report-matrix-cell numeric fw-semibold">{{ number_format((float) $row->total_cod, 2) }}</div>
                            </div>
                        @empty
                            <div class="reporting-detail-empty report-matrix-empty">
                                No appliance cash transaction data found. Try changing the date range, branch, or business unit filter.
                            </div>
                        @endforelse
                        @if($applianceCashSummary->isNotEmpty())
                            <div class="report-matrix-row report-matrix-total-row">
                                <div class="report-matrix-cell report-matrix-branch-cell">TOTAL</div>
                                <div class="report-matrix-cell numeric">{{ $applianceCashTotals->today_brand_new_units }}</div>
                                <div class="report-matrix-cell numeric">{{ number_format((float) $applianceCashTotals->today_brand_new_cod, 2) }}</div>
                                <div class="report-matrix-cell numeric">{{ $applianceCashTotals->today_repo_units }}</div>
                                <div class="report-matrix-cell numeric">{{ number_format((float) $applianceCashTotals->today_repo_cod, 2) }}</div>
                                <div class="report-matrix-cell numeric">{{ $applianceCashTotals->todate_brand_new_units }}</div>
                                <div class="report-matrix-cell numeric">{{ number_format((float) $applianceCashTotals->todate_brand_new_cod, 2) }}</div>
                                <div class="report-matrix-cell numeric">{{ $applianceCashTotals->todate_repo_units }}</div>
                                <div class="report-matrix-cell numeric">{{ number_format((float) $applianceCashTotals->todate_repo_cod, 2) }}</div>
                                <div class="report-matrix-cell numeric">{{ $applianceCashTotals->total_units }}</div>
                                <div class="report-matrix-cell numeric">{{ number_format((float) $applianceCashTotals->total_cod, 2) }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="report-mobile-cards">
                        @forelse($applianceCashSummary as $row)
                            <article class="mobile-report-card">
                                <div class="mobile-report-branch">{{ $row->branch_name }}</div>
                                <div class="mobile-report-code">{{ $row->branch_code }}</div>

                                <div class="mobile-report-section">
                                    <div class="mobile-report-section-title">Sales Today</div>
                                    <div class="mobile-report-row">
                                        <span class="mobile-report-label">BN</span>
                                        <span class="mobile-report-value">{{ number_format((int) $row->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_brand_new_cod, 2) }}</span>
                                    </div>
                                    <div class="mobile-report-row">
                                        <span class="mobile-report-label">Repo</span>
                                        <span class="mobile-report-value">{{ number_format((int) $row->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_repo_cod, 2) }}</span>
                                    </div>
                                </div>

                                <div class="mobile-report-section">
                                    <div class="mobile-report-section-title">Sales To Date</div>
                                    <div class="mobile-report-row">
                                        <span class="mobile-report-label">BN</span>
                                        <span class="mobile-report-value">{{ number_format((int) $row->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_brand_new_cod, 2) }}</span>
                                    </div>
                                    <div class="mobile-report-row">
                                        <span class="mobile-report-label">Repo</span>
                                        <span class="mobile-report-value">{{ number_format((int) $row->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_repo_cod, 2) }}</span>
                                    </div>
                                </div>

                                <div class="mobile-report-section">
                                    <div class="mobile-report-section-title">Total</div>
                                    <div class="mobile-report-row">
                                        <span class="mobile-report-label">Unit / COD</span>
                                        <span class="mobile-report-value">{{ number_format((int) $row->total_units) }} unit(s) - &#8369;{{ number_format((float) $row->total_cod, 2) }}</span>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="reporting-detail-empty">
                                No report data available for the selected filters.
                            </div>
                        @endforelse

                        @if($applianceCashSummary->isNotEmpty())
                            <article class="mobile-report-card total">
                                <div class="mobile-report-branch">TOTAL</div>
                                <div class="mobile-report-section">
                                    <div class="mobile-report-section-title">Sales Today</div>
                                    <div class="mobile-report-row">
                                        <span class="mobile-report-label">BN</span>
                                        <span class="mobile-report-value">{{ number_format((int) $applianceCashTotals->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $applianceCashTotals->today_brand_new_cod, 2) }}</span>
                                    </div>
                                    <div class="mobile-report-row">
                                        <span class="mobile-report-label">Repo</span>
                                        <span class="mobile-report-value">{{ number_format((int) $applianceCashTotals->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $applianceCashTotals->today_repo_cod, 2) }}</span>
                                    </div>
                                </div>
                                <div class="mobile-report-section">
                                    <div class="mobile-report-section-title">Sales To Date</div>
                                    <div class="mobile-report-row">
                                        <span class="mobile-report-label">BN</span>
                                        <span class="mobile-report-value">{{ number_format((int) $applianceCashTotals->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $applianceCashTotals->todate_brand_new_cod, 2) }}</span>
                                    </div>
                                    <div class="mobile-report-row">
                                        <span class="mobile-report-label">Repo</span>
                                        <span class="mobile-report-value">{{ number_format((int) $applianceCashTotals->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $applianceCashTotals->todate_repo_cod, 2) }}</span>
                                    </div>
                                </div>
                                <div class="mobile-report-section">
                                    <div class="mobile-report-section-title">Total</div>
                                    <div class="mobile-report-row">
                                        <span class="mobile-report-label">Unit / COD</span>
                                        <span class="mobile-report-value">{{ number_format((int) $applianceCashTotals->total_units) }} unit(s) - &#8369;{{ number_format((float) $applianceCashTotals->total_cod, 2) }}</span>
                                    </div>
                                </div>
                            </article>
                        @endif
                    </div>
                </div>
            </div>
                <div id="motorcycle-cash" class="summary-card report-table-card">
                    <div class="summary-section-header compact">
                        <div>
                            <h5 class="mb-1 dashboard-card-title">Motorcycle Cash Transactions</h5>
                            <p class="mb-0">
                                Lucky 4 and Motor 8 motorcycle cash sales summary by branch.
                            </p>
                        </div>
                        <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
                    </div>

                    <div class="p-3 p-md-4">
                        <div class="report-matrix report-desktop-table">
                            <div class="report-matrix-row report-matrix-group-row">
                                <div class="report-matrix-cell group">Branch</div>
                                <div class="report-matrix-cell group span-4">Sales Today</div>
                                <div class="report-matrix-cell group span-4">Sales To Date</div>
                                <div class="report-matrix-cell group span-2">Total</div>
                            </div>
                            <div class="report-matrix-row report-matrix-subheader-row">
                                <div class="report-matrix-cell sub" aria-hidden="true"></div>
                                <div class="report-matrix-cell sub">BN Unit</div>
                                <div class="report-matrix-cell sub">BN COD</div>
                                <div class="report-matrix-cell sub">Repo Unit</div>
                                <div class="report-matrix-cell sub">Repo COD</div>
                                <div class="report-matrix-cell sub">BN Unit</div>
                                <div class="report-matrix-cell sub">BN COD</div>
                                <div class="report-matrix-cell sub">Repo Unit</div>
                                <div class="report-matrix-cell sub">Repo COD</div>
                                <div class="report-matrix-cell sub">Unit</div>
                                <div class="report-matrix-cell sub">COD</div>
                            </div>
                            @forelse($motorcycleCashSummary as $row)
                                <div class="report-matrix-row report-matrix-body-row">
                                    <div class="report-matrix-cell report-matrix-branch-cell">
                                        <div class="branch-name">{{ $row->branch_name }}</div>
                                        <div class="branch-code">{{ $row->branch_code }}</div>
                                    </div>
                                    <div class="report-matrix-cell numeric">{{ $row->today_brand_new_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_brand_new_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $row->today_repo_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_repo_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $row->todate_brand_new_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_brand_new_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $row->todate_repo_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_repo_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric fw-semibold">{{ $row->total_units }}</div>
                                    <div class="report-matrix-cell numeric fw-semibold">{{ number_format((float) $row->total_cod, 2) }}</div>
                                </div>
                            @empty
                                <div class="reporting-detail-empty report-matrix-empty">
                                    No motorcycle cash transaction data found. Try changing the date range, branch, or business unit filter.
                                </div>
                            @endforelse
                            @if($motorcycleCashSummary->isNotEmpty())
                                <div class="report-matrix-row report-matrix-total-row">
                                    <div class="report-matrix-cell report-matrix-branch-cell">TOTAL</div>
                                    <div class="report-matrix-cell numeric">{{ $motorcycleCashTotals->today_brand_new_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $motorcycleCashTotals->today_brand_new_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $motorcycleCashTotals->today_repo_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $motorcycleCashTotals->today_repo_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $motorcycleCashTotals->todate_brand_new_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $motorcycleCashTotals->todate_brand_new_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $motorcycleCashTotals->todate_repo_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $motorcycleCashTotals->todate_repo_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $motorcycleCashTotals->total_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $motorcycleCashTotals->total_cod, 2) }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="report-mobile-cards">
                            @forelse($motorcycleCashSummary as $row)
                                <article class="mobile-report-card">
                                    <div class="mobile-report-branch">{{ $row->branch_name }}</div>
                                    <div class="mobile-report-code">{{ $row->branch_code }}</div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Sales Today</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">BN</span>
                                            <span class="mobile-report-value">{{ number_format((int) $row->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_brand_new_cod, 2) }}</span>
                                        </div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Repo</span>
                                            <span class="mobile-report-value">{{ number_format((int) $row->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_repo_cod, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Sales To Date</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">BN</span>
                                            <span class="mobile-report-value">{{ number_format((int) $row->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_brand_new_cod, 2) }}</span>
                                        </div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Repo</span>
                                            <span class="mobile-report-value">{{ number_format((int) $row->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_repo_cod, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Total</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Unit / COD</span>
                                            <span class="mobile-report-value">{{ number_format((int) $row->total_units) }} unit(s) - &#8369;{{ number_format((float) $row->total_cod, 2) }}</span>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="reporting-detail-empty">
                                    No report data available for the selected filters.
                                </div>
                            @endforelse

                            @if($motorcycleCashSummary->isNotEmpty())
                                <article class="mobile-report-card total">
                                    <div class="mobile-report-branch">TOTAL</div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Sales Today</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">BN</span>
                                            <span class="mobile-report-value">{{ number_format((int) $motorcycleCashTotals->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $motorcycleCashTotals->today_brand_new_cod, 2) }}</span>
                                        </div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Repo</span>
                                            <span class="mobile-report-value">{{ number_format((int) $motorcycleCashTotals->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $motorcycleCashTotals->today_repo_cod, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Sales To Date</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">BN</span>
                                            <span class="mobile-report-value">{{ number_format((int) $motorcycleCashTotals->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $motorcycleCashTotals->todate_brand_new_cod, 2) }}</span>
                                        </div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Repo</span>
                                            <span class="mobile-report-value">{{ number_format((int) $motorcycleCashTotals->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $motorcycleCashTotals->todate_repo_cod, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Total</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Unit / COD</span>
                                            <span class="mobile-report-value">{{ number_format((int) $motorcycleCashTotals->total_units) }} unit(s) - &#8369;{{ number_format((float) $motorcycleCashTotals->total_cod, 2) }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endif
                        </div>
                    </div>
                </div>
                <div id="combined-cash" class="summary-card report-table-card">
                    <div class="summary-section-header compact">
                        <div>
                            <h5 class="mb-1 dashboard-card-title">Combined Motorcycle and Appliances Cash Transactions</h5>
                            <p class="mb-0">
                                Lucky 4 and Motor 8 motorcycle combined with appliances cash sales summary by branch.
                            </p>
                        </div>
                        <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
                    </div>

                    <div class="p-3 p-md-4">
                        <div class="report-matrix report-desktop-table">
                            <div class="report-matrix-row report-matrix-group-row">
                                <div class="report-matrix-cell group">Branch</div>
                                <div class="report-matrix-cell group span-4">Sales Today</div>
                                <div class="report-matrix-cell group span-4">Sales To Date</div>
                                <div class="report-matrix-cell group span-2">Total</div>
                            </div>
                            <div class="report-matrix-row report-matrix-subheader-row">
                                <div class="report-matrix-cell sub" aria-hidden="true"></div>
                                <div class="report-matrix-cell sub">BN Unit</div>
                                <div class="report-matrix-cell sub">BN COD</div>
                                <div class="report-matrix-cell sub">Repo Unit</div>
                                <div class="report-matrix-cell sub">Repo COD</div>
                                <div class="report-matrix-cell sub">BN Unit</div>
                                <div class="report-matrix-cell sub">BN COD</div>
                                <div class="report-matrix-cell sub">Repo Unit</div>
                                <div class="report-matrix-cell sub">Repo COD</div>
                                <div class="report-matrix-cell sub">Unit</div>
                                <div class="report-matrix-cell sub">COD</div>
                            </div>
                            @forelse($combinedCashSummary as $row)
                                <div class="report-matrix-row report-matrix-body-row">
                                    <div class="report-matrix-cell report-matrix-branch-cell">
                                        <div class="branch-name">{{ $row->branch_name }}</div>
                                        <div class="branch-code">{{ $row->branch_code }}</div>
                                    </div>
                                    <div class="report-matrix-cell numeric">{{ $row->today_brand_new_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_brand_new_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $row->today_repo_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_repo_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $row->todate_brand_new_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_brand_new_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $row->todate_repo_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_repo_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric fw-semibold">{{ $row->total_units }}</div>
                                    <div class="report-matrix-cell numeric fw-semibold">{{ number_format((float) $row->total_cod, 2) }}</div>
                                </div>
                            @empty
                                <div class="reporting-detail-empty report-matrix-empty">
                                    No combined cash transaction data found. Try changing the date range, branch, or business unit filter.
                                </div>
                            @endforelse
                            @if($combinedCashSummary->isNotEmpty())
                                <div class="report-matrix-row report-matrix-total-row">
                                    <div class="report-matrix-cell report-matrix-branch-cell">TOTAL</div>
                                    <div class="report-matrix-cell numeric">{{ $combinedCashTotals->today_brand_new_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $combinedCashTotals->today_brand_new_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $combinedCashTotals->today_repo_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $combinedCashTotals->today_repo_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $combinedCashTotals->todate_brand_new_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $combinedCashTotals->todate_brand_new_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $combinedCashTotals->todate_repo_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $combinedCashTotals->todate_repo_cod, 2) }}</div>
                                    <div class="report-matrix-cell numeric">{{ $combinedCashTotals->total_units }}</div>
                                    <div class="report-matrix-cell numeric">{{ number_format((float) $combinedCashTotals->total_cod, 2) }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="report-mobile-cards">
                            @forelse($combinedCashSummary as $row)
                                <article class="mobile-report-card">
                                    <div class="mobile-report-branch">{{ $row->branch_name }}</div>
                                    <div class="mobile-report-code">{{ $row->branch_code }}</div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Sales Today</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">BN</span>
                                            <span class="mobile-report-value">{{ number_format((int) $row->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_brand_new_cod, 2) }}</span>
                                        </div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Repo</span>
                                            <span class="mobile-report-value">{{ number_format((int) $row->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_repo_cod, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Sales To Date</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">BN</span>
                                            <span class="mobile-report-value">{{ number_format((int) $row->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_brand_new_cod, 2) }}</span>
                                        </div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Repo</span>
                                            <span class="mobile-report-value">{{ number_format((int) $row->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_repo_cod, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Total</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Unit / COD</span>
                                            <span class="mobile-report-value">{{ number_format((int) $row->total_units) }} unit(s) - &#8369;{{ number_format((float) $row->total_cod, 2) }}</span>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="reporting-detail-empty">
                                    No report data available for the selected filters.
                                </div>
                            @endforelse

                            @if($combinedCashSummary->isNotEmpty())
                                <article class="mobile-report-card total">
                                    <div class="mobile-report-branch">TOTAL</div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Sales Today</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">BN</span>
                                            <span class="mobile-report-value">{{ number_format((int) $combinedCashTotals->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $combinedCashTotals->today_brand_new_cod, 2) }}</span>
                                        </div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Repo</span>
                                            <span class="mobile-report-value">{{ number_format((int) $combinedCashTotals->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $combinedCashTotals->today_repo_cod, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Sales To Date</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">BN</span>
                                            <span class="mobile-report-value">{{ number_format((int) $combinedCashTotals->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $combinedCashTotals->todate_brand_new_cod, 2) }}</span>
                                        </div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Repo</span>
                                            <span class="mobile-report-value">{{ number_format((int) $combinedCashTotals->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $combinedCashTotals->todate_repo_cod, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="mobile-report-section">
                                        <div class="mobile-report-section-title">Total</div>
                                        <div class="mobile-report-row">
                                            <span class="mobile-report-label">Unit / COD</span>
                                            <span class="mobile-report-value">{{ number_format((int) $combinedCashTotals->total_units) }} unit(s) - &#8369;{{ number_format((float) $combinedCashTotals->total_cod, 2) }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endif
                        </div>
                    </div>
                </div>

        <div id="appliance-installment" class="summary-card report-table-card">
            <div class="summary-section-header compact">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Appliance Installment Transactions</h5>
                    <p class="mb-0">
                        Lucky 4 appliance installment sales summary by branch.
                    </p>
                </div>
                <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
            </div>

            <div class="p-3 p-md-4">
                <div class="report-matrix report-desktop-table">
                    <div class="report-matrix-row report-matrix-group-row">
                        <div class="report-matrix-cell group">Branch</div>
                        <div class="report-matrix-cell group span-4">Sales Today</div>
                        <div class="report-matrix-cell group span-4">Sales To Date</div>
                        <div class="report-matrix-cell group span-2">Total</div>
                    </div>
                    <div class="report-matrix-row report-matrix-subheader-row">
                        <div class="report-matrix-cell sub" aria-hidden="true"></div>
                        <div class="report-matrix-cell sub">BN Unit</div>
                        <div class="report-matrix-cell sub">BN PN</div>
                        <div class="report-matrix-cell sub">Repo Unit</div>
                        <div class="report-matrix-cell sub">Repo PN</div>
                        <div class="report-matrix-cell sub">BN Unit</div>
                        <div class="report-matrix-cell sub">BN PN</div>
                        <div class="report-matrix-cell sub">Repo Unit</div>
                        <div class="report-matrix-cell sub">Repo PN</div>
                        <div class="report-matrix-cell sub">Unit</div>
                        <div class="report-matrix-cell sub">PN</div>
                    </div>
                    @forelse($applianceInstallmentSummary as $row)
                        <div class="report-matrix-row report-matrix-body-row">
                            <div class="report-matrix-cell report-matrix-branch-cell">
                                <div class="branch-name">{{ $row->branch_name }}</div>
                                <div class="branch-code">{{ $row->branch_code }}</div>
                            </div>
                            <div class="report-matrix-cell numeric">{{ $row->today_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $row->today_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $row->todate_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $row->todate_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric fw-semibold">{{ $row->total_units }}</div>
                            <div class="report-matrix-cell numeric fw-semibold">{{ number_format((float) $row->total_amount, 2) }}</div>
                        </div>
                    @empty
                        <div class="reporting-detail-empty report-matrix-empty">
                            No appliance installment sales transaction data found. Try changing the date range, branch, or business unit filter.
                        </div>
                    @endforelse
                    @if($applianceInstallmentSummary->isNotEmpty())
                        <div class="report-matrix-row report-matrix-total-row">
                            <div class="report-matrix-cell report-matrix-branch-cell">TOTAL</div>
                            <div class="report-matrix-cell numeric">{{ $applianceInstallmentTotals->today_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $applianceInstallmentTotals->today_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $applianceInstallmentTotals->today_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $applianceInstallmentTotals->today_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $applianceInstallmentTotals->todate_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $applianceInstallmentTotals->todate_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $applianceInstallmentTotals->todate_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $applianceInstallmentTotals->todate_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $applianceInstallmentTotals->total_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $applianceInstallmentTotals->total_amount, 2) }}</div>
                        </div>
                    @endif
                </div>

                <div class="report-mobile-cards">
                    @forelse($applianceInstallmentSummary as $row)
                        <article class="mobile-report-card">
                            <div class="mobile-report-branch">{{ $row->branch_name }}</div>
                            <div class="mobile-report-code">{{ $row->branch_code }}</div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales Today</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales To Date</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Total</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Unit / PN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->total_units) }} unit(s) - &#8369;{{ number_format((float) $row->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="reporting-detail-empty">
                            No report data available for the selected filters.
                        </div>
                    @endforelse

                    @if($applianceInstallmentSummary->isNotEmpty())
                        <article class="mobile-report-card total">
                            <div class="mobile-report-branch">TOTAL</div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales Today</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $applianceInstallmentTotals->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $applianceInstallmentTotals->today_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $applianceInstallmentTotals->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $applianceInstallmentTotals->today_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales To Date</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $applianceInstallmentTotals->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $applianceInstallmentTotals->todate_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $applianceInstallmentTotals->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $applianceInstallmentTotals->todate_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Total</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Unit / PN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $applianceInstallmentTotals->total_units) }} unit(s) - &#8369;{{ number_format((float) $applianceInstallmentTotals->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </article>
                    @endif
                </div>
            </div>
        </div>

        <div id="motorcycle-installment" class="summary-card report-table-card">
            <div class="summary-section-header compact">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Motorcycle Installment Transactions</h5>
                    <p class="mb-0">
                        Lucky 4 and Motor 8 motorcycle installment sales summary by branch.
                    </p>
                </div>
                <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
            </div>

            <div class="p-3 p-md-4">
                <div class="report-matrix report-desktop-table">
                    <div class="report-matrix-row report-matrix-group-row">
                        <div class="report-matrix-cell group">Branch</div>
                        <div class="report-matrix-cell group span-4">Sales Today</div>
                        <div class="report-matrix-cell group span-4">Sales To Date</div>
                        <div class="report-matrix-cell group span-2">Total</div>
                    </div>
                    <div class="report-matrix-row report-matrix-subheader-row">
                        <div class="report-matrix-cell sub" aria-hidden="true"></div>
                        <div class="report-matrix-cell sub">BN Unit</div>
                        <div class="report-matrix-cell sub">BN PN</div>
                        <div class="report-matrix-cell sub">Repo Unit</div>
                        <div class="report-matrix-cell sub">Repo PN</div>
                        <div class="report-matrix-cell sub">BN Unit</div>
                        <div class="report-matrix-cell sub">BN PN</div>
                        <div class="report-matrix-cell sub">Repo Unit</div>
                        <div class="report-matrix-cell sub">Repo PN</div>
                        <div class="report-matrix-cell sub">Unit</div>
                        <div class="report-matrix-cell sub">PN</div>
                    </div>
                    @forelse($motorcycleInstallmentSummary as $row)
                        <div class="report-matrix-row report-matrix-body-row">
                            <div class="report-matrix-cell report-matrix-branch-cell">
                                <div class="branch-name">{{ $row->branch_name }}</div>
                                <div class="branch-code">{{ $row->branch_code }}</div>
                            </div>
                            <div class="report-matrix-cell numeric">{{ $row->today_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $row->today_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $row->todate_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $row->todate_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric fw-semibold">{{ $row->total_units }}</div>
                            <div class="report-matrix-cell numeric fw-semibold">{{ number_format((float) $row->total_amount, 2) }}</div>
                        </div>
                    @empty
                        <div class="reporting-detail-empty report-matrix-empty">
                            No motorcycle installment transaction data found. Try changing the date range, branch, or business unit filter.
                        </div>
                    @endforelse
                    @if($motorcycleInstallmentSummary->isNotEmpty())
                        <div class="report-matrix-row report-matrix-total-row">
                            <div class="report-matrix-cell report-matrix-branch-cell">TOTAL</div>
                            <div class="report-matrix-cell numeric">{{ $motorcycleInstallmentTotals->today_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $motorcycleInstallmentTotals->today_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $motorcycleInstallmentTotals->today_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $motorcycleInstallmentTotals->today_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $motorcycleInstallmentTotals->todate_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $motorcycleInstallmentTotals->todate_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $motorcycleInstallmentTotals->todate_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $motorcycleInstallmentTotals->todate_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $motorcycleInstallmentTotals->total_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $motorcycleInstallmentTotals->total_amount, 2) }}</div>
                        </div>
                    @endif
                </div>

                <div class="report-mobile-cards">
                    @forelse($motorcycleInstallmentSummary as $row)
                        <article class="mobile-report-card">
                            <div class="mobile-report-branch">{{ $row->branch_name }}</div>
                            <div class="mobile-report-code">{{ $row->branch_code }}</div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales Today</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales To Date</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Total</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Unit / PN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->total_units) }} unit(s) - &#8369;{{ number_format((float) $row->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="reporting-detail-empty">
                            No report data available for the selected filters.
                        </div>
                    @endforelse

                    @if($motorcycleInstallmentSummary->isNotEmpty())
                        <article class="mobile-report-card total">
                            <div class="mobile-report-branch">TOTAL</div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales Today</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $motorcycleInstallmentTotals->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $motorcycleInstallmentTotals->today_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $motorcycleInstallmentTotals->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $motorcycleInstallmentTotals->today_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales To Date</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $motorcycleInstallmentTotals->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $motorcycleInstallmentTotals->todate_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $motorcycleInstallmentTotals->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $motorcycleInstallmentTotals->todate_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Total</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Unit / PN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $motorcycleInstallmentTotals->total_units) }} unit(s) - &#8369;{{ number_format((float) $motorcycleInstallmentTotals->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </article>
                    @endif
                </div>
            </div>
        </div>

        <div id="combined-installment" class="summary-card report-table-card">
            <div class="summary-section-header compact">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Combined Motorcycle and Appliances Installment Transactions</h5>
                    <p class="mb-0">
                        Lucky 4 and Motor 8 combined installment sales summary by branch.
                    </p>
                </div>
                <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
            </div>

            <div class="p-3 p-md-4">
                <div class="report-matrix report-desktop-table">
                    <div class="report-matrix-row report-matrix-group-row">
                        <div class="report-matrix-cell group">Branch</div>
                        <div class="report-matrix-cell group span-4">Sales Today</div>
                        <div class="report-matrix-cell group span-4">Sales To Date</div>
                        <div class="report-matrix-cell group span-2">Total</div>
                    </div>
                    <div class="report-matrix-row report-matrix-subheader-row">
                        <div class="report-matrix-cell sub" aria-hidden="true"></div>
                        <div class="report-matrix-cell sub">BN Unit</div>
                        <div class="report-matrix-cell sub">BN PN</div>
                        <div class="report-matrix-cell sub">Repo Unit</div>
                        <div class="report-matrix-cell sub">Repo PN</div>
                        <div class="report-matrix-cell sub">BN Unit</div>
                        <div class="report-matrix-cell sub">BN PN</div>
                        <div class="report-matrix-cell sub">Repo Unit</div>
                        <div class="report-matrix-cell sub">Repo PN</div>
                        <div class="report-matrix-cell sub">Unit</div>
                        <div class="report-matrix-cell sub">PN</div>
                    </div>
                    @forelse($combinedInstallmentSummary as $row)
                        <div class="report-matrix-row report-matrix-body-row">
                            <div class="report-matrix-cell report-matrix-branch-cell">
                                <div class="branch-name">{{ $row->branch_name }}</div>
                                <div class="branch-code">{{ $row->branch_code }}</div>
                            </div>
                            <div class="report-matrix-cell numeric">{{ $row->today_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $row->today_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->today_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $row->todate_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $row->todate_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $row->todate_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric fw-semibold">{{ $row->total_units }}</div>
                            <div class="report-matrix-cell numeric fw-semibold">{{ number_format((float) $row->total_amount, 2) }}</div>
                        </div>
                    @empty
                        <div class="reporting-detail-empty report-matrix-empty">
                            No combined installment sales transaction data found. Try changing the date range, branch, or business unit filter.
                        </div>
                    @endforelse
                    @if($combinedInstallmentSummary->isNotEmpty())
                        <div class="report-matrix-row report-matrix-total-row">
                            <div class="report-matrix-cell report-matrix-branch-cell">TOTAL</div>
                            <div class="report-matrix-cell numeric">{{ $combinedInstallmentTotals->today_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $combinedInstallmentTotals->today_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $combinedInstallmentTotals->today_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $combinedInstallmentTotals->today_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $combinedInstallmentTotals->todate_brand_new_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $combinedInstallmentTotals->todate_brand_new_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $combinedInstallmentTotals->todate_repo_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $combinedInstallmentTotals->todate_repo_amount, 2) }}</div>
                            <div class="report-matrix-cell numeric">{{ $combinedInstallmentTotals->total_units }}</div>
                            <div class="report-matrix-cell numeric">{{ number_format((float) $combinedInstallmentTotals->total_amount, 2) }}</div>
                        </div>
                    @endif
                </div>

                <div class="report-mobile-cards">
                    @forelse($combinedInstallmentSummary as $row)
                        <article class="mobile-report-card">
                            <div class="mobile-report-branch">{{ $row->branch_name }}</div>
                            <div class="mobile-report-code">{{ $row->branch_code }}</div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales Today</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->today_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales To Date</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $row->todate_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Total</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Unit / PN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $row->total_units) }} unit(s) - &#8369;{{ number_format((float) $row->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="reporting-detail-empty">
                            No report data available for the selected filters.
                        </div>
                    @endforelse

                    @if($combinedInstallmentSummary->isNotEmpty())
                        <article class="mobile-report-card total">
                            <div class="mobile-report-branch">TOTAL</div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales Today</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $combinedInstallmentTotals->today_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $combinedInstallmentTotals->today_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $combinedInstallmentTotals->today_repo_units) }} unit(s) - &#8369;{{ number_format((float) $combinedInstallmentTotals->today_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales To Date</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">BN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $combinedInstallmentTotals->todate_brand_new_units) }} unit(s) - &#8369;{{ number_format((float) $combinedInstallmentTotals->todate_brand_new_amount, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Repo</span>
                                    <span class="mobile-report-value">{{ number_format((int) $combinedInstallmentTotals->todate_repo_units) }} unit(s) - &#8369;{{ number_format((float) $combinedInstallmentTotals->todate_repo_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Total</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Unit / PN</span>
                                    <span class="mobile-report-value">{{ number_format((int) $combinedInstallmentTotals->total_units) }} unit(s) - &#8369;{{ number_format((float) $combinedInstallmentTotals->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </article>
                    @endif
                </div>
            </div>
        </div>

        <div id="report-branch-sales" class="summary-card report-table-card">
            <div class="summary-section-header compact">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <div>
                        <h5 class="mb-1 dashboard-card-title">Branch Sales Report</h5>
                        <p class="mb-0">
                            Branch-level cash, PN / installment, and total sales under the selected filters.
                        </p>
                    </div>
                </div>
                <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
            </div>

            <div class="p-3 p-md-4">
                <div class="table-responsive report-desktop-table report-table-wrap">
                    <table class="branch-sales-table">
                        <thead class="table-light">
                            <tr>
                                <th class="branch-name">Branch</th>
                                <th class="numeric">Transactions</th>
                                <th class="numeric">Cash</th>
                                <th class="numeric">PN / Installment</th>
                                <th class="numeric">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branchPerformanceSummary as $branch)
                                <tr>
                                    <td class="branch-name">
                                        <div class="branch-name">{{ $branch->branch_name }}</div>
                                        <div class="branch-code">{{ $branch->branch_code }}</div>
                                    </td>
                                    <td class="numeric">{{ number_format((int) $branch->transaction_count) }}</td>
                                    <td class="numeric fw-semibold">&#8369;{{ number_format((float) $branch->cash_total, 2) }}</td>
                                    <td class="numeric fw-semibold">&#8369;{{ number_format((float) $branch->pn_total, 2) }}</td>
                                    <td class="numeric fw-semibold">&#8369;{{ number_format((float) $branch->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No branch sales data available for the selected filters.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="report-mobile-cards">
                    @forelse($branchPerformanceSummary as $branch)
                        <article class="mobile-report-card">
                            <div class="mobile-report-branch">{{ $branch->branch_name }}</div>
                            <div class="mobile-report-code">{{ $branch->branch_code }}</div>

                            <div class="mobile-report-section">
                                <div class="mobile-report-section-title">Sales</div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Transactions</span>
                                    <span class="mobile-report-value">{{ number_format((int) $branch->transaction_count) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Cash</span>
                                    <span class="mobile-report-value">&#8369;{{ number_format((float) $branch->cash_total, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">PN / Installment</span>
                                    <span class="mobile-report-value">&#8369;{{ number_format((float) $branch->pn_total, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Total</span>
                                    <span class="mobile-report-value">&#8369;{{ number_format((float) $branch->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="reporting-detail-empty">
                            No branch sales data available for the selected filters.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div id="report-business-unit-totals" class="summary-card report-table-card business-unit-totals-section">
            <div class="summary-section-header compact">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Business Unit Totals</h5>
                    <p class="mb-0">Business unit sales totals for the selected filters.</p>
                </div>
                <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
            </div>
            <div class="p-3 p-md-4">
                <div class="table-responsive report-desktop-table report-table-wrap">
                    <table class="business-unit-table">
                        <thead class="table-light">
                            <tr>
                                <th class="business-unit-name">Business Unit</th>
                                <th class="code-col">Code</th>
                                <th class="numeric">Branch Count</th>
                                <th class="numeric">Transaction Count</th>
                                <th class="numeric">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($businessUnitTotals as $unit)
                                <tr>
                                    <td class="business-unit-name">
                                        {{ $unit->name }}
                                    </td>
                                    <td class="code-col">
                                        <span class="badge rounded-pill text-bg-dark">{{ $unit->code }}</span>
                                    </td>
                                    <td class="numeric">{{ number_format((int) $unit->branch_count) }}</td>
                                    <td class="numeric">{{ number_format((int) $unit->transaction_count) }}</td>
                                    <td class="numeric fw-semibold">&#8369;{{ number_format((float) $unit->total_amount, 2) }}</td>
                                </tr>
                           @empty
                                <tr>
                                    <td colspan="5" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No business unit totals available for the selected filters.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="report-mobile-cards">
                    @forelse($businessUnitTotals as $unit)
                        <article class="mobile-report-card">
                            <div class="mobile-report-branch">{{ $unit->name }}</div>
                            <div class="mobile-report-code">{{ $unit->code }}</div>

                            <div class="mobile-report-section">
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Branches</span>
                                    <span class="mobile-report-value">{{ number_format((int) $unit->branch_count) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Transactions</span>
                                    <span class="mobile-report-value">{{ number_format((int) $unit->transaction_count) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Total Amount</span>
                                    <span class="mobile-report-value">&#8369;{{ number_format((float) $unit->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="reporting-detail-empty">
                            No business unit totals available for the selected filters.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div id="report-latest-sales" class="summary-card report-table-card latest-sales-section mb-4">
            <div class="summary-section-header compact">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Latest Sales Transactions</h5>
                    <p class="mb-0">Recent sales transaction records for the selected filters.</p>
                </div>
                <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
            </div>
            <div class="p-3 p-md-4">
                <div class="table-responsive latest-sales-desktop-table report-table-wrap">
                    <table class="latest-sales-table">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Branch</th>
                                <th>Product / Model</th>
                                <th>Product Line</th>
                                <th>Transaction Type</th>
                                <th class="numeric">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestTransactions as $transaction)
                                @php
                                    $latestProduct = $transaction->model
                                        ?: ($transaction->product
                                            ?: ($transaction->product_description
                                                ?: ($transaction->parts_number ?: '—')));
                                    $latestAmountCandidates = [
                                        $transaction->promissory_note_amount,
                                        $transaction->cash_amount,
                                        $transaction->gross_sales_amount,
                                        $transaction->amount,
                                    ];
                                    $latestAmount = collect($latestAmountCandidates)
                                        ->first(fn ($value) => $value !== null && (float) $value !== 0.0);
                                    $latestAmount ??= collect($latestAmountCandidates)
                                        ->first(fn ($value) => $value !== null);
                                @endphp
                                <tr>
                                    <td class="text-nowrap">
                                        {{ $transaction->invoice_date ? \Carbon\Carbon::parse($transaction->invoice_date)->format('M d, Y') : '—' }}
                                    </td>
                                    <td class="truncate-cell" title="{{ $transaction->customer_name ?? 'Unknown' }}">
                                        <a href="{{ route('sales-transactions.show', $transaction) }}" class="primary-text text-decoration-none">
                                            {{ $transaction->customer_name ?? 'Unknown' }}
                                        </a>
                                        <div class="muted-text">{{ $transaction->account_number ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        <div class="primary-text">{{ $transaction->branch->display_name ?? 'Unknown' }}</div>
                                    </td>
                                    <td>
                                        <div class="primary-text">{{ $latestProduct }}</div>
                                        <div class="muted-text">{{ $transaction->brand_name_raw ?? '—' }}</div>
                                    </td>
                                    <td>{{ $transaction->product_line_name ?? '—' }}</td>
                                    <td>{{ $transaction->transaction_type ?? '—' }}</td>
                                    <td class="numeric fw-semibold">
                                        @if($latestAmount !== null)
                                            &#8369;{{ number_format((float) $latestAmount, 2) }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No latest sales transactions available for the selected filters.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="latest-sales-mobile-cards">
                    @forelse($latestTransactions as $transaction)
                        @php
                            $latestProduct = $transaction->model
                                ?: ($transaction->product
                                    ?: ($transaction->product_description
                                        ?: ($transaction->parts_number ?: '—')));
                            $latestAmountCandidates = [
                                $transaction->promissory_note_amount,
                                $transaction->cash_amount,
                                $transaction->gross_sales_amount,
                                $transaction->amount,
                            ];
                            $latestAmount = collect($latestAmountCandidates)
                                ->first(fn ($value) => $value !== null && (float) $value !== 0.0);
                            $latestAmount ??= collect($latestAmountCandidates)
                                ->first(fn ($value) => $value !== null);
                        @endphp
                        <article class="latest-sales-card">
                            <div class="latest-sales-card-title">
                                <a href="{{ route('sales-transactions.show', $transaction) }}" class="text-decoration-none text-reset">
                                    {{ $transaction->customer_name ?? 'Unknown' }}
                                </a>
                            </div>
                            <div class="latest-sales-card-date">
                                {{ $transaction->invoice_date ? \Carbon\Carbon::parse($transaction->invoice_date)->format('M d, Y') : '—' }}
                            </div>

                            <div class="latest-sales-card-details">
                                <div class="latest-sales-card-row">
                                    <span class="latest-sales-card-label">Branch</span>
                                    <span class="latest-sales-card-value">{{ $transaction->branch->display_name ?? 'Unknown' }}</span>
                                </div>
                                <div class="latest-sales-card-row">
                                    <span class="latest-sales-card-label">Product</span>
                                    <span class="latest-sales-card-value">{{ $latestProduct }}</span>
                                </div>
                                <div class="latest-sales-card-row">
                                    <span class="latest-sales-card-label">Product Line</span>
                                    <span class="latest-sales-card-value">{{ $transaction->product_line_name ?? '—' }}</span>
                                </div>
                                <div class="latest-sales-card-row">
                                    <span class="latest-sales-card-label">Type</span>
                                    <span class="latest-sales-card-value">{{ $transaction->transaction_type ?? '—' }}</span>
                                </div>
                                <div class="latest-sales-card-row">
                                    <span class="latest-sales-card-label">Amount</span>
                                    <span class="latest-sales-card-value">
                                        @if($latestAmount !== null)
                                            &#8369;{{ number_format((float) $latestAmount, 2) }}
                                        @else
                                            —
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="reporting-detail-empty">
                            No latest sales transactions available for the selected filters.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div id="report-branch-transaction-total" class="summary-card report-table-card branch-transaction-total-section mb-4">
            <div class="summary-section-header compact">
                <div>
                    <h5 class="mb-1 dashboard-card-title">Branch Transaction Totals</h5>
                    <p class="mb-0">Cash, PN / installment, and total sales by branch for the selected filters.</p>
                </div>
                <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
            </div>
            <div class="p-3 p-md-4">
                <div class="table-responsive branch-transaction-desktop-table report-table-wrap">
                    <table class="branch-transaction-table">
                        <thead class="table-light">
                            <tr>
                                <th class="branch-name">Branch</th>
                                <th class="numeric">Transactions</th>
                                <th class="numeric">Cash Sales</th>
                                <th class="numeric">PN / Installment Sales</th>
                                <th class="numeric">Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branchTotals as $branchTotal)
                                <tr>
                                    <td class="branch-name">
                                        {{ $branchTotal->branch->display_name ?? 'Unknown' }}
                                        <span class="branch-code">{{ $branchTotal->branch->code ?? 'N/A' }}</span>
                                    </td>
                                    <td class="numeric">{{ number_format((int) $branchTotal->transaction_count) }}</td>
                                    <td class="numeric fw-semibold">&#8369;{{ number_format((float) $branchTotal->cash_sales, 2) }}</td>
                                    <td class="numeric fw-semibold">&#8369;{{ number_format((float) $branchTotal->pn_sales, 2) }}</td>
                                    <td class="numeric fw-semibold">&#8369;{{ number_format((float) $branchTotal->total_sales, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3">
                                        <div class="dashboard-empty-state text-center">
                                            <div class="dashboard-empty-state-title">
                                                No branch transaction totals available for the selected filters.
                                            </div>
                                            <p class="dashboard-empty-state-text">
                                                Try changing the date range, branch, or business unit filter.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="branch-transaction-mobile-cards">
                    @forelse($branchTotals as $branchTotal)
                        <article class="mobile-report-card">
                            <div class="mobile-report-branch">{{ $branchTotal->branch->display_name ?? 'Unknown' }}</div>
                            <div class="mobile-report-code">{{ $branchTotal->branch->code ?? 'N/A' }}</div>

                            <div class="mobile-report-section">
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Transactions</span>
                                    <span class="mobile-report-value">{{ number_format((int) $branchTotal->transaction_count) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Cash Sales</span>
                                    <span class="mobile-report-value">&#8369;{{ number_format((float) $branchTotal->cash_sales, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">PN / Installment</span>
                                    <span class="mobile-report-value">&#8369;{{ number_format((float) $branchTotal->pn_sales, 2) }}</span>
                                </div>
                                <div class="mobile-report-row">
                                    <span class="mobile-report-label">Total Sales</span>
                                    <span class="mobile-report-value">&#8369;{{ number_format((float) $branchTotal->total_sales, 2) }}</span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="reporting-detail-empty">
                            No branch transaction totals available for the selected filters.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if(auth()->user()->hasAnyRole(['importer', 'admin', 'super_admin']))
            <div id="report-latest-imports" class="summary-card report-table-card latest-imports-section mb-4">
                <div class="summary-section-header compact">
                    <div>
                        <h5 class="mb-1 dashboard-card-title">Latest Import Batches</h5>
                        <p class="mb-0">Recent uploaded import batches and processing status.</p>
                    </div>
                    <span class="reporting-scope-pill">{{ $datePresetLabel ?? 'This Month' }}</span>
                </div>
                <div class="p-3 p-md-4">
                    <div class="table-responsive latest-imports-desktop-table report-table-wrap">
                        <table class="latest-imports-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Batch</th>
                                    <th>Filename</th>
                                    <th>Uploaded By</th>
                                    <th>Uploaded</th>
                                    <th>Rows / Sheets</th>
                                    <th class="status-cell">Status</th>
                                    <th class="action-cell">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestImportBatches as $batch)
                                    @php
                                        $statusValue = $batch->status ?? 'default';
                                        $normalizedStatus = strtolower(str_replace([' ', '_'], '-', $statusValue));
                                        $statusClass = match (true) {
                                            in_array($normalizedStatus, ['completed', 'success', 'processed'], true) => 'import-status-completed',
                                            in_array($normalizedStatus, ['pending', 'processing'], true) => 'import-status-processing',
                                            in_array($normalizedStatus, ['failed', 'error'], true) => 'import-status-failed',
                                            default => 'import-status-default',
                                        };
                                        $uploadedDate = $batch->imported_at ?? $batch->created_at;
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{ route('import-batches.show', $batch) }}" class="primary-text text-decoration-none">
                                                Batch #{{ $batch->id }}
                                            </a>
                                        </td>
                                        <td class="truncate-cell" title="{{ $batch->original_filename }}">
                                            <div class="primary-text">{{ $batch->original_filename ?? 'N/A' }}</div>
                                            <div class="muted-text">{{ $batch->source_type ?? '—' }}</div>
                                        </td>
                                        <td>{{ $batch->user->name ?? 'Unknown' }}</td>
                                        <td>{{ $uploadedDate ? \Carbon\Carbon::parse($uploadedDate)->format('M d, Y') : '—' }}</td>
                                        <td>
                                            <div class="primary-text">{{ number_format((int) ($batch->total_rows ?? 0)) }} rows</div>
                                            <div class="muted-text">{{ number_format((int) ($batch->total_sheets ?? 0)) }} sheets</div>
                                        </td>
                                        <td class="status-cell">
                                            <span class="import-status-badge {{ $statusClass }}">
                                                {{ ucfirst(str_replace(['_', '-'], ' ', $statusValue)) }}
                                            </span>
                                        </td>
                                        <td class="action-cell">
                                            <a href="{{ route('import-batches.show', $batch) }}" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-3">
                                            <div class="dashboard-empty-state text-center">
                                                <div class="dashboard-empty-state-title">
                                                    No latest import batches available.
                                                </div>
                                                <p class="dashboard-empty-state-text">
                                                    No import batches have been uploaded yet.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="latest-imports-mobile-cards">
                        @forelse($latestImportBatches as $batch)
                            @php
                                $statusValue = $batch->status ?? 'default';
                                $normalizedStatus = strtolower(str_replace([' ', '_'], '-', $statusValue));
                                $statusClass = match (true) {
                                    in_array($normalizedStatus, ['completed', 'success', 'processed'], true) => 'import-status-completed',
                                    in_array($normalizedStatus, ['pending', 'processing'], true) => 'import-status-processing',
                                    in_array($normalizedStatus, ['failed', 'error'], true) => 'import-status-failed',
                                    default => 'import-status-default',
                                };
                                $uploadedDate = $batch->imported_at ?? $batch->created_at;
                            @endphp
                            <article class="latest-import-card">
                                <div class="latest-import-card-header">
                                    <div>
                                        <div class="latest-import-card-title">Import Batch #{{ $batch->id }}</div>
                                        <div class="latest-import-card-subtitle">{{ $batch->original_filename ?? 'N/A' }}</div>
                                    </div>
                                    <span class="import-status-badge {{ $statusClass }}">
                                        {{ ucfirst(str_replace(['_', '-'], ' ', $statusValue)) }}
                                    </span>
                                </div>

                                <div class="latest-import-card-details">
                                    <div class="latest-import-card-row">
                                        <span class="latest-import-card-label">Uploaded</span>
                                        <span class="latest-import-card-value">{{ $uploadedDate ? \Carbon\Carbon::parse($uploadedDate)->format('M d, Y') : '—' }}</span>
                                    </div>
                                    <div class="latest-import-card-row">
                                        <span class="latest-import-card-label">Uploaded By</span>
                                        <span class="latest-import-card-value">{{ $batch->user->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="latest-import-card-row">
                                        <span class="latest-import-card-label">Rows</span>
                                        <span class="latest-import-card-value">{{ number_format((int) ($batch->total_rows ?? 0)) }}</span>
                                    </div>
                                    <div class="latest-import-card-row">
                                        <span class="latest-import-card-label">Sheets</span>
                                        <span class="latest-import-card-value">{{ number_format((int) ($batch->total_sheets ?? 0)) }}</span>
                                    </div>
                                </div>

                                <div class="latest-import-card-actions">
                                    <a href="{{ route('import-batches.show', $batch) }}" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold d-inline-flex align-items-center justify-content-center">
                                        View Batch
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="reporting-detail-empty">
                                No latest import batches available.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

    </div>
    <div class="report-fab">
        <div id="reportMenu" class="report-menu">
            <div class="report-menu-header">Reports</div>
            <div class="report-menu-body">
                <div class="report-menu-group">Cash Reports</div>
                <a href="#appliance-cash">Appliance Cash</a>
                <a href="#motorcycle-cash">Motorcycle Cash</a>
                <a href="#combined-cash">Combined Cash</a>

                <div class="report-menu-group">Installment Reports</div>
                <a href="#appliance-installment">Appliance Installment</a>
                <a href="#motorcycle-installment">Motorcycle Installment</a>
                <a href="#combined-installment">Combined Installment</a>

                <div class="report-menu-group">Summary Sections</div>
                <a href="#report-kpi-details">Executive KPI Detail Reports</a>
                <a href="#report-sales-mix-detail">Sales Mix Detail Report</a>
                <a href="#report-product-sales">Product & Sales Report</a>
                <a href="#report-customer">Customer Intelligence</a>
                <a href="#report-branch-sales">Branch Performance</a>
                <a href="#report-business-unit-totals">Business Unit Totals</a>
                <a href="#report-latest-sales">Latest Sales Transactions</a>
                <a href="#report-branch-transaction-total">Branch Transaction Totals</a>
                

                @if(auth()->user()->hasAnyRole(['importer', 'admin', 'super_admin']))
                    <a href="#report-latest-imports">Latest Import Batches</a>
                @endif

            </div>
        </div>

        <button id="reportMenuToggle" type="button" class="btn btn-dark">
            Reports
        </button>
    </div>
        <script>
            const filterToggle = document.querySelector('[data-filter-toggle]');
            const filterPanel = document.querySelector('[data-filter-panel]');

            if (filterToggle && filterPanel) {
                filterToggle.addEventListener('click', function () {
                    const isOpen = filterPanel.classList.toggle('is-open');

                    filterToggle.textContent = isOpen ? 'Hide Filters' : 'Show Filters';
                    filterToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });
            }

            document.querySelectorAll('[data-sales-mix-report], [data-product-sales-report], [data-customer-report]').forEach(function (reportBoard) {
                const tabs = reportBoard.querySelectorAll('[data-report-tab]');
                const panels = reportBoard.querySelectorAll('[data-report-panel]');

                tabs.forEach(function (tab) {
                    tab.addEventListener('click', function () {
                        const target = tab.getAttribute('data-report-tab');

                        tabs.forEach(function (item) {
                            const isActive = item === tab;
                            item.classList.toggle('active', isActive);
                            item.setAttribute('aria-selected', isActive ? 'true' : 'false');
                        });

                        panels.forEach(function (panel) {
                            panel.classList.toggle('active', panel.getAttribute('data-report-panel') === target);
                        });
                    });
                });
            });

            const reportMenuToggle = document.getElementById('reportMenuToggle');
            const reportMenu = document.getElementById('reportMenu');

            if (reportMenuToggle && reportMenu) {
                reportMenuToggle.addEventListener('click', function () {
                    reportMenu.classList.toggle('show');
                });

                document.addEventListener('click', function (event) {
                    const clickedInsideMenu = reportMenu.contains(event.target);
                    const clickedToggle = reportMenuToggle.contains(event.target);

                    if (!clickedInsideMenu && !clickedToggle) {
                        reportMenu.classList.remove('show');
                    }
                });

                reportMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function () {
                        reportMenu.classList.remove('show');
                    });
                });
            }
        </script>
</x-app-layout>
