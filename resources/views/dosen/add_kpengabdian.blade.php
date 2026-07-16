@extends('layout.doslayout')
@section('content')

<style>
    .img-preview {
        max-width: 150px;
        height: auto;
        display: block;
        margin: 0 auto;
        object-fit: contain;
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
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">{{ $pagetitle }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('dosen.storekumpulanp3m') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">{{ $pagetitle }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <form style="align-content: center;">
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Pengumpulan Penelitian</label> <br>
                                                    <div class="form-group ">
                                                        <small>Judul Pengabdian :</small>
                                                        <input type="text" name="judul" class="form-control" placeholder="Enter ..." value="{{ old('judul') }}">
                                                        @error('judul')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Bidang Ilmu :</small>
                                                        <input type="text" name="bidang" class="form-control" placeholder="Enter ..." value="{{ old('bidang') }}">
                                                        @error('bidang')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <small>Kategori</small>
                                                        <input type="text" class="form-control" value="Laporan Pengabdian Masyarakat" name="jeniskategori" readonly>
                                                        <!-- <input type=" hidden" name="jeniskategori" value="Proposal Pengabdian"> -->
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Lokasi :</small>
                                                        <input type="text" name="lokasi" class="form-control" placeholder="Enter ..." value="{{ old('lokasi') }}">
                                                        @error('lokasi')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Lama Penelitian :</small>
                                                        <div class="input-group mb-3">
                                                            <!-- <input type="text" class="form-control" name="lamapenelitian" placeholder="Enter ..." value="{{ old('lamapenelitian') }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Hari</span>
                                                            </div> -->
                                                            <div class="d-flex">
                                                                <input type="date" name="tanggal_mulai" class="form-control me-2" required>
                                                                <span class="align-self-center">sampai</span>
                                                                <input type="date" name="tanggal_selesai" class="form-control ms-2" required>
                                                            </div>
                                                        </div>
                                                        @error('tanggal_mulai' && 'tanggal_selesai')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Biaya :</small>
                                                        <input type="text" name="biaya" class="form-control" placeholder="Enter ..." value="{{ old('biaya') }}">
                                                        <sup>*contoh (1500000)</sup>
                                                        @error('biaya')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <small>Unggah Laporan</small>
                                                    <div class="form-group mb-3">
                                                        <div class="custom-file">
                                                            <input type="file" name="uppdf" class="custom-file-input" id="uploadLaporan" value="{{ old('uppdf') }}">
                                                            <label class="custom-file-label" for="uploadLaporan">Unggah File</label>
                                                            <sup>*maks file 2 mb</sup>
                                                        </div>
                                                        @error('uppdf')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <div class="form-group-prepend">
                                                            <small for="image">Unggah Gambar/Foto</small>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" name="foto" class="custom-file-input" id="uploadFoto">
                                                            <label class="custom-file-label" for="foto">Unggah Gambar</label>
                                                        </div>
                                                        @error('image')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Biodata Ketua</label> <br>
                                                    <div class="form-group ">
                                                        <small>Nama Ketua :</small>
                                                        <input type="text" name="ketua" class="form-control" placeholder="Enter ..." value="{{ old('ketua') }}">
                                                        @error('ketua')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Jenis Kelamin :</small>
                                                        <select class="custom-select form-control-border" id="exampleSelectBorder" name="jeniskelamin">

                                                            <option value="">---Pilih---</option>
                                                            <option value="L" {{ old('jeniskelamin') == 'L' ? 'selected' : '' }}>Laki - Laki</option>
                                                            <option value="P" {{ old('jeniskelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>

                                                        </select>
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>NIDN :</small>
                                                        <input type="text" name="nidn" class="form-control" placeholder="Enter ..." value="{{ old('nidn') }}">
                                                        @error('nidn')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Jabatan Fungsional :</small>
                                                        <!-- <input type="text" name="jabatan" class="form-control" placeholder="Enter ..." value="{{ old('jabatan') }}"> -->
                                                        <select class="custom-select form-control-border" id="exampleSelectBorder" name="jabatan">

                                                            <option value="">---Pilih---</option>
                                                            <option value="DR" {{ old('jabatan') == 'DR' ? 'selected' : '' }}>Direktur</option>
                                                            <option value="LT" {{ old('jabatan') == 'LT' ? 'selected' : '' }}>Wakil Direktur</option>
                                                            <option value="KP" {{ old('jabatan') == 'KP' ? 'selected' : '' }}>Ketua Program Studi</option>
                                                            <option value="DS" {{ old('jabatan') == 'DS' ? 'selected' : '' }}>Dosen Polibang</option>

                                                        </select>
                                                        @error('jabatan')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Program Studi :</small>
                                                        <select class="custom-select form-control-border" id="exampleSelectBorder" name="prodi">

                                                            <option value="">---Pilih---</option>
                                                            <option value="R" {{ old('prodi') == 'R' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                                            <option value="A" {{ old('prodi') == 'A' ? 'selected' : '' }}>Administrasi Bisnis Internasional</option>
                                                            <option value="AK" {{ old('prodi') == 'AK' ? 'selected' : '' }}>Akutansi Keuangan Publik</option>
                                                            <option value="AB" {{ old('prodi') == 'AB' ? 'selected' : '' }}>Bisnis Digital</option>
                                                            <option value="AP" {{ old('prodi') == 'AP' ? 'selected' : '' }}>Agribisnis Perternakan</option>

                                                        </select>
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>No. Telepon :</small>
                                                        <input type="text" name="telp" class="form-control" placeholder="Enter ..." value="{{ old('telp') }}">
                                                        @error('telp')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Alamat :</small>
                                                        <input type="text" name="alamat" class="form-control" placeholder="Enter ..." value="{{ old('alamat') }}">
                                                        @error('alamat')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <div id="anggota-wrapper">
                                                    <label class="col-form-label" for="">Anggota Pengabdian Masyarakat</label> <button type="button" onclick="addAnggota()" class="btn btn-success" value="{{ old('email') }}"> <b>+</b> </button> <br>
                                                    <div class="anggota-row border p-2 mb-2">
                                                        <label class="col-form-label" for="">Identitas Anggota</label>
                                                        <button type="button" class="btn btn-danger btn-sm remove-anggota float-end mb-2">&times;</button>
                                                        <!-- <div class="form-group">
                                                            <small>Nama :</small>
                                                            <input type="text" class="form-control" name="anggota[0][nama]" placeholder="Nama" value="{{ old('nama') }}">
                                                            @error('nama')
                                                            <small>{{ $message }}</small>
                                                            @enderror
                                                        </div> -->
                                                        <div class="form-group">
                                                            <small>Nama :</small>
                                                            <input type="text" class="form-control" name="anggota[0][nama]" placeholder="Nama" value="{{ old('anggota.0.nama') }}">
                                                            @error('anggota.0.nama')
                                                            <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <small>Program Studi :</small>
                                                            <!-- <input type="text" class="form-control" name="anggota[0][prodi]" placeholder="Prodi" value="{{ old('prodi') }}"> -->
                                                            <select class="custom-select form-control-border"
                                                                name="anggota[0][prodi]">

                                                                <option value="">---Pilih---</option>
                                                                <option value="R" {{ old('anggota.0.prodi') == 'R' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                                                <option value="A" {{ old('anggota.0.prodi') == 'A' ? 'selected' : '' }}>Administrasi Bisnis Internasional</option>
                                                                <option value="AK" {{ old('anggota.0.prodi') == 'AK' ? 'selected' : '' }}>Akutansi Keuangan Publik</option>
                                                                <option value="AB" {{ old('anggota.0.prodi') == 'AB' ? 'selected' : '' }}>Bisnis Digital</option>
                                                                <option value="AP" {{ old('anggota.0.prodi') == 'AP' ? 'selected' : '' }}>Agribisnis Perternakan</option>
                                                            </select>
                                                            @error('prodi')
                                                            <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <small>NIM / NIDN :</small>
                                                            <input type="text" class="form-control" name="anggota[0][nim]" placeholder="NIM/NIDN" value="{{ old('nim') }}">
                                                            @error('nim')
                                                            <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <small>Jabatan :</small>
                                                            <!-- <input type="text" class="form-control" name="anggota[0][jabatan]" placeholder="Jabatan" value="{{ old('jabatan') }}"> -->
                                                            <select class="custom-select form-control-border"
                                                                name="anggota[0][jabatan]">
                                                                <option value="">---Pilih---</option>
                                                                <option value="DR" {{ old('anggota.0.jabatan') == 'DR' ? 'selected' : '' }}>Direktur</option>
                                                                <option value="LT" {{ old('anggota.0.jabatan') == 'LT' ? 'selected' : '' }}>Wakil Direktur</option>
                                                                <option value="KP" {{ old('anggota.0.jabatan') == 'KP' ? 'selected' : '' }}>Ketua Program Studi</option>
                                                                <option value="DS" {{ old('anggota.0.jabatan') == 'DS' ? 'selected' : '' }}>Dosen</option>
                                                                <option value="MHS" {{ old('anggota.0.jabatan') == 'MHS' ? 'selected' : '' }}>Mahasiswa</option>
                                                            </select>
                                                            @error('jabatan')
                                                            <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    let count = 1;

    function addAnggota() {
        const wrapper = document.getElementById('anggota-wrapper');
        const html = `
            <div class="anggota-row border p-2 mb-2">
            <label class="col-form-label" for="">Identitas Anggota</label>
            <button type="button" class="btn btn-danger btn-sm remove-anggota float-end mb-2">&times;</button>
            <div class="form-group">
                <small>Nama :</small>
                <input type="text" class="form-control" name="anggota[${count}][nama]" placeholder="Nama">
            </div>
            <div class="form-group">
            <small>Program Studi :</small>
            <select class="custom-select form-control-border" id="exampleSelectBorder" name="anggota[${count}][prodi]" required>
                <option value="">---Pilih---</option>
                <option value="R" {{ old('anggota.0.prodi') == 'R' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                <option value="A" {{ old('anggota.0.prodi') == 'A' ? 'selected' : '' }}>Administrasi Bisnis Internasional</option>
                <option value="AK" {{ old('anggota.0.prodi') == 'AK' ? 'selected' : '' }}>Akutansi Keuangan Publik</option>
                <option value="AB" {{ old('anggota.0.prodi') == 'AB' ? 'selected' : '' }}>Bisnis Digital</option>
                <option value="AP" {{ old('anggota.0.prodi') == 'AP' ? 'selected' : '' }}>Agribisnis Perternakan</option>
                                                                
            </select>
            </div>
            <div class="form-group">
            <small>NIM / NIDN :</small>
            <input type="text" class="form-control" name="anggota[${count}][nim]" placeholder="NIM/NIDN" value="{{ old('nim') }}">
            </div>
            <div class="form-group">
            <small>Jabatan :</small>
            <select class="custom-select form-control-border" id="exampleSelectBorder" name="anggota[${count}][jabatan]" required>
                <option value="">---Pilih---</option>
                <option value="DR" {{ old('anggota.0.jabatan') == 'DR' ? 'selected' : '' }}>Direktur</option>
                <option value="LT" {{ old('anggota.0.jabatan') == 'LT' ? 'selected' : '' }}>Wakil Direktur</option>
                <option value="KP" {{ old('anggota.0.jabatan') == 'KP' ? 'selected' : '' }}>Ketua Program Studi</option>
                <option value="DS" {{ old('anggota.0.jabatan') == 'DS' ? 'selected' : '' }}>Dosen</option>
                <option value="MHS" {{ old('anggota.0.jabatan') == 'MHS' ? 'selected' : '' }}>Mahasiswa</option>
            </select>
            </div>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
        count++;
    }
    document.getElementById('anggota-wrapper').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-anggota')) {
            e.target.closest('.anggota-row').remove();
        }
    });
</script>
<script>
    document.querySelectorAll('.custom-file-input').forEach(function(input) {
        input.addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            e.target.nextElementSibling.innerText = fileName;
        })
    });
</script>
<!-- <script>
    function previewImage() {
        const input = document.getElementById('upload');
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script> -->
@endsection