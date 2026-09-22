<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="turbo-root" content="/">
    <title>Dosen P3M POLIBANG</title>

    <link rel="shortcut icon" href="{{ asset('favicon/icon_log.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon/icon_log.ico') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}" data-turbo-track="reload">
    <link rel="stylesheet"
        href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"
        data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"
        data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}" data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}" data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}"
        data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}"
        data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}"
        data-turbo-track="reload">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.0/ckeditor5.css">

    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}"
        data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"
        data-turbo-track="reload">

    <link rel="stylesheet" href="{{ asset('css/p3m-admin.css') }}?v={{ file_exists(public_path('css/p3m-admin.css')) ? filemtime(public_path('css/p3m-admin.css')) : time() }}" data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('css/p3m-dosen.css') }}?v={{ file_exists(public_path('css/p3m-dosen.css')) ? filemtime(public_path('css/p3m-dosen.css')) : time() }}" data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('lte/plugins/sweetalert2/sweetalert2.min.css') }}" data-turbo-track="reload">
    <script src="{{ asset('lte/plugins/sweetalert2/sweetalert2.all.min.js') }}" data-turbo-eval="false"></script>

    {{-- SPA Turbo Drive --}}
    <script type="module" src="{{ asset('js/turbo.esm.js') }}"></script>
    <style>
        /* ── Turbo progress bar ── */
        .turbo-progress-bar {
            height: 3px;
            background: linear-gradient(90deg, #31b777, #0d6e53, #b99835);
            box-shadow: 0 0 10px rgba(49, 183, 119, 0.45);
        }

        /* ── Silky smooth SPA page transitions ── */
        .content-wrapper {
            will-change: auto;
        }

        .dosen-page-exit {
            opacity: .72 !important;
        }

        .dosen-page-enter {
            animation: dosenPageIn .18s cubic-bezier(.16, 1, .3, 1) both;
        }

        @keyframes dosenPageIn {
            0% {
                opacity: .72;
                transform: translateY(3px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed p3m-admin-elegant p3m-dosen-shell @yield('body_class')"
    data-turbo="false">

    <div class="wrapper">

        @php
            $navAvatarPath = !empty($user->image) ? 'storage/photo-user/' . $user->image : null;
            $navAvatarExists = $navAvatarPath && file_exists(public_path($navAvatarPath));
            $navInitial = strtoupper(substr($user->name ?? 'D', 0, 1));
        @endphp

        <nav class="main-header navbar navbar-expand navbar-white navbar-light dosen-topbar" id="dosen-topnav"
            data-turbo-permanent>

            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link dosen-menu-toggle" data-widget="pushmenu" href="#" role="button"
                        aria-label="Toggle sidebar" data-turbo="false">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>

                <li class="nav-item d-none d-sm-flex">
                    <div class="dosen-topbar-breadcrumb">
                        <span class="dosen-topbar-workspace">Dosen Workspace</span>
                        <i class="fas fa-chevron-right dosen-topbar-sep"></i>
                        <span class="dosen-topbar-page" id="js-topbar-page">Dashboard</span>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto align-items-center dosen-topbar-actions">

                <li class="nav-item d-none d-md-flex">
                    <a href="{{ route('tampilan') }}" class="dosen-website-btn" target="_blank" rel="noopener"
                        data-turbo="false">
                        <i class="fas fa-globe"></i>
                        <span>Website P3M</span>
                    </a>
                </li>

                <li class="nav-item dosen-topbar-divider d-none d-md-flex"></li>

                <li class="nav-item dropdown d-none d-sm-flex">
                    <button type="button" class="dosen-user-chip" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-turbo="false" id="dosenUserDropdownTrigger">
                        <div class="dosen-user-avatar">
                            @if ($navAvatarExists)
                                <img src="{{ asset($navAvatarPath) }}" alt="{{ $user->name }}">
                            @else
                                {{ $navInitial }}
                            @endif
                        </div>

                        <div class="dosen-user-info">
                            <span class="dosen-user-name">{{ $user->name }}</span>
                            <span class="dosen-user-role">Dosen POLIBANG</span>
                        </div>
                        <i class="fas fa-chevron-down dosen-user-caret"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right dosen-user-dropdown"
                        aria-labelledby="dosenUserDropdownTrigger">
                        <div class="dosen-dropdown-header">
                            <span class="dosen-dropdown-name">{{ $user->name }}</span>
                            <span class="dosen-dropdown-role">Dosen POLIBANG</span>
                        </div>

                        <div class="dosen-dropdown-body">
                            <a href="{{ route('dosen.profil', ['id' => Auth::user()->id]) }}" data-turbo="true"
                                class="dropdown-item dosen-dropdown-item">
                                <i class="fas fa-user-circle"></i>
                                <span>Profil Saya</span>
                            </a>

                            <hr class="dosen-dropdown-divider">

                            <form action="{{ route('logout') }}" method="POST" id="dosen-nav-logout-form">
                                @csrf
                                <button type="button" class="dropdown-item dosen-dropdown-item dosen-dropdown-logout"
                                    id="js-nav-logout-btn">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout Akun</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </li>

            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4 dosen-sidebar" id="p3m-sidebar"
            data-turbo-permanent>
            <a href="{{ route('dosen.dash') }}" class="dosen-brand" data-turbo="true">
                <div class="dosen-brand-logo">
                    <img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M">
                </div>

                <div class="dosen-brand-copy">
                    <strong>P3M POLIBANG</strong>
                    <span>DOSEN WORKSPACE</span>
                </div>
            </a>

            <div class="sidebar">

                @php
                    $avatarPath = !empty($user->image) ? 'storage/photo-user/' . $user->image : null;
                    $avatarExists = $avatarPath && file_exists(public_path($avatarPath));
                    $avatarInitial = strtoupper(substr($user->name ?? 'D', 0, 1));
                @endphp

                <div class="dosen-sidebar-user">
                    <div class="dosen-sidebar-avatar">
                        @if ($avatarExists)
                            <img src="{{ asset($avatarPath) }}" alt="{{ $user->name ?? 'User' }}">
                        @else
                            <span>{{ $avatarInitial }}</span>
                        @endif
                    </div>

                    <div class="dosen-sidebar-user-copy">
                        <a href="{{ route('dosen.profil', ['id' => Auth::user()->id]) }}"
                            data-turbo="true">{{ $user->name }}</a>
                        <span>Dosen POLIBANG</span>
                    </div>
                </div>

                <div class="dosen-sidebar-search">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu..."
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar" type="button" aria-label="Cari">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="dosen-navigation mt-2" data-turbo="true">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ route('dosen.dash') }}" data-turbo="true"
                                class="nav-link dosen-nav-link {{ request()->routeIs('dosen.dash') ? 'active' : '' }}"
                                @if (request()->routeIs('dosen.dash')) aria-current="page" @endif>
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard Dosen</p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('dosen.profil*') ? 'menu-open' : '' }}">
                            <a href="#" data-turbo="false" role="button" aria-controls="dosen-nav-profil"
                                aria-expanded="{{ request()->routeIs('dosen.profil*') ? 'true' : 'false' }}"
                                class="nav-link dosen-nav-link {{ request()->routeIs('dosen.profil*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>
                                    Profil
                                    <i class="right fas fa-chevron-right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview" id="dosen-nav-profil">
                                <li class="nav-item">
                                    <a href="{{ route('dosen.profil', ['id' => Auth::user()->id]) }}"
                                        data-turbo="true"
                                        class="nav-link dosen-child-link {{ request()->routeIs('dosen.profil*') ? 'active' : '' }}"
                                        @if (request()->routeIs('dosen.profil*')) aria-current="page" @endif>
                                        <i class="nav-icon fas fa-id-card"></i>
                                        <p>Setting Akun</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @php
                            $currentJurnalKat = request('kategori') ?? ($kategori ?? ($jurnal->kategori ?? null));
                            $isJurnalPengabdian =
                                request()->routeIs('dosen.jurnal_upload.*') && $currentJurnalKat === 'pengabdian';
                            $isJurnalPenelitian =
                                request()->routeIs('dosen.jurnal_upload.*') &&
                                ($currentJurnalKat === 'penelitian' || !$currentJurnalKat);
                        @endphp

                        <li
                            class="nav-item {{ request()->routeIs('dosen.upp3m', 'dosen.addp3m', 'dosen.edit_ajupengab', 'dosen.dash_kpengabdian', 'dosen.addkpengabdian', 'dosen.edit_kpengabdian') || $isJurnalPengabdian ? 'menu-open' : '' }}">
                            <a href="#" data-turbo="false" role="button" aria-controls="dosen-nav-pengabdian"
                                aria-expanded="{{ request()->routeIs('dosen.upp3m', 'dosen.addp3m', 'dosen.edit_ajupengab', 'dosen.dash_kpengabdian', 'dosen.addkpengabdian', 'dosen.edit_kpengabdian') || $isJurnalPengabdian ? 'true' : 'false' }}"
                                class="nav-link dosen-nav-link {{ request()->routeIs('dosen.upp3m', 'dosen.addp3m', 'dosen.edit_ajupengab', 'dosen.dash_kpengabdian', 'dosen.addkpengabdian', 'dosen.edit_kpengabdian') || $isJurnalPengabdian ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hand-holding-heart"></i>
                                <p>
                                    Pengabdian Masyarakat
                                    <i class="right fas fa-chevron-right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview" id="dosen-nav-pengabdian">
                                <li class="nav-item">
                                    <a href="{{ route('dosen.upp3m') }}" data-turbo="true"
                                        class="nav-link dosen-child-link {{ request()->routeIs('dosen.upp3m', 'dosen.addp3m', 'dosen.edit_ajupengab') ? 'active' : '' }}"
                                        @if (request()->routeIs('dosen.upp3m', 'dosen.addp3m', 'dosen.edit_ajupengab')) aria-current="page" @endif>
                                        <i class="nav-icon far fa-file-alt"></i>
                                        <p>Pengajuan Pengabdian</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('dosen.dash_kpengabdian') }}" data-turbo="true"
                                        class="nav-link dosen-child-link {{ request()->routeIs('dosen.dash_kpengabdian', 'dosen.addkpengabdian', 'dosen.edit_kpengabdian') ? 'active' : '' }}"
                                        @if (request()->routeIs('dosen.dash_kpengabdian', 'dosen.addkpengabdian', 'dosen.edit_kpengabdian')) aria-current="page" @endif>
                                        <i class="nav-icon fas fa-folder-open"></i>
                                        <p>Laporan Pengabdian</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('dosen.jurnal_upload.index', ['kategori' => 'pengabdian']) }}"
                                        data-turbo="true"
                                        class="nav-link dosen-child-link {{ $isJurnalPengabdian ? 'active' : '' }}"
                                        @if ($isJurnalPengabdian) aria-current="page" @endif>
                                        <i class="nav-icon fas fa-file-upload"></i>
                                        <p>Upload Jurnal Pengabdian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="nav-item {{ request()->routeIs('dosen.dash_ajuanpenelitian', 'dosen.add_ajuanpenelitian', 'dosen.edit_ajuanpenelitian', 'dosen.dash_kpenelitian', 'dosen.add_kumnpeneliti', 'dosen.edit_kpenliti') || $isJurnalPenelitian ? 'menu-open' : '' }}">
                            <a href="#" data-turbo="false" role="button" aria-controls="dosen-nav-penelitian"
                                aria-expanded="{{ request()->routeIs('dosen.dash_ajuanpenelitian', 'dosen.add_ajuanpenelitian', 'dosen.edit_ajuanpenelitian', 'dosen.dash_kpenelitian', 'dosen.add_kumnpeneliti', 'dosen.edit_kpenliti') || $isJurnalPenelitian ? 'true' : 'false' }}"
                                class="nav-link dosen-nav-link {{ request()->routeIs('dosen.dash_ajuanpenelitian', 'dosen.add_ajuanpenelitian', 'dosen.edit_ajuanpenelitian', 'dosen.dash_kpenelitian', 'dosen.add_kumnpeneliti', 'dosen.edit_kpenliti') || $isJurnalPenelitian ? 'active' : '' }}">
                                <i class="nav-icon fas fa-microscope"></i>
                                <p>
                                    Penelitian
                                    <i class="right fas fa-chevron-right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview" id="dosen-nav-penelitian">
                                <li class="nav-item">
                                    <a href="{{ route('dosen.dash_ajuanpenelitian') }}" data-turbo="true"
                                        class="nav-link dosen-child-link {{ request()->routeIs('dosen.dash_ajuanpenelitian', 'dosen.add_ajuanpenelitian', 'dosen.edit_ajuanpenelitian') ? 'active' : '' }}"
                                        @if (request()->routeIs('dosen.dash_ajuanpenelitian', 'dosen.add_ajuanpenelitian', 'dosen.edit_ajuanpenelitian')) aria-current="page" @endif>
                                        <i class="nav-icon far fa-file-alt"></i>
                                        <p>Pengajuan Penelitian</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('dosen.dash_kpenelitian') }}" data-turbo="true"
                                        class="nav-link dosen-child-link {{ request()->routeIs('dosen.dash_kpenelitian', 'dosen.add_kumnpeneliti', 'dosen.edit_kpenliti') ? 'active' : '' }}"
                                        @if (request()->routeIs('dosen.dash_kpenelitian', 'dosen.add_kumnpeneliti', 'dosen.edit_kpenliti')) aria-current="page" @endif>
                                        <i class="nav-icon fas fa-folder-open"></i>
                                        <p>Laporan Penelitian</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('dosen.jurnal_upload.index', ['kategori' => 'penelitian']) }}"
                                        data-turbo="true"
                                        class="nav-link dosen-child-link {{ $isJurnalPenelitian ? 'active' : '' }}"
                                        @if ($isJurnalPenelitian) aria-current="page" @endif>
                                        <i class="nav-icon fas fa-file-upload"></i>
                                        <p>Upload Jurnal Penelitian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('dosen.hki.index') }}" data-turbo="true"
                                class="nav-link dosen-nav-link {{ request()->routeIs('dosen.hki.*') ? 'active' : '' }}"
                                @if (request()->routeIs('dosen.hki.*')) aria-current="page" @endif>
                                <i class="nav-icon fas fa-award"></i>
                                <p>Hak Kekayaan Intelektual</p>
                            </a>
                        </li>

                        <li class="nav-item dosen-logout-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link dosen-logout-link">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>Logout Akun</p>
                                </button>
                            </form>
                        </li>

                    </ul>
                </nav>

            </div>
        </aside>

        @yield('content')

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    @include('components.global-alert')

    {{-- Global upload validator: manages inputs named "uppdf" (PDF, max 5 MB)
         and "foto" (JPG/PNG, max 2 MB). Profile photo (name="image") is not
         intercepted by this component. --}}
    @include('components.upload-validation')

    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}" data-turbo-eval="false"></script>
    <script data-turbo-eval="false">
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/sparklines/sparkline.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/jqvmap/jquery.vmap.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/jquery-knob/jquery.knob.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/moment/moment.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/daterangepicker/daterangepicker.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"
        data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}" data-turbo-eval="false">
    </script>
    <script src="{{ asset('lte/dist/js/adminlte.js') }}" data-turbo-eval="false"></script>
    {{-- CKEditor loaded after jQuery, with data-turbo-eval="false" so it is never re-evaluated on Turbo visits --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js" data-turbo-eval="false"></script>

    {{-- DataTables plugins loaded globally once with data-turbo-eval="false" so SPA visits never fail --}}
    <script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}" data-turbo-eval="false">
    </script>
    <script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}" data-turbo-eval="false">
    </script>
    <script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}" data-turbo-eval="false"></script>

    {{-- Global DataTables Row Numbering: ensures visible rows are always sequentially numbered starting from 1 --}}
    <script data-turbo-eval="false">
        $(document).on('draw.dt', function(e, settings) {
            try {
                var api = new $.fn.dataTable.Api(settings);
                var info = api.page.info();
                if (!info || info.recordsDisplay === 0) return;
                var headerCol0 = $(api.column(0).header());
                var headerText = headerCol0.text().trim().toLowerCase();
                if (headerText === 'no' || headerText === '#' || headerText === 'no.' || headerCol0.hasClass('col-num')) {
                    api.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
                        var num = i + 1 + info.start;
                        var rowNumEl = cell.querySelector('.row-num, .upp3m-row-num');
                        if (rowNumEl) {
                            rowNumEl.textContent = num;
                        } else {
                            cell.innerHTML = num;
                        }
                    });
                }
            } catch (err) {
                // Ignore non-compatible tables
            }
        });
    </script>

    <script data-turbo-eval="false">
        (function() {
            'use strict';

            /*
             * Dosen Workspace — Enterprise SPA Navigation Layer
             *
             * - Turbo Drive handles seamless page-to-page navigation.
             * - Sidebar & topbar are data-turbo-permanent (no re-renders / zero flickering).
             * - destinationUrl captured on turbo:before-visit to sync sidebar on turbo:before-render.
             * - Treeview open/closed display properties are managed explicitly.
             * - Silky 60fps fade+slide entrance/exit animations.
             */

            const SIDEBAR_SELECTOR = '#p3m-sidebar';
            const NAV_LINK_SELECTOR = `${SIDEBAR_SELECTOR} a.nav-link[href]`;
            const SIDEBAR_SCROLL_KEY = 'p3m.dosen.navigation.sidebar-scroll';

            let destinationUrl = null;
            let isRestoringScroll = false;

            /* ── Utilities ─────────────────────────────────────────────────── */

            function getSidebar() {
                return document.querySelector(SIDEBAR_SELECTOR);
            }

            function getSidebarScrollContainer() {
                const sidebar = getSidebar();
                if (!sidebar) return null;

                // Priority 1: OverlayScrollbars viewport (used by AdminLTE layout-fixed)
                const osViewport = sidebar.querySelector('.os-viewport');
                if (osViewport) return osViewport;

                // Priority 2: AdminLTE .sidebar wrapper
                const sidebarDiv = sidebar.querySelector('.sidebar');
                if (sidebarDiv) return sidebarDiv;

                return sidebar;
            }

            function getOverlayScrollbarsInstance() {
                const sidebar = getSidebar();
                if (!sidebar) return null;
                const target = sidebar.querySelector('.sidebar') || sidebar;
                if (typeof $ !== 'undefined' && typeof $(target).overlayScrollbars === 'function') {
                    return $(target).overlayScrollbars();
                }
                return null;
            }

            function getSidebarScrollTop() {
                const osInstance = getOverlayScrollbarsInstance();
                if (osInstance && typeof osInstance.scroll === 'function') {
                    const scrollInfo = osInstance.scroll();
                    if (scrollInfo && scrollInfo.position && typeof scrollInfo.position.y === 'number') {
                        return scrollInfo.position.y;
                    }
                }
                const container = getSidebarScrollContainer();
                return container ? (container.scrollTop || 0) : 0;
            }

            function setSidebarScrollTop(scrollTop) {
                const targetY = Math.max(0, Number(scrollTop) || 0);

                const container = getSidebarScrollContainer();
                if (container) {
                    container.scrollTop = targetY;
                }

                const osInstance = getOverlayScrollbarsInstance();
                if (osInstance && typeof osInstance.scroll === 'function') {
                    try {
                        osInstance.scroll({ y: targetY });
                    } catch (e) {}
                }
            }

            function saveSidebarScrollPosition() {
                if (isRestoringScroll) return;
                try {
                    const top = getSidebarScrollTop();
                    sessionStorage.setItem(SIDEBAR_SCROLL_KEY, String(top));
                } catch (e) {
                    // Safe fallback if storage unavailable
                }
            }

            function getSavedSidebarScrollPosition() {
                try {
                    const val = Number(sessionStorage.getItem(SIDEBAR_SCROLL_KEY));
                    return Number.isFinite(val) && val >= 0 ? val : 0;
                } catch (e) {
                    return 0;
                }
            }

            function ensureActiveLinkVisible() {
                const sidebar = getSidebar();
                if (!sidebar) return;

                const activeLink =
                    sidebar.querySelector('.nav-treeview .nav-link.active') ||
                    sidebar.querySelector('.nav-link.active:not([href="#"])');

                if (!activeLink) return;

                const container = getSidebarScrollContainer();
                if (!container) return;

                const containerRect = container.getBoundingClientRect();
                const linkRect = activeLink.getBoundingClientRect();

                // Only adjust if the active link is partially or completely outside the visible viewport
                if (linkRect.top < containerRect.top || linkRect.bottom > containerRect.bottom) {
                    activeLink.scrollIntoView({ block: 'nearest', behavior: 'instant' });
                    // Re-save adjusted scroll
                    const newTop = getSidebarScrollTop();
                    try {
                        sessionStorage.setItem(SIDEBAR_SCROLL_KEY, String(newTop));
                    } catch (e) {}
                }
            }

            function restoreSidebarScrollPosition(targetPosition) {
                const saved = typeof targetPosition === 'number' ? targetPosition : getSavedSidebarScrollPosition();
                isRestoringScroll = true;

                function apply() {
                    setSidebarScrollTop(saved);
                }

                // Phase 1: immediate application
                apply();

                // Phase 2: next frame after DOM mutations
                requestAnimationFrame(() => {
                    apply();

                    // Phase 3: frame after layout rendering
                    requestAnimationFrame(() => {
                        apply();
                        ensureActiveLinkVisible();
                        isRestoringScroll = false;
                    });
                });
            }

            function withTreeviewTransitionsDisabled(callback) {
                const sidebar = getSidebar();
                if (!sidebar) {
                    callback();
                    return;
                }

                const treeviews = Array.from(sidebar.querySelectorAll('.nav-treeview'));
                const previousTransitions = treeviews.map(tv => ({
                    element: tv,
                    transition: tv.style.transition,
                    animation: tv.style.animation
                }));

                treeviews.forEach(tv => {
                    tv.style.transition = 'none';
                    tv.style.animation = 'none';
                });

                try {
                    callback();
                } finally {
                    requestAnimationFrame(() => {
                        previousTransitions.forEach(entry => {
                            entry.element.style.transition = entry.transition;
                            entry.element.style.animation = entry.animation;
                        });
                    });
                }
            }

            function normalizeUrl(url) {
                try {
                    const parsed = new URL(url, window.location.origin);
                    parsed.hash = '';
                    return parsed.href.replace(/\/$/, '');
                } catch {
                    return String(url || '').split('#')[0].replace(/\/$/, '');
                }
            }

            function findActiveLink(url) {
                const currentUrl = normalizeUrl(url);
                const sidebar = getSidebar();
                if (!sidebar) return null;

                const links = Array.from(sidebar.querySelectorAll(NAV_LINK_SELECTOR));
                let exactMatch = null;
                let bestMatch = null;
                let bestLength = 0;

                for (const link of links) {
                    const href = link.getAttribute('href');
                    if (!href || href === '#' || href.startsWith('javascript:')) continue;

                    const linkUrl = normalizeUrl(link.href);

                    if (linkUrl === currentUrl) {
                        exactMatch = link;
                        break;
                    }

                    if (linkUrl && currentUrl.startsWith(`${linkUrl}/`) && linkUrl.length > bestLength) {
                        bestLength = linkUrl.length;
                        bestMatch = link;
                    }
                }

                return exactMatch || bestMatch;
            }

            /* ── Sidebar sync ──────────────────────────────────────────────── */

            function syncSidebarState(url) {
                const sidebar = getSidebar();
                if (!sidebar) return;

                const activeLink = findActiveLink(url);
                const previousScroll = getSidebarScrollTop();

                withTreeviewTransitionsDisabled(() => {
                    /* Remove all active states first */
                    sidebar.querySelectorAll('.nav-link').forEach(link => {
                        link.classList.remove('active');
                        link.removeAttribute('aria-current');
                    });

                    if (!activeLink) {
                        updateTreeviewAccessibility(sidebar);
                        return;
                    }

                    activeLink.classList.add('active');
                    activeLink.setAttribute('aria-current', 'page');

                    /* Determine whether the active link lives inside a sub-menu */
                    const treeview = activeLink.closest('.nav-treeview');

                    if (treeview) {
                        /* Active link is inside a sub-menu: ensure its parent group is open and marked active */
                        const parentItem = treeview.closest('.nav-item');
                        if (parentItem) {
                            parentItem.classList.add('menu-open');
                            treeview.style.display = 'block';

                            const parentLink = parentItem.querySelector(':scope > .nav-link');
                            if (parentLink) parentLink.classList.add('active');
                        }
                    }
                    /*
                     * Note: With data-accordion="false", multiple dropdown groups can be opened simultaneously.
                     * We do NOT forcibly close sibling .menu-open groups so that groups opened by the user
                     * (e.g. Profil) remain open as the user browses sub-menus in another group (e.g. Penelitian).
                     */
                    updateTreeviewAccessibility(sidebar);
                });

                // Preserve scroll position during treeview updates
                setSidebarScrollTop(previousScroll);
            }

            function updateTreeviewAccessibility(sidebar = getSidebar()) {
                if (!sidebar) return;

                sidebar.querySelectorAll('.nav-item > .nav-link[aria-controls]').forEach(link => {
                    const item = link.closest('.nav-item');
                    link.setAttribute('aria-expanded', item?.classList.contains('menu-open') ? 'true' :
                    'false');
                });
            }

            /* ── Topbar breadcrumb ─────────────────────────────────────────── */

            function updateTopbarPage() {
                const pageElement = document.getElementById('js-topbar-page');
                if (!pageElement) return;

                const activeLink =
                    document.querySelector(`${SIDEBAR_SELECTOR} .nav-treeview .nav-link.active`) ||
                    document.querySelector(`${SIDEBAR_SELECTOR} .nav-link.active:not([href="#"])`);

                if (!activeLink) return;

                const paragraph = activeLink.querySelector('p');
                const pageName = paragraph ? paragraph.textContent.trim() : '';
                if (pageName) pageElement.textContent = pageName;
            }

            /* ── Per-page component init ───────────────────────────────────── */

            function initializeImagePreview() {
                const input = document.getElementById('image');
                const label = document.querySelector('.custom-file-label');
                const preview = document.getElementById('preview-image');

                if (!input || input.dataset.p3mPreviewReady === 'true') return;
                input.dataset.p3mPreviewReady = 'true';

                input.addEventListener('change', event => {
                    const file = event.target.files?.[0];
                    if (!file) return;
                    if (label) label.textContent = file.name;
                    if (!preview) return;

                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        preview.src = reader.result;
                    }, {
                        once: true
                    });
                    reader.readAsDataURL(file);
                });
            }

            function initializeEditor() {
                const editorElement = document.querySelector('#editor');
                if (!editorElement || !window.ClassicEditor || editorElement.classList.contains('ck-applied')) return;

                window.ClassicEditor
                    .create(editorElement)
                    .then(editor => {
                        window.editor = editor;
                        editorElement.classList.add('ck-applied');
                    })
                    .catch(error => console.error('CKEditor init failed:', error));
            }

            function initializePageComponents() {
                initializeEditor();
                initializeImagePreview();
            }

            /* ── Shell refresh (called after every navigation) ─────────────── */

            function refreshDosenShell(url) {
                syncSidebarState(url || window.location.href);
                updateTopbarPage();
                initializePageComponents();
                restoreSidebarScrollPosition();
            }

            /* ── Page enter animation ──────────────────────────────────────── */

            function triggerPageEnterAnimation() {
                const cw = document.querySelector('.content-wrapper');
                if (!cw || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                cw.classList.remove('dosen-page-enter', 'dosen-page-exit');
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => cw.classList.add('dosen-page-enter'));
                });
            }

            /* ── Browser & Turbo event hooks ───────────────────────────────── */

            // Prevent browser scroll fighting Turbo Drive
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }

            // Continuously listen to scroll events on sidebar elements to record scroll position
            document.addEventListener('scroll', function(e) {
                const target = e.target;
                if (target && (target.classList?.contains('os-viewport') || target.classList?.contains('sidebar') || target.closest?.(SIDEBAR_SELECTOR))) {
                    saveSidebarScrollPosition();
                }
            }, { passive: true, capture: true });

            // Capture exact scroll position immediately on navigation link click before transition begins
            if (typeof $ !== 'undefined') {
                $(document)
                    .off('mousedown.p3mDosenNav click.p3mDosenNav', `${SIDEBAR_SELECTOR} a.nav-link`)
                    .on('mousedown.p3mDosenNav click.p3mDosenNav', `${SIDEBAR_SELECTOR} a.nav-link`, function() {
                        const href = this.getAttribute('href');
                        if (!href || href === '#' || href.startsWith('javascript:')) return;

                        saveSidebarScrollPosition();
                        destinationUrl = normalizeUrl(this.href);
                    });
            }

            // Always save scroll position on window unload / pagehide (for standard non-Turbo navigations)
            window.addEventListener('beforeunload', saveSidebarScrollPosition);
            window.addEventListener('pagehide', saveSidebarScrollPosition);

            /* Close topbar dropdown before any navigation and start exit transition */
            document.addEventListener('turbo:before-visit', function(e) {
                destinationUrl = e.detail && e.detail.url ? e.detail.url : null;
                saveSidebarScrollPosition();

                if (typeof $ !== 'undefined') {
                    $('.dosen-user-dropdown').removeClass('show').closest('.dropdown').removeClass('show');
                    $('#dosenUserDropdownTrigger').attr('aria-expanded', 'false');
                }

                const cw = document.querySelector('.content-wrapper');
                if (cw) cw.classList.add('dosen-page-exit');
            });

            /* Sync sidebar active state & body class BEFORE DOM swap so menu highlights immediately */
            document.addEventListener('turbo:before-render', function(event) {
                if (event.detail && event.detail.newBody) {
                    document.body.className = event.detail.newBody.className;
                }
                if (destinationUrl) {
                    syncSidebarState(destinationUrl);
                    restoreSidebarScrollPosition();
                }
            });

            /* Sync sidebar + init page components on every Turbo load */
            document.addEventListener('turbo:load', function() {
                const url = destinationUrl || window.location.href;
                refreshDosenShell(url);
                triggerPageEnterAnimation();
                destinationUrl = null;
            });

            /* Strip the animation class before Turbo caches the page so the
               cached snapshot starts clean (no mid-animation state stored). */
            document.addEventListener('turbo:before-cache', function() {
                saveSidebarScrollPosition();
                const cw = document.querySelector('.content-wrapper');
                if (cw) cw.classList.remove('dosen-page-enter', 'dosen-page-exit');
            });

            /* Initial non-Turbo boot (first page load). */
            document.addEventListener('DOMContentLoaded', function() {
                refreshDosenShell();
                triggerPageEnterAnimation();
            }, {
                once: true
            });

            /* Also restore when window completes load (AdminLTE initializes OverlayScrollbars on window load) */
            window.addEventListener('load', function() {
                restoreSidebarScrollPosition();
                setTimeout(restoreSidebarScrollPosition, 60);
                setTimeout(restoreSidebarScrollPosition, 200);
            });

            /* Keep AdminLTE's visual treeview state and its ARIA contract in sync.
               Space activates role="button" controls just like a native button. */
            document.addEventListener('click', function(event) {
                const toggle = event.target.closest(`${SIDEBAR_SELECTOR} .nav-link[aria-controls]`);
                if (!toggle) return;

                /* Treeview controls are buttons, not hash navigation. Keeping the
                   scroll position here also protects it from AdminLTE's slide animation. */
                event.preventDefault();
                saveSidebarScrollPosition();
                const saved = getSavedSidebarScrollPosition();
                requestAnimationFrame(() => {
                    updateTreeviewAccessibility();
                    restoreSidebarScrollPosition(saved);
                });
            });

            document.addEventListener('keydown', function(event) {
                const toggle = event.target.closest(`${SIDEBAR_SELECTOR} .nav-link[role="button"]`);
                if (!toggle || event.key !== ' ') return;
                event.preventDefault();
                toggle.click();
            });

            /* ── Logout confirmation ───────────────────────────────────────── */

            /* Use event delegation so it works after Turbo replaces page content */
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('#js-nav-logout-btn, .dosen-logout-link');
                if (!btn) return;

                e.preventDefault();
                e.stopPropagation();

                const form = btn.closest('form');
                if (!form) return;

                if (typeof window.p3mConfirm === 'function') {
                    window.p3mConfirm({
                        title: 'Logout dari Akun?',
                        html: 'Anda akan keluar dari sesi Dosen Workspace saat ini.<br><span style="font-size:13px;color:#9ca3af;">Anda perlu login kembali untuk mengakses data.</span>',
                        icon: 'warning',
                        confirmText: '<i class="fas fa-sign-out-alt" style="font-size:12px;"></i>&nbsp; Ya, Logout',
                        confirmClass: 'p3m-swal-btn-danger',
                        onConfirm: function() {
                            form.submit();
                        }
                    });
                } else if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Logout dari Akun?',
                        text: 'Anda akan keluar dari sesi Dosen Workspace saat ini.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal'
                    }).then(result => {
                        if (result.isConfirmed) form.submit();
                    });
                } else {
                    if (confirm('Apakah Anda yakin ingin logout dari akun ini?')) form.submit();
                }
            });

        })();
    </script>

    {{-- Global Custom Dropdown System --}}
    <script src="{{ asset('js/p3m-dropdown.js') }}?v={{ file_exists(public_path('js/p3m-dropdown.js')) ? filemtime(public_path('js/p3m-dropdown.js')) : time() }}" data-turbo-eval="false" data-turbo-track="reload"></script>

    @yield('scripts')

    {{-- Global Image Cropper Component --}}
    <x-image-cropper />
</body>

</html>
