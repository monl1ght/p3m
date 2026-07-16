@extends('layout.main')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">

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

    .tentang-form-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .tentang-form-wrap {
        width: 100%;
        max-width: 980px;
        margin: 0 auto;
    }

    .tentang-form-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .tentang-form-header {
        padding: 20px 22px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .tentang-kicker {
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

    .tentang-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: var(--p3m-gold);
    }

    .tentang-form-header h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .tentang-form-header p {
        margin: 7px 0 0;
        color: var(--p3m-slate-500);
        font-size: 13.25px;
        line-height: 1.6;
    }

    .tentang-form-body {
        padding: 22px;
    }

    .tentang-form-group {
        margin-bottom: 20px;
    }

    .tentang-form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--p3m-slate-900);
        font-size: 13.25px;
        font-weight: 850;
    }

    .tentang-form-group .form-control {
        border: 1px solid #dbe4f0;
        border-radius: 13px;
        color: var(--p3m-slate-900);
        box-shadow: none;
    }

    .tentang-form-group .form-control:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .tentang-form-group small {
        display: block;
        margin-top: 6px;
        color: #dc2626;
        font-weight: 650;
    }

    .note-editor.note-frame {
        border: 1px solid #dbe4f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: none;
    }

    .note-toolbar {
        background: var(--p3m-bg-soft) !important;
        border-bottom: 1px solid var(--p3m-border-soft) !important;
    }

    .tentang-form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 22px 22px;
        border-top: 1px solid var(--p3m-border-soft);
        background: var(--p3m-bg-soft);
    }

    .btn-tentang-cancel,
    .btn-tentang-submit {
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

    .btn-tentang-cancel {
        background: #ffffff;
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-700);
    }

    .btn-tentang-cancel:hover {
        background: #ffffff;
        color: var(--p3m-slate-900);
        transform: translateY(-1px);
    }

    .btn-tentang-submit {
        background: var(--p3m-blue);
        border: 1px solid var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .17);
    }

    .btn-tentang-submit:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    @media (max-width: 575.98px) {
        .tentang-form-body {
            padding: 16px;
        }

        .tentang-form-footer {
            flex-direction: column-reverse;
            padding: 16px;
        }

        .btn-tentang-cancel,
        .btn-tentang-submit {
            width: 100%;
        }
    }
</style>

@endsection

@section('content')
<div class="content-wrapper tentang-form-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="tentang-form-wrap">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tentang.index') }}">Tentang P3M</a></li>
                    <li class="breadcrumb-item active">{{ $pagetitle }}</li>
                </ol>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="tentang-form-wrap">
                <form action="{{ route('tentang.store') }}" method="post">
                    @csrf

                    <div class="tentang-form-panel">
                        <div class="tentang-form-header">
                            <span class="tentang-kicker">Profil P3M</span>
                            <h1>Tambah Tentang P3M</h1>
                            <p>Lengkapi informasi visi, misi, dan deskripsi P3M yang akan tampil di halaman publik.</p>
                        </div>

                        <div class="tentang-form-body">
                            <div class="tentang-form-group">
                                <label for="visi-textarea">Visi</label>
                                <textarea name="visi" id="visi-textarea" class="form-control">{{ old('visi') }}</textarea>
                                @error('visi')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="tentang-form-group">
                                <label for="misi-textarea">Misi</label>
                                <textarea name="misi" id="misi-textarea" class="form-control">{{ old('misi') }}</textarea>
                                @error('misi')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="tentang-form-group mb-0">
                                <label for="ourbout-textarea">Tentang Kami</label>
                                <textarea name="ourbout" id="ourbout-textarea" class="form-control">{{ old('ourbout') }}</textarea>
                                @error('ourbout')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="tentang-form-footer">
                            <a href="{{ route('tentang.index') }}" class="btn btn-tentang-cancel">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-tentang-submit">
                                Simpan Data
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

@section('scripts')
<script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function() {
        $('#visi-textarea, #misi-textarea, #ourbout-textarea').summernote({
            height: 220,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>
@endsection
