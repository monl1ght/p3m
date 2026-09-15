@extends('layout.main')

@section('body_class', 'page-tentang')

@section('css')
<style>
/* ================================================================
   P3M — Tentang P3M Page — Premium SaaS Redesign
   ================================================================ */

:root {
    --forest:       #003d2d;
    --forest-deep:  #002e22;
    --forest-mid:   #00573b;
    --forest-soft:  #eaf5ee;
    --gold:         #b99835;
    --gold-soft:    #fdf8ec;
    --ink:          #0d1f1a;
    --ink-2:        #1e3328;
    --tx:           #3b4f47;
    --muted:        #6b7f78;
    --light:        #9caaa4;
    --border:       #e4ede8;
    --border-2:     #d3e0d9;
    --surface:      #ffffff;
    --surface-alt:  #f7faf8;
    --surface-hov:  #f2f7f4;
    --r-sm: 8px; --r-md: 12px; --r-lg: 16px; --r-xl: 20px; --r-2xl: 24px;
}

/* Page Shell */
.page-tentang .content-wrapper {
    min-height: calc(100vh - 78px);
    background: radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0,93,59,.06), transparent),
                linear-gradient(180deg, #f2f8f5 0%, #f7faf8 100%);
}
.page-tentang .content-header { padding: 26px 28px 0; }
.page-tentang section.content { padding: 16px 28px 36px; }

/* Breadcrumb */
.page-tentang .breadcrumb {
    background: transparent; padding: 0; margin: 0;
    font-size: 12.5px; font-weight: 600;
}
.page-tentang .breadcrumb-item a { color: var(--forest); text-decoration: none; transition: opacity .18s; }
.page-tentang .breadcrumb-item a:hover { opacity: .75; }
.page-tentang .breadcrumb-item.active { color: var(--muted); }
.page-tentang .breadcrumb-item + .breadcrumb-item::before { content: "/"; padding: 0 8px; color: var(--border-2); }

/* Main Card */
.tentang-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r-2xl); box-shadow: 0 20px 56px rgba(3,50,33,.12), 0 4px 12px rgba(0,0,0,.06);
    overflow: hidden;
}

