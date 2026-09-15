@extends('layout.main')
@section('css')
<style>
    :root {
        --p3m-blue: #003d2d;
        --p3m-blue-dark: #002e22;
        --p3m-gold: #b99835;
        --p3m-slate-900: #0f172a;
        --p3m-slate-700: #334155;
        --p3m-slate-500: #64748b;
        --p3m-border: #e2e8f0;
        --p3m-border-soft: #eef2f7;
        --p3m-bg-soft: #f8fafc;
    }

    .form-page .content-header { padding-top: 22px; padding-bottom: 6px; }
    .form-page .content { padding-top: 8px; }

    .form-wrap { width: 100%; max-width: 760px; margin: 0 auto; }

    .form-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .form-header {
        padding: 24px 28px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .form-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        color: var(--p3m-blue);
        font-size: 11.5px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .form-kicker::before {
        content: ""; width: 24px; height: 2px; border-radius: 999px; background: var(--p3m-gold);
    }

    .form-header h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: 24px;
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .form-header p {
        margin: 6px 0 0; color: var(--p3m-slate-500); font-size: 13.5px; line-height: 1.6;
    }

    .form-body { padding: 28px; }

    .form-group { margin-bottom: 20px; }
    .form-group label {
        display: block; margin-bottom: 8px; color: var(--p3m-slate-900); font-size: 13.5px; font-weight: 800;
    }

    .form-group .form-control {
        min-height: 46px;
        border: 1px solid #dbe4f0;
        border-radius: 12px;
        color: var(--p3m-slate-900);
        font-size: 14px;
        box-shadow: none;
        padding: 10px 16px;
    }

    .form-group .form-control:focus {
        border-color: #93c5fd; box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .form-group small {
        display: block; margin-top: 6px; color: #dc2626; font-weight: 650; font-size: 12.5px;
    }
    
    .file-upload-box {
        padding: 18px;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        background: var(--p3m-bg-soft);
    }

    .form-footer {
        display: flex; justify-content: flex-end; gap: 12px;
        padding: 20px 28px;
        border-top: 1px solid var(--p3m-border-soft);
        background: var(--p3m-bg-soft);
    }

    .btn-cancel, .btn-submit {
        min-height: 44px;
        display: inline-flex; align-items: center; justify-content: center;
        gap: 8px; padding: 10px 20px; border-radius: 12px; font-weight: 800; font-size: 13.5px;
        transition: .22s ease;
    }

    .btn-cancel {
        background: #ffffff; border: 1px solid var(--p3m-border); color: var(--p3m-slate-700);
    }
    .btn-cancel:hover {
        background: #f1f5f9; color: var(--p3m-slate-900); text-decoration: none; transform: translateY(-1px);
    }

    .btn-submit {
        background: var(--p3m-blue); border: 1px solid var(--p3m-blue); color: #ffffff;
        box-shadow: 0 12px 24px rgba(0, 61, 45, .17);
    }
    .btn-submit:hover {
        background: var(--p3m-blue-dark); border-color: var(--p3m-blue-dark); color: #ffffff; transform: translateY(-1px);
    }

    @media (max-width: 575.98px) {
        .form-body { padding: 20px; }
        .form-footer { flex-direction: column-reverse; padding: 20px; }
        .btn-cancel, .btn-submit { width: 100%; }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper form-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="form-wrap">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 12.5px; font-weight: 600;">
                    <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}" style="color: var(--p3m-slate-500);">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}" style="color: var(--p3m-slate-500);">Dokumen</a></li>
                    <li class="breadcrumb-item active" style="color: var(--p3m-slate-900);">{{ $pagetitle }}</li>
                </ol>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="form-wrap">
                <form action="{{ route('dokumen.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-panel">
                        <div class="form-header">
                            <span class="form-kicker">Data Dokumen</span>
                            <h1>Unggah Dokumen P3M</h1>
                            <p>Unggah file dokumen yang diperlukan ke dalam sistem informasi.</p>
                        </div>

                        <div class="form-body">
                            <div class="form-group">
                                <label for="namefile">Nama File</label>
                                <input type="text" name="namefile" id="namefile" class="form-control" placeholder="Contoh: SK Pengangkatan Dosen..." value="{{ old('namefile') }}">
                                @error('namefile')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label for="originalname">Upload File</label>
                                <div class="file-upload-box">
                                    <input type="file" name="originalname" id="originalname" class="form-control" style="padding: 7px 10px; border: none; box-shadow: none; background: transparent;" required>
                                </div>
                                <span class="text-muted d-block mt-1" style="font-size: 12px;">Format yang didukung: PDF atau DOCX. Maksimal 5 MB.</span>
                                @error('originalname')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-footer">
                            <a href="{{ route('dokumen.index') }}" class="btn btn-cancel">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-submit">
                                Simpan Dokumen <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection