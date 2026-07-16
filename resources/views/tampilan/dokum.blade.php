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
            <div class="section-label justify-content-center">Dokumen</div>
            <h2>Dokumen P3M</h2>
            <p>Kumpulan dokumen P3M Politeknik Balekambang Jepara yang dapat diakses dan diunduh.</p>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 90px;">No</th>
                        <th scope="col">Dokumen</th>
                        <th scope="col" style="width: 180px;">Get</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($dok as $d)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $d->namefile }}</td>
                            <td>
                                <a href="{{ asset('uploud/' . $d->originalname) }}" target="_blank" class="btn btn-info">
                                    <i class="fas fa-download"></i>
                                    Download
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada dokumen yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