/* Card Header */
.tentang-card-head {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 20px; flex-wrap: wrap;
    padding: 28px 32px 24px;
    background: linear-gradient(112deg, #ffffff 55%, #f0faf5 100%);
    border-bottom: 1px solid var(--border);
    position: relative; overflow: hidden;
}
.tentang-card-head::after {
    content: ""; position: absolute; top: -40px; right: -40px;
    width: 200px; height: 200px; border-radius: 50%;
    background: radial-gradient(circle, rgba(0,93,59,.05), transparent 70%);
    pointer-events: none;
}

.card-eyebrow {
    display: inline-flex; align-items: center; gap: 8px; margin-bottom: 10px;
    color: var(--forest-mid); font-size: 11px; font-weight: 800;
    letter-spacing: .12em; text-transform: uppercase;
}
.card-eyebrow::before {
    content: ""; width: 20px; height: 2.5px; border-radius: 99px; background: var(--gold);
}

.card-head-title {
    font-family: "Plus Jakarta Sans", "Inter", sans-serif;
    font-size: 22px; font-weight: 800; color: var(--ink);
    letter-spacing: -.04em; margin: 0 0 6px; line-height: 1.2;
}
.card-head-sub {
    color: var(--muted); font-size: 13.5px; line-height: 1.65; margin: 0; max-width: 480px;
}

.card-head-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

.btn-tentang-add,
.btn-tentang-edit {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 18px; border: none; border-radius: var(--r-md);
    font-size: 13.5px; font-weight: 700; cursor: pointer; transition: all .18s ease; white-space: nowrap;
}

.btn-tentang-add {
    background: var(--forest); color: #fff;
    box-shadow: 0 6px 18px rgba(0,61,45,.22);
}
.btn-tentang-add:hover {
    background: var(--forest-deep); color: #fff;
    transform: translateY(-1px); box-shadow: 0 10px 24px rgba(0,46,34,.28);
}

.btn-tentang-edit {
    background: var(--surface); color: var(--forest);
    border: 1px solid var(--border-2);
}
.btn-tentang-edit:hover {
    background: var(--forest-soft); color: var(--forest-deep); border-color: #c2dece;
    transform: translateY(-1px);
}

/* Body & Grid */
.tentang-card-body { padding: 32px; }

.tentang-empty {
    padding: 40px 20px; border: 1.5px dashed var(--border-2); border-radius: var(--r-xl);
    background: var(--surface-alt); text-align: center; color: var(--muted); font-weight: 600;
}

.tentang-grid {
    display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px;
}

.info-box {
    position: relative; display: flex; flex-direction: column;
    border: 1px solid var(--border); border-radius: var(--r-xl);
    background: var(--surface); box-shadow: 0 10px 30px rgba(0,30,20,.03); overflow: hidden;
}
.info-box::before {
    content: ""; position: absolute; left: 0; top: 24px; bottom: 24px;
    width: 3px; border-radius: 0 4px 4px 0; background: var(--gold);
}
.info-box-full { grid-column: 1 / -1; }

.info-box-head { display: flex; align-items: center; gap: 14px; padding: 20px 24px 12px; }

.info-box-icon {
    width: 42px; height: 42px; border-radius: 12px;
    background: var(--forest-soft); color: var(--forest);
    display: inline-flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;
}

.info-box-title { min-width: 0; }
.info-box-title h2 {
    margin: 0 0 3px; font-size: 16px; font-weight: 800; color: var(--ink); letter-spacing: -.02em;
}
.info-box-title span { display: block; font-size: 13px; color: var(--muted); font-weight: 600; }

.info-box-body {
    padding: 0 24px 24px 80px; font-size: 14px; color: var(--tx); line-height: 1.7;
}
.info-box-body p { margin-bottom: 12px; }
.info-box-body p:last-child { margin-bottom: 0; }
.info-box-body ul, .info-box-body ol { margin: 0; padding-left: 18px; }
.info-box-body li { margin-bottom: 6px; }
.info-box-body li:last-child { margin-bottom: 0; }

/* Responsive */
@media (max-width: 991.98px) {
    .tentang-grid { grid-template-columns: 1fr; }
    .info-box-full { grid-column: auto; }
}

@media (max-width: 767.98px) {
    .page-tentang .content-header { padding: 20px 16px 0; }
    .page-tentang section.content { padding: 14px 16px 28px; }
    .tentang-card { border-radius: var(--r-lg); }
    .tentang-card-head { padding: 22px 20px 18px; }
    .card-head-title { font-size: 19px; }
    .tentang-card-body { padding: 20px; }
    .info-box-head { padding: 16px 16px 10px; }
    .info-box-body { padding: 0 16px 20px 16px; }
    .info-box::before { top: 16px; bottom: 16px; }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $pagetitle }}</li>
        </ol>
    </div>

    <section class="content">
        @php
            $tentang = $bout->first();
        @endphp

        <div class="tentang-card">

            {{-- Card Header --}}
            <div class="tentang-card-head">
                <div>
                    <span class="card-eyebrow">Profil P3M</span>
                    <h1 class="card-head-title">Tentang P3M</h1>
                    <p class="card-head-sub">Kelola informasi visi, misi, dan deskripsi P3M yang tampil pada halaman publik website.</p>
                </div>
                <div class="card-head-actions">
                    <a href="{{ route('tentang.create') }}" class="btn-tentang-add">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                    @if($tentang)
                    <a href="{{ route('tentang.edit', ['id' => $tentang->id]) }}" class="btn-tentang-edit">
                        <i class="fas fa-pen"></i> Edit Data
                    </a>
                    @endif
                </div>
            </div>

            {{-- Body --}}
            <div class="tentang-card-body">
                @if(!$tentang)
                    <div class="tentang-empty">
                        <i class="fas fa-info-circle mb-2" style="font-size: 24px; color: var(--border-2); display: block;"></i>
                        Belum ada data Tentang P3M. Silakan tambahkan data terlebih dahulu.
                    </div>
                @else
                    <div class="tentang-grid">
                        
                        <article class="info-box">
                            <div class="info-box-head">
                                <span class="info-box-icon"><i class="fas fa-eye"></i></span>
                                <div class="info-box-title">
                                    <h2>Visi</h2>
                                    <span>Arah dan tujuan utama P3M.</span>
                                </div>
                            </div>
                            <div class="info-box-body">
                                {{ strip_tags($tentang->visi) }}
                            </div>
                        </article>

                        <article class="info-box">
                            <div class="info-box-head">
                                <span class="info-box-icon"><i class="fas fa-bullseye"></i></span>
                                <div class="info-box-title">
                                    <h2>Misi</h2>
                                    <span>Langkah strategis pendukung visi.</span>
                                </div>
                            </div>
                            <div class="info-box-body">
                                {{ strip_tags($tentang->misi) }}
                            </div>
                        </article>

                        <article class="info-box info-box-full">
                            <div class="info-box-head">
                                <span class="info-box-icon"><i class="fas fa-info-circle"></i></span>
                                <div class="info-box-title">
                                    <h2>Tentang P3M</h2>
                                    <span>Informasi umum Pusat Penelitian dan Pengabdian.</span>
                                </div>
                            </div>
                            <div class="info-box-body">
                                {{ strip_tags($tentang->ourbout) }}
                            </div>
                        </article>

                    </div>
                @endif
            </div>
            
        </div>
    </section>
</div>
@endsection
