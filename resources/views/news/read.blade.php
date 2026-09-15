@extends('layout.main')

@section('css')
<style>
    :root {
        --p3m-blue: #003d2d;
        --p3m-blue-dark: #002e22;
        --p3m-gold: #d5a72f;
        --p3m-slate-900: #0f172a;
        --p3m-slate-700: #334155;
        --p3m-slate-600: #475569;
        --p3m-slate-500: #64748b;
        --p3m-border: #e2e8f0;
        --p3m-border-soft: #eef2f7;
        --p3m-bg-soft: #f8fafc;
    }

    .news-read-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .news-read-page .content {
        padding-top: 8px;
    }

    .news-read-wrap {
        width: 100%;
        max-width: 1040px;
        margin: 0 auto;
    }

    .news-read-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .news-read-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
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

    .news-read-title h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.55rem, 2vw, 2.15rem);
        line-height: 1.2;
        font-weight: 900;
        letter-spacing: -0.045em;
    }

    .news-read-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .news-meta-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 30px;
        padding: 6px 10px;
        border-radius: 999px;
        background: var(--p3m-bg-soft);
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-600);
        font-size: 12px;
        font-weight: 800;
    }

    .news-read-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0 0 auto;
    }

    .btn-news-back,
    .btn-news-edit {
        min-height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 13px;
        border-radius: 11px;
        font-size: 13.25px;
        font-weight: 850;
        transition: .22s ease;
    }

    .btn-news-back {
        background: #ffffff;
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-700);
    }

    .btn-news-back:hover {
        background: var(--p3m-bg-soft);
        color: var(--p3m-slate-900);
        transform: translateY(-1px);
    }

    .btn-news-edit {
        background: var(--p3m-blue);
        border: 1px solid var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 10px 22px rgba(0, 61, 45, .16);
    }

    .btn-news-edit:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .news-read-body {
        padding: 22px;
    }

    .news-read-image,
    .news-read-image-fallback {
        width: 100%;
        height: 360px;
        border-radius: 18px;
        object-fit: cover;
        border: 1px solid var(--p3m-border);
        background: var(--p3m-bg-soft);
    }

    .news-read-image-fallback {
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--p3m-blue);
        font-size: 42px;
    }

    .news-content-box {
        margin-top: 20px;
        padding: 22px;
        border: 1px solid var(--p3m-border);
        border-radius: 18px;
        color: var(--p3m-slate-700);
        font-size: 15px;
        line-height: 1.85;
    }

    .news-content-box p:last-child {
        margin-bottom: 0;
    }

    @media (max-width: 767.98px) {
        .news-read-wrap {
            max-width: 100%;
        }

        .news-read-header {
            flex-direction: column;
        }

        .news-read-actions {
            width: 100%;
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-news-back,
        .btn-news-edit {
            width: 100%;
        }

        .news-read-body {
            padding: 16px;
        }

        .news-read-image,
        .news-read-image-fallback {
            height: 240px;
        }
    }
</style>
@endsection

@section('content')
@php
    $item = $news ?? $berita ?? $data ?? null;
@endphp

<div class="content-wrapper news-read-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="news-read-wrap">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Kegiatan P3M</a></li>
                    <li class="breadcrumb-item active">{{ $pagetitle ?? 'Detail Kegiatan' }}</li>
                </ol>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="news-read-wrap">
                @if(!$item)
                    <div class="alert alert-danger">Data kegiatan tidak ditemukan.</div>
                @else
                    @php
                        $imagePath = !empty($item->image) ? 'storage/photo-news/'.$item->image : null;
                        $imageExists = $imagePath && file_exists(public_path($imagePath));
                        $categoryName = optional($item->category)->name
                            ?? optional($item->categories)->name
                            ?? optional($item->kategori)->name
                            ?? ($item->category_name ?? $item->kategori_name ?? '-');
                        $authorName = optional($item->user)->name ?? optional($item->users)->name ?? ($item->pembuat ?? '-');
                    @endphp

                    <article class="news-read-panel">
                        <div class="news-read-header">
                            <div class="news-read-title">
                                <span class="news-kicker">Detail Kegiatan</span>
                                <h1>{{ $item->title }}</h1>
                                <div class="news-read-meta">
                                    <span class="news-meta-pill">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $item->date ?? '-' }}
                                    </span>
                                    <span class="news-meta-pill">
                                        <i class="fas fa-user"></i>
                                        {{ $authorName }}
                                    </span>
                                    <span class="news-meta-pill">
                                        <i class="fas fa-layer-group"></i>
                                        {{ $categoryName }}
                                    </span>
                                </div>
                            </div>

                            <div class="news-read-actions">
                                <a href="{{ route('news.index') }}" class="btn btn-news-back">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                                <a href="{{ route('news.edit', ['id' => $item->id]) }}" class="btn btn-news-edit">
                                    Edit
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </div>

                        <div class="news-read-body">
                            @if($imageExists)
                                <img src="{{ asset($imagePath) }}" alt="{{ $item->title }}" class="news-read-image">
                            @else
                                <div class="news-read-image-fallback">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif

                            <div class="news-content-box">
                                {{ strip_tags($item->content) }}
                            </div>
                        </div>
                    </article>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
