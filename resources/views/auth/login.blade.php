<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Login | P3M Politeknik Balekambang Jepara</title>

    <link rel="shortcut icon" href="{{ asset('favicon/icon_log.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon/icon_log.ico') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">

    <style>
        :root {
            --primary: #059669;
            --primary-hover: #047857;
            --primary-soft: #ecfdf5;
            --primary-border: #a7f3d0;
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --text-heading: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --font-body: "Inter", system-ui, sans-serif;
            --font-heading: "Plus Jakarta Sans", "Inter", sans-serif;
            --transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            min-height: 100%;
        }

        body.login-page {
            min-height: 100vh;
            margin: 0;
            padding: 24px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-body);
            color: var(--text-body);
            background: 
                radial-gradient(circle at 10% 10%, rgba(5, 150, 105, 0.05), transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(5, 150, 105, 0.04), transparent 40%),
                linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .auth-wrapper {
            width: 100%;
            max-width: 880px;
            margin: auto;
        }

        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 28px;
            box-shadow: 0 20px 50px -10px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.03);
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            overflow: hidden;
            min-height: 520px;
        }

        /* ── Form Side ── */
        .auth-form-side {
            padding: 48px 46px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
            text-decoration: none;
            color: var(--text-heading);
        }

        .auth-brand:hover {
            color: var(--text-heading);
            opacity: 0.9;
        }

        .auth-brand-logo {
            width: 36px;
            height: 36px;
            object-fit: contain;
            border-radius: 50%;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 3px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
        }

        .auth-brand-name {
            font-family: var(--font-heading);
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--text-heading);
        }

        .auth-header {
            margin-bottom: 24px;
        }

        .auth-header h1 {
            font-family: var(--font-heading);
            font-size: 26px;
            font-weight: 800;
            color: var(--text-heading);
            line-height: 1.25;
            margin: 0 0 6px 0;
            letter-spacing: -0.02em;
        }

        .auth-header p {
            font-size: 13.5px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.5;
        }

        /* ── Form Controls ── */
        .form-group-custom {
            margin-bottom: 16px;
        }

        .form-label-custom {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }

        .input-wrap-custom {
            position: relative;
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            transition: var(--transition);
        }

        .input-wrap-custom:hover {
            border-color: #cbd5e1;
        }

        .input-wrap-custom:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3.5px rgba(5, 150, 105, 0.12);
        }

        .form-input-custom {
            width: 100%;
            height: 48px;
            padding: 0 46px 0 16px;
            border: none;
            background: transparent;
            font-family: var(--font-body);
            font-size: 14px;
            color: var(--text-heading);
            outline: none;
        }

        .form-input-custom::placeholder {
            color: #94a3b8;
            font-size: 13.5px;
        }

        .input-addon-btn,
        .input-addon-icon {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            background: transparent;
            border: none;
            outline: none;
            font-size: 14px;
        }

        .input-addon-btn {
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .input-addon-btn:hover {
            color: var(--primary);
        }

        .form-error {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            font-weight: 600;
            color: #ef4444;
        }

        /* ── Remember Me Checkbox ── */
        .form-remember-wrap {
            display: flex;
            align-items: center;
            margin-top: 12px;
            margin-bottom: 26px;
        }

        .checkbox-remember-label {
            display: inline-flex;
            align-items: center;
            gap: 7.5px;
            cursor: pointer;
            user-select: none;
            margin: 0;
            font-size: 12.5px;
            font-weight: 500;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .checkbox-remember-label:hover {
            color: #1e293b;
        }

        .checkbox-remember-input {
            width: 14.5px;
            height: 14.5px;
            cursor: pointer;
            accent-color: var(--primary);
            border-radius: 3.5px;
            border: 1.5px solid var(--border-color);
            margin: 0;
            vertical-align: middle;
            outline: none;
            transition: box-shadow 0.2s ease;
        }

        .checkbox-remember-input:focus-visible {
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.18);
            outline: 2px solid var(--primary);
            outline-offset: 1px;
        }

        .checkbox-remember-text {
            line-height: 1;
        }

        /* ── Submit Button ── */
        .btn-submit-p3m {
            width: 100%;
            height: 48px;
            margin-top: 0;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            font-family: var(--font-heading);
            font-size: 14.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.24);
            transition: var(--transition);
        }

        .btn-submit-p3m:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(5, 150, 105, 0.32);
        }

        .btn-submit-p3m:active {
            transform: translateY(0);
        }

        /* ── Clean Switch & Links ── */
        .auth-switch {
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13.5px;
            color: var(--text-muted);
        }

        .auth-switch-btn {
            background: none;
            border: none;
            padding: 0;
            color: var(--primary);
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .auth-switch-btn:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .auth-back {
            margin-top: 14px;
            text-align: center;
        }

        .auth-back a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .auth-back a:hover {
            color: var(--primary);
            text-decoration: none;
        }

        /* ── Side Art Panel (Desktop) ── */
        .auth-art-side {
            background: linear-gradient(145deg, #04261f 0%, #063f35 60%, #047857 100%);
            position: relative;
            padding: 44px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #ffffff;
            overflow: hidden;
            isolation: isolate;
        }

        .auth-art-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 85% 15%, rgba(52, 211, 153, 0.18), transparent 45%);
            z-index: -1;
        }

        .art-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #ffffff;
            width: fit-content;
        }

        .art-header-badge i {
            color: #34d399;
        }

        .art-body {
            margin: auto 0;
        }

        .art-body h2 {
            font-family: var(--font-heading);
            font-size: 32px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.03em;
            color: #ffffff;
            margin: 0 0 12px 0;
        }

        .art-body p {
            font-size: 14px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.85);
            margin: 0;
            max-width: 320px;
        }

        .art-footer-meta {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.65);
            font-weight: 500;
        }

        /* ── Modal Gatekeeper ── */
        .modal-gatekeeper .modal-content {
            border: 1px solid var(--border-color);
            border-radius: 22px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.2);
            overflow: hidden;
            background: #ffffff;
        }

        .modal-gatekeeper .modal-header {
            border-bottom: 1px solid #f1f5f9;
            padding: 20px 24px;
            background: #f8fafc;
        }

        .modal-gatekeeper .modal-body {
            padding: 22px 24px;
        }

        .gate-icon-wrapper {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .gate-notice {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #059669;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12.5px;
            color: #475569;
            line-height: 1.5;
            margin-bottom: 16px;
        }

        .gate-error-box {
            display: none;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12.5px;
            margin-bottom: 14px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .gate-success-box {
            display: none;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 12.5px;
            margin-bottom: 14px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }

        .btn-gate-verify {
            background: #059669;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 13.5px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn-gate-verify:hover:not(:disabled) {
            background: #047857;
            color: #ffffff;
        }

        .btn-gate-cancel {
            background: #f1f5f9;
            color: #64748b;
            border: none;
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 600;
            font-size: 13.5px;
            cursor: pointer;
        }

        .btn-gate-cancel:hover {
            background: #e2e8f0;
            color: #334155;
        }

        /* ── Floating Alerts ── */
        .alert-floating {
            position: fixed;
            right: 20px;
            top: 20px;
            z-index: 9999;
            max-width: 380px;
            border: 0;
            border-radius: 14px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.15);
        }

        /* ── Mobile Layout (< 992px) ── */
        @media (max-width: 991.98px) {
            body.login-page {
                padding: 20px 14px;
            }

            .auth-card {
                grid-template-columns: 1fr;
                max-width: 440px;
                min-height: auto;
                border-radius: 24px;
            }

            .auth-art-side {
                display: none;
            }

            .auth-form-side {
                padding: 36px 28px 32px;
            }

            .auth-brand {
                margin-bottom: 20px;
            }

            .auth-header {
                margin-bottom: 20px;
            }

            .auth-header h1 {
                font-size: 23px;
            }

            .auth-header p {
                font-size: 13px;
            }
        }

        @media (max-width: 575.98px) {
            body.login-page {
                padding: 16px 12px;
            }

            .auth-card {
                border-radius: 20px;
            }

            .auth-form-side {
                padding: 30px 20px 26px;
            }

            .form-input-custom {
                height: 46px;
                font-size: 14px;
            }

            .btn-submit-p3m {
                height: 46px;
                font-size: 14px;
            }

            .alert-floating {
                left: 12px;
                right: 12px;
                top: 12px;
            }
        }
    </style>
</head>

<body class="hold-transition login-page">
    <main class="auth-wrapper">
        <div class="auth-card">

            {{-- 1. Form Column --}}
            <div class="auth-form-side">
                <a href="{{ route('tampilan') }}" class="auth-brand">
                    <img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M Polibang" class="auth-brand-logo">
                    <span class="auth-brand-name">P3M Polibang</span>
                </a>

                <div class="auth-header">
                    <h1>Login P3M</h1>
                    <p>Portal Pengelola & Dosen Polibang</p>
                </div>

                <form action="{{ route('proses-login') }}" method="post">
                    @csrf

                    <div class="form-group-custom">
                        <label class="form-label-custom" for="name">Username</label>
                        <div class="input-wrap-custom">
                            <input id="name" type="text" name="name" class="form-input-custom" placeholder="Masukkan username" value="{{ old('name') }}" autocomplete="username" autofocus required>
                            <span class="input-addon-icon">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        @error('name')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom" for="password">Password</label>
                        <div class="input-wrap-custom">
                            <input id="password" type="password" name="password" class="form-input-custom" placeholder="Masukkan password" autocomplete="current-password" required>
                            <button class="input-addon-btn" type="button" id="togglePassword" aria-label="Tampilkan password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-remember-wrap">
                        <label class="checkbox-remember-label" for="remember">
                            <input type="checkbox" name="remember" id="remember" value="1" {{ old('remember') ? 'checked' : '' }} class="checkbox-remember-input">
                            <span class="checkbox-remember-text">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-submit-p3m">
                        <span>Login</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>

                    <div class="auth-switch">
                        <span>Belum punya akun?</span>
                        <button type="button" class="auth-switch-btn" data-toggle="modal" data-target="#modalDosenGate" id="btnOpenRegisterGate">
                            Daftar Dosen
                        </button>
                    </div>
                </form>

                <div class="auth-back">
                    <a href="{{ route('tampilan') }}">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>

            {{-- 2. Art Column (Desktop Only) --}}
            <aside class="auth-art-side">
                <div class="art-header-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>Portal Resmi</span>
                </div>

                <div class="art-body">
                    <h2>Selamat Datang di P3M</h2>
                    <p>Sistem Pengelolaan Penelitian dan Pengabdian Kepada Masyarakat Politeknik Balekambang Jepara.</p>
                </div>

                <div class="art-footer-meta">
                    © {{ date('Y') }} P3M Polibang
                </div>
            </aside>

        </div>
    </main>

    {{-- Modal Gatekeeper Otorisasi Dosen --}}
    <div class="modal fade modal-gatekeeper" id="modalDosenGate" tabindex="-1" role="dialog" aria-labelledby="modalDosenGateTitle" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 440px;">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="gate-icon-wrapper mr-3">
                            <i class="fas fa-key"></i>
                        </div>
                        <div>
                            <h5 class="modal-title font-weight-bold text-dark mb-0" id="modalDosenGateTitle" style="font-size: 16px;">
                                Otorisasi Dosen
                            </h5>
                            <small class="text-muted" style="font-size: 12px;">Pendaftaran khusus dosen Polibang</small>
                        </div>
                    </div>
                    <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close" style="font-size: 24px; line-height: 1;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formGateDosen" action="{{ route('register.verify-gate') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="gate-notice">
                            <i class="fas fa-info-circle mr-1" style="color: #059669;"></i>
                            Masukkan <strong>Kode Akses Khusus</strong> yang diterbitkan oleh sekretariat P3M Polibang.
                        </div>

                        <div id="gateErrorBox" class="gate-error-box">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            <span id="gateErrorMessage">Kode otorisasi tidak valid.</span>
                        </div>

                        <div id="gateSuccessBox" class="gate-success-box">
                            <i class="fas fa-check-circle mr-1"></i>
                            <span id="gateSuccessMessage">Kode terverifikasi! Membuka formulir...</span>
                        </div>

                        <div class="form-group-custom mb-1">
                            <label class="form-label-custom" for="passcodeGateInput">
                                Kode Otorisasi Registrasi
                            </label>
                            <div class="input-wrap-custom">
                                <input id="passcodeGateInput" type="password" name="passcode" class="form-input-custom" placeholder="Masukkan kode..." autocomplete="off" required>
                                <button class="input-addon-btn" type="button" id="toggleGatePassword" aria-label="Tampilkan kode">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top-0 d-flex justify-content-between px-4 pb-4 pt-2">
                        <button type="button" class="btn-gate-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-gate-verify" id="btnSubmitGate">
                            <span id="btnSubmitGateText">Lanjutkan</span>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @inject('session', 'Illuminate\Support\Facades\Session')
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show alert-floating">
            {{ Session::get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show alert-floating">
            {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const icon = this.querySelector('i');
                const isPassword = passwordInput.getAttribute('type') === 'password';

                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                if (icon) {
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                }
            });
        }

        // Toggle eye for gatekeeper modal
        const toggleGatePassword = document.getElementById('toggleGatePassword');
        const passcodeGateInput = document.getElementById('passcodeGateInput');

        if (toggleGatePassword && passcodeGateInput) {
            toggleGatePassword.addEventListener('click', function () {
                const icon = this.querySelector('i');
                const isPassword = passcodeGateInput.getAttribute('type') === 'password';
                passcodeGateInput.setAttribute('type', isPassword ? 'text' : 'password');
                if (icon) {
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                }
            });
        }

        // Handle Gatekeeper AJAX verification
        const formGateDosen = document.getElementById('formGateDosen');
        const btnSubmitGate = document.getElementById('btnSubmitGate');
        const btnSubmitGateText = document.getElementById('btnSubmitGateText');
        const gateErrorBox = document.getElementById('gateErrorBox');
        const gateErrorMessage = document.getElementById('gateErrorMessage');
        const gateSuccessBox = document.getElementById('gateSuccessBox');

        $('#modalDosenGate').on('shown.bs.modal', function () {
            if (passcodeGateInput) {
                passcodeGateInput.value = '';
                passcodeGateInput.focus();
            }
            if (gateErrorBox) gateErrorBox.style.display = 'none';
            if (gateSuccessBox) gateSuccessBox.style.display = 'none';
            if (btnSubmitGate) {
                btnSubmitGate.disabled = false;
                btnSubmitGateText.textContent = 'Lanjutkan';
            }
        });

        $('#modalDosenGate').on('hide.bs.modal', function () {
            if (document.activeElement && typeof document.activeElement.blur === 'function') {
                document.activeElement.blur();
            }
        });

        $('#modalDosenGate').on('hidden.bs.modal', function () {
            const openBtn = document.getElementById('btnOpenRegisterGate');
            if (openBtn) {
                openBtn.focus();
            }
        });

        if (formGateDosen) {
            formGateDosen.addEventListener('submit', function (e) {
                e.preventDefault();

                const passcode = passcodeGateInput.value.trim();
                if (!passcode) {
                    if (gateErrorBox) {
                        gateErrorBox.style.display = 'block';
                        gateErrorMessage.textContent = 'Silakan masukkan kode otorisasi dosen.';
                    }
                    passcodeGateInput.focus();
                    return;
                }

                btnSubmitGate.disabled = true;
                btnSubmitGateText.textContent = 'Memverifikasi...';
                if (gateErrorBox) gateErrorBox.style.display = 'none';
                if (gateSuccessBox) gateSuccessBox.style.display = 'none';

                fetch(formGateDosen.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ passcode: passcode })
                })
                .then(async response => {
                    const data = await response.json();
                    return { status: response.status, body: data };
                })
                .then(res => {
                    if (res.body.success) {
                        if (gateSuccessBox) {
                            gateSuccessBox.style.display = 'block';
                            document.getElementById('gateSuccessMessage').textContent = 'Kode terverifikasi! Membuka pendaftaran...';
                        }
                        btnSubmitGateText.textContent = 'Berhasil!';
                        setTimeout(() => {
                            window.location.href = res.body.redirect;
                        }, 500);
                    } else {
                        btnSubmitGate.disabled = false;
                        btnSubmitGateText.textContent = 'Lanjutkan';
                        if (gateErrorBox) {
                            gateErrorBox.style.display = 'block';
                            gateErrorMessage.textContent = res.body.message || 'Kode otorisasi tidak valid!';
                        }
                        passcodeGateInput.select();
                    }
                })
                .catch(err => {
                    btnSubmitGate.disabled = false;
                    btnSubmitGateText.textContent = 'Lanjutkan';
                    if (gateErrorBox) {
                        gateErrorBox.style.display = 'block';
                        gateErrorMessage.textContent = 'Terjadi kesalahan atau koneksi terputus. Silakan coba kembali.';
                    }
                });
            });
        }
    </script>
</body>

</html>
