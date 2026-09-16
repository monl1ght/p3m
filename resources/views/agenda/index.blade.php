@extends('layout.main')

@section('body_class', 'page-users')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
/* ================================================================
   P3M — Agenda Page — Premium SaaS Redesign
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

.agenda-main-cell { display: flex; align-items: flex-start; gap: 14px; }
.agenda-icon {
    width: 44px; height: 44px; border-radius: var(--r-md); flex-shrink: 0;
    background: var(--forest-soft); color: var(--forest); border: 1px solid #c2dece;
    display: flex; align-items: center; justify-content: center; font-size: 18px; margin-top: 2px;
}
.agenda-title { display: block; font-size: 14px; font-weight: 800; color: var(--ink); line-height: 1.35; margin-bottom: 6px; }

.agenda-meta-inline { display: flex; flex-wrap: wrap; gap: 6px; }
.agenda-mini-pill {
    display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px;
    border-radius: 99px; background: var(--surface-alt); border: 1px solid var(--border-2);
    color: var(--muted); font-size: 11.5px; font-weight: 700;
}
.agenda-mini-pill i { color: var(--forest); font-size: 11px; }

.agenda-schedule { display: flex; flex-direction: column; gap: 4px; }
.agenda-schedule strong { color: var(--ink); font-size: 13.5px; font-weight: 800; }
.agenda-schedule span { display: inline-flex; align-items: center; gap: 6px; color: var(--muted); font-size: 12.5px; font-weight: 600; }
.agenda-schedule i { color: var(--forest-mid); font-size: 12px; }

.agenda-location { display: flex; align-items: flex-start; gap: 8px; color: var(--tx); font-size: 13px; font-weight: 600; line-height: 1.5; }
.agenda-location i { color: var(--forest-mid); font-size: 13px; margin-top: 2px; }

.agenda-note { display: block; color: var(--muted); font-size: 13px; line-height: 1.6; }

.action-wrap { display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-icon {
    width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
    border: 1.5px solid transparent; border-radius: var(--r-sm); font-size: 13px;
    cursor: pointer; transition: all .18s ease; background: transparent; padding: 0;
}
.btn-icon-view { background: var(--info-soft); color: var(--info); border-color: #bae6fd; }
.btn-icon-view:hover { background: var(--info); color: #fff; border-color: var(--info); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(2,132,199,.22); }
.btn-icon-edit { background: var(--forest-soft); color: var(--forest); border-color: #c2dece; }
.btn-icon-edit:hover { background: var(--forest); color: #fff; border-color: var(--forest); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,61,45,.22); }
.btn-icon-del { background: var(--danger-soft); color: var(--danger); border-color: #f5c0c0; }
.btn-icon-del:hover { background: var(--danger); color: #fff; border-color: var(--danger); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(217,75,75,.22); }

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
            <li class="breadcrumb-item active">Agenda Kegiatan P3M</li>
        </ol>
    </div>

    <section class="content">
        <div class="users-card">
            {{-- Card Header --}}
            <div class="users-card-head">
                <div>
                    <span class="card-eyebrow">Agenda P3M</span>
                    <h1 class="card-head-title">Agenda Kegiatan P3M</h1>
                </div>
                <div class="card-head-actions">
                    <div class="stat-chip">
                        <i class="fas fa-calendar-alt"></i>
                        Total {{ count($data) }} agenda
                    </div>
                    <a href="{{ route('agenda.create') }}" class="btn-add-user">
                        <i class="fas fa-plus"></i> Tambah Agenda
                    </a>
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
                    <input type="text" class="search-input" id="tableSearch" placeholder="Cari nama agenda...">
                </div>
            </div>

            {{-- Table --}}
            <div class="users-table-wrap">
                <table class="table users-table" id="agendaTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Agenda</th>
                            <th width="15%">Jadwal</th>
                            <th width="20%">Lokasi</th>
                            <th width="15%">Ringkasan</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td class="row-num">{{ $loop->iteration }}</td>
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
                                        {{ \Illuminate\Support\Str::words(strip_tags(html_entity_decode($d->keterangan)), 10) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-wrap">
                                        <a href="{{ route('agenda.read', ['id' => $d->id]) }}" class="btn-icon btn-icon-view" title="Lihat Agenda">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('agenda.edit', ['id' => $d->id]) }}" class="btn-icon btn-icon-edit" title="Edit Agenda">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('agenda.delete', ['id' => $d->id]) }}" method="POST" class="d-inline" id="del-agenda-{{ $d->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-icon btn-icon-del"
                                                title="Hapus Agenda"
                                                data-p3m-delete
                                                data-type="Agenda"
                                                data-label="{{ Str::limit($d->title ?? 'Agenda', 40) }}"
                                                data-form-id="del-agenda-{{ $d->id }}">
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
@endsection

@section('scripts')
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
$(function () {
    var table = $('#agendaTable').DataTable({
        responsive: true,
        lengthChange: false,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: false,
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Cari nama agenda...",
            info: "Menampilkan _START_-_END_ dari _TOTAL_ data",
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next:     '<i class="fas fa-chevron-right"></i>'
            },
            emptyTable: "Belum ada data agenda",
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
});
</script>
@endsection
