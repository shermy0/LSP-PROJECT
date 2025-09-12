@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">

<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01') }}">FR.MAPA.01</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rencana Asesmen</li>
        </ol>
    </nav>
</div>

<div class="mapa-card">

<div class="judul-header">Mempersiapkan Rencana Asesmen</div>

    <div class="mapa-subsection-header">
        <span>Kelompok Pekerjaan 1</span>
        <form action="" method="POST">
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
            @forelse ($hasilAsesmen as $hasil)
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
        <a href="" 
           class="btn btn-sm btn-warning me-1">
            <i class="bi bi-pencil-fill"></i>
        </a>

        <!-- Tombol Hapus -->
        <form action="{{ route('form.mapa01.hapusunit', [$skema->id_skema, $hasil->id_hasil]) }}" 
              method="POST" class="d-inline">
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

    <a href="{{ route('form.mapa01.tambahunit', $skema->id_skema) }}" class="btn btn-add-unit mt-3">
        + Tambah Unit
    </a>
</div>

    <a href="{{ route('form.mapa01.tambahunit', $skema->id_skema) }}" class="btn btn-add-unit mt-3">
        + Tambah Kelompok Pekerjaan
    </a>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('form.mapa01') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('form.mapa01.modifikasi', ['skema_id' => $skema->id_skema]) }}" class="btn btn-primary">Simpan dan Lanjut</a>
    </div>
</div>

@endsection
