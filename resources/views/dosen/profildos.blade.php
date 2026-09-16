@extends('layout.doslayout')

@section('body_class', 'page-dosen-profile')

@section('content')

    <div class="content-wrapper dosen-profile-page">

        <div class="content-header">
            <div class="container-fluid">
                <div class="dosen-profile-shell">

                    <div class="dosen-profile-heading">
                        <div>
                            <span class="dosen-profile-eyebrow">Pengaturan akun</span>
                            <h1>Edit Profil</h1>
                        </div>

                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dosen.dash') }}" data-turbo="true">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Edit Profil</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="dosen-profile-shell">

                    <div class="dosen-profile-card">

                        <div class="dosen-profile-card-head">
                            <div class="dosen-profile-card-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>

                            <div>
                                <span class="dosen-profile-card-kicker">Profil Dosen</span>
                                <h2>Profil Dosen P3M Polibang</h2>
                                <p>Pastikan informasi akun Anda tetap sesuai dan mudah dikenali.</p>
                            </div>
                        </div>

                        <form action="{{ route('dosen.profil.update', ['id' => $data->id]) }}" method="post"
                            enctype="multipart/form-data" novalidate data-turbo="false" id="dosen-profile-form">
                            @csrf
                            @method('put')
                            @if (request('layout'))
                                <input type="hidden" name="layout" value="{{ request('layout') }}">
                            @endif

                            <div class="dosen-profile-card-body">

                                {{-- 01. Profile --}}
                                <section class="dosen-profile-section">

                                    <div class="dosen-profile-section-label">
                                        <span class="dosen-profile-section-number" aria-hidden="true">01</span>
                                        <div>
                                            <h3>Profil &amp; Informasi Akun</h3>
                                            <small>Kelola foto profil dan informasi dasar akun Anda.</small>
                                        </div>
                                    </div>

                                    <div class="dosen-profile-main-grid">

                                        {{-- Photo upload --}}
                                        <div class="dosen-profile-photo-column">

                                            <div class="dosen-profile-photo-frame">

                                                <div class="dosen-profile-current-photo">
                                                    @if ($data->image)
                                                        <img id="photo-preview-thumb"
                                                            src="{{ asset('storage/photo-user/' . $data->image) }}"
                                                            alt="Foto profil {{ $data->name }}">
                                                    @else
                                                        <span id="photo-placeholder"
                                                            aria-hidden="true">{{ strtoupper(substr($data->name ?? 'D', 0, 1)) }}</span>
                                                        <img id="photo-preview-thumb" src=""
                                                            alt="Foto profil {{ $data->name }}" style="display: none;">
                                                    @endif
                                                </div>

                                                @if ($data->image)
                                                    <span class="dosen-profile-photo-status">
                                                        <i class="fas fa-check" aria-hidden="true"></i>
                                                        Foto tersimpan
                                                    </span>
                                                @endif

                                            </div>

                                            <div class="dosen-profile-photo-copy">

                                                <strong>{{ $data->name }}</strong>
                                                <span>Dosen POLIBANG</span>

                                                <label class="dosen-file-picker" id="photo-picker-label">
                                                    <i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>
                                                    <span>Pilih foto baru</span>
                                                    <input type="file" id="photo-file-input" name="image"
                                                        class="p3m-cropper-input" data-base64-target="#image_base64_input"
                                                        data-preview-target="#photo-preview-thumb"
                                                        data-p3m-upload-exclude
                                                        accept=".png,.jpg,.jpeg,.webp,image/png,image/jpeg,image/webp"
                                                        aria-describedby="photo-help">
                                                </label>

                                                {{-- Hidden field: menampung hasil crop dari Cropper.js --}}
                                                <input type="hidden" name="image_base64" id="image_base64_input">

                                                <small id="photo-help" class="dosen-profile-photo-filename"
                                                    data-default="PNG, JPG atau WebP · Maks. 5MB">
                                                    PNG, JPG atau WebP · Maks. 5MB
                                                </small>

                                                @error('image')
                                                    <div class="dosen-profile-error" role="alert">
                                                        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror

                                            </div>

                                        </div>


                                        {{-- Account form --}}
                                        <div class="dosen-profile-account-column">

                                            <div class="dosen-profile-form-stack">

                                                <div class="dosen-profile-field">

                                                    <label for="email">
                                                        Alamat Email
                                                        <span aria-hidden="true">*</span>
                                                    </label>

                                                    <div class="dosen-input-wrap">
                                                        <i class="far fa-envelope" aria-hidden="true"></i>
                                                        <input id="email" type="email" name="email"
                                                            value="{{ old('email', $data->email) }}"
                                                            placeholder="Masukkan alamat email" autocomplete="email"
                                                            required
                                                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                                                    </div>

                                                    @error('email')
                                                        <div class="dosen-profile-error" id="email-error" role="alert">
                                                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                                                            <span>{{ $message }}</span>
                                                        </div>
                                                    @enderror

                                                </div>


                                                <div class="dosen-profile-field">

                                                    <label for="name">
                                                        Nama Lengkap
                                                        <span aria-hidden="true">*</span>
                                                    </label>

                                                    <div class="dosen-input-wrap">
                                                        <i class="far fa-user" aria-hidden="true"></i>
                                                        <input id="name" type="text" name="name"
                                                            value="{{ old('name', $data->name) }}"
                                                            placeholder="Masukkan nama lengkap" autocomplete="name" required
                                                            @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                                                    </div>

                                                    @error('name')
                                                        <div class="dosen-profile-error" id="name-error" role="alert">
                                                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                                                            <span>{{ $message }}</span>
                                                        </div>
                                                    @enderror

                                                </div>


                                                <div class="dosen-profile-password-field">

                                                    <label for="password">Ubah Password</label>

                                                    <div class="dosen-input-wrap">
                                                        <i class="fas fa-lock" aria-hidden="true"></i>
                                                        <input id="password" type="password" name="password"
                                                            placeholder="Masukkan password baru (opsional)"
                                                            autocomplete="new-password"
                                                            @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                                                        <button type="button" class="dosen-password-toggle"
                                                            data-password-target="password"
                                                            aria-label="Tampilkan password" aria-pressed="false">
                                                            <i class="far fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </div>

                                                    <small class="dosen-field-hint">
                                                        Biarkan kosong apabila tidak ingin mengubah password.
                                                    </small>

                                                    @error('password')
                                                        <div class="dosen-profile-error" id="password-error" role="alert">
                                                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                                                            <span>{{ $message }}</span>
                                                        </div>
                                                    @enderror

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </section>

                            </div>

                            <div class="dosen-profile-card-footer">

                                <div class="dosen-profile-save-note" aria-live="polite">
                                    <i class="fas fa-shield-alt" aria-hidden="true"></i>
                                    <span>Perubahan akan diterapkan ke akun Anda.</span>
                                </div>

                                <div class="dosen-profile-actions">
                                    <a href="{{ route('dosen.dash') }}" class="dosen-profile-cancel" data-turbo="true">
                                        Batal
                                    </a>

                                    <button type="submit" class="dosen-profile-submit">
                                        <i class="fas fa-save" aria-hidden="true"></i>
                                        <span>Simpan Perubahan</span>
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </section>

    </div>

