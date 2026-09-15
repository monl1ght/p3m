@extends('layout.doslayout')

@section('body_class', 'page-dosen-addp3m')

@section('css')
    <style>
        /* =========================================================================
                       P3M DOSEN — FORM PROPOSAL PENGABDIAN
                       UI redesign only. Existing routes, field names, values and submit flow
                       are intentionally preserved.
                       ========================================================================= */

        :root {
            --addp3m-forest: #003d2d;
            --addp3m-forest-deep: #002e22;
            --addp3m-forest-mid: #00573b;
            --addp3m-forest-soft: #eaf5ee;
            --addp3m-gold: #b99835;
            --addp3m-ink: #0d1f1a;
            --addp3m-ink-2: #1e3328;
            --addp3m-text: #3b4f47;
            --addp3m-muted: #6b7f78;
            --addp3m-light: #9caaa4;
            --addp3m-border: #e4ede8;
            --addp3m-border-2: #d3e0d9;
            --addp3m-surface: #ffffff;
            --addp3m-surface-alt: #f7faf8;
            --addp3m-danger: #d94b4b;
            --addp3m-danger-soft: #fef2f2;
            --addp3m-danger-border: #f5c0c0;
            --addp3m-radius-sm: 8px;
            --addp3m-radius-md: 12px;
            --addp3m-radius-lg: 16px;
            --addp3m-radius-xl: 20px;
            --addp3m-radius-2xl: 24px;
        }

        /* -------------------------------------------------------------------------
                       PAGE
                       ------------------------------------------------------------------------- */

        .page-dosen-addp3m .content-wrapper {
            min-height: calc(100vh - 66px);
            background:
                radial-gradient(ellipse 70% 40% at 100% 0%,
                    rgba(0, 93, 59, .06),
                    transparent),
                linear-gradient(180deg,
                    #f2f8f5 0%,
                    #f7faf8 100%) !important;
        }

        .addp3m-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-addp3m .content-header {
            padding: 26px 0 10px !important;
        }

        .page-dosen-addp3m .content {
            padding: 6px 0 36px !important;
        }

        /* -------------------------------------------------------------------------
                       HEADING
                       ------------------------------------------------------------------------- */

        .addp3m-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .addp3m-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 9px;
            color: var(--addp3m-forest-mid);
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .addp3m-eyebrow::before {
            content: "";
            width: 20px;
            height: 2.5px;
            border-radius: 99px;
            background: var(--addp3m-gold);
        }

        .addp3m-heading h1 {
            margin: 0;
            color: var(--addp3m-ink);
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: clamp(28px, 3vw, 36px);
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -.045em;
        }

        .addp3m-heading p {
            margin: 7px 0 0;
            color: var(--addp3m-muted);
            font-size: 12.5px;
            line-height: 1.55;
        }

        .addp3m-breadcrumb {
            margin: 0;
            padding: 0;
            background: transparent;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .addp3m-breadcrumb a {
            color: var(--addp3m-forest);
            text-decoration: none;
        }

        .addp3m-breadcrumb .active {
            color: var(--addp3m-muted);
        }

        .addp3m-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            padding: 0 8px;
            color: var(--addp3m-border-2);
        }

        /* -------------------------------------------------------------------------
                       MAIN CARD
                       ------------------------------------------------------------------------- */

        .addp3m-card {
            overflow: hidden;
            border: 1px solid var(--addp3m-border);
            border-radius: var(--addp3m-radius-2xl);
            background: var(--addp3m-surface);
            box-shadow:
                0 20px 56px rgba(3, 50, 33, .12),
                0 4px 12px rgba(0, 0, 0, .06);
        }

        .addp3m-card-head {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 24px 30px;
            overflow: hidden;
            background: linear-gradient(112deg, #ffffff 55%, #f0faf5 100%);
            border-bottom: 1px solid var(--addp3m-border);
        }

        .addp3m-card-head::after {
            content: "";
            position: absolute;
            top: -55px;
            right: -55px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 93, 59, .055), transparent 70%);
            pointer-events: none;
        }

        .addp3m-title-group {
            position: relative;
            z-index: 1;
        }

        .addp3m-card-title {
            margin: 0;
            color: var(--addp3m-ink);
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 18px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -.025em;
        }

        .addp3m-card-subtitle {
            margin: 5px 0 0;
            color: var(--addp3m-muted);
            font-size: 11.5px;
            line-height: 1.45;
        }

        .addp3m-secure-chip {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border: 1px solid var(--addp3m-border);
            border-radius: var(--addp3m-radius-md);
            background: rgba(255, 255, 255, .78);
            color: var(--addp3m-forest-mid);
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .addp3m-secure-chip i {
            font-size: 11px;
        }

        /* -------------------------------------------------------------------------
                       FORM BODY
                       ------------------------------------------------------------------------- */

        .addp3m-card-body {
            padding: 28px 30px 8px;
        }

        .addp3m-section {
            margin-bottom: 28px;
        }

        .addp3m-section:last-child {
            margin-bottom: 8px;
        }

        .addp3m-section-head {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 18px;
        }

        .addp3m-section-head .addp3m-section-number {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #eef6f1;
            color: var(--addp3m-forest);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            margin: 0; /* Reset margin from generic span */
        }

        .addp3m-section-head strong {
            display: block;
            color: var(--addp3m-ink-2);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            line-height: 1.2;
            font-weight: 800;
        }

        .addp3m-section-head span {
            display: block;
            margin-top: 3px;
            color: var(--addp3m-muted);
            font-size: 10px;
            line-height: 1.35;
        }

        .addp3m-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 30px;
        }

        .addp3m-column {
            min-width: 0;
            padding: 0 2px;
        }

        .addp3m-column+.addp3m-column {
            padding-left: 28px;
            border-left: 1px solid #eaf0ed;
        }

        .addp3m-field {
            margin-bottom: 18px;
        }

        .addp3m-field:last-child {
            margin-bottom: 0;
        }

        .addp3m-label {
            display: block;
            margin-bottom: 7px;
            color: var(--addp3m-ink-2);
            font-size: 11px;
            line-height: 1.3;
            font-weight: 800;
        }

        .addp3m-label .req {
            color: var(--addp3m-danger);
            margin-left: 2px;
        }

        .addp3m-input,
        .addp3m-select {
            width: 100%;
            min-height: 42px;
            padding: 9px 12px;
            border: 1px solid var(--addp3m-border-2);
            border-radius: var(--addp3m-radius-md);
            outline: none;
            background: #fff;
            color: var(--addp3m-ink);
            font-family: inherit;
            font-size: 12px;
            font-weight: 500;
            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .addp3m-input::placeholder {
            color: var(--addp3m-light);
        }

        .addp3m-input:hover,
        .addp3m-select:hover {
            border-color: #c5d6cd;
        }

        .addp3m-input:focus,
        .addp3m-select:focus {
            border-color: var(--addp3m-forest-mid);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 87, 59, .09);
        }

        .addp3m-input[readonly] {
            background: #f4f7f6;
            color: #667a72;
            cursor: default;
        }

        .addp3m-help {
            display: block;
            margin-top: 6px;
            color: var(--addp3m-light);
            font-size: 9.5px;
            line-height: 1.4;
        }

        .addp3m-error {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            margin-top: 6px;
            color: var(--addp3m-danger);
            font-size: 10px;
            line-height: 1.4;
        }

        .addp3m-error i {
            margin-top: 1px;
            font-size: 9px;
        }

        /* Date group */
        .addp3m-date-group {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
            gap: 8px;
            align-items: center;
        }

        .addp3m-date-separator {
            color: var(--addp3m-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        /* File */
        .addp3m-file-wrap {
            position: relative;
        }

        .addp3m-file-input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
        }

        .addp3m-file-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-height: 46px;
            padding: 8px 10px 8px 12px;
            border: 1px dashed #bfd4c8;
            border-radius: var(--addp3m-radius-md);
            background: #f8fbf9;
            cursor: pointer;
            transition:
                border-color .18s ease,
                background .18s ease,
                transform .18s ease;
        }

        .addp3m-file-label:hover {
            border-color: #9fbead;
            background: #f0f7f3;
            transform: translateY(-1px);
        }

        .addp3m-file-copy {
            display: flex;
            align-items: center;
            gap: 9px;
            min-width: 0;
        }

        .addp3m-file-icon {
            width: 30px;
            height: 30px;
            flex: 0 0 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: var(--addp3m-forest-soft);
            color: var(--addp3m-forest-mid);
            font-size: 12px;
        }

        .addp3m-file-name {
            min-width: 0;
            overflow: hidden;
            color: var(--addp3m-text);
            font-size: 10.5px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .addp3m-file-browse {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border: 1px solid var(--addp3m-border-2);
            border-radius: 9px;
            background: #fff;
            color: var(--addp3m-forest);
            font-size: 9.5px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* -------------------------------------------------------------------------
                       TEAM SECTION
                       ------------------------------------------------------------------------- */

        .addp3m-team-section {
            padding-top: 23px;
            border-top: 1px solid #eaf0ed;
        }

        .addp3m-team-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .addp3m-team-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .addp3m-team-title i {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #eef6f1;
            color: var(--addp3m-forest);
            font-size: 12px;
        }

        .addp3m-team-title strong {
            color: var(--addp3m-ink-2);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .addp3m-team-title span {
            display: block;
            margin-top: 2px;
            color: var(--addp3m-muted);
            font-size: 9.5px;
        }

        .addp3m-add-member {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-height: 34px;
            padding: 0 11px;
            border: 1px solid #c7ddd0;
            border-radius: 9px;
            background: #fff;
            color: var(--addp3m-forest);
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            transition: .18s ease;
        }

        .addp3m-add-member:hover {
            background: var(--addp3m-forest-soft);
            border-color: #aec9bb;
            transform: translateY(-1px);
        }

        .addp3m-member-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .addp3m-member-card {
            padding: 15px 16px;
            border: 1px solid var(--addp3m-border);
            border-radius: 14px;
            background: #fbfdfc;
        }

        .addp3m-member-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 13px;
        }

        .addp3m-member-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--addp3m-ink-2);
            font-size: 11px;
            font-weight: 800;
        }

        .addp3m-member-index {
            width: 23px;
            height: 23px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            background: #eaf5ee;
            color: var(--addp3m-forest);
            font-size: 9px;
            font-weight: 800;
        }

        .addp3m-remove-member {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #f1d2d2;
            border-radius: 8px;
            background: #fff7f7;
            color: var(--addp3m-danger);
            font-size: 10px;
            cursor: pointer;
            transition: .18s ease;
        }

        .addp3m-remove-member:hover {
            background: #fdeeee;
            border-color: #eabcbc;
        }

        .addp3m-member-grid {
            display: grid;
            grid-template-columns: 1.15fr 1fr .85fr .95fr;
            gap: 12px;
        }

        /* -------------------------------------------------------------------------
                       FOOTER
                       ------------------------------------------------------------------------- */

        .addp3m-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 17px 30px;
            border-top: 1px solid var(--addp3m-border);
            background: var(--addp3m-surface-alt);
        }

        .addp3m-footer-note {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--addp3m-muted);
            font-size: 10px;
            line-height: 1.4;
        }

        .addp3m-footer-note i {
            color: var(--addp3m-forest-mid);
        }

        .addp3m-submit {
            min-height: 41px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 16px;
            border: 1px solid var(--addp3m-forest);
            border-radius: var(--addp3m-radius-md);
            background: var(--addp3m-forest);
            color: #fff;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(0, 61, 45, .18);
            transition: .18s ease;
        }

        .addp3m-submit:hover {
            background: var(--addp3m-forest-deep);
            border-color: var(--addp3m-forest-deep);
            transform: translateY(-1px);
            box-shadow: 0 9px 20px rgba(0, 61, 45, .23);
        }

        /* -------------------------------------------------------------------------
                       RESPONSIVE
                       ------------------------------------------------------------------------- */

        @media (max-width: 991.98px) {
            .addp3m-shell {
                width: calc(100% - 34px);
            }

            .addp3m-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            .addp3m-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .addp3m-column+.addp3m-column {
                padding-left: 0;
                padding-top: 24px;
                border-left: 0;
                border-top: 1px solid #eaf0ed;
            }

            .addp3m-member-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .addp3m-shell {
                width: calc(100% - 24px);
            }

            .addp3m-card {
                border-radius: var(--addp3m-radius-lg);
            }

            .addp3m-card-head {
                align-items: flex-start;
                flex-direction: column;
                padding: 20px 19px 17px;
            }

            .addp3m-card-body {
                padding: 22px 19px 7px;
            }

            .addp3m-card-footer {
                align-items: stretch;
                flex-direction: column;
                padding: 15px 19px 18px;
            }

            .addp3m-submit {
                width: 100%;
            }

            .addp3m-team-toolbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .addp3m-add-member {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 575.98px) {
            .addp3m-shell {
                width: calc(100% - 18px);
            }

            .addp3m-heading h1 {
                font-size: 28px;
            }

            .addp3m-date-group {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .addp3m-date-separator {
                text-align: center;
            }

            .addp3m-member-grid {
                grid-template-columns: 1fr;
            }

            .addp3m-file-label {
                align-items: flex-start;
                flex-direction: column;
            }

            .addp3m-file-browse {
                width: 100%;
                justify-content: center;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .page-dosen-addp3m *,
            .page-dosen-addp3m *::before,
            .page-dosen-addp3m *::after {
                transition: none !important;
            }
        }
    </style>
@endsection


@section('content')

    <div class="content-wrapper">

        <div class="content-header">

            <div class="addp3m-shell">

                <div class="addp3m-heading">

                    <div>
                        <span class="addp3m-eyebrow">
                            Pengabdian Masyarakat
                        </span>

                        <h1>
                            {{ $pagetitle }}
                        </h1>

                        <p>
                            Lengkapi informasi proposal dan data ketua pengusul sebelum mengirimkan pengajuan.
                        </p>
                    </div>

                    <ol class="breadcrumb addp3m-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dosen.upp3m') }}">Home</a>
                        </li>

                        <li class="breadcrumb-item active">
                            {{ $pagetitle }}
                        </li>
                    </ol>

                </div>

            </div>

        </div>


        <section class="content">

            <div class="addp3m-shell">

                <form action="{{ route('dosen.storep3m') }}" method="post" enctype="multipart/form-data" id="addp3mForm">

                    @csrf


                    <div class="addp3m-card">

                        <div class="addp3m-card-head">

                            <div class="addp3m-title-group">

                                <h2 class="addp3m-card-title">
                                    P3M Polibang Jepara
                                </h2>

                                <p class="addp3m-card-subtitle">
                                    Form pengajuan proposal pengabdian masyarakat.
                                </p>

                            </div>

                            <div class="addp3m-secure-chip">
                                <i class="fas fa-shield-alt"></i>
                                Data tersimpan secara aman
                            </div>

                        </div>


                        <div class="addp3m-card-body">

                            {{-- =====================================================
                             MAIN INFORMATION
                        ====================================================== --}}

                            <section class="addp3m-section">

                                <div class="addp3m-section-head">
                                    <span class="addp3m-section-number">01</span>

                                    <div>
                                        <strong>Informasi Pengajuan</strong>
                                        <span>Detail utama proposal pengabdian masyarakat.</span>
                                    </div>
                                </div>


                                <div class="addp3m-grid">

                                    {{-- Left --}}
                                    <div class="addp3m-column">

                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Judul Pengabdian <span class="req">*</span>
                                            </label>

                                            <input type="text" name="judul" class="addp3m-input"
                                                placeholder="Masukkan judul pengabdian" value="{{ old('judul') }}">

                                            @error('judul')
                                                <span class="addp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Bidang Ilmu <span class="req">*</span>
                                            </label>

                                            <input type="text" name="bidang" class="addp3m-input"
                                                placeholder="Contoh: Teknologi Informasi" value="{{ old('bidang') }}">

                                            @error('bidang')
                                                <span class="addp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Kategori
                                            </label>

                                            <input type="text" name="jeniskategori" class="addp3m-input"
                                                value="Pengajuan Pengabdian Masyarakat" readonly>

                                        </div>


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Lokasi <span class="req">*</span>
                                            </label>

                                            <input type="text" name="lokasi" class="addp3m-input"
                                                placeholder="Masukkan lokasi pengabdian" value="{{ old('lokasi') }}">

                                            @error('lokasi')
                                                <span class="addp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Lama Pelaksanaan
                                            </label>

                                            <div class="addp3m-date-group">

                                                <input type="date" name="tanggal_mulai" class="addp3m-input"
                                                    value="{{ old('tanggal_mulai') }}" required>

                                                <span class="addp3m-date-separator">
                                                    <i class="fas fa-minus"></i>
                                                </span>

                                                <input type="date" name="tanggal_selesai" class="addp3m-input"
                                                    value="{{ old('tanggal_selesai') }}" required>

                                            </div>

                                            @if ($errors->has('tanggal_mulai') || $errors->has('tanggal_selesai'))
                                                <span class="addp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $errors->first('tanggal_mulai') ?: $errors->first('tanggal_selesai') }}
                                                </span>
                                            @endif

                                        </div>


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Biaya
                                            </label>

                                            <input type="number" name="biaya" class="addp3m-input"
                                                placeholder="Contoh: 1500000" min="0" step="any"
                                                value="{{ old('biaya') }}">

                                            <span class="addp3m-help">
                                                Masukkan nominal dalam angka, contoh 1500000.
                                            </span>

                                            @error('biaya')
                                                <span class="addp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        @php
                                            $cachedUppdf = old('cached_uppdf', session('cached_uppdf'));
                                            $cachedUppdfName = old('cached_uppdf_name', session('cached_uppdf_name'));
                                        @endphp

                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Unggah Laporan
                                            </label>

                                            <div class="addp3m-file-wrap">

                                                @if ($cachedUppdf && $cachedUppdfName)
                                                    <input type="hidden" name="cached_uppdf" value="{{ $cachedUppdf }}">
                                                    <input type="hidden" name="cached_uppdf_name" value="{{ $cachedUppdfName }}">
                                                @endif

                                                <input type="file" name="uppdf" id="uploadLaporan"
                                                    class="addp3m-file-input" accept=".pdf,application/pdf"
                                                    data-p3m-upload
                                                    data-p3m-upload-preserve-accept
                                                    data-p3m-upload-name-id="uploadLaporanName"
                                                    data-p3m-upload-label="Dokumen proposal"
                                                    data-p3m-upload-empty-label="{{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : 'Pilih file laporan' }}"
                                                    data-p3m-cached-name="{{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : '' }}"
                                                    data-p3m-upload-formats="PDF"
                                                    data-p3m-upload-extensions="pdf"
                                                    data-p3m-upload-mime-types="application/pdf"
                                                    data-p3m-upload-max-bytes="5242880"
                                                    @if ($errors->has('uppdf')) data-p3m-upload-error="{{ $errors->first('uppdf') }}" @endif>

                                                <label for="uploadLaporan" class="addp3m-file-label">

                                                    <span class="addp3m-file-copy">

                                                        <span class="addp3m-file-icon">
                                                            <i class="fas fa-file-pdf" style="{{ $cachedUppdfName ? 'color: #16a34a;' : '' }}"></i>
                                                        </span>

                                                        <span class="addp3m-file-name" id="uploadLaporanName">
                                                            {{ $cachedUppdfName ? $cachedUppdfName . ' (Tersimpan)' : 'Pilih file laporan' }}
                                                        </span>

                                                    </span>

                                                    <span class="addp3m-file-browse">
                                                        <i class="fas fa-folder-open"></i>
                                                        {{ $cachedUppdfName ? 'Ganti File' : 'Pilih File' }}
                                                    </span>

                                                </label>

                                            </div>

                                            <span class="addp3m-help">
                                                Hanya PDF · Maksimal ukuran file 5 MB.
                                            </span>

                                            @error('uppdf')
                                                <span class="addp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- Right --}}
                                    <div class="addp3m-column">

                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Nama Ketua <span class="req">*</span>
                                            </label>

                                            <input type="text" name="ketua" class="addp3m-input"
                                                placeholder="Masukkan nama ketua" value="{{ old('ketua') }}">

                                            @error('ketua')
                                                <span class="addp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Jenis Kelamin
                                            </label>

                                            <select class="addp3m-select" name="jeniskelamin">

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


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                NIDN
                                            </label>

                                            <input type="text" name="nidn" class="addp3m-input"
                                                placeholder="Masukkan NIDN" value="{{ old('nidn') }}">

                                            @error('nidn')
                                                <span class="addp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Jabatan Fungsional
                                            </label>

                                            <select class="addp3m-select" name="jabatan">

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
                                                <span class="addp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Program Studi
                                            </label>

                                            <select class="addp3m-select" name="prodi">

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


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                No. Telepon
                                            </label>

                                            <input type="text" name="telp" class="addp3m-input"
                                                placeholder="Masukkan nomor telepon" value="{{ old('telp') }}">

                                            @error('telp')
                                                <span class="addp3m-error">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>


                                        <div class="addp3m-field">

                                            <label class="addp3m-label">
                                                Alamat
                                            </label>

                                            <input type="text" name="alamat" class="addp3m-input"
                                                placeholder="Masukkan alamat" value="{{ old('alamat') }}">

                                            @error('alamat')
                                                <span class="addp3m-error">
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

                            <section class="addp3m-team-section">

                                <div class="addp3m-team-toolbar">

                                    <div class="addp3m-team-title">

                                        <i class="fas fa-users"></i>

                                        <div>
                                            <strong>Anggota Pengabdian Masyarakat</strong>
                                            <span>Tambahkan anggota yang terlibat dalam proposal.</span>
                                        </div>

                                    </div>


                                    <button type="button" onclick="addAnggota()" class="addp3m-add-member">
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

                                <div id="anggota-wrapper" class="addp3m-member-list">

                                    @foreach ($membersData as $i => $mem)
                                        <div class="addp3m-member-card anggota-row">

                                            <div class="addp3m-member-head">

                                                <span class="addp3m-member-label">
                                                    <span class="addp3m-member-index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                                    Identitas Anggota
                                                </span>

                                                <button type="button" class="addp3m-remove-member remove-anggota"
                                                    aria-label="Hapus anggota" title="Hapus anggota"
                                                    @if (count($membersData) <= 1) style="display: none;" @endif>
                                                    <i class="fas fa-times"></i>
                                                </button>

                                            </div>


                                            <div class="addp3m-member-grid">

                                                <div class="addp3m-field">

                                                    <label class="addp3m-label">
                                                        Nama
                                                    </label>

                                                    <input type="text" class="addp3m-input" name="anggota[{{ $i }}][nama]"
                                                        placeholder="Nama anggota" value="{{ old("anggota.{$i}.nama", $mem['nama'] ?? '') }}">

                                                    @error("anggota.{$i}.nama")
                                                        <span class="addp3m-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="addp3m-field">

                                                    <label class="addp3m-label">
                                                        Program Studi
                                                    </label>

                                                    <select class="addp3m-select" name="anggota[{{ $i }}][prodi]">

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
                                                        <span class="addp3m-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="addp3m-field">

                                                    <label class="addp3m-label">
                                                        NIM / NIDN
                                                    </label>

                                                    <input type="text" class="addp3m-input" name="anggota[{{ $i }}][nim]"
                                                        placeholder="NIM / NIDN" value="{{ old("anggota.{$i}.nim", $mem['nim'] ?? '') }}">

                                                    @error("anggota.{$i}.nim")
                                                        <span class="addp3m-error">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </span>
                                                    @enderror

                                                </div>


                                                <div class="addp3m-field">

                                                    <label class="addp3m-label">
                                                        Jabatan
                                                    </label>

                                                    <select class="addp3m-select" name="anggota[{{ $i }}][jabatan]">

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
                                                        <span class="addp3m-error">
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


                        {{-- =====================================================
                         FOOTER
                    ====================================================== --}}

                        <div class="addp3m-card-footer">

                            <div class="addp3m-footer-note">
                                <i class="fas fa-info-circle"></i>
                                <span>Periksa kembali informasi sebelum mengirim proposal.</span>
                            </div>


                            <button type="submit" class="addp3m-submit">
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
                    const number = row.querySelector('.addp3m-member-index');
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
                <div class="addp3m-member-card anggota-row">
                    <div class="addp3m-member-head">
                        <span class="addp3m-member-label">
                            <span class="addp3m-member-index">00</span>
                            Identitas Anggota
                        </span>
                        <button
                            type="button"
                            class="addp3m-remove-member remove-anggota"
                            aria-label="Hapus anggota"
                            title="Hapus anggota"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="addp3m-member-grid">
                        <div class="addp3m-field">
                            <label class="addp3m-label">Nama</label>
                            <input
                                type="text"
                                class="addp3m-input"
                                name="anggota[${index}][nama]"
                                placeholder="Nama anggota"
                            >
                        </div>
                        <div class="addp3m-field">
                            <label class="addp3m-label">Program Studi</label>
                            <select
                                class="addp3m-select"
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
                        <div class="addp3m-field">
                            <label class="addp3m-label">NIM / NIDN</label>
                            <input
                                type="text"
                                class="addp3m-input"
                                name="anggota[${index}][nim]"
                                placeholder="NIM / NIDN"
                            >
                        </div>
                        <div class="addp3m-field">
                            <label class="addp3m-label">Jabatan</label>
                            <select
                                class="addp3m-select"
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

            const uploadInput = document.getElementById('uploadLaporan');
            const uploadName = document.getElementById('uploadLaporanName');

            if (uploadInput && uploadName) {
                uploadInput.addEventListener('change', function(event) {
                    const file = event.target.files && event.target.files[0];
                    uploadName.textContent = file ? file.name : (uploadInput.dataset.p3mCachedName || 'Pilih file laporan');
                });
            }

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
