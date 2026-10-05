@extends($layout)

@section('body_class', 'page-detail-proposal')

@section('css')
<style>
/* =========================================================================
   P3M POLIBANG — DETAIL PROPOSAL (PREMIUM HARMONIZED SYSTEM)
   Keseimbangan Sempurna: Bersih, Rapi, Elegan, Berwibawa, Enak Dilihat
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
    text-decoration: none;
    transition: all .18s cubic-bezier(.16, 1, .3, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, .02);
}

.p3m-back-btn:hover {
    color: var(--p3m-forest);
    background: var(--p3m-forest-soft);
    border-color: #cde0d5;
    text-decoration: none;
    transform: translateX(-2px);
}

.p3m-top-actions {
    display: flex;
    align-items: center;
    gap: 10px;
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
    text-decoration: none;
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

/* Status Pill */
.p3m-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.p3m-status-pill.approved {
    background: var(--p3m-success-bg);
    color: var(--p3m-success);
    border: 1px solid var(--p3m-success-border);
}

.p3m-status-pill.process {
    background: var(--p3m-warning-bg);
    color: var(--p3m-warning);
    border: 1px solid var(--p3m-warning-border);
}

.p3m-status-pill.rejected {
    background: var(--p3m-danger-bg);
    color: var(--p3m-danger);
    border: 1px solid var(--p3m-danger-border);
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
    font-size: 15.5px;
    font-weight: 800;
    color: var(--p3m-ink);
    line-height: 1.3;
}

