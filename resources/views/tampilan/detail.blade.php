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
                <div class="portfolio-details-slider swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                        {
                            "loop": true,
                            "speed": 600,
                            "autoplay": {
                                "delay": 5000
                            },
                            "slidesPerView": "auto",
                            "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                            }
                        }
                    </script>

                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/photo-news/'.$berita->image) }}" alt="{{ $berita->title }}">
                        </div>
                    </div>
                </div>

                <article class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-meta">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $berita->date }}</span>
                    </div>

                    <h2>{{ $berita->title }}</h2>

                    <div class="content-body">
                        {!! $berita->content !!}
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                    <h3>Kegiatan terbaru</h3>

                    <ul>
                        @foreach($data as $news)
                            <li>
                                <h6>
                                    <i class="far fa-newspaper"></i>
                                    <a href="{{ route('tampilan.detail', ['id' => $news->id]) }}">
                                        {{ $news->title }}
                                    </a>
                                </h6>
                                <p>{{ Str::words(strip_tags($news->content), 12) }}</p>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</section>

@endsection
