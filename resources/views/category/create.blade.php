@extends('layout.main')

@section('css')

<style>
    :root {
        --p3m-blue: #003d2d;
        --p3m-blue-dark: #002e22;
        --p3m-gold: #d5a72f;
        --p3m-slate-900: #0f172a;
        --p3m-slate-700: #334155;
        --p3m-slate-500: #64748b;
        --p3m-border: #e2e8f0;
        --p3m-border-soft: #eef2f7;
        --p3m-bg-soft: #f8fafc;
    }

    .category-form-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .category-form-page .content {
        padding-top: 8px;
    }

    .category-form-wrap {
        width: 100%;
        max-width: 760px;
        margin: 0 auto;
    }

    .category-form-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .category-form-header {
        padding: 20px 22px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .category-kicker {
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

    .category-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: var(--p3m-gold);
    }

    .category-form-header h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .category-form-header p {
        margin: 7px 0 0;
        color: var(--p3m-slate-500);
        font-size: 13.25px;
        line-height: 1.6;
    }

    .category-form-body {
        padding: 22px;
    }

    .category-form-group {
        margin-bottom: 18px;
    }

    .category-form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--p3m-slate-900);
        font-size: 13.25px;
        font-weight: 850;
    }

    .category-form-group .form-control {
        min-height: 44px;
        border: 1px solid #dbe4f0;
        border-radius: 13px;
        color: var(--p3m-slate-900);
        box-shadow: none;
    }

    .category-form-group .form-control:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 4px rgba(0, 61, 45, .08);
    }

    .category-form-group small {
        display: block;
        margin-top: 6px;
        color: #dc2626;
        font-weight: 650;
    }

    .category-help-text {
        display: block;
        margin-top: 6px;
        color: var(--p3m-slate-500);
        font-size: 12px;
        font-weight: 600;
    }

    .category-form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 22px 22px;
        border-top: 1px solid var(--p3m-border-soft);
        background: var(--p3m-bg-soft);
    }

    .btn-category-cancel,
    .btn-category-submit {
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

    .btn-category-cancel {
        background: #ffffff;
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-700);
    }

    .btn-category-cancel:hover {
        background: #ffffff;
        color: var(--p3m-slate-900);
        transform: translateY(-1px);
    }

    .btn-category-submit {
        background: var(--p3m-blue);
        border: 1px solid var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(0, 61, 45, .17);
    }

    .btn-category-submit:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    @media (max-width: 575.98px) {
        .category-form-body {
            padding: 16px;
        }

        .category-form-footer {
            flex-direction: column-reverse;
            padding: 16px;
        }

        .btn-category-cancel,
        .btn-category-submit {
            width: 100%;
        }
    }
</style>

@endsection

@section('content')
<div class="content-wrapper category-form-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="category-form-wrap">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Kategori Berita</a></li>
                    <li class="breadcrumb-item active">{{ $pagetitle }}</li>
                </ol>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="category-form-wrap">
                <form action="{{ route('category.store') }}" method="post">
                    @csrf

                    <div class="category-form-panel">
                        <div class="category-form-header">
                            <span class="category-kicker">Seputar P3M</span>
                            <h1>Tambah Kategori Berita</h1>
                            <p>Buat kategori baru untuk mengelompokkan konten kegiatan dan berita P3M.</p>
                        </div>

                        <div class="category-form-body">
                            <div class="category-form-group">
                                <label for="category_name">Nama Kategori</label>
                                <input type="text" name="name" id="category_name" class="form-control" placeholder="Contoh: Pengabdian Masyarakat" value="{{ old('name') }}" required>
                                @error('name')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="category-form-group mb-0">
                                <label for="category_slug">Slug</label>
                                <input type="text" name="slug" id="category_slug" class="form-control" placeholder="Contoh: pengabdian-masyarakat" value="{{ old('slug') }}" required>
                                <span class="category-help-text">Gunakan huruf kecil dan tanda hubung agar URL terlihat rapi.</span>
                                @error('slug')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="category-form-footer">
                            <a href="{{ route('category.index') }}" class="btn btn-category-cancel">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-category-submit">
                                Simpan Kategori
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
