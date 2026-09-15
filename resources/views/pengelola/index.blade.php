@extends('layout.main')

@section('body_class', 'page-users')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
/* ================================================================
   P3M — Data Pengelola Page — Premium SaaS Redesign
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
    padding: 10px 18px; background: var(--forest); color: #fff;
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
    padding: 14px 20px; vertical-align: middle;
    border-bottom: 1px solid var(--border); font-size: 14px; color: var(--tx);
    transition: background .15s ease;
}
.users-table tbody td:first-child { padding-left: 32px; text-align: left !important; }
.users-table tbody td:last-child  { padding-right: 32px; }
.users-table tbody tr:last-child td { border-bottom: none; }
.users-table tbody tr:hover td { background: var(--surface-alt); }

.row-num { font-size: 13px; font-variant-numeric: tabular-nums; color: var(--light); font-weight: 600; }

.user-cell { display: flex; align-items: center; gap: 13px; }
.u-avatar {
    width: 40px; height: 40px; border-radius: 12px; flex-shrink: 0;
    background: var(--forest-soft); display: flex; align-items: center; justify-content: center;
    font-size: 16px; font-weight: 800; color: var(--forest);
    border: 1.5px solid rgba(0,93,59,.12); overflow: hidden;
}
.u-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 10px; }
.u-name { display: block; font-size: 14px; font-weight: 800; color: var(--ink); letter-spacing: -.01em; line-height: 1.3; }
.u-email { display: block; font-size: 12.5px; color: var(--muted); margin-top: 2px; }

.nik-value { font-size: 13px; font-variant-numeric: tabular-nums; color: var(--tx); font-weight: 600;}
.nik-value.empty { color: var(--light); font-style: italic; }

.role-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 11px; border-radius: 99px; font-size: 12px; font-weight: 800;
}
.role-badge::before {
    content: ""; width: 6px; height: 6px; border-radius: 50%;
    background: currentColor; opacity: .6;
}
.badge-admin  { background: var(--gold-soft);    color: #7a6214; border: 1px solid #e8d68a; }
.badge-dosen  { background: var(--forest-soft);  color: var(--forest); border: 1px solid #b5ddc7; }
.badge-default{ background: #f3f4f6; color: #6b7280; border: 1px solid #e5e7eb; }

.action-wrap { display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-icon {
    width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
    border: 1.5px solid transparent; border-radius: var(--r-sm); font-size: 13px;
    cursor: pointer; transition: all .18s ease; background: transparent; padding: 0;
}
.btn-icon-edit { background: var(--forest-soft); color: var(--forest); border-color: #c2dece; }
.btn-icon-edit:hover {
    background: var(--forest); color: #fff; border-color: var(--forest);
    transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,61,45,.22);
}
.btn-icon-del { background: var(--danger-soft); color: var(--danger); border-color: #f5c0c0; }
.btn-icon-del:hover {
    background: var(--danger); color: #fff; border-color: var(--danger);
    transform: translateY(-1px); box-shadow: 0 4px 12px rgba(217,75,75,.22);
}

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

/* Hide DT default controls — NOT the table row itself */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate { display: none !important; }

/* Remove Bootstrap grid padding from DataTables wrapper to fix table alignment */
.dataTables_wrapper > .row { margin: 0 !important; }
.dataTables_wrapper > .row > [class*="col-"] { padding: 0 !important; }

