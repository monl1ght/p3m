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

    .news-form-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .news-form-page .content {
        padding-top: 8px;
    }

    .news-form-wrap {
        width: 100%;
        max-width: 980px;
        margin: 0 auto;
    }

    .news-form-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .news-form-header {
        padding: 20px 22px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .news-kicker {
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

    .news-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: var(--p3m-gold);
    }

    .news-form-header h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .news-form-header p {
        margin: 7px 0 0;
        color: var(--p3m-slate-500);
        font-size: 13.25px;
        line-height: 1.6;
    }

    .news-form-body {
        padding: 22px;
    }

    .news-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .news-form-group {
        margin-bottom: 18px;
    }

    .news-form-group-full {
        grid-column: 1 / -1;
    }

    .news-form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--p3m-slate-900);
        font-size: 13.25px;
        font-weight: 850;
    }

    .news-form-group .form-control {
        min-height: 44px;
        border: 1px solid #dbe4f0;
        border-radius: 13px;
        color: var(--p3m-slate-900);
        box-shadow: none;
    }

    .news-form-group .form-control:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .news-form-group small {
        display: block;
        margin-top: 6px;
        color: #dc2626;
        font-weight: 650;
    }

    .news-help-text {
        display: block;
        margin-top: 6px;
        color: var(--p3m-slate-500);
        font-size: 12px;
        font-weight: 600;
    }

    .news-upload-box {
        padding: 18px;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        background: var(--p3m-bg-soft);
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

    .news-current-image {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin-top: 10px;
        padding: 10px;
        border: 1px solid var(--p3m-border);
        border-radius: 14px;
        background: #ffffff;
    }

    .news-current-image img {
        width: 58px;
        height: 58px;
        object-fit: cover;
        border-radius: 12px;
    }

    .news-current-image span {
        color: var(--p3m-slate-500);
        font-size: 12px;
        font-weight: 700;
    }

    .news-form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 22px 22px;
        border-top: 1px solid var(--p3m-border-soft);
        background: var(--p3m-bg-soft);
    }

    .btn-news-cancel,
    .btn-news-submit {
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

    .btn-news-cancel {
        background: #ffffff;
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-700);
    }

    .btn-news-cancel:hover {
        background: #ffffff;
        color: var(--p3m-slate-900);
        transform: translateY(-1px);
    }

    .btn-news-submit {
        background: var(--p3m-blue);
        border: 1px solid var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .17);
    }

    .btn-news-submit:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    @media (max-width: 767.98px) {
        .news-form-grid {
            grid-template-columns: 1fr;
        }

        .news-form-body {
            padding: 16px;
        }

        .news-form-footer {
            flex-direction: column-reverse;
            padding: 16px;
        }

        .btn-news-cancel,
        .btn-news-submit {
            width: 100%;
        }
    }
</style>

@endsection

@section('content')
@php
    $categoryOptions = collect();
    if (isset($categories)) {
        $categoryOptions = collect($categories);
    } elseif (isset($category)) {
        $categoryOptions = collect($category);
    } elseif (isset($kategori)) {
        $categoryOptions = collect($kategori);
    }
@endphp

<div class="content-wrapper news-form-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="news-form-wrap">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Kegiatan P3M</a></li>
                    <li class="breadcrumb-item active">{{ $pagetitle ?? 'Tambah Kegiatan P3M' }}</li>
                </ol>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="news-form-wrap">
                <form action="{{ route('news.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="news-form-panel">
                        <div class="news-form-header">
                            <span class="news-kicker">Seputar P3M</span>
                            <h1>Tambah Kegiatan P3M</h1>
                            <p>Lengkapi data kegiatan dengan judul yang jelas, kategori, tanggal, gambar, dan isi publikasi.</p>
                        </div>

                        <div class="news-form-body">
                            <div class="news-form-grid">
                                <div class="news-form-group news-form-group-full">
                                    <label for="title">Judul Kegiatan</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Masukkan judul kegiatan" required>
                                    @error('title')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="news-form-group">
                                    <label for="date">Tanggal</label>
                                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
                                    @error('date')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="news-form-group">
                                    <label for="category_id">Kategori</label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Pilih kategori</option>
                                        @foreach($categoryOptions as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="news-form-group news-form-group-full">
                                    <label for="image">Gambar Kegiatan</label>
                                    <div class="news-upload-box">
                                        <input type="file" name="image" id="image" class="form-control" required>
                                        <span class="news-help-text">Format yang didukung: PNG, JPG, JPEG. Maksimal 2MB.</span>
                                    </div>
                                    @error('image')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="news-form-group news-form-group-full mb-0">
                                    <label for="content">Isi Kegiatan</label>
                                    <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
                                    @error('content')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="news-form-footer">
                            <a href="{{ route('news.index') }}" class="btn btn-news-cancel">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-news-submit">
                                Simpan Kegiatan
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

@section('script')
<script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function() {
        $('#content').summernote({
            height: 260,
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
