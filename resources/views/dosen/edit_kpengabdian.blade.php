@extends('layout.doslayout')

@php
    $latestRejection = $latestRejection ?? null;
@endphp

@section('body_class', 'page-dosen-edit-kpengabdian')

@section('css')

    <style>
        /* =========================================================================
                   P3M DOSEN — EDIT LAPORAN PENGABDIAN
                   UI redesign only.
                   Existing update route, field names, current values, upload fields and
                   dynamic member structure are preserved from the source form.
                   ========================================================================= */

        :root {
            --peng-edit-forest: #003d2d;
            --peng-edit-forest-deep: #002e22;
            --peng-edit-forest-mid: #00573b;
            --peng-edit-forest-soft: #eaf5ee;

            --peng-edit-gold: #b99835;

            --peng-edit-ink: #0d1f1a;
            --peng-edit-ink-2: #1e3328;
            --peng-edit-text: #3b4f47;
            --peng-edit-muted: #6b7f78;
            --peng-edit-light: #9caaa4;

            --peng-edit-border: #e4ede8;
            --peng-edit-border-2: #d3e0d9;

            --peng-edit-surface: #ffffff;
            --peng-edit-surface-alt: #f7faf8;

            --peng-edit-danger: #d94b4b;
            --peng-edit-danger-soft: #fef2f2;
            --peng-edit-danger-border: #f5c0c0;

            --peng-edit-radius-sm: 8px;
            --peng-edit-radius-md: 12px;
            --peng-edit-radius-lg: 16px;
            --peng-edit-radius-2xl: 24px;
        }

        /* -------------------------------------------------------------------------
                   PAGE
                   ------------------------------------------------------------------------- */

        .page-dosen-edit-kpengabdian .content-wrapper {
            min-height: calc(100vh - 66px);

            background:
                radial-gradient(ellipse 70% 40% at 100% 0%,
                    rgba(0, 93, 59, .06),
                    transparent),
                linear-gradient(180deg,
                    #f2f8f5 0%,
                    #f7faf8 100%) !important;
        }

        .peng-edit-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-edit-kpengabdian .content-header {
            padding: 26px 0 10px !important;
        }

        .page-dosen-edit-kpengabdian section.content {
            padding: 6px 0 36px !important;
        }

        /* -------------------------------------------------------------------------
                   PAGE HEADING
                   ------------------------------------------------------------------------- */

        .peng-edit-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 24px;
        }

        .peng-edit-eyebrow {
            display: inline-flex;
            align-items: center;

            gap: 8px;

            margin-bottom: 9px;

            color: var(--peng-edit-forest-mid);

            font-size: 10.5px;
            font-weight: 800;

            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .peng-edit-eyebrow::before {
            content: "";

            width: 20px;
            height: 2.5px;

            border-radius: 99px;

            background: var(--peng-edit-gold);
        }

        .peng-edit-heading h1 {
            margin: 0;

            color: var(--peng-edit-ink);

            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: clamp(28px, 3vw, 36px);
            line-height: 1.12;
            font-weight: 800;

            letter-spacing: -.045em;
        }

        .peng-edit-heading p {
            margin: 7px 0 0;

            color: var(--peng-edit-muted);

            font-size: 12.5px;
            line-height: 1.55;
        }

        .peng-edit-breadcrumb {
            margin: 0;
            padding: 0;

            background: transparent;

            font-size: 12px;
            font-weight: 600;

            white-space: nowrap;
        }

        .peng-edit-breadcrumb a {
            color: var(--peng-edit-forest);
            text-decoration: none;
        }

        .peng-edit-breadcrumb .active {
            color: var(--peng-edit-muted);
        }

        .peng-edit-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "/";

            padding: 0 8px;

            color: var(--peng-edit-border-2);
        }

        /* -------------------------------------------------------------------------
                   CARD
                   ------------------------------------------------------------------------- */

        .peng-edit-card {
            overflow: hidden;

            border: 1px solid var(--peng-edit-border);
            border-radius: var(--peng-edit-radius-2xl);

            background: var(--peng-edit-surface);

            box-shadow:
                0 20px 56px rgba(3, 50, 33, .12),
                0 4px 12px rgba(0, 0, 0, .06);
        }

        .peng-edit-card-head {
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

            border-bottom: 1px solid var(--peng-edit-border);
        }

        .peng-edit-card-head::after {
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

        .peng-edit-title-group {
            position: relative;
            z-index: 1;
        }

        .peng-edit-card-title {
            margin: 0;

            color: var(--peng-edit-ink);

            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 18px;
            line-height: 1.25;
            font-weight: 800;

            letter-spacing: -.025em;
        }

        .peng-edit-card-subtitle {
            margin: 5px 0 0;

            color: var(--peng-edit-muted);

            font-size: 11.5px;
            line-height: 1.45;
        }

        .peng-edit-mode {
            position: relative;
            z-index: 1;

            display: inline-flex;
            align-items: center;

            gap: 7px;

            padding: 8px 12px;

            border: 1px solid var(--peng-edit-border);
            border-radius: var(--peng-edit-radius-md);

            background: rgba(255, 255, 255, .78);

            color: var(--peng-edit-forest-mid);

            font-size: 10px;
            font-weight: 800;

            white-space: nowrap;
        }

        .peng-edit-card-body {
            padding: 28px 30px 8px;
        }

        /* -------------------------------------------------------------------------
                   SECTION
                   ------------------------------------------------------------------------- */

        .peng-edit-section {
            margin-bottom: 28px;
        }

        .peng-edit-section-head {
            display: flex;
            align-items: center;

            gap: 11px;

            margin-bottom: 18px;
        }

        .peng-edit-section-head .peng-edit-section-number {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: #eef6f1;
            color: var(--peng-edit-forest);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .peng-edit-section-head strong {
            display: block;

            color: var(--peng-edit-ink-2);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            line-height: 1.2;
            font-weight: 800;
        }

        .peng-edit-section-head span {
            display: block;

            margin-top: 3px;

            color: var(--peng-edit-muted);

            font-size: 10px;
            line-height: 1.35;
        }

        /* -------------------------------------------------------------------------
                   TWO-COLUMN FORM
                   ------------------------------------------------------------------------- */

        .peng-edit-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr) minmax(0, 1fr);

            gap: 30px;
        }

        .peng-edit-column {
            min-width: 0;

            padding: 0 2px;
        }

        .peng-edit-column+.peng-edit-column {
            padding-left: 28px;

            border-left: 1px solid #eaf0ed;
        }

        .peng-edit-field {
            margin-bottom: 18px;
        }

        .peng-edit-field:last-child {
            margin-bottom: 0;
        }

        .peng-edit-label {
            display: block;

            margin-bottom: 7px;

            color: var(--peng-edit-ink-2);

            font-size: 11px;
            line-height: 1.3;
            font-weight: 800;
        }

        .peng-edit-label .req {
            margin-left: 2px;

            color: var(--peng-edit-danger);
        }

        .peng-edit-input,
        .peng-edit-select {
            width: 100%;

            min-height: 42px;

            padding: 9px 12px;

            border: 1px solid var(--peng-edit-border-2);
            border-radius: var(--peng-edit-radius-md);

            outline: none;

            background: #fff;
            color: var(--peng-edit-ink);

            font-family: inherit;
            font-size: 12px;
            font-weight: 500;

            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .peng-edit-input::placeholder {
            color: var(--peng-edit-light);
        }

        .peng-edit-input:hover,
        .peng-edit-select:hover {
            border-color: #c5d6cd;
        }

        .peng-edit-input:focus,
        .peng-edit-select:focus {
            border-color: var(--peng-edit-forest-mid);

            box-shadow:
                0 0 0 3px rgba(0, 87, 59, .09);
        }

        .peng-edit-input[readonly] {
            background: #f4f7f6;
            color: #667a72;
            cursor: default;
        }

        .peng-edit-help {
            display: block;

            margin-top: 6px;

            color: var(--peng-edit-light);

            font-size: 9.5px;
            line-height: 1.4;
        }

        .peng-edit-error {
            display: flex;
            align-items: flex-start;

            gap: 6px;

            margin-top: 6px;

            color: var(--peng-edit-danger);

            font-size: 10px;
            line-height: 1.4;
        }

        .peng-edit-error i {
            margin-top: 1px;

            font-size: 9px;
        }

        /* -------------------------------------------------------------------------
                   DATE RANGE
                   ------------------------------------------------------------------------- */

        .peng-edit-date-group {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr) auto minmax(0, 1fr);

            gap: 8px;

            align-items: center;
        }

        .peng-edit-date-separator {
            color: var(--peng-edit-muted);

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;
        }

        /* -------------------------------------------------------------------------
                   CURRENT FILE / PHOTO
                   ------------------------------------------------------------------------- */

        .peng-edit-file-wrap {
            display: flex;
            flex-direction: column;

            gap: 8px;
        }

        .peng-edit-current-file {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            min-height: 46px;

            padding: 8px 11px;

            border: 1px solid var(--peng-edit-border);
            border-radius: var(--peng-edit-radius-md);

            background: var(--peng-edit-surface-alt);
        }

        .peng-edit-current-file-copy {
            display: flex;
            align-items: center;

            gap: 9px;

            min-width: 0;
        }

        .peng-edit-file-icon {
            width: 30px;
            height: 30px;
            flex: 0 0 30px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: var(--peng-edit-forest-soft);
            color: var(--peng-edit-forest-mid);

            font-size: 12px;
        }

        .peng-edit-file-name {
            min-width: 0;
            overflow: hidden;

            color: var(--peng-edit-text);

            font-size: 10.5px;
            font-weight: 700;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .peng-edit-file-status {
            flex: 0 0 auto;

            padding: 5px 8px;

            border-radius: 99px;

            background: #eef6f1;
            color: var(--peng-edit-forest);

            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }

        .peng-edit-file-input {
            position: absolute;

            width: 1px;
            height: 1px;

            overflow: hidden;

            opacity: 0;
            pointer-events: none;
        }

        .peng-edit-file-label {
            display: flex;
            align-items: center;
            justify-content: center;

            min-height: 38px;

            padding: 0 12px;

            border: 1px dashed #bfd4c8;
            border-radius: 10px;

            background: #fbfdfc;
            color: var(--peng-edit-forest);

            font-size: 10px;
            font-weight: 800;

            cursor: pointer;

            transition: .18s ease;
        }

        .peng-edit-file-label:hover {
            border-color: #9fbead;
            background: var(--peng-edit-forest-soft);

            transform: translateY(-1px);
        }

        .peng-edit-file-wrap.is-invalid .peng-edit-file-label {
            border-color: var(--peng-edit-danger);
            background: var(--peng-edit-danger-soft);
        }

        .peng-edit-photo-preview {
            width: 110px;
            height: 110px;

            display: block;

            margin-bottom: 2px;

            object-fit: cover;

            border: 4px solid #fff;
            border-radius: 16px;

            box-shadow:
                0 8px 24px rgba(3, 50, 33, .1);

            background: #f1f5f3;
        }

        .peng-edit-photo-empty {
            width: 110px;
            height: 110px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 2px;

            border: 1px dashed #c9d8d0;
            border-radius: 16px;

            background: #f8fbf9;
            color: var(--peng-edit-muted);

            font-size: 24px;
        }

        /* -------------------------------------------------------------------------
                   MEMBERS
                   ------------------------------------------------------------------------- */

        .peng-edit-team {
            padding-top: 23px;

            border-top: 1px solid #eaf0ed;
        }

        .peng-edit-team-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            margin-bottom: 14px;
        }

        .peng-edit-team-title {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .peng-edit-team-title .peng-edit-team-icon {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: #eef6f1;
            color: var(--peng-edit-forest);

            font-size: 12px;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .peng-edit-team-title strong {
            color: var(--peng-edit-ink-2);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .peng-edit-team-title span {
            display: block;

            margin-top: 2px;

            color: var(--peng-edit-muted);

            font-size: 9.5px;
        }

        .peng-edit-add-member {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            min-height: 34px;

            padding: 0 11px;

            border: 1px solid #c7ddd0;
            border-radius: 9px;

            background: #fff;
            color: var(--peng-edit-forest);

            font-size: 10px;
            font-weight: 800;

            cursor: pointer;

            transition: .18s ease;
        }

        .peng-edit-add-member:hover {
            background: var(--peng-edit-forest-soft);
            border-color: #aec9bb;

            transform: translateY(-1px);
        }

        .peng-edit-member-list {
            display: flex;
            flex-direction: column;

            gap: 10px;
        }

        .peng-edit-member-card {
            padding: 15px 16px;

            border: 1px solid var(--peng-edit-border);
            border-radius: 14px;

            background: #fbfdfc;

            transition:
                border-color .18s ease,
                box-shadow .18s ease;
        }

        .peng-edit-member-card:hover {
            border-color: #d5e3dc;

            box-shadow:
                0 7px 20px rgba(7, 62, 45, .04);
        }

        .peng-edit-member-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-bottom: 13px;
        }

        .peng-edit-member-label {
            display: flex;
            align-items: center;

            gap: 8px;

            color: var(--peng-edit-ink-2);

            font-size: 11px;
            font-weight: 800;
        }

        .peng-edit-member-label .peng-edit-member-index {
            width: 23px;
            height: 23px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 7px;

            background: #eaf5ee;
            color: var(--peng-edit-forest);

            font-size: 9px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .peng-edit-remove {
            width: 28px;
            height: 28px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--peng-edit-danger-border);
            border-radius: 8px;

            background: var(--peng-edit-danger-soft);
            color: var(--peng-edit-danger);

            font-size: 10px;

            cursor: pointer;

            transition: .18s ease;
        }

        .peng-edit-remove:hover {
            background: #fdeaea;

            transform: translateY(-1px);
        }

        .peng-edit-member-grid {
            display: grid;

            grid-template-columns:
                1.15fr 1fr .85fr .95fr;

            gap: 12px;
        }

        .peng-edit-team-empty {
            display: flex;
            align-items: center;

            gap: 11px;

            padding: 14px;

            border: 1px dashed var(--peng-edit-border-2);
            border-radius: 13px;

            background: #fbfdfc;
            color: var(--peng-edit-muted);
        }

        .peng-edit-team-empty-icon {
            width: 34px;
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: var(--peng-edit-forest-soft);
            color: var(--peng-edit-forest-mid);

            font-size: 12px;
        }

        .peng-edit-team-empty strong {
            display: block;

            color: var(--peng-edit-ink-2);

            font-size: 11px;
            font-weight: 800;
        }

        .peng-edit-team-empty small {
            display: block;

            margin-top: 2px;

            color: var(--peng-edit-muted);

            font-size: 9.5px;
        }

        /* -------------------------------------------------------------------------
                   FOOTER
                   ------------------------------------------------------------------------- */

        .peng-edit-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 18px;

            padding: 17px 30px;

            border-top: 1px solid var(--peng-edit-border);

            background: var(--peng-edit-surface-alt);
        }

        .peng-edit-footer-note {
            display: inline-flex;
            align-items: center;

            gap: 8px;

            color: var(--peng-edit-muted);

            font-size: 10px;
            line-height: 1.4;
        }

        .peng-edit-footer-note i {
            color: var(--peng-edit-forest-mid);
        }

        .peng-edit-actions {
            display: flex;
            align-items: center;

            gap: 9px;
        }

        .peng-edit-back {
            min-height: 41px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 14px;

            border: 1px solid var(--peng-edit-border-2);
            border-radius: var(--peng-edit-radius-md);

            background: #fff;
            color: var(--peng-edit-text);

            font-size: 10.5px;
            font-weight: 700;

            text-decoration: none !important;

            transition: .18s ease;
        }

        .peng-edit-back:hover {
            background: #f4f8f6;
            color: var(--peng-edit-ink-2);

            transform: translateY(-1px);
        }

        .peng-edit-submit {
            min-height: 41px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 0 17px;

            border: 1px solid var(--peng-edit-forest);
            border-radius: var(--peng-edit-radius-md);

            background: var(--peng-edit-forest);
            color: #fff;

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 6px 16px rgba(0, 61, 45, .18);

            transition: .18s ease;
        }

        .peng-edit-submit:hover {
            background: var(--peng-edit-forest-deep);
            border-color: var(--peng-edit-forest-deep);

            transform: translateY(-1px);

            box-shadow:
                0 9px 20px rgba(0, 61, 45, .23);
        }

        /* -------------------------------------------------------------------------
                   RESPONSIVE
                   ------------------------------------------------------------------------- */

        @media (max-width: 991.98px) {

            .peng-edit-shell {
                width: calc(100% - 34px);
            }

            .peng-edit-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            .peng-edit-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .peng-edit-column+.peng-edit-column {
                padding-left: 0;
                padding-top: 24px;

                border-left: 0;
                border-top: 1px solid #eaf0ed;
            }

            .peng-edit-member-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {

            .peng-edit-shell {
                width: calc(100% - 24px);
            }

            .peng-edit-card {
                border-radius: var(--peng-edit-radius-lg);
            }

            .peng-edit-card-head {
                align-items: flex-start;
                flex-direction: column;

                padding: 20px 19px 17px;
            }

            .peng-edit-card-body {
                padding: 22px 19px 7px;
            }

            .peng-edit-footer {
                align-items: stretch;
                flex-direction: column;

                padding: 15px 19px 18px;
            }

            .peng-edit-actions {
                width: 100%;
            }

            .peng-edit-back,
            .peng-edit-submit {
                flex: 1;
            }

            .peng-edit-team-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .peng-edit-add-member {
                width: 100%;
                justify-content: center;
            }

            .peng-edit-current-file {
                align-items: flex-start;
                flex-direction: column;
            }

            .peng-edit-file-status {
                align-self: flex-start;
            }
        }

        @media (max-width: 575.98px) {

            .peng-edit-shell {
                width: calc(100% - 18px);
            }

            .peng-edit-heading h1 {
                font-size: 28px;
            }

            .peng-edit-date-group {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .peng-edit-date-separator {
                text-align: center;
            }

            .peng-edit-member-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .page-dosen-edit-kpengabdian *,
            .page-dosen-edit-kpengabdian *::before,
            .page-dosen-edit-kpengabdian *::after {
                transition: none !important;
            }
        }
    </style>

@endsection


@section('content')

    <div class="content-wrapper">

        <div class="content-header">

            <div class="peng-edit-shell">

                <div class="peng-edit-heading">

                    <div>

                        <span class="peng-edit-eyebrow">
                            Pengabdian Masyarakat
                        </span>

                        <h1>
                            {{ $pagetitle }}
                        </h1>
                    </div>


                    <ol class="breadcrumb peng-edit-breadcrumb">

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

            <div class="peng-edit-shell">

                <form action="{{ route('dosen.updatekumpulanp3m', ['id' => $penelitian->id]) }}" method="post"
                    enctype="multipart/form-data" id="editKpengabdianForm">

                    @csrf


                    <div class="peng-edit-card">

                        <div class="peng-edit-card-head">

                            <div class="peng-edit-title-group">

                                <h2 class="peng-edit-card-title">
                                    Proposal Pengabdian Masyarakat
                                </h2>

                                <p class="peng-edit-card-subtitle">
                                    Edit informasi laporan pengabdian yang tersimpan.
                                </p>

                            </div>


                            <div class="peng-edit-mode">

                                <i class="fas fa-edit"></i>

                                Mode Edit

                            </div>

                        </div>


                        <div class="peng-edit-card-body">

                            {{-- Revision Alert Banner --}}
                            @if (in_array($penelitian->status, ['non-approve', 'tolak'], true) && !empty($latestRejection?->reason))
                                <div class="peng-edit-revision-alert" style="display: flex; align-items: flex-start; gap: 16px; padding: 18px 22px; margin-bottom: 24px; border-radius: 14px; background: linear-gradient(135deg, #fff5f5 0%, #fef2f2 100%); border: 1.5px solid #fecdd3; box-shadow: 0 4px 16px rgba(225, 29, 72, .07);">
                                    <div class="peng-edit-revision-icon" style="width: 44px; height: 44px; border-radius: 12px; background: #be123c; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(190, 18, 60, .25);">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="peng-edit-revision-body" style="flex: 1; min-width: 0;">
                                        <div class="peng-edit-revision-title" style="display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 8px;">
                                            <strong style="font-size: 14.5px; font-weight: 800; color: #881337; font-family: 'Plus Jakarta Sans', sans-serif;"><i class="fas fa-comment-dots mr-1"></i> Catatan Revisi dari Reviewer / Admin P3M</strong>
                                            @if ($latestRejection->decided_at)
                                                <span class="peng-edit-revision-date" style="font-size: 12px; font-weight: 600; color: #9f1239;">
                                                    <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($latestRejection->decided_at)->translatedFormat('d F Y, H:i') }} WIB
                                                </span>
                                            @endif
                                        </div>
                                        <div class="peng-edit-revision-content" style="padding: 12px 16px; background: #ffffff; border: 1px dashed #fda4af; border-radius: 8px; color: #1f2937; font-size: 13.5px; line-height: 1.6; white-space: pre-wrap; font-weight: 500; margin-bottom: 10px;">"{{ $latestRejection->reason }}"</div>
                                        <div class="peng-edit-revision-meta" style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; color: #64748b;">
                                            <span><i class="fas fa-user-shield text-danger mr-1"></i> Direview oleh: <strong>{{ $latestRejection->decisionMaker?->name ?? 'Admin P3M' }}</strong></span>
                                            <span style="color: #475569;"><i class="fas fa-info-circle mr-1"></i> Silakan periksa dan perbaiki poin-poin di atas pada isian form atau file lampiran, lalu klik <strong>"Simpan & Ajukan Ulang Laporan"</strong> di bagian bawah untuk mengajukan kembali ke P3M.</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- =====================================================
                             INFORMATION
                        ====================================================== --}}

                            <section class="peng-edit-section">

                                <div class="peng-edit-section-head">

                                    <span class="peng-edit-section-number">
                                        01
                                    </span>

                                    <div>
                                        <strong>
                                            Informasi Laporan
                                        </strong>

                                        <span>
                                            Perbarui detail utama laporan pengabdian dan data ketua.
                                        </span>
                                    </div>

                                </div>


                                <div class="peng-edit-grid">

                                    {{-- LEFT --}}
                                    <div class="peng-edit-column">

                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Judul Pengabdian
                                            </label>

                                            <input type="text" name="judul" class="peng-edit-input"
                                                placeholder="Masukkan judul pengabdian" value="{{ $penelitian->judul }}">

                                            @error('judul')
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Bidang Ilmu
                                            </label>

                                            <input type="text" name="bidang" class="peng-edit-input"
                                                placeholder="Masukkan bidang ilmu" value="{{ $penelitian->bidang }}">

                                            @error('bidang')
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Kategori
                                            </label>

                                            <input type="text" name="jeniskategori" class="peng-edit-input"
                                                value="Proposal Pengabdian Masyarakat" readonly>

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Lokasi
                                            </label>

                                            <input type="text" name="lokasi" class="peng-edit-input"
                                                placeholder="Masukkan lokasi pengabdian" value="{{ $penelitian->lokasi }}">

                                            @error('lokasi')
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Lama Pengabdian
                                            </label>

                                            <div class="peng-edit-date-group">

                                                <input type="date" name="tanggal_mulai" class="peng-edit-input"
                                                    value="{{ $penelitian->tanggal_mulai }}" required>

                                                <span class="peng-edit-date-separator">
                                                    <i class="fas fa-minus"></i>
                                                </span>

                                                <input type="date" name="tanggal_selesai" class="peng-edit-input"
                                                    value="{{ $penelitian->tanggal_selesai }}" required>

                                            </div>

                                            @if ($errors->has('tanggal_mulai') || $errors->has('tanggal_selesai'))
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $errors->first('tanggal_mulai') ?: $errors->first('tanggal_selesai') }}
                                                </span>
                                            @endif

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Biaya
                                            </label>

                                            <input type="number" name="biaya" class="peng-edit-input"
                                                placeholder="Contoh: 1500000" min="0" step="any"
                                                value="{{ $penelitian->biaya }}">

                                            <span class="peng-edit-help">
                                                Contoh penulisan nominal: 1500000.
                                            </span>

                                            @error('biaya')
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Unggah Laporan
                                            </label>

                                            <div class="peng-edit-file-wrap">

                                                @if ($penelitian->uppdf)
                                                    <div class="peng-edit-current-file">

                                                        <div class="peng-edit-current-file-copy">

                                                            <span class="peng-edit-file-icon">
                                                                <i class="fas fa-file-pdf"></i>
                                                            </span>

                                                            <span class="peng-edit-file-name"
                                                                title="{{ $penelitian->uppdf }}">
                                                                {{ $penelitian->uppdf }}
                                                            </span>

                                                        </div>


                                                        <span class="peng-edit-file-status">
                                                            File saat ini
                                                        </span>

                                                    </div>
                                                @endif


                                                <input type="file" name="uppdf" class="peng-edit-file-input"
                                                    id="uploadLaporan" accept=".pdf,application/pdf" data-p3m-upload
                                                    data-p3m-upload-label="Dokumen laporan"
                                                    data-p3m-upload-empty-label="Biarkan kosong jika file tidak ingin diganti."
                                                    data-p3m-upload-name-id="uploadLaporanName"
                                                    data-p3m-upload-formats="PDF" data-p3m-upload-extensions="pdf"
                                                    data-p3m-upload-mime-types="application/pdf"
                                                    data-p3m-upload-max-bytes="5242880"
                                                    @if ($errors->has('uppdf')) data-p3m-upload-error="{{ $errors->first('uppdf') }}" @endif>

                                                <label for="uploadLaporan" class="peng-edit-file-label">
                                                    <span>
                                                        <i class="fas fa-upload mr-1"></i>
                                                        Pilih file baru
                                                    </span>
                                                </label>

                                                <span class="peng-edit-help" id="uploadLaporanName">
                                                    Biarkan kosong jika file tidak ingin diganti.
                                                </span>

                                            </div>

                                            @error('uppdf')
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Gambar / Foto
                                            </label>

                                            @if ($penelitian->foto)
                                                <img src="{{ asset('storage/photo-upp3m/' . $penelitian->foto) }}"
                                                    alt="Foto laporan pengabdian saat ini" class="peng-edit-photo-preview"
                                                    id="preview-image">
                                            @else
                                                <div class="peng-edit-photo-empty" id="preview-image-placeholder">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif


                                            <input type="file" name="foto" class="peng-edit-file-input"
                                                id="uploadFoto" accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                                data-p3m-upload data-p3m-upload-label="Foto"
                                                data-p3m-upload-empty-label="Biarkan kosong jika foto tidak ingin diganti. Maks. 2 MB."
                                                data-p3m-upload-name-id="uploadFotoName"
                                                data-p3m-upload-formats="JPG atau PNG"
                                                data-p3m-upload-extensions="jpg,jpeg,png"
                                                data-p3m-upload-mime-types="image/jpeg,image/png"
                                                data-p3m-upload-max-bytes="2097152"
                                                @if ($errors->has('foto')) data-p3m-upload-error="{{ $errors->first('foto') }}" @endif>

                                            <label for="uploadFoto" class="peng-edit-file-label">
                                                <span>
                                                    <i class="fas fa-camera mr-1"></i>
                                                    Pilih foto baru
                                                </span>
                                            </label>

                                            <span class="peng-edit-help" id="uploadFotoName">
                                                Biarkan kosong jika foto tidak ingin diganti. Maks. 2 MB.
                                            </span>

                                            @error('foto')
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- RIGHT --}}
                                    <div class="peng-edit-column">

                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Nama Ketua
                                            </label>

                                            <input type="text" name="ketua" class="peng-edit-input"
                                                placeholder="Masukkan nama ketua" value="{{ $penelitian->ketua }}">

                                            @error('ketua')
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Jenis Kelamin
                                            </label>

                                            <select class="peng-edit-select" name="jeniskelamin">

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


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                NIDN
                                            </label>

                                            <input type="text" name="nidn" class="peng-edit-input"
                                                placeholder="Masukkan NIDN" value="{{ $penelitian->nidn }}">

                                            @error('nidn')
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Jabatan Fungsional
                                            </label>

                                            <select class="peng-edit-select" name="jabatan">

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
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Program Studi
                                            </label>

                                            <select class="peng-edit-select" name="prodi">

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


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                No. Telepon
                                            </label>

                                            <input type="text" name="telp" class="peng-edit-input"
                                                placeholder="Masukkan nomor telepon" value="{{ $penelitian->telp }}">

                                            @error('telp')
                                                <span class="peng-edit-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="peng-edit-field">

                                            <label class="peng-edit-label">
                                                Alamat
                                            </label>

                                            <input type="text" name="alamat" class="peng-edit-input"
                                                placeholder="Masukkan alamat" value="{{ $penelitian->alamat }}">

                                            @error('alamat')
                                                <span class="peng-edit-error">
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

                            <section class="peng-edit-team">

                                <div class="peng-edit-team-head">

                                    <div class="peng-edit-team-title">

                                        <span class="peng-edit-team-icon">
                                            <i class="fas fa-users"></i>
                                        </span>

                                        <div>

                                            <strong>
                                                Anggota Pengabdian Masyarakat
                                            </strong>

                                            <span>
                                                Kelola anggota yang terlibat dalam laporan pengabdian.
                                            </span>

                                        </div>

                                    </div>


                                    <button type="button" onclick="addAnggota()" class="peng-edit-add-member">
                                        <i class="fas fa-plus"></i>
                                        Tambah Anggota
                                    </button>

                                </div>


                                <div id="anggota-wrapper" class="peng-edit-member-list">

                                    @forelse($penelitian->anggotap3m as $i => $anggota)
                                        <div class="peng-edit-member-card anggota-row">

                                            <div class="peng-edit-member-head">

                                                <span class="peng-edit-member-label">

                                                    <span class="peng-edit-member-index">
                                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                    </span>

                                                    Identitas Anggota

                                                </span>


                                                <button type="button" class="peng-edit-remove remove-anggota"
                                                    aria-label="Hapus anggota dari form" title="Hapus anggota dari form">
                                                    <i class="fas fa-times"></i>
                                                </button>

                                            </div>


                                            <div class="peng-edit-member-grid">

                                                <div class="peng-edit-field">

                                                    <label class="peng-edit-label">
                                                        Nama
                                                    </label>

                                                    <input type="text" class="peng-edit-input"
                                                        name="anggota[{{ $i }}][nama]"
                                                        placeholder="Nama anggota" value="{{ $anggota->nama }}">

                                                    @error("anggota.$i.nama")
                                                        <span class="peng-edit-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="peng-edit-field">

                                                    <label class="peng-edit-label">
                                                        Program Studi
                                                    </label>

                                                    <select class="peng-edit-select"
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
                                                        <span class="peng-edit-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="peng-edit-field">

                                                    <label class="peng-edit-label">
                                                        NIM / NIDN
                                                    </label>

                                                    <input type="text" class="peng-edit-input"
                                                        name="anggota[{{ $i }}][nim]" placeholder="NIM / NIDN"
                                                        value="{{ $anggota->nim }}">

                                                    @error("anggota.$i.nim")
                                                        <span class="peng-edit-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="peng-edit-field">

                                                    <label class="peng-edit-label">
                                                        Jabatan
                                                    </label>

                                                    <select class="peng-edit-select"
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
                                                        <span class="peng-edit-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>

                                            </div>

                                        </div>

                                    @empty

                                        <div class="peng-edit-team-empty">

                                            <span class="peng-edit-team-empty-icon">
                                                <i class="fas fa-users-slash"></i>
                                            </span>

                                            <div>

                                                <strong>
                                                    Belum ada anggota
                                                </strong>

                                                <small>
                                                    Tambahkan anggota jika laporan memiliki tim.
                                                </small>

                                            </div>

                                        </div>
                                    @endforelse

                                </div>

                            </section>

                        </div>


                        <div class="peng-edit-footer">

                            <div class="peng-edit-footer-note">

                                <i class="fas fa-shield-alt"></i>

                                <span>
                                    Perubahan hanya diterapkan setelah Anda menyimpan laporan.
                                </span>

                            </div>


                            <div class="peng-edit-actions">

                                <a href="{{ route('dosen.dash_kpengabdian') }}" class="peng-edit-back">
                                    Batal
                                </a>


                                <button type="submit" class="peng-edit-submit">
                                    <i class="fas {{ in_array($penelitian->status, ['non-approve', 'tolak'], true) ? 'fa-paper-plane' : 'fa-save' }}"></i>
                                    {{ in_array($penelitian->status, ['non-approve', 'tolak'], true) ? 'Simpan & Ajukan Ulang Laporan' : 'Simpan Perubahan' }}
                                </button>

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
             * Continue member indexes after the highest existing numeric index.
             * This avoids duplicate input names when adding new members.
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
                            '.peng-edit-member-index'
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
            <div class="peng-edit-member-card anggota-row">

                <div class="peng-edit-member-head">

                    <span class="peng-edit-member-label">

                        <span class="peng-edit-member-index">
                            00
                        </span>

                        Identitas Anggota

                    </span>


                    <button
                        type="button"
                        class="peng-edit-remove remove-anggota"
                        aria-label="Hapus anggota dari form"
                        title="Hapus anggota dari form"
                    >
                        <i class="fas fa-times"></i>
                    </button>

                </div>


                <div class="peng-edit-member-grid">

                    <div class="peng-edit-field">

                        <label class="peng-edit-label">
                            Nama
                        </label>

                        <input
                            type="text"
                            class="peng-edit-input"
                            name="anggota[${index}][nama]"
                            placeholder="Nama anggota"
                        >

                    </div>


                    <div class="peng-edit-field">

                        <label class="peng-edit-label">
                            Program Studi
                        </label>

                        <select
                            class="peng-edit-select"
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


                    <div class="peng-edit-field">

                        <label class="peng-edit-label">
                            NIM / NIDN
                        </label>

                        <input
                            type="text"
                            class="peng-edit-input"
                            name="anggota[${index}][nim]"
                            placeholder="NIM / NIDN"
                        >

                    </div>


                    <div class="peng-edit-field">

                        <label class="peng-edit-label">
                            Jabatan
                        </label>

                        <select
                            class="peng-edit-select"
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

                        uploadName.textContent =
                            file ?
                            'File baru: ' + file.name :
                            'Biarkan kosong jika file tidak ingin diganti.';

                    }
                );

            }


            const photoInput =
                document.getElementById(
                    'uploadFoto'
                );

            const photoName =
                document.getElementById(
                    'uploadFotoName'
                );


            if (photoInput) {

                photoInput.addEventListener(
                    'change',
                    function(event) {

                        const file =
                            event.target.files &&
                            event.target.files[0];

                        if (!file) {
                            if (photoName) {
                                photoName.textContent =
                                    'Biarkan kosong jika foto tidak ingin diganti. Maks. 5 MB.';
                            }

                            return;
                        }


                        if (!file.type.startsWith('image/')) {
                            event.target.value = '';

                            if (photoName) {
                                photoName.textContent =
                                    'Pilih file gambar yang valid.';
                            }

                            return;
                        }


                        if (photoName) {
                            photoName.textContent =
                                'File baru: ' + file.name;
                        }


                        const preview =
                            document.getElementById(
                                'preview-image'
                            );

                        const placeholder =
                            document.getElementById(
                                'preview-image-placeholder'
                            );


                        const reader =
                            new FileReader();


                        reader.onload =
                            function(readerEvent) {

                                if (preview) {

                                    preview.src =
                                        readerEvent.target.result;

                                    preview.style.display =
                                        'block';

                                } else if (placeholder) {

                                    const image =
                                        document.createElement(
                                            'img'
                                        );

                                    image.src =
                                        readerEvent.target.result;

                                    image.alt =
                                        'Pratinjau foto laporan pengabdian';

                                    image.className =
                                        'peng-edit-photo-preview';

                                    image.id =
                                        'preview-image';

                                    placeholder.replaceWith(
                                        image
                                    );

                                }

                            };


                        reader.readAsDataURL(
                            file
                        );

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