/* Alert */
.alert-p3m {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px; border-radius: var(--r-lg); font-size: 14px; font-weight: 600;
    margin-bottom: 18px; border: 1px solid;
}
.alert-p3m.success { background: var(--forest-soft); color: var(--forest); border-color: #b5ddc7; }
.alert-p3m i { font-size: 15px; flex-shrink: 0; }
.alert-p3m .close-btn {
    margin-left: auto; background: none; border: none; color: currentColor;
    opacity: .7; cursor: pointer; font-size: 16px; padding: 0; line-height: 1;
}
.alert-p3m .close-btn:hover { opacity: 1; }

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
.modal-head-text { flex: 1; min-width: 0; }
.modal-head-text h5 { margin: 0 0 4px; font-size: 17px; font-weight: 800; color: var(--ink); letter-spacing: -.02em; }
.modal-head-text p  { margin: 0; font-size: 13px; color: var(--muted); line-height: 1.5; }
.modal-close-btn {
    background: none; border: none; color: var(--light); font-size: 18px;
    cursor: pointer; padding: 0; line-height: 1; margin-left: auto; flex-shrink: 0; transition: color .15s;
}
.modal-close-btn:hover { color: var(--ink); }

.p3m-modal .modal-body { padding: 22px 26px; background: var(--surface); }

.form-field { margin-bottom: 16px; }
.form-field:last-child { margin-bottom: 0; }
.form-field label { display: block; font-size: 12.5px; font-weight: 800; color: var(--ink-2); margin-bottom: 7px; }
.form-field label .req { color: var(--danger); margin-left: 2px; }
.form-input, .form-select {
    width: 100%; height: 40px; padding: 0 14px;
    border: 1.5px solid var(--border-2); border-radius: var(--r-md);
    font-size: 13.5px; color: var(--ink); background: var(--surface);
    outline: none; transition: all .18s ease; font-family: inherit;
}
.form-input::placeholder { color: var(--light); }
.form-input:focus, .form-select:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.1);
}
.form-input.file { height: auto; padding: 7px 12px; cursor: pointer; }
.form-hint { display: block; margin-top: 5px; font-size: 12px; color: var(--light); }

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
    display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px;
    background: var(--forest); border: none; border-radius: var(--r-md);
    font-size: 13px; font-weight: 700; color: #fff; cursor: pointer;
    transition: all .18s; box-shadow: 0 6px 16px rgba(0,61,45,.22);
}
.btn-modal-submit:hover { background: var(--forest-deep); transform: translateY(-1px); }

.modal-errors {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 14px; border-radius: var(--r-md);
    background: var(--danger-soft); border: 1px solid #f5c0c0;
    margin-bottom: 16px; font-size: 13px; color: var(--danger);
}
.modal-errors ul { margin: 6px 0 0; padding-left: 16px; }

/* ----------------------------------------------------------------
   Photo Picker — professional avatar upload widget
   ---------------------------------------------------------------- */
