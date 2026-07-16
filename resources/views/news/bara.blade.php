@extends('layout.main')
@section('css')
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{ asset('lte/../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> -->

<link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css" />
@endsection


@section('content')
<style>
    /* table {
        width: 250px;
    }

    table td {
        word-wrap: break-word;
        min-width: 10px;
    } */
    /* table td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    } */
    table {
        border-collapse: collapse;
        table-layout: fixed;
        width: 100%;
    }

    .custom-btn {
        border-radius: 50px;
    }

    table th,
    table td {
        border: 1px black;
        /* Menambahkan border pada sel */
    }

    table td {
        width: 200px;
        max-width: 40px;
        /* word-wrap: break-all;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis; */
    }

    .col-md-3 {
        width: 25%;
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
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('news.create') }}" class="btn btn-primary mb-2"><i class="fas fa-plus"></i> Tambah</a>
                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Berita P3M POLIBANG</h3>
                            <div class="card-tools">
                                <form action="{{ route('news.search') }}" method="get">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="search" class="form-control float-right" placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table id="clientside " class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th colspan="2">Title</th>
                                        <th colspan="2">Tanggal</th>
                                        <th colspan="2">Pembuat</th>
                                        <th colspan="2">Gambar</th>
                                        <th colspan="2">Kategory</th>
                                        <th class="col-md-3">ISI</th>
                                        <th colspan="3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($news as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td colspan="2">{{ $d->title }}</td>
                                        <td colspan="2">{{ $d->date }}</td>
                                        <td colspan="2">{{ optional($d->user)->name }}</td>
                                        <td colspan="2"><img src="{{ asset('storage/photo-news/'.$d->image) }}" alt="" width="100"></td>
                                        <td colspan="2">{{ $d->category->name }}</td>
                                        <td id="compose-textarea">{!! Str::words($d->content, 20) !!}</td>
                                        <td colspan="3">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route ('news.read', ['id' => $d->id]) }}" class="btn btn-info text-white"><i class="fas fa-eye white"></i></a>
                                                <a href="{{ route ('news.edit', ['id' => $d->id]) }}" class="btn btn-primary"><i class="fas fa-pen"></i></a>
                                                <a href="{{ route ('news.delete', ['id' => $d->id]) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>

        <!-- /.card-body -->
    </section>

</div>


@endsection
@section('scripts')
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script>
    $(document).ready(function() {
        $('#clientside').DataTable();
    });
</script>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('lte/../../plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('lte/../../plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.js"></script> -->

<!-- <script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script> -->

<script>
    // new DataTable('#example');
    // $(function() {
    //     $("#example1").DataTable({
    // "paging": true,
    // "lengthChange": false,
    // "searching": false,
    // "ordering": true,
    // "info": true,
    // "autoWidth": false,
    // "responsive": true,
    // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    // $('#example2').DataTable({
    // "paging": true,
    // "lengthChange": false,
    // "searching": false,
    // "ordering": true,
    // "info": true,
    // "autoWidth": false,
    // "responsive": true,
    //     });
    // });
</script>
@endsection