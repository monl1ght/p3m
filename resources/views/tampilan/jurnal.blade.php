@extends('layout.views')
@section('isi')

<style>
/* ── PREMIUM JURNAL STYLES (DESKTOP) ───────────────── */
:root {
    --primary-light: #059669;
    --primary-dark: #047857;
    --primary-soft: #ecfdf5;
    --primary-border: #a7f3d0;
    --surface: #ffffff;
    --surface-alt: #f8fafc;
    --text-main: #0f172a;
    --text-muted: #475569;
    --border-color: #e2e8f0;
    --transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

body {
    background-color: var(--surface-alt);
}

.portfolio-details.section {
    padding: 72px 0 100px;
}

.section-title {
    text-align: center;
    margin-bottom: 48px;
}

.section-label {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    color: var(--primary-light);
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.section-label::before, .section-label::after {
    content: "";
    width: 24px;
    height: 2px;
    border-radius: 2px;
    background: var(--primary-light);
    opacity: 0.5;
}

.section-title h2 {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: clamp(2rem, 3vw, 2.5rem);
    font-weight: 800;
    color: var(--text-main);
    margin: 0 0 16px;
    letter-spacing: -0.02em;
}

.section-title p {
    color: var(--text-muted);
    font-size: 16px;
    margin: 0 auto;
    text-align: center;
}

/* Premium Table Card */
.premium-table-wrap {
    background: var(--surface);
    border: 1px solid var(--border-color);
    border-radius: 24px;
    padding: 32px 40px;
    box-shadow: 0 10px 40px rgba(15, 23, 42, 0.04);
}

.table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table thead th {
    background: var(--surface-alt);
    color: var(--text-muted);
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 20px 24px;
    border: none;
    border-bottom: 2px solid var(--border-color);
}

.table thead th:first-child { border-top-left-radius: 14px; }
.table thead th:last-child { border-top-right-radius: 14px; }

.table tbody tr {
    transition: var(--transition);
}

.table tbody tr:hover {
    background: #f8fafc;
}

.table tbody td, .table tbody th {
    padding: 24px;
    border-top: none;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-muted);
    font-size: 14.5px;
    vertical-align: middle;
}

.table tbody tr:last-child td,
.table tbody tr:last-child th {
    border-bottom: none;
}

/* Specific columns styling */
.col-jurnal {
    color: var(--text-main) !important;
    font-size: 16px;
    font-weight: 700;
    line-height: 1.5;
    font-family: "Plus Jakarta Sans", sans-serif;
    display: flex;
    align-items: center;
    gap: 16px;
}

.col-jurnal i {
    color: var(--primary-light);
    font-size: 20px;
    background: var(--primary-soft);
    padding: 12px;
    border-radius: 12px;
    border: 1px solid var(--primary-border);
}

/* Action Button */
.btn-download-premium {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 24px;
    border-radius: 10px;
    background: var(--primary-soft);
    color: var(--primary-dark);
    border: 1px solid var(--primary-border);
    font-weight: 700;
    font-size: 13.5px;
    transition: var(--transition);
    text-decoration: none;
}

.btn-download-premium:hover {
    background: var(--primary-light);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(5, 150, 105, 0.25);
}

.btn-download-premium i {
    font-size: 14px;
    transition: transform 0.3s ease;
}

.btn-download-premium:hover i {
    transform: translateY(-2px) translateX(2px);
}

/* ── MOBILE JURNAL CARDS (< 769px) ─────────────────── */
@media (max-width: 768px) {
    .portfolio-details.section {
        padding: 32px 0 64px;
    }

    .section-title {
        margin-bottom: 24px;
        text-align: center;
    }

    .section-title h2 {
        font-size: 24px;
        margin-bottom: 8px;
    }

    .section-title p {
        font-size: 14px;
        line-height: 1.55;
    }

    .mobile-jurnal-container {
        display: flex !important;
        flex-direction: column !important;
        gap: 16px !important;
    }

    .mobile-jurnal-card {
        background: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 18px 16px;
        box-shadow: 0 3px 14px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 16px;
    }

    .mobile-jurnal-card:last-child {
        margin-bottom: 0;
    }

    .mobile-jurnal-top {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .mobile-jurnal-icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: var(--primary-soft);
        color: var(--primary-light);
        font-size: 20px;
        flex-shrink: 0;
        border: 1px solid var(--primary-border);
    }

    .mobile-jurnal-meta {
        flex: 1;
        min-width: 0;
    }

    .mobile-jurnal-tag {
        font-size: 11px;
        font-weight: 700;
        color: var(--primary-dark);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 3px;
        display: block;
    }

    .mobile-jurnal-title {
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 15.5px;
        font-weight: 700;
        color: var(--text-main);
        line-height: 1.45;
        margin: 0;
        word-break: break-word;
    }

    .btn-mobile-jurnal-visit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        min-height: 44px;
        padding: 10px 16px;
        border-radius: 12px;
        background: var(--primary-soft);
        color: var(--primary-dark);
        border: 1px solid var(--primary-border);
        font-weight: 700;
        font-size: 13.5px;
        text-decoration: none;
        transition: all 0.2s ease;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-mobile-jurnal-visit:active {
        background: var(--primary-light);
        color: #ffffff;
        border-color: var(--primary-light);
        transform: scale(0.98);
    }
}
</style>

<div class="page-title" data-aos="fade">
    <div class="container">
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ route('tampilan') }}">Home</a></li>
                <li class="current">{{ $pagetitle }}</li>
            </ol>
        </nav>
        <h1>{{ $pagetitle }}</h1>
        <small>Politeknik Balekambang Jepara</small>
    </div>
