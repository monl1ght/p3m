@extends('layout.views')
@section('isi')

<style>
/* ── DETAIL KEGIATAN P3M STYLES ───────────────── */
:root {
    --primary-light: #059669;
    --primary-dark: #047857;
    --primary-soft: #ecfdf5;
    --primary-border: #a7f3d0;
    --surface: #ffffff;
    --surface-alt: #f8fafc;
    --text-main: #0f172a;
    --text-muted: #475569;
    --text-light: #64748b;
    --border-color: #e2e8f0;
    --transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

body {
    background-color: var(--surface-alt);
}

.detail-section {
    padding: 48px 0 80px;
}

/* ── Main Article Card ── */
.article-main-card {
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: 24px;
    padding: 36px;
    box-shadow: 0 4px 24px -2px rgba(15, 23, 42, 0.04), 0 1px 2px rgba(15, 23, 42, 0.02);
    transition: var(--transition);
}

.article-main-card:hover {
    box-shadow: 0 12px 32px -4px rgba(5, 150, 105, 0.08), 0 2px 6px rgba(15, 23, 42, 0.03);
}

/* ── Hero / Featured Image ── */
.article-hero-wrap {
    position: relative;
    width: 100%;
    height: 380px;
    border-radius: 18px;
    overflow: hidden;
    background: linear-gradient(135deg, #ecfdf5 0%, #f1f5f9 100%);
    border: 1px solid var(--border-color);
    margin-bottom: 28px;
}

.article-hero-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.5s ease;
    display: block;
}

.article-main-card:hover .article-hero-img {
    transform: scale(1.02);
}

.article-hero-badge {
    position: absolute;
    bottom: 16px;
    left: 16px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(4, 38, 31, 0.84);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    padding: 7px 16px;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
}

.article-hero-badge i {
    color: #34d399;
    font-size: 13px;
}

/* ── Meta Bar ── */
.article-meta-bar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
    padding-bottom: 18px;
    border-bottom: 1px solid #f1f5f9;
}

.meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 6px 14px;
    border-radius: 999px;
}

.meta-pill i {
    color: #059669;
    font-size: 13px;
}

.meta-pill.pill-accent {
    background: #ecfdf5;
    border-color: #a7f3d0;
    color: #047857;
    font-weight: 700;
}

/* ── Title ── */
.article-title {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.4;
    letter-spacing: -0.02em;
    margin: 0 0 24px 0;
}

/* ── Article Content Typography ── */
.article-content {
    font-family: "Inter", sans-serif;
    font-size: 16px;
    line-height: 1.85;
    color: #334155;
    text-align: justify !important;
    text-justify: inter-word !important;
}

.article-content p {
    margin-bottom: 20px;
    text-align: justify !important;
    text-justify: inter-word !important;
    line-height: 1.85;
    color: #334155;
}

