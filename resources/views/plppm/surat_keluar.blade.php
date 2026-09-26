@extends('layout.main')

@section('title', 'Riwayat Surat Keluar - Panel Admin P3M')
@section('body_class', 'page-usulan')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

<style>
/* ================================================================
   P3M — Admin Riwayat Surat Keluar — Clean SaaS Design
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
    --purple:       #7c3aed;
    --purple-soft:  #f5f3ff;
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
    gap: 20px;
    flex-wrap: wrap;
    padding: 20px 32px;
    background: linear-gradient(112deg, #ffffff 60%, #f4faf6 100%);
    border-bottom: 1px solid var(--border);
}
.card-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 5px;
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
    font-size: 22px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -.03em;
    margin: 0;
    line-height: 1.2;
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
    width: 340px;
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
    width: 55px;
    text-align: left !important;
}
table.users-table thead th:last-child {
    padding-right: 32px !important;
}
table.users-table tbody td {
    padding: 16px 18px !important;
    vertical-align: middle !important;
    border-top: none !important;
    border-bottom: 1px solid var(--border) !important;
    font-size: 13.5px;
    color: var(--tx);
    background: #ffffff;
    transition: background-color .15s ease;
}
table.users-table tbody td:first-child {
    padding-left: 32px !important;
    padding-right: 14px !important;
}
table.users-table tbody td:last-child {
    padding-right: 32px !important;
}
table.users-table tbody tr:hover td {
    background: #f8fbf9 !important;
}
table.users-table tbody tr:last-child td {
    border-bottom: none !important;
}

.row-num {
    display: inline-block;
    font-size: 13px;
    font-weight: 700;
    color: var(--light);
}

/* Dosen Pengusul Cell */
.dosen-cell {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 180px;
}
.dosen-avatar {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    background: #eaf5ee;
    color: #00573b;
    border: 1px solid rgba(0, 87, 59, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 800;
    flex-shrink: 0;
    overflow: hidden;
}
.dosen-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.dosen-meta {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 0;
}
.dosen-name {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.dosen-meta-sub {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    font-size: 11px;
    color: var(--muted);
}
.dosen-prodi-pill {
    background: #f1f5f9;
    padding: 1px 6px;
    border-radius: 4px;
    font-weight: 600;
    color: #475569;
}

/* Badge Jenis Surat */
.badge-jenis {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 99px;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: .02em;
    width: fit-content;
    white-space: nowrap;
}
.badge-jenis-penelitian {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}
.badge-jenis-pengabdian {
    background: #f5f3ff;
    color: #6d28d9;
    border: 1px solid #ddd6fe;
}

/* Nomor Surat Badge */
.nomor-surat-cell {
    display: flex;
    align-items: center;
}
.nomor-surat-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 9px;
    font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, monospace;
    font-size: 12.5px;
    font-weight: 700;
    color: #166534;
    letter-spacing: -.01em;
    width: fit-content;
    box-shadow: 0 1px 2px rgba(22, 101, 52, .05);
    white-space: nowrap;
}
.nomor-surat-badge i {
    font-size: 11.5px;
    color: #15803d;
}

/* Date Cell */
.date-cell {
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}
.date-icon {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    background: var(--surface-alt);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--forest-mid);
    font-size: 13px;
    flex-shrink: 0;
}
.date-main {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--ink);
}

/* File Download PDF (Exact like HKI Dosen screenshot) */
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
.btn-file-pdf i {
    font-size: 12.5px;
    color: #dc2626;
}

/* Action Eye Button */
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
    cursor: pointer;
    border: none;
}
.btn-view {
    background: #f0f9ff;
    color: #0284c7;
    border: 1.5px solid #bae6fd;
}
.btn-view:hover {
    background: #e0f2fe;
    border-color: #7dd3fc;
    color: #0369a1;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(2, 132, 199, .15);
}
.btn-view i {
    font-size: 14px;
    color: #0284c7;
}

/* Detail Modal Styles */
.p3m-modal .modal-content {
    border-radius: var(--r-xl);
    border: 1px solid var(--border);
    box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
    overflow: hidden;
}
.p3m-modal .modal-header {
    padding: 20px 28px;
    background: #ffffff;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 16px;
}
.modal-icon.modal-icon-info {
    width: 44px; height: 44px; border-radius: 12px;
    background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;
    display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;
}
.modal-head-text h5 {
    font-size: 16px; font-weight: 800; color: var(--ink); margin: 0 0 3px;
    font-family: "Plus Jakarta Sans", "Inter", sans-serif;
}
.modal-head-text p {
    font-size: 12.5px; color: var(--muted); margin: 0;
}
.modal-close-btn {
    margin-left: auto; background: none; border: none; font-size: 24px;
    color: var(--light); cursor: pointer; line-height: 1; padding: 0;
}
.modal-close-btn:hover { color: var(--ink); }
.btn-modal-cancel {
    height: 38px; padding: 0 18px; border-radius: var(--r-md);
    background: #ffffff; border: 1.5px solid var(--border-2); color: var(--tx);
    font-size: 13px; font-weight: 700; cursor: pointer; transition: all .18s;
}
.btn-modal-cancel:hover {
    background: var(--surface-hov); border-color: var(--light); color: var(--ink);
}

