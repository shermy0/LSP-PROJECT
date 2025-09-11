@extends('master')
@section('konten')

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
        <div class="judul-header">Mempersiapkan Rencana Asesmen</div>

    <div class="card p-3">
        <h6 class="fw-bold">Kelompok Pekerjaan 1</h6>

        <table class="table table-bordered mt-3">
            <thead class="table-light">
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
                    <td>
                        <form action="{{ route('form.mapa01.hapusunit', [$skema->id_skema, $hasil->id_hasil]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Belum ada unit ditambahkan</td></tr>
            @endforelse
        </tbody>
        </table>

        <a href="{{ route('form.mapa01.tambahunit', $skema->id_skema) }}" class="btn btn-success">
            + Tambah Unit
        </a>



        <div class="d-flex justify-content-between">
    <a href="{{ route('form.mapa01') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('form.mapa01.modifikasi', ['skema_id' => $skema->id_skema]) }}" class="btn btn-primary">Simpan dan Lanjut</a>
</div>

    </div>
</div>
@endsection