@extends('layout.doslayout')

@section('title', 'Edit HKI: ' . $hki->judul . ' - P3M Politeknik Balekambang')
@section('body_class', 'page-dosen-hki-form')

@section('css')
    <style>
        /* =========================================================================
           P3M DOSEN — FORM EDIT HKI
           Enterprise UI/UX Harmonized System (Consistent with Master Dosen Workspace)
           ========================================================================= */

        :root {
            --p3m-form-forest: #003d2d;
            --p3m-form-forest-deep: #002e22;
            --p3m-form-forest-mid: #00573b;
            --p3m-form-forest-soft: #eaf5ee;
            --p3m-form-gold: #b99835;
            --p3m-form-ink: #0f172a;
            --p3m-form-ink-2: #1e293b;
            --p3m-form-text: #334155;
            --p3m-form-muted: #64748b;
            --p3m-form-light: #94a3b8;
            --p3m-form-border: #e2ece6;
            --p3m-form-border-2: #cbd5e1;
            --p3m-form-surface: #ffffff;
            --p3m-form-surface-alt: #f8fafc;
            --p3m-form-surface-hover: #f1f5f9;
            --p3m-form-danger: #dc2626;
            --p3m-form-danger-bg: #fef2f2;
            --p3m-form-danger-border: #fecaca;
            --p3m-form-r-sm: 8px;
            --p3m-form-r-md: 12px;
            --p3m-form-r-lg: 16px;
            --p3m-form-r-xl: 20px;
            --p3m-form-r-2xl: 24px;
        }

        .page-dosen-hki-form .content-wrapper {
            min-height: calc(100vh - 66px);
            background:
                radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0, 93, 59, .05), transparent 70%),
                linear-gradient(180deg, #f2f8f5 0%, #f7faf8 100%) !important;
        }

        .page-dosen-hki-form .hki-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-hki-form .content-header {
            padding: 24px 0 14px !important;
        }

        .page-dosen-hki-form section.content {
            padding: 0 0 40px !important;
        }

        /* ── Breadcrumb ── */
        .page-dosen-hki-form .hki-breadcrumb {
            margin: 0;
            padding: 0;
            background: transparent;
            font-size: 12.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .page-dosen-hki-form .hki-breadcrumb .breadcrumb-item a {
            color: var(--p3m-form-forest-mid);
            text-decoration: none;
            transition: opacity .18s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .page-dosen-hki-form .hki-breadcrumb .breadcrumb-item a:hover {
            opacity: .75;
        }

        .page-dosen-hki-form .hki-breadcrumb .breadcrumb-item.active {
            color: var(--p3m-form-muted);
        }

        .page-dosen-hki-form .hki-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            content: "/";
            padding: 0 8px;
            color: var(--p3m-form-border-2);
        }

        /* ── Card Container ── */
        .page-dosen-hki-form .hki-card {
            background: var(--p3m-form-surface);
            border: 1px solid var(--p3m-form-border);
            border-radius: var(--p3m-form-r-2xl);
            box-shadow: 0 12px 36px rgba(3, 50, 33, .07), 0 2px 6px rgba(0, 0, 0, .02);
            overflow: hidden;
        }

        .page-dosen-hki-form .hki-card-head {
            padding: 26px 36px 22px;
            background: linear-gradient(112deg, #ffffff 60%, #f4faf6 100%);
            border-bottom: 1px solid var(--p3m-form-border);
        }

        .page-dosen-hki-form .hki-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
            color: var(--p3m-form-forest-mid);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .page-dosen-hki-form .hki-kicker::before {
            content: "";
            width: 18px;
            height: 2.5px;
            border-radius: 99px;
            background: var(--p3m-form-gold);
        }

        .page-dosen-hki-form .hki-card-title {
            margin: 0 0 6px;
            color: var(--p3m-form-ink);
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 22px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .page-dosen-hki-form .hki-card-subtitle {
            margin: 0;
            color: var(--p3m-form-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .page-dosen-hki-form .hki-form-body {
            padding: 36px;
        }


        /* ── Form Section Header ── */
        .form-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            margin-bottom: 22px;
            border-bottom: 2px solid var(--p3m-form-border);
        }

        .form-section-title {
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: var(--p3m-form-forest-deep);
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .form-section-title i {
            color: var(--p3m-form-forest-mid);
            font-size: 15px;
        }

        /* ── Form Groups & Controls ── */
        .form-group-custom {
            margin-bottom: 24px;
        }

        .form-label-custom {
            display: block;
            margin-bottom: 8px;
            color: var(--p3m-form-ink-2);
            font-size: 13px;
            font-weight: 700;
        }

        .form-label-custom .required {
            color: var(--p3m-form-danger);
            margin-left: 2px;
        }

        .form-control-custom {
            width: 100%;
            height: 46px;
            padding: 0 16px;
            border: 1.5px solid var(--p3m-form-border-2);
            border-radius: var(--p3m-form-r-md);
            font-size: 13.5px;
            color: var(--p3m-form-ink);
            background: var(--p3m-form-surface);
            outline: none;
            transition: all .18s ease;
        }

        .form-control-custom:focus {
            border-color: var(--p3m-form-forest-mid);
            box-shadow: 0 0 0 3px rgba(0, 87, 59, .12);
        }

        .form-control-custom.is-invalid {
            border-color: var(--p3m-form-danger);
            background-color: #fffbfa;
        }

        .form-control-custom.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, .12);
        }

        .invalid-feedback-custom {
            margin-top: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--p3m-form-danger);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-help-text {
            margin-top: 6px;
            font-size: 12px;
            color: var(--p3m-form-muted);
        }

        /* ── Anggota Dynamic Repeater ── */
        .anggota-repeater-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-bottom: 16px;
        }

        .anggota-card-item {
            background: var(--p3m-form-surface-alt);
            border: 1.5px solid var(--p3m-form-border);
            border-radius: var(--p3m-form-r-md);
            padding: 18px 20px;
            position: relative;
            transition: border-color .18s ease;
        }

        .anggota-card-item:hover {
            border-color: #b7d6c6;
        }

        .anggota-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px dashed var(--p3m-form-border-2);
        }

        .anggota-badge-order {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 800;
            color: var(--p3m-form-forest-deep);
            background: #e2efe8;
            padding: 3px 10px;
            border-radius: 6px;
        }

        .btn-remove-anggota {
            background: none;
            border: none;
            color: #ef4444;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all .16s ease;
        }

        .btn-remove-anggota:hover:not(:disabled) {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-remove-anggota:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .btn-add-anggota {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border: 1.5px dashed var(--p3m-form-forest-mid);
            border-radius: var(--p3m-form-r-md);
            background: var(--p3m-form-forest-soft);
            color: var(--p3m-form-forest-mid);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .18s ease;
        }

        .btn-add-anggota:hover {
            background: #d8ede0;
            border-color: var(--p3m-form-forest-deep);
            color: var(--p3m-form-forest-deep);
            transform: translateY(-1px);
        }

        /* ── Existing File Card ── */
        .existing-file-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-radius: 12px;
            background: #f1f5f9;
            border: 1.5px solid #cbd5e1;
            margin-bottom: 16px;
            gap: 16px;
        }

        .existing-file-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .existing-file-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #fee2e2;
            color: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .existing-file-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--p3m-form-ink);
            word-break: break-all;
        }

        .existing-file-sub {
            font-size: 12px;
            color: var(--p3m-form-muted);
            margin-top: 2px;
        }

        .btn-download-existing {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            background: #ffffff;
            border: 1.5px solid #94a3b8;
            color: #334155;
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none !important;
            transition: all .16s ease;
            white-space: nowrap;
        }

        .btn-download-existing:hover {
            background: var(--p3m-form-forest-soft);
            color: var(--p3m-form-forest-mid);
            border-color: var(--p3m-form-forest-mid);
        }

        /* ── File Upload Dropzone ── */
        .sr-only-file-input {
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            padding: 0 !important;
            margin: -1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            white-space: nowrap !important;
            border: 0 !important;
            opacity: 0 !important;
        }

        .upload-dropzone {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 34px 24px;
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            background: #f8fafc;
            cursor: pointer;
            text-align: center;
            transition: all .2s ease;
            margin-bottom: 0;
            width: 100%;
        }

        .upload-dropzone:hover,
        .upload-dropzone.dragover {
            border-color: var(--p3m-form-forest-mid);
            background: #f0f7f3;
            transform: translateY(-1px);
        }

        .upload-dropzone.has-error {
            border-color: var(--p3m-form-danger);
            background: #fef2f2;
        }

        .upload-dropzone-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            color: #475569;
            font-size: 20px;
            transition: all .2s ease;
        }

        .upload-dropzone:hover .upload-dropzone-icon,
        .upload-dropzone.dragover .upload-dropzone-icon {
            background: var(--p3m-form-forest-soft);
            color: var(--p3m-form-forest-mid);
        }

        .upload-dropzone-text {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--p3m-form-ink);
            margin-bottom: 3px;
        }

        .upload-dropzone-sub {
            font-size: 12px;
            color: var(--p3m-form-muted);
        }

        /* ── File Preview Box ── */
        .upload-file-preview {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border: 1.5px solid #a7c4b5;
            border-radius: 14px;
            background: #f0f7f3;
            gap: 16px;
        }

        .upload-file-preview.active {
            display: flex;
        }

        .upload-file-preview-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .preview-pdf-badge {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #fee2e2;
            color: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .upload-file-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--p3m-form-ink);
            word-break: break-all;
        }

        .upload-file-size {
            font-size: 12px;
            color: var(--p3m-form-forest-mid);
            font-weight: 600;
            margin-top: 2px;
        }

        .btn-change-file {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: 1.5px solid #d3e0d9;
            border-radius: 10px;
            background: #ffffff;
            color: var(--p3m-form-text);
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .18s ease;
            white-space: nowrap;
        }

        .btn-change-file:hover {
            border-color: #dc2626;
            color: #dc2626;
            background: #fff5f5;
        }

        /* ── Form Footer ── */
        .hki-form-footer {
            padding: 22px 36px;
            background: #f8fafc;
            border-top: 1px solid var(--p3m-form-border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 14px;
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 22px;
            border: 1.5px solid var(--p3m-form-border-2);
            border-radius: var(--p3m-form-r-md);
            background: #ffffff;
            color: var(--p3m-form-text);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none !important;
            transition: all .18s ease;
        }

        .btn-cancel:hover {
            background: var(--p3m-form-surface-alt);
            color: var(--p3m-form-ink);
            border-color: #94a3b8;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 26px;
            border: none;
            border-radius: var(--p3m-form-r-md);
            background: linear-gradient(135deg, var(--p3m-form-forest) 0%, var(--p3m-form-forest-mid) 100%);
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(0, 61, 45, .22);
            transition: all .18s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, var(--p3m-form-forest-deep) 0%, var(--p3m-form-forest) 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 46, 34, .28);
        }

        @media (max-width: 767.98px) {
            .page-dosen-hki-form .hki-card-head,
            .page-dosen-hki-form .hki-form-body,
            .page-dosen-hki-form .hki-form-footer {
                padding: 20px 18px;
            }
            .hki-form-footer {
                flex-direction: column-reverse;
            }
            .btn-cancel, .btn-submit {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">

        {{-- Content Header & Breadcrumbs --}}
        <div class="content-header">
            <div class="hki-shell">
                <ol class="breadcrumb hki-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dosen.dash') }}">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('dosen.hki.index') }}">Hak Kekayaan Intelektual</a>
                    </li>
                    <li class="breadcrumb-item active">Edit HKI #{{ str_pad($hki->id, 3, '0', STR_PAD_LEFT) }}</li>
                </ol>
            </div>
        </div>

        {{-- Main Content Section --}}
        <section class="content">
            <div class="hki-shell">

                <div class="hki-card">

                    {{-- CARD HEADER --}}
                    <div class="hki-card-head">
                        <div class="hki-kicker">Formulir Perubahan Data</div>
                        <h1 class="hki-card-title">Edit Hak Kekayaan Intelektual (HKI)</h1>
                        <p class="hki-card-subtitle">
                            Perbarui identitas ciptaan, tanggal, susunan anggota/pencipta, atau ganti berkas sertifikat resmi.
                        </p>
                    </div>


                    {{-- ERROR CALLOUT IF VALIDATION FAILS --}}
                    @if ($errors->any())
                        <div style="margin: 24px 36px 0; padding: 16px 20px; border-radius: var(--p3m-form-r-md); background: #fef2f2; border: 1.5px solid #fecaca;">
                            <div style="display: flex; align-items: center; gap: 10px; color: #b91c1c; font-weight: 700; font-size: 13.5px; margin-bottom: 6px;">
                                <i class="fas fa-exclamation-circle"></i>
                                Terdapat beberapa kesalahan pengisian formulir:
                            </div>
                            <ul style="margin: 0; padding-left: 24px; color: #991b1b; font-size: 12.5px;">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM START --}}
                    <form action="{{ route('dosen.hki.update', $hki->id) }}" method="POST" enctype="multipart/form-data" id="formEditHki">
                        @csrf

                        <div class="hki-form-body">

                            {{-- SECTION 1: INFORMASI UTAMA HKI --}}
                            <div class="form-section-header">
                                <h3 class="form-section-title">
                                    <i class="fas fa-file-signature"></i>
                                    <span>1. Informasi Karya & Pendaftaran HKI</span>
                                </h3>
                            </div>

                            {{-- Field Judul --}}
                            <div class="form-group-custom">
                                <label for="judul" class="form-label-custom">
                                    Judul Karya / Ciptaan / Invensi <span class="required">*</span>
                                </label>
                                <input type="text" name="judul" id="judul"
                                    class="form-control-custom @error('judul') is-invalid @enderror"
                                    placeholder="Contoh: Sistem Informasi Monitoring Smart Farming Berbasis Internet of Things"
                                    value="{{ old('judul', $hki->judul) }}" maxlength="255" required autofocus>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px;">
                                    <span class="form-help-text">Tuliskan judul lengkap sesuai dengan dokumen sertifikat atau permohonan resmi HKI.</span>
                                    <span id="judulCharCount" style="font-size: 11.5px; color: var(--p3m-form-muted);">0 / 255</span>
                                </div>
                                @error('judul')
                                    <div class="invalid-feedback-custom">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Grid 3 Kolom: Tanggal, Jenis HKI, Nomor Pencatatan --}}
                            <div class="row">
                                {{-- Tanggal --}}
                                <div class="col-md-4">
                                    <div class="form-group-custom">
                                        <label for="tanggal" class="form-label-custom">
                                            Tanggal Terbit / Permohonan <span class="required">*</span>
                                        </label>
                                        <input type="date" name="tanggal" id="tanggal"
                                            class="form-control-custom @error('tanggal') is-invalid @enderror"
                                            value="{{ old('tanggal', $hki->tanggal ? $hki->tanggal->format('Y-m-d') : '') }}" required>
                                        <div class="form-help-text">Tanggal resmi pencatatan atau pengajuan HKI.</div>
                                        @error('tanggal')
                                            <div class="invalid-feedback-custom">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Jenis HKI --}}
                                <div class="col-md-4">
                                    <div class="form-group-custom">
                                        <label for="jenis_hki" class="form-label-custom">
                                            Jenis HKI
                                        </label>
                                        <select name="jenis_hki" id="jenis_hki"
                                            class="form-control-custom @error('jenis_hki') is-invalid @enderror">
                                            <option value="">-- Pilih Jenis HKI --</option>
                                            @php
                                                $selectedJenis = old('jenis_hki', $hki->jenis_hki);
                                                $jenisOptions = [
                                                    'Hak Cipta',
                                                    'Paten',
                                                    'Paten Sederhana',
                                                    'Merek',
                                                    'Desain Industri',
                                                    'Rahasia Dagang',
                                                    'Desain Tata Letak Sirkuit Terpadu',
                                                    'Indikasi Geografis',
                                                    'Lainnya'
                                                ];
                                            @endphp
                                            @foreach ($jenisOptions as $opt)
                                                <option value="{{ $opt }}" {{ $selectedJenis == $opt ? 'selected' : '' }}>
                                                    {{ $opt }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="form-help-text">Kategori perlindungan kekayaan intelektual.</div>
                                        @error('jenis_hki')
                                            <div class="invalid-feedback-custom">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Nomor Pencatatan --}}
                                <div class="col-md-4">
                                    <div class="form-group-custom">
                                        <label for="nomor_pencatatan" class="form-label-custom">
                                            Nomor Pencatatan / Permohonan
                                        </label>
                                        <input type="text" name="nomor_pencatatan" id="nomor_pencatatan"
                                            class="form-control-custom @error('nomor_pencatatan') is-invalid @enderror"
                                            placeholder="Contoh: EC00202612345"
                                            value="{{ old('nomor_pencatatan', $hki->nomor_pencatatan) }}" maxlength="100">
                                        <div class="form-help-text">Nomor pencatatan Kemenkumham (opsional).</div>
                                        @error('nomor_pencatatan')
                                            <div class="invalid-feedback-custom">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 2: DAFTAR PENCIPTA / ANGGOTA --}}
                            <div class="form-section-header mt-4">
                                <div>
                                    <h3 class="form-section-title">
                                        <i class="fas fa-users"></i>
                                        <span>2. Pencipta / Inventor / Anggota Terlibat</span>
                                    </h3>
                                    <div style="font-size: 12.5px; color: var(--p3m-form-muted); margin-top: 4px;">
                                        Minimal 1 orang pencipta utama. Anda dapat menyesuaikan nama, peran, dan urutan anggota.
                                    </div>
                                </div>
                                <div>
                                    <button type="button" id="btnAddAnggota" class="btn-add-anggota">
                                        <i class="fas fa-user-plus"></i>
                                        <span>Tambah Anggota</span>
                                    </button>
                                </div>
                            </div>

                            {{-- Repeater Container --}}
                            <div id="anggotaWrapper" class="anggota-repeater-list">
                                @php
                                    $membersData = old('anggota');
                                    if (empty($membersData) || !is_array($membersData)) {
                                        $membersData = $hki->anggotas->map(function ($a) {
                                            return [
                                                'nama' => $a->nama,
                                                'nim_nidn' => $a->nim_nidn,
                                                'peran' => $a->peran,
                                            ];
                                        })->toArray();
                                    }
                                    if (empty($membersData)) {
                                        $membersData = [
                                            [
                                                'nama' => Auth::user()->name,
                                                'nim_nidn' => Auth::user()->nidn_nip ?? '',
                                                'peran' => 'Ketua Pencipta',
                                            ]
                                        ];
                                    }
                                @endphp

                                @foreach ($membersData as $idx => $anggota)
                                    <div class="anggota-card-item js-anggota-row" data-index="{{ $idx }}">
                                        <div class="anggota-card-head">
                                            <span class="anggota-badge-order">
                                                <i class="fas fa-user"></i>
                                                <span class="js-order-text">Pencipta {{ $idx + 1 }}</span>
                                            </span>
                                            <button type="button" class="btn-remove-anggota js-btn-remove-anggota" title="Hapus anggota ini">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group-custom" style="margin-bottom: 0;">
                                                    <label class="form-label-custom" style="font-size: 12px;">
                                                        Nama Lengkap Pencipta <span class="required">*</span>
                                                    </label>
                                                    <input type="text" name="anggota[{{ $idx }}][nama]"
                                                        class="form-control-custom js-input-nama @error("anggota.{$idx}.nama") is-invalid @enderror"
                                                        placeholder="Nama lengkap beserta gelar jika ada"
                                                        value="{{ $anggota['nama'] ?? '' }}" required maxlength="150">
                                                    @error("anggota.{$idx}.nama")
                                                        <div class="invalid-feedback-custom">
                                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group-custom" style="margin-bottom: 0;">
                                                    <label class="form-label-custom" style="font-size: 12px;">
                                                        NIM / NIDN
                                                    </label>
                                                    <input type="text" name="anggota[{{ $idx }}][nim_nidn]"
                                                        class="form-control-custom js-input-nim"
                                                        placeholder="NIDN Dosen atau NIM Mahasiswa"
                                                        value="{{ $anggota['nim_nidn'] ?? '' }}" maxlength="50">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group-custom" style="margin-bottom: 0;">
                                                    <label class="form-label-custom" style="font-size: 12px;">
                                                        Peran / Kontribusi
                                                    </label>
                                                    <select name="anggota[{{ $idx }}][peran]" class="form-control-custom js-input-peran">
                                                        @php
                                                            $currentPeran = $anggota['peran'] ?? ($idx === 0 ? 'Ketua Pencipta' : 'Anggota Pencipta');
                                                        @endphp
                                                        <option value="Ketua Pencipta" {{ $currentPeran == 'Ketua Pencipta' ? 'selected' : '' }}>Ketua Pencipta</option>
                                                        <option value="Anggota Pencipta" {{ $currentPeran == 'Anggota Pencipta' ? 'selected' : '' }}>Anggota Pencipta (Dosen)</option>
                                                        <option value="Anggota Mahasiswa" {{ $currentPeran == 'Anggota Mahasiswa' ? 'selected' : '' }}>Anggota (Mahasiswa)</option>
                                                        <option value="Anggota Eksternal" {{ $currentPeran == 'Anggota Eksternal' ? 'selected' : '' }}>Anggota Eksternal / Mitra</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- SECTION 3: UNGGAH BERKAS SERTIFIKAT --}}
                            <div class="form-section-header mt-4">
                                <div>
                                    <h3 class="form-section-title">
                                        <i class="fas fa-file-pdf"></i>
                                        <span>3. Berkas Sertifikat / Dokumen HKI</span>
                                    </h3>
                                    <div style="font-size: 12.5px; color: var(--p3m-form-muted); margin-top: 4px;">
                                        Biarkan kosong jika tidak ingin mengubah berkas sertifikat yang sudah ada.
                                    </div>
                                </div>
                            </div>

                            {{-- Existing File Info --}}
                            @if ($hki->file_name)
                                <div class="existing-file-card">
                                    <div class="existing-file-left">
                                        <div class="existing-file-icon">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <div class="existing-file-name">{{ $hki->file_name }}</div>
                                            <div class="existing-file-sub">Berkas sertifikat yang saat ini tersimpan di sistem.</div>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('dosen.hki.download', $hki->id) }}" class="btn-download-existing" target="_blank">
                                            <i class="fas fa-download"></i> Unduh Berkas
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    Unggah Berkas Sertifikat Baru (PDF) <span style="font-weight: normal; color: var(--p3m-form-muted); font-size: 12px;">(Opsional jika tidak diganti)</span>
                                </label>

                                <input type="file" name="file_sertifikat" id="file_sertifikat"
                                    class="sr-only-file-input" accept=".pdf,application/pdf">

                                {{-- Drag and Drop Area --}}
                                <label for="file_sertifikat" class="upload-dropzone @error('file_sertifikat') has-error @enderror" id="dropzoneContainer">
                                    <div class="upload-dropzone-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="upload-dropzone-text">
                                        Klik untuk memilih file pengganti atau seret & jatuhkan berkas PDF baru ke sini
                                    </div>
                                    <div class="upload-dropzone-sub">
                                        Format berkas yang didukung: <strong>PDF</strong> (Maksimal <strong>5 MB</strong>)
                                    </div>
                                </label>

                                {{-- File Preview Area --}}
                                <div class="upload-file-preview" id="filePreviewContainer">
                                    <div class="upload-file-preview-left">
                                        <div class="preview-pdf-badge">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <div class="upload-file-name" id="previewFileName">filename.pdf</div>
                                            <div class="upload-file-size" id="previewFileSize">0 KB</div>
                                        </div>
                                    </div>
                                    <label for="file_sertifikat" class="btn-change-file">
                                        <i class="fas fa-sync-alt"></i> Ganti File Baru
                                    </label>
                                </div>

                                @error('file_sertifikat')
                                    <div class="invalid-feedback-custom mt-2">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        {{-- CARD FOOTER / ACTIONS --}}
                        <div class="hki-form-footer">
                            <a href="{{ route('dosen.hki.index') }}" class="btn-cancel">
                                <i class="fas fa-arrow-left mr-1"></i> Batal / Kembali
                            </a>

                            <button type="submit" class="btn-submit" id="btnSubmitForm">
                                <i class="fas fa-check-circle"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Character counter for Judul
            const judulInput = document.getElementById('judul');
            const judulCounter = document.getElementById('judulCharCount');
            if (judulInput && judulCounter) {
                const updateCount = () => {
                    judulCounter.textContent = `${judulInput.value.length} / 255`;
                };
                judulInput.addEventListener('input', updateCount);
                updateCount();
            }

            // File Upload & Preview Handler
            const fileInput = document.getElementById('file_sertifikat');
            const dropzone = document.getElementById('dropzoneContainer');
            const preview = document.getElementById('filePreviewContainer');
            const previewName = document.getElementById('previewFileName');
            const previewSize = document.getElementById('previewFileSize');

            function handleFileSelect(file) {
                if (!file) return;

                // Validate PDF type
                if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Sesuai',
                        text: 'File sertifikat wajib berformat PDF (.pdf).',
                        confirmButtonColor: '#d94b4b'
                    });
                    fileInput.value = '';
                    return;
                }

                // Validate 5MB (5 * 1024 * 1024 bytes)
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran Terlalu Besar',
                        text: 'Ukuran file sertifikat baru maksimal adalah 5 MB.',
                        confirmButtonColor: '#d94b4b'
                    });
                    fileInput.value = '';
                    return;
                }

                // Format size
                const sizeKb = (file.size / 1024).toFixed(1);
                const sizeStr = file.size > 1048576 
                    ? (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                    : sizeKb + ' KB';

                previewName.textContent = file.name;
                previewSize.textContent = sizeStr;

                dropzone.style.display = 'none';
                preview.classList.add('active');
            }

            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    handleFileSelect(this.files[0]);
                }
            });

            // Drag and drop events
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.add('dragover');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.remove('dragover');
                });
            });

            dropzone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files.length > 0) {
                    fileInput.files = files;
                    handleFileSelect(files[0]);
                }
            });

            // ── Dynamic Anggota Repeater ──
            const anggotaWrapper = document.getElementById('anggotaWrapper');
            const btnAddAnggota = document.getElementById('btnAddAnggota');

            function refreshAnggotaIndices() {
                const rows = anggotaWrapper.querySelectorAll('.js-anggota-row');
                rows.forEach((row, idx) => {
                    row.setAttribute('data-index', idx);
                    const orderText = row.querySelector('.js-order-text');
                    if (orderText) orderText.textContent = `Pencipta ${idx + 1}`;

                    const inputNama = row.querySelector('.js-input-nama');
                    if (inputNama) inputNama.name = `anggota[${idx}][nama]`;

                    const inputNim = row.querySelector('.js-input-nim');
                    if (inputNim) inputNim.name = `anggota[${idx}][nim_nidn]`;

                    const inputPeran = row.querySelector('.js-input-peran');
                    if (inputPeran) inputPeran.name = `anggota[${idx}][peran]`;

                    const removeBtn = row.querySelector('.js-btn-remove-anggota');
                    if (removeBtn) {
                        removeBtn.disabled = rows.length <= 1;
                    }
                });
            }

            btnAddAnggota.addEventListener('click', function () {
                const currentCount = anggotaWrapper.querySelectorAll('.js-anggota-row').length;
                const newIdx = currentCount;

                const newCard = document.createElement('div');
                newCard.className = 'anggota-card-item js-anggota-row';
                newCard.setAttribute('data-index', newIdx);
                newCard.innerHTML = `
                    <div class="anggota-card-head">
                        <span class="anggota-badge-order">
                            <i class="fas fa-user"></i>
                            <span class="js-order-text">Pencipta ${newIdx + 1}</span>
                        </span>
                        <button type="button" class="btn-remove-anggota js-btn-remove-anggota" title="Hapus anggota ini">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group-custom" style="margin-bottom: 0;">
                                <label class="form-label-custom" style="font-size: 12px;">
                                    Nama Lengkap Pencipta <span class="required">*</span>
                                </label>
                                <input type="text" name="anggota[${newIdx}][nama]"
                                    class="form-control-custom js-input-nama"
                                    placeholder="Nama lengkap beserta gelar jika ada"
                                    required maxlength="150">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group-custom" style="margin-bottom: 0;">
                                <label class="form-label-custom" style="font-size: 12px;">
                                    NIM / NIDN
                                </label>
                                <input type="text" name="anggota[${newIdx}][nim_nidn]"
                                    class="form-control-custom js-input-nim"
                                    placeholder="NIDN Dosen atau NIM Mahasiswa"
                                    maxlength="50">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group-custom" style="margin-bottom: 0;">
                                <label class="form-label-custom" style="font-size: 12px;">
                                    Peran / Kontribusi
                                </label>
                                <select name="anggota[${newIdx}][peran]" class="form-control-custom js-input-peran">
                                    <option value="Anggota Pencipta" selected>Anggota Pencipta (Dosen)</option>
                                    <option value="Anggota Mahasiswa">Anggota (Mahasiswa)</option>
                                    <option value="Anggota Eksternal">Anggota Eksternal / Mitra</option>
                                    <option value="Ketua Pencipta">Ketua Pencipta</option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;

                anggotaWrapper.appendChild(newCard);
                refreshAnggotaIndices();

                const newNama = newCard.querySelector('.js-input-nama');
                if (newNama) newNama.focus();
            });

            anggotaWrapper.addEventListener('click', function (e) {
                const btn = e.target.closest('.js-btn-remove-anggota');
                if (!btn) return;

                const rows = anggotaWrapper.querySelectorAll('.js-anggota-row');
                if (rows.length <= 1) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Minimal 1 Pencipta',
                        text: 'Paling tidak harus ada 1 nama pencipta atau ketua.',
                        confirmButtonColor: '#00573b'
                    });
                    return;
                }

                const card = btn.closest('.js-anggota-row');
                if (card) {
                    card.remove();
                    refreshAnggotaIndices();
                }
            });

            refreshAnggotaIndices();

            const form = document.getElementById('formEditHki');
            const submitBtn = document.getElementById('btnSubmitForm');
            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan Perubahan...';
            });
        });
    </script>
@endsection
