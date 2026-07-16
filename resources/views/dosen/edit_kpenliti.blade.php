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
            <form action="{{ route('dosen.updatekumpulanpenelitian' , ['id' => $penelitian->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">P3M Polibang Jepara</h3>
                            </div>
                            <!-- /.card-header -->
                            <form style="align-content: center;">
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Pengabdian Masyarakat</label> <br>
                                                    <div class="form-group ">
                                                        <small>Judul Pengabdian :</small>
                                                        <input type="text" name="judul" class="form-control" placeholder="Enter ..." value="{{ $penelitian->judul }}">
                                                        @error('judul')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Bidang Ilmu :</small>
                                                        <input type="text" name="bidang" class="form-control" placeholder="Enter ..." value="{{ $penelitian->bidang }}">
                                                        @error('bidang')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <small>Kategori</small>
                                                        <input type="text" class="form-control" value="Laporan Penelitian" name="jeniskategori" value="{{ $penelitian->jeniskategori }}" readonly>
                                                        <!-- <input type=" hidden" name="jeniskategori" value="Proposal Pengabdian"> -->
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Lokasi :</small>
                                                        <input type="text" name="lokasi" class="form-control" placeholder="Enter ..." value="{{ $penelitian->lokasi }}">
                                                        @error('lokasi')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Lama Penelitian :</small>
                                                        <!-- <div class="input-group mb-3">
                                                            <input type="text" class="form-control" name="lamapenelitian" placeholder="Enter ..." value="{{ $penelitian->lamapenelitian }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Hari</span>
                                                            </div>
                                                        </div> -->
                                                        <div class="d-flex">
                                                            <input type="date" name="tanggal_mulai" class="form-control me-2" value="{{ $penelitian->tanggal_mulai }}" required>
                                                            <span class="align-self-center">sampai</span>
                                                            <input type="date" name="tanggal_selesai" class="form-control ms-2" value="{{ $penelitian->tanggal_selesai }}" required>
                                                        </div>
                                                        @error('tanggal_mulai' && 'tanggal_selesai')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Biaya :</small>
                                                        <input type="text" name="biaya" class="form-control" placeholder="Enter ..." value="{{ $penelitian->biaya }}">
                                                        <sup>*contoh (1500000)</sup>
                                                        @error('biaya')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <small>Unggah Laporan</small>
                                                    <div class="form-group mb-3">
                                                        <div class="custom-file">
                                                            <input type="file" name="uppdf" class="custom-file-input" id="uploadLaporan" value="{{ $penelitian->uppdf }}">
                                                            <label class="custom-file-label" for="uppdf">{{ $penelitian->uppdf ?? 'Unggah File' }}</label>
                                                        </div>
                                                        <small>Maks. 2 Mb</small>
                                                        @error('uppdf')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        @if($penelitian->foto)
                                                        <img src="{{ asset('storage/photo-upp3m/'.$penelitian->foto) }}" alt="preview-image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;" id="preview-image">
                                                        @endif
                                                        <div class="form-group-prepend">
                                                            <small for="image">Unggah Gambar/Foto</small>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" name="foto" class="custom-file-input" id="foto">
                                                            <label class="custom-file-label" for="foto">{{ $penelitian->foto ?? 'Unggah File' }}</label>
                                                        </div>
                                                        @error('foto')
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
                                                        <input type="text" name="ketua" class="form-control" placeholder="Enter ..." value="{{ $penelitian->ketua }}">
                                                        @error('ketua')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Jenis Kelamin :</small>
                                                        <select class="custom-select form-control-border" id="exampleSelectBorder" name="jeniskelamin">

                                                            <option value="">---Pilih---</option>
                                                            <option value="L" {{ (isset($penelitian) && $penelitian->jeniskelamin == 'L') ? 'selected' : '' }}>Laki - Laki</option>
                                                            <option value="P" {{ (isset($penelitian) && $penelitian->jeniskelamin == 'P') ? 'selected' : '' }}>Perempuan</option>

                                                        </select>
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>NIDN :</small>
                                                        <input type="text" name="nidn" class="form-control" placeholder="Enter ..." value="{{ $penelitian->nidn }}">
                                                        @error('nidn')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Jabatan Fungsional :</small>
                                                        <!-- <input type="text" name="jabatan" class="form-control" placeholder="Enter ..." value="{{ $penelitian->jabatan }}"> -->
                                                        <select class="custom-select form-control-border" id="exampleSelectBorder" name="jabatan">

                                                            <option value="">---Pilih---</option>
                                                            <option value="DR" {{ (isset($penelitian) && $penelitian->jabatan == 'DR') ? 'selected' : '' }}>Direktur</option>
                                                            <option value="LT" {{ (isset($penelitian) && $penelitian->jabatan == 'LT') ? 'selected' : '' }}>Wakil Direktur</option>
                                                            <option value="KP" {{ (isset($penelitian) && $penelitian->jabatan == 'KP') ? 'selected' : '' }}>Ketua Program Studi</option>
                                                            <option value="DS" {{ (isset($penelitian) && $penelitian->jabatan == 'DS') ? 'selected' : '' }}>Dosen Polibang</option>

                                                        </select>
                                                        @error('jabatan')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Program Studi :</small>
                                                        <select class="custom-select form-control-border" id="exampleSelectBorder" name="prodi">

                                                            <option value="">---Pilih---</option>
                                                            <option value="R" {{ (isset($penelitian) && $penelitian->prodi == 'R') ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                                            <option value="A" {{ (isset($penelitian) && $penelitian->prodi == 'A') ? 'selected' : '' }}>Administrasi Bisnis Internasional</option>
                                                            <option value="AK" {{ (isset($penelitian) && $penelitian->prodi == 'AK') ? 'selected' : '' }}>Akutansi Keuangan Publik</option>
                                                            <option value="AB" {{ (isset($penelitian) && $penelitian->prodi == 'AB') ? 'selected' : '' }}>Bisnis Digital</option>
                                                            <option value="AP" {{ (isset($penelitian) && $penelitian->prodi == 'AP') ? 'selected' : '' }}>Agri Bisnis Perternakan</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>No. Telepon :</small>
                                                        <input type="text" name="telp" class="form-control" placeholder="Enter ..." value="{{ $penelitian->telp }}">
                                                        @error('telp')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group ">
                                                        <small>Alamat :</small>
                                                        <input type="text" name="alamat" class="form-control" placeholder="Enter ..." value="{{ $penelitian->alamat }}">
                                                        @error('alamat')
                                                        <small>{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label" for="">Anggota Penelitian</label>
                                            <div class="form-group mb-3">
                                                <label class="col-form-label" for="">Anggota Penelitian</label>
                                                <button type="button" onclick="addAnggota()" class="btn btn-success"> <b>+</b> </button> <br>
                                                <div id="anggota-wrapper">
                                                    @foreach($penelitian->anggotap3m as $i => $anggota)
                                                    <div class="anggota-row border p-2 mb-2">
                                                        <label class="col-form-label" for="">Anggota Penelitian</label>
                                                        <button type="button" class="btn btn-danger btn-sm remove-anggota float-end">&times;</button>
                                                        <input type="hidden" name="id" id="anggota_dihapus">
                                                        <!-- <div class="form-group">
                                                            <small>Nama :</small>
                                                            <input type="text" class="form-control" name="anggota[0][nama]" placeholder="Nama" value="{{ old('nama') }}">
                                                            @error('nama')
                                                            <small>{{ $message }}</small>
                                                            @enderror
                                                        </div> -->
                                                        <div class="form-group">
                                                            <small>Nama :</small>
                                                            <input type="text" class="form-control" name="anggota[{{ $i }}][nama]" placeholder="Nama" value="{{ $anggota->nama }}">
                                                            @error('anggota.0.nama')
                                                            <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <small>Program Studi :</small>
                                                            <!-- <input type="text" class="form-control" name="anggota[{{ $i }}][prodi]" placeholder="Prodi" value="{{ $anggota->prodi }}"> -->
                                                            <select class="custom-select form-control-border" id="exampleSelectBorder" name="anggota[{{ $i }}][prodi]">

                                                                <option value="">---Pilih---</option>
                                                                <option value="R" {{ (isset($anggota) && $anggota->prodi == 'R') ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                                                <option value="A" {{ (isset($anggota) && $anggota->prodi == 'A') ? 'selected' : '' }}>Administrasi Bisnis Internasional</option>
                                                                <option value="AK" {{ (isset($anggota) && $anggota->prodi == 'AK') ? 'selected' : '' }}>Akutansi Keuangan Publik</option>
                                                                <option value="AB" {{ (isset($anggota) && $anggota->prodi == 'AB') ? 'selected' : '' }}>Bisnis Digital</option>
                                                                <option value="AP" {{ (isset($anggota) && $anggota->prodi == 'AP') ? 'selected' : '' }}>Agri Bisnis Perternakan</option>
                                                            </select>
                                                            @error('prodi')
                                                            <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <small>NIM / NIDN :</small>
                                                            <input type="text" class="form-control" name="anggota[{{ $i }}][nim]" placeholder="NIM/NIDn" value="{{ $anggota->nim }}">
                                                            @error('nim')
                                                            <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <small>Jabatan :</small>
                                                            <!-- <input type="text" class="form-control" name="anggota[{{ $i }}][jabatan]" placeholder="Jabatan" value="{{ $anggota->jabatan }}"> -->
                                                            <select class="custom-select form-control-border" id="exampleSelectBorder" name="anggota[{{ $i }}][jabatan]">

                                                                <option value="">---Pilih---</option>
                                                                <option value="DR" {{ (isset($anggota) && $anggota->jabatan == 'DR') ? 'selected' : '' }}>Direktur</option>
                                                                <option value="LT" {{ (isset($anggota) && $anggota->jabatan == 'LT') ? 'selected' : '' }}>Wakil Direktur</option>
                                                                <option value="KP" {{ (isset($anggota) && $anggota->jabatan == 'KP') ? 'selected' : '' }}>Ketua Program Studi</option>
                                                                <option value="DS" {{ (isset($anggota) && $anggota->jabatan == 'DS') ? 'selected' : '' }}>Dosen Polibang</option>
                                                                <option value="MHS" {{ (isset($anggota) && $anggota->jabatan == 'MHS') ? 'selected' : '' }}>Mahasiswa</option>
                                                            </select>
                                                            @error('jabatan')
                                                            <small>{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <!-- <button type="button" class="btn btn-danger btn-sm remove-anggota float-end">&times;</button> -->
                                                    </div>
                                                    @endforeach
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
                <option value="R" {{ (isset($anggota) && $anggota->prodi == 'R') ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                <option value="A" {{ (isset($anggota) && $anggota->prodi == 'A') ? 'selected' : '' }}>Administrasi Bisnis Internasional</option>
                <option value="AK" {{ (isset($anggota) && $anggota->prodi == 'AK') ? 'selected' : '' }}>Akutansi Keuangan Publik</option>
                <option value="AB" {{ (isset($anggota) && $anggota->prodi == 'AB') ? 'selected' : '' }}>Bisnis Digital</option>
                <option value="AP" {{ (isset($anggota) && $anggota->prodi == 'AP') ? 'selected' : '' }}>Agri Bisnis Perternakan</option>
                                                                
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
                <option value="DR" {{ (isset($anggota) && $anggota->jabatan == 'DR') ? 'selected' : '' }}>Direktur</option>
                <option value="LT" {{ (isset($anggota) && $anggota->jabatan == 'LT') ? 'selected' : '' }}>Wakil Direktur</option>
                <option value="KP" {{ (isset($anggota) && $anggota->jabatan == 'KP') ? 'selected' : '' }}>Ketua Program Studi</option>
                <option value="DS" {{ (isset($anggota) && $anggota->jabatan == 'DS') ? 'selected' : '' }}>Dosen Polibang</option>
                <option value="MHS" {{ (isset($anggota) && $anggota->jabatan == 'MHS') ? 'selected' : '' }}>Mahasiswa</option>
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
<script>
    const inputFile = document.getElementById('foto');
    const fileLabel = document.querySelector('.custom-file-label');

    inputFile.addEventListener('change', (e) => {
        if (file && file.type.startsWith('image/')) {
            document.querySelector('.custom-file-label').textContent = file.name;
            const fileName = e.target.files[0].name;
            fileLabel.textContent = fileName;
        }
        reader.readAsDataURL(file);
    });
</script>

<script>
    // Function to preview image

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview-image');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // Add event listener to the image input
    document.getElementById('foto').addEventListener('change', previewImage);
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