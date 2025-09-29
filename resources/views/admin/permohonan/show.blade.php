@extends('master')

@section('title', 'Detail Permohonan Sertifikasi Asesi')

@section('konten')
<div class="container mt-4 my-5">
    <!-- Main Card Container -->
    <div class="main-card bg-white border-0 rounded-4 shadow-lg p-4 p-md-5">

        <!-- Header Section -->
        <div class="header-section mb-5">
            <div class="breadcrumb-wrapper mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.permohonan.index') }}"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.permohonan.index') }}">Permohonan</a></li>
                        <li class="breadcrumb-item active">FR.APL.02</li>
                    </ol>
                </nav>
            </div>
            
            <div class="text-center">
                <div class="logo-badge mx-auto mb-3" style="width:60px; height:60px; background: linear-gradient(135deg, #041562 0%, #0a2472 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(4, 21, 98, 0.3);">
                    <i class="fas fa-file-alt text-white fs-3"></i>
                </div>
                <h1 class="h3 fw-bold mb-2">Detail Permohonan Sertifikasi</h1>
                <p class="text-muted mb-3">Form Asesmen FR.APL.02</p>
                <span class="badge bg-gradient-primary px-4 py-2 rounded-pill">
                    <i class="fas fa-info-circle me-2"></i>Rincian Data Pemohon
                </span>
            </div>
        </div>

        <!-- Form mulai -->
        <form action="{{ route('admin.permohonan.update', $permohonan->id_permohonan) }}" method="POST">
            @csrf

            {{-- Data Pribadi --}}
            <div class="section-card mb-4">
                <div class="section-header">
                    <i class="fas fa-user me-2"></i>
                    <span>Data Pribadi</span>
                </div>
                <div class="section-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-id-card text-primary me-2"></i>Nama Lengkap</label>
                                <p>{{ $asesi->nama_lengkap }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-fingerprint text-primary me-2"></i>NIK</label>
                                <p>{{ $asesi->nik }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-birthday-cake text-primary me-2"></i>Tempat/Tgl Lahir</label>
                                <p>{{ $asesi->tempat_lahir }}, {{ $asesi->tgl_lahir }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-venus-mars text-primary me-2"></i>Jenis Kelamin</label>
                                <p>{{ $asesi->jenis_kelamin }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item">
                                <label><i class="fas fa-map-marker-alt text-primary me-2"></i>Alamat</label>
                                <p>{{ $asesi->alamat }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-phone text-primary me-2"></i>Telepon</label>
                                <p>{{ $asesi->telepon }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-envelope text-primary me-2"></i>Email</label>
                                <p>{{ $asesi->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-graduation-cap text-primary me-2"></i>Pendidikan Terakhir</label>
                                <p>{{ $asesi->pendidikan_terakhir }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Pekerjaan --}}
            <div class="section-card mb-4">
                <div class="section-header">
                    <i class="fas fa-building me-2"></i>
                    <span>Data Pekerjaan</span>
                </div>
                <div class="section-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-briefcase text-success me-2"></i>Nama Institusi</label>
                                <p>{{ $tuk->nama_tuk ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-map-marked-alt text-success me-2"></i>Alamat Instansi</label>
                                <p>{{ $tuk->alamat_tuk ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-phone-alt text-success me-2"></i>Telepon Instansi</label>
                                <p>{{ $tuk->telepon ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-envelope text-success me-2"></i>Email Instansi</label>
                                <p>{{ $tuk->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Sertifikasi --}}
            <div class="section-card mb-4">
                <div class="section-header">
                    <i class="fas fa-certificate me-2"></i>
                    <span>Data Sertifikasi</span>
                </div>
                <div class="section-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-award text-warning me-2"></i>Skema Sertifikasi</label>
                                <p>{{ $skema->nama_skema ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-bookmark text-warning me-2"></i>Judul Sertifikasi</label>
                                <p>{{ $skema->judul_skema ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-barcode text-warning me-2"></i>Nomor Skema</label>
                                <p>{{ $skema->kode_skema ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-bullseye text-warning me-2"></i>Tujuan Asesmen</label>
                                <p>{{ $permohonan->tujuan_asesmen }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label><i class="fas fa-flag text-warning me-2"></i>Status Permohonan</label>
                                <p>
                                    <span class="badge status-badge bg-{{ $permohonan->status=='Diajukan' ? 'warning' : ($permohonan->status=='Diterima' ? 'success' : 'danger') }}">
                                        @if($permohonan->status == 'Diajukan')
                                            <i class="fas fa-clock me-1"></i>
                                        @elseif($permohonan->status == 'Diterima')
                                            <i class="fas fa-check-circle me-1"></i>
                                        @else
                                            <i class="fas fa-times-circle me-1"></i>
                                        @endif
                                        {{ $permohonan->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Unit Kompetensi --}}
            <div class="section-card mb-4">
                <div class="section-header">
                    <i class="fas fa-list-check me-2"></i>
                    <span>Daftar Unit Kompetensi</span>
                </div>
                <div class="section-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 modern-table">
                            <thead>
                                <tr>
                                    <th width="60">No</th>
                                    <th>Kode Unit</th>
                                    <th>Judul Unit</th>
                                    <th>Standar Kompetensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($units as $i => $unit)
                                    <tr>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark">{{ $i + 1 }}</span>
                                        </td>
                                        <td><code class="text-primary">{{ $unit->kode_unit }}</code></td>
                                        <td class="fw-semibold">{{ $unit->judul_unit }}</td>
                                        <td>{{ $unit->standar_kompetensi }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fs-1 mb-2 d-block"></i>
                                            Belum ada unit kompetensi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Bukti Kelengkapan --}}
            <div class="section-card mb-4">
                <div class="section-header">
                    <i class="fas fa-folder-open me-2"></i>
                    <span>Bukti Kelengkapan Dokumen</span>
                </div>
                <div class="section-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 modern-table">
                            <thead>
                                <tr>
                                    <th width="60">No</th>
                                    <th>Jenis Dokumen</th>
                                    <th width="120" class="text-center">Lampiran</th>
                                    <th width="280">Status Kelengkapan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumen as $i => $d)
                                    <tr>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark">{{ $i + 1 }}</span>
                                        </td>
                                        <td>
                                            <i class="fas fa-file-alt text-muted me-2"></i>
                                            {{ $d->jenis }}
                                        </td>
                                        <td class="text-center">
                                            @if($d->file_path)
                                                <button type="button" class="btn btn-sm btn-info btn-preview"
                                                    onclick="openPreview('{{ asset('storage/' . $d->file_path) }}', '{{ pathinfo($d->file_path, PATHINFO_EXTENSION) }}')">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </button>
                                            @else
                                                <span class="text-muted small">
                                                    <i class="fas fa-ban me-1"></i>Tidak ada file
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" 
                                                        name="syarat[{{ $d->id_dokumen }}]" value="Ya" id="ya{{ $i }}">
                                                    <label class="form-check-label text-success fw-semibold" for="ya{{ $i }}">
                                                        <i class="fas fa-check-circle me-1"></i>Memenuhi
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" 
                                                        name="syarat[{{ $d->id_dokumen }}]" value="Tidak" id="tidak{{ $i }}">
                                                    <label class="form-check-label text-danger fw-semibold" for="tidak{{ $i }}">
                                                        <i class="fas fa-times-circle me-1"></i>Tidak Memenuhi
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fs-1 mb-2 d-block"></i>
                                            Belum ada dokumen persyaratan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Tanda Tangan Persetujuan --}}
            <div class="section-card mb-4">
                <div class="section-header">
                    <i class="fas fa-signature me-2"></i>
                    <span>Tanda Tangan Persetujuan</span>
                </div>
                <div class="section-body">
                    <div class="row g-4">
                        <!-- Asesi -->
                        <div class="col-lg-6">
                            <div class="signature-card">
                                <div class="signature-card-header">
                                    <i class="fas fa-user-circle me-2"></i>Tanda Tangan Asesi
                                </div>
                                <div class="signature-card-body">
                                    <div class="mb-3">
                                        <label class="small text-muted mb-1">Tanggal</label>
                                        <p class="fw-semibold mb-0">{{ $persetujuan->tgl_ttd_asesi ?? '-' }}</p>
                                    </div>
                                    <div class="signature-container">
                                        @if(!empty($persetujuan->ttd_asesi))
                                            <img src="{{ asset('storage/' . $persetujuan->ttd_asesi) }}" 
                                                 alt="TTD Asesi" 
                                                 class="signature-image">
                                        @else
                                            <div class="signature-empty">
                                                <i class="fas fa-pen-fancy fs-1 text-muted mb-2"></i>
                                                <p class="text-muted mb-0">Belum ada tanda tangan</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Admin -->
                        <div class="col-lg-6">
                            <div class="signature-card">
                                <div class="signature-card-header">
                                    <i class="fas fa-user-shield me-2"></i>Tanda Tangan Admin
                                </div>
                                <div class="signature-card-body">
                                    <div class="mb-3">
                                        <label for="tanggal-admin" class="form-label small text-muted">Tanggal</label>
                                        <input type="date" id="tanggal-admin" name="tanggal_admin" 
                                               class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted mb-2">Tanda Tangan</label>
                                        <div class="signature-pad-wrapper">
                                            <canvas id="ttd-admin" width="500" height="180"></canvas>
                                            <div class="signature-pad-hint">
                                                <i class="fas fa-hand-pointer me-2"></i>
                                                Klik dan geser untuk membuat tanda tangan
                                            </div>
                                        </div>
                                        <input type="hidden" name="ttd_admin" id="ttd_admin_data">
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm flex-fill" onclick="clearCanvasAdmin()">
                                            <i class="fas fa-eraser me-2"></i>Hapus
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm flex-fill" onclick="downloadTTDAdmin()">
                                            <i class="fas fa-download me-2"></i>Unduh
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keputusan Permohonan --}}
            <div class="section-card mb-4">
                <div class="section-header bg-gradient-warning">
                    <i class="fas fa-gavel me-2"></i>
                    <span>Keputusan Permohonan</span>
                </div>
                <div class="section-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold mb-3">
                            <i class="fas fa-clipboard-check me-2 text-primary"></i>Status Keputusan
                        </label>
                        <div class="decision-options">
                            <div class="decision-card">
                                <input class="form-check-input" type="radio" 
                                       name="status_permohonan" id="statusDiterima" value="Diterima" 
                                       {{ old('status_permohonan', $permohonan->status ?? '') == 'Diterima' ? 'checked' : '' }}>
                                <label class="decision-label" for="statusDiterima">
                                    <div class="decision-icon bg-success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <div class="decision-title">Diterima</div>
                                        <div class="decision-desc">Permohonan memenuhi persyaratan</div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="decision-card">
                                <input class="form-check-input" type="radio" 
                                       name="status_permohonan" id="statusDitolak" value="Ditolak" 
                                       {{ old('status_permohonan', $permohonan->status ?? '') == 'Ditolak' ? 'checked' : '' }}>
                                <label class="decision-label" for="statusDitolak">
                                    <div class="decision-icon bg-danger">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                    <div>
                                        <div class="decision-title">Ditolak</div>
                                        <div class="decision-desc">Permohonan tidak memenuhi syarat</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label for="catatan" class="form-label fw-bold mb-2">
                            <i class="fas fa-comment-dots me-2 text-primary"></i>Catatan / Keterangan
                        </label>
                        <textarea id="catatan" name="catatan" class="form-control" rows="4" 
                                  placeholder="Masukkan catatan atau alasan keputusan...">{{ old('catatan', $permohonan->catatan ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-end gap-3 mt-4">
                <a href="{{ route('admin.permohonan.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Preview --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Preview Dokumen</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center p-4" id="previewContent">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-3">Memuat dokumen...</p>
            </div>
        </div>
    </div>
</div>

{{-- Script Preview + TTD Admin --}}
<script>
    function openPreview(url, ext) {
        let content = '';
        ext = ext.toLowerCase();
        if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
            content = `<img src="${url}" class="img-fluid rounded shadow-sm" alt="preview" style="max-height: 70vh;">`;
        } else if (ext === 'pdf') {
            content = `<embed src="${url}" type="application/pdf" width="100%" height="600px" class="rounded">`;
        } else {
            content = `<div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Format file tidak dapat ditampilkan. <a href="${url}" target="_blank" class="alert-link">Klik di sini untuk mengunduh</a>
            </div>`;
        }
        document.getElementById('previewContent').innerHTML = content;
        let modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
    }

    // Canvas TTD Admin
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('ttd-admin');
        const ctx = canvas.getContext('2d');
        let isDrawing = false, lastX = 0, lastY = 0;

        // Set white background
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = '#000';

        function getPos(e) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: (e.clientX - rect.left) * (canvas.width / rect.width),
                y: (e.clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        function startDrawing(e) {
            isDrawing = true;
            const pos = getPos(e);
            lastX = pos.x;
            lastY = pos.y;
        }

        function draw(e) {
            if (!isDrawing) return;
            const pos = getPos(e);
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            lastX = pos.x;
            lastY = pos.y;
        }

        function stopDrawing() { isDrawing = false; }

        // Mouse events
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);

        // Touch events
        canvas.addEventListener('touchstart', (e) => { 
            e.preventDefault(); 
            startDrawing(e.touches[0]); 
        });
        canvas.addEventListener('touchmove', (e) => { 
            e.preventDefault(); 
            draw(e.touches[0]); 
        });
        canvas.addEventListener('touchend', stopDrawing);

        // Save signature on form submit
        document.querySelector('form')?.addEventListener('submit', function () {
            document.getElementById('ttd_admin_data').value = canvas.toDataURL();
        });
    });

    function clearCanvasAdmin() {
        const canvas = document.getElementById('ttd-admin');
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }

    function downloadTTDAdmin() {
        const canvas = document.getElementById('ttd-admin');
        const tanggal = document.getElementById('tanggal-admin').value || new Date().toISOString().split('T')[0];
        const link = document.createElement('a');
        link.download = `Admin_${tanggal}_tanda_tangan.png`;
        link.href = canvas.toDataURL();
        link.click();
    }
</script>

{{-- Enhanced Styles --}}
<style>
    /* Main Card */
    .main-card {
        animation: fadeInUp 0.5s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Breadcrumb */
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.3s;
    }

    .breadcrumb-item a:hover {
        color: #007bff;
    }

    .breadcrumb-item.active {
        color: #007bff;
        font-weight: 600;
    }

    /* Gradients */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    }

    /* Section Cards */
    .section-card {
        border: 1px solid #e9ecef;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .section-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .section-header {
        background: linear-gradient(135deg, #041562 0%, #0a2472 100%);
        color: white;
        padding: 16px 24px;
        font-weight: 600;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
    }

    .section-body {
        padding: 24px;
    }

    /* Info Items */
    .info-item {
        margin-bottom: 1rem;
    }

    .info-item label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        display: block;
        font-weight: 500;
    }

    .info-item p {
        font-size: 1rem;
        color: #212529;
        margin: 0;
        font-weight: 500;
    }

    /* Modern Table */
    .modern-table {
        border: none;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .modern-table thead th {
        border: none;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 16px;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f5;
    }

    .modern-table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
    }

    .modern-table tbody td {
        padding: 16px;
        vertical-align: middle;
        border: none;
    }

    /* Status Badge */
    .status-badge {
        padding: 8px 16px;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 20px;
    }

    /* Button Preview */
    .btn-preview {
        border-radius: 8px;
        font-weight: 500;
        padding: 6px 16px;
        transition: all 0.3s ease;
    }

    .btn-preview:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    /* Signature Cards */
    .signature-card {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
        transition: all 0.3s ease;
    }

    .signature-card:hover {
        border-color: #007bff;
        box-shadow: 0 4px 16px rgba(0, 123, 255, 0.15);
    }

    .signature-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 16px 20px;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .signature-card-body {
        padding: 20px;
    }

    .signature-container {
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
    }

    .signature-image {
        max-width: 100%;
        height: auto;
        max-height: 180px;
        object-fit: contain;
    }

    .signature-empty {
        text-align: center;
    }

    /* Signature Pad */
    .signature-pad-wrapper {
        position: relative;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background: white;
    }

    #ttd-admin {
        display: block;
        width: 100%;
        height: 180px;
        cursor: crosshair;
        touch-action: none;
    }

    .signature-pad-hint {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #adb5bd;
        font-size: 0.9rem;
        pointer-events: none;
        opacity: 0.5;
        text-align: center;
    }

    /* Decision Cards */
    .decision-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .decision-card {
        position: relative;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .decision-card:hover {
        border-color: #007bff;
        box-shadow: 0 4px 16px rgba(0, 123, 255, 0.15);
        transform: translateY(-2px);
    }

    .decision-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .decision-card input[type="radio"]:checked ~ .decision-label {
        border-color: #007bff;
        background: #f0f7ff;
    }

    .decision-label {
        display: flex;
        align-items: center;
        gap: 16px;
        cursor: pointer;
        margin: 0;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .decision-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }

    .decision-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: #212529;
        margin-bottom: 4px;
    }

    .decision-desc {
        font-size: 0.85rem;
        color: #6c757d;
    }

    /* Form Controls */
    .form-control:focus,
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.15);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 123, 255, 0.3);
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px);
    }

    /* Code styling */
    code {
        background: #f8f9fa;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.9em;
    }

    /* Modal Enhancements */
    .modal-content {
        border-radius: 16px;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
        padding: 20px 24px;
    }

    .modal-body {
        padding: 24px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main-card {
            padding: 20px !important;
        }

        .section-header {
            font-size: 0.95rem;
            padding: 12px 16px;
        }

        .section-body {
            padding: 16px;
        }

        .info-item label {
            font-size: 0.8rem;
        }

        .info-item p {
            font-size: 0.9rem;
        }

        .modern-table thead th {
            font-size: 0.75rem;
            padding: 12px 8px;
        }

        .modern-table tbody td {
            padding: 12px 8px;
            font-size: 0.85rem;
        }

        .decision-options {
            grid-template-columns: 1fr;
        }

        .signature-card-body {
            padding: 16px;
        }

        #ttd-admin {
            height: 150px;
        }
    }

    /* Print styles */
    @media print {
        .btn,
        .breadcrumb-wrapper,
        .signature-pad-hint {
            display: none !important;
        }

        .section-card {
            page-break-inside: avoid;
            box-shadow: none;
            border: 1px solid #dee2e6;
        }

        .main-card {
            box-shadow: none;
        }
    }

    /* Animations */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .spinner-border {
        animation: pulse 1.5s ease-in-out infinite;
    }

    /* Custom Scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Badge improvements */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* Empty state */
    tbody tr td i.fa-inbox {
        opacity: 0.3;
    }