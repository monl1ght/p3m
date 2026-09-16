@extends('layout.main')

@section('body_class', 'page-users')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
/* ================================================================
   P3M — Panduan Page — Premium SaaS Redesign
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
    color: var(--muted); font-size: 13.5px; line-height: 1.65; margin: 0; max-width: 480px;
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
    width: 240px; height: 36px; padding: 0 14px 0 36px;
    border: 1px solid var(--border-2); border-radius: var(--r-sm);
    font-size: 13px; font-weight: 500; color: var(--ink);
    background: var(--surface); outline: none; transition: all .18s ease;
}
.search-input::placeholder { color: var(--light); }
.search-input:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.1); width: 280px;
}

/* Table */
.users-table-wrap { overflow-x: auto; }
table.users-table { width: 100% !important; margin: 0 !important; border-collapse: collapse !important; }

.users-table thead th {
    padding: 13px 20px; background: var(--surface-alt);
    border-bottom: 1px solid var(--border) !important; border-top: none;
    font-size: 11px; font-weight: 800; text-transform: uppercase;
    letter-spacing: .08em; color: var(--muted); white-space: nowrap;
}
.users-table thead th:first-child { padding-left: 32px; text-align: left !important; }
.users-table thead th:last-child  { padding-right: 32px; }

.users-table tbody td {
    padding: 16px 20px; vertical-align: middle;
    border-bottom: 1px solid var(--border); font-size: 14px; color: var(--tx);
    transition: background .15s ease;
}
.users-table tbody td:first-child { padding-left: 32px; text-align: left !important; }
.users-table tbody td:last-child  { padding-right: 32px; vertical-align: middle; }
.users-table tbody tr:last-child td { border-bottom: none; }
.users-table tbody tr:hover td { background: var(--surface-alt); }

.row-num { font-size: 13px; font-variant-numeric: tabular-nums; color: var(--light); font-weight: 600; }

.agenda-main-cell { display: flex; align-items: center; gap: 14px; }
.agenda-icon {
    width: 44px; height: 44px; border-radius: var(--r-md); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 18px; margin-top: 0;
    transition: transform .18s ease;
}
.agenda-icon.pdf {
    background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;
}
.agenda-icon.docx {
    background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;
}
.agenda-icon.other {
    background: var(--surface-alt); color: var(--forest); border: 1px solid var(--border-2);
}
.agenda-title { display: block; font-size: 14px; font-weight: 800; color: var(--ink); line-height: 1.35; margin-bottom: 4px; }
.agenda-subtitle { display: block; color: var(--muted); font-size: 12.5px; font-weight: 600; line-height: 1.4; word-break: break-all; }

