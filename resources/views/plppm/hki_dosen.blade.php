@extends('layout.main')

@section('title', 'Verifikasi HKI Dosen - Panel Admin P3M')
@section('body_class', 'page-usulan')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

<style>
/* ================================================================
   P3M — Admin Verifikasi HKI Dosen — Clean SaaS Design
   ================================================================ */

:root {
    --forest:       #003d2d;
    --forest-deep:  #002e22;
    --forest-mid:   #00573b;
    --forest-soft:  #eaf5ee;
    --gold:         #b99835;
    --gold-soft:    #fdf8ec;
    --ink:          #0f172a;
    --ink-2:        #1e293b;
    --tx:           #334155;
    --muted:        #64748b;
    --light:        #94a3b8;
    --border:       #e2e8f0;
    --border-2:     #cbd5e1;
    --surface:      #ffffff;
    --surface-alt:  #f8fafc;
    --surface-hov:  #f1f5f9;
    --danger:       #dc2626;
    --danger-soft:  #fef2f2;
    --warning:      #d97706;
    --warning-soft: #fffbeb;
    --info:         #0284c7;
    --info-soft:    #f0f9ff;
    --success:      #16a34a;
    --success-soft: #f0fdf4;
    --r-sm: 8px; --r-md: 12px; --r-lg: 16px; --r-xl: 20px; --r-2xl: 24px;
}

.page-usulan .content-wrapper {
    min-height: calc(100vh - 78px);
    background: radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0,93,59,.04), transparent),
                linear-gradient(180deg, #f6f9f7 0%, #f8fafc 100%);
}
.page-usulan .content-header { padding: 26px 32px 0; }
.page-usulan section.content { padding: 16px 32px 40px; }

.page-usulan .breadcrumb {
    background: transparent; padding: 0; margin: 0;
    font-size: 12.5px; font-weight: 600;
}
.page-usulan .breadcrumb-item a { color: var(--forest-mid); text-decoration: none; transition: opacity .18s; }
.page-usulan .breadcrumb-item a:hover { opacity: .75; }
.page-usulan .breadcrumb-item.active { color: var(--muted); }
.page-usulan .breadcrumb-item + .breadcrumb-item::before { content: "/"; padding: 0 8px; color: var(--border-2); }

.users-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-2xl);
    box-shadow: 0 16px 40px rgba(15,23,42,.06), 0 2px 6px rgba(0,0,0,.03);
    overflow: hidden;
}

.users-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    flex-wrap: wrap;
    padding: 24px 32px;
    background: linear-gradient(112deg, #ffffff 60%, #f4faf6 100%);
    border-bottom: 1px solid var(--border);
}
.card-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    color: var(--forest-mid);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}
.card-eyebrow::before {
    content: "";
    width: 18px;
    height: 3px;
    border-radius: 99px;
    background: var(--gold);
}
.card-head-title {
    font-family: "Plus Jakarta Sans", "Inter", sans-serif;
    font-size: 23px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -.03em;
    margin: 0 0 6px;
    line-height: 1.25;
}
.card-head-sub {
    color: var(--muted);
    font-size: 13.5px;
    line-height: 1.6;
    margin: 0;
    max-width: 560px;
}

/* Stat Chips */
.stat-chips {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-left: auto;
    flex-shrink: 0;
}
.stat-chip {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 16px;
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    transition: all .2s ease;
}
.stat-chip:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 61, 45, 0.08);
    border-color: rgba(0, 87, 59, 0.25);
}
.stat-chip-icon {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}
.stat-chip-emerald .stat-chip-icon { background: #eaf5ee; color: #00573b; }
.stat-chip-blue .stat-chip-icon    { background: #eff6ff; color: #2563eb; }
.stat-chip-purple .stat-chip-icon  { background: #f5f3ff; color: #7c3aed; }
.stat-chip-gold .stat-chip-icon    { background: #fefce8; color: #b45309; }
.stat-chip-content {
    display: flex;
    flex-direction: column;
    line-height: 1.25;
}
.stat-chip-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .04em;
}
.stat-chip-val {
    font-size: 18px;
    font-weight: 800;
    color: var(--ink);
}

/* Table Toolbar */
.table-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    padding: 16px 32px;
    background: #ffffff;
    border-bottom: 1px solid var(--border);
}
.toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    color: var(--muted);
    font-size: 13px;
    font-weight: 600;
}
.search-wrap {
    position: relative;
    width: 320px;
    max-width: 100%;
    margin-left: auto;
    flex-shrink: 0;
}
.search-wrap i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--light);
    font-size: 13.5px;
    pointer-events: none;
    transition: color .18s;
}
.search-input {
    width: 100%;
    height: 40px;
    padding: 0 14px 0 38px;
    border: 1.5px solid var(--border-2);
    border-radius: 10px;
    font-size: 13px;
    color: var(--ink);
    background: #ffffff;
    outline: none;
    transition: all .18s ease;
}
.search-input:focus {
    border-color: var(--forest-mid);
    box-shadow: 0 0 0 3.5px rgba(0, 87, 59, .09);
}

