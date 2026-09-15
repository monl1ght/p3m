@extends('layout.main')

@section('body_class', 'page-users')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
/* ================================================================
   P3M — Jurnal Page — Premium SaaS Redesign
   ================================================================ */

:root {
    --forest:       #003d2d;
    --forest-deep:  #002e22;
    --forest-mid:   #00573b;
    --forest-soft:  #eaf5ee;
    --gold:         #b99835;
    --gold-soft:    #fdf8ec;
    --ink:          #0d1f1a;
    --ink-2:        #1e3328;
    --tx:           #3b4f47;
    --muted:        #6b7f78;
    --light:        #9caaa4;
    --border:       #e4ede8;
    --border-2:     #d3e0d9;
    --surface:      #ffffff;
    --surface-alt:  #f7faf8;
    --surface-hov:  #f2f7f4;
    --danger:       #d94b4b;
    --danger-soft:  #fef2f2;
    --info:         #0284c7;
    --info-soft:    #f0f9ff;
    --r-sm: 8px; --r-md: 12px; --r-lg: 16px; --r-xl: 20px; --r-2xl: 24px;
}

/* Page Shell */
.page-users .content-wrapper {
    min-height: calc(100vh - 78px);
    background: radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0,93,59,.06), transparent),
                linear-gradient(180deg, #f2f8f5 0%, #f7faf8 100%);
}
.page-users .content-header { padding: 26px 28px 0; }
.page-users section.content { padding: 16px 28px 36px; }

/* Breadcrumb */
.page-users .breadcrumb {
    background: transparent; padding: 0; margin: 0;
    font-size: 12.5px; font-weight: 600;
}
.page-users .breadcrumb-item a { color: var(--forest); text-decoration: none; transition: opacity .18s; }
.page-users .breadcrumb-item a:hover { opacity: .75; }
.page-users .breadcrumb-item.active { color: var(--muted); }
.page-users .breadcrumb-item + .breadcrumb-item::before { content: "/"; padding: 0 8px; color: var(--border-2); }

/* Main Card */
.users-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r-2xl); box-shadow: 0 20px 56px rgba(3,50,33,.12), 0 4px 12px rgba(0,0,0,.06);
    overflow: hidden;
}

/* Card Header */
.users-card-head {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 20px; flex-wrap: wrap;
    padding: 28px 32px 24px;
    background: linear-gradient(112deg, #ffffff 55%, #f0faf5 100%);
    border-bottom: 1px solid var(--border);
    position: relative; overflow: hidden;
}
.users-card-head::after {
    content: ""; position: absolute; top: -40px; right: -40px;
    width: 200px; height: 200px; border-radius: 50%;
    background: radial-gradient(circle, rgba(0,93,59,.05), transparent 70%);
    pointer-events: none;
}
.card-eyebrow {
    display: inline-flex; align-items: center; gap: 8px; margin-bottom: 10px;
    color: var(--forest-mid); font-size: 11px; font-weight: 800;
    letter-spacing: .12em; text-transform: uppercase;
}
.card-eyebrow::before {
    content: ""; width: 20px; height: 2.5px; border-radius: 99px; background: var(--gold);
}
.card-head-title {
    font-family: "Plus Jakarta Sans", "Inter", sans-serif;
    font-size: 22px; font-weight: 800; color: var(--ink);
    letter-spacing: -.04em; margin: 0 0 6px; line-height: 1.2;
}
.card-head-sub {
    color: var(--muted); font-size: 13.5px; line-height: 1.65; margin: 0; max-width: 520px;
}
.card-head-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.stat-chip {
    display: inline-flex; align-items: center; gap: 8px; padding: 9px 14px;
    background: var(--surface-alt); border: 1px solid var(--border);
    border-radius: var(--r-md); font-size: 13px; font-weight: 700; color: var(--ink-2); white-space: nowrap;
}
.stat-chip i { color: var(--forest-mid); font-size: 14px; }
.btn-add-user {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 18px; background: var(--forest); color: #fff; text-decoration: none;
    border: none; border-radius: var(--r-md); font-size: 13.5px; font-weight: 700;
    cursor: pointer; transition: all .18s ease;
    box-shadow: 0 6px 18px rgba(0,61,45,.22); white-space: nowrap;
}
.btn-add-user:hover {
    background: var(--forest-deep); color: #fff;
    transform: translateY(-1px); box-shadow: 0 10px 24px rgba(0,46,34,.28);
}
.btn-add-user i { font-size: 12px; }

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
    border: 1px solid var(--border-2); border-radius: var(--r-sm);
    font-size: 13px; font-weight: 700; color: var(--ink);
    background: var(--surface); cursor: pointer; outline: none; transition: border-color .18s;
}
.toolbar-select:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.1);
}
.search-wrap { position: relative; }
.search-icon {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--light); font-size: 13px; pointer-events: none;
}
.search-input {
    width: 260px; height: 36px; padding: 0 14px 0 36px;
    border: 1px solid var(--border-2); border-radius: var(--r-sm);
    font-size: 13px; font-weight: 500; color: var(--ink);
    background: var(--surface); outline: none; transition: all .18s ease;
}
.search-input::placeholder { color: var(--light); }
.search-input:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.1); width: 300px;
}

