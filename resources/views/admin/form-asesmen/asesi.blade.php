@extends('master')

<style>
.table-custom thead th {
    background: #041562 !important; /* biru sidebar */
    color: white !important;
    font-weight: 600;
    text-align: center;
}

.table-custom tbody td {
    vertical-align: middle;
    text-align: center;
}

.btn-lihat {
    background: #124E9C;
    color: white !important;
    border-radius: 6px;
    padding: 8px 18px;
    border: none;
    text-decoration: none !important; /* HAPUS GARIS */
    display: inline-block;
    font-weight: 500;
}
.btn-lihat:hover {
    background: #0f3e7c;
    text-decoration: none !important; /* HAPUS GARIS SAAT HOVER */
}

</style>

@section('konten')

<div class="container mt-4">

    <h1 class="fw-bold text-center">Daftar Asesi</h1>
    <h5 class="text-center mb-4 text-secondary">
        Skema: <strong>{{ $skema->nama_skema }}</strong>
    </h5>

    <div class="card shadow-sm p-4">

        @if($asesi->isEmpty())
            {{-- KALAU BELUM ADA ASES I --}}
            <p class="text-center text-muted mb-3">
                Belum ada peserta uji terdaftar untuk skema ini.
            </p>

            <div class="text-center">

            </div>

        @else
            {{-- TABEL ASLI DARI DATABASE --}}
            <table class="table table-bordered mt-3 table-custom">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 30%">Nama Asesi</th>
                        <th style="width: 30%">Email</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($asesi as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->name ?? '-' }}</td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.formasesmen.hasil', [
                                    'skemaId' => $skemaId,
                                    'tipe'    => $tipe,
                                    'asesiId' => $item->id_asesi,
                                ]) }}"
                                   class="btn-lihat">
                                    Lihat Hasil
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

</div>

@endsection
