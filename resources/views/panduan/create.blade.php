@extends('layout.main')

@section('css')
<style>
    :root {
        --p3m-blue: #2563eb;
        --p3m-blue-dark: #1d4ed8;
        --p3m-gold: #d5a72f;
        --p3m-slate-900: #0f172a;
        --p3m-slate-700: #334155;
        --p3m-slate-500: #64748b;
        --p3m-border: #e2e8f0;
        --p3m-border-soft: #eef2f7;
        --p3m-bg-soft: #f8fafc;
    }

    .panduan-form-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .panduan-form-page .content {
        padding-top: 8px;
    }

    .panduan-form-wrap {
        width: 100%;
        max-width: 760px;
        margin: 0 auto;
    }

    .panduan-form-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .panduan-form-header {
        padding: 20px 22px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .panduan-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 7px;
        color: var(--p3m-blue);
        font-size: 11.25px;
        font-weight: 900;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .panduan-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: var(--p3m-gold);
    }

    .panduan-form-header h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .panduan-form-header p {
        margin: 7px 0 0;
        color: var(--p3m-slate-500);
        font-size: 13.25px;
        line-height: 1.6;
    }

    .panduan-form-body {
        padding: 22px;
    }

    .panduan-form-group {
        margin-bottom: 18px;
    }

    .panduan-form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--p3m-slate-900);
        font-size: 13.25px;
        font-weight: 850;
    }

    .panduan-form-group .form-control,
    .panduan-file-input {
        min-height: 44px;
        border: 1px solid #dbe4f0;
        border-radius: 13px;
        color: var(--p3m-slate-900);
        box-shadow: none;
    }

    .panduan-form-group .form-control:focus,
    .panduan-file-input:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .panduan-form-group small {
        display: block;
        margin-top: 6px;
        color: #dc2626;
        font-weight: 650;
    }

    .panduan-help-text {
        display: block;
        margin-top: 6px;
        color: var(--p3m-slate-500);
        font-size: 12px;
        font-weight: 600;
    }

    .panduan-upload-box {
        padding: 18px;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        background: var(--p3m-bg-soft);
    }

    .panduan-form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 22px 22px;
        border-top: 1px solid var(--p3m-border-soft);
        background: var(--p3m-bg-soft);
    }

    .btn-panduan-cancel,
    .btn-panduan-submit {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: 13px;
        font-weight: 850;
        transition: .22s ease;
    }

    .btn-panduan-cancel {
        background: #ffffff;
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-700);
    }

    .btn-panduan-cancel:hover {
        background: #ffffff;
        color: var(--p3m-slate-900);
        transform: translateY(-1px);
    }

    .btn-panduan-submit {
        background: var(--p3m-blue);
        border: 1px solid var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .17);
    }

    .btn-panduan-submit:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    @media (max-width: 575.98px) {
        .panduan-form-body {
            padding: 16px;
        }

        .panduan-form-footer {
            flex-direction: column-reverse;
            padding: 16px;
        }

        .btn-panduan-cancel,
        .btn-panduan-submit {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper panduan-form-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="panduan-form-wrap">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('panduan.index') }}">Panduan</a></li>
                    <li class="breadcrumb-item active">{{ $pagetitle }}</li>
                </ol>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="panduan-form-wrap">
                <form action="{{ route('panduan.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="panduan-form-panel">
                        <div class="panduan-form-header">
                            <span class="panduan-kicker">Dokumen Panduan</span>
                            <h1>Tambah Panduan P3M</h1>
                            <p>Unggah file panduan dalam format PDF atau DOCX dengan nama yang jelas dan mudah dikenali.</p>
                        </div>

                        <div class="panduan-form-body">
                            <div class="panduan-form-group">
                                <label for="namefile">Nama File</label>
                                <input type="text" name="namefile" id="namefile" class="form-control" placeholder="Masukkan nama file" value="{{ old('namefile') }}" required>
                                @error('namefile')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="panduan-form-group mb-0">
                                <label for="original_name">Upload File</label>
                                <div class="panduan-upload-box">
                                    <input type="file" name="original_name" id="original_name" class="form-control panduan-file-input" required>
                                    <span class="panduan-help-text">Format yang didukung: PDF atau DOCX. Maksimal 2MB.</span>
                                </div>
                                @error('original_name')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="panduan-form-footer">
                            <a href="{{ route('panduan.index') }}" class="btn btn-panduan-cancel">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-panduan-submit">
                                Simpan Panduan
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
