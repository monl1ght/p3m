@extends('layout.main')

@section('title', 'List Jurnal P3M - Verifikasi Jurnal Dosen')
@section('body_class', 'page-usulan')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
/* ================================================================
   P3M — Admin Verifikasi Jurnal Dosen — Clean SaaS Design
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
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r-2xl); box-shadow: 0 16px 40px rgba(15,23,42,.06), 0 2px 6px rgba(0,0,0,.03);
    overflow: hidden;
}

.users-card-head {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 20px; flex-wrap: wrap;
    padding: 28px 32px 24px;
    background: linear-gradient(112deg, #ffffff 60%, #f4faf6 100%);
    border-bottom: 1px solid var(--border);
}
.card-eyebrow {
    display: inline-flex; align-items: center; gap: 8px; margin-bottom: 8px;
    color: var(--forest-mid); font-size: 11px; font-weight: 800;
    letter-spacing: .12em; text-transform: uppercase;
}
.card-eyebrow::before {
    content: ""; width: 20px; height: 2.5px; border-radius: 99px; background: var(--gold);
}
.card-head-title {
    font-family: "Plus Jakarta Sans", "Inter", sans-serif;
    font-size: 22px; font-weight: 800; color: var(--ink);
    letter-spacing: -.03em; margin: 0 0 6px; line-height: 1.2;
}
.card-head-sub {
    color: var(--muted); font-size: 13.5px; line-height: 1.6; margin: 0; max-width: 540px;
}
.stat-chip {
    display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px;
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r-md); font-size: 13px; font-weight: 700; color: var(--ink);
    box-shadow: 0 2px 6px rgba(0,0,0,.03);
}
.stat-chip i { color: var(--forest-mid); font-size: 13px; }

/* Table Toolbar */
.table-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; flex-wrap: wrap; padding: 14px 32px;
    background: var(--surface); border-bottom: 1px solid var(--border);
}
.toolbar-left {
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
}
.select-filter {
    height: 38px; padding: 0 28px 0 12px;
    border: 1.5px solid var(--border-2); border-radius: var(--r-sm);
    background: var(--surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2364748b'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E") no-repeat right 8px center/14px;
    appearance: none; -webkit-appearance: none;
    font-size: 13px; font-weight: 700; color: var(--ink); cursor: pointer; outline: none;
}
.select-filter:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.1);
}
.search-wrap { position: relative; width: 260px; }
.search-wrap i {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--light); font-size: 13px; pointer-events: none;
}
.search-input {
    width: 100%; height: 38px; padding: 0 14px 0 36px;
    border: 1.5px solid var(--border-2); border-radius: var(--r-sm);
    font-size: 13px; color: var(--ink); background: var(--surface); outline: none;
}
.search-input:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.1);
}

/* Table */
.users-table-wrap { width: 100%; overflow-x: auto; }
table.users-table {
    width: 100% !important; margin: 0 !important;
    border-collapse: separate !important; border-spacing: 0 !important;
}
table.users-table thead th {
    padding: 13px 18px !important; background: var(--surface-alt);
    border-top: none !important; border-bottom: 1px solid var(--border) !important;
    color: #52675e; font-size: 11px; font-weight: 800; letter-spacing: .08em;
    text-transform: uppercase; white-space: nowrap; vertical-align: middle;
}
table.users-table thead th:first-child { padding-left: 32px !important; width: 50px; text-align: center; }
table.users-table thead th:last-child  { padding-right: 32px !important; width: 130px; text-align: center; }

table.users-table tbody td {
    padding: 16px 18px !important; vertical-align: middle !important;
    border-bottom: 1px solid var(--border); color: var(--tx); font-size: 13px;
}
table.users-table tbody tr:hover td { background: var(--surface-alt); }
table.users-table tbody td:first-child { padding-left: 32px !important; }
table.users-table tbody td:last-child  { padding-right: 32px !important; text-align: center; }

.row-num {
    color: var(--light); font-size: 12.5px; font-weight: 700;
    font-variant-numeric: tabular-nums; text-align: center;
}

