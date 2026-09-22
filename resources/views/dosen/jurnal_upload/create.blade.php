@extends('layout.doslayout')

@section('title', 'Unggah Jurnal Baru - P3M Politeknik Balekambang Jepara')
@section('body_class', 'page-dosen-jurnal-form')

@section('css')
    <style>
        /* =========================================================================
           P3M DOSEN — FORM UNGGAH JURNAL ILMIAH
           Card size & padding strictly matching the master Dosen Workspace pages
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
            --p3m-form-border: #e4ede8;
            --p3m-form-border-2: #cbd5e1;
            --p3m-form-surface: #ffffff;
            --p3m-form-surface-alt: #f8fafc;
            --p3m-form-surface-hover: #f1f5f9;
            --p3m-form-danger: #dc2626;
            --p3m-form-danger-bg: #fef2f2;
            --p3m-form-r-sm: 8px;
            --p3m-form-r-md: 12px;
            --p3m-form-r-lg: 16px;
            --p3m-form-r-xl: 20px;
            --p3m-form-r-2xl: 24px;
        }

        .page-dosen-jurnal-form .content-wrapper {
            min-height: calc(100vh - 66px);
            background:
                radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0, 93, 59, .05), transparent 70%),
                linear-gradient(180deg, #f2f8f5 0%, #f7faf8 100%) !important;
        }

        /* ── Strict Shell Width Matching All Other Dosen Menus ── */
        .page-dosen-jurnal-form .upp3m-shell {
            width: min(1320px, calc(100% - 44px));
            margin: 0 auto;
        }

        .page-dosen-jurnal-form .content-header {
            padding: 24px 0 14px !important;
        }

        .page-dosen-jurnal-form section.content {
            padding: 0 0 40px !important;
        }

        /* Breadcrumb Navigation */
        .page-dosen-jurnal-form .upp3m-breadcrumb {
            margin: 0;
            padding: 0;
            background: transparent;
            font-size: 12.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .page-dosen-jurnal-form .upp3m-breadcrumb .breadcrumb-item a {
            color: var(--p3m-form-forest-mid);
            text-decoration: none;
            transition: opacity .18s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .page-dosen-jurnal-form .upp3m-breadcrumb .breadcrumb-item a:hover {
            opacity: .75;
        }

        .page-dosen-jurnal-form .upp3m-breadcrumb .breadcrumb-item.active {
            color: var(--p3m-form-muted);
        }

        .page-dosen-jurnal-form .upp3m-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            content: "/";
            padding: 0 8px;
            color: var(--p3m-form-border-2);
        }

        /* Card Container */
        .page-dosen-jurnal-form .jurnal-card {
            background: var(--p3m-form-surface);
            border: 1px solid var(--p3m-form-border);
            border-radius: var(--p3m-form-r-2xl);
            box-shadow: 0 12px 36px rgba(3, 50, 33, .07), 0 2px 6px rgba(0, 0, 0, .02);
            overflow: hidden;
        }

        .page-dosen-jurnal-form .jurnal-card-head {
            padding: 26px 36px 22px;
            background: linear-gradient(112deg, #ffffff 60%, #f4faf6 100%);
            border-bottom: 1px solid var(--p3m-form-border);
        }

        .page-dosen-jurnal-form .jurnal-card-title {
            margin: 0 0 6px;
            color: var(--p3m-form-ink);
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: 22px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .page-dosen-jurnal-form .jurnal-card-subtitle {
            margin: 0;
            color: var(--p3m-form-muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .page-dosen-jurnal-form .jurnal-form-body {
            padding: 36px;
        }

        .form-group-custom {
            margin-bottom: 26px;
        }

        .form-group-custom:last-child {
            margin-bottom: 0;
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

        .form-help-text {
            margin-top: 7px;
            font-size: 12px;
            color: var(--p3m-form-muted);
        }

        /* Radio Pill Category */
        .category-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
        }

        .category-radio-card {
            position: relative;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            border: 1.5px solid var(--p3m-form-border-2);
            border-radius: var(--p3m-form-r-md);
            background: var(--p3m-form-surface);
            cursor: pointer;
            transition: all .18s ease;
            margin-bottom: 0;
        }

        .category-radio-card:hover {
            border-color: #9fbead;
            background: var(--p3m-form-surface-alt);
            transform: translateY(-1px);
        }

        .category-radio-card.active {
            border-color: var(--p3m-form-forest-mid);
            background: var(--p3m-form-forest-soft);
            box-shadow: 0 0 0 1px var(--p3m-form-forest-mid);
        }

        .category-radio-card input[type="radio"] {
            accent-color: var(--p3m-form-forest-mid);
            width: 18px;
            height: 18px;
            cursor: pointer;
            flex-shrink: 0;
            margin: 0;
        }

        .category-meta h5 {
            margin: 0 0 3px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--p3m-form-ink);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .category-meta p {
            margin: 0;
            font-size: 12px;
            color: var(--p3m-form-muted);
        }

        /* ── Accessible Hidden Input ── */
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

        /* ── Upload Dropzone (Label Native Click) ── */
        .upload-dropzone {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 44px 24px;
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
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
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 87, 59, .06);
        }

        .upload-dropzone-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            color: #475569;
            font-size: 24px;
            transition: all .2s ease;
        }

        .upload-dropzone:hover .upload-dropzone-icon,
        .upload-dropzone.dragover .upload-dropzone-icon {
            background: var(--p3m-form-forest-soft);
            color: var(--p3m-form-forest-mid);
            transform: scale(1.06);
        }

        .upload-dropzone-text {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--p3m-form-ink);
            margin-bottom: 4px;
        }

        .upload-dropzone-sub {
            font-size: 12.5px;
            color: var(--p3m-form-muted);
        }

        /* ── Upload File Preview ── */
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
            margin: 0;
        }

        .btn-change-file:hover {
            border-color: #dc2626;
            color: #dc2626;
            background: #fff5f5;
        }

        /* ── Form Footer ── */
        .jurnal-form-footer {
            padding: 20px 36px;
            background: #f8fafc;
            border-top: 1px solid var(--p3m-form-border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
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
            padding: 10px 24px;
            border: none;
            border-radius: var(--p3m-form-r-md);
            background: linear-gradient(135deg, var(--p3m-form-forest) 0%, var(--p3m-form-forest-mid) 100%);
            color: #ffffff;
            font-size: 13px;
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
            .page-dosen-jurnal-form .jurnal-card-head,
            .page-dosen-jurnal-form .jurnal-form-body,
            .page-dosen-jurnal-form .jurnal-form-footer {
                padding: 20px 18px;
            }
            .category-options {
                grid-template-columns: 1fr;
            }
            .jurnal-form-footer {
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

        {{-- BREADCRUMBS --}}
        <div class="content-header">
            <div class="upp3m-shell">
                <ol class="breadcrumb upp3m-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dosen.dash') }}">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('dosen.jurnal_upload.index', ['kategori' => $kategori]) }}">
                            Upload Jurnal {{ strtolower($kategori) === 'pengabdian' ? 'Pengabdian' : (strtolower($kategori) === 'penelitian' ? 'Penelitian' : 'Ilmiah') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Upload Baru
                    </li>
                </ol>
            </div>
        </div>

        {{-- MAIN CARD --}}
        <section class="content">
            <div class="upp3m-shell">

                <div class="jurnal-card">
                    {{-- CARD HEADER --}}
                    <div class="jurnal-card-head">
                        <h1 class="jurnal-card-title">Unggah Jurnal Ilmiah Baru</h1>
                        <p class="jurnal-card-subtitle">
                            Silakan lengkapi informasi jurnal ilmiah dan unggah naskah lengkap dalam format PDF.
                        </p>
                    </div>

                    <form action="{{ route('dosen.jurnal_upload.store') }}" method="POST" enctype="multipart/form-data" id="jurnalUploadForm">
                        @csrf

                        <div class="jurnal-form-body">
                            {{-- Alert Error Validasi --}}
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4" style="border-radius: 12px; font-size: 13px;">
                                    <div class="font-weight-bold mb-1"><i class="fas fa-exclamation-circle mr-1"></i> Terjadi kesalahan pengisian form:</div>
                                    <ul class="mb-0 pl-3">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Judul Jurnal --}}
                            <div class="form-group-custom">
                                <label for="judul" class="form-label-custom">
                                    Judul Lengkap Jurnal <span class="required">*</span>
                                </label>
                                <input type="text" id="judul" name="judul" class="form-control-custom"
                                    placeholder="Contoh: Rancang Bangun Sistem Monitoring IoT Berbasis LoRa"
                                    value="{{ old('judul') }}" required>
                                <div class="form-help-text">Tuliskan judul artikel jurnal secara lengkap dan jelas.</div>
                            </div>

                            {{-- Kategori Jurnal --}}
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    Kategori Jurnal <span class="required">*</span>
                                </label>
                                <div class="category-options">
                                    <label class="category-radio-card {{ (old('kategori', $kategori) === 'penelitian') ? 'active' : '' }}">
                                        <input type="radio" name="kategori" value="penelitian"
                                            {{ (old('kategori', $kategori) === 'penelitian') ? 'checked' : '' }} required>
                                        <div class="category-meta">
                                            <h5><i class="fas fa-microscope" style="color: #00573b;"></i> Penelitian</h5>
                                            <p>Publikasi luaran riset / penelitian dosen</p>
                                        </div>
                                    </label>

                                    <label class="category-radio-card {{ (old('kategori', $kategori) === 'pengabdian') ? 'active' : '' }}">
                                        <input type="radio" name="kategori" value="pengabdian"
                                            {{ (old('kategori', $kategori) === 'pengabdian') ? 'checked' : '' }}>
                                        <div class="category-meta">
                                            <h5><i class="fas fa-hand-holding-heart" style="color: #86198f;"></i> Pengabdian</h5>
                                            <p>Publikasi luaran pengabdian masyarakat</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- Upload File PDF --}}
                            <div class="form-group-custom">
                                <label class="form-label-custom">
                                    Berkas Naskah Jurnal (PDF) <span class="required">*</span>
                                </label>

                                {{-- Hidden file input for native browser interaction and accessibility --}}
                                <input type="file" name="uppdf" id="uppdf" accept=".pdf,application/pdf" class="sr-only-file-input" required>

                                {{-- Dropzone box rendered as a <label for="uppdf"> which natively triggers file dialog --}}
                                <label for="uppdf" class="upload-dropzone" id="dropzoneBox">
                                    <div class="upload-dropzone-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="upload-dropzone-text">Pilih file PDF atau seret dan lepas ke sini</div>
                                    <div class="upload-dropzone-sub">Hanya format PDF dengan ukuran maksimal 5 MB</div>
                                </label>

                                {{-- File selected preview card --}}
                                <div class="upload-file-preview" id="filePreview">
                                    <div class="upload-file-preview-left">
                                        <div class="preview-pdf-badge">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <div class="upload-file-name" id="previewFileName">-</div>
                                            <div class="upload-file-size" id="previewFileSize">-</div>
                                        </div>
                                    </div>
                                    <label for="uppdf" class="btn-change-file" role="button">
                                        <i class="fas fa-sync-alt"></i> Ganti File
                                    </label>
                                </div>
                            </div>

                        </div>

                        {{-- FOOTER ACTIONS --}}
                        <div class="jurnal-form-footer">
                            <a href="{{ route('dosen.jurnal_upload.index', ['kategori' => $kategori]) }}" class="btn-cancel">Batal</a>
                            <button type="submit" class="btn-submit" id="btnSubmitForm">
                                <i class="fas fa-upload"></i> Unggah & Kirim Verifikasi
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
        (function() {
            'use strict';

            function setupJurnalForm() {
                const fileInput = document.getElementById('uppdf');
                const dropzone = document.getElementById('dropzoneBox');
                const preview = document.getElementById('filePreview');
                const fileName = document.getElementById('previewFileName');
                const fileSize = document.getElementById('previewFileSize');
                const form = document.getElementById('jurnalUploadForm');

                if (!fileInput || !dropzone) return;

                // Sync category card active states
                document.querySelectorAll('input[name="kategori"]').forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        document.querySelectorAll('.category-radio-card').forEach(function(card) {
                            card.classList.remove('active');
                        });
                        const parent = this.closest('.category-radio-card');
                        if (parent) parent.classList.add('active');
                    });
                });

                // Update file preview when file is selected
                function displayFile(file) {
                    if (!file) return;

                    if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Format Tidak Sesuai',
                                text: 'Hanya berkas naskah format PDF yang diperbolehkan.',
                                confirmButtonColor: '#00573b'
                            });
                        } else {
                            alert('Hanya berkas naskah format PDF yang diperbolehkan.');
                        }
                        fileInput.value = '';
                        dropzone.style.display = 'flex';
                        if (preview) preview.classList.remove('active');
                        return;
                    }

                    if (file.size > 5 * 1024 * 1024) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ukuran File Terlalu Besar',
                                text: 'Ukuran berkas naskah PDF maksimal adalah 5 MB.',
                                confirmButtonColor: '#00573b'
                            });
                        } else {
                            alert('Ukuran berkas naskah PDF maksimal adalah 5 MB.');
                        }
                        fileInput.value = '';
                        dropzone.style.display = 'flex';
                        if (preview) preview.classList.remove('active');
                        return;
                    }

                    if (fileName) fileName.textContent = file.name;
                    if (fileSize) {
                        const sizeKB = (file.size / 1024).toFixed(1);
                        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                        fileSize.textContent = file.size > 1024 * 1024 ? sizeMB + ' MB' : sizeKB + ' KB';
                    }

                    dropzone.style.display = 'none';
                    if (preview) preview.classList.add('active');
                }

                // File input change
                fileInput.addEventListener('change', function() {
                    if (this.files && this.files.length > 0) {
                        displayFile(this.files[0]);
                    }
                });

                // Drag and drop support
                ['dragenter', 'dragover'].forEach(function(eventName) {
                    dropzone.addEventListener(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        dropzone.classList.add('dragover');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(function(eventName) {
                    dropzone.addEventListener(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        dropzone.classList.remove('dragover');
                    }, false);
                });

                dropzone.addEventListener('drop', function(e) {
                    const dt = e.dataTransfer;
                    if (dt && dt.files && dt.files.length > 0) {
                        fileInput.files = dt.files;
                        displayFile(dt.files[0]);
                    }
                }, false);

                // Button submit loading feedback
                if (form) {
                    form.addEventListener('submit', function() {
                        const submitBtn = document.getElementById('btnSubmitForm');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Mengunggah...';
                        }
                    });
                }
            }

            // Run on both standard load and Turbo Drive load
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', setupJurnalForm);
            } else {
                setupJurnalForm();
            }
            document.addEventListener('turbo:load', setupJurnalForm);
            document.addEventListener('turbo:render', setupJurnalForm);
        })();
    </script>
@endsection