/* Table */
.users-table-wrap { width: 100%; overflow-x: auto; }
table.users-table {
    width: 100% !important;
    margin: 0 !important;
    border-collapse: separate !important;
    border-spacing: 0 !important;
}
table.users-table thead th {
    padding: 14px 18px !important;
    background: #f8faf9;
    border-top: none !important;
    border-bottom: 1.5px solid var(--border) !important;
    color: #475569;
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: .06em;
    text-transform: uppercase;
    white-space: nowrap;
    vertical-align: middle;
}
table.users-table thead th:first-child {
    padding-left: 32px !important;
    padding-right: 14px !important;
    width: 64px;
    text-align: left !important;
}
table.users-table thead th:last-child {
    padding-right: 32px !important;
    width: 130px;
    text-align: center;
}

table.users-table tbody td {
    padding: 16px 18px !important;
    vertical-align: middle !important;
    border-bottom: 1px solid #f1f5f9;
    color: var(--tx);
    font-size: 13px;
    transition: background .15s ease;
}
table.users-table tbody tr:hover td {
    background: #fbfdfc;
}
table.users-table tbody td:first-child {
    padding-left: 32px !important;
    padding-right: 14px !important;
    text-align: left !important;
}
table.users-table tbody td:last-child {
    padding-right: 32px !important;
    text-align: center;
}

.row-num {
    display: inline-block;
    color: var(--light);
    font-size: 12.5px;
    font-weight: 700;
    font-variant-numeric: tabular-nums;
    text-align: left;
}

