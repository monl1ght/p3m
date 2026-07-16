<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>P3M POLIBANG</title>
    <meta name="description" content="Pusat Penelitian dan Pengabdian Kepada Masyarakat Politeknik Balekambang Jepara">
    <meta name="keywords" content="P3M, Polibang, Penelitian, Pengabdian Masyarakat">

    <link href="{{ asset('mte/assets/img/icon_log.ico') }}" rel="icon">
    <link href="{{ asset('mte/assets/img/icon_log.ico') }}" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <link href="{{ asset('mte/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('mte/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('mte/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('mte/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('mte/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="{{ asset('mte/assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

    <header id="header" class="site-header fixed-top">
        <div class="header-top d-none d-lg-block">
            <div class="container-xl">
                <div class="header-top-grid">
                    <div class="header-social">
                        <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>

                    <a href="{{ route('tampilan') }}" class="brand-center">
                        <img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M Polibang">
                        <span>P3M Polibang</span>
                    </a>

                    <form class="header-search" action="{{ route('tampilan.berita') }}" method="GET">
                        <input type="search" name="q" placeholder="Saya mencari..." aria-label="Cari">
                        <button type="submit" aria-label="Cari"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="header-mobile d-lg-none">
            <div class="container-fluid">
                <div class="mobile-header-inner">
                    <button class="mobile-nav-toggle" type="button" aria-label="Buka menu">
                        <i class="bi bi-list"></i>
                    </button>

                    <a href="{{ route('tampilan') }}" class="mobile-brand">
                        <img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M Polibang">
                        <span>P3M Polibang</span>
                    </a>

                    <a href="{{ route('login') }}" class="mobile-login" aria-label="Login">
                        <i class="bi bi-person"></i>
                    </a>
                </div>
            </div>
        </div>

        <nav id="navmenu" class="navmenu">
            <div class="container-xl">
                <ul>
                    <li>
                        <a href="{{ route('tampilan') }}" class="{{ request()->routeIs('tampilan') ? 'active' : '' }}">Beranda</a>
                    </li>

                    <li class="dropdown">
                        <a href="#">
                            <span>Profil P3M</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="{{ route('tampilan.tentangp3m') }}">Tentang P3M</a></li>
                            <li><a href="{{ route('tampilan.struktur') }}">Struktur Organisasi P3M</a></li>
                            <li><a href="{{ route('tampilan.panduan') }}">Panduan P3M</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#">
                            <span>Seputar P3M</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="{{ route('tampilan.berita') }}" class="{{ request()->routeIs('tampilan.berita') ? 'active' : '' }}">Kegiatan P3M</a></li>
                            <li><a href="{{ route('tampilan.agenda') }}">Berita P3M</a></li>
                            <li><a href="{{ route('tampilan.dokumen') }}">Dokumen P3M</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#">
                            <span>Jurnal P3M</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="{{ route('tampilan.jurnal') }}">List Jurnal P3M</a></li>
                            <li><a href="https://www.polibang.ac.id/maktab" target="_blank" rel="noopener noreferrer">Jurnal Maktab</a></li>
                        </ul>
                    </li>

                    <li class="nav-login d-lg-none">
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </nav>

        <a class="desktop-login d-none d-lg-inline-flex" href="{{ route('login') }}">Login</a>
    </header>

    <main class="main">
        @yield('isi')
    </main>

    <footer id="footer" class="footer">
        <section id="clients" class="clients section">
            <div class="container" data-aos="zoom-in">
                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                        {
                            "loop": true,
                            "speed": 600,
                            "autoplay": {
                                "delay": 5000
                            },
                            "slidesPerView": "auto",
                            "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                            },
                            "breakpoints": {
                                "320": {
                                    "slidesPerView": 2,
                                    "spaceBetween": 40
                                },
                                "480": {
                                    "slidesPerView": 3,
                                    "spaceBetween": 60
                                },
                                "640": {
                                    "slidesPerView": 4,
                                    "spaceBetween": 80
                                },
                                "992": {
                                    "slidesPerView": 5,
                                    "spaceBetween": 120
                                },
                                "1200": {
                                    "slidesPerView": 6,
                                    "spaceBetween": 120
                                }
                            }
                        }
                    </script>
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide"><img src="{{ asset('mte/assets/img/clients/polibang.png') }}" class="img-fluid" alt="Polibang"></div>
                        <div class="swiper-slide"><img src="{{ asset('mte/assets/img/clients/ponpes.jpg') }}" class="img-fluid" alt="Pondok Pesantren"></div>
                        <div class="swiper-slide"><img src="{{ asset('mte/assets/img/clients/Pusat_Penelitian.png') }}" class="img-fluid" alt="P3M"></div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ route('tampilan') }}" class="footer-brand">
                        <img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M">
                        <span>P3M Polibang</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Politeknik Balekambang Jepara</p>
                        <p>Gemiring, Nalumsari, Jepara</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+62 3301 90210</span></p>
                        <p><strong>Email:</strong> <span>p3mpolibang@gmail.com</span></p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Menu Cepat</h4>
                    <ul>
                        <li><a href="{{ route('tampilan') }}">Beranda</a></li>
                        <li><a href="{{ route('tampilan.berita') }}">Kegiatan P3M</a></li>
                        <li><a href="{{ route('tampilan.agenda') }}">Berita P3M</a></li>
                        <li><a href="{{ route('tampilan.dokumen') }}">Dokumen P3M</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Kampus Kami</h4>
                    <ul>
                        <li><a href="https://www.polibang.ac.id/" target="_blank" rel="noopener noreferrer">POLIBANG</a></li>
                        <li><a href="https://pmb.polibang.ac.id/" target="_blank" rel="noopener noreferrer">PMB POLIBANG</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-social">
                    <h4>Follow Us</h4>
                    <p>Kenali kami juga melalui media sosial.</p>
                    <div class="social-links d-flex">
                        <a href="#" target="_blank" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" target="_blank" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container copyright text-center">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">P3M</strong> <span>Politeknik Balekambang Jepara</span></p>
        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" aria-label="Kembali ke atas">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <script src="{{ asset('mte/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('mte/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('mte/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('mte/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('mte/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('mte/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('mte/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('mte/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('mte/assets/js/main.js') }}"></script>

</body>

</html>
