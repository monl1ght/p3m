@extends('layout.main')

@section('title', 'Detail HKI: ' . $hki->judul . ' - Panel Admin P3M')
@section('body_class', 'page-detail-hki')

@section('css')
<style>
/* =========================================================================
   P3M POLIBANG — DETAIL HKI ADMIN (SAMAKAN 100% DENGAN DETAIL HKI DOSEN)
   Identik dengan Desain Standar Sistem P3M Polibang
   ========================================================================= */

:root {
    --p3m-forest: #003d2d;
    --p3m-forest-mid: #005a3e;
    --p3m-forest-soft: #edf6f1;
    --p3m-forest-soft-2: #e2f0e8;

    --p3m-gold: #b99835;
    --p3m-gold-soft: #fcf8ec;

    --p3m-ink: #0b1d16;
    --p3m-ink-2: #1e3129;
    --p3m-text: #2f433b;
    --p3m-muted: #5e736b;
    --p3m-light: #8e9f98;

    --p3m-line: #e2ece6;
    --p3m-line-2: #cfded6;
    --p3m-surface: #ffffff;
    --p3m-surface-alt: #f7faf8;
    --p3m-surface-hover: #f1f6f3;

    --p3m-success: #077943;
    --p3m-success-bg: #eaf8ef;
    --p3m-success-border: #b8e6cc;

    --p3m-warning: #855b0a;
    --p3m-warning-bg: #fff8e8;
    --p3m-warning-border: #fae4a8;

    --p3m-danger: #b91c1c;
    --p3m-danger-bg: #fef2f2;
    --p3m-danger-border: #fecaca;

    --p3m-r-sm: 8px;
    --p3m-r-md: 12px;
    --p3m-r-lg: 16px;
    --p3m-r-xl: 20px;
}

.content-wrapper {
    background:
        radial-gradient(ellipse 70% 35% at 100% 0%, rgba(0, 93, 59, .04), transparent 70%),
        linear-gradient(180deg, #f2f7f4 0%, #f7faf8 100%) !important;
    min-height: calc(100vh - 66px);
}

.p3m-shell {
    width: min(1280px, calc(100% - 44px));
    margin: 0 auto;
}

.content-header {
    padding: 22px 0 14px !important;
}

section.content {
    padding: 0 0 44px !important;
}

/* -------------------------------------------------------------------------
   TOP BAR (BREADCRUMB & ACTIONS)
   ------------------------------------------------------------------------- */
.p3m-page-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.p3m-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    color: var(--p3m-forest);
    background: var(--p3m-surface);
    border: 1px solid var(--p3m-line);
    padding: 8px 16px;
    border-radius: var(--p3m-r-md);
    text-decoration: none !important;
    transition: all .18s cubic-bezier(.16, 1, .3, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, .02);
}

.p3m-back-btn:hover {
    color: var(--p3m-forest);
    background: var(--p3m-forest-soft);
    border-color: #cde0d5;
    transform: translateX(-2px);
}

.p3m-top-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-p3m-print {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 15px;
    background: var(--p3m-surface);
    border: 1px solid var(--p3m-line);
    border-radius: var(--p3m-r-md);
    font-size: 12.5px;
    font-weight: 600;
    color: var(--p3m-muted);
    text-decoration: none !important;
    transition: all .15s ease;
    cursor: pointer;
}

.btn-p3m-print:hover {
    background: var(--p3m-surface-alt);
    color: var(--p3m-ink);
    border-color: var(--p3m-line-2);
}

/* -------------------------------------------------------------------------
   MAIN DOCUMENT CONTAINER
   ------------------------------------------------------------------------- */
.p3m-doc-container {
    background: var(--p3m-surface);
    border: 1px solid var(--p3m-line);
    border-radius: var(--p3m-r-xl);
    box-shadow: 0 8px 30px rgba(3, 50, 33, .04), 0 1px 3px rgba(0, 0, 0, .01);
    overflow: hidden;
    margin-bottom: 24px;
}

/* Document Header Banner */
.p3m-doc-banner {
    padding: 28px 36px 26px;
    background: linear-gradient(135deg, #ffffff 60%, #f4faf6 100%);
    border-bottom: 1px solid var(--p3m-line);
}

.p3m-banner-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}