/* Table - Clean layout without horizontal scrollbar */
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
    padding: 14px 20px; background: var(--surface-alt);
    border-bottom: 1px solid var(--border) !important; border-top: none;
    font-size: 11px; font-weight: 800; text-transform: uppercase;
    letter-spacing: .08em; color: var(--muted); white-space: nowrap;
}
.users-table thead th:first-child { padding-left: 32px; text-align: center; }
.users-table thead th:last-child  { padding-right: 32px; }

.users-table tbody td {
    padding: 16px 20px; vertical-align: middle;
    border-bottom: 1px solid var(--border); font-size: 14px; color: var(--tx);
    transition: background .15s ease;
}
.users-table tbody td:first-child { padding-left: 32px; text-align: center; }
.users-table tbody td:last-child  { padding-right: 32px; }
.users-table tbody tr:last-child td { border-bottom: none; }
.users-table tbody tr:hover td { background: var(--surface-alt); }

.row-num {
    font-size: 13px; font-variant-numeric: tabular-nums;
    color: var(--light); font-weight: 700;
}

/* Journal Main Info Cell */
.jurnal-main-cell {
    display: flex; align-items: flex-start; gap: 14px;
}
.jurnal-icon {
    width: 44px; height: 44px; border-radius: var(--r-md); flex-shrink: 0;
    background: var(--forest-soft); color: var(--forest); border: 1.5px solid #c2dece;
    display: flex; align-items: center; justify-content: center; font-size: 18px; margin-top: 2px;
}
.jurnal-title {
    display: block; font-size: 14px; font-weight: 800; color: var(--ink);
    line-height: 1.45; margin-bottom: 4px; word-break: break-word;
}
.jurnal-subtitle {
    display: flex; align-items: center; gap: 6px; font-size: 12px;
    font-weight: 600; color: var(--muted);
}

/* Link & Platform Pill */
.platform-pill {
    display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px;
    border-radius: 99px; background: #f0f9ff; border: 1px solid #bae6fd;
    color: #0369a1; font-size: 12px; font-weight: 700; max-width: 220px;
    text-decoration: none; transition: all .15s ease;
}
.platform-pill:hover {
    background: #e0f2fe; color: #0284c7; text-decoration: none;
    transform: translateY(-1px);
}
.platform-pill i { font-size: 11px; flex-shrink: 0; }
.platform-pill span {
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}

/* Date Pill */
.date-pill {
    display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px;
    border-radius: 99px; background: var(--surface-alt); border: 1px solid var(--border-2);
    color: var(--muted); font-size: 12px; font-weight: 700; white-space: nowrap;
}
.date-pill i { color: var(--forest-mid); font-size: 11px; }

/* Action Buttons */
.action-wrap { display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-icon {
    width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
    border: 1.5px solid transparent; border-radius: var(--r-sm); font-size: 13px;
    cursor: pointer; transition: all .18s ease; background: transparent; padding: 0;
    text-decoration: none;
}
.btn-icon-link {
    background: var(--info-soft) !important; color: var(--info) !important; border-color: #bae6fd !important;
}
.btn-icon-link:hover {
    background: var(--info) !important; color: #fff !important; border-color: var(--info) !important;
    transform: translateY(-1px); box-shadow: 0 4px 12px rgba(2,132,199,.22);
}
.btn-icon-edit {
    background: var(--forest-soft) !important; color: var(--forest) !important; border-color: #c2dece !important;
}
.btn-icon-edit:hover {
    background: var(--forest) !important; color: #fff !important; border-color: var(--forest) !important;
    transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,61,45,.22);
}
.btn-icon-del {
    background: var(--danger-soft) !important; color: var(--danger) !important; border-color: #f5c0c0 !important;
}
.btn-icon-del:hover {
    background: var(--danger) !important; color: #fff !important; border-color: var(--danger) !important;
    transform: translateY(-1px); box-shadow: 0 4px 12px rgba(217,75,75,.22);
}

