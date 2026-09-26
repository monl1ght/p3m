@extends('layout.views')

@section('title', 'Struktur Organisasi P3M')
@section('meta_description', 'Susunan pengelola dan struktur organisasi Pusat Penelitian dan Pengabdian Kepada Masyarakat (P3M) Politeknik Balekambang Jepara.')
@section('meta_keywords', 'Struktur Organisasi P3M, Pengelola P3M Polibang, Dosen Peneliti, Manajemen P3M Balekambang')
@section('canonical', route('tampilan.struktur'))

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
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
      "name": "Struktur Organisasi",
      "item": "{{ route('tampilan.struktur') }}"
    }
  ]
}
</script>
@endsection

@section('isi')
<style>
/* ── STRUKTUR ORGANISASI P3M STYLES ───────────────── */
:root {
    --primary-light: #047857;
    --primary-dark: #047857;
    --primary-soft: #ecfdf5;
    --primary-border: #a7f3d0;
    --surface: #ffffff;
    --surface-alt: #f8fafc;
    --text-main: #0f172a;
    --text-muted: #475569;
    --border-color: #e2e8f0;
    --transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

body {
    background-color: var(--surface-alt);
}

.team.section {
    padding: 72px 0 100px;
}

.section-title {
    text-align: center;
    margin-bottom: 48px;
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
    margin-bottom: 20px;
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

.section-title h2 {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: clamp(2rem, 3vw, 2.5rem);
    font-weight: 800;
    color: var(--text-main);
    margin: 0 0 16px;
    letter-spacing: -0.02em;
}

.section-title p {
    color: var(--text-muted);
    font-size: 16px;
    margin: 0 auto;
    text-align: center;
}

/* Premium Team Card */
.premium-team-card {
    background: #ffffff;
    border: 1px solid var(--border-color, #e2e8f0);
    border-radius: 20px;
    padding: 32px 24px 28px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04), 0 1px 2px rgba(15, 23, 42, 0.02);
    transition: var(--transition-smooth, all 0.35s cubic-bezier(0.16, 1, 0.3, 1));
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.premium-team-card:hover {
    box-shadow: 0 16px 36px -4px rgba(5, 150, 105, 0.1), 0 4px 10px rgba(15, 23, 42, 0.03);
    transform: translateY(-4px);
    border-color: #a7f3d0;
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
    flex-shrink: 0;
}

.team-avatar-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 15%;
    display: block;
}

.team-info {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-grow: 1;
}

.team-info h3,
.team-info h4 {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 6px 0;
    letter-spacing: -0.015em;
    line-height: 1.35;
}

.team-role {
    font-size: 13px;
    font-weight: 600;
    color: #047857;
    line-height: 1.45;
    margin: 0 0 16px 0;
    max-width: 320px;
}

.team-footer {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: auto;
    padding-top: 4px;
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
    white-space: nowrap;
}

.team-meta i {
    color: #059669;
    font-size: 11px;
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
    white-space: nowrap;
}

.team-email-btn:hover {
    background: #059669;
    color: #ffffff;
    border-color: #059669;
    box-shadow: 0 3px 10px rgba(5, 150, 105, 0.25);
    transform: translateY(-1px);
}

/* ── Mobile Optimizations ── */
@media (max-width: 768px) {
    .team.section {
        padding: 36px 0 64px;
    }

    .section-title {
        margin-bottom: 28px;
    }

    .section-title h2 {
        font-size: 24px;
        margin-bottom: 8px;
    }

    .section-title p {
        font-size: 14px;
    }

    /* Team Cards on Mobile — Centered Executive Layout */
    .premium-team-card {
        padding: 24px 18px 20px !important;
        border-radius: 18px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
    }

    .team-avatar-wrap {
        width: 92px !important;
        height: 118px !important;
        border-radius: 14px !important;
        margin-bottom: 14px !important;
        padding: 0 !important;
    }

    .team-info {
        padding-right: 0 !important;
        align-items: center !important;
        text-align: center !important;
    }

    .team-info h3,
    .team-info h4 {
        font-size: 16.5px !important;
        margin: 0 0 5px 0 !important;
        line-height: 1.3 !important;
        text-align: center !important;
    }

    .team-role {
        font-size: 12.5px !important;
        margin: 0 0 14px 0 !important;
        line-height: 1.4 !important;
        text-align: center !important;
    }

    .team-footer {
        gap: 8px !important;
        justify-content: center !important;
    }

    .team-meta {
        font-size: 11.5px !important;
        padding: 5px 12px !important;
    }

    .team-email-btn {
        position: static !important;
        font-size: 11.5px !important;
        padding: 5px 14px !important;
        width: auto !important;
        height: auto !important;
    }
}
</style>

<div class="page-title">
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

<section id="team" class="team section">
    <div class="container section-title" data-aos="fade-up">
        <div class="section-label">Struktur Organisasi</div>
        <h2>Team P3M</h2>
        <p>Pengelola Pusat Penelitian dan Pengabdian Masyarakat</p>
    </div>

    <div class="container">
        <div class="row gy-3 gy-md-4 justify-content-center">
            @forelse($pengelola as $d)
                <div class="col-12 col-md-6 col-lg-5 d-flex" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                    <div class="premium-team-card w-100">
                        <div class="team-avatar-wrap">
                            <img src="{{ asset('storage/photo-pengelola/' . $d->image) }}" alt="{{ $d->nama_pengelola }} - {{ $d->jabatan_pengelola }}"
                                onerror="this.src='{{ asset('mte/assets/img/polibang.webp') }}';" loading="lazy" width="105" height="130">
                        </div>

                        <div class="team-info">
                            <h3>{{ $d->nama_pengelola }}</h3>
                            <p class="team-role">{{ $d->jabatan_pengelola }}</p>

                            <div class="team-footer">
                                <div class="team-meta">
                                    <i class="fas fa-id-badge"></i>
                                    <span>{{ $d->jenis_identitas ?? 'NIDN' }}: {{ !empty($d->NIDN) ? $d->NIDN : '-' }}</span>
                                </div>

                                @if (!empty($d->email_pengelola))
                                    <a href="mailto:{{ $d->email_pengelola }}" class="team-email-btn"
                                        title="Kirim Email ke {{ $d->nama_pengelola }}">
                                        <i class="fas fa-envelope"></i>
                                        <span>Email</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5"
                        style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; color: #94a3b8; padding: 32px 20px;">
                        <i class="fas fa-users-slash fa-3x mb-3" style="color: #cbd5e1;"></i>
                        <p class="mb-0" style="font-size: 15px; font-weight: 600;">Belum ada data struktur organisasi P3M.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