.article-content p:last-child {
    margin-bottom: 0;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4 {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-weight: 800;
    color: #0f172a;
    margin: 32px 0 16px;
    letter-spacing: -0.015em;
    line-height: 1.35;
}

.article-content ul,
.article-content ol {
    margin: 16px 0 24px;
    padding-left: 24px;
}

.article-content li {
    margin-bottom: 8px;
    line-height: 1.75;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 16px;
    margin: 24px 0;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
}

.article-content figure {
    margin: 24px 0;
    text-align: center;
}

.article-content figure img {
    margin: 0 auto;
    display: block;
}

.article-content figure figcaption {
    font-size: 13px;
    color: #64748b;
    margin-top: 8px;
    font-style: italic;
}

.article-content blockquote {
    border-left: 4px solid #059669;
    background: #f8fafc;
    padding: 18px 24px;
    border-radius: 0 14px 14px 0;
    margin: 24px 0;
    color: #475569;
    font-style: italic;
    font-size: 15.5px;
}

/* ── Article Footer & Share Bar ── */
.article-footer-bar {
    margin-top: 36px;
    padding-top: 24px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}

.btn-back-kegiatan {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #334155;
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 13.5px;
    font-weight: 700;
    padding: 10px 20px;
    border-radius: 12px;
    text-decoration: none;
    transition: var(--transition);
}

.btn-back-kegiatan:hover {
    background: #059669;
    color: #ffffff;
    border-color: #059669;
    transform: translateX(-3px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
}

.share-group {
    display: flex;
    align-items: center;
    gap: 8px;
}

.share-label {
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    margin-right: 4px;
}

.share-btn {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    color: #475569;
    font-size: 15px;
    text-decoration: none;
    transition: var(--transition);
    cursor: pointer;
}

.share-btn:hover {
    background: #ecfdf5;
    border-color: #a7f3d0;
    color: #059669;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(5, 150, 105, 0.15);
}

.share-btn.btn-wa:hover {
    background: #25d366;
    border-color: #25d366;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
}

.share-btn.btn-fb:hover {
    background: #1877f2;
    border-color: #1877f2;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);
}

/* ── Sidebar: Kegiatan Terbaru ── */
.sidebar-sticky-wrap {
    position: sticky;
    top: 90px;
}

.sidebar-card {
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: 24px;
    padding: 32px 28px;
    box-shadow: 0 4px 24px -2px rgba(15, 23, 42, 0.04), 0 1px 2px rgba(15, 23, 42, 0.02);
}

.sidebar-header {
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f1f5f9;
}

.sidebar-eyebrow {
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #059669;
    margin-bottom: 6px;
    display: inline-block;
}

.sidebar-title {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    letter-spacing: -0.01em;
}

.sidebar-news-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-news-item {
    display: block;
    padding: 16px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    text-decoration: none;
    transition: var(--transition);
}

.sidebar-news-item:hover {
    background: #ffffff;
    border-color: #a7f3d0;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(5, 150, 105, 0.08);
}

.sidebar-news-date {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11.5px;
    font-weight: 700;
    color: #059669;
    margin-bottom: 8px;
}

.sidebar-news-date i {
    font-size: 12px;
}

.sidebar-news-item h6 {
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 14.5px;
    font-weight: 700;
    line-height: 1.45;
    color: #0f172a;
    margin: 0 0 8px 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s;
}

.sidebar-news-item:hover h6 {
    color: #059669;
}

.sidebar-news-item p {
    font-size: 13px;
    line-height: 1.55;
    color: #64748b;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-align: justify !important;
    text-justify: inter-word !important;
}

.btn-all-kegiatan {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 20px;
    padding: 12px 18px;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #047857;
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 13.5px;
    font-weight: 700;
    border-radius: 14px;
    text-decoration: none;
    transition: var(--transition);
}

.btn-all-kegiatan:hover {
    background: #059669;
    color: #ffffff;
    border-color: #059669;
    box-shadow: 0 6px 18px rgba(5, 150, 105, 0.22);
}

/* ── Copy Toast Notification ── */
.copy-toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: #04261f;
    color: #ffffff;
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 13.5px;
    font-weight: 700;
    padding: 12px 22px;
    border-radius: 999px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 10px;
    z-index: 9999;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
}

.copy-toast.show {
    opacity: 1;
    transform: translateY(0);
}

.copy-toast i {
    color: #34d399;
    font-size: 16px;
}

/* ── Mobile Optimizations ── */
@media (max-width: 768px) {
    .detail-section {
        padding: 24px 0 64px;
    }

    .article-main-card {
        padding: 20px 16px 24px;
        border-radius: 18px;
    }

    .article-hero-wrap {
        height: 210px;
        border-radius: 14px;
        margin-bottom: 20px;
    }

    .article-hero-badge {
        bottom: 12px;
        left: 12px;
        font-size: 11.5px;
        padding: 5px 12px;
    }

    .article-meta-bar {
        gap: 8px;
        margin-bottom: 16px;
        padding-bottom: 14px;
    }

    .meta-pill {
        font-size: 11.5px;
        padding: 4px 10px;
        gap: 5px;
    }

    .article-title {
        font-size: 19px;
        line-height: 1.35;
        margin: 0 0 18px 0;
    }

    .article-content {
        font-size: 14.5px;
        line-height: 1.8;
    }

    .article-content p {
        margin-bottom: 16px;
        line-height: 1.8;
    }

    .article-footer-bar {
        flex-direction: column-reverse;
        align-items: stretch;
        gap: 16px;
        margin-top: 28px;
        padding-top: 20px;
    }

    .btn-back-kegiatan {
        justify-content: center;
        width: 100%;
        padding: 12px;
    }

    .share-group {
        justify-content: center;
        width: 100%;
    }

    .sidebar-card {
        padding: 20px 16px;
        border-radius: 18px;
    }

    .sidebar-title {
        font-size: 18px;
    }

    .sidebar-news-item {
        padding: 14px;
    }

    .sidebar-news-item h6 {
        font-size: 14px;
    }

    .sidebar-news-item p {
        font-size: 12.5px;
    }
}
</style>

{{-- Page Header --}}
<div class="page-title" data-aos="fade">
    <div class="container">
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ route('tampilan') }}">Home</a></li>
                <li><a href="{{ route('tampilan.berita') }}">Kegiatan P3M</a></li>
                <li class="current">Detail Kegiatan</li>
            </ol>
        </nav>
        <h1>Detail Kegiatan</h1>
        <small>Pusat Penelitian dan Pengabdian Kepada Masyarakat POLIBANG</small>
    </div>
