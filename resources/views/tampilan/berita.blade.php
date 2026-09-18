@extends('layout.views')

@section('title', 'Kegiatan dan Berita P3M')
@section('meta_description', 'Kumpulan berita, liputan kegiatan, dan dokumentasi penelitian serta pengabdian masyarakat di lingkungan P3M Politeknik Balekambang Jepara.')
@section('meta_keywords', 'Berita P3M, Kegiatan P3M Polibang, Riset Politeknik Balekambang, Pengabdian Balekambang Jepara')
@section('canonical', route('tampilan.berita'))

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
      "name": "Kegiatan P3M",
      "item": "{{ route('tampilan.berita') }}"
    }
  ]
}
</script>
@endsection

@section('isi')

<style>
/* ── PREMIUM KEGIATAN P3M STYLES (DESKTOP) ───────────────── */
:root {
    --primary-light: #059669;
    --primary-dark: #047857;
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

.team.section {
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

/* Premium Card Design */
.premium-news-card {
    display: flex;
    flex-direction: column;
    background: var(--surface);
    border: 1px solid var(--border-color);
    border-radius: 24px;
    overflow: hidden;
    height: 100%;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    transition: var(--transition);
}

.premium-news-card:hover {
    box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
    transform: translateY(-4px);
    border-color: #cbd5e1;
}

.news-card-img-wrap {
    position: relative;
    width: 100%;
    height: 240px;
    background-color: #e2e8f0;
    overflow: hidden;
}

.news-card-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
    color: transparent; /* hides alt text if image is broken */
}

.premium-news-card:hover .news-card-img-wrap img {
    transform: scale(1.05);
}

.news-card-body {
    padding: 32px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.news-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 16px;
}

.news-meta i {
    color: var(--primary-light);
    font-size: 15px;
}

.news-card-body h3 {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 20px;
    font-weight: 800;
    color: var(--text-main);
    line-height: 1.4;
    margin: 0 0 16px;
    letter-spacing: -0.01em;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.news-card-body p {
    font-size: 15px;
    line-height: 1.7;
    color: var(--text-muted);
    margin: 0 0 32px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.news-card-footer {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.btn-read-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14.5px;
    font-weight: 700;
    color: var(--primary-light);
    text-decoration: none;
    transition: var(--transition);
}

.btn-read-more i {
    transition: transform 0.3s ease;
}

.btn-read-more:hover {
    color: var(--primary-dark);
}

.btn-read-more:hover i {
    transform: translateX(4px);
}

/* Pagination Overrides */
.pagination {
    margin: 0;
    gap: 4px;
}
.page-item .page-link {
    border-radius: 8px;
    border: 1px solid var(--border-color);
    color: var(--text-main);
    font-weight: 600;
    min-width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}
.page-item.active .page-link {
    background-color: var(--primary-light);
    border-color: var(--primary-light);
    color: #fff;
}
.page-item:not(.active) .page-link:hover {
    background-color: #f1f5f9;
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

<section id="team" class="team section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <div class="section-label">Kegiatan P3M</div>
            <h2>Kegiatan P3M POLIBANG</h2>
            <p>Informasi dan dokumentasi kegiatan P3M Politeknik Balekambang Jepara.</p>
        </div>

        <div class="row gy-4">
            @forelse($berita as $d)
                <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <article class="premium-news-card w-100">
                        <div class="news-card-img-wrap">
                            <img src="{{ asset('storage/photo-news/'.$d->image) }}" alt="{{ $d->title }}" onerror="this.src='{{ asset('mte/assets/img/polibang.webp') }}';" loading="lazy" width="400" height="220" decoding="async">
                        </div>

                        <div class="news-card-body">
                            <div class="news-meta">
                                <i class="far fa-user-circle"></i>
                                <span>{{ optional($d->user)->name ?? 'Pengelola P3M' }}</span>
                                <span style="color: #cbd5e1; margin: 0 4px;">•</span>
                                <span>{{ \Carbon\Carbon::parse($d->created_at)->translatedFormat('d M Y') }}</span>
                            </div>

                            <h3>{{ $d->title }}</h3>
                            <p>{{ Str::words(strip_tags(html_entity_decode($d->content)), 16) }}</p>

                            <div class="news-card-footer">
                                <a href="{{ route('tampilan.detail', ['id' => $d->id]) }}" class="btn-read-more" aria-label="Baca selengkapnya mengenai {{ $d->title }}">
                                    Baca Selengkapnya
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5" style="background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; color: #94a3b8;">
                        <i class="fas fa-inbox fa-3x mb-3" style="color: #cbd5e1;"></i>
                        <p class="mb-0" style="font-size: 16px; font-weight: 600;">Belum ada kegiatan P3M yang tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $berita->links('pagination::bootstrap-4') }}
        </div>
    </div>
</section>

@endsection
