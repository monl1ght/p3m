@extends('layout.views')

@section('title', 'Agenda Kegiatan P3M')
@section('meta_description', 'Jadwal dan kalender agenda kegiatan penelitian, pengabdian, workshop, dan seminar P3M Politeknik Balekambang Jepara.')
@section('meta_keywords', 'Agenda P3M, Jadwal Kegiatan Polibang, Seminar Penelitian, Workshop Pengabdian Balekambang')
@section('canonical', route('tampilan.agenda'))

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Beranda",
      "item": "{{ route('tampilan') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Agenda P3M",
      "item": "{{ route('tampilan.agenda') }}"
    }
  ]
}
</script>
@endsection

@section('isi')

<style>
/* ── PREMIUM AGENDA STYLES (DESKTOP) ───────────────── */
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
    padding: 80px 0 120px;
}

.section-title {
    text-align: center;
    margin-bottom: 56px;
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
    white-space: nowrap;
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
.col-nama {
    color: var(--text-main) !important;
    font-size: 16px;
    font-weight: 700;
    line-height: 1.5;
    font-family: "Plus Jakarta Sans", sans-serif;
    max-width: 260px;
}

.col-keterangan {
    max-width: 320px;
    line-height: 1.7;
    color: var(--text-muted);
}

.col-date-time {
    font-weight: 600;
    color: #334155;
    white-space: nowrap;
}

/* Action Button */
.btn-action-view {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 14px;
    background: var(--primary-soft);
    color: var(--primary-light);
    border: 1px solid var(--primary-border);
    transition: var(--transition);
    text-decoration: none;
    font-size: 18px;
}

.btn-action-view:hover {
    background: var(--primary-light);
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(5, 150, 105, 0.25);
}

@media (max-width: 991px) {
    .premium-table-wrap {
        padding: 24px;
        border-radius: 20px;
    }
}

/* ── MOBILE HORIZONTAL SCROLL AGENDA CARDS (< 769px) ────── */
@media (max-width: 768px) {
    .portfolio-details.section {
        padding: 28px 0 60px;
    }

    .section-title {
        margin-bottom: 20px;
        text-align: center;
    }

    .section-title h2 {
        font-size: clamp(1.45rem, 5.2vw, 1.8rem);
        margin-bottom: 8px;
    }

    .section-title p {
        font-size: 13.5px;
        line-height: 1.5;
        padding: 0 12px;
    }

    /* Swipe hint header */
    .mobile-scroll-hint {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        padding: 0 4px;
        font-size: 12px;
    }

    .mobile-scroll-hint .hint-label {
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .mobile-scroll-hint .hint-action {
        color: var(--primary-light);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Horizontal swipe carousel */
    .agenda-scroll-container {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        overflow-y: hidden !important;
        scroll-snap-type: x mandatory !important;
        -webkit-overflow-scrolling: touch !important;
        gap: 14px !important;
        padding: 4px 16px 20px 16px !important;
        margin-left: -12px !important;
        margin-right: -12px !important;
        scrollbar-width: none !important;
    }

    .agenda-scroll-container::-webkit-scrollbar {
        display: none !important;
    }

    /* Minimalist Simple Card */
    .agenda-scroll-card {
        flex: 0 0 80% !important;
        max-width: 300px !important;
        scroll-snap-align: start !important;
        background: var(--surface) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 18px !important;
        padding: 18px 16px !important;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04) !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        gap: 14px !important;
        text-decoration: none !important;
        color: inherit !important;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease !important;
        -webkit-tap-highlight-color: transparent !important;
    }

    .agenda-scroll-card:active {
        transform: scale(0.98) !important;
        border-color: var(--primary-light) !important;
        background: #fcfdfd !important;
    }

    .card-top-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .badge-agenda-date {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 8px;
        background: var(--primary-soft);
        color: var(--primary-dark);
        border: 1px solid var(--primary-border);
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .badge-agenda-time {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
    }

    .badge-agenda-time i {
        font-size: 11px;
        color: #94a3b8;
    }

    .agenda-card-title {
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 14.5px;
        font-weight: 700;
        color: var(--text-main);
        line-height: 1.45;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 42px;
    }

    .agenda-card-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
    }

    .agenda-loc-info {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        min-width: 0;
        overflow: hidden;
    }

    .agenda-loc-info i {
        color: var(--primary-light);
        font-size: 12px;
        flex-shrink: 0;
    }

    .agenda-loc-info span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .agenda-view-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--primary-soft);
        color: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
        transition: background 0.15s ease, color 0.15s ease;
    }

    .agenda-scroll-card:active .agenda-view-icon {
        background: var(--primary-light);
        color: #ffffff;
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
            <div class="section-label">Agenda</div>
            <h2>Agenda Kegiatan P3M</h2>
            <p>Daftar agenda kegiatan P3M Politeknik Balekambang Jepara.</p>
        </div>

        {{-- Desktop Table View (≥ 769px) --}}
        <div class="premium-table-wrap d-none d-md-block">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 60px; text-align: center;">#</th>
                            <th scope="col">Nama Kegiatan</th>
                            <th scope="col" style="width: 140px;">Tanggal</th>
                            <th scope="col" style="width: 120px;">Waktu</th>
                            <th scope="col" style="width: 180px;">Lokasi</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col" style="width: 90px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($agenda as $d)
                            <tr>
                                <th scope="row" style="text-align: center; color: #94a3b8;">{{ $loop->iteration }}</th>
                                <td class="col-nama">
                                    {{ $d->title }}
                                </td>
                                <td class="col-date-time">
                                    <i class="far fa-calendar-alt me-1" style="color: #94a3b8;"></i> 
                                    {{ \Carbon\Carbon::parse($d->date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="col-date-time">
                                    <i class="far fa-clock me-1" style="color: #94a3b8;"></i>
                                    {{ \Carbon\Carbon::parse($d->time)->format('H:i') }}
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt me-1" style="color: #cbd5e1;"></i>
                                    {{ $d->lokasi }}
                                </td>
                                <td class="col-keterangan">
                                    {{ Str::words(strip_tags(html_entity_decode($d->keterangan)), 16, '...') }}
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('tampilan.detailagenda', ['id' => $d->id]) }}" class="btn-action-view" aria-label="Lihat detail agenda" title="Lihat Detail">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5" style="color: #94a3b8;">
                                    <i class="fas fa-inbox fa-3x mb-3" style="color: #e2e8f0;"></i>
                                    <p class="mb-0">Belum ada agenda kegiatan P3M.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Cards View (< 769px) — Horizontal Swipeable --}}
        <div class="d-block d-md-none">
            <div class="mobile-scroll-hint">
                <span class="hint-label">Agenda Kegiatan</span>
                <span class="hint-action">Geser <i class="bi bi-arrow-right"></i></span>
            </div>

            <div class="agenda-scroll-container">
                @forelse ($agenda as $d)
                    <a href="{{ route('tampilan.detailagenda', ['id' => $d->id]) }}" class="agenda-scroll-card">
                        <div class="card-top-meta">
                            <span class="badge-agenda-date">
                                <i class="bi bi-calendar4-week"></i>
                                {{ \Carbon\Carbon::parse($d->date)->translatedFormat('d M Y') }}
                            </span>
                            <span class="badge-agenda-time">
                                <i class="bi bi-clock"></i>
                                {{ \Carbon\Carbon::parse($d->time)->format('H:i') }}
                            </span>
                        </div>

                        <h3 class="agenda-card-title">
                            {{ $d->title }}
                        </h3>

                        <div class="agenda-card-bottom">
                            <div class="agenda-loc-info">
                                <i class="bi bi-geo-alt"></i>
                                <span>{{ $d->lokasi ?: 'Politeknik Balekambang' }}</span>
                            </div>
                            <div class="agenda-view-icon">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-4 w-100" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; color: #94a3b8; padding: 24px 16px;">
                        <i class="bi bi-calendar-x fa-2x mb-2" style="font-size: 32px; color: #cbd5e1; display: block;"></i>
                        <p class="mb-0" style="font-size: 14px; font-weight: 600;">Belum ada agenda kegiatan P3M.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

@endsection
