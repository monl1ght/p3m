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

    .news-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .news-page .content {
        padding-top: 8px;
    }

    .news-wrap {
        width: 100%;
        max-width: 1140px;
        margin: 0 auto;
    }

    .news-breadcrumb {
        margin-bottom: 12px;
    }

    .news-breadcrumb .breadcrumb {
        margin: 0;
    }

    .news-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .news-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 20px 22px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .news-title-group {
        min-width: 0;
    }

    .news-kicker {
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

    .news-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: var(--p3m-gold);
    }

    .news-panel-header h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .news-panel-header p {
        max-width: 620px;
        margin: 7px 0 0;
        color: var(--p3m-slate-500);
        font-size: 13.25px;
        line-height: 1.6;
    }

    .news-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0 0 auto;
    }

    .news-count-pill {
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

    .btn-add-news {
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

    .btn-add-news:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .news-panel-body {
        padding: 0 22px 20px;
    }

    .news-table {
        width: 100%;
        margin-bottom: 0 !important;
        color: var(--p3m-slate-700);
        table-layout: fixed;
    }

    .news-table thead th {
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

    .news-table thead th:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .news-table thead th:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .news-table tbody td {
        vertical-align: middle;
        border-top: 0;
        border-bottom: 1px solid var(--p3m-border-soft);
        padding: 12px;
        color: var(--p3m-slate-700);
        font-size: 13.35px;
    }

    .news-table tbody tr:hover {
        background: var(--p3m-bg-soft);
    }

    .news-no {
        width: 54px;
        color: var(--p3m-slate-500);
        font-weight: 800;
    }

    .news-title-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .news-thumb,
    .news-thumb-fallback {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        flex: 0 0 auto;
        object-fit: cover;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: var(--p3m-blue);
        font-size: 15px;
    }

    .news-title {
        display: block;
        color: var(--p3m-slate-900);
        font-weight: 850;
        line-height: 1.35;
    }

    .news-excerpt {
        display: block;
        margin-top: 2px;
        color: var(--p3m-slate-500);
        font-size: 12.5px;
        font-weight: 600;
        line-height: 1.4;
    }

    .news-date {
        color: var(--p3m-slate-600);
        font-size: 12.75px;
        font-weight: 750;
        white-space: nowrap;
    }

    .news-author {
        display: inline-flex;
        align-items: center;
        max-width: 100%;
        min-height: 30px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: var(--p3m-blue);
        font-size: 12px;
        font-weight: 850;
        line-height: 1.25;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        max-width: 100%;
        min-height: 30px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
        color: #047857;
        font-size: 12px;
        font-weight: 850;
        line-height: 1.25;
    }

    .action-buttons {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-view-news,
    .btn-edit-news,
    .btn-delete-news {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12.5px;
        transition: .22s ease;
    }

    .btn-view-news {
        background: #ecfeff;
        border: 1px solid #a5f3fc;
        color: #0891b2;
    }

    .btn-view-news:hover {
        background: #0891b2;
        border-color: #0891b2;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-edit-news {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: var(--p3m-blue);
    }

    .btn-edit-news:hover {
        background: var(--p3m-blue);
        border-color: var(--p3m-blue);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-delete-news {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #e11d48;
    }

    .btn-delete-news:hover {
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
        .news-table {
            table-layout: auto;
        }
    }

    @media (max-width: 767.98px) {
        .news-wrap {
            max-width: 100%;
        }

        .news-panel-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .news-header-actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .news-count-pill,
        .btn-add-news {
            width: 100%;
            justify-content: center;
        }

        .news-panel-body {
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
@php
    $newsItems = isset($data) ? $data : (isset($news) ? $news : (isset($berita) ? $berita : collect()));
@endphp

<div class="content-wrapper news-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="news-wrap">
                <div class="news-breadcrumb">
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
            <div class="news-wrap">
                <div class="news-panel">
                    <div class="news-panel-header">
                        <div class="news-title-group">
                            <span class="news-kicker">Seputar P3M</span>
                            <h1>Kegiatan P3M</h1>
                            <p>Kelola publikasi kegiatan P3M Polibang, mulai dari judul, tanggal, gambar, kategori, hingga isi konten.</p>
                        </div>

                        <div class="news-header-actions">
                            <span class="news-count-pill">Total {{ count($newsItems) }} kegiatan</span>
                            <a href="{{ route('news.create') }}" class="btn-add-news">
                                <i class="fas fa-plus"></i>
                                Tambah
                            </a>
                        </div>
                    </div>

                    <div class="news-panel-body table-responsive">
                        <table id="newsTable" class="table news-table">
                            <colgroup>
                                <col style="width: 58px;">
                                <col style="width: 38%;">
                                <col style="width: 12%;">
                                <col style="width: 16%;">
                                <col style="width: 16%;">
                                <col style="width: 120px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kegiatan</th>
                                    <th>Tanggal</th>
                                    <th>Pembuat</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newsItems as $d)
                                    @php
                                        $imagePath = !empty($d->image) ? 'storage/photo-news/'.$d->image : null;
                                        $imageExists = $imagePath && file_exists(public_path($imagePath));
                                        $categoryName = optional($d->category)->name
                                            ?? optional($d->categories)->name
                                            ?? optional($d->kategori)->name
                                            ?? ($d->category_name ?? $d->kategori_name ?? '-');
                                        $authorName = optional($d->user)->name ?? optional($d->users)->name ?? ($d->pembuat ?? '-');
                                    @endphp
                                    <tr>
                                        <td class="news-no">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="news-title-cell">
                                                @if($imageExists)
                                                    <img src="{{ asset($imagePath) }}" alt="{{ $d->title }}" class="news-thumb">
                                                @else
                                                    <span class="news-thumb-fallback">
                                                        <i class="fas fa-newspaper"></i>
                                                    </span>
                                                @endif

                                                <div>
                                                    <span class="news-title">{{ $d->title }}</span>
                                                    <span class="news-excerpt">{{ \Illuminate\Support\Str::words(strip_tags($d->content), 12) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="news-date">{{ $d->date ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="news-author">{{ $authorName }}</span>
                                        </td>
                                        <td>
                                            <span class="category-badge">{{ $categoryName }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="action-buttons">
                                                <a href="{{ route('news.read', ['id' => $d->id]) }}" class="btn btn-view-news" title="Lihat Kegiatan">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('news.edit', ['id' => $d->id]) }}" class="btn btn-edit-news" title="Edit Kegiatan">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a href="{{ route('news.delete', ['id' => $d->id]) }}" class="btn btn-delete-news" title="Hapus Kegiatan" onclick="return confirm('Yakin ingin menghapus kegiatan ini?')">
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

@section('script')
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
    $(function() {
        $('#newsTable').DataTable({
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
                emptyTable: "Belum ada data kegiatan"
            }
        });
    });
</script>
@endsection
