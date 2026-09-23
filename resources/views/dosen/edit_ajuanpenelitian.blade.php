@extends('layout.doslayout')

@section('body_class', 'page-dosen-edit-kpenelitian')

@section('css')

    <style>
        /* =========================================================================
               P3M DOSEN — EDIT LAPORAN PENELITIAN
               UI redesign only.
               Existing update route, field names, existing values and member structure
               are preserved from the original Blade.
               ========================================================================= */

        :root {
            --research-edit-forest: #003d2d;
            --research-edit-forest-deep: #002e22;
            --research-edit-forest-mid: #00573b;
            --research-edit-forest-soft: #eaf5ee;

            --research-edit-gold: #b99835;

            --research-edit-ink: #0d1f1a;
            --research-edit-ink-2: #1e3328;
            --research-edit-text: #3b4f47;
            --research-edit-muted: #6b7f78;
            --research-edit-light: #9caaa4;

            --research-edit-border: #e4ede8;
            --research-edit-border-2: #d3e0d9;

            --research-edit-surface: #ffffff;
            --research-edit-surface-alt: #f7faf8;

            --research-edit-danger: #d94b4b;
            --research-edit-danger-soft: #fef2f2;
            --research-edit-danger-border: #f5c0c0;

            --research-edit-radius-sm: 8px;
            --research-edit-radius-md: 12px;
            --research-edit-radius-lg: 16px;
            --research-edit-radius-2xl: 24px;
        }

        /* -------------------------------------------------------------------------
               PAGE
               ------------------------------------------------------------------------- */

        .page-dosen-edit-kpenelitian .content-wrapper {
            min-height: calc(100vh - 66px);

            background:
                radial-gradient(ellipse 70% 40% at 100% 0%,
                    rgba(0, 93, 59, .06),
                    transparent),
                linear-gradient(180deg,
                    #f2f8f5 0%,
                    #f7faf8 100%) !important;
        }

        .research-edit-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-edit-kpenelitian .content-header {
            padding: 26px 0 10px !important;
        }

        .page-dosen-edit-kpenelitian section.content {
            padding: 6px 0 36px !important;
        }

        /* -------------------------------------------------------------------------
               PAGE HEADING
               ------------------------------------------------------------------------- */

        .research-edit-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .research-edit-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 9px;

            color: var(--research-edit-forest-mid);

            font-size: 10.5px;
            font-weight: 800;

            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .research-edit-eyebrow::before {
            content: "";

            width: 20px;
            height: 2.5px;

            border-radius: 99px;

            background: var(--research-edit-gold);
        }

        .research-edit-heading h1 {
            margin: 0;

            color: var(--research-edit-ink);

            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: clamp(28px, 3vw, 36px);
            line-height: 1.12;
            font-weight: 800;

            letter-spacing: -.045em;
        }

        .research-edit-heading p {
            margin: 7px 0 0;

            color: var(--research-edit-muted);

            font-size: 12.5px;
            line-height: 1.55;
        }

        .research-edit-breadcrumb {
            margin: 0;
            padding: 0;

            background: transparent;

            font-size: 12px;
            font-weight: 600;

            white-space: nowrap;
        }

        .research-edit-breadcrumb a {
            color: var(--research-edit-forest);
            text-decoration: none;
        }

        .research-edit-breadcrumb .active {
            color: var(--research-edit-muted);
        }

        .research-edit-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "/";

            padding: 0 8px;

            color: var(--research-edit-border-2);
        }

        /* -------------------------------------------------------------------------
               CARD
               ------------------------------------------------------------------------- */

        .research-edit-card {
            overflow: hidden;

            border: 1px solid var(--research-edit-border);
            border-radius: var(--research-edit-radius-2xl);

            background: var(--research-edit-surface);

            box-shadow:
                0 20px 56px rgba(3, 50, 33, .12),
                0 4px 12px rgba(0, 0, 0, .06);
        }

        .research-edit-card-head {
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

            border-bottom: 1px solid var(--research-edit-border);
        }

        .research-edit-card-head::after {
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

        .research-edit-title-group {
            position: relative;
            z-index: 1;
        }

        .research-edit-card-title {
            margin: 0;

            color: var(--research-edit-ink);

            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 18px;
            line-height: 1.25;
            font-weight: 800;

            letter-spacing: -.025em;
        }

        .research-edit-card-subtitle {
            margin: 5px 0 0;

            color: var(--research-edit-muted);

            font-size: 11.5px;
            line-height: 1.45;
        }

        .research-edit-mode {
            position: relative;
            z-index: 1;

            display: inline-flex;
            align-items: center;

            gap: 7px;

            padding: 8px 12px;

            border: 1px solid var(--research-edit-border);
            border-radius: var(--research-edit-radius-md);

            background: rgba(255, 255, 255, .78);

            color: var(--research-edit-forest-mid);

            font-size: 10px;
            font-weight: 800;

            white-space: nowrap;
        }

        .research-edit-card-body {
            padding: 28px 30px 8px;
        }

        /* -------------------------------------------------------------------------
               SECTIONS
               ------------------------------------------------------------------------- */

        .research-edit-section {
            margin-bottom: 28px;
        }

        .research-edit-section-head {
            display: flex;
            align-items: center;

            gap: 11px;

            margin-bottom: 18px;
        }

        .research-edit-section-head .research-edit-section-number {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #eef6f1;
            color: var(--research-edit-forest);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .research-edit-section-head strong {
            display: block;

            color: var(--research-edit-ink-2);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            line-height: 1.2;
            font-weight: 800;
        }

        .research-edit-section-head span {
            display: block;

            margin-top: 3px;

            color: var(--research-edit-muted);

            font-size: 10px;
            line-height: 1.35;
        }

        /* -------------------------------------------------------------------------
               FORM GRID
               ------------------------------------------------------------------------- */

        .research-edit-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr) minmax(0, 1fr);

            gap: 30px;
        }

        .research-edit-column {
            min-width: 0;

            padding: 0 2px;
        }

        .research-edit-column+.research-edit-column {
            padding-left: 28px;

            border-left: 1px solid #eaf0ed;
        }

        .research-edit-field {
            margin-bottom: 18px;
        }

        .research-edit-field:last-child {
            margin-bottom: 0;
        }

        .research-edit-label {
            display: block;

            margin-bottom: 7px;

            color: var(--research-edit-ink-2);

            font-size: 11px;
            line-height: 1.3;
            font-weight: 800;
        }

        .research-edit-label .req {
            margin-left: 2px;

            color: var(--research-edit-danger);
        }

        .research-edit-input,
        .research-edit-select {
            width: 100%;

            min-height: 42px;

            padding: 9px 12px;

            border: 1px solid var(--research-edit-border-2);
            border-radius: var(--research-edit-radius-md);

            outline: none;

            background: #fff;
            color: var(--research-edit-ink);

            font-family: inherit;
            font-size: 12px;
            font-weight: 500;

            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .research-edit-input::placeholder {
            color: var(--research-edit-light);
        }

        .research-edit-input:hover,
        .research-edit-select:hover {
            border-color: #c5d6cd;
        }

        .research-edit-input:focus,
        .research-edit-select:focus {
            border-color: var(--research-edit-forest-mid);

            box-shadow:
                0 0 0 3px rgba(0, 87, 59, .09);
        }

        .research-edit-input[readonly] {
            background: #f4f7f6;
            color: #667a72;
            cursor: default;
        }

        .research-edit-help {
            display: block;

            margin-top: 6px;

            color: var(--research-edit-light);

            font-size: 9.5px;
            line-height: 1.4;
        }

        .research-edit-error {
            display: flex;
            align-items: flex-start;

            gap: 6px;

            margin-top: 6px;

            color: var(--research-edit-danger);

            font-size: 10px;
            line-height: 1.4;
        }

        .research-edit-error i {
            margin-top: 1px;

            font-size: 9px;
        }

        /* -------------------------------------------------------------------------
               DATES
               ------------------------------------------------------------------------- */

        .research-edit-date-group {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr) auto minmax(0, 1fr);

            gap: 8px;

            align-items: center;
        }

        .research-edit-date-separator {
            color: var(--research-edit-muted);

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;
        }

        /* -------------------------------------------------------------------------
               CURRENT FILE
               ------------------------------------------------------------------------- */

        .research-edit-file-wrap {
            display: flex;
            flex-direction: column;

            gap: 8px;
        }

        .research-edit-current-file {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            min-height: 46px;

            padding: 8px 11px;

            border: 1px solid var(--research-edit-border);
            border-radius: var(--research-edit-radius-md);

            background: var(--research-edit-surface-alt);
        }

        .research-edit-current-file-copy {
            display: flex;
            align-items: center;

            gap: 9px;

            min-width: 0;
        }

        .research-edit-file-icon {
            width: 30px;
            height: 30px;
            flex: 0 0 30px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: var(--research-edit-forest-soft);
            color: var(--research-edit-forest-mid);

            font-size: 12px;
        }

        .research-edit-file-name {
            min-width: 0;
            overflow: hidden;

            color: var(--research-edit-text);

            font-size: 10.5px;
            font-weight: 700;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .research-edit-file-status {
            flex: 0 0 auto;

            padding: 5px 8px;

            border-radius: 99px;

            background: #eef6f1;
            color: var(--research-edit-forest);

            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }

        .research-edit-file-input {
            position: absolute;

            width: 1px;
            height: 1px;

            overflow: hidden;

            opacity: 0;
            pointer-events: none;
        }

        .research-edit-file-label {
            display: flex;
            align-items: center;
            justify-content: center;

            min-height: 38px;

            padding: 0 12px;

            border: 1px dashed #bfd4c8;
            border-radius: 10px;

            background: #fbfdfc;
            color: var(--research-edit-forest);

            font-size: 10px;
            font-weight: 800;

            cursor: pointer;

            transition: .18s ease;
        }

        .research-edit-file-label:hover {
            border-color: #9fbead;
            background: var(--research-edit-forest-soft);

            transform: translateY(-1px);
        }

        /* -------------------------------------------------------------------------
               MEMBERS
               ------------------------------------------------------------------------- */

        .research-edit-team {
            padding-top: 23px;

            border-top: 1px solid #eaf0ed;
        }

        .research-edit-team-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            margin-bottom: 14px;
        }

        .research-edit-team-title {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .research-edit-team-title .research-edit-team-icon {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #eef6f1;
            color: var(--research-edit-forest);
            font-size: 12px;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .research-edit-team-title strong {
            color: var(--research-edit-ink-2);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .research-edit-team-title span {
            display: block;

            margin-top: 2px;

            color: var(--research-edit-muted);

            font-size: 9.5px;
        }

        .research-edit-add-member {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            min-height: 34px;

            padding: 0 11px;

            border: 1px solid #c7ddd0;
            border-radius: 9px;

            background: #fff;
            color: var(--research-edit-forest);

            font-size: 10px;
            font-weight: 800;

            cursor: pointer;

            transition: .18s ease;
        }

        .research-edit-add-member:hover {
            background: var(--research-edit-forest-soft);
            border-color: #aec9bb;

            transform: translateY(-1px);
        }

        .research-edit-member-list {
            display: flex;
            flex-direction: column;

            gap: 10px;
        }

        .research-edit-member-card {
            padding: 15px 16px;

            border: 1px solid var(--research-edit-border);
            border-radius: 14px;

            background: #fbfdfc;

            transition:
                border-color .18s ease,
                box-shadow .18s ease;
        }

        .research-edit-member-card:hover {
            border-color: #d5e3dc;

            box-shadow:
                0 7px 20px rgba(7, 62, 45, .04);
        }

        .research-edit-member-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-bottom: 13px;
        }

        .research-edit-member-label {
            display: flex;
            align-items: center;

            gap: 8px;

            color: var(--research-edit-ink-2);

            font-size: 11px;
            font-weight: 800;
        }

        .research-edit-member-label .research-edit-member-index {
            width: 23px;
            height: 23px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            background: #eaf5ee;
            color: var(--research-edit-forest);
            font-size: 9px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .research-edit-remove {
            width: 28px;
            height: 28px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--research-edit-danger-border);
            border-radius: 8px;

            background: var(--research-edit-danger-soft);
            color: var(--research-edit-danger);

            font-size: 10px;

            cursor: pointer;

            transition: .18s ease;
        }

        .research-edit-remove:hover {
            background: #fdeaea;

            transform: translateY(-1px);
        }

        .research-edit-member-grid {
            display: grid;

            grid-template-columns:
                1.15fr 1fr .85fr .95fr;

            gap: 12px;
        }

        /* -------------------------------------------------------------------------
               EMPTY TEAM
               ------------------------------------------------------------------------- */

        .research-edit-team-empty {
            display: flex;
            align-items: center;

            gap: 11px;

            padding: 14px;

            border: 1px dashed var(--research-edit-border-2);
            border-radius: 13px;

            background: #fbfdfc;
            color: var(--research-edit-muted);
        }

        .research-edit-team-empty-icon {
            width: 34px;
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: var(--research-edit-forest-soft);
            color: var(--research-edit-forest-mid);

            font-size: 12px;
        }

        .research-edit-team-empty strong {
            display: block;

            color: var(--research-edit-ink-2);

            font-size: 11px;
            font-weight: 800;
        }

        .research-edit-team-empty small {
            display: block;

            margin-top: 2px;

            color: var(--research-edit-muted);

            font-size: 9.5px;
        }

        /* -------------------------------------------------------------------------
               FOOTER
               ------------------------------------------------------------------------- */

        .research-edit-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 18px;

            padding: 17px 30px;

            border-top: 1px solid var(--research-edit-border);

            background: var(--research-edit-surface-alt);
        }

        .research-edit-footer-note {
            display: inline-flex;
            align-items: center;

            gap: 8px;

            color: var(--research-edit-muted);

            font-size: 10px;
            line-height: 1.4;
        }

        .research-edit-footer-note i {
            color: var(--research-edit-forest-mid);
        }

        .research-edit-actions {
            display: flex;
            align-items: center;

            gap: 9px;
        }

        .research-edit-back {
            min-height: 41px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 14px;

            border: 1px solid var(--research-edit-border-2);
            border-radius: var(--research-edit-radius-md);

            background: #fff;
            color: var(--research-edit-text);

            font-size: 10.5px;
            font-weight: 700;

            text-decoration: none !important;

            transition: .18s ease;
        }

        .research-edit-back:hover {
            background: #f4f8f6;
            color: var(--research-edit-ink-2);

            transform: translateY(-1px);
        }

        .research-edit-submit {
            min-height: 41px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 0 17px;

            border: 1px solid var(--research-edit-forest);
            border-radius: var(--research-edit-radius-md);

            background: var(--research-edit-forest);
            color: #fff;

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 6px 16px rgba(0, 61, 45, .18);

            transition: .18s ease;
        }

        .research-edit-submit:hover {
            background: var(--research-edit-forest-deep);
            border-color: var(--research-edit-forest-deep);

            transform: translateY(-1px);

            box-shadow:
                0 9px 20px rgba(0, 61, 45, .23);
        }

        .research-edit-submit-resubmit {
            background: linear-gradient(135deg, #00573b 0%, #003d2d 100%);
            border-color: #003d2d;
            box-shadow: 0 6px 18px rgba(0, 87, 59, .28);
        }

        .research-edit-submit-resubmit:hover {
            background: linear-gradient(135deg, #00452f 0%, #002e22 100%);
            box-shadow: 0 8px 22px rgba(0, 87, 59, .35);
        }

        /* Revision Alert Box */
        .research-edit-revision-alert {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 18px 22px;
            margin-bottom: 24px;
            border-radius: var(--research-edit-radius-md);
            background: linear-gradient(135deg, #fff5f5 0%, #fef2f2 100%);
            border: 1.5px solid #fecdd3;
            box-shadow: 0 4px 16px rgba(225, 29, 72, .07);
        }

        .research-edit-revision-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #be123c;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(190, 18, 60, .25);
        }

        .research-edit-revision-body {
            flex: 1;
            min-width: 0;
        }

        .research-edit-revision-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }

        .research-edit-revision-title strong {
            font-size: 14.5px;
            font-weight: 800;
            color: #881337;
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .research-edit-revision-date {
            font-size: 12px;
            font-weight: 600;
            color: #9f1239;
        }

        .research-edit-revision-content {
            padding: 12px 16px;
            background: #ffffff;
            border: 1px dashed #fda4af;
            border-radius: 8px;
            color: #1f2937;
            font-size: 13.5px;
            line-height: 1.6;
            white-space: pre-wrap;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .research-edit-revision-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 12px;
            color: #64748b;
        }

        .research-edit-revision-meta strong {
            color: #334155;
        }

        .research-edit-revision-tip {
            color: #00573b;
            font-weight: 600;
        }

        /* -------------------------------------------------------------------------
               RESPONSIVE
               ------------------------------------------------------------------------- */

        @media (max-width: 991.98px) {

            .research-edit-shell {
                width: calc(100% - 34px);
            }

            .research-edit-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            .research-edit-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .research-edit-column+.research-edit-column {
                padding-left: 0;
                padding-top: 24px;

                border-left: 0;
                border-top: 1px solid #eaf0ed;
            }

            .research-edit-member-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {

            .research-edit-shell {
                width: calc(100% - 24px);
            }

            .research-edit-card {
                border-radius: var(--research-edit-radius-lg);
            }

            .research-edit-card-head {
                align-items: flex-start;
                flex-direction: column;

                padding: 20px 19px 17px;
            }

            .research-edit-card-body {
                padding: 22px 19px 7px;
            }

            .research-edit-footer {
                align-items: stretch;
                flex-direction: column;

                padding: 15px 19px 18px;
            }

            .research-edit-actions {
                width: 100%;
            }

            .research-edit-back,
            .research-edit-submit {
                flex: 1;
            }

            .research-edit-team-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .research-edit-add-member {
                width: 100%;
                justify-content: center;
            }

            .research-edit-current-file {
                align-items: flex-start;
                flex-direction: column;
            }

            .research-edit-file-status {
                align-self: flex-start;
            }
        }

        @media (max-width: 575.98px) {

            .research-edit-shell {
                width: calc(100% - 18px);
            }

            .research-edit-heading h1 {
                font-size: 28px;
            }

            .research-edit-date-group {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .research-edit-date-separator {
                text-align: center;
            }

            .research-edit-member-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .page-dosen-edit-kpenelitian *,
            .page-dosen-edit-kpenelitian *::before,
            .page-dosen-edit-kpenelitian *::after {
                transition: none !important;
            }
        }
    </style>

@endsection


@section('content')

    <div class="content-wrapper">

        <div class="content-header">

            <div class="research-edit-shell">

                <div class="research-edit-heading">

                    <div>

                        <span class="research-edit-eyebrow">
                            Penelitian
                        </span>

                        <h1>
                            {{ $pagetitle }}
                        </h1>
                    </div>


                    <ol class="breadcrumb research-edit-breadcrumb">

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

            <div class="research-edit-shell">

                <form action="{{ route('dosen.updatepenelitian', ['id' => $penelitian->id]) }}" method="post"
                    enctype="multipart/form-data" id="editKpenelitianForm">

                    @csrf


                    <div class="research-edit-card">

                        <div class="research-edit-card-head">

                            <div class="research-edit-title-group">

                                <h2 class="research-edit-card-title">
                                    Laporan Penelitian Masyarakat
                                </h2>

                                <p class="research-edit-card-subtitle">
                                    Edit informasi laporan penelitian yang tersimpan.
                                </p>

                            </div>


                            <div class="research-edit-mode">

                                <i class="fas fa-edit"></i>

                                Mode Edit

                            </div>

                        </div>


                        <div class="research-edit-card-body">

                            {{-- Revision Alert Banner --}}
                            @if (in_array($penelitian->status, ['non-approve', 'tolak'], true) && !empty($latestRejection?->reason))
                                <div class="research-edit-revision-alert">
                                    <div class="research-edit-revision-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="research-edit-revision-body">
                                        <div class="research-edit-revision-title">
                                            <strong><i class="fas fa-comment-dots mr-1"></i> Catatan Revisi dari Reviewer / Admin P3M</strong>
                                            @if ($latestRejection->decided_at)
                                                <span class="research-edit-revision-date">
                                                    <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($latestRejection->decided_at)->translatedFormat('d F Y, H:i') }} WIB
                                                </span>
                                            @endif
                                        </div>
                                        <div class="research-edit-revision-content">"{{ $latestRejection->reason }}"</div>
                                        <div class="research-edit-revision-meta">
                                            <span><i class="fas fa-user-shield text-danger mr-1"></i> Direview oleh: <strong>{{ $latestRejection->decisionMaker?->name ?? 'Admin P3M' }}</strong></span>
                                            <span class="research-edit-revision-tip"><i class="fas fa-info-circle mr-1"></i> Silakan periksa dan perbaiki poin-poin di atas pada isian form atau file lampiran, lalu klik <strong>"Simpan & Ajukan Ulang Proposal"</strong> di bagian bawah untuk mengajukan kembali ke P3M.</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- =====================================================
                             MAIN INFORMATION
                        ====================================================== --}}

                            <section class="research-edit-section">

                                <div class="research-edit-section-head">

                                    <span class="research-edit-section-number">
                                        01
                                    </span>

                                    <div>
                                        <strong>
                                            Informasi Laporan
                                        </strong>

                                        <span>
                                            Perbarui detail utama laporan penelitian dan data ketua.
                                        </span>
                                    </div>

                                </div>


                                <div class="research-edit-grid">

                                    {{-- LEFT --}}
                                    <div class="research-edit-column">

                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Judul Penelitian
                                            </label>

                                            <input type="text" name="judul" class="research-edit-input"
                                                placeholder="Masukkan judul penelitian" value="{{ $penelitian->judul }}">

                                            @error('judul')
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Bidang Ilmu
                                            </label>

                                            <input type="text" name="bidang" class="research-edit-input"
                                                placeholder="Masukkan bidang ilmu" value="{{ $penelitian->bidang }}">

                                            @error('bidang')
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Kategori
                                            </label>

                                            <input type="text" name="jeniskategori" class="research-edit-input"
                                                value="Proposal Penelitian" readonly>

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Lokasi
                                            </label>

                                            <input type="text" name="lokasi" class="research-edit-input"
                                                placeholder="Masukkan lokasi penelitian" value="{{ $penelitian->lokasi }}">

                                            @error('lokasi')
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Lama Penelitian
                                            </label>

                                            <div class="research-edit-date-group">

                                                <input type="date" name="tanggal_mulai" class="research-edit-input"
                                                    value="{{ $penelitian->tanggal_mulai }}" required>

                                                <span class="research-edit-date-separator">
                                                    <i class="fas fa-minus"></i>
                                                </span>

                                                <input type="date" name="tanggal_selesai" class="research-edit-input"
                                                    value="{{ $penelitian->tanggal_selesai }}" required>

                                            </div>

                                            @if ($errors->has('tanggal_mulai') || $errors->has('tanggal_selesai'))
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $errors->first('tanggal_mulai') ?: $errors->first('tanggal_selesai') }}
                                                </span>
                                            @endif

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Biaya
                                            </label>

                                            <input type="number" name="biaya" class="research-edit-input"
                                                placeholder="Contoh: 1500000" min="0" step="any"
                                                value="{{ $penelitian->biaya }}">

                                            <span class="research-edit-help">
                                                Contoh penulisan nominal: 1500000.
                                            </span>

                                            @error('biaya')
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Unggah Laporan
                                            </label>

                                            <div class="research-edit-file-wrap">

                                                @if ($penelitian->uppdf)
                                                    <div class="research-edit-current-file">

                                                        <div class="research-edit-current-file-copy">

                                                            <span class="research-edit-file-icon">
                                                                <i class="fas fa-file-pdf"></i>
                                                            </span>

                                                            <span class="research-edit-file-name"
                                                                title="{{ $penelitian->uppdf }}">
                                                                {{ $penelitian->uppdf }}
                                                            </span>

                                                        </div>


                                                        <span class="research-edit-file-status">
                                                            File saat ini
                                                        </span>

                                                    </div>
                                                @endif


                                                <input type="file" name="uppdf" class="research-edit-file-input"
                                                    id="uploadLaporanPenelitian" accept=".pdf,application/pdf"
                                                    data-p3m-upload-preserve-accept
                                                    data-p3m-upload-name-id="uploadLaporanPenelitianName">

                                                <label for="uploadLaporanPenelitian" class="research-edit-file-label">
                                                    <span>
                                                        <i class="fas fa-upload mr-1"></i>
                                                        Pilih file baru
                                                    </span>
                                                </label>

                                                <span class="research-edit-help" id="uploadLaporanPenelitianName">
                                                    Biarkan kosong jika file tidak ingin diganti. Hanya PDF · Maks. 5 MB.
                                                </span>

                                            </div>

                                            @error('uppdf')
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- RIGHT --}}
                                    <div class="research-edit-column">

                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Nama Ketua
                                            </label>

                                            <input type="text" name="ketua" class="research-edit-input"
                                                placeholder="Masukkan nama ketua" value="{{ $penelitian->ketua }}">

                                            @error('ketua')
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Jenis Kelamin
                                            </label>

                                            <select class="research-edit-select" name="jeniskelamin">

                                                <option value="">
                                                    --- Pilih ---
                                                </option>

                                                <option value="L"
                                                    {{ $penelitian->jeniskelamin == 'L' ? 'selected' : '' }}>
                                                    Laki - Laki
                                                </option>

                                                <option value="P"
                                                    {{ $penelitian->jeniskelamin == 'P' ? 'selected' : '' }}>
                                                    Perempuan
                                                </option>

                                            </select>

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                NIDN
                                            </label>

                                            <input type="text" name="nidn" class="research-edit-input"
                                                placeholder="Masukkan NIDN" value="{{ $penelitian->nidn }}">

                                            @error('nidn')
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Jabatan Fungsional
                                            </label>

                                            <select class="research-edit-select" name="jabatan">

                                                <option value="">
                                                    --- Pilih ---
                                                </option>

                                                <option value="DR"
                                                    {{ $penelitian->jabatan == 'DR' ? 'selected' : '' }}>
                                                    Direktur
                                                </option>

                                                <option value="LT"
                                                    {{ $penelitian->jabatan == 'LT' ? 'selected' : '' }}>
                                                    Wakil Direktur
                                                </option>

                                                <option value="KP"
                                                    {{ $penelitian->jabatan == 'KP' ? 'selected' : '' }}>
                                                    Ketua Program Studi
                                                </option>

                                                <option value="DS"
                                                    {{ $penelitian->jabatan == 'DS' ? 'selected' : '' }}>
                                                    Dosen Polibang
                                                </option>

                                            </select>

                                            @error('jabatan')
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Program Studi
                                            </label>

                                            <select class="research-edit-select" name="prodi">

                                                <option value="">
                                                    --- Pilih ---
                                                </option>

                                                <option value="R" {{ $penelitian->prodi == 'R' ? 'selected' : '' }}>
                                                    Rekayasa Perangkat Lunak
                                                </option>

                                                <option value="A" {{ $penelitian->prodi == 'A' ? 'selected' : '' }}>
                                                    Administrasi Bisnis Internasional
                                                </option>

                                                <option value="AK" {{ $penelitian->prodi == 'AK' ? 'selected' : '' }}>
                                                    Akutansi Keuangan Publik
                                                </option>

                                                <option value="AB" {{ $penelitian->prodi == 'AB' ? 'selected' : '' }}>
                                                    Bisnis Digital
                                                </option>

                                                <option value="AP" {{ $penelitian->prodi == 'AP' ? 'selected' : '' }}>
                                                    Agri Bisnis Perternakan
                                                </option>

                                            </select>

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                No. Telepon
                                            </label>

                                            <input type="text" name="telp" class="research-edit-input"
                                                placeholder="Masukkan nomor telepon" value="{{ $penelitian->telp }}">

                                            @error('telp')
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-edit-field">

                                            <label class="research-edit-label">
                                                Alamat
                                            </label>

                                            <input type="text" name="alamat" class="research-edit-input"
                                                placeholder="Masukkan alamat" value="{{ $penelitian->alamat }}">

                                            @error('alamat')
                                                <span class="research-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                    </div>

                                </div>

                            </section>


                            {{-- =====================================================
                             MEMBERS
                        ====================================================== --}}

                            <section class="research-edit-team">

                                <div class="research-edit-team-head">

                                    <div class="research-edit-team-title">

                                        <span class="research-edit-team-icon">
                                            <i class="fas fa-users"></i>
                                        </span>

                                        <div>

                                            <strong>
                                                Anggota Penelitian
                                            </strong>

                                            <span>
                                                Kelola anggota yang terlibat dalam laporan penelitian.
                                            </span>

                                        </div>

                                    </div>


                                    <button type="button" onclick="addAnggota()" class="research-edit-add-member">
                                        <i class="fas fa-plus"></i>
                                        Tambah Anggota
                                    </button>

                                </div>


                                <div id="anggota-wrapper" class="research-edit-member-list">

                                    @forelse($penelitian->anggotap3m as $i => $anggota)
                                        <div class="research-edit-member-card anggota-row">

                                            <div class="research-edit-member-head">

                                                <span class="research-edit-member-label">

                                                    <span class="research-edit-member-index">
                                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                    </span>

                                                    Identitas Anggota

                                                </span>


                                                <button type="button" class="research-edit-remove remove-anggota"
                                                    aria-label="Hapus anggota dari form" title="Hapus anggota dari form">
                                                    <i class="fas fa-times"></i>
                                                </button>

                                            </div>


                                            <div class="research-edit-member-grid">

                                                <div class="research-edit-field">

                                                    <label class="research-edit-label">
                                                        Nama
                                                    </label>

                                                    <input type="text" class="research-edit-input"
                                                        name="anggota[{{ $i }}][nama]"
                                                        placeholder="Nama anggota" value="{{ $anggota->nama }}">

                                                    @error("anggota.$i.nama")
                                                        <span class="research-edit-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="research-edit-field">

                                                    <label class="research-edit-label">
                                                        Program Studi
                                                    </label>

                                                    <select class="research-edit-select"
                                                        name="anggota[{{ $i }}][prodi]">

                                                        <option value="">
                                                            --- Pilih ---
                                                        </option>

                                                        <option value="R"
                                                            {{ $anggota->prodi == 'R' ? 'selected' : '' }}>
                                                            Rekayasa Perangkat Lunak
                                                        </option>

                                                        <option value="A"
                                                            {{ $anggota->prodi == 'A' ? 'selected' : '' }}>
                                                            Administrasi Bisnis Internasional
                                                        </option>

                                                        <option value="AK"
                                                            {{ $anggota->prodi == 'AK' ? 'selected' : '' }}>
                                                            Akutansi Keuangan Publik
                                                        </option>

                                                        <option value="AB"
                                                            {{ $anggota->prodi == 'AB' ? 'selected' : '' }}>
                                                            Bisnis Digital
                                                        </option>

                                                        <option value="AP"
                                                            {{ $anggota->prodi == 'AP' ? 'selected' : '' }}>
                                                            Agri Bisnis Perternakan
                                                        </option>

                                                    </select>

                                                    @error("anggota.$i.prodi")
                                                        <span class="research-edit-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="research-edit-field">

                                                    <label class="research-edit-label">
                                                        NIM / NIDN
                                                    </label>

                                                    <input type="text" class="research-edit-input"
                                                        name="anggota[{{ $i }}][nim]" placeholder="NIM / NIDN"
                                                        value="{{ $anggota->nim }}">

                                                    @error("anggota.$i.nim")
                                                        <span class="research-edit-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="research-edit-field">

                                                    <label class="research-edit-label">
                                                        Jabatan
                                                    </label>

                                                    <select class="research-edit-select"
                                                        name="anggota[{{ $i }}][jabatan]">

                                                        <option value="">
                                                            --- Pilih ---
                                                        </option>

                                                        <option value="DR"
                                                            {{ $anggota->jabatan == 'DR' ? 'selected' : '' }}>
                                                            Direktur
                                                        </option>

                                                        <option value="LT"
                                                            {{ $anggota->jabatan == 'LT' ? 'selected' : '' }}>
                                                            Wakil Direktur
                                                        </option>

                                                        <option value="KP"
                                                            {{ $anggota->jabatan == 'KP' ? 'selected' : '' }}>
                                                            Ketua Program Studi
                                                        </option>

                                                        <option value="DS"
                                                            {{ $anggota->jabatan == 'DS' ? 'selected' : '' }}>
                                                            Dosen Polibang
                                                        </option>

                                                        <option value="MHS"
                                                            {{ $anggota->jabatan == 'MHS' ? 'selected' : '' }}>
                                                            Mahasiswa
                                                        </option>

                                                    </select>

                                                    @error("anggota.$i.jabatan")
                                                        <span class="research-edit-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>

                                            </div>

                                        </div>

                                    @empty

                                        <div class="research-edit-team-empty">

                                            <span class="research-edit-team-empty-icon">
                                                <i class="fas fa-users-slash"></i>
                                            </span>

                                            <div>

                                                <strong>
                                                    Belum ada anggota
                                                </strong>

                                                <small>
                                                    Tambahkan anggota jika laporan penelitian memiliki tim.
                                                </small>

                                            </div>

                                        </div>
                                    @endforelse

                                </div>

                            </section>

                        </div>


                        <div class="research-edit-footer">

                            <div class="research-edit-footer-note">

                                <i class="fas fa-shield-alt"></i>

                                <span>
                                    Perubahan hanya diterapkan setelah Anda menyimpan laporan.
                                </span>

                            </div>


                            <div class="research-edit-actions">

                                <a href="{{ route('dosen.dash_ajuanpenelitian') }}" class="research-edit-back">
                                    Batal
                                </a>

                                @if (in_array($penelitian->status, ['non-approve', 'tolak'], true))
                                    <button type="submit" class="research-edit-submit research-edit-submit-resubmit">
                                        <i class="fas fa-paper-plane"></i>
                                        Simpan & Ajukan Ulang Proposal
                                    </button>
                                @else
                                    <button type="submit" class="research-edit-submit">
                                        <i class="fas fa-save"></i>
                                        Simpan Perubahan
                                    </button>
                                @endif

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </section>

    </div>


    <script>
        (function() {
            'use strict';

        /*
         * Start after the highest existing numeric member index to prevent
         * duplicate input names when adding new members.
         */
        let count = 0;

        @foreach ($penelitian->anggotap3m as $i => $anggota)
            count = Math.max(
                count,
                {{ is_numeric($i) ? (int) $i + 1 : $loop->iteration }}
            );
        @endforeach


        function updateMemberNumbers() {

            const rows =
                document.querySelectorAll(
                    '#anggota-wrapper .anggota-row'
                );

            rows.forEach(function(row, index) {

                const number =
                    row.querySelector(
                        '.research-edit-member-index'
                    );

                if (number) {
                    number.textContent =
                        String(index + 1).padStart(2, '0');
                }

            });

        }


        function addAnggota() {

            const wrapper =
                document.getElementById(
                    'anggota-wrapper'
                );

            if (!wrapper) {
                return;
            }


            const index = count;


            const html = `
            <div class="research-edit-member-card anggota-row">

                <div class="research-edit-member-head">

                    <span class="research-edit-member-label">

                        <span class="research-edit-member-index">
                            00
                        </span>

                        Identitas Anggota

                    </span>


                    <button
                        type="button"
                        class="research-edit-remove remove-anggota"
                        aria-label="Hapus anggota dari form"
                        title="Hapus anggota dari form"
                    >
                        <i class="fas fa-times"></i>
                    </button>

                </div>


                <div class="research-edit-member-grid">

                    <div class="research-edit-field">

                        <label class="research-edit-label">
                            Nama
                        </label>

                        <input
                            type="text"
                            class="research-edit-input"
                            name="anggota[${index}][nama]"
                            placeholder="Nama anggota"
                        >

                    </div>


                    <div class="research-edit-field">

                        <label class="research-edit-label">
                            Program Studi
                        </label>

                        <select
                            class="research-edit-select"
                            name="anggota[${index}][prodi]"
                        >

                            <option value="">
                                --- Pilih ---
                            </option>

                            <option value="R">
                                Rekayasa Perangkat Lunak
                            </option>

                            <option value="A">
                                Administrasi Bisnis Internasional
                            </option>

                            <option value="AK">
                                Akutansi Keuangan Publik
                            </option>

                            <option value="AB">
                                Bisnis Digital
                            </option>

                            <option value="AP">
                                Agri Bisnis Perternakan
                            </option>

                        </select>

                    </div>


                    <div class="research-edit-field">

                        <label class="research-edit-label">
                            NIM / NIDN
                        </label>

                        <input
                            type="text"
                            class="research-edit-input"
                            name="anggota[${index}][nim]"
                            placeholder="NIM / NIDN"
                        >

                    </div>


                    <div class="research-edit-field">

                        <label class="research-edit-label">
                            Jabatan
                        </label>

                        <select
                            class="research-edit-select"
                            name="anggota[${index}][jabatan]"
                        >

                            <option value="">
                                --- Pilih ---
                            </option>

                            <option value="DR">
                                Direktur
                            </option>

                            <option value="LT">
                                Wakil Direktur
                            </option>

                            <option value="KP">
                                Ketua Program Studi
                            </option>

                            <option value="DS">
                                Dosen Polibang
                            </option>

                            <option value="MHS">
                                Mahasiswa
                            </option>

                        </select>

                    </div>

                </div>

            </div>
        `;


            wrapper.insertAdjacentHTML(
                'beforeend',
                html
            );


            count++;

            updateMemberNumbers();

        }


        document.addEventListener(
            'click',
            function(event) {

                const removeButton =
                    event.target.closest(
                        '.remove-anggota'
                    );

                if (!removeButton) {
                    return;
                }


                const row =
                    removeButton.closest(
                        '.anggota-row'
                    );

                if (!row) {
                    return;
                }


                row.remove();

                updateMemberNumbers();

            }
        );


        const uploadInput =
            document.getElementById(
                'uploadLaporanPenelitian'
            );

        const uploadName =
            document.getElementById(
                'uploadLaporanPenelitianName'
            );


        if (uploadInput && uploadName) {

            uploadInput.addEventListener(
                'change',
                function(event) {

                    const file =
                        event.target.files &&
                        event.target.files[0];

                    uploadName.textContent =
                        file ?
                        'File baru: ' + file.name :
                        'Biarkan kosong jika file tidak ingin diganti. Hanya PDF · Maks. 5 MB.';

                }
            );

        }


        window.updateMemberNumbers = updateMemberNumbers;
        window.addAnggota = addAnggota;

        document.addEventListener(
            'DOMContentLoaded',
            function() {
                updateMemberNumbers();
            }
        );
        document.addEventListener(
            'turbo:load',
            function() {
                updateMemberNumbers();
            }
        );
    })();
    </script>

@endsection