@endsection

@section('css')
    <style>
        :root {
            --profile-green-950: #003d2d;
            --profile-green-900: #064b39;
            --profile-green-700: #0d6e53;
            --profile-green-100: #eaf6ef;
            --profile-gold: #b99835;
            --profile-ink: #10251f;
            --profile-text: #405b52;
            --profile-muted: #73857e;
            --profile-line: #e1ebe6;
            --profile-surface: #ffffff;
            --profile-soft: #f8fbf9;
            --profile-danger: #d85d68;
        }

        body.page-dosen-profile .content-wrapper {
            min-height: calc(100vh - 66px);
            background:
                radial-gradient(ellipse 65% 35% at 100% 0%, rgba(7, 86, 64, .055), transparent 70%),
                linear-gradient(180deg, #f4f8f6 0%, #f7faf8 100%) !important;
        }

        body.page-dosen-profile .content-header {
            padding: 24px 0 10px !important;
        }

        body.page-dosen-profile .content {
            padding: 4px 0 36px !important;
        }

        .dosen-profile-shell {
            width: min(1080px, calc(100% - 44px));
            margin: 0 auto;
        }

        /* Accessible focus ring for every interactive element on this page */
        .dosen-profile-page a:focus-visible,
        .dosen-profile-page button:focus-visible,
        .dosen-profile-page input:focus-visible {
            outline: 2px solid var(--profile-green-700);
            outline-offset: 2px;
        }

        /* ---------- Heading ---------- */

        .dosen-profile-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .dosen-profile-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 8px;
            color: var(--profile-green-700);
            font-size: 10px;
            line-height: 1;
            font-weight: 800;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        .dosen-profile-eyebrow::before {
            content: "";
            width: 24px;
            height: 2px;
            border-radius: 999px;
            background: var(--profile-gold);
        }

        .dosen-profile-heading h1 {
            margin: 0;
            color: #10233a;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: clamp(29px, 3vw, 36px);
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -.045em;
        }

        .dosen-profile-heading p {
            margin: 7px 0 0;
            color: var(--profile-muted);
            font-size: 12px;
            line-height: 1.55;
        }

        .dosen-profile-heading .breadcrumb {
            margin: 0;
            padding: 0;
            background: transparent;
            font-size: 11.5px;
            font-weight: 600;
        }

        .dosen-profile-heading .breadcrumb-item a {
            color: var(--profile-green-700);
            text-decoration: none;
        }

        .dosen-profile-heading .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .dosen-profile-heading .breadcrumb-item.active {
            color: var(--profile-muted);
        }

        .dosen-profile-heading .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            padding: 0 9px;
            color: #b6c4bd;
        }

        /* ---------- Card shell ---------- */

        .dosen-profile-card {
            overflow: hidden;
            border: 1px solid var(--profile-line);
            border-radius: 20px;
            background: var(--profile-surface);
            box-shadow:
                0 18px 50px rgba(7, 62, 45, .075),
                0 3px 12px rgba(16, 45, 35, .025);
        }

        .dosen-profile-card-head {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 22px 28px 20px;
            border-bottom: 1px solid #e8efeb;
            background: linear-gradient(120deg, #fff 50%, #f3f9f6 100%);
        }

        .dosen-profile-card-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: linear-gradient(150deg, var(--profile-green-100), #dcf0e5);
            color: var(--profile-green-900);
            font-size: 16px;
        }

        .dosen-profile-card-kicker {
            display: block;
            margin-bottom: 3px;
            color: var(--profile-green-700);
            font-size: 9.5px;
            line-height: 1;
            font-weight: 800;
            letter-spacing: .11em;
            text-transform: uppercase;
        }

        .dosen-profile-card-head h2 {
            margin: 0;
            color: var(--profile-ink);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 18px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -.025em;
        }

        .dosen-profile-card-head p {
            margin: 4px 0 0;
            color: var(--profile-muted);
            font-size: 11.5px;
            line-height: 1.45;
        }

        .dosen-profile-card-body {
            padding: 27px 28px 25px;
        }

        /* ---------- Section label ---------- */

        .dosen-profile-section-label {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 17px;
        }

        .dosen-profile-section-number {
            width: 31px;
            height: 31px;
            flex: 0 0 31px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #f1f7f4;
            color: var(--profile-green-700);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 10px;
            font-weight: 800;
        }

        .dosen-profile-section-label h3 {
            margin: 0;
            color: #17332a;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            line-height: 1.25;
            font-weight: 800;
        }

        .dosen-profile-section-label small {
            display: block;
            margin-top: 2px;
            color: #8a9a94;
            font-size: 10px;
            line-height: 1.4;
        }

        /* ---------- Main grid: photo + form ---------- */

        .dosen-profile-main-grid {
            display: grid;
            grid-template-columns: minmax(280px, 0.95fr) minmax(360px, 1.45fr);
            gap: 28px;
            align-items: stretch;
        }

        .dosen-profile-photo-column {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 370px;
            padding: 28px;
            border: 1px solid #e2ebe7;
            border-radius: 18px;
            background:
                radial-gradient(circle at 50% 0%, rgba(49, 183, 119, .08), transparent 55%),
                linear-gradient(145deg, #fbfdfc 0%, #f4f9f6 100%);
        }

        .dosen-profile-photo-frame {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dosen-profile-current-photo {
            width: 190px;
            height: 190px;
            flex: 0 0 190px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 6px solid #ffffff;
            border-radius: 28px;
            background: linear-gradient(150deg, #e9f6ef, #d8ecdf);
            color: #075640;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 52px;
            font-weight: 800;
            box-shadow:
                0 16px 35px rgba(7, 62, 45, .13),
                0 0 0 1px #d8e9df;
        }

        .dosen-profile-current-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dosen-profile-photo-status {
            position: absolute;
            right: -10px;
            bottom: 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border: 2px solid #fff;
            border-radius: 999px;
            background: #ffffff;
            color: #0d6e53;
            font-size: 9.5px;
            font-weight: 800;
            box-shadow: 0 7px 16px rgba(16, 45, 35, .10);
        }

        .dosen-profile-photo-status i {
            width: 16px;
            height: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #eaf6ef;
            color: #0d6e53;
            font-size: 8px;
        }

        .dosen-profile-photo-copy {
            width: 100%;
            margin-top: 19px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .dosen-profile-photo-copy>strong {
            color: #17332a;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 17px;
            line-height: 1.3;
            font-weight: 800;
        }

        .dosen-profile-photo-copy>span {
            margin-top: 3px;
            color: #7d8d87;
            font-size: 10.5px;
            font-weight: 600;
        }

        .dosen-file-picker {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 14px;
            padding: 10px 14px;
            overflow: hidden;
            border: 1px solid #c8dbd1;
            border-radius: 10px;
            background: #ffffff;
            color: #075640;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 5px 12px rgba(7, 86, 64, .05);
            transition: background .18s ease, border-color .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .dosen-file-picker:hover {
            background: #f1f8f4;
            border-color: #aec9bc;
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(7, 86, 64, .08);
        }

        .dosen-file-picker input {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .dosen-profile-photo-filename {
            display: block;
            margin-top: 7px;
            max-width: 220px;
            color: #9aa8a2;
            font-size: 9.5px;
            line-height: 1.5;
        }

        .dosen-profile-photo-filename.has-file {
            color: var(--profile-green-700);
            font-weight: 700;
        }

        /* ---------- Account form ---------- */

        .dosen-profile-account-column {
            min-width: 0;
            display: flex;
            align-items: center;
            padding: 10px 2px;
        }

        .dosen-profile-form-stack {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 22px;
            padding: 7px 4px;
        }

        .dosen-profile-account-column .dosen-profile-field,
        .dosen-profile-account-column .dosen-profile-password-field {
            width: 100%;
        }

        .dosen-profile-field label,
        .dosen-profile-password-field label {
            display: block;
            margin-bottom: 7px;
            color: #263e35;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            line-height: 1.3;
            font-weight: 800;
        }

        .dosen-profile-field label span {
            color: var(--profile-danger);
        }

        .dosen-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .dosen-input-wrap>i {
            position: absolute;
            left: 13px;
            color: #83958d;
            font-size: 12px;
            pointer-events: none;
            transition: color .18s ease;
        }

        .dosen-input-wrap input {
            width: 100%;
            height: 43px;
            padding: 0 40px 0 37px;
            border: 1px solid #dfe9e4;
            border-radius: 10px;
            outline: none;
            background: #fff;
            color: #18312a;
            font-family: "Inter", sans-serif;
            font-size: 12px;
            font-weight: 500;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .dosen-input-wrap input::placeholder {
            color: #a2aea9;
        }

        .dosen-input-wrap input:hover {
            border-color: #cbdad2;
        }

        .dosen-input-wrap input:focus {
            border-color: var(--profile-green-700);
            box-shadow: 0 0 0 3px rgba(13, 110, 83, .09);
        }

        .dosen-input-wrap input[aria-invalid="true"] {
            border-color: var(--profile-danger);
        }

        .dosen-input-wrap:focus-within>i {
            color: var(--profile-green-700);
        }

        .dosen-password-toggle {
            position: absolute;
            right: 8px;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: #899a93;
            cursor: pointer;
            transition: background .18s ease, color .18s ease;
        }

        .dosen-password-toggle:hover {
            background: #f1f6f3;
            color: var(--profile-green-900);
        }

        .dosen-field-hint {
            display: block;
            margin-top: 7px;
            color: #98a69f;
            font-size: 9.5px;
            line-height: 1.45;
        }

        .dosen-profile-error {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            margin-top: 7px;
            color: var(--profile-danger);
            font-size: 10.5px;
            line-height: 1.45;
        }

        .dosen-profile-error i {
            margin-top: 1px;
        }

        /* ---------- Footer ---------- */

        .dosen-profile-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 17px 28px;
            border-top: 1px solid #e7eeeb;
            background: #f9fbfa;
        }

        .dosen-profile-save-note {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #84948d;
            font-size: 10px;
            line-height: 1.4;
        }

        .dosen-profile-save-note i {
            color: var(--profile-green-700);
        }

        .dosen-profile-actions {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .dosen-profile-cancel {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 14px;
            border: 1px solid #d7e2dc;
            border-radius: 10px;
            background: #fff;
            color: #52675e;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none !important;
            transition: background .18s ease, border-color .18s ease, color .18s ease;
        }

        .dosen-profile-cancel:hover {
            background: #f4f8f6;
            border-color: #c6d6ce;
            color: #263e35;
        }

        .dosen-profile-submit {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 16px;
            border: 1px solid var(--profile-green-950);
            border-radius: 10px;
            background: var(--profile-green-950);
            color: #fff;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(0, 61, 45, .16);
            transition: background .18s ease, border-color .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .dosen-profile-submit:hover {
            background: #002e22;
            border-color: #002e22;
            transform: translateY(-1px);
            box-shadow: 0 9px 20px rgba(0, 61, 45, .22);
        }

        .dosen-profile-submit:disabled {
            cursor: not-allowed;
            opacity: .75;
            transform: none;
        }

        .dosen-profile-submit .fa-spinner {
            animation: dosen-spin .7s linear infinite;
        }

        @keyframes dosen-spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ---------- Responsive ---------- */

        @media (max-width: 991.98px) {
            .dosen-profile-shell {
                width: calc(100% - 34px);
            }

            .dosen-profile-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            .dosen-profile-heading .breadcrumb {
                align-self: flex-start;
            }

            .dosen-profile-main-grid {
                grid-template-columns: 1fr;
            }

            .dosen-profile-photo-column {
                min-height: auto;
            }

            .dosen-profile-account-column {
                padding: 0;
            }
        }

        @media (max-width: 767.98px) {
            .dosen-profile-shell {
                width: calc(100% - 26px);
            }

            .dosen-profile-card {
                border-radius: 16px;
            }

            .dosen-profile-card-head {
                align-items: flex-start;
                padding: 19px 20px 17px;
            }

            .dosen-profile-card-body {
                padding: 22px 20px;
            }

            .dosen-profile-current-photo {
                width: 160px;
                height: 160px;
                flex-basis: 160px;
                border-radius: 24px;
            }

            .dosen-profile-photo-column {
                padding: 24px 18px;
            }

            .dosen-profile-form-stack {
                padding: 0;
            }

            .dosen-profile-card-footer {
                align-items: stretch;
                flex-direction: column;
                padding: 15px 20px 18px;
            }

            .dosen-profile-actions {
                justify-content: flex-end;
            }
        }

        @media (max-width: 575.98px) {
            .dosen-profile-shell {
                width: calc(100% - 18px);
            }

            .dosen-profile-heading h1 {
                font-size: 28px;
            }

            .dosen-profile-card-body {
                padding: 20px 16px;
            }

            .dosen-profile-current-photo {
                width: 140px;
                height: 140px;
                flex-basis: 140px;
                border-radius: 22px;
                font-size: 40px;
            }

            .dosen-profile-card-footer {
                padding-left: 16px;
                padding-right: 16px;
            }

            .dosen-profile-actions {
                width: 100%;
            }

            .dosen-profile-cancel,
            .dosen-profile-submit {
                flex: 1;
            }
        }

        /* ========== MODAL OVERLAY ========== */

        .p3m-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(10, 30, 22, 0.55);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            animation: modal-fade-in .22s ease;
        }

        .p3m-modal-overlay[hidden] {
            display: none !important;
        }

        @keyframes modal-fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .p3m-modal-box {
            position: relative;
            width: 100%;
            border: 1px solid var(--profile-line);
            border-radius: 20px;
            background: #fff;
            box-shadow:
                0 32px 80px rgba(7, 40, 25, .18),
                0 6px 20px rgba(7, 40, 25, .08);
            animation: modal-slide-up .24s ease;
        }

        @keyframes modal-slide-up {
            from {
                opacity: 0;
                transform: translateY(16px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* -- Danger modal (foto terlalu besar) -- */
        .p3m-modal-danger {
            max-width: 420px;
            padding: 32px 28px 26px;
            text-align: center;
        }

        .p3m-modal-icon-wrap {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            margin: 0 auto 18px;
            font-size: 22px;
        }

        .p3m-modal-icon-danger {
            background: #fef2f2;
            color: #dc2626;
        }

        .p3m-modal-icon-success {
            background: var(--profile-green-100);
            color: var(--profile-green-700);
        }

        .p3m-modal-danger h4 {
            margin: 0 0 10px;
            color: #1a1a1a;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 17px;
            font-weight: 800;
            line-height: 1.3;
        }

        .p3m-modal-danger p {
            margin: 0 0 22px;
            color: #6b7280;
            font-size: 12.5px;
            line-height: 1.65;
        }

        /* -- Preview / Cropper modal -- */
        .p3m-modal-preview {
            max-width: 680px;
            overflow: hidden;
        }

        .p3m-modal-preview-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px 22px 16px;
            border-bottom: 1px solid var(--profile-line);
        }

        .p3m-modal-preview-header .p3m-modal-icon-wrap {
            margin: 0;
            flex: 0 0 44px;
            width: 44px;
            height: 44px;
            font-size: 17px;
            border-radius: 12px;
        }

        .p3m-modal-preview-header h4 {
            margin: 0;
            color: var(--profile-ink);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 14.5px;
            font-weight: 800;
            line-height: 1.3;
        }

        .p3m-modal-preview-header p {
            margin: 2px 0 0;
            color: var(--profile-muted);
            font-size: 10.5px;
            line-height: 1.45;
        }

        /* Cropper layout */
        .p3m-cropper-container {
            display: grid;
            grid-template-columns: 1fr 220px;
            min-height: 320px;
        }

        .p3m-cropper-wrap {
            background: #141414;
            overflow: hidden;
            max-height: 380px;
        }

        .p3m-cropper-wrap img {
            display: block;
            max-width: 100%;
        }

        /* Sidebar */
        .p3m-cropper-sidebar {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 18px 16px;
            border-left: 1px solid var(--profile-line);
            background: #fafcfb;
            overflow-y: auto;
        }

        /* Result preview */
        .p3m-cropper-result-label {
            margin-bottom: 8px;
            color: var(--profile-muted);
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .p3m-cropper-result-preview {
            width: 100px;
            height: 100px;
            overflow: hidden;
            border-radius: 50%;
            margin: 0 auto;
            border: 3px solid #fff;
            box-shadow:
                0 8px 20px rgba(7, 62, 45, .14),
                0 0 0 1px #d4e8df;
            background: #eaf6ef;
        }

        /* Meta info */
        .p3m-preview-meta {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .p3m-preview-meta-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .p3m-preview-meta-item>i {
            width: 26px;
            height: 26px;
            flex: 0 0 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            background: #f1f7f4;
            color: var(--profile-green-700);
            font-size: 10px;
        }

        .p3m-preview-meta-webp>i {
            background: rgba(7, 86, 64, .10);
        }

        .p3m-preview-meta-label {
            display: block;
            color: var(--profile-muted);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .p3m-preview-meta-value {
            display: block;
            margin-top: 2px;
            color: var(--profile-ink);
            font-size: 11px;
            font-weight: 600;
            word-break: break-all;
        }

        .p3m-size-loading {
            color: var(--profile-muted);
            font-size: 10px;
        }

        /* Cropper controls */
        .p3m-cropper-controls {
            margin-top: auto;
        }

        .p3m-cropper-controls-label {
            display: block;
            margin-bottom: 7px;
            color: var(--profile-muted);
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
        }
    </style>
@endsection

@section('scripts')
    <script>
        (function() {
            'use strict';

            const FORM_SELECTOR = '#dosen-profile-form';
            const TOGGLE_SELECTOR = '.dosen-password-toggle';

            function initializeDosenProfileControls() {
                const form = document.querySelector(FORM_SELECTOR);
                const toggle = document.querySelector(TOGGLE_SELECTOR);
                const password = document.getElementById('password');

                if (toggle && password && toggle.dataset.p3mReady !== 'true') {
                    toggle.dataset.p3mReady = 'true';

                    toggle.addEventListener('click', function() {
                        const showPassword = password.type === 'password';
                        password.type = showPassword ? 'text' : 'password';
                        toggle.setAttribute('aria-pressed', String(showPassword));
                        toggle.setAttribute(
                            'aria-label',
                            showPassword ? 'Sembunyikan password' : 'Tampilkan password'
                        );

                        const icon = toggle.querySelector('i');
                        if (icon) {
                            icon.classList.toggle('fa-eye', !showPassword);
                            icon.classList.toggle('fa-eye-slash', showPassword);
                            icon.classList.remove('far');
                            icon.classList.add('fas');
                        }
                    });
                }

                if (form && form.dataset.p3mSubmitReady !== 'true') {
                    form.dataset.p3mSubmitReady = 'true';

                    form.addEventListener('submit', function() {
                        const submit = form.querySelector('.dosen-profile-submit');
                        if (!submit || submit.dataset.p3mSubmitting === 'true') {
                            return;
                        }

                        submit.dataset.p3mSubmitting = 'true';
                        submit.setAttribute('aria-busy', 'true');

                        const icon = submit.querySelector('i');
                        const label = submit.querySelector('span');

                        if (icon) {
                            icon.className = 'fas fa-spinner fa-spin';
                        }
                        if (label) {
                            label.textContent = 'Menyimpan...';
                        }

                        setTimeout(function() {
                            submit.disabled = true;
                        }, 20);
                    });
                }
            }

            window.addEventListener('pageshow', function() {
                const submit = document.querySelector('.dosen-profile-submit');
                if (submit) {
                    delete submit.dataset.p3mSubmitting;
                    submit.disabled = false;
                    submit.removeAttribute('aria-busy');
                    const icon = submit.querySelector('i');
                    const label = submit.querySelector('span');
                    if (icon) icon.className = 'fas fa-save';
                    if (label) label.textContent = 'Simpan Perubahan';
                }
            });

            document.addEventListener('turbo:load', initializeDosenProfileControls);
            document.addEventListener('DOMContentLoaded', initializeDosenProfileControls, {
                once: true
            });
        })();
    </script>
@endsection