</div>

<section id="portfolio-details" class="portfolio-details section detail-section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">

            {{-- 1. MAIN ARTICLE COLUMN --}}
            <div class="col-lg-8">
                <article class="article-main-card">
                    @php
                        $defaultBanner = asset('mte/assets/img/banner-p3m.jpg');
                        $imageSrc = $defaultBanner;

                        if (!empty($berita->image)) {
                            if (Storage::disk('public')->exists('photo-news/' . $berita->image)) {
                                $imageSrc = asset('storage/photo-news/' . $berita->image);
                            } elseif (file_exists(public_path('storage/photo-news/' . $berita->image))) {
                                $imageSrc = asset('storage/photo-news/' . $berita->image);
                            }
                        }

                        // Clean inner content from DOMDocument::saveHTML() wrappers
                        $rawContent = $berita->content ?? '';
                        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $rawContent, $bodyMatches)) {
                            $cleanContent = $bodyMatches[1];
                        } else {
                            $cleanContent = preg_replace('/<!DOCTYPE[^>]*>/i', '', $rawContent);
                            $cleanContent = preg_replace('/<\/?(html|body|head)[^>]*>/i', '', $cleanContent);
                        }
                        $cleanContent = trim($cleanContent);

                        // Word count & read time
                        $plainText = strip_tags(html_entity_decode($cleanContent));
                        $wordCount = str_word_count($plainText);
                        $readTime = max(1, ceil($wordCount / 180));
                    @endphp

                    {{-- Featured Hero Image with graceful fallback --}}
                    <div class="article-hero-wrap">
                        <img src="{{ $imageSrc }}" 
                             alt="{{ $berita->title }}" 
                             class="article-hero-img" 
                             loading="eager"
                             onerror="this.onerror=null; this.src='{{ $defaultBanner }}';">
                        
                        <div class="article-hero-badge">
                            <i class="fas fa-bullhorn"></i>
                            <span>{{ optional($berita->category)->name ?? 'Kegiatan P3M' }}</span>
                        </div>
                    </div>

                    {{-- Metadata Bar --}}
                    <div class="article-meta-bar">
                        <div class="meta-pill pill-accent">
                            <i class="far fa-calendar-alt"></i>
                            <span>{{ \Carbon\Carbon::parse($berita->date ?? $berita->created_at)->translatedFormat('d F Y') }}</span>
                        </div>

                        <div class="meta-pill">
                            <i class="far fa-user-circle"></i>
                            <span>{{ optional($berita->user)->name ?? 'Pengelola P3M' }}</span>
                        </div>

                        <div class="meta-pill">
                            <i class="far fa-clock"></i>
                            <span>~{{ $readTime }} menit baca</span>
                        </div>
                    </div>

                    {{-- Title --}}
                    <h1 class="article-title">{{ $berita->title }}</h1>

                    {{-- Content Body with full formatting & justify --}}
                    <div class="article-content">
                        @if (Str::contains($cleanContent, ['<p', '<div', '<br', '<figure', '<ul', '<ol', '<h1', '<h2', '<h3', '<h4']))
                            {!! $cleanContent !!}
                        @else
                            @foreach (preg_split('/\r\n|\r|\n/', $cleanContent) as $paragraph)
                                @if (trim($paragraph) !== '')
                                    <p>{{ trim($paragraph) }}</p>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    {{-- Bottom Action & Social Share Bar --}}
                    <div class="article-footer-bar">
                        <a href="{{ route('tampilan.berita') }}" class="btn-back-kegiatan">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Kegiatan P3M</span>
                        </a>

                        <div class="share-group">
                            <span class="share-label">Bagikan:</span>
                            @php
                                $currentUrl = urlencode(url()->current());
                                $shareText = urlencode($berita->title . ' - P3M Politeknik Balekambang Jepara');
                            @endphp
                            <a href="https://api.whatsapp.com/send?text={{ $shareText }}%20{{ $currentUrl }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="share-btn btn-wa" 
                               title="Bagikan ke WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $currentUrl }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="share-btn btn-fb" 
                               title="Bagikan ke Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ $currentUrl }}&text={{ $shareText }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="share-btn btn-tw" 
                               title="Bagikan ke Twitter / X">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <button type="button" 
                                    class="share-btn btn-copy" 
                                    onclick="copyCurrentUrl()" 
                                    title="Salin Link Kegiatan">
                                <i class="far fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </article>
            </div>

            {{-- 2. SIDEBAR COLUMN: KEGIATAN TERBARU --}}
            <div class="col-lg-4">
                <div class="sidebar-sticky-wrap">
                    <aside class="sidebar-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="sidebar-header">
                            <span class="sidebar-eyebrow">AGENDA & INFORMASI</span>
                            <h3 class="sidebar-title">Kegiatan Terbaru</h3>
                        </div>

                        <div class="sidebar-news-list">
                            @php
                                $recentList = $data->where('id', '!=', $berita->id)->take(4);
                                if ($recentList->isEmpty()) {
                                    $recentList = $data->take(4);
                                }
                            @endphp

                            @forelse($recentList as $news)
                                <a href="{{ route('tampilan.detail', ['id' => $news->id]) }}" class="sidebar-news-item">
                                    <div class="sidebar-news-date">
                                        <i class="far fa-calendar-alt"></i>
                                        <span>{{ \Carbon\Carbon::parse($news->date ?? $news->created_at)->translatedFormat('d M Y') }}</span>
                                    </div>
                                    <h6>{{ $news->title }}</h6>
                                    <p>{{ Str::words(strip_tags(html_entity_decode($news->content)), 12) }}</p>
                                </a>
                            @empty
                                <div class="text-center py-4 text-muted" style="font-size: 13.5px;">
                                    Belum ada kegiatan lainnya.
                                </div>
                            @endforelse
                        </div>

                        <a href="{{ route('tampilan.berita') }}" class="btn-all-kegiatan">
                            <span>Lihat Semua Kegiatan</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </aside>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Toast Notification for Copied Link --}}
<div id="copyToast" class="copy-toast">
    <i class="fas fa-check-circle"></i>
    <span>Tautan kegiatan berhasil disalin!</span>
</div>

<script>
function copyCurrentUrl() {
    const url = window.location.href;
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(showToast);
    } else {
        const tempInput = document.createElement('input');
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        showToast();
    }
}

function showToast() {
    const toast = document.getElementById('copyToast');
    if (toast) {
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2600);
    }
}
</script>

@endsection
