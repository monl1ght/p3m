@extends('layout.views')

@section('title', 'Data Penelitian Dosen P3M')
@section('meta_description', 'Direktori dan rekapitulasi data penelitian dosen yang telah disetujui serta didanai oleh P3M Politeknik Balekambang Jepara.')
@section('meta_keywords', 'Penelitian Dosen, Riset Terapan, Penelitian Polibang, P3M Politeknik Balekambang, Proposal Penelitian')
@section('canonical', route('tampilan.penelitian'))

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
      "name": "Data Penelitian P3M",
      "item": "{{ route('tampilan.penelitian') }}"
    }
  ]
}
</script>
@endsection

@section('isi')

<style>
/* ── PENELITIAN P3M MODERN RESPONSIVE STYLES ───────── */
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
    white-space: nowrap;
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

.col-judul {
    color: var(--p3m-text) !important;
    font-size: 15.5px;
    font-weight: 700;
    line-height: 1.5;
    font-family: "Plus Jakarta Sans", sans-serif;
    max-width: 320px;
}

.col-ketua {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 600;
    color: var(--p3m-text);
}

.avatar-initial {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: var(--p3m-soft);
    color: var(--p3m-dark);
    border: 1px solid var(--p3m-border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 14px;
    flex-shrink: 0;
}

.badge-bidang-pill {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 700;
    background: #f0fdf4;
    color: var(--p3m-dark);
    border: 1px solid var(--p3m-border);
}

.btn-download-premium {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 9px 20px;
    border-radius: 10px;
    background: var(--p3m-soft);
    color: var(--p3m-dark);
    border: 1px solid var(--p3m-border);
    font-weight: 700;
    font-size: 13px;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    text-decoration: none;
    white-space: nowrap;
}

.btn-download-premium:hover {
    background: var(--p3m-primary);
    color: #ffffff;
    border-color: var(--p3m-primary);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(5, 150, 105, 0.25);
}

/* ── MOBILE RESEARCH CARDS (< 769px) ───────────────── */
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

    .mobile-research-container {
        display: flex !important;
        flex-direction: column !important;
        gap: 16px !important;
    }

    .mobile-research-card {
        background: var(--p3m-surface);
        border: 1px solid var(--p3m-stroke);
        border-radius: 18px;
        padding: 18px 16px;
        box-shadow: 0 3px 14px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 16px;
    }

    .mobile-research-card:last-child {
        margin-bottom: 0;
    }

    .mobile-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .mobile-badge-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .mobile-date-text {
        font-size: 12px;
        color: var(--p3m-muted);
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 500;
    }

    .mobile-card-num {
        font-size: 12px;
        font-weight: 800;
        color: #94a3b8;
    }

    .mobile-research-title {
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 15.5px;
        font-weight: 700;
        color: var(--p3m-text);
        line-height: 1.45;
        margin: 0;
        word-break: break-word;
    }

    .mobile-research-author {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }

    .author-details {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .author-label {
        font-size: 11px;
        color: var(--p3m-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .author-name {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--p3m-text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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

    .mobile-no-file {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 10px 16px;
        border-radius: 12px;
        background: #f8fafc;
        color: #94a3b8;
        border: 1px dashed var(--p3m-stroke);
        font-size: 12.5px;
        font-weight: 600;
    }

    .mobile-empty-state {
        background: var(--p3m-surface);
        border: 1px solid var(--p3m-stroke);
        border-radius: 18px;
        padding: 44px 20px;
        text-align: center;
        color: var(--p3m-muted);
        box-shadow: 0 3px 14px rgba(15, 23, 42, 0.03);
    }

    .empty-icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--p3m-soft);
        color: var(--p3m-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin: 0 auto 16px;
        border: 1px solid var(--p3m-border);
    }

    .mobile-empty-state h4 {
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 17px;
        font-weight: 800;
        color: var(--p3m-text);
        margin: 0 0 6px;
    }

    .mobile-empty-state p {
        font-size: 13.5px;
        line-height: 1.55;
        margin: 0;
        color: var(--p3m-muted);
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
            <div class="section-label">Penelitian</div>
            <h2>Penelitian P3M</h2>
            <p>Daftar penelitian yang telah disetujui oleh P3M Politeknik Balekambang Jepara.</p>
        </div>

        {{-- Desktop Table View (≥ 769px) --}}
        <div class="premium-table-wrap d-none d-md-block">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 70px; text-align: center;">No</th>
                            <th scope="col">Judul Penelitian</th>
                            <th scope="col">Ketua Peneliti</th>
                            <th scope="col">Bidang</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col" style="width: 140px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penelitian as $p)
                            <tr>
                                <th scope="row" style="text-align: center; color: #94a3b8;">{{ $loop->iteration }}</th>
                                <td class="col-judul">
                                    {{ $p->judul }}
                                </td>
                                <td>
                                    <div class="col-ketua">
                                        <div class="avatar-initial">{{ strtoupper(substr(trim($p->ketua), 0, 1)) ?: '?' }}</div>
                                        <span>{{ $p->ketua }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-bidang-pill">{{ $p->bidang ?? 'Umum' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2" style="color: #64748b; font-weight: 500;">
                                        <i class="bi bi-calendar-event"></i>
                                        {{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d M Y') }}
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    @if($p->uppdf)
                                        <a href="{{ route('tampilan.download_karya', ['type' => 'penelitian', 'id' => $p->id]) }}" class="btn-download-premium" title="Unduh File">
                                            <i class="bi bi-download"></i>
                                            <span>Unduh</span>
                                        </a>
                                    @else
                                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">Belum ada file</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5" style="color: #94a3b8;">
                                    <i class="bi bi-journal-x fa-3x mb-3" style="font-size: 40px; color: #cbd5e1; display: block;"></i>
                                    <p class="mb-0" style="font-size: 15px; font-weight: 600;">Belum ada data penelitian yang disetujui.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Cards View (< 769px) --}}
        <div class="d-flex flex-column d-md-none mobile-research-container">
            @forelse ($penelitian as $p)
                <div class="mobile-research-card">
                    <div class="mobile-card-top">
                        <div class="mobile-badge-group">
                            <span class="badge-bidang-pill">{{ $p->bidang ?? 'Umum' }}</span>
                            <span class="mobile-date-text">
                                <i class="bi bi-calendar-event"></i>
                                {{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        <span class="mobile-card-num">#{{ $loop->iteration }}</span>
                    </div>

                    <h3 class="mobile-research-title">{{ $p->judul }}</h3>

                    <div class="mobile-research-author">
                        <div class="avatar-initial">{{ strtoupper(substr(trim($p->ketua), 0, 1)) ?: '?' }}</div>
                        <div class="author-details">
                            <span class="author-label">Ketua Peneliti</span>
                            <span class="author-name">{{ $p->ketua }}</span>
                        </div>
                    </div>

                    <div class="mobile-card-action">
                        @if($p->uppdf)
                            <a href="{{ route('tampilan.download_karya', ['type' => 'penelitian', 'id' => $p->id]) }}" class="btn-mobile-download" aria-label="Unduh dokumen {{ $p->judul }}">
                                <i class="bi bi-download"></i>
                                <span>Unduh Dokumen</span>
                            </a>
                        @else
                            <div class="mobile-no-file">
                                <i class="bi bi-file-earmark-x"></i>
                                <span>Dokumen Belum Tersedia</span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="mobile-empty-state">
                    <div class="empty-icon-wrap">
                        <i class="bi bi-journal-x"></i>
                    </div>
                    <h4>Belum Ada Penelitian</h4>
                    <p>Saat ini belum ada data penelitian yang telah disetujui untuk dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
