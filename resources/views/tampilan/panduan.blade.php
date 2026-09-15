@extends('layout.views')
@section('isi')
<style>
/* ── PANDUAN P3M MODERN RESPONSIVE STYLES ───────────── */
:root {
    --p3m-primary: #059669;
    --p3m-dark: #047857;
    --p3m-soft: #ecfdf5;
    --p3m-border: #a7f3d0;
    --p3m-surface: #ffffff;
    --p3m-bg: #f8fafc;
    --p3m-text: #0f172a;
    --p3m-muted: #64748b;
    --p3m-stroke: #e2e8f0;
}

body {
    background-color: var(--p3m-bg);
}

.portfolio-details.section {
    padding: 64px 0 100px;
}

/* Section Header */
.section-title {
    text-align: center;
    margin-bottom: 44px;
}

.section-label {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    color: var(--p3m-primary);
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
    background: var(--p3m-primary);
    opacity: 0.5;
}

.section-title h2 {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: clamp(1.85rem, 3vw, 2.35rem);
    font-weight: 800;
    color: var(--p3m-text);
    margin: 0 0 12px;
    letter-spacing: -0.02em;
}

.section-title p {
    color: var(--p3m-muted);
    font-size: 15.5px;
    margin: 0 auto;
    max-width: 560px;
    line-height: 1.6;
}

/* ── DESKTOP TABLE VIEW (≥ 769px) ──────────────────── */
.premium-table-wrap {
    background: var(--p3m-surface);
    border: 1px solid var(--p3m-stroke);
    border-radius: 22px;
    padding: 28px 36px;
    box-shadow: 0 6px 24px rgba(15, 23, 42, 0.03);
}

.table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table thead th {
    background: var(--p3m-bg);
    color: var(--p3m-muted);
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 18px 22px;
    border: none;
    border-bottom: 2px solid var(--p3m-stroke);
}

.table thead th:first-child { border-top-left-radius: 12px; }
.table thead th:last-child { border-top-right-radius: 12px; }

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background: #f8fafc;
}

.table tbody td, .table tbody th {
    padding: 20px 22px;
    border-top: none;
    border-bottom: 1px solid var(--p3m-stroke);
    color: var(--p3m-muted);
    font-size: 14.5px;
    vertical-align: middle;
}

.table tbody tr:last-child td,
.table tbody tr:last-child th {
    border-bottom: none;
}

.col-panduan {
    color: var(--p3m-text) !important;
    font-size: 15.5px;
    font-weight: 700;
    line-height: 1.45;
    font-family: "Plus Jakarta Sans", sans-serif;
    display: flex;
    align-items: center;
    gap: 16px;
}

.col-panduan .doc-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--p3m-soft);
    color: var(--p3m-primary);
    font-size: 18px;
    flex-shrink: 0;
    border: 1px solid var(--p3m-border);
}

.btn-download-premium {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 9px 22px;
    border-radius: 10px;
    background: var(--p3m-soft);
    color: var(--p3m-dark);
    border: 1px solid var(--p3m-border);
    font-weight: 700;
    font-size: 13.5px;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    text-decoration: none;
}

.btn-download-premium:hover {
    background: var(--p3m-primary);
    color: #ffffff;
    border-color: var(--p3m-primary);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(5, 150, 105, 0.25);
}

.btn-download-premium i {
    font-size: 13px;
}

