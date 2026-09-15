@extends('layout.main')

@section('content')
    <div class="content-wrapper admin-dashboard-page">
        <div class="content-header">
            <div class="container-fluid">
                <div class="admin-dashboard-shell">
                    <div class="row align-items-center mb-3">
                        <div class="col-sm-7">
                            <span class="dashboard-eyebrow">Panel Pengelola</span>
                            <h1 class="m-0">Dashboard P3M</h1>
                        </div>
                        <div class="col-sm-5">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dash.dashadmin') }}">Home</a></li>
                                <li class="breadcrumb-item active">Pengelola P3M</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="admin-dashboard-shell">
                    <!-- Hero Card -->
                    <div class="admin-hero-card">
                        <div class="admin-hero-content">
                            <span class="hero-badge">
                                <i class="fas fa-shield-alt"></i>
                                Ruang Kerja Admin
                            </span>
                            <h2>Satu pusat kendali untuk P3M Polibang.</h2>
                            <p>
                                Kelola profil, konten, dokumen, kegiatan, jurnal, pengajuan, dan laporan melalui satu
                                ruang kerja yang terstruktur dan mudah digunakan.
                            </p>

                            <div class="hero-actions">
                                <a href="{{ route('pengelola.index') }}" class="btn btn-primary">
                                    <i class="fas fa-id-card-alt mr-1"></i>
                                    Kelola Profil P3M
                                </a>
                                <a href="{{ route('tampilan') }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-globe mr-1"></i>
                                    Lihat Website
                                </a>
                            </div>
                        </div>

                        <div class="admin-hero-visual">
                            <div class="visual-card">
                                <div class="visual-card-header">
                                    <i class="fas fa-compass"></i>
                                    <div>
                                        <strong>Area Pengelolaan</strong>
                                        <span>Akses yang tersedia</span>
                                    </div>
                                </div>
                                <div class="visual-card-body">
                                    <div class="workspace-item">
                                        <span><i class="fas fa-check"></i> Konten & informasi</span>
                                        <small>Siap dikelola</small>
                                    </div>
                                    <div class="workspace-item">
                                        <span><i class="fas fa-check"></i> Dokumen & jurnal</span>
                                        <small>Terorganisir</small>
                                    </div>
                                    <div class="workspace-item">
                                        <span><i class="fas fa-check"></i> Pengajuan & laporan</span>
                                        <small>Terintegrasi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="dashboard-section-heading">
                        <div>
                            <span>Menu Cepat</span>
                            <h3>Akses pengelolaan utama</h3>
                        </div>
                        <p>Pilih area yang ingin Anda kelola.</p>
                    </div>

                    <div class="row dashboard-quick-row">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('news.index') }}" class="dashboard-quick-card">
                                <div class="quick-card-header">
                                    <span class="quick-icon">
                                        <i class="fas fa-newspaper"></i>
                                    </span>
                                    <i class="fas fa-arrow-right quick-arrow"></i>
                                </div>
                                <strong>Kegiatan P3M</strong>
                                <span>Kelola informasi kegiatan</span>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('agenda.index') }}" class="dashboard-quick-card">
                                <div class="quick-card-header">
                                    <span class="quick-icon">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                    <i class="fas fa-arrow-right quick-arrow"></i>
                                </div>
                                <strong>Berita P3M</strong>
                                <span>Kelola berita dan publikasi</span>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('dokumen.index') }}" class="dashboard-quick-card">
                                <div class="quick-card-header">
                                    <span class="quick-icon">
                                        <i class="fas fa-folder"></i>
                                    </span>
                                    <i class="fas fa-arrow-right quick-arrow"></i>
                                </div>
                                <strong>Dokumen P3M</strong>
                                <span>Kelola dokumen website</span>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('jurnal.index') }}" class="dashboard-quick-card">
                                <div class="quick-card-header">
                                    <span class="quick-icon">
                                        <i class="fas fa-book-open"></i>
                                    </span>
                                    <i class="fas fa-arrow-right quick-arrow"></i>
                                </div>
                                <strong>Jurnal P3M</strong>
                                <span>Kelola data jurnal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('css')
    <style>
        :root {
            /* Color Palette */
            --dash-green-950: #002e22;
            --dash-green-900: #003d2d;
            --dash-green-800: #006b3b;
            --dash-green-700: #087f47;
            --dash-green-100: #e8f4ed;
            --dash-green-050: #f4faf6;

            --dash-gold: #bd9a36;
            --dash-gold-light: #fcf7e8;

            --dash-ink: #10233e;
            --dash-text: #40556c;
            --dash-muted: #728096;
            --dash-line: #e3ebe6;
            --dash-white: #ffffff;

            /* Typography */
            --dash-display: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
            --dash-body: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        /* ---------- Background / Page Shell ---------- */
        .admin-dashboard-page {
            min-height: calc(100vh - 84px);
            background: #f7faf8;
            font-family: var(--dash-body);
            color: var(--dash-text);
        }

        .admin-dashboard-page .content-header {
            padding: 28px 0 18px;
        }

        .admin-dashboard-page .content {
            padding: 0 0 40px;
        }

        .admin-dashboard-shell {
            width: min(1210px, calc(100% - 64px));
            margin: 0 auto;
        }

        /* ---------- Page Heading ---------- */
        .admin-dashboard-page .dashboard-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            color: var(--dash-green-800);
            font-size: 11px;
            line-height: 1;
            font-weight: 800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }

        .admin-dashboard-page .dashboard-eyebrow::before {
            content: "";
            width: 28px;
            height: 2px;
            border-radius: 999px;
            background: var(--dash-gold);
        }

        .admin-dashboard-page .content-header h1 {
            margin: 0;
            color: var(--dash-ink);
            font-family: var(--dash-display);
            font-size: clamp(30px, 2.5vw, 38px);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .admin-dashboard-page .breadcrumb {
            margin: 0;
            padding: 0;
            background: transparent;
            font-size: 13px;
            font-weight: 600;
        }

        .admin-dashboard-page .breadcrumb a {
            color: var(--dash-green-800);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .admin-dashboard-page .breadcrumb a:hover {
            color: var(--dash-green-700);
        }

        .admin-dashboard-page .breadcrumb-item.active {
            color: var(--dash-muted);
        }

        .admin-dashboard-page .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            padding: 0 10px;
            color: #b0c0b6;
        }

        /* ---------- Hero Card ---------- */
        .admin-hero-card {
            position: relative;
            overflow: hidden;
            min-height: 304px;
            padding: 38px 42px;
            display: grid;
            grid-template-columns: minmax(0, 1.42fr) minmax(245px, 0.58fr);
            gap: 36px;
            align-items: center;
            color: var(--dash-white);

            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 28px;
            background:
                radial-gradient(circle at 88% 0%, rgba(189, 154, 54, 0.18), transparent 29%),
                radial-gradient(circle at 0% 100%, rgba(17, 142, 81, 0.16), transparent 28%),
                linear-gradient(135deg, #003d2d 0%, #005638 52%, #003f2c 100%);
            box-shadow:
                0 24px 60px rgba(7, 66, 51, 0.18),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            isolation: isolate;
        }

        .admin-hero-card::before {
            content: "";
            position: absolute;
            right: -90px;
            top: -120px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            z-index: -1;
        }

        .admin-hero-card::after {
            content: "";
            position: absolute;
            left: 42px;
            right: 42px;
            bottom: 26px;
            height: 1px;
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.5), rgba(212, 175, 55, 0));
            z-index: -1;
        }

        .admin-hero-content {
            min-width: 0;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            margin-bottom: 17px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.95);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            backdrop-filter: blur(4px);
        }

        .hero-badge i {
            color: var(--dash-gold);
        }

        .admin-hero-content h2 {
            max-width: 680px;
            margin: 0;
            color: var(--dash-white);
            font-family: var(--dash-display);
            font-size: clamp(2rem, 2.75vw, 2.8rem);
            line-height: 1.13;
            font-weight: 800;
            letter-spacing: -0.05em;
        }

        .admin-hero-content p {
            max-width: 620px;
            margin: 15px 0 0;
            color: rgba(234, 246, 239, 0.85);
            font-size: 14px;
            line-height: 1.72;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
        }

        .hero-actions .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 9px 17px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.25s ease;
            border: 1px solid transparent;
        }

        .hero-actions .btn-primary {
            background: #0a8649;
            border-color: #0a8649;
            color: var(--dash-white);
            box-shadow: 0 9px 18px rgba(0, 46, 34, 0.23);
        }

        .hero-actions .btn-primary:hover {
            background: #006b3b;
            border-color: #006b3b;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 46, 34, 0.3);
        }

        .hero-actions .btn-outline-primary {
            color: var(--dash-white);
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(4px);
        }

        .hero-actions .btn-outline-primary:hover {
            color: var(--dash-white);
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.45);
            transform: translateY(-2px);
        }

        /* ---------- Hero Visual (Glassmorphism) ---------- */
        .admin-hero-visual {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .visual-card {
            width: 100%;
            max-width: 276px;
            padding: 22px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 18px 36px rgba(0, 33, 24, 0.2);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: transform 0.3s ease;
        }

        .visual-card:hover {
            transform: translateY(-4px);
        }

        .visual-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 17px;
        }

        .visual-card-header i {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: rgba(10, 134, 73, 0.9);
            color: var(--dash-white);
            font-size: 20px;
            box-shadow: 0 8px 16px rgba(0, 46, 34, 0.22);
        }

        .visual-card-header strong {
            display: block;
            color: var(--dash-white);
            font-size: 15px;
            font-weight: 800;
            font-family: var(--dash-display);
        }

        .visual-card-header span {
            display: block;
            margin-top: 2px;
            color: rgba(230, 240, 235, 0.7);
            font-size: 11.5px;
        }

        .visual-card-body {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .workspace-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .workspace-item span {
            display: inline-flex;
            align-items: center;
            min-width: 0;
            gap: 7px;
            color: rgba(245, 252, 247, 0.86);
            font-size: 11.5px;
            font-weight: 600;
        }

        .workspace-item i {
            color: #dbc16d;
            font-size: 9px;
        }

        .workspace-item small {
            color: rgba(237, 248, 241, 0.6);
            font-size: 10px;
            white-space: nowrap;
        }

        /* ---------- Quick Links ---------- */
        .dashboard-section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-top: 30px;
        }

        .dashboard-section-heading span {
            display: block;
            margin-bottom: 5px;
            color: var(--dash-green-800);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .dashboard-section-heading h3 {
            margin: 0;
            color: var(--dash-ink);
            font-family: var(--dash-display);
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.025em;
        }

        .dashboard-section-heading p {
            margin: 0 0 2px;
            color: var(--dash-muted);
            font-size: 13px;
        }

        .dashboard-quick-row {
            margin-top: 14px;
        }

        .dashboard-quick-row>[class*="col-"] {
            margin-bottom: 20px;
        }

        .dashboard-quick-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            min-height: 158px;
            padding: 22px;
            border: 1px solid var(--dash-line);
            border-radius: 18px;
            background: var(--dash-white);
            box-shadow: 0 4px 20px rgba(14, 72, 41, 0.04);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .dashboard-quick-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--dash-green-700), var(--dash-gold));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dashboard-quick-card:hover {
            transform: translateY(-4px);
            border-color: transparent;
            box-shadow: 0 16px 36px rgba(14, 72, 41, 0.1);
        }

        .dashboard-quick-card:hover::before {
            opacity: 1;
        }

        .quick-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .quick-icon {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: var(--dash-green-050);
            color: var(--dash-green-800);
            font-size: 17px;
            transition: all 0.3s ease;
        }

        .dashboard-quick-card:hover .quick-icon {
            background: var(--dash-green-800);
            color: var(--dash-white);
            transform: scale(1.05);
        }

        .quick-arrow {
            color: var(--dash-green-800);
            font-size: 14px;
            opacity: 0;
            transform: translateX(-6px);
            transition: all 0.3s ease;
        }

        .dashboard-quick-card:hover .quick-arrow {
            opacity: 1;
            transform: translateX(0);
            color: var(--dash-green-700);
        }

        .dashboard-quick-card strong {
            color: var(--dash-ink);
            font-size: 15px;
            font-weight: 800;
            font-family: var(--dash-display);
            margin-bottom: 6px;
            display: block;
        }

        .dashboard-quick-card span:not(.quick-icon) {
            color: var(--dash-muted);
            font-size: 12.5px;
            line-height: 1.5;
        }

        /* ---------- Responsive Adjustments ---------- */
        @media (max-width: 1199.98px) {
            .admin-dashboard-shell {
                width: calc(100% - 48px);
            }
        }

        @media (max-width: 991.98px) {
            .admin-hero-card {
                grid-template-columns: 1fr;
                padding: 32px;
                gap: 40px;
            }

            .admin-hero-visual {
                justify-content: flex-start;
            }

            .visual-card {
                max-width: 100%;
            }

            .admin-hero-card::after {
                left: 32px;
                right: 32px;
                bottom: 24px;
            }
        }

        @media (max-width: 767.98px) {
            .admin-dashboard-page .content-header {
                padding: 24px 0 12px;
            }

            .admin-dashboard-shell {
                width: calc(100% - 32px);
            }

            .admin-hero-card {
                padding: 28px 24px;
                border-radius: 24px;
            }

            .admin-hero-content h2 {
                font-size: 2rem;
            }

            .dashboard-section-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 7px;
                margin-top: 24px;
            }

            .dashboard-section-heading p {
                margin: 0;
            }

            .hero-actions {
                flex-direction: column;
            }

            .hero-actions .btn {
                width: 100%;
            }

            .dashboard-quick-card {
                padding: 20px;
            }
        }

        @media (max-width: 575.98px) {
            .admin-dashboard-shell {
                width: calc(100% - 24px);
            }

            .admin-hero-card {
                padding: 24px 20px;
                border-radius: 20px;
            }

            .visual-card {
                padding: 20px;
                border-radius: 20px;
            }

            .admin-hero-card::after {
                left: 20px;
                right: 20px;
                bottom: 16px;
            }
        }
    </style>
@endsection