/* Slug & Metadata Badges matching Category page */
.slug-badge {
    display: inline-flex; align-items: center; gap: 7px; padding: 6px 14px;
    border-radius: 99px; background: var(--surface-alt); border: 1px solid var(--border-2);
    color: var(--tx); font-size: 12.5px; font-weight: 600; white-space: nowrap;
    transition: all .18s ease;
}
.slug-badge i { font-size: 12px; }
.slug-badge.slug-pdf {
    background: #fff5f5; border-color: #fed7d7; color: #991b1b;
}
.slug-badge.slug-pdf i { color: #dc2626; }
.slug-badge.slug-docx {
    background: #f0f7ff; border-color: #cce4ff; color: #1e40af;
}
.slug-badge.slug-docx i { color: #2563eb; }
.slug-badge.slug-date {
    background: var(--surface-alt); border-color: var(--border-2); color: var(--tx);
}
.slug-badge.slug-date i { color: var(--forest-mid); }
.slug-badge.slug-size {
    background: var(--surface-alt); border-color: var(--border-2); color: var(--muted); font-variant-numeric: tabular-nums;
}
.slug-badge.slug-size i { color: var(--light); }

/* Action Buttons */
.action-wrap { display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-icon {
    width: 34px !important; height: 34px !important; display: inline-flex !important;
    align-items: center !important; justify-content: center !important;
    border: 1.5px solid transparent !important; border-radius: var(--r-sm) !important;
    font-size: 13px !important; cursor: pointer !important; transition: all .18s ease !important;
    background: transparent; padding: 0 !important; text-decoration: none !important;
    line-height: 1 !important; flex-shrink: 0 !important;
}
.btn-icon-view {
    background: var(--info-soft) !important; color: var(--info) !important; border-color: #bae6fd !important;
}
.btn-icon-view:hover {
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
.btn-icon-download, .btn-icon-down {
    background: var(--gold-soft) !important; color: #8d701e !important; border-color: #f3e5b8 !important;
}
.btn-icon-download:hover, .btn-icon-down:hover {
    background: var(--gold) !important; color: #fff !important; border-color: var(--gold) !important;
    transform: translateY(-1px); box-shadow: 0 4px 12px rgba(185,152,53,.25);
}
.btn-icon-del {
    background: var(--danger-soft) !important; color: var(--danger) !important; border-color: #f5c0c0 !important;
}
.btn-icon-del:hover {
    background: var(--danger) !important; color: #fff !important; border-color: var(--danger) !important;
    transform: translateY(-1px); box-shadow: 0 4px 12px rgba(217,75,75,.22);
}
.modal-icon-edit {
    background: var(--forest-soft); color: var(--forest); border: 1.5px solid #c2dece;
}

/* Remove Bootstrap grid padding from DataTables wrapper to fix table alignment */
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

/* Modal */
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
    background: var(--forest-soft); color: var(--forest);
    display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;
}
.modal-icon.modal-icon-pdf {
    background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;
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
.form-input {
    width: 100%; height: 42px; padding: 0 14px;
    border: 1.5px solid var(--border-2); border-radius: var(--r-md);
    font-size: 13.5px; color: var(--ink); background: var(--surface);
    outline: none; transition: all .18s ease; font-family: inherit;
}
.form-input::placeholder { color: var(--light); }
.form-input:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.1);
}

.modal-errors {
    display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px;
    background: #fef2f2; border: 1px solid #fecaca; border-radius: var(--r-md);
    color: #b91c1c; font-size: 12.5px; margin-bottom: 18px;
}
.modal-errors ul { margin: 4px 0 0; padding-left: 18px; }
.modal-errors li { margin-bottom: 2px; }

/* Interactive Dropzone */
.panduan-dropzone {
    border: 2px dashed var(--border-2); border-radius: var(--r-lg);
    background: var(--surface-alt); padding: 24px 20px; text-align: center;
    cursor: pointer; transition: all .2s ease; user-select: none;
}
.panduan-dropzone:hover, .panduan-dropzone.drag-over {
    border-color: var(--forest-mid); background: var(--forest-soft);
}
.dropzone-icon {
    width: 52px; height: 52px; border-radius: 50%;
    background: #ffffff; color: var(--forest);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 22px; box-shadow: 0 4px 14px rgba(0,0,0,.06); margin-bottom: 12px;
}
.dropzone-main-text {
    display: block; font-size: 13.5px; font-weight: 700; color: var(--ink); margin-bottom: 4px;
}
.dropzone-sub-text {
    display: block; font-size: 12px; color: var(--muted);
}

/* File Selected Chip */
.file-chip {
    display: flex; align-items: center; gap: 14px; padding: 12px 16px;
    background: #ffffff; border: 1.5px solid var(--border); border-radius: var(--r-md);
    text-align: left; box-shadow: 0 4px 12px rgba(0,0,0,.04);
}
.file-chip-icon {
    width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 20px;
}
.file-chip-icon.pdf { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.file-chip-icon.docx { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
.file-chip-info { flex: 1; min-width: 0; }
.file-chip-name {
    font-size: 13.5px; font-weight: 700; color: var(--ink);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.file-chip-meta {
    font-size: 12px; color: var(--muted); font-weight: 600; margin-top: 2px;
    display: flex; align-items: center; gap: 6px;
}
.file-chip-remove {
    background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;
    width: 32px; height: 32px; border-radius: 8px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; font-size: 13px;
    margin-left: auto; transition: all .15s; flex-shrink: 0;
}
.file-chip-remove:hover { background: #fee2e2; color: #b91c1c; }

.field-error {
    color: var(--danger); font-size: 12px; font-weight: 600; margin-top: 6px;
    display: flex; align-items: center; gap: 5px;
}

.p3m-modal .modal-footer {
    padding: 16px 26px; background: var(--surface-alt); border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: flex-end; gap: 10px;
}
.btn-modal-cancel {
    display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px;
    background: var(--surface); border: 1.5px solid var(--border-2); border-radius: var(--r-md);
    font-size: 13px; font-weight: 700; color: var(--tx); cursor: pointer; transition: all .18s;
}
.btn-modal-cancel:hover { background: var(--surface-hov); }
.btn-modal-submit {
    display: inline-flex; align-items: center; gap: 7px; padding: 9px 20px;
    background: var(--forest); border: none; border-radius: var(--r-md);
    font-size: 13px; font-weight: 700; color: #fff; cursor: pointer;
    transition: all .18s; box-shadow: 0 6px 16px rgba(0,61,45,.22);
}
.btn-modal-submit:hover { background: var(--forest-deep); transform: translateY(-1px); }
.btn-modal-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
</style>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $pagetitle }}</li>
        </ol>
    </div>

    <section class="content">
        <div class="users-card">
            {{-- Card Header --}}
            <div class="users-card-head">
                <div>
                    <span class="card-eyebrow">Dokumen Panduan</span>
                    <h1 class="card-head-title">Panduan P3M</h1>
                </div>
                <div class="card-head-actions">
                    <div class="stat-chip">
                        <i class="fas fa-file-pdf"></i>
                        Total {{ count($pands) }} panduan
                    </div>
                    <button type="button" class="btn-add-user" data-toggle="modal" data-target="#createPanduanModal">
                        <i class="fas fa-plus"></i> Tambah Panduan
                    </button>
                </div>
            </div>

            {{-- Toolbar --}}
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
                    <input type="text" class="search-input" id="tableSearch" placeholder="Cari nama panduan...">
                </div>
            </div>

            {{-- Table --}}
            <div class="users-table-wrap">
                <table class="table users-table" id="panduanTable">
                    <thead>
                        <tr>
                            <th width="4%">No</th>
                            <th width="36%">Dokumen Panduan</th>
                            <th width="16%">Tanggal Unggah</th>
                            <th width="13%">Format File</th>
                            <th width="13%">Ukuran File</th>
                            <th width="18%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pands as $d)
                        @php
                            $ext = strtolower(pathinfo($d->original_name ?? $d->generated_name ?? '', PATHINFO_EXTENSION));
                            $isPdf = in_array($ext, ['pdf', '']);
                            $isDocx = in_array($ext, ['docx', 'doc']);
                            $panBase = basename($d->original_name ?? $d->generated_name ?? '');
                            $storagePath = \Illuminate\Support\Facades\Storage::disk('public')->path('panduan/' . $panBase);
                            $legacyPath = public_path('uplouds' . DIRECTORY_SEPARATOR . $panBase);
                            $filePath = (is_file($storagePath)) ? $storagePath : ((is_file($legacyPath)) ? $legacyPath : null);
                            $fileSize = ($filePath && file_exists($filePath)) ? filesize($filePath) : null;
                            if ($fileSize) {
                                if ($fileSize < 1048576) {
                                    $sizeLabel = round($fileSize / 1024, 1) . ' KB';
                                } else {
                                    $sizeLabel = round($fileSize / 1048576, 2) . ' MB';
                                }
                            } else {
                                $sizeLabel = '-';
                            }
                            $dateFormatted = $d->created_at ? $d->created_at->format('d M Y') : '-';
                        @endphp
                        <tr>
                            <td class="row-num">{{ $loop->iteration }}</td>
                            <td>
                                <div class="agenda-main-cell">
                                    <span class="agenda-icon {{ $isPdf ? 'pdf' : ($isDocx ? 'docx' : 'other') }}">
                                        <i class="fas {{ $isPdf ? 'fa-file-pdf' : ($isDocx ? 'fa-file-word' : 'fa-file-alt') }}"></i>
                                    </span>
                                    <div>
                                        <span class="agenda-title">{{ $d->namefile }}</span>
                                        <span class="agenda-subtitle">{{ $d->original_name ?? $d->generated_name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="slug-badge slug-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $dateFormatted }}
                                </span>
                            </td>
                            <td>
                                <span class="slug-badge {{ $isPdf ? 'slug-pdf' : ($isDocx ? 'slug-docx' : '') }}">
                                    <i class="fas {{ $isPdf ? 'fa-file-pdf' : ($isDocx ? 'fa-file-word' : 'fa-file-alt') }}"></i>
                                    {{ strtoupper($ext ?: 'PDF') }}
                                </span>
                            </td>
                            <td>
                                <span class="slug-badge slug-size">
                                    <i class="fas fa-hdd"></i>
                                    {{ $sizeLabel }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-wrap">
                                    <a href="{{ route('panduan.view', ['id' => $d->id]) }}" class="btn-icon btn-icon-view" title="Lihat Panduan">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn-icon btn-icon-edit" data-toggle="modal" data-target="#editPanduanModal{{ $d->id }}" title="Edit Panduan">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <a href="{{ route('panduan.download', $d->id) }}" class="btn-icon btn-icon-download" title="Unduh File" download>
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <form action="{{ route('panduan.delete', ['id' => $d->id]) }}" method="POST" class="d-inline" id="del-panduan-{{ $d->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-icon btn-icon-del"
                                            title="Hapus Panduan"
                                            data-p3m-delete
                                            data-type="Panduan"
                                            data-label="{{ Str::limit($d->namefile ?? 'Panduan', 40) }}"
                                            data-form-id="del-panduan-{{ $d->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            <div class="table-footer">
                <span class="table-info-text" id="tableInfo"></span>
                <div id="tablePagination"></div>
            </div>

        </div>
    </section>
</div>

@foreach ($pands as $d)
{{-- Edit Panduan Modal #{{ $d->id }} --}}
<div class="modal fade p3m-modal" id="editPanduanModal{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="editPanduanLabel{{ $d->id }}" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('panduan.update', $d->id) }}" method="POST" enctype="multipart/form-data" class="modal-content" id="editPanduanForm{{ $d->id }}">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <div class="modal-icon modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <div class="modal-head-text">
                    <h5 id="editPanduanLabel{{ $d->id }}">Edit Dokumen Panduan</h5>
                    <p>Perbarui nama panduan atau ganti file dokumen resmi.</p>
                </div>
                <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
            </div>

            <div class="modal-body">
                @if (session('form_context') === 'edit_panduan_' . $d->id && $errors->any())
                <div class="modal-errors">
                    <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
                    <div>
                        <strong>Terdapat kesalahan:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="form-field">
                    <label for="editName{{ $d->id }}">Nama / Judul Panduan <span class="req">*</span></label>
                    <input type="text" name="namefile" id="editName{{ $d->id }}" class="form-input"
                           value="{{ old('namefile', $d->namefile) }}" required>
                </div>

                <div class="form-field mb-0">
                    <label for="editFile{{ $d->id }}">Ganti File Dokumen <span style="font-size:12px; font-weight:500; color:var(--muted);">(Opsional)</span></label>
                    <input type="file" name="original_name" id="editFile{{ $d->id }}" class="form-input" style="padding: 9px 12px;"
                           accept=".pdf,.docx,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                    <span class="dropzone-sub-text mt-2" style="font-size: 12px; color: var(--muted); line-height: 1.5;">
                        Mendukung format <strong>PDF</strong> atau <strong>DOCX</strong> &bull; Maksimal 5 MB.<br>
                        File saat ini: <strong style="color:var(--ink);">{{ $d->original_name ?? $d->generated_name }}</strong>
                    </span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-submit">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- Create Panduan Modal --}}
<div class="modal fade p3m-modal" id="createPanduanModal" tabindex="-1" role="dialog" aria-labelledby="createPanduanModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('panduan.store') }}" method="POST" enctype="multipart/form-data" class="modal-content" id="createPanduanForm">
            @csrf

            <div class="modal-header">
                <div class="modal-icon modal-icon-pdf">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div class="modal-head-text">
                    <h5 id="createPanduanModalLabel">Tambah Panduan P3M</h5>
                    <p>Unggah dokumen panduan resmi dalam format PDF atau DOCX.</p>
                </div>
                <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
            </div>

            <div class="modal-body">
                @if (session('form_context') === 'create_panduan' && $errors->any())
                <div class="modal-errors">
                    <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
                    <div>
                        <strong>Terdapat kesalahan:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="form-field">
                    <label for="modalNamefile">Nama / Judul Panduan <span class="req">*</span></label>
                    <input type="text" name="namefile" id="modalNamefile" class="form-input"
                           placeholder="Contoh: Panduan Pengajuan Hibah Penelitian 2026"
                           value="{{ old('namefile') }}" required>
                    <div class="field-error" id="namefileError" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i> Nama panduan wajib diisi.
                    </div>
                </div>

                <div class="form-field mb-0">
                    <label>File Dokumen <span class="req">*</span></label>

                    {{-- Interactive Drag & Drop Upload Zone --}}
                    <div class="panduan-dropzone" id="panduanDropzone">
                        <input type="file" name="original_name" id="panduanFileInput"
                               accept=".pdf,.docx,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                               style="display:none;" required>

                        <div class="dropzone-idle" id="dropzoneIdle">
                            <div class="dropzone-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="dropzone-text">
                                <span class="dropzone-main-text">Klik untuk memilih atau seret &amp; lepas file ke sini</span>
                                <span class="dropzone-sub-text">Mendukung format <strong>PDF</strong> atau <strong>DOCX</strong> &bull; Maksimal 5 MB</span>
                            </div>
                        </div>

                        <div class="dropzone-selected" id="dropzoneSelected" style="display: none;">
                            <div class="file-chip">
                                <div class="file-chip-icon pdf" id="fileChipIcon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="file-chip-info">
                                    <div class="file-chip-name" id="fileChipName">-</div>
                                    <div class="file-chip-meta" id="fileChipMeta">-</div>
                                </div>
                                <button type="button" class="file-chip-remove" id="fileChipRemove" title="Hapus file">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="field-error" id="fileError" style="display:none;"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-submit" id="btnSubmitPanduan">
                    <i class="fas fa-upload"></i> Unggah Panduan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
$(function () {
    var table = $('#panduanTable').DataTable({
        responsive: true,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Cari nama panduan...",
            info: "Menampilkan _START_-_END_ dari _TOTAL_ data",
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next:     '<i class="fas fa-chevron-right"></i>'
            },
            emptyTable: "Belum ada data panduan",
            zeroRecords: "Tidak ada yang cocok dengan pencarian"
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

    @if (session('form_context') === 'create_panduan')
    $('#createPanduanModal').modal('show');
    @elseif (str_starts_with(session('form_context') ?? '', 'edit_panduan_'))
    $('#editPanduanModal{{ str_replace('edit_panduan_', '', session('form_context')) }}').modal('show');
    @endif

    // Dropzone & File Input Handler
    var dropzone = document.getElementById('panduanDropzone');
    var fileInput = document.getElementById('panduanFileInput');
    var idleState = document.getElementById('dropzoneIdle');
    var selectedState = document.getElementById('dropzoneSelected');
    var chipName = document.getElementById('fileChipName');
    var chipMeta = document.getElementById('fileChipMeta');
    var chipIcon = document.getElementById('fileChipIcon');
    var chipRemove = document.getElementById('fileChipRemove');
    var fileError = document.getElementById('fileError');
    var form = document.getElementById('createPanduanForm');
    var btnSubmit = document.getElementById('btnSubmitPanduan');
    var MAX_FILE_SIZE = 5 * 1024 * 1024; // 5 MB

    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(2) + ' MB';
    }

    function handleFile(file) {
        if (!file) return;

        var ext = file.name.split('.').pop().toLowerCase();
        if (ext !== 'pdf' && ext !== 'docx') {
            fileError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Format file tidak didukung. Harap pilih file PDF atau DOCX.';
            fileError.style.display = 'flex';
            resetFile();
            return;
        }

        if (file.size > MAX_FILE_SIZE) {
            fileError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Ukuran file melebihi 5 MB (' + formatFileSize(file.size) + '). Silakan pilih file yang tidak melebihi 5 MB.';
            fileError.style.display = 'flex';
            resetFile();
            return;
        }

        fileError.style.display = 'none';
        fileError.innerHTML = '';

        chipName.textContent = file.name;
        chipMeta.innerHTML = '<span>' + formatFileSize(file.size) + '</span> &bull; <span style="text-transform: uppercase; font-weight:700; color:' + (ext === 'pdf' ? '#dc2626' : '#2563eb') + ';">' + ext + '</span>';

        if (ext === 'pdf') {
            chipIcon.className = 'file-chip-icon pdf';
            chipIcon.innerHTML = '<i class="fas fa-file-pdf"></i>';
        } else {
            chipIcon.className = 'file-chip-icon docx';
            chipIcon.innerHTML = '<i class="fas fa-file-word"></i>';
        }

        idleState.style.display = 'none';
        selectedState.style.display = 'block';

        var nameInput = document.getElementById('modalNamefile');
        if (nameInput && !nameInput.value.trim()) {
            var rawName = file.name.replace(/\.[^/.]+$/, "");
            nameInput.value = rawName.charAt(0).toUpperCase() + rawName.slice(1);
        }
    }

    function resetFile() {
        if (fileInput) fileInput.value = '';
        if (idleState) idleState.style.display = 'block';
        if (selectedState) selectedState.style.display = 'none';
    }

    if (dropzone && fileInput) {
        dropzone.addEventListener('click', function(e) {
            if (e.target.closest('#fileChipRemove')) return;
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                handleFile(this.files[0]);
            }
        });

        if (chipRemove) {
            chipRemove.addEventListener('click', function(e) {
                e.stopPropagation();
                resetFile();
            });
        }

        ['dragenter', 'dragover'].forEach(function(evt) {
            dropzone.addEventListener(evt, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('drag-over');
            });
        });

        ['dragleave', 'drop'].forEach(function(evt) {
            dropzone.addEventListener(evt, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('drag-over');
            });
        });

        dropzone.addEventListener('drop', function(e) {
            var dt = e.dataTransfer;
            if (dt && dt.files && dt.files[0]) {
                fileInput.files = dt.files;
                handleFile(dt.files[0]);
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            if (!fileInput.files || !fileInput.files[0]) {
                e.preventDefault();
                fileError.innerHTML = '<i class="fas fa-exclamation-circle"></i> File dokumen panduan wajib dipilih.';
                fileError.style.display = 'flex';
                return false;
            }
            if (fileInput.files[0].size > MAX_FILE_SIZE) {
                e.preventDefault();
                fileError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Ukuran file melebihi 5 MB (' + formatFileSize(fileInput.files[0].size) + '). Silakan pilih file yang tidak melebihi 5 MB.';
                fileError.style.display = 'flex';
                return false;
            }
            if (btnSubmit) {
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengunggah...';
            }
            return true;
        });
    }

    $('#createPanduanModal').on('hidden.bs.modal', function () {
        resetFile();
        var nameInput = document.getElementById('modalNamefile');
        if (nameInput) nameInput.value = '';
        if (fileError) {
            fileError.style.display = 'none';
            fileError.innerHTML = '';
        }
        if (btnSubmit) {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="fas fa-upload"></i> Unggah Panduan';
        }
    });
});
</script>
@endsection
