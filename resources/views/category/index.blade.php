@extends('layout.main')

@section('body_class', 'page-users')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
/* ================================================================
   P3M — Category Page — Premium SaaS Redesign
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

/* Alert Styles */
.agenda-alert {
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;
    border-radius: var(--r-md); padding: 14px 20px; font-weight: 600; font-size: 14px;
    margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;
}
.agenda-alert .close { color: #166534; opacity: .8; background: none; border: none; font-size: 20px; cursor: pointer; padding: 0; line-height: 1; }

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
    padding: 16px 20px; vertical-align: top;
    border-bottom: 1px solid var(--border); font-size: 14px; color: var(--tx);
    transition: background .15s ease;
}
.users-table tbody td:first-child { padding-left: 32px; text-align: left !important; }
.users-table tbody td:last-child  { padding-right: 32px; vertical-align: middle; }
.users-table tbody tr:last-child td { border-bottom: none; }
.users-table tbody tr:hover td { background: var(--surface-alt); }

.row-num { font-size: 13px; font-variant-numeric: tabular-nums; color: var(--light); font-weight: 600; padding-top: 20px !important; }

.agenda-main-cell { display: flex; align-items: center; gap: 14px; }
.agenda-icon {
    width: 44px; height: 44px; border-radius: var(--r-md); flex-shrink: 0;
    background: var(--forest-soft); color: var(--forest); border: 1px solid #c2dece;
    display: flex; align-items: center; justify-content: center; font-size: 18px; margin-top: 2px;
}
.agenda-title { display: block; font-size: 14px; font-weight: 800; color: var(--ink); line-height: 1.35; margin-bottom: 4px; }
.agenda-subtitle { display: block; color: var(--muted); font-size: 12.5px; font-weight: 600; }