.pengelola-photo-picker {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 16px;
    background: var(--surface-alt);
    border: 1.5px dashed var(--border-2);
    border-radius: var(--r-lg);
    transition: border-color .18s, background .18s;
    cursor: pointer;
    position: relative;
}
.pengelola-photo-picker:hover {
    border-color: var(--forest-mid);
    background: var(--forest-soft);
}
.pengelola-avatar-preview {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    overflow: hidden;
    border: 2.5px solid var(--border-2);
    background: var(--surface);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: border-color .18s;
}
.pengelola-photo-picker:hover .pengelola-avatar-preview {
    border-color: var(--forest-mid);
}
.pengelola-avatar-preview img {
    width: 100%; height: 100%; object-fit: cover; border-radius: 50%;
}
.pengelola-avatar-placeholder {
    width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
    background: var(--forest-soft); color: var(--forest-mid); font-size: 22px;
}
.pengelola-photo-copy {
    flex: 1; min-width: 0;
}
.pengelola-photo-copy strong {
    display: block; font-size: 13.5px; font-weight: 700; color: var(--ink); margin-bottom: 3px;
}
.pengelola-photo-copy small {
    display: block; font-size: 11.5px; color: var(--muted); line-height: 1.5;
}
.pengelola-photo-btn {
    flex-shrink: 0;
    display: inline-flex; align-items: center; gap: 6px; padding: 7px 13px;
    background: var(--forest); color: #fff; border: none; border-radius: var(--r-md);
    font-size: 12px; font-weight: 700; cursor: pointer; transition: all .18s;
    box-shadow: 0 4px 10px rgba(0,61,45,.2);
    pointer-events: none; /* label handles click */
}
.pengelola-photo-picker:hover .pengelola-photo-btn {
    background: var(--forest-deep);
}
.pengelola-photo-input {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.pengelola-photo-name {
    margin-top: 6px; font-size: 11.5px; color: var(--forest-mid); font-weight: 600;
    display: none;
    align-items: center; gap: 5px;
}
.pengelola-photo-name.visible { display: flex; }
.pengelola-photo-name i { font-size: 12px; }

/* Multi-step Form */
.p3m-stepper {
    display: flex; align-items: center; justify-content: center; gap: 12px;
    padding: 16px 26px 12px; background: var(--surface); border-bottom: 1px solid var(--border);
}
.stepper-item {
    display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: var(--light);
    transition: color .2s;
}
.stepper-item.active { color: var(--forest); }
.stepper-item.completed { color: var(--forest); }
.stepper-icon {
    width: 20px; height: 20px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
    border: 2px solid currentColor; font-size: 10px; font-weight: 800;
}
.stepper-item.active .stepper-icon { background: var(--forest); color: #fff; border-color: var(--forest); }
.stepper-item.completed .stepper-icon { background: var(--forest); color: #fff; border-color: var(--forest); }
.stepper-line { width: 40px; height: 2px; background: var(--border-2); border-radius: 2px; }

.step-pane { display: none; padding: 22px 26px; background: var(--surface); animation: fadeIn .3s ease; }
.step-pane.active { display: block; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }

/* Hero Photo Upload - Sleek Minimal Avatar */
.hero-photo-upload {
    display: flex; flex-direction: column; align-items: center; text-align: center;
    margin-bottom: 24px; transition: all .2s; cursor: pointer; position: relative;
    padding-top: 8px; border: none; background: transparent;
}
.hero-photo-preview {
    width: 140px; height: 140px; border-radius: 50%; overflow: hidden; margin-bottom: 12px;
    border: 4px solid var(--surface); box-shadow: 0 6px 20px rgba(0,0,0,.08);
    background: var(--surface-alt); display: flex; align-items: center; justify-content: center;
    position: relative; transition: all .3s;
}
.hero-photo-upload:hover .hero-photo-preview {
    box-shadow: 0 8px 25px rgba(0,0,0,.15);
}
.hero-photo-preview img { width: 100%; height: 100%; object-fit: cover; }
.hero-photo-preview .placeholder { font-size: 56px; color: var(--border-2); display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; }
.hero-photo-badge {
    position: absolute; bottom: 32px; right: 50%; margin-right: -60px;
    width: 38px; height: 38px; background: var(--forest); border: 3px solid var(--surface);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 15px; box-shadow: 0 3px 8px rgba(0,0,0,.15);
    transition: transform .2s, background .2s; z-index: 5;
}
.hero-photo-upload:hover .hero-photo-badge { transform: scale(1.1); background: var(--forest-deep); }
.hero-photo-hint { font-size: 11.5px; color: var(--muted); }
.hero-photo-input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }

.step-title-wrap { margin-bottom: 20px; text-align: center; }
.step-title { font-size: 16px; font-weight: 800; color: var(--ink); margin: 0 0 4px; }
.step-desc { font-size: 13px; color: var(--muted); margin: 0; }

.btn-modal-back {
    display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px;
    background: transparent; border: 1.5px transparent; border-radius: var(--r-md);
    font-size: 13px; font-weight: 700; color: var(--tx); cursor: pointer; transition: all .18s;
}
.btn-modal-back:hover { background: var(--surface-alt); border: 1.5px solid var(--border-2); }

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
    .p3m-modal .modal-header { padding: 20px 18px 16px; }
    .p3m-modal .modal-body   { padding: 18px; }
    .p3m-modal .modal-footer { padding: 14px 18px; }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dash.dashadmin') }}">Home</a></li>
            <li class="breadcrumb-item active">Pengelola P3M</li>
        </ol>
    </div>

    <section class="content">

        <div class="users-card">

            {{-- Card Header --}}
            <div class="users-card-head">
                <div>
                    <span class="card-eyebrow">Profil P3M</span>
                    <h1 class="card-head-title">Pengelola P3M</h1>
                    <p class="card-head-sub">Kelola profil pengelola yang ditampilkan pada halaman publik P3M Polibang.</p>
                </div>
                <div class="card-head-actions">
                    <div class="stat-chip">
                        <i class="fas fa-users"></i>
                        Total {{ count($pengelola) }} pengelola
                    </div>
                    <button type="button" class="btn-add-user" data-toggle="modal" data-target="#createPengelolaModal">
                        <i class="fas fa-plus"></i> Tambah Pengelola
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
                    <input type="text" class="search-input" id="userSearch" placeholder="Cari nama, NIDN, atau jabatan...">
                </div>
            </div>

            {{-- Table --}}
            <div class="users-table-wrap">
                <table class="table users-table" id="pengelolaTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="38%">Pengelola</th>
                            <th width="15%">NIDN</th>
                            <th width="27%">Jabatan</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengelola as $d)
                        @php
                            $photoPath   = !empty($d->image) ? 'storage/photo-pengelola/' . $d->image : null;
                            $photoExists = $photoPath && file_exists(public_path($photoPath));
                            $initial     = strtoupper(substr($d->nama_pengelola ?? 'P', 0, 1));
                        @endphp
                        <tr>
                            <td class="row-num">{{ $loop->iteration }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="u-avatar">
                                        @if($photoExists)
                                            <img src="{{ asset($photoPath) }}" alt="{{ $d->nama_pengelola }}">
                                        @else
                                            {{ $initial }}
                                        @endif
                                    </div>
                                    <div>
                                        <span class="u-name">{{ $d->nama_pengelola }}</span>
                                        <span class="u-email">{{ $d->email_pengelola }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="nik-value {{ empty($d->NIDN) ? 'empty' : '' }}">{{ $d->NIDN ?? '—' }}</span>
                            </td>
                            <td>
                                <span class="role-badge badge-default">{{ $d->jabatan_pengelola }}</span>
                            </td>
                            <td class="text-center">
                                <div class="action-wrap">
                                    <button type="button" class="btn-icon btn-icon-edit"
                                        data-toggle="modal" data-target="#editPengelolaModal{{ $d->id }}"
                                        title="Edit {{ $d->nama_pengelola }}">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn-icon btn-icon-del"
                                        data-p3m-delete
                                        data-url="{{ route('pengelola.delete', ['id' => $d->id]) }}"
                                        data-type="Pengelola"
                                        data-label="{{ $d->nama_pengelola }}"
                                        title="Hapus {{ $d->nama_pengelola }}"
                                        onclick="confirmDeletePengelola(this)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
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

{{-- Global Delete Form --}}
<form id="global-delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

{{-- Create Modal --}}
<div class="modal fade p3m-modal" id="createPengelolaModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('pengelola.store') }}" method="POST" enctype="multipart/form-data" class="modal-content" id="createForm">
            @csrf
            
            <div class="modal-header" style="border-bottom: none; padding-bottom: 12px;">
                <div class="modal-icon"><i class="fas fa-user-plus"></i></div>
                <div class="modal-head-text">
                    <h5 id="createModalLabel">Tambah Pengelola P3M</h5>
                    <p>Lengkapi data pengelola secara bertahap.</p>
                </div>
                <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
            </div>
            
            <div class="p3m-stepper">
                <div class="stepper-item active" id="stepper1-create">
                    <span class="stepper-icon">01</span> Profil
                </div>
                <div class="stepper-line"></div>
                <div class="stepper-item" id="stepper2-create">
                    <span class="stepper-icon">02</span> Informasi
                </div>
            </div>

            @if (session('form_context') === 'create_pengelola' && $errors->any())
            <div style="padding: 16px 26px 0;">
                <div class="modal-errors" style="margin-bottom: 0;">
                    <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:1px;"></i>
                    <div>
                        <strong>Data belum valid.</strong>
                        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="step-pane active" id="step1-create">
                <div class="step-title-wrap">
                    <h6 class="step-title">Profil Pengelola</h6>
                    <p class="step-desc">Lengkapi identitas dasar pengelola.</p>
                </div>
                
                <label class="hero-photo-upload" id="createPhotoPicker">
                    <div class="hero-photo-preview">
                        <img id="createAvatarImg" src="" alt="Preview" style="display: none;">
                        <span class="placeholder"><i class="fas fa-user"></i></span>
                    </div>
                    <div class="hero-photo-badge">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="hero-photo-hint">PNG, JPG, JPEG, WebP &middot; Maks. 5 MB</div>
                    <input type="file" name="image" id="createPhotoInput"
                        class="hero-photo-input p3m-cropper-input"
                        data-base64-target="#image_base64_create"
                        data-preview-target="#createAvatarImg"
                        accept=".png,.jpg,.jpeg,.webp,image/png,image/jpeg,image/webp">
                </label>
                <input type="hidden" name="image_base64" id="image_base64_create">

                <div class="form-field">
                    <label>Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="nama_pengelola" id="createNama" class="form-input" value="{{ old('nama_pengelola') }}" placeholder="Masukkan nama pengelola" required>
                    <div class="invalid-feedback" style="display:none; color:var(--danger); font-size:12.5px; margin-top:5px;"><i class="fas fa-exclamation-circle"></i> Nama lengkap wajib diisi.</div>
                </div>
                
                <div class="modal-footer" style="padding: 24px 0 0; background: transparent; border: none; justify-content: space-between;">
                    <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn-modal-submit btn-next" data-id="create">Lanjut <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            <div class="step-pane" id="step2-create">
                <div class="step-title-wrap">
                    <h6 class="step-title">Informasi Pengelola</h6>
                    <p class="step-desc">Lengkapi informasi profesional pengelola.</p>
                </div>
                
                <div class="form-field">
                    <label>NIDN <span class="req">*</span></label>
                    <input type="text" name="NIDN" id="createNIDN" class="form-input" value="{{ old('NIDN') }}" placeholder="Masukkan NIDN" required>
                </div>
                <div class="form-field">
                    <label>Jabatan <span class="req">*</span></label>
                    <input type="text" name="jabatan_pengelola" id="createJabatan" class="form-input" value="{{ old('jabatan_pengelola') }}" placeholder="Masukkan jabatan" required>
                </div>
                <div class="form-field">
                    <label>Email <span class="req">*</span></label>
                    <input type="email" name="email_pengelola" id="createEmail" class="form-input" value="{{ old('email_pengelola') }}" placeholder="Masukkan email" required>
                </div>

                <div class="modal-footer" style="padding: 24px 0 0; background: transparent; border: none; justify-content: space-between;">
                    <button type="button" class="btn-modal-back btn-prev" data-id="create"><i class="fas fa-arrow-left"></i> Kembali</button>
                    <button type="submit" class="btn-modal-submit"><i class="fas fa-save"></i> Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modals --}}
@foreach ($pengelola as $d)
<div class="modal fade p3m-modal" id="editPengelolaModal{{ $d->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('pengelola.update', ['id' => $d->id]) }}" method="POST" enctype="multipart/form-data" class="modal-content" id="editForm{{ $d->id }}">
            @csrf
            @method('PUT')
            <div class="modal-header" style="border-bottom: none; padding-bottom: 12px;">
                <div class="modal-icon"><i class="fas fa-user-edit"></i></div>
                <div class="modal-head-text">
                    <h5>Edit Pengelola P3M</h5>
                    <p>Perbarui profil pengelola secara bertahap.</p>
                </div>
                <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Tutup">&times;</button>
            </div>
            
            <div class="p3m-stepper">
                <div class="stepper-item active" id="stepper1-{{ $d->id }}">
                    <span class="stepper-icon">01</span> Profil
                </div>
                <div class="stepper-line"></div>
                <div class="stepper-item" id="stepper2-{{ $d->id }}">
                    <span class="stepper-icon">02</span> Informasi
                </div>
            </div>

            @if (session('form_context') === 'edit_pengelola_' . $d->id && $errors->any())
            <div style="padding: 16px 26px 0;">
                <div class="modal-errors" style="margin-bottom: 0;">
                    <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:1px;"></i>
                    <div>
                        <strong>Data belum valid.</strong>
                        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="step-pane active" id="step1-{{ $d->id }}">
                <div class="step-title-wrap">
                    <h6 class="step-title">Profil Pengelola</h6>
                    <p class="step-desc">Lengkapi identitas dasar pengelola.</p>
                </div>
                
                <label class="hero-photo-upload" id="editPhotoPicker{{ $d->id }}">
                    <div class="hero-photo-preview">
                        @php
                            $epPath = !empty($d->image) ? asset('storage/photo-pengelola/' . $d->image) : null;
                        @endphp
                        @if($epPath)
                            <img src="{{ $epPath }}" alt="{{ $d->nama_pengelola }}" id="editAvatarImg{{ $d->id }}">
                            <span class="placeholder" style="display: none;"><i class="fas fa-user"></i></span>
                        @else
                            <img id="editAvatarImg{{ $d->id }}" src="" alt="Preview" style="display: none;">
                            <span class="placeholder"><i class="fas fa-user"></i></span>
                        @endif
                    </div>
                    <div class="hero-photo-badge">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="hero-photo-hint">PNG, JPG, JPEG, WebP &middot; Maks. 5 MB</div>
                    <input type="file" name="image" id="editPhotoInput{{ $d->id }}"
                        class="hero-photo-input p3m-cropper-input"
                        data-base64-target="#image_base64_edit_{{ $d->id }}"
                        data-preview-target="#editAvatarImg{{ $d->id }}"
                        accept=".png,.jpg,.jpeg,.webp,image/png,image/jpeg,image/webp">
                </label>
                <input type="hidden" name="image_base64" id="image_base64_edit_{{ $d->id }}">

                <div class="form-field">
                    <label>Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="nama_pengelola" id="editNama{{ $d->id }}" class="form-input" value="{{ old('nama_pengelola', $d->nama_pengelola) }}" placeholder="Masukkan nama pengelola" required>
                    <div class="invalid-feedback" style="display:none; color:var(--danger); font-size:12.5px; margin-top:5px;"><i class="fas fa-exclamation-circle"></i> Nama lengkap wajib diisi.</div>
                </div>
                
                <div class="modal-footer" style="padding: 24px 0 0; background: transparent; border: none; justify-content: space-between;">
                    <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn-modal-submit btn-next" data-id="{{ $d->id }}">Lanjut <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            <div class="step-pane" id="step2-{{ $d->id }}">
                <div class="step-title-wrap">
                    <h6 class="step-title">Informasi Pengelola</h6>
                    <p class="step-desc">Lengkapi informasi profesional pengelola.</p>
                </div>
                
                <div class="form-field">
                    <label>NIDN <span class="req">*</span></label>
                    <input type="text" name="NIDN" id="editNIDN{{ $d->id }}" class="form-input" value="{{ old('NIDN', $d->NIDN) }}" placeholder="Masukkan NIDN" required>
                </div>
                <div class="form-field">
                    <label>Jabatan <span class="req">*</span></label>
                    <input type="text" name="jabatan_pengelola" id="editJabatan{{ $d->id }}" class="form-input" value="{{ old('jabatan_pengelola', $d->jabatan_pengelola) }}" placeholder="Masukkan jabatan" required>
                </div>
                <div class="form-field">
                    <label>Email <span class="req">*</span></label>
                    <input type="email" name="email_pengelola" id="editEmail{{ $d->id }}" class="form-input" value="{{ old('email_pengelola', $d->email_pengelola) }}" placeholder="Masukkan email" required>
                </div>

                <div class="modal-footer" style="padding: 24px 0 0; background: transparent; border: none; justify-content: space-between;">
                    <button type="button" class="btn-modal-back btn-prev" data-id="{{ $d->id }}"><i class="fas fa-arrow-left"></i> Kembali</button>
                    <button type="submit" class="btn-modal-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
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
    var table = $('#pengelolaTable').DataTable({
        responsive: true,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Cari nama, NIDN, atau jabatan...",
            info: "Menampilkan _START_-_END_ dari _TOTAL_ data",
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next:     '<i class="fas fa-chevron-right"></i>'
            },
            emptyTable: "Belum ada data pengelola",
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

    $('#userSearch').on('keyup', function () { table.search(this.value).draw(); });
    $('#pageLengthSelect').on('change', function () { table.page.len(+this.value).draw(); });

    @if (session('form_context') === 'create_pengelola')
        $('#createPengelolaModal').modal('show');
    @endif
    @foreach ($pengelola as $d)
        @if (session('form_context') === 'edit_pengelola_' . $d->id)
            $('#editPengelolaModal{{ $d->id }}').modal('show');
        @endif
    @endforeach

    // Multi-step form logic for Create and Edit Pengelola
    $('.btn-next').on('click', function() {
        var id = $(this).data('id');
        var namaInput = id === 'create' ? $('#createNama') : $('#editNama' + id);
        var isValid = true;
        
        // Native HTML5 validity check for Nama
        if (!namaInput[0].checkValidity() || namaInput.val().trim() === '') {
            namaInput.css('border-color', 'var(--danger)');
            namaInput.siblings('.invalid-feedback').show();
            namaInput.focus();
            isValid = false;
        } else {
            namaInput.css('border-color', '');
            namaInput.siblings('.invalid-feedback').hide();
        }

        // Validate Photo for Create
        if (id === 'create') {
            var base64Input = $('#image_base64_create');
            if (base64Input.val().trim() === '') {
                $('.hero-photo-upload').css('border-color', 'var(--danger)');
                if ($('#createPhotoError').length === 0) {
                    $('.hero-photo-hint').after('<div id="createPhotoError" style="color:var(--danger); font-size:12.5px; margin-top:5px;"><i class="fas fa-exclamation-circle"></i> Foto profil wajib dipilih.</div>');
                }
                $('#createPhotoError').show();
                isValid = false;
            } else {
                $('.hero-photo-upload').css('border-color', '');
                $('#createPhotoError').hide();
            }
        }

        if (!isValid) return;
        
        // Proceed to Step 2
        $('#step1-' + id).removeClass('active');
        $('#step2-' + id).addClass('active');
        
        // Update Stepper
        var stepper1 = $('#stepper1-' + id);
        stepper1.removeClass('active').addClass('completed');
        stepper1.find('.stepper-icon').html('<i class="fas fa-check"></i>');
        $('#stepper2-' + id).addClass('active');
    });

    $('.btn-prev').on('click', function() {
        var id = $(this).data('id');
        
        // Back to Step 1
        $('#step2-' + id).removeClass('active');
        $('#step1-' + id).addClass('active');
        
        // Update Stepper
        var stepper1 = $('#stepper1-' + id);
        stepper1.removeClass('completed').addClass('active');
        stepper1.find('.stepper-icon').html('01');
        $('#stepper2-' + id).removeClass('active');
    });

    // Reset multi-step on modal close to always start at step 1 next time
    $('.p3m-modal').on('hidden.bs.modal', function () {
        var id = $(this).attr('id').replace('editPengelolaModal', '').replace('createPengelolaModal', 'create');
        if (id) {
            $('#step2-' + id).removeClass('active');
            $('#step1-' + id).addClass('active');
            
            var stepper1 = $('#stepper1-' + id);
            stepper1.removeClass('completed').addClass('active');
            stepper1.find('.stepper-icon').html('01');
            $('#stepper2-' + id).removeClass('active');
            
            var namaInput = id === 'create' ? $('#createNama') : $('#editNama' + id);
            if (namaInput.length) {
                namaInput.css('border-color', '');
                namaInput.siblings('.invalid-feedback').hide();
            }
            
            if (id === 'create') {
                $('.hero-photo-upload').css('border-color', '');
                $('#createPhotoError').hide();
                
                // Reset form fields
                $('#createForm')[0].reset();
                
                // Reset image preview state
                $('#image_base64_create').val('');
                $('#createAvatarImg').hide().attr('src', '');
                $('#createPhotoPicker .placeholder').show();
            }
        }
    });
    
    // Auto-update photo preview visibility when a photo is selected
    // Note: The cropper JS might also handle this, but adding a fallback just in case
    $('.hero-photo-input').on('change', function() {
        if (this.files && this.files[0]) {
            var $parent = $(this).closest('.hero-photo-upload');
            $parent.find('.placeholder').hide();
            $parent.find('img').show();
        }
    });
});

// Delete confirmation using P3M Global Alert System
window.confirmDeletePengelola = function(btn) {
    if (typeof window.p3mDelete === 'function') {
        window.p3mDelete(btn);
        return;
    }

    var url = btn.getAttribute('data-url');
    var name = btn.getAttribute('data-label') || (btn.getAttribute('title') ? btn.getAttribute('title').replace('Hapus ', '') : 'pengelola ini');
    if (!url) return;

    if (confirm('Yakin ingin menghapus ' + name + '?')) {
        var form = document.getElementById('global-delete-form');
        if (form) {
            form.action = url;
            form.submit();
        }
    }
};
</script>
@endsection
