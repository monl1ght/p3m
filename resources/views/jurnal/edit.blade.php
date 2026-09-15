@extends('layout.main')

@section('body_class', 'page-users')

@section('css')
<style>
/* ================================================================
   P3M — Jurnal Edit Page — Premium SaaS Redesign
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
    --danger:       #d94b4b;
    --r-sm: 8px; --r-md: 12px; --r-lg: 16px; --r-xl: 20px; --r-2xl: 24px;
}

.page-users .content-wrapper {
    min-height: calc(100vh - 78px);
    background: radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0,93,59,.06), transparent),
                linear-gradient(180deg, #f2f8f5 0%, #f7faf8 100%);
}
.page-users .content-header { padding: 26px 28px 0; }
.page-users section.content { padding: 16px 28px 36px; }

/* Breadcrumb */
.page-users .breadcrumb {
    background: transparent; padding: 0; margin: 0;
    font-size: 12.5px; font-weight: 600;
}
.page-users .breadcrumb-item a { color: var(--forest); text-decoration: none; transition: opacity .18s; }
.page-users .breadcrumb-item a:hover { opacity: .75; }
.page-users .breadcrumb-item.active { color: var(--muted); }
.page-users .breadcrumb-item + .breadcrumb-item::before { content: "/"; padding: 0 8px; color: var(--border-2); }

.form-wrap {
    width: 100%;
    max-width: 780px;
    margin: 0 auto;
}

.form-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-2xl);
    box-shadow: 0 20px 56px rgba(3,50,33,.12), 0 4px 12px rgba(0,0,0,.06);
    overflow: hidden;
}

.form-card-head {
    padding: 28px 32px 24px;
    background: linear-gradient(112deg, #ffffff 55%, #f0faf5 100%);
    border-bottom: 1px solid var(--border);
    position: relative;
    overflow: hidden;
}
.form-card-head::after {
    content: ""; position: absolute; top: -40px; right: -40px;
    width: 180px; height: 180px; border-radius: 50%;
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
    color: var(--muted); font-size: 13.5px; line-height: 1.65; margin: 0;
}

.form-card-body {
    padding: 32px;
}

.form-field { margin-bottom: 22px; }
.form-field:last-child { margin-bottom: 0; }
.form-field label {
    display: block; font-size: 13px; font-weight: 800; color: var(--ink-2); margin-bottom: 8px;
}
.form-field label .req { color: var(--danger); margin-left: 2px; }

.form-input-wrap { position: relative; }
.form-input-icon {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    color: var(--light); font-size: 14px; pointer-events: none;
}
.form-input {
    width: 100%; height: 46px; padding: 0 16px;
    border: 1.5px solid var(--border-2); border-radius: var(--r-md);
    font-size: 14px; color: var(--ink); background: var(--surface);
    outline: none; transition: all .18s ease; font-family: inherit;
}
.form-input.has-icon { padding-left: 42px; }
.form-input::placeholder { color: var(--light); }
.form-input:focus {
    border-color: var(--forest-mid); box-shadow: 0 0 0 3px rgba(0,87,59,.1);
}
.form-hint { display: block; margin-top: 6px; font-size: 12.5px; color: var(--muted); }
.form-error { display: block; margin-top: 6px; font-size: 12.5px; font-weight: 700; color: var(--danger); }

.form-card-footer {
    display: flex; align-items: center; justify-content: flex-end; gap: 12px;
    padding: 20px 32px; background: var(--surface-alt);
    border-top: 1px solid var(--border);
}

.btn-form-cancel {
    height: 44px; padding: 0 20px; border-radius: var(--r-md);
    background: var(--surface); border: 1.5px solid var(--border-2);
    color: var(--tx); font-size: 13.5px; font-weight: 700; text-decoration: none;
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .15s ease;
}
.btn-form-cancel:hover {
    background: var(--surface-hov); color: var(--ink); text-decoration: none;
}

.btn-form-submit {
    height: 44px; padding: 0 24px; border-radius: var(--r-md);
    background: var(--forest); border: none; color: #fff;
    font-size: 13.5px; font-weight: 700; cursor: pointer;
    box-shadow: 0 6px 18px rgba(0,61,45,.22);
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .18s ease;
}
.btn-form-submit:hover {
    background: var(--forest-deep); transform: translateY(-1px);
    box-shadow: 0 10px 24px rgba(0,46,34,.28);
}

@media (max-width: 767.98px) {
    .page-users .content-header { padding: 20px 16px 0; }
    .page-users section.content { padding: 14px 16px 28px; }
    .form-card-head { padding: 22px 20px 18px; }
    .form-card-body { padding: 22px 20px; }
    .form-card-footer { padding: 16px 20px; flex-direction: column-reverse; }
    .btn-form-cancel, .btn-form-submit { width: 100%; }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="form-wrap">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jurnal.index') }}">Jurnal P3M</a></li>
                <li class="breadcrumb-item active">Edit Jurnal</li>
            </ol>
        </div>
    </div>

    <section class="content">
        <div class="form-wrap">
            <form action="{{ route('jurnal.update', ['id' => $jurnal->id]) }}" method="POST" class="form-card">
                @csrf
                @method('PUT')

                <div class="form-card-head">
                    <span class="card-eyebrow">Seputar P3M</span>
                    <h1 class="card-head-title">Edit Jurnal P3M</h1>
                    <p class="card-head-sub">Perbarui judul artikel karya ilmiah atau tautan web jurnal yang telah diindeks.</p>
                </div>

                <div class="form-card-body">
                    <div class="form-field">
                        <label for="jurnalname">Judul Jurnal <span class="req">*</span></label>
                        <input type="text" name="jurnalname" id="jurnalname" class="form-input"
                               placeholder="Contoh: Implementasi Metode Prototype pada Pembuatan Website..."
                               value="{{ old('jurnalname', $jurnal->jurnalname) }}" required autofocus>
                        <span class="form-hint">Tuliskan judul lengkap publikasi ilmiah atau artikel penelitian.</span>
                        @error('jurnalname')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field mb-0">
                        <label for="link">Tautan / URL Jurnal <span class="req">*</span></label>
                        <div class="form-input-wrap">
                            <i class="fas fa-link form-input-icon"></i>
                            <input type="url" name="link" id="link" class="form-input has-icon"
                                   placeholder="https://scholar.google.com/..."
                                   value="{{ old('link', $jurnal->link) }}" required>
                        </div>
                        <span class="form-hint">Dapat berupa tautan Google Scholar, SINTA, Scopus, DOAJ, atau OJS resmi.</span>
                        @error('link')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-card-footer">
                    <a href="{{ route('jurnal.index') }}" class="btn-form-cancel">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-form-submit">
                        <i class="fas fa-save"></i> Perbarui Jurnal
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection