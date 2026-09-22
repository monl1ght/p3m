@extends('layout.doslayout')

@section('body_class', 'page-dosen-ajupeneliti')

@section('css')
    <style>
        /* =========================================================================
           P3M DOSEN — PENGAJUAN PENELITIAN
           Enterprise UI / UX Harmonized System (Consistent with Pengabdian Pages)
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
        .page-dosen-ajupeneliti .content-wrapper {
            min-height: calc(100vh - 66px);
            background:
                radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0, 93, 59, .05), transparent 70%),
                linear-gradient(180deg, #f2f8f5 0%, #f7faf8 100%) !important;
        }

        .upp3m-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-ajupeneliti .content-header {
            padding: 24px 0 14px !important;
        }

        .page-dosen-ajupeneliti section.content {
            padding: 0 0 40px !important;
        }

        /* -------------------------------------------------------------------------
           BREADCRUMB
           ------------------------------------------------------------------------- */
        .upp3m-breadcrumb {
            margin: 0;
            padding: 0;
            background: transparent;
            font-size: 12.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .upp3m-breadcrumb .breadcrumb-item a {
            color: var(--p3m-up-forest);
            text-decoration: none;
            transition: opacity .18s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .upp3m-breadcrumb .breadcrumb-item a:hover {
            opacity: .75;
        }

        .upp3m-breadcrumb .breadcrumb-item.active {
            color: var(--p3m-up-muted);
        }

        .upp3m-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            content: "/";
            padding: 0 8px;
            color: var(--p3m-up-border-2);
        }

        /* -------------------------------------------------------------------------
           MAIN CARD
           ------------------------------------------------------------------------- */
        .upp3m-card {
            background: var(--p3m-up-surface);
            border: 1px solid var(--p3m-up-border);
            border-radius: var(--p3m-up-r-2xl);
            box-shadow: 0 12px 36px rgba(3, 50, 33, .07), 0 2px 6px rgba(0, 0, 0, .02);
            overflow: hidden;
        }

        /* -------------------------------------------------------------------------
           CARD HEADER
           ------------------------------------------------------------------------- */
        .upp3m-card-head {
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

        .upp3m-title-group {
            min-width: 0;
        }

        .upp3m-kicker {
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

        .upp3m-kicker::before {
            content: "";
            width: 18px;
            height: 2.5px;
            border-radius: 99px;
            background: var(--p3m-up-gold);
        }

        .upp3m-card-title {
            margin: 0 0 5px;
            color: var(--p3m-up-ink);
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 22px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .upp3m-card-subtitle {
            margin: 0;
            color: var(--p3m-up-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .upp3m-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .upp3m-count-chip {
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

        .upp3m-count-chip i {
            color: var(--p3m-up-forest-mid);
            font-size: 12px;
        }

        .upp3m-add-btn {
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

        .upp3m-add-btn:hover {
            background: linear-gradient(135deg, var(--p3m-up-forest-deep) 0%, var(--p3m-up-forest) 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 46, 34, .28);
            color: #ffffff !important;
        }

        .upp3m-add-btn i {
            font-size: 11px;
            transition: transform .2s ease;
        }

        .upp3m-add-btn:hover i {
            transform: rotate(90deg);
        }

        /* -------------------------------------------------------------------------
           TOOLBAR
           ------------------------------------------------------------------------- */
        .upp3m-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            padding: 14px var(--p3m-up-card-inline);
            background: var(--p3m-up-surface);
            border-bottom: 1px solid var(--p3m-up-border);
        }

        .upp3m-toolbar-left {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--p3m-up-muted);
            font-size: 13px;
            font-weight: 600;
        }

        .upp3m-toolbar-label {
            color: var(--p3m-up-ink-2);
            font-weight: 700;
        }

        .upp3m-toolbar-select {
            height: 38px;
            padding: 0 28px 0 12px;
            border: 1.5px solid var(--p3m-up-border-2);
            border-radius: var(--p3m-up-r-sm);
            outline: none;
            background: var(--p3m-up-surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236b7f78'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E") no-repeat right 8px center/14px;
            appearance: none;
            -webkit-appearance: none;
            color: var(--p3m-up-ink);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .18s ease;
        }

        .upp3m-toolbar-select:focus {
            border-color: var(--p3m-up-forest-mid);
            box-shadow: 0 0 0 3px rgba(0, 87, 59, .1);
        }

        .upp3m-toolbar-select:hover {
            border-color: #c7d8cf;
            background-color: var(--p3m-up-surface-hover);
        }

        .upp3m-search-wrap {
            position: relative;
            width: 250px;
        }

        .upp3m-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--p3m-up-light);
            font-size: 13px;
            pointer-events: none;
        }

        .upp3m-search-input {
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

        .upp3m-search-input::placeholder {
            color: var(--p3m-up-light);
        }

        .upp3m-search-input:hover {
            border-color: #c7d8cf;
            background-color: var(--p3m-up-surface-hover);
        }

        .upp3m-search-input:focus {
            border-color: var(--p3m-up-forest-mid);
            box-shadow: 0 0 0 3px rgba(0, 87, 59, .1);
            background-color: #ffffff;
        }

        /* -------------------------------------------------------------------------
           DATA TABLE WRAPPER & CORE
           ------------------------------------------------------------------------- */
        .upp3m-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 61, 45, 0.18) transparent;
        }

        .upp3m-table-wrap::-webkit-scrollbar {
            height: 5px;
        }

        .upp3m-table-wrap::-webkit-scrollbar-track {
            background: transparent;
        }

        .upp3m-table-wrap::-webkit-scrollbar-thumb {
            background: rgba(0, 61, 45, 0.18);
            border-radius: 99px;
        }

        table.upp3m-table {
            width: 100% !important;
            margin: 0 !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        table.upp3m-table thead th {
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

        table.upp3m-table thead th:first-child {
            padding-left: var(--p3m-up-card-inline, 28px) !important;
            padding-right: 14px !important;
            text-align: left !important;
            vertical-align: middle !important;
            width: 60px;
        }

        table.upp3m-table thead th:last-child {
            padding-right: var(--p3m-up-card-inline) !important;
        }

        /* Completely remove DataTables sorting symbols / arrow icons */
        table.dataTable thead th:before,
        table.dataTable thead th:after,
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead th.sorting_disabled:before,
        table.dataTable thead th.sorting_disabled:after {
            display: none !important;
            content: "" !important;
        }

        table.upp3m-table tbody td {
            padding: 16px 18px;
            vertical-align: middle;
            border-bottom: 1px solid var(--p3m-up-border);
            color: var(--p3m-up-text);
            font-size: 13px;
            transition: background .15s ease;
        }

        table.upp3m-table tbody tr:last-child td {
            border-bottom: none;
        }

        table.upp3m-table tbody tr:hover td {
            background: var(--p3m-up-surface-alt);
        }

        table.upp3m-table tbody td:first-child {
            padding-left: var(--p3m-up-card-inline, 28px) !important;
            padding-right: 14px !important;
            text-align: left !important;
            vertical-align: middle !important;
            width: 60px;
        }

        table.upp3m-table tbody td:last-child {
            padding-right: var(--p3m-up-card-inline);
        }

        /* Number Column */
        .upp3m-row-num {
            display: table-cell !important;
            vertical-align: middle !important;
            text-align: left !important;
            color: var(--p3m-up-light);
            font-size: 12.5px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        /* Proposal / Penelitian Cell */
        .upp3m-proposal-cell {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .upp3m-proposal-icon {
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

        .upp3m-proposal-copy {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .upp3m-proposal-title {
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

        .upp3m-proposal-meta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .upp3m-proposal-id {
            display: inline-block;
            padding: 1.5px 7px;
            background: #eef5f1;
            border-radius: 5px;
            color: var(--p3m-up-forest-mid);
            font-size: 11px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        .upp3m-proposal-date {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: var(--p3m-up-muted);
            font-size: 11px;
            font-weight: 500;
        }

        /* Field & Category */
        .upp3m-field-stack {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
            min-width: 0;
        }

        .upp3m-field-main {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--p3m-up-ink);
            font-size: 13px;
            line-height: 1.35;
            font-weight: 700;
        }

        .upp3m-field-main i {
            color: var(--p3m-up-forest-mid);
            font-size: 11px;
        }

        .upp3m-field-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            max-width: 100%;
            padding: 4px 10px;
            border: 1px solid var(--p3m-up-border-2);
            border-radius: 99px;
            background: var(--p3m-up-surface-alt);
            color: var(--p3m-up-text);
            font-size: 11px;
            font-weight: 600;
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .upp3m-field-chip i {
            color: var(--p3m-up-forest-mid);
            font-size: 10px;
            flex-shrink: 0;
        }

        .upp3m-field-chip span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Chairman Cell */
        .upp3m-chair {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .upp3m-chair-avatar {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(0, 93, 59, .15);
            border-radius: 10px;
            background: var(--p3m-up-forest-soft);
            color: var(--p3m-up-forest);
            font-size: 13px;
            font-weight: 800;
        }

        .upp3m-chair-copy {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .upp3m-chair-name {
            color: var(--p3m-up-ink);
            font-size: 13px;
            line-height: 1.35;
            font-weight: 700;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 180px;
        }

        .upp3m-chair-role {
            color: var(--p3m-up-muted);
            font-size: 11px;
            line-height: 1.3;
            font-weight: 600;
        }

        /* Status */
        .upp3m-status-wrap {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }

        .upp3m-status-badge {
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

        .upp3m-status-badge i {
            font-size: 10.5px;
        }

        .upp3m-status-approved {
            background: var(--p3m-up-success-bg);
            color: var(--p3m-up-success);
            border-color: var(--p3m-up-success-border);
        }

        .upp3m-status-process {
            background: var(--p3m-up-warning-bg);
            color: var(--p3m-up-warning);
            border-color: var(--p3m-up-warning-border);
        }

        .upp3m-status-rejected {
            background: var(--p3m-up-danger-bg);
            color: var(--p3m-up-danger);
            border-color: var(--p3m-up-danger-border);
        }

        .upp3m-download {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            min-height: 28px;
            padding: 0 10px;
            border: 1px solid #e8d68a;
            border-radius: 99px;
            background: var(--p3m-up-gold-soft);
            color: #7a6214 !important;
            font-size: 10.5px;
            font-weight: 700;
            text-decoration: none !important;
            transition: all .18s ease;
        }

        .upp3m-download:hover {
            background: #f7ecd0;
            color: #5f4b0b !important;
            transform: translateY(-1px);
        }

        .upp3m-download i {
            font-size: 10px;
        }

        /* Action Buttons */
        .upp3m-action-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .upp3m-action-btn {
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

        .upp3m-action-detail {
            background: #f0f9ff;
            color: #0284c7;
            border-color: #bae6fd;
        }

        .upp3m-action-detail:hover {
            background: #0284c7;
            color: #ffffff !important;
            border-color: #0284c7;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, .22);
        }

        .upp3m-action-edit {
            background: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }

        .upp3m-action-edit:hover {
            background: #16a34a;
            color: #ffffff !important;
            border-color: #16a34a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(22, 163, 74, .22);
        }

        .upp3m-action-delete {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .upp3m-action-delete:hover {
            background: #dc2626;
            color: #ffffff !important;
            border-color: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, .22);
        }

        /* -------------------------------------------------------------------------
           EMPTY STATE
           ------------------------------------------------------------------------- */
        .upp3m-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 42px 20px;
            text-align: center;
        }

        .upp3m-empty-icon {
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

        .upp3m-empty-title {
            color: var(--p3m-up-ink-2);
            font-size: 13.5px;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .upp3m-empty-text {
            color: var(--p3m-up-muted);
            font-size: 12px;
            max-width: 380px;
            line-height: 1.5;
        }

        /* -------------------------------------------------------------------------
           FOOTER & PAGINATION
           ------------------------------------------------------------------------- */
        .upp3m-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            padding: 14px var(--p3m-up-card-inline);
            background: var(--p3m-up-surface-alt);
            border-top: 1px solid var(--p3m-up-border);
        }

        .upp3m-info {
            color: var(--p3m-up-muted);
            font-size: 12.5px;
            font-weight: 600;
        }

        .upp3m-pagination {
            display: flex;
            align-items: center;
            gap: 4px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .upp3m-pagination .page-item .page-link {
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

        .upp3m-pagination .page-item.active .page-link {
            background: var(--p3m-up-forest);
            border-color: var(--p3m-up-forest);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 61, 45, .22);
        }

        .upp3m-pagination .page-item:not(.active) .page-link:hover {
            background: var(--p3m-up-surface-hover);
            border-color: var(--p3m-up-border-2);
            color: var(--p3m-up-ink);
        }

        .upp3m-pagination .page-item.disabled .page-link {
            opacity: .45;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Hide native DataTables controls */
        #clientside_wrapper .dataTables_length,
        #clientside_wrapper .dataTables_filter,
        #clientside_wrapper .dataTables_info,
        #clientside_wrapper .dataTables_paginate,
        #example2_wrapper .dataTables_length,
        #example2_wrapper .dataTables_filter,
        #example2_wrapper .dataTables_info,
        #example2_wrapper .dataTables_paginate {
            display: none !important;
        }

        /* -------------------------------------------------------------------------
           DESKTOP & RESPONSIVE BEHAVIOR
           ------------------------------------------------------------------------- */
        @media (min-width: 992px) {
            .upp3m-table-wrap {
                overflow-x: visible;
            }
        }

        @media (max-width: 991.98px) {
            table.upp3m-table {
                min-width: 860px;
            }
        }

        @media (max-width: 767.98px) {
            :root {
                --p3m-up-card-inline: 18px;
            }

            .upp3m-shell {
                width: calc(100% - 28px);
            }

            .page-dosen-ajupeneliti .content-header {
                padding: 18px 0 10px !important;
            }

            .upp3m-card-head {
                padding: 20px var(--p3m-up-card-inline) 16px;
            }

            .upp3m-card-title {
                font-size: 19px;
            }

            .upp3m-header-actions {
                width: 100%;
            }

            .upp3m-count-chip,
            .upp3m-add-btn {
                flex: 1;
                justify-content: center;
            }

            .upp3m-toolbar {
                flex-direction: column;
                align-items: stretch;
                padding: 12px var(--p3m-up-card-inline);
            }

            .upp3m-toolbar-left {
                width: 100%;
                justify-content: space-between;
            }

            .upp3m-search-wrap {
                width: 100%;
            }

            .upp3m-footer {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 12px var(--p3m-up-card-inline);
            }
        }

        @media (max-width: 575.98px) {
            .upp3m-shell {
                width: calc(100% - 18px);
            }

            .upp3m-header-actions {
                flex-direction: column;
            }

            .upp3m-count-chip,
            .upp3m-add-btn {
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
                    <li class="breadcrumb-item active">
                        {{ $pagetitle }}
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
                            <span class="upp3m-kicker">
                                Penelitian Masyarakat
                            </span>
                            <h1 class="upp3m-card-title">
                                {{ $pagetitle }}
                            </h1>
                        </div>

                        <div class="upp3m-header-actions">
                            <div class="upp3m-count-chip" id="researchCountChip">
                                <i class="fas fa-file-alt"></i>
                                <span>Total <strong>{{ $penelitians->count() }}</strong> pengajuan</span>
                            </div>

                            <a href="{{ route('dosen.add_ajuanpenelitian') }}" class="upp3m-add-btn">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Pengajuan</span>
                            </a>
                        </div>
                    </div>

                    {{-- TOOLBAR --}}
                    <div class="upp3m-toolbar">
                        <div class="upp3m-toolbar-left">
                            <span class="upp3m-toolbar-label">
                                Tampilkan
                            </span>
                            <x-p3m-dropdown
                                id="researchPageLength"
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
                                $currentStatus = '';
                                if (request('status')) {
                                    $reqSt = strtolower(request('status'));
                                    if ($reqSt === 'proses' || $reqSt === 'diproses') $currentStatus = 'Proses';
                                    elseif ($reqSt === 'disetujui' || $reqSt === 'approve') $currentStatus = 'Disetujui';
                                    elseif ($reqSt === 'ditolak' || $reqSt === 'reject') $currentStatus = 'Ditolak';
                                }
                            @endphp

                            <x-p3m-dropdown
                                id="filterStatus"
                                value="{{ $currentStatus }}"
                                class="ml-1"
                                :options="[
                                    ['value' => '', 'label' => 'Semua Status', 'icon' => 'fas fa-sliders-h p3m-dropdown-icon', 'divider' => true],
                                    ['value' => 'Proses', 'label' => 'Proses', 'dot' => 'dot-warning'],
                                    ['value' => 'Disetujui', 'label' => 'Disetujui', 'dot' => 'dot-success'],
                                    ['value' => 'Ditolak', 'label' => 'Ditolak', 'dot' => 'dot-danger'],
                                ]"
                            />
                        </div>

                        <div class="upp3m-search-wrap">
                            <i class="fas fa-search upp3m-search-icon"></i>
                            <input type="text" class="upp3m-search-input" id="researchSearch"
                                placeholder="Cari penelitian..." aria-label="Cari penelitian">
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="upp3m-table-wrap">
                        <table id="example2" class="table upp3m-table">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">
                                         No
                                     </th>
                                    <th style="width: 33%;">
                                        Judul Proposal
                                    </th>
                                    <th style="width: 25%;">
                                        Bidang &amp; Kategori
                                    </th>
                                    <th style="width: 17%;">
                                        Ketua Peneliti
                                    </th>
                                    <th style="width: 11%;">
                                        Status
                                    </th>
                                    <th style="width: 9%;" class="text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($penelitians as $d)
                                    <tr>
                                        {{-- 1. No --}}
                                        <td class="upp3m-row-num">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- 2. Judul Proposal --}}
                                        <td>
                                            <div class="upp3m-proposal-cell">
                                                <span class="upp3m-proposal-icon" aria-hidden="true">
                                                    <i class="fas fa-file-alt"></i>
                                                </span>
                                                <div class="upp3m-proposal-copy">
                                                    <span class="upp3m-proposal-title" title="{{ $d->judul }}">
                                                        {{ $d->judul }}
                                                    </span>
                                                    <div class="upp3m-proposal-meta">
                                                        <span class="upp3m-proposal-id">
                                                            #{{ str_pad($d->id, 3, '0', STR_PAD_LEFT) }}
                                                        </span>
                                                        @if(!empty($d->created_at))
                                                            <span class="upp3m-proposal-date">
                                                                <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($d->created_at)->translatedFormat('d M Y') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- 3. Bidang & Kategori --}}
                                        <td>
                                            <div class="upp3m-field-stack">
                                                <span class="upp3m-field-main">
                                                    <i class="fas fa-compass"></i>
                                                    {{ $d->bidang ?: 'Umum' }}
                                                </span>

                                                <span class="upp3m-field-chip" title="{{ $d->jeniskategori }}">
                                                    <i class="fas fa-layer-group"></i>
                                                    <span>{{ $d->jeniskategori ?: 'Penelitian' }}</span>
                                                </span>
                                            </div>
                                        </td>

                                        {{-- 4. Ketua Peneliti --}}
                                        <td>
                                            @php
                                                $chairName = $d->ketua ?: ($user->name ?? 'Dosen');
                                                $initial = strtoupper(substr($chairName, 0, 1));
                                            @endphp
                                            <span class="upp3m-chair">
                                                <span class="upp3m-chair-avatar">
                                                    {{ $initial }}
                                                </span>
                                                <span class="upp3m-chair-copy">
                                                    <span class="upp3m-chair-name" title="{{ $chairName }}">
                                                        {{ $chairName }}
                                                    </span>
                                                    <span class="upp3m-chair-role">
                                                        Ketua Peneliti
                                                    </span>
                                                </span>
                                            </span>
                                        </td>

                                        {{-- 5. Status --}}
                                        <td>
                                            <div class="upp3m-status-wrap">
                                                @if ($d->status === 'approve')
                                                    <span class="upp3m-status-badge upp3m-status-approved">
                                                        <i class="fas fa-check-circle"></i>
                                                        <span>Disetujui</span>
                                                    </span>

                                                    @if(!empty($d->id))
                                                        <a href="{{ route('p3m.surat-tugaspen.download', $d->id) }}"
                                                            class="upp3m-download" title="Unduh Surat Tugas Resmi">
                                                            <i class="fas fa-file-download"></i>
                                                            <span>Unduh Surat</span>
                                                        </a>
                                                    @endif
                                                @elseif($d->status === 'proses')
                                                    <span class="upp3m-status-badge upp3m-status-process">
                                                        <i class="fas fa-clock"></i>
                                                        <span>Proses</span>
                                                    </span>
                                                @else
                                                    <span class="upp3m-status-badge upp3m-status-rejected">
                                                        <i class="fas fa-times-circle"></i>
                                                        <span>Ditolak</span>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- 6. Aksi --}}
                                        <td class="text-center">
                                            <div class="upp3m-action-wrap">
                                                <a href="{{ route('detail.detail', ['tipe' => 'ajupenel', 'id' => $d->id]) }}"
                                                    class="upp3m-action-btn upp3m-action-detail" title="Lihat Detail Proposal"
                                                    aria-label="Lihat detail proposal penelitian">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @if ($d->status !== 'approve')
                                                    <a href="{{ route('dosen.edit_ajuanpenelitian', ['id' => $d->id]) }}"
                                                        class="upp3m-action-btn upp3m-action-edit" title="Edit Proposal"
                                                        aria-label="Edit pengajuan penelitian">
                                                        <i class="fas fa-pen"></i>
                                                    </a>

                                                    <button type="button" class="upp3m-action-btn upp3m-action-delete"
                                                        data-url="{{ route('dosen.deletepropen', ['id' => $d->id]) }}"
                                                        data-label="{{ Str::limit($d->judul ?? 'Pengajuan', 40) }}"
                                                        title="Hapus Proposal" aria-label="Hapus pengajuan penelitian">
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
                        <span class="upp3m-info" id="researchTableInfo">
                            Menampilkan 0–0 dari 0 data
                        </span>

                        <div id="researchTablePagination"></div>
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

            function initResearchTable() {
                const $tableElement = $('#example2');
                if (!$tableElement.length) return;

                if ($.fn.DataTable.isDataTable('#example2')) {
                    $('#example2').DataTable().destroy();
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
                        searchPlaceholder: "Cari penelitian...",
                        emptyTable: `
                            <div class="upp3m-empty-state">
                                <span class="upp3m-empty-icon"><i class="fas fa-inbox"></i></span>
                                <span class="upp3m-empty-title">Belum ada pengajuan penelitian</span>
                                <span class="upp3m-empty-text">Data proposal penelitian yang Anda buat akan tampil rapi pada tabel ini.</span>
                            </div>
                        `,
                        zeroRecords: `
                            <div class="upp3m-empty-state">
                                <span class="upp3m-empty-icon"><i class="fas fa-search"></i></span>
                                <span class="upp3m-empty-title">Tidak ada hasil pencarian</span>
                                <span class="upp3m-empty-text">Coba ubah kata kunci pencarian agar penelitian yang dicari lebih mudah ditemukan.</span>
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

                        $('#researchTableInfo').text(
                            'Menampilkan ' + from + '–' + to + ' dari ' + info.recordsDisplay + ' data'
                        );
                        $('#researchCountChip strong').text(info.recordsDisplay);

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

                        $('#researchTablePagination').empty().append($pagination);
                    }
                });

                // Custom search input
                $('#researchSearch').off('input').on('input', function() {
                    table.search(this.value).draw();
                });

                // Page length select
                $('#researchPageLength').off('change').on('change', function() {
                    table.page.len(Number(this.value)).draw();
                });

                // Filter Status (Column 4)
                $('#filterStatus').off('change').on('change', function() {
                    const val = $(this).val();
                    table.column(4).search(val ? val : '').draw();

                    const params = new URLSearchParams(window.location.search);
                    if (val) {
                        params.set('status', val.toLowerCase());
                    } else {
                        params.delete('status');
                    }
                    const query = params.toString() ? '?' + params.toString() : '';
                    window.history.replaceState({}, '', window.location.pathname + query);
                });

                // Initial filter if set
                const initStatus = $('#filterStatus').val();
                if (initStatus) {
                    table.column(4).search(initStatus);
                }
                table.draw();
            }

            // Global Delete Confirmation
            $(document).off('click', '.upp3m-action-delete').on('click', '.upp3m-action-delete', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const url = $btn.data('url');
                const label = $btn.data('label') || 'pengajuan ini';
                if (!url) return;

                const desc = 'Pengajuan "' + label + '" akan dihapus permanen dan tidak dapat dibatalkan.';

                if (typeof window.p3mConfirm === 'function') {
                    window.p3mConfirm({
                        title: 'Hapus Pengajuan?',
                        html: desc,
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
                        title: 'Hapus Pengajuan?',
                        html: desc,
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
                initTimer = setTimeout(initResearchTable, 20);
            }

            document.addEventListener('turbo:load', scheduleInit);
            document.addEventListener('turbo:before-cache', function() {
                if ($.fn.DataTable.isDataTable('#example2')) {
                    $('#example2').DataTable().destroy();
                }
            });

            scheduleInit();
        })();
    </script>
@endsection