/* ── MOBILE DOCUMENT CARDS (< 769px) ───────────────── */
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
        padding: 0 8px;
    }

    .mobile-panduan-container {
        display: flex !important;
        flex-direction: column !important;
        gap: 16px !important;
    }

    .mobile-panduan-card {
        background: var(--p3m-surface);
        border: 1px solid var(--p3m-stroke);
        border-radius: 18px;
        padding: 18px 16px;
        box-shadow: 0 3px 14px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 16px;
    }

    .mobile-panduan-card:last-child {
        margin-bottom: 0;
    }

    .mobile-panduan-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .mobile-panduan-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: var(--p3m-soft);
        color: var(--p3m-primary);
        font-size: 20px;
        flex-shrink: 0;
        border: 1px solid var(--p3m-border);
    }

    .mobile-panduan-meta {
        flex: 1;
        min-width: 0;
    }

    .mobile-panduan-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        color: var(--p3m-dark);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 3px;
    }

    .mobile-panduan-title {
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 15.5px;
        font-weight: 700;
        color: var(--p3m-text);
        line-height: 1.42;
        margin: 0;
        word-break: break-word;
    }

    .btn-mobile-download {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        min-height: 44px;
        padding: 10px 16px;
        border-radius: 12px;
        background: var(--p3m-soft);
        color: var(--p3m-dark);
        border: 1px solid var(--p3m-border);
        font-weight: 700;
        font-size: 13.5px;
        text-decoration: none;
        transition: all 0.2s ease;
        -webkit-tap-highlight-color: transparent;
    }

    .btn-mobile-download:active {
        background: var(--p3m-primary);
        color: #ffffff;
        border-color: var(--p3m-primary);
        transform: scale(0.98);
    }

    .btn-mobile-download i {
        font-size: 14px;
    }

    .mobile-empty-state {
        background: var(--p3m-surface);
        border: 1px solid var(--p3m-stroke);
        border-radius: 18px;
        padding: 36px 20px;
        text-align: center;
        color: var(--p3m-muted);
    }

    .mobile-empty-state i {
        font-size: 36px;
        color: #cbd5e1;
        margin-bottom: 12px;
        display: block;
    }

    .mobile-empty-state p {
        font-size: 14px;
        font-weight: 600;
        margin: 0;
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
        <!-- Section Header -->
        <div class="section-title">
            <div class="section-label">Panduan</div>
            <h2>Panduan P3M</h2>
            <p>Kumpulan panduan P3M Politeknik Balekambang Jepara yang dapat dibaca dan diunduh.</p>
        </div>

        {{-- Desktop Table View (≥ 769px) --}}
        <div class="premium-table-wrap d-none d-md-block">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 70px; text-align: center;">No</th>
                            <th scope="col">Nama Panduan</th>
                            <th scope="col" style="width: 160px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($panduan as $d)
                            <tr>
                                <th scope="row" style="text-align: center; color: #94a3b8;">{{ $loop->iteration }}</th>
                                <td class="col-panduan">
                                    <div class="doc-icon">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                    <span>{{ $d->namefile }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('tampilan.unduh', $d->id) }}" class="btn-download-premium" title="Unduh Panduan">
                                        <i class="bi bi-download"></i>
                                        <span>Unduh</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5" style="color: #94a3b8;">
                                    <i class="bi bi-folder2-open fa-3x mb-3" style="font-size: 40px; color: #cbd5e1; display: block;"></i>
                                    <p class="mb-0" style="font-size: 15px; font-weight: 600;">Belum ada panduan yang tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Document Cards List (< 769px) --}}
        <div class="d-flex flex-column d-md-none mobile-panduan-container">
            @forelse ($panduan as $d)
                <div class="mobile-panduan-card">
                    <div class="mobile-panduan-header">
                        <div class="mobile-panduan-icon">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <div class="mobile-panduan-meta">
                            <span class="mobile-panduan-tag">Dokumen #{{ $loop->iteration }}</span>
                            <h3 class="mobile-panduan-title">{{ $d->namefile }}</h3>
                        </div>
                    </div>
                    <div class="mobile-panduan-action">
                        <a href="{{ route('tampilan.unduh', $d->id) }}" class="btn-mobile-download" aria-label="Unduh {{ $d->namefile }}">
                            <i class="bi bi-download"></i>
                            <span>Unduh Dokumen</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="mobile-empty-state">
                    <i class="bi bi-folder2-open"></i>
                    <p>Belum ada panduan yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
