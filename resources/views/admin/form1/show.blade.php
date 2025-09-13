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
            <p><strong>Tanggal Lahir:</strong> {{ $asesi->tgl_lahir }}</p>
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
            <p><strong>Nama Sekolah:</strong> {{ $asesi->nama_sekolah ?? '-' }}</p>
            <p><strong>Jabatan:</strong> {{ $asesi->jabatan ?? '-' }}</p>
            <p><strong>Alamat Instansi:</strong> {{ $asesi->alamat_instansi ?? '-' }}</p>
            <p><strong>Telepon:</strong> {{ $asesi->telepon_instansi ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $asesi->email_instansi ?? '-' }}</p>
        </div>
    </div>

    {{-- Data Sertifikasi --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">Data Sertifikasi</div>
        <div class="card-body">
            <p><strong>Skema Sertifikasi:</strong> {{ $skema->nama_skema ?? '-' }}</p>
            <p><strong>Judul Sertifikasi:</strong> {{ $skema->judul_skema ?? '-' }}</p>
            <p><strong>Nomor Skema:</strong> {{ $skema->kode_skema ?? '-' }}</p>
            <p><strong>Tujuan Asesmen:</strong> {{ $permohonan->tujuan_asesmen ?? '-' }}</p>
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
                    @foreach ($units as $i => $unit)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $unit->kode_unit }}</td>
                            <td>{{ $unit->judul_unit }}</td>
                            <td>{{ $unit->standar_kompetensi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bukti Kelengkapan --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">Bukti Kelengkapan</div>
        <div class="card-body">
            <p>1. Rapor: <a href="{{ asset('uploads/'.$permohonan->file_rapor) }}" target="_blank">Lihat</a></p>
            <p>2. Sertifikat PKL: <a href="{{ asset('uploads/'.$permohonan->file_pkl) }}" target="_blank">Lihat</a></p>
            <p>3. Kartu Siswa: <a href="{{ asset('uploads/'.$permohonan->file_kartu_siswa) }}" target="_blank">Lihat</a></p>
            <p>4. KTP/Kartu Keluarga: <a href="{{ asset('uploads/'.$permohonan->file_ktp) }}" target="_blank">Lihat</a></p>
            <p>5. Pas Foto: <a href="{{ asset('uploads/'.$permohonan->file_foto) }}" target="_blank">Lihat</a></p>
        </div>
    </div>

    {{-- Tanda Tangan Asesi --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">Tanda Tangan Asesi</div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $asesi->nama_lengkap }}</p>
            <p><strong>Tanggal:</strong> {{ $permohonan->tanggal_ttd ?? '-' }}</p>
            @if(!empty($permohonan->ttd))
                <img src="{{ asset('uploads/'.$permohonan->ttd) }}" alt="Tanda Tangan" class="border" style="max-width:200px;">
            @else
                <p class="text-muted">Belum ada tanda tangan</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.form1.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
