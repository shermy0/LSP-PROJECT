@extends('master')

@section('title', 'Detail Permohonan Sertifikasi Asesi')

@section('konten')
<div class="container mt-4 my-5">
    <div class="bg-white border rounded-3 shadow-sm p-4">

        <!-- Header -->
        <div class="mb-4">
            <p class="small text-muted mb-1">Form Asesmen &gt; <span class="fw-semibold">FR.APL.02</span></p>
            <div class="d-flex flex-column align-items-center text-center">
                <div class="rounded mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
                <h1 class="h5 fw-bold">Detail Permohonan Sertifikasi (FR.APL.02)</h1>
                <span class="badge bg-light text-dark mt-2 px-3 py-2 rounded-pill">Rincian Data Pemohon</span>
            </div>
        </div>

        <!-- Form mulai -->
        <form action="{{ route('admin.permohonan.update', $permohonan->id_permohonan) }}" method="POST">
            @csrf

            {{-- Data Pribadi --}}
            <div class="border rounded-3 p-3 mb-4 shadow-sm">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Data Pribadi
                </div>
                <div class="ps-2">
                    <p><strong>Nama Lengkap:</strong> {{ $asesi->nama_lengkap }}</p>
                    <p><strong>NIK:</strong> {{ $asesi->nik }}</p>
                    <p><strong>Tempat/Tgl Lahir:</strong> {{ $asesi->tempat_lahir }}, {{ $asesi->tgl_lahir }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $asesi->jenis_kelamin }}</p>
                    <p><strong>Alamat:</strong> {{ $asesi->alamat }}</p>
                    <p><strong>Telepon/Email:</strong> {{ $asesi->telepon }} / {{ $asesi->email }}</p>
                    <p><strong>Pendidikan Terakhir:</strong> {{ $asesi->pendidikan_terakhir }}</p>
                </div>
            </div>

            {{-- Data Pekerjaan --}}
            <div class="border rounded-3 p-3 mb-4 shadow-sm">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Data Pekerjaan
                </div>
                <div class="ps-2">
                    <p><strong>Nama Institusi:</strong> {{ $tuk->nama_tuk ?? '-' }}</p>
                    <p><strong>Alamat Instansi:</strong> {{ $tuk->alamat_tuk ?? '-' }}</p>
                    <p><strong>Telepon Instansi:</strong> {{ $tuk->telepon ?? '-' }}</p>
                    <p><strong>Email Instansi:</strong> {{ $tuk->email ?? '-' }}</p>
                </div>
            </div>

            {{-- Data Sertifikasi --}}
            <div class="border rounded-3 p-3 mb-4 shadow-sm">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Data Sertifikasi
                </div>
                <div class="ps-2">
                    <p><strong>Skema Sertifikasi:</strong> {{ $skema->nama_skema ?? '-' }}</p>
                    <p><strong>Judul Sertifikasi:</strong> {{ $skema->judul_skema ?? '-' }}</p>
                    <p><strong>Nomor Skema:</strong> {{ $skema->kode_skema ?? '-' }}</p>
                    <p><strong>Tujuan Asesmen:</strong> {{ $permohonan->tujuan_asesmen }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $permohonan->status=='Diajukan' ? 'warning' : ($permohonan->status=='Diterima' ? 'success' : 'danger') }}">
                            {{ $permohonan->status }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Daftar Unit Kompetensi --}}
            <div class="border rounded-3 p-3 mb-4 shadow-sm">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Daftar Unit Kompetensi
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Unit</th>
                                <th>Judul Unit</th>
                                <th>Standar Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($units as $i => $unit)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $unit->kode_unit }}</td>
                                    <td>{{ $unit->judul_unit }}</td>
                                    <td>{{ $unit->standar_kompetensi }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">Belum ada unit kompetensi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Bukti Kelengkapan --}}
            <div class="border rounded-3 p-3 mb-4 shadow-sm">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Bukti Kelengkapan
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Jenis Dokumen</th>
                                <th>Lampiran</th>
                                <th>Memenuhi Syarat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dokumen as $i => $d)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $d->jenis }}</td>
                                    <td class="text-center">
                                        @if($d->file_path)
                                            <button type="button" class="btn btn-sm btn-info"
                                                onclick="openPreview('{{ asset('storage/' . $d->file_path) }}', '{{ pathinfo($d->file_path, PATHINFO_EXTENSION) }}')">
                                                Lihat
                                            </button>
                                        @else
                                            <span class="text-muted">Belum diunggah</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="syarat[{{ $d->id_dokumen }}]" value="Ya" id="ya{{ $i }}">
                                            <label class="form-check-label" for="ya{{ $i }}">Memenuhi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                name="syarat[{{ $d->id_dokumen }}]" value="Tidak" id="tidak{{ $i }}">
                                            <label class="form-check-label" for="tidak{{ $i }}">Tidak Memenuhi</label>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">Belum ada dokumen persyaratan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tanda Tangan Persetujuan --}}
            <div class="border rounded-3 p-3 mb-4 shadow-sm">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Tanda Tangan Persetujuan
                </div>
                <div class="row">
                    <!-- Asesi -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-title">Asesi</div>
                            <p><strong>Tanggal:</strong> {{ $persetujuan->tgl_ttd_asesi ?? '-' }}</p>
                            @if(!empty($persetujuan->ttd_asesi))
                                <img src="{{ asset('storage/' . $persetujuan->ttd_asesi) }}" alt="TTD Asesi" class="border rounded" style="max-width:100%; height:150px; object-fit:contain;">
                            @else
                                <p class="text-muted">Belum ada tanda tangan asesi</p>
                            @endif
                        </div>
                    </div>

                    <!-- Admin -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-title">Admin</div>
                            <div class="mb-2">
                                <label for="tanggal-admin">Tanggal</label>
                                <input type="date" id="tanggal-admin" name="tanggal_admin" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="mb-3">
                                <label for="ttd-admin">Tanda Tangan</label>
                                <canvas id="ttd-admin" width="400" height="150"></canvas>
                                <input type="hidden" name="ttd_admin" id="ttd_admin_data">
                            </div>
                            <div class="btns">
                                <button type="button" class="btn clear" onclick="clearCanvasAdmin()">Hapus</button>
                                <button type="button" class="btn download" onclick="downloadTTDAdmin()">Unduh</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keputusan Permohonan --}}
            <div class="border rounded-3 p-3 mb-4 shadow-sm">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Keputusan Permohonan
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Status Keputusan</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="status_permohonan" id="statusDiterima" value="Diterima" 
                               {{ old('status_permohonan', $permohonan->status ?? '') == 'Diterima' ? 'checked' : '' }}>
                        <label class="form-check-label text-success fw-semibold" for="statusDiterima">
                            ✅ Diterima
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="status_permohonan" id="statusDitolak" value="Ditolak" 
                               {{ old('status_permohonan', $permohonan->status ?? '') == 'Ditolak' ? 'checked' : '' }}>
                        <label class="form-check-label text-danger fw-semibold" for="statusDitolak">
                            ❌ Ditolak
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alasan" class="form-label fw-semibold">Alasan / Keterangan</label>
                    <textarea id="catatan" name="catatan" class="form-control" rows="3">
    {{ old('catatan', $permohonan->catatan ?? '') }}
