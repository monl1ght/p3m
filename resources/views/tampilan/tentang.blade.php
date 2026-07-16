@extends('layout.views')
@section('isi')

<style>
    .portfolio-info a {
        color: #000;
        text-decoration: none;
        font-size: inherit;
        font-weight: inherit;
    }

    .portfolio-info a:hover {
        text-decoration: underline;
    }

    ul {
        list-style-type: square;
        padding-left: 20px;
    }

    li {
        margin-bottom: 12px;
    }

    h6 {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .card-text {
        font-size: 14px;
        color: #666;
        margin: 0;

    }
</style>
<div class="page-title mt-5" data-aos="fade">
    <div class="container">
        <nav class="breadcrumbs mt-5">
            <ol>
                <li><a href="{{ route('tampilan') }}">Home</a></li>
                <li class="current">{{ $pagetitle }}</li>
            </ol>
        </nav>
        <h1>{{ $pagetitle }}</h1>
        <small>Politeknik Balekambang Jepara</small>
    </div>
</div>

<body class="portfolio-details-page mt-5">
    <main class="main mt-5">
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
                        </div>
                        <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
                            @foreach ($tentang as $bout)
                            <h2>Tentang Kami</h2>
                            <p>
                                {!! $bout->ourbout !!}
                            </p>
                            <h2>Visi Kami</h2>
                            <p>
                                {!! $bout->visi !!}
                            </p>
                            <h2>Misi Kami</h2>
                            <p>
                                {!! $bout->misi !!}
                            </p>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                            <h3>Berita terbaru</h3>
                            <ul>
                                @foreach($berita as $news)
                                <li>
                                    <h6>
                                        <i class="far fa-newspaper"></i>
                                        <a href="{{ route('tampilan.detail', ['id' => $news->id]) }}" style="color: #133E87;">{{ $news->title }}</a>
                                    </h6>
                                    <p>{{ Str::words(strip_tags($news->content), 10) }}</p>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
@endsection