/* Remove Bootstrap grid padding from DataTables wrapper */
.dataTables_wrapper > .row { margin: 0 !important; }
.dataTables_wrapper > .row > [class*="col-"] { padding: 0 !important; }

/* Table Footer */
.table-footer {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 14px; padding: 16px 32px;
    background: var(--surface-alt); border-top: 1px solid var(--border);
}
.table-info-text { font-size: 13px; color: var(--muted); font-weight: 500; }
.dt-pagination { display: flex; align-items: center; gap: 4px; }
.dt-pagination .page-item .page-link {
    min-width: 34px; height: 34px; display: inline-flex;
    align-items: center; justify-content: center;
    border: 1px solid var(--border); border-radius: var(--r-sm);
    background: var(--surface); color: var(--tx); font-size: 13px; font-weight: 700;
    padding: 0 8px; transition: all .18s; cursor: pointer;
}
.dt-pagination .page-item.active .page-link {
    background: var(--forest); border-color: var(--forest); color: #fff;
    box-shadow: 0 4px 10px rgba(0,61,45,.22);
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

/* In-Page Modal */
.p3m-modal .modal-content {
    border: none; border-radius: var(--r-xl);
    box-shadow: 0 28px 70px rgba(0,30,20,.18); overflow: hidden;
}
.p3m-modal .modal-header {
    padding: 24px 26px 20px; background: var(--surface);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: flex-start; gap: 14px;
}
.modal-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: var(--forest-soft); color: var(--forest); border: 1.5px solid #c2dece;
    display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;
}
.modal-icon.modal-icon-edit {
    background: #fdf8ec; color: var(--gold); border: 1.5px solid #fae8b4;
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

.form-field { margin-bottom: 18px; }
.form-field:last-child { margin-bottom: 0; }
.form-field label { display: block; font-size: 12.5px; font-weight: 800; color: var(--ink-2); margin-bottom: 7px; }
.form-field label .req { color: var(--danger); margin-left: 2px; }
.form-input-wrap { position: relative; }
.form-input-icon {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    color: var(--light); font-size: 14px; pointer-events: none;
}
.form-input {
    width: 100%; height: 44px; padding: 0 14px;
    border: 1.5px solid var(--border-2); border-radius: var(--r-md);
    font-size: 13.5px; color: var(--ink); background: var(--surface);
    outline: none; transition: all .18s ease; font-family: inherit;
}
.form-input.has-icon { padding-left: 40px; }
.form-input::placeholder { color: var(--light); }
.form-input:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.1);
}
.form-hint { display: block; margin-top: 6px; font-size: 12px; color: var(--muted); }

.modal-errors {
    display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px;
    background: #fef2f2; border: 1px solid #fecaca; border-radius: var(--r-md);
    color: #b91c1c; font-size: 12.5px; margin-bottom: 18px;
}
.modal-errors ul { margin: 4px 0 0; padding-left: 18px; }
.modal-errors li { margin-bottom: 2px; }

.p3m-modal .modal-footer {
    padding: 16px 26px 20px; background: var(--surface-alt);
    border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px;
}
.btn-modal-cancel {
    height: 40px; padding: 0 18px; border-radius: var(--r-md);
    background: var(--surface); border: 1px solid var(--border-2);
    color: var(--tx); font-size: 13px; font-weight: 700; cursor: pointer; transition: all .15s;
}
.btn-modal-cancel:hover { background: var(--surface-hov); color: var(--ink); }
.btn-modal-submit {
    height: 40px; padding: 0 20px; border-radius: var(--r-md);
    background: var(--forest); border: none; color: #fff;
    font-size: 13px; font-weight: 700; cursor: pointer; transition: all .18s;
    box-shadow: 0 4px 14px rgba(0,61,45,.22); display: inline-flex; align-items: center; gap: 8px;
}
.btn-modal-submit:hover {
    background: var(--forest-deep); transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(0,46,34,.28);
}

