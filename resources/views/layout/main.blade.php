<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="turbo-root" content="/">
    <title>Sistem Informasi P3M POLIBANG</title>

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
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.0/ckeditor5.css" data-turbo-track="reload">

    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js" data-turbo-track="reload"></script>
    <link rel="stylesheet" href="{{ asset('css/p3m-admin.css') }}?v={{ file_exists(public_path('css/p3m-admin.css')) ? filemtime(public_path('css/p3m-admin.css')) : time() }}" data-turbo-track="reload">
    <link rel="stylesheet" href="{{ asset('lte/plugins/sweetalert2/sweetalert2.min.css') }}" data-turbo-track="reload">
    <script src="{{ asset('lte/plugins/sweetalert2/sweetalert2.all.min.js') }}" data-turbo-eval="false"></script>

    {{-- SPA Turbo Drive — local file, loaded early so it intercepts navigation before AdminLTE --}}
    <script type="module" src="{{ asset('js/turbo.esm.js') }}"></script>
    <style>
        .turbo-progress-bar {
            height: 3px;
            background: linear-gradient(90deg, #31b777, #0d6e53);
        }

        /* ── Silky smooth SPA page transitions ── */
        .content-wrapper {
            will-change: auto;
        }

        .admin-page-exit {
            opacity: .72 !important;
        }

        .admin-page-enter {
            animation: adminPageIn .18s cubic-bezier(.16, 1, .3, 1) both;
        }

        @keyframes adminPageIn {
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

<body class="hold-transition sidebar-mini layout-fixed p3m-admin-elegant @yield('body_class')" data-turbo="false">
    <div class="wrapper">
        @php
            $navAvatarPath = !empty($user->image) ? 'storage/photo-user/' . $user->image : null;
            $navAvatarExists = $navAvatarPath && file_exists(public_path($navAvatarPath));
            $navInitial = strtoupper(substr($user->name ?? 'A', 0, 1));
        @endphp
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" id="admin-topnav" data-turbo-permanent>
            {{-- Left: hamburger + breadcrumb --}}
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar"
                        data-turbo="false">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-flex">
                    <div class="admin-topbar-breadcrumb">
                        <span class="admin-topbar-workspace">Admin Workspace</span>
                        <i class="fas fa-chevron-right admin-topbar-sep"></i>
                        <span class="admin-topbar-page" id="js-admin-topbar-page">Dashboard</span>
                    </div>
                </li>
            </ul>

            {{-- Right: actions + user chip --}}
            <ul class="navbar-nav ml-auto align-items-center admin-topbar-actions">

                {{-- Lihat Website --}}
                <li class="nav-item d-none d-md-flex">
                    <a href="{{ route('tampilan') }}" class="topbar-website-btn admin-topbar-website" target="_blank"
                        rel="noopener" data-turbo="false">
                        <i class="fas fa-globe"></i>
                        <span>Website P3M</span>
                    </a>
                </li>

                <li class="nav-item admin-topbar-divider d-none d-md-flex"></li>

                {{-- Notification Bell --}}
                <li class="nav-item dropdown">
                    <a class="nav-link topbar-notif-btn p-0" data-toggle="dropdown" href="#"
                        aria-label="Notifikasi" data-turbo="false">
                        <i class="far fa-bell"></i>
                        @if (($totalNotif ?? 0) > 0)
                            <span class="notif-dot"></span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p3m-notif-dropdown">
                        <div class="p3m-notif-header">
                            <span class="p3m-notif-label">Notifikasi</span>
                            <span class="p3m-notif-badge">{{ $totalNotif ?? 0 }}</span>
                        </div>
                        @forelse(($notifikasi ?? collect()) as $n)
                            <form action="{{ route('notif.open', $n['tipe']) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="dropdown-item border-0 bg-transparent text-left w-100 p3m-notif-item">
                                    <i class="fas fa-circle p3m-notif-dot-icon"></i>
                                    {{ $n['judul'] }}
                                </button>
                            </form>
                        @empty
                            <div class="p3m-notif-empty">
                                <i class="far fa-bell-slash"></i>
                                Tidak ada aktivitas
                            </div>
                        @endforelse
                        @if (($totalNotif ?? 0) > 0)
                            <div class="p3m-notif-footer">
                                <a href="#">Lihat semua</a>
                            </div>
                        @endif
                    </div>
                </li>

                <li class="nav-item admin-topbar-divider d-none d-sm-flex"></li>

                {{-- User Chip Dropdown --}}
                <li class="nav-item dropdown d-none d-sm-flex">
                    <button type="button" class="topbar-user-chip" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-turbo="false" id="adminUserDropdownTrigger">
                        <div class="topbar-user-avatar">
                            @if ($navAvatarExists)
                                <img src="{{ asset($navAvatarPath) }}" alt="{{ $user->name }}">
                            @else
                                {{ $navInitial }}
                            @endif
                        </div>
                        <div class="topbar-user-info">
                            <span class="topbar-user-name">{{ $user->name }}</span>
                            <span class="topbar-user-role">Pengelola P3M</span>
                        </div>
                        <i class="fas fa-chevron-down admin-topbar-caret"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right dosen-user-dropdown"
                        aria-labelledby="adminUserDropdownTrigger">
                        <div class="dosen-dropdown-header">
                            <span class="dosen-dropdown-name">{{ $user->name }}</span>
                            <span class="dosen-dropdown-role">Pengelola P3M</span>
                        </div>

                        <div class="dosen-dropdown-body">
                            <a href="{{ route('dosen.profil', ['id' => Auth::user()->id]) }}"
                                class="dropdown-item dosen-dropdown-item">
                                <i class="fas fa-user-circle"></i>
                                <span>Profil Saya</span>
                            </a>

                            <hr class="dosen-dropdown-divider">

                            <form action="{{ route('logout') }}" method="POST" id="admin-nav-logout-form">
                                @csrf
                                <button type="button" class="dropdown-item dosen-dropdown-item dosen-dropdown-logout"
                                    id="js-admin-nav-logout-btn">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout Akun</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </li>

            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4" id="p3m-sidebar" data-turbo-permanent>
            <a href="{{ route('dash.dashadmin') }}" class="brand-link p3m-brand" data-turbo="true">
                <img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M">
                <span>
                    <strong>P3M Polibang</strong>
                    <span>Admin Panel</span>
                </span>
            </a>

            <div class="sidebar">

                @php
                    $avatarPath = !empty($user->image) ? 'storage/photo-user/' . $user->image : null;
                    $avatarExists = $avatarPath && file_exists(public_path($avatarPath));
                    $avatarInitial = strtoupper(substr($user->name ?? 'P', 0, 1));
                @endphp

                <div class="user-panel d-flex">
                    <div class="image">
                        @if ($avatarExists)
                            <img src="{{ asset($avatarPath) }}" alt="{{ $user->name ?? 'User' }}">
                        @else
                            <span class="admin-avatar">{{ $avatarInitial }}</span>
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('dosen.profil', ['id' => Auth::user()->id]) }}"
                            class="d-block">{{ $user->name }}</a>
                        <span class="user-role">Pengelola P3M</span>
                    </div>
                </div>

                <div class="form-inline mb-2">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu..."
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar" type="button">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2" data-turbo="true">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item {{ request()->routeIs('dash.*', 'index') ? 'menu-open' : '' }}">
                            <a href="#" data-turbo="false" role="button" aria-controls="admin-nav-utama"
                                aria-expanded="{{ request()->routeIs('dash.*', 'index') ? 'true' : 'false' }}"
                                class="nav-link {{ request()->routeIs('dash.*', 'index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Halaman Utama
                                    <i class="right fas fa-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" id="admin-nav-utama">
                                <li class="nav-item">
                                    <a href="{{ route('dash.dashboard') }}"
                                        class="nav-link {{ request()->routeIs('dash.dashboard', 'dash.create_dash', 'dash.edit_dash') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-clipboard-list"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index') }}"
                                        class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-user-shield"></i>
                                        <p>Admin</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="nav-item {{ request()->routeIs('pengelola.*', 'tentang.*', 'panduan.*') ? 'menu-open' : '' }}">
                            <a href="#" data-turbo="false" role="button" aria-controls="admin-nav-profil"
                                aria-expanded="{{ request()->routeIs('pengelola.*', 'tentang.*', 'panduan.*') ? 'true' : 'false' }}"
                                class="nav-link {{ request()->routeIs('pengelola.*', 'tentang.*', 'panduan.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-id-card-alt"></i>
                                <p>
                                    Profil P3M
                                    <i class="right fas fa-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" id="admin-nav-profil">
                                <li class="nav-item">
                                    <a href="{{ route('pengelola.index') }}"
                                        class="nav-link {{ request()->routeIs('pengelola.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Pengelola P3M</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('tentang.index') }}"
                                        class="nav-link {{ request()->routeIs('tentang.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-address-card"></i>
                                        <p>Tentang P3M</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('panduan.index') }}"
                                        class="nav-link {{ request()->routeIs('panduan.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-book-reader"></i>
                                        <p>Panduan P3M</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="nav-item {{ request()->routeIs('category.*', 'news.*', 'agenda.*', 'dokumen.*') ? 'menu-open' : '' }}">
                            <a href="#" data-turbo="false" role="button" aria-controls="admin-nav-seputar"
                                aria-expanded="{{ request()->routeIs('category.*', 'news.*', 'agenda.*', 'dokumen.*') ? 'true' : 'false' }}"
                                class="nav-link {{ request()->routeIs('category.*', 'news.*', 'agenda.*', 'dokumen.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>
                                    Seputar P3M
                                    <i class="right fas fa-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" id="admin-nav-seputar">
                                <li class="nav-item">
                                    <a href="{{ route('category.index') }}"
                                        class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-list-alt"></i>
                                        <p>Kategori Berita</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('news.index') }}"
                                        class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-newspaper"></i>
                                        <p>Kegiatan P3M</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('agenda.index') }}"
                                        class="nav-link {{ request()->routeIs('agenda.*') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-calendar-alt"></i>
                                        <p>Berita P3M</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('dokumen.index') }}"
                                        class="nav-link {{ request()->routeIs('dokumen.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-folder"></i>
                                        <p>Dokumen P3M</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @php
                            $isPengajuanLaporanActive = request()->routeIs(
                                'plppm.lpengabdian*',
                                'plppm.ppengabdian*',
                                'plppm.lpeneleitian*',
                                'plppm.ppenelitian*',
                                'plppm.kpengabdian*',
                                'plppm.kpenelitian*',
                                'plppm.kumpulan*',
                                'detail.detail*'
                            );
                        @endphp
                        <li class="nav-item {{ $isPengajuanLaporanActive ? 'menu-open' : '' }}">
                            <a href="#" data-turbo="false" role="button" aria-controls="admin-nav-pengajuan"
                                aria-expanded="{{ $isPengajuanLaporanActive ? 'true' : 'false' }}"
                                class="nav-link {{ $isPengajuanLaporanActive ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-signature"></i>
                                <p>
                                    Pengajuan & Laporan
                                    <i class="right fas fa-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" id="admin-nav-pengajuan">
                                <li class="nav-item">
                                    <a href="{{ route('plppm.lpengabdian') }}"
                                        class="nav-link {{ request()->routeIs('plppm.lpengabdian*') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-file"></i>
                                        <p>Pengajuan Pengabdian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('plppm.lpeneleitian') }}"
                                        class="nav-link {{ request()->routeIs('plppm.lpeneleitian*') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-file"></i>
                                        <p>Pengajuan Penelitian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('plppm.kpengabdian') }}"
                                        class="nav-link {{ request()->routeIs('plppm.kpengabdian*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-folder"></i>
                                        <p>Laporan Pengabdian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('plppm.kpenelitian') }}"
                                        class="nav-link {{ request()->routeIs('plppm.kpenelitian*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-folder"></i>
                                        <p>Laporan Penelitian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('plppm.jurnal_dosen') }}"
                                class="nav-link {{ request()->routeIs('plppm.jurnal_dosen*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>List Jurnal P3M</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('plppm.hki_dosen') }}"
                                class="nav-link {{ request()->routeIs('plppm.hki_dosen*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-award"></i>
                                <p>HKI Dosen</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('plppm.surat_keluar') }}"
                                class="nav-link {{ request()->routeIs('plppm.surat_keluar*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-paper-plane"></i>
                                <p>Riwayat Surat Keluar</p>
                            </a>
                        </li>

                        <li class="nav-item mt-2">
                            <form action="{{ route('logout') }}" method="POST" data-turbo="false">
                                @csrf
                                <button type="button" class="nav-link w-100 text-left border-0 bg-transparent admin-logout-link" id="js-admin-sidebar-logout-btn">
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
    @include('components.upload-validation')

    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}" data-turbo-eval="false"></script>
    <script data-turbo-eval="false">
        $.widget.bridge('uibutton', $.ui.button)
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

    {{-- DataTables plugins loaded globally once with data-turbo-eval="false" so SPA visits never fail --}}
    <script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}" data-turbo-eval="false"></script>
    <script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}" data-turbo-eval="false"></script>

    {{-- Global DataTables Row Numbering & Aesthetic Empty State --}}
    <script data-turbo-eval="false">
        if (typeof $.fn.dataTable !== 'undefined') {
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    emptyTable: `
                        <div class="upp3m-empty-state">
                            <span class="upp3m-empty-icon"><i class="fas fa-inbox"></i></span>
                            <span class="upp3m-empty-title">Belum ada data yang tersedia</span>
                            <span class="upp3m-empty-text">Data yang tersimpan akan tampil secara rapi pada tabel ini.</span>
                        </div>
                    `,
                    zeroRecords: `
                        <div class="upp3m-empty-state">
                            <span class="upp3m-empty-icon"><i class="fas fa-search"></i></span>
                            <span class="upp3m-empty-title">Tidak ada hasil pencarian</span>
                            <span class="upp3m-empty-text">Coba ubah kata kunci pencarian agar data yang dicari lebih mudah ditemukan.</span>
                        </div>
                    `
                }
            });
        }

        $(document).on('draw.dt', function(e, settings) {
            try {
                var api = new $.fn.dataTable.Api(settings);
                var info = api.page.info();

                // Global Empty State Formatter: transform plain empty table cells into premium aesthetic cards
                var $emptyCell = $(settings.nTable).find('tbody td.dataTables_empty');
                if ($emptyCell.length && !$emptyCell.find('.upp3m-empty-state').length) {
                    var rawText = $emptyCell.text().trim();
                    var isSearch = Boolean((settings.oPreviousSearch && settings.oPreviousSearch.sSearch) ||
                        rawText.toLowerCase().includes('pencarian') ||
                        rawText.toLowerCase().includes('cocok'));

                    var icon = isSearch ? 'fa-search' : 'fa-inbox';
                    var title = '';
                    var subtext = '';

                    if (isSearch) {
                        title = 'Tidak ada hasil pencarian';
                        subtext = 'Coba ubah kata kunci pencarian agar data yang dicari lebih mudah ditemukan.';
                    } else {
                        var isGeneric = !rawText ||
                            rawText.includes('No data available') ||
                            rawText.includes('Tidak ada data yang tersedia') ||
                            rawText.includes('Belum ada data yang tersedia');

                        if (!isGeneric) {
                            title = rawText;
                        } else {
                            var contextTitle = $('.breadcrumb-item.active, .users-card-head h2, .users-card-head h3, .users-card-head h4').first().text().trim();
                            title = contextTitle ? 'Belum ada data ' + contextTitle.toLowerCase() : 'Belum ada data yang diunggah';
                        }
                        subtext = 'Data yang masuk atau diunggah akan tampil secara rapi pada tabel ini.';
                    }

                    $emptyCell.html(
                        '<div class="upp3m-empty-state">' +
                            '<span class="upp3m-empty-icon"><i class="fas ' + icon + '"></i></span>' +
                            '<span class="upp3m-empty-title">' + title + '</span>' +
                            '<span class="upp3m-empty-text">' + subtext + '</span>' +
                        '</div>'
                    );
                }

                // Global Footer Safety Formatter for 0 records
                if (info && (info.recordsTotal === 0 || info.recordsDisplay === 0)) {
                    var $tableContainer = $(settings.nTable).closest('.users-card, .p3m-card, .card, section.content');
                    var $footerInfo = $tableContainer.find('#tableInfo, #js-table-info, .table-info-text');
                    if ($footerInfo.length) {
                        var currentText = $footerInfo.text().trim();
                        if (!currentText || currentText === 'Menampilkan data' || currentText === 'Menampilkan 0 dari 0 data' || currentText === 'Menampilkan 0-0 dari 0 data') {
                            $footerInfo.text('Menampilkan 0–0 dari 0 data');
                        }
                    }
                }

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
        /**
         * P3M ADMIN — STABLE NAVIGATION LAYER
         *
         * Goals:
         * - Keep page/sidebar scroll stable during Turbo navigation.
         * - Keep the permanent sidebar responsive.
         * - Update active navigation using the DESTINATION URL.
         * - Avoid repeated teardown/rebuild of treeview state.
         * - Avoid forced inline display changes that trigger layout jumps.
         * - Register listeners once and safely re-use them across Turbo visits.
         */
        (function() {
            'use strict';

            const PAGE_SCROLL_KEY = 'p3m.admin.navigation.page-scroll';
            const SIDEBAR_SCROLL_KEY = 'p3m.admin.navigation.sidebar-scroll';

            let navigationState = {
                destinationUrl: null,
                restoring: false
            };

            function getPageScrollElement() {
                return document.scrollingElement || document.documentElement;
            }

            function getSidebarScrollElement() {
                const sidebar = document.getElementById('p3m-sidebar');

                if (!sidebar) {
                    return null;
                }

                // OverlayScrollbars may create a dedicated viewport.
                return sidebar.querySelector('.os-viewport') ||
                    sidebar.querySelector('.sidebar') ||
                    sidebar;
            }

            function normalizeUrl(url) {
                try {
                    const parsed = new URL(url, window.location.origin);
                    parsed.hash = '';
                    return parsed.href;
                } catch (error) {
                    return String(url || '').split('#')[0];
                }
            }

            function isInternalTurboUrl(url) {
                try {
                    const parsed = new URL(url, window.location.href);

                    if (parsed.origin !== window.location.origin) {
                        return false;
                    }

                    // Let normal browser/Turbo hash navigation handle in-page anchors.
                    if (
                        parsed.pathname === window.location.pathname &&
                        parsed.search === window.location.search &&
                        parsed.hash
                    ) {
                        return false;
                    }

                    return true;
                } catch (error) {
                    return false;
                }
            }

            function readNumber(key) {
                try {
                    const value = Number(sessionStorage.getItem(key));
                    return Number.isFinite(value) && value >= 0 ? value : 0;
                } catch (error) {
                    return 0;
                }
            }

            function saveNavigationScroll() {
                const pageScroller = getPageScrollElement();
                const sidebarScroller = getSidebarScrollElement();

                try {
                    sessionStorage.setItem(
                        PAGE_SCROLL_KEY,
                        String(pageScroller ? pageScroller.scrollTop : window.scrollY || 0)
                    );

                    if (sidebarScroller) {
                        sessionStorage.setItem(
                            SIDEBAR_SCROLL_KEY,
                            String(sidebarScroller.scrollTop || 0)
                        );
                    }
                } catch (error) {
                    // Navigation remains fully functional if storage is unavailable.
                }
            }

            function getSavedNavigationScroll() {
                return {
                    page: readNumber(PAGE_SCROLL_KEY),
                    sidebar: readNumber(SIDEBAR_SCROLL_KEY)
                };
            }

            function setScrollPosition(position) {
                const pageScroller = getPageScrollElement();
                const sidebarScroller = getSidebarScrollElement();

                if (pageScroller) {
                    pageScroller.scrollTop = position.page;
                    window.scrollTo(0, position.page);
                }

                if (sidebarScroller) {
                    sidebarScroller.scrollTop = position.sidebar;
                }
            }

            function ensureAdminActiveLinkVisible() {
                const sidebar = document.getElementById('p3m-sidebar');
                if (!sidebar) return;

                const activeLink =
                    sidebar.querySelector('.nav-treeview .nav-link.active') ||
                    sidebar.querySelector('.nav-link.active:not([href="#"])');

                if (!activeLink) return;

                const container = getSidebarScrollElement();
                if (!container) return;

                const containerRect = container.getBoundingClientRect();
                const linkRect = activeLink.getBoundingClientRect();

                if (linkRect.top < containerRect.top || linkRect.bottom > containerRect.bottom) {
                    activeLink.scrollIntoView({ block: 'nearest', behavior: 'instant' });
                    saveNavigationScroll();
                }
            }

            function restoreNavigationScroll() {
                if (navigationState.restoring) {
                    return;
                }

                navigationState.restoring = true;

                const position = getSavedNavigationScroll();

                // First restore immediately after Turbo has swapped the document.
                setScrollPosition(position);

                // Then restore after the browser has completed the next layout pass.
                requestAnimationFrame(function() {
                    setScrollPosition(position);

                    requestAnimationFrame(function() {
                        setScrollPosition(position);
                        ensureAdminActiveLinkVisible();
                        navigationState.restoring = false;
                    });
                });
            }

            function findActiveSidebarLink(url) {
                const currentUrl = normalizeUrl(url);
                const sidebar = document.getElementById('p3m-sidebar');

                if (!sidebar) {
                    return null;
                }

                const links = Array.from(
                    sidebar.querySelectorAll('a.nav-link[href]')
                );

                let exactMatch = null;
                let bestMatch = null;
                let longestMatch = 0;

                links.forEach(function(link) {
                    const href = link.getAttribute('href');

                    if (!href || href === '#' || href.startsWith('javascript:')) {
                        return;
                    }

                    const normalizedHref = normalizeUrl(link.href);

                    if (normalizedHref === currentUrl) {
                        exactMatch = link;
                        return;
                    }

                    if (
                        normalizedHref &&
                        normalizedHref.length > 0 &&
                        currentUrl.startsWith(normalizedHref) &&
                        normalizedHref.length > longestMatch
                    ) {
                        longestMatch = normalizedHref.length;
                        bestMatch = link;
                    }
                });

                return exactMatch || bestMatch;
            }

            function withTreeviewTransitionsDisabled(callback) {
                const sidebar = document.getElementById('p3m-sidebar');

                if (!sidebar) {
                    callback();
                    return;
                }

                const treeviews = Array.from(
                    sidebar.querySelectorAll('.nav-treeview')
                );

                const previousTransitions = treeviews.map(function(treeview) {
                    return {
                        element: treeview,
                        transition: treeview.style.transition,
                        animation: treeview.style.animation
                    };
                });

                treeviews.forEach(function(treeview) {
                    treeview.style.transition = 'none';
                    treeview.style.animation = 'none';
                });

                try {
                    callback();
                } finally {
                    requestAnimationFrame(function() {
                        previousTransitions.forEach(function(entry) {
                            entry.element.style.transition = entry.transition;
                            entry.element.style.animation = entry.animation;
                        });
                    });
                }
            }

            function updateSidebarActiveState(url) {
                const sidebar = document.getElementById('p3m-sidebar');

                if (!sidebar) {
                    return;
                }

                const activeLink = findActiveSidebarLink(url);
                const sidebarScroller = getSidebarScrollElement();
                const previousSidebarScroll = sidebarScroller ? sidebarScroller.scrollTop : 0;

                withTreeviewTransitionsDisabled(function() {
                    const allLinks = sidebar.querySelectorAll('.nav-link');

                    allLinks.forEach(function(link) {
                        link.classList.remove('active');
                        link.removeAttribute('aria-current');
                    });

                    if (!activeLink) {
                        return;
                    }

                    activeLink.classList.add('active');
                    activeLink.setAttribute('aria-current', 'page');

                    const treeview = activeLink.closest('.nav-treeview');

                    if (treeview) {
                        const parentItem = treeview.closest('.nav-item');

                        if (parentItem) {
                            parentItem.classList.add('menu-open');
                            treeview.style.display = 'block';

                            const parentLink = parentItem.querySelector(':scope > .nav-link');

                            if (parentLink) {
                                parentLink.classList.add('active');
                            }
                        }
                    }
                    /* Note: With data-accordion="false", multiple dropdown groups can be opened simultaneously.
                       We do NOT forcibly close other .menu-open groups so user-opened dropdowns stay open. */
                });

                // Class changes can alter the tree height. Restore the exact
                // sidebar position so the menu itself does not visibly jump.
                if (sidebarScroller) {
                    sidebarScroller.scrollTop = previousSidebarScroll;

                    requestAnimationFrame(function() {
                        sidebarScroller.scrollTop = previousSidebarScroll;
                    });
                }

                updateTreeviewAccessibility(sidebar);
                updateAdminTopbarPage();
            }

            function updateTreeviewAccessibility(sidebar) {
                const targetSidebar = sidebar || document.getElementById('p3m-sidebar');
                if (!targetSidebar) return;

                targetSidebar.querySelectorAll('.nav-item > .nav-link[aria-controls]').forEach(function(link) {
                    const item = link.closest('.nav-item');
                    link.setAttribute('aria-expanded', item && item.classList.contains('menu-open') ? 'true' : 'false');
                });
            }

            function updateAdminTopbarPage() {
                const pageElement = document.getElementById('js-admin-topbar-page');

                if (!pageElement) {
                    return;
                }

                const activeLink = document.querySelector(
                    '#p3m-sidebar .nav-treeview .nav-link.active'
                ) || document.querySelector(
                    '#p3m-sidebar .nav-link.active:not([href="#"])'
                );

                if (!activeLink) {
                    return;
                }

                const paragraph = activeLink.querySelector('p');

                if (!paragraph) {
                    return;
                }

                const textNode = Array.from(paragraph.childNodes).find(function(node) {
                    return node.nodeType === Node.TEXT_NODE && node.textContent.trim();
                });

                const pageName = textNode ?
                    textNode.textContent.trim() :
                    paragraph.textContent.trim();

                if (pageName) {
                    pageElement.textContent = pageName;
                }
            }

            function initializePageComponents() {
                // CKEditor
                const editorElement = document.querySelector('#editor');

                if (
                    editorElement &&
                    window.ClassicEditor &&
                    !editorElement.classList.contains('ck-applied')
                ) {
                    window.ClassicEditor
                        .create(editorElement)
                        .then(function(editor) {
                            window.editor = editor;
                            editorElement.classList.add('ck-applied');
                        })
                        .catch(function(error) {
                            console.error('CKEditor initialization failed:', error);
                        });
                }

                // Image preview
                const inputFile = document.getElementById('image');
                const fileLabel = document.querySelector('.custom-file-label');
                const previewOutput = document.getElementById('preview-image');

                if (inputFile && fileLabel && !inputFile.dataset.p3mPreviewReady) {
                    inputFile.dataset.p3mPreviewReady = 'true';

                    inputFile.addEventListener('change', function(event) {
                        const file = event.target.files && event.target.files[0];

                        if (!file) {
                            return;
                        }

                        fileLabel.textContent = file.name;

                        if (!previewOutput) {
                            return;
                        }

                        const reader = new FileReader();

                        reader.onload = function() {
                            previewOutput.src = reader.result;
                        };

                        reader.readAsDataURL(file);
                    });
                }

                // Notification links
                document.querySelectorAll('.notif-table').forEach(function(element) {
                    if (element.dataset.p3mNotifReady === 'true') {
                        return;
                    }

                    element.dataset.p3mNotifReady = 'true';

                    element.addEventListener('click', function(event) {
                        event.preventDefault();

                        const tipe = this.dataset.tipe;
                        const link = this.dataset.link;

                        if (!tipe || !link) {
                            return;
                        }

                        fetch('/notif/read-table/' + encodeURIComponent(tipe), {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                credentials: 'same-origin'
                            })
                            .then(function() {
                                saveNavigationScroll();

                                if (typeof Turbo !== 'undefined') {
                                    navigationState.destinationUrl = normalizeUrl(link);
                                    Turbo.visit(link);
                                } else {
                                    window.location.href = link;
                                }
                            })
                            .catch(function() {
                                window.location.href = link;
                            });
                    });
                });
            }

            function triggerPageEnterAnimation() {
                const cw = document.querySelector('.content-wrapper');
                if (!cw || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                cw.classList.remove('admin-page-enter', 'admin-page-exit');
                requestAnimationFrame(function() {
                    requestAnimationFrame(function() {
                        cw.classList.add('admin-page-enter');
                    });
                });
            }

            // Browser should not fight Turbo with its own scroll restoration.
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }

            // Capture the destination BEFORE Turbo renders the next page.
            document.addEventListener('turbo:before-visit', function(event) {
                const destination = event.detail && event.detail.url;

                if (!destination || !isInternalTurboUrl(destination)) {
                    return;
                }

                navigationState.destinationUrl = normalizeUrl(destination);
                saveNavigationScroll();

                const cw = document.querySelector('.content-wrapper');
                if (cw) cw.classList.add('admin-page-exit');
            });

            // Use the destination URL, not the current URL, so active state is
            // not rendered twice (old menu -> new menu), which was causing the jump.
            document.addEventListener('turbo:before-render', function() {
                if (navigationState.destinationUrl) {
                    updateSidebarActiveState(navigationState.destinationUrl);
                }
            });

            document.addEventListener('turbo:load', function() {
                const url = navigationState.destinationUrl || window.location.href;

                updateSidebarActiveState(url);
                updateAdminTopbarPage();
                initializePageComponents();
                restoreNavigationScroll();
                triggerPageEnterAnimation();

                navigationState.destinationUrl = null;
            });

            document.addEventListener('turbo:before-cache', function() {
                const cw = document.querySelector('.content-wrapper');
                if (cw) cw.classList.remove('admin-page-enter', 'admin-page-exit');
            });

            document.addEventListener('DOMContentLoaded', function() {
                updateSidebarActiveState(window.location.href);
                updateAdminTopbarPage();
                initializePageComponents();
                restoreNavigationScroll();
                triggerPageEnterAnimation();
            });

            window.addEventListener('load', function() {
                restoreNavigationScroll();
                setTimeout(restoreNavigationScroll, 60);
                setTimeout(restoreNavigationScroll, 200);
            });

            window.addEventListener('beforeunload', saveNavigationScroll);
            window.addEventListener('pagehide', saveNavigationScroll);

            document.addEventListener('scroll', function(e) {
                const target = e.target;
                if (target && (target.classList?.contains('os-viewport') || target.classList?.contains('sidebar') || target.closest?.('#p3m-sidebar'))) {
                    saveNavigationScroll();
                }
            }, { passive: true, capture: true });

            // Save the current sidebar/page position immediately when a real
            // sidebar navigation link is activated. Group toggle links (#) are
            // intentionally ignored so opening a group never changes scroll.
            $(document)
                .off('mousedown.p3mAdminNavigation click.p3mAdminNavigation', '#p3m-sidebar a.nav-link')
                .on('mousedown.p3mAdminNavigation click.p3mAdminNavigation', '#p3m-sidebar a.nav-link', function() {
                    const href = this.getAttribute('href');

                    if (!href || href === '#' || href.startsWith('javascript:')) {
                        return;
                    }

                    saveNavigationScroll();
                    navigationState.destinationUrl = normalizeUrl(this.href);
                });

            // A group is a disclosure control, never an in-page hash link.
            // Preserve the sidebar position while AdminLTE expands/collapses it.
            $(document)
                .off('click.p3mAdminTreeview', '#p3m-sidebar .nav-link[aria-controls]')
                .on('click.p3mAdminTreeview', '#p3m-sidebar .nav-link[aria-controls]', function(event) {
                    event.preventDefault();
                    saveNavigationScroll();

                    requestAnimationFrame(function() {
                        updateTreeviewAccessibility();
                        restoreNavigationScroll();
                    });
                });

            $(document)
                .off('keydown.p3mAdminTreeview', '#p3m-sidebar .nav-link[role="button"]')
                .on('keydown.p3mAdminTreeview', '#p3m-sidebar .nav-link[role="button"]', function(event) {
                    if (event.key !== ' ') return;
                    event.preventDefault();
                    $(this).trigger('click');
                });

            // Close dropdown upon Turbo navigation
            document.addEventListener('turbo:before-visit', function() {
                $('.dosen-user-dropdown').removeClass('show').closest('.dropdown').removeClass('show');
                $('#adminUserDropdownTrigger').attr('aria-expanded', 'false');
            });

            // Smooth logout confirmation for both Navbar & Sidebar
            $(document).on('click', '#js-admin-nav-logout-btn, .admin-logout-link', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const $target = $(this);
                const $form = $target.closest('form');
                if (!$form.length) return;

                if (typeof window.p3mConfirm === 'function') {
                    window.p3mConfirm({
                        title: 'Logout dari Akun?',
                        html: 'Anda akan keluar dari sesi Admin Workspace saat ini.<br><span style="font-size:13px;color:#9ca3af;">Anda perlu login kembali untuk mengakses data.</span>',
                        icon: 'warning',
                        confirmText: '<i class="fas fa-sign-out-alt" style="font-size:12px;"></i>&nbsp; Ya, Logout',
                        confirmClass: 'p3m-swal-btn-danger',
                        onConfirm: function() {
                            $form.submit();
                        }
                    });
                } else if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Logout dari Akun?',
                        text: 'Anda akan keluar dari sesi Admin Workspace saat ini.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $form.submit();
                        }
                    });
                } else {
                    if (confirm('Apakah Anda yakin ingin logout dari akun ini?')) {
                        $form.submit();
                    }
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
