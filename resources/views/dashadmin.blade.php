@extends('layout.main')

@section('content')
<div class="content-wrapper admin-dashboard-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-7">
                    <span class="dashboard-eyebrow">Panel Pengelola</span>
                    <h1 class="m-0">Pengelola Website P3M</h1>
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

    <section class="content">
        <div class="container-fluid">
            <div class="admin-hero-card">
                <div class="admin-hero-content">
                    <span class="hero-badge">
                        <i class="fas fa-shield-alt"></i>
                        Admin P3M
                    </span>
                    <h2>Selamat Datang di Halaman Pengelola Website P3M</h2>
                    <p>
                        Kelola konten, data, dokumen, kegiatan, berita, jurnal, pengajuan, dan laporan P3M Politeknik Balekambang Jepara melalui satu panel yang rapi.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('dash.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-clipboard-list mr-1"></i>
                            Kelola Dashboard
                        </a>
                        <a href="{{ route('tampilan') }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-globe mr-1"></i>
                            Lihat Website
                        </a>
                    </div>
                </div>

                <div class="admin-hero-visual">
                    <div class="visual-card">
                        <i class="fas fa-chart-line"></i>
                        <strong>Dashboard</strong>
                        <span>Pengelolaan konten P3M</span>
                    </div>
                </div>
            </div>

            <div class="row dashboard-quick-row">
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('news.index') }}" class="dashboard-quick-card">
                        <span class="quick-icon">
                            <i class="fas fa-newspaper"></i>
                        </span>
                        <strong>Kegiatan P3M</strong>
                        <span>Kelola informasi kegiatan</span>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('agenda.index') }}" class="dashboard-quick-card">
                        <span class="quick-icon">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        <strong>Berita P3M</strong>
                        <span>Kelola berita dan publikasi</span>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('dokumen.index') }}" class="dashboard-quick-card">
                        <span class="quick-icon">
                            <i class="fas fa-folder"></i>
                        </span>
                        <strong>Dokumen P3M</strong>
                        <span>Kelola dokumen website</span>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('jurnal.index') }}" class="dashboard-quick-card">
                        <span class="quick-icon">
                            <i class="fas fa-journal-whills"></i>
                        </span>
                        <strong>Jurnal P3M</strong>
                        <span>Kelola data jurnal</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('css')
<style>
    .admin-dashboard-page .dashboard-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        color: #2563eb;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .admin-dashboard-page .dashboard-eyebrow::before {
        content: "";
        width: 28px;
        height: 2px;
        border-radius: 999px;
        background: #d5a72f;
    }

    .admin-dashboard-page .content-header h1 {
        font-size: clamp(1.7rem, 2.2vw, 2.35rem);
    }

    .admin-hero-card {
        position: relative;
        overflow: hidden;
        min-height: 330px;
        padding: 42px;
        border: 1px solid #e2e8f0;
        border-radius: 28px;
        background:
            linear-gradient(135deg, rgba(6, 63, 53, .96), rgba(7, 31, 36, .94)),
            radial-gradient(circle at 82% 12%, rgba(213, 167, 47, .22), transparent 34%);
        box-shadow: 0 24px 70px rgba(15, 23, 42, .12);
        display: grid;
        grid-template-columns: 1.25fr .75fr;
        gap: 28px;
        align-items: center;
        color: #ffffff;
        isolation: isolate;
    }

    .admin-hero-card::before {
        content: "";
        position: absolute;
        top: -80px;
        right: -110px;
        width: 300px;
        height: 300px;
        border-radius: 999px;
        background: rgba(213, 167, 47, .16);
        z-index: -1;
    }

    .admin-hero-card::after {
        content: "";
        position: absolute;
        left: 42px;
        right: 42px;
        bottom: 34px;
        height: 1px;
        background: linear-gradient(90deg, rgba(213, 167, 47, .75), rgba(213, 167, 47, 0));
        z-index: -1;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
        margin-bottom: 18px;
        padding: 9px 13px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .16);
        color: rgba(255, 255, 255, .92);
        font-size: 12px;
        font-weight: 850;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .hero-badge i {
        color: #d5a72f;
    }

    .admin-hero-content h2 {
        max-width: 760px;
        margin: 0;
        color: #ffffff;
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(2rem, 3vw, 3.35rem);
        line-height: 1.08;
        font-weight: 900;
        letter-spacing: -0.06em;
    }

    .admin-hero-content p {
        max-width: 660px;
        margin: 18px 0 0;
        color: rgba(226, 232, 240, .88);
        font-size: 15px;
        line-height: 1.85;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 24px;
    }

    .hero-actions .btn {
        padding: 11px 16px;
        border-radius: 14px;
        font-weight: 850;
    }

    .hero-actions .btn-outline-primary {
        border-color: rgba(255, 255, 255, .32);
        color: #ffffff;
        background: rgba(255, 255, 255, .08);
    }

    .hero-actions .btn-outline-primary:hover {
        border-color: #ffffff;
        background: rgba(255, 255, 255, .16);
        color: #ffffff;
    }

    .admin-hero-visual {
        display: flex;
        justify-content: flex-end;
    }

    .visual-card {
        width: min(100%, 250px);
        padding: 28px;
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, .16);
        background: rgba(255, 255, 255, .09);
        backdrop-filter: blur(10px);
        box-shadow: 0 18px 40px rgba(0, 0, 0, .15);
    }

    .visual-card i {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        background: rgba(37, 99, 235, .95);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 18px;
    }

    .visual-card strong {
        display: block;
        color: #ffffff;
        font-size: 20px;
        font-weight: 900;
    }

    .visual-card span {
        display: block;
        margin-top: 6px;
        color: rgba(226, 232, 240, .76);
        font-size: 13px;
        line-height: 1.5;
    }

    .dashboard-quick-row {
        margin-top: 22px;
    }

    .dashboard-quick-row > [class*="col-"] {
        margin-bottom: 18px;
    }

    .dashboard-quick-card {
        height: 100%;
        min-height: 142px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 22px;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        background: #ffffff;
        box-shadow: 0 16px 42px rgba(15, 23, 42, .06);
        transition: .22s ease;
    }

    .dashboard-quick-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 22px 55px rgba(15, 23, 42, .10);
        border-color: #bfdbfe;
    }

    .quick-icon {
        width: 46px;
        height: 46px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #2563eb;
        margin-bottom: 16px;
        font-size: 18px;
    }

    .dashboard-quick-card strong {
        color: #0f172a;
        font-size: 16px;
        font-weight: 900;
    }

    .dashboard-quick-card span:not(.quick-icon) {
        margin-top: 4px;
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    @media (max-width: 991.98px) {
        .admin-hero-card {
            grid-template-columns: 1fr;
            padding: 32px;
        }

        .admin-hero-visual {
            justify-content: flex-start;
        }
    }

    @media (max-width: 575.98px) {
        .admin-hero-card {
            padding: 26px;
            border-radius: 24px;
        }

        .hero-actions .btn {
            width: 100%;
        }

        .visual-card {
            width: 100%;
        }
    }
</style>
@endsection
