@extends('layout.main')

@section('body_class', 'page-usulan')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
/* ================================================================
   P3M — Laporan Pengabdian — Breathable & Clean SaaS Design
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
    --r-sm: 8px; --r-md: 12px; --r-lg: 16px; --r-xl: 20px; --r-2xl: 24px;
}

/* Page Shell */
.page-usulan .content-wrapper {
    min-height: calc(100vh - 78px);
    background: radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0,93,59,.04), transparent),
                linear-gradient(180deg, #f6f9f7 0%, #f8fafc 100%);
}
.page-usulan .content-header { padding: 26px 32px 0; }
.page-usulan section.content { padding: 16px 32px 40px; }

/* Breadcrumb */
.page-usulan .breadcrumb {
    background: transparent; padding: 0; margin: 0;
    font-size: 12.5px; font-weight: 600;
}
.page-usulan .breadcrumb-item a { color: var(--forest-mid); text-decoration: none; transition: opacity .18s; }
.page-usulan .breadcrumb-item a:hover { opacity: .75; }
.page-usulan .breadcrumb-item.active { color: var(--muted); }
.page-usulan .breadcrumb-item + .breadcrumb-item::before { content: "/"; padding: 0 8px; color: var(--border-2); }

/* Main Card */
.users-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r-2xl); box-shadow: 0 16px 40px rgba(15,23,42,.06), 0 2px 6px rgba(0,0,0,.03);
    overflow: hidden;
}

/* Card Header */
.users-card-head {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 20px; flex-wrap: wrap;
    padding: 28px 32px 24px;
    background: linear-gradient(112deg, #ffffff 60%, #f4faf6 100%);
    border-bottom: 1px solid var(--border);
    position: relative; overflow: hidden;
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
    gap: 16px; flex-wrap: wrap;
    padding: 16px 32px;
    background: var(--surface); border-bottom: 1px solid var(--border);
}
.toolbar-left {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; font-weight: 600; color: var(--muted);
}
.toolbar-select {
    height: 36px; padding: 0 10px;
    border: 1px solid var(--border); border-radius: var(--r-sm);
    font-size: 13px; font-weight: 700; color: var(--ink);
    background: var(--surface); cursor: pointer; outline: none; transition: border-color .18s;
}
.toolbar-select:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.08);
}
.search-wrap { position: relative; }
.search-icon {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--light); font-size: 13px; pointer-events: none;
}
.search-input {
    width: 260px; height: 36px; padding: 0 14px 0 36px;
    border: 1px solid var(--border); border-radius: var(--r-sm);
    font-size: 13px; font-weight: 500; color: var(--ink);
    background: var(--surface); outline: none; transition: all .18s ease;
}
.search-input::placeholder { color: var(--light); }
.search-input:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.08); width: 290px;
}

/* Table - Clean, Generous Whitespace, No Horizontal Scrollbar */
.users-table-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
table.users-table {
    width: 100% !important;
    margin: 0 !important;
    border-collapse: collapse !important;
}

.users-table thead th {
    padding: 13px 20px; background: #fbfcfb;
    border-bottom: 1px solid var(--border) !important; border-top: none;
    font-size: 11px; font-weight: 800; text-transform: uppercase;
    letter-spacing: .08em; color: var(--muted); white-space: nowrap;
}
.users-table thead th:first-child { padding-left: 32px; text-align: center; }
.users-table thead th:last-child  { padding-right: 32px; }