/* Empty State */
.empty-state {
    padding: 56px 20px; text-align: center;
}
.empty-state-icon {
    width: 68px; height: 68px; border-radius: 50%;
    background: var(--forest-soft); color: var(--forest-mid);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 28px; margin-bottom: 18px; border: 2px solid #c2dece;
}
.empty-state h3 { font-size: 17px; font-weight: 800; color: var(--ink); margin: 0 0 6px; }
.empty-state p { font-size: 13.5px; color: var(--muted); margin: 0 0 20px; max-width: 380px; margin-inline: auto; }

/* Responsive */
@media (max-width: 767.98px) {
    .page-users .content-header { padding: 20px 16px 0; }
    .page-users section.content { padding: 14px 16px 28px; }
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
    {{-- Breadcrumb Header --}}
    <div class="content-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Seputar P3M</li>
            <li class="breadcrumb-item active">{{ $pagetitle }}</li>
        </ol>
    </div>

    {{-- Main Section --}}
    <section class="content">
        <div class="users-card">
            {{-- Card Header --}}
            <div class="users-card-head">
                <div>
                    <span class="card-eyebrow">Seputar P3M</span>
                    <h1 class="card-head-title">Jurnal P3M</h1>
                    <p class="card-head-sub">Kelola indeks publikasi ilmiah dan tautan jurnal penelitian atau pengabdian civitas akademika.</p>
                </div>
                <div class="card-head-actions">
                    <div class="stat-chip">
                        <i class="fas fa-book-open"></i>
                        Total {{ count($jurnal) }} jurnal
                    </div>
                    <button type="button" class="btn-add-user" data-toggle="modal" data-target="#createJurnalModal">
                        <i class="fas fa-plus"></i> Tambah Jurnal
                    </button>
                </div>
            </div>

            {{-- Table Toolbar --}}
            <div class="table-toolbar">
                <div class="toolbar-left">
                    <span>Tampilkan</span>
                    <select class="toolbar-select" id="pageLengthSelect">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>data</span>
                </div>
                <div class="search-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="tableSearch" placeholder="Cari judul atau tautan jurnal...">
                </div>
            </div>

            {{-- Table --}}
            <div class="users-table-wrap">
                <table class="table users-table" id="jurnalTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="44%">Informasi Jurnal</th>
                            <th width="22%">Tautan Jurnal / Platform</th>
                            <th width="14%">Tanggal Ditambahkan</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jurnal as $d)
                            @php
                                $parsedHost = parse_url($d->link, PHP_URL_HOST);
                                $displayHost = $parsedHost ? preg_replace('/^www\./', '', $parsedHost) : 'Tautan Eksternal';
                            @endphp
                            <tr>
                                <td class="row-num">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="jurnal-main-cell">
                                        <span class="jurnal-icon">
                                            <i class="fas fa-book-reader"></i>
                                        </span>
                                        <div>
                                            <span class="jurnal-title">{{ $d->jurnalname }}</span>
                                            <span class="jurnal-subtitle">
                                                <i class="fas fa-university text-muted"></i>
                                                Publikasi Ilmiah P3M Polibang
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ $d->link }}" target="_blank" rel="noopener noreferrer" class="platform-pill" title="{{ $d->link }}">
                                        <i class="fas fa-external-link-alt"></i>
                                        <span>{{ $displayHost }}</span>
                                    </a>
                                </td>
                                <td>
                                    <span class="date-pill">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $d->created_at ? $d->created_at->format('d M Y') : '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-wrap">
                                        <a href="{{ $d->link }}" class="btn-icon btn-icon-link" title="Buka Tautan Jurnal" target="_blank" rel="noopener noreferrer">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <button type="button" class="btn-icon btn-icon-edit" title="Edit Jurnal" data-toggle="modal" data-target="#editJurnalModal{{ $d->id }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <form action="{{ route('jurnal.delete', ['id' => $d->id]) }}" method="POST" class="d-inline" id="del-jurnal-{{ $d->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-icon btn-icon-del"
                                                title="Hapus Jurnal"
                                                data-p3m-delete
                                                data-type="Jurnal"
                                                data-label="{{ Str::limit($d->jurnalname ?? 'Jurnal', 40) }}"
                                                data-form-id="del-jurnal-{{ $d->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- Handled by DataTables emptyTable --}}
                        @endforelse
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

{{-- Create Jurnal Modal --}}
<div class="modal fade p3m-modal" id="createJurnalModal" tabindex="-1" role="dialog" aria-labelledby="createJurnalModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('jurnal.store') }}" method="POST" class="modal-content" id="createJurnalForm">
            @csrf

            <div class="modal-header">
                <div class="modal-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="modal-head-text">
                    <h5 id="createJurnalModalLabel">Tambah Jurnal P3M</h5>
                    <p>Publikasikan tautan jurnal ilmiah baru ke dalam indeks portal P3M.</p>
                </div>
                <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
            </div>

            <div class="modal-body">
                @if (session('form_context') === 'create_jurnal' && $errors->any())
                <div class="modal-errors">
                    <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
                    <div>
                        <strong>Terdapat kesalahan pengisian:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="form-field">
                    <label for="createJurnalName">Judul Jurnal <span class="req">*</span></label>
                    <input type="text" name="jurnalname" id="createJurnalName" class="form-input"
                           placeholder="Contoh: Implementasi Metode Prototype pada Pembuatan Website..."
                           value="{{ old('jurnalname') }}" required>
                    <span class="form-hint">Tuliskan judul lengkap karya ilmiah atau artikel jurnal.</span>
                </div>

                <div class="form-field mb-0">
                    <label for="createJurnalLink">Tautan / URL Jurnal <span class="req">*</span></label>
                    <div class="form-input-wrap">
                        <i class="fas fa-link form-input-icon"></i>
                        <input type="url" name="link" id="createJurnalLink" class="form-input has-icon"
                               placeholder="https://scholar.google.com/..."
                               value="{{ old('link') }}" required>
                    </div>
                    <span class="form-hint">Dapat berupa tautan Google Scholar, SINTA, Scopus, DOAJ, atau OJS resmi.</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-submit" id="btnSubmitCreateJurnal">
                    <i class="fas fa-save"></i> Simpan Jurnal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Jurnal Modals --}}
