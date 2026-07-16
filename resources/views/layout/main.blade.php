<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin P3M POLIBANG</title>

    <link rel="shortcut icon" href="{{ asset('favicon/icon_log.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon/icon_log.ico') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.0/ckeditor5.css">

    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>

    <style>
        :root {
            --admin-bg: #f6f8fb;
            --admin-surface: #ffffff;
            --admin-border: #e2e8f0;
            --admin-text: #334155;
            --admin-heading: #0f172a;
            --admin-muted: #64748b;
            --admin-blue: #2563eb;
            --admin-blue-hover: #1d4ed8;
            --admin-green: #063f35;
            --admin-dark: #071f24;
            --admin-gold: #d5a72f;
            --admin-radius: 18px;
            --admin-shadow: 0 18px 45px rgba(15, 23, 42, .07);
            --admin-font: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            --admin-heading-font: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--admin-bg);
            color: var(--admin-text);
            font-family: var(--admin-font);
            font-size: 14px;
        }

        a {
            text-decoration: none;
        }

        .wrapper {
            background: var(--admin-bg);
        }

        .content-wrapper {
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, .06), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, #f6f8fb 100%);
            min-height: calc(100vh - 57px);
        }
to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        /* Anti flicker: jangan animasikan content-wrapper saat full page reload */
        html,
        body,
        .wrapper,
        .content-wrapper {
            background-color: var(--admin-bg);
        }

        .main-sidebar {
            will-change: auto;
        }

        .content-wrapper,
        .main-header,
        .main-sidebar {
            backface-visibility: hidden;
        }

        .main-header {
            min-height: 64px;
            background: rgba(255, 255, 255, .96) !important;
            border-bottom: 1px solid var(--admin-border);
            box-shadow: 0 12px 30px rgba(15, 23, 42, .04);
            backdrop-filter: blur(12px);
        }

        .main-header .nav-link {
            color: #475569 !important;
            font-weight: 700;
        }

        .main-header .nav-link:hover {
            color: var(--admin-blue) !important;
        }

        .topbar-title {
            display: flex;
            flex-direction: column;
            justify-content: center;
            line-height: 1.25;
        }

        .topbar-title strong {
            color: var(--admin-heading);
            font-family: var(--admin-heading-font);
            font-size: 15px;
            font-weight: 900;
            letter-spacing: -0.035em;
        }

        .topbar-title span {
            color: var(--admin-muted);
            font-size: 12px;
            font-weight: 600;
        }

        .navbar-badge {
            width: 9px !important;
            height: 9px !important;
            top: 12px;
            right: 9px;
            border: 2px solid #ffffff;
        }

        .dropdown-menu {
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            box-shadow: 0 22px 60px rgba(15, 23, 42, .14);
        }

        .dropdown-header {
            color: var(--admin-heading);
            font-weight: 850;
        }

        .main-sidebar {
            background: linear-gradient(180deg, #071f24 0%, #061c20 52%, #020617 100%) !important;
            box-shadow: 18px 0 45px rgba(15, 23, 42, .12);
        }

        .sidebar {
            padding: 16px 12px 20px;
        }

        .brand-panel {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 12px 18px;
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(148, 163, 184, .16);
        }

        .brand-panel img {
            width: 42px;
            height: 42px;
            object-fit: contain;
            border-radius: 999px;
            background: #ffffff;
            padding: 4px;
            border: 1px solid rgba(255, 255, 255, .22);
        }

        .brand-panel strong {
            display: block;
            color: #ffffff;
            font-family: var(--admin-heading-font);
            font-size: 16px;
            font-weight: 900;
            letter-spacing: -0.045em;
            line-height: 1.2;
        }

        .brand-panel span {
            display: block;
            margin-top: 2px;
            color: rgba(226, 232, 240, .68);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .user-panel {
            align-items: center;
            padding: 12px !important;
            margin: 0 0 14px !important;
            border: 1px solid rgba(148, 163, 184, .15);
            border-radius: 18px;
            background: rgba(255, 255, 255, .06);
        }

        .user-panel .image {
            padding-left: 0;
        }

        .user-panel img,
        .admin-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 999px;
            border: 2px solid rgba(255, 255, 255, .18);
        }

        .admin-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--admin-blue);
            color: #ffffff;
            font-weight: 900;
        }

        .user-panel .info {
            padding: 0 0 0 10px;
            line-height: 1.25;
        }

        .user-panel .info a {
            color: #ffffff !important;
            font-weight: 800;
            font-size: 13px;
        }

        .user-role {
            display: block;
            margin-top: 3px;
            color: rgba(226, 232, 240, .60);
            font-size: 11px;
            font-weight: 700;
        }

        .form-control-sidebar,
        .btn-sidebar {
            background: rgba(255, 255, 255, .08) !important;
            border-color: rgba(148, 163, 184, .16) !important;
            color: #ffffff !important;
        }

        .form-control-sidebar::placeholder {
            color: rgba(226, 232, 240, .50);
        }

        .nav-sidebar {
            margin-top: 12px;
        }

        .nav-sidebar .nav-item {
            margin-bottom: 4px;
        }

        .nav-sidebar .nav-link {
            min-height: 42px;
            border-radius: 14px;
            color: rgba(226, 232, 240, .76) !important;
            font-weight: 750;
            transition: .2s ease;
        }

        .nav-sidebar .nav-link p {
            font-size: 13px;
        }

        .nav-sidebar .nav-link .nav-icon {
            color: rgba(226, 232, 240, .68);
            width: 22px;
            font-size: 14px;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, .08) !important;
            color: #ffffff !important;
        }

        .nav-sidebar .nav-link.active {
            background: rgba(37, 99, 235, .95) !important;
            color: #ffffff !important;
            box-shadow: 0 12px 28px rgba(37, 99, 235, .22);
        }

        .nav-treeview {
            padding: 5px 0 5px 10px;
        }

        .nav-treeview .nav-link {
            min-height: 38px;
            border-radius: 12px;
            color: rgba(226, 232, 240, .68) !important;
        }

        .nav-treeview .nav-link p {
            font-size: 12.5px;
        }

        .nav-treeview .nav-link.active {
            background: rgba(255, 255, 255, .12) !important;
        }

        .content-header {
            padding: 26px 24px 10px;
        }

        .content-header h1,
        .content-header h2,
        .content-header h3 {
            color: var(--admin-heading);
            font-family: var(--admin-heading-font);
            font-weight: 900;
            letter-spacing: -0.045em;
        }

        .breadcrumb {
            padding: 0;
            margin: 0;
            background: transparent;
            font-size: 13px;
            font-weight: 700;
        }

        .breadcrumb a {
            color: var(--admin-blue);
        }

        .breadcrumb-item.active {
            color: var(--admin-muted);
        }

        .content {
            padding: 14px 24px 28px;
        }

        .card,
        .small-box,
        .info-box {
            border: 1px solid var(--admin-border);
            border-radius: var(--admin-radius);
            box-shadow: var(--admin-shadow);
            overflow: hidden;
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid var(--admin-border);
            padding: 16px 18px;
        }

        .card-title {
            color: var(--admin-heading);
            font-weight: 850;
        }

        .card-body {
            padding: 18px;
        }

        .btn {
            border-radius: 12px;
            font-weight: 800;
        }

        .btn-primary {
            background: var(--admin-blue);
            border-color: var(--admin-blue);
        }

        .btn-primary:hover {
            background: var(--admin-blue-hover);
            border-color: var(--admin-blue-hover);
        }

        .table {
            color: var(--admin-text);
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: 1px solid var(--admin-border);
            color: var(--admin-heading);
            font-size: 12px;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        @media (max-width: 767.98px) {
            .content-header {
                padding: 22px 16px 8px;
            }

            .content {
                padding: 12px 16px 24px;
            }

            .topbar-title span {
                display: none;
            }
        }


    
        /* No footer - new47 */
        .content-wrapper {
            padding-bottom: 28px;
        }

    </style>

    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <div class="topbar-title ml-2">
                        <strong>Dashboard P3M</strong>
                        <span>Panel pengelola website</span>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item d-none d-md-inline-block">
                    <a href="{{ route('tampilan') }}" class="nav-link" target="_blank">
                        <i class="fas fa-globe mr-1"></i> Lihat Website
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-label="Notifikasi">
                        <i class="far fa-bell"></i>
                        @if(($totalNotif ?? 0) > 0)
                            <span class="badge badge-danger navbar-badge"></span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">
                            {{ $totalNotif ?? 0 }} Aktivitas Terbaru
                        </span>

                        <div class="dropdown-divider"></div>

                        @forelse(($notifikasi ?? collect()) as $n)
                            <a href="{{ route('notif.open', $n['tipe']) }}" class="dropdown-item">
                                <i class="fas fa-circle text-primary mr-2" style="font-size: 8px;"></i>
                                {{ $n['judul'] }}
                            </a>
                        @empty
                            <span class="dropdown-item text-muted text-center">
                                Tidak ada aktivitas
                            </span>
                        @endforelse
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="sidebar">
                <a href="{{ route('dash.dashadmin') }}" class="brand-panel">
                    <img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M">
                    <span>
                        <strong>P3M Polibang</strong>
                        <span>Admin Panel</span>
                    </span>
                </a>

                @php
                    $avatarPath = !empty($user->image) ? 'storage/photo-user/'.$user->image : null;
                    $avatarExists = $avatarPath && file_exists(public_path($avatarPath));
                    $avatarInitial = strtoupper(substr($user->name ?? 'P', 0, 1));
                @endphp

                <div class="user-panel d-flex">
                    <div class="image">
                        @if($avatarExists)
                            <img src="{{ asset($avatarPath) }}" alt="{{ $user->name ?? 'User' }}">
                        @else
                            <span class="admin-avatar">{{ $avatarInitial }}</span>
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('dosen.profil', ['id' => Auth::user()->id]) }}" class="d-block">{{ $user->name }}</a>
                        <span class="user-role">Pengelola P3M</span>
                    </div>
                </div>

                <div class="form-inline mb-2">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu..." aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar" type="button">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item {{ request()->routeIs('dash.*', 'index') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('dash.*', 'index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Halaman Utama
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('dash.dashboard') }}" class="nav-link {{ request()->routeIs('dash.dashboard', 'dash.create_dash', 'dash.edit_dash') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-clipboard-list"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index') }}" class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-user-shield"></i>
                                        <p>Admin</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item {{ request()->routeIs('pengelola.*', 'tentang.*', 'panduan.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('pengelola.*', 'tentang.*', 'panduan.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-id-card-alt"></i>
                                <p>
                                    Profil P3M
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pengelola.index') }}" class="nav-link {{ request()->routeIs('pengelola.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Pengelola P3M</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('tentang.index') }}" class="nav-link {{ request()->routeIs('tentang.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-address-card"></i>
                                        <p>Tentang P3M</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('panduan.index') }}" class="nav-link {{ request()->routeIs('panduan.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-book-reader"></i>
                                        <p>Panduan P3M</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item {{ request()->routeIs('category.*', 'news.*', 'agenda.*', 'dokumen.*', 'jurnal.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('category.*', 'news.*', 'agenda.*', 'dokumen.*', 'jurnal.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>
                                    Seputar P3M
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('category.index') }}" class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-list-alt"></i>
                                        <p>Kategori Berita</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('news.index') }}" class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-newspaper"></i>
                                        <p>Kegiatan P3M</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('agenda.index') }}" class="nav-link {{ request()->routeIs('agenda.*') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-calendar-alt"></i>
                                        <p>Berita P3M</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('dokumen.index') }}" class="nav-link {{ request()->routeIs('dokumen.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-folder"></i>
                                        <p>Dokumen P3M</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('jurnal.index') }}" class="nav-link {{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-journal-whills"></i>
                                        <p>Jurnal P3M</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item {{ request()->routeIs('plppm.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('plppm.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-signature"></i>
                                <p>
                                    Pengajuan & Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('plppm.lpengabdian') }}" class="nav-link {{ request()->routeIs('plppm.lpengabdian') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-file"></i>
                                        <p>Pengajuan Pengabdian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('plppm.lpeneleitian') }}" class="nav-link {{ request()->routeIs('plppm.lpeneleitian') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-file"></i>
                                        <p>Pengajuan Penelitian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('plppm.kpengabdian') }}" class="nav-link {{ request()->routeIs('plppm.kpengabdian') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-folder"></i>
                                        <p>Laporan Pengabdian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('plppm.kpenelitian') }}" class="nav-link {{ request()->routeIs('plppm.kpenelitian') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-folder"></i>
                                        <p>Laporan Penelitian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item mt-2">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout Akun</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        @yield('content')
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>

    <script>
        const editorElement = document.querySelector('#editor');

        if (editorElement && window.ClassicEditor) {
            ClassicEditor
                .create(editorElement)
                .then(editor => {
                    window.editor = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        }

        const inputFile = document.getElementById('image');
        const fileLabel = document.querySelector('.custom-file-label');
        const previewOutput = document.getElementById('preview-image');

        if (inputFile && fileLabel) {
            inputFile.addEventListener('change', function (event) {
                const file = event.target.files && event.target.files[0];

                if (!file) {
                    return;
                }

                fileLabel.textContent = file.name;

                if (previewOutput) {
                    const reader = new FileReader();
                    reader.onload = function () {
                        previewOutput.src = reader.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        document.querySelectorAll('.notif-table').forEach(el => {
            el.addEventListener('click', function(e) {
                e.preventDefault();

                const tipe = this.dataset.tipe;
                const link = this.dataset.link;

                fetch('/notif/read-table/' + tipe, {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                }).then(() => {
                    window.location.href = link;
                });
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