.users-table tbody td {
    padding: 18px 20px; vertical-align: middle;
    border-bottom: 1px solid #f1f5f3; font-size: 13.5px; color: var(--tx);
    transition: background .15s ease;
}
.users-table tbody td:first-child { padding-left: 32px; text-align: center; }
.users-table tbody td:last-child  { padding-right: 32px; }
.users-table tbody tr:last-child td { border-bottom: none; }
.users-table tbody tr:hover td { background: #f8faf9; }

.row-num {
    font-size: 13px; font-variant-numeric: tabular-nums;
    color: var(--light); font-weight: 700;
}

/* Usulan Cell - Spacious & Elegant */
.usulan-cell {
    padding-right: 12px;
}
.usulan-title {
    display: block; font-size: 14.5px; font-weight: 700; color: var(--ink);
    line-height: 1.45; margin-bottom: 6px; letter-spacing: -0.01em;
}
.usulan-sub {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    font-size: 12.5px; color: var(--muted); line-height: 1.4;
}
.bidang-tag {
    display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px;
    border-radius: 6px; background: #f0f7f4; border: 1px solid #d3e8dc;
    color: var(--forest-mid); font-size: 11.5px; font-weight: 700;
    text-transform: capitalize;
}
.sub-meta {
    font-size: 12px; color: var(--muted); font-weight: 500; display: inline-flex; align-items: center; gap: 4px;
}
.sub-meta i { font-size: 11px; }

/* Pengusul Cell */
.pengusul-name {
    display: block; font-weight: 700; color: var(--ink); font-size: 13.5px;
    line-height: 1.35; margin-bottom: 2px;
}
.pengusul-meta {
    font-size: 12px; color: var(--muted); display: block;
}

/* Date Cell */
.date-text {
    font-size: 13px; font-weight: 600; color: var(--tx); white-space: nowrap;
}

/* Refined Minimal Status Badges */
.status-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 99px; font-size: 11px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 0.04em; white-space: nowrap;
}
.status-pill::before {
    content: ""; width: 6px; height: 6px; border-radius: 50%;
    background: currentColor;
}
.status-approve {
    background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;
}
.status-proses {
    background: #fffbeb; color: #92400e; border: 1px solid #fde68a;
}
.status-reject {
    background: #fef2f2; color: #991b1b; border: 1px solid #fecaca;
}
.status-default {
    background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;
}

