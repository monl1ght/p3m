@extends('layout.views')
@section('isi')


<style>
    :root {
        --p3m-hero-blue: #2563eb;
    }

    /*
        Hero banner fix:
        - Pakai banner sebagai gambar utuh.
        - Tidak ada overlay kuning tambahan dari CSS.
        - Overlay hanya gelap tipis di sisi kiri agar teks terbaca.
        - Agar sama seperti referensi, simpan banner referensi ke:
          public/mte/assets/img/banner-p3m.jpg
    */
    #hero.p3m-banner-hero {
        position: relative;
        min-height: 660px;
        height: calc(100vh - 162px);
        max-height: 780px;
        display: flex;
        align-items: center;
        overflow: hidden;
        background-image: url("{{ asset('mte/assets/img/banner-p3m.jpg') }}");
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        isolation: isolate;
    }

    #hero.p3m-banner-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            90deg,
            rgba(0, 31, 27, .46) 0%,
            rgba(0, 31, 27, .30) 34%,
            rgba(0, 31, 27, .08) 52%,
            rgba(0, 31, 27, 0) 70%
        );
        pointer-events: none;
        z-index: -1;
    }

    #hero.p3m-banner-hero .container {
        position: relative;
        z-index: 2;
    }

    #hero.p3m-banner-hero .hero-content {
        max-width: 660px;
        padding-top: 18px;
    }

    #hero.p3m-banner-hero .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        color: #dbeafe;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .18em;
        text-transform: uppercase;
    }

    #hero.p3m-banner-hero .hero-eyebrow::before {
        content: "";
        width: 44px;
        height: 2px;
        border-radius: 999px;
        background: #60a5fa;
    }

    #hero.p3m-banner-hero h1 {
        max-width: 650px;
        margin: 0;
        color: #ffffff;
        font-family: "Plus Jakarta Sans", "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        font-size: clamp(2.65rem, 4.55vw, 4.85rem);
        line-height: 1.03;
        font-weight: 900;
        letter-spacing: -.07em;
        text-wrap: balance;
    }

    #hero.p3m-banner-hero p {
        max-width: 610px;
        margin: 22px 0 0;
        color: rgba(255, 255, 255, .9);
        font-size: clamp(1rem, 1.25vw, 1.2rem);
        line-height: 1.7;
        font-weight: 600;
    }

    #hero.p3m-banner-hero .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 30px;
    }

    #hero.p3m-banner-hero .btn-brand,
    #hero.p3m-banner-hero .btn-outline-light {
        min-height: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 13px 21px;
        border-radius: 13px;
        font-size: 15px;
        font-weight: 850;
        line-height: 1;
        transition: .22s ease;
    }

    #hero.p3m-banner-hero .btn-brand {
        background: var(--p3m-hero-blue);
        border: 1px solid var(--p3m-hero-blue);
        color: #ffffff;
        box-shadow: 0 16px 30px rgba(37, 99, 235, .25);
    }

    #hero.p3m-banner-hero .btn-brand:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff;
        transform: translateY(-2px);
    }

    #hero.p3m-banner-hero .btn-outline-light {
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .30);
        color: #ffffff;
        backdrop-filter: blur(8px);
    }

    #hero.p3m-banner-hero .btn-outline-light:hover {
        background: rgba(255, 255, 255, .14);
        border-color: rgba(255, 255, 255, .52);
        color: #ffffff;
        transform: translateY(-2px);
    }

    .quick-access {
        position: relative;
        z-index: 10;
        margin-top: -58px;
    }

    .quick-access .quick-access-panel {
        border: 1px solid rgba(226, 232, 240, .95);
        border-radius: 28px;
        background: rgba(255, 255, 255, .97);
        box-shadow: 0 24px 60px rgba(15, 23, 42, .10);
        backdrop-filter: blur(12px);
    }

    @media (max-width: 1199.98px) {
        #hero.p3m-banner-hero {
            min-height: 620px;
            height: 74vh;
            background-position: 58% center;
        }

        #hero.p3m-banner-hero .hero-content {
            max-width: 620px;
        }
    }

    @media (max-width: 991.98px) {
        #hero.p3m-banner-hero {
            min-height: 620px;
            height: auto;
            padding: 118px 0 150px;
            background-position: 68% center;
        }

        #hero.p3m-banner-hero::before {
            background: linear-gradient(
                90deg,
                rgba(0, 54, 45, .92) 0%,
                rgba(0, 54, 45, .72) 54%,
                rgba(0, 54, 45, .28) 100%
            );
        }

        #hero.p3m-banner-hero .hero-content {
            max-width: 640px;
            padding-top: 0;
        }

        .quick-access {
            margin-top: -86px;
        }
    }

    @media (max-width: 575.98px) {
        #hero.p3m-banner-hero {
            min-height: 620px;
            padding: 96px 0 136px;
            background-position: 72% center;
        }

        #hero.p3m-banner-hero .hero-eyebrow {
            font-size: 11px;
            letter-spacing: .14em;
            gap: 9px;
            margin-bottom: 18px;
        }

        #hero.p3m-banner-hero .hero-eyebrow::before {
            width: 30px;
        }

        #hero.p3m-banner-hero h1 {
            font-size: clamp(2.35rem, 13vw, 3.35rem);
            line-height: 1.03;
        }

        #hero.p3m-banner-hero p {
            font-size: 15px;
            line-height: 1.65;
            margin-top: 18px;
        }

        #hero.p3m-banner-hero .hero-actions {
            gap: 10px;
            margin-top: 24px;
        }

        #hero.p3m-banner-hero .btn-brand,
        #hero.p3m-banner-hero .btn-outline-light {
            width: 100%;
            min-height: 50px;
        }

        .quick-access {
            margin-top: -70px;
        }

        .quick-access .quick-access-panel {
            border-radius: 22px;
        }
    }
