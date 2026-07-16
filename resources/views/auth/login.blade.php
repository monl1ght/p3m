<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengelola P3M dan Dosen Polibang</title>

    <link rel="shortcut icon" href="{{ asset('favicon/icon_log.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon/icon_log.ico') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">

    <style>

        :root {
            --p3m-green: #063f35;
            --p3m-dark: #071f24;
            --p3m-blue: #2563eb;
            --p3m-blue-hover: #1d4ed8;
            --p3m-gold: #d5a72f;
            --p3m-border: #e2e8f0;
            --p3m-muted: #64748b;
            --p3m-heading: #0f172a;
            --p3m-soft: #f8fafc;
            --p3m-font: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            --p3m-heading-font: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body.login-page {
            min-height: 100vh;
            margin: 0;
            padding: 28px 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-family: var(--p3m-font);
            background:
                radial-gradient(circle at 16% 14%, rgba(6, 63, 53, .07), transparent 30%),
                radial-gradient(circle at 84% 18%, rgba(213, 167, 47, .08), transparent 28%),
                linear-gradient(135deg, #f8fafc 0%, #f3f6fb 52%, #eef2f7 100%);
        }

        a {
            color: var(--p3m-blue);
            text-decoration: none;
            transition: .22s ease;
        }

        a:hover {
            color: var(--p3m-blue-hover);
            text-decoration: none;
        }

        .login-wrapper {
            width: 100%;
            max-width: 920px;
        }

        .login-card {
            min-height: 540px;
            display: grid;
            grid-template-columns: 1fr .92fr;
            overflow: hidden;
            border-radius: 30px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, .96);
            box-shadow: 0 28px 70px rgba(15, 23, 42, .11), 0 1px 0 rgba(255, 255, 255, .85) inset;
        }

        .login-form-side {
            padding: 50px 58px 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-side .brand-inline,
        .login-form-side .login-title,
        .login-form-side form,
        .login-form-side .back-home {
            width: 100%;
            max-width: 382px;
        }

        .brand-inline {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            color: var(--p3m-heading);
            font-family: var(--p3m-heading-font);
            font-size: 18.5px;
            font-weight: 900;
            letter-spacing: -0.045em;
        }

        .brand-inline:hover {
            color: var(--p3m-heading);
            opacity: .88;
        }

        .brand-inline img {
            width: 37px;
            height: 37px;
            object-fit: contain;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid #dbeafe;
            padding: 4px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
        }

        .login-title {
            position: relative;
            margin-bottom: 25px;
            padding-top: 12px;
        }

        .login-title::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 36px;
            height: 3px;
            border-radius: 999px;
            background: var(--p3m-gold);
        }

        .login-title h1 {
            margin: 0;
            color: var(--p3m-heading);
            font-family: var(--p3m-heading-font);
            font-size: 30px;
            line-height: 1.12;
            font-weight: 900;
            letter-spacing: -0.052em;
        }

        .login-title p {
            margin: 8px 0 0;
            color: var(--p3m-muted);
            font-size: 13.5px;
            line-height: 1.65;
        }

        .auth-input-group {
            margin-bottom: 15px;
        }

        .form-label-custom {
            display: block;
            margin-bottom: 7px;
            color: #1e293b;
            font-size: 12.75px;
            font-weight: 850;
        }

        .auth-input-group .input-group {
            overflow: hidden;
            border: 1px solid #dbe4f0;
            border-radius: 12px;
            background: #ffffff;
            transition: .22s ease;
        }

        .auth-input-group .input-group:hover {
            border-color: #cbd5e1;
        }

        .auth-input-group .input-group:focus-within {
            border-color: #93c5fd;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .09);
        }

        .auth-input-group .form-control {
            height: 44px;
            border: 0;
            box-shadow: none;
            color: #0f172a;
            background: transparent;
            font-size: 13.8px;
            padding-left: 14px;
        }

        .auth-input-group .form-control::placeholder {
            color: #94a3b8;
        }

        .auth-input-group .input-group-text,
        .password-toggle {
            width: 46px;
            border: 0;
            background: #f8fafc;
            color: #475569;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle {
            cursor: pointer;
            transition: .22s ease;
        }

        .password-toggle:hover {
            color: var(--p3m-blue);
            background: #eff6ff;
        }

        .auth-error {
            display: block;
            margin-top: -8px;
            margin-bottom: 14px;
            color: #dc2626;
            font-size: 13px;
            font-weight: 650;
        }

        .btn-login {
            width: 100%;
            height: 47px;
            margin-top: 7px;
            border: 0;
            border-radius: 12px;
            background: var(--p3m-blue);
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 900;
            letter-spacing: 0;
            box-shadow: 0 13px 26px rgba(37, 99, 235, .18);
            transition: .22s ease;
        }

        .btn-login:hover {
            background: var(--p3m-blue-hover);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 16px 32px rgba(37, 99, 235, .22);
        }

        .login-secondary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 15px;
            padding: 12px 13px;
            border: 1px solid var(--p3m-border);
            border-radius: 13px;
            background: linear-gradient(180deg, #ffffff 0%, var(--p3m-soft) 100%);
            text-align: left;
        }

        .register-copy {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .register-icon {
            width: 34px;
            height: 34px;
            flex: 0 0 auto;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            color: var(--p3m-blue);
            font-size: 13px;
        }

        .login-secondary strong {
            display: block;
            color: var(--p3m-heading);
            font-size: 13px;
            line-height: 1.25;
            font-weight: 850;
        }

        .login-secondary span:not(.register-icon) {
            display: block;
            margin-top: 2px;
            color: var(--p3m-muted);
            font-size: 11.7px;
            line-height: 1.35;
        }

        .register-btn {
            flex: 0 0 auto;
            min-height: 32px;
            padding: 7px 13px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid #bfdbfe;
            color: var(--p3m-blue);
            font-size: 12.5px;
            font-weight: 850;
            white-space: nowrap;
        }

        .register-btn:hover {
            background: var(--p3m-blue);
            border-color: var(--p3m-blue);
            color: #ffffff;
        }

        .back-home {
            margin-top: 13px;
            text-align: center;
            color: var(--p3m-muted);
            font-size: 13.25px;
        }

        .back-home a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border-radius: 999px;
            color: var(--p3m-blue);
            font-weight: 800;
        }

        .back-home a:hover {
            background: #eff6ff;
            color: var(--p3m-blue-hover);
        }

        .login-art-side {
            position: relative;
            overflow: hidden;
            margin: 18px 18px 18px 0;
            border-radius: 24px;
            color: #ffffff;
            background: linear-gradient(145deg, var(--p3m-green) 0%, #05352f 48%, var(--p3m-dark) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 46px;
            isolation: isolate;
        }

        .login-art-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, .075), transparent 36%),
                radial-gradient(circle at 88% 12%, rgba(213, 167, 47, .16), transparent 30%);
            z-index: -2;
        }

        .login-art-side::after {
            content: "";
            position: absolute;
            left: 46px;
            right: 46px;
            bottom: 40px;
            height: 1px;
            background: linear-gradient(90deg, rgba(213, 167, 47, .82), rgba(213, 167, 47, 0));
            opacity: .8;
            z-index: -1;
        }

        .art-badge {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 38px;
            padding: 9px 13px;
            border-radius: 999px;
            color: rgba(255, 255, 255, .92);
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .16);
            backdrop-filter: blur(10px);
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .art-badge i {
            color: var(--p3m-gold);
        }

        .art-content {
            max-width: 350px;
        }

        .art-content h2 {
            margin: 0;
            color: #ffffff;
            font-family: var(--p3m-heading-font);
            font-size: 40px;
            line-height: 1.05;
            letter-spacing: -0.055em;
            font-weight: 900;
        }

        .art-content p {
            max-width: 315px;
            margin: 15px 0 0;
            color: rgba(226, 232, 240, .88);
            font-size: 13.5px;
            line-height: 1.8;
        }

        .art-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 26px;
        }

        .art-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 11px;
            border-radius: 999px;
            color: rgba(226, 232, 240, .88);
            background: rgba(255, 255, 255, .09);
            border: 1px solid rgba(255, 255, 255, .12);
            font-size: 11.8px;
            font-weight: 700;
        }

        .art-tag i {
            color: #bfdbfe;
            font-size: 11px;
        }

        .alert-floating {
            position: fixed;
            right: 24px;
            top: 24px;
            z-index: 9999;
            max-width: 420px;
            border: 0;
            border-radius: 18px;
            box-shadow: 0 22px 60px rgba(15, 23, 42, .18);
        }

        @media (max-width: 991.98px) {
            .login-card {
                max-width: 520px;
                min-height: auto;
                margin: 0 auto;
                grid-template-columns: 1fr;
            }

            .login-form-side {
                padding: 42px 36px 36px;
            }

            .login-form-side .brand-inline,
            .login-form-side .login-title,
            .login-form-side form,
            .login-form-side .back-home {
                max-width: 100%;
            }

            .login-art-side {
                min-height: 235px;
                margin: 0 18px 18px;
                padding: 34px;
                order: -1;
            }

            .art-badge {
                margin-bottom: 24px;
            }

            .art-tags {
                display: none;
            }
        }

        @media (max-width: 575.98px) {
            body.login-page {
                padding: 18px 12px;
            }

            .login-card {
                border-radius: 24px;
            }

            .login-form-side {
                padding: 32px 22px 28px;
            }

            .login-title h1 {
                font-size: 29px;
            }

            .login-art-side {
                display: none;
            }

            .login-secondary {
                align-items: stretch;
                flex-direction: column;
            }

            .register-btn {
                width: 100%;
            }

            .alert-floating {
                left: 14px;
                right: 14px;
                top: 14px;
            }
        }

    </style>