/* Action Wrap */
.action-wrap {
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-eye {
    width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
    background: var(--surface) !important; border: 1.5px solid var(--border) !important;
    border-radius: var(--r-sm); color: var(--forest-mid) !important; font-size: 13px;
    cursor: pointer; transition: all .18s ease; text-decoration: none;
}
.btn-eye:hover {
    background: var(--forest-soft) !important; border-color: #b5ddc7 !important;
    color: var(--forest) !important; transform: translateY(-1px);
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

/* Force zero horizontal scroll from DT wrappers */
.dataTables_wrapper { width: 100% !important; overflow: hidden !important; }
.dataTables_wrapper > .row { margin: 0 !important; }
.dataTables_wrapper > .row > [class*="col-"] { padding: 0 !important; }

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

/* Hide DT default */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate { display: none !important; }

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

/* Responsive */
@media (max-width: 767.98px) {
    .page-usulan .content-header { padding: 20px 16px 0; }
    .page-usulan section.content { padding: 14px 16px 28px; }
    .users-card { border-radius: var(--r-lg); }
    .users-card-head { padding: 22px 20px 18px; }
    .card-head-title { font-size: 19px; }
    .table-toolbar { padding: 14px 20px; gap: 12px; }
    .search-input, .search-input:focus { width: 100%; }
    .users-table thead th:first-child, .users-table tbody td:first-child { padding-left: 20px; }
    .users-table thead th:last-child,  .users-table tbody td:last-child  { padding-right: 20px; }
    .table-footer { padding: 14px 20px; }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    {{-- Breadcrumb --}}
    <div class="content-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Pengajuan & Laporan</li>
            <li class="breadcrumb-item active">{{ $pagetitle }}</li>
        </ol>
    </div>

    {{-- Main Content Section --}}
    <section class="content">
        <div class="users-card">
            {{-- Card Header --}}
            <div class="users-card-head">
                <div>
                    <span class="card-eyebrow">Pengajuan & Laporan</span>
                    <h1 class="card-head-title">Laporan Pengabdian Masyarakat</h1>
                </div>
                <div class="card-head-actions">
                    <div class="stat-chip">
                        <i class="fas fa-file-invoice"></i>
                        Total {{ count($penelitians) }} laporan
                    </div>
                </div>
            </div>

            {{-- Table Toolbar --}}
            <div class="table-toolbar">
                <div class="toolbar-left">
                    <span>Tampilkan</span>
                    <x-p3m-dropdown
                        id="pageLengthSelect"
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
                        $currentStatus = '';
                        if (request('status')) {
                            $reqSt = strtolower(request('status'));
                            if ($reqSt === 'proses' || $reqSt === 'diproses') $currentStatus = 'Diproses';
                            elseif ($reqSt === 'approve' || $reqSt === 'disetujui') $currentStatus = 'Disetujui';
                            elseif ($reqSt === 'reject' || $reqSt === 'non-approve' || $reqSt === 'ditolak') $currentStatus = 'Ditolak';
                        }
                    @endphp

                    <x-p3m-dropdown
                        id="filterStatus"
                        value="{{ $currentStatus }}"
                        class="ml-1"
                        :options="[
                            ['value' => '', 'label' => 'Semua Status', 'icon' => 'fas fa-sliders-h p3m-dropdown-icon', 'divider' => true],
                            ['value' => 'Diproses', 'label' => 'Diproses', 'dot' => 'dot-warning'],
                            ['value' => 'Disetujui', 'label' => 'Disetujui', 'dot' => 'dot-success'],
                            ['value' => 'Ditolak', 'label' => 'Ditolak', 'dot' => 'dot-danger'],
                        ]"
                    />
                </div>
                <div class="search-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="tableSearch" placeholder="Cari laporan, ketua pengabdi, bidang...">
                </div>
            </div>

            {{-- Table --}}
            <div class="users-table-wrap">
                <table class="table users-table" id="usulanTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="44%">Judul Laporan</th>
                            <th width="18%">Pengabdi</th>
                            <th width="11%">Tanggal</th>
                            <th width="10%">Status</th>
                            <th width="12%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penelitians as $d)
                        <tr>
                            <td class="row-num">{{ $loop->iteration }}</td>
                            <td>
                                <div class="usulan-cell">
                                    <span class="usulan-title">{{ $d->judul }}</span>
                                    <div class="usulan-sub">
                                        @if ($d->bidang)
                                        <span class="bidang-tag">{{ $d->bidang }}</span>
                                        @endif
                                        @if ($d->biaya)
                                        <span class="sub-meta">
                                            &bull; Rp {{ number_format($d->biaya, 0, ',', '.') }}
                                        </span>
                                        @endif
                                        @if ($d->uppdf)
                                        <span class="sub-meta" title="Tersedia berkas PDF laporan">
                                            &bull; <i class="fas fa-paperclip text-muted"></i> PDF
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="pengusul-name">{{ $d->ketua }}</span>
                                <span class="pengusul-meta">
                                    {{ $d->prodi ?? 'Polibang' }} &bull; {{ $d->nidn ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="date-text">
                                    {{ $d->created_at ? $d->created_at->translatedFormat('d M Y') : '-' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($d->status) {
                                        'approve' => 'status-approve',
                                        'proses' => 'status-proses',
                                        'non-approve' => 'status-reject',
                                        default => 'status-default',
                                    };
                                    $statusLabel = match($d->status) {
                                        'approve' => 'Disetujui',
                                        'proses' => 'Diproses',
                                        'non-approve' => 'Ditolak',
                                        default => ucfirst($d->status ?? '-'),
                                    };
                                @endphp
                                <span class="status-pill {{ $badgeClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="text-center">
                                <div class="action-wrap">
                                    <a href="{{ route('detail.detailk', ['tipe' => 'kpengeabdian', 'id' => $d->id]) }}" class="btn-eye" title="Lihat Detail Laporan">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <div class="dropdown action-dropdown">
                                        <button class="btn-trigger" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi <i class="fas fa-chevron-down" style="font-size:10px; margin-left:3px; color: var(--light);"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <form action="{{ route('plppm.kumpulan.status', ['tipe' => 'kum_pengabdian', 'id' => $d->id]) }}" method="POST" id="approve-kpeng-{{ $d->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approve">
                                                <button type="button" class="dropdown-item text-success"
                                                    data-p3m-approve
                                                    data-type="Laporan Pengabdian"
                                                    data-title="Setujui Laporan Pengabdian"
                                                    data-label="{{ Str::limit($d->judul ?? 'laporan ini', 40) }}"
                                                    data-form-id="approve-kpeng-{{ $d->id }}">
                                                    <i class="fas fa-check"></i> Setujui (Approve)
                                                </button>
                                            </form>

                                            <form action="{{ route('plppm.kumpulan.status', ['tipe' => 'kum_pengabdian', 'id' => $d->id]) }}" method="POST" id="proses-kpeng-{{ $d->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="proses">
                                                <button type="button" class="dropdown-item"
                                                    data-p3m-proses
                                                    data-type="Laporan Pengabdian"
                                                    data-title="Set Laporan Diproses"
                                                    data-label="{{ Str::limit($d->judul ?? 'laporan ini', 40) }}"
                                                    data-form-id="proses-kpeng-{{ $d->id }}">
                                                    <i class="fas fa-clock"></i> Set Diproses
                                                </button>
                                            </form>

                                            <div class="dropdown-divider"></div>

                                            <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-nonapprove-{{ $d->id }}">
                                                <i class="fas fa-ban"></i> Tolak / Revisi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Table Footer --}}
            <div class="table-footer">
                <span class="table-info-text" id="tableInfo"></span>
                <div id="tablePagination"></div>
            </div>
        </div>
    </section>
</div>

{{-- Modals Non-Approve / Tolak & Revisi --}}
@foreach ($penelitians as $d)
<div class="modal fade p3m-modal" id="modal-nonapprove-{{ $d->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-left">
            <form action="{{ route('plppm.kumpulan.status', ['tipe' => 'kum_pengabdian', 'id' => $d->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="non-approve">
                <div class="modal-header">
                    <div class="modal-icon modal-icon-danger"><i class="fas fa-ban"></i></div>
                    <div class="modal-head-text">
                        <h5>Catatan Penolakan / Revisi</h5>
                        <p>Berikan instruksi perbaikan atau alasan penolakan bagi laporan pengabdian.</p>
                    </div>
                    <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-field mb-0">
                        <label>Catatan Admin <span class="req">*</span></label>
                        <textarea name="reason" class="form-input" rows="4" required placeholder="Tuliskan catatan perbaikan atau alasan laporan pengabdian ini belum dapat disetujui..."></textarea>
                        <span class="form-hint">Catatan ini akan langsung terlihat oleh dosen pengabdi pada riwayat status.</span>
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
<script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
(function () {
    function initUsulanTable() {
        if ($.fn.DataTable.isDataTable('#usulanTable')) {
            $('#usulanTable').DataTable().destroy();
        }

        var table = $('#usulanTable').DataTable({
            responsive: true,
            lengthChange: false,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: false,
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Cari laporan, ketua pengabdi, bidang...",
                info: "Menampilkan _START_-_END_ dari _TOTAL_ data",
                paginate: {
                    previous: '<i class="fas fa-chevron-left"></i>',
                    next:     '<i class="fas fa-chevron-right"></i>'
                },
                emptyTable: "Belum ada laporan pengabdian",
                zeroRecords: "Tidak ada laporan yang sesuai dengan pencarian"
            },
            drawCallback: function () {
                var info = this.api().page.info();
                var from  = info.recordsDisplay === 0 ? 0 : info.start + 1;
                var to    = Math.min(info.end, info.recordsDisplay);
                $('#tableInfo').text('Menampilkan ' + from + '\u2013' + to + ' dari ' + info.recordsDisplay + ' data');

                var $container = $(this.api().table().container());
                var $dtPg = $container.find('.dataTables_paginate');
                var $ul = $('<ul class="dt-pagination pagination"></ul>');
                $dtPg.find('li').each(function () { $ul.append($(this).clone(true)); });
                $('#tablePagination').html('').append($ul);

                $('#tablePagination').find('li').each(function (i) {
                    var $orig = $dtPg.find('li').eq(i);
                    $(this).find('a, span').on('click', function (e) {
                        e.preventDefault();
                        $orig.find('a, span').first().trigger('click');
                    });
                });

                // Re-bind P3M SweetAlert2 action listeners on DataTable redraw
                if (typeof window.p3mBindActions === 'function') {
                    window.p3mBindActions();
                }
            }
        });

        $('#tableSearch').off('input keyup').on('input keyup', function () { table.search(this.value).draw(); });
        $('#pageLengthSelect').off('change').on('change', function () { table.page.len(+this.value).draw(); });

        $('#filterStatus').off('change').on('change', function () {
            var val = $(this).val();
            table.column(4).search(val ? val : '').draw();

            var params = new URLSearchParams(window.location.search);
            if (val) {
                params.set('status', val.toLowerCase());
            } else {
                params.delete('status');
            }
            var query = params.toString() ? '?' + params.toString() : '';
            window.history.replaceState({}, '', window.location.pathname + query);
        });

        // Initial filter if set
        var initStatus = $('#filterStatus').val();
        if (initStatus) {
            table.column(4).search(initStatus);
        }
        table.draw();
    }

    var initTimer = null;
    function scheduleInit() {
        clearTimeout(initTimer);
        initTimer = setTimeout(initUsulanTable, 20);
    }

    document.addEventListener('turbo:load', scheduleInit);
    document.addEventListener('turbo:before-cache', function() {
        if ($.fn.DataTable.isDataTable('#usulanTable')) {
            $('#usulanTable').DataTable().destroy();
        }
    });

    scheduleInit();
})();
</script>
@endsection
