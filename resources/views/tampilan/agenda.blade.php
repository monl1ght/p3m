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
            <div class="section-label justify-content-center">Agenda</div>
            <h2>Agenda Kegiatan P3M</h2>
            <p>Daftar agenda kegiatan P3M Politeknik Balekambang Jepara.</p>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 80px;">#</th>
                        <th scope="col">Nama Kegiatan</th>
                        <th scope="col" style="width: 150px;">Tanggal</th>
                        <th scope="col" style="width: 130px;">Waktu</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col" style="width: 90px;">#</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($agenda as $d)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                <strong>{{ $d->title }}</strong>
                            </td>
                            <td>{{ $d->date }}</td>
                            <td>{{ $d->time }}</td>
                            <td>{{ $d->lokasi }}</td>
                            <td>{!! Str::words($d->keterangan, 20) !!}</td>
                            <td>
                                <a href="{{ route('tampilan.detailagenda', ['id' => $d->id]) }}" class="btn btn-warning" aria-label="Lihat detail agenda">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada agenda kegiatan P3M.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