.p3m-category-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 4px 12px;
    background: var(--p3m-forest-soft);
    border: 1px solid #cce2d6;
    border-radius: 99px;
    font-size: 11.5px;
    font-weight: 700;
    color: var(--p3m-forest);
    letter-spacing: .02em;
}

.p3m-category-badge .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--p3m-gold);
}

.p3m-field-tag {
    font-size: 12px;
    font-weight: 600;
    color: var(--p3m-muted);
}

.p3m-doc-title {
    font-family: "Plus Jakarta Sans", "Inter", sans-serif;
    font-size: 23px;
    font-weight: 800;
    color: var(--p3m-ink);
    line-height: 1.35;
    letter-spacing: -.02em;
    margin: 0 0 24px;
}

/* 4-Item Metrics Row */
.p3m-metrics-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.p3m-metric-card {
    background: var(--p3m-surface);
    border: 1px solid var(--p3m-line);
    border-radius: var(--p3m-r-md);
    padding: 14px 18px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    transition: all .18s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .01);
}

.p3m-metric-card:hover {
    border-color: var(--p3m-line-2);
    box-shadow: 0 4px 12px rgba(0, 61, 45, .04);
}

.p3m-metric-lbl {
    font-size: 11px;
    font-weight: 700;
    color: var(--p3m-light);
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 4px;
}

.p3m-metric-val {
    font-size: 15px;
    font-weight: 800;
    color: var(--p3m-ink);
    line-height: 1.3;
}

.p3m-metric-val.code {
    font-family: monospace;
    color: var(--p3m-forest-mid);
    font-size: 14px;
}

/* -------------------------------------------------------------------------
   DOCUMENT BODY (65% / 35%)
   ------------------------------------------------------------------------- */
.p3m-doc-body {
    padding: 32px 36px;
}

.p3m-columns-wrap {
    display: grid;
    grid-template-columns: 1.35fr 0.95fr;
    gap: 36px;
    align-items: start;
}

/* Section Header */
.p3m-block-title {
    font-size: 13.5px;
    font-weight: 800;
    color: var(--p3m-ink);
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.p3m-block-title span.count {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--p3m-muted);
    text-transform: none;
    letter-spacing: normal;
}

/* Ketua Peneliti / Pengusul Card */
.p3m-lead-card {
    background: var(--p3m-surface-alt);
    border: 1px solid var(--p3m-line);
    border-radius: var(--p3m-r-lg);
    padding: 20px 22px;
    margin-bottom: 28px;
    transition: border-color .15s ease;
}

.p3m-lead-card:hover {
    border-color: var(--p3m-line-2);
}

.p3m-lead-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 18px;
}

.p3m-lead-avatar {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--p3m-forest) 0%, var(--p3m-forest-mid) 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    font-weight: 800;
    box-shadow: 0 4px 10px rgba(0, 61, 45, .15);
    flex-shrink: 0;
    overflow: hidden;
}

.p3m-lead-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.p3m-lead-title-box {
    flex: 1;
    min-width: 0;
}

.p3m-lead-name {
    font-size: 16.5px;
    font-weight: 800;
    color: var(--p3m-ink);
    margin: 0 0 3px;
    line-height: 1.25;
}

.p3m-lead-tags {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.p3m-tag-pill {
    display: inline-flex;
    padding: 2px 9px;
    border-radius: 6px;
    background: #ffffff;
    border: 1px solid var(--p3m-line);
    font-size: 11.5px;
    font-weight: 700;
    color: var(--p3m-forest);
}

.p3m-tag-muted {
    font-size: 12px;
    color: var(--p3m-muted);
}

/* Key-Value Info Grid */
.p3m-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px 20px;
    padding-top: 14px;
    border-top: 1px solid var(--p3m-line);
}

.p3m-info-cell {
    display: flex;
    flex-direction: column;
}

.p3m-info-cell.full {
    grid-column: 1 / -1;
}

.p3m-info-k {
    font-size: 11px;
    font-weight: 600;
    color: var(--p3m-light);
    margin-bottom: 2px;
}

.p3m-info-v {
    font-size: 13px;
    font-weight: 700;
    color: var(--p3m-text);
    word-break: break-word;
}

/* Anggota Table / Roster */
.p3m-roster-wrap {
    background: var(--p3m-surface);
    border: 1px solid var(--p3m-line);
    border-radius: var(--p3m-r-lg);
    overflow: hidden;
}