</style>




<style>
    /*
        FIX new55:
        Menghilangkan shape/overlay kuning bawaan CSS lama pada .hero::after.
        Kalau masih muncul kuning setelah ini, berarti kuning tersebut sudah menyatu di file gambar banner-p3m.jpg.
    */
    #hero.p3m-banner-hero {
        background-image: url("{{ asset('mte/assets/img/banner-p3m.jpg') }}") !important;
        background-size: cover !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
        background-blend-mode: normal !important;
    }

    #hero.p3m-banner-hero::after {
        content: none !important;
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
        background: transparent !important;
    }

    #hero.p3m-banner-hero::before {
        content: "" !important;
        position: absolute !important;
        inset: 0 !important;
        display: block !important;
        background: linear-gradient(
            90deg,
            rgba(0, 31, 27, .42) 0%,
            rgba(0, 31, 27, .24) 34%,
            rgba(0, 31, 27, .06) 52%,
            rgba(0, 31, 27, 0) 70%
        ) !important;
        pointer-events: none !important;
        z-index: -1 !important;
    }

    #hero.p3m-banner-hero .hero-bg,
    #hero.p3m-banner-hero .hero-bg img {
        display: none !important;
    }

    @media (max-width: 991.98px) {
        #hero.p3m-banner-hero::before {
            background: linear-gradient(
                90deg,
                rgba(0, 54, 45, .92) 0%,
                rgba(0, 54, 45, .72) 54%,
                rgba(0, 54, 45, .28) 100%
            ) !important;
        }
    }
</style>


