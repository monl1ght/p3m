@extends('layout.doslayout')

@section('body_class', 'page-dosen-dashboard')

@section('content')

    <div class="content-wrapper dosen-dashboard-page">

        <div class="content-header">
            <div class="container-fluid">
                <div class="dosen-dashboard-shell">

                    <div class="dosen-page-heading">
                        <div>
                            <span class="dosen-eyebrow">Workspace Dosen</span>
                            <h1>Dashboard Dosen</h1>
                        </div>

                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dosen.dash') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <section class="content">

            <div class="container-fluid">
                <div class="dosen-dashboard-shell">

                    {{-- Welcome / action hero --}}
                    <section class="dosen-hero">

                        <div class="dosen-hero-glow dosen-hero-glow-one"></div>
                        <div class="dosen-hero-glow dosen-hero-glow-two"></div>

                        <div class="dosen-hero-content">

                            <span class="dosen-hero-badge">
                                <i class="fas fa-compass"></i>
                                Ruang kerja dosen
                            </span>

                            <h2>
                                Selamat Datang, {{ Auth::user()->name }}
                                <span aria-hidden="true">👋</span>
                            </h2>

                            <p>
                                Kelola proposal penelitian dan pengabdian masyarakat Anda
                                melalui satu ruang kerja P3M yang terstruktur, sederhana,
                                dan mudah digunakan.
                            </p>

                            <div class="dosen-hero-actions">

                                <a href="{{ route('dosen.dash_ajuanpenelitian') }}" class="dosen-primary-action">
                                    <i class="fas fa-microscope"></i>
                                    <span>Unggah Penelitian</span>
                                    <i class="fas fa-arrow-right action-arrow"></i>
                                </a>

                                <a href="{{ route('dosen.upp3m') }}" class="dosen-secondary-action">
                                    <i class="fas fa-hand-holding-heart"></i>
                                    <span>Unggah Pengabdian</span>
                                </a>

                            </div>

                        </div>

                        <div class="dosen-hero-side">

                            <div class="dosen-hero-panel">

                                <div class="dosen-hero-panel-head">

                                    <div class="dosen-hero-panel-icon">
                                        <i class="fas fa-layer-group"></i>
                                    </div>

                                    <div>
                                        <strong>Area Pengelolaan</strong>
                                        <span>Pilih aktivitas Anda</span>
                                    </div>

                                </div>

                                <div class="dosen-hero-panel-list">

                                    <div class="dosen-hero-panel-item">
                                        <span>
                                            <i class="fas fa-check"></i>
                                            Penelitian
                                        </span>
                                        <small>Proposal &amp; laporan</small>
                                    </div>

                                    <div class="dosen-hero-panel-item">
                                        <span>
                                            <i class="fas fa-check"></i>
                                            Pengabdian
                                        </span>
                                        <small>Proposal &amp; laporan</small>
                                    </div>

                                    <div class="dosen-hero-panel-item">
                                        <span>
                                            <i class="fas fa-check"></i>
                                            Profil
                                        </span>
                                        <small>Pengaturan akun</small>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>


                    <div class="dosen-section-heading">

                        <div>
                            <span>Akses cepat</span>
                            <h3>Kelola karya Anda</h3>
                        </div>

                        <p>Pilih area yang ingin Anda buka.</p>

                    </div>


                    <div class="row dosen-quick-row">

                        <div class="col-lg-6 col-xl-6 col-md-6 col-12 mb-4">

                            <a href="{{ route('dosen.dash_ajuanpenelitian') }}" class="dosen-work-card">

                                <div class="dosen-work-card-top">
                                    <div class="dosen-work-icon dosen-work-icon-green">
                                        <i class="fas fa-file-alt"></i>
                                    </div>

                                    <span class="dosen-work-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>

                                <div class="dosen-work-copy">
                                    <strong>Karya Penelitian</strong>
                                    <p>
                                        Kelola pengajuan dan riwayat penelitian Anda.
                                    </p>
                                </div>

                                <span class="dosen-work-link">
                                    Lihat penelitian
                                    <i class="fas fa-arrow-right"></i>
                                </span>

                            </a>

                        </div>


                        <div class="col-lg-6 col-xl-6 col-md-6 col-12 mb-4">

                            <a href="{{ route('dosen.dash_kpengabdian') }}" class="dosen-work-card">

                                <div class="dosen-work-card-top">
                                    <div class="dosen-work-icon dosen-work-icon-gold">
                                        <i class="fas fa-users"></i>
                                    </div>

                                    <span class="dosen-work-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>

                                <div class="dosen-work-copy">
                                    <strong>Pengabdian Masyarakat</strong>
                                    <p>
                                        Kelola pengajuan dan riwayat pengabdian masyarakat Anda.
                                    </p>
                                </div>

                                <span class="dosen-work-link">
                                    Lihat pengabdian
                                    <i class="fas fa-arrow-right"></i>
                                </span>

                            </a>

                        </div>

                    </div>

                </div>
            </div>

        </section>

    </div>

@endsection