.p3m-roster-table {
    width: 100%;
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.p3m-roster-table thead th {
    background: var(--p3m-surface-alt);
    padding: 10px 18px;
    font-size: 11px;
    font-weight: 800;
    color: var(--p3m-light);
    text-transform: uppercase;
    letter-spacing: .04em;
    border-top: none;
    border-bottom: 1px solid var(--p3m-line);
}

.p3m-roster-table tbody td {
    padding: 14px 18px;
    font-size: 13px;
    color: var(--p3m-text);
    border-bottom: 1px solid var(--p3m-line);
    vertical-align: middle;
}

.p3m-roster-table tbody tr:last-child td {
    border-bottom: none;
}

.p3m-roster-table tbody tr:hover td {
    background: var(--p3m-surface-alt);
}

.p3m-member-bold {
    font-weight: 700;
    color: var(--p3m-ink);
}

/* File Attachments (Right Column) */
.p3m-files-card {
    background: var(--p3m-surface);
    border: 1px solid var(--p3m-line);
    border-radius: var(--p3m-r-lg);
    padding: 8px 18px;
    margin-bottom: 24px;
}

.p3m-file-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 14px 0;
    border-bottom: 1px solid var(--p3m-line);
}

.p3m-file-row:last-child {
    border-bottom: none;
}

.p3m-file-left {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}

.p3m-file-icon-box {
    width: 38px;
    height: 38px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.p3m-file-icon-box.pdf {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fed7d7;
}

.p3m-file-name {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--p3m-ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
    max-width: 220px;
}

.p3m-file-desc {
    font-size: 11.5px;
    color: var(--p3m-muted);
}

.btn-p3m-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 13px;
    background: var(--p3m-surface-alt);
    border: 1px solid var(--p3m-line-2);
    border-radius: var(--p3m-r-sm);
    font-size: 12px;
    font-weight: 700;
    color: var(--p3m-forest);
    text-decoration: none !important;
    white-space: nowrap;
    transition: all .16s ease;
}

.btn-p3m-action:hover {
    background: var(--p3m-forest);
    border-color: var(--p3m-forest);
    color: #ffffff;
}

/* System Meta Card */
.p3m-meta-card {
    background: var(--p3m-surface-alt);
    border: 1px solid var(--p3m-line);
    border-radius: var(--p3m-r-lg);
    padding: 18px 20px;
}

.p3m-meta-title {
    font-size: 11.5px;
    font-weight: 800;
    color: var(--p3m-muted);
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 12px;
}

.p3m-meta-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    font-size: 12.5px;
}

.p3m-meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--p3m-line);
}

.p3m-meta-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.p3m-meta-k {
    color: var(--p3m-muted);
}

.p3m-meta-v {
    font-weight: 700;
    color: var(--p3m-ink);
}

/* -------------------------------------------------------------------------
   RESPONSIVE BREAKPOINTS
   ------------------------------------------------------------------------- */
