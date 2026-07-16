@extends('layout.main')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
    .pengelola-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .pengelola-page .content {
        padding-top: 8px;
    }

    .pengelola-wrap {
        width: 100%;
        max-width: 1140px;
        margin: 0 auto;
    }

    .pengelola-breadcrumb {
        margin-bottom: 12px;
    }

    .pengelola-breadcrumb .breadcrumb {
        margin: 0;
    }

    .pengelola-panel {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .pengelola-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 20px 22px;
        border-bottom: 1px solid #e2e8f0;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .pengelola-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 7px;
        color: #2563eb;
        font-size: 11.25px;
        font-weight: 900;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .pengelola-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: #d5a72f;
    }

    .pengelola-panel-header h1 {
        margin: 0;
        color: #0f172a;
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .pengelola-panel-header p {
        max-width: 620px;
        margin: 7px 0 0;
        color: #64748b;
        font-size: 13.25px;
        line-height: 1.6;
    }

    .pengelola-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0 0 auto;
    }

    .pengelola-count-pill {
        display: inline-flex;
        align-items: center;
        min-height: 36px;
        padding: 7px 11px;
        border-radius: 999px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        font-size: 12.25px;
        font-weight: 850;
        white-space: nowrap;
    }

    .btn-add-pengelola {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 38px;
        padding: 8px 13px;
        border-radius: 11px;
        background: #2563eb;
        border: 1px solid #2563eb;
        color: #ffffff;
        font-size: 13.25px;
        font-weight: 850;
        box-shadow: 0 10px 22px rgba(37, 99, 235, .16);
        transition: .22s ease;
        cursor: pointer;
    }

    .btn-add-pengelola:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .pengelola-panel-body {
        padding: 0 22px 20px;
    }

    .pengelola-alert {
        border: 0;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .07);
        margin-bottom: 16px;
    }

    .pengelola-table {
        width: 100%;
        margin-bottom: 0 !important;
        color: #334155;
        table-layout: fixed;
    }

    .pengelola-table thead th {
        border-top: 0;
        border-bottom: 1px solid #e2e8f0 !important;
        background: #f8fafc;
        color: #0f172a;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .07em;
        text-transform: uppercase;
        padding: 11px 12px;
        white-space: nowrap;
    }

    .pengelola-table thead th:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .pengelola-table thead th:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .pengelola-table tbody td {
        vertical-align: middle;
        border-top: 0;
        border-bottom: 1px solid #eef2f7;
        padding: 12px;
        color: #334155;
        font-size: 13.35px;
    }

    .pengelola-table tbody tr:hover {
        background: #f8fafc;
    }

    .pengelola-no {
        width: 54px;
        color: #64748b;
        font-weight: 800;
    }

    .pengelola-person {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .pengelola-photo,
    .pengelola-photo-fallback {
        width: 44px;
        height: 44px;
        border-radius: 999px;
        flex: 0 0 auto;
        object-fit: cover;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #2563eb;
        font-size: 13px;
        font-weight: 900;
    }

    .pengelola-name {
        display: block;
        color: #0f172a;
        font-weight: 850;
        line-height: 1.35;
    }

    .pengelola-email {
        display: block;
        margin-top: 1px;
        color: #64748b;
        font-size: 12.5px;
        font-weight: 600;
        line-height: 1.35;
    }

    .pengelola-nidn {
        color: #475569;
        font-weight: 650;
        white-space: nowrap;
    }

    .jabatan-badge {
        display: inline-flex;
        align-items: center;
        max-width: 100%;
        min-height: 28px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-size: 12px;
        font-weight: 750;
        line-height: 1.3;
    }

    .action-buttons {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-edit-pengelola,
    .btn-delete-pengelola {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12.5px;
        transition: .22s ease;
    }

    .btn-edit-pengelola {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
    }

    .btn-edit-pengelola:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-delete-pengelola {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #e11d48;
    }

    .btn-delete-pengelola:hover {
        background: #ef4444;
        border-color: #ef4444;
        color: #ffffff;
        transform: translateY(-1px);
    }

    table.dataTable.no-footer {
        border-bottom: 0 !important;
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
        color: #64748b;
        font-size: 12.75px;
        font-weight: 650;
    }

    .dataTables_wrapper .dataTables_length select {
        width: 68px !important;
        min-width: 68px;
        height: 34px;
        margin: 0 !important;
        padding: 6px 28px 6px 12px !important;
        border: 1px solid #dbe4f0;
        border-radius: 11px;
        background-color: #ffffff;
        color: #0f172a;
        font-weight: 750;
        box-shadow: none;
        outline: none;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 210px !important;
        min-height: 34px;
        margin-left: 0 !important;
        padding: 6px 12px !important;
        border: 1px solid #dbe4f0;
        border-radius: 11px;
        color: #0f172a;
        box-shadow: none;
        outline: none;
    }

    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
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
        background: #f8fafc;
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
        color: #64748b;
        font-size: 12.5px;
        font-weight: 800;
        line-height: 1;
        box-shadow: none !important;
        transition: .18s ease;
    }

    .dataTables_wrapper .page-link:hover {
        background: #ffffff;
        color: #2563eb;
        box-shadow: 0 6px 16px rgba(15, 23, 42, .07) !important;
    }

    .dataTables_wrapper .page-item.active .page-link {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 8px 18px rgba(37, 99, 235, .22) !important;
    }

    .dataTables_wrapper .page-item.disabled .page-link {
        background: transparent;
        color: #cbd5e1;
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
        color: #64748b;
        font-size: 12.25px;
        box-shadow: none !important;
    }

    .dataTables_wrapper .page-item.previous .page-link:hover,
    .dataTables_wrapper .page-item.next .page-link:hover {
        color: #2563eb;
        box-shadow: 0 6px 16px rgba(15, 23, 42, .07) !important;
    }

    .dataTables_wrapper .page-item.previous.disabled .page-link,
    .dataTables_wrapper .page-item.next.disabled .page-link {
        background: #f1f5f9;
        color: #cbd5e1;
        box-shadow: none !important;
    }

    .dataTables_wrapper .page-link i {
        font-size: 10px;
        line-height: 1;
    }

    .p3m-modal .modal-dialog {
        max-width: 620px;
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
        border-bottom: 1px solid #e2e8f0;
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
        color: #0f172a;
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
        color: #64748b !important;
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
        border: 1px solid #e2e8f0;
        color: #334155;
    }

    .btn-modal-cancel:hover {
        background: #f8fafc;
        color: #0f172a;
    }

    .btn-modal-submit {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .17);
    }

    .btn-modal-submit:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff;
    }

    @media (max-width: 991.98px) {
        .pengelola-table {
            table-layout: auto;
        }
    }

    @media (max-width: 767.98px) {
        .pengelola-wrap {
            max-width: 100%;
        }

        .pengelola-panel-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .pengelola-header-actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .pengelola-count-pill,
        .btn-add-pengelola {
            width: 100%;
            justify-content: center;
        }

        .pengelola-panel-body {
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
<div class="content-wrapper pengelola-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="pengelola-wrap">
                <div class="pengelola-breadcrumb">
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
            <div class="pengelola-wrap">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show pengelola-alert" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="pengelola-panel">
                    <div class="pengelola-panel-header">
                        <div>
                            <span class="pengelola-kicker">Profil P3M</span>
                            <h1>Pengelola P3M</h1>
                            <p>Kelola data pengelola P3M yang tampil pada halaman publik website Politeknik Balekambang.</p>
                        </div>

                        <div class="pengelola-header-actions">
                            <span class="pengelola-count-pill">Total {{ count($pengelola) }} pengelola</span>
                            <button type="button" class="btn-add-pengelola" data-toggle="modal" data-target="#createPengelolaModal">
                                <i class="fas fa-plus"></i>
                                Tambah
                            </button>
                        </div>
                    </div>

                    <div class="pengelola-panel-body table-responsive">
                        <table id="pengelolaTable" class="table pengelola-table">
                            <colgroup>
                                <col style="width: 58px;">
                                <col style="width: 38%;">
                                <col style="width: 15%;">
                                <col style="width: 32%;">
                                <col style="width: 110px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pengelola</th>
                                    <th>NIDN</th>
                                    <th>Jabatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengelola as $d)
                                    @php
                                        $photoPath = !empty($d->image) ? 'storage/photo-pengelola/'.$d->image : null;
                                        $photoExists = $photoPath && file_exists(public_path($photoPath));
                                        $initial = strtoupper(substr($d->nama_pengelola ?? 'P', 0, 1));
                                    @endphp
                                    <tr>
                                        <td class="pengelola-no">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="pengelola-person">
                                                @if($photoExists)
                                                    <img src="{{ asset($photoPath) }}" alt="{{ $d->nama_pengelola }}" class="pengelola-photo">
                                                @else
                                                    <span class="pengelola-photo-fallback">{{ $initial }}</span>
                                                @endif

                                                <div>
                                                    <span class="pengelola-name">{{ $d->nama_pengelola }}</span>
                                                    <span class="pengelola-email">{{ $d->email_pengelola }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="pengelola-nidn">{{ $d->NIDN }}</span></td>
                                        <td><span class="jabatan-badge">{{ $d->jabatan_pengelola }}</span></td>
                                        <td class="text-center">
                                            <span class="action-buttons">
                                                <button type="button" class="btn btn-edit-pengelola" data-toggle="modal" data-target="#editPengelolaModal{{ $d->id }}" title="Edit Pengelola">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <a href="{{ route('pengelola.delete', ['id' => $d->id]) }}" class="btn btn-delete-pengelola" title="Hapus Pengelola">
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

    <div class="modal fade p3m-modal" id="createPengelolaModal" tabindex="-1" role="dialog" aria-labelledby="createPengelolaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('pengelola.store') }}" method="post" enctype="multipart/form-data" class="modal-content">
                @csrf

                <div class="modal-header">
                    <div class="p3m-modal-title">
                        <span class="p3m-modal-icon">
                            <i class="fas fa-user-plus"></i>
                        </span>
                        <div>
                            <h5 id="createPengelolaModalLabel">Tambah Pengelola P3M</h5>
                            <p>Lengkapi data pengelola yang akan tampil di halaman publik.</p>
                        </div>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @if(session('form_context') === 'create_pengelola' && $errors->any())
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
                        <label for="create_image">Foto Pengelola</label>
                        <input type="file" name="image" class="form-control" id="create_image" required>
                        <span class="modal-help-text">Wajib. Format PNG, JPG, atau JPEG maksimal 2MB.</span>
                    </div>

                    <div class="modal-form-group">
                        <label for="create_nama">Nama</label>
                        <input type="text" name="nama_pengelola" class="form-control" id="create_nama" value="{{ old('nama_pengelola') }}" placeholder="Masukkan nama pengelola" required>
                    </div>

                    <div class="modal-form-group">
                        <label for="create_nidn">NIDN</label>
                        <input type="text" name="NIDN" class="form-control" id="create_nidn" value="{{ old('NIDN') }}" placeholder="Masukkan NIDN" required>
                    </div>

                    <div class="modal-form-group">
                        <label for="create_jabatan">Jabatan</label>
                        <input type="text" name="jabatan_pengelola" class="form-control" id="create_jabatan" value="{{ old('jabatan_pengelola') }}" placeholder="Masukkan jabatan" required>
                    </div>

                    <div class="modal-form-group">
                        <label for="create_email">Email</label>
                        <input type="email" name="email_pengelola" class="form-control" id="create_email" value="{{ old('email_pengelola') }}" placeholder="Masukkan email" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-modal-submit">
                        Simpan Data
                        <i class="fas fa-save ml-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @foreach($pengelola as $d)
        <div class="modal fade p3m-modal" id="editPengelolaModal{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="editPengelolaModalLabel{{ $d->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{ route('pengelola.update', ['id' => $d->id]) }}" method="post" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('put')

                    <div class="modal-header">
                        <div class="p3m-modal-title">
                            <span class="p3m-modal-icon">
                                <i class="fas fa-user-edit"></i>
                            </span>
                            <div>
                                <h5 id="editPengelolaModalLabel{{ $d->id }}">Edit Pengelola P3M</h5>
                                <p>Perbarui data pengelola dan foto profil jika dibutuhkan.</p>
                            </div>
                        </div>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        @if(session('form_context') === 'edit_pengelola_' . $d->id && $errors->any())
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
                            <label for="edit_image_{{ $d->id }}">Foto Pengelola</label>
                            <input type="file" name="image" class="form-control" id="edit_image_{{ $d->id }}">
                            <span class="modal-help-text">Opsional. Kosongkan jika foto tidak ingin diganti.</span>
                        </div>

                        <div class="modal-form-group">
                            <label for="edit_nama_{{ $d->id }}">Nama</label>
                            <input type="text" name="nama_pengelola" class="form-control" id="edit_nama_{{ $d->id }}" value="{{ old('nama_pengelola', $d->nama_pengelola) }}" placeholder="Masukkan nama pengelola" required>
                        </div>

                        <div class="modal-form-group">
                            <label for="edit_nidn_{{ $d->id }}">NIDN</label>
                            <input type="text" name="NIDN" class="form-control" id="edit_nidn_{{ $d->id }}" value="{{ old('NIDN', $d->NIDN) }}" placeholder="Masukkan NIDN" required>
                        </div>

                        <div class="modal-form-group">
                            <label for="edit_jabatan_{{ $d->id }}">Jabatan</label>
                            <input type="text" name="jabatan_pengelola" class="form-control" id="edit_jabatan_{{ $d->id }}" value="{{ old('jabatan_pengelola', $d->jabatan_pengelola) }}" placeholder="Masukkan jabatan" required>
                        </div>

                        <div class="modal-form-group">
                            <label for="edit_email_{{ $d->id }}">Email</label>
                            <input type="email" name="email_pengelola" class="form-control" id="edit_email_{{ $d->id }}" value="{{ old('email_pengelola', $d->email_pengelola) }}" placeholder="Masukkan email" required>
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
        $('#pengelolaTable').DataTable({
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
                emptyTable: "Belum ada data pengelola"
            }
        });

        @if(session('form_context') === 'create_pengelola')
            $('#createPengelolaModal').modal('show');
        @endif

        @foreach($pengelola as $d)
            @if(session('form_context') === 'edit_pengelola_' . $d->id)
                $('#editPengelolaModal{{ $d->id }}').modal('show');
            @endif
        @endforeach
    });
</script>
@endsection
