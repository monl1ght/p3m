@extends('layout.doslayout')

@section('body_class', 'page-dosen-editp3m')

@section('css')
    <style>
        /* =========================================================================
                   P3M DOSEN — EDIT PROPOSAL PENGABDIAN
                   Frontend redesign only.
                   Backend route, HTTP method, field names, existing values and member
                   array structure are preserved from the original edit form.
                   ========================================================================= */

        :root {
            --editp3m-forest: #003d2d;
            --editp3m-forest-deep: #002e22;
            --editp3m-forest-mid: #00573b;
            --editp3m-forest-soft: #eaf5ee;
            --editp3m-gold: #b99835;

            --editp3m-ink: #0d1f1a;
            --editp3m-ink-2: #1e3328;
            --editp3m-text: #3b4f47;
            --editp3m-muted: #6b7f78;
            --editp3m-light: #9caaa4;

            --editp3m-border: #e4ede8;
            --editp3m-border-2: #d3e0d9;

            --editp3m-surface: #ffffff;
            --editp3m-surface-alt: #f7faf8;

            --editp3m-danger: #d94b4b;
            --editp3m-danger-soft: #fef2f2;
            --editp3m-danger-border: #f5c0c0;

            --editp3m-radius-sm: 8px;
            --editp3m-radius-md: 12px;
            --editp3m-radius-lg: 16px;
            --editp3m-radius-xl: 20px;
            --editp3m-radius-2xl: 24px;
        }

        /* -------------------------------------------------------------------------
                   PAGE
                   ------------------------------------------------------------------------- */

        .page-dosen-editp3m .content-wrapper {
            min-height: calc(100vh - 66px);

            background:
                radial-gradient(ellipse 70% 40% at 100% 0%,
                    rgba(0, 93, 59, .06),
                    transparent),
                linear-gradient(180deg,
                    #f2f8f5 0%,
                    #f7faf8 100%) !important;
        }

        .editp3m-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-editp3m .content-header {
            padding: 26px 0 10px !important;
        }

        .page-dosen-editp3m .content {
            padding: 6px 0 36px !important;
        }

        /* -------------------------------------------------------------------------
                   PAGE HEADING
                   ------------------------------------------------------------------------- */

        .editp3m-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .editp3m-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 9px;

            color: var(--editp3m-forest-mid);

            font-size: 10.5px;
            font-weight: 800;

            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .editp3m-eyebrow::before {
            content: "";

            width: 20px;
            height: 2.5px;

            border-radius: 99px;

            background: var(--editp3m-gold);
        }

        .editp3m-heading h1 {
            margin: 0;

            color: var(--editp3m-ink);

            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: clamp(28px, 3vw, 36px);
            line-height: 1.12;
            font-weight: 800;

            letter-spacing: -.045em;
        }

        .editp3m-heading p {
            margin: 7px 0 0;

            color: var(--editp3m-muted);

            font-size: 12.5px;
            line-height: 1.55;
        }

        .editp3m-breadcrumb {
            margin: 0;
            padding: 0;

            background: transparent;

            font-size: 12px;
            font-weight: 600;

            white-space: nowrap;
        }

        .editp3m-breadcrumb a {
            color: var(--editp3m-forest);
            text-decoration: none;
        }

        .editp3m-breadcrumb .active {
            color: var(--editp3m-muted);
        }

        .editp3m-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "/";

            padding: 0 8px;

            color: var(--editp3m-border-2);
        }

        /* -------------------------------------------------------------------------
                   CARD
                   ------------------------------------------------------------------------- */

        .editp3m-card {
            overflow: hidden;

            border: 1px solid var(--editp3m-border);
            border-radius: var(--editp3m-radius-2xl);

            background: var(--editp3m-surface);

            box-shadow:
                0 20px 56px rgba(3, 50, 33, .12),
                0 4px 12px rgba(0, 0, 0, .06);
        }

        .editp3m-card-head {
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

            border-bottom: 1px solid var(--editp3m-border);
        }

        .editp3m-card-head::after {
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

        .editp3m-title-group {
            position: relative;
            z-index: 1;
        }

        .editp3m-card-title {
            margin: 0;

            color: var(--editp3m-ink);

            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 18px;
            line-height: 1.25;
            font-weight: 800;

            letter-spacing: -.025em;
        }

        .editp3m-card-subtitle {
            margin: 5px 0 0;

            color: var(--editp3m-muted);

            font-size: 11.5px;
            line-height: 1.45;
        }

        .editp3m-state-chip {
            position: relative;
            z-index: 1;

            display: inline-flex;
            align-items: center;

            gap: 7px;

            padding: 8px 12px;

            border: 1px solid var(--editp3m-border);
            border-radius: var(--editp3m-radius-md);

            background: rgba(255, 255, 255, .78);

            color: var(--editp3m-forest-mid);

            font-size: 10px;
            font-weight: 800;

            white-space: nowrap;
        }

        .editp3m-state-chip i {
            font-size: 11px;
        }

        /* -------------------------------------------------------------------------
                   BODY / SECTION
                   ------------------------------------------------------------------------- */

        .editp3m-card-body {
            padding: 28px 30px 8px;
        }

        .editp3m-section {
            margin-bottom: 28px;
        }

        .editp3m-section-head {
            display: flex;
            align-items: center;
            gap: 11px;

            margin-bottom: 18px;
        }

        .editp3m-section-head .editp3m-section-number {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: #eef6f1;
            color: var(--editp3m-forest);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            margin: 0; /* Reset margin from generic span */
        }

        .editp3m-section-head strong {
            display: block;

            color: var(--editp3m-ink-2);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            line-height: 1.2;
            font-weight: 800;
        }

        .editp3m-section-head span {
            display: block;

            margin-top: 3px;

            color: var(--editp3m-muted);

            font-size: 10px;
            line-height: 1.35;
        }

        .editp3m-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr) minmax(0, 1fr);

            gap: 30px;
        }

        .editp3m-column {
            min-width: 0;

            padding: 0 2px;
        }

        .editp3m-column+.editp3m-column {
            padding-left: 28px;

            border-left: 1px solid #eaf0ed;
        }

        .editp3m-field {
            margin-bottom: 18px;
        }

        .editp3m-field:last-child {
            margin-bottom: 0;
        }

        .editp3m-label {
            display: block;

            margin-bottom: 7px;

            color: var(--editp3m-ink-2);

            font-size: 11px;
            line-height: 1.3;
            font-weight: 800;
        }

        .editp3m-label .req {
            margin-left: 2px;
            color: var(--editp3m-danger);
        }

        .editp3m-input,
        .editp3m-select {
            width: 100%;
            min-height: 42px;

            padding: 9px 12px;

            border: 1px solid var(--editp3m-border-2);
            border-radius: var(--editp3m-radius-md);

            outline: none;

            background: #fff;
            color: var(--editp3m-ink);

            font-family: inherit;
            font-size: 12px;
            font-weight: 500;

            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .editp3m-input::placeholder {
            color: var(--editp3m-light);
        }

        .editp3m-input:hover,
        .editp3m-select:hover {
            border-color: #c5d6cd;
        }

        .editp3m-input:focus,
        .editp3m-select:focus {
            border-color: var(--editp3m-forest-mid);

            background: #fff;

            box-shadow:
                0 0 0 3px rgba(0, 87, 59, .09);
        }

        .editp3m-input[readonly] {
            background: #f4f7f6;
            color: #667a72;
            cursor: default;
        }

        .editp3m-input[type="date"] {
            color-scheme: light;
        }

        .editp3m-help {
            display: block;

            margin-top: 6px;

            color: var(--editp3m-light);

            font-size: 9.5px;
            line-height: 1.4;
        }

        .editp3m-error {
            display: flex;
            align-items: flex-start;
            gap: 6px;

            margin-top: 6px;

            color: var(--editp3m-danger);

            font-size: 10px;
            line-height: 1.4;
        }

        .editp3m-error i {
            margin-top: 1px;

            font-size: 9px;
        }

        /* -------------------------------------------------------------------------
                   DATES
                   ------------------------------------------------------------------------- */

        .editp3m-date-group {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr) auto minmax(0, 1fr);

            gap: 8px;

            align-items: center;
        }

        .editp3m-date-separator {
            color: var(--editp3m-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        /* -------------------------------------------------------------------------
                   EXISTING FILE
                   ------------------------------------------------------------------------- */

        .editp3m-file-wrap {
            display: flex;
            flex-direction: column;

            gap: 8px;
        }

        .editp3m-current-file {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            padding: 11px 12px;

            border: 1px solid var(--editp3m-border);
            border-radius: var(--editp3m-radius-md);

            background: var(--editp3m-surface-alt);
        }

        .editp3m-current-file-copy {
            display: flex;
            align-items: center;

            gap: 9px;

            min-width: 0;
        }

        .editp3m-file-icon {
            width: 31px;
            height: 31px;
            flex: 0 0 31px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: var(--editp3m-forest-soft);
            color: var(--editp3m-forest-mid);

            font-size: 12px;
        }

        .editp3m-file-name {
            min-width: 0;
            overflow: hidden;

            color: var(--editp3m-text);

            font-size: 10.5px;
            font-weight: 700;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .editp3m-file-status {
            flex: 0 0 auto;

            padding: 5px 8px;

            border-radius: 999px;

            background: #eef6f1;
            color: var(--editp3m-forest);

            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }

        .editp3m-file-input {
            position: absolute;

            width: 1px;
            height: 1px;

            opacity: 0;
            overflow: hidden;
        }

        .editp3m-file-picker {
            display: flex;
            align-items: center;
            justify-content: center;

            min-height: 38px;

            padding: 0 12px;

            border: 1px dashed #bfd4c8;
            border-radius: 10px;

            background: #fbfdfc;
            color: var(--editp3m-forest);

            font-size: 10px;
            font-weight: 800;

            cursor: pointer;

            transition: .18s ease;
        }

        .editp3m-file-picker:hover {
            background: var(--editp3m-forest-soft);
            border-color: #9fbead;

            transform: translateY(-1px);
        }

        /* -------------------------------------------------------------------------
                   TEAM MEMBERS
                   ------------------------------------------------------------------------- */

        .editp3m-team-section {
            padding-top: 23px;

            border-top: 1px solid #eaf0ed;
        }

        .editp3m-team-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            margin-bottom: 14px;
        }

        .editp3m-team-title {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .editp3m-team-title>i {
            width: 32px;
            height: 32px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: #eef6f1;
            color: var(--editp3m-forest);

            font-size: 12px;
        }

        .editp3m-team-title strong {
            color: var(--editp3m-ink-2);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .editp3m-team-title span {
            display: block;

            margin-top: 2px;

            color: var(--editp3m-muted);

            font-size: 9.5px;
        }

        .editp3m-add-member {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            min-height: 34px;

            padding: 0 11px;

            border: 1px solid #c7ddd0;
            border-radius: 9px;

            background: #fff;
            color: var(--editp3m-forest);

            font-size: 10px;
            font-weight: 800;

            cursor: pointer;

            transition: .18s ease;
        }

        .editp3m-add-member:hover {
            background: var(--editp3m-forest-soft);
            border-color: #aec9bb;

            transform: translateY(-1px);
        }

        .editp3m-member-list {
            display: flex;
            flex-direction: column;

            gap: 10px;
        }

        .editp3m-member-card {
            padding: 15px 16px;

            border: 1px solid var(--editp3m-border);
            border-radius: 14px;

            background: #fbfdfc;

            transition:
                border-color .18s ease,
                box-shadow .18s ease;
        }

        .editp3m-member-card:hover {
            border-color: #d5e3dc;

            box-shadow:
                0 7px 20px rgba(7, 62, 45, .04);
        }

        .editp3m-member-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-bottom: 13px;
        }

        .editp3m-member-label {
            display: flex;
            align-items: center;

            gap: 8px;

            color: var(--editp3m-ink-2);

            font-size: 11px;
            font-weight: 800;
        }

        .editp3m-member-index {
            width: 23px;
            height: 23px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 7px;

            background: #eaf5ee;
            color: var(--editp3m-forest);

            font-size: 9px;
            font-weight: 800;
        }

        .editp3m-remove-member {
            width: 28px;
            height: 28px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--editp3m-danger-border);
            border-radius: 8px;

            background: var(--editp3m-danger-soft);
            color: var(--editp3m-danger);

            font-size: 10px;

            cursor: pointer;

            transition: .18s ease;
        }

        .editp3m-remove-member:hover {
            background: #fdeaea;

            transform: translateY(-1px);
        }

        .editp3m-member-grid {
            display: grid;

            grid-template-columns:
                1.15fr 1fr .85fr .95fr;

            gap: 12px;
        }

        /* -------------------------------------------------------------------------
                   EMPTY TEAM STATE
                   ------------------------------------------------------------------------- */

        .editp3m-team-empty {
            display: flex;
            align-items: center;

            gap: 11px;

            padding: 13px;

            color: var(--editp3m-muted);
        }

        .editp3m-team-empty>span {
            width: 34px;
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: #eef6f1;
            color: var(--editp3m-forest-mid);

            font-size: 12px;
        }

        .editp3m-team-empty strong {
            display: block;

            color: var(--editp3m-ink-2);

            font-size: 11px;
            font-weight: 800;
        }

        .editp3m-team-empty small {
            display: block;

            margin-top: 2px;

            color: var(--editp3m-muted);

            font-size: 9.5px;
        }

        /* -------------------------------------------------------------------------
                   FOOTER
                   ------------------------------------------------------------------------- */

        .editp3m-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 18px;

            padding: 17px 30px;

            border-top: 1px solid var(--editp3m-border);

            background: var(--editp3m-surface-alt);
        }

        .editp3m-footer-note {
            display: inline-flex;
            align-items: center;

            gap: 8px;

            color: var(--editp3m-muted);

            font-size: 10px;
            line-height: 1.4;
        }

        .editp3m-footer-note i {
            color: var(--editp3m-forest-mid);
        }

        .editp3m-actions {
            display: flex;
            align-items: center;

            gap: 9px;
        }

        .editp3m-back {
            min-height: 41px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 14px;

            border: 1px solid var(--editp3m-border-2);
            border-radius: var(--editp3m-radius-md);

            background: #fff;
            color: var(--editp3m-text);

            font-size: 10.5px;
            font-weight: 700;

            text-decoration: none !important;

            transition: .18s ease;
        }

        .editp3m-back:hover {
            background: #f4f8f6;
            color: var(--editp3m-ink-2);

            transform: translateY(-1px);
        }

        .editp3m-submit {
            min-height: 41px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 0 16px;

            border: 1px solid var(--editp3m-forest);
            border-radius: var(--editp3m-radius-md);

            background: var(--editp3m-forest);
            color: #fff;

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 6px 16px rgba(0, 61, 45, .18);

            transition: .18s ease;
        }

        .editp3m-submit:hover {
            background: var(--editp3m-forest-deep);
            border-color: var(--editp3m-forest-deep);

            transform: translateY(-1px);

            box-shadow:
                0 9px 20px rgba(0, 61, 45, .23);
        }

        .editp3m-submit-resubmit {
            background: linear-gradient(135deg, #00573b 0%, #003d2d 100%);
            border-color: #003d2d;
            box-shadow: 0 6px 18px rgba(0, 87, 59, .28);
        }

        .editp3m-submit-resubmit:hover {
            background: linear-gradient(135deg, #00452f 0%, #002e22 100%);
            box-shadow: 0 8px 22px rgba(0, 87, 59, .35);
        }

        /* Revision Alert Box */
        .editp3m-revision-alert {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 18px 22px;
            margin-bottom: 24px;
            border-radius: var(--editp3m-radius-md);
            background: linear-gradient(135deg, #fff5f5 0%, #fef2f2 100%);
            border: 1.5px solid #fecdd3;
            box-shadow: 0 4px 16px rgba(225, 29, 72, .07);
        }

        .editp3m-revision-icon {
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

        .editp3m-revision-body {
            flex: 1;
            min-width: 0;
        }

        .editp3m-revision-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }

        .editp3m-revision-title strong {
            font-size: 14.5px;
            font-weight: 800;
            color: #881337;
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .editp3m-revision-date {
            font-size: 12px;
            font-weight: 600;
            color: #9f1239;
        }

        .editp3m-revision-content {
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

        .editp3m-revision-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 12px;
            color: #64748b;
        }

        .editp3m-revision-meta strong {
            color: #334155;
        }

        .editp3m-revision-tip {
            color: #00573b;
            font-weight: 600;
        }

        /* -------------------------------------------------------------------------
                   RESPONSIVE
                   ------------------------------------------------------------------------- */

        @media (max-width: 991.98px) {

            .editp3m-shell {
                width: calc(100% - 34px);
            }

            .editp3m-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            .editp3m-grid {
                grid-template-columns: 1fr;

                gap: 0;
            }

            .editp3m-column+.editp3m-column {
                padding-left: 0;
                padding-top: 24px;

                border-left: 0;
                border-top: 1px solid #eaf0ed;
            }

            .editp3m-member-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {

            .editp3m-shell {
                width: calc(100% - 24px);
            }

            .editp3m-card {
                border-radius: var(--editp3m-radius-lg);
            }

            .editp3m-card-head {
                align-items: flex-start;
                flex-direction: column;

                padding: 20px 19px 17px;
            }

            .editp3m-card-body {
                padding: 22px 19px 7px;
            }

            .editp3m-card-footer {
                align-items: stretch;
                flex-direction: column;

                padding: 15px 19px 18px;
            }

            .editp3m-actions {
                width: 100%;
            }

            .editp3m-back,
            .editp3m-submit {
                flex: 1;
            }

            .editp3m-team-toolbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .editp3m-add-member {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 575.98px) {

            .editp3m-shell {
                width: calc(100% - 18px);
            }

            .editp3m-heading h1 {
                font-size: 28px;
            }

            .editp3m-date-group {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .editp3m-date-separator {
                text-align: center;
            }

            .editp3m-member-grid {
                grid-template-columns: 1fr;
            }

            .editp3m-current-file {
                align-items: flex-start;
                flex-direction: column;
            }

            .editp3m-file-status {
                align-self: flex-start;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .page-dosen-editp3m *,
            .page-dosen-editp3m *::before,
            .page-dosen-editp3m *::after {
                transition: none !important;
            }
        }
    </style>
@endsection


@section('content')

    <div class="content-wrapper">

        <div class="content-header">

            <div class="editp3m-shell">

                <div class="editp3m-heading">

                    <div>
                        <span class="editp3m-eyebrow">
                            Pengabdian Masyarakat
                        </span>

                        <h1>
                            {{ $pagetitle }}
                        </h1>
                    </div>


                    <ol class="breadcrumb editp3m-breadcrumb">

                        <li class="breadcrumb-item">
                            <a href="{{ route('dosen.upp3m') }}">
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

            <div class="editp3m-shell">

                <form action="{{ route('dosen.updatep3m', ['id' => $penelitian->id]) }}" method="post"
                    enctype="multipart/form-data" id="editp3mForm">

                    @csrf

                    {{-- Preserve the original request ID contract for the update action. --}}
                    <input type="hidden" name="id" value="{{ $penelitian->id }}">

                    <div class="editp3m-card">

                        <div class="editp3m-card-head">

                            <div class="editp3m-title-group">

                                <h2 class="editp3m-card-title">
                                    P3M Polibang Jepara
                                </h2>

                                <p class="editp3m-card-subtitle">
                                    Edit data proposal pengabdian masyarakat yang tersimpan.
                                </p>

                            </div>

                            <div class="editp3m-state-chip">
                                <i class="fas fa-edit"></i>
                                Mode Edit
                            </div>

                        </div>


                        <div class="editp3m-card-body">

                            {{-- Revision Alert Banner --}}
                            @if (in_array($penelitian->status, ['non-approve', 'tolak'], true) && !empty($latestRejection?->reason))
                                <div class="editp3m-revision-alert">
                                    <div class="editp3m-revision-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="editp3m-revision-body">
                                        <div class="editp3m-revision-title">
                                            <strong><i class="fas fa-comment-dots mr-1"></i> Catatan Revisi dari Reviewer / Admin P3M</strong>
                                            @if ($latestRejection->decided_at)
                                                <span class="editp3m-revision-date">
                                                    <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($latestRejection->decided_at)->translatedFormat('d F Y, H:i') }} WIB
                                                </span>
                                            @endif
                                        </div>
                                        <div class="editp3m-revision-content">"{{ $latestRejection->reason }}"</div>
                                        <div class="editp3m-revision-meta">
                                            <span><i class="fas fa-user-shield text-danger mr-1"></i> Direview oleh: <strong>{{ $latestRejection->decisionMaker?->name ?? 'Admin P3M' }}</strong></span>
                                            <span class="editp3m-revision-tip"><i class="fas fa-info-circle mr-1"></i> Silakan periksa dan perbaiki poin-poin di atas pada isian form atau file lampiran, lalu klik <strong>"Simpan & Ajukan Ulang Proposal"</strong> di bagian bawah untuk mengajukan kembali ke P3M.</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- =====================================================
                             PROPOSAL + CHAIR
                        ====================================================== --}}

                            <section class="editp3m-section">

                                <div class="editp3m-section-head">

                                    <span class="editp3m-section-number">
                                        01
                                    </span>

                                    <div>
                                        <strong>Informasi Proposal</strong>

                                        <span>
                                            Perbarui detail utama pengabdian masyarakat dan data ketua.
                                        </span>
                                    </div>

                                </div>


                                <div class="editp3m-grid">

                                    {{-- Left column --}}
                                    <div class="editp3m-column">

                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Judul Pengabdian
                                                <span class="req">*</span>
                                            </label>

                                            <input type="text" name="judul" class="editp3m-input"
                                                placeholder="Masukkan judul pengabdian" value="{{ $penelitian->judul }}">

                                            @error('judul')
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Bidang Ilmu
                                                <span class="req">*</span>
                                            </label>

                                            <input type="text" name="bidang" class="editp3m-input"
                                                placeholder="Masukkan bidang ilmu" value="{{ $penelitian->bidang }}">

                                            @error('bidang')
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Kategori
                                            </label>

                                            <input type="text" class="editp3m-input" name="jeniskategori"
                                                value="Proposal Pengabdian Masyarakat" readonly>

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Lokasi
                                                <span class="req">*</span>
                                            </label>

                                            <input type="text" name="lokasi" class="editp3m-input"
                                                placeholder="Masukkan lokasi pengabdian" value="{{ $penelitian->lokasi }}">

                                            @error('lokasi')
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Lama Pelaksanaan
                                            </label>

                                            <div class="editp3m-date-group">

                                                <input type="date" name="tanggal_mulai" class="editp3m-input"
                                                    value="{{ $penelitian->tanggal_mulai }}" required>

                                                <span class="editp3m-date-separator">
                                                    <i class="fas fa-minus"></i>
                                                </span>

                                                <input type="date" name="tanggal_selesai" class="editp3m-input"
                                                    value="{{ $penelitian->tanggal_selesai }}" required>

                                            </div>

                                            @if ($errors->has('tanggal_mulai') || $errors->has('tanggal_selesai'))
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>

                                                    {{ $errors->first('tanggal_mulai') ?: $errors->first('tanggal_selesai') }}
                                                </span>
                                            @endif

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Biaya
                                            </label>

                                            <input type="number" name="biaya" class="editp3m-input"
                                                placeholder="Contoh: 1500000" min="0" step="any"
                                                value="{{ $penelitian->biaya }}">

                                            <span class="editp3m-help">
                                                Contoh penulisan nominal: 1500000.
                                            </span>

                                            @error('biaya')
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Unggah Laporan
                                            </label>

                                            <div class="editp3m-file-wrap">

                                                @if ($penelitian->uppdf)
                                                    <div class="editp3m-current-file">

                                                        <div class="editp3m-current-file-copy">

                                                            <span class="editp3m-file-icon">
                                                                <i class="fas fa-file-pdf"></i>
                                                            </span>

                                                            <span class="editp3m-file-name"
                                                                title="{{ $penelitian->uppdf }}">
                                                                {{ $penelitian->uppdf }}
                                                            </span>

                                                        </div>

                                                        <span class="editp3m-file-status">
                                                            File saat ini
                                                        </span>

                                                    </div>
                                                @endif


                                                <input type="file" name="uppdf" class="editp3m-file-input"
                                                    id="uploadLaporan" accept=".pdf,application/pdf"
                                                    data-p3m-upload-preserve-accept
                                                    data-p3m-upload-name-id="uploadLaporanName">

                                                <label for="uploadLaporan" class="editp3m-file-picker">
                                                    <span>
                                                        <i class="fas fa-upload mr-1"></i>
                                                        Pilih file baru
                                                    </span>
                                                </label>

                                                <span class="editp3m-help" id="uploadLaporanName">
                                                    Biarkan kosong jika file tidak ingin diganti.
                                                    Hanya PDF · Maks. 5 MB.
                                                </span>

                                            </div>

                                            @error('uppdf')
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- Right column --}}
                                    <div class="editp3m-column">

                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Nama Ketua
                                                <span class="req">*</span>
                                            </label>

                                            <input type="text" name="ketua" class="editp3m-input"
                                                placeholder="Masukkan nama ketua" value="{{ $penelitian->ketua }}">

                                            @error('ketua')
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Jenis Kelamin
                                            </label>

                                            <select class="editp3m-select" name="jeniskelamin">

                                                <option value="">
                                                    --- Pilih ---
                                                </option>

                                                <option value="L"
                                                    {{ isset($penelitian) && $penelitian->jeniskelamin == 'L' ? 'selected' : '' }}>
                                                    Laki - Laki
                                                </option>

                                                <option value="P"
                                                    {{ isset($penelitian) && $penelitian->jeniskelamin == 'P' ? 'selected' : '' }}>
                                                    Perempuan
                                                </option>

                                            </select>

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                NIDN
                                            </label>

                                            <input type="text" name="nidn" class="editp3m-input"
                                                placeholder="Masukkan NIDN" value="{{ $penelitian->nidn }}">

                                            @error('nidn')
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Jabatan
                                            </label>

                                            <select class="editp3m-select" name="jabatan">

                                                <option value="">
                                                    --- Pilih ---
                                                </option>

                                                <option value="DR"
                                                    {{ isset($penelitian) && $penelitian->jabatan == 'DR' ? 'selected' : '' }}>
                                                    Direktur
                                                </option>

                                                <option value="LT"
                                                    {{ isset($penelitian) && $penelitian->jabatan == 'LT' ? 'selected' : '' }}>
                                                    Wakil Direktur
                                                </option>

                                                <option value="KP"
                                                    {{ isset($penelitian) && $penelitian->jabatan == 'KP' ? 'selected' : '' }}>
                                                    Ketua Program Studi
                                                </option>

                                                <option value="DS"
                                                    {{ isset($penelitian) && $penelitian->jabatan == 'DS' ? 'selected' : '' }}>
                                                    Dosen Polibang
                                                </option>

                                            </select>

                                            @error('jabatan')
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Program Studi
                                            </label>

                                            <select class="editp3m-select" name="prodi">

                                                <option value="">
                                                    --- Pilih ---
                                                </option>

                                                <option value="R"
                                                    {{ isset($penelitian) && $penelitian->prodi == 'R' ? 'selected' : '' }}>
                                                    Rekayasa Perangkat Lunak
                                                </option>

                                                <option value="A"
                                                    {{ isset($penelitian) && $penelitian->prodi == 'A' ? 'selected' : '' }}>
                                                    Administrasi Bisnis Internasional
                                                </option>

                                                <option value="AK"
                                                    {{ isset($penelitian) && $penelitian->prodi == 'AK' ? 'selected' : '' }}>
                                                    Akutansi Keuangan Publik
                                                </option>

                                                <option value="AB"
                                                    {{ isset($penelitian) && $penelitian->prodi == 'AB' ? 'selected' : '' }}>
                                                    Bisnis Digital
                                                </option>

                                                <option value="AP"
                                                    {{ isset($penelitian) && $penelitian->prodi == 'AP' ? 'selected' : '' }}>
                                                    Agre Bisnis Perternakan
                                                </option>

                                            </select>

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                No. Telepon
                                            </label>

                                            <input type="text" name="telp" class="editp3m-input"
                                                placeholder="Masukkan nomor telepon" value="{{ $penelitian->telp }}">

                                            @error('telp')
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="editp3m-field">

                                            <label class="editp3m-label">
                                                Alamat
                                            </label>

                                            <input type="text" name="alamat" class="editp3m-input"
                                                placeholder="Masukkan alamat" value="{{ $penelitian->alamat }}">

                                            @error('alamat')
                                                <span class="editp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                    </div>

                                </div>

                            </section>


                            {{-- =====================================================
                             EXISTING / NEW MEMBERS
                        ====================================================== --}}

                            <section class="editp3m-team-section">

                                <div class="editp3m-team-toolbar">

                                    <div class="editp3m-team-title">

                                        <i class="fas fa-users"></i>

                                        <div>
                                            <strong>Anggota Pengabdian Masyarakat</strong>
                                            <span>
                                                Kelola anggota yang terlibat dalam proposal ini.
                                            </span>
                                        </div>

                                    </div>


                                    <button type="button" onclick="addAnggota()" class="editp3m-add-member">
                                        <i class="fas fa-plus"></i>
                                        Tambah Anggota
                                    </button>

                                </div>


                                <div id="anggota-wrapper" class="editp3m-member-list">

                                    @foreach ($penelitian->anggotap3m as $i => $anggota)
                                        <div class="editp3m-member-card anggota-row">

                                            <div class="editp3m-member-head">

                                                <span class="editp3m-member-label">

                                                    <span class="editp3m-member-index">
                                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                    </span>

                                                    Identitas Anggota

                                                </span>


                                                <button type="button" class="editp3m-remove-member remove-anggota"
                                                    aria-label="Hapus anggota" title="Hapus anggota">
                                                    <i class="fas fa-times"></i>
                                                </button>

                                            </div>


                                            <div class="editp3m-member-grid">

                                                <div class="editp3m-field">

                                                    <label class="editp3m-label">
                                                        Nama
                                                    </label>

                                                    <input type="text" class="editp3m-input"
                                                        name="anggota[{{ $i }}][nama]"
                                                        placeholder="Nama anggota" value="{{ $anggota->nama }}">

                                                    @error("anggota.$i.nama")
                                                        <span class="editp3m-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="editp3m-field">

                                                    <label class="editp3m-label">
                                                        Program Studi
                                                    </label>

                                                    <select class="editp3m-select"
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
                                                            Agre Bisnis Perternakan
                                                        </option>

                                                    </select>

                                                    @error("anggota.$i.prodi")
                                                        <span class="editp3m-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="editp3m-field">

                                                    <label class="editp3m-label">
                                                        NIM / NIDN
                                                    </label>

                                                    <input type="text" class="editp3m-input"
                                                        name="anggota[{{ $i }}][nim]" placeholder="NIM / NIDN"
                                                        value="{{ $anggota->nim }}">

                                                    @error("anggota.$i.nim")
                                                        <span class="editp3m-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="editp3m-field">

                                                    <label class="editp3m-label">
                                                        Jabatan
                                                    </label>

                                                    <select class="editp3m-select"
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
                                                        <span class="editp3m-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>

                                            </div>

                                        </div>
                                    @endforeach


                                </div>

                                @if ($penelitian->anggotap3m->count() === 0)
                                    <div class="editp3m-member-card">

                                        <div class="editp3m-team-empty">
                                            <span>
                                                <i class="fas fa-users-slash"></i>
                                            </span>

                                            <div>
                                                <strong>Belum ada anggota</strong>
                                                <small>
                                                    Tambahkan anggota jika proposal memiliki tim.
                                                </small>
                                            </div>
                                        </div>

                                    </div>
                                @endif

                            </section>

                        </div>


                        <div class="editp3m-card-footer">

                            <div class="editp3m-footer-note">
                                <i class="fas fa-shield-alt"></i>
                                <span>
                                    Perubahan hanya diterapkan setelah Anda menyimpan proposal.
                                </span>
                            </div>


                            <div class="editp3m-actions">

                                <a href="{{ route('dosen.upp3m') }}" class="editp3m-back">
                                    Batal
                                </a>


                                @if (in_array($penelitian->status, ['non-approve', 'tolak'], true))
                                    <button type="submit" class="editp3m-submit editp3m-submit-resubmit">
                                        <i class="fas fa-paper-plane"></i>
                                        Simpan & Ajukan Ulang Proposal
                                    </button>
                                @else
                                    <button type="submit" class="editp3m-submit">
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
             * Member index starts above the highest existing numeric key.
             * This prevents duplicate names when adding a member to an existing edit form.
             */
            let count = 0;

            @foreach ($penelitian->anggotap3m as $i => $anggota)
                count = Math.max(
                    count,
                    {{ is_numeric($i) ? (int) $i + 1 : $loop->iteration }}
                );
            @endforeach


            function updateMemberNumbers() {

                const rows = document.querySelectorAll(
                    '#anggota-wrapper .anggota-row'
                );

                rows.forEach(function(row, index) {

                    const number = row.querySelector(
                        '.editp3m-member-index'
                    );

                    if (number) {
                        number.textContent =
                            String(index + 1).padStart(2, '0');
                    }

                });

            }


            function addAnggota() {

                const wrapper = document.getElementById(
                    'anggota-wrapper'
                );

                if (!wrapper) {
                    return;
                }


                const index = count;

                const html = `
            <div class="editp3m-member-card anggota-row">

                <div class="editp3m-member-head">

                    <span class="editp3m-member-label">

                        <span class="editp3m-member-index">
                            00
                        </span>

                        Identitas Anggota

                    </span>


                    <button
                        type="button"
                        class="editp3m-remove-member remove-anggota"
                        aria-label="Hapus anggota"
                        title="Hapus anggota"
                    >
                        <i class="fas fa-times"></i>
                    </button>

                </div>


                <div class="editp3m-member-grid">

                    <div class="editp3m-field">

                        <label class="editp3m-label">
                            Nama
                        </label>

                        <input
                            type="text"
                            class="editp3m-input"
                            name="anggota[${index}][nama]"
                            placeholder="Nama anggota"
                        >

                    </div>


                    <div class="editp3m-field">

                        <label class="editp3m-label">
                            Program Studi
                        </label>

                        <select
                            class="editp3m-select"
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
                                Agre Bisnis Perternakan
                            </option>

                        </select>

                    </div>


                    <div class="editp3m-field">

                        <label class="editp3m-label">
                            NIM / NIDN
                        </label>

                        <input
                            type="text"
                            class="editp3m-input"
                            name="anggota[${index}][nim]"
                            placeholder="NIM / NIDN"
                        >

                    </div>


                    <div class="editp3m-field">

                        <label class="editp3m-label">
                            Jabatan
                        </label>

                        <select
                            class="editp3m-select"
                            name="anggota[${index}][jabatan]"
                        >

                            <option value="">
                                --- Pilih ---
                            </option>

                            <option value="DR">Direktur</option>
                            <option value="LT">Wakil Direktur</option>
                            <option value="KP">Ketua Program Studi</option>
                            <option value="DS">Dosen Polibang</option>
                            <option value="MHS">Mahasiswa</option>

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

                    if (row) {
                        row.remove();
                        updateMemberNumbers();
                    }

                }
            );


            const uploadInput =
                document.getElementById(
                    'uploadLaporan'
                );

            const uploadName =
                document.getElementById(
                    'uploadLaporanName'
                );


            if (uploadInput && uploadName) {

                uploadInput.addEventListener(
                    'change',
                    function(event) {

                        const file =
                            event.target.files &&
                            event.target.files[0];

                        if (!file) {
                            return;
                        }

                        uploadName.textContent =
                            'File baru: ' + file.name;

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
