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

    .agenda-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .agenda-page .content {
        padding-top: 8px;
    }

    .agenda-wrap {
        width: 100%;
        max-width: 1140px;
        margin: 0 auto;
    }

    .agenda-breadcrumb {
        margin-bottom: 12px;
    }

    .agenda-breadcrumb .breadcrumb {
        margin: 0;
    }

    .agenda-alert {
        border: 1px solid #bbf7d0;
        border-radius: 14px;
        background: #f0fdf4;
        color: #166534;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .agenda-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .agenda-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 20px 22px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .agenda-title-group {
        min-width: 0;
    }

    .agenda-kicker {
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

    .agenda-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: var(--p3m-gold);
    }

    .agenda-panel-header h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .agenda-panel-header p {
        max-width: 620px;
        margin: 7px 0 0;
        color: var(--p3m-slate-500);
        font-size: 13.25px;
        line-height: 1.6;
    }

    .agenda-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0 0 auto;
    }

    .agenda-count-pill {
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

    .btn-add-agenda {
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
    }

    .btn-add-agenda:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .agenda-panel-body {
        padding: 0 22px 20px;
    }

    .agenda-table {
        width: 100%;
        margin-bottom: 0 !important;
        color: var(--p3m-slate-700);
        table-layout: fixed;
    }

    .agenda-table thead th {
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

    .agenda-table thead th:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .agenda-table thead th:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .agenda-table tbody td {
        vertical-align: middle;
        border-top: 0;
        border-bottom: 1px solid var(--p3m-border-soft);
        padding: 14px 12px;
        color: var(--p3m-slate-700);
        font-size: 13.35px;
    }

    .agenda-table tbody tr:hover {
        background: var(--p3m-bg-soft);
    }

    .agenda-no {
        width: 54px;
        color: var(--p3m-slate-500);
        font-weight: 800;
    }

    .agenda-main-cell {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        min-width: 0;
    }

    .agenda-icon {
        width: 42px;
        height: 42px;
        margin-top: 2px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        color: var(--p3m-blue);
        background: #eff6ff;
        border: 1px solid #dbeafe;
        font-size: 15px;
    }

    .agenda-title {
        display: block;
        color: var(--p3m-slate-900);
        font-weight: 850;
        line-height: 1.36;
    }

    .agenda-meta-inline {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 6px;
    }

    .agenda-mini-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 26px;
        padding: 5px 9px;
        border-radius: 999px;
        background: var(--p3m-bg-soft);
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-600);
        font-size: 11.75px;
        font-weight: 750;
        line-height: 1;
    }

    .agenda-mini-pill i {
        color: var(--p3m-blue);
        font-size: 11px;
    }

    .agenda-schedule {
        display: flex;
        flex-direction: column;
        gap: 6px;
        white-space: nowrap;
    }

    .agenda-schedule strong {
        color: var(--p3m-slate-900);
        font-size: 13.25px;
        font-weight: 850;
        line-height: 1.25;
    }

    .agenda-schedule span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: var(--p3m-slate-500);
        font-size: 12.5px;
        font-weight: 750;
        line-height: 1.25;
    }

    .agenda-schedule i {
        color: var(--p3m-blue);
        font-size: 12px;
    }

    .agenda-location {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: var(--p3m-slate-600);
        font-size: 13.1px;
        font-weight: 700;
        line-height: 1.5;
    }

    .agenda-location i {
        margin-top: 3px;
        color: var(--p3m-blue);
        font-size: 12px;
        flex: 0 0 auto;
    }

    .agenda-note {
        display: block;
        color: var(--p3m-slate-600);
        line-height: 1.58;
    }

    .action-buttons {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-view-agenda,
    .btn-edit-agenda,
    .btn-delete-agenda {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12.5px;
        transition: .22s ease;
    }

    .btn-view-agenda {
        background: #ecfeff;
        border: 1px solid #a5f3fc;
        color: #0891b2;
    }

    .btn-view-agenda:hover {
        background: #0891b2;
        border-color: #0891b2;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-edit-agenda {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: var(--p3m-blue);
    }

    .btn-edit-agenda:hover {
        background: var(--p3m-blue);
        border-color: var(--p3m-blue);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-delete-agenda {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #e11d48;
    }

    .btn-delete-agenda:hover {
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

    .dataTables_wrapper .page-link i {
        font-size: 10px;
        line-height: 1;
    }

    @media (max-width: 1199.98px) {
        .agenda-table {
            table-layout: auto;
        }
    }

    @media (max-width: 767.98px) {
        .agenda-wrap {
            max-width: 100%;
        }

        .agenda-panel-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .agenda-header-actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .agenda-count-pill,
        .btn-add-agenda {
            width: 100%;
            justify-content: center;
        }

        .agenda-panel-body {
            padding: 0 16px 18px;
        }
    }

    @media (max-width: 575.98px) {
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
<div class="content-wrapper agenda-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="agenda-wrap">
                <div class="agenda-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Agenda Kegiatan P3M</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="agenda-wrap">
                @if(session('success'))
                    <div class="alert agenda-alert alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="agenda-panel">
                    <div class="agenda-panel-header">
                        <div class="agenda-title-group">
                            <span class="agenda-kicker">Agenda P3M</span>
                            <h1>Agenda Kegiatan P3M</h1>
                            <p>Kelola jadwal kegiatan P3M, mulai dari tanggal, waktu pelaksanaan, lokasi, hingga ringkasan agenda.</p>
                        </div>

                        <div class="agenda-header-actions">
                            <span class="agenda-count-pill">Total {{ count($data) }} agenda</span>
                            <a href="{{ route('agenda.create') }}" class="btn-add-agenda">
                                <i class="fas fa-plus"></i>
                                Tambah Agenda
                            </a>
                        </div>
                    </div>

                    <div class="agenda-panel-body table-responsive">
                        <table id="agendaTable" class="table agenda-table">
                            <colgroup>
                                <col style="width: 58px;">
                                <col style="width: 36%;">
                                <col style="width: 16%;">
                                <col style="width: 22%;">
                                <col style="width: 16%;">
                                <col style="width: 120px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Agenda</th>
                                    <th>Jadwal</th>
                                    <th>Lokasi</th>
                                    <th>Ringkasan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td class="agenda-no">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="agenda-main-cell">
                                                <span class="agenda-icon">
                                                    <i class="fas fa-calendar-check"></i>
                                                </span>
                                                <div>
                                                    <span class="agenda-title">{{ $d->title }}</span>
                                                    <div class="agenda-meta-inline">
                                                        <span class="agenda-mini-pill">
                                                            <i class="far fa-calendar"></i>
                                                            Agenda kegiatan
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="agenda-schedule">
                                                <strong>{{ $d->date }}</strong>
                                                <span>
                                                    <i class="far fa-clock"></i>
                                                    {{ \Illuminate\Support\Str::limit($d->time, 5, '') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="agenda-location">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span>{{ $d->lokasi }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="agenda-note">
                                                {{ \Illuminate\Support\Str::words(strip_tags(html_entity_decode($d->keterangan)), 15) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="action-buttons">
                                                <a href="{{ route('agenda.read', ['id' => $d->id]) }}" class="btn btn-view-agenda" title="Lihat Agenda">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('agenda.edit', ['id' => $d->id]) }}" class="btn btn-edit-agenda" title="Edit Agenda">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a href="{{ route('agenda.delete', ['id' => $d->id]) }}" class="btn btn-delete-agenda" title="Hapus Agenda" onclick="return confirm('Yakin ingin menghapus agenda ini?')">
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
</div>
@endsection

@section('scripts')
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $('#agendaTable').DataTable({
            responsive: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            pageLength: 10,
            columnDefs: [
                { orderable: false, targets: [5] }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    previous: '<i class="fas fa-chevron-left"></i> Previous',
                    next: 'Next <i class="fas fa-chevron-right"></i>'
                },
                emptyTable: "Belum ada data agenda"
            }
        });
    });
</script>
@endsection
