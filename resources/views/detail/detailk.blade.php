@extends($layout)

@section('css')
<style>
/* ================================================================
   P3M — Detail Laporan Page — Premium SaaS Redesign
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
    --info:         #0284c7;
    --info-soft:    #f0f9ff;
    --r-sm: 8px; --r-md: 12px; --r-lg: 16px; --r-xl: 20px; --r-2xl: 24px;
}

/* Page Shell */
.content-wrapper {
    background: radial-gradient(ellipse 70% 40% at 100% 0%, rgba(0,93,59,.04), transparent),
                linear-gradient(180deg, #f2f8f5 0%, #f7faf8 100%);
    min-height: calc(100vh - 78px);
}
.content-header { padding: 26px 28px 16px; }
.content { padding: 0 28px 36px; }

/* Breadcrumb */
.breadcrumb {
    background: transparent; padding: 0; margin: 0;
    font-size: 12.5px; font-weight: 600;
}
.breadcrumb-item a { color: var(--forest); text-decoration: none; transition: opacity .18s; }
.breadcrumb-item a:hover { opacity: .75; }
.breadcrumb-item.active { color: var(--muted); }
.breadcrumb-item + .breadcrumb-item::before { content: "/"; padding: 0 8px; color: var(--border-2); }

/* Header Area */
.page-header-wrap {
    display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; flex-wrap: wrap;
    margin-bottom: 24px;
}
.page-title-group h1 {
    font-family: "Plus Jakarta Sans", "Inter", sans-serif;
    font-size: 26px; font-weight: 800; color: var(--ink);
    letter-spacing: -.03em; margin: 0 0 6px; line-height: 1.2;
}
.page-title-group p {
    color: var(--muted); font-size: 14px; margin: 0;
}
.btn-back {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 8px 16px; background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r-md); font-size: 13px; font-weight: 700; color: var(--tx);
    text-decoration: none; transition: all .2s; box-shadow: 0 2px 6px rgba(0,0,0,.04);
}
.btn-back:hover {
    background: var(--surface-hov); border-color: var(--border-2); color: var(--ink);
    transform: translateY(-1px);
}

