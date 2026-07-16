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
    <div class="container section-title" data-aos="fade-up">
        <div class="section-label justify-content-center">Struktur Organisasi</div>
        <h2>Team P3M</h2>
        <p>Pengelola Pusat Penelitian dan Pengabdian Masyarakat</p>
    </div>

    <div class="container">
        <div class="row gy-4">
            @forelse($pengelola as $d)
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
                                <a href="mailto:{{ $d->email_pengelola }}" aria-label="Email {{ $d->nama_pengelola }}">
                                    <i class="bi bi-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="content-card text-center">
                        Belum ada data pengelola P3M.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
