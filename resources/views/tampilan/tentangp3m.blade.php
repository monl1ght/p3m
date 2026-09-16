@extends('layout.views')

@section('title', 'Tentang P3M - Profil, Visi, dan Misi')
@section('meta_description', 'Profil lengkap, visi, misi, dan komitmen Pusat Penelitian dan Pengabdian Kepada Masyarakat (P3M) Politeknik Balekambang Jepara.')
@section('meta_keywords', 'Tentang P3M, Profil P3M Polibang, Visi Misi P3M, Balekambang Jepara, Lembaga Riset Vokasi')
@section('canonical', route('tampilan.tentangp3m'))

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@graph": [
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Beranda",
          "item": "{{ route('tampilan') }}"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Tentang P3M",
          "item": "{{ route('tampilan.tentangp3m') }}"
        }
      ]
    },
    {
      "@type": "AboutPage",
      "@id": "{{ route('tampilan.tentangp3m') }}#about",
      "url": "{{ route('tampilan.tentangp3m') }}",
      "name": "Tentang P3M Politeknik Balekambang Jepara",
      "description": "Profil lengkap, visi, misi, dan komitmen Pusat Penelitian dan Pengabdian Kepada Masyarakat (P3M) Politeknik Balekambang Jepara.",
      "mainEntity": {
        "@id": "{{ url('/') }}#organization"
      }
    }
  ]
}
</script>
@endsection

@section('isi')
    <style>
        /* ── PROFIL P3M (TENTANG KAMI) STYLES ───────────────── */
        :root {
            --primary-light: #059669;
            --primary-dark: #047857;
            --primary-soft: #ecfdf5;
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #475569;
            --border-color: #e2e8f0;
        }

        .portfolio-details .row {
            align-items: stretch;
        }

        .content-card,
        .portfolio-info {
            height: 100%;
            background: #ffffff;
            border: 1px solid #e2e8f0 !important;
            border-radius: 24px !important;
            padding: 40px !important;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03) !important;
            transition: all 0.3s ease;
        }

        .content-card:hover,
        .portfolio-info:hover {
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.06) !important;
            border-color: #cbd5e1 !important;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--primary-light);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 24px;
        }

        .section-label::before,
        .section-label::after {
            content: "";
            width: 24px;
            height: 2px;
            border-radius: 2px;
            background: var(--primary-light);
            opacity: 0.5;
        }

        .content-card h2 {
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }

        .content-card .content-body,
        .content-card .content-body p,
        .content-card .content-body span,
        .content-card .content-body li {
            font-size: 15.5px;
            line-height: 1.85 !important;
            color: #334155;
            text-align: justify !important;
            text-justify: inter-word !important;
            font-family: inherit !important;
        }

        .content-card .content-body p {
            margin-bottom: 16px !important;
        }

        .content-card .content-body p:last-child {
            margin-bottom: 0 !important;
        }

        .content-card .content-body p:empty,
        .content-card .content-body p:has(br:only-child) {
            display: none !important;
        }

        .content-card .content-body ul,
        .content-card .content-body ol {
            padding-left: 20px !important;
            margin: 12px 0 20px !important;
            list-style-type: disc !important;
        }

        .content-card .content-body li {
            margin-bottom: 10px !important;
        }

        .portfolio-info h3 {
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 19px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .portfolio-info ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .portfolio-info ul li {
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f8fafc;
        }

        .portfolio-info ul li:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .portfolio-info ul li h6 {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.45;
            margin: 0;
            text-align: justify !important;
            text-justify: inter-word !important;
        }

        .portfolio-info ul li h6 a {
            color: #0f172a;
            text-decoration: none;
            transition: color 0.2s;
        }

        .portfolio-info ul li h6 a:hover {
            color: var(--primary-light);
        }

        .portfolio-info ul li h6 i {
            color: var(--primary-light);
            margin-right: 6px;
        }

        .portfolio-info ul li p,
        .portfolio-info p {
            font-size: 13.5px;
            line-height: 1.65;
            color: #64748b;
            margin: 0;
            text-align: justify !important;
            text-justify: inter-word !important;
        }

        @media (max-width: 991px) {
            .content-card,
            .portfolio-info {
                padding: 22px 18px !important;
                border-radius: 18px !important;
            }

            .content-card h2 {
                font-size: 20px;
                margin-bottom: 12px;
            }

            .content-card .content-body {
                font-size: 14.5px;
                line-height: 1.75;
                text-align: justify !important;
                text-justify: inter-word !important;
            }

            .portfolio-info ul li h6 {
                text-align: justify !important;
                text-justify: inter-word !important;
            }

            .portfolio-info ul li p,
            .portfolio-info p {
                text-align: justify !important;
                text-justify: inter-word !important;
            }

            .section-label {
                margin-bottom: 18px;
            }
        }
    </style>
    <div class="page-title" data-aos="fade">
        <div class="container">
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('tampilan') }}">Home</a></li>
                    <li class="current">{{ $pagetitle }}</li>
                </ol>
            </nav>
            <h1>{{ $pagetitle }}</h1>
            <small>Politeknik Balekambang Jepara</small>
        </div>
    </div>

    <section id="portfolio-details" class="portfolio-details section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg-8">
                    <div class="content-card" data-aos="fade-up" data-aos-delay="200">
                        @foreach ($tentang as $bout)
                            <div class="section-label">Profil P3M</div>

                            <h2>Tentang Kami</h2>
                            <div class="content-body mb-5">
                                {!! preg_replace('#<p[^>]*>(\s*<br\s*/?>\s*|\s*)*</p>#i', '', strip_tags($bout->ourbout, '<p><br><strong><b><em><i>')) !!}
                            </div>

                            <h2>Visi P3M</h2>
                            <div class="content-body mb-5">
                                {!! preg_replace('#<p[^>]*>(\s*<br\s*/?>\s*|\s*)*</p>#i', '', strip_tags($bout->visi, '<p><br><strong><b><em><i>')) !!}
                            </div>

                            <h2>Misi P3M</h2>
                            <div class="content-body">
                                {!! strip_tags($bout->misi, '<p><ul><ol><li><br><strong><b><em><i>') !!}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="portfolio-info" data-aos="fade-up" data-aos-delay="300">
                        <h3>Kegiatan Terbaru</h3>

                        <ul>
                            @foreach ($berita as $news)
                                <li>
                                    <h6 style="text-align: justify; text-justify: inter-word;">
                                        <i class="far fa-newspaper"></i>
                                        <a href="{{ route('tampilan.detail', ['id' => $news->id]) }}">
                                            {{ $news->title }}
                                        </a>
                                    </h6>
                                    <p style="text-align: justify; text-justify: inter-word; margin: 0;">{{ Str::words(strip_tags(html_entity_decode($news->content)), 12) }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection
