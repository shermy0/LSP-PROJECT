@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">

<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01') }}">FR.MAPA.01</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rencana Asesmen</li>
        </ol>
    </nav>
</div>

{{-- Looping kelompok pekerjaan --}}
@foreach ($kelompokPekerjaan as $index => $kelompok)
<div class="mapa-card mb-4">
    <div class="mapa-subsection-header d-flex justify-content-between align-items-center">
        <span>Kelompok Pekerjaan {{ $index + 1 }}</span>
        <form action="{{ route('form.mapa01.hapusKelompok', [$skema->id_skema, $kelompok->id_kelompok]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Kelompok Pekerjaan ini? Semua unit di dalamnya juga akan terhapus.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete-header">
                <i class="bi bi-trash-fill"></i>
            </button>
        </form>
    </div>

    <table class="mapa-table">
        <thead>
            <tr>
                <th>Kode Unit</th>
                <th>Unit Kompetensi</th>
                <th>Bukti-Bukti</th>
                <th>Jenis Bukti</th>
                <th>Metode dan Perangkat Asesmen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kelompok->hasilAsesmen as $hasil)
                <tr>
                    <td>{{ $hasil->unit->kode_unit ?? '-' }}</td>
                    <td>{{ $hasil->unit->judul_unit ?? '-' }}</td>
                    <td>{{ $hasil->catatan }}</td>
                    <td>
                        @foreach ($hasil->bukti as $bukti)
                            {{ $bukti->jenisBukti->nama_bukti ?? '-' }}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($hasil->perangkat as $perangkat)
                            {{ $perangkat->perangkat->catatan_penerapan ?? '-' }}<br>
                        @endforeach
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <!-- Tombol Edit -->
                            <a href="{{ route('form.mapa01.editunit', [$skema->id_skema, $hasil->id_hasil]) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('form.mapa01.hapusunit', [$skema->id_skema, $hasil->id_hasil]) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus unit ini?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Belum ada unit ditambahkan</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tombol Tambah Unit khusus per kelompok -->
    <a href="{{ route('form.mapa01.tambahunit', [$skema->id_skema, $kelompok->id_kelompok]) }}" class="btn btn-success mt-2">
        + Tambah Unit
    </a>
</div>
@endforeach

<!-- Tombol Tambah Kelompok Pekerjaan -->
<form action="{{ route('form.mapa01.tambahKelompok', $skema->id_skema) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-primary mt-3">
        + Tambah Kelompok Pekerjaan
    </button>
</form>


<div class="d-flex justify-content-between mt-3">
    <a href="{{ route('form.mapa01') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('form.mapa01.modifikasi', ['skema_id' => $skema->id_skema]) }}" class="btn btn-primary">Simpan dan Lanjut</a>
</div>
@endsection
