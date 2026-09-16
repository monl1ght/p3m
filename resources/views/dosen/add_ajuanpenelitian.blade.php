@extends('layout.doslayout')

@section('body_class', 'page-dosen-add-penelitian')

@section('css')

    <style>
        /* =========================================================================
                   P3M DOSEN — TAMBAH PENGAJUAN PENELITIAN
                   Visual master: Admin P3M / Dosen workspace.
                   Backend contract preserved:
                   route, CSRF, field names, values, member array and dynamic rows.
                   ========================================================================= */

        :root {
            --research-add-forest: #003d2d;
            --research-add-forest-deep: #002e22;
            --research-add-forest-mid: #00573b;
            --research-add-forest-soft: #eaf5ee;

            --research-add-gold: #b99835;
            --research-add-ink: #0d1f1a;
            --research-add-ink-2: #1e3328;
            --research-add-text: #3b4f47;
            --research-add-muted: #6b7f78;
            --research-add-light: #9caaa4;

            --research-add-border: #e4ede8;
            --research-add-border-2: #d3e0d9;

            --research-add-surface: #ffffff;
            --research-add-surface-alt: #f7faf8;

            --research-add-danger: #d94b4b;
            --research-add-danger-soft: #fef2f2;
            --research-add-danger-border: #f5c0c0;

            --research-add-radius-sm: 8px;
            --research-add-radius-md: 12px;
            --research-add-radius-lg: 16px;
            --research-add-radius-2xl: 24px;
        }

        .page-dosen-add-penelitian .content-wrapper {
            min-height: calc(100vh - 66px);
            background:
                radial-gradient(ellipse 70% 40% at 100% 0%,
                    rgba(0, 93, 59, .06),
                    transparent),
                linear-gradient(180deg,
                    #f2f8f5 0%,
                    #f7faf8 100%) !important;
        }

        .research-add-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-add-penelitian .content-header {
            padding: 26px 0 10px !important;
        }

        .page-dosen-add-penelitian section.content {
            padding: 6px 0 36px !important;
        }

        /* =========================================================================
                   PAGE HEADING
                   ========================================================================= */

        .research-add-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .research-add-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 9px;
            color: var(--research-add-forest-mid);
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .research-add-eyebrow::before {
            content: "";
            width: 20px;
            height: 2.5px;
            border-radius: 99px;
            background: var(--research-add-gold);
        }

        .research-add-heading h1 {
            margin: 0;
            color: var(--research-add-ink);
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: clamp(28px, 3vw, 36px);
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -.045em;
        }

        .research-add-heading p {
            margin: 7px 0 0;
            color: var(--research-add-muted);
            font-size: 12.5px;
            line-height: 1.55;
        }

        .research-add-breadcrumb {
            margin: 0;
            padding: 0;
            background: transparent;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .research-add-breadcrumb a {
            color: var(--research-add-forest);
            text-decoration: none;
        }

        .research-add-breadcrumb .active {
            color: var(--research-add-muted);
        }

        .research-add-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            padding: 0 8px;
            color: var(--research-add-border-2);
        }

        /* =========================================================================
                   CARD
                   ========================================================================= */

        .research-add-card {
            overflow: hidden;
            border: 1px solid var(--research-add-border);
            border-radius: var(--research-add-radius-2xl);
            background: var(--research-add-surface);
            box-shadow:
                0 20px 56px rgba(3, 50, 33, .12),
                0 4px 12px rgba(0, 0, 0, .06);
        }

        .research-add-card-head {
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
            border-bottom: 1px solid var(--research-add-border);
        }

        .research-add-card-head::after {
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

        .research-add-title-group {
            position: relative;
            z-index: 1;
        }

        .research-add-card-title {
            margin: 0;
            color: var(--research-add-ink);
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 18px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -.025em;
        }

        .research-add-card-subtitle {
            margin: 5px 0 0;
            color: var(--research-add-muted);
            font-size: 11.5px;
            line-height: 1.45;
        }

        .research-add-secure {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border: 1px solid var(--research-add-border);
            border-radius: var(--research-add-radius-md);
            background: rgba(255, 255, 255, .78);
            color: var(--research-add-forest-mid);
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .research-add-card-body {
            padding: 28px 30px 8px;
        }

        /* =========================================================================
                   SECTIONS
                   ========================================================================= */

        .research-add-section {
            margin-bottom: 28px;
        }

        .research-add-section-head {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 18px;
        }

        .research-add-section-head .research-add-section-number {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #eef6f1;
            color: var(--research-add-forest);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .research-add-section-head strong {
            display: block;
            color: var(--research-add-ink-2);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            line-height: 1.2;
            font-weight: 800;
        }

        .research-add-section-head span {
            display: block;
            margin-top: 3px;
            color: var(--research-add-muted);
            font-size: 10px;
            line-height: 1.35;
        }

        /* =========================================================================
                   TWO-COLUMN FORM
                   ========================================================================= */

        .research-add-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 30px;
        }

        .research-add-column {
            min-width: 0;
            padding: 0 2px;
        }

        .research-add-column+.research-add-column {
            padding-left: 28px;
            border-left: 1px solid #eaf0ed;
        }

        .research-add-field {
            margin-bottom: 18px;
        }

        .research-add-field:last-child {
            margin-bottom: 0;
        }

        .research-add-label {
            display: block;
            margin-bottom: 7px;
            color: var(--research-add-ink-2);
            font-size: 11px;
            line-height: 1.3;
            font-weight: 800;
        }

        .research-add-label .req {
            color: var(--research-add-danger);
            margin-left: 2px;
        }

        .research-add-input,
        .research-add-select {
            width: 100%;
            min-height: 42px;
            padding: 9px 12px;
            border: 1px solid var(--research-add-border-2);
            border-radius: var(--research-add-radius-md);
            outline: none;
            background: #fff;
            color: var(--research-add-ink);
            font-family: inherit;
            font-size: 12px;
            font-weight: 500;
            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .research-add-input::placeholder {
            color: var(--research-add-light);
        }

        .research-add-input:hover,
        .research-add-select:hover {
            border-color: #c5d6cd;
        }

        .research-add-input:focus,
        .research-add-select:focus {
            border-color: var(--research-add-forest-mid);
            box-shadow: 0 0 0 3px rgba(0, 87, 59, .09);
        }

        .research-add-input[readonly] {
            background: #f4f7f6;
            color: #667a72;
            cursor: default;
        }

        .research-add-help {
            display: block;
            margin-top: 6px;
            color: var(--research-add-light);
            font-size: 9.5px;
            line-height: 1.4;
        }

        .research-add-error {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            margin-top: 6px;
            color: var(--research-add-danger);
            font-size: 10px;
            line-height: 1.4;
        }

        .research-add-error i {
            margin-top: 1px;
            font-size: 9px;
        }

        .research-add-date-group {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
            gap: 8px;
            align-items: center;
        }

        .research-add-date-separator {
            color: var(--research-add-muted);
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* =========================================================================
                   FILE UPLOAD
                   ========================================================================= */

        .research-add-file-wrap {
            position: relative;
        }

        .research-add-file-input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
        }

        .research-add-file-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-height: 46px;
            padding: 8px 10px 8px 12px;
            border: 1px dashed #bfd4c8;
            border-radius: var(--research-add-radius-md);
            background: #f8fbf9;
            cursor: pointer;
            transition:
                border-color .18s ease,
                background .18s ease,
                transform .18s ease;
        }

        .research-add-file-label:hover {
            border-color: #9fbead;
            background: #f0f7f3;
            transform: translateY(-1px);
        }

        .research-add-file-copy {
            display: flex;
            align-items: center;
            gap: 9px;
            min-width: 0;
        }

        .research-add-file-icon {
            width: 30px;
            height: 30px;
            flex: 0 0 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: var(--research-add-forest-soft);
            color: var(--research-add-forest-mid);
            font-size: 12px;
        }

        .research-add-file-name {
            min-width: 0;
            overflow: hidden;
            color: var(--research-add-text);
            font-size: 10.5px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .research-add-file-browse {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border: 1px solid var(--research-add-border-2);
            border-radius: 9px;
            background: #fff;
            color: var(--research-add-forest);
            font-size: 9.5px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* =========================================================================
                   MEMBERS
                   ========================================================================= */

        .research-add-team {
            padding-top: 23px;
            border-top: 1px solid #eaf0ed;
        }

        .research-add-team-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .research-add-team-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .research-add-team-title .research-add-team-icon {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #eef6f1;
            color: var(--research-add-forest);
            font-size: 12px;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .research-add-team-title strong {
            color: var(--research-add-ink-2);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .research-add-team-title span {
            display: block;
            margin-top: 2px;
            color: var(--research-add-muted);
            font-size: 9.5px;
        }

        .research-add-add-member {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-height: 34px;
            padding: 0 11px;
            border: 1px solid #c7ddd0;
            border-radius: 9px;
            background: #fff;
            color: var(--research-add-forest);
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            transition: .18s ease;
        }

        .research-add-add-member:hover {
            background: var(--research-add-forest-soft);
            border-color: #aec9bb;
            transform: translateY(-1px);
        }

        .research-add-member-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .research-add-member-card {
            padding: 15px 16px;
            border: 1px solid var(--research-add-border);
            border-radius: 14px;
            background: #fbfdfc;
        }

        .research-add-member-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 13px;
        }

        .research-add-member-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--research-add-ink-2);
            font-size: 11px;
            font-weight: 800;
        }

        .research-add-member-label .research-add-member-index {
            width: 23px;
            height: 23px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            background: #eaf5ee;
            color: var(--research-add-forest);
            font-size: 9px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .research-add-remove {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--research-add-danger-border);
            border-radius: 8px;
            background: var(--research-add-danger-soft);
            color: var(--research-add-danger);
            font-size: 10px;
            cursor: pointer;
            transition: .18s ease;
        }

        .research-add-remove:hover {
            background: #fdeaea;
            transform: translateY(-1px);
        }

        .research-add-member-grid {
            display: grid;
            grid-template-columns: 1.15fr 1fr .85fr .95fr;
            gap: 12px;
        }

        /* =========================================================================
                   FOOTER
                   ========================================================================= */

        .research-add-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 17px 30px;
            border-top: 1px solid var(--research-add-border);
            background: var(--research-add-surface-alt);
        }

        .research-add-footer-note {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--research-add-muted);
            font-size: 10px;
            line-height: 1.4;
        }

        .research-add-footer-note i {
            color: var(--research-add-forest-mid);
        }

        .research-add-submit {
            min-height: 41px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 17px;
            border: 1px solid var(--research-add-forest);
            border-radius: var(--research-add-radius-md);
            background: var(--research-add-forest);
            color: #fff;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(0, 61, 45, .18);
            transition: .18s ease;
        }

        .research-add-submit:hover {
            background: var(--research-add-forest-deep);
            border-color: var(--research-add-forest-deep);
            transform: translateY(-1px);
            box-shadow: 0 9px 20px rgba(0, 61, 45, .23);
        }

        /* =========================================================================
                   RESPONSIVE
                   ========================================================================= */

        @media (max-width: 991.98px) {
            .research-add-shell {
                width: calc(100% - 34px);
            }

            .research-add-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            .research-add-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .research-add-column+.research-add-column {
                padding-left: 0;
                padding-top: 24px;
                border-left: 0;
                border-top: 1px solid #eaf0ed;
            }

            .research-add-member-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .research-add-shell {
                width: calc(100% - 24px);
            }

            .research-add-card {
                border-radius: var(--research-add-radius-lg);
            }

            .research-add-card-head {
                align-items: flex-start;
                flex-direction: column;
                padding: 20px 19px 17px;
            }

            .research-add-card-body {
                padding: 22px 19px 7px;
            }

            .research-add-footer {
                align-items: stretch;
                flex-direction: column;
                padding: 15px 19px 18px;
            }

            .research-add-submit {
                width: 100%;
            }

            .research-add-team-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .research-add-add-member {
                width: 100%;
                justify-content: center;
            }

            .research-add-file-label {
                align-items: flex-start;
                flex-direction: column;
            }

            .research-add-file-browse {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 575.98px) {
            .research-add-shell {
                width: calc(100% - 18px);
            }

            .research-add-heading h1 {
                font-size: 28px;
            }

            .research-add-date-group {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .research-add-date-separator {
                text-align: center;
            }

            .research-add-member-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .page-dosen-add-penelitian *,
            .page-dosen-add-penelitian *::before,
            .page-dosen-add-penelitian *::after {
                transition: none !important;
            }
        }
    </style>

@endsection


@section('content')

    <div class="content-wrapper">

        <div class="content-header">

            <div class="research-add-shell">

                <div class="research-add-heading">

                    <div>

                        <span class="research-add-eyebrow">
                            Penelitian
                        </span>

                        <h1>
                            {{ $pagetitle }}
                        </h1>
                    </div>


                    <ol class="breadcrumb research-add-breadcrumb">

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

            <div class="research-add-shell">

                <form action="{{ route('dosen.storepenelitian') }}" method="post" enctype="multipart/form-data"
                    id="addPenelitianForm">

                    @csrf


                    <div class="research-add-card">

                        <div class="research-add-card-head">

                            <div class="research-add-title-group">

                                <h2 class="research-add-card-title">
                                    P3M Polibang Jepara
                                </h2>

                                <p class="research-add-card-subtitle">
                                    Form pengajuan proposal penelitian untuk ditinjau oleh tim P3M.
                                </p>

                            </div>


                            <div class="research-add-secure">

                                <i class="fas fa-shield-alt"></i>

                                Data tersimpan secara aman

                            </div>

                        </div>


                        <div class="research-add-card-body">

                            {{-- =====================================================
                             INFORMATION
                        ====================================================== --}}

                            <section class="research-add-section">

                                <div class="research-add-section-head">

                                    <span class="research-add-section-number">
                                        01
                                    </span>

                                    <div>
                                        <strong>
                                            Informasi Penelitian
                                        </strong>

                                        <span>
                                            Detail utama proposal penelitian.
                                        </span>
                                    </div>

                                </div>


                                <div class="research-add-grid">

                                    {{-- LEFT --}}
                                    <div class="research-add-column">

                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Judul Penelitian
                                                <span class="req">*</span>
                                            </label>

                                            <input type="text" name="judul" class="research-add-input"
                                                placeholder="Masukkan judul penelitian" value="{{ old('judul') }}">

                                            @error('judul')
                                                <span class="research-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Bidang Ilmu
                                                <span class="req">*</span>
                                            </label>

                                            <input type="text" name="bidang" class="research-add-input"
                                                placeholder="Contoh: Teknologi Informasi" value="{{ old('bidang') }}">

                                            @error('bidang')
                                                <span class="research-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Kategori
                                            </label>

                                            <input type="text" name="jeniskategori" class="research-add-input"
                                                value="Surat Pengajuan Penelitian" readonly>

                                        </div>


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Lokasi
                                                <span class="req">*</span>
                                            </label>

                                            <input type="text" name="lokasi" class="research-add-input"
                                                placeholder="Masukkan lokasi penelitian" value="{{ old('lokasi') }}">

                                            @error('lokasi')
                                                <span class="research-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Lama Penelitian
                                            </label>

                                            <div class="research-add-date-group">

                                                <input type="date" name="tanggal_mulai" class="research-add-input"
                                                    value="{{ old('tanggal_mulai') }}" required>

                                                <span class="research-add-date-separator">
                                                    <i class="fas fa-minus"></i>
                                                </span>

                                                <input type="date" name="tanggal_selesai" class="research-add-input"
                                                    value="{{ old('tanggal_selesai') }}" required>

                                            </div>

                                            @if ($errors->has('tanggal_mulai') || $errors->has('tanggal_selesai'))
                                                <span class="research-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $errors->first('tanggal_mulai') ?: $errors->first('tanggal_selesai') }}
                                                </span>
                                            @endif

                                        </div>


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Biaya
                                            </label>

                                            <input type="number" name="biaya" class="research-add-input"
                                                placeholder="Contoh: 1500000" min="0" step="any"
                                                value="{{ old('biaya') }}">

                                            <span class="research-add-help">
                                                Contoh penulisan nominal: 1500000.
                                            </span>

                                            @error('biaya')
                                                <span class="research-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        @php
                                            $cachedUppdf = old('cached_uppdf', session('cached_uppdf'));
                                            $cachedUppdfName = old('cached_uppdf_name', session('cached_uppdf_name'));
                                        @endphp

                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Unggah Laporan / Dokumen
                                            </label>

                                            <div class="research-add-file-wrap">

                                                @if ($cachedUppdf && $cachedUppdfName)
                                                    <input type="hidden" name="cached_uppdf" value="{{ $cachedUppdf }}">
                                                    <input type="hidden" name="cached_uppdf_name" value="{{ $cachedUppdfName }}">
                                                @endif

                                                <input type="file" name="uppdf" class="research-add-file-input"
                                                    id="uploadPenelitian" accept=".pdf,application/pdf"
                                                    data-p3m-upload
                                                    data-p3m-upload-preserve-accept
                                                    data-p3m-upload-name-id="uploadPenelitianName"
                                                    data-p3m-upload-label="Dokumen proposal"
                                                    data-p3m-upload-empty-label="{{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : 'Pilih file dokumen' }}"
                                                    data-p3m-cached-name="{{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : '' }}"
                                                    data-p3m-upload-formats="PDF"
                                                    data-p3m-upload-extensions="pdf"
                                                    data-p3m-upload-mime-types="application/pdf"
                                                    data-p3m-upload-max-bytes="5242880"
                                                    @if ($errors->has('uppdf')) data-p3m-upload-error="{{ $errors->first('uppdf') }}" @endif>

                                                <label for="uploadPenelitian" class="research-add-file-label">

                                                    <span class="research-add-file-copy">

                                                        <span class="research-add-file-icon">
                                                            <i class="fas fa-file-pdf" style="{{ $cachedUppdfName ? 'color: #16a34a;' : '' }}"></i>
                                                        </span>

                                                        <span class="research-add-file-name" id="uploadPenelitianName">
                                                            {{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : 'Pilih file dokumen' }}
                                                        </span>

                                                    </span>


                                                    <span class="research-add-file-browse">
                                                        <i class="fas fa-folder-open"></i>
                                                        {{ $cachedUppdfName ? 'Ganti File' : 'Pilih File' }}
                                                    </span>

                                                </label>

                                            </div>

                                            <span class="research-add-help">
                                                Hanya PDF · Maksimal ukuran file 5 MB.
                                            </span>

                                            @error('uppdf')
                                                <span class="research-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- RIGHT --}}
                                    <div class="research-add-column">

                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Nama Ketua
                                                <span class="req">*</span>
                                            </label>

                                            <input type="text" name="ketua" class="research-add-input"
                                                placeholder="Masukkan nama ketua" value="{{ old('ketua') }}">

                                            @error('ketua')
                                                <span class="research-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Jenis Kelamin
                                            </label>

                                            <select class="research-add-select" name="jeniskelamin">

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


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                NIDN
                                            </label>

                                            <input type="text" name="nidn" class="research-add-input"
                                                placeholder="Masukkan NIDN" value="{{ old('nidn') }}">

                                            @error('nidn')
                                                <span class="research-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Jabatan Fungsional
                                            </label>

                                            <select class="research-add-select" name="jabatan">

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
                                                <span class="research-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Program Studi
                                            </label>

                                            <select class="research-add-select" name="prodi">

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


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                No. Telepon
                                            </label>

                                            <input type="text" name="telp" class="research-add-input"
                                                placeholder="Masukkan nomor telepon" value="{{ old('telp') }}">

                                            @error('telp')
                                                <span class="research-add-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="research-add-field">

                                            <label class="research-add-label">
                                                Alamat
                                            </label>

                                            <input type="text" name="alamat" class="research-add-input"
                                                placeholder="Masukkan alamat" value="{{ old('alamat') }}">

                                            @error('alamat')
                                                <span class="research-add-error">
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

                            <section class="research-add-team">

                                <div class="research-add-team-head">

                                    <div class="research-add-team-title">

                                        <span class="research-add-team-icon">
                                            <i class="fas fa-users"></i>
                                        </span>

                                        <div>
                                            <strong>
                                                Anggota Penelitian
                                            </strong>

                                            <span>
                                                Tambahkan anggota yang terlibat dalam proposal.
                                            </span>
                                        </div>

                                    </div>


                                    <button type="button" onclick="addAnggota()" class="research-add-add-member">
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

                                <div id="anggota-wrapper" class="research-add-member-list">

                                    @foreach ($membersData as $i => $mem)
                                        <div class="research-add-member-card anggota-row">

                                            <div class="research-add-member-head">

                                                <span class="research-add-member-label">

                                                    <span class="research-add-member-index">
                                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                    </span>

                                                    Identitas Anggota

                                                </span>


                                                <button type="button" class="research-add-remove remove-anggota"
                                                    aria-label="Hapus anggota" title="Hapus anggota"
                                                    @if (count($membersData) <= 1) style="display: none;" @endif>
                                                    <i class="fas fa-times"></i>
                                                </button>

                                            </div>


                                            <div class="research-add-member-grid">

                                                <div class="research-add-field">

                                                    <label class="research-add-label">
                                                        Nama
                                                    </label>

                                                    <input type="text" class="research-add-input"
                                                        name="anggota[{{ $i }}][nama]" placeholder="Nama anggota"
                                                        value="{{ old("anggota.{$i}.nama", $mem['nama'] ?? '') }}">

                                                    @error("anggota.{$i}.nama")
                                                        <span class="research-add-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="research-add-field">

                                                    <label class="research-add-label">
                                                        Program Studi
                                                    </label>

                                                    <select class="research-add-select" name="anggota[{{ $i }}][prodi]">

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
                                                        <span class="research-add-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="research-add-field">

                                                    <label class="research-add-label">
                                                        NIM / NIDN
                                                    </label>

                                                    <input type="text" class="research-add-input"
                                                        name="anggota[{{ $i }}][nim]" placeholder="NIM / NIDN"
                                                        value="{{ old("anggota.{$i}.nim", $mem['nim'] ?? '') }}">

                                                    @error("anggota.{$i}.nim")
                                                        <span class="research-add-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="research-add-field">

                                                    <label class="research-add-label">
                                                        Jabatan
                                                    </label>

                                                    <select class="research-add-select" name="anggota[{{ $i }}][jabatan]">

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
                                                        <span class="research-add-error">
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


                        <div class="research-add-footer">

                            <div class="research-add-footer-note">

                                <i class="fas fa-info-circle"></i>

                                <span>
                                    Periksa kembali informasi sebelum mengirim pengajuan.
                                </span>

                            </div>


                            <button type="submit" class="research-add-submit">
                                <i class="fas fa-paper-plane"></i>
                                Submit Pengajuan
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
                    const number = row.querySelector('.research-add-member-index');
                    if (number) {
                        number.textContent = String(index + 1).padStart(2, '0');
                    }
                    const removeBtn = row.querySelector('.remove-anggota');
                    if (removeBtn) {
                        removeBtn.style.display = rows.length > 1 ? '' : 'none';
                    }
                });
            }

            function addAnggota() {
                const wrapper = document.getElementById('anggota-wrapper');
                if (!wrapper) {
                    return;
                }

                const index = getNextMemberIndex();

                const html = `
                <div class="research-add-member-card anggota-row">
                    <div class="research-add-member-head">
                        <span class="research-add-member-label">
                            <span class="research-add-member-index">00</span>
                            Identitas Anggota
                        </span>
                        <button
                            type="button"
                            class="research-add-remove remove-anggota"
                            aria-label="Hapus anggota"
                            title="Hapus anggota"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="research-add-member-grid">
                        <div class="research-add-field">
                            <label class="research-add-label">Nama</label>
                            <input
                                type="text"
                                class="research-add-input"
                                name="anggota[${index}][nama]"
                                placeholder="Nama anggota"
                            >
                        </div>
                        <div class="research-add-field">
                            <label class="research-add-label">Program Studi</label>
                            <select
                                class="research-add-select"
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
                        <div class="research-add-field">
                            <label class="research-add-label">NIM / NIDN</label>
                            <input
                                type="text"
                                class="research-add-input"
                                name="anggota[${index}][nim]"
                                placeholder="NIM / NIDN"
                            >
                        </div>
                        <div class="research-add-field">
                            <label class="research-add-label">Jabatan</label>
                            <select
                                class="research-add-select"
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
            }

            document.addEventListener('click', function(event) {
                const removeButton = event.target.closest('.remove-anggota');
                if (!removeButton) {
                    return;
                }

                const row = removeButton.closest('.anggota-row');
                if (!row) {
                    return;
                }

                const rows = document.querySelectorAll('#anggota-wrapper .anggota-row');
                if (rows.length <= 1) {
                    return;
                }

                row.remove();
                updateMemberNumbers();
            });

            window.updateMemberNumbers = updateMemberNumbers;
            window.addAnggota = addAnggota;

            document.addEventListener('DOMContentLoaded', function() {
                updateMemberNumbers();
            });
            document.addEventListener('turbo:load', function() {
                updateMemberNumbers();
            });
        })();
    </script>

@endsection
