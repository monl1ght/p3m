@extends('layout.doslayout')

@section('title', 'Hak Kekayaan Intelektual (HKI) - P3M Politeknik Balekambang')
@section('body_class', 'page-dosen-hki page-dosen-jurnal')

@section('css')
    <style>
        /* =========================================================================
               P3M DOSEN — HAK KEKAYAAN INTELEKTUAL (HKI)
               Harmonized System (100% Serasi & Identik dengan Upload Jurnal Penelitian)
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
        .page-dosen-hki .content-wrapper {
            min-height: calc(100vh - 66px);
            background:
                radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0, 93, 59, .05), transparent 70%),
                linear-gradient(180deg, #f2f8f5 0%, #f7faf8 100%) !important;
        }

        .page-dosen-hki .upp3m-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-hki .content-header {
            padding: 24px 0 14px !important;
        }

        .page-dosen-hki section.content {
            padding: 0 0 40px !important;
        }

        /* -------------------------------------------------------------------------
               BREADCRUMB
               ------------------------------------------------------------------------- */
        .page-dosen-hki .upp3m-breadcrumb {
            margin: 0;
            padding: 0;
            background: transparent;
            font-size: 12.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .page-dosen-hki .upp3m-breadcrumb .breadcrumb-item a {
            color: var(--p3m-up-forest);
            text-decoration: none;
            transition: opacity .18s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .page-dosen-hki .upp3m-breadcrumb .breadcrumb-item a:hover {
            opacity: .75;
        }

        .page-dosen-hki .upp3m-breadcrumb .breadcrumb-item.active {
            color: var(--p3m-up-muted);
        }

        .page-dosen-hki .upp3m-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            padding: 0 8px;
            color: var(--p3m-up-border-2);
        }

        /* -------------------------------------------------------------------------
               MAIN CARD
               ------------------------------------------------------------------------- */
        .page-dosen-hki .upp3m-card {
            background: var(--p3m-up-surface);
            border: 1px solid var(--p3m-up-border);
            border-radius: var(--p3m-up-r-2xl);
            box-shadow: 0 12px 36px rgba(3, 50, 33, .07), 0 2px 6px rgba(0, 0, 0, .02);
            overflow: hidden;
        }

        /* -------------------------------------------------------------------------
               CARD HEADER
               ------------------------------------------------------------------------- */
        .page-dosen-hki .upp3m-card-head {
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

        .page-dosen-hki .upp3m-title-group {
            min-width: 0;
        }

        .page-dosen-hki .upp3m-kicker {
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

        .page-dosen-hki .upp3m-kicker::before {
            content: "";
            width: 18px;
            height: 2.5px;
            border-radius: 99px;
            background: var(--p3m-up-gold);
        }

        .page-dosen-hki .upp3m-card-title {
            margin: 0 0 5px;
            color: var(--p3m-up-ink);
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 22px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .page-dosen-hki .upp3m-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .page-dosen-hki .upp3m-count-chip {
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

        .page-dosen-hki .upp3m-count-chip i {
            color: var(--p3m-up-forest-mid);
            font-size: 12px;
        }

        .page-dosen-hki .upp3m-add-btn {
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

        .page-dosen-hki .upp3m-add-btn:hover {
            background: linear-gradient(135deg, var(--p3m-up-forest-deep) 0%, var(--p3m-up-forest) 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 46, 34, .28);
            color: #ffffff !important;
        }

        .page-dosen-hki .upp3m-add-btn i {
            font-size: 11px;
            transition: transform .2s ease;
        }

        .page-dosen-hki .upp3m-add-btn:hover i {
            transform: rotate(90deg);
        }

        /* -------------------------------------------------------------------------
               TOOLBAR (Identik: Tampilkan [10] data + Dropdown Filter & Search)
               ------------------------------------------------------------------------- */
        .page-dosen-hki .upp3m-toolbar {
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

        .page-dosen-hki .upp3m-toolbar-left {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--p3m-up-muted);
            font-size: 13px;
            font-weight: 600;
            flex-wrap: wrap;
        }

        .page-dosen-hki .upp3m-toolbar-label {
            color: var(--p3m-up-ink-2);
            font-weight: 700;
        }

        .page-dosen-hki .upp3m-search-wrap {
            position: relative;
            width: 260px;
        }

        .page-dosen-hki .upp3m-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--p3m-up-light);
            font-size: 13px;
            pointer-events: none;
        }

        .page-dosen-hki .upp3m-search-input {
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

        .page-dosen-hki .upp3m-search-input::placeholder {
            color: var(--p3m-up-light);
        }

        .page-dosen-hki .upp3m-search-input:hover {
            border-color: #c7d8cf;
            background-color: var(--p3m-up-surface-hover);
        }

        .page-dosen-hki .upp3m-search-input:focus {
            border-color: var(--p3m-up-forest-mid);
            box-shadow: 0 0 0 3px rgba(0, 87, 59, .1);
            background-color: #ffffff;
        }

        /* -------------------------------------------------------------------------
               DATA TABLE
               ------------------------------------------------------------------------- */
        .page-dosen-hki .upp3m-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 61, 45, 0.18) transparent;
        }

        .page-dosen-hki .upp3m-table-wrap::-webkit-scrollbar {
            height: 5px;
        }

        .page-dosen-hki .upp3m-table-wrap::-webkit-scrollbar-track {
            background: transparent;
        }

        .page-dosen-hki .upp3m-table-wrap::-webkit-scrollbar-thumb {
            background: rgba(0, 61, 45, 0.18);
            border-radius: 99px;
        }

        .page-dosen-hki table.upp3m-table {
            width: 100% !important;
            margin: 0 !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        .page-dosen-hki table.upp3m-table thead th {
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

        .page-dosen-hki table.upp3m-table thead th:first-child {
            padding-left: var(--p3m-up-card-inline, 28px) !important;
            padding-right: 14px !important;
            text-align: left !important;
            vertical-align: middle !important;
            width: 60px;
        }

        .page-dosen-hki table.upp3m-table thead th:last-child {
            padding-right: var(--p3m-up-card-inline) !important;
        }

        .page-dosen-hki table.dataTable thead th:before,
        .page-dosen-hki table.dataTable thead th:after,
        .page-dosen-hki table.dataTable thead .sorting:before,
        .page-dosen-hki table.dataTable thead .sorting_asc:before,
        .page-dosen-hki table.dataTable thead .sorting_desc:before,
        .page-dosen-hki table.dataTable thead .sorting:after,
        .page-dosen-hki table.dataTable thead .sorting_asc:after,
        .page-dosen-hki table.dataTable thead .sorting_desc:after,
        .page-dosen-hki table.dataTable thead th.sorting_disabled:before,
        .page-dosen-hki table.dataTable thead th.sorting_disabled:after {
            display: none !important;
            content: "" !important;
        }

        .page-dosen-hki table.upp3m-table tbody td {
            padding: 16px 18px;
            vertical-align: middle;
            border-bottom: 1px solid var(--p3m-up-border);
            color: var(--p3m-up-text);
            font-size: 13px;
            transition: background .15s ease;
        }

        .page-dosen-hki table.upp3m-table tbody tr:last-child td {
            border-bottom: none;
        }

        .page-dosen-hki table.upp3m-table tbody tr:hover td {
            background: var(--p3m-up-surface-alt);
        }

        .page-dosen-hki table.upp3m-table tbody td:first-child {
            padding-left: var(--p3m-up-card-inline, 28px) !important;
            padding-right: 14px !important;
            text-align: left !important;
            vertical-align: middle !important;
            width: 60px;
        }

        .page-dosen-hki table.upp3m-table tbody td:last-child {
            padding-right: var(--p3m-up-card-inline);
        }

        /* Number Column */
        .page-dosen-hki .upp3m-row-num {
            display: table-cell !important;
            vertical-align: middle !important;
            text-align: left !important;
            color: var(--p3m-up-light);
            font-size: 12.5px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        /* Proposal / HKI Title Cell */
        .page-dosen-hki .upp3m-proposal-cell {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .page-dosen-hki .upp3m-proposal-icon {
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d0e4d7;
            border-radius: 9px;
            background: linear-gradient(145deg, #f7fbf8 0%, #edf6f1 100%);
            color: #00573b;
            font-size: 15px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.85);
        }

        .page-dosen-hki .upp3m-proposal-copy {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .page-dosen-hki .upp3m-proposal-title {
            color: #0f172a;
            font-size: 13px;
            line-height: 1.4;
            font-weight: 700;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-word;
            text-decoration: none !important;
            transition: color .15s ease;
        }

        .page-dosen-hki .upp3m-proposal-title:hover {
            color: #00573b;
        }

        .page-dosen-hki .upp3m-proposal-meta {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .page-dosen-hki .upp3m-proposal-id {
            display: inline-flex;
            align-items: center;
            height: 18px;
            padding: 0 5px;
            background: #eef7f2;
            border: 1px solid #cfe5d7;
            border-radius: 4px;
            color: #00573b;
            font-size: 9.5px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
            line-height: 1;
            letter-spacing: 0.2px;
        }

        .page-dosen-hki .upp3m-author-tag {
            display: inline-flex;
            align-items: center;
            gap: 3.5px;
            height: 18px;
            padding: 0 5px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            color: #334155;
            font-size: 9.5px;
            font-weight: 600;
            line-height: 1;
        }

        .page-dosen-hki .upp3m-author-tag i {
            color: #64748b;
            font-size: 9px;
        }

        .page-dosen-hki .upp3m-member-count {
            display: inline-flex;
            align-items: center;
            height: 18px;
            padding: 0 5px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            color: #64748b;
            font-size: 9.5px;
            font-weight: 600;
            line-height: 1;
        }

        /* Jenis & Tanggal */
        .page-dosen-hki .upp3m-jenis-col {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }

        .page-dosen-hki .upp3m-field-chip {
            display: inline-flex;
            align-items: center;
            gap: 4.5px;
            height: 20px;
            padding: 0 8px;
            border: 1px solid #d3e5db;
            border-radius: 99px;
            background: #f7fbf9;
            color: #00573b;
            font-size: 10.5px;
            font-weight: 600;
            line-height: 1;
            white-space: nowrap;
        }

        .page-dosen-hki .upp3m-field-chip i {
            color: #00573b;
            font-size: 9.5px;
        }

        .page-dosen-hki .upp3m-date-meta {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #64748b;
            font-size: 10px;
            font-weight: 500;
            line-height: 1;
            padding-left: 2px;
        }

        .page-dosen-hki .upp3m-date-meta i {
            color: #94a3b8;
            font-size: 9.5px;
        }

        /* No. Pencatatan Monospace Badge */
        .page-dosen-hki .upp3m-no-pencatatan {
            font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, monospace;
            font-size: 12px;
            font-weight: 700;
            color: var(--p3m-up-forest-mid);
            background: var(--p3m-up-forest-soft);
            padding: 3px 8px;
            border-radius: 6px;
            letter-spacing: .02em;
            display: inline-block;
            white-space: nowrap;
        }

        /* File Download Link Pill */
        .page-dosen-hki .upp3m-file-pill {
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

        .page-dosen-hki .upp3m-file-pill i {
            color: #dc2626;
            font-size: 12.5px;
            flex-shrink: 0;
        }

        .page-dosen-hki .upp3m-file-pill span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .page-dosen-hki .upp3m-file-pill:hover {
            background: var(--p3m-up-surface-hover);
            border-color: #c7d8cf;
            color: var(--p3m-up-forest);
        }

        /* Action Buttons */
        .page-dosen-hki .upp3m-action-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .page-dosen-hki .upp3m-action-btn {
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
            outline: none !important;
        }

        .page-dosen-hki .upp3m-action-detail {
            background: #f0f9ff;
            color: #0284c7;
            border-color: #bae6fd;
        }

        .page-dosen-hki .upp3m-action-detail:hover {
            background: #0284c7;
            color: #ffffff !important;
            border-color: #0284c7;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, .22);
        }

        .page-dosen-hki .upp3m-action-download {
            background: #f0fdfa;
            color: #0d9488;
            border-color: #99f6e4;
        }

        .page-dosen-hki .upp3m-action-download:hover {
            background: #0d9488;
            color: #ffffff !important;
            border-color: #0d9488;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, .22);
        }

        .page-dosen-hki .upp3m-action-edit {
            background: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }

        .page-dosen-hki .upp3m-action-edit:hover {
            background: #16a34a;
            color: #ffffff !important;
            border-color: #16a34a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(22, 163, 74, .22);
        }

        .page-dosen-hki .upp3m-action-delete {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .page-dosen-hki .upp3m-action-delete:hover {
            background: #dc2626;
            color: #ffffff !important;
            border-color: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, .22);
        }

        /* Empty State */
        .page-dosen-hki .upp3m-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 42px 20px;
            text-align: center;
        }

        .page-dosen-hki .upp3m-empty-icon {
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

        .page-dosen-hki .upp3m-empty-title {
            color: var(--p3m-up-ink-2);
            font-size: 13.5px;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .page-dosen-hki .upp3m-empty-text {
            color: var(--p3m-up-muted);
            font-size: 12px;
            max-width: 380px;
            line-height: 1.5;
        }

        /* -------------------------------------------------------------------------
               FOOTER & PAGINATION (100% Identik tanpa bullet dot)
               ------------------------------------------------------------------------- */
        .page-dosen-hki .upp3m-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            padding: 14px var(--p3m-up-card-inline);
            background: var(--p3m-up-surface-alt);
            border-top: 1px solid var(--p3m-up-border);
        }

        .page-dosen-hki .upp3m-info {
            color: var(--p3m-up-muted);
            font-size: 12.5px;
            font-weight: 600;
        }

        .page-dosen-hki .upp3m-pagination {
            display: flex;
            align-items: center;
            gap: 4px;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }

        .page-dosen-hki .upp3m-pagination li {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .page-dosen-hki .upp3m-pagination li::before {
            display: none !important;
            content: "" !important;
        }

        .page-dosen-hki .upp3m-pagination .page-item .page-link {
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

        .page-dosen-hki .upp3m-pagination .page-item.active .page-link {
            background: var(--p3m-up-forest);
            border-color: var(--p3m-up-forest);
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 61, 45, .22);
        }

        .page-dosen-hki .upp3m-pagination .page-item:not(.active) .page-link:hover {
            background: var(--p3m-up-surface-hover);
            border-color: var(--p3m-up-border-2);
            color: var(--p3m-up-ink);
        }

        .page-dosen-hki .upp3m-pagination .page-item.disabled .page-link {
            opacity: .45;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Hide native DataTables controls */
        #hkiTable_wrapper .dataTables_length,
        #hkiTable_wrapper .dataTables_filter,
        #hkiTable_wrapper .dataTables_info,
        #hkiTable_wrapper .dataTables_paginate {
            display: none !important;
        }


        /* -------------------------------------------------------------------------
               DESKTOP & RESPONSIVE BEHAVIOR
               ------------------------------------------------------------------------- */
        @media (min-width: 992px) {
            .page-dosen-hki .upp3m-table-wrap {
                overflow-x: visible;
            }
        }

        @media (max-width: 991.98px) {
            .page-dosen-hki table.upp3m-table {
                min-width: 860px;
            }
        }

        @media (max-width: 767.98px) {
            :root {
                --p3m-up-card-inline: 18px;
            }

            .page-dosen-hki .upp3m-shell {
                width: calc(100% - 28px);
            }

            .page-dosen-hki .content-header {
                padding: 18px 0 10px !important;
            }

            .page-dosen-hki .upp3m-card-head {
                padding: 20px var(--p3m-up-card-inline) 16px;
            }

            .page-dosen-hki .upp3m-card-title {
                font-size: 19px;
            }

            .page-dosen-hki .upp3m-header-actions {
                width: 100%;
            }

            .page-dosen-hki .upp3m-count-chip,
            .page-dosen-hki .upp3m-add-btn {
                flex: 1;
                justify-content: center;
            }

            .page-dosen-hki .upp3m-toolbar {
                flex-direction: column;
                align-items: stretch;
                padding: 12px var(--p3m-up-card-inline);
            }

            .page-dosen-hki .upp3m-toolbar-left {
                width: 100%;
                justify-content: flex-start;
            }

            .page-dosen-hki .upp3m-search-wrap {
                width: 100%;
            }

            .page-dosen-hki .upp3m-footer {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 12px var(--p3m-up-card-inline);
            }
        }

        @media (max-width: 575.98px) {
            .page-dosen-hki .upp3m-shell {
                width: calc(100% - 18px);
            }

            .page-dosen-hki .upp3m-header-actions {
                flex-direction: column;
            }

            .page-dosen-hki .upp3m-count-chip,
            .page-dosen-hki .upp3m-add-btn {
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
                        Hak Kekayaan Intelektual
                    </li>
                </ol>
            </div>
        </div>

        {{-- MAIN CARD (Tanpa KPI stats cards di atasnya, sesuai foto ke-2) --}}
        <section class="content">
            <div class="upp3m-shell">

                <div class="upp3m-card">

                    {{-- CARD HEADER --}}
                    <div class="upp3m-card-head">
                        <div class="upp3m-title-group">
                            <span class="upp3m-kicker">
                                Panel Dosen — Luaran & HKI
                            </span>
                            <h1 class="upp3m-card-title">
                                Hak Kekayaan Intelektual (HKI)
                            </h1>
                        </div>

                        <div class="upp3m-header-actions">
                            <div class="upp3m-count-chip" id="hkiCountChip">
                                <i class="fas fa-award"></i>
                                <span>Total <strong>{{ $uploads->count() }}</strong> HKI</span>
                            </div>

                            <a href="{{ route('dosen.hki.create') }}" class="upp3m-add-btn" id="btnAddHki">
                                <i class="fas fa-plus"></i>
                                <span>Tambah HKI Baru</span>
                            </a>
                        </div>
                    </div>

                    {{-- TOOLBAR (Tampilkan [10] data + Dropdown Filter Jenis HKI + Search) --}}
                    <div class="upp3m-toolbar">
                        <div class="upp3m-toolbar-left">
                            <span class="upp3m-toolbar-label">
                                Tampilkan
                            </span>
                            <x-p3m-dropdown id="hkiPageLength" value="10" :compact="true" :options="[
                                ['value' => '10', 'label' => '10'],
                                ['value' => '25', 'label' => '25'],
                                ['value' => '50', 'label' => '50'],
                                ['value' => '100', 'label' => '100'],
                            ]" />
                            <span>
                                data
                            </span>

                            <x-p3m-dropdown id="hkiFilterJenis" value="" class="ml-1" :options="[
                                [
                                    'value' => '',
                                    'label' => 'Semua Jenis HKI',
                                    'icon' => 'fas fa-layer-group p3m-dropdown-icon',
                                    'divider' => true,
                                ],
                                ['value' => 'Hak Cipta', 'label' => 'Hak Cipta', 'dot' => 'dot-primary'],
                                ['value' => 'Paten', 'label' => 'Paten', 'dot' => 'dot-purple'],
                                ['value' => 'Paten Sederhana', 'label' => 'Paten Sederhana', 'dot' => 'dot-purple'],
                                ['value' => 'Merek', 'label' => 'Merek', 'dot' => 'dot-warning'],
                                ['value' => 'Desain Industri', 'label' => 'Desain Industri', 'dot' => 'dot-success'],
                                ['value' => 'Lainnya', 'label' => 'Lainnya', 'dot' => 'dot-primary'],
                            ]" />
                        </div>

                        <div class="upp3m-search-wrap">
                            <i class="fas fa-search upp3m-search-icon"></i>
                            <input type="text" class="upp3m-search-input" id="hkiSearch"
                                placeholder="Cari judul, nomor, anggota..." aria-label="Cari data HKI">
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="upp3m-table-wrap">
                        <table id="hkiTable" class="table upp3m-table">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">
                                        No
                                    </th>
                                    <th style="width: 35%;">
                                        Judul &amp; Pencipta
                                    </th>
                                    <th style="width: 18%;">
                                        Jenis &amp; Tanggal
                                    </th>
                                    <th style="width: 17%;">
                                        No. Pencatatan
                                    </th>
                                    <th style="width: 15%;">
                                        Sertifikat HKI
                                    </th>
                                    <th style="width: 10%;" class="text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($uploads as $item)
                                    @php
                                        $ketua = $item->anggotas->first();
                                        $totalAnggota = $item->anggotas->count();
                                        $searchMeta = strtolower(
                                            $item->judul .
                                                ' ' .
                                                ($item->nomor_pencatatan ?? '') .
                                                ' ' .
                                                ($item->jenis_hki ?? '') .
                                                ' ' .
                                                $item->anggotas->pluck('nama')->implode(' '),
                                        );
                                    @endphp
                                    <tr data-jenis="{{ strtolower($item->jenis_hki ?? '') }}">
                                        {{-- 1. No --}}
                                        <td class="upp3m-row-num">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- 2. Judul & Pencipta --}}
                                        <td>
                                            <div class="upp3m-proposal-cell">
                                                <span class="upp3m-proposal-icon" aria-hidden="true"
                                                    title="{{ $item->jenis_hki ?? 'HKI' }}">
                                                    <i class="fas fa-award"></i>
                                                </span>
                                                <div class="upp3m-proposal-copy">
                                                    <a href="{{ route('dosen.hki.show', $item->id) }}"
                                                        class="upp3m-proposal-title" title="{{ $item->judul }}">
                                                        {{ $item->judul }}
                                                    </a>
                                                    <div class="upp3m-proposal-meta">
                                                        <span class="upp3m-proposal-id">
                                                            #HKI-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                                        </span>
                                                        @if ($ketua)
                                                            <span class="upp3m-author-tag"
                                                                title="Pencipta Utama: {{ $ketua->nama }}">
                                                                <i class="far fa-user"></i>
                                                                <span>{{ $ketua->nama }}</span>
                                                            </span>
                                                        @endif
                                                        @if ($totalAnggota > 1)
                                                            <span class="upp3m-member-count"
                                                                title="{{ $item->anggotas->pluck('nama')->implode(', ') }}">
                                                                +{{ $totalAnggota - 1 }} anggota
                                                            </span>
                                                        @endif
                                                    </div>
                                                    {{-- Hidden text for DataTables search across authors and notes --}}
                                                    <span class="d-none">{{ $searchMeta }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- 3. Jenis & Tanggal --}}
                                        <td>
                                            <div class="upp3m-jenis-col">
                                                @if ($item->jenis_hki)
                                                    <span class="upp3m-field-chip" title="Jenis: {{ $item->jenis_hki }}">
                                                        <i class="far fa-bookmark"></i>
                                                        <span>{{ $item->jenis_hki }}</span>
                                                    </span>
                                                @else
                                                    <span class="text-muted" style="font-size: 12px;">-</span>
                                                @endif

                                                <div class="upp3m-date-meta">
                                                    <i class="far fa-calendar-alt"></i>
                                                    <span>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') : '-' }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- 4. No. Pencatatan --}}
                                        <td>
                                            @if ($item->nomor_pencatatan)
                                                <span class="upp3m-no-pencatatan" title="Nomor Pencatatan Kemenkumham">
                                                    {{ $item->nomor_pencatatan }}
                                                </span>
                                            @else
                                                <span class="text-muted" style="font-size: 12px; font-style: italic;">
                                                    Belum terbit
                                                </span>
                                            @endif
                                        </td>

                                        {{-- 5. Sertifikat HKI --}}
                                        <td>
                                            @if ($item->file_name)
                                                <a href="{{ route('dosen.hki.download', $item->id) }}"
                                                    class="upp3m-file-pill" title="Unduh Berkas: {{ $item->file_name }}">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <span>Unduh Sertifikat</span>
                                                </a>
                                            @else
                                                <span class="text-muted" style="font-size: 12px;">-</span>
                                            @endif
                                        </td>

                                        {{-- 6. Aksi (Full CRUD Dosen Workspace) --}}
                                        <td class="text-center">
                                            <div class="upp3m-action-wrap">
                                                {{-- Detail HKI --}}
                                                <a href="{{ route('dosen.hki.show', $item->id) }}"
                                                    class="upp3m-action-btn upp3m-action-detail"
                                                    title="Lihat Detail HKI"
                                                    aria-label="Lihat Detail HKI">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                {{-- Edit HKI --}}
                                                <a href="{{ route('dosen.hki.edit', $item->id) }}"
                                                    class="upp3m-action-btn upp3m-action-edit" title="Edit HKI"
                                                    aria-label="Edit HKI">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                {{-- Hapus HKI --}}
                                                <button type="button"
                                                    class="upp3m-action-btn upp3m-action-delete js-delete-hki"
                                                    data-url="{{ route('dosen.hki.delete', $item->id) }}"
                                                    data-title="{{ $item->judul }}" title="Hapus HKI"
                                                    aria-label="Hapus HKI">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- FOOTER --}}
                    <div class="upp3m-footer">
                        <span class="upp3m-info" id="hkiTableInfo">
                            Menampilkan 0–0 dari 0 data
                        </span>

                        <div id="hkiTablePagination"></div>
                    </div>

                </div>

            </div>
        </section>

    </div>


    {{-- HIDDEN GLOBAL DELETE FORM --}}
    <form id="globalDeleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('scripts')
    <script>
        (function() {
            let table = null;

            function initHkiTable() {
                const $tableElement = $('#hkiTable');
                if (!$tableElement.length) return;

                if ($.fn.DataTable.isDataTable('#hkiTable')) {
                    $('#hkiTable').DataTable().destroy();
                }

                // Register custom Jenis HKI search extension
                $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(fn => fn._hkiFilter !== true);
                const hkiCustomFilter = function(settings, data, dataIndex) {
                    if (settings.nTable.id !== 'hkiTable') return true;
                    const filterVal = ($('#hkiFilterJenis').val() || '').trim().toLowerCase();
                    if (!filterVal) return true;

                    const $row = $(settings.aoData[dataIndex].nTr);
                    const rowJenis = ($row.attr('data-jenis') || '').toLowerCase();

                    if (filterVal === 'lainnya') {
                        const standard = ['hak cipta', 'paten', 'paten sederhana', 'merek', 'desain industri'];
                        return !standard.includes(rowJenis);
                    }
                    return rowJenis.includes(filterVal);
                };
                hkiCustomFilter._hkiFilter = true;
                $.fn.dataTable.ext.search.push(hkiCustomFilter);

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
                        searchPlaceholder: "Cari judul, nomor, anggota...",
                        emptyTable: `
                            <div class="upp3m-empty-state">
                                <span class="upp3m-empty-icon"><i class="fas fa-award"></i></span>
                                <span class="upp3m-empty-title">Belum Ada Data HKI Terdaftar</span>
                                <span class="upp3m-empty-text">Data pendaftaran Hak Kekayaan Intelektual Anda akan tampil rapi pada tabel ini.</span>
                            </div>
                        `,
                        zeroRecords: `
                            <div class="upp3m-empty-state">
                                <span class="upp3m-empty-icon"><i class="fas fa-search"></i></span>
                                <span class="upp3m-empty-title">Tidak ada hasil pencarian</span>
                                <span class="upp3m-empty-text">Coba ubah kata kunci pencarian atau filter agar data HKI yang dicari dapat ditemukan.</span>
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

                        $('#hkiTableInfo').text(
                            'Menampilkan ' + from + '–' + to + ' dari ' + info.recordsDisplay + ' data'
                        );
                        $('#hkiCountChip strong').text(info.recordsDisplay);

                        // Rebuild Custom Pagination (100% Identik dengan Upload Jurnal)
                        const $nativePagination = $(this.api().table().container()).find(
                            '.dataTables_paginate');
                        const $pagination = $('<ul class="upp3m-pagination pagination"></ul>');

                        $nativePagination.find('li').each(function(index) {
                            const $item = $(this).clone(true);
                            const $link = $item.find('a, span').first();
                            const $source = $nativePagination.find('li').eq(index);

                            $link.off('click.customPagination').on('click.customPagination',
                                function(e) {
                                    e.preventDefault();
                                    $source.find('a, span').first().trigger('click');
                                });

                            $pagination.append($item);
                        });

                        $('#hkiTablePagination').empty().append($pagination);
                    }
                });

                // Custom search input
                $('#hkiSearch').off('input').on('input', function() {
                    table.search(this.value).draw();
                });

                // Page length select
                $('#hkiPageLength').off('change').on('change', function() {
                    table.page.len(Number(this.value)).draw();
                });

                // Filter Jenis HKI
                $('#hkiFilterJenis').off('change').on('change', function() {
                    table.draw();
                });

                table.draw();
            }


            // SweetAlert2 / p3mConfirm Delete Confirmation
            $(document).off('click', '.js-delete-hki').on('click', '.js-delete-hki', function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                const title = $(this).data('title');
                if (!url) return;

                const desc = title 
                    ? 'Data HKI "' + title + '" akan dihapus permanen dan tidak dapat dibatalkan.' 
                    : 'Data HKI ini akan dihapus permanen dan tidak dapat dibatalkan.';

                if (typeof window.p3mConfirm === 'function') {
                    window.p3mConfirm({
                        title: 'Hapus Data HKI?',
                        html: desc,
                        icon: 'warning',
                        confirmText: '<i class="fas fa-trash-alt" style="font-size:12px;"></i>&nbsp; Ya, Hapus',
                        confirmClass: 'p3m-swal-btn-danger',
                        onConfirm: function() {
                            const form = document.getElementById('globalDeleteForm');
                            if (form) {
                                form.action = url;
                                form.submit();
                            }
                        }
                    });
                } else if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Hapus Data HKI?',
                        html: desc,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Ya, Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.getElementById('globalDeleteForm');
                            if (form) {
                                form.action = url;
                                form.submit();
                            }
                        }
                    });
                } else {
                    if (confirm('Apakah Anda yakin ingin menghapus data HKI: ' + title + '?')) {
                        const form = document.getElementById('globalDeleteForm');
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
                initTimer = setTimeout(initHkiTable, 20);
            }

            document.addEventListener('turbo:load', scheduleInit);
            document.addEventListener('turbo:before-cache', function() {
                if (table && $.fn.DataTable.isDataTable('#hkiTable')) {
                    $('#hkiTable').DataTable().destroy();
                }
            });

            scheduleInit();
        })();
    </script>
@endsection