.meta-chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: var(--surface);
    border: 1px solid var(--border);
    padding: 3px 9px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    color: var(--tx);
}

/* Footer Pagination */
.table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    padding: 18px 32px;
    background: #ffffff;
    border-top: 1px solid var(--border);
}
.table-info-text {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--muted);
}
.dt-pagination {
    display: flex;
    align-items: center;
    gap: 5px;
    list-style: none;
    margin: 0;
    padding: 0;
}
.dt-pagination .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    border-radius: 9px;
    background: #ffffff;
    border: 1px solid var(--border);
    color: var(--tx);
    font-size: 12.5px;
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
.p3m-empty-state {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 48px 20px !important;
    text-align: center !important;
    margin: 0 auto !important;
}
.p3m-empty-icon {
    width: 56px !important;
    height: 56px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 14px !important;
    background: #eaf5ee !important;
    color: #00573b !important;
    font-size: 22px !important;
    margin: 0 auto 14px auto !important;
}
.p3m-empty-title {
    color: #1e3328 !important;
    font-size: 15px !important;
    font-weight: 800 !important;
    margin-bottom: 5px !important;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
}
.p3m-empty-text {
    color: #6b7f78 !important;
    font-size: 13px !important;
    max-width: 440px !important;
    line-height: 1.6 !important;
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
                <li class="breadcrumb-item active">{{ $pagetitle ?? 'Riwayat Surat Keluar' }}</li>
            </ol>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="users-card">
                {{-- Header Card --}}
                <div class="users-card-head">
                    <div>
                        <div class="card-eyebrow">Dokumen & Arsip Resmi</div>
                        <h1 class="card-head-title">Riwayat Surat Keluar</h1>
                    </div>
                    <div class="stat-chips">
                        <div class="stat-chip stat-chip-emerald" title="Total Surat Tugas Terbit">
                            <div class="stat-chip-icon">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div class="stat-chip-content">
                                <span class="stat-chip-label">Total Surat Keluar</span>
                                <strong class="stat-chip-val">{{ $totalSurat }}</strong>
                            </div>
                        </div>
                        <div class="stat-chip stat-chip-blue" title="Total Surat Tugas Penelitian">
                            <div class="stat-chip-icon">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <div class="stat-chip-content">
                                <span class="stat-chip-label">Penelitian</span>
                                <strong class="stat-chip-val">{{ $totalPenelitian }}</strong>
                            </div>
                        </div>
                        <div class="stat-chip stat-chip-purple" title="Total Surat Tugas Pengabdian">
                            <div class="stat-chip-icon">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <div class="stat-chip-content">
                                <span class="stat-chip-label">Pengabdian</span>
                                <strong class="stat-chip-val">{{ $totalPengabdian }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Toolbar Filter & Search --}}
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
                                ['value' => '', 'label' => 'Semua Jenis Surat', 'icon' => 'fas fa-layer-group p3m-dropdown-icon', 'divider' => true],
                                ['value' => 'Penelitian', 'label' => 'Surat Tugas Penelitian', 'icon' => 'fas fa-microscope p3m-dropdown-icon'],
                                ['value' => 'Pengabdian', 'label' => 'Surat Tugas Pengabdian', 'icon' => 'fas fa-hands-helping p3m-dropdown-icon'],
                            ]"
                        />
                    </div>

                    <div class="search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="search" id="js-search-input" class="search-input" placeholder="Cari nama pengusul, no. surat, jenis...">
                    </div>
                </div>

                {{-- Table --}}
                <div class="users-table-wrap">
                    <table id="adminSuratKeluarTable" class="users-table">
                        <thead>
                            <tr>
                                <th style="width: 55px;">NO</th>
                                <th>NAMA PENGUSUL</th>
                                <th style="width: 150px;">JENIS SURAT</th>
                                <th style="width: 230px;">NOMOR SURAT</th>
                                <th style="width: 140px;">TANGGAL</th>
                                <th style="width: 140px; text-align: center;">UNDUH SURAT</th>
                                <th style="width: 90px; text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allSurat as $index => $item)
                                <tr>
                                    <td style="vertical-align: middle;">
                                        <span class="row-num">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="dosen-cell">
                                            <div class="dosen-avatar">
                                                {{ strtoupper(substr($item->ketua ?? 'D', 0, 1)) }}
                                            </div>
                                            <div class="dosen-meta">
                                                <div class="dosen-name" title="{{ $item->ketua }}">{{ $item->ketua ?? '-' }}</div>
                                                <div class="dosen-meta-sub">
                                                    @if (!empty($item->prodi))
                                                        <span class="dosen-prodi-pill">{{ $item->prodi }}</span>
                                                    @endif
                                                    @if (!empty($item->nidn))
                                                        <span>NIDN: {{ $item->nidn }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->type === 'penelitian')
                                            <span class="badge-jenis badge-jenis-penelitian">
                                                <i class="fas fa-microscope"></i> Penelitian
                                            </span>
                                        @else
                                            <span class="badge-jenis badge-jenis-pengabdian">
                                                <i class="fas fa-hands-helping"></i> Pengabdian
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="nomor-surat-cell">
                                            <div class="nomor-surat-badge" title="Nomor Surat Tugas Resmi">
                                                <i class="fas fa-file-contract"></i>
                                                <span>{{ $item->nomor_surat }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-cell">
                                            <div class="date-icon">
                                                <i class="far fa-calendar-alt"></i>
                                            </div>
                                            <span class="date-main">
                                                {{ $item->tanggal_surat ? $item->tanggal_surat->locale('id')->translatedFormat('j M Y') : '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ $item->download_url }}"
                                           class="btn-file-pdf"
                                           title="Unduh Berkas PDF Surat Tugas Resmi">
                                            <i class="fas fa-file-pdf"></i>
                                            <span>Unduh PDF</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <button type="button"
                                                class="btn-icon-action btn-view"
                                                data-toggle="modal"
                                                data-target="#modal-detail-{{ $item->type }}-{{ $item->source_id }}"
                                                title="Lihat Detail & Judul Usulan">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Footer Pagination --}}
                <div class="table-footer">
                    <span class="table-info-text" id="js-table-info">Menampilkan {{ $allSurat->isEmpty() ? '0–0 dari 0 data' : 'data' }}</span>
                    <ul class="dt-pagination" id="js-dt-pagination">
                        @if ($allSurat->isEmpty())
                            <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>
                            <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Modals Detail Surat Keluar (Memuat Judul Usulan Lengkap) --}}
