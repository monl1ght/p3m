@extends($layout)
@section('content')

<style>
    .mailbox-attachments li {
        height: auto !important;
        padding-bottom: 0 !important;
    }

    .mailbox-attachment-icon.has-img {
        height: auto !important;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $pagetitle }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="">Home</a></li> -->
                        <li class="breadcrumb-item active">{{ $pagetitle }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $pagetitle }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <a href="{{ url()->previous() }}" type="button" class="btn btn-tool" data-card-widget="back" title="back">
                        <i class="fas fa-long-arrow-alt-left"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- col-lg-8 order-2 order-md-1 -->
                    <div class="col-8 col-md-8 col-lg-7 order-1 order-md-1">
                        <div class="row">
                            <div class="col-10">
                                <h4 class="text-muted">{{ $penelitians->judul  }}</h4>
                                <span class="text-muted">{{ $penelitians->jeniskategori }}</span>
                                <div class="text-muted">
                                    <p class="d-inline text-sm"><b class="d-inline d-block">Bidang Ilmu</b>
                                        {{ $penelitians->bidang }}
                                    </p>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-8 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Biaya Penelitian</span>
                                                <span class="info-box-number text-center text-muted mb-0">{{ $penelitians->biaya }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Lama Penelitian</span>
                                                <span class="info-box-number text-center text-muted mb-0">{{ $penelitians->lamapenelitian }} Hari</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="post clearfix">
                                    <div class="user">
                                        <h5>Data Ketua / Dosen</h5>
                                        <!-- <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image"> -->
                                        <span class="username">
                                            <i class="fas fa-book-reader me-2"> </i>
                                            <!-- <span class="fw-bold me-2">{{ $penelitians->ketua }}</span> -->
                                            <!-- <span class="text-muted">- {{ $penelitians->jabatan }}</span> -->
                                            <h6 class="d-inline me-1">{{ $penelitians->ketua }}</h6>
                                            <small class="border-start ps-2 ms-2 text-muted me-1">{{ $penelitians->jabatan === 'DR' ? 'Direktur' : ($penelitians->jabatan === 'LT' ? 'Wakil Derektur' : ($penelitians->jabatan === 'KP' ? 'Ketua Program Studi' : ($penelitians->jabatan ==='DS' ? 'Dosen' : '-'))) }}</small>
                                            <small class="border-start ps-2 ms-2 text-muted">NIDN : {{ $penelitians->nidn }}</small>

                                        </span>
                                        <br>
                                        <i class="fas fa-user-circle me-1"></i> Jenis Kelamin : {{ $penelitians->jeniskelamin === 'P' ? 'Perempuan' : ($penelitians->jeniskelamin === 'L' ? 'Laki-laki' : '-') }} <br>
                                        <i class="fas fa-map-marker-alt me-2"></i> Alamat : {{ $penelitians->alamat }} <br>
                                        <i class="fas fa-phone-alt me-1"></i> No.Telp : {{ $penelitians->telp }} <br>
                                        <i class="fas fa-graduation-cap "></i> Program Studi : {{ $penelitians->prodi === 'R' ? 'RPL' : ($penelitians->prodi === 'A' ? 'ABI' :  ($penelitians->prodi === 'AK' ? 'AKP' : ($penelitians->prodi === 'AB' ? 'Agre Bisnis Digital' : ($penelitians->prodi === 'AP' ? 'Agre Perternakan' : '-')) )) }}
                                        <!-- <span class="username ">
                                            <i class="fas fa-circle"></i>
                                            <span class="d-inline me-1">Jenis Kelamin :</span>{{ $penelitians->jeniskelamin }}
                                        </span>
                                        <br>
                                        <span class="username ">
                                            <i class="fas fa-circle"></i>
                                            <h7 class="d-inline me-1">Alamat :</h7>{{ $penelitians->alamat }}
                                        </span>
                                        <br>
                                        <span class="username ">
                                            <i class="fas fa-circle"></i>
                                            <h7 class="d-inline me-1">No.Telp :</h7>{{ $penelitians->telp }}
                                        </span>
                                        <br>
                                        <span class="username ">
                                            <i class="fas fa-circle"></i>
                                            <h7 class="d-inline me-1">No.Telp :</h7>{{ $penelitians->prodi }}
                                        </span> -->
                                    </div>
                                    <!-- /.user-block -->
                                    <!-- <p>
                                        Lorem ipsum represents a long-held tradition for designers,
                                        typographers and the like. Some people hate it and argue for
                                        its demise, but others ignore.
                                    </p>
                                    <p>
                                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 2</a>
                                    </p> -->
                                    <hr>
                                    @if (Auth::user()->role === 'admin')
                                    <span class="badge bg-primary">Dilihat oleh Admin</span>
                                    @endif

                                    @if (Auth::user()->role === 'dosen')
                                    <span class="badge bg-primary">Dilihat oleh Dosen</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- col-md-8 col-lg-4 order-1 order-md-2 -->
                    <div class="col-8 col-lg-5 order-md-2">
                        <div class="post">
                            <h6>👥 Anggota {{ $pagetitle }}</h6>
                            <div class="user-block">
                                @foreach($penelitians->anggotap3m as $index => $anggota)
                                <div class="mb-3">
                                    <div class="text-muted">Anggota {{ $index + 1 }}</div>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-user-circle text-secondary"></i>
                                        <span class="fw-semibold">{{ $anggota->nama }}</span>
                                        @if ($anggota->prodi)
                                        <span class="border-start ps-2 ms-2 text-muted">{{ $anggota->prodi === 'R' ? 'RPL' : ($anggota->prodi === 'A' ? 'ABI' :  ($anggota->prodi === 'AK' ? 'AKP' : ($anggota->prodi === 'AB' ? 'Bisnis Digital' : ($anggota->prodi === 'AP' ? 'Agre Perternakan' : '-')) )) }}</span>
                                        @endif
                                        @if ($anggota->nim)
                                        <span class="border-start ps-2 ms-2 text-muted">{{ $anggota->nim }}</span>
                                        @endif
                                        @if ($anggota->jabatan)
                                        <span class="border-start ps-2 ms-2 text-muted">{{ $anggota->jabatan === 'DR' ? 'Direktur' : ($anggota->jabatan === 'LT' ? 'Wakil Derektur' : ($anggota->jabatan === 'KP' ? 'Ketua Program Studi' : ($anggota->jabatan ==='DS' ? 'Dosen' : ($anggota->jabatan === 'MHS' ? 'Mahasiswa' : '-'))))  }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- <small class="description">Anggota {{ $index + 1 }} </small>
                                <span class="username">
                                    <h7 class="d-inline me-1">{{ $anggota->nama }}</h7>
                                    <small class="border-start ps-2 ms-2 text-muted">{{ $anggota->prodi }}</small>
                                    <small class="border-start ps-2 ms-2 text-muted me-1">{{ $anggota->jabatan }}</small>
                                </span> -->
                                @endforeach
                            </div>
                        </div>
                        <h5 class="mt-5 text-muted">Project files</h5>
                        <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                            <li>
                                <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                                <div class="mailbox-attachment-info">
                                    <a href="{{ asset('storage/uppdf/' . $penelitians->uppdf) }}" target="_blank" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>{{ $penelitians->uppdf }}</a>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex flex-column align-items-center">
                                    <span class="mailbox-attachment-icon has-img">
                                        <img src="{{ asset('storage/photo-upp3m/' . $penelitians->foto) }}" alt="Attachment" style="height: 150px; object-fit: cover;">
                                    </span>
                                    <div class=" mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name">
                                            <i class="fas fa-camera"></i> {{ $penelitians->foto }}
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>

@endsection
@section('scripts')

@endsection