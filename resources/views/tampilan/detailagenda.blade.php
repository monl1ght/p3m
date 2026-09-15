@extends('layout.views')
@section('isi')

<style>
/* Perbaikan Desain Card Detail & Sidebar */
.portfolio-details .row {
    align-items: stretch;
}

.portfolio-description, .portfolio-info {
    height: 100%;
    background: #ffffff;
    border: 1px solid #e2e8f0 !important;
    border-radius: 24px !important;
    padding: 48px !important;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04) !important;
    transition: all 0.3s ease;
}

.portfolio-description:hover, .portfolio-info:hover {
    box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08) !important;
    border-color: #cbd5e1 !important;
}

.section-label {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    color: #059669;
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
    background: #059669;
    opacity: 0.5;
}

.portfolio-description h2 {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 24px;
    line-height: 1.4;
    letter-spacing: -0.02em;
}

.card-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    color: #475569;
    font-size: 15px;
}

.card-meta i {
    color: #94a3b8;
    width: 20px;
    text-align: center;
}

.portfolio-description .content-body {
    font-size: 16px;
    line-height: 1.85;
    color: #475569;
    text-align: justify;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #f1f5f9;
}

.portfolio-info h3 {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f1f5f9;
}

.portfolio-info ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.portfolio-info ul li {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 0;
    border: none;
}

.portfolio-info ul li h6 {
    font-size: 15px;
    font-weight: 700;
    line-height: 1.4;
    margin: 0;
}

.portfolio-info ul li h6 a {
    color: #0f172a;
    text-decoration: none;
    transition: color 0.2s;
}

.portfolio-info ul li h6 a:hover {
    color: #059669;
}

.portfolio-info ul li h6 i {
    color: #059669;
    margin-right: 6px;
}

.portfolio-info ul li p {
    font-size: 14px;
    line-height: 1.6;
    color: #64748b;
    margin: 0;
}

@media (max-width: 991px) {
    .portfolio-description, .portfolio-info {
        padding: 32px 24px !important;
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
        <div class="row gy-4">
            <div class="col-lg-8">
                <article class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
                    <div class="section-label">Detail Agenda</div>

                    <h2>{{ $agen->title }}</h2>

                    <div class="card-meta">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ \Carbon\Carbon::parse($agen->date)->translatedFormat('d F Y') }}</span>
                    </div>

                    <div class="card-meta">
                        <i class="far fa-clock"></i>
                        <span>{{ \Carbon\Carbon::parse($agen->time)->format('H:i') }} WIB</span>
                    </div>

                    @if(!empty($agen->lokasi))
                        <div class="card-meta">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $agen->lokasi }}</span>
                        </div>
                    @endif

                    <div class="content-body">
                        {!! nl2br(strip_tags(html_entity_decode($agen->keterangan))) !!}
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                    <h3>Agenda Lainnya</h3>

                    <ul>
                        @foreach($agenda as $recentAgenda)
                            <li>
                                <h6>
                                    <a href="{{ route('tampilan.detailagenda', ['id' => $recentAgenda->id]) }}">
                                        <i class="far fa-calendar-check"></i>
                                        {{ $recentAgenda->title }}
                                    </a>
                                </h6>
                                <p>{{ Str::words(strip_tags(html_entity_decode($recentAgenda->keterangan)), 10) }}</p>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</section>

@endsection
