<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    @php
        // Resolusi judul halaman secara konsisten untuk SERP & Social Graph
        if (View::hasSection('title')) {
            $seoTitle = trim(View::getSection('title'));
        } elseif (isset($pagetitle) && request()->routeIs('tampilan') === false) {
            $seoTitle = trim($pagetitle);
        } else {
            $seoTitle = '';
        }

        $siteBrand = 'P3M Politeknik Balekambang Jepara';
        if ($seoTitle !== '') {
            $fullTitle = str_contains($seoTitle, 'P3M') ? $seoTitle . ' - Politeknik Balekambang Jepara' : $seoTitle . ' - ' . $siteBrand;
        } else {
            $fullTitle = 'P3M POLIBANG - Pusat Penelitian dan Pengabdian Masyarakat Politeknik Balekambang Jepara';
        }

        $defaultDescription = 'Pusat Penelitian dan Pengabdian Kepada Masyarakat (P3M) Politeknik Balekambang Jepara memfasilitasi riset inovatif, hilirisasi pengabdian masyarakat, dan publikasi jurnal ilmiah.';
        $seoDescription = View::hasSection('meta_description') ? trim(View::getSection('meta_description')) : $defaultDescription;
        $seoKeywords = View::hasSection('meta_keywords') ? trim(View::getSection('meta_keywords')) : 'P3M Polibang, Penelitian Dosen, Pengabdian Masyarakat, Jurnal Polibang, Riset Politeknik Balekambang Jepara';
        $seoCanonical = View::hasSection('canonical') ? trim(View::getSection('canonical')) : request()->url();
        $seoImage = View::hasSection('og_image') ? trim(View::getSection('og_image')) : asset('mte/assets/img/clients/polibang.png');
        $seoType = View::hasSection('og_type') ? trim(View::getSection('og_type')) : 'website';
    @endphp

    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="author" content="P3M Politeknik Balekambang Jepara">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <link rel="canonical" href="{{ $seoCanonical }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:site_name" content="{{ $siteBrand }}">
    <meta property="og:locale" content="id_ID">
    @yield('og_extra')

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $seoCanonical }}">
    <meta name="twitter:title" content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    <!-- Structured Data (JSON-LD Organization & WebSite) -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@graph": [
        {
          "@type": "EducationalOrganization",
          "@id": "{{ url('/') }}#organization",
          "name": "P3M Politeknik Balekambang Jepara",
          "url": "{{ url('/') }}",
          "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('mte/assets/img/clients/polibang.png') }}",
            "width": 192,
            "height": 192
          },
          "description": "Pusat Penelitian dan Pengabdian Kepada Masyarakat Politeknik Balekambang Jepara.",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Gemiring, Nalumsari",
            "addressLocality": "Jepara",
            "addressRegion": "Jawa Tengah",
            "postalCode": "59466",
            "addressCountry": "ID"
          },
          "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+62-3301-90210",
            "contactType": "Customer Support",
            "email": "p3mpolibang@gmail.com"
          },
          "parentOrganization": {
            "@type": "CollegeOrUniversity",
            "name": "Politeknik Balekambang Jepara",
            "url": "https://polibang.ac.id"
          }
        },
        {
          "@type": "WebSite",
          "@id": "{{ url('/') }}#website",
          "url": "{{ url('/') }}",
          "name": "P3M Politeknik Balekambang Jepara",
          "description": "Pusat Penelitian dan Pengabdian Kepada Masyarakat",
          "publisher": {
            "@id": "{{ url('/') }}#organization"
          },
          "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ route('tampilan.berita') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
          },
          "inLanguage": "id-ID"
        }
      ]
    }
    </script>
    @yield('schema')

    <link href="{{ asset('mte/assets/img/icon_log.ico') }}" rel="icon">
    <link href="{{ asset('mte/assets/img/icon_log.ico') }}" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>

    <!-- Preload Critical LCP Hero Image -->
    @hasSection('preload')
        @yield('preload')
    @elseif(request()->routeIs('tampilan'))
        <link rel="preload" as="image" href="{{ asset('mte/assets/img/banner-p3m.webp') }}" type="image/webp" fetchpriority="high">
    @else
        <link rel="preload" as="image" href="{{ asset('mte/assets/img/polibang-mobile.webp') }}" type="image/webp" media="(max-width: 768px)" fetchpriority="high">
        <link rel="preload" as="image" href="{{ asset('mte/assets/img/polibang.webp') }}" type="image/webp" media="(min-width: 769px)" fetchpriority="high">
    @endif

    <!-- Core Layout Styles -->
    <link href="{{ asset('mte/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('mte/assets/css/main.css') }}?v={{ filemtime(public_path('mte/assets/css/main.css')) }}" rel="stylesheet">

    <!-- Non-Blocking Google Fonts & Secondary Stylesheets -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap"
        media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap">
    </noscript>

    <link rel="stylesheet" href="{{ asset('mte/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('mte/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    </noscript>

    <link rel="stylesheet" href="{{ asset('mte/assets/vendor/aos/aos.css') }}" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('mte/assets/vendor/aos/aos.css') }}">
    </noscript>

    <link rel="stylesheet" href="{{ asset('mte/assets/vendor/swiper/swiper-bundle.min.css') }}" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('mte/assets/vendor/swiper/swiper-bundle.min.css') }}">
    </noscript>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </noscript>

    @stack('styles')

    <style>
