@extends('layout.doslayout')
@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')

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
                        <li class="breadcrumb-item"><a href="{{ route('dosen.upp3m') }}">Home</a></li>
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
                    <a href="{{ route('dosen.addp3m') }}" class="btn btn-primary mb-2">+</a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $pagetitle }}</h3>

                        </div>
                        <!-- /.card-header -->

                        <div class="card-body ">
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Bidang Ilmu</th>
                                            <th>Kategori</th>
                                            <th>Ketua Peneliti</th>
                                            <th>Aksi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penelitians as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{!! Str::words($d->judul, 10) !!}</td>
                                            <td>{!! $d->bidang !!}</td>
                                            <td>{!! $d->jeniskategori !!}</td>

                                            <td>{!! $d->ketua !!}</td>

                                            <!-- <td>
                                             <ul>
                                                 @foreach($d->anggotap3m as $anggota)
                                                 <li>
                                                     {!! $anggota->nama !!} - {!! $anggota->prodi !!} -{!! $anggota->jabatan !!}
                                                 </li>
                                                 @endforeach
                                             </ul>
                                         </td> -->
                                            <!-- <td><img src="{{ asset('storage/photo-upp3m/' . $d->foto) }}" alt="image" width="100px" height="120px"></td> -->
                                            <!-- <td><a href="{{ asset('storage/uppdf/' . $d->uppdf) }}" target="_blank">Lihat File</a></td> -->
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('detail.detail', ['tipe' => 'ajupengab', 'id' => $d->id]) }}" class="btn btn-info text-white"><i class="fas fa-eye white"></i></a>
                                                    <a href="{{ route('dosen.edit_ajupengab',['id' => $d->id]) }}" class="btn btn-primary"><i class="fas fa-pen"></i></a>
                                                    <a href="{{ route ('dosen.deletep3m', ['id' => $d->id]) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                            <td>@if($d->status === 'approve')
                                                <span class="badge bg-success">
                                                    ✅ Disetujui
                                                </span>
                                                <small class="text-primary ms-1"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Silahkan konfirmasi dengan Ketua P3M"
                                                    style="cursor: pointer; text-decoration: underline;">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </small>
                                                <a href="{{ route('p3m.surat-tugas.download', $d->id) }}"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fa-solid fa-file-pdf"></i> Download Surat
                                                </a>

                                                @elseif($d->status === 'proses')
                                                <span class="badge badge-warning">⏳ Proses</span>
                                                @else
                                                <span class="badge badge-danger">❌ Non-approve</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </section>
    <!-- /.content -->
</div>

@endsection
@section('scripts')
<!-- DataTables  & Plugins -->
<!-- <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script> -->
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('lte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
    $(function() {

        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "dom": '<"top"f>rt<"bottom"ip>',
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endsection