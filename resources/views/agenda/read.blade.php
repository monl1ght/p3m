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
        --p3m-bg-soft: #f8fafc;
    }

    .agenda-read-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .agenda-read-page .content {
        padding-top: 8px;
    }

    .agenda-read-wrap {
        width: 100%;
        max-width: 1040px;
        margin: 0 auto;
    }

    .agenda-read-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .agenda-read-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        padding: 20px 22px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .agenda-kicker {
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

    .agenda-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: var(--p3m-gold);
    }

    .agenda-read-title {
        min-width: 0;
    }

    .agenda-read-title h1 {
        max-width: 760px;
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.35rem, 1.75vw, 1.9rem);
        line-height: 1.25;
        font-weight: 900;
        letter-spacing: -0.045em;
    }

    .agenda-read-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .agenda-meta-pill {
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

    .agenda-read-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0 0 auto;
    }

    .btn-agenda-back,
    .btn-agenda-edit {
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

    .btn-agenda-back {
        background: #ffffff;
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-700);
    }

    .btn-agenda-back:hover {
        background: var(--p3m-bg-soft);
        color: var(--p3m-slate-900);
        transform: translateY(-1px);
    }

    .btn-agenda-edit {
        background: var(--p3m-blue);
        border: 1px solid var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 10px 22px rgba(37, 99, 235, .16);
    }

    .btn-agenda-edit:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .agenda-read-body {
        padding: 22px;
    }

    .agenda-content-box {
        padding: 22px;
        border: 1px solid var(--p3m-border);
        border-radius: 18px;
        color: var(--p3m-slate-700);
        font-size: 15px;
        line-height: 1.85;
    }

    .agenda-content-box p:last-child {
        margin-bottom: 0;
    }

    .agenda-content-box img {
        max-width: 100%;
        height: auto;
        border-radius: 14px;
        margin: 10px 0;
    }

    @media (max-width: 767.98px) {
        .agenda-read-wrap {
            max-width: 100%;
        }

        .agenda-read-header {
            flex-direction: column;
        }

        .agenda-read-actions {
            width: 100%;
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-agenda-back,
        .btn-agenda-edit {
            width: 100%;
        }

        .agenda-read-body {
            padding: 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper agenda-read-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="agenda-read-wrap">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></li>
                    <li class="breadcrumb-item active">Detail Agenda</li>
                </ol>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="agenda-read-wrap">
                <article class="agenda-read-panel">
                    <div class="agenda-read-header">
                        <div class="agenda-read-title">
                            <span class="agenda-kicker">Detail Agenda</span>
                            <h1>{{ $data->title }}</h1>
                            <div class="agenda-read-meta">
                                <span class="agenda-meta-pill">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $data->date }}
                                </span>
                                <span class="agenda-meta-pill">
                                    <i class="fas fa-clock"></i>
                                    {{ \Illuminate\Support\Str::limit($data->time, 5, '') }}
                                </span>
                                <span class="agenda-meta-pill">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $data->lokasi }}
                                </span>
                            </div>
                        </div>

                        <div class="agenda-read-actions">
                            <a href="{{ route('agenda.index') }}" class="btn btn-agenda-back">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <a href="{{ route('agenda.edit', ['id' => $data->id]) }}" class="btn btn-agenda-edit">
                                Edit
                                <i class="fas fa-pen"></i>
                            </a>
                        </div>
                    </div>

                    <div class="agenda-read-body">
                        <div class="agenda-content-box">
                            {!! $data->keterangan !!}
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</div>
@endsection
