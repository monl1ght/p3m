@extends('layout.doslayout')

@section('body_class', 'page-dosen-add-kpengabdian')

@section('css')

    <style>
        /* =========================================================================
                       P3M DOSEN — TAMBAH LAPORAN PENGABDIAN MASYARAKAT
                       Visual master: Admin P3M / Dosen Proposal pages.
                       Backend contract preserved from the original Blade:
                       route, field names, CSRF, member array structure and dynamic rows.
                       ========================================================================= */

        :root {
            --report-add-forest: #003d2d;
            --report-add-forest-deep: #002e22;
            --report-add-forest-mid: #00573b;
            --report-add-forest-soft: #eaf5ee;

            --report-add-gold: #b99835;
            --report-add-gold-soft: #fdf8ec;

            --report-add-ink: #0d1f1a;
            --report-add-ink-2: #1e3328;
            --report-add-text: #3b4f47;
            --report-add-muted: #6b7f78;
            --report-add-light: #9caaa4;

            --report-add-border: #e4ede8;
            --report-add-border-2: #d3e0d9;

            --report-add-surface: #ffffff;
            --report-add-surface-alt: #f7faf8;

            --report-add-danger: #d94b4b;
            --report-add-danger-soft: #fef2f2;
            --report-add-danger-border: #f5c0c0;

            --report-add-radius-sm: 8px;
            --report-add-radius-md: 12px;
            --report-add-radius-lg: 16px;
            --report-add-radius-2xl: 24px;
        }

        .page-dosen-add-kpengabdian .content-wrapper {
            min-height: calc(100vh - 66px);

            background:
                radial-gradient(ellipse 70% 40% at 100% 0%,
                    rgba(0, 93, 59, .06),
                    transparent),
                linear-gradient(180deg,
                    #f2f8f5 0%,
                    #f7faf8 100%) !important;
        }

        .report-add-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-add-kpengabdian .content-header {
            padding: 26px 0 10px !important;
        }

        .page-dosen-add-kpengabdian section.content {
            padding: 6px 0 36px !important;
        }

        /* -------------------------------------------------------------------------
                       HEADING
                       ------------------------------------------------------------------------- */

        .report-add-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .report-add-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 9px;

            color: var(--report-add-forest-mid);

            font-size: 10.5px;
            font-weight: 800;

            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .report-add-eyebrow::before {
            content: "";

            width: 20px;
            height: 2.5px;

            border-radius: 99px;

            background: var(--report-add-gold);
        }

        .report-add-heading h1 {
            margin: 0;

            color: var(--report-add-ink);

            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: clamp(28px, 3vw, 36px);
            line-height: 1.12;
            font-weight: 800;

            letter-spacing: -.045em;
        }

        .report-add-heading p {
            margin: 7px 0 0;

            color: var(--report-add-muted);

            font-size: 12.5px;
            line-height: 1.55;
        }

        .report-add-breadcrumb {
            margin: 0;
            padding: 0;

            background: transparent;

            font-size: 12px;
            font-weight: 600;

            white-space: nowrap;
        }

        .report-add-breadcrumb a {
            color: var(--report-add-forest);
            text-decoration: none;
        }

        .report-add-breadcrumb .active {
            color: var(--report-add-muted);
        }

        .report-add-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "/";

            padding: 0 8px;

            color: var(--report-add-border-2);
        }

        /* -------------------------------------------------------------------------
                       CARD
                       ------------------------------------------------------------------------- */

        .report-add-card {
            overflow: hidden;

            border: 1px solid var(--report-add-border);
            border-radius: var(--report-add-radius-2xl);

            background: var(--report-add-surface);

            box-shadow:
                0 20px 56px rgba(3, 50, 33, .12),
                0 4px 12px rgba(0, 0, 0, .06);
        }

        .report-add-card-head {
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

            border-bottom: 1px solid var(--report-add-border);
        }

        .report-add-card-head::after {
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

        .report-add-title-group {
            position: relative;
            z-index: 1;
        }

        .report-add-card-title {
            margin: 0;

            color: var(--report-add-ink);

            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 18px;
            line-height: 1.25;
            font-weight: 800;

            letter-spacing: -.025em;
        }

        .report-add-card-subtitle {
            margin: 5px 0 0;

            color: var(--report-add-muted);

            font-size: 11.5px;
            line-height: 1.45;
        }

        .report-add-secure {
            position: relative;
            z-index: 1;

            display: inline-flex;
            align-items: center;

            gap: 7px;

            padding: 8px 12px;

            border: 1px solid var(--report-add-border);
            border-radius: var(--report-add-radius-md);

            background: rgba(255, 255, 255, .78);

            color: var(--report-add-forest-mid);

            font-size: 10px;
            font-weight: 800;

            white-space: nowrap;
        }

        .report-add-card-body {
            padding: 28px 30px 8px;
        }

        /* -------------------------------------------------------------------------
                       SECTION
                       ------------------------------------------------------------------------- */

        .report-add-section {
            margin-bottom: 28px;
        }

        .report-add-section:last-child {
            margin-bottom: 8px;
        }

        .report-add-section-head {
            display: flex;
            align-items: center;

            gap: 11px;

            margin-bottom: 18px;
        }

        .report-add-section-head .report-add-section-number {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: #eef6f1;
            color: var(--report-add-forest);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .report-add-section-head strong {
            display: block;

            color: var(--report-add-ink-2);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            line-height: 1.2;
            font-weight: 800;
        }

        .report-add-section-head span {
            display: block;

            margin-top: 3px;

            color: var(--report-add-muted);

            font-size: 10px;
            line-height: 1.35;
        }

        /* -------------------------------------------------------------------------
                       TWO COLUMN FORM
                       ------------------------------------------------------------------------- */

        .report-add-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr) minmax(0, 1fr);

            gap: 30px;
        }

        .report-add-column {
            min-width: 0;

            padding: 0 2px;
        }

        .report-add-column+.report-add-column {
            padding-left: 28px;

            border-left: 1px solid #eaf0ed;
        }

        .report-add-field {
            margin-bottom: 18px;
        }

        .report-add-field:last-child {
            margin-bottom: 0;
        }

        .report-add-label {
            display: block;

            margin-bottom: 7px;

            color: var(--report-add-ink-2);

            font-size: 11px;
            line-height: 1.3;
            font-weight: 800;
        }

        .report-add-label .req {
            color: var(--report-add-danger);
            margin-left: 2px;
        }

        .report-add-input,
        .report-add-select {
            width: 100%;

            min-height: 42px;

            padding: 9px 12px;

            border: 1px solid var(--report-add-border-2);
            border-radius: var(--report-add-radius-md);

            outline: none;

            background: #fff;
            color: var(--report-add-ink);

            font-family: inherit;
            font-size: 12px;
            font-weight: 500;

            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .report-add-input::placeholder {
            color: var(--report-add-light);
        }

        .report-add-input:hover,
        .report-add-select:hover {
            border-color: #c5d6cd;
        }

        .report-add-input:focus,
        .report-add-select:focus {
            border-color: var(--report-add-forest-mid);

            box-shadow:
                0 0 0 3px rgba(0, 87, 59, .09);
        }

        .report-add-input[readonly] {
            background: #f4f7f6;
            color: #667a72;
            cursor: default;
        }

        .report-add-help {
            display: block;

            margin-top: 6px;

            color: var(--report-add-light);

            font-size: 9.5px;
            line-height: 1.4;
        }

        .report-add-error {
            display: flex;
            align-items: flex-start;

            gap: 6px;

            margin-top: 6px;

            color: var(--report-add-danger);

            font-size: 10px;
            line-height: 1.4;
        }

        .report-add-error i {
            margin-top: 1px;

            font-size: 9px;
        }

        /* -------------------------------------------------------------------------
                       DATE RANGE
                       ------------------------------------------------------------------------- */

        .report-add-date-group {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr) auto minmax(0, 1fr);

            gap: 8px;

            align-items: center;
        }

        .report-add-date-separator {
            color: var(--report-add-muted);

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;
        }

        /* -------------------------------------------------------------------------
                       UPLOADS
                       ------------------------------------------------------------------------- */

        .report-add-upload {
            display: flex;
            flex-direction: column;

            gap: 7px;
        }

        .report-add-file {
            position: absolute;

            width: 1px;
            height: 1px;

            overflow: hidden;

            opacity: 0;
            pointer-events: none;
        }

        .report-add-file-label {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            min-height: 46px;

            padding: 8px 10px 8px 12px;

            border: 1px dashed #bfd4c8;
            border-radius: var(--report-add-radius-md);

            background: #f8fbf9;

            cursor: pointer;

            transition:
                border-color .18s ease,
                background .18s ease,
                transform .18s ease;
        }

        .report-add-file-label:hover {
            border-color: #9fbead;
            background: #f0f7f3;

            transform: translateY(-1px);
        }

        .report-add-file-copy {
            display: flex;
            align-items: center;

            gap: 9px;

            min-width: 0;
        }

        .report-add-file-icon {
            width: 30px;
            height: 30px;
            flex: 0 0 30px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: var(--report-add-forest-soft);
            color: var(--report-add-forest-mid);

            font-size: 12px;
        }

        .report-add-file-name {
            min-width: 0;
            overflow: hidden;

            color: var(--report-add-text);

            font-size: 10.5px;
            font-weight: 700;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .report-add-file-browse {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 7px 10px;

            border: 1px solid var(--report-add-border-2);
            border-radius: 9px;

            background: #fff;
            color: var(--report-add-forest);

            font-size: 9.5px;
            font-weight: 800;

            white-space: nowrap;
        }

        /* -------------------------------------------------------------------------
                       MEMBERS
                       ------------------------------------------------------------------------- */

        .report-add-team {
            padding-top: 23px;

            border-top: 1px solid #eaf0ed;
        }

        .report-add-team-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            margin-bottom: 14px;
        }

        .report-add-team-title {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .report-add-team-title .report-add-team-icon {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: #eef6f1;
            color: var(--report-add-forest);

            font-size: 12px;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .report-add-team-title strong {
            color: var(--report-add-ink-2);

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .report-add-team-title span {
            display: block;

            margin-top: 2px;

            color: var(--report-add-muted);

            font-size: 9.5px;
        }

        .report-add-add-member {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            min-height: 34px;

            padding: 0 11px;

            border: 1px solid #c7ddd0;
            border-radius: 9px;

            background: #fff;
            color: var(--report-add-forest);

            font-size: 10px;
            font-weight: 800;

            cursor: pointer;

            transition: .18s ease;
        }

        .report-add-add-member:hover {
            background: var(--report-add-forest-soft);
            border-color: #aec9bb;

            transform: translateY(-1px);
        }

        .report-add-member-list {
            display: flex;
            flex-direction: column;

            gap: 10px;
        }

        .report-add-member-card {
            padding: 15px 16px;

            border: 1px solid var(--report-add-border);
            border-radius: 14px;

            background: #fbfdfc;
        }

        .report-add-member-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-bottom: 13px;
        }

        .report-add-member-label {
            display: flex;
            align-items: center;

            gap: 8px;

            color: var(--report-add-ink-2);

            font-size: 11px;
            font-weight: 800;
        }

        .report-add-member-label .report-add-member-index {
            width: 23px;
            height: 23px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 7px;

            background: #eaf5ee;
            color: var(--report-add-forest);

            font-size: 9px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .report-add-remove {
            width: 28px;
            height: 28px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--report-add-danger-border);
            border-radius: 8px;

            background: var(--report-add-danger-soft);
            color: var(--report-add-danger);

            font-size: 10px;

            cursor: pointer;

            transition: .18s ease;
        }

        .report-add-remove:hover {
            background: #fdeaea;
            transform: translateY(-1px);
        }

        .report-add-member-grid {
            display: grid;

            grid-template-columns:
                1.15fr 1fr .85fr .95fr;

            gap: 12px;
        }

        /* -------------------------------------------------------------------------
                       FOOTER
                       ------------------------------------------------------------------------- */

        .report-add-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 18px;

            padding: 17px 30px;

            border-top: 1px solid var(--report-add-border);

            background: var(--report-add-surface-alt);
        }

        .report-add-footer-note {
            display: inline-flex;
            align-items: center;

            gap: 8px;

            color: var(--report-add-muted);

            font-size: 10px;
            line-height: 1.4;
        }

        .report-add-footer-note i {
            color: var(--report-add-forest-mid);
        }

        .report-add-submit {
            min-height: 41px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 0 17px;

            border: 1px solid var(--report-add-forest);
            border-radius: var(--report-add-radius-md);

            background: var(--report-add-forest);
            color: #fff;

            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;

            cursor: pointer;

            box-shadow: 0 6px 16px rgba(0, 61, 45, .18);

            transition: .18s ease;
        }

        .report-add-submit:hover {
            background: var(--report-add-forest-deep);
            border-color: var(--report-add-forest-deep);

            transform: translateY(-1px);

            box-shadow: 0 9px 20px rgba(0, 61, 45, .23);
        }

        /* -------------------------------------------------------------------------
                       RESPONSIVE
                       ------------------------------------------------------------------------- */

        @media (max-width: 991.98px) {

            .report-add-shell {
                width: calc(100% - 34px);
            }

            .report-add-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            .report-add-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .report-add-column+.report-add-column {
                padding-left: 0;
                padding-top: 24px;

                border-left: 0;
                border-top: 1px solid #eaf0ed;
            }

            .report-add-member-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {

            .report-add-shell {
                width: calc(100% - 24px);
            }

            .report-add-card {
                border-radius: var(--report-add-radius-lg);
            }

            .report-add-card-head {
                align-items: flex-start;
                flex-direction: column;

                padding: 20px 19px 17px;
            }

            .report-add-card-body {
                padding: 22px 19px 7px;
            }

            .report-add-footer {
                align-items: stretch;
                flex-direction: column;

                padding: 15px 19px 18px;
            }

            .report-add-submit {
                width: 100%;
            }

            .report-add-team-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .report-add-add-member {
                width: 100%;
                justify-content: center;
            }

            .report-add-file-label {
                align-items: flex-start;
                flex-direction: column;
            }

            .report-add-file-browse {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 575.98px) {

            .report-add-shell {
                width: calc(100% - 18px);
            }

            .report-add-heading h1 {
                font-size: 28px;
            }

            .report-add-date-group {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .report-add-date-separator {
                text-align: center;
            }

            .report-add-member-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .page-dosen-add-kpengabdian *,
            .page-dosen-add-kpengabdian *::before,
            .page-dosen-add-kpengabdian *::after {
                transition: none !important;
            }
        }
    </style>

@endsection


@section('content')

    <div class="content-wrapper">

        <div class="content-header">

            <div class="report-add-shell">

                <div class="report-add-heading">

                    <div>

                        <span class="report-add-eyebrow">
                            Pengabdian Masyarakat
                        </span>

                        <h1>
                            {{ $pagetitle }}
                        </h1>

                        <p>
                            Lengkapi data laporan pengabdian dan informasi ketua sebelum mengirimkan laporan.
                        </p>

                    </div>


                    <ol class="breadcrumb report-add-breadcrumb">

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

            <div class="report-add-shell">

                <form action="{{ route('dosen.storekumpulanp3m') }}" method="post" enctype="multipart/form-data"
                    id="addKpengabdianForm">

                    @csrf


                    <div class="report-add-card">

                        <div class="report-add-card-head">

                            <div class="report-add-title-group">

                                <h2 class="report-add-card-title">
                                    Laporan Pengabdian Masyarakat
                                </h2>

                                <p class="report-add-card-subtitle">
                                    Form pengumpulan laporan kegiatan pengabdian.
                                </p>

                            </div>


                            <div class="report-add-secure">

                                <i class="fas fa-shield-alt"></i>

                                Data tersimpan secara aman

                            </div>

                        </div>


                        <div class="report-add-card-body">

                            {{-- =====================================================
                             MAIN INFORMATION
                        ====================================================== --}}

                            <section class="report-add-section">

                                <div class="report-add-section-head">

                                    <span class="report-add-section-number">
                                        01
                                    </span>

                                    <div>

                                        <strong>
                                            Informasi Laporan
                                        </strong>

                                        <span>
                                            Detail utama laporan pengabdian masyarakat.
                                        </span>

                                    </div>

                                </div>


                                <div class="report-add-grid">

                                    {{-- LEFT --}}
                                    <div class="report-add-column">

                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Judul Pengabdian
                                            </label>

                                            <input type="text" name="judul" class="report-add-input"
                                                placeholder="Masukkan judul pengabdian" value="{{ old('judul') }}">

                                            @error('judul')
                                                <span class="report-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Bidang Ilmu
                                            </label>

                                            <input type="text" name="bidang" class="report-add-input"
                                                placeholder="Contoh: Teknologi Informasi" value="{{ old('bidang') }}">

                                            @error('bidang')
                                                <span class="report-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Kategori
                                            </label>

                                            <input type="text" name="jeniskategori" class="report-add-input"
                                                value="Laporan Pengabdian Masyarakat" readonly>

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Lokasi
                                            </label>

                                            <input type="text" name="lokasi" class="report-add-input"
                                                placeholder="Masukkan lokasi pengabdian" value="{{ old('lokasi') }}">

                                            @error('lokasi')
                                                <span class="report-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Lama Pelaksanaan
                                            </label>

                                            <div class="report-add-date-group">

                                                <input type="date" name="tanggal_mulai" class="report-add-input"
                                                    value="{{ old('tanggal_mulai') }}" required>

                                                <span class="report-add-date-separator">
                                                    <i class="fas fa-minus"></i>
                                                </span>

                                                <input type="date" name="tanggal_selesai" class="report-add-input"
                                                    value="{{ old('tanggal_selesai') }}" required>

                                            </div>

                                            @if ($errors->has('tanggal_mulai') || $errors->has('tanggal_selesai'))
                                                <span class="report-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $errors->first('tanggal_mulai') ?: $errors->first('tanggal_selesai') }}
                                                </span>
                                            @endif

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Biaya
                                            </label>

                                            <input type="number" name="biaya" class="report-add-input"
                                                placeholder="Contoh: 1500000" min="0" step="any"
                                                value="{{ old('biaya') }}">

                                            <span class="report-add-help">
                                                Contoh penulisan nominal: 1500000.
                                            </span>

                                            @error('biaya')
                                                <span class="report-add-error">
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

                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Unggah Laporan
                                            </label>

                                            <div class="report-add-upload">

                                                @if ($cachedUppdf && $cachedUppdfName)
                                                    <input type="hidden" name="cached_uppdf" value="{{ $cachedUppdf }}">
                                                    <input type="hidden" name="cached_uppdf_name" value="{{ $cachedUppdfName }}">
                                                @endif

                                                <input type="file" name="uppdf" class="report-add-file"
                                                    id="uploadLaporan" accept=".pdf,application/pdf"
                                                    data-p3m-upload
                                                    data-p3m-upload-preserve-accept
                                                    data-p3m-upload-name-id="uploadLaporanName"
                                                    data-p3m-upload-label="Dokumen laporan"
                                                    data-p3m-upload-empty-label="{{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : 'Pilih file laporan' }}"
                                                    data-p3m-cached-name="{{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : '' }}"
                                                    data-p3m-upload-formats="PDF"
                                                    data-p3m-upload-extensions="pdf"
                                                    data-p3m-upload-mime-types="application/pdf"
                                                    data-p3m-upload-max-bytes="5242880"
                                                    @if ($errors->has('uppdf')) data-p3m-upload-error="{{ $errors->first('uppdf') }}" @endif>

                                                <label for="uploadLaporan" class="report-add-file-label">

                                                    <span class="report-add-file-copy">

                                                        <span class="report-add-file-icon">
                                                            <i class="fas fa-file-pdf" style="{{ $cachedUppdfName ? 'color: #16a34a;' : '' }}"></i>
                                                        </span>

                                                        <span class="report-add-file-name" id="uploadLaporanName">
                                                            {{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : 'Pilih file laporan' }}
                                                        </span>

                                                    </span>

                                                    <span class="report-add-file-browse">
                                                        <i class="fas fa-folder-open"></i>
                                                        {{ $cachedUppdfName ? 'Ganti File' : 'Pilih File' }}
                                                    </span>

                                                </label>

                                            </div>

                                            <span class="report-add-help">
                                                Hanya PDF · Maksimal ukuran file 5 MB.
                                            </span>

                                            @error('uppdf')
                                                <span class="report-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Unggah Gambar / Foto
                                            </label>

                                            <div class="report-add-upload">

                                                @if ($cachedFoto && $cachedFotoName)
                                                    <input type="hidden" name="cached_foto" value="{{ $cachedFoto }}">
                                                    <input type="hidden" name="cached_foto_name" value="{{ $cachedFotoName }}">
                                                @endif

                                                <input type="file" name="foto" class="report-add-file"
                                                    id="uploadFoto" accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                                    data-p3m-upload
                                                    data-p3m-upload-preserve-accept
                                                    data-p3m-upload-name-id="uploadFotoName"
                                                    data-p3m-upload-label="Foto kegiatan"
                                                    data-p3m-upload-empty-label="{{ $cachedFotoName ? $cachedFotoName . ' (Tersimpan)' : 'Pilih gambar / foto' }}"
                                                    data-p3m-cached-name="{{ $cachedFotoName ? $cachedFotoName . ' (Tersimpan)' : '' }}"
                                                    data-p3m-upload-formats="JPG atau PNG"
                                                    data-p3m-upload-extensions="jpg,jpeg,png"
                                                    data-p3m-upload-mime-types="image/jpeg,image/png"
                                                    data-p3m-upload-max-bytes="2097152"
                                                    @if ($errors->has('foto')) data-p3m-upload-error="{{ $errors->first('foto') }}" @endif>

                                                <label for="uploadFoto" class="report-add-file-label">

                                                    <span class="report-add-file-copy">

                                                        <span class="report-add-file-icon">
                                                            <i class="fas fa-image" style="{{ $cachedFotoName ? 'color: #16a34a;' : '' }}"></i>
                                                        </span>

                                                        <span class="report-add-file-name" id="uploadFotoName">
                                                            {{ $cachedFotoName ? $cachedFotoName . ' (Tersimpan)' : 'Pilih gambar / foto' }}
                                                        </span>

                                                    </span>

                                                    <span class="report-add-file-browse">
                                                        <i class="fas fa-camera"></i>
                                                        {{ $cachedFotoName ? 'Ganti Gambar' : 'Pilih Gambar' }}
                                                    </span>

                                                </label>

                                            </div>

                                            <span class="report-add-help">
                                                JPG atau PNG · Maksimal ukuran file 2 MB.
                                            </span>

                                            @error('foto')
                                                <span class="report-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- RIGHT --}}
                                    <div class="report-add-column">

                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Nama Ketua
                                            </label>

                                            <input type="text" name="ketua" class="report-add-input"
                                                placeholder="Masukkan nama ketua" value="{{ old('ketua') }}">

                                            @error('ketua')
                                                <span class="report-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Jenis Kelamin
                                            </label>

                                            <select class="report-add-select" name="jeniskelamin">

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


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                NIDN
                                            </label>

                                            <input type="text" name="nidn" class="report-add-input"
                                                placeholder="Masukkan NIDN" value="{{ old('nidn') }}">

                                            @error('nidn')
                                                <span class="report-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Jabatan Fungsional
                                            </label>

                                            <select class="report-add-select" name="jabatan">

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
                                                <span class="report-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Program Studi
                                            </label>

                                            <select class="report-add-select" name="prodi">

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
                                                    Agribisnis Perternakan
                                                </option>

                                            </select>

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                No. Telepon
                                            </label>

                                            <input type="text" name="telp" class="report-add-input"
                                                placeholder="Masukkan nomor telepon" value="{{ old('telp') }}">

                                            @error('telp')
                                                <span class="report-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="report-add-field">

                                            <label class="report-add-label">
                                                Alamat
                                            </label>

                                            <input type="text" name="alamat" class="report-add-input"
                                                placeholder="Masukkan alamat" value="{{ old('alamat') }}">

                                            @error('alamat')
                                                <span class="report-add-error">
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

                            <section class="report-add-team">

                                <div class="report-add-team-head">

                                    <div class="report-add-team-title">

                                        <span class="report-add-team-icon">
                                            <i class="fas fa-users"></i>
                                        </span>

                                        <div>
                                            <strong>
                                                Anggota Pengabdian Masyarakat
                                            </strong>

                                            <span>
                                                Tambahkan anggota yang terlibat dalam laporan.
                                            </span>
                                        </div>

                                    </div>


                                    <button type="button" onclick="addAnggota()" class="report-add-add-member">
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

                                <div id="anggota-wrapper" class="report-add-member-list">

                                    @foreach ($membersData as $i => $mem)
                                        <div class="report-add-member-card anggota-row">

                                            <div class="report-add-member-head">

                                                <span class="report-add-member-label">

                                                    <span class="report-add-member-index">
                                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                    </span>

                                                    Identitas Anggota

                                                </span>


                                                <button type="button" class="report-add-remove remove-anggota"
                                                    aria-label="Hapus anggota" title="Hapus anggota"
                                                    @if (count($membersData) <= 1) style="display: none;" @endif>
                                                    <i class="fas fa-times"></i>
                                                </button>

                                            </div>


                                            <div class="report-add-member-grid">

                                                <div class="report-add-field">

                                                    <label class="report-add-label">
                                                        Nama
                                                    </label>

                                                    <input type="text" class="report-add-input" name="anggota[{{ $i }}][nama]"
                                                        placeholder="Nama anggota" value="{{ old("anggota.{$i}.nama", $mem['nama'] ?? '') }}">

                                                    @error("anggota.{$i}.nama")
                                                        <span class="report-add-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="report-add-field">

                                                    <label class="report-add-label">
                                                        Program Studi
                                                    </label>

                                                    <select class="report-add-select" name="anggota[{{ $i }}][prodi]">

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
                                                        <span class="report-add-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="report-add-field">

                                                    <label class="report-add-label">
                                                        NIM / NIDN
                                                    </label>

                                                    <input type="text" class="report-add-input" name="anggota[{{ $i }}][nim]"
                                                        placeholder="NIM / NIDN" value="{{ old("anggota.{$i}.nim", $mem['nim'] ?? '') }}">

                                                    @error("anggota.{$i}.nim")
                                                        <span class="report-add-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="report-add-field">

                                                    <label class="report-add-label">
                                                        Jabatan
                                                    </label>

                                                    <select class="report-add-select" name="anggota[{{ $i }}][jabatan]">

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
                                                        <span class="report-add-error">
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


                        {{-- FOOTER --}}
                        <div class="report-add-footer">

                            <div class="report-add-footer-note">

                                <i class="fas fa-info-circle"></i>

                                <span>
                                    Periksa kembali informasi sebelum mengirim laporan.
                                </span>

                            </div>


                            <button type="submit" class="report-add-submit">
                                <i class="fas fa-paper-plane"></i>
                                Submit Laporan
                            </button>

                        </div>

                    </div>

                </form>

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
                    const number = row.querySelector('.report-add-member-index');
                    if (number) {
                        number.textContent = String(index + 1).padStart(2, '0');
                    }
                    const removeBtn = row.querySelector('.remove-anggota');
                    if (removeBtn) {
                        removeBtn.style.display = rows.length > 1 ? '' : 'none';
                    }
                });
            }

            window.updateMemberNumbers = updateMemberNumbers;

            window.addAnggota = function() {
                const wrapper = document.getElementById('anggota-wrapper');
                if (!wrapper) {
                    return;
                }

                const index = getNextMemberIndex();

                const html = `
                <div class="report-add-member-card anggota-row">
                    <div class="report-add-member-head">
                        <span class="report-add-member-label">
                            <span class="report-add-member-index">00</span>
                            Identitas Anggota
                        </span>
                        <button
                            type="button"
                            class="report-add-remove remove-anggota"
                            aria-label="Hapus anggota"
                            title="Hapus anggota"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="report-add-member-grid">
                        <div class="report-add-field">
                            <label class="report-add-label">
                                Nama
                            </label>
                            <input
                                type="text"
                                class="report-add-input"
                                name="anggota[${index}][nama]"
                                placeholder="Nama anggota"
                            >
                        </div>
                        <div class="report-add-field">
                            <label class="report-add-label">
                                Program Studi
                            </label>
                            <select
                                class="report-add-select"
                                name="anggota[${index}][prodi]"
                            >
                                <option value="">--- Pilih ---</option>
                                <option value="R">Rekayasa Perangkat Lunak</option>
                                <option value="A">Administrasi Bisnis Internasional</option>
                                <option value="AK">Akutansi Keuangan Publik</option>
                                <option value="AB">Bisnis Digital</option>
                                <option value="AP">Agribisnis Perternakan</option>
                            </select>
                        </div>
                        <div class="report-add-field">
                            <label class="report-add-label">
                                NIM / NIDN
                            </label>
                            <input
                                type="text"
                                class="report-add-input"
                                name="anggota[${index}][nim]"
                                placeholder="NIM / NIDN"
                            >
                        </div>
                        <div class="report-add-field">
                            <label class="report-add-label">
                                Jabatan
                            </label>
                            <select
                                class="report-add-select"
                                name="anggota[${index}][jabatan]"
                            >
                                <option value="">--- Pilih ---</option>
                                <option value="DR">Direktur</option>
                                <option value="LT">Wakil Direktur</option>
                                <option value="KP">Ketua Program Studi</option>
                                <option value="DS">Dosen</option>
                                <option value="MHS">Mahasiswa</option>
                            </select>
                        </div>
                    </div>
                </div>
                `;

                wrapper.insertAdjacentHTML('beforeend', html);
                updateMemberNumbers();
            };

            function bindFileName(inputId, labelId, fallback) {
                const input = document.getElementById(inputId);
                const label = document.getElementById(labelId);

                if (!input || !label) {
                    return;
                }

                if (input._p3mBound) {
                    return;
                }
                input._p3mBound = true;

                input.addEventListener('change', function(event) {
                    const file = event.target.files && event.target.files[0];
                    label.textContent = file ? file.name : (input.dataset.p3mCachedName || fallback);
                });
            }

            function initPage() {
                updateMemberNumbers();
                bindFileName('uploadLaporan', 'uploadLaporanName', 'Pilih file laporan');
                bindFileName('uploadFoto', 'uploadFotoName', 'Pilih gambar / foto');

                const addBtn = document.querySelector('.report-add-add-member');
                if (addBtn && !addBtn._p3mBound) {
                    addBtn._p3mBound = true;
                    addBtn.addEventListener('click', function() {
                        // Handled by onclick or fallback here
                    });
                }
            }

            if (!window._p3mAnggotaRemoveBound) {
                window._p3mAnggotaRemoveBound = true;
                document.addEventListener('click', function(event) {
                    const removeButton = event.target.closest('.remove-anggota');
                    if (!removeButton) {
                        return;
                    }

                    const row = removeButton.closest('.anggota-row');
                    if (!row) {
                        return;
                    }

                    const wrapper = row.closest('#anggota-wrapper');
                    if (!wrapper) {
                        return;
                    }

                    const rows = wrapper.querySelectorAll('.anggota-row');
                    if (rows.length <= 1) {
                        return;
                    }

                    row.remove();
                    updateMemberNumbers();
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initPage, {
                    once: true
                });
            } else {
                initPage();
            }
            document.addEventListener('turbo:load', initPage);
        })();
    </script>

@endsection
