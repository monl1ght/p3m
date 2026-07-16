@extends('layout.main')

@section('css')
<style>
    .admin-form-page .page-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        color: #2563eb;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .admin-form-page .page-eyebrow::before {
        content: "";
        width: 28px;
        height: 2px;
        border-radius: 999px;
        background: #d5a72f;
    }

    .form-shell-card {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 18px 45px rgba(15, 23, 42, .07);
    }

    .form-shell-header {
        padding: 24px;
        border-bottom: 1px solid #e2e8f0;
        background:
            linear-gradient(135deg, rgba(6, 63, 53, .96), rgba(7, 31, 36, .94));
        color: #ffffff;
    }

    .form-shell-header h3 {
        margin: 0;
        color: #ffffff;
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-weight: 900;
        letter-spacing: -0.045em;
    }

    .form-shell-header p {
        margin: 8px 0 0;
        color: rgba(226, 232, 240, .84);
        font-size: 13px;
    }

    .form-shell-body {
        padding: 24px;
    }

    .modern-form-group {
        margin-bottom: 18px;
    }

    .modern-form-group label {
        color: #1e293b;
        font-size: 13px;
        font-weight: 850;
        margin-bottom: 8px;
    }

    .modern-form-group .form-control {
        min-height: 46px;
        border: 1px solid #dbe4f0;
        border-radius: 13px;
        color: #0f172a;
        font-size: 14px;
        box-shadow: none;
    }

    .modern-form-group .form-control:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .modern-form-group small {
        color: #dc2626;
        font-weight: 650;
    }

    .form-help {
        display: block;
        margin-top: 6px;
        color: #64748b !important;
        font-size: 12px;
    }

    .form-shell-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 24px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .btn-form-primary,
    .btn-form-secondary {
        min-height: 42px;
        padding: 10px 15px;
        border-radius: 13px;
        font-weight: 850;
    }

    .btn-form-primary {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .btn-form-primary:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #ffffff;
    }

    .btn-form-secondary {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #334155;
    }

    .btn-form-secondary:hover {
        background: #eff6ff;
        color: #2563eb;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper admin-form-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-7">
                    <span class="page-eyebrow">Tambah User</span>
                    <h1 class="m-0">Tambah Data User P3M</h1>
                </div>
                <div class="col-sm-5">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">User</a></li>
                        <li class="breadcrumb-item active">Tambah Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-7 col-xl-6">
                        <div class="form-shell-card">
                            <div class="form-shell-header">
                                <h3>Informasi Akun User</h3>
                                <p>Lengkapi data user yang akan diberi akses ke panel pengelola P3M.</p>
                            </div>

                            <div class="form-shell-body">
                                <div class="modern-form-group">
                                    <label for="image">Profile Photo</label>
                                    <input type="file" name="image" class="form-control" id="image">
                                    @error('image')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="modern-form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Masukkan email">
                                    @error('email')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="modern-form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Masukkan nama user">
                                    @error('nama')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="modern-form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password">
                                    @error('password')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-shell-footer">
                                <a href="{{ route('index') }}" class="btn btn-form-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-form-primary">
                                    Simpan User
                                    <i class="fas fa-save ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
