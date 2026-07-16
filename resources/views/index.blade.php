@extends('layout.main')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
    :root {
        --p3m-blue: #2563eb;
        --p3m-blue-dark: #1d4ed8;
        --p3m-gold: #d5a72f;
        --p3m-slate-900: #0f172a;
        --p3m-slate-700: #334155;
        --p3m-slate-600: #475569;
        --p3m-slate-500: #64748b;
        --p3m-slate-300: #cbd5e1;
        --p3m-border: #e2e8f0;
        --p3m-border-soft: #eef2f7;
        --p3m-bg-soft: #f8fafc;
    }

    .admin-users-clean .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .admin-users-clean .content {
        padding-top: 8px;
    }

    .users-clean-wrap {
        width: 100%;
        max-width: 1140px;
        margin: 0 auto;
    }

    .users-clean-breadcrumb {
        margin-bottom: 12px;
    }

    .users-clean-breadcrumb .breadcrumb {
        margin: 0;
    }

    .users-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .users-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 20px 22px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .users-title-group {
        min-width: 0;
    }

    .users-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 7px;
        color: var(--p3m-blue);
        font-size: 11.25px;
        font-weight: 900;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .users-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: var(--p3m-gold);
    }

    .users-panel-header h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .users-panel-header p {
        max-width: 540px;
        margin: 7px 0 0;
        color: var(--p3m-slate-500);
        font-size: 13.25px;
        line-height: 1.6;
    }

    .users-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0 0 auto;
    }

    .users-count-pill {
        display: inline-flex;
        align-items: center;
        min-height: 36px;
        padding: 7px 11px;
        border-radius: 999px;
        border: 1px solid var(--p3m-border);
        background: var(--p3m-bg-soft);
        color: var(--p3m-slate-600);
        font-size: 12.25px;
        font-weight: 850;
        white-space: nowrap;
    }

    .btn-add-user-clean {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 38px;
        padding: 8px 13px;
        border-radius: 11px;
        background: var(--p3m-blue);
        border: 1px solid var(--p3m-blue);
        color: #ffffff;
        font-size: 13.25px;
        font-weight: 850;
        box-shadow: 0 10px 22px rgba(37, 99, 235, .16);
        transition: .22s ease;
        cursor: pointer;
    }

    .btn-add-user-clean:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .users-panel-body {
        padding: 0 22px 20px;
    }

    .admin-alert-clean {
        border: 0;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .07);
        margin-bottom: 16px;
    }

    .users-table {
        width: 100%;
        margin-bottom: 0 !important;
        color: var(--p3m-slate-700);
        table-layout: fixed;
    }

    .users-table thead th {
        border-top: 0;
        border-bottom: 1px solid var(--p3m-border) !important;
        background: var(--p3m-bg-soft);
        color: var(--p3m-slate-900);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .07em;
        text-transform: uppercase;
        padding: 11px 12px;
        white-space: nowrap;
    }

    .users-table thead th:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .users-table thead th:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .users-table tbody td {
        vertical-align: middle;
        border-top: 0;
        border-bottom: 1px solid var(--p3m-border-soft);
        padding: 11px 12px;
        color: var(--p3m-slate-700);
        font-size: 13.35px;
    }

    .users-table tbody tr:hover {
        background: var(--p3m-bg-soft);
    }

    .users-no {
        width: 54px;
        color: var(--p3m-slate-500);
        font-weight: 800;
    }

    .pengelola-cell {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .user-avatar-clean,
    .user-avatar-fallback {
        width: 38px;
        height: 38px;
        border-radius: 999px;
        flex: 0 0 auto;
        object-fit: cover;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: var(--p3m-blue);
        font-size: 12.5px;
        font-weight: 900;
    }

    .pengelola-name {
        display: block;
        color: var(--p3m-slate-900);
        font-weight: 800;
        line-height: 1.35;
    }

    .pengelola-email {
        display: block;
        margin-top: 1px;
        color: var(--p3m-slate-500);
        font-size: 12.5px;
        font-weight: 600;
        line-height: 1.35;
    }

    .nidn-clean {
        color: var(--p3m-slate-600);
        font-weight: 600;
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 28px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 850;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .role-admin {
        background: #eff6ff;
        color: var(--p3m-blue);
        border: 1px solid #bfdbfe;
    }

    .role-dosen {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #bbf7d0;
    }

    .role-empty {
        background: var(--p3m-bg-soft);
        color: var(--p3m-slate-500);
        border: 1px solid var(--p3m-border);
    }

    .action-buttons {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-edit-clean,
    .btn-delete-clean {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12.5px;
        transition: .22s ease;
    }

    .btn-edit-clean {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: var(--p3m-blue);
    }

    .btn-edit-clean:hover {
        background: var(--p3m-blue);
        border-color: var(--p3m-blue);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-delete-clean {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #e11d48;
    }

    .btn-delete-clean:hover {
        background: #ef4444;
        border-color: #ef4444;
        color: #ffffff;
        transform: translateY(-1px);
    }

    table.dataTable.no-footer {
        border-bottom: 0 !important;
    }

    table.dataTable thead .sorting::before,
    table.dataTable thead .sorting::after,
    table.dataTable thead .sorting_asc::before,
    table.dataTable thead .sorting_asc::after,
    table.dataTable thead .sorting_desc::before,
    table.dataTable thead .sorting_desc::after,
    table.dataTable thead .sorting_asc_disabled::before,
    table.dataTable thead .sorting_asc_disabled::after,
    table.dataTable thead .sorting_desc_disabled::before,
    table.dataTable thead .sorting_desc_disabled::after {
        display: none !important;
        content: "" !important;
    }

    table.dataTable thead > tr > th.sorting,
    table.dataTable thead > tr > th.sorting_asc,
    table.dataTable thead > tr > th.sorting_desc {
        padding-right: 12px !important;
    }

    .dataTables_wrapper {
        padding-top: 14px;
    }

    .dataTables_wrapper .row:first-child {
        margin-bottom: 6px;
    }

    .dataTables_wrapper .row:last-child {
        margin-top: 10px;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label,
    .dataTables_wrapper .dataTables_info {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 0;
        color: var(--p3m-slate-500);
        font-size: 12.75px;
        font-weight: 650;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        min-height: 34px;
        border: 1px solid #dbe4f0;
        border-radius: 11px;
        color: var(--p3m-slate-900);
        box-shadow: none;
        outline: none;
    }

    .dataTables_wrapper .dataTables_length select {
        width: 68px !important;
        min-width: 68px;
        margin: 0 !important;
        padding: 6px 28px 6px 12px !important;
        background-color: #ffffff;
        font-weight: 750;
        line-height: 1.2;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 210px !important;
        margin-left: 0 !important;
        padding: 6px 12px !important;
    }

    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .dataTables_wrapper .dataTables_paginate {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 0;
    }

    .dataTables_wrapper .pagination {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin: 0;
        padding: 4px;
        border-radius: 16px;
        background: var(--p3m-bg-soft);
        border: 1px solid #eaf0f7;
        box-shadow: none;
    }

    .dataTables_wrapper .page-item {
        margin: 0;
    }

    .dataTables_wrapper .page-link {
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        border: 0 !important;
        border-radius: 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: transparent;
        color: var(--p3m-slate-500);
        font-size: 12.5px;
        font-weight: 800;
        line-height: 1;
        box-shadow: none !important;
        transition: .18s ease;
    }

    .dataTables_wrapper .page-link:hover {
        background: #ffffff;
        color: var(--p3m-blue);
        box-shadow: 0 6px 16px rgba(15, 23, 42, .07) !important;
    }

    .dataTables_wrapper .page-item.active .page-link {
        background: var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 8px 18px rgba(37, 99, 235, .22) !important;
    }

    .dataTables_wrapper .page-item.disabled .page-link {
        background: transparent;
        color: var(--p3m-slate-300);
        opacity: 1;
        cursor: not-allowed;
        box-shadow: none !important;
    }

    .dataTables_wrapper .page-item.previous .page-link,
    .dataTables_wrapper .page-item.next .page-link {
        min-width: 72px;
        height: 32px;
        padding: 0 11px;
        border-radius: 999px !important;
        background: #ffffff;
        color: var(--p3m-slate-500);
        font-size: 12.25px;
        box-shadow: none !important;
    }

    .dataTables_wrapper .page-item.previous .page-link:hover,
    .dataTables_wrapper .page-item.next .page-link:hover {
        color: var(--p3m-blue);
        box-shadow: 0 6px 16px rgba(15, 23, 42, .07) !important;
    }

    .dataTables_wrapper .page-item.previous.disabled .page-link,
    .dataTables_wrapper .page-item.next.disabled .page-link {
        background: #f1f5f9;
        color: var(--p3m-slate-300);
        box-shadow: none !important;
    }

    .dataTables_wrapper .page-link i {
        font-size: 10px;
        line-height: 1;
    }

    .p3m-modal .modal-dialog {
        max-width: 560px;
    }

    .p3m-modal .modal-content {
        overflow: hidden;
        border: 0;
        border-radius: 24px;
        box-shadow: 0 30px 90px rgba(15, 23, 42, .22);
    }

    .p3m-modal .modal-header {
        align-items: flex-start;
        padding: 24px 26px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(135deg, rgba(6, 63, 53, .96), rgba(7, 31, 36, .94));
        color: #ffffff;
    }

    .p3m-modal-title {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .p3m-modal-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .12);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, .16);
        flex: 0 0 auto;
    }

    .p3m-modal-title h5 {
        margin: 0;
        color: #ffffff;
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: 21px;
        font-weight: 900;
        letter-spacing: -0.045em;
    }

    .p3m-modal-title p {
        margin: 4px 0 0;
        color: rgba(226, 232, 240, .82);
        font-size: 13px;
        line-height: 1.5;
    }

    .p3m-modal .close {
        color: #ffffff;
        opacity: .82;
        text-shadow: none;
        padding: 0;
        margin: 0;
    }

    .p3m-modal .close:hover {
        opacity: 1;
    }

    .p3m-modal .modal-body {
        padding: 24px 26px 10px;
        background: #ffffff;
    }

    .modal-form-group {
        margin-bottom: 16px;
    }

    .modal-form-group label {
        display: block;
        margin-bottom: 7px;
        color: #1e293b;
        font-size: 13px;
        font-weight: 850;
    }

    .modal-form-group .form-control {
        min-height: 44px;
        border: 1px solid #dbe4f0;
        border-radius: 13px;
        color: var(--p3m-slate-900);
        font-size: 14px;
        box-shadow: none;
    }

    .modal-form-group .form-control:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .modal-form-group small {
        display: block;
        margin-top: 6px;
        color: #dc2626;
        font-weight: 650;
    }

    .modal-help-text {
        display: block;
        margin-top: 6px;
        color: var(--p3m-slate-500) !important;
        font-size: 12px;
        font-weight: 600;
    }

    .p3m-modal .modal-footer {
        gap: 10px;
        padding: 18px 26px 24px;
        border-top: 0;
        background: #ffffff;
    }

    .btn-modal-cancel,
    .btn-modal-submit {
        min-height: 42px;
        padding: 10px 15px;
        border-radius: 13px;
        font-weight: 850;
    }

    .btn-modal-cancel {
        background: #ffffff;
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-700);
    }

    .btn-modal-cancel:hover {
        background: var(--p3m-bg-soft);
        color: var(--p3m-slate-900);
    }

    .btn-modal-submit {
        background: var(--p3m-blue);
        border-color: var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .17);
    }

    .btn-modal-submit:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
    }

    @media (max-width: 991.98px) {
        .users-table {
            table-layout: auto;
        }
    }

    @media (max-width: 767.98px) {
        .users-clean-wrap {
            max-width: 100%;
        }

        .users-panel-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .users-header-actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .users-count-pill,
        .btn-add-user-clean {
            width: 100%;
            justify-content: center;
        }

        .users-panel-body {
            padding: 0 16px 18px;
        }
    }

    @media (max-width: 575.98px) {
        .p3m-modal .modal-dialog {
            margin: 12px;
        }

        .p3m-modal .modal-header,
        .p3m-modal .modal-body,
        .p3m-modal .modal-footer {
            padding-left: 20px;
            padding-right: 20px;
        }

        .btn-modal-cancel,
        .btn-modal-submit {
            width: 100%;
        }

        .dataTables_wrapper .row:last-child > div {
            width: 100%;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            width: 100%;
            justify-content: space-between;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 100% !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            justify-content: center;
            margin-top: 12px;
        }

        .dataTables_wrapper .pagination {
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper admin-users-clean">
    <div class="content-header">
        <div class="container-fluid">
            <div class="users-clean-wrap">
                <div class="users-clean-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $pagetitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="users-clean-wrap">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show admin-alert-clean" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="users-panel">
                    <div class="users-panel-header">
                        <div class="users-title-group">
                            <span class="users-kicker">Manajemen User</span>
                            <h1>Data User P3M</h1>
                            <p>Kelola akun pengelola P3M Politeknik Balekambang Jepara secara ringkas dan mudah.</p>
                        </div>

                        <div class="users-header-actions">
                            <span class="users-count-pill">Total {{ count($data) }} user</span>
                            <button type="button" class="btn-add-user-clean" data-toggle="modal" data-target="#createUserModal">
                                <i class="fas fa-plus"></i>
                                Tambah User
                            </button>
                        </div>
                    </div>

                    <div class="users-panel-body table-responsive">
                        <table class="table users-table" id="clientside">
                            <colgroup>
                                <col style="width: 58px;">
                                <col style="width: 48%;">
                                <col style="width: 18%;">
                                <col style="width: 18%;">
                                <col style="width: 110px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pengelola</th>
                                    <th>NIDN</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    @php
                                        $photoPath = !empty($d->image) ? 'storage/photo-user/'.$d->image : null;
                                        $photoExists = $photoPath && file_exists(public_path($photoPath));
                                        $initial = strtoupper(substr($d->name ?? 'U', 0, 1));
                                        $role = $d->role ?? null;
                                    @endphp
                                    <tr>
                                        <td class="users-no">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="pengelola-cell">
                                                @if($photoExists)
                                                    <img src="{{ asset($photoPath) }}" alt="{{ $d->name }}" class="user-avatar-clean">
                                                @else
                                                    <span class="user-avatar-fallback">{{ $initial }}</span>
                                                @endif

                                                <div>
                                                    <span class="pengelola-name">{{ $d->name }}</span>
                                                    <span class="pengelola-email">{{ $d->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="nidn-clean">{{ $d->ktp->nik ?? '-' }}</span></td>
                                        <td>
                                            <span class="role-badge role-{{ $role ?: 'empty' }}">
                                                {{ $role ?: '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="action-buttons">
                                                <button type="button" class="btn btn-edit-clean" data-toggle="modal" data-target="#editUserModal{{ $d->id }}" title="Edit User">
                                                    <i class="fas fa-pen"></i>
                                                </button>

                                                <a href="{{ route('delete' , ['id' => $d->id]) }}" class="btn btn-delete-clean" title="Hapus User">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade p3m-modal" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('store') }}" method="post" enctype="multipart/form-data" class="modal-content">
                @csrf

                <div class="modal-header">
                    <div class="p3m-modal-title">
                        <span class="p3m-modal-icon">
                            <i class="fas fa-user-plus"></i>
                        </span>
                        <div>
                            <h5 id="createUserModalLabel">Tambah User P3M</h5>
                            <p>Lengkapi data user yang akan diberi akses ke panel pengelola P3M.</p>
                        </div>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @if(session('form_context') === 'create_user' && $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Data belum valid.</strong>
                            <ul class="mb-0 mt-2 pl-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="modal-form-group">
                        <label for="create_image">Profile Photo</label>
                        <input type="file" name="image" class="form-control" id="create_image" required>
                        <span class="modal-help-text">Wajib. Format PNG, JPG, atau JPEG maksimal 2MB.</span>
                    </div>

                    <div class="modal-form-group">
                        <label for="create_email">Email</label>
                        <input type="email" name="email" class="form-control" id="create_email" value="{{ old('email') }}" placeholder="Masukkan email" required>
                    </div>

                    <div class="modal-form-group">
                        <label for="create_name">Nama</label>
                        <input type="text" name="name" class="form-control" id="create_name" value="{{ old('name') }}" placeholder="Masukkan nama user" required>
                    </div>

                    <div class="modal-form-group">
                        <label for="create_role">Role</label>
                        <select name="role" id="create_role" class="form-control" required>
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="dosen" {{ old('role') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                        </select>
                    </div>

                    <div class="modal-form-group">
                        <label for="create_password">Password</label>
                        <input type="password" name="password" class="form-control" id="create_password" placeholder="Masukkan password" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-modal-submit">
                        Simpan User
                        <i class="fas fa-save ml-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @foreach($data as $d)
        <div class="modal fade p3m-modal" id="editUserModal{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel{{ $d->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{ route('edit' , ['id' => $d->id]) }}" method="post" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('put')

                    <div class="modal-header">
                        <div class="p3m-modal-title">
                            <span class="p3m-modal-icon">
                                <i class="fas fa-user-edit"></i>
                            </span>
                            <div>
                                <h5 id="editUserModalLabel{{ $d->id }}">Edit User P3M</h5>
                                <p>Perbarui data user dan role akses akun.</p>
                            </div>
                        </div>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        @if(session('form_context') === 'edit_user_' . $d->id && $errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Data belum valid.</strong>
                                <ul class="mb-0 mt-2 pl-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="modal-form-group">
                            <label for="edit_image_{{ $d->id }}">Profile Photo</label>
                            <input type="file" name="image" class="form-control" id="edit_image_{{ $d->id }}">
                            <span class="modal-help-text">Opsional. Kosongkan jika foto tidak ingin diganti.</span>
                        </div>

                        <div class="modal-form-group">
                            <label for="edit_email_{{ $d->id }}">Email</label>
                            <input type="email" name="email" class="form-control" id="edit_email_{{ $d->id }}" value="{{ old('email', $d->email) }}" placeholder="Masukkan email" required>
                        </div>

                        <div class="modal-form-group">
                            <label for="edit_name_{{ $d->id }}">Nama</label>
                            <input type="text" name="name" class="form-control" id="edit_name_{{ $d->id }}" value="{{ old('name', $d->name) }}" placeholder="Masukkan nama user" required>
                        </div>

                        <div class="modal-form-group">
                            <label for="edit_role_{{ $d->id }}">Role</label>
                            <select name="role" id="edit_role_{{ $d->id }}" class="form-control" required>
                                <option value="admin" {{ old('role', $d->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="dosen" {{ old('role', $d->role) === 'dosen' ? 'selected' : '' }}>Dosen</option>
                            </select>
                        </div>

                        <div class="modal-form-group">
                            <label for="edit_password_{{ $d->id }}">Password Baru</label>
                            <input type="password" name="password" class="form-control" id="edit_password_{{ $d->id }}" placeholder="Kosongkan jika tidak diganti">
                            <span class="modal-help-text">Opsional. Isi hanya jika ingin mengganti password.</span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-modal-submit">
                            Simpan Perubahan
                            <i class="fas fa-save ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $('#clientside').DataTable({
            responsive: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            pageLength: 10,
            columnDefs: [
                { orderable: false, targets: [4] }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    previous: '<i class="fas fa-chevron-left"></i> Previous',
                    next: 'Next <i class="fas fa-chevron-right"></i>'
                },
                emptyTable: "Belum ada data user"
            }
        });

        @if(session('form_context') === 'create_user')
            $('#createUserModal').modal('show');
        @endif

        @foreach($data as $d)
            @if(session('form_context') === 'edit_user_' . $d->id)
                $('#editUserModal{{ $d->id }}').modal('show');
            @endif
        @endforeach
    });
</script>
@endsection
