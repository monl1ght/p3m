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

    .panduan-view-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .panduan-view-page .content {
        padding-top: 8px;
    }

    .panduan-view-wrap {
        width: 100%;
        max-width: 1140px;
        margin: 0 auto;
    }

    .panduan-view-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .panduan-view-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
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

    .panduan-view-title h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .panduan-view-title p {
        margin: 7px 0 0;
        color: var(--p3m-slate-500);
        font-size: 13.25px;
        line-height: 1.6;
    }

    .panduan-view-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0 0 auto;
    }

    .btn-panduan-back,
    .btn-panduan-download {
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

    .btn-panduan-back {
        background: #ffffff;
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-700);
    }

    .btn-panduan-back:hover {
        color: var(--p3m-slate-900);
        transform: translateY(-1px);
    }

    .btn-panduan-download {
        background: var(--p3m-blue);
        border: 1px solid var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 10px 22px rgba(37, 99, 235, .16);
    }

    .btn-panduan-download:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .panduan-view-body {
        padding: 20px;
        background: var(--p3m-bg-soft);
    }

    .panduan-frame {
        width: 100%;
        height: 680px;
        border: 1px solid var(--p3m-border);
        border-radius: 16px;
        background: #ffffff;
    }

    @media (max-width: 767.98px) {
        .panduan-view-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .panduan-view-actions {
            width: 100%;
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-panduan-back,
        .btn-panduan-download {
            width: 100%;
        }

        .panduan-frame {
            height: 560px;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper panduan-view-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="panduan-view-wrap">
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
            <div class="panduan-view-wrap">
                <div class="panduan-view-panel">
                    <div class="panduan-view-header">
                        <div class="panduan-view-title">
                            <span class="panduan-kicker">Preview Dokumen</span>
                            <h1>{{ $panduan->namefile }}</h1>
                            <p>{{ $panduan->original_name }}</p>
                        </div>

                        <div class="panduan-view-actions">
                            <a href="{{ route('panduan.index') }}" class="btn btn-panduan-back">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <a href="{{ route('panduan.download', $panduan->id) }}" class="btn btn-panduan-download">
                                Download PDF
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>

                    <div class="panduan-view-body">
                        <iframe src="{{ asset('uplouds/' . $panduan->generated_name) }}" class="panduan-frame" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
