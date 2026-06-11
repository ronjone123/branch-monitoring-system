<x-app-layout>
    <style>
        :root {
            --exec-bg: #f5f7fb;
            --exec-surface: #ffffff;
            --exec-border: #dfe6f1;
            --exec-text: #0f172a;
            --exec-muted: #64748b;
            --exec-navy: #071b3a;
            --exec-blue: #1268f3;
            --exec-blue-dark: #0b4fc6;
            --exec-green: #20b26b;
            --exec-orange: #f59e0b;
            --exec-purple: #8b5cf6;
            --exec-teal: #14b8a6;
            --exec-red: #ef233c;
            --exec-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        }

        body {
            background:
                radial-gradient(circle at top right, rgba(18, 104, 243, 0.09), transparent 32rem),
                var(--exec-bg);
            color: var(--exec-text);
        }

        .exec-shell {
            max-width: 1780px;
            margin: 0 auto;
            padding-top: 4.75rem;
        }

        .exec-card {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid var(--exec-border);
            border-radius: 0.9rem;
            box-shadow: var(--exec-shadow);
            overflow: hidden;
        }

        .executive-card,
        .executive-section-card {
            height: 100%;
        }

        .exec-filter-card {
            padding: 1.35rem;
            margin-bottom: 1.15rem;
        }

        .executive-filter-mobile-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
            margin-bottom: .85rem;
        }

        .executive-filter-summary-label {
            display: block;
            color: #64748b;
            font-size: .7rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: .15rem;
        }

        .executive-filter-mobile-summary strong {
            color: #0f172a;
            font-size: .95rem;
            font-weight: 900;
        }

        .executive-filter-mobile-summary p {
            margin: .15rem 0 0;
            color: #64748b;
            font-size: .78rem;
            font-weight: 700;
        }

        .executive-filter-toggle {
            border: 1px solid rgba(37, 99, 235, 0.25);
            background: #ffffff;
            color: #2563eb;
            border-radius: 999px;
            padding: .55rem .8rem;
            font-size: .78rem;
            font-weight: 900;
            white-space: nowrap;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.10);
        }

        .executive-filter-toggle:hover {
            background: rgba(96, 165, 250, 0.14);
            border-color: rgba(37, 99, 235, 0.28);
            color: #1d4ed8;
        }

        .executive-filter-collapsible {
            display: none;
            margin-top: .85rem;
        }

        .executive-filter-collapsible.is-open {
            display: block;
        }

        .executive-filter-presets {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .executive-filter-preset {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .45rem .75rem;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            background: #ffffff;
            color: #334155;
            font-size: .8rem;
            font-weight: 700;
            text-decoration: none;
            transition: all .15s ease;
        }

        .executive-filter-preset:hover {
            background: rgba(96, 165, 250, 0.14);
            color: #1d4ed8;
            border-color: rgba(37, 99, 235, 0.28);
            text-decoration: none;
        }

        .executive-filter-preset.active {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
        }

        .executive-filter-preset.active:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #ffffff;
        }

        .executive-filter-grid {
            display: grid;
            grid-template-columns: repeat(8, minmax(0, 1fr));
            gap: 0.75rem;
            align-items: end;
        }

        .executive-filter-grid > * {
            min-width: 0;
        }

        .executive-filter-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .exec-filter-label {
            display: block;
            color: var(--exec-text);
            font-size: 0.78rem;
            font-weight: 800;
            margin-bottom: 0.45rem;
        }

        .form-control,
        .form-select {
            border: 1px solid #cfd8e6;
            border-radius: 0.55rem;
            min-height: 44px;
            color: var(--exec-text);
            font-size: 0.9rem;
            box-shadow: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--exec-blue);
            box-shadow: 0 0 0 0.18rem rgba(18, 104, 243, 0.1);
        }

        .exec-btn-primary {
            min-height: 44px;
            border-radius: 0.55rem;
            border: 1px solid var(--exec-blue);
            background: linear-gradient(135deg, var(--exec-blue), var(--exec-blue-dark));
            color: #fff;
            font-weight: 800;
            padding: 0.65rem 1.15rem;
        }

        .exec-btn-primary:hover {
            color: #fff;
            background: linear-gradient(135deg, var(--exec-blue-dark), #083f9e);
        }

        .exec-btn-outline {
            min-height: 44px;
            border-radius: 0.55rem;
            border: 1px solid #cfd8e6;
            background: #fff;
            color: var(--exec-text);
            font-weight: 800;
            padding: 0.65rem 1.05rem;
        }

        .exec-btn-primary,
        .exec-btn-outline {
            width: 100%;
            white-space: nowrap;
        }

        .executive-hero-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.5rem;
            align-items: stretch;
        }

        .executive-hero-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            padding: 1.25rem;
            height: 100%;
        }

        .executive-hero-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .executive-hero-card-header.compact {
            align-items: center;
            gap: .75rem;
        }

        .executive-hero-card-header.compact h2 {
            margin: 0;
        }

        .executive-hero-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 800;
        }

        .executive-scope-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            border-radius: 999px;
            padding: .35rem .65rem;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #1d4ed8;
            background: rgba(37, 99, 235, 0.10);
            border: 1px solid rgba(37, 99, 235, 0.20);
        }

        .executive-scope-pill-muted {
            color: #475569;
            background: rgba(100, 116, 139, 0.10);
            border-color: rgba(100, 116, 139, 0.20);
        }

        .executive-header-actions {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .executive-report-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .35rem;
            white-space: nowrap;
            border-radius: 999px;
            padding: .42rem .75rem;
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
            font-size: .75rem;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
            text-decoration: none;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
            transition: background .15s ease, border-color .15s ease, transform .15s ease, box-shadow .15s ease;
        }

        .executive-report-link:hover,
        .executive-report-link:focus {
            color: #ffffff;
            background: #1d4ed8;
            border-color: #1d4ed8;
            text-decoration: none;
            box-shadow: 0 10px 22px rgba(29, 78, 216, 0.20);
            transform: translateY(-1px);
        }

        .executive-report-link:active {
            transform: translateY(0);
        }

        .executive-kpi-board-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .85rem;
        }

        .executive-chart-board-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .85rem;
        }

        .executive-chart-panel {
            min-height: 225px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: .9rem;
            background: #f8fafc;
            padding: .9rem;
        }

        .executive-chart-title {
            color: #334155;
            font-size: .74rem;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: .35rem;
        }

        .executive-chart-subtitle {
            color: #64748b;
            font-size: .72rem;
            line-height: 1.35;
            margin-bottom: .65rem;
        }

        .executive-chart-canvas {
            position: relative;
            height: 165px;
        }

        .exec-kpi {
            position: relative;
            height: 100%;
            min-height: 145px;
            border: 1px solid var(--exec-border);
            border-radius: 0.9rem;
            background: #fff;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.07);
            padding: 1.35rem;
            overflow: hidden;
        }

        .executive-kpi-card {
            min-height: 140px;
        }

        .executive-insight-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .executive-insight-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            padding: 1.25rem;
            height: 100%;
        }

        .executive-insight-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .executive-insight-card-header.compact,
        .exec-section-header.compact,
        .pn-target-card-header.compact {
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
        }

        .executive-insight-card-title {
            margin: 0;
            color: #0f172a;
            font-size: 1rem;
            font-weight: 800;
        }

        .executive-insight-inner-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .85rem;
            align-items: stretch;
        }

        .executive-insight-panel {
            min-height: 280px;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: .9rem;
            background: #f8fafc;
            padding: 1rem;
        }

        .executive-insight-panel-title {
            color: #334155;
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: .75rem;
        }

        .executive-insight-value {
            color: #0f172a;
            font-size: 1.35rem;
            font-weight: 800;
        }

        .executive-insight-muted {
            color: #64748b;
            font-size: .82rem;
        }

        .sales-mix-graph-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: .55rem;
            margin-top: .85rem;
        }

        .sales-mix-segment {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 999px;
            background: #ffffff;
            color: #334155;
            padding: .45rem .65rem;
            cursor: pointer;
            min-width: 0;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease, transform .18s ease;
        }

        .sales-mix-segment:hover,
        .sales-mix-segment:focus {
            outline: 0;
            transform: translateY(-1px);
            border-color: rgba(37, 99, 235, 0.28);
            background: #f8fafc;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.06);
        }

        .sales-mix-label {
            color: #0f172a;
            font-weight: 800;
            font-size: .78rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 8.25rem;
        }

        .sales-mix-percent {
            color: #334155;
            font-weight: 800;
            font-size: .76rem;
            white-space: nowrap;
        }

        .sales-mix-segment::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 50%;
            bottom: calc(100% + .65rem);
            transform: translateX(-50%) translateY(4px);
            width: max-content;
            max-width: 260px;
            padding: .55rem .7rem;
            border-radius: .65rem;
            background: #0f172a;
            color: #ffffff;
            font-size: .75rem;
            font-weight: 700;
            line-height: 1.4;
            text-align: left;
            opacity: 0;
            pointer-events: none;
            box-shadow: 0 12px 24px rgba(15, 23, 42, .18);
            transition: opacity .16s ease, transform .16s ease;
            white-space: normal;
            z-index: 30;
        }

        .sales-mix-segment::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: calc(100% + .35rem);
            transform: translateX(-50%);
            border: .35rem solid transparent;
            border-top-color: #0f172a;
            opacity: 0;
            transition: opacity .16s ease;
            z-index: 31;
        }

        .sales-mix-segment:hover::after,
        .sales-mix-segment:focus::after {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .sales-mix-segment:hover::before,
        .sales-mix-segment:focus::before {
            opacity: 1;
        }

        .sales-mix-dot {
            width: .55rem;
            height: .55rem;
            border-radius: 999px;
            flex: 0 0 auto;
            background: #2563eb;
        }

        .metric-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            align-self: flex-start;
            min-height: 40px;
            padding: .55rem .9rem;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #fff;
            margin-bottom: 1rem;
        }

        .metric-pill-brand {
            background: #2563eb;
        }

        .metric-pill-hot {
            background: linear-gradient(135deg, #ef4444, #f97316);
        }

        .metric-pill-term {
            background: #14b8a6;
        }

        .product-rank-list {
            display: flex;
            flex-direction: column;
            gap: .75rem;
            margin-top: .75rem;
        }

        .product-rank-item {
            padding-top: .7rem;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        .product-rank-item:first-child {
            border-top: 0;
            padding-top: 0;
        }

        .product-rank-label {
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
        }

        .product-rank-meta {
            font-size: .8rem;
            color: #64748b;
            margin-top: .12rem;
        }

        .product-rank-amount {
            font-size: .85rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: .18rem;
        }

        .exec-kpi::after {
            content: "";
            position: absolute;
            inset: auto -30px -50px auto;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(18, 104, 243, 0.07);
        }

        .exec-kpi-top {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            margin-bottom: 0.9rem;
        }

        .exec-kpi-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 900;
            font-size: 1.05rem;
            flex: 0 0 auto;
        }

        .exec-kpi-icon.blue { background: linear-gradient(135deg, #1473ff, #0b55d8); }
        .exec-kpi-icon.green { background: linear-gradient(135deg, #32c889, #13985d); }
        .exec-kpi-icon.orange { background: linear-gradient(135deg, #ffb020, #f97316); }
        .exec-kpi-icon.purple { background: linear-gradient(135deg, #9b6cff, #6d42dc); }
        .exec-kpi-icon.teal { background: linear-gradient(135deg, #2dd4bf, #0891b2); }
        .exec-kpi-icon.red { background: linear-gradient(135deg, #ff304d, #d90429); }

        .exec-kpi-label {
            color: #334155;
            font-size: 0.76rem;
            font-weight: 850;
            text-transform: uppercase;
        }

        .exec-kpi-value {
            color: var(--exec-text);
            font-size: 1.45rem;
            font-weight: 900;
            line-height: 1.15;
            position: relative;
            z-index: 1;
            overflow-wrap: anywhere;
        }

        .exec-kpi-sub {
            color: var(--exec-muted);
            font-size: 0.84rem;
            margin-top: 0.55rem;
            position: relative;
            z-index: 1;
        }

        .latest-customer-sales-card {
            min-height: 140px;
        }

        .latest-customer-sale-details {
            position: relative;
            z-index: 1;
        }

        .latest-customer-sale-name {
            color: #0f172a;
            font-size: 1.1rem;
            font-weight: 900;
            line-height: 1.25;
            word-break: normal;
            overflow-wrap: anywhere;
            margin-bottom: .45rem;
        }

        .latest-customer-sale-row {
            color: #0f172a;
            font-size: .82rem;
            font-weight: 800;
            line-height: 1.4;
        }

        .latest-customer-sale-row span {
            color: #64748b;
            font-weight: 800;
        }

        .latest-customer-sale-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: .45rem;
            margin-top: .7rem;
        }

        .latest-customer-sale-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: .22rem .5rem;
            font-size: .68rem;
            font-weight: 900;
            line-height: 1;
            white-space: nowrap;
        }

        .latest-customer-sale-pill.brand-new {
            color: #166534;
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.22);
        }

        .latest-customer-sale-pill.repo {
            color: #92400e;
            background: rgba(245, 158, 11, 0.14);
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .latest-customer-sale-empty {
            position: relative;
            z-index: 1;
            color: #64748b;
            font-size: .82rem;
            font-weight: 700;
            line-height: 1.4;
        }

        .kpi-status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: .5rem;
            padding: .35rem .65rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .kpi-status-hit {
            color: #166534;
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.25);
        }

        .kpi-status-behind {
            color: #991b1b;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .exec-section-card {
            background: #fff;
            border: 1px solid var(--exec-border);
            border-radius: 0.9rem;
            box-shadow: var(--exec-shadow);
            height: 100%;
            overflow: hidden;
        }

        .exec-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.25rem 1.35rem;
            border-bottom: 1px solid var(--exec-border);
            background: linear-gradient(180deg, #fff, #fbfdff);
        }

        .exec-section-title {
            margin: 0;
            color: var(--exec-text);
            font-size: 1.05rem;
            font-weight: 900;
        }

        .exec-link {
            color: var(--exec-blue);
            font-weight: 850;
            font-size: 0.85rem;
            text-decoration: none;
            white-space: nowrap;
        }

        .exec-link:hover {
            color: var(--exec-blue-dark);
        }

        .exec-table {
            width: 100%;
            margin-bottom: 0;
        }

        .exec-table thead th {
            color: #475569;
            background: #f8fafc;
            border-color: #e5eaf2;
            font-size: 0.75rem;
            font-weight: 850;
            text-transform: uppercase;
            white-space: nowrap;
            padding: 0.85rem 1rem;
        }

        .exec-table tbody td {
            border-color: #edf1f7;
            color: var(--exec-text);
            font-size: 0.86rem;
            padding: 0.82rem 1rem;
            vertical-align: middle;
        }

        .cash-installment-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.25rem;
        }

        .report-summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .85rem;
        }

        .report-summary-card {
            height: 100%;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: .9rem;
            background: #f8fafc;
            padding: 1rem;
        }

        .report-summary-label {
            color: #334155;
            font-size: .78rem;
            font-weight: 850;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: .75rem;
        }

        .report-summary-value {
            color: #0f172a;
            font-size: 1.35rem;
            font-weight: 900;
            line-height: 1.15;
            overflow-wrap: anywhere;
        }

        .report-summary-meta {
            color: #64748b;
            font-size: .82rem;
            margin-top: .35rem;
        }

        .report-summary-split {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .65rem;
            margin-top: .9rem;
        }

        .report-summary-mini {
            border: 1px solid rgba(15, 23, 42, 0.07);
            border-radius: .75rem;
            background: #ffffff;
            padding: .7rem;
        }

        .report-summary-mini-label {
            color: #64748b;
            font-size: .7rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .report-summary-mini-value {
            color: #0f172a;
            font-size: .9rem;
            font-weight: 850;
            margin-top: .18rem;
        }

        .customer-intelligence-section {
            margin-bottom: 1.5rem;
        }

        .customer-intelligence-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .customer-intelligence-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            padding: 1.1rem;
            height: 100%;
        }

        .customer-intelligence-label {
            color: #64748b;
            font-size: .78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .customer-intelligence-value {
            color: #0f172a;
            font-size: 1.25rem;
            font-weight: 900;
            line-height: 1.2;
            margin-top: .55rem;
            overflow-wrap: anywhere;
        }

        .customer-intelligence-meta {
            color: #64748b;
            font-size: .82rem;
            margin-top: .35rem;
        }

        .amount-col,
        .count-col {
            text-align: right;
            white-space: nowrap;
        }

        .exec-rank {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #eef4ff;
            color: var(--exec-blue);
            font-size: 0.78rem;
            font-weight: 900;
        }

        .branch-card {
            height: 100%;
            border: 1px solid var(--exec-border);
            border-top: 4px solid var(--exec-blue);
            border-radius: 0.78rem;
            background: #fff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.07);
            padding: 1rem;
        }

        .branch-card.rank-1 { border-top-color: #f5b301; }
        .branch-card.rank-2 { border-top-color: #94a3b8; }
        .branch-card.rank-3 { border-top-color: #b7791f; }

        .branch-card.top-branch-card {
            padding: 1.15rem;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.09);
        }

        .branch-card.mini-branch-card {
            padding: 0.85rem;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
        }

        .branch-top-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .branch-mini-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 1rem;
        }

        .branch-rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.25rem;
            height: 1.75rem;
            border-radius: 999px;
            background: #eaf3ff;
            color: var(--exec-blue);
            font-size: 0.76rem;
            font-weight: 900;
            padding: 0 0.55rem;
            flex: 0 0 auto;
        }

        .branch-rank-badge.rank-1 {
            background: #fff7d6;
            color: #9a6700;
        }

        .branch-rank-badge.rank-2 {
            background: #f1f5f9;
            color: #475569;
        }

        .branch-rank-badge.rank-3 {
            background: #fff1dd;
            color: #92400e;
        }

        .branch-card-title {
            color: var(--exec-text);
            font-size: 0.92rem;
            font-weight: 900;
            line-height: 1.2;
            min-width: 0;
        }

        .top-branch-card .branch-card-title {
            font-size: 1rem;
        }

        .mini-branch-card .branch-card-title {
            font-size: 0.84rem;
        }

        .branch-main-value {
            color: var(--exec-text);
            font-size: 1.25rem;
            font-weight: 900;
            line-height: 1.15;
            margin-top: 0.85rem;
            overflow-wrap: anywhere;
        }

        .top-branch-card .branch-main-value {
            font-size: 1.45rem;
        }

        .mini-branch-card .branch-main-value {
            font-size: 1rem;
            margin-top: 0.65rem;
        }

        .branch-main-label,
        .branch-info-label {
            color: var(--exec-muted);
            font-size: 0.7rem;
            font-weight: 850;
            text-transform: uppercase;
        }

        .branch-metric-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.55rem;
            margin-top: 0.85rem;
        }

        .mini-branch-card .branch-metric-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.4rem;
            margin-top: 0.65rem;
        }

        .branch-mini-metric {
            border-radius: 0.55rem;
            background: #f8fafc;
            border: 1px solid #edf1f7;
            padding: 0.55rem;
            min-width: 0;
        }

        .branch-mini-value {
            color: var(--exec-text);
            font-size: 0.82rem;
            font-weight: 900;
            margin-top: 0.18rem;
            overflow-wrap: anywhere;
        }

        .mini-branch-card .branch-mini-metric {
            padding: 0.42rem;
        }

        .mini-branch-card .branch-mini-value {
            font-size: 0.74rem;
        }

        .branch-intel {
            display: grid;
            gap: 0.45rem;
            margin-top: 0.85rem;
        }

        .mini-branch-card .branch-intel {
            gap: 0.35rem;
            margin-top: 0.65rem;
        }

        .branch-intel-row {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            border-top: 1px solid #edf1f7;
            padding-top: 0.45rem;
            min-width: 0;
        }

        .branch-info-value {
            color: var(--exec-text);
            font-size: 0.8rem;
            font-weight: 850;
            text-align: right;
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .mini-branch-card .branch-info-label {
            font-size: 0.64rem;
        }

        .mini-branch-card .branch-info-value {
            font-size: 0.72rem;
        }

        @media (max-width: 767.98px) {
            .branch-top-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1399.98px) {
            .branch-mini-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .branch-mini-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .branch-mini-grid {
                grid-template-columns: 1fr;
            }
        }

        .watch-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: inline-block;
            background: var(--exec-red);
            margin-right: 0.45rem;
        }

        .soft-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.32rem 0.62rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .soft-badge.success { background: #e9f8ef; color: #16784a; }
        .soft-badge.info { background: #eaf3ff; color: #0b62d6; }
        .soft-badge.warning { background: #fff4df; color: #a85400; }
        .soft-badge.danger { background: #feecef; color: #c1121f; }
        .soft-badge.secondary { background: #eef2f7; color: #475569; }

        .pn-target-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .pn-target-card {
            height: 100%;
            border: 1px solid var(--exec-border);
            border-radius: 0.85rem;
            background: #fff;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.07);
            overflow: hidden;
        }

        .pn-target-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid var(--exec-border);
            background: linear-gradient(180deg, #fff, #fbfdff);
        }

        .pn-target-title {
            margin: 0;
            color: var(--exec-text);
            font-size: 0.98rem;
            font-weight: 900;
        }

        .pn-target-table-wrap {
            overflow-x: auto;
        }

        .pn-target-table {
            width: 100%;
            min-width: 1120px;
            margin-bottom: 0;
        }

        .pn-target-table thead th {
            color: #475569;
            background: #f8fafc;
            border-color: #e5eaf2;
            font-size: 0.7rem;
            font-weight: 850;
            text-transform: uppercase;
            white-space: nowrap;
            padding: 0.78rem 0.85rem;
        }

        .pn-target-table tbody td,
        .pn-target-table tfoot td {
            border-color: #edf1f7;
            color: var(--exec-text);
            font-size: 0.82rem;
            padding: 0.72rem 0.85rem;
            vertical-align: middle;
        }

        .pn-target-total-row td {
            background: #f8fafc;
            color: var(--exec-text);
            font-weight: 900;
            border-top: 1px solid #dbe4f0;
        }

        .variance-positive {
            color: #16784a !important;
            font-weight: 900;
        }

        .variance-negative {
            color: #c1121f !important;
            font-weight: 900;
        }

        .variance-neutral {
            color: var(--exec-muted) !important;
            font-weight: 900;
        }

        .donut-panel {
            border: 1px solid var(--exec-border);
            border-radius: 0.75rem;
            height: 100%;
            padding: 1rem;
            background: #fff;
        }

        .donut-title {
            color: #334155;
            font-size: 0.75rem;
            font-weight: 900;
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .donut {
            --slice-a: 50%;
            --color-a: var(--exec-blue);
            --color-b: var(--exec-purple);
            width: 138px;
            height: 138px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            background: conic-gradient(var(--color-a) 0 var(--slice-a), var(--color-b) var(--slice-a) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 0 1px rgba(15, 23, 42, 0.04);
        }

        .donut.multi {
            background:
                conic-gradient(
                    #1268f3 0 42%,
                    #20b26b 42% 63%,
                    #f59e0b 63% 78%,
                    #8b5cf6 78% 90%,
                    #ef476f 90% 100%
                );
        }

        .donut-center {
            width: 78px;
            height: 78px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--exec-text);
            box-shadow: 0 5px 16px rgba(15, 23, 42, 0.08);
        }

        .donut-center small {
            color: var(--exec-muted);
            font-size: 0.68rem;
            font-weight: 800;
        }

        .donut-center strong {
            font-size: 0.82rem;
            font-weight: 900;
        }

        .legend-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.8rem;
            color: #334155;
            font-size: 0.82rem;
            padding: 0.28rem 0;
        }

        .legend-left {
            display: inline-flex;
            align-items: center;
            min-width: 0;
            gap: 0.45rem;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            flex: 0 0 auto;
        }

        .insight-card {
            border: 1px solid var(--exec-border);
            border-radius: 0.75rem;
            background: linear-gradient(180deg, #fff, #fbfdff);
            padding: 1.15rem;
            height: 100%;
            text-align: center;
        }

        .insight-icon {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 900;
            margin-bottom: 0.85rem;
        }

        .insight-label {
            color: var(--exec-blue);
            font-size: 0.7rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .insight-value {
            color: var(--exec-text);
            font-size: 1.38rem;
            font-weight: 900;
            margin-top: 0.55rem;
            overflow-wrap: anywhere;
        }

        .insight-sub {
            color: var(--exec-muted);
            font-size: 0.82rem;
            margin-top: 0.45rem;
        }

        .integrity-metric {
            border-radius: 0.72rem;
            padding: 0.9rem;
            height: 100%;
            border: 1px solid #ead7d7;
            background: #fff8f8;
            text-align: center;
        }

        .integrity-metric.warning {
            border-color: #f6dfb8;
            background: #fffaf0;
        }

        .integrity-metric.info {
            border-color: #cbe7e9;
            background: #f0fdfa;
        }

        .integrity-import-card {
            border: 1px solid var(--exec-border);
            border-radius: 0.72rem;
            background: #fff;
            height: 100%;
            overflow: hidden;
        }

        .integrity-label {
            color: #991b1b;
            font-size: 0.72rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .integrity-metric.warning .integrity-label {
            color: #a85400;
        }

        .integrity-metric.info .integrity-label {
            color: #0f766e;
        }

        .integrity-value {
            color: var(--exec-text);
            font-size: 1.45rem;
            font-weight: 900;
            margin-top: 0.35rem;
        }

        .quick-insight {
            display: flex;
            gap: 0.9rem;
            padding: 1rem;
            border-bottom: 1px solid var(--exec-border);
        }

        .quick-insight:last-child {
            border-bottom: 0;
        }

        .quick-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 900;
            flex: 0 0 auto;
        }

        .empty-state {
            padding: 2rem 1rem;
            text-align: center;
            color: var(--exec-muted);
        }

        .empty-state-title {
            color: var(--exec-text);
            font-weight: 900;
            margin-bottom: 0.35rem;
        }

        @media (min-width: 1200px) {
            .border-xl-end {
                border-right: 1px solid var(--exec-border);
            }
        }

        @media (max-width: 1399.98px) {
            .executive-filter-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

        }

        @media (max-width: 1199.98px) {
            .executive-hero-grid,
            .executive-insight-grid,
            .cash-installment-grid {
                grid-template-columns: 1fr;
            }

            .border-xl-end {
                border-bottom: 1px solid var(--exec-border);
            }
        }

        @media (max-width: 991.98px) {
            .executive-filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .executive-insight-inner-grid {
                grid-template-columns: 1fr;
            }

            .executive-kpi-board-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .report-summary-grid {
                grid-template-columns: 1fr;
            }

            .customer-intelligence-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575.98px) {
            .executive-filter-grid {
                grid-template-columns: 1fr;
            }

            .executive-filter-actions {
                grid-template-columns: 1fr;
            }

            .executive-hero-card-header.compact {
                align-items: flex-start;
                flex-direction: column;
            }

            .executive-header-actions {
                justify-content: flex-start;
            }

            .executive-insight-card-header.compact,
            .exec-section-header.compact,
            .pn-target-card-header.compact {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 767.98px) {
            .exec-shell {
                padding-top: 4.75rem;
            }

            .exec-filter-card {
                padding: 1rem;
            }

            .executive-filter-mobile-summary {
                background: #ffffff;
                border: 1px solid rgba(15, 23, 42, 0.08);
                border-radius: 1rem;
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
                padding: .9rem;
            }

            .executive-filter-toggle {
                background: #2563eb;
                color: #ffffff;
                box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
            }

            .exec-kpi {
                min-height: 130px;
            }

            .executive-chart-board-grid {
                grid-template-columns: 1fr;
            }

            .cash-installment-grid,
            .report-summary-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575.98px) {
            .executive-kpi-board-grid {
                grid-template-columns: 1fr;
            }

            .executive-filter-mobile-summary {
                align-items: flex-start;
                flex-direction: column;
            }

            .executive-filter-toggle {
                width: 100%;
            }
        }
    </style>

    @php
        $formatMoney = fn ($value) => 'PHP ' . number_format((float) $value, 2);
        $formatCompactMoney = function ($value) {
            $amount = (float) $value;

            if (abs($amount) >= 1000000) {
                return 'PHP ' . number_format($amount / 1000000, 2) . 'M';
            }

            if (abs($amount) >= 1000) {
                return 'PHP ' . number_format($amount / 1000, 2) . 'K';
            }

            return 'PHP ' . number_format($amount, 2);
        };
        $formatDate = fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('M d, Y') : '-';
        $totalMixAmount = max((float) $cashSales + (float) $installmentSales, 1);
        $cashPercent = round(((float) $cashSales / $totalMixAmount) * 100, 1);
        $installmentPercent = round(((float) $installmentSales / $totalMixAmount) * 100, 1);
        $cashUnits = (int) ($cashVsInstallment['cash']->units ?? 0);
        $installmentUnits = (int) ($cashVsInstallment['installment']->units ?? 0);
        $repoMix = $brandNewVsRepo->firstWhere('unit_group', 'Repo');
        $brandNewMix = $brandNewVsRepo->firstWhere('unit_group', 'Brand New');
        $repoUnits = (int) optional($repoMix)->units_sold;
        $brandNewUnits = (int) optional($brandNewMix)->units_sold;
        $repoAmount = (float) optional($repoMix)->total_sales;
        $brandNewAmount = (float) optional($brandNewMix)->total_sales;
        $unitMixTotal = max($repoUnits + $brandNewUnits, 1);
        $brandNewPercent = round(($brandNewUnits / $unitMixTotal) * 100, 1);
        $repoPercent = round(($repoUnits / $unitMixTotal) * 100, 1);
        $brandNewTopBrand = $unitTypeMixInsights['brand_new']['top_brand'] ?? '—';
        $brandNewTopProduct = $unitTypeMixInsights['brand_new']['top_product'] ?? '—';
        $repoTopBrand = $unitTypeMixInsights['repo']['top_brand'] ?? '—';
        $repoTopProduct = $unitTypeMixInsights['repo']['top_product'] ?? '—';
        $visibleProductGroupBreakdown = ($productGroupBreakdown ?? collect())
            ->reject(fn ($item) => strtoupper(trim((string) ($item->product_group ?? ''))) === 'UNCLASSIFIED')
            ->values();
        $visibleProductGroupUnits = (int) $visibleProductGroupBreakdown->sum('units_sold');
        $salesMixColors = ['#1268f3', '#20b26b', '#f59e0b', '#8b5cf6', '#ef476f'];
        $productGroupGradientStops = [];
        $productGroupCursor = 0;

        foreach ($visibleProductGroupBreakdown->take(5) as $index => $item) {
            $groupPercent = $totalSales > 0 ? round(((float) $item->total_sales / (float) $totalSales) * 100, 1) : 0;
            $nextStop = min(100, $productGroupCursor + $groupPercent);
            $productGroupGradientStops[] = $salesMixColors[$index % count($salesMixColors)] . ' ' . $productGroupCursor . '% ' . $nextStop . '%';
            $productGroupCursor = $nextStop;
        }

        if ($productGroupCursor < 100) {
            $productGroupGradientStops[] = '#e2e8f0 ' . $productGroupCursor . '% 100%';
        }

        $productGroupGradient = implode(', ', $productGroupGradientStops);
        $datePresetLabel = match ($filters['date_preset'] ?? 'this_month') {
            'today' => 'Today',
            'this_month' => 'This Month',
            'last_month' => 'Last Month',
            'year_to_date' => 'Year to Date',
            'all_time' => 'All Time',
            'custom' => 'Custom Range',
            default => 'This Month',
        };
    @endphp

    <div class="exec-shell px-3 px-md-4 py-4">
        <div class="exec-card exec-filter-card">
            @php
                $filterCarry = array_filter([
                    'business_unit_id' => $filters['business_unit_id'] ?? null,
                    'branch_id' => $filters['branch_id'] ?? null,
                    'product_group' => $filters['product_group'] ?? null,
                    'transaction_type' => $filters['transaction_type'] ?? null,
                ], fn ($value) => filled($value));

                $today = now()->toDateString();
                $thisMonthStart = now()->startOfMonth()->toDateString();
                $yearStart = now()->startOfYear()->toDateString();
                $datePresetLinks = [
                    'today' => [
                        'label' => 'Today',
                        'query' => ['date_preset' => 'today', 'date_from' => $today, 'date_to' => $today],
                    ],
                    'this_month' => [
                        'label' => 'This Month',
                        'query' => ['date_preset' => 'this_month', 'date_from' => $thisMonthStart, 'date_to' => $today],
                    ],
                    'year_to_date' => [
                        'label' => 'Year to Date',
                        'query' => ['date_preset' => 'year_to_date', 'date_from' => $yearStart, 'date_to' => $today],
                    ],
                    'all_time' => [
                        'label' => 'All Time',
                        'query' => ['date_preset' => 'all_time'],
                    ],
                ];

                $selectedBusinessUnit = $businessUnits->first(
                    fn ($businessUnit) => (string) $businessUnit->id === (string) ($filters['business_unit_id'] ?? '')
                );
                $selectedBranch = $branches->first(
                    fn ($branch) => (string) $branch->id === (string) ($filters['branch_id'] ?? '')
                );
                $selectedBusinessUnitLabel = $selectedBusinessUnit->name ?? 'All Business Units';
                $selectedBranchLabel = $selectedBranch->display_name ?? 'All Branches';
            @endphp

            <div class="executive-filter-mobile-summary">
                <div>
                    <span class="executive-filter-summary-label">Showing</span>
                    <strong>{{ $datePresetLabel ?? 'This Month' }}</strong>
                    <p>{{ $selectedBranchLabel }} &bull; {{ $selectedBusinessUnitLabel }}</p>
                </div>

                <button type="button" class="executive-filter-toggle" data-executive-filter-toggle aria-expanded="false">
                    Show Filters
                </button>
            </div>

            <div class="executive-filter-presets" aria-label="Quick date filters">
                @foreach($datePresetLinks as $presetKey => $presetLink)
                    <a
                        href="{{ route('executive.dashboard', array_merge($filterCarry, $presetLink['query'])) }}"
                        class="executive-filter-preset {{ ($filters['date_preset'] ?? 'this_month') === $presetKey ? 'active' : '' }}"
                    >
                        {{ $presetLink['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="executive-filter-collapsible" data-executive-filter-panel>
                <form method="GET" action="{{ route('executive.dashboard') }}">
                    <input type="hidden" name="date_preset" value="custom">
                    <div class="executive-filter-grid">
                        <div>
                            <label for="date_from" class="exec-filter-label">Date From</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}">
                        </div>

                        <div>
                            <label for="date_to" class="exec-filter-label">Date To</label>
                            <input type="date" name="date_to" id="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}">
                        </div>

                        <div>
                            <label for="business_unit_id" class="exec-filter-label">Business Unit</label>
                            <select name="business_unit_id" id="business_unit_id" class="form-select">
                                <option value="">All Business Units</option>
                                @foreach($businessUnits as $businessUnit)
                                    <option value="{{ $businessUnit->id }}" {{ (string) $filters['business_unit_id'] === (string) $businessUnit->id ? 'selected' : '' }}>
                                        {{ $businessUnit->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="branch_id" class="exec-filter-label">Branch</label>
                            <select name="branch_id" id="branch_id" class="form-select">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ (string) $filters['branch_id'] === (string) $branch->id ? 'selected' : '' }}>
                                        {{ $branch->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="product_group" class="exec-filter-label">Product Group</label>
                            <select name="product_group" id="product_group" class="form-select">
                                <option value="">All Product Groups</option>
                                <option value="motorcycle" {{ $filters['product_group'] === 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                <option value="appliance" {{ $filters['product_group'] === 'appliance' ? 'selected' : '' }}>Appliance</option>
                                <option value="furniture" {{ $filters['product_group'] === 'furniture' ? 'selected' : '' }}>Furniture</option>
                                <option value="bed_foam" {{ $filters['product_group'] === 'bed_foam' ? 'selected' : '' }}>Bed / Foam</option>
                                <option value="spare_parts" {{ $filters['product_group'] === 'spare_parts' ? 'selected' : '' }}>Spare Parts</option>
                                <option value="non_motorcycle" {{ $filters['product_group'] === 'non_motorcycle' ? 'selected' : '' }}>Non-Motorcycle</option>
                            </select>
                        </div>

                        <div>
                            <label for="transaction_type" class="exec-filter-label">Transaction Type</label>
                            <select name="transaction_type" id="transaction_type" class="form-select">
                                <option value="">All Types</option>
                                <option value="cash_sales" {{ $filters['transaction_type'] === 'cash_sales' ? 'selected' : '' }}>Cash Sales</option>
                                <option value="installment_sales" {{ $filters['transaction_type'] === 'installment_sales' ? 'selected' : '' }}>Installment Sales</option>
                            </select>
                        </div>

                        <div class="executive-filter-actions">
                            <button type="submit" class="btn exec-btn-primary">Apply Filters</button>
                            <a href="{{ route('executive.dashboard') }}" class="btn exec-btn-outline">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="executive-hero-grid">
            <section class="executive-hero-card">
                <div class="executive-hero-card-header compact">
                    <h2 class="executive-hero-card-title">Executive KPI Overview</h2>
                    <div class="executive-header-actions">
                        <span class="executive-scope-pill">{{ $datePresetLabel }}</span>
                        <a href="{{ route('dashboard') }}#report-kpi-details" class="executive-report-link">View Details</a>
                    </div>
                </div>

                <div class="executive-kpi-board-grid">
                    <div class="exec-kpi executive-kpi-card">
                        <div class="exec-kpi-top">
                            <div class="exec-kpi-icon blue">$</div>
                            <div class="exec-kpi-label">Total Sales</div>
                        </div>
                        <div class="exec-kpi-value">{{ $formatMoney($totalSales) }}</div>
                        <div class="exec-kpi-sub">Best available transaction amount</div>
                    </div>

                    <div class="exec-kpi executive-kpi-card">
                        <div class="exec-kpi-top">
                            <div class="exec-kpi-icon green">U</div>
                            <div class="exec-kpi-label">Units Sold</div>
                        </div>
                        <div class="exec-kpi-value">{{ number_format($unitsSold) }}</div>
                        <div class="exec-kpi-sub">Filtered sales transactions</div>
                    </div>

                    <div class="exec-kpi executive-kpi-card">
                        <div class="exec-kpi-top">
                            <div class="exec-kpi-icon orange">C</div>
                            <div class="exec-kpi-label">Cash Sales</div>
                        </div>
                        <div class="exec-kpi-value">{{ $formatMoney($cashSales) }}</div>
                        <div class="exec-kpi-sub">{{ $cashPercent }}% of total sales mix</div>
                    </div>

                    <div class="exec-kpi executive-kpi-card">
                        <div class="exec-kpi-top">
                            <div class="exec-kpi-icon purple">PN</div>
                            <div class="exec-kpi-label">Installment / PN Sales</div>
                        </div>
                        <div class="exec-kpi-value">{{ $formatMoney($installmentSales) }}</div>
                        <div class="exec-kpi-sub">{{ $installmentPercent }}% of total sales mix</div>
                    </div>

                    <div class="exec-kpi executive-kpi-card">
                        <div class="exec-kpi-top">
                            <div class="exec-kpi-icon teal">T</div>
                            <div class="exec-kpi-label">Target Achievement</div>
                        </div>
                        <div class="exec-kpi-value">{{ $formatCompactMoney($targetAchievement->target_total ?? 0) }}</div>
                        <div class="exec-kpi-sub">
                            PN Target<br>
                            Actual: {{ $formatCompactMoney($targetAchievement->actual_total ?? 0) }}
                            &bull; {{ number_format($targetAchievement->achievement_percentage ?? 0, 1) }}% achieved
                            <br>
                            <span class="kpi-status-pill kpi-status-{{ $targetAchievement->status ?? 'behind' }}">
                                {{ $targetAchievement->status_label ?? 'Below Target' }}
                            </span>
                        </div>
                    </div>

                    <div class="exec-kpi executive-kpi-card latest-customer-sales-card">
                        <div class="exec-kpi-top">
                            <div class="exec-kpi-icon blue">S</div>
                            <div>
                                <div class="exec-kpi-label">Latest Customer Sale</div>
                                <div class="exec-kpi-sub mt-1">Recent customer sales activity</div>
                            </div>
                        </div>

                        @if($latestCustomerSale)
                            @php
                                $saleTypeKey = $latestCustomerSale['sales_type_key'] ?? 'brand-new';
                                $saleBranch = $latestCustomerSale['branch_code']
                                    ? $latestCustomerSale['branch'] . ' (' . $latestCustomerSale['branch_code'] . ')'
                                    : $latestCustomerSale['branch'];
                            @endphp

                            <div class="latest-customer-sale-details">
                                <div class="latest-customer-sale-name">{{ $latestCustomerSale['customer_name'] }}</div>
                                <div class="latest-customer-sale-row">
                                    <span>Branch:</span> {{ $saleBranch }}
                                </div>
                                <div class="latest-customer-sale-row">
                                    <span>Brand:</span> {{ $latestCustomerSale['brand'] }}
                                </div>
                                <div class="latest-customer-sale-row">
                                    <span>Model:</span> {{ $latestCustomerSale['model'] }}
                                </div>

                                <div class="latest-customer-sale-actions">
                                    <span class="latest-customer-sale-pill {{ $saleTypeKey }}">{{ $latestCustomerSale['sales_type'] }}</span>
                                    <a href="{{ route('dashboard') }}#report-latest-sales" class="executive-report-link">View Details</a>
                                </div>
                            </div>
                        @else
                            <div class="latest-customer-sale-empty">
                                No latest customer sales available for the selected filters.
                                <div class="latest-customer-sale-actions">
                                    <a href="{{ route('dashboard') }}#report-latest-sales" class="executive-report-link">View Details</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section class="executive-hero-card">
                <div class="executive-hero-card-header compact">
                    <h2 class="executive-hero-card-title">Executive Trends Overview</h2>
                    <span class="executive-scope-pill executive-scope-pill-muted">Historical + Filtered</span>
                </div>

                <div class="executive-chart-board-grid">
                    <div class="executive-chart-panel">
                        <div class="executive-chart-title">Filtered Transactions by Branch</div>
                        @if(count($executiveChartData['branch_labels'] ?? []) > 0)
                            <div class="executive-chart-canvas">
                                <canvas id="executiveBranchTransactionsChart"></canvas>
                            </div>
                        @else
                            <div class="empty-state py-3">
                                <div class="empty-state-title">No branch chart data available.</div>
                            </div>
                        @endif
                    </div>

                    <div class="executive-chart-panel">
                        <div class="executive-chart-title">Filtered Amount by Business Unit</div>
                        @if(count($executiveChartData['business_unit_labels'] ?? []) > 0)
                            <div class="executive-chart-canvas">
                                <canvas id="executiveBusinessUnitAmountChart"></canvas>
                            </div>
                        @else
                            <div class="empty-state py-3">
                                <div class="empty-state-title">No business unit chart data available.</div>
                            </div>
                        @endif
                    </div>

                    <div class="executive-chart-panel">
                        <div class="executive-chart-title">All-Time Monthly Transaction Trend</div>
                        <div class="executive-chart-subtitle">Historical trend across all available imports. Other filters still apply.</div>
                        @if(count($executiveChartData['monthly_labels'] ?? []) > 0)
                            <div class="executive-chart-canvas">
                                <canvas id="executiveTransactionsByMonthChart"></canvas>
                            </div>
                        @else
                            <div class="empty-state py-3">
                                <div class="empty-state-title">No monthly transaction trend available.</div>
                            </div>
                        @endif
                    </div>

                    <div class="executive-chart-panel">
                        <div class="executive-chart-title">All-Time Monthly Amount Trend</div>
                        <div class="executive-chart-subtitle">Historical trend across all available imports. Other filters still apply.</div>
                        @if(count($executiveChartData['monthly_labels'] ?? []) > 0)
                            <div class="executive-chart-canvas">
                                <canvas id="executiveAmountByMonthChart"></canvas>
                            </div>
                        @else
                            <div class="empty-state py-3">
                                <div class="empty-state-title">No monthly amount trend available.</div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        <div class="executive-insight-grid">
            <section class="executive-insight-card">
                <div class="executive-insight-card-header compact">
                    <h2 class="executive-insight-card-title">Sales Mix</h2>
                    <div class="executive-header-actions">
                        <span class="executive-scope-pill">{{ $datePresetLabel }}</span>
                        <a href="{{ route('dashboard') }}#report-sales-mix-detail" class="executive-report-link">View Details</a>
                    </div>
                </div>

                <div class="executive-insight-inner-grid">
                    <div class="executive-insight-panel">
                        <div class="executive-insight-panel-title">Cash vs Installment</div>
                        @if(((float) ($cashSales ?? 0) + (float) ($installmentSales ?? 0)) > 0)
                            <div class="donut" style="--slice-a: {{ $cashPercent }}%; --color-a: var(--exec-blue); --color-b: var(--exec-purple);">
                                <div class="donut-center">
                                    <small>Total</small>
                                    <strong>{{ $formatCompactMoney($totalMixAmount) }}</strong>
                                </div>
                            </div>
                            <div class="sales-mix-graph-legend" aria-label="Cash versus installment sales details">
                                <span class="sales-mix-segment" tabindex="0" data-tooltip="Cash Sales: &#8369;{{ number_format((float) $cashSales, 2) }} &bull; {{ number_format($cashUnits) }} units &bull; {{ $cashPercent }}%">
                                    <span class="sales-mix-dot" style="background: var(--exec-blue);"></span>
                                    <span class="sales-mix-label">Cash</span>
                                    <span class="sales-mix-percent">{{ $cashPercent }}%</span>
                                </span>

                                <span class="sales-mix-segment" tabindex="0" data-tooltip="Installment / PN Sales: &#8369;{{ number_format((float) $installmentSales, 2) }} &bull; {{ number_format($installmentUnits) }} units &bull; {{ $installmentPercent }}%">
                                    <span class="sales-mix-dot" style="background: var(--exec-purple);"></span>
                                    <span class="sales-mix-label">Installment / PN</span>
                                    <span class="sales-mix-percent">{{ $installmentPercent }}%</span>
                                </span>
                            </div>
                        @else
                            <div class="empty-state py-3">
                                <div class="empty-state-title">No cash/installment mix available for the selected filters.</div>
                            </div>
                        @endif
                    </div>

                    <div class="executive-insight-panel">
                        <div class="executive-insight-panel-title">Brand New vs Repo</div>
                        @if(($repoUnits + $brandNewUnits) > 0)
                            <div class="donut" style="--slice-a: {{ $brandNewPercent }}%; --color-a: var(--exec-green); --color-b: var(--exec-orange);">
                                <div class="donut-center">
                                    <small>Total</small>
                                    <strong>{{ number_format($unitMixTotal) }}</strong>
                                </div>
                            </div>
                            <div class="sales-mix-graph-legend" aria-label="Brand new versus repo unit details">
                                <span class="sales-mix-segment" tabindex="0" data-tooltip="Brand New: &#8369;{{ number_format($brandNewAmount, 2) }} &bull; {{ number_format($brandNewUnits) }} units &bull; {{ $brandNewPercent }}% | Top Brand: {{ $brandNewTopBrand }} | Top Product/Model: {{ $brandNewTopProduct }}">
                                    <span class="sales-mix-dot" style="background: var(--exec-green);"></span>
                                    <span class="sales-mix-label">Brand New</span>
                                    <span class="sales-mix-percent">{{ $brandNewPercent }}%</span>
                                </span>

                                <span class="sales-mix-segment" tabindex="0" data-tooltip="Repo: &#8369;{{ number_format($repoAmount, 2) }} &bull; {{ number_format($repoUnits) }} units &bull; {{ $repoPercent }}% | Top Brand: {{ $repoTopBrand }} | Top Product/Model: {{ $repoTopProduct }}">
                                    <span class="sales-mix-dot" style="background: var(--exec-orange);"></span>
                                    <span class="sales-mix-label">Repo</span>
                                    <span class="sales-mix-percent">{{ $repoPercent }}%</span>
                                </span>
                            </div>
                        @else
                            <div class="empty-state py-3">
                                <div class="empty-state-title">No unit type mix available for the selected filters.</div>
                            </div>
                        @endif
                    </div>

                    <div class="executive-insight-panel">
                        <div class="executive-insight-panel-title">Product Group Breakdown</div>
                        @if($visibleProductGroupBreakdown->isNotEmpty())
                            <div class="donut multi" style="background: conic-gradient({{ $productGroupGradient }});">
                                <div class="donut-center">
                                    <small>Units</small>
                                    <strong>{{ number_format($visibleProductGroupUnits) }}</strong>
                                </div>
                            </div>
                            <div class="sales-mix-graph-legend" aria-label="Product group breakdown details">
                                @foreach($visibleProductGroupBreakdown->take(5) as $item)
                                    @php
                                        $groupPercent = $totalSales > 0 ? round(((float) $item->total_sales / (float) $totalSales) * 100, 1) : 0;
                                        $groupColor = $salesMixColors[($loop->iteration - 1) % count($salesMixColors)];
                                        $groupLabel = $item->product_group ?? 'Unclassified';
                                        $groupTopBrand = $item->top_brand ?? '—';
                                        $groupTopProduct = $item->top_product ?? '—';
                                    @endphp
                                    <span class="sales-mix-segment" tabindex="0" data-tooltip="{{ $groupLabel }}: &#8369;{{ number_format((float) ($item->total_sales ?? 0), 2) }} &bull; {{ number_format((int) ($item->units_sold ?? 0)) }} units &bull; {{ $groupPercent }}% | Top Brand: {{ $groupTopBrand }} | Top Product/Model: {{ $groupTopProduct }}">
                                        <span class="sales-mix-dot" style="background: {{ $groupColor }};"></span>
                                        <span class="sales-mix-label">{{ $groupLabel }}</span>
                                        <span class="sales-mix-percent">{{ $groupPercent }}%</span>
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state py-3">
                                <div class="empty-state-title">No product group breakdown available for the selected filters.</div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section class="executive-insight-card">
                <div class="executive-insight-card-header compact">
                    <h2 class="executive-insight-card-title">Product Intelligence</h2>
                    <div class="executive-header-actions">
                        <span class="executive-scope-pill">{{ $datePresetLabel }}</span>
                        <a href="{{ route('dashboard') }}#report-product-sales" class="executive-report-link">See Report</a>
                    </div>
                </div>

                <div class="executive-insight-inner-grid">
                    <div class="executive-insight-panel">
                        <div class="metric-pill metric-pill-brand">Brand</div>
                        <div class="executive-insight-panel-title">Top Selling Brands</div>
                        <div class="product-rank-list">
                            @forelse(($productIntelligence['top_brands'] ?? collect()) as $brand)
                                <div class="product-rank-item">
                                    <div class="product-rank-label">#{{ $loop->iteration }} {{ $brand->label ?? '-' }}</div>
                                    <div class="product-rank-meta">{{ number_format($brand->units_sold ?? 0) }} units sold</div>
                                    <div class="product-rank-amount">{{ $formatMoney($brand->total_sales ?? 0) }}</div>
                                </div>
                            @empty
                                <div class="empty-state py-3">
                                    <div class="empty-state-title">No brand data available for the selected filters.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="executive-insight-panel">
                        <div class="metric-pill metric-pill-hot">Hot Product</div>
                        <div class="executive-insight-panel-title">Hot Products / Top Models</div>
                        <div class="product-rank-list">
                            @forelse(($productIntelligence['hot_products'] ?? collect()) as $product)
                                <div class="product-rank-item">
                                    <div class="product-rank-label">#{{ $loop->iteration }} {{ $product->label ?? '-' }}</div>
                                    <div class="product-rank-meta">{{ number_format($product->units_sold ?? 0) }} units sold</div>
                                    <div class="product-rank-amount">{{ $formatMoney($product->total_sales ?? 0) }}</div>
                                </div>
                            @empty
                                <div class="empty-state py-3">
                                    <div class="empty-state-title">No product/model data available for the selected filters.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="executive-insight-panel">
                        <div class="metric-pill metric-pill-term">Term</div>
                        <div class="executive-insight-panel-title">Highest Term Share</div>
                        <div class="product-rank-list">
                            @forelse(($productIntelligence['top_terms'] ?? collect()) as $term)
                                <div class="product-rank-item">
                                    <div class="product-rank-label">#{{ $loop->iteration }} {{ $term->label ?? '-' }}</div>
                                    <div class="product-rank-meta">{{ number_format($term->units_sold ?? 0) }} units</div>
                                    <div class="product-rank-amount">{{ number_format($term->share_percentage ?? 0, 1) }}% of term-tagged sales</div>
                                </div>
                            @empty
                                <div class="empty-state py-3">
                                    <div class="empty-state-title">No term data available for the selected filters.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="exec-section-card executive-section-card">
                    @php
                        $topBranches = $branchLeaderboard->take(3);
                        $remainingBranches = $branchLeaderboard->slice(3);
                    @endphp

                    <div class="exec-section-header compact">
                        <h2 class="exec-section-title">Branch Leaderboard</h2>
                        <div class="executive-header-actions">
                            <span class="executive-scope-pill">{{ $datePresetLabel }}</span>
                            <a href="{{ route('dashboard') }}#report-branch-sales" class="executive-report-link">See Report</a>
                        </div>
                    </div>

                    <div class="p-3">
                        <div class="branch-top-grid mb-4">
                            @foreach($topBranches as $branch)
                                @php
                                    $rank = $loop->iteration;
                                    $branchCode = $branch->branch_code ?? $branch->code ?? 'N/A';
                                    $branchName = $branch->branch_name ?? $branch->name ?? 'Unknown Branch';
                                    $topBrand = $branch->top_brand ?? '-';
                                    $hotProduct = $branch->hot_product ?? $branch->top_model ?? '-';
                                    $topTerm = $branch->top_term ?? '-';
                                @endphp
                                <div class="branch-card top-branch-card rank-{{ $rank }}">
                                    <div class="d-flex align-items-start gap-2">
                                        <span class="branch-rank-badge rank-{{ $rank }}">#{{ $rank }}</span>
                                        <div class="branch-card-title text-truncate">
                                            {{ $branchCode }} - {{ $branchName }}
                                        </div>
                                    </div>

                                    <div class="branch-main-value">{{ $formatMoney($branch->total_sales ?? 0) }}</div>
                                    <div class="branch-main-label">Total Sales</div>

                                    <div class="branch-metric-grid">
                                        <div class="branch-mini-metric">
                                            <div class="branch-info-label">Units</div>
                                            <div class="branch-mini-value">{{ number_format($branch->units_sold ?? 0) }}</div>
                                        </div>
                                        <div class="branch-mini-metric">
                                            <div class="branch-info-label">Cash</div>
                                            <div class="branch-mini-value">{{ $formatCompactMoney($branch->cash_sales ?? 0) }}</div>
                                        </div>
                                        <div class="branch-mini-metric">
                                            <div class="branch-info-label">PN</div>
                                            <div class="branch-mini-value">{{ $formatCompactMoney($branch->installment_sales ?? 0) }}</div>
                                        </div>
                                    </div>

                                    <div class="branch-intel">
                                        <div class="branch-intel-row">
                                            <div class="branch-info-label">Top Brand</div>
                                            <div class="branch-info-value">{{ $topBrand }}</div>
                                        </div>
                                        <div class="branch-intel-row">
                                            <div class="branch-info-label">Hot Product</div>
                                            <div class="branch-info-value">{{ $hotProduct }}</div>
                                        </div>
                                        <div class="branch-intel-row">
                                            <div class="branch-info-label">Top Term</div>
                                            <div class="branch-info-value">{{ $topTerm }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($topBranches->isEmpty())
                            <div class="empty-state">
                                <div class="empty-state-title">No branch sales found</div>
                                <div>Try widening the reporting filters.</div>
                            </div>
                        @endif

                        @if($remainingBranches->count())
                            <div class="branch-mini-grid">
                                @foreach($remainingBranches as $branch)
                                    @php
                                        $rank = $loop->iteration + 3;
                                        $branchCode = $branch->branch_code ?? $branch->code ?? 'N/A';
                                        $branchName = $branch->branch_name ?? $branch->name ?? 'Unknown Branch';
                                        $topBrand = $branch->top_brand ?? '-';
                                        $hotProduct = $branch->hot_product ?? $branch->top_model ?? '-';
                                        $topTerm = $branch->top_term ?? '-';
                                    @endphp
                                    <div class="branch-card mini-branch-card rank-other">
                                        <div class="d-flex align-items-start gap-2">
                                            <span class="branch-rank-badge rank-other">#{{ $rank }}</span>
                                            <div class="branch-card-title text-truncate">
                                                {{ $branchCode }} - {{ $branchName }}
                                            </div>
                                        </div>

                                        <div class="branch-main-value">{{ $formatCompactMoney($branch->total_sales ?? 0) }}</div>
                                        <div class="branch-main-label">Total Sales</div>

                                        <div class="branch-metric-grid">
                                            <div class="branch-mini-metric">
                                                <div class="branch-info-label">Units</div>
                                                <div class="branch-mini-value">{{ number_format($branch->units_sold ?? 0) }}</div>
                                            </div>
                                            <div class="branch-mini-metric">
                                                <div class="branch-info-label">Cash</div>
                                                <div class="branch-mini-value">{{ $formatCompactMoney($branch->cash_sales ?? 0) }}</div>
                                            </div>
                                            <div class="branch-mini-metric">
                                                <div class="branch-info-label">PN</div>
                                                <div class="branch-mini-value">{{ $formatCompactMoney($branch->installment_sales ?? 0) }}</div>
                                            </div>
                                        </div>

                                        <div class="branch-intel">
                                            <div class="branch-intel-row">
                                                <div class="branch-info-label">Top Brand</div>
                                                <div class="branch-info-value">{{ $topBrand }}</div>
                                            </div>
                                            <div class="branch-intel-row">
                                                <div class="branch-info-label">Hot Product</div>
                                                <div class="branch-info-value">{{ $hotProduct }}</div>
                                            </div>
                                            <div class="branch-intel-row">
                                                <div class="branch-info-label">Top Term</div>
                                                <div class="branch-info-value">{{ $topTerm }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="cash-installment-grid">
                    @foreach(($cashInstallmentReports ?? []) as $reportGroup)
                        <section class="exec-section-card executive-section-card">
                            <div class="exec-section-header compact">
                                <h2 class="exec-section-title">{{ $reportGroup['title'] ?? 'Sales Report' }}</h2>
                                <div class="executive-header-actions">
                                    <span class="executive-scope-pill">{{ $datePresetLabel }}</span>
                                    <a href="{{ route('dashboard') }}#report-cash-installment" class="executive-report-link">See Report</a>
                                </div>
                            </div>

                            <div class="p-3">
                                <div class="report-summary-grid">
                                    @foreach(($reportGroup['reports'] ?? []) as $report)
                                        @php
                                            $totalUnits = (int) ($report->total_units ?? 0);
                                            $totalAmount = (float) ($report->total_amount ?? 0);
                                            $todayUnits = (int) ($report->today_brand_new_units ?? 0) + (int) ($report->today_repo_units ?? 0);
                                            $todayAmount = (float) ($report->today_brand_new_amount ?? 0) + (float) ($report->today_repo_amount ?? 0);
                                            $brandNewUnits = (int) ($report->todate_brand_new_units ?? 0);
                                            $brandNewAmount = (float) ($report->todate_brand_new_amount ?? 0);
                                            $repoUnits = (int) ($report->todate_repo_units ?? 0);
                                            $repoAmount = (float) ($report->todate_repo_amount ?? 0);
                                        @endphp
                                        <div class="report-summary-card">
                                            <div class="report-summary-label">{{ $report->label ?? 'Report' }}</div>
                                            <div class="report-summary-value">{{ $formatCompactMoney($totalAmount) }}</div>
                                            <div class="report-summary-meta">{{ number_format($totalUnits) }} total transactions</div>

                                            <div class="report-summary-split">
                                                <div class="report-summary-mini">
                                                    <div class="report-summary-mini-label">Today</div>
                                                    <div class="report-summary-mini-value">{{ $formatCompactMoney($todayAmount) }}</div>
                                                    <div class="small text-muted">{{ number_format($todayUnits) }} units</div>
                                                </div>
                                                <div class="report-summary-mini">
                                                    <div class="report-summary-mini-label">To Date</div>
                                                    <div class="report-summary-mini-value">{{ number_format($brandNewUnits + $repoUnits) }} units</div>
                                                    <div class="small text-muted">{{ $formatCompactMoney($brandNewAmount + $repoAmount) }}</div>
                                                </div>
                                                <div class="report-summary-mini">
                                                    <div class="report-summary-mini-label">Brand New</div>
                                                    <div class="report-summary-mini-value">{{ number_format($brandNewUnits) }} units</div>
                                                    <div class="small text-muted">{{ $formatCompactMoney($brandNewAmount) }}</div>
                                                </div>
                                                <div class="report-summary-mini">
                                                    <div class="report-summary-mini-label">Repo</div>
                                                    <div class="report-summary-mini-value">{{ number_format($repoUnits) }} units</div>
                                                    <div class="small text-muted">{{ $formatCompactMoney($repoAmount) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                <div class="pn-target-grid">
                    @foreach($pnTargetUpdates ?? [] as $targetGroup)
                        <div class="pn-target-card">
                            <div class="pn-target-card-header compact">
                                <h2 class="pn-target-title">{{ $targetGroup['title'] ?? 'PN Sales Target Update' }}</h2>
                                <span class="executive-scope-pill">{{ $datePresetLabel }}</span>
                            </div>

                            <div class="pn-target-table-wrap">
                                <table class="table pn-target-table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Branch</th>
                                            <th class="text-end">Working Plan</th>
                                            <th class="text-end">Projected PN Sales Current Date: Amount</th>
                                            <th class="text-end">Projected PN Sales Current Date: Percentage</th>
                                            <th class="text-end">Sales Target Per Day</th>
                                            <th class="text-end">Actual PN Sales: Amount</th>
                                            <th class="text-end">Actual PN Sales: Percentage</th>
                                            <th class="text-end">Variance Per Day: Amount</th>
                                            <th class="text-end">Variance Per Day: Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(($targetGroup['rows'] ?? collect()) as $row)
                                            @php
                                                $varianceAmount = (float) ($row->variance_amount ?? 0);
                                                $varianceClass = $varianceAmount > 0
                                                    ? 'variance-positive'
                                                    : ($varianceAmount < 0 ? 'variance-negative' : 'variance-neutral');
                                            @endphp
                                            <tr>
                                                <td class="fw-bold text-nowrap">{{ $row->branch ?? '-' }}</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($row->working_plan ?? 0), 2) }}</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($row->projected_amount ?? 0), 2) }}</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($row->projected_percentage ?? 0), 2) }}%</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($row->sales_target_per_day ?? 0), 2) }}</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($row->actual_amount ?? 0), 2) }}</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($row->actual_percentage ?? 0), 2) }}%</td>
                                                <td class="text-end text-nowrap {{ $varianceClass }}">{{ number_format($varianceAmount, 2) }}</td>
                                                <td class="text-end text-nowrap {{ $varianceClass }}">{{ number_format((float) ($row->variance_percentage ?? 0), 2) }}%</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="p-0">
                                                    <div class="empty-state">
                                                        <div class="empty-state-title">No target rows found</div>
                                                        <div>No branches matched the current filter scope.</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    @if(isset($targetGroup['totals']))
                                        @php
                                            $total = $targetGroup['totals'];
                                            $totalVarianceAmount = (float) ($total->variance_amount ?? 0);
                                            $totalVarianceClass = $totalVarianceAmount > 0
                                                ? 'variance-positive'
                                                : ($totalVarianceAmount < 0 ? 'variance-negative' : 'variance-neutral');
                                        @endphp
                                        <tfoot>
                                            <tr class="pn-target-total-row">
                                                <td>{{ $total->branch ?? 'TOTAL' }}</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($total->working_plan ?? 0), 2) }}</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($total->projected_amount ?? 0), 2) }}</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($total->projected_percentage ?? 0), 2) }}%</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($total->sales_target_per_day ?? 0), 2) }}</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($total->actual_amount ?? 0), 2) }}</td>
                                                <td class="text-end text-nowrap">{{ number_format((float) ($total->actual_percentage ?? 0), 2) }}%</td>
                                                <td class="text-end text-nowrap {{ $totalVarianceClass }}">{{ number_format($totalVarianceAmount, 2) }}</td>
                                                <td class="text-end text-nowrap {{ $totalVarianceClass }}">{{ number_format((float) ($total->variance_percentage ?? 0), 2) }}%</td>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                @php
                    $topRepeatBuyer = $customerIntelligenceKpis['top_repeat_buyer'] ?? [];
                    $highestPnCustomer = $customerIntelligenceKpis['highest_pn_customer'] ?? [];
                    $repeatBuyerCount = (int) ($customerIntelligenceKpis['repeat_count'] ?? 0);
                @endphp
                <section class="exec-section-card executive-section-card customer-intelligence-section">
                    <div class="exec-section-header compact">
                        <h2 class="exec-section-title">Customer Intelligence</h2>
                        <div class="executive-header-actions">
                            <span class="executive-scope-pill">{{ $datePresetLabel }}</span>
                            <a href="{{ route('dashboard') }}#report-customer" class="executive-report-link">See Report</a>
                        </div>
                    </div>

                    <div class="p-3">
                        <div class="customer-intelligence-grid">
                            <div class="customer-intelligence-card">
                                <div class="customer-intelligence-label">Top Repeat Buyer</div>
                                <div class="customer-intelligence-value">
                                    {{ $topRepeatBuyer['customer_name'] ?? 'No repeat buyer data' }}
                                </div>
                                <div class="customer-intelligence-meta">
                                    {{ number_format((int) ($topRepeatBuyer['account_count'] ?? 0)) }} account(s)
                                    | {{ number_format((int) ($topRepeatBuyer['count'] ?? 0)) }} transaction(s)
                                </div>
                                <div class="customer-intelligence-meta">
                                    {{ $formatMoney((float) ($topRepeatBuyer['amount'] ?? 0)) }} total paid sales
                                </div>
                            </div>

                            <div class="customer-intelligence-card">
                                <div class="customer-intelligence-label">Highest PN Customer</div>
                                <div class="customer-intelligence-value">
                                    {{ $highestPnCustomer['customer_name'] ?? 'No PN customer data' }}
                                </div>
                                <div class="customer-intelligence-meta">
                                    {{ $highestPnCustomer['account_number'] ?? '-' }}
                                    | {{ $highestPnCustomer['receipt_number'] ?? '-' }}
                                </div>
                                <div class="customer-intelligence-meta">
                                    &#8369;{{ number_format((float) ($highestPnCustomer['pn_amount'] ?? 0), 2) }} total PN
                                </div>
                            </div>

                            <div class="customer-intelligence-card">
                                <div class="customer-intelligence-label">Repeat Count</div>
                                <div class="customer-intelligence-value">{{ number_format($repeatBuyerCount) }}</div>
                                <div class="customer-intelligence-meta">
                                    Customers with more than one paid purchase in the selected filters
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const executiveFilterToggle = document.querySelector('[data-executive-filter-toggle]');
            const executiveFilterPanel = document.querySelector('[data-executive-filter-panel]');

            if (executiveFilterToggle && executiveFilterPanel) {
                executiveFilterToggle.addEventListener('click', function () {
                    const isOpen = executiveFilterPanel.classList.toggle('is-open');

                    executiveFilterToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    executiveFilterToggle.textContent = isOpen ? 'Hide Filters' : 'Show Filters';
                });
            }

            if (typeof Chart === 'undefined') {
                return;
            }

            const executiveBranchLabels = @json($executiveChartData['branch_labels'] ?? []);
            const executiveBranchCounts = @json($executiveChartData['branch_counts'] ?? []);
            const executiveBusinessUnitLabels = @json($executiveChartData['business_unit_labels'] ?? []);
            const executiveBusinessUnitAmounts = @json($executiveChartData['business_unit_amounts'] ?? []);
            const executiveMonthlyLabels = @json($executiveChartData['monthly_labels'] ?? []);
            const executiveMonthlyCounts = @json($executiveChartData['monthly_counts'] ?? []);
            const executiveMonthlyAmounts = @json($executiveChartData['monthly_amounts'] ?? []);

            const executiveChartColors = ['#1268f3', '#20b26b', '#f59e0b', '#8b5cf6', '#ef476f', '#14b8a6'];
            const executiveDefaultChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            boxWidth: 10,
                            color: '#334155',
                            font: {
                                size: 10,
                                weight: '700'
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#64748b',
                            font: { size: 10 }
                        },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#64748b',
                            font: { size: 10 }
                        },
                        grid: { color: 'rgba(148, 163, 184, 0.18)' }
                    }
                }
            };

            const executivePieChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            color: '#334155',
                            font: {
                                size: 10,
                                weight: '700'
                            }
                        }
                    }
                }
            };

            const executiveBranchTransactionsCtx = document.getElementById('executiveBranchTransactionsChart');

            if (executiveBranchTransactionsCtx) {
                new Chart(executiveBranchTransactionsCtx, {
                    type: 'bar',
                    data: {
                        labels: executiveBranchLabels,
                        datasets: [{
                            label: 'Transactions',
                            data: executiveBranchCounts,
                            backgroundColor: '#1268f3',
                            borderWidth: 0,
                            borderRadius: 8
                        }]
                    },
                    options: executiveDefaultChartOptions
                });
            }

            const executiveBusinessUnitAmountCtx = document.getElementById('executiveBusinessUnitAmountChart');

            if (executiveBusinessUnitAmountCtx) {
                new Chart(executiveBusinessUnitAmountCtx, {
                    type: 'pie',
                    data: {
                        labels: executiveBusinessUnitLabels,
                        datasets: [{
                            label: 'Total Amount',
                            data: executiveBusinessUnitAmounts,
                            backgroundColor: executiveChartColors,
                            borderWidth: 1
                        }]
                    },
                    options: executivePieChartOptions
                });
            }

            const executiveTransactionsByMonthCtx = document.getElementById('executiveTransactionsByMonthChart');

            if (executiveTransactionsByMonthCtx) {
                new Chart(executiveTransactionsByMonthCtx, {
                    type: 'line',
                    data: {
                        labels: executiveMonthlyLabels,
                        datasets: [{
                            label: 'Transactions',
                            data: executiveMonthlyCounts,
                            borderColor: '#20b26b',
                            backgroundColor: 'rgba(32, 178, 107, 0.12)',
                            borderWidth: 2,
                            tension: 0.25,
                            fill: false
                        }]
                    },
                    options: executiveDefaultChartOptions
                });
            }

            const executiveAmountByMonthCtx = document.getElementById('executiveAmountByMonthChart');

            if (executiveAmountByMonthCtx) {
                new Chart(executiveAmountByMonthCtx, {
                    type: 'line',
                    data: {
                        labels: executiveMonthlyLabels,
                        datasets: [{
                            label: 'Total Amount',
                            data: executiveMonthlyAmounts,
                            borderColor: '#8b5cf6',
                            backgroundColor: 'rgba(139, 92, 246, 0.12)',
                            borderWidth: 2,
                            tension: 0.25,
                            fill: false
                        }]
                    },
                    options: executiveDefaultChartOptions
                });
            }
        });
    </script>
</x-app-layout>
