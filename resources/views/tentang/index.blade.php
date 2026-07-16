@extends('layout.main')

@section('css')
<style>
    :root {
        --p3m-blue: #2563eb;
        --p3m-blue-dark: #1d4ed8;
        --p3m-gold: #d5a72f;
        --p3m-slate-900: #0f172a;
        --p3m-slate-700: #334155;
        --p3m-slate-600: #475569;
        --p3m-slate-500: #64748b;
        --p3m-border: #e2e8f0;
        --p3m-border-soft: #eef2f7;
        --p3m-bg-soft: #f8fafc;
    }

    .tentang-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .tentang-page .content {
        padding-top: 8px;
    }

    .tentang-wrap {
        width: 100%;
        max-width: 1120px;
        margin: 0 auto;
    }

    .tentang-breadcrumb {
        margin-bottom: 12px;
    }

    .tentang-breadcrumb .breadcrumb {
        margin: 0;
    }

    .tentang-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .tentang-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 22px 24px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .tentang-title-group {
        min-width: 0;
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

    .tentang-panel-header h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .tentang-panel-header p {
        max-width: 620px;
        margin: 7px 0 0;
        color: var(--p3m-slate-500);
        font-size: 13.25px;
        line-height: 1.6;
    }

    .tentang-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0 0 auto;
    }

    .btn-tentang-primary,
    .btn-tentang-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 38px;
        padding: 8px 13px;
        border-radius: 11px;
        font-size: 13.25px;
        font-weight: 850;
        transition: .22s ease;
    }

    .btn-tentang-primary {
        background: var(--p3m-blue);
        border: 1px solid var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 10px 22px rgba(37, 99, 235, .16);
    }

    .btn-tentang-primary:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-tentang-soft {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: var(--p3m-blue);
    }

    .btn-tentang-soft:hover {
        background: var(--p3m-blue);
        border-color: var(--p3m-blue);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .tentang-panel-body {
        padding: 24px;
    }

    .tentang-empty {
        padding: 34px 22px;
        border: 1px dashed var(--p3m-border);
        border-radius: 18px;
        background: var(--p3m-bg-soft);
        text-align: center;
        color: var(--p3m-slate-500);
        font-weight: 650;
    }

    .tentang-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .tentang-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        border: 1px solid var(--p3m-border);
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .035);
    }

    .tentang-card::before {
        content: "";
        position: absolute;
        top: 18px;
        bottom: 18px;
        left: 0;
        width: 3px;
        border-radius: 999px;
        background: var(--p3m-gold);
    }

    .tentang-card-full {
        grid-column: 1 / -1;
    }

    .tentang-card-head {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 20px 12px;
    }

    .tentang-card-icon {
        width: 38px;
        height: 38px;
        border-radius: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        color: var(--p3m-blue);
        background: #eff6ff;
        border: 1px solid #dbeafe;
    }

    .tentang-card-title {
        min-width: 0;
    }

    .tentang-card-title h2 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-size: 16px;
        line-height: 1.25;
        font-weight: 900;
        letter-spacing: -0.025em;
    }

    .tentang-card-title span {
        display: block;
        margin-top: 3px;
        color: var(--p3m-slate-500);
        font-size: 12.5px;
        font-weight: 650;
    }

    .tentang-card-body {
        padding: 0 20px 20px 70px;
        color: var(--p3m-slate-700);
        font-size: 14.25px;
        line-height: 1.75;
    }

    .tentang-card-body p {
        margin-bottom: 10px;
    }

    .tentang-card-body p:last-child {
        margin-bottom: 0;
    }

    .tentang-card-body ul,
    .tentang-card-body ol {
        margin-top: 0;
        margin-bottom: 0;
        padding-left: 20px;
    }

    .tentang-card-body li {
        margin-bottom: 6px;
        padding-left: 2px;
    }

    .tentang-card-body li:last-child {
        margin-bottom: 0;
    }

    @media (max-width: 991.98px) {
        .tentang-grid {
            grid-template-columns: 1fr;
        }

        .tentang-card-full {
            grid-column: auto;
        }
    }

    @media (max-width: 767.98px) {
        .tentang-wrap {
            max-width: 100%;
        }

        .tentang-panel-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .tentang-actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .btn-tentang-primary,
        .btn-tentang-soft {
            width: 100%;
        }

        .tentang-panel-body {
            padding: 16px;
        }

        .tentang-card-head {
            padding: 16px 16px 10px;
        }

        .tentang-card-body {
            padding: 0 16px 18px 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper tentang-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="tentang-wrap">
                <div class="tentang-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $pagetitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="tentang-wrap">
                @php
                    $tentang = $bout->first();
                @endphp

                <div class="tentang-panel">
                    <div class="tentang-panel-header">
                        <div class="tentang-title-group">
                            <span class="tentang-kicker">Profil P3M</span>
                            <h1>Tentang P3M</h1>
                            <p>Kelola informasi visi, misi, dan deskripsi P3M yang tampil pada halaman publik website.</p>
                        </div>

                        <div class="tentang-actions">
                            <a href="{{ route('tentang.create') }}" class="btn-tentang-primary">
                                <i class="fas fa-plus"></i>
                                Tambah
                            </a>

                            @if($tentang)
                                <a href="{{ route('tentang.edit', ['id' => $tentang->id]) }}" class="btn-tentang-soft">
                                    <i class="fas fa-pen"></i>
                                    Edit
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="tentang-panel-body">
                        @if(!$tentang)
                            <div class="tentang-empty">
                                Belum ada data Tentang P3M. Silakan tambahkan data terlebih dahulu.
                            </div>
                        @else
                            <div class="tentang-grid">
                                <article class="tentang-card">
                                    <div class="tentang-card-head">
                                        <span class="tentang-card-icon">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <div class="tentang-card-title">
                                            <h2>Visi</h2>
                                            <span>Arah dan tujuan utama P3M.</span>
                                        </div>
                                    </div>
                                    <div class="tentang-card-body">
                                        {!! $tentang->visi !!}
                                    </div>
                                </article>

                                <article class="tentang-card">
                                    <div class="tentang-card-head">
                                        <span class="tentang-card-icon">
                                            <i class="fas fa-bullseye"></i>
                                        </span>
                                        <div class="tentang-card-title">
                                            <h2>Misi</h2>
                                            <span>Langkah strategis pendukung visi.</span>
                                        </div>
                                    </div>
                                    <div class="tentang-card-body">
                                        {!! $tentang->misi !!}
                                    </div>
                                </article>

                                <article class="tentang-card tentang-card-full">
                                    <div class="tentang-card-head">
                                        <span class="tentang-card-icon">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                        <div class="tentang-card-title">
                                            <h2>Tentang P3M</h2>
                                            <span>Informasi umum Pusat Penelitian dan Pengabdian.</span>
                                        </div>
                                    </div>
                                    <div class="tentang-card-body">
                                        {!! $tentang->ourbout !!}
                                    </div>
                                </article>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
