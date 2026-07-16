<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register P3M | Polibang</title>

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

        .register-wrapper {
            width: 100%;
            max-width: 920px;
        }

        .register-card {
            min-height: 560px;
            display: grid;
            grid-template-columns: 1fr .92fr;
            overflow: hidden;
            border-radius: 30px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, .96);
            box-shadow: 0 28px 70px rgba(15, 23, 42, .11), 0 1px 0 rgba(255, 255, 255, .85) inset;
        }

        .register-form-side {
            padding: 50px 58px 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-form-side .brand-inline,
        .register-form-side .register-title,
        .register-form-side form,
        .register-form-side .back-login {
            width: 100%;
            max-width: 382px;
        }

        .brand-inline {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
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

        .register-title {
            position: relative;
            margin-bottom: 24px;
            padding-top: 12px;
        }

        .register-title::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 36px;
            height: 3px;
            border-radius: 999px;
            background: var(--p3m-gold);
        }

        .register-title h1 {
            margin: 0;
            color: var(--p3m-heading);
            font-family: var(--p3m-heading-font);
            font-size: 30px;
            line-height: 1.12;
            font-weight: 900;
            letter-spacing: -0.052em;
        }

        .register-title p {
            margin: 8px 0 0;
            color: var(--p3m-muted);
            font-size: 13.5px;
            line-height: 1.65;
        }

        .auth-input-group {
            margin-bottom: 14px;
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
            margin-top: -7px;
            margin-bottom: 11px;
            color: #dc2626;
            font-size: 13px;
            font-weight: 650;
        }

        .btn-register {
            width: 100%;
            height: 47px;
            margin-top: 8px;
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

        .btn-register:hover {
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

        .login-copy {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login-icon {
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

        .login-secondary span:not(.login-icon) {
            display: block;
            margin-top: 2px;
            color: var(--p3m-muted);
            font-size: 11.7px;
            line-height: 1.35;
        }

        .login-btn {
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

        .login-btn:hover {
            background: var(--p3m-blue);
            border-color: var(--p3m-blue);
            color: #ffffff;
        }

        .register-art-side {
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

        .register-art-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, .075), transparent 36%),
                radial-gradient(circle at 88% 12%, rgba(213, 167, 47, .16), transparent 30%);
            z-index: -2;
        }

        .register-art-side::after {
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
            .register-card {
                max-width: 520px;
                min-height: auto;
                margin: 0 auto;
                grid-template-columns: 1fr;
            }

            .register-form-side {
                padding: 42px 36px 36px;
            }

            .register-form-side .brand-inline,
            .register-form-side .register-title,
            .register-form-side form,
            .register-form-side .back-login {
                max-width: 100%;
            }

            .register-art-side {
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

            .register-card {
                border-radius: 24px;
            }

            .register-form-side {
                padding: 32px 22px 28px;
            }

            .register-title h1 {
                font-size: 29px;
            }

            .register-art-side {
                display: none;
            }

            .login-secondary {
                align-items: stretch;
                flex-direction: column;
            }

            .login-btn {
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
    <main class="register-wrapper">
        <section class="register-card">
            <div class="register-form-side">
                <a href="{{ route('tampilan') }}" class="brand-inline">
                    <img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M Polibang">
                    <span>P3M Polibang</span>
                </a>

                <div class="register-title">
                    <h1>Register P3M</h1>
                    <p>Buat akun P3M khusus dosen Politeknik Balekambang Jepara.</p>
                </div>

                <form action="{{ route('proses-register') }}" method="post">
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
                        <label class="form-label-custom" for="email">Email</label>
                        <div class="input-group">
                            <input id="email" type="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" autocomplete="email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <small class="auth-error">{{ $message }}</small>
                    @enderror

                    <div class="auth-input-group">
                        <label class="form-label-custom" for="password">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan password" autocomplete="new-password">
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

                    <button type="submit" class="btn-register">
                        Daftar Akun
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>

                    <div class="login-secondary">
                        <div class="login-copy">
                            <span class="login-icon">
                                <i class="fas fa-sign-in-alt"></i>
                            </span>
                            <div>
                                <strong>Sudah punya akun?</strong>
                                <span>Masuk ke portal pengelola atau dosen.</span>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="login-btn">Login</a>
                    </div>
                </form>
            </div>

            <aside class="register-art-side">
                <div class="art-badge">
                    <i class="fas fa-user-plus"></i>
                    Registrasi Dosen
                </div>

                <div class="art-content">
                    <h2>Mulai<br>Bergabung</h2>
                    <p>Daftarkan akun dosen untuk mengakses layanan pengelolaan data P3M Politeknik Balekambang Jepara.</p>
                </div>

                <div class="art-tags">
                    <span class="art-tag">
                        <i class="fas fa-check"></i>
                        Akun dosen
                    </span>
                    <span class="art-tag">
                        <i class="fas fa-lock"></i>
                        Data aman
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
