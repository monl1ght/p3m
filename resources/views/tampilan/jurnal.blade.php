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
        <div class="section-title">
            <div class="section-label justify-content-center">Jurnal</div>
            <h2>Jurnal P3M</h2>
            <p>Daftar jurnal penelitian dan pengabdian masyarakat yang terhubung dengan P3M Politeknik Balekambang Jepara.</p>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 90px;">No</th>
                        <th scope="col">Jurnal</th>
                        <th scope="col" style="width: 140px;">Get</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($dok as $d)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                <strong>{{ $d->jurnalname }}</strong>
                            </td>
                            <td>
                                <a href="{{ $d->link }}" target="_blank" class="btn btn-info" aria-label="Buka jurnal">
                                    <i class="fas fa-link"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada jurnal yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
