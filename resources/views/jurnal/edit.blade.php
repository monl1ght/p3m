@extends('layout.main')
@section('content')

<style>

</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editing Data</h1>
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
            <form action="{{ route('jurnal.update' , ['id' => $jurnal->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-9">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $pagetitle }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form class="">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="jurnalname">Judul Jurnal</label>
                                        <input type="text" name="jurnalname" class="form-control" placeholder="judul jurnal" value="{{ $jurnal->jurnalname }}">
                                        @error('jurnalname')
                                        <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="link">Link Jurnal</label>
                                        <input type="text" name="link" class="form-control" placeholder="link jurnal" value="{{ $jurnal->link }}">
                                        @error('link')
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

<script>
    // Inisialisasi CKEditor
    CKEDITOR.replace('editor', {
        filebrowserUploadUrl: 'photo-news/', // URL untuk meng-upload gambar
        filebrowserUploadMethod: 'form'
    });
</script>
@endsection