/* Dosen Meta */
.dosen-cell {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}
.dosen-avatar {
    width: 42px;
    height: 42px;
    flex: 0 0 42px;
    border-radius: 12px;
    background: linear-gradient(135deg, #eaf5ee 0%, #d4ede0 100%);
    color: var(--forest-mid);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    font-weight: 800;
    border: 1.5px solid rgba(0, 93, 59, .14);
    overflow: hidden;
    position: relative;
    box-shadow: 0 2px 6px rgba(0, 0, 0, .04);
}
.dosen-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.dosen-meta {
    display: flex;
    flex-direction: column;
    min-width: 0;
}
.dosen-name {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.3;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.dosen-meta-sub {
    font-size: 11.5px;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.dosen-email {
    color: var(--muted);
}
.dosen-phone-pill {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 10.5px;
    font-weight: 600;
    color: #475569;
    background: #f1f5f9;
    padding: 1px 7px;
    border-radius: 999px;
    border: 1px solid #e2e8f0;
}
.dosen-nidn-pill {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 10.5px;
    font-weight: 700;
    color: #0369a1;
    background: #f0f9ff;
    padding: 1px 7px;
    border-radius: 999px;
    border: 1px solid #bae6fd;
}

/* Judul HKI (Strict flex-start avoids badge stretching) */
.judul-cell {
    min-width: 260px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 6px;
}
.judul-meta-top {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.hki-id-chip {
    display: inline-flex;
    align-items: center;
    padding: 2.5px 8px;
    border-radius: 6px;
    background: var(--forest-soft);
    color: var(--forest-mid);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .02em;
    border: 1px solid rgba(0, 93, 59, .14);
}
.anggota-count {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2.5px 8px;
    border-radius: 6px;
    background: #eef2ff;
    color: #4338ca;
    font-size: 11px;
    font-weight: 700;
    border: 1px solid #c7d2fe;
}
.judul-text {
    font-family: "Plus Jakarta Sans", "Inter", sans-serif;
    font-weight: 700;
    color: var(--ink);
    font-size: 14px;
    line-height: 1.45;
    word-break: break-word;
}
.judul-link {
    color: var(--ink);
    text-decoration: none;
    transition: color .18s ease;
}
.judul-link:hover {
    color: var(--forest-mid);
    text-decoration: underline;
    text-underline-offset: 3px;
}
.judul-meta-bottom {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 1px;
}
.badge-jenis {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3.5px 11px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
    white-space: nowrap;
    width: fit-content !important;
    max-width: fit-content !important;
    align-self: flex-start !important;
    background: #f5f3ff;
    color: #6d28d9;
    border: 1px solid #ddd6fe;
}
.badge-jenis-hak-cipta {
    background: #f5f3ff;
    color: #6d28d9;
    border: 1px solid #ddd6fe;
}
.badge-jenis-paten,
.badge-jenis-paten-sederhana {
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fde68a;
}
.badge-jenis-merek {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}
.badge-jenis-desain-industri {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}
.hki-no-catat {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 600;
    color: #475569;
    background: #f8fafc;
    padding: 2.5px 8px;
    border-radius: 6px;
    border: 1px solid var(--border);
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
}

/* Date */
.date-cell {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}
.date-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #f1f5f9;
    color: var(--forest-mid);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12.5px;
    flex-shrink: 0;
}
.date-main {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--ink);
}

/* File Download PDF */
.btn-file-pdf {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 13px;
    border-radius: 9px;
    background: #ffffff;
    border: 1.5px solid #fecaca;
    color: #dc2626;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all .18s ease;
    box-shadow: 0 1px 3px rgba(220, 38, 38, .04);
    white-space: nowrap;
}
.btn-file-pdf:hover {
    background: #fef2f2;
    border-color: #f87171;
    color: #b91c1c;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(220, 38, 38, .12);
}

/* Action Button (Icon Only - Photo 1) */
.btn-icon-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none !important;
    transition: all .18s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}
.btn-view {
    background: #f0f9ff;
    color: #0284c7;
    border: 1.5px solid #bae6fd;
}
.btn-view i {
    font-size: 14px;
    color: #0284c7;
    transition: color .18s ease;
}
.btn-view:hover {
    background: #0284c7;
    border-color: #0284c7;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(2, 132, 199, .25);
}
.btn-view:hover i {
    color: #ffffff;
}

/* Table Footer */
.table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    padding: 18px 32px;
    background: #fbfcfb;
    border-top: 1px solid var(--border);
}
.table-info-text {
    font-size: 13px;
    color: var(--muted);
    font-weight: 600;
}
.dt-pagination {
    display: flex;
    align-items: center;
    gap: 5px;
    list-style: none;
    padding: 0;
    margin: 0;
}
.dt-pagination .page-item .page-link {
    min-width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border);
    border-radius: 9px;
    background: var(--surface);
    color: var(--tx);
    font-size: 13px;
    font-weight: 700;
    padding: 0 10px;
    transition: all .18s;
    cursor: pointer;
    text-decoration: none;
}
.dt-pagination .page-item.active .page-link {
    background: var(--forest);
    border-color: var(--forest);
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 61, 45, .20);
}
.dt-pagination .page-item:not(.active):not(.disabled) .page-link:hover {
    background: var(--surface-hov);
    border-color: var(--border-2);
    color: var(--ink);
}
.dt-pagination .page-item.disabled .page-link {
    opacity: .45;
    cursor: not-allowed;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate { display: none !important; }

/* Empty state styling */
.upp3m-empty-state, .p3m-empty-state {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 46px 20px !important;
    text-align: center !important;
    margin: 0 auto !important;
}
.upp3m-empty-icon, .p3m-empty-icon {
    width: 52px !important;
    height: 52px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 14px !important;
    background: #eaf5ee !important;
    color: #00573b !important;
    font-size: 20px !important;
    margin: 0 auto 12px auto !important;
}
.upp3m-empty-title, .p3m-empty-title {
    color: #1e3328 !important;
    font-size: 14px !important;
    font-weight: 800 !important;
    margin-bottom: 4px !important;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
}
.upp3m-empty-text, .p3m-empty-text {
    color: #6b7f78 !important;
    font-size: 12.5px !important;
    max-width: 400px !important;
    line-height: 1.55 !important;
    margin: 0 auto !important;
}
td.dataTables_empty {
    padding: 30px 10px !important;
    background: transparent !important;
    border: none !important;
    text-align: center !important;
}

@media (max-width: 767.98px) {
    .page-usulan .content-header { padding: 20px 16px 0; }
    .page-usulan section.content { padding: 14px 16px 28px; }
    .users-card-head { padding: 20px 16px; flex-direction: column; align-items: stretch; gap: 16px; }
    .stat-chips { margin-left: 0; width: 100%; justify-content: flex-start; }
    .table-toolbar { padding: 14px 16px; flex-direction: column; align-items: stretch; gap: 12px; }
    .toolbar-left { width: 100%; justify-content: flex-start; }
    .search-wrap { width: 100%; margin-left: 0; }
    table.users-table thead th:first-child, table.users-table tbody td:first-child { padding-left: 16px !important; }
    table.users-table thead th:last-child,  table.users-table tbody td:last-child  { padding-right: 16px !important; }
    .table-footer { padding: 14px 16px; }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $pagetitle ?? 'Data HKI Dosen' }}</li>
            </ol>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="users-card">
                {{-- Header --}}
                <div class="users-card-head">
                    <div>
                        <div class="card-eyebrow">Data HKI Dosen</div>
                        <h1 class="card-head-title" style="margin-bottom: 0;">Hak Kekayaan Intelektual</h1>
                        <p class="card-head-sub">Pangkalan data dan rekapitulasi Hak Kekayaan Intelektual (HKI) yang didaftarkan oleh dosen.</p>
                    </div>
                    <div class="stat-chips">
                        <div class="stat-chip stat-chip-emerald">
                            <div class="stat-chip-icon">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="stat-chip-content">
                                <span class="stat-chip-label">Total HKI</span>
                                <strong class="stat-chip-val">{{ $hkis->count() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Toolbar Filter --}}
                <div class="table-toolbar">
                    <div class="toolbar-left">
                        <span>Tampilkan</span>
                        <x-p3m-dropdown
                            id="js-entries-select"
                            value="10"
                            :compact="true"
                            :options="[
                                ['value' => '10', 'label' => '10'],
                                ['value' => '25', 'label' => '25'],
                                ['value' => '50', 'label' => '50'],
                                ['value' => '100', 'label' => '100'],
                            ]"
                        />
                        <span>data</span>

                        <x-p3m-dropdown
                            id="js-filter-jenis"
                            value=""
                            :options="[
                                ['value' => '', 'label' => 'Semua Jenis HKI', 'icon' => 'fas fa-layer-group p3m-dropdown-icon', 'divider' => true],
                                ['value' => 'Hak Cipta', 'label' => 'Hak Cipta'],
                                ['value' => 'Paten', 'label' => 'Paten'],
                                ['value' => 'Paten Sederhana', 'label' => 'Paten Sederhana'],
                                ['value' => 'Merek', 'label' => 'Merek'],
                                ['value' => 'Desain Industri', 'label' => 'Desain Industri'],
                            ]"
                        />
                    </div>

                    <div class="search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="search" id="js-search-input" class="search-input" placeholder="Cari dosen, judul, no. HKI...">
                    </div>
                </div>

                {{-- Table --}}
                <div class="users-table-wrap">
                    <table id="adminHkiTable" class="users-table">
                        <thead>
                            <tr>
                                <th style="width: 64px;">NO</th>
                                <th>DOSEN PENGUSUL</th>
                                <th>JUDUL & JENIS HKI</th>
                                <th style="width: 140px;">TANGGAL</th>
                                <th style="width: 130px;">BERKAS HKI</th>
                                <th style="width: 110px; text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hkis as $index => $hki)
                                <tr>
                                    <td style="vertical-align: middle;">
                                        <span class="row-num">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $ketua = $hki->anggotas->where('urutan', 1)->first() ?? $hki->anggotas->first();
                                            $dosenNidn = $ketua ? $ketua->nim_nidn : ($hki->user->nidn ?? null);
                                            $userPhoto = !empty($hki->user->image) ? 'storage/photo-user/' . $hki->user->image : null;
                                            $userPhotoExists = $userPhoto && file_exists(public_path($userPhoto));
                                        @endphp
                                        <div class="dosen-cell">
                                            <div class="dosen-avatar">
                                                @if($userPhotoExists)
                                                    <img src="{{ asset($userPhoto) }}" alt="{{ $hki->user->name ?? 'Dosen' }}">
                                                @else
                                                    {{ strtoupper(substr($hki->user->name ?? 'D', 0, 1)) }}
                                                @endif
                                            </div>
                                            <div class="dosen-meta">
                                                <div class="dosen-name">{{ $hki->user->name ?? 'Dosen Polibang' }}</div>
                                                <div class="dosen-meta-sub">
                                                    <span class="dosen-email">{{ $hki->user->email ?? '-' }}</span>
                                                    @if(!empty($hki->user->no_hp))
                                                        <span class="dosen-phone-pill" title="No. Telepon: {{ $hki->user->no_hp }}">
                                                            <i class="fas fa-phone-alt"></i> {{ $hki->user->no_hp }}
                                                        </span>
                                                    @endif
                                                    @if($dosenNidn)
                                                        <span class="dosen-nidn-pill" title="NIDN: {{ $dosenNidn }}">
                                                            <i class="fas fa-id-badge"></i> {{ $dosenNidn }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="judul-cell">
                                            <div class="judul-meta-top">
                                                <span class="hki-id-chip">#HKI-{{ $hki->id }}</span>
                                                @if($hki->anggotas->count() > 0)
                                                    <span class="anggota-count" title="Daftar Pencipta: {{ $hki->anggotas->pluck('nama')->implode(', ') }}">
                                                        <i class="fas fa-users"></i> {{ $hki->anggotas->count() }} pencipta
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="judul-text">
                                                <a href="{{ route('plppm.hki_dosen.show', $hki->id) }}" class="judul-link">
                                                    {{ $hki->judul }}
                                                </a>
                                            </div>
                                            <div class="judul-meta-bottom">
                                                @if($hki->jenis_hki)
                                                    @php
                                                        $jenisSlug = \Illuminate\Support\Str::slug($hki->jenis_hki);
                                                    @endphp
                                                    <span class="badge-jenis badge-jenis-{{ $jenisSlug }}">
                                                        <i class="fas fa-award"></i> {{ $hki->jenis_hki }}
                                                    </span>
                                                @endif
                                                @if($hki->nomor_pencatatan)
                                                    <span class="hki-no-catat" title="Nomor Pencatatan">
                                                        <i class="fas fa-hashtag"></i> {{ $hki->nomor_pencatatan }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-cell">
                                            <div class="date-icon">
                                                <i class="far fa-calendar-alt"></i>
                                            </div>
                                            <span class="date-main">{{ $hki->tanggal ? $hki->tanggal->isoFormat('D MMM Y') : '-' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($hki->file_path)
                                            <a href="{{ route('plppm.hki_dosen.download', $hki->id) }}" class="btn-file-pdf" title="Unduh Berkas: {{ $hki->file_name }}">
                                                <i class="fas fa-file-pdf"></i>
                                                <span>Unduh PDF</span>
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size: 13px; font-weight: 600;">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('plppm.hki_dosen.show', $hki->id) }}"
                                           class="btn-icon-action btn-view"
                                           title="Lihat Detail HKI">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Footer Pagination --}}
                <div class="table-footer">
                    <span class="table-info-text" id="js-table-info">Menampilkan {{ $hkis->isEmpty() ? '0–0 dari 0 data' : 'data' }}</span>
                    <ul class="dt-pagination" id="js-dt-pagination">
                        @if($hkis->isEmpty())
                            <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>
                            <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
(function() {
    function initAdminHkiTable() {
        if ($.fn.DataTable.isDataTable('#adminHkiTable')) {
            $('#adminHkiTable').DataTable().destroy();
        }

        var table = $('#adminHkiTable').DataTable({
            responsive: false,
            autoWidth: false,
            ordering: false,
            pageLength: 10,
            dom: 't',
            language: {
                emptyTable: `
                    <div class="upp3m-empty-state">
                        <span class="upp3m-empty-icon"><i class="fas fa-inbox"></i></span>
                        <span class="upp3m-empty-title">Belum ada data HKI yang diunggah</span>
                        <span class="upp3m-empty-text">Data berkas permohonan HKI dari dosen akan tampil rapi pada tabel ini.</span>
                    </div>
                `,
                zeroRecords: `
                    <div class="upp3m-empty-state">
                        <span class="upp3m-empty-icon"><i class="fas fa-search"></i></span>
                        <span class="upp3m-empty-title">Tidak ada hasil pencarian</span>
                        <span class="upp3m-empty-text">Coba ubah kata kunci pencarian agar data HKI yang dicari dapat ditemukan.</span>
                    </div>
                `
            },
            drawCallback: function(settings) {
                var api = this.api();
                var pageInfo = api.page.info();

                if (pageInfo.recordsTotal === 0 || pageInfo.recordsDisplay === 0) {
                    $('#js-table-info').text('Menampilkan 0–0 dari 0 data');
                    $('#js-dt-pagination').html(
                        '<li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>' +
                        '<li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>'
                    );
                    return;
                }

                var start = pageInfo.start + 1;
                var end = Math.min(pageInfo.end, pageInfo.recordsDisplay);
                var total = pageInfo.recordsDisplay;

                $('#js-table-info').text('Menampilkan ' + start + '–' + end + ' dari ' + total + ' data');

                // Dynamic sequential row re-indexing
                api.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
                    var num = i + 1 + pageInfo.start;
                    var rowNumEl = cell.querySelector('.row-num');
                    if (rowNumEl) {
                        rowNumEl.textContent = num;
                    } else {
                        cell.innerHTML = num;
                    }
                });

                var paginationHtml = '';
                var totalPages = pageInfo.pages;
                var currentPage = pageInfo.page;

                paginationHtml += '<li class="page-item ' + (currentPage === 0 ? 'disabled' : '') + '">';
                paginationHtml += '<a class="page-link" href="#" data-dt-page="' + (currentPage - 1) + '"><i class="fas fa-chevron-left"></i></a>';
                paginationHtml += '</li>';

                for (var i = 0; i < totalPages; i++) {
                    if (totalPages <= 7 || i === 0 || i === totalPages - 1 || (i >= currentPage - 1 && i <= currentPage + 1)) {
                        paginationHtml += '<li class="page-item ' + (currentPage === i ? 'active' : '') + '">';
                        paginationHtml += '<a class="page-link" href="#" data-dt-page="' + i + '">' + (i + 1) + '</a>';
                        paginationHtml += '</li>';
                    } else if (i === currentPage - 2 || i === currentPage + 2) {
                        paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }

                paginationHtml += '<li class="page-item ' + (currentPage === totalPages - 1 || totalPages === 0 ? 'disabled' : '') + '">';
                paginationHtml += '<a class="page-link" href="#" data-dt-page="' + (currentPage + 1) + '"><i class="fas fa-chevron-right"></i></a>';
                paginationHtml += '</li>';

                $('#js-dt-pagination').html(paginationHtml);

                // Re-bind P3M SweetAlert2 action listeners on DataTable redraw
                if (typeof window.p3mBindActions === 'function') {
                    window.p3mBindActions();
                }
            }
        });

        $('#js-entries-select').off('change').on('change', function() {
            table.page.len(Number($(this).val())).draw();
        });

        $('#js-search-input').off('keyup input').on('keyup input', function() {
            table.search($(this).val()).draw();
        });

        // Filter Jenis HKI (kolom index 2 — judul & jenis)
        $('#js-filter-jenis').off('change').on('change', function() {
            var val = $(this).val();
            table.column(2).search(val ? val : '', true, false).draw();
        });

        table.draw();
    }

    $(document).off('click', '#js-dt-pagination a.page-link').on('click', '#js-dt-pagination a.page-link', function(e) {
        e.preventDefault();
        var page = $(this).data('dt-page');
        if ($.fn.DataTable.isDataTable('#adminHkiTable')) {
            var table = $('#adminHkiTable').DataTable();
            if (page !== undefined && page >= 0 && page < table.page.info().pages) {
                table.page(page).draw('page');
            }
        }
    });

    var initTimer = null;
    function scheduleInit() {
        clearTimeout(initTimer);
        initTimer = setTimeout(initAdminHkiTable, 20);
    }

    document.addEventListener('turbo:load', scheduleInit);
    document.addEventListener('turbo:before-cache', function() {
        if ($.fn.DataTable.isDataTable('#adminHkiTable')) {
            $('#adminHkiTable').DataTable().destroy();
        }
    });

    scheduleInit();
})();
</script>
@endsection
