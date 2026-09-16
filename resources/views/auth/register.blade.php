<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Daftar Akun Dosen | P3M Polibang</title>

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
            min-height: 540px;
        }

        /* ── Form Side ── */
        .auth-form-side {
            padding: 44px 46px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
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
            margin-bottom: 22px;
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
            margin-bottom: 15px;
        }

        .form-label-custom {
            display: block;
            margin-bottom: 6px;
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

        /* ── Submit Button ── */
        .btn-submit-p3m {
            width: 100%;
            height: 48px;
            margin-top: 8px;
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

        .auth-switch-link {
            color: var(--primary);
            font-weight: 700;
            font-size: 13.5px;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .auth-switch-link:hover {
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
                padding: 34px 28px 30px;
            }

            .auth-brand {
                margin-bottom: 18px;
            }

            .auth-header {
                margin-bottom: 18px;
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
                padding: 28px 20px 24px;
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
                    <h1>Daftar Akun Dosen</h1>
                    <p>Khusus dosen resmi Politeknik Balekambang</p>
                </div>

                <form action="{{ route('proses-register') }}" method="post">
                    @csrf

                    <div class="form-group-custom">
                        <label class="form-label-custom" for="name">Username</label>
                        <div class="input-wrap-custom">
                            <input id="name" type="text" name="name" class="form-input-custom" placeholder="Masukkan username" value="{{ old('name') }}" autocomplete="username" maxlength="255" required autofocus>
                            <span class="input-addon-icon">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        @error('name')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom" for="email">Email</label>
                        <div class="input-wrap-custom">
                            <input id="email" type="email" name="email" class="form-input-custom" placeholder="Masukkan email" value="{{ old('email') }}" autocomplete="email" maxlength="255" required>
                            <span class="input-addon-icon">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        @error('email')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom" for="password">Password</label>
                        <div class="input-wrap-custom">
                            <input id="password" type="password" name="password" class="form-input-custom" placeholder="Minimal 8 karakter" autocomplete="new-password" minlength="8" required>
                            <button class="input-addon-btn" type="button" id="togglePassword" aria-label="Tampilkan password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit-p3m">
                        <span>Daftar Sekarang</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>

                    <div class="auth-switch">
                        <span>Sudah memiliki akun?</span>
                        <a href="{{ route('login') }}" class="auth-switch-link">
                            Masuk di sini
                        </a>
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
                    <i class="fas fa-user-plus"></i>
                    <span>Registrasi Dosen</span>
                </div>

                <div class="art-body">
                    <h2>Mulai Bergabung</h2>
                    <p>Daftarkan akun dosen untuk mengakses layanan penelitian dan pengabdian masyarakat Politeknik Balekambang Jepara.</p>
                </div>

                <div class="art-footer-meta">
                    © {{ date('Y') }} P3M Polibang
                </div>
            </aside>

        </div>
    </main>

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
    </script>
</body>

</html>