@foreach ($allSurat as $item)
<div class="modal fade p3m-modal" id="modal-detail-{{ $item->type }}-{{ $item->source_id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content text-left">
            <div class="modal-header">
                <div class="modal-icon modal-icon-info">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="modal-head-text">
                    <h5>Detail Riwayat Surat Keluar</h5>
                    <p>Informasi resmi Surat Tugas {{ $item->jenis_surat }} yang telah disetujui & diterbitkan.</p>
                </div>
                <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
            </div>
            <div class="modal-body" style="padding: 24px 28px;">
                {{-- Judul Kegiatan (Tambahan Judul) --}}
                <div style="background: linear-gradient(135deg, #f8fafc 0%, #f0fdf4 100%); border: 1.5px solid #dcfce7; border-radius: var(--r-md); padding: 18px 20px; margin-bottom: 22px;">
                    <div style="font-size: 11px; font-weight: 800; color: var(--forest-mid); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-heading"></i> Judul Kegiatan / Usulan
                    </div>
                    <div style="font-size: 16px; font-weight: 800; color: var(--ink); line-height: 1.45;">
                        {{ $item->judul }}
                    </div>
                    <div style="margin-top: 10px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        @if (!empty($item->prodi))
                            <span class="meta-chip"><i class="fas fa-graduation-cap"></i> {{ $item->prodi }}</span>
                        @endif
                        @if (!empty($item->tanggal_mulai) && !empty($item->tanggal_selesai))
                            <span class="meta-chip"><i class="far fa-calendar-check"></i> {{ \Carbon\Carbon::parse($item->tanggal_mulai)->locale('id')->translatedFormat('j M Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->locale('id')->translatedFormat('j M Y') }}</span>
                        @endif
                        @if ($item->anggota_count > 0)
                            <span class="meta-chip"><i class="fas fa-users"></i> {{ $item->anggota_count }} Anggota</span>
                        @endif
                    </div>
                </div>

                {{-- Detail Grid --}}
                <div class="row" style="row-gap: 16px;">
                    <div class="col-md-6">
                        <div style="font-size: 11.5px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; margin-bottom: 5px;">Nomor Surat Tugas</div>
                        <div class="nomor-surat-badge">
                            <i class="fas fa-file-contract"></i>
                            <span>{{ $item->nomor_surat }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div style="font-size: 11.5px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; margin-bottom: 5px;">Jenis Surat</div>
                        @if ($item->type === 'penelitian')
                            <span class="badge-jenis badge-jenis-penelitian"><i class="fas fa-microscope"></i> Surat Tugas Penelitian</span>
                        @else
                            <span class="badge-jenis badge-jenis-pengabdian"><i class="fas fa-hands-helping"></i> Surat Tugas Pengabdian</span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div style="font-size: 11.5px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; margin-bottom: 5px;">Nama Ketua / Pengusul</div>
                        <div style="font-size: 14px; font-weight: 700; color: var(--ink);">{{ $item->ketua }}</div>
                        <div style="font-size: 12px; color: var(--muted); margin-top: 2px;">NIDN: {{ $item->nidn ?: '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div style="font-size: 11.5px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; margin-bottom: 5px;">Tanggal Surat Keluar</div>
                        <div style="font-size: 13.5px; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 6px;">
                            <i class="far fa-calendar-alt text-success"></i>
                            {{ $item->tanggal_surat ? $item->tanggal_surat->locale('id')->translatedFormat('l, j F Y') : '-' }}
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <a href="{{ $item->view_url }}" target="_blank" class="btn-action-view" style="padding: 7px 14px; font-size: 12.5px;">
                            <i class="fas fa-file-pdf"></i>
                            <span>Buka Pratinjau PDF</span>
                        </a>
                        <a href="{{ $item->download_url }}" class="btn-file-pdf">
                            <i class="fas fa-file-pdf"></i>
                            <span>Unduh PDF</span>
                        </a>
                    </div>
                    <a href="{{ $item->detail_url }}" style="font-size: 13px; font-weight: 700; color: var(--forest-mid); text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <span>Lihat Detail Usulan Lengkap</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="modal-footer" style="padding: 14px 28px; background: var(--surface-alt); border-top: 1px solid var(--border);">
                <button type="button" class="btn-modal-cancel" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
(function() {
    function initAdminSuratKeluarTable() {
        if (!$.fn.DataTable) return;

        if ($.fn.DataTable.isDataTable('#adminSuratKeluarTable')) {
            $('#adminSuratKeluarTable').DataTable().destroy();
        }

        var table = $('#adminSuratKeluarTable').DataTable({
            responsive: true,
            autoWidth: false,
            paging: true,
            searching: true,
            ordering: false,
            info: true,
            pageLength: 10,
            dom: 't',
            language: {
                emptyTable: `
                    <div class="p3m-empty-state">
                        <span class="p3m-empty-icon"><i class="fas fa-envelope-open-text"></i></span>
                        <span class="p3m-empty-title">Belum ada riwayat surat keluar</span>
                        <span class="p3m-empty-text">Surat tugas yang telah disetujui Admin dan diterbitkan nomor suratnya akan otomatis terarsip rapi pada tabel ini.</span>
                    </div>
                `,
                zeroRecords: `
                    <div class="p3m-empty-state">
                        <span class="p3m-empty-icon"><i class="fas fa-search"></i></span>
                        <span class="p3m-empty-title">Tidak ada surat yang cocok</span>
                        <span class="p3m-empty-text">Coba periksa kata kunci pencarian atau ganti filter jenis surat untuk menemukan data surat keluar.</span>
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
            }
        });

        $('#js-entries-select').off('change').on('change', function() {
            table.page.len(Number($(this).val())).draw();
        });

        $('#js-search-input').off('keyup input').on('keyup input', function() {
            table.search($(this).val()).draw();
        });

        // Filter Jenis Surat (kolom index 2 — JENIS SURAT)
        $('#js-filter-jenis').off('change').on('change', function() {
            var val = $(this).val();
            table.column(2).search(val ? val : '', true, false).draw();
        });

        table.draw();
    }

    $(document).off('click', '#js-dt-pagination a.page-link').on('click', '#js-dt-pagination a.page-link', function(e) {
        e.preventDefault();
        var page = $(this).data('dt-page');
        if ($.fn.DataTable.isDataTable('#adminSuratKeluarTable')) {
            var table = $('#adminSuratKeluarTable').DataTable();
            if (page !== undefined && page >= 0 && page < table.page.info().pages) {
                table.page(page).draw('page');
            }
        }
    });

    var initTimer = null;
    function scheduleInit() {
        clearTimeout(initTimer);
        initTimer = setTimeout(initAdminSuratKeluarTable, 20);
    }

    document.addEventListener('turbo:load', scheduleInit);
    document.addEventListener('turbo:before-cache', function() {
        if ($.fn.DataTable.isDataTable('#adminSuratKeluarTable')) {
            $('#adminSuratKeluarTable').DataTable().destroy();
        }
    });

    scheduleInit();
})();
</script>
@endsection