@media (max-width: 991.98px) {
    .p3m-shell {
        width: calc(100% - 32px);
    }
    .p3m-doc-banner {
        padding: 22px 24px;
    }
    .p3m-doc-body {
        padding: 24px;
    }
    .p3m-columns-wrap {
        grid-template-columns: 1fr;
        gap: 32px;
    }
    .p3m-metrics-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 767.98px) {
    .p3m-shell {
        width: calc(100% - 24px);
    }
    .p3m-doc-title {
        font-size: 19px;
    }
    .p3m-metrics-row {
        grid-template-columns: 1fr;
    }
    .p3m-info-grid {
        grid-template-columns: 1fr;
    }
    .p3m-page-topbar {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media print {
    .main-header, .main-sidebar, .p3m-page-topbar, .btn-p3m-action, footer {
        display: none !important;
    }
    .content-wrapper {
        background: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .p3m-doc-container {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="p3m-shell">
            {{-- Top Navigation Bar --}}
            <div class="p3m-page-topbar">
                <a href="{{ route('plppm.hki_dosen') }}" class="p3m-back-btn">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar HKI
                </a>
                <div class="p3m-top-actions">
                    <button type="button" class="btn-p3m-print" onclick="window.print()" title="Cetak Dokumen HKI">
                        <i class="fas fa-print"></i> Cetak HKI
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="p3m-shell">

            {{-- Main Document Card --}}
            <div class="p3m-doc-container">

                {{-- Banner Header --}}
                <div class="p3m-doc-banner">
                    <div class="p3m-banner-top">
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <span class="p3m-category-badge">
                                <span class="dot"></span>
                                {{ $hki->jenis_hki ?: 'Hak Kekayaan Intelektual' }}
                            </span>
                            <span class="p3m-field-tag">• #HKI-{{ str_pad($hki->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>

                    {{-- HKI Title --}}
                    <h1 class="p3m-doc-title">{{ $hki->judul }}</h1>

                    {{-- 4-Item Metrics Row --}}
                    <div class="p3m-metrics-row">
                        <div class="p3m-metric-card">
                            <span class="p3m-metric-lbl">Nomor Pencatatan</span>
                            <span class="p3m-metric-val code" title="{{ $hki->nomor_pencatatan }}">
                                {{ $hki->nomor_pencatatan ?: 'Dalam Proses' }}
                            </span>
                        </div>
                        <div class="p3m-metric-card">
                            <span class="p3m-metric-lbl">Tanggal Perolehan</span>
                            <span class="p3m-metric-val">
                                {{ $hki->tanggal ? \Carbon\Carbon::parse($hki->tanggal)->translatedFormat('d M Y') : '—' }}
                            </span>
                        </div>
                        <div class="p3m-metric-card">
                            <span class="p3m-metric-lbl">Jenis HKI</span>
                            <span class="p3m-metric-val" style="font-size: 14.5px;">
                                {{ $hki->jenis_hki ?: 'Hak Cipta' }}
                            </span>
                        </div>
                        <div class="p3m-metric-card">
                            <span class="p3m-metric-lbl">Total Pencipta</span>
                            <span class="p3m-metric-val">
                                {{ $hki->anggotas->count() }} Orang
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Document Body Grid --}}
                <div class="p3m-doc-body">
                    <div class="p3m-columns-wrap">

                        {{-- Left Column: Ketua & Tim Pencipta --}}
                        <div class="p3m-col-main">

                            @php
                                $dosenOwner = $hki->user;
                                $ketua = $hki->anggotas->first(function($a) {
                                    return str_contains(strtolower($a->peran ?? ''), 'ketua') || $a->urutan === 1;
                                }) ?? $hki->anggotas->first();

                                $ketuaNama = $ketua ? $ketua->nama : ($dosenOwner->name ?? 'Dosen Pengusul');
                                $ketuaNidn = $ketua ? ($ketua->nim_nidn ?: ($dosenOwner->nidn ?? '—')) : ($dosenOwner->nidn ?? '—');
                                $ketuaPeran = $ketua ? ($ketua->peran ?: 'Ketua Pencipta') : 'Ketua Pencipta';
                                $ketuaInitial = strtoupper(substr($ketuaNama, 0, 1));

                                $avatarPath = !empty($dosenOwner->image) ? 'storage/photo-user/' . $dosenOwner->image : null;
                                $avatarExists = $avatarPath && file_exists(public_path($avatarPath));
                            @endphp

                            {{-- Ketua Pencipta Box --}}
                            <div class="p3m-block-title">
                                <span>Ketua Pencipta / Dosen Pengusul</span>
                            </div>

                            <div class="p3m-lead-card">
                                <div class="p3m-lead-header">
                                    <div class="p3m-lead-avatar">
                                        @if ($avatarExists)
                                            <img src="{{ asset($avatarPath) }}" alt="{{ $ketuaNama }}">
                                        @else
                                            {{ $ketuaInitial }}
                                        @endif
                                    </div>
                                    <div class="p3m-lead-title-box">
                                        <h3 class="p3m-lead-name">{{ $ketuaNama }}</h3>
                                        <div class="p3m-lead-tags">
                                            <span class="p3m-tag-pill">{{ $ketuaPeran }}</span>
                                            <span class="p3m-tag-muted">• Dosen Pengusul</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p3m-info-grid">
                                    <div class="p3m-info-cell">
                                        <span class="p3m-info-k">NIDN / Nomor Induk</span>
                                        <span class="p3m-info-v">{{ $ketuaNidn }}</span>
                                    </div>
                                    <div class="p3m-info-cell">
                                        <span class="p3m-info-k">Peran / Kontribusi</span>
                                        <span class="p3m-info-v">{{ $ketuaPeran }}</span>
                                    </div>
                                    <div class="p3m-info-cell">
                                        <span class="p3m-info-k">Akun Pengusul</span>
                                        <span class="p3m-info-v">{{ $dosenOwner->name ?? '—' }}</span>
                                    </div>
                                    <div class="p3m-info-cell">
                                        <span class="p3m-info-k">Email Pengusul</span>
                                        <span class="p3m-info-v">{{ $dosenOwner->email ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Anggota Tim Table --}}
                            <div class="p3m-block-title">
                                <span>Anggota Tim Pencipta</span>
                                <span class="count">{{ $hki->anggotas->count() }} Pencipta Terdaftar</span>
                            </div>

                            @if($hki->anggotas && $hki->anggotas->count() > 0)
                                <div class="p3m-roster-wrap">
                                    <table class="p3m-roster-table">
                                        <thead>
                                            <tr>
                                                <th width="42%">Nama Anggota</th>
                                                <th width="30%">Peran / Jabatan</th>
                                                <th width="28%">NIM / NIDN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hki->anggotas as $anggota)
                                                <tr>
                                                    <td>
                                                        <div class="p3m-member-bold">{{ $anggota->nama }}</div>
                                                    </td>
                                                    <td>
                                                        @if(str_contains(strtolower($anggota->peran ?? ''), 'ketua') || $anggota->urutan === 1)
                                                            <span class="p3m-tag-pill" style="font-size: 11px; background: var(--p3m-forest-soft); color: var(--p3m-forest);">
                                                                {{ $anggota->peran ?: 'Ketua Pencipta' }}
                                                            </span>
                                                        @else
                                                            <span class="p3m-tag-pill" style="font-size: 11px;">
                                                                {{ $anggota->peran ?: 'Anggota' }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span style="font-family: monospace; color: var(--p3m-text);">
                                                            {{ $anggota->nim_nidn ?: '—' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div style="padding: 18px; text-align: center; background: var(--p3m-surface-alt); border: 1px dashed var(--p3m-line-2); border-radius: var(--p3m-r-md); color: var(--p3m-muted); font-size: 12.5px;">
                                    Tidak ada data anggota pencipta terdaftar.
                                </div>
                            @endif

                        </div>

                        {{-- Right Column: Berkas Lampiran & Metadata --}}
                        <div class="p3m-col-side">

                            {{-- Berkas Lampiran --}}
                            <div class="p3m-block-title">
                                <span>Berkas Lampiran</span>
                            </div>

                            <div class="p3m-files-card">
                                @if(!empty($hki->file_path))
                                    <div class="p3m-file-row">
                                        <div class="p3m-file-left">
                                            <div class="p3m-file-icon-box pdf">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div style="min-width: 0;">
                                                <span class="p3m-file-name" title="{{ $hki->file_name ?: 'Sertifikat_HKI.pdf' }}">
                                                    {{ $hki->file_name ?: 'Sertifikat_HKI.pdf' }}
                                                </span>
                                                <span class="p3m-file-desc">Dokumen Sertifikat HKI</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('plppm.hki_dosen.download', $hki->id) }}" target="_blank" class="btn-p3m-action" title="Unduh Sertifikat HKI">
                                            <i class="fas fa-download"></i> Unduh
                                        </a>
                                    </div>
                                @else
                                    <div style="padding: 16px 0; color: var(--p3m-muted); font-size: 12.5px; text-align: center;">
                                        Tidak ada berkas sertifikat yang diunggah.
                                    </div>
                                @endif
                            </div>

                            {{-- Metadata Informasi HKI --}}
                            <div class="p3m-meta-card">
                                <div class="p3m-meta-title">Informasi Registrasi</div>
                                <div class="p3m-meta-list">
                                    <div class="p3m-meta-row">
                                        <span class="p3m-meta-k">Nomor Registrasi</span>
                                        <span class="p3m-meta-v">#HKI-{{ str_pad($hki->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <div class="p3m-meta-row">
                                        <span class="p3m-meta-k">Tanggal Pengajuan</span>
                                        <span class="p3m-meta-v">{{ $hki->created_at ? $hki->created_at->translatedFormat('d M Y, H:i') : '—' }}</span>
                                    </div>
                                    <div class="p3m-meta-row">
                                        <span class="p3m-meta-k">Terakhir Diperbarui</span>
                                        <span class="p3m-meta-v">{{ $hki->updated_at ? $hki->updated_at->translatedFormat('d M Y, H:i') : '—' }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>
</div>
@endsection