/* Detail Card */
.detail-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r-xl); box-shadow: 0 12px 32px rgba(3,50,33,.06);
    overflow: hidden; margin-bottom: 24px;
}
.detail-card-head {
    padding: 24px 32px; border-bottom: 1px solid var(--border);
    background: linear-gradient(112deg, #ffffff 55%, #f0faf5 100%);
}
.detail-card-body { padding: 32px; }

/* Typo */
.section-title {
    font-size: 16px; font-weight: 800; color: var(--ink); margin: 0 0 16px;
    display: flex; align-items: center; gap: 8px;
}
.section-title i { color: var(--forest-mid); font-size: 15px; }

/* Grid Layout */
.detail-grid {
    display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 40px;
}
@media (max-width: 991.98px) {
    .detail-grid { grid-template-columns: 1fr; gap: 32px; }
}

/* Main Info */
.info-main h2 {
    font-size: 22px; font-weight: 800; color: var(--ink); margin: 0 0 8px; line-height: 1.3;
}
.info-meta {
    display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
}
.meta-badge {
    display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px;
    background: var(--surface-alt); border: 1px solid var(--border); border-radius: 99px;
    font-size: 12px; font-weight: 700; color: var(--muted);
}
.meta-badge i { color: var(--gold); }

/* Stats Box */
.stats-wrap {
    display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 32px;
}
.stat-box {
    background: var(--surface-alt); border: 1px solid var(--border);
    border-radius: var(--r-md); padding: 16px 20px;
    display: flex; flex-direction: column; justify-content: center;
}
.stat-label { font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px; }
.stat-value { font-size: 18px; font-weight: 800; color: var(--ink); }

/* Person List */
.person-group { margin-bottom: 32px; }
.person-item {
    display: flex; align-items: flex-start; gap: 16px; padding: 16px;
    background: var(--surface-alt); border: 1px solid var(--border);
    border-radius: var(--r-md); margin-bottom: 12px; transition: background .2s;
}
.person-item:hover { background: var(--surface-hov); }
.person-avatar {
    width: 48px; height: 48px; border-radius: 50%;
    background: var(--forest-soft); color: var(--forest);
    display: flex; align-items: center; justify-content: center; font-size: 20px;
    flex-shrink: 0; border: 1px solid #c2dece;
}
.person-info { flex: 1; min-width: 0; }
.person-name { font-size: 15px; font-weight: 800; color: var(--ink); margin-bottom: 4px; display: block; }
.person-role { font-size: 13px; font-weight: 600; color: var(--forest-mid); margin-bottom: 8px; display: block; }
.person-details {
    display: flex; flex-wrap: wrap; gap: x; font-size: 12.5px; color: var(--muted); gap: 12px;
}
.person-details span { display: inline-flex; align-items: center; gap: 6px; }

/* Attachments */
.attach-wrap { display: flex; flex-wrap: wrap; gap: 16px; }
.attach-card {
    width: 140px; border: 1px solid var(--border); border-radius: var(--r-md);
    overflow: hidden; background: var(--surface-alt); text-decoration: none;
    transition: all .2s; display: flex; flex-direction: column;
}
.attach-card:hover {
    border-color: var(--forest-mid); transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,61,45,.08);
}
.attach-preview {
    height: 100px; background: #eaf0ed; display: flex; align-items: center; justify-content: center;
    color: var(--light); font-size: 32px; overflow: hidden; position: relative;
}
.attach-preview img { width: 100%; height: 100%; object-fit: cover; }
.attach-preview i.pdf-icon { color: #d94b4b; }
.attach-info {
    padding: 10px 12px; border-top: 1px solid var(--border); background: var(--surface);
}
.attach-name {
    font-size: 12px; font-weight: 700; color: var(--ink);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; margin-bottom: 2px;
}
.attach-type { font-size: 11px; color: var(--muted); }

/* History Table */
.history-table { width: 100%; border-collapse: collapse; }
.history-table th {
    padding: 12px 16px; background: var(--surface-alt); border-bottom: 1px solid var(--border);
    font-size: 11px; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; text-align: left;
}
.history-table td {
    padding: 16px; border-bottom: 1px solid var(--border); font-size: 13.5px; color: var(--tx);
}
.history-table tr:last-child td { border-bottom: none; }
.status-badge {
    display: inline-flex; padding: 4px 10px; border-radius: 99px; font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .05em;
}
.status-approve { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.status-non-approve { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
.status-proses { background: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }

@media (max-width: 767.98px) {
    .content-header { padding: 20px 16px 12px; }
    .content { padding: 0 16px 24px; }
    .detail-card-head { padding: 20px 20px; }
    .detail-card-body { padding: 20px; }
    .stats-wrap { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $pagetitle }}</li>
        </ol>
    </div>

    <section class="content">
        <div class="page-header-wrap">
            <div class="page-title-group">
                <h1>{{ $pagetitle }}</h1>
                <p>Informasi detail mengenai laporan P3M.</p>
            </div>
            <a href="javascript:history.back()" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="detail-card">
            <div class="detail-card-body detail-grid">
                
                {{-- Kiri: Info Utama & Dosen --}}
                <div class="grid-left">
                    <div class="info-main">
                        <h2>{{ $penelitians->judul }}</h2>
                        <div class="info-meta">
                            <span class="meta-badge"><i class="fas fa-tag"></i> {{ $penelitians->jeniskategori }}</span>
                            <span class="meta-badge"><i class="fas fa-microscope"></i> {{ $penelitians->bidang }}</span>
                        </div>
                    </div>

                    <div class="stats-wrap">
                        <div class="stat-box">
                            <span class="stat-label">Biaya Penelitian</span>
                            <span class="stat-value">Rp {{ number_format((float)$penelitians->biaya, 0, ',', '.') }}</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-label">Lama Penelitian</span>
                            <span class="stat-value">{{ $penelitians->lamapenelitian }} Hari</span>
                        </div>
                    </div>

                    <div class="person-group">
                        <h3 class="section-title"><i class="fas fa-user-tie"></i> Ketua Peneliti / Dosen</h3>
                        <div class="person-item">
                            <div class="person-avatar"><i class="fas fa-user"></i></div>
                            <div class="person-info">
                                <span class="person-name">{{ $penelitians->ketua }}</span>
                                <span class="person-role">
                                    {{ $penelitians->jabatan === 'DR' ? 'Direktur' : ($penelitians->jabatan === 'LT' ? 'Wakil Direktur' : ($penelitians->jabatan === 'KP' ? 'Ketua Program Studi' : ($penelitians->jabatan ==='DS' ? 'Dosen' : '-'))) }}
                                </span>
                                <div class="person-details">
                                    <span><i class="fas fa-id-card"></i> NIDN: {{ $penelitians->nidn }}</span>
                                    <span><i class="fas fa-venus-mars"></i> {{ $penelitians->jeniskelamin === 'P' ? 'Perempuan' : ($penelitians->jeniskelamin === 'L' ? 'Laki-laki' : '-') }}</span>
                                    <span><i class="fas fa-graduation-cap"></i> {{ $penelitians->prodi === 'R' ? 'RPL' : ($penelitians->prodi === 'A' ? 'ABI' :  ($penelitians->prodi === 'AK' ? 'AKP' : ($penelitians->prodi === 'AB' ? 'Bisnis Digital' : ($penelitians->prodi === 'AP' ? 'Agro Peternakan' : '-')) )) }}</span>
                                    <span><i class="fas fa-phone"></i> {{ $penelitians->telp }}</span>
                                </div>
                                <div class="person-details mt-2">
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $penelitians->alamat }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- Kanan: Anggota & File --}}
                <div class="grid-right">
                    
                    <div class="person-group">
                        <h3 class="section-title"><i class="fas fa-users"></i> Anggota Tim</h3>
                        @if($penelitians->anggotap3m && $penelitians->anggotap3m->count() > 0)
                            @foreach($penelitians->anggotap3m as $index => $anggota)
                            <div class="person-item" style="padding: 12px;">
                                <div class="person-avatar" style="width: 40px; height: 40px; font-size: 16px;"><i class="fas fa-user"></i></div>
                                <div class="person-info">
                                    <span class="person-name" style="font-size: 14px;">{{ $anggota->nama }}</span>
                                    <div class="person-details" style="font-size: 11.5px; gap: 8px;">
                                        @if ($anggota->jabatan)
                                        <span><i class="fas fa-briefcase"></i> {{ $anggota->jabatan === 'DR' ? 'Direktur' : ($anggota->jabatan === 'LT' ? 'Wakil Direktur' : ($anggota->jabatan === 'KP' ? 'Kaprodi' : ($anggota->jabatan ==='DS' ? 'Dosen' : ($anggota->jabatan === 'MHS' ? 'Mahasiswa' : '-')))) }}</span>
                                        @endif
                                        @if ($anggota->prodi)
                                        <span><i class="fas fa-graduation-cap"></i> {{ $anggota->prodi === 'R' ? 'RPL' : ($anggota->prodi === 'A' ? 'ABI' :  ($anggota->prodi === 'AK' ? 'AKP' : ($anggota->prodi === 'AB' ? 'Bisnis Digital' : ($anggota->prodi === 'AP' ? 'Agro Peternakan' : '-')) )) }}</span>
                                        @endif
                                        @if ($anggota->nim)
                                        <span><i class="fas fa-id-badge"></i> {{ $anggota->nim }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted text-sm">Tidak ada data anggota.</p>
                        @endif
                    </div>

                    <div class="person-group">
                        <h3 class="section-title"><i class="fas fa-paperclip"></i> Dokumen Lampiran</h3>
                        <div class="attach-wrap">
                            @if($penelitians->uppdf)
                            <a href="{{ route('submission.document.download', ['type' => $documentType, 'id' => $penelitians->id]) }}" class="attach-card">
                                <div class="attach-preview"><i class="fas fa-file-pdf pdf-icon"></i></div>
                                <div class="attach-info">
                                    <span class="attach-name">Laporan.pdf</span>
                                    <span class="attach-type">Unduh Dokumen</span>
                                </div>
                            </a>
                            @endif

                            @if($penelitians->foto)
                            <a href="{{ asset('storage/photo-upp3m/' . $penelitians->foto) }}" target="_blank" class="attach-card">
                                <div class="attach-preview">
                                    <img src="{{ asset('storage/photo-upp3m/' . $penelitians->foto) }}" alt="Foto Laporan">
                                </div>
                                <div class="attach-info">
                                    <span class="attach-name">Foto Kegiatan</span>
                                    <span class="attach-type">Lihat Gambar</span>
                                </div>
                            </a>
                            @endif

                            @if(!$penelitians->uppdf && !$penelitians->foto)
                                <p class="text-muted text-sm">Tidak ada dokumen lampiran tersedia.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Riwayat Keputusan Admin --}}
        @if(isset($statusHistories) && $statusHistories->isNotEmpty())
        <div class="detail-card">
            <div class="detail-card-head" style="padding: 16px 24px;">
                <h3 class="section-title" style="margin:0;"><i class="fas fa-history"></i> Riwayat Keputusan Admin</h3>
            </div>
            <div class="table-responsive">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Waktu</th>
                            <th width="15%">Dari Status</th>
                            <th width="15%">Ke Status</th>
                            <th width="20%">Oleh Admin</th>
                            <th width="30%">Catatan / Alasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statusHistories as $i => $h)
                        @php
                            $badgePrev = match($h->previous_status) {
                                'approve'     => 'status-approve',
                                'non-approve' => 'status-non-approve',
                                default       => 'status-proses',
                            };
                            $badgeNext = match($h->status) {
                                'approve'     => 'status-approve',
                                'non-approve' => 'status-non-approve',
                                default       => 'status-proses',
                            };
                        @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="text-muted text-sm">{{ $h->decided_at->translatedFormat('d M Y, H:i') }}</td>
                            <td><span class="status-badge {{ $badgePrev }}">{{ ucfirst($h->previous_status) }}</span></td>
                            <td><span class="status-badge {{ $badgeNext }}">{{ ucfirst($h->status) }}</span></td>
                            <td class="font-weight-bold">{{ optional($h->decisionMaker)->name ?? '-' }}</td>
                            <td>{{ $h->reason ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </section>
</div>
@endsection
@section('scripts')

@endsection