</head>

<body class="hold-transition login-page">
    <main class="login-wrapper">
        <section class="login-card">
            <div class="login-form-side">
                <a href="{{ route('tampilan') }}" class="brand-inline">
                    <img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M Polibang">
                    <span>P3M Polibang</span>
                </a>

                <div class="login-title">
                    <h1>Login P3M</h1>
                    <p>Masuk Ke Laman Pengelola / Dosen P3M</p>
                </div>

                <form action="{{ route('proses-login') }}" method="post">
                    @csrf

                    <div class="auth-input-group">
                        <label class="form-label-custom" for="name">Username</label>
                        <div class="input-group">
                            <input id="name" type="text" name="name" class="form-control" placeholder="Masukkan username" value="{{ old('name') }}" autocomplete="username" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('name')
                        <small class="auth-error">{{ $message }}</small>
                    @enderror

                    <div class="auth-input-group">
                        <label class="form-label-custom" for="password">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan password" autocomplete="current-password">
                            <div class="input-group-append">
                                <button class="password-toggle" type="button" id="togglePassword" aria-label="Tampilkan password">
                                    <span class="fas fa-eye"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('password')
                        <small class="auth-error">{{ $message }}</small>
                    @enderror

                    <button type="submit" class="btn-login">
                        Login
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>

                    <div class="login-secondary">
                        <div class="register-copy">
                            <span class="register-icon">
                                <i class="fas fa-user-plus"></i>
                            </span>
                            <div>
                                <strong>Belum punya akun?</strong>
                                <span>Daftar khusus untuk dosen Polibang.</span>
                            </div>
                        </div>
                        <a href="{{ route('register') }}" class="register-btn">Daftar</a>
                    </div>
                </form>

                <div class="back-home">
                    <a href="{{ route('tampilan') }}">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

            <aside class="login-art-side">
                <div class="art-badge">
                    <i class="fas fa-shield-alt"></i>
                    Portal P3M
                </div>

                <div class="art-content">
                    <h2>Selamat<br>Datang</h2>
                    <p>Akses pengelolaan data, kegiatan, dokumen, dan laporan P3M Politeknik Balekambang Jepara.</p>
                </div>

                <div class="art-tags">
                    <span class="art-tag">
                        <i class="fas fa-check"></i>
                        Dashboard
                    </span>
                    <span class="art-tag">
                        <i class="fas fa-lock"></i>
                        Akses aman
                    </span>
                </div>
            </aside>
        </section>
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
                const icon = this.querySelector('span');
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
