@extends('layout.main')
@section('content')

<style>
    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $pagetitle }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $pagetitle }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $pagetitle }}</h3>
                        </div>
                        <div class="card">
                            <div class="container">
                                <h1>Detail Panduan: {{ $dokum->namefile }}</h1>

                                <iframe src="{{ asset('uploud/' . $dokum->originalname) }}"
                                    style="width: 100%; height: 600px;"
                                    frameborder="0"></iframe>

                                <a href="{{ route('dokumen.download', $dokum->id) }}" class="btn btn-primary">Download PDF</a>
                                <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection