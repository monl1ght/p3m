@extends('layout.main')
@section('content')

<style>
    .custom-option {
        background-color: #fff;
        /* or any other color you prefer */
        color: #333;
        /* or any other text color you prefer */
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Adding Data</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
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
            <form action="{{ route('pengelola.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Pengelola P3M</h3>
                            </div>
                            <!-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif -->
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form style="align-content: center;">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <div class="form-group-prepend">
                                            <label for="image">Upload</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="image" value="{{ old('image') }}">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                        @error('image')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama</label>
                                        <input type="text" name="nama_pengelola" class="form-control" placeholder="masukkan nama" value="{{ old('nama_pengelola') }}">
                                        @error('nama_pengelola')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">NIDN</label>
                                        <input type="text" name="NIDN" class="form-control" placeholder="masukkan nidn" value="{{ old('NIDN') }}">
                                        @error('NIDN')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Jabatan</label>
                                        <input type="text" name="jabatan_pengelola" class="form-control" placeholder="masukkan jabatan" value="{{ old('jabatan_pengelola') }}">
                                        @error('jabatan_pengelola')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" name="email_pengelola" class="form-control" placeholder="masukkan email" value="{{ old('email') }}">
                                        @error('email_pengelola')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </form>
    </section>
    <!-- /.content -->
</div>


@endsection