.p3m-metric-val.money {
    color: var(--p3m-forest-mid);
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

/* Ketua Pengusul Card */
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

.p3m-file-icon-box.img {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
    overflow: hidden;
}

.p3m-file-icon-box.img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.p3m-file-name {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--p3m-ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
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
    text-decoration: none;
    white-space: nowrap;
    transition: all .16s ease;
}

.btn-p3m-action:hover {
    background: var(--p3m-forest);
    border-color: var(--p3m-forest);
    color: #ffffff;
    text-decoration: none;
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
   HISTORY VERIFICATION TABLE
   ------------------------------------------------------------------------- */
.p3m-audit-card {
    background: var(--p3m-surface);
    border: 1px solid var(--p3m-line);
    border-radius: var(--p3m-r-xl);
    box-shadow: 0 4px 20px rgba(3, 50, 33, .03);
    overflow: hidden;
    margin-bottom: 24px;
}

.p3m-audit-head {
    padding: 18px 24px;
    background: linear-gradient(112deg, #ffffff 60%, #f4faf6 100%);
    border-bottom: 1px solid var(--p3m-line);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.p3m-audit-table {
    width: 100%;
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.p3m-audit-table thead th {
    background: var(--p3m-surface-alt);
    padding: 12px 18px;
    font-size: 11px;
    font-weight: 800;
    color: var(--p3m-light);
    text-transform: uppercase;
    letter-spacing: .04em;
    border-top: none;
    border-bottom: 1px solid var(--p3m-line);
}

.p3m-audit-table tbody td {
    padding: 15px 18px;
    font-size: 12.5px;
    color: var(--p3m-text);
    border-bottom: 1px solid var(--p3m-line);
    vertical-align: middle;
}

.p3m-audit-table tbody tr:last-child td {
    border-bottom: none;
}

.p3m-audit-table tbody tr:hover td {
    background: var(--p3m-surface-alt);
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
    .dosen-topbar, .main-sidebar, .p3m-page-topbar, .btn-p3m-action {
        display: none !important;
    }
    .content-wrapper {
        background: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .p3m-doc-container, .p3m-audit-card {
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
                <a href="javascript:history.back()" class="p3m-back-btn">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Proposal
                </a>
                <div class="p3m-top-actions">
                    <button type="button" class="btn-p3m-print" onclick="window.print()" title="Cetak Dokumen Proposal">
                        <i class="fas fa-print"></i> Cetak Dokumen
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
                                {{ $penelitians->jeniskategori ?? 'Proposal Kegiatan P3M' }}
                            </span>
                            @if(!empty($penelitians->bidang))
                                <span class="p3m-field-tag">• Bidang {{ ucwords($penelitians->bidang) }}</span>
                            @endif
                        </div>

                        {{-- Status Pill --}}
                        @php
                            $st = strtolower($penelitians->status ?? 'proses');
                            $statusClass = match($st) {
                                'approve'     => 'approved',
                                'non-approve' => 'rejected',
                                default       => 'process',
                            };
                            $statusLabel = match($st) {
                                'approve'     => 'Disetujui',
                                'non-approve' => 'Perlu Revisi / Ditolak',
                                default       => 'Sedang Diproses',
                            };
                            $statusIcon = match($st) {
                                'approve'     => 'fa-check-circle',
                                'non-approve' => 'fa-times-circle',
                                default       => 'fa-clock',
                            };
                        @endphp
                        <span class="p3m-status-pill {{ $statusClass }}">
                            <i class="fas {{ $statusIcon }}"></i> {{ $statusLabel }}
                        </span>
                        @if(!empty($penelitians->nomor_surat))
                            <span class="p3m-status-pill" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; margin-left: 8px;">
                                <i class="fas fa-certificate"></i> No. Surat: {{ $penelitians->nomor_surat }}
                            </span>
                        @endif
                    </div>

                    {{-- Research Title --}}
                    <h1 class="p3m-doc-title">{{ $penelitians->judul }}</h1>

                    {{-- 4-Item Metrics Row --}}
                    @php
                        $durasiStr = '—';
                        if (!empty($penelitians->lamapenelitian)) {
                            $durasiStr = $penelitians->lamapenelitian . ' Hari';
                        } elseif (!empty($penelitians->tanggal_mulai) && !empty($penelitians->tanggal_selesai)) {
                            try {
                                $s = \Carbon\Carbon::parse($penelitians->tanggal_mulai);
                                $e = \Carbon\Carbon::parse($penelitians->tanggal_selesai);
                                $durasiStr = ($s->diffInDays($e) + 1) . ' Hari';
                            } catch (\Exception $ex) {
                                $durasiStr = '—';
                            }
                        }
                    @endphp
                    <div class="p3m-metrics-row">
                        <div class="p3m-metric-card">
                            <span class="p3m-metric-lbl">Anggaran Usulan</span>
                            <span class="p3m-metric-val money">Rp {{ number_format((float)($penelitians->biaya ?? 0), 0, ',', '.') }}</span>
                        </div>
                        <div class="p3m-metric-card">
                            <span class="p3m-metric-lbl">Durasi Kegiatan</span>
                            <span class="p3m-metric-val">{{ $durasiStr }}</span>
                        </div>
                        <div class="p3m-metric-card">
                            <span class="p3m-metric-lbl">Periode Rencana</span>
                            <span class="p3m-metric-val" style="font-size: 14.5px;">
                                @if(!empty($penelitians->tanggal_mulai) && !empty($penelitians->tanggal_selesai))
                                    {{ \Carbon\Carbon::parse($penelitians->tanggal_mulai)->translatedFormat('d M Y') }} – {{ \Carbon\Carbon::parse($penelitians->tanggal_selesai)->translatedFormat('d M Y') }}
                                @elseif(!empty($penelitians->tanggal_mulai))
                                    Mulai {{ \Carbon\Carbon::parse($penelitians->tanggal_mulai)->translatedFormat('d M Y') }}
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                        <div class="p3m-metric-card">
                            <span class="p3m-metric-lbl">Lokasi Sasaran</span>
                            <span class="p3m-metric-val" style="font-size: 14px;" title="{{ $penelitians->lokasi ?? '' }}">
                                {{ !empty($penelitians->lokasi) ? ucwords($penelitians->lokasi) : '—' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Document Body Grid --}}
                <div class="p3m-doc-body">
                    <div class="p3m-columns-wrap">

                        {{-- Left Column: Ketua & Tim --}}
                        <div class="p3m-col-main">

                            {{-- Ketua Pengusul Box --}}
                            <div class="p3m-block-title">
                                <span>Ketua Pengusul / Dosen</span>
                            </div>

                            @php
                                $jabatanMap = [
                                    'DR' => 'Direktur',
                                    'LT' => 'Wakil Direktur',
                                    'KP' => 'Ketua Program Studi',
                                    'DS' => 'Dosen',
                                    'MHS' => 'Mahasiswa'
                                ];

                                $cJabatan = $jabatanMap[$penelitians->jabatan ?? ''] ?? ($penelitians->jabatan ?? '-');
                                $cProdi = \App\Services\SuratTugasPdfService::formatProdi($penelitians->prodi ?? null);
                                $cInitial = strtoupper(substr($penelitians->ketua ?? 'P', 0, 1));
                            @endphp

                            <div class="p3m-lead-card">
                                <div class="p3m-lead-header">
                                    <div class="p3m-lead-avatar">
                                        {{ $cInitial }}
                                    </div>
                                    <div class="p3m-lead-title-box">
                                        <h3 class="p3m-lead-name">{{ \App\Services\SuratTugasPdfService::sanitizeText($penelitians->ketua) }}</h3>
                                        <div class="p3m-lead-tags">
                                            <span class="p3m-tag-pill">{{ $cJabatan }}</span>
                                            <span class="p3m-tag-muted">• {{ $cProdi }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p3m-info-grid">
                                    <div class="p3m-info-cell">
                                        <span class="p3m-info-k">NIDN / Nomor Induk</span>
                                        <span class="p3m-info-v">{{ $penelitians->nidn ?? '—' }}</span>
                                    </div>
                                    <div class="p3m-info-cell">
                                        <span class="p3m-info-k">Jenis Kelamin</span>
                                        <span class="p3m-info-v">
                                            {{ $penelitians->jeniskelamin === 'P' ? 'Perempuan' : ($penelitians->jeniskelamin === 'L' ? 'Laki-laki' : '—') }}
                                        </span>
                                    </div>
                                    <div class="p3m-info-cell">
                                        <span class="p3m-info-k">Kontak / Telepon</span>
                                        <span class="p3m-info-v">{{ $penelitians->telp ?? '—' }}</span>
                                    </div>
                                    <div class="p3m-info-cell">
                                        <span class="p3m-info-k">Program Studi</span>
                                        <span class="p3m-info-v">{{ $cProdi }}</span>
                                    </div>
                                    <div class="p3m-info-cell full">
                                        <span class="p3m-info-k">Alamat / Institusi</span>
                                        <span class="p3m-info-v">{{ $penelitians->alamat ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Anggota Tim Table --}}
                            <div class="p3m-block-title">
                                <span>Anggota Tim Pengusul</span>
                                <span class="count">{{ $penelitians->anggotap3m ? $penelitians->anggotap3m->count() : 0 }} Anggota Terdaftar</span>
                            </div>

                            @if($penelitians->anggotap3m && $penelitians->anggotap3m->count() > 0)
                                <div class="p3m-roster-wrap">
                                    <table class="p3m-roster-table">
                                        <thead>
                                            <tr>
                                                <th width="35%">Nama Anggota</th>
                                                <th width="25%">Peran / Jabatan</th>
                                                <th width="25%">Program Studi</th>
                                                <th width="15%">NIM / NIDN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($penelitians->anggotap3m as $anggota)
                                                @php
                                                    $mJab = $jabatanMap[$anggota->jabatan ?? ''] ?? ($anggota->jabatan ?? '-');
                                                    $mProd = \App\Services\SuratTugasPdfService::formatProdi($anggota->prodi ?? null);
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="p3m-member-bold">{{ \App\Services\SuratTugasPdfService::sanitizeText($anggota->nama) }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="p3m-tag-pill" style="font-size: 11px;">{{ $mJab }}</span>
                                                    </td>
                                                    <td>{{ $mProd }}</td>
                                                    <td>{{ $anggota->nim ?? '—' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div style="padding: 18px; text-align: center; background: var(--p3m-surface-alt); border: 1px dashed var(--p3m-line-2); border-radius: var(--p3m-r-md); color: var(--p3m-muted); font-size: 12.5px;">
                                    Tidak ada data anggota tim terdaftar.
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
                                {{-- Naskah PDF --}}
                                @if(!empty($penelitians->uppdf))
                                    <div class="p3m-file-row">
                                        <div class="p3m-file-left">
                                            <div class="p3m-file-icon-box pdf">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div style="min-width: 0;">
                                                <span class="p3m-file-name" title="{{ $penelitians->uppdf }}">Naskah Proposal.pdf</span>
                                                <span class="p3m-file-desc">Dokumen PDF Proposal</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('submission.document.download', ['type' => $documentType, 'id' => $penelitians->id]) }}" class="btn-p3m-action" title="Unduh Berkas PDF">
                                            <i class="fas fa-download"></i> Unduh
                                        </a>
                                    </div>
                                @endif

                                {{-- Foto Dokumentasi Jika Ada --}}
                                @if(!empty($penelitians->foto))
                                    <div class="p3m-file-row">
                                        <div class="p3m-file-left">
                                            <div class="p3m-file-icon-box img">
                                                <img src="{{ asset('storage/photo-upp3m/' . $penelitians->foto) }}" alt="Thumbnail">
                                            </div>
                                            <div style="min-width: 0;">
                                                <span class="p3m-file-name">Foto Lampiran</span>
                                                <span class="p3m-file-desc">Dokumentasi Terkait</span>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/photo-upp3m/' . $penelitians->foto) }}" target="_blank" class="btn-p3m-action" title="Buka Gambar">
                                            <i class="fas fa-external-link-alt"></i> Buka Foto
                                        </a>
                                    </div>
                                @endif

                                @if(empty($penelitians->uppdf) && empty($penelitians->foto))
                                    <div style="padding: 16px 0; color: var(--p3m-muted); font-size: 12.5px; text-align: center;">
                                        Tidak ada berkas lampiran yang diunggah.
                                    </div>
                                @endif
                            </div>

                            {{-- Metadata Informasi Pengajuan --}}
                            <div class="p3m-meta-card">
                                <div class="p3m-meta-title">Informasi Registrasi</div>
                                <div class="p3m-meta-list">
                                    <div class="p3m-meta-row">
                                        <span class="p3m-meta-k">Nomor Registrasi</span>
                                        <span class="p3m-meta-v">#P3M-{{ str_pad($penelitians->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <div class="p3m-meta-row">
                                        <span class="p3m-meta-k">Tanggal Pengajuan</span>
                                        <span class="p3m-meta-v">{{ $penelitians->created_at ? $penelitians->created_at->translatedFormat('d M Y, H:i') : '—' }}</span>
                                    </div>
                                    <div class="p3m-meta-row">
                                        <span class="p3m-meta-k">Terakhir Diperbarui</span>
                                        <span class="p3m-meta-v">{{ $penelitians->updated_at ? $penelitians->updated_at->translatedFormat('d M Y, H:i') : '—' }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            {{-- Riwayat Keputusan Admin --}}
            @if(isset($statusHistories) && $statusHistories->isNotEmpty())
                <div class="p3m-audit-card">
                    <div class="p3m-audit-head">
                        <div class="p3m-block-title" style="margin: 0;">
                            <span>Riwayat Keputusan & Verifikasi Admin</span>
                        </div>
                        <span class="p3m-category-badge">{{ $statusHistories->count() }} Catatan</span>
                    </div>
                    <div class="table-responsive">
                        <table class="p3m-audit-table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="18%">Waktu Keputusan</th>
                                    <th width="15%">Status Sebelumnya</th>
                                    <th width="15%">Status Baru</th>
                                    <th width="20%">Admin Verifikator</th>
                                    <th width="27%">Catatan / Alasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statusHistories as $i => $h)
                                    @php
                                        $prev = strtolower($h->previous_status ?? '');
                                        $next = strtolower($h->status ?? '');

                                        $pClass = match($prev) {
                                            'approve'     => 'approved',
                                            'non-approve' => 'rejected',
                                            default       => 'process',
                                        };
                                        $nClass = match($next) {
                                            'approve'     => 'approved',
                                            'non-approve' => 'rejected',
                                            default       => 'process',
                                        };

                                        $pLbl = match($prev) {
                                            'approve'     => 'Disetujui',
                                            'non-approve' => 'Ditolak',
                                            default       => 'Diproses',
                                        };
                                        $nLbl = match($next) {
                                            'approve'     => 'Disetujui',
                                            'non-approve' => 'Ditolak',
                                            default       => 'Diproses',
                                        };
                                    @endphp
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="font-weight-600" style="color: var(--p3m-muted);">
                                            {{ $h->decided_at ? $h->decided_at->translatedFormat('d M Y, H:i') . ' WIB' : '—' }}
                                        </td>
                                        <td>
                                            <span class="p3m-status-pill {{ $pClass }}" style="font-size: 11px; padding: 3px 10px;">
                                                {{ $pLbl }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="p3m-status-pill {{ $nClass }}" style="font-size: 11px; padding: 3px 10px;">
                                                {{ $nLbl }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="font-weight-700" style="color: var(--p3m-ink);">
                                                <i class="fas fa-user-shield mr-1" style="color: var(--p3m-light);"></i>
                                                {{ optional($h->decisionMaker)->name ?? 'Admin P3M' }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ $h->reason ?? '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </section>
</div>
@endsection

@section('scripts')
@endsection
