@extends('layout.views')
@section('isi')

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
                        <span>{{ $agen->date }}</span>
                    </div>

                    <div class="card-meta">
                        <i class="far fa-clock"></i>
                        <span>{{ $agen->date }}</span>
                    </div>

                    @if(!empty($agen->lokasi))
                        <div class="card-meta">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $agen->lokasi }}</span>
                        </div>
                    @endif

                    <div class="content-body mt-4">
                        {!! $agen->keterangan !!}
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                    <h3>Kegiatan terbaru</h3>

                    <ul>
                        @foreach($agenda as $agen)
                            <li>
                                <h6>
                                    <i class="far fa-newspaper"></i>
                                    <a href="{{ route('tampilan.detail', ['id' => $agen->id]) }}">
                                        {{ $agen->title }}
                                    </a>
                                </h6>
                                <p>{{ Str::words(strip_tags($agen->content), 10) }}</p>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</section>

@endsection
