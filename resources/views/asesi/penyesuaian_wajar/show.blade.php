@extends('master')

@section('title', 'FR.AK.07 - Detail Penyesuaian Wajar')

@section('konten')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </svg>
        </div>
        <h1 class="display-6 fw-bold text-dark">Detail Penyesuaian Wajar dan Beralasan</h1>
        <p class="text-secondary">FR.AK.07 – Data penyesuaian untuk asesi</p>
        <span class="badge bg-{{ $penyesuaian->status == 'selesai' ? 'success' : ($penyesuaian->status == 'draf' ? 'secondary' : ($penyesuaian->status == 'menunggu_asesi' ? 'warning' : 'info')) }} px-3 py-2 rounded-pill">
            Status: 
            @if($penyesuaian->status == 'menunggu_asesi')
                Menunggu Tanda Tangan Anda
            @elseif($penyesuaian->status == 'menunggu_asesor')
                Menunggu Tanda Tangan Asesor
            @elseif($penyesuaian->status == 'draf')
                Draf (Asesor)
            @elseif($penyesuaian->status == 'selesai')
                Selesai
            @else
                {{ ucfirst($penyesuaian->status) }}
            @endif
        </span>
    </div>

    <!-- Informasi Sertifikasi (Read-only) -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle text-primary" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Informasi Sertifikasi</h5>
                    <p class="text-secondary mb-0 small">Data skema, asesi, dan asesor</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted">Skema Sertifikasi</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $penyesuaian->permohonan->skema->nama_skema ?? '-' }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Judul</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $penyesuaian->permohonan->skema->judul_skema ?? $penyesuaian->permohonan->skema->nama_skema }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Nomor Skema</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $penyesuaian->permohonan->skema->kode_skema ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted">TUK</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $penyesuaian->permohonan->persetujuan->tuk->nama_tuk ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted">Nama Asesor</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $penyesuaian->asesor->user->name ?? $penyesuaian->asesor->nama_asesor ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted">Nama Asesi</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $penyesuaian->asesi->user->name ?? $penyesuaian->asesi->nama_asesi ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted">Tanggal Dibuat</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $penyesuaian->created_at->format('d-m-Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Potensi Asesi -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-check text-primary" viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514zM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Potensi Asesi</h5>
                    <p class="text-secondary mb-0 small">Potensi yang dipilih asesor</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            @forelse($penyesuaian->potensi as $potensi)
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" disabled {{ $potensi->dipilih ? 'checked' : '' }}>
                    <label class="form-check-label">
                        {{ $potensi->teks_potensi }}
                    </label>
                </div>
            @empty
                <p class="text-muted fst-italic">Tidak ada potensi yang dipilih.</p>
            @endforelse
        </div>
    </div>

    <!-- Tabel Modifikasi (Item 1-8) -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list-check text-primary" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Mengidentifikasi Persyaratan Modifikasi dan Kontekstualisasi</h5>
                    <p class="text-secondary mb-0 small">Data yang diisi asesor</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:30%">Mengidentifikasi</th>
                            <th style="width:15%">Diperlukan penyesuaian?</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $itemLabels = [
                                1 => 'Keterbatasan asesi terhadap persyaratan bahasa, literasi, numerasi.',
                                2 => 'Penyediaan dukungan pembaca, penerjemah, pelayan, penulis.',
                                3 => 'Penggunaan teknologi adaptif atau peralatan khusus.',
                                4 => 'Pelaksanaan asesmen secara fleksibel karena alasan keletihan atau keperluan pengobatan.',
                                5 => 'Penyediaan peralatan asesmen berupa braille, audio/video-tape.',
                                6 => 'Penyesuaian tempat fisik/lingkungan asesmen',
                                7 => 'Pertimbangan umur/usia lanjut/gender asesi.',
                                8 => 'Pertimbangan budaya/tradisi/agama.',
                            ];
                            $items = $penyesuaian->items->keyBy('nomor_item');
                        @endphp
                        @foreach(range(1,8) as $i)
                            @php $item = $items->get($i); @endphp
                            <tr>
                                <td class="align-middle text-center">{{ $i }}</td>
                                <td class="align-middle">{{ $itemLabels[$i] ?? '-' }}</td>
                                <td class="align-middle">
                                    @if($item && $item->dipilih)
                                        <span class="badge bg-success">Ya</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item && $item->dipilih)
                                        @php
                                            $keteranganBaku = $item->keteranganItems->where('is_lainnya', false)->pluck('keterangan');
                                            $keteranganLain = $item->keteranganItems->where('is_lainnya', true)->pluck('keterangan');
                                        @endphp
                                        @if($keteranganBaku->isNotEmpty())
                                            <ul class="mb-2">
                                                @foreach($keteranganBaku as $k)
                                                    <li>{{ $k }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if($keteranganLain->isNotEmpty())
                                            <div class="mt-2">
                                                <strong>Lainnya:</strong>
                                                <ul>
                                                    @foreach($keteranganLain as $k)
                                                        <li>{{ $k }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-muted fst-italic">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Hasil Penyesuaian -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check2-circle text-primary" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Hasil Penyesuaian yang wajar dan beralasan disepakati menggunakan</h5>
                    <p class="text-secondary mb-0 small">Kesepakatan asesor dan asesi</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="mb-3">
                <label class="form-label text-muted">1) Acuan Pembanding Asesmen</label>
                <p class="border p-3 rounded bg-light">{{ $penyesuaian->acuan_pembanding ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label text-muted">2) Metode Asesmen</label>
                <p class="border p-3 rounded bg-light">{{ $penyesuaian->metode_asesmen ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label text-muted">3) Instrumen Asesmen</label>
                <p class="border p-3 rounded bg-light">{{ $penyesuaian->instrumen_asesmen ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Bagian Tanda Tangan -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pen text-primary" viewBox="0 0 16 16">
                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Tanda Tangan Persetujuan</h5>
                    <p class="text-secondary mb-0 small">Status penandatanganan</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            @php $persetujuan = $penyesuaian->persetujuan; @endphp

            {{-- Jika status menunggu asesi dan asesi belum tanda tangan, tampilkan form --}}
            @if($penyesuaian->status == 'menunggu_asesi' && (!$persetujuan || !$persetujuan->ttd_asesi))
                {{-- Form Tanda Tangan Asesi --}}
                <form method="POST" action="{{ route('asesi.penyesuaian_wajar.signature', $penyesuaian->id_penyesuaian) }}" id="signatureForm">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="setuju" value="1" id="setujuCheckbox" required>
                                <label class="form-check-label fw-semibold" for="setujuCheckbox">
                                    Saya menyetujui penyesuaian yang wajar dan beralasan ini
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="tgl_ttd_asesi" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="canvas-wrapper mb-2">
                                <canvas id="ttd-asesi" class="ttd-canvas" width="400" height="160"></canvas>
                                <span class="canvas-placeholder">Tanda tangan di sini</span>
                            </div>
                            <input type="hidden" name="ttd_asesi" id="ttd-asesi-input" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearCanvas('ttd-asesi')">Hapus</button>
                        <button type="submit" id="submitSignature" class="btn btn-sm btn-primary" disabled>Simpan Tanda Tangan</button>
                    </div>
                </form>
            @else
                {{-- Tampilkan tanda tangan jika sudah ada --}}
                <div class="row">
                    <div class="col-md-6 text-center mb-3">
                        <div class="border rounded p-3 bg-light h-100">
                            <h6 class="fw-bold mb-3">Asesi (Anda)</h6>
                            @if($persetujuan && $persetujuan->ttd_asesi)
                                <img src="{{ asset('storage/' . $persetujuan->ttd_asesi) }}" alt="Tanda Tangan Asesi" class="img-fluid mb-2" style="max-height: 100px;">
                                <p class="mb-0">Tanggal: {{ $persetujuan->tgl_ttd_asesi ? \Carbon\Carbon::parse($persetujuan->tgl_ttd_asesi)->format('d-m-Y') : '-' }}</p>
                            @else
                                <p class="text-muted fst-italic">Belum ditandatangani</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 text-center mb-3">
                        <div class="border rounded p-3 bg-light h-100">
                            <h6 class="fw-bold mb-3">Asesor</h6>
                            @if($persetujuan && $persetujuan->ttd_asesor)
                                <img src="{{ asset('storage/' . $persetujuan->ttd_asesor) }}" alt="Tanda Tangan Asesor" class="img-fluid mb-2" style="max-height: 100px;">
                                <p class="mb-0">Tanggal: {{ $persetujuan->tgl_ttd_asesor ? \Carbon\Carbon::parse($persetujuan->tgl_ttd_asesor)->format('d-m-Y') : '-' }}</p>
                            @else
                                <p class="text-muted fst-italic">Belum ditandatangani</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="button-group mt-4">
        <a href="{{ route('form_pra_assesmen') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

<style>
    /* ===== VARIABEL & RESET dengan warna utama #0b2f7c ===== */
    :root {
        --primary: #0b2f7c;
        --primary-dark: #08205c;
        --primary-light: #1a3e9c;
        --secondary: #6c757d;
        --success: #198754;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #212529;
        --font-sans: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    body {
        font-family: var(--font-sans);
        background-color: #f1f4f9;
    }

    .container-fluid {
        max-width: 1280px;
        margin: 0 auto;
    }

    .card {
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .card:hover {
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.08) !important;
    }

    .card-header {
        background: transparent;
        padding-bottom: 0;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1e293b;
        margin-bottom: 0.3rem;
    }

    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        background-color: #fff;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(11,47,124,0.15);
        outline: none;
    }

    .form-control:read-only {
        background-color: #f8f9fa;
    }

    .bg-primary {
        background-color: var(--primary) !important;
    }

    .bg-primary.bg-gradient {
        background: linear-gradient(145deg, var(--primary), var(--primary-dark)) !important;
    }

    .bg-primary.bg-opacity-10 {
        background-color: rgba(11,47,124,0.1) !important;
    }

    .text-primary {
        color: var(--primary) !important;
    }

    .border-primary {
        border-color: var(--primary) !important;
    }

    .btn-back {
        background-color: #fff;
        color: var(--secondary);
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        border: 1.5px solid #dee2e6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background-color: #f1f3f5;
        color: #495057;
        border-color: #ced4da;
    }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .badge {
        font-weight: 500;
        border-radius: 2rem;
        padding: 0.5rem 1rem;
    }

    /* Canvas wrapper */
    .canvas-wrapper {
        position: relative;
        width: 100%;
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        border: 2px dashed #d0d9e8;
    }

    .ttd-canvas {
        display: block;
        width: 100%;
        height: 160px;
        background: #ffffff;
        cursor: crosshair;
        touch-action: none;
    }

    .canvas-placeholder {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        color: #9aa9b9;
        font-size: 0.9rem;
        background: rgba(255,255,255,0.7);
        padding: 4px 12px;
        border-radius: 40px;
        pointer-events: none;
        backdrop-filter: blur(2px);
    }

    .btn-outline-danger,
    .btn-primary {
        border-width: 1.5px;
        border-radius: 2rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-outline-danger:hover {
        background-color: var(--danger);
        color: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        box-shadow: 0 8px 18px rgba(11,47,124,0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), #061944);
        transform: translateY(-2px);
        box-shadow: 0 12px 22px rgba(11,47,124,0.35);
    }

    @media (max-width: 768px) {
        .button-group {
            justify-content: center;
        }
    }
</style>

<script>
    // Fungsi inisialisasi signature canvas (diadaptasi dari halaman persetujuan)
    function initSignature(canvasId, inputId) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let drawing = false;
        const VISIBLE_HEIGHT = 160;

        function resizeCanvas() {
            const container = canvas.parentElement;
            const cssWidth = container.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = Math.round(cssWidth * ratio);
            canvas.height = Math.round(cssHeight * ratio);

            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';
        }

        function getPointerPos(evt) {
            const rect = canvas.getBoundingClientRect();
            let clientX, clientY;
            if (evt.touches && evt.touches.length > 0) {
                clientX = evt.touches[0].clientX;
                clientY = evt.touches[0].clientY;
            } else {
                clientX = evt.clientX;
                clientY = evt.clientY;
            }
            return {
                x: (clientX - rect.left) * (canvas.width / rect.width),
                y: (clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        function startDrawing(evt) {
            evt.preventDefault();
            drawing = true;
            const pos = getPointerPos(evt);
            ctx.beginPath();
            ctx.moveTo(pos.x / (canvas.width / canvas.clientWidth), pos.y / (canvas.height / canvas.clientHeight));
        }

        function drawMove(evt) {
            if (!drawing) return;
            evt.preventDefault();
            const pos = getPointerPos(evt);
            ctx.lineTo(pos.x / (canvas.width / canvas.clientWidth), pos.y / (canvas.height / canvas.clientHeight));
            ctx.stroke();
        }

        function stopDrawing() {
            drawing = false;
            ctx.beginPath();
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', drawMove);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);

        canvas.addEventListener('touchstart', startDrawing, { passive: false });
        canvas.addEventListener('touchmove', drawMove, { passive: false });
        canvas.addEventListener('touchend', stopDrawing);

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        window.clearCanvas = function(id) {
            const c = document.getElementById(id);
            if (!c) return;
            const ctx = c.getContext('2d');
            const container = c.parentElement;
            const cssWidth = container.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            c.width = Math.round(cssWidth * ratio);
            c.height = Math.round(cssHeight * ratio);
            ctx.setTransform(1,0,0,1,0,0);
            ctx.scale(ratio, ratio);
            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);
            document.getElementById(inputId).value = '';
            toggleSubmit();
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        const canvasId = 'ttd-asesi';
        const inputId = 'ttd-asesi-input';
        initSignature(canvasId, inputId);

        const setujuCheckbox = document.getElementById('setujuCheckbox');
        const submitBtn = document.getElementById('submitSignature');
        const canvas = document.getElementById(canvasId);

        function isCanvasBlank() {
            const ctx = canvas.getContext('2d');
            const pixelData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
            for (let i = 0; i < pixelData.length; i += 4) {
                if (pixelData[i] !== 255 || pixelData[i+1] !== 255 || pixelData[i+2] !== 255) {
                    return false;
                }
            }
            return true;
        }

        function toggleSubmit() {
            if (setujuCheckbox && submitBtn) {
                submitBtn.disabled = !(setujuCheckbox.checked && !isCanvasBlank());
            }
        }

        if (setujuCheckbox && submitBtn && canvas) {
            setujuCheckbox.addEventListener('change', toggleSubmit);
            canvas.addEventListener('mouseup', toggleSubmit);
            canvas.addEventListener('touchend', toggleSubmit);
        }

        const form = document.getElementById('signatureForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (setujuCheckbox && !setujuCheckbox.checked) {
                    e.preventDefault();
                    alert('Anda harus menyetujui penyesuaian ini terlebih dahulu.');
                    return;
                }
                if (isCanvasBlank()) {
                    e.preventDefault();
                    alert('Tanda tangan harus diisi.');
                    return;
                }
                document.getElementById(inputId).value = canvas.toDataURL('image/png');
            });
        }
    });
</script>
@endsection