@media (max-width:991.98px){.header-mobile{display:block !important;min-height:64px;background:#ffffff;border-bottom:1px solid #f1f5f9;box-shadow:0 1px 3px rgba(15,23,42,0.03);position:relative;z-index:1060;padding:0 20px}.header-mobile .container-fluid{padding:0 !important;margin:0 !important;max-width:100% !important}.mobile-header-inner{height:64px;display:flex;align-items:center;justify-content:space-between;width:100%}.mobile-brand{display:inline-flex;align-items:center;gap:12px;text-decoration:none}.mobile-brand-logo{width:40px;height:40px;border-radius:50%;background:#ecfdf5;border:1px solid #a7f3d0;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 6px rgba(5,150,105,0.12)}.mobile-brand-logo img{width:26px;height:26px;object-fit:contain}.mobile-brand-meta{display:flex;flex-direction:column;gap:1px}.mobile-brand-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:#0f172a;letter-spacing:-0.01em;line-height:1.2}.mobile-brand-sub{font-family:'Inter',sans-serif;font-size:11px;color:#64748b;font-weight:500;letter-spacing:0.01em;line-height:1.2}.mobile-header-actions{display:flex;align-items:center;gap:8px}.mobile-action-btn{width:40px;height:40px;border-radius:50%;border:1px solid #e2e8f0;background:#ffffff;color:#1e293b;display:inline-flex;align-items:center;justify-content:center;font-size:18px;cursor:pointer;transition:all 0.22s cubic-bezier(0.16,1,0.3,1)}.mobile-action-btn:hover{background:#f8fafc;color:#059669;border-color:#cbd5e1}.mobile-action-btn:active{transform:scale(0.94)}.mobile-action-btn.mobile-drawer-toggle{font-size:22px}.mobile-action-btn.mobile-drawer-toggle.is-active{width:40px;height:40px;background:#059669;border-color:#059669;color:#ffffff;font-size:19px;box-shadow:0 4px 12px rgba(5,150,105,0.35);transform:none}.mobile-search-expand{display:none;padding:0 0 12px;animation:slideDown 0.2s ease-out forwards}.mobile-search-expand.show{display:block}@keyframes slideDown{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}.mobile-search-form{position:relative;display:flex;align-items:center;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;padding:5px 12px}.mobile-search-form .search-icon{color:#94a3b8;font-size:14px;margin-right:8px}.mobile-search-form input{border:none;background:transparent;font-size:13.5px;color:#0f172a;width:100%;outline:none;padding:6px 0;font-family:'Plus Jakarta Sans',sans-serif}.mobile-search-form .search-close-btn{background:none;border:none;color:#94a3b8;font-size:16px;padding:0 4px;cursor:pointer}.mobile-collapse-menu{display:none;position:absolute;top:100%;left:0;right:0;width:100%;background-color:#ffffff !important;border-top:1px solid #f8fafc;border-bottom:1px solid #e2e8f0;box-shadow:0 20px 30px rgba(15,23,42,0.08);padding:24px 20px 32px 20px;max-height:calc(100vh - 64px);overflow-y:auto;-webkit-overflow-scrolling:touch;z-index:1060}.mobile-collapse-menu.show{display:block;animation:collapseSlideDown 0.18s cubic-bezier(0.16,1,0.3,1) forwards}@keyframes collapseSlideDown{from{transform:translateY(-6px)}to{transform:translateY(0)}}.mobile-nav-wrap{display:block}.mobile-nav-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:22px}.mobile-nav-item{width:100%}.mobile-nav-link,.mobile-nav-parent{position:relative;display:flex;align-items:center;justify-content:space-between;padding:2px 0 2px 22px;font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:#2b3649;text-decoration:none;background:transparent;cursor:pointer;border:none;width:100%;text-align:left;transition:color 0.18s ease}.mobile-nav-link:hover,.mobile-nav-parent:hover{color:#059669}.mobile-nav-link.active,.mobile-nav-parent.active{color:#059669 !important;font-weight:700 !important}.mobile-nav-link.active::before,.mobile-nav-parent.active::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:3.5px;height:22px;background-color:#059669;border-radius:4px}.mobile-nav-parent .arrow-icon{color:#94a3b8;font-size:14px;margin-right:4px;transition:transform 0.22s cubic-bezier(0.16,1,0.3,1),color 0.2s}.mobile-nav-parent.active .arrow-icon{color:#059669}.mobile-nav-item.is-open .arrow-icon{transform:rotate(180deg);color:#059669}.mobile-nav-item.is-open>.mobile-nav-parent{color:#059669}.mobile-subnav-list{display:none;list-style:none;margin:12px 0 4px 22px;padding:2px 0 2px 14px;border-left:2px solid #e2e8f0}.mobile-nav-item.is-open .mobile-subnav-list{display:flex;flex-direction:column;gap:14px;animation:subnavFade 0.2s ease forwards}@keyframes subnavFade{from{opacity:0;transform:translateY(-3px)}to{opacity:1;transform:translateY(0)}}.mobile-subnav-list a{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px;font-weight:600;color:#64748b;text-decoration:none;transition:color 0.15s ease}.mobile-subnav-list a:hover{color:#059669}.mobile-subnav-list a.active{color:#059669;font-weight:700}}@media (min-width:992px){.header-mobile,.mobile-collapse-menu{display:none !important}}.scroll-top{background-color:#059669 !important;box-shadow:0 8px 24px rgba(5,150,105,0.3) !important}.scroll-top:hover{background-color:#047857 !important;color:#ffffff !important}
</style>
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
                        <img src="{{ asset('mte/assets/img/Pusat_Penelitian.webp') }}" alt="Logo P3M Polibang" width="34" height="32" fetchpriority="high">
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
            <div class="container-fluid px-3">
                <div class="mobile-header-inner">
                    <a href="{{ route('tampilan') }}" class="mobile-brand">
                        <div class="mobile-brand-logo">
                            <img src="{{ asset('mte/assets/img/Pusat_Penelitian.webp') }}" alt="Logo P3M Polibang" width="26" height="25" fetchpriority="high">
                        </div>
                        <div class="mobile-brand-meta">
                            <span class="mobile-brand-title">P3M POLIBANG</span>
                            <span class="mobile-brand-sub">Politeknik Balekambang</span>
                        </div>
                    </a>

                    <div class="mobile-header-actions">
                        <button class="mobile-action-btn mobile-search-toggle" type="button" aria-label="Buka pencarian" id="mobileSearchToggle">
                            <i class="bi bi-search"></i>
                        </button>
                        <button class="mobile-action-btn mobile-drawer-toggle" type="button" aria-label="Buka menu navigasi" id="mobileNavToggleBtn">
                            <i class="bi bi-list" id="mobileNavToggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Dropdown Search on Mobile -->
                <div class="mobile-search-expand" id="mobileSearchExpand">
                    <form class="mobile-search-form" action="{{ route('tampilan.berita') }}" method="GET">
                        <i class="bi bi-search search-icon"></i>
                        <input type="search" name="q" placeholder="Cari info penelitian, jurnal, panduan..." aria-label="Cari info P3M">
                        <button type="button" class="search-close-btn" id="mobileSearchClose" aria-label="Tutup pencarian">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- DROPDOWN COLLAPSE MENU UNDER NAVBAR -->
            <div class="mobile-collapse-menu" id="mobileCollapseMenu">
                <nav class="mobile-nav-wrap">
                    <ul class="mobile-nav-list">
                        <li class="mobile-nav-item">
                            <a href="{{ route('tampilan') }}" class="mobile-nav-link {{ request()->routeIs('tampilan') ? 'active' : '' }}">
                                <span class="nav-text">Beranda</span>
                            </a>
                        </li>

                        <li class="mobile-nav-item has-dropdown">
                            <div class="mobile-nav-parent {{ request()->routeIs('tampilan.tentangp3m', 'tampilan.struktur', 'tampilan.panduan*') ? 'active' : '' }}">
                                <span class="nav-text">Profil P3M</span>
                                <i class="bi bi-chevron-down arrow-icon"></i>
                            </div>
                            <ul class="mobile-subnav-list">
                                <li><a href="{{ route('tampilan.tentangp3m') }}" class="{{ request()->routeIs('tampilan.tentangp3m') ? 'active' : '' }}">Tentang P3M</a></li>
                                <li><a href="{{ route('tampilan.struktur') }}" class="{{ request()->routeIs('tampilan.struktur') ? 'active' : '' }}">Struktur Organisasi P3M</a></li>
                                <li><a href="{{ route('tampilan.panduan') }}" class="{{ request()->routeIs('tampilan.panduan*') ? 'active' : '' }}">Panduan P3M</a></li>
                            </ul>
                        </li>

                        <li class="mobile-nav-item has-dropdown">
                            <div class="mobile-nav-parent {{ request()->routeIs('tampilan.penelitian', 'tampilan.pengabdian', 'tampilan.download_karya') ? 'active' : '' }}">
                                <span class="nav-text">Penelitian & Pengabdian</span>
                                <i class="bi bi-chevron-down arrow-icon"></i>
                            </div>
                            <ul class="mobile-subnav-list">
                                <li><a href="{{ route('tampilan.penelitian') }}" class="{{ request()->routeIs('tampilan.penelitian') ? 'active' : '' }}">Penelitian</a></li>
                                <li><a href="{{ route('tampilan.pengabdian') }}" class="{{ request()->routeIs('tampilan.pengabdian') ? 'active' : '' }}">Pengabdian</a></li>
                            </ul>
                        </li>

                        <li class="mobile-nav-item has-dropdown">
                            <div class="mobile-nav-parent {{ request()->routeIs('tampilan.berita', 'tampilan.detail', 'tampilan.agenda', 'tampilan.detailagenda', 'tampilan.dokumen') ? 'active' : '' }}">
                                <span class="nav-text">Seputar P3M</span>
                                <i class="bi bi-chevron-down arrow-icon"></i>
                            </div>
                            <ul class="mobile-subnav-list">
                                <li><a href="{{ route('tampilan.berita') }}" class="{{ request()->routeIs('tampilan.berita', 'tampilan.detail') ? 'active' : '' }}">Kegiatan P3M</a></li>
                                <li><a href="{{ route('tampilan.agenda') }}" class="{{ request()->routeIs('tampilan.agenda', 'tampilan.detailagenda') ? 'active' : '' }}">Berita P3M</a></li>
                                <li><a href="{{ route('tampilan.dokumen') }}" class="{{ request()->routeIs('tampilan.dokumen') ? 'active' : '' }}">Dokumen P3M</a></li>
                            </ul>
                        </li>

                        <li class="mobile-nav-item has-dropdown">
                            <div class="mobile-nav-parent {{ request()->routeIs('tampilan.jurnal') ? 'active' : '' }}">
                                <span class="nav-text">Jurnal P3M</span>
                                <i class="bi bi-chevron-down arrow-icon"></i>
                            </div>
                            <ul class="mobile-subnav-list">
                                <li><a href="{{ route('tampilan.jurnal') }}" class="{{ request()->routeIs('tampilan.jurnal') ? 'active' : '' }}">List Jurnal P3M</a></li>
                                <li><a href="https://www.polibang.ac.id/maktab" target="_blank" rel="noopener noreferrer">Jurnal Maktab</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- DESKTOP NAVIGATION (100% Original Desktop Layout & Styles) -->
        <nav id="navmenu" class="navmenu d-none d-lg-block">
            <div class="container-xl">
                <ul>
                    <li>
                        <a href="{{ route('tampilan') }}" class="{{ request()->routeIs('tampilan') ? 'active' : '' }}">Beranda</a>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="{{ request()->routeIs('tampilan.tentangp3m', 'tampilan.struktur', 'tampilan.panduan*') ? 'active' : '' }}">
                            <span>Profil P3M</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="{{ route('tampilan.tentangp3m') }}" class="{{ request()->routeIs('tampilan.tentangp3m') ? 'active' : '' }}">Tentang P3M</a></li>
                            <li><a href="{{ route('tampilan.struktur') }}" class="{{ request()->routeIs('tampilan.struktur') ? 'active' : '' }}">Struktur Organisasi P3M</a></li>
                            <li><a href="{{ route('tampilan.panduan') }}" class="{{ request()->routeIs('tampilan.panduan*') ? 'active' : '' }}">Panduan P3M</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="{{ request()->routeIs('tampilan.penelitian', 'tampilan.pengabdian', 'tampilan.download_karya') ? 'active' : '' }}">
                            <span>Penelitian & Pengabdian</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="{{ route('tampilan.penelitian') }}" class="{{ request()->routeIs('tampilan.penelitian') ? 'active' : '' }}">Penelitian</a></li>
                            <li><a href="{{ route('tampilan.pengabdian') }}" class="{{ request()->routeIs('tampilan.pengabdian') ? 'active' : '' }}">Pengabdian</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="{{ request()->routeIs('tampilan.berita', 'tampilan.detail', 'tampilan.agenda', 'tampilan.detailagenda', 'tampilan.dokumen') ? 'active' : '' }}">
                            <span>Seputar P3M</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="{{ route('tampilan.berita') }}" class="{{ request()->routeIs('tampilan.berita', 'tampilan.detail') ? 'active' : '' }}">Kegiatan P3M</a></li>
                            <li><a href="{{ route('tampilan.agenda') }}" class="{{ request()->routeIs('tampilan.agenda', 'tampilan.detailagenda') ? 'active' : '' }}">Berita P3M</a></li>
                            <li><a href="{{ route('tampilan.dokumen') }}" class="{{ request()->routeIs('tampilan.dokumen') ? 'active' : '' }}">Dokumen P3M</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="{{ request()->routeIs('tampilan.jurnal') ? 'active' : '' }}">
                            <span>Jurnal P3M</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="{{ route('tampilan.jurnal') }}" class="{{ request()->routeIs('tampilan.jurnal') ? 'active' : '' }}">List Jurnal P3M</a></li>
                            <li><a href="https://www.polibang.ac.id/maktab" target="_blank" rel="noopener noreferrer">Jurnal Maktab</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="main">
        @yield('isi')
    </main>

    <style>
@media (max-width:767px){.footer-mobile-only{padding-top:20px;text-align:center}.footer-mobile-brand{display:flex;flex-direction:column;align-items:center;gap:12px;margin-bottom:30px;text-decoration:none}.footer-mobile-brand span{font-family:"Plus Jakarta Sans",sans-serif;font-size:1.6rem;font-weight:800;color:#ffffff;letter-spacing:-0.02em}.footer-mobile-social{display:flex;justify-content:center;gap:30px;margin-bottom:40px}.footer-mobile-social a{color:#ffffff;font-size:22px;transition:color 0.2s ease,transform 0.2s ease}.footer-mobile-social a:hover{color:#94a3b8;transform:scale(1.1)}.footer-mobile-menus{max-width:100%;margin:0 auto 30px}.footer-mobile-menus details{border-bottom:none;margin-bottom:15px}.footer-mobile-menus summary{list-style:none;display:flex;justify-content:center;align-items:center;gap:8px;font-size:12px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;cursor:pointer;padding:10px 0;color:#ffffff;transition:color 0.2s}.footer-mobile-menus summary::-webkit-details-marker{display:none}.footer-mobile-menus summary::after{content:'\F282';font-family:"bootstrap-icons";font-size:12px;transition:transform 0.3s ease}.footer-mobile-menus details[open] summary::after{transform:rotate(180deg)}.footer-mobile-menus details[open] summary{color:#94a3b8}.footer-mobile-content{padding:10px 0 20px;display:flex;flex-direction:column;gap:12px}.footer-mobile-content a,.footer-mobile-content p{color:#cbd5e1;text-decoration:none;font-size:13.5px;margin:0;transition:color 0.2s}.footer-mobile-content a:hover{color:#ffffff}.footer-mobile-divider{width:80%;height:1px;background-color:rgba(255,255,255,0.1);margin:0 auto 30px;border:none}.footer-mobile-bottom{display:flex;flex-direction:column;gap:24px;margin-bottom:40px}.footer-mobile-bottom a{color:#ffffff;text-decoration:none;font-size:11px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;transition:color 0.2s}.footer-mobile-bottom a:hover{color:#94a3b8}.footer-mobile-copy{font-size:11px;color:#64748b;letter-spacing:0.05em;text-transform:uppercase;padding-bottom:20px}}
</style>

    <footer id="footer" class="footer">
        <section id="clients" class="clients section">
            <div class="container" data-aos="zoom-in">
                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                        {
                            "loop": false,
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
                        <div class="swiper-slide"><img src="{{ asset('mte/assets/img/clients/polibang.webp') }}"
                                class="img-fluid" alt="Politeknik Balekambang Jepara" loading="lazy" width="69" height="80"></div>
                        <div class="swiper-slide"><img src="{{ asset('mte/assets/img/clients/ponpes.webp') }}"
                                class="img-fluid" alt="Pondok Pesantren Balekambang Jepara" loading="lazy" width="160" height="48"></div>
                        <div class="swiper-slide"><img
                                src="{{ asset('mte/assets/img/clients/Pusat_Penelitian.webp') }}" class="img-fluid"
                                alt="Pusat Penelitian dan Pengabdian Kepada Masyarakat P3M POLIBANG" loading="lazy" width="69" height="65"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- DESKTOP FOOTER (Original) -->
        <div class="d-none d-md-block">
            <div class="container footer-top">
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6 footer-about">
                        <a href="{{ route('tampilan') }}" class="footer-brand">
                            <img src="{{ asset('mte/assets/img/Pusat_Penelitian.webp') }}" alt="Logo Resmi P3M Politeknik Balekambang Jepara" width="44" height="44">
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
                            <li><a href="https://www.polibang.ac.id/" target="_blank"
                                    rel="noopener noreferrer">POLIBANG</a></li>
                            <li><a href="https://pmb.polibang.ac.id/" target="_blank" rel="noopener noreferrer">PMB
                                    POLIBANG</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-social">
                        <h4>Follow Us</h4>
                        <p>Kenali kami juga melalui media sosial.</p>
                        <div class="social-links d-flex">
                            <a href="#" target="_blank" aria-label="Twitter"><i
                                    class="bi bi-twitter-x"></i></a>
                            <a href="#" target="_blank" aria-label="Instagram"><i
                                    class="bi bi-instagram"></i></a>
                            <a href="#" target="_blank" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container copyright text-center">
                <p>© <span>Copyright</span> <strong class="px-1 sitename">P3M</strong> <span>Politeknik Balekambang
                        Jepara</span></p>
            </div>
        </div>

        <!-- MOBILE FOOTER (Allure Style) -->
        <div class="d-md-none footer-mobile-only">
            <div class="container">

                <!-- 1. Logo -->
                <a href="{{ route('tampilan') }}" class="footer-mobile-brand">
                    <span>P3M Polibang</span>
                </a>

                <!-- 2. Social Icons -->
                <div class="footer-mobile-social">
                    <a href="#" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" target="_blank" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" target="_blank" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                </div>

                <!-- 3. Collapsible Menus (Accordions) -->
                <div class="footer-mobile-menus">
                    <details>
                        <summary>Menu Cepat</summary>
                        <div class="footer-mobile-content">
                            <a href="{{ route('tampilan') }}">Beranda</a>
                            <a href="{{ route('tampilan.berita') }}">Kegiatan P3M</a>
                            <a href="{{ route('tampilan.agenda') }}">Berita P3M</a>
                            <a href="{{ route('tampilan.dokumen') }}">Dokumen P3M</a>
                        </div>
                    </details>

                    <details>
                        <summary>Hubungi Kami</summary>
                        <div class="footer-mobile-content">
                            <p>Politeknik Balekambang Jepara</p>
                            <p>Gemiring, Nalumsari, Jepara</p>
                            <p>Phone: +62 3301 90210</p>
                            <p>Email: p3mpolibang@gmail.com</p>
                        </div>
                    </details>
                </div>

                <!-- 4. Divider -->
                <hr class="footer-mobile-divider">

                <!-- 5. Bottom Direct Links -->
                <div class="footer-mobile-bottom">
                    <a href="https://www.polibang.ac.id/" target="_blank" rel="noopener noreferrer">Polibang</a>
                    <a href="https://pmb.polibang.ac.id/" target="_blank" rel="noopener noreferrer">PMB Polibang</a>
                    <a href="{{ route('tampilan.tentangp3m') }}">Tentang P3M</a>
                </div>

                <!-- 6. Copyright -->
                <div class="footer-mobile-copy">
                    <p class="mb-0">© Copyright P3M Politeknik Balekambang Jepara</p>
                </div>

            </div>
        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"
        aria-label="Kembali ke atas">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Essential Scripts with Defer (Non-Blocking) -->
    <script src="{{ asset('mte/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('mte/assets/vendor/aos/aos.js') }}" defer></script>
    <script src="{{ asset('mte/assets/vendor/swiper/swiper-bundle.min.js') }}" defer></script>
    <script src="{{ asset('mte/assets/js/main.js') }}" defer></script>
    @stack('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mobile Search Toggle
        const searchToggle = document.getElementById('mobileSearchToggle');
        const searchExpand = document.getElementById('mobileSearchExpand');
        const searchClose = document.getElementById('mobileSearchClose');
        
        if (searchToggle && searchExpand) {
            searchToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                if (collapseMenu && collapseMenu.classList.contains('show')) {
                    collapseMenu.classList.remove('show');
                    if (navToggleBtn) navToggleBtn.classList.remove('is-active');
                    if (navToggleIcon) {
                        navToggleIcon.classList.remove('bi-x-lg');
                        navToggleIcon.classList.add('bi-list');
                    }
                }
                searchExpand.classList.toggle('show');
                if (searchExpand.classList.contains('show')) {
                    const input = searchExpand.querySelector('input');
                    if (input) input.focus();
                }
            });
        }
        if (searchClose && searchExpand) {
            searchClose.addEventListener('click', function() {
                searchExpand.classList.remove('show');
            });
        }

        // Mobile Dropdown Collapse Menu & Hamburger/Close Icon Toggle
        const headerMobile = document.querySelector('.header-mobile');
        const navToggleBtn = document.getElementById('mobileNavToggleBtn');
        const navToggleIcon = document.getElementById('mobileNavToggleIcon');
        const collapseMenu = document.getElementById('mobileCollapseMenu');

        if (navToggleBtn && collapseMenu) {
            navToggleBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                // Close search if open
                if (searchExpand && searchExpand.classList.contains('show')) {
                    searchExpand.classList.remove('show');
                }

                const isOpen = collapseMenu.classList.toggle('show');
                navToggleBtn.classList.toggle('is-active', isOpen);
                if (headerMobile) {
                    headerMobile.classList.toggle('is-open', isOpen);
                }

                if (navToggleIcon) {
                    if (isOpen) {
                        navToggleIcon.classList.remove('bi-list');
                        navToggleIcon.classList.add('bi-x-lg');
                    } else {
                        navToggleIcon.classList.remove('bi-x-lg');
                        navToggleIcon.classList.add('bi-list');
                    }
                }
            });

            // Close collapse menu when clicking outside
            document.addEventListener('click', function (e) {
                if (collapseMenu.classList.contains('show') && !collapseMenu.contains(e.target) && !navToggleBtn.contains(e.target)) {
                    collapseMenu.classList.remove('show');
                    navToggleBtn.classList.remove('is-active');
                    if (headerMobile) {
                        headerMobile.classList.remove('is-open');
                    }
                    if (navToggleIcon) {
                        navToggleIcon.classList.remove('bi-x-lg');
                        navToggleIcon.classList.add('bi-list');
                    }
                }
            });
        }

        // Submenu accordion in mobile drawer
        document.querySelectorAll('.mobile-nav-item.has-dropdown .mobile-nav-parent').forEach(function(parent) {
            parent.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const item = parent.closest('.mobile-nav-item');
                if (item) {
                    item.classList.toggle('is-open');
                }
            });
        });
    });
    </script>
</body>

</html>
