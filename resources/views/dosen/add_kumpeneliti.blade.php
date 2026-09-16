@extends('layout.doslayout')

@section('body_class', 'page-dosen-add-kpenelitian')

@section('css')

    <style>
        /* =========================================================================
                               P3M DOSEN — TAMBAH LAPORAN PENELITIAN
                               Visual master: Admin P3M / Dosen workspace.
                               Backend contract preserved from the original Blade:
                               route, CSRF, field names, member array structure and dynamic rows.
                               ========================================================================= */

        :root {
            --research-report-forest: #003d2d;
            --research-report-forest-deep: #002e22;
            --research-report-forest-mid: #00573b;
            --research-report-forest-soft: #eaf5ee;

            --research-report-gold: #b99835;

            --research-report-ink: #0d1f1a;
            --research-report-ink-2: #1e3328;
            --research-report-text: #3b4f47;
            --research-report-muted: #6b7f78;
            --research-report-light: #9caaa4;

            --research-report-border: #e4ede8;
            --research-report-border-2: #d3e0d9;

            --research-report-surface: #ffffff;
            --research-report-surface-alt: #f7faf8;

            --research-report-danger: #d94b4b;
            --research-report-danger-soft: #fef2f2;
            --research-report-danger-border: #f5c0c0;

            --research-report-radius-sm: 8px;
            --research-report-radius-md: 12px;
            --research-report-radius-lg: 16px;
            --research-report-radius-2xl: 24px;
        }

        /* -------------------------------------------------------------------------
                               PAGE
                               ------------------------------------------------------------------------- */

        .page-dosen-add-kpenelitian .content-wrapper {
            min-height: calc(100vh - 66px);

            background:
                radial-gradient(ellipse 70% 40% at 100% 0%,
                    rgba(0, 93, 59, .06),
                    transparent),
                linear-gradient(180deg,
                    #f2f8f5 0%,
                    #f7faf8 100%) !important;
        }

        .research-report-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-add-kpenelitian .content-header {
            padding: 26px 0 10px !important;
        }

        .page-dosen-add-kpenelitian section.content {
            padding: 6px 0 36px !important;
        }

        /* -------------------------------------------------------------------------
                               HEADING
                               ------------------------------------------------------------------------- */

        .research-report-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .research-report-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 9px;

            color: var(--research-report-forest-mid);

            font-size: 10.5px;
            font-weight: 800;

            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .research-report-eyebrow::before {
            content: "";

            width: 20px;
            height: 2.5px;

            border-radius: 99px;

            background: var(--research-report-gold);
        }

        .research-report-heading h1 {
            margin: 0;

            color: var(--research-report-ink);

            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: clamp(28px, 3vw, 36px);
            line-height: 1.12;
            font-weight: 800;

            letter-spacing: -.045em;
        }

        .research-report-heading p {
            margin: 7px 0 0;

            color: var(--research-report-muted);

            font-size: 12.5px;
            line-height: 1.55;
        }

        .research-report-breadcrumb {
            margin: 0;
            padding: 0;

            background: transparent;

            font-size: 12px;
            font-weight: 600;

            white-space: nowrap;
        }

        .research-report-breadcrumb a {
            color: var(--research-report-forest);
            text-decoration: none;
        }

        .research-report-breadcrumb .active {
            color: var(--research-report-muted);
        }

        .research-report-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "/";

            padding: 0 8px;

            color: var(--research-report-border-2);
        }

        /* -------------------------------------------------------------------------
                               CARD
                               ------------------------------------------------------------------------- */

        .research-report-card {
            overflow: hidden;

            border: 1px solid var(--research-report-border);
            border-radius: var(--research-report-radius-2xl);

            background: var(--research-report-surface);

            box-shadow:
                0 20px 56px rgba(3, 50, 33, .12),
                0 4px 12px rgba(0, 0, 0, .06);
        }

        .research-report-card-head {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            padding: 24px 30px;

            overflow: hidden;

            background:
                linear-gradient(112deg,
                    #ffffff 55%,
                    #f0faf5 100%);

            border-bottom: 1px solid var(--research-report-border);
        }

        .research-report-card-head::after {
            content: "";

            position: absolute;

            top: -55px;
            right: -55px;

            width: 220px;
            height: 220px;

            border-radius: 50%;

            background:
                radial-gradient(circle,
                    rgba(0, 93, 59, .055),
                    transparent 70%);

            pointer-events: none;
        }

        .research-report-title-group {
            position: relative;
            z-index: 1;
        }

        .research-report-card-title {
            margin: 0;

            color: var(--research-report-ink);

            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 18px;
            line-height: 1.25;
            font-weight: 800;

            letter-spacing: -.025em;
        }

        .research-report-card-subtitle {
            margin: 5px 0 0;

            color: var(--research-report-muted);

            font-size: 11.5px;
            line-height: 1.45;
        }

        .research-report-secure {
            position: relative;
            z-index: 1;

            display: inline-flex;
            align-items: center;

            gap: 7px;

            padding: 8px 12px;

            border: 1px solid var(--research-report-border);
            border-radius: var(--research-report-radius-md);

            background: rgba(255, 255, 255, .78);

            color: var(--research-report-forest-mid);

            font-size: 10px;
            font-weight: 800;

            white-space: nowrap;
        }

        .research-report-card-body {
            padding: 28px 30px 8px;
        }

        /* -------------------------------------------------------------------------
                               SECTION
                               ------------------------------------------------------------------------- */

        .research-report-section {
            margin-bottom: 28px;
        }

        .research-report-section-head {
            display: flex;
            align-items: center;

            gap: 11px;

            margin-bottom: 18px;
        }

        .research-report-section-head .research-report-section-number {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #eef6f1;
            color: var(--research-report-forest);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .research-report-section-head strong {
            display: block;

            color: var(--research-report-ink-2);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            line-height: 1.2;
            font-weight: 800;
        }

        .research-report-section-head span {
            display: block;

            margin-top: 3px;

            color: var(--research-report-muted);

            font-size: 10px;
            line-height: 1.35;
        }

        /* -------------------------------------------------------------------------
                               FORM GRID
                               ------------------------------------------------------------------------- */

        .research-report-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr) minmax(0, 1fr);

            gap: 30px;
        }

        .research-report-column {
            min-width: 0;

            padding: 0 2px;
        }

        .research-report-column+.research-report-column {
            padding-left: 28px;

            border-left: 1px solid #eaf0ed;
        }

        .research-report-field {
            margin-bottom: 18px;
        }

        .research-report-field:last-child {
            margin-bottom: 0;
        }

        .research-report-label {
            display: block;

            margin-bottom: 7px;

            color: var(--research-report-ink-2);

            font-size: 11px;
            line-height: 1.3;
            font-weight: 800;
        }

        .research-report-label .req {
            margin-left: 2px;

            color: var(--research-report-danger);
        }

        .research-report-input,
        .research-report-select {
            width: 100%;

            min-height: 42px;

            padding: 9px 12px;

            border: 1px solid var(--research-report-border-2);
            border-radius: var(--research-report-radius-md);

            outline: none;

            background: #fff;
            color: var(--research-report-ink);

            font-family: inherit;
            font-size: 12px;
            font-weight: 500;

            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .research-report-input::placeholder {
            color: var(--research-report-light);
        }

        .research-report-input:hover,
        .research-report-select:hover {
            border-color: #c5d6cd;
        }

        .research-report-input:focus,
        .research-report-select:focus {
            border-color: var(--research-report-forest-mid);

            box-shadow:
                0 0 0 3px rgba(0, 87, 59, .09);
        }

        .research-report-input[readonly] {
            background: #f4f7f6;
            color: #667a72;
            cursor: default;
        }

        .research-report-help {
            display: block;

            margin-top: 6px;

            color: var(--research-report-light);

            font-size: 9.5px;
            line-height: 1.4;
        }

        .research-report-error {
            display: flex;
            align-items: flex-start;

            gap: 6px;

            margin-top: 6px;

            color: var(--research-report-danger);

            font-size: 10px;
            line-height: 1.4;
        }

        .research-report-error i {
            margin-top: 1px;

            font-size: 9px;
        }

        /* -------------------------------------------------------------------------
                               DATE RANGE
                               ------------------------------------------------------------------------- */

        .research-report-date-group {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr) auto minmax(0, 1fr);

            gap: 8px;

            align-items: center;
        }

        .research-report-date-separator {
            color: var(--research-report-muted);

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;
        }

        /* -------------------------------------------------------------------------
                               UPLOAD
                               ------------------------------------------------------------------------- */

        .research-report-file-input {
            position: absolute;

            width: 1px;
            height: 1px;

            overflow: hidden;

            opacity: 0;
            pointer-events: none;
        }

        .research-report-file-label {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            min-height: 46px;

            padding: 8px 10px 8px 12px;

            border: 1px dashed #bfd4c8;
            border-radius: var(--research-report-radius-md);

            background: #f8fbf9;

            cursor: pointer;

            transition:
                border-color .18s ease,
                background .18s ease,
                transform .18s ease;
        }

        .research-report-file-label:hover {
            border-color: #9fbead;
            background: #f0f7f3;

            transform: translateY(-1px);
        }

        .research-report-file-copy {
            display: flex;
            align-items: center;

            gap: 9px;

            min-width: 0;
        }

        .research-report-file-icon {
            width: 30px;
            height: 30px;
            flex: 0 0 30px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: var(--research-report-forest-soft);
            color: var(--research-report-forest-mid);

            font-size: 12px;
        }

        .research-report-file-name {
            min-width: 0;
            overflow: hidden;

            color: var(--research-report-text);

            font-size: 10.5px;
            font-weight: 700;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .research-report-file-browse {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 7px 10px;

            border: 1px solid var(--research-report-border-2);
            border-radius: 9px;

            background: #fff;
            color: var(--research-report-forest);

            font-size: 9.5px;
            font-weight: 800;

            white-space: nowrap;
        }

        /* -------------------------------------------------------------------------
                               MEMBERS
                               ------------------------------------------------------------------------- */

        .research-report-team {
            padding-top: 23px;

            border-top: 1px solid #eaf0ed;
        }

        .research-report-team-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            margin-bottom: 14px;
        }

        .research-report-team-title {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .research-report-team-title .research-report-team-icon {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #eef6f1;
            color: var(--research-report-forest);
            font-size: 12px;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .research-report-team-title strong {
            color: var(--research-report-ink-2);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .research-report-team-title span {
            display: block;

            margin-top: 2px;

            color: var(--research-report-muted);

            font-size: 9.5px;
        }

        .research-report-add-member {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            min-height: 34px;

            padding: 0 11px;

            border: 1px solid #c7ddd0;
            border-radius: 9px;

            background: #fff;
            color: var(--research-report-forest);

            font-size: 10px;
            font-weight: 800;

            cursor: pointer;

            transition: .18s ease;
        }

        .research-report-add-member:hover {
            background: var(--research-report-forest-soft);
            border-color: #aec9bb;

            transform: translateY(-1px);
        }

        .research-report-member-list {
            display: flex;
            flex-direction: column;

            gap: 10px;
        }

        .research-report-member-card {
            padding: 15px 16px;

            border: 1px solid var(--research-report-border);
            border-radius: 14px;

            background: #fbfdfc;
        }

        .research-report-member-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-bottom: 13px;
        }

        .research-report-member-label {
            display: flex;
            align-items: center;

            gap: 8px;

            color: var(--research-report-ink-2);

            font-size: 11px;
            font-weight: 800;
        }

        .research-report-member-label .research-report-member-index {
            width: 23px;
            height: 23px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            background: #eaf5ee;
            color: var(--research-report-forest);
            font-size: 9px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .research-report-remove {
            width: 28px;
            height: 28px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--research-report-danger-border);
            border-radius: 8px;

            background: var(--research-report-danger-soft);
            color: var(--research-report-danger);

            font-size: 10px;

            cursor: pointer;

            transition: .18s ease;
        }

        .research-report-remove:hover {
            background: #fdeaea;
            transform: translateY(-1px);
        }

        .research-report-member-grid {
            display: grid;

            grid-template-columns:
                1.15fr 1fr .85fr .95fr;

            gap: 12px;
        }

        /* -------------------------------------------------------------------------
                               FOOTER
                               ------------------------------------------------------------------------- */

        .research-report-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 18px;

            padding: 17px 30px;

            border-top: 1px solid var(--research-report-border);

            background: var(--research-report-surface-alt);
        }

        .research-report-footer-note {
            display: inline-flex;
            align-items: center;

            gap: 8px;

            color: var(--research-report-muted);

            font-size: 10px;
            line-height: 1.4;
        }

        .research-report-footer-note i {
            color: var(--research-report-forest-mid);
        }

        .research-report-submit {
            min-height: 41px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 0 17px;

            border: 1px solid var(--research-report-forest);
            border-radius: var(--research-report-radius-md);

            background: var(--research-report-forest);
            color: #fff;

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;

            cursor: pointer;

            box-shadow: 0 6px 16px rgba(0, 61, 45, .18);

            transition: .18s ease;
        }

        .research-report-submit:hover {
            background: var(--research-report-forest-deep);
            border-color: var(--research-report-forest-deep);

            transform: translateY(-1px);

            box-shadow: 0 9px 20px rgba(0, 61, 45, .23);
        }

        /* -------------------------------------------------------------------------
                               RESPONSIVE
                               ------------------------------------------------------------------------- */

        @media (max-width: 991.98px) {

            .research-report-shell {
                width: calc(100% - 34px);
            }

            .research-report-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            .research-report-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .research-report-column+.research-report-column {
                padding-left: 0;
                padding-top: 24px;

                border-left: 0;
                border-top: 1px solid #eaf0ed;
            }

            .research-report-member-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {

            .research-report-shell {
                width: calc(100% - 24px);
            }

            .research-report-card {
                border-radius: var(--research-report-radius-lg);
            }

            .research-report-card-head {
                align-items: flex-start;
                flex-direction: column;

                padding: 20px 19px 17px;
            }

            .research-report-card-body {
                padding: 22px 19px 7px;
            }

            .research-report-footer {
                align-items: stretch;
                flex-direction: column;

                padding: 15px 19px 18px;
            }

            .research-report-submit {
                width: 100%;
            }

            .research-report-team-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .research-report-add-member {
                width: 100%;
                justify-content: center;
            }

            .research-report-file-label {
                align-items: flex-start;
                flex-direction: column;
            }

            .research-report-file-browse {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 575.98px) {

            .research-report-shell {
                width: calc(100% - 18px);
            }

            .research-report-heading h1 {
                font-size: 28px;
            }

            .research-report-date-group {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .research-report-date-separator {
                text-align: center;
            }

            .research-report-member-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .page-dosen-add-kpenelitian *,
            .page-dosen-add-kpenelitian *::before,
            .page-dosen-add-kpenelitian *::after {
                transition: none !important;
            }
        }

        /* FILE VALIDATION MODAL — Reuses the existing P3M modal visual language. */
        .research-report-file-modal .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 28px 70px rgba(0, 30, 20, .18);
            overflow: hidden;
        }

        .research-report-file-modal .modal-header {
            padding: 24px 26px 20px;
            background: #fff;
            border-bottom: 1px solid var(--research-report-border);
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .research-report-file-modal .modal-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--research-report-danger-soft);
            color: var(--research-report-danger);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .research-report-file-modal .modal-head-text {
            flex: 1;
            min-width: 0;
        }

        .research-report-file-modal .modal-head-text h5 {
            margin: 0 0 4px;
            color: var(--research-report-ink);
            font-size: 17px;
            line-height: 1.3;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .research-report-file-modal .modal-head-text p {
            margin: 0;
            color: var(--research-report-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .research-report-file-modal .modal-close-btn {
            margin-left: auto;
            padding: 0;
            border: 0;
            background: none;
            color: var(--research-report-light);
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
        }

        .research-report-file-modal .modal-close-btn:hover {
            color: var(--research-report-ink);
        }

        .research-report-file-modal .modal-body {
            padding: 22px 26px;
            background: #fff;
        }

        .research-report-file-modal .modal-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 0;
            padding: 13px 14px;
            border: 1px solid var(--research-report-danger-border);
            border-radius: 12px;
            background: var(--research-report-danger-soft);
            color: var(--research-report-danger);
            font-size: 12.5px;
            line-height: 1.55;
            font-weight: 600;
        }

        .research-report-file-modal .modal-alert i {
            margin-top: 2px;
            flex: 0 0 auto;
        }

        .research-report-file-modal .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 16px 26px;
            gap: 10px;
            border-top: 1px solid var(--research-report-border);
            background: var(--research-report-surface-alt);
        }

        .research-report-file-modal .btn-modal-close {
            min-height: 38px;
            padding: 0 15px;
            border: 1px solid var(--research-report-forest);
            border-radius: 9px;
            background: var(--research-report-forest);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
        }

        .research-report-file-modal .btn-modal-close:hover {
            background: var(--research-report-forest-deep);
            border-color: var(--research-report-forest-deep);
        }

        @media (max-width: 575.98px) {

            .research-report-file-modal .modal-header,
            .research-report-file-modal .modal-body,
            .research-report-file-modal .modal-footer {
                padding-left: 19px;
                padding-right: 19px;
            }
        }
    </style>

@endsection


@section('content')

    <div class="content-wrapper">

        <div class="content-header">

            <div class="research-report-shell">

                <div class="research-report-heading">

                    <div>

                        <span class="research-report-eyebrow">
                            Penelitian
                        </span>

                        <h1>
                            {{ $pagetitle }}
                        </h1>
                    </div>


                    <ol class="breadcrumb research-report-breadcrumb">

                        <li class="breadcrumb-item">
                            <a href="{{ route('dosen.dash') }}">
                                Home
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            {{ $pagetitle }}
                        </li>

                    </ol>

                </div>

            </div>

        </div>


        <section class="content">

            <div class="research-report-shell">

                <form action="{{ route('dosen.storekumpulanpenelitian') }}" method="post" enctype="multipart/form-data"
                    id="addKpenelitianForm">

                    @csrf


                    <div class="research-report-card">

                        <div class="research-report-card-head">

                            <div class="research-report-title-group">

                                <h2 class="research-report-card-title">
                                    Laporan Penelitian Masyarakat
                                </h2>

                                <p class="research-report-card-subtitle">
                                    Form pengumpulan laporan penelitian untuk dikelola melalui P3M.
                                </p>

                            </div>


                            <div class="research-report-secure">

                                <i class="fas fa-shield-alt"></i>

                                Data tersimpan secara aman

                            </div>

                        </div>


                        <div class="research-report-card-body">

                            {{-- =====================================================
                             MAIN INFORMATION
                        ====================================================== --}}

                            <section class="research-report-section">

                                <div class="research-report-section-head">

                                    <span class="research-report-section-number">
                                        01
                                    </span>

                                    <div>
                                        <strong>
                                            Informasi Laporan
                                        </strong>

                                        <span>
                                            Detail utama laporan penelitian masyarakat.
                                        </span>
                                    </div>

                                </div>


                                <div class="research-report-grid">

                                    {{-- LEFT --}}
                                    <div class="research-report-column">

                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Judul Penelitian
                                            </label>

                                            <input type="text" name="judul" class="research-report-input"
                                                placeholder="Masukkan judul penelitian" value="{{ old('judul') }}">

                                            @error('judul')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Bidang Ilmu
                                            </label>

                                            <input type="text" name="bidang" class="research-report-input"
                                                placeholder="Contoh: Teknologi Informasi" value="{{ old('bidang') }}">

                                            @error('bidang')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Kategori
                                            </label>

                                            <input type="text" name="jeniskategori" class="research-report-input"
                                                value="Laporan Penelitian Masyarakat" readonly>

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Lokasi
                                            </label>

                                            <input type="text" name="lokasi" class="research-report-input"
                                                placeholder="Masukkan lokasi penelitian" value="{{ old('lokasi') }}">

                                            @error('lokasi')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Lama Penelitian
                                            </label>

                                            <div class="research-report-date-group">

                                                <input type="date" name="tanggal_mulai" class="research-report-input"
                                                    value="{{ old('tanggal_mulai') }}" required>

                                                <span class="research-report-date-separator">
                                                    <i class="fas fa-minus"></i>
                                                </span>

                                                <input type="date" name="tanggal_selesai" class="research-report-input"
                                                    value="{{ old('tanggal_selesai') }}" required>

                                            </div>

                                            @if ($errors->has('tanggal_mulai') || $errors->has('tanggal_selesai'))
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $errors->first('tanggal_mulai') ?: $errors->first('tanggal_selesai') }}
                                                </span>
                                            @endif

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Biaya
                                            </label>

                                            <input type="number" name="biaya" class="research-report-input"
                                                placeholder="Contoh 1500000" min="0" step="any"
                                                value="{{ old('biaya') }}">

                                            <span class="research-report-help">
                                                Contoh penulisan nominal: 1500000.
                                            </span>

                                            @error('biaya')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        @php
                                            $cachedUppdf = old('cached_uppdf', session('cached_uppdf'));
                                            $cachedUppdfName = old('cached_uppdf_name', session('cached_uppdf_name'));
                                            $cachedFoto = old('cached_foto', session('cached_foto'));
                                            $cachedFotoName = old('cached_foto_name', session('cached_foto_name'));
                                        @endphp

                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Unggah Laporan
                                            </label>

                                            @if ($cachedUppdf && $cachedUppdfName)
                                                <input type="hidden" name="cached_uppdf" value="{{ $cachedUppdf }}">
                                                <input type="hidden" name="cached_uppdf_name" value="{{ $cachedUppdfName }}">
                                            @endif

                                            <input type="file" name="uppdf" class="research-report-file-input"
                                                id="uploadLaporanPenelitian" accept=".pdf,application/pdf"
                                                data-p3m-upload
                                                data-p3m-upload-preserve-accept
                                                data-p3m-upload-name-id="uploadLaporanPenelitianName"
                                                data-p3m-upload-label="Dokumen laporan"
                                                data-p3m-upload-empty-label="{{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : 'Pilih file laporan' }}"
                                                data-p3m-cached-name="{{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : '' }}"
                                                data-p3m-upload-formats="PDF"
                                                data-p3m-upload-extensions="pdf"
                                                data-p3m-upload-mime-types="application/pdf"
                                                data-p3m-upload-max-bytes="5242880"
                                                @if ($errors->has('uppdf')) data-p3m-upload-error="{{ $errors->first('uppdf') }}" @endif>

                                            <label for="uploadLaporanPenelitian" class="research-report-file-label">

                                                <span class="research-report-file-copy">

                                                    <span class="research-report-file-icon">
                                                        <i class="fas fa-file-pdf" style="{{ $cachedUppdfName ? 'color: #16a34a;' : '' }}"></i>
                                                    </span>

                                                    <span class="research-report-file-name"
                                                        id="uploadLaporanPenelitianName">
                                                        {{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : 'Pilih file laporan' }}
                                                    </span>

                                                </span>


                                                <span class="research-report-file-browse">
                                                    <i class="fas fa-folder-open"></i>
                                                    {{ $cachedUppdfName ? 'Ganti File' : 'Pilih File' }}
                                                </span>

                                            </label>

                                            <span class="research-report-help">
                                                Hanya PDF · Maksimal ukuran file 5 MB.
                                            </span>

                                            @error('uppdf')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Unggah Gambar / Foto
                                            </label>

                                            @if ($cachedFoto && $cachedFotoName)
                                                <input type="hidden" name="cached_foto" value="{{ $cachedFoto }}">
                                                <input type="hidden" name="cached_foto_name" value="{{ $cachedFotoName }}">
                                            @endif

                                            <input type="file" name="foto" class="research-report-file-input"
                                                id="uploadFotoPenelitian" accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                                data-p3m-upload
                                                data-p3m-upload-preserve-accept
                                                data-p3m-upload-name-id="uploadFotoPenelitianName"
                                                data-p3m-upload-label="Foto kegiatan"
                                                data-p3m-upload-empty-label="{{ $cachedFotoName ? $cachedFotoName . ' (Tersimpan)' : 'Pilih gambar / foto' }}"
                                                data-p3m-cached-name="{{ $cachedFotoName ? $cachedFotoName . ' (Tersimpan)' : '' }}"
                                                data-p3m-upload-formats="JPG atau PNG"
                                                data-p3m-upload-extensions="jpg,jpeg,png"
                                                data-p3m-upload-mime-types="image/jpeg,image/png"
                                                data-p3m-upload-max-bytes="2097152"
                                                @if ($errors->has('foto')) data-p3m-upload-error="{{ $errors->first('foto') }}" @endif>

                                            <label for="uploadFotoPenelitian" class="research-report-file-label">

                                                <span class="research-report-file-copy">

                                                    <span class="research-report-file-icon">
                                                        <i class="fas fa-image" style="{{ $cachedFotoName ? 'color: #16a34a;' : '' }}"></i>
                                                    </span>

                                                    <span class="research-report-file-name" id="uploadFotoPenelitianName">
                                                        {{ $cachedFotoName ? $cachedFotoName . ' (Tersimpan)' : 'Pilih gambar / foto' }}
                                                    </span>

                                                </span>


                                                <span class="research-report-file-browse">
                                                    <i class="fas fa-camera"></i>
                                                    {{ $cachedFotoName ? 'Ganti Gambar' : 'Pilih Gambar' }}
                                                </span>

                                            </label>

                                            <span class="research-report-help">
                                                JPG atau PNG · Maksimal ukuran file 2 MB.
                                            </span>

                                            @error('foto')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- RIGHT --}}
                                    <div class="research-report-column">

                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Nama Ketua
                                            </label>

                                            <input type="text" name="ketua" class="research-report-input"
                                                placeholder="Masukkan nama ketua" value="{{ old('ketua') }}">

                                            @error('ketua')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Jenis Kelamin
                                            </label>

                                            <select class="research-report-select" name="jeniskelamin">

                                                <option value="">
                                                    --- Pilih ---
                                                </option>

                                                <option value="L" {{ old('jeniskelamin') == 'L' ? 'selected' : '' }}>
                                                    Laki - Laki
                                                </option>

                                                <option value="P" {{ old('jeniskelamin') == 'P' ? 'selected' : '' }}>
                                                    Perempuan
                                                </option>

                                            </select>

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                NIDN
                                            </label>

                                            <input type="text" name="nidn" class="research-report-input"
                                                placeholder="Masukkan NIDN" value="{{ old('nidn') }}">

                                            @error('nidn')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Jabatan Fungsional
                                            </label>

                                            <select class="research-report-select" name="jabatan">

                                                <option value="">
                                                    --- Pilih ---
                                                </option>

                                                <option value="DR" {{ old('jabatan') == 'DR' ? 'selected' : '' }}>
                                                    Direktur
                                                </option>

                                                <option value="LT" {{ old('jabatan') == 'LT' ? 'selected' : '' }}>
                                                    Wakil Direktur
                                                </option>

                                                <option value="KP" {{ old('jabatan') == 'KP' ? 'selected' : '' }}>
                                                    Ketua Program Studi
                                                </option>

                                                <option value="DS" {{ old('jabatan') == 'DS' ? 'selected' : '' }}>
                                                    Dosen Polibang
                                                </option>

                                            </select>

                                            @error('jabatan')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Program Studi
                                            </label>

                                            <select class="research-report-select" name="prodi">

                                                <option value="">
                                                    --- Pilih ---
                                                </option>

                                                <option value="R" {{ old('prodi') == 'R' ? 'selected' : '' }}>
                                                    Rekayasa Perangkat Lunak
                                                </option>

                                                <option value="A" {{ old('prodi') == 'A' ? 'selected' : '' }}>
                                                    Administrasi Bisnis Internasional
                                                </option>

                                                <option value="AK" {{ old('prodi') == 'AK' ? 'selected' : '' }}>
                                                    Akutansi Keuangan Publik
                                                </option>

                                                <option value="AB" {{ old('prodi') == 'AB' ? 'selected' : '' }}>
                                                    Bisnis Digital
                                                </option>

                                                <option value="AP" {{ old('prodi') == 'AP' ? 'selected' : '' }}>
                                                    Agribisnis Pertanian
                                                </option>

                                            </select>

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                No. Telepon
                                            </label>

                                            <input type="text" name="telp" class="research-report-input"
                                                placeholder="Masukkan nomor telepon" value="{{ old('telp') }}">

                                            @error('telp')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-report-field">

                                            <label class="research-report-label">
                                                Alamat
                                            </label>

                                            <input type="text" name="alamat" class="research-report-input"
                                                placeholder="Masukkan alamat" value="{{ old('alamat') }}">

                                            @error('alamat')
                                                <span class="research-report-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                    </div>

                                </div>

                            </section>


                            {{-- =====================================================
                             TEAM MEMBERS
                        ====================================================== --}}

                            <section class="research-report-team">

                                <div class="research-report-team-head">

                                    <div class="research-report-team-title">

                                        <span class="research-report-team-icon">
                                            <i class="fas fa-users"></i>
                                        </span>

                                        <div>
                                            <strong>
                                                Anggota Penelitian
                                            </strong>

                                            <span>
                                                Tambahkan anggota yang terlibat dalam laporan penelitian.
                                            </span>
                                        </div>

                                    </div>


                                    <button type="button" onclick="addAnggota()" class="research-report-add-member">
                                        <i class="fas fa-plus"></i>
                                        Tambah Anggota
                                    </button>

                                </div>


                                @php
                                    $membersData = old('anggota');
                                    if (!is_array($membersData) || empty($membersData)) {
                                        $membersData = [
                                            ['nama' => '', 'prodi' => '', 'nim' => '', 'jabatan' => '']
                                        ];
                                    }
                                @endphp

                                <div id="anggota-wrapper" class="research-report-member-list">

                                    @foreach ($membersData as $i => $mem)
                                        <div class="research-report-member-card anggota-row">

                                            <div class="research-report-member-head">

                                                <span class="research-report-member-label">

                                                    <span class="research-report-member-index">
                                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                    </span>

                                                    Identitas Anggota

                                                </span>


                                                <button type="button" class="research-report-remove remove-anggota"
                                                    aria-label="Hapus anggota" title="Hapus anggota"
                                                    @if (count($membersData) <= 1) style="display: none;" @endif>
                                                    <i class="fas fa-times"></i>
                                                </button>

                                            </div>


                                            <div class="research-report-member-grid">

                                                <div class="research-report-field">

                                                    <label class="research-report-label">
                                                        Nama
                                                    </label>

                                                    <input type="text" class="research-report-input"
                                                        name="anggota[{{ $i }}][nama]" placeholder="Nama anggota"
                                                        value="{{ old("anggota.{$i}.nama", $mem['nama'] ?? '') }}">

                                                    @error("anggota.{$i}.nama")
                                                        <span class="research-report-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="research-report-field">

                                                    <label class="research-report-label">
                                                        Program Studi
                                                    </label>

                                                    <select class="research-report-select" name="anggota[{{ $i }}][prodi]">

                                                        <option value="">
                                                            --- Pilih ---
                                                        </option>

                                                        <option value="R"
                                                            {{ old("anggota.{$i}.prodi", $mem['prodi'] ?? '') == 'R' ? 'selected' : '' }}>
                                                            Rekayasa Perangkat Lunak
                                                        </option>

                                                        <option value="A"
                                                            {{ old("anggota.{$i}.prodi", $mem['prodi'] ?? '') == 'A' ? 'selected' : '' }}>
                                                            Administrasi Bisnis Internasional
                                                        </option>

                                                        <option value="AK"
                                                            {{ old("anggota.{$i}.prodi", $mem['prodi'] ?? '') == 'AK' ? 'selected' : '' }}>
                                                            Akutansi Keuangan Publik
                                                        </option>

                                                        <option value="AB"
                                                            {{ old("anggota.{$i}.prodi", $mem['prodi'] ?? '') == 'AB' ? 'selected' : '' }}>
                                                            Bisnis Digital
                                                        </option>

                                                        <option value="AP"
                                                            {{ old("anggota.{$i}.prodi", $mem['prodi'] ?? '') == 'AP' ? 'selected' : '' }}>
                                                            Agribisnis Perternakan
                                                        </option>

                                                    </select>

                                                    @error("anggota.{$i}.prodi")
                                                        <span class="research-report-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="research-report-field">

                                                    <label class="research-report-label">
                                                        NIM / NIDN
                                                    </label>

                                                    <input type="text" class="research-report-input"
                                                        name="anggota[{{ $i }}][nim]" placeholder="NIM / NIDN"
                                                        value="{{ old("anggota.{$i}.nim", $mem['nim'] ?? '') }}">

                                                    @error("anggota.{$i}.nim")
                                                        <span class="research-report-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="research-report-field">

                                                    <label class="research-report-label">
                                                        Jabatan
                                                    </label>

                                                    <select class="research-report-select" name="anggota[{{ $i }}][jabatan]">

                                                        <option value="">
                                                            --- Pilih ---
                                                        </option>

                                                        <option value="DR"
                                                            {{ old("anggota.{$i}.jabatan", $mem['jabatan'] ?? '') == 'DR' ? 'selected' : '' }}>
                                                            Direktur
                                                        </option>

                                                        <option value="LT"
                                                            {{ old("anggota.{$i}.jabatan", $mem['jabatan'] ?? '') == 'LT' ? 'selected' : '' }}>
                                                            Wakil Direktur
                                                        </option>

                                                        <option value="KP"
                                                            {{ old("anggota.{$i}.jabatan", $mem['jabatan'] ?? '') == 'KP' ? 'selected' : '' }}>
                                                            Ketua Program Studi
                                                        </option>

                                                        <option value="DS"
                                                            {{ old("anggota.{$i}.jabatan", $mem['jabatan'] ?? '') == 'DS' ? 'selected' : '' }}>
                                                            Dosen
                                                        </option>

                                                        <option value="MHS"
                                                            {{ old("anggota.{$i}.jabatan", $mem['jabatan'] ?? '') == 'MHS' ? 'selected' : '' }}>
                                                            Mahasiswa
                                                        </option>

                                                    </select>

                                                    @error("anggota.{$i}.jabatan")
                                                        <span class="research-report-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>

                            </section>

                        </div>


                        <div class="research-report-footer">

                            <div class="research-report-footer-note">

                                <i class="fas fa-info-circle"></i>

                                <span>
                                    Periksa kembali informasi sebelum mengirim laporan penelitian.
                                </span>

                            </div>


                            <button type="submit" class="research-report-submit">
                                <i class="fas fa-paper-plane"></i>
                                Submit Laporan
                            </button>

                        </div>

                    </div>

                </form>
                {{-- P3M-style validation modal. No SweetAlert dependency required. --}}
                <div class="modal fade p3m-modal research-report-file-modal" id="researchReportFileErrorModal"
                    tabindex="-1" role="dialog" aria-labelledby="researchReportFileErrorTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content text-left">
                            <div class="modal-header">
                                <div class="modal-icon"><i class="fas fa-exclamation-circle"></i></div>
                                <div class="modal-head-text">
                                    <h5 id="researchReportFileErrorTitle">File Tidak Valid</h5>
                                    <p id="researchReportFileErrorDescription">Periksa file yang dipilih sebelum
                                        melanjutkan.</p>
                                </div>
                                <button type="button" class="modal-close-btn" data-dismiss="modal"
                                    aria-label="Tutup">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-alert">
                                    <i class="fas fa-info-circle"></i>
                                    <span id="researchReportFileErrorMessage"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn-modal-close" data-dismiss="modal">Mengerti</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </section>

    </div>


    <script>
        (function() {
            'use strict';

            function getNextMemberIndex() {
                const inputs = document.querySelectorAll('#anggota-wrapper [name^="anggota["]');
                let max = -1;
                inputs.forEach(function(el) {
                    const match = el.name.match(/^anggota\[(\d+)\]/);
                    if (match) {
                        const idx = parseInt(match[1], 10);
                        if (idx > max) max = idx;
                    }
                });
                return max + 1;
            }

            function updateMemberNumbers() {
                const rows = document.querySelectorAll('#anggota-wrapper .anggota-row');
                rows.forEach(function(row, index) {
                    const number = row.querySelector('.research-report-member-index');
                    if (number) number.textContent = String(index + 1).padStart(2, '0');
                    const removeBtn = row.querySelector('.remove-anggota');
                    if (removeBtn) {
                        removeBtn.style.display = rows.length > 1 ? '' : 'none';
                    }
                });
            }

            function addAnggota() {
                const wrapper = document.getElementById('anggota-wrapper');
                if (!wrapper) return;

                const index = getNextMemberIndex();
                const html = `
                    <div class="research-report-member-card anggota-row">
                        <div class="research-report-member-head">
                            <span class="research-report-member-label">
                                <span class="research-report-member-index">00</span>
                                Identitas Anggota
                            </span>
                            <button type="button" class="research-report-remove remove-anggota" aria-label="Hapus anggota" title="Hapus anggota">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="research-report-member-grid">
                            <div class="research-report-field">
                                <label class="research-report-label">Nama</label>
                                <input type="text" class="research-report-input" name="anggota[${index}][nama]" placeholder="Nama anggota">
                            </div>
                            <div class="research-report-field">
                                <label class="research-report-label">Program Studi</label>
                                <select class="research-report-select" name="anggota[${index}][prodi]">
                                    <option value="">--- Pilih ---</option>
                                    <option value="R">Rekayasa Perangkat Lunak</option>
                                    <option value="A">Administrasi Bisnis Internasional</option>
                                    <option value="AK">Akutansi Keuangan Publik</option>
                                    <option value="AB">Bisnis Digital</option>
                                    <option value="AP">Agribisnis Perternakan</option>
                                </select>
                            </div>
                            <div class="research-report-field">
                                <label class="research-report-label">NIM / NIDN</label>
                                <input type="text" class="research-report-input" name="anggota[${index}][nim]" placeholder="NIM / NIDN">
                            </div>
                            <div class="research-report-field">
                                <label class="research-report-label">Jabatan</label>
                                <select class="research-report-select" name="anggota[${index}][jabatan]">
                                    <option value="">--- Pilih ---</option>
                                    <option value="DR">Direktur</option>
                                    <option value="LT">Wakil Direktur</option>
                                    <option value="KP">Ketua Program Studi</option>
                                    <option value="DS">Dosen</option>
                                    <option value="MHS">Mahasiswa</option>
                                </select>
                            </div>
                        </div>
                    </div>`;

                wrapper.insertAdjacentHTML('beforeend', html);
                updateMemberNumbers();
            }

            window.addAnggota = addAnggota;
            window.updateMemberNumbers = updateMemberNumbers;

            if (!document.documentElement.dataset.researchReportRemoveBound) {
                document.documentElement.dataset.researchReportRemoveBound = 'true';
                document.addEventListener('click', function(event) {
                    const removeButton = event.target.closest('.remove-anggota');
                    if (!removeButton) return;

                    const row = removeButton.closest('.anggota-row');
                    if (!row) return;

                    const rows = document.querySelectorAll('#anggota-wrapper .anggota-row');
                    if (rows.length <= 1) return;

                    row.remove();
                    updateMemberNumbers();
                });
            }

            document.addEventListener('turbo:load', updateMemberNumbers);
            document.addEventListener('DOMContentLoaded', updateMemberNumbers, { once: true });
        })();
    </script>

@endsection