</div>

<section id="portfolio-details" class="portfolio-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title">
            <div class="section-label">Jurnal</div>
            <h2>Jurnal P3M</h2>
            <p>Daftar jurnal penelitian dan pengabdian masyarakat yang terhubung dengan P3M Politeknik Balekambang Jepara.</p>
        </div>

        {{-- Desktop Table (≥ 769px) --}}
        <div class="premium-table-wrap d-none d-md-block">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 70px; text-align: center;">No</th>
                            <th scope="col">Nama Jurnal</th>
                            <th scope="col" style="width: 160px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dok as $d)
                            <tr>
                                <th scope="row" style="text-align: center; color: #94a3b8;">{{ $loop->iteration }}</th>
                                <td class="col-jurnal">
                                    <i class="fas fa-newspaper"></i>
                                    {{ $d->jurnalname }}
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ $d->link }}" target="_blank" class="btn-download-premium" title="Buka Jurnal">
                                        Kunjungi <i class="fas fa-external-link-alt ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5" style="color: #94a3b8;">
                                    <i class="fas fa-folder-open fa-3x mb-3" style="color: #cbd5e1;"></i>
                                    <p class="mb-0">Belum ada jurnal yang tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Cards (< 769px) --}}
        <div class="d-flex flex-column d-md-none mobile-jurnal-container">
            @forelse ($dok as $d)
                <div class="mobile-jurnal-card">
                    <div class="mobile-jurnal-top">
                        <div class="mobile-jurnal-icon-box">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="mobile-jurnal-meta">
                            <span class="mobile-jurnal-tag">Jurnal #{{ $loop->iteration }}</span>
                            <h3 class="mobile-jurnal-title">{{ $d->jurnalname }}</h3>
                        </div>
                    </div>
                    <a href="{{ $d->link }}" target="_blank" class="btn-mobile-jurnal-visit" aria-label="Kunjungi jurnal {{ $d->jurnalname }}">
                        <span>Kunjungi Jurnal</span>
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            @empty
                <div class="text-center py-5" style="background: #ffffff; border-radius: 18px; border: 1px solid #e2e8f0; color: #94a3b8; padding: 36px 20px;">
                    <i class="fas fa-folder-open fa-3x mb-3" style="color: #cbd5e1; display: block;"></i>
                    <p class="mb-0" style="font-size: 15px; font-weight: 600;">Belum ada jurnal yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