<style>
    /*
        FIX new56:
        Banner dibuat benar-benar full terlihat, tidak di-crop.
        background-size: 100% 100% dipakai agar seluruh banner masuk ke area hero.
    */
    #hero.p3m-banner-hero {
        min-height: 620px !important;
        height: clamp(620px, 42vw, 720px) !important;
        max-height: none !important;
        background-image: url("{{ asset('mte/assets/img/banner-p3m.jpg') }}") !important;
        background-size: 100% 100% !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
        background-color: #004638 !important;
        background-blend-mode: normal !important;
    }

    #hero.p3m-banner-hero::after {
        content: none !important;
        display: none !important;
    }

    #hero.p3m-banner-hero::before {
        content: "" !important;
        position: absolute !important;
        inset: 0 !important;
        display: block !important;
        background: linear-gradient(
            90deg,
            rgba(0, 31, 27, .34) 0%,
            rgba(0, 31, 27, .20) 34%,
            rgba(0, 31, 27, .05) 52%,
            rgba(0, 31, 27, 0) 70%
        ) !important;
        pointer-events: none !important;
        z-index: -1 !important;
    }

    #hero.p3m-banner-hero .hero-content {
        max-width: 650px !important;
        padding-top: 12px !important;
    }

    #hero.p3m-banner-hero h1 {
        font-size: clamp(2.55rem, 4.25vw, 4.55rem) !important;
        line-height: 1.04 !important;
    }

    .quick-access {
        margin-top: -44px !important;
    }

    @media (max-width: 1199.98px) {
        #hero.p3m-banner-hero {
            min-height: 600px !important;
            height: 600px !important;
            background-size: 100% 100% !important;
        }
    }

    @media (max-width: 991.98px) {
        #hero.p3m-banner-hero {
            min-height: 620px !important;
            height: auto !important;
            padding: 112px 0 148px !important;
            background-size: cover !important;
            background-position: 68% center !important;
        }

        #hero.p3m-banner-hero::before {
            background: linear-gradient(
                90deg,
                rgba(0, 54, 45, .92) 0%,
                rgba(0, 54, 45, .72) 54%,
                rgba(0, 54, 45, .28) 100%
            ) !important;
        }

        .quick-access {
            margin-top: -76px !important;
        }
    }

    @media (max-width: 575.98px) {
        #hero.p3m-banner-hero {
            min-height: 620px !important;
            padding: 96px 0 136px !important;
            background-size: cover !important;
            background-position: 72% center !important;
        }

        .quick-access {
            margin-top: -64px !important;
        }
    }
</style>


<style>
    /*
        FIX new57:
        Tidak gepeng dan tidak memaksa gambar 100% x 100%.
        Banner dipasang mengikuti rasio asli 2:1:
        lebar penuh, tinggi mengikuti lebar.
    */
    #hero.p3m-banner-hero {
        min-height: 0 !important;
        height: calc(100vw * 0.5) !important;
        max-height: none !important;
        padding: 0 !important;
        background-image: url("{{ asset('mte/assets/img/banner-p3m.jpg') }}") !important;
        background-size: 100% auto !important;
        background-position: center top !important;
        background-repeat: no-repeat !important;
        background-color: #004638 !important;
        background-blend-mode: normal !important;
        display: flex !important;
        align-items: center !important;
        overflow: hidden !important;
    }

    #hero.p3m-banner-hero::after {
        content: none !important;
        display: none !important;
    }

    #hero.p3m-banner-hero::before {
        content: "" !important;
        position: absolute !important;
        inset: 0 !important;
        display: block !important;
        background: linear-gradient(
            90deg,
            rgba(0, 31, 27, .28) 0%,
            rgba(0, 31, 27, .16) 34%,
            rgba(0, 31, 27, .04) 52%,
            rgba(0, 31, 27, 0) 70%
        ) !important;
        pointer-events: none !important;
        z-index: -1 !important;
    }

    #hero.p3m-banner-hero .hero-content {
        max-width: 650px !important;
        padding-top: 0 !important;
        transform: translateY(-6px);
    }

    #hero.p3m-banner-hero .hero-eyebrow {
        margin-bottom: 22px !important;
    }

    #hero.p3m-banner-hero h1 {
        font-size: clamp(2.5rem, 4.2vw, 4.5rem) !important;
        line-height: 1.04 !important;
    }

    #hero.p3m-banner-hero p {
        margin-top: 20px !important;
    }

    #hero.p3m-banner-hero .hero-actions {
        margin-top: 28px !important;
    }

    .quick-access {
        margin-top: -52px !important;
    }

    @media (max-width: 1199.98px) {
        #hero.p3m-banner-hero {
            height: calc(100vw * 0.5) !important;
            min-height: 560px !important;
            background-size: auto 100% !important;
            background-position: center top !important;
        }
    }

    @media (max-width: 991.98px) {
        #hero.p3m-banner-hero {
            min-height: 620px !important;
            height: auto !important;
            padding: 112px 0 148px !important;
            background-size: cover !important;
            background-position: 68% center !important;
        }

        #hero.p3m-banner-hero::before {
            background: linear-gradient(
                90deg,
                rgba(0, 54, 45, .92) 0%,
                rgba(0, 54, 45, .72) 54%,
                rgba(0, 54, 45, .28) 100%
            ) !important;
        }

        #hero.p3m-banner-hero .hero-content {
            transform: none;
        }

        .quick-access {
            margin-top: -76px !important;
        }
    }

    @media (max-width: 575.98px) {
        #hero.p3m-banner-hero {
            min-height: 620px !important;
            padding: 96px 0 136px !important;
            background-size: cover !important;
            background-position: 72% center !important;
        }

        .quick-access {
            margin-top: -64px !important;
        }
    }
