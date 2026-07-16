@extends('layout.main')
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
                        <li class="breadcrumb-item"><a href="{{ route('plppm.kpenelitian') }}">Home</a></li>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $pagetitle }}</h3>
                            <div class="card-tools">
                                <form action="{{ route('plppm.kpenelitian') }}" method="GET">
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
                        <!-- /.card-header -->

                        <div class="card-body table-responsive">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Bidang Ilmu</th>
                                        <th>Kategori</th>
                                        <th>Ketua Peneliti</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penelitians as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{!! Str::words($d->judul, 7) !!}</td>
                                        <td>{!! $d->created_at->translatedFormat('d F Y') !!}</td>
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
                                        <td style="white-space: nowrap;">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('detail.detailk', ['tipe' => 'kpeneliti', 'id' => $d->id]) }}" class="btn btn-info text-white"><i class="fas fa-eye white"></i></a>
                                                <!-- <a href="{{ route('dosen.edit_kpenliti',['id' => $d->id]) }}" class="btn btn-primary rounded-circle m-1"><i class="fas fa-pen"></i></a> -->
                                                <!-- <a href="#" class="btn btn-danger rounded-circle m-1"><i class="fas fa-trash"></i></a> -->
                                            </div>

                                            @php
                                            // Atur class button sesuai status
                                            $btnClass = match($d->status) {
                                            'approve' => 'btn-success', // hijau
                                            'proses' => 'btn-warning', // kuning
                                            'non-approve' => 'btn-danger', // merah
                                            default => 'btn-secondary', // default
                                            };
                                            @endphp
                                            <div class="btn-group">
                                                <button type="button" class="btn {{ $btnClass }} btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{ ucfirst($d->status) }}
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Approve -->
                                                    <form action="{{ route('plppm.kumpulan.status', ['tipe' => 'kum_penelitian', $d->id]) }}" method="POST" class="px-3 py-1">
                                                        @csrf
                                                        @method('patch')
                                                        <input type="hidden" name="status" value="approve">
                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Yakin ingin approve pengajuan ini?')">
                                                            ✅ Approve
                                                        </button>
                                                    </form>

                                                    <!-- Proses -->
                                                    <form action="{{ route('plppm.kumpulan.status', ['tipe' => 'kum_penelitian', $d->id]) }}" method="POST" class="px-3 py-1">
                                                        @csrf
                                                        @method('patch')
                                                        <input type="hidden" name="status" value="proses">
                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Set status jadi proses?')">
                                                            ⏳ Proses
                                                        </button>
                                                    </form>

                                                    <!-- Non-approve -->
                                                    <form action="{{ route('plppm.kumpulan.status', ['tipe' => 'kum_penelitian', $d->id]) }}" method="POST" class="px-3 py-1">
                                                        @csrf
                                                        @method('patch')
                                                        <input type="hidden" name="status" value="non-approve">
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Tolak pengajuan ini?')">
                                                            ❌ Non-approve
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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
</script>
@endsection