/* Dosen Meta */
.dosen-cell {
    display: flex; align-items: center; gap: 10px; min-width: 0;
}
.dosen-avatar {
    width: 36px; height: 36px; flex: 0 0 36px;
    border-radius: 10px; background: var(--forest-soft);
    color: var(--forest-mid); display: inline-flex; align-items: center;
    justify-content: center; font-size: 13px; font-weight: 800;
    border: 1px solid rgba(0,93,59,.15);
}
.dosen-name {
    font-weight: 700; color: var(--ink); font-size: 13px; line-height: 1.3;
}
.dosen-email {
    font-size: 11.5px; color: var(--muted);
}

/* Judul Jurnal */
.judul-cell {
    min-width: 220px; display: flex; flex-direction: column; gap: 3px;
}
.judul-text {
    font-weight: 700; color: var(--ink); font-size: 13.5px; line-height: 1.4;
    word-break: break-word;
}
.judul-date {
    font-size: 11px; color: var(--muted); display: inline-flex; align-items: center; gap: 4px;
    white-space: nowrap;
}

/* Badges */
.badge-kat {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700;
}
.badge-kat-penelitian { background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
.badge-kat-pengabdian { background: #fdf4ff; color: #86198f; border: 1px solid #f5d0fe; }

.badge-status {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 11px; border-radius: 99px; font-size: 11.5px; font-weight: 700;
}
.badge-diproses { background: var(--warning-soft); color: var(--warning); border: 1px solid #fde68a; }
.badge-diterima { background: var(--success-soft); color: var(--success); border: 1px solid #bbf7d0; }
.badge-direvisi { background: var(--info-soft); color: var(--info); border: 1px solid #bae6fd; }
.badge-ditolak  { background: var(--danger-soft); color: var(--danger); border: 1px solid #fecaca; }

.admin-note-box {
    margin-top: 5px; padding: 4px 8px; border-radius: 6px;
    background: #fff; border: 1px dashed var(--border-2);
    font-size: 11px; color: var(--muted); max-width: 220px;
}

/* Action Dropdown */
.action-dropdown .btn-trigger {
    height: 34px; padding: 0 12px; display: inline-flex; align-items: center; gap: 5px;
    background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--r-sm);
    font-size: 12.5px; font-weight: 700; color: var(--ink); cursor: pointer; transition: all .15s ease;
}
.action-dropdown .btn-trigger:hover, .action-dropdown.show .btn-trigger {
    border-color: var(--border-2); background: var(--surface-hov);
}
.action-dropdown .dropdown-menu {
    border: 1px solid var(--border); border-radius: var(--r-md);
    box-shadow: 0 14px 36px rgba(15,23,42,.1); padding: 6px; margin-top: 4px; min-width: 175px;
}
.action-dropdown .dropdown-item {
    padding: 8px 12px; border-radius: 6px; font-size: 13px; font-weight: 600; color: var(--tx);
    display: flex; align-items: center; gap: 8px; transition: all .15s ease; background: transparent; border: none; width: 100%; text-align: left;
}
.action-dropdown .dropdown-item i { font-size: 12px; width: 16px; text-align: center; }
.action-dropdown .dropdown-item:hover { background: var(--surface-hov); color: var(--ink); }
.action-dropdown .dropdown-item.text-success { color: #059669 !important; }
.action-dropdown .dropdown-item.text-success:hover { background: #ecfdf5; color: #047857 !important; }
.action-dropdown .dropdown-item.text-danger { color: #dc2626 !important; }
.action-dropdown .dropdown-item.text-danger:hover { background: #fef2f2; color: #b91c1c !important; }

/* Modal Non-Approve */
.p3m-modal {
    z-index: 1060 !important;
}
.p3m-modal .modal-content {
    border: none; border-radius: var(--r-xl);
    box-shadow: 0 28px 70px rgba(0,30,20,.18); overflow: hidden;
}
.p3m-modal .modal-header {
    padding: 24px 26px 20px; background: var(--surface);
    border-bottom: 1px solid var(--border); display: flex; align-items: flex-start; gap: 14px;
}
.modal-icon.modal-icon-danger {
    width: 44px; height: 44px; border-radius: 12px;
    background: var(--danger-soft); color: var(--danger); border: 1px solid #fecaca;
    display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;
}
.modal-head-text { flex: 1; min-width: 0; }
.modal-head-text h5 { margin: 0 0 4px; font-size: 17px; font-weight: 800; color: var(--ink); letter-spacing: -.02em; }
.modal-head-text p  { margin: 0; font-size: 13px; color: var(--muted); line-height: 1.5; }
.modal-close-btn {
    background: none; border: none; color: var(--light); font-size: 24px;
    cursor: pointer; padding: 0; line-height: 1; margin-left: auto; flex-shrink: 0; transition: color .15s;
}
.modal-close-btn:hover { color: var(--ink); }

.p3m-modal .modal-body { padding: 22px 26px; background: var(--surface); }
.form-field { margin-bottom: 16px; }
.form-field label { display: block; font-size: 12.5px; font-weight: 800; color: var(--ink-2); margin-bottom: 7px; }
.form-field label .req { color: var(--danger); margin-left: 2px; }
.form-input {
    width: 100%; padding: 12px 14px; border: 1.5px solid var(--border); border-radius: var(--r-md);
    font-size: 13.5px; color: var(--ink); background: var(--surface); outline: none;
    transition: all .18s ease; font-family: inherit; resize: vertical;
}
.form-input:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.08);
}
.form-hint { display: block; margin-top: 6px; font-size: 12px; color: var(--muted); }

.p3m-modal .modal-footer {
    padding: 16px 26px 20px; background: var(--surface-alt);
    border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: flex-end; gap: 10px;
}
.btn-modal-cancel {
    height: 40px; padding: 0 18px; border-radius: var(--r-md);
    background: var(--surface); border: 1px solid var(--border);
    color: var(--tx); font-size: 13px; font-weight: 700; cursor: pointer; transition: all .15s;
}
.btn-modal-cancel:hover { background: var(--surface-hov); color: var(--ink); }
.btn-modal-submit.btn-danger {
    height: 40px; padding: 0 20px; border-radius: var(--r-md);
    background: var(--danger); border: none; color: #fff;
    font-size: 13px; font-weight: 700; cursor: pointer; transition: all .18s;
    box-shadow: 0 4px 14px rgba(220,38,38,.2); display: inline-flex; align-items: center; gap: 8px;
}
.btn-modal-submit.btn-danger:hover {
    background: #b91c1c; transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(185,28,28,.25);
}

/* Table Footer */
.table-footer {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 14px; padding: 16px 32px;
    background: #fbfcfb; border-top: 1px solid var(--border);
}
.table-info-text { font-size: 13px; color: var(--muted); font-weight: 500; }
.dt-pagination { display: flex; align-items: center; gap: 4px; }
.dt-pagination .page-item .page-link {
    min-width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
    border: 1px solid var(--border); border-radius: var(--r-sm);
    background: var(--surface); color: var(--tx); font-size: 13px; font-weight: 700;
    padding: 0 8px; transition: all .18s; cursor: pointer;
}
.dt-pagination .page-item.active .page-link {
    background: var(--forest); border-color: var(--forest); color: #fff;
    box-shadow: 0 4px 10px rgba(0,61,45,.18);
}
.dt-pagination .page-item:not(.active) .page-link:hover {
    background: var(--surface-hov); border-color: var(--border-2);
}
.dt-pagination .page-item.disabled .page-link { opacity: .45; cursor: not-allowed; }

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate { display: none !important; }

@media (max-width: 767.98px) {
    .page-usulan .content-header { padding: 20px 16px 0; }
    .page-usulan section.content { padding: 14px 16px 28px; }
    .users-card-head { padding: 22px 20px 18px; }
    .table-toolbar { padding: 14px 20px; }
    .search-wrap { width: 100%; }
    table.users-table thead th:first-child, table.users-table tbody td:first-child { padding-left: 20px !important; }
    table.users-table thead th:last-child,  table.users-table tbody td:last-child  { padding-right: 20px !important; }
    .table-footer { padding: 14px 20px; }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Pengajuan & Laporan</li>
                <li class="breadcrumb-item active">{{ $pagetitle ?? 'List Jurnal P3M' }}</li>
            </ol>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="users-card">
                {{-- Header --}}
                <div class="users-card-head">
                    <div>
                        <div class="card-eyebrow">Verifikasi Jurnal Dosen</div>
                        <h1 class="card-head-title" style="margin-bottom: 0;">List Jurnal P3M</h1>
                    </div>
                    <div class="stat-chip">
                        <i class="fas fa-book-reader"></i>
                        <span>Total Jurnal: <strong>{{ $jurnals->count() }}</strong></span>
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

                        @php
                            $currentKat = '';
                            if (request('kategori')) {
                                $reqKat = strtolower(request('kategori'));
                                if ($reqKat === 'penelitian') $currentKat = 'Penelitian';
                                elseif ($reqKat === 'pengabdian') $currentKat = 'Pengabdian';
                            }
                        @endphp
                        <x-p3m-dropdown
                            id="js-filter-kategori"
                            value="{{ $currentKat }}"
                            :options="[
                                ['value' => '', 'label' => 'Semua Kategori', 'icon' => 'fas fa-layer-group p3m-dropdown-icon', 'divider' => true],
                                ['value' => 'Penelitian', 'label' => 'Penelitian', 'icon' => 'fas fa-microscope p3m-dropdown-icon'],
                                ['value' => 'Pengabdian', 'label' => 'Pengabdian', 'icon' => 'fas fa-hands-helping p3m-dropdown-icon'],
                            ]"
                        />

                        @php
                            $currentStatus = '';
                            if (request('status')) {
                                $reqSt = strtolower(request('status'));
                                if ($reqSt === 'diproses' || $reqSt === 'proses') $currentStatus = 'Diproses';
                                elseif ($reqSt === 'diterima' || $reqSt === 'disetujui' || $reqSt === 'acc') $currentStatus = 'Disetujui';
                                elseif ($reqSt === 'direvisi' || $reqSt === 'revisi') $currentStatus = 'Direvisi';
                                elseif ($reqSt === 'ditolak' || $reqSt === 'reject') $currentStatus = 'Ditolak';
                            }
                        @endphp
                        <x-p3m-dropdown
                            id="js-filter-status"
                            value="{{ $currentStatus }}"
                            :options="[
                                ['value' => '', 'label' => 'Semua Status', 'icon' => 'fas fa-sliders-h p3m-dropdown-icon', 'divider' => true],
                                ['value' => 'Diproses', 'label' => 'Diproses', 'dot' => 'dot-warning'],
                                ['value' => 'Disetujui', 'label' => 'Disetujui', 'dot' => 'dot-success'],
                                ['value' => 'Direvisi', 'label' => 'Direvisi', 'dot' => 'dot-primary'],
                                ['value' => 'Ditolak', 'label' => 'Ditolak', 'dot' => 'dot-danger'],
                            ]"
                        />
                    </div>

                    <div class="search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="search" id="js-search-input" class="search-input" placeholder="Cari dosen atau judul jurnal...">
                    </div>
                </div>

                {{-- Table --}}
                <div class="users-table-wrap">
                    <table id="adminJurnalTable" class="users-table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>DOSEN PENGUSUL</th>
                                <th>JUDUL JURNAL</th>
                                <th>KATEGORI</th>
                                <th>BERKAS JURNAL</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jurnals as $index => $jurnal)
                                <tr>
                                    <td>
                                        <span class="row-num">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="dosen-cell">
                                            <div class="dosen-avatar">
                                                {{ strtoupper(substr($jurnal->user->name ?? 'D', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="dosen-name">{{ $jurnal->user->name ?? 'Dosen Polibang' }}</div>
                                                <div class="dosen-email">{{ $jurnal->user->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="judul-cell">
                                            <div class="judul-text">{{ $jurnal->judul }}</div>
                                            <div class="judul-date">
                                                <i class="far fa-calendar-alt"></i>
                                                <span>{{ $jurnal->created_at ? $jurnal->created_at->isoFormat('D MMMM Y, HH:mm') . ' WIB' : '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($jurnal->kategori === 'pengabdian')
                                            <span class="badge-kat badge-kat-pengabdian">
                                                <i class="fas fa-hand-holding-heart"></i> Pengabdian
                                            </span>
                                        @else
                                            <span class="badge-kat badge-kat-penelitian">
                                                <i class="fas fa-microscope"></i> Penelitian
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('plppm.jurnal_dosen.download', $jurnal->id) }}" class="btn btn-sm btn-light border font-weight-bold" style="border-radius: 8px; font-size: 12px;" title="Unduh File: {{ $jurnal->file_name }}">
                                            <i class="fas fa-file-pdf text-danger mr-1"></i> Unduh PDF
                                        </a>
                                    </td>
                                    <td>
                                        @if ($jurnal->status === 'diterima')
                                            <span class="badge-status badge-diterima"><i class="fas fa-check-circle"></i> Disetujui</span>
                                        @elseif ($jurnal->status === 'direvisi')
                                            <span class="badge-status badge-direvisi"><i class="fas fa-exclamation-circle"></i> Direvisi</span>
                                        @elseif ($jurnal->status === 'ditolak')
                                            <span class="badge-status badge-ditolak"><i class="fas fa-times-circle"></i> Ditolak</span>
                                        @else
                                            <span class="badge-status badge-diproses"><i class="fas fa-clock"></i> Diproses</span>
                                        @endif

                                        @if ($jurnal->catatan_admin)
                                            <div class="admin-note-box" title="{{ $jurnal->catatan_admin }}">
                                                <strong>Catatan:</strong> {{ Str::limit($jurnal->catatan_admin, 35) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown action-dropdown">
                                            <button class="btn-trigger" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Aksi <i class="fas fa-chevron-down" style="font-size:10px; margin-left:3px; color: var(--light);"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <form action="{{ route('plppm.jurnal_dosen.status', $jurnal->id) }}" method="POST" id="approve-jurnal-{{ $jurnal->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="diterima">
                                                    <button type="button" class="dropdown-item text-success"
                                                        data-p3m-approve
                                                        data-type="List Jurnal P3M"
                                                        data-title="Setujui Jurnal"
                                                        data-label="{{ Str::limit($jurnal->judul ?? 'jurnal ini', 40) }}"
                                                        data-form-id="approve-jurnal-{{ $jurnal->id }}">
                                                        <i class="fas fa-check"></i> Setujui (Approve)
                                                    </button>
                                                </form>

                                                <form action="{{ route('plppm.jurnal_dosen.status', $jurnal->id) }}" method="POST" id="proses-jurnal-{{ $jurnal->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="diproses">
                                                    <button type="button" class="dropdown-item"
                                                        data-p3m-proses
                                                        data-type="List Jurnal P3M"
                                                        data-title="Set Jurnal Diproses"
                                                        data-label="{{ Str::limit($jurnal->judul ?? 'jurnal ini', 40) }}"
                                                        data-form-id="proses-jurnal-{{ $jurnal->id }}">
                                                        <i class="fas fa-clock"></i> Set Diproses
                                                    </button>
                                                </form>

                                                <div class="dropdown-divider"></div>

                                                <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-nonapprove-{{ $jurnal->id }}">
                                                    <i class="fas fa-ban"></i> Tolak / Revisi
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 text-secondary d-block"></i>
                                        Belum ada data jurnal yang diunggah oleh dosen.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Footer Pagination --}}
                <div class="table-footer">
                    <span class="table-info-text" id="js-table-info">Menampilkan data</span>
                    <ul class="dt-pagination" id="js-dt-pagination"></ul>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Modals Non-Approve / Tolak & Revisi --}}
@foreach ($jurnals as $jurnal)
<div class="modal fade p3m-modal" id="modal-nonapprove-{{ $jurnal->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-left">
            <form action="{{ route('plppm.jurnal_dosen.status', $jurnal->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="ditolak">
                <div class="modal-header">
                    <div class="modal-icon modal-icon-danger"><i class="fas fa-ban"></i></div>
                    <div class="modal-head-text">
                        <h5>Catatan Penolakan / Revisi</h5>
                        <p>Berikan instruksi perbaikan atau alasan penolakan bagi publikasi jurnal ini.</p>
                    </div>
                    <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-field mb-0">
                        <label>Catatan Admin <span class="req">*</span></label>
                        <textarea name="reason" class="form-input" rows="4" required placeholder="Tuliskan catatan perbaikan atau alasan jurnal ini belum dapat disetujui..."></textarea>
                        <span class="form-hint">Catatan ini akan langsung terlihat oleh dosen pengunggah pada riwayat status jurnal.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-submit btn-danger">
                        <i class="fas fa-times"></i> Simpan Penolakan
                    </button>
                </div>
            </form>
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
    function initAdminJurnalTable() {
        if ($.fn.DataTable.isDataTable('#adminJurnalTable')) {
            $('#adminJurnalTable').DataTable().destroy();
        }

        var table = $('#adminJurnalTable').DataTable({
            responsive: true,
            autoWidth: false,
            ordering: false,
            pageLength: 10,
            dom: 't',
            language: {
                emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                zeroRecords: "Tidak ditemukan data yang sesuai dengan pencarian"
            },
            drawCallback: function(settings) {
                var api = this.api();
                var pageInfo = api.page.info();

                if (pageInfo.recordsTotal === 0) {
                    $('#js-table-info').text('Menampilkan 0 dari 0 data');
                    $('#js-dt-pagination').empty();
                    return;
                }

                var start = pageInfo.start + 1;
                var end = pageInfo.end;
                var total = pageInfo.recordsDisplay;

                $('#js-table-info').text('Menampilkan ' + start + ' - ' + end + ' dari ' + total + ' data');

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

        // Filter Kategori (kolom index 3)
        $('#js-filter-kategori').off('change').on('change', function() {
            var val = $(this).val();
            table.column(3).search(val ? val : '', true, false).draw();

            var params = new URLSearchParams(window.location.search);
            if (val) {
                params.set('kategori', val.toLowerCase());
            } else {
                params.delete('kategori');
            }
            var query = params.toString() ? '?' + params.toString() : '';
            window.history.replaceState({}, '', window.location.pathname + query);
        });

        // Filter Status (kolom index 5)
        $('#js-filter-status').off('change').on('change', function() {
            var val = $(this).val();
            table.column(5).search(val ? val : '', true, false).draw();

            var params = new URLSearchParams(window.location.search);
            if (val) {
                params.set('status', val.toLowerCase());
            } else {
                params.delete('status');
            }
            var query = params.toString() ? '?' + params.toString() : '';
            window.history.replaceState({}, '', window.location.pathname + query);
        });

        // Initial filter
        var initKat = $('#js-filter-kategori').val();
        if (initKat) {
            table.column(3).search(initKat, true, false);
        }
        var initStatus = $('#js-filter-status').val();
        if (initStatus) {
            table.column(5).search(initStatus, true, false);
        }
        table.draw();
    }

    $(document).off('click', '#js-dt-pagination a.page-link').on('click', '#js-dt-pagination a.page-link', function(e) {
        e.preventDefault();
        var page = $(this).data('dt-page');
        if ($.fn.DataTable.isDataTable('#adminJurnalTable')) {
            var table = $('#adminJurnalTable').DataTable();
            if (page !== undefined && page >= 0 && page < table.page.info().pages) {
                table.page(page).draw('page');
            }
        }
    });

    var initTimer = null;
    function scheduleInit() {
        clearTimeout(initTimer);
        initTimer = setTimeout(initAdminJurnalTable, 20);
    }

    document.addEventListener('turbo:load', scheduleInit);
    document.addEventListener('turbo:before-cache', function() {
        if ($.fn.DataTable.isDataTable('#adminJurnalTable')) {
            $('#adminJurnalTable').DataTable().destroy();
        }
    });

    scheduleInit();
})();
</script>
@endsection
