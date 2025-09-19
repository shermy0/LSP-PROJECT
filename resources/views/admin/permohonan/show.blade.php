@extends('master')

@section('title', 'Detail Permohonan Sertifikasi Asesi')

@section('konten')
<div class="container mt-4">
    <h2 class="mb-4">Detail Permohonan Sertifikasi (FR.APL.02)</h2>

    {{-- Data Pribadi --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">Data Pribadi</div>
        <div class="card-body">
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
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">Data Pekerjaan</div>
        <div class="card-body">
            <p><strong>Nama Institusi:</strong> {{ $tuk->nama_tuk ?? '-' }}</p>
            <p><strong>Alamat Instansi:</strong> {{ $tuk->alamat_tuk ?? '-' }}</p>
            <p><strong>Telepon Instansi:</strong> {{ $tuk->telepon ?? '-' }}</p>
            <p><strong>Email Instansi:</strong> {{ $tuk->email ?? '-' }}</p>
        </div>
    </div>

    {{-- Data Sertifikasi --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">Data Sertifikasi</div>
        <div class="card-body">
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
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">Daftar Unit Kompetensi</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
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
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">Bukti Kelengkapan</div>
        <div class="card-body">
            @foreach($dokumen as $d)
                <p>{{ $loop->iteration }}. {{ $d->jenis }} :
                    @if($d->file_path)
                        <button type="button" 
                                class="btn btn-sm btn-info"
                                onclick="openPreview('{{ asset('storage/' . $d->file_path) }}', '{{ pathinfo($d->file_path, PATHINFO_EXTENSION) }}')">
                            Lihat
                        </button>
                    @else
                        <span class="text-muted">Belum diunggah</span>
                    @endif
                </p>
            @endforeach
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

    {{-- Tanda Tangan Persetujuan --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">Tanda Tangan Persetujuan</div>
        <div class="card-body">
            <p><strong>Tanggal TTD Asesi:</strong> {{ $persetujuan->tgl_ttd_asesi ?? '-' }}</p>
            @if(!empty($persetujuan->ttd_asesi))
                <img src="{{ asset('storage/'.$persetujuan->ttd_asesi) }}" alt="TTD Asesi" class="border mb-3" style="max-width:200px;">
            @else
                <p class="text-muted">Belum ada tanda tangan asesi</p>
            @endif

            <p><strong>Tanggal TTD Admin:</strong> {{ $persetujuan->tgl_ttd_admin ?? '-' }}</p>
            @if(!empty($persetujuan->ttd_admin))
                <img src="{{ asset('storage/'.$persetujuan->ttd_admin) }}" alt="TTD Admin" class="border" style="max-width:200px;">
            @else
                <p class="text-muted">Belum ada tanda tangan admin</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.permohonan.index') }}" class="btn btn-secondary">Kembali</a>
</div>

{{-- Script Preview --}}
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
</script>
@endsection
