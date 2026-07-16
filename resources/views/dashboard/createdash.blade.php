@extends('layout.main')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashborad Data</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('dash.buat') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Dashboard View</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <div class="form-group-prepend">
                                            <label for="image">Logo</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" value="{{ old('image') }}" id="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                        @error('image')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="image">Logo</label>
                                        <input type="file" name="image" class="form-control" id="exampleInputEmail1" placeholder="chose image">
                                        @error('image')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div> -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Judul</label>
                                        <input type="title" name="title" class="form-control" id="exampleInputEmail1" value="{{ old('title') }}" placeholder="Enter Title">
                                        @error('title')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Instansi</label>
                                        <input type="instansi" name="instansi" class="form-control" id="exampleInputEmail1" value="{{ old('instansi') }}" placeholder="Enter Instansis">
                                        @error('instansi')
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