@extends('layout.main')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Data Pengelola P3M</h1>
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
            <form action="{{ route('pengelola.update' , ['id' => $pengelola->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Pengelola</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                    @if($pengelola->image)
                                    <img src="{{ asset('storage/photo-pengelola/'.$pengelola->image) }}" alt="preview-image" width="100px" height="100px" id="preview-image">
                                    @endif
                                    <div class="form-group mb-3">
                                        <div class="form-group-prepend">
                                            <label for="image">Upload</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                            <small>pilih gambar jika ingin diganti / biarkan</small>
                                        </div>
                                        @error('image')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama</label>
                                        <input type="text" name="nama_pengelola" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" value="{{ $pengelola->nama_pengelola }}">
                                        @error('nama_pengelola')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">NIDN</label>
                                        <input type="text" name="NIDN" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" value="{{ $pengelola->NIDN }}">
                                        @error('NIDN')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Jabatan</label>
                                        <input type="text" name="jabatan_pengelola" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" value="{{ $pengelola->jabatan_pengelola }}">
                                        @error('jabatan_pengelola')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" name="email_pengelola" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="{{ $pengelola->email_pengelola }}">
                                        @error('email')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->

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