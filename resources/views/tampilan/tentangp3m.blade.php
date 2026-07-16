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
                <div class="content-card" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($tentang as $bout)
                        <div class="section-label">Profil P3M</div>

                        <h2>Tentang Kami</h2>
                        <div class="content-body mb-5">
                            {!! $bout->ourbout !!}
                        </div>

                        <h2>Visi Kami</h2>
                        <div class="content-body mb-5">
                            {!! $bout->visi !!}
                        </div>

                        <h2>Misi Kami</h2>
                        <div class="content-body">
                            {!! $bout->misi !!}
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4">
                <aside class="portfolio-info" data-aos="fade-up" data-aos-delay="300">
                    <h3>Kegiatan terbaru</h3>

                    <ul>
                        @foreach($berita as $news)
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
