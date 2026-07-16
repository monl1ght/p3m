@extends('layout.main')

@section('css')
<link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">

<style>
    :root {
        --p3m-blue: #2563eb;
        --p3m-blue-dark: #1d4ed8;
        --p3m-gold: #d5a72f;
        --p3m-slate-900: #0f172a;
        --p3m-slate-700: #334155;
        --p3m-slate-500: #64748b;
        --p3m-border: #e2e8f0;
        --p3m-border-soft: #eef2f7;
        --p3m-bg-soft: #f8fafc;
    }

    .agenda-form-page .content-header {
        padding-top: 22px;
        padding-bottom: 6px;
    }

    .agenda-form-page .content {
        padding-top: 8px;
    }

    .agenda-form-wrap {
        width: 100%;
        max-width: 980px;
        margin: 0 auto;
    }

    .agenda-form-panel {
        overflow: hidden;
        border: 1px solid var(--p3m-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .055);
    }

    .agenda-form-header {
        padding: 20px 22px;
        border-bottom: 1px solid var(--p3m-border);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .agenda-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 7px;
        color: var(--p3m-blue);
        font-size: 11.25px;
        font-weight: 900;
        letter-spacing: .11em;
        text-transform: uppercase;
    }

    .agenda-kicker::before {
        content: "";
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: var(--p3m-gold);
    }

    .agenda-form-header h1 {
        margin: 0;
        color: var(--p3m-slate-900);
        font-family: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
        font-size: clamp(1.38rem, 1.65vw, 1.82rem);
        line-height: 1.16;
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .agenda-form-header p {
        margin: 7px 0 0;
        color: var(--p3m-slate-500);
        font-size: 13.25px;
        line-height: 1.6;
    }

    .agenda-form-body {
        padding: 22px;
    }

    .agenda-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .agenda-form-group {
        margin-bottom: 18px;
    }

    .agenda-form-group-full {
        grid-column: 1 / -1;
    }

    .agenda-form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--p3m-slate-900);
        font-size: 13.25px;
        font-weight: 850;
    }

    .agenda-form-group .form-control {
        min-height: 44px;
        border: 1px solid #dbe4f0;
        border-radius: 13px;
        color: var(--p3m-slate-900);
        box-shadow: none;
    }

    .agenda-form-group .form-control:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .agenda-form-group small {
        display: block;
        margin-top: 6px;
        color: #dc2626;
        font-weight: 650;
    }

    .note-editor.note-frame {
        border: 1px solid #dbe4f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: none;
    }

    .note-toolbar {
        background: var(--p3m-bg-soft) !important;
        border-bottom: 1px solid var(--p3m-border-soft) !important;
    }

    .agenda-form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 22px 22px;
        border-top: 1px solid var(--p3m-border-soft);
        background: var(--p3m-bg-soft);
    }

    .btn-agenda-cancel,
    .btn-agenda-submit {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: 13px;
        font-weight: 850;
        transition: .22s ease;
    }

    .btn-agenda-cancel {
        background: #ffffff;
        border: 1px solid var(--p3m-border);
        color: var(--p3m-slate-700);
    }

    .btn-agenda-cancel:hover {
        background: #ffffff;
        color: var(--p3m-slate-900);
        transform: translateY(-1px);
    }

    .btn-agenda-submit {
        background: var(--p3m-blue);
        border: 1px solid var(--p3m-blue);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .17);
    }

    .btn-agenda-submit:hover {
        background: var(--p3m-blue-dark);
        border-color: var(--p3m-blue-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    @media (max-width: 767.98px) {
        .agenda-form-grid {
            grid-template-columns: 1fr;
        }

        .agenda-form-body {
            padding: 16px;
        }

        .agenda-form-footer {
            flex-direction: column-reverse;
            padding: 16px;
        }

        .btn-agenda-cancel,
        .btn-agenda-submit {
            width: 100%;
        }
    }
</style>

@endsection

@section('content')
<div class="content-wrapper agenda-form-page">
    <div class="content-header">
        <div class="container-fluid">
            <div class="agenda-form-wrap">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dash.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></li>
                    <li class="breadcrumb-item active">Edit Agenda</li>
                </ol>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="agenda-form-wrap">
                <form action="{{ route('agenda.update', ['id' => $agenda->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="agenda-form-panel">
                        <div class="agenda-form-header">
                            <span class="agenda-kicker">Agenda P3M</span>
                            <h1>Edit Agenda Kegiatan</h1>
                            <p>Perbarui informasi agenda kegiatan, jadwal, lokasi, dan keterangan kegiatan.</p>
                        </div>

                        <div class="agenda-form-body">
                            <div class="agenda-form-grid">
                                <div class="agenda-form-group agenda-form-group-full">
                                    <label for="title">Nama Agenda</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $agenda->title) }}" placeholder="Masukkan nama agenda" required>
                                    @error('title')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="agenda-form-group">
                                    <label for="date">Tanggal Pelaksanaan</label>
                                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $agenda->date) }}" required>
                                    @error('date')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="agenda-form-group">
                                    <label for="time">Waktu Pelaksanaan</label>
                                    <input type="time" name="time" id="time" class="form-control" value="{{ old('time', $agenda->time) }}" required>
                                    @error('time')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="agenda-form-group agenda-form-group-full">
                                    <label for="lokasi">Lokasi Agenda</label>
                                    <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ old('lokasi', $agenda->lokasi) }}" placeholder="Masukkan lokasi agenda" required>
                                    @error('lokasi')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="agenda-form-group agenda-form-group-full mb-0">
                                    <label for="keterangan-textarea">Keterangan Agenda</label>
                                    <textarea name="keterangan" id="keterangan-textarea" class="form-control">{{ old('keterangan', $agenda->keterangan) }}</textarea>
                                    @error('keterangan')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="agenda-form-footer">
                            <a href="{{ route('agenda.index') }}" class="btn btn-agenda-cancel">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-agenda-submit">
                                Simpan Perubahan
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function() {
        $('#keterangan-textarea').summernote({
            height: 260,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>
@endsection