</textarea>

                </div>
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.permohonan.index') }}" class="btn btn-danger">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Preview --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center" id="previewContent">
                <p class="text-muted">Memuat...</p>
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
            content = `<img src="${url}" class="img-fluid" alt="preview">`;
        } else if (ext === 'pdf') {
            content = `<embed src="${url}" type="application/pdf" width="100%" height="600px">`;
        } else {
            content = `<a href="${url}" target="_blank">Download File</a>`;
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

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);

        canvas.addEventListener('touchstart', (e) => { e.preventDefault(); startDrawing(e.touches[0]); });
        canvas.addEventListener('touchmove', (e) => { e.preventDefault(); draw(e.touches[0]); });
        canvas.addEventListener('touchend', stopDrawing);

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

{{-- Style tambahan --}}
<style>
    .border.rounded-3 { border: 1px solid #ddd; border-radius: 12px !important; }
    .shadow-sm { box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important; }
    .card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        padding: 20px;
        margin-bottom: 20px;
    }
    .card-title {
        font-weight: bold;
        margin-bottom: 15px;
        font-size: 1.1rem;
        color: #333;
        border-bottom: 1px solid #eee;
        padding-bottom: 8px;
    }
    .card canvas {
        border: 1px solid #999;
        border-radius: 6px;
        width: 100%;
        height: 150px;
        background-color: #ffffff;
        cursor: crosshair;
    }
    .btns { display: flex; justify-content: space-between; gap: 10px; }
    .btns .clear { background: #dc3545; color: white; }
    .btns .download { background: #0d6efd; color: white; }
</style>
@endsection