</style>

@php
    $hero = $dash->first();
    $about = $tentang->first();
@endphp

<section id="hero" class="hero p3m-banner-hero">
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <div class="hero-eyebrow">Pusat Penelitian dan Pengabdian</div>

            <h1>
                {{ $hero->title ?? 'Pusat Penelitian dan Pengabdian Kepada Masyarakat' }}
            </h1>

            <p>
                {{ $hero->instansi ?? 'Politeknik Balekambang Jepara' }}
            </p>

            <div class="hero-actions">
                <a href="{{ route('tampilan.dokumen') }}" class="btn-brand">
                    Dokumen P3M
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('tampilan.berita') }}" class="btn-outline-light">
                    Kegiatan Terbaru
                </a>
            </div>
        </div>
    </div>
</section>

<section class="quick-access">
    <div class="container">
        <div class="quick-access-panel" data-aos="fade-up">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <a href="{{ route('tampilan.dokumen') }}" class="quick-link">
                        <span class="quick-link-icon"><i class="bi bi-file-earmark-text"></i></span>
                        <span>
                            <h3>Dokumen</h3>
                            <p>Dokumen P3M</p>
                        </span>
                    </a>
                </div>

                <div class="col-6 col-lg-3">
                    <a href="{{ route('tampilan.berita') }}" class="quick-link">
                        <span class="quick-link-icon"><i class="bi bi-newspaper"></i></span>
                        <span>
                            <h3>Kegiatan</h3>
                            <p>Kegiatan P3M</p>
                        </span>
                    </a>
                </div>

                <div class="col-6 col-lg-3">
                    <a href="{{ route('tampilan.agenda') }}" class="quick-link">
                        <span class="quick-link-icon"><i class="bi bi-calendar-event"></i></span>
                        <span>
                            <h3>Berita</h3>
                            <p>Berita P3M</p>
                        </span>
                    </a>
                </div>

                <div class="col-6 col-lg-3">
                    <a href="{{ route('tampilan.jurnal') }}" class="quick-link">
                        <span class="quick-link-icon"><i class="bi bi-journal-bookmark"></i></span>
                        <span>
                            <h3>Jurnal</h3>
                            <p>Jurnal P3M</p>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="about-modern">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="about-image">
                    @if($hero && $hero->image)
                        <img src="{{ asset('storage/photo-dash/'.$hero->image) }}" alt="{{ $hero->title }}">
                    @else
                        <img src="{{ asset('mte/assets/img/polibang.png') }}" alt="Politeknik Balekambang">
                    @endif
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up">
                <div class="about-copy">
                    <div class="section-label">Tentang P3M</div>
                    <h2>Penelitian dan Pengabdian Masyarakat</h2>

                    <div class="content">
                        @if($about)
                            <p>{!! Str::words(strip_tags($about->ourbout), 48) !!}</p>
                        @else
                            <p>P3M berperan dalam mendukung penelitian dan pengabdian kepada masyarakat di lingkungan Politeknik Balekambang Jepara.</p>
                        @endif
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('tampilan.tentangp3m') }}" class="btn-brand">
                            Selengkapnya
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3" data-aos="fade-left">
                <div class="row g-3">
                    <div class="col-6 col-lg-12">
                        <div class="stat-card">
                            <strong>{{ $berita->count() }}+</strong>
                            <span>Kegiatan</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-12">
                        <div class="stat-card">
                            <strong>{{ $agenda->count() }}+</strong>
                            <span>Berita P3M</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-12">
                        <div class="stat-card">
                            <strong>{{ $pengelola->count() }}+</strong>
                            <span>Pengelola</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-12">
                        <div class="stat-card">
                            <strong>{{ $categories->count() }}+</strong>
                            <span>Kategori</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services" class="services section section-soft">
    <div class="container section-title" data-aos="fade-up">
        <h2>Berita P3M</h2>
        <p>Berita Pelaksanaan Kegiatan P3M di Politeknik Balekambang Jepara</p>
    </div>

    <div class="container">
        <div class="row gy-4">
            @forelse($agenda as $genda)
                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative w-100">
                        <div class="icon"><i class="bi bi-calendar4-week"></i></div>
                        <h4>
                            <a href="{{ route('tampilan.detailagenda', ['id' => $genda->id]) }}" class="stretched-link">
                                {{ $genda->title }}
                            </a>
                        </h4>
                        <p>
                            <i class="far fa-calendar-alt"></i>
                            {{ $genda->date }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="content-card text-center">
                        Belum ada berita P3M.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section id="call-to-action" class="call-to-action">
    <img src="{{ asset('mte/assets/img/polibang.png') }}" alt="Politeknik Balekambang">

    <div class="container">
        <div class="row align-items-center g-4" data-aos="zoom-in">
            <div class="col-xl-9 text-center text-xl-start">
                <h3>Cari Tau Yuk !!</h3>
                <p>Cari tahu bagaimana P3M mendukung penelitian dan pengabdian masyarakat untuk dosen dan mahasiswa.</p>
            </div>
            <div class="col-xl-3 text-center text-xl-end">
                <a class="cta-btn" href="{{ route('tampilan.panduan') }}">Pelajari Panduan</a>
            </div>
        </div>
    </div>
</section>

<section id="portfolio" class="portfolio section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Kegiatan P3M</h2>
        <p>Dokumentasi Kegiatan P3M Di Politeknik Balekambang Jepara</p>
    </div>

    <div class="container">
        <div class="row gy-4">
            @foreach($berita->take(3) as $d)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <article class="card-clean h-100">
                        <img src="{{ asset('storage/photo-news/'.$d->image) }}" class="news-card-image" alt="{{ $d->title }}">

                        <div class="card-clean-body">
                            <div class="card-meta">
                                <i class="fas fa-calendar-week"></i>
                                <span>{{ $d->date }}</span>
                            </div>

                            <h3>{!! Str::words(strip_tags($d->title), 10) !!}</h3>
                            <p>{!! Str::words(strip_tags($d->content), 18) !!}</p>

                            <a href="{{ route('tampilan.detail', ['id' => $d->id]) }}" class="link-more">
                                Detail
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="zoom-in">
            <a href="{{ route('tampilan.berita') }}" class="btn-brand">
                Selengkapnya
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<section id="team" class="team section dark-background">
    <div class="container section-title" data-aos="fade-up">
        <h2>Team P3M</h2>
        <p>Pengelola Pusat Penelitian dan Pengabdian Masyarakat</p>
    </div>

    <div class="container">
        <div class="row gy-4">
            @foreach($pengelola as $d)
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member d-flex align-items-start">
                        <div class="pic">
                            <img src="{{ asset('storage/photo-pengelola/'.$d->image) }}" class="img-fluid" alt="{{ $d->nama_pengelola }}">
                        </div>
                        <div class="member-info">
                            <h4>{{ $d->nama_pengelola }}</h4>
                            <span>{{ $d->jabatan_pengelola }}</span>
                            <p>{{ $d->NIDN }}</p>
                            <div class="social">
                                <a href="mailto:{{ $d->email_pengelola }}"><i class="bi bi-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="zoom-in">
            <a href="{{ route('tampilan.struktur') }}" class="btn-outline-light">
                Selengkapnya
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

@endsection