@foreach ($jurnal as $d)
<div class="modal fade p3m-modal" id="editJurnalModal{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="editJurnalModalLabel{{ $d->id }}" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('jurnal.update', ['id' => $d->id]) }}" method="POST" class="modal-content" id="editJurnalForm{{ $d->id }}">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <div class="modal-icon modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <div class="modal-head-text">
                    <h5 id="editJurnalModalLabel{{ $d->id }}">Edit Jurnal P3M</h5>
                    <p>Perbarui judul publikasi atau tautan web jurnal ilmiah.</p>
                </div>
                <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
            </div>

            <div class="modal-body">
                @if (session('form_context') === 'edit_jurnal_' . $d->id && $errors->any())
                <div class="modal-errors">
                    <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
                    <div>
                        <strong>Terdapat kesalahan pengisian:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="form-field">
                    <label for="editJurnalName{{ $d->id }}">Judul Jurnal <span class="req">*</span></label>
                    <input type="text" name="jurnalname" id="editJurnalName{{ $d->id }}" class="form-input"
                           value="{{ old('jurnalname', $d->jurnalname) }}" required>
                </div>

                <div class="form-field mb-0">
                    <label for="editJurnalLink{{ $d->id }}">Tautan / URL Jurnal <span class="req">*</span></label>
                    <div class="form-input-wrap">
                        <i class="fas fa-link form-input-icon"></i>
                        <input type="url" name="link" id="editJurnalLink{{ $d->id }}" class="form-input has-icon"
                               value="{{ old('link', $d->link) }}" required>
                    </div>
                    <span class="form-hint">Pastikan tautan aktif dan dapat diakses publik.</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-submit" id="btnSubmitEditJurnal{{ $d->id }}">
                    <i class="fas fa-save"></i> Perbarui Jurnal
                </button>
            </div>
        </form>
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
$(function () {
    var table = $('#jurnalTable').DataTable({
        responsive: true,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Cari judul atau tautan jurnal...",
            info: "Menampilkan _START_-_END_ dari _TOTAL_ data",
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next:     '<i class="fas fa-chevron-right"></i>'
            },
            emptyTable: "Belum ada data jurnal yang dipublikasikan",
            zeroRecords: "Tidak ada jurnal yang sesuai dengan pencarian"
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
        }
    });

    $('#tableSearch').on('keyup', function () { table.search(this.value).draw(); });
    $('#pageLengthSelect').on('change', function () { table.page.len(+this.value).draw(); });

    // Auto-reopen modal if validation errors occurred in session
    @if (session('form_context') === 'create_jurnal')
    $('#createJurnalModal').modal('show');
    @elseif (str_starts_with(session('form_context') ?? '', 'edit_jurnal_'))
    $('#editJurnalModal{{ str_replace('edit_jurnal_', '', session('form_context')) }}').modal('show');
    @endif
});
</script>
@endsection
