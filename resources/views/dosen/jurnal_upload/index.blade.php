@extends('layout.doslayout')

@section('body_class', 'page-dosen-jurnal')

@section('css')
    <style>
        /* =========================================================================
           P3M DOSEN — UPLOAD JURNAL ILMIAH
           Enterprise UI / UX Harmonized System (100% Identik dengan Menu Lainnya)
           ========================================================================= */

        :root {
            --p3m-up-forest: #003d2d;
            --p3m-up-forest-deep: #002e22;
            --p3m-up-forest-mid: #00573b;
            --p3m-up-forest-soft: #eaf5ee;

            --p3m-up-gold: #b99835;
            --p3m-up-gold-soft: #fdf8ec;

            --p3m-up-ink: #0d1f1a;
            --p3m-up-ink-2: #1e3328;
            --p3m-up-text: #3b4f47;
            --p3m-up-muted: #6b7f78;
            --p3m-up-light: #9caaa4;

            --p3m-up-border: #e4ede8;
            --p3m-up-border-2: #d3e0d9;

            --p3m-up-surface: #ffffff;
            --p3m-up-surface-alt: #f7faf8;
            --p3m-up-surface-hover: #f2f7f4;

            --p3m-up-success: #087844;
            --p3m-up-success-bg: #eaf7ef;
            --p3m-up-success-border: #b5ddc7;

            --p3m-up-warning: #7a6214;
            --p3m-up-warning-bg: #fdf8ec;
            --p3m-up-warning-border: #e8d68a;

            --p3m-up-danger: #d94b4b;
            --p3m-up-danger-bg: #fef2f2;
            --p3m-up-danger-border: #f5c0c0;

            --p3m-up-r-sm: 8px;
            --p3m-up-r-md: 12px;
            --p3m-up-r-lg: 16px;
            --p3m-up-r-xl: 20px;
            --p3m-up-r-2xl: 24px;
            --p3m-up-card-inline: 28px;
        }

        /* -------------------------------------------------------------------------
           PAGE SHELL
           ------------------------------------------------------------------------- */
        .page-dosen-jurnal .content-wrapper {
            min-height: calc(100vh - 66px);
            background:
                radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0, 93, 59, .05), transparent 70%),
                linear-gradient(180deg, #f2f8f5 0%, #f7faf8 100%) !important;
        }

        .page-dosen-jurnal .upp3m-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-jurnal .content-header {
            padding: 24px 0 14px !important;
        }

        .page-dosen-jurnal section.content {
            padding: 0 0 40px !important;
        }

        /* -------------------------------------------------------------------------
           BREADCRUMB
           ------------------------------------------------------------------------- */
        .page-dosen-jurnal .upp3m-breadcrumb {
            margin: 0;
            padding: 0;
            background: transparent;
            font-size: 12.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .page-dosen-jurnal .upp3m-breadcrumb .breadcrumb-item a {
            color: var(--p3m-up-forest);
            text-decoration: none;
            transition: opacity .18s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .page-dosen-jurnal .upp3m-breadcrumb .breadcrumb-item a:hover {
            opacity: .75;
        }

        .page-dosen-jurnal .upp3m-breadcrumb .breadcrumb-item.active {
            color: var(--p3m-up-muted);
        }

        .page-dosen-jurnal .upp3m-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            content: "/";
            padding: 0 8px;
            color: var(--p3m-up-border-2);
        }

        /* -------------------------------------------------------------------------
           MAIN CARD
           ------------------------------------------------------------------------- */
        .page-dosen-jurnal .upp3m-card {
            background: var(--p3m-up-surface);
            border: 1px solid var(--p3m-up-border);
            border-radius: var(--p3m-up-r-2xl);
            box-shadow: 0 12px 36px rgba(3, 50, 33, .07), 0 2px 6px rgba(0, 0, 0, .02);
            overflow: hidden;
        }

        /* -------------------------------------------------------------------------
           CARD HEADER
           ------------------------------------------------------------------------- */
        .page-dosen-jurnal .upp3m-card-head {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            padding: 24px var(--p3m-up-card-inline) 22px;
            background: linear-gradient(112deg, #ffffff 60%, #f2faf6 100%);
            border-bottom: 1px solid var(--p3m-up-border);
        }

        .page-dosen-jurnal .upp3m-title-group {
            min-width: 0;
        }

        .page-dosen-jurnal .upp3m-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            color: var(--p3m-up-forest-mid);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .page-dosen-jurnal .upp3m-kicker::before {
            content: "";
            width: 18px;
            height: 2.5px;
            border-radius: 99px;
            background: var(--p3m-up-gold);
        }

        .page-dosen-jurnal .upp3m-card-title {
            margin: 0 0 5px;
            color: var(--p3m-up-ink);
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 22px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .page-dosen-jurnal .upp3m-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .page-dosen-jurnal .upp3m-count-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 40px;
            padding: 0 15px;
            border: 1px solid var(--p3m-up-border);
            border-radius: var(--p3m-up-r-md);
            background: var(--p3m-up-surface-alt);
            color: var(--p3m-up-ink-2);
            font-size: 12.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .page-dosen-jurnal .upp3m-count-chip i {
            color: var(--p3m-up-forest-mid);
            font-size: 12px;
        }

        .page-dosen-jurnal .upp3m-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 40px;
            padding: 0 18px;
            border: none;
            border-radius: var(--p3m-up-r-md);
            background: linear-gradient(135deg, var(--p3m-up-forest) 0%, var(--p3m-up-forest-mid) 100%);
            color: #ffffff !important;
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none !important;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(0, 61, 45, .22);
            transition: all .2s ease;
            white-space: nowrap;
        }

        .page-dosen-jurnal .upp3m-add-btn:hover {
            background: linear-gradient(135deg, var(--p3m-up-forest-deep) 0%, var(--p3m-up-forest) 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 46, 34, .28);
            color: #ffffff !important;
        }

        .page-dosen-jurnal .upp3m-add-btn i {
            font-size: 11px;
            transition: transform .2s ease;
        }

        .page-dosen-jurnal .upp3m-add-btn:hover i {
            transform: rotate(90deg);
        }

        /* -------------------------------------------------------------------------
           TOOLBAR (Identik: Tampilkan [10] data + Dropdown Filter Kategori & Status)
           ------------------------------------------------------------------------- */
        .page-dosen-jurnal .upp3m-toolbar {
            position: relative;
            z-index: 25;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            padding: 14px var(--p3m-up-card-inline);
            background: var(--p3m-up-surface);
            border-bottom: 1px solid var(--p3m-up-border);
        }

        .page-dosen-jurnal .upp3m-toolbar-left {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--p3m-up-muted);
            font-size: 13px;
            font-weight: 600;
            flex-wrap: wrap;
        }

        .page-dosen-jurnal .upp3m-toolbar-label {
            color: var(--p3m-up-ink-2);
            font-weight: 700;
        }

        .page-dosen-jurnal .upp3m-select-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .page-dosen-jurnal .upp3m-toolbar-select {
            height: 38px;
            padding: 0 32px 0 14px;
            border: 1.5px solid var(--p3m-up-border-2);
            border-radius: var(--p3m-up-r-sm);
            outline: none;
            background-color: var(--p3m-up-surface);
            color: var(--p3m-up-ink);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            transition: all .18s ease;
            line-height: 38px;
        }

        .page-dosen-jurnal .upp3m-page-len-wrap .upp3m-toolbar-select {
            padding: 0 24px 0 10px;
            width: 62px;
        }

        .page-dosen-jurnal .upp3m-toolbar-select:focus {
            border-color: var(--p3m-up-forest-mid);
            box-shadow: 0 0 0 3px rgba(0, 87, 59, .1);
        }

        .page-dosen-jurnal .upp3m-toolbar-select:hover {
            border-color: #a7c4b5;
            background-color: var(--p3m-up-surface-hover);
        }

        .page-dosen-jurnal .upp3m-select-chevron {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 11px;
            pointer-events: none;
            transition: all .18s ease;
        }

        .page-dosen-jurnal .upp3m-select-wrap:hover .upp3m-select-chevron {
            color: var(--p3m-up-forest-mid);
        }

        .page-dosen-jurnal .upp3m-search-wrap {
            position: relative;
            width: 250px;
        }

        .page-dosen-jurnal .upp3m-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--p3m-up-light);
            font-size: 13px;
            pointer-events: none;
        }

        .page-dosen-jurnal .upp3m-search-input {
            width: 100%;
            height: 38px;
            padding: 0 14px 0 36px;
            border: 1.5px solid var(--p3m-up-border-2);
            border-radius: var(--p3m-up-r-sm);
            outline: none;
            background: var(--p3m-up-surface);
            color: var(--p3m-up-ink);
            font-size: 13px;
            font-weight: 500;
            transition: all .18s ease;
        }

        .page-dosen-jurnal .upp3m-search-input::placeholder {
            color: var(--p3m-up-light);
        }

        .page-dosen-jurnal .upp3m-search-input:hover {
            border-color: #c7d8cf;
            background-color: var(--p3m-up-surface-hover);
        }

        .page-dosen-jurnal .upp3m-search-input:focus {
            border-color: var(--p3m-up-forest-mid);
            box-shadow: 0 0 0 3px rgba(0, 87, 59, .1);
            background-color: #ffffff;
        }

        /* -------------------------------------------------------------------------
           DATA TABLE
           ------------------------------------------------------------------------- */
        .page-dosen-jurnal .upp3m-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 61, 45, 0.18) transparent;
        }

        .page-dosen-jurnal .upp3m-table-wrap::-webkit-scrollbar {
            height: 5px;
        }

        .page-dosen-jurnal .upp3m-table-wrap::-webkit-scrollbar-track {
            background: transparent;
        }

        .page-dosen-jurnal .upp3m-table-wrap::-webkit-scrollbar-thumb {
            background: rgba(0, 61, 45, 0.18);
            border-radius: 99px;
        }

        .page-dosen-jurnal table.upp3m-table {
            width: 100% !important;
            margin: 0 !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        .page-dosen-jurnal table.upp3m-table thead th {
            padding: 13px 18px !important;
            background: var(--p3m-up-surface-alt);
            border-top: none !important;
            border-bottom: 1px solid var(--p3m-up-border) !important;
            color: #52675e;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            white-space: nowrap;
            vertical-align: middle;
            position: relative;
            cursor: default !important;
        }

        .page-dosen-jurnal table.upp3m-table thead th:first-child {
            padding-left: var(--p3m-up-card-inline) !important;
        }

        .page-dosen-jurnal table.upp3m-table thead th:last-child {
            padding-right: var(--p3m-up-card-inline) !important;
        }

        .page-dosen-jurnal table.dataTable thead th:before,
        .page-dosen-jurnal table.dataTable thead th:after,
        .page-dosen-jurnal table.dataTable thead .sorting:before,
        .page-dosen-jurnal table.dataTable thead .sorting_asc:before,
        .page-dosen-jurnal table.dataTable thead .sorting_desc:before,
        .page-dosen-jurnal table.dataTable thead .sorting:after,
        .page-dosen-jurnal table.dataTable thead .sorting_asc:after,
        .page-dosen-jurnal table.dataTable thead .sorting_desc:after,
        .page-dosen-jurnal table.dataTable thead th.sorting_disabled:before,
        .page-dosen-jurnal table.dataTable thead th.sorting_disabled:after {
            display: none !important;
            content: "" !important;
        }

        .page-dosen-jurnal table.upp3m-table tbody td {
            padding: 16px 18px;
            vertical-align: middle;
            border-bottom: 1px solid var(--p3m-up-border);
            color: var(--p3m-up-text);
            font-size: 13px;
            transition: background .15s ease;
        }

        .page-dosen-jurnal table.upp3m-table tbody tr:last-child td {
            border-bottom: none;
        }

        .page-dosen-jurnal table.upp3m-table tbody tr:hover td {
            background: var(--p3m-up-surface-alt);
        }

        .page-dosen-jurnal table.upp3m-table tbody td:first-child {
            padding-left: var(--p3m-up-card-inline);
        }

        .page-dosen-jurnal table.upp3m-table tbody td:last-child {
            padding-right: var(--p3m-up-card-inline);
        }

        /* Number Column */
        .page-dosen-jurnal .upp3m-row-num {
            color: var(--p3m-up-light);
            font-size: 12.5px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
            text-align: center;
        }

        /* Proposal / Jurnal Cell */
        .page-dosen-jurnal .upp3m-proposal-cell {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .page-dosen-jurnal .upp3m-proposal-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d3e2d9;
            border-radius: var(--p3m-up-r-md);
            background: linear-gradient(135deg, #f7fbf8 0%, #edf6f1 100%);
            color: var(--p3m-up-forest);
            font-size: 16px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .8);
        }

        .page-dosen-jurnal .upp3m-proposal-copy {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .page-dosen-jurnal .upp3m-proposal-title {
            color: var(--p3m-up-ink);
            font-size: 13.5px;
            line-height: 1.4;
            font-weight: 700;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-word;
        }

        .page-dosen-jurnal .upp3m-proposal-meta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .page-dosen-jurnal .upp3m-proposal-id {
            display: inline-block;
            padding: 1.5px 7px;
            background: #eef5f1;
            border-radius: 5px;
            color: var(--p3m-up-forest-mid);
            font-size: 11px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        .page-dosen-jurnal .upp3m-proposal-date {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: var(--p3m-up-muted);
            font-size: 11px;
            font-weight: 500;
        }

        /* Field & Category Chip */
        .page-dosen-jurnal .upp3m-field-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            max-width: 100%;
            padding: 5px 12px;
            border: 1px solid var(--p3m-up-border-2);
            border-radius: 99px;
            background: var(--p3m-up-surface-alt);
            color: var(--p3m-up-text);
            font-size: 11.5px;
            font-weight: 600;
            line-height: 1.3;
            white-space: nowrap;
        }

        .page-dosen-jurnal .upp3m-field-chip i {
            color: var(--p3m-up-forest-mid);
            font-size: 11px;
            flex-shrink: 0;
        }

        /* File Download Link Pill */
        .page-dosen-jurnal .upp3m-file-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: var(--p3m-up-r-sm);
            background: var(--p3m-up-surface-alt);
            border: 1px solid var(--p3m-up-border-2);
            color: var(--p3m-up-ink-2);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none !important;
            transition: all .15s ease;
            max-width: 220px;
        }

        .page-dosen-jurnal .upp3m-file-pill i {
            color: #dc2626;
            font-size: 12.5px;
            flex-shrink: 0;
        }

        .page-dosen-jurnal .upp3m-file-pill span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .page-dosen-jurnal .upp3m-file-pill:hover {
            background: var(--p3m-up-surface-hover);
            border-color: #c7d8cf;
            color: var(--p3m-up-forest);
        }

        /* Status Badges */
        .page-dosen-jurnal .upp3m-status-wrap {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }

        .page-dosen-jurnal .upp3m-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border: 1px solid transparent;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 700;
            white-space: nowrap;
            letter-spacing: .01em;
        }

        .page-dosen-jurnal .upp3m-status-badge i {
            font-size: 10.5px;
        }

        .page-dosen-jurnal .upp3m-status-approved {
            background: var(--p3m-up-success-bg);
            color: var(--p3m-up-success);
            border-color: var(--p3m-up-success-border);
        }

        .page-dosen-jurnal .upp3m-status-process {
            background: var(--p3m-up-warning-bg);
            color: var(--p3m-up-warning);
            border-color: var(--p3m-up-warning-border);
        }

        .page-dosen-jurnal .upp3m-status-revised {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .page-dosen-jurnal .upp3m-status-rejected {
            background: var(--p3m-up-danger-bg);
            color: var(--p3m-up-danger);
            border-color: var(--p3m-up-danger-border);
        }

        .page-dosen-jurnal .upp3m-admin-note {
            margin-top: 4px;
            padding: 5px 9px;
            border-radius: 6px;
            background: #ffffff;
            border: 1px dashed var(--p3m-up-border-2);
            font-size: 11px;
            color: var(--p3m-up-muted);
            line-height: 1.4;
            max-width: 240px;
        }

        .page-dosen-jurnal .upp3m-admin-note strong {
            color: var(--p3m-up-ink-2);
        }

        /* Action Buttons */
        .page-dosen-jurnal .upp3m-action-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .page-dosen-jurnal .upp3m-action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 1px solid transparent;
            border-radius: var(--p3m-up-r-sm);
            font-size: 12px;
            text-decoration: none !important;
            cursor: pointer;
            transition: all .18s ease;
        }

        .page-dosen-jurnal .upp3m-action-detail {
            background: #f0f9ff;
            color: #0284c7;
            border-color: #bae6fd;
        }

        .page-dosen-jurnal .upp3m-action-detail:hover {
            background: #0284c7;
            color: #ffffff !important;
            border-color: #0284c7;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, .22);
        }

        .page-dosen-jurnal .upp3m-action-edit {
            background: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }

        .page-dosen-jurnal .upp3m-action-edit:hover {
            background: #16a34a;
            color: #ffffff !important;
            border-color: #16a34a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(22, 163, 74, .22);
        }

        .page-dosen-jurnal .upp3m-action-delete {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .page-dosen-jurnal .upp3m-action-delete:hover {
            background: #dc2626;
            color: #ffffff !important;
            border-color: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, .22);
        }

        /* Empty State */
        .page-dosen-jurnal .upp3m-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 42px 20px;
            text-align: center;
        }

        .page-dosen-jurnal .upp3m-empty-icon {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: var(--p3m-up-forest-soft);
            color: var(--p3m-up-forest-mid);
            font-size: 20px;
            margin-bottom: 10px;
        }

        .page-dosen-jurnal .upp3m-empty-title {
            color: var(--p3m-up-ink-2);
            font-size: 13.5px;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .page-dosen-jurnal .upp3m-empty-text {
            color: var(--p3m-up-muted);
            font-size: 12px;
            max-width: 380px;
            line-height: 1.5;
        }

        /* -------------------------------------------------------------------------
           FOOTER & PAGINATION (100% Identik tanpa bullet dot)
           ------------------------------------------------------------------------- */
        .page-dosen-jurnal .upp3m-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            padding: 14px var(--p3m-up-card-inline);
            background: var(--p3m-up-surface-alt);
            border-top: 1px solid var(--p3m-up-border);
        }

        .page-dosen-jurnal .upp3m-info {
            color: var(--p3m-up-muted);
            font-size: 12.5px;
            font-weight: 600;
        }

        .page-dosen-jurnal .upp3m-pagination {
            display: flex;
            align-items: center;
            gap: 4px;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }

        .page-dosen-jurnal .upp3m-pagination li {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .page-dosen-jurnal .upp3m-pagination li::before {
            display: none !important;
            content: "" !important;
        }

        .page-dosen-jurnal .upp3m-pagination .page-item .page-link {
            min-width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 8px;
            border: 1px solid var(--p3m-up-border);
            border-radius: var(--p3m-up-r-sm);
            background: var(--p3m-up-surface);
            color: var(--p3m-up-text);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all .18s ease;
        }

        .page-dosen-jurnal .upp3m-pagination .page-item.active .page-link {
            background: var(--p3m-up-forest);
            border-color: var(--p3m-up-forest);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 61, 45, .22);
        }

        .page-dosen-jurnal .upp3m-pagination .page-item:not(.active) .page-link:hover {
            background: var(--p3m-up-surface-hover);
            border-color: var(--p3m-up-border-2);
            color: var(--p3m-up-ink);
        }

        .page-dosen-jurnal .upp3m-pagination .page-item.disabled .page-link {
            opacity: .45;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Hide native DataTables controls */
        #jurnalTable_wrapper .dataTables_length,
        #jurnalTable_wrapper .dataTables_filter,
        #jurnalTable_wrapper .dataTables_info,
        #jurnalTable_wrapper .dataTables_paginate {
            display: none !important;
        }

        /* -------------------------------------------------------------------------
           DESKTOP & RESPONSIVE BEHAVIOR
           ------------------------------------------------------------------------- */
        @media (min-width: 992px) {
            .page-dosen-jurnal .upp3m-table-wrap {
                overflow-x: visible;
            }
        }

        @media (max-width: 991.98px) {
            .page-dosen-jurnal table.upp3m-table {
                min-width: 860px;
            }
        }

        @media (max-width: 767.98px) {
            :root {
                --p3m-up-card-inline: 18px;
            }

            .page-dosen-jurnal .upp3m-shell {
                width: calc(100% - 28px);
            }

            .page-dosen-jurnal .content-header {
                padding: 18px 0 10px !important;
            }

            .page-dosen-jurnal .upp3m-card-head {
                padding: 20px var(--p3m-up-card-inline) 16px;
            }

            .page-dosen-jurnal .upp3m-card-title {
                font-size: 19px;
            }

            .page-dosen-jurnal .upp3m-header-actions {
                width: 100%;
            }

            .page-dosen-jurnal .upp3m-count-chip,
            .page-dosen-jurnal .upp3m-add-btn {
                flex: 1;
                justify-content: center;
            }

            .page-dosen-jurnal .upp3m-toolbar {
                flex-direction: column;
                align-items: stretch;
                padding: 12px var(--p3m-up-card-inline);
            }

            .page-dosen-jurnal .upp3m-toolbar-left {
                width: 100%;
                justify-content: flex-start;
            }

            .page-dosen-jurnal .upp3m-search-wrap {
                width: 100%;
            }

            .page-dosen-jurnal .upp3m-footer {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 12px var(--p3m-up-card-inline);
            }
        }

        @media (max-width: 575.98px) {
            .page-dosen-jurnal .upp3m-shell {
                width: calc(100% - 18px);
            }

            .page-dosen-jurnal .upp3m-header-actions {
                flex-direction: column;
            }

            .page-dosen-jurnal .upp3m-count-chip,
            .page-dosen-jurnal .upp3m-add-btn {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">

        {{-- BREADCRUMBS --}}
        <div class="content-header">
            <div class="upp3m-shell">
                <ol class="breadcrumb upp3m-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dosen.dash') }}">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active" id="jurnalBreadcrumbActive">
                        Upload Jurnal {{ strtolower($kategori) === 'pengabdian' ? 'Pengabdian' : (strtolower($kategori) === 'penelitian' ? 'Penelitian' : 'Ilmiah') }}
                    </li>
                </ol>
            </div>
        </div>

        {{-- MAIN CARD --}}
        <section class="content">
            <div class="upp3m-shell">

                <div class="upp3m-card">

                    {{-- CARD HEADER --}}
                    <div class="upp3m-card-head">
                        <div class="upp3m-title-group">
                            <span class="upp3m-kicker" id="jurnalKicker">
                                {{ strtolower($kategori) === 'pengabdian' ? 'Pengabdian Masyarakat' : (strtolower($kategori) === 'penelitian' ? 'Penelitian Masyarakat' : 'Panel Dosen P3M') }}
                            </span>
                            <h1 class="upp3m-card-title" id="jurnalCardTitle">
                                Upload Jurnal {{ strtolower($kategori) === 'pengabdian' ? 'Pengabdian' : (strtolower($kategori) === 'penelitian' ? 'Penelitian' : 'Ilmiah') }}
                            </h1>
                        </div>

                        <div class="upp3m-header-actions">
                            <div class="upp3m-count-chip" id="jurnalCountChip">
                                <i class="fas fa-file-alt"></i>
                                <span>Total <strong>0</strong> jurnal</span>
                            </div>

                            <a href="{{ route('dosen.jurnal_upload.create', ['kategori' => $kategori ?: 'penelitian']) }}" class="upp3m-add-btn" id="btnAddJurnal">
                                <i class="fas fa-plus"></i>
                                <span>Upload Jurnal Baru</span>
                            </a>
                        </div>
                    </div>

                    {{-- TOOLBAR (Tampilkan [10] data + Dropdown Filter Kategori & Status) --}}
                    <div class="upp3m-toolbar">
                        <div class="upp3m-toolbar-left">
                            <span class="upp3m-toolbar-label">
                                Tampilkan
                            </span>
                            <x-p3m-dropdown
                                id="jurnalPageLength"
                                value="10"
                                :compact="true"
                                :options="[
                                    ['value' => '10', 'label' => '10'],
                                    ['value' => '25', 'label' => '25'],
                                    ['value' => '50', 'label' => '50'],
                                    ['value' => '100', 'label' => '100'],
                                ]"
                            />
                            <span>
                                data
                            </span>

                            @php
                                $currentKat = '';
                                if (strtolower($kategori) === 'penelitian') $currentKat = 'Penelitian';
                                elseif (strtolower($kategori) === 'pengabdian') $currentKat = 'Pengabdian';

                                $currentStatus = '';
                                if (strtolower($status) === 'diproses') $currentStatus = 'Diproses';
                                elseif (in_array(strtolower($status), ['disetujui', 'diterima'])) $currentStatus = 'Disetujui';
                                elseif (in_array(strtolower($status), ['ditolak', 'direvisi'])) $currentStatus = 'Ditolak';
                            @endphp

                            <x-p3m-dropdown
                                id="filterKategori"
                                value="{{ $currentKat }}"
                                class="ml-1"
                                :options="[
                                    ['value' => '', 'label' => 'Semua Kategori', 'icon' => 'fas fa-layer-group p3m-dropdown-icon', 'divider' => true],
                                    ['value' => 'Penelitian', 'label' => 'Jurnal Penelitian', 'dot' => 'dot-primary'],
                                    ['value' => 'Pengabdian', 'label' => 'Jurnal Pengabdian', 'dot' => 'dot-purple'],
                                ]"
                            />

                            <x-p3m-dropdown
                                id="filterStatus"
                                value="{{ $currentStatus }}"
                                class="ml-1"
                                :options="[
                                    ['value' => '', 'label' => 'Semua Status', 'icon' => 'fas fa-sliders-h p3m-dropdown-icon', 'divider' => true],
                                    ['value' => 'Diproses', 'label' => 'Diproses', 'dot' => 'dot-warning'],
                                    ['value' => 'Disetujui', 'label' => 'Disetujui', 'dot' => 'dot-success'],
                                    ['value' => 'Ditolak', 'label' => 'Ditolak', 'dot' => 'dot-danger'],
                                ]"
                            />
                        </div>

                        <div class="upp3m-search-wrap">
                            <i class="fas fa-search upp3m-search-icon"></i>
                            <input type="text" class="upp3m-search-input" id="jurnalSearch"
                                placeholder="Cari judul jurnal..." aria-label="Cari judul jurnal">
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="upp3m-table-wrap">
                        <table id="jurnalTable" class="table upp3m-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;" class="text-center">
                                        No
                                    </th>
                                    <th style="width: 35%;">
                                        Judul Jurnal
                                    </th>
                                    <th style="width: 20%;">
                                        Kategori
                                    </th>
                                    <th style="width: 17%;">
                                        Berkas Jurnal
                                    </th>
                                    <th style="width: 13%;">
                                        Status
                                    </th>
                                    <th style="width: 10%;" class="text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($uploads as $item)
                                    <tr>
                                        {{-- 1. No --}}
                                        <td class="upp3m-row-num">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- 2. Judul Jurnal --}}
                                        <td>
                                            <div class="upp3m-proposal-cell">
                                                <span class="upp3m-proposal-icon" aria-hidden="true">
                                                    <i class="fas fa-file-alt"></i>
                                                </span>
                                                <div class="upp3m-proposal-copy">
                                                    <span class="upp3m-proposal-title" title="{{ $item->judul }}">
                                                        {{ $item->judul }}
                                                    </span>
                                                    <div class="upp3m-proposal-meta">
                                                        <span class="upp3m-proposal-id">
                                                            #{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                                        </span>
                                                        @if(!empty($item->created_at))
                                                            <span class="upp3m-proposal-date">
                                                                <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- 3. Kategori --}}
                                        <td>
                                            @if ($item->kategori === 'pengabdian')
                                                <span class="upp3m-field-chip" title="Jurnal Pengabdian Masyarakat">
                                                    <i class="fas fa-hand-holding-heart"></i>
                                                    <span>Pengabdian</span>
                                                </span>
                                            @else
                                                <span class="upp3m-field-chip" title="Jurnal Penelitian">
                                                    <i class="fas fa-microscope"></i>
                                                    <span>Penelitian</span>
                                                </span>
                                            @endif
                                        </td>

                                        {{-- 4. Berkas Jurnal --}}
                                        <td>
                                            <a href="{{ route('dosen.jurnal_upload.download', $item->id) }}" class="upp3m-file-pill" title="Unduh Berkas: {{ $item->file_name }}">
                                                <i class="fas fa-file-pdf"></i>
                                                <span>{{ $item->file_name }}</span>
                                            </a>
                                        </td>

                                        {{-- 5. Status --}}
                                        <td>
                                            <div class="upp3m-status-wrap">
                                                @if ($item->status === 'diterima' || $item->status === 'approve')
                                                    <span class="upp3m-status-badge upp3m-status-approved">
                                                        <i class="fas fa-check-circle"></i>
                                                        <span>Disetujui</span>
                                                    </span>
                                                @elseif ($item->status === 'diproses' || $item->status === 'proses')
                                                    <span class="upp3m-status-badge upp3m-status-process">
                                                        <i class="fas fa-clock"></i>
                                                        <span>Diproses</span>
                                                    </span>
                                                @else
                                                    <span class="upp3m-status-badge upp3m-status-rejected">
                                                        <i class="fas fa-times-circle"></i>
                                                        <span>Ditolak</span>
                                                    </span>
                                                @endif

                                                @if ($item->catatan_admin)
                                                    <div class="upp3m-admin-note">
                                                        <strong>Catatan:</strong> {{ $item->catatan_admin }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- 6. Aksi --}}
                                        <td class="text-center">
                                            <div class="upp3m-action-wrap">
                                                <a href="{{ route('dosen.jurnal_upload.download', $item->id) }}"
                                                    class="upp3m-action-btn upp3m-action-detail" title="Unduh Berkas Jurnal"
                                                    aria-label="Unduh berkas jurnal">
                                                    <i class="fas fa-download"></i>
                                                </a>

                                                @if ($item->status !== 'diterima')
                                                    <a href="{{ route('dosen.jurnal_upload.edit', $item->id) }}"
                                                        class="upp3m-action-btn upp3m-action-edit" title="Edit Jurnal"
                                                        aria-label="Edit jurnal">
                                                        <i class="fas fa-pen"></i>
                                                    </a>

                                                    <button type="button" class="upp3m-action-btn upp3m-action-delete js-delete-btn"
                                                        data-url="{{ route('dosen.jurnal_upload.delete', $item->id) }}"
                                                        data-label="{{ Str::limit($item->judul, 40) }}"
                                                        title="Hapus Jurnal" aria-label="Hapus jurnal">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- FOOTER --}}
                    <div class="upp3m-footer">
                        <span class="upp3m-info" id="jurnalTableInfo">
                            Menampilkan 0–0 dari 0 data
                        </span>

                        <div id="jurnalTablePagination"></div>
                    </div>

                </div>

            </div>
        </section>

    </div>

    {{-- Global Hidden Delete Form --}}
    <form id="global-delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('scripts')
    <script>
        (function() {
            let table = null;

            function initJurnalTable() {
                const $tableElement = $('#jurnalTable');
                if (!$tableElement.length) return;

                if ($.fn.DataTable.isDataTable('#jurnalTable')) {
                    $('#jurnalTable').DataTable().destroy();
                }

                table = $tableElement.DataTable({
                    responsive: false,
                    lengthChange: false,
                    searching: true,
                    ordering: false,
                    info: true,
                    autoWidth: false,
                    pageLength: 10,
                    language: {
                        search: "",
                        searchPlaceholder: "Cari judul jurnal...",
                        emptyTable: `
                            <div class="upp3m-empty-state">
                                <span class="upp3m-empty-icon"><i class="fas fa-inbox"></i></span>
                                <span class="upp3m-empty-title">Belum ada jurnal yang diunggah</span>
                                <span class="upp3m-empty-text">Data publikasi berkas jurnal yang Anda unggah akan tampil rapi pada tabel ini.</span>
                            </div>
                        `,
                        zeroRecords: `
                            <div class="upp3m-empty-state">
                                <span class="upp3m-empty-icon"><i class="fas fa-search"></i></span>
                                <span class="upp3m-empty-title">Tidak ada hasil pencarian</span>
                                <span class="upp3m-empty-text">Coba ubah kata kunci pencarian agar data jurnal yang dicari lebih mudah ditemukan.</span>
                            </div>
                        `,
                        info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0–0 dari 0 data",
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            next: '<i class="fas fa-chevron-right"></i>',
                            previous: '<i class="fas fa-chevron-left"></i>'
                        }
                    },
                    drawCallback: function() {
                        const info = this.api().page.info();
                        const from = info.recordsDisplay === 0 ? 0 : info.start + 1;
                        const to = Math.min(info.end, info.recordsDisplay);

                        $('#jurnalTableInfo').text(
                            'Menampilkan ' + from + '–' + to + ' dari ' + info.recordsDisplay + ' data'
                        );
                        $('#jurnalCountChip strong').text(info.recordsDisplay);

                        // Rebuild Custom Pagination
                        const $nativePagination = $(this.api().table().container()).find('.dataTables_paginate');
                        const $pagination = $('<ul class="upp3m-pagination pagination"></ul>');

                        $nativePagination.find('li').each(function(index) {
                            const $item = $(this).clone(true);
                            const $link = $item.find('a, span').first();
                            const $source = $nativePagination.find('li').eq(index);

                            $link.off('click.customPagination').on('click.customPagination', function(e) {
                                e.preventDefault();
                                $source.find('a, span').first().trigger('click');
                            });

                            $pagination.append($item);
                        });

                        $('#jurnalTablePagination').empty().append($pagination);
                    }
                });

                // Custom search input
                $('#jurnalSearch').off('input').on('input', function() {
                    table.search(this.value).draw();
                });

                // Page length select
                $('#jurnalPageLength').off('change').on('change', function() {
                    table.page.len(Number(this.value)).draw();
                });

                function updateHeaderDisplay() {
                    const kat = $('#filterKategori').val();
                    const $kicker = $('#jurnalKicker');
                    const $title = $('#jurnalCardTitle');
                    const $breadcrumbActive = $('#jurnalBreadcrumbActive');
                    const $btn = $('#btnAddJurnal');

                    if (kat === 'Pengabdian') {
                        $kicker.text('Pengabdian Masyarakat');
                        $title.text('Upload Jurnal Pengabdian');
                        $breadcrumbActive.text('Upload Jurnal Pengabdian');
                        if ($btn.length) $btn.attr('href', "{{ route('dosen.jurnal_upload.create', ['kategori' => 'pengabdian']) }}");
                    } else if (kat === 'Penelitian') {
                        $kicker.text('Penelitian Masyarakat');
                        $title.text('Upload Jurnal Penelitian');
                        $breadcrumbActive.text('Upload Jurnal Penelitian');
                        if ($btn.length) $btn.attr('href', "{{ route('dosen.jurnal_upload.create', ['kategori' => 'penelitian']) }}");
                    } else {
                        $kicker.text('Panel Dosen P3M');
                        $title.text('Upload Jurnal Ilmiah');
                        $breadcrumbActive.text('Upload Jurnal Ilmiah');
                        if ($btn.length) $btn.attr('href', "{{ route('dosen.jurnal_upload.create', ['kategori' => 'penelitian']) }}");
                    }
                }

                function syncFilterUrl() {
                    const kat = ($('#filterKategori').val() || '').toLowerCase();
                    const st = ($('#filterStatus').val() || '').toLowerCase();
                    const params = new URLSearchParams(window.location.search);
                    if (kat) {
                        params.set('kategori', kat);
                    } else {
                        params.delete('kategori');
                    }
                    if (st) {
                        params.set('status', st);
                    } else {
                        params.delete('status');
                    }
                    const query = params.toString() ? '?' + params.toString() : '';
                    const newUrl = window.location.pathname + query;
                    window.history.replaceState({}, '', newUrl);
                }

                // Filter Kategori (Column 2)
                $('#filterKategori').off('change').on('change', function() {
                    const val = $(this).val();
                    table.column(2).search(val ? val : '').draw();
                    updateHeaderDisplay();
                    syncFilterUrl();
                });

                // Filter Status (Column 4)
                $('#filterStatus').off('change').on('change', function() {
                    const val = $(this).val();
                    table.column(4).search(val ? val : '').draw();
                    syncFilterUrl();
                });

                // Trigger initial filters if selected
                const initKat = $('#filterKategori').val();
                const initStatus = $('#filterStatus').val();
                if (initKat) {
                    table.column(2).search(initKat);
                }
                if (initStatus) {
                    table.column(4).search(initStatus);
                }
                table.draw();
            }

            // Global Delete Confirmation (SweetAlert2 / p3mConfirm)
            $(document).off('click', '.js-delete-btn').on('click', '.js-delete-btn', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const url = $btn.data('url');
                const label = $btn.data('label') || 'jurnal ini';
                if (!url) return;

                if (typeof window.p3mConfirm === 'function') {
                    window.p3mConfirm({
                        title: 'Hapus Jurnal Ilmiah?',
                        html: 'Jurnal <strong>' + label +
                            '</strong> akan dihapus secara permanen.<br><span style="font-size:13px;color:#9ca3af;">Tindakan ini tidak dapat dibatalkan.</span>',
                        icon: 'warning',
                        confirmText: '<i class="fas fa-trash-alt" style="font-size:12px;"></i>&nbsp; Ya, Hapus',
                        confirmClass: 'p3m-swal-btn-danger',
                        onConfirm: function() {
                            const form = document.getElementById('global-delete-form');
                            if (form) {
                                form.action = url;
                                form.submit();
                            }
                        }
                    });
                } else if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Hapus Jurnal Ilmiah?',
                        html: 'Jurnal <strong>' + label + '</strong> akan dihapus secara permanen.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.getElementById('global-delete-form');
                            if (form) {
                                form.action = url;
                                form.submit();
                            }
                        }
                    });
                } else {
                    if (confirm('Apakah Anda yakin ingin menghapus ' + label + '?')) {
                        const form = document.getElementById('global-delete-form');
                        if (form) {
                            form.action = url;
                            form.submit();
                        }
                    }
                }
            });

            // Handle Turbo lifecycle & immediate execution
            let initTimer = null;
            function scheduleInit() {
                clearTimeout(initTimer);
                initTimer = setTimeout(initJurnalTable, 20);
            }

            document.addEventListener('turbo:load', scheduleInit);
            document.addEventListener('turbo:before-cache', function() {
                if (table && $.fn.DataTable.isDataTable('#jurnalTable')) {
                    $('#jurnalTable').DataTable().destroy();
                }
            });

            scheduleInit();
        })();
    </script>
@endsection