.action-wrap { display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-icon {
    width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
    border: 1.5px solid transparent; border-radius: var(--r-sm); font-size: 13px;
    cursor: pointer; transition: all .18s ease; background: transparent; padding: 0;
    text-decoration: none !important; line-height: 1; flex-shrink: 0;
}
.btn-icon-edit { background: var(--forest-soft); color: var(--forest); border-color: #c2dece; }
.btn-icon-edit:hover { background: var(--forest); color: #fff; border-color: var(--forest); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,61,45,.22); }
.btn-icon-del { background: var(--danger-soft); color: var(--danger); border-color: #f5c0c0; }
.btn-icon-del:hover { background: var(--danger); color: #fff; border-color: var(--danger); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(217,75,75,.22); }

.slug-badge {
    display: inline-flex; align-items: center; gap: 7px; padding: 6px 14px;
    border-radius: 99px; background: var(--surface-alt); border: 1px solid var(--border-2);
    color: var(--tx); font-size: 12.5px; font-weight: 600; white-space: nowrap;
    transition: all .18s ease;
}
.slug-badge i { font-size: 12px; }
.slug-badge.slug-count {
    background: var(--surface-alt); border-color: var(--border-2); color: var(--tx);
}
.slug-badge.slug-count i { color: var(--forest-mid); }

/* Modal Styles */
.p3m-modal .modal-content {
    border: none; border-radius: var(--r-xl);
    box-shadow: 0 25px 60px rgba(0,0,0,.18);
    overflow: hidden;
}
.p3m-modal .modal-header {
    padding: 24px 28px 20px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, #ffffff 60%, #f0faf5 100%);
    display: flex; align-items: flex-start; gap: 14px;
    position: relative;
}
.p3m-modal .modal-icon {
    width: 44px; height: 44px; border-radius: var(--r-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.p3m-modal .modal-icon-cat {
    background: var(--forest-soft); color: var(--forest); border: 1.5px solid #c2dece;
}
.p3m-modal .modal-icon-edit {
    background: var(--forest-soft); color: var(--forest); border: 1.5px solid #c2dece;
}
.p3m-modal .modal-head-text h5 {
    font-family: "Plus Jakarta Sans", "Inter", sans-serif;
    font-size: 18px; font-weight: 800; color: var(--ink);
    margin: 0 0 4px; line-height: 1.25;
}
.p3m-modal .modal-head-text p {
    font-size: 13px; color: var(--muted); margin: 0; line-height: 1.5;
}
.p3m-modal .modal-close-btn {
    position: absolute; right: 20px; top: 20px;
    background: none; border: none; font-size: 24px; line-height: 1;
    color: var(--light); cursor: pointer; padding: 4px 8px; border-radius: 6px;
    transition: all .15s;
}
.p3m-modal .modal-close-btn:hover { color: var(--ink); background: var(--surface-alt); }
.p3m-modal .modal-body { padding: 24px 28px; }
.p3m-modal .form-field { margin-bottom: 18px; }
.p3m-modal .form-field:last-child { margin-bottom: 0; }
.p3m-modal .form-field label {
    display: block; font-size: 13px; font-weight: 700; color: var(--ink-2);
    margin-bottom: 7px;
}
.p3m-modal .form-field label .req { color: var(--danger); }
.p3m-modal .form-input {
    width: 100%; height: 42px; padding: 0 14px;
    border: 1.5px solid var(--border-2); border-radius: var(--r-sm);
    font-size: 13.5px; font-weight: 500; color: var(--ink);
    background: #fff; outline: none; transition: all .18s;
}
.p3m-modal .form-input:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3.5px rgba(0,87,59,.1);
}
.p3m-modal .form-hint {
    display: block; font-size: 12px; color: var(--muted); margin-top: 6px; font-weight: 500;
}
.p3m-modal .modal-errors {
    background: #fef2f2; border: 1px solid #fecaca; border-radius: var(--r-sm);
    padding: 12px 16px; margin-bottom: 18px; font-size: 13px; color: #991b1b;
    display: flex; align-items: flex-start; gap: 10px;
}
.p3m-modal .modal-errors ul { margin: 4px 0 0 16px; padding: 0; }
.p3m-modal .modal-errors li { margin-bottom: 2px; }
.p3m-modal .modal-footer {
    padding: 16px 28px; background: var(--surface-alt);
    border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: flex-end; gap: 10px;
}
.btn-modal-cancel {
    padding: 9px 18px; border-radius: var(--r-sm);
    background: #fff; border: 1px solid var(--border-2);
    color: var(--muted); font-size: 13.5px; font-weight: 700;
    cursor: pointer; transition: all .18s;
}
.btn-modal-cancel:hover { background: var(--surface-hov); color: var(--ink); }
.btn-modal-submit {
    padding: 9px 22px; border-radius: var(--r-sm);
    background: var(--forest); border: 1px solid var(--forest);
    color: #fff; font-size: 13.5px; font-weight: 700;
    display: inline-flex; align-items: center; gap: 7px;
    cursor: pointer; transition: all .18s; box-shadow: 0 6px 16px rgba(0,61,45,.22);
}
.btn-modal-submit:hover { background: var(--forest-deep); transform: translateY(-1px); }
.btn-modal-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

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

/* Remove Bootstrap grid padding from DataTables wrapper to fix table alignment */
.dataTables_wrapper > .row { margin: 0 !important; }
.dataTables_wrapper > .row > [class*="col-"] { padding: 0 !important; }

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
                    <span class="card-eyebrow">Seputar P3M</span>
                    <h1 class="card-head-title">Kategori Berita</h1>
                </div>
                <div class="card-head-actions">
                    <div class="stat-chip">
                        <i class="fas fa-layer-group"></i>
                        Total {{ count($categories) }} kategori
                    </div>
                    <button type="button" class="btn-add-user" data-toggle="modal" data-target="#createCategoryModal">
                        <i class="fas fa-plus"></i> Tambah Kategori
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
                    <input type="text" class="search-input" id="tableSearch" placeholder="Cari nama kategori...">
                </div>
            </div>

            {{-- Table --}}
            <div class="users-table-wrap">
                <table class="table users-table" id="categoryTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="42%">Kategori</th>
                            <th width="24%">Slug</th>
                            <th width="15%">Total Berita</th>
                            <th width="14%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $d)
                            <tr>
                                <td class="row-num">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="agenda-main-cell">
                                        <span class="agenda-icon">
                                            <i class="fas fa-layer-group"></i>
                                        </span>
                                        <div>
                                            <span class="agenda-title">{{ $d->name }}</span>
                                            <span class="agenda-subtitle">Kategori Konten & Publikasi P3M</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="slug-badge">
                                        <i class="fas fa-link text-muted"></i>
                                        {{ $d->slug }}
                                    </span>
                                </td>
                                <td>
                                    <span class="slug-badge slug-count">
                                        <i class="fas fa-newspaper"></i>
                                        {{ $d->news_count ?? 0 }} Berita
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-wrap">
                                        <button type="button" class="btn-icon btn-icon-edit" data-toggle="modal" data-target="#editCategoryModal{{ $d->id }}" title="Edit Kategori">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <form action="{{ route('category.delete', ['id' => $d->id]) }}" method="POST" class="d-inline" id="del-category-{{ $d->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-icon btn-icon-del"
                                                title="Hapus Kategori"
                                                data-p3m-delete
                                                data-type="Kategori"
                                                data-label="{{ Str::limit($d->name, 40) }}"
                                                data-form-id="del-category-{{ $d->id }}">
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

{{-- Create Category Modal --}}
<div class="modal fade p3m-modal" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('category.store') }}" method="POST" class="modal-content" id="createCategoryForm">
            @csrf

            <div class="modal-header">
                <div class="modal-icon modal-icon-cat">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="modal-head-text">
                    <h5 id="createCategoryModalLabel">Tambah Kategori Berita</h5>
                    <p>Buat kategori baru untuk mengelompokkan kegiatan dan berita P3M.</p>
                </div>
                <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
            </div>

            <div class="modal-body">
                @if (session('form_context') === 'create_category' && $errors->any())
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
                    <label for="createCategoryName">Nama Kategori <span class="req">*</span></label>
                    <input type="text" name="name" id="createCategoryName" class="form-input"
                           placeholder="Contoh: Pengabdian Masyarakat"
                           value="{{ old('name') }}" required>
                </div>

                <div class="form-field mb-0">
                    <label for="createCategorySlug">Slug URL <span class="req">*</span></label>
                    <input type="text" name="slug" id="createCategorySlug" class="form-input"
                           placeholder="Contoh: pengabdian-masyarakat"
                           value="{{ old('slug') }}" required>
                    <span class="form-hint">Slug URL dibuat otomatis dari nama kategori dan dapat Anda sesuaikan.</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-submit" id="btnSubmitCategory">
                    <i class="fas fa-save"></i> Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>

@foreach ($categories as $d)
{{-- Edit Category Modal #{{ $d->id }} --}}
<div class="modal fade p3m-modal" id="editCategoryModal{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel{{ $d->id }}" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('category.ubah', ['id' => $d->id]) }}" method="POST" class="modal-content" id="editCategoryForm{{ $d->id }}">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <div class="modal-icon modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <div class="modal-head-text">
                    <h5 id="editCategoryLabel{{ $d->id }}">Edit Kategori Berita</h5>
                    <p>Perbarui nama kategori atau slug URL pengelompokan konten.</p>
                </div>
                <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
            </div>

            <div class="modal-body">
                @if (session('form_context') === 'edit_category_' . $d->id && $errors->any())
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
                    <label for="editCategoryName{{ $d->id }}">Nama Kategori <span class="req">*</span></label>
                    <input type="text" name="name" id="editCategoryName{{ $d->id }}" class="form-input"
                           value="{{ old('name', $d->name) }}" required>
                </div>

                <div class="form-field mb-0">
                    <label for="editCategorySlug{{ $d->id }}">Slug URL <span class="req">*</span></label>
                    <input type="text" name="slug" id="editCategorySlug{{ $d->id }}" class="form-input"
                           value="{{ old('slug', $d->slug) }}" required>
                    <span class="form-hint">Gunakan huruf kecil dan tanda hubung (-) untuk URL bersih.</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-submit" id="btnEditSubmitCategory{{ $d->id }}">
                    <i class="fas fa-save"></i> Simpan Perubahan
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
    var table = $('#categoryTable').DataTable({
        responsive: true,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Cari nama kategori...",
            info: "Menampilkan _START_-_END_ dari _TOTAL_ data",
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next:     '<i class="fas fa-chevron-right"></i>'
            },
            emptyTable: "Belum ada data kategori",
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

    // Auto-slug generator function
    function slugify(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }

    var createNameInput = document.getElementById('createCategoryName');
    var createSlugInput = document.getElementById('createCategorySlug');
    if (createNameInput && createSlugInput) {
        createNameInput.addEventListener('input', function () {
            createSlugInput.value = slugify(this.value);
        });
    }

    @foreach ($categories as $d)
    (function () {
        var nameInput = document.getElementById('editCategoryName{{ $d->id }}');
        var slugInput = document.getElementById('editCategorySlug{{ $d->id }}');
        if (nameInput && slugInput) {
            nameInput.addEventListener('input', function () {
                slugInput.value = slugify(this.value);
            });
        }
    })();
    @endforeach

    @if (session('form_context') === 'create_category')
    $('#createCategoryModal').modal('show');
    @elseif (str_starts_with(session('form_context') ?? '', 'edit_category_'))
    $('#editCategoryModal{{ str_replace('edit_category_', '', session('form_context')) }}').modal('show');
    @endif
});
</script>
@endsection
