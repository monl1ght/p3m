@extends('layout.views')

@section('title', 'Pusat Penelitian dan Pengabdian Kepada Masyarakat')
@section('meta_description',
    'P3M Politeknik Balekambang Jepara memfasilitasi riset terapan inovatif, publikasi jurnal
    ilmiah, hilirisasi pengabdian masyarakat, dan pedoman penelitian vokasi.')
@section('meta_keywords',
    'P3M POLIBANG, Politeknik Balekambang Jepara, Penelitian Terapan, Pengabdian Masyarakat,
    Jurnal Polibang, Riset Dosen')
@section('canonical', route('tampilan'))

@section('schema')
    <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "WebPage",
  "@id": "{{ route('tampilan') }}#webpage",
  "url": "{{ route('tampilan') }}",
  "name": "Pusat Penelitian dan Pengabdian Kepada Masyarakat - P3M Politeknik Balekambang Jepara",
  "description": "P3M Politeknik Balekambang Jepara memfasilitasi riset terapan inovatif, publikasi jurnal ilmiah, hilirisasi pengabdian masyarakat, dan pedoman penelitian vokasi.",
  "isPartOf": {
    "@id": "{{ url('/') }}#website"
  },
  "about": {
    "@id": "{{ url('/') }}#organization"
  },
  "inLanguage": "id-ID"
}
</script>
@endsection

@section('isi')
    @php
        $hero = $dash->first();
        $about = $tentang->first();
    @endphp

    {{-- ============================================================
     BERANDA P3M — Modern Responsive & Mobile-First Redesign
     ============================================================ --}}
    <style>
        :root {
            --primary-dark: #04261f;
            --primary: #064e3b;
            --primary-light: #059669;
            --accent: #059669;
            --accent-hover: #047857;
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #475569;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-lg: 0 10px 25px -3px rgba(0, 0, 0, 0.05), 0 4px 10px -2px rgba(0, 0, 0, 0.03);
            --shadow-xl: 0 20px 60px rgba(15, 23, 42, .08);
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-xl: 24px;
            --transition-smooth: all 0.35s cubic-bezier(0.16, 1, 0.3, 1)
        }

        body {
            background-color: var(--surface-alt);
            color: var(--text-main);
            overflow-x: hidden
        }

        #hero-p3m {
            position: relative;
            min-height: 580px;
            height: clamp(580px, 52vw, 720px);
            display: flex;
            align-items: center;
            overflow: hidden;
            background-color: var(--primary-dark);
            isolation: isolate
        }

        #hero-p3m .hero-bg-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            z-index: 0
        }

        #hero-p3m::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(100deg, rgba(4, 38, 31, .96) 0%, rgba(4, 38, 31, .84) 38%, rgba(4, 38, 31, .45) 60%, rgba(4, 38, 31, .05) 85%)
        }

        #hero-p3m .container {
            position: relative;
            z-index: 2
        }

        .hero-content {
            max-width: 760px;
            position: relative;
        }

        @media (min-width: 992px) {
            .hero-content {
                top: -35px;
            }
        }

        @media (min-width: 1200px) {
            .hero-content {
                top: -50px;
            }
        }


        .hero-eyebrow-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: #a7f3d0;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1)
        }

        .eyebrow-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 10px #10b981
        }

        #hero-p3m h1 {
            color: #ffffff;
            font-family: "Plus Jakarta Sans", "Inter", sans-serif;
            font-size: clamp(2.2rem, 3.8vw, 3.6rem);
            font-weight: 800;
            line-height: 1.18;
            letter-spacing: -0.03em;
            max-width: 700px;
            margin: 0 0 20px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.35)
        }

        #hero-p3m .hero-sub {
            color: rgba(255, 255, 255, 0.88);
            font-size: clamp(1rem, 1.2vw, 1.15rem);
            line-height: 1.7;
            max-width: 600px;
            margin: 0 0 36px;
            font-weight: 400
        }

        .hero-actions-p3m {
            display: flex;
            flex-wrap: wrap;
            gap: 16px
        }

        .hero-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            background: var(--accent);
            border: 1px solid var(--accent);
            color: #fff;
            border-radius: var(--radius-md);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 15px;
            font-weight: 700;
            transition: var(--transition-smooth);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
            text-decoration: none
        }

        .hero-btn-primary:hover,
        .hero-btn-primary:active {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(5, 150, 105, 0.4)
        }

        .hero-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            border-radius: var(--radius-md);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 15px;
            font-weight: 700;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: var(--transition-smooth);
            text-decoration: none
        }

        .hero-btn-secondary:hover,
        .hero-btn-secondary:active {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.5);
            color: #fff;
            transform: translateY(-3px)
        }

        .quick-wrap {
            padding: 0;
            margin-top: -55px;
            position: relative;
            z-index: 10
        }

        .quick-panel {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: var(--radius-xl);
            padding: 28px 36px;
            box-shadow: var(--shadow-xl)
        }

        .quick-item {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 18px;
            border-radius: var(--radius-lg);
            text-decoration: none;
            color: var(--text-main);
            transition: var(--transition-smooth);
            height: 100%;
            background: transparent;
            border: 1px solid transparent
        }

        .quick-item:hover {
            background: var(--surface);
            border-color: var(--border-color);
            box-shadow: var(--shadow-md);
            transform: translateY(-4px)
        }

        .quick-icon-wrap {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-md);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
            transition: var(--transition-smooth)
        }

        .quick-icon-blue,
        .quick-icon-forest {
            background: #ecfdf5;
            color: #047857
        }

        .quick-icon-emerald {
            background: #ecfdf5;
            color: #047857
        }

        .quick-icon-amber {
            background: #fffbeb;
            color: #d97706
        }

        .quick-icon-purple {
            background: #f5f3ff;
            color: #7c3aed
        }

        .quick-item:hover .quick-icon-wrap {
            transform: scale(1.08)
        }

        .quick-label h2,
        .quick-label h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -0.01em;
            line-height: 1.3;
            color: var(--text-main)
        }

        .quick-label p {
            margin: 4px 0 0;
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.4;
            font-weight: 500
        }

        .about-section {
            background: var(--surface);
            padding: 110px 0;
            position: relative
        }

        .about-img-wrap {
            border-radius: var(--radius-xl);
            overflow: hidden;
            position: relative;
            box-shadow: var(--shadow-xl)
        }

        .about-img-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: var(--radius-xl);
            border: 1px solid rgba(255, 255, 255, 0.2);
            pointer-events: none
        }

        .about-img-wrap img {
            width: 100%;
            height: 540px;
            object-fit: cover;
            display: block;
            transition: var(--transition-smooth)
        }

        .about-img-wrap:hover img {
            transform: scale(1.03)
        }

        .about-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #047857;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            margin-bottom: 18px
        }

        .about-label::before {
            content: "";
            width: 36px;
            height: 2px;
            border-radius: 4px;
            background: #059669
        }

        .about-heading {
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: clamp(2rem, 2.8vw, 2.75rem);
            font-weight: 800;
            line-height: 1.18;
            letter-spacing: -0.03em;
            color: var(--text-main);
            margin: 0 0 20px
        }

        .about-body {
            color: var(--text-muted);
            font-size: 15.5px;
            line-height: 1.8;
            margin: 0 0 36px;
            text-align: justify !important;
            text-justify: inter-word !important
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px
        }

        .stat-box {
            background: var(--surface-alt);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 28px 20px;
            box-shadow: var(--shadow-sm);
            text-align: center;
            transition: var(--transition-smooth)
        }

        .stat-box:hover {
            background: var(--surface);
            border-color: #047857;
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px)
        }

        .stat-number {
            display: block;
            color: var(--primary);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 2.6rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1
        }

        .stat-label {
            display: block;
            margin-top: 10px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase
        }

        .sec-header {
            text-align: center;
            margin-bottom: 56px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto
        }

        .sec-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #047857;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            margin-bottom: 14px
        }

        .sec-label::before,
        .sec-label::after {
            content: "";
            width: 28px;
            height: 2px;
            border-radius: 4px;
            background: #059669;
            opacity: 0.5
        }

        .sec-title {
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: clamp(1.85rem, 2.4vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--text-main);
            margin: 0 0 14px
        }

        .sec-subtitle {
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.65;
            margin: 0
        }

        .berita-section {
            background: var(--surface-alt);
            padding: 100px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.02)
        }

        .berita-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 36px 28px;
            height: 100%;
            transition: var(--transition-smooth);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            text-decoration: none;
            color: var(--text-main)
        }

        .berita-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #059669;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease
        }

        .berita-card:hover::before {
            transform: scaleX(1)
        }

        .berita-card:hover {
            border-color: transparent;
            box-shadow: var(--shadow-lg);
            transform: translateY(-6px);
            color: var(--text-main)
        }

        .berita-icon {
            width: 54px;
            height: 54px;
            border-radius: var(--radius-md);
            background: var(--surface-alt);
            color: #047857;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
            flex-shrink: 0;
            transition: var(--transition-smooth)
        }

        .berita-card:hover .berita-icon {
            background: #059669;
            color: #fff
        }

        .berita-date {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #047857;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px
        }

        .berita-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.45;
            margin: 0;
            flex: 1
        }

        .berita-card:hover .berita-title {
            color: #047857
        }

        .cta-section {
            position: relative;
            overflow: hidden;
            padding: 90px 0;
            background: var(--primary);
            isolation: isolate
        }

        .cta-section .cta-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.12;
            z-index: 0;
            mix-blend-mode: luminosity
        }

        .cta-section::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(2, 44, 34, 0.96), rgba(6, 78, 59, 0.88));
            z-index: 1
        }

        .cta-section .container {
            position: relative;
            z-index: 2
        }

        .cta-section h2,
        .cta-section h3 {
            color: #fff;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: clamp(1.85rem, 2.3vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            margin: 0 0 14px
        }

        .cta-section p {
            color: rgba(255, 255, 255, 0.88);
            margin: 0;
            font-size: 16px;
            line-height: 1.7;
            max-width: 600px
        }

        .cta-btn-p3m {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 34px;
            background: var(--accent);
            color: #fff;
            border-radius: var(--radius-md);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 15px;
            font-weight: 700;
            transition: var(--transition-smooth);
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3)
        }

        .cta-btn-p3m:hover {
            background: var(--accent-hover);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(5, 150, 105, 0.4)
        }

        .kegiatan-section {
            background: var(--surface);
            padding: 100px 0
        }

        .premium-news-card {
            display: flex;
            flex-direction: column;
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
            transition: var(--transition-smooth)
        }

        .premium-news-card:hover {
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
            transform: translateY(-4px);
            border-color: #cbd5e1
        }

        .news-card-img-wrap {
            position: relative;
            width: 100%;
            height: 220px;
            background-color: #e2e8f0;
            overflow: hidden
        }

        .news-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease
        }

        .premium-news-card:hover .news-card-img-wrap img {
            transform: scale(1.05)
        }

        .news-card-body {
            padding: 28px 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1
        }

        .news-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 14px
        }

        .news-meta i {
            color: #047857;
            font-size: 14px
        }

        .news-card-body h3 {
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.4;
            margin: 0 0 14px;
            letter-spacing: -0.01em;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden
        }

        .news-card-body h3 a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s
        }

        .news-card-body h3 a:hover {
            color: #047857
        }

        .news-card-body p {
            font-size: 14.5px;
            line-height: 1.65;
            color: var(--text-muted);
            margin: 0 0 24px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden
        }

        .news-card-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .btn-read-more {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #047857;
            text-decoration: none;
            transition: var(--transition-smooth)
        }

        .btn-read-more i {
            transition: transform 0.3s ease
        }

        .btn-read-more:hover {
            color: #047857
        }

        .btn-read-more:hover i {
            transform: translateX(4px)
        }

        .btn-outline-primary-p3m {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: transparent;
            border: 2px solid #059669;
            color: #047857;
            border-radius: var(--radius-md);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 15px;
            font-weight: 700;
            transition: var(--transition-smooth);
            text-decoration: none
        }

        .btn-outline-primary-p3m:hover {
            background: #059669;
            color: #fff;
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.2);
            transform: translateY(-2px)
        }

        .team-section {
            background: var(--surface-alt);
            padding: 100px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.02)
        }

        .premium-team-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 32px 24px 28px;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04), 0 1px 2px rgba(15, 23, 42, 0.02);
            transition: var(--transition-smooth);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center
        }

        .premium-team-card:hover {
            box-shadow: 0 16px 36px -4px rgba(5, 150, 105, 0.1), 0 4px 10px rgba(15, 23, 42, 0.03);
            transform: translateY(-4px);
            border-color: #a7f3d0
        }

        .team-avatar-wrap {
            width: 105px;
            height: 130px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            margin-bottom: 18px;
            flex-shrink: 0
        }

        .team-avatar-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 15%;
            display: block
        }

        .team-info {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1
        }

        .team-info h3,
        .team-info h4 {
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 6px 0;
            letter-spacing: -0.015em;
            line-height: 1.35
        }

        .team-role {
            font-size: 13px;
            font-weight: 600;
            color: #047857;
            line-height: 1.45;
            margin: 0 0 16px 0;
            max-width: 320px
        }

        .team-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: auto;
            padding-top: 4px
        }

        .team-meta {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 999px;
            white-space: nowrap
        }

        .team-meta i {
            color: #047857;
            font-size: 11px
        }

        .team-email-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #047857;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 999px;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap
        }

        .team-email-btn:hover {
            background: #059669;
            color: #ffffff;
            border-color: #047857;
            box-shadow: 0 3px 10px rgba(5, 150, 105, 0.25);
            transform: translateY(-1px)
        }

        .empty-state {
            text-align: center;
            padding: 60px 24px;
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px dashed var(--border-color);
            color: var(--text-light)
        }

        .empty-state i {
            font-size: 3rem;
            display: block;
            margin-bottom: 12px;
            color: #cbd5e1
        }

        .empty-state p {
            font-size: 15px;
            margin: 0
        }

        @media (max-width:991px) {
            #hero-p3m {
                height: auto;
                padding: 120px 0 80px;
                background-color: #064e3b
            }

            #hero-p3m::before {
                background: linear-gradient(180deg, rgba(6, 78, 59, 0.72) 0%, rgba(4, 56, 44, 0.58) 50%, rgba(3, 42, 33, 0.76) 100%) !important
            }

            .about-section,
            .berita-section,
            .kegiatan-section,
            .team-section,
            .cta-section {
                padding: 70px 0
            }
        }

        @media (max-width:767px) {
            #hero-p3m {
                min-height: 480px;
                height: auto;
                padding: 104px 0 64px;
                text-align: left;
                background-color: #064e3b
            }

            #hero-p3m::before {
                background: linear-gradient(180deg, rgba(6, 78, 59, 0.70) 0%, rgba(4, 54, 43, 0.50) 45%, rgba(3, 38, 30, 0.72) 100%) !important
            }

            #hero-p3m h1 {
                font-size: clamp(1.85rem, 7.2vw, 2.35rem);
                line-height: 1.22;
                margin-bottom: 14px;
                text-shadow: 0 2px 14px rgba(0, 0, 0, 0.45)
            }

            #hero-p3m .hero-sub {
                font-size: 14.5px;
                line-height: 1.6;
                margin-bottom: 24px;
                color: #ffffff;
                text-shadow: 0 1px 6px rgba(0, 0, 0, 0.35)
            }

            .hero-eyebrow-badge {
                font-size: 11px;
                padding: 6px 14px;
                margin-bottom: 16px
            }

            .hero-actions-p3m {
                flex-direction: column;
                gap: 12px;
                width: 100%
            }

            .hero-btn-primary,
            .hero-btn-secondary {
                width: 100%;
                justify-content: center;
                padding: 14px 20px;
                font-size: 15px;
                border-radius: 14px
            }

            .quick-wrap {
                margin-top: -30px
            }

            .quick-panel {
                padding: 14px 10px;
                border-radius: 18px
            }

            .quick-item {
                padding: 12px 6px;
                gap: 8px;
                border-radius: 12px;
                background: #f8fafc;
                border: 1px solid #edf2f7;
                flex-direction: column;
                text-align: center
            }

            .quick-icon-wrap {
                width: 44px;
                height: 44px;
                font-size: 20px;
                border-radius: 12px
            }

            .quick-label h2,
            .quick-label h3 {
                font-size: 13.5px;
                margin: 0
            }

            .quick-label p {
                font-size: 11px;
                margin: 2px 0 0
            }

            .about-section,
            .berita-section,
            .kegiatan-section,
            .team-section {
                padding: 52px 0
            }

            .cta-section {
                padding: 44px 0
            }

            .sec-header {
                margin-bottom: 30px
            }

            .sec-title {
                font-size: 1.6rem
            }

            .sec-subtitle {
                font-size: 13.5px
            }

            .about-img-wrap img {
                height: 220px;
                border-radius: 18px
            }

            .about-heading {
                font-size: 1.6rem;
                margin-bottom: 14px
            }

            .about-body {
                font-size: 14px;
                line-height: 1.65;
                margin-bottom: 22px;
                text-align: justify !important;
                text-justify: inter-word !important
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                margin-top: 24px
            }

            .stat-box {
                padding: 16px 10px;
                border-radius: 14px;
                background: #ffffff;
                border: 1px solid #e2e8f0
            }

            .stat-number {
                font-size: 1.75rem
            }

            .stat-label {
                font-size: 11px
            }

            .berita-card {
                flex-direction: row;
                align-items: center;
                padding: 14px 16px;
                border-radius: 16px;
                gap: 14px;
                text-decoration: none;
                color: var(--text-main)
            }

            .berita-card::before {
                display: none
            }

            .berita-card .berita-icon {
                width: 44px;
                height: 44px;
                border-radius: 12px;
                font-size: 18px;
                margin-bottom: 0;
                background: #ecfdf5;
                color: #047857;
                flex-shrink: 0
            }

            .berita-card-content {
                flex: 1;
                min-width: 0
            }

            .berita-card .berita-date {
                font-size: 11.5px;
                margin-bottom: 3px;
                color: #047857
            }

            .berita-card .berita-title {
                font-size: 14px;
                font-weight: 700;
                line-height: 1.4;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden
            }

            .berita-chevron {
                color: #94a3b8;
                font-size: 15px
            }

            .swipe-hint {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 11.5px;
                color: #475569;
                background: #f1f5f9;
                border: 1px solid #e2e8f0;
                padding: 5px 14px;
                border-radius: 999px;
                margin-top: 10px;
                font-weight: 600
            }

            .swipe-hint i {
                color: #047857;
                font-size: 13px
            }

            .kegiatan-mobile-carousel {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                justify-content: flex-start !important;
                align-items: stretch !important;
                overflow-x: auto !important;
                overflow-y: hidden !important;
                scroll-snap-type: x mandatory !important;
                scroll-padding-left: 16px !important;
                -webkit-overflow-scrolling: touch !important;
                touch-action: pan-x pan-y !important;
                gap: 16px !important;
                padding: 6px 16px 24px 16px !important;
                margin-left: -12px !important;
                margin-right: -12px !important;
                scrollbar-width: none !important;
                -ms-overflow-style: none !important
            }

            .kegiatan-mobile-carousel::-webkit-scrollbar {
                display: none !important;
                width: 0 !important;
                height: 0 !important
            }

            .kegiatan-card-col {
                flex: 0 0 82% !important;
                max-width: 82% !important;
                width: 82% !important;
                scroll-snap-align: start !important;
                scroll-snap-stop: normal !important;
                display: flex !important
            }

            .kegiatan-card-col[data-aos] {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important
            }

            .kegiatan-mobile-carousel .premium-news-card {
                width: 100% !important;
                height: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                border-radius: 20px !important;
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: 0 6px 20px rgba(15, 23, 42, 0.05) !important;
                overflow: hidden !important
            }

            .kegiatan-mobile-carousel .news-card-img-wrap {
                height: 175px !important;
                width: 100% !important
            }

            .kegiatan-mobile-carousel .news-card-img-wrap img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important
            }

            .kegiatan-mobile-carousel .news-card-body {
                padding: 18px 16px 20px !important;
                display: flex !important;
                flex-direction: column !important;
                flex-grow: 1 !important
            }

            .kegiatan-mobile-carousel .news-meta {
                font-size: 11.5px !important;
                color: #64748b !important;
                margin-bottom: 8px !important;
                gap: 6px !important
            }

            .kegiatan-mobile-carousel .news-card-body h3 {
                font-size: 15.5px !important;
                font-weight: 800 !important;
                margin-bottom: 8px !important;
                line-height: 1.38 !important;
                display: -webkit-box !important;
                -webkit-line-clamp: 2 !important;
                -webkit-box-orient: vertical !important;
                overflow: hidden !important
            }

            .kegiatan-mobile-carousel .news-card-body p {
                font-size: 13px !important;
                line-height: 1.55 !important;
                color: #64748b !important;
                margin-bottom: 16px !important;
                display: -webkit-box !important;
                -webkit-line-clamp: 2 !important;
                -webkit-box-orient: vertical !important;
                overflow: hidden !important
            }

            .kegiatan-mobile-carousel .news-card-footer {
                margin-top: auto !important;
                padding-top: 4px !important
            }

            .kegiatan-mobile-carousel .btn-read-more {
                font-size: 13.5px !important;
                font-weight: 700 !important;
                color: #047857 !important
            }

            .btn-outline-primary-p3m {
                width: 100%;
                justify-content: center;
                padding: 13px 20px;
                font-size: 14.5px
            }

            .premium-team-card {
                padding: 24px 18px 20px !important;
                border-radius: 18px !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important
            }

            .team-avatar-wrap {
                width: 92px !important;
                height: 118px !important;
                border-radius: 14px !important;
                margin-bottom: 14px !important;
                padding: 0 !important
            }

            .team-info {
                padding-right: 0 !important;
                align-items: center !important;
                text-align: center !important
            }

            .team-info h3,
            .team-info h4 {
                font-size: 16.5px !important;
                margin: 0 0 5px 0 !important;
                line-height: 1.3 !important;
                text-align: center !important
            }

            .team-role {
                font-size: 12.5px !important;
                margin: 0 0 14px 0 !important;
                line-height: 1.4 !important;
                text-align: center !important
            }

            .team-footer {
                gap: 8px !important;
                justify-content: center !important
            }

            .team-meta {
                font-size: 11.5px !important;
                padding: 5px 12px !important
            }

            .team-email-btn {
                position: static !important;
                font-size: 11.5px !important;
                padding: 5px 14px !important;
                width: auto !important;
                height: auto !important
            }

            .cta-section h2,
            .cta-section h3 {
                font-size: 1.6rem
            }

            .cta-section p {
                font-size: 14px;
                line-height: 1.6;
                margin-bottom: 18px
            }

            .cta-btn-p3m {
                width: 100%;
                justify-content: center;
                padding: 14px;
                border-radius: 14px
            }
        }
    </style>

    {{-- ================================================================
     1. HERO SECTION
     ================================================================ --}}
    <section id="hero-p3m">
        <picture>
            <source srcset="{{ asset('mte/assets/img/banner-p3m.webp') }}" type="image/webp">
            <img class="hero-bg-img" src="{{ asset('mte/assets/img/banner-p3m.jpg') }}"
                alt="Pusat Penelitian dan Pengabdian Kepada Masyarakat Politeknik Balekambang Jepara" fetchpriority="high"
                width="1600" height="800">
        </picture>

        <div class="container">
            <div class="hero-content" data-aos="fade-up" data-aos-duration="700">
                <div class="hero-eyebrow-badge">
                    <span class="eyebrow-dot"></span>
                    <span>Pusat Riset & Pengabdian Masyarakat</span>
                </div>

                <h1>
                    {{ $hero->title ?? 'Pusat Penelitian dan Pengabdian Kepada Masyarakat' }}
                </h1>

                @php
                    $heroSub = $hero->instansi ?? 'Politeknik Balekambang Jepara';
                    if (empty($heroSub) || strcasecmp(trim($heroSub), trim($hero->title ?? '')) === 0) {
                        $heroSub =
                            'Mengembangkan riset inovatif dan pengabdian aplikatif di lingkungan Politeknik Balekambang Jepara.';
                    }
                @endphp
                <p class="hero-sub">
                    {{ $heroSub }}
                </p>

                <div class="hero-actions-p3m">
                    <a href="{{ route('tampilan.dokumen') }}" class="hero-btn-primary">
                        <span>Dokumen P3M</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ route('tampilan.berita') }}" class="hero-btn-secondary">
                        <i class="bi bi-calendar-event"></i>
                        <span>Kegiatan Terbaru</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
     2. QUICK ACCESS
     ================================================================ --}}
    <div class="quick-wrap">
        <div class="container">
            <div class="quick-panel" data-aos="fade-up" data-aos-duration="600">
                <div class="row g-2 g-md-3">
                    <div class="col-6 col-lg-3">
                        <a href="{{ route('tampilan.dokumen') }}" class="quick-item">
                            <div class="quick-icon-wrap quick-icon-forest">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="quick-label">
                                <h2>Dokumen</h2>
                                <p>Arsip & Unduhan</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3">
                        <a href="{{ route('tampilan.berita') }}" class="quick-item">
                            <div class="quick-icon-wrap quick-icon-emerald">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="quick-label">
                                <h2>Kegiatan</h2>
                                <p>Agenda Terkini</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3">
                        <a href="{{ route('tampilan.agenda') }}" class="quick-item">
                            <div class="quick-icon-wrap quick-icon-amber">
                                <i class="bi bi-newspaper"></i>
                            </div>
                            <div class="quick-label">
                                <h2>Berita</h2>
                                <p>Warta Kampus</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3">
                        <a href="{{ route('tampilan.jurnal') }}" class="quick-item">
                            <div class="quick-icon-wrap quick-icon-purple">
                                <i class="bi bi-journal-bookmark"></i>
                            </div>
                            <div class="quick-label">
                                <h2>Jurnal</h2>
                                <p>Publikasi Ilmiah</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================
     3. ABOUT SECTION
     ================================================================ --}}
    <section class="about-section">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-center">

                {{-- Gambar --}}
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="700">
                    <div class="about-img-wrap">
                        @php
                            $aboutImg = asset('mte/assets/img/polibang.webp');
                            if (
                                $hero &&
                                $hero->image &&
                                Storage::disk('public')->exists('photo-dash/' . $hero->image)
                            ) {
                                $aboutImg = asset('storage/photo-dash/' . $hero->image);
                            }
                        @endphp
                        <img src="{{ $aboutImg }}"
                            alt="{{ $hero->title ?? 'Pusat Penelitian dan Pengabdian Kepada Masyarakat Politeknik Balekambang Jepara' }}"
                            width="600" height="540" loading="lazy" decoding="async">
                    </div>
                </div>

                {{-- Copy --}}
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="700" data-aos-delay="100">
                    <div class="about-label">Tentang P3M</div>
                    <h2 class="about-heading">Penelitian & Pengabdian Masyarakat</h2>

                    <p class="about-body" style="text-align: justify; text-justify: inter-word;">
                        @if ($about)
                            {{ Str::words(strip_tags($about->ourbout), 48, '...') }}
                        @else
                            P3M berperan dalam mendukung penelitian dan pengabdian kepada masyarakat di lingkungan
                            Politeknik Balekambang Jepara sebagai pusat keunggulan akademik.
                        @endif
                    </p>

                    <a href="{{ route('tampilan.tentangp3m') }}" class="hero-btn-primary" style="width: fit-content;">
                        <span>Selengkapnya</span>
                        <i class="bi bi-arrow-up-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ================================================================
     4. BERITA P3M — Agenda / Event Cards
     ================================================================ --}}
    <section class="berita-section">
        <div class="container">
            <div class="sec-header" data-aos="fade-up">
                <div class="sec-label">Berita Terkini</div>
                <h2 class="sec-title">Berita P3M</h2>
                <p class="sec-subtitle">Warta pelaksanaan kegiatan P3M di Politeknik Balekambang Jepara</p>
            </div>

            <div class="row gy-3 gy-lg-4 justify-content-center">
                @forelse($agenda as $genda)
                    <div class="col-12 col-md-6 col-xl-3 d-flex" data-aos="fade-up"
                        data-aos-delay="{{ $loop->iteration * 80 }}">
                        <a href="{{ route('tampilan.detailagenda', ['id' => $genda->id]) }}" class="berita-card w-100">
                            <div class="berita-icon">
                                <i class="bi bi-calendar4-week"></i>
                            </div>
                            <div class="berita-card-content">
                                <div class="berita-date">
                                    <i class="bi bi-clock"></i>
                                    <span>{{ $genda->date }}</span>
                                </div>
                                <h3 class="berita-title">
                                    {{ $genda->title }}
                                </h3>
                            </div>
                            <div class="berita-chevron d-md-none">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada berita P3M saat ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================================================================
     5. CTA SECTION
     ================================================================ --}}
    <section class="cta-section">
        <picture>
            <source srcset="{{ asset('mte/assets/img/polibang.webp') }}" type="image/webp">
            <img src="{{ asset('mte/assets/img/polibang.webp') }}" class="cta-bg"
                alt="Gedung Politeknik Balekambang Jepara" loading="lazy" decoding="async" width="1600"
                height="800">
        </picture>

        <div class="container">
            <div class="row align-items-center gy-4" data-aos="fade-up">
                <div class="col-xl-8 text-center text-xl-start">
                    <h2 class="cta-heading">Cari Tahu Lebih Lanjut</h2>
                    <p>
                        Pelajari bagaimana P3M mendukung penelitian dan pengabdian masyarakat
                        untuk dosen dan mahasiswa Politeknik Balekambang Jepara.
                    </p>
                </div>
                <div class="col-xl-4 text-center text-xl-end">
                    <a href="{{ route('tampilan.panduan') }}" class="cta-btn-p3m">
                        <span>Pelajari Panduan</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
     6. KEGIATAN / PORTFOLIO — News card with image
     ================================================================ --}}
    <section class="kegiatan-section">
        <div class="container">
            <div class="sec-header" data-aos="fade-up">
                <div class="sec-label">Dokumentasi</div>
                <h2 class="sec-title">Kegiatan P3M</h2>
                <p class="sec-subtitle">Dokumentasi kegiatan riset & pengabdian Politeknik Balekambang Jepara</p>
                <div class="swipe-hint d-md-none">
                    <i class="bi bi-arrow-left-right"></i>
                    <span>Geser ke samping untuk melihat kegiatan</span>
                </div>
            </div>

            <div class="row gy-4 justify-content-lg-center kegiatan-mobile-carousel">
                @foreach ($berita->take(6) as $d)
                    <div class="col-12 col-md-6 col-lg-4 d-flex kegiatan-card-col" data-aos="fade-up"
                        data-aos-delay="{{ $loop->iteration * 100 }}">
                        <article class="premium-news-card w-100">
                            @php
                                $newsImg = asset('mte/assets/img/polibang.webp');
                                if ($d->image && Storage::disk('public')->exists('photo-news/' . $d->image)) {
                                    $newsImg = asset('storage/photo-news/' . $d->image);
                                }
                            @endphp
                            <div class="news-card-img-wrap">
                                <img src="{{ $newsImg }}" alt="{{ $d->title }}" loading="lazy"
                                    decoding="async" width="400" height="220"
                                    onerror="this.src='{{ asset('mte/assets/img/polibang.webp') }}';">
                            </div>

                            <div class="news-card-body">
                                <div class="news-meta">
                                    <i class="bi bi-person-circle"></i>
                                    <span>{{ optional($d->user)->name ?? 'Pengelola P3M' }}</span>
                                    <span class="meta-dot" style="color: #cbd5e1; margin: 0 4px;">•</span>
                                    <span>{{ \Carbon\Carbon::parse($d->created_at)->translatedFormat('d M Y') }}</span>
                                </div>
                                <h3>
                                    <a href="{{ route('tampilan.detail', ['id' => $d->id]) }}">
                                        {{ $d->title }}
                                    </a>
                                </h3>
                                <p>{{ Str::words(strip_tags(html_entity_decode($d->content)), 16) }}</p>

                                <div class="news-card-footer">
                                    <a href="{{ route('tampilan.detail', ['id' => $d->id]) }}" class="btn-read-more"
                                        aria-label="Baca selengkapnya mengenai {{ $d->title }}">
                                        <span>Baca Selengkapnya</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4 mt-lg-5" data-aos="fade-up">
                <a href="{{ route('tampilan.berita') }}" class="btn-outline-primary-p3m">
                    <span>Lihat Semua Kegiatan</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- ================================================================
     7. TEAM P3M
     ================================================================ --}}
    <section class="team-section">
        <div class="container">
            <div class="sec-header" data-aos="fade-up">
                <div class="sec-label">Pengurus</div>
                <h2 class="sec-title">Tim P3M</h2>
                <p class="sec-subtitle">Pengelola Pusat Penelitian dan Pengabdian Masyarakat Polibang</p>
            </div>

            <div class="row gy-3 gy-lg-4 justify-content-center">
                @foreach ($pengelola as $d)
                    <div class="col-12 col-md-6 col-lg-5 d-flex" data-aos="fade-up"
                        data-aos-delay="{{ $loop->iteration * 80 }}">
                        <div class="premium-team-card w-100">
                            <div class="team-avatar-wrap">
                                <img src="{{ asset('storage/photo-pengelola/' . $d->image) }}"
                                    alt="{{ $d->nama_pengelola }} - {{ $d->jabatan_pengelola }} P3M Polibang"
                                    loading="lazy" decoding="async" width="105" height="130"
                                    onerror="this.src='{{ asset('mte/assets/img/polibang.webp') }}';">
                            </div>

                            <div class="team-info">
                                <h3>{{ $d->nama_pengelola }}</h3>
                                <p class="team-role">{{ $d->jabatan_pengelola }}</p>

                                <div class="team-footer">
                                    <div class="team-meta">
                                        <i class="bi bi-person-badge"></i>
                                        <span>{{ $d->jenis_identitas ?? 'NIDN' }}: {{ !empty($d->NIDN) ? $d->NIDN : '-' }}</span>
                                    </div>

                                    @if (!empty($d->email_pengelola))
                                        <a href="mailto:{{ $d->email_pengelola }}" class="team-email-btn"
                                            title="Kirim Email ke {{ $d->nama_pengelola }}">
                                            <i class="bi bi-envelope"></i>
                                            <span>Email</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4 mt-lg-5" data-aos="fade-up">
                <a href="{{ route('tampilan.struktur') }}" class="btn-outline-primary-p3m">
                    <span>Struktur Organisasi</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.querySelector('.kegiatan-mobile-carousel');
            if (!carousel) return;

            let isDown = false;
            let startX;
            let scrollLeft;

            carousel.addEventListener('mousedown', function(e) {
                isDown = true;
                carousel.style.scrollSnapType = 'none';
                carousel.style.cursor = 'grabbing';
                startX = e.pageX - carousel.offsetLeft;
                scrollLeft = carousel.scrollLeft;
            });

            const stopDrag = function() {
                if (!isDown) return;
                isDown = false;
                carousel.style.cursor = 'grab';
                carousel.style.scrollSnapType = 'x mandatory';
            };

            carousel.addEventListener('mouseleave', stopDrag);
            carousel.addEventListener('mouseup', stopDrag);

            carousel.addEventListener('mousemove', function(e) {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - carousel.offsetLeft;
                const walk = (x - startX) * 1.5;
                carousel.scrollLeft = scrollLeft - walk;
            });
        });
    </script>
@endsection
