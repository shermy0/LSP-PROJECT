@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold text-center mb-3">Detail Rekaman Asesmen</h4>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>ID Rekaman:</strong> {{ $rekaman->id_rekaman }}</p>
            <p><strong>Nama Asesi:</strong> {{ $rekaman->asesi->nama_lengkap ?? '-' }}</p>
<p><strong>Nama Asesor:</strong> {{ $rekaman->asesor->name ?? '-' }}</p>

            <p><strong>Hasil:</strong> 
               <span class="badge 
        bg-{{ $rekaman->hasil === 'K' ? 'success' : 'danger' }}">
        {{ $rekaman->hasil }}
    </span>
            </p>
            <p><strong>Tindak Lanjut:</strong> {{ $rekaman->tindak_lanjut ?? '-' }}</p>
            <p><strong>Komentar Asesor:</strong> {{ $rekaman->komentar_asesor ?? '-' }}</p>
        </div>
    </div>

    <h5 class="fw-bold mb-3">Rincian Unit Kompetensi</h5>
    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Unit Kompetensi</th>
                <th>OD</th>
                <th>PPK</th>
                <th>PW</th>
                <th>PL</th>
                <th>PT</th>
                <th>PK</th>
                <th>L</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekaman->detailHasil as $hasil)
<tr>
    <td class="text-start">{{ $hasil->unit->judul_unit ?? '-' }}</td>
    <td>{{ $hasil->observasi ? '✔️' : '' }}</td>
    <td>{{ $hasil->pernyataan_pihak_ketiga ? '✔️' : '' }}</td>
    <td>{{ $hasil->pertanyaan_wawancara ? '✔️' : '' }}</td>
    <td>{{ $hasil->pertanyaan_lisan ? '✔️' : '' }}</td>
    <td>{{ $hasil->pertanyaan_tertulis ? '✔️' : '' }}</td>
    <td>{{ $hasil->proyek_kerja ? '✔️' : '' }}</td>
    <td>{{ $hasil->lainnya ? '✔️' : '' }}</td>
</tr>
@endforeach

        </tbody>
    </table>

    <div class="text-center mt-3">
        <a href="{{ route('rekap.asesmen', $rekaman->id_skema) }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
</div>
@endsection
