@extends('master')

@section('konten')
    <link rel="stylesheet" href="{{ asset('assets/css/detailpesertauji.css') }}">

<div style="margin: 30px;">
    <!-- Judul Halaman -->
    <h1 class="page-title">📊 Detail Peserta Asesmen</h1>
    <hr class="blue-line">

    <!-- Card Profil Peserta -->
    <div class="card" style="display: flex; align-items: center; gap: 20px;">
        <!-- Foto Profil -->
        <div style="width: 80px; height: 80px; background: #2F3E6E; color: white; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 28px; font-weight: bold;">
            {{ strtoupper(substr($peserta->nama, 0, 2)) }}
        </div>
        <!-- Info Peserta -->
        <div style="flex: 1;">
            <h2 style="font-size: 22px; font-weight: bold;">{{ $peserta->nama }}</h2>
            <p style="color: #555;">Siswa Kelas {{ $peserta->kelas }}</p>
            <span class="status success">✔ Selesai Asesmen</span>
        </div>
        <a href="#" class="btn" style="background: #0284C7;">Lihat Hasil</a>
    </div>

    <!-- Informasi & Status -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <!-- Informasi Pribadi -->
        <div class="card">
            <h3 class="section-title">🔍 Informasi Pribadi</h3>
            <div class="info-list">
                <div class="info-item"><span>Nama Lengkap:</span> <span>{{ $peserta->nama }}</span></div>
                <div class="info-item"><span>NIS:</span> <span>{{ $peserta->nis }}</span></div>
                <div class="info-item"><span>Kelas:</span> <span>{{ $peserta->kelas }}</span></div>
                <div class="info-item"><span>Skema Sertifikasi:</span> <span>{{ $peserta->skema ?? 'Sinematografi Dasar' }}</span></div>
            </div>
        </div>

        <!-- Status Asesmen -->
        <div class="card">
            <h3 class="section-title">✅ Status Asesmen</h3>
            <p>Status Portofolio: <span class="status success">● Sudah Upload</span></p>
            <p>Status Kegiatan: <span class="status success">● Sudah Upload</span></p>
            <p>Progres:</p>
            <div style="width: 100%; background: #E5E5E5; border-radius: 10px; height: 10px; margin-top: 5px;">
                <div style="width: 100%; height: 10px; background: #2F764B; border-radius: 10px;"></div>
            </div>
            <p style="margin-top: 10px;">Tanggal Upload: <strong>28 Juni 2025</strong></p>
        </div>
    </div>

    <!-- Dokumen Asesmen -->
    <div class="card">
        <h3 class="section-title">📂 Dokumen Asesmen</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="card" style="box-shadow: none; border: 1px solid #ddd;">
                <h4>File Portofolio</h4>
                <div class="file-details">
                    <p>Nama File: <strong>portofolio_{{ strtolower($peserta->nama) }}.pdf</strong></p>
                    <p>Ukuran: 2.4 MB</p>
                    <p>Upload: 28 Juni 2025</p>
                </div>
                <button class="btn btn-download">⬇ Download File</button>
            </div>
            <div class="card" style="box-shadow: none; border: 1px solid #ddd;">
                <h4>File Kegiatan</h4>
                <div class="file-details">
                    <p>Nama File: <strong>kegiatan_{{ strtolower($peserta->nama) }}.pdf</strong></p>
                    <p>Ukuran: 2.4 MB</p>
                    <p>Upload: 28 Juni 2025</p>
                </div>
                <button class="btn btn-download">⬇ Download File</button>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="back-btn">
        <a href="{{ route('datapesertauji') }}" class="btn btn-back">← Kembali</a>
    </div>
</div>
@endsection
