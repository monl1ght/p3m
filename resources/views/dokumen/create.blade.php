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
            <form action="{{ route('dokumen.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Unggah Dokumen</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form style="align-content: center;">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="namefiles">Nama File</label>
                                        <input type="text" name="namefile" class="form-control" placeholder="nama file" value="{{ old('namefile') }}">
                                        @error('namefile')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="form-group-prepend">
                                            <label for="image">Upload</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="originalname" class="custom-file-input" id="image">
                                            <label class="custom-file-label" for="originalname">Choose file</label>
                                        </div>
                                        @error('original_name')
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