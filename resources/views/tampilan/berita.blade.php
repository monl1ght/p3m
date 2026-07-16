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

<section id="team" class="team section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <div class="section-label justify-content-center">Kegiatan P3M</div>
            <h2>Kegiatan P3M POLIBANG</h2>
            <p>Informasi dan dokumentasi kegiatan P3M Politeknik Balekambang Jepara.</p>
        </div>

        <div class="row gy-4">
            @forelse($berita as $d)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <article class="card-clean h-100">
                        <img src="{{ asset('storage/photo-news/'.$d->image) }}" class="news-card-image" alt="{{ $d->title }}">

                        <div class="card-clean-body">
                            <div class="card-meta">
                                <i class="bi bi-person-circle"></i>
                                <span>{{ optional($d->user)->name ?? 'P3M Polibang' }}</span>
                            </div>

                            <h3>{{ $d->title }}</h3>
                            <p>{{ Str::words(strip_tags($d->content), 18) }}</p>

                            <a href="{{ route('tampilan.detail', ['id' => $d->id]) }}" class="link-more">
                                Detail
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="content-card text-center">
                        Belum ada kegiatan P3M yang tersedia.
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
