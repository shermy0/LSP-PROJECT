@extends('master')

@section('konten')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formasesmen') }}" class="text-primary">Form Asesmen</a></li>
            <li class="breadcrumb-item active" aria-current="page">FR.IA.07</li>
        </ol>
    </nav>

    <!-- Header Judul -->
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark">FR.IA.07 – Lembar Pertanyaan Pilihan Ganda</h4>
        <p class="text-muted mb-1">Skema Sertifikasi Kompetensi</p>

        <div class="d-inline-block mb-2">
            <button class="btn" style="background-color:#003366; color:#fff;" type="button">
                {{ strtoupper($skema->nama_skema) }}
            </button>
        </div>

        <p class="text-muted">{{ $skema->kode_skema ?? 'N/A' }}</p>
    </div>

    <!-- Panduan Khusus PG -->
    <div class="card shadow-sm mb-5 border-0">
        <div class="card-header" style="background-color:#f0f6ff; color:#333; font-weight:bold;">
            Panduan Bagi Asesor - Pilihan Ganda
        </div>
        <div class="card-body">
            <ol class="list-group list-group-numbered">
                <li class="list-group-item border-0 ps-0">
                    Buatlah pertanyaan pilihan ganda dengan 5 opsi jawaban (A, B, C, D, E).
                </li>
                <li class="list-group-item border-0 ps-0">
                    Pastikan hanya ada satu jawaban yang benar untuk setiap pertanyaan.
                </li>
                <li class="list-group-item border-0 ps-0">
                    Opsi jawaban harus jelas dan tidak ambigu.
                </li>
                <li class="list-group-item border-0 ps-0">
                    Pertanyaan harus mengukur pemahaman terhadap kompetensi yang diujikan.
                </li>
            </ol>
        </div>
    </div>

    <!-- Daftar pembuatan pertanyaan yang sudah ada -->
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background-color:#f9fbff; font-weight:bold;">
            Pembuatan Pertanyaan yang Sudah Ada
        </div>
        <div class="card-body">
            @if($pembuatanList->isEmpty())
                <p class="text-muted">Belum ada pembuatan pertanyaan untuk skema ini.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pembuatan</th>
                            <th>Timer</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembuatanList as $pembuatan)
                            <tr>
                                <td>{{ $pembuatan->id_pembuatan_pertanyaan }}</td>
                                <td>{{ $pembuatan->timer }} menit</td>
                                <td>
                                    {{ $pembuatan->timescap 
                                        ? \Carbon\Carbon::parse($pembuatan->timescap)->format('d-m-Y H:i') 
                                        : '-' }}
                                </td>
                                <td>
                                <a href="{{ route('pertanyaan.pg.kelompok', [
                'id_skema' => $skema->id_skema,
                'id_pembuatan_pertanyaan' => $pembuatan->id_pembuatan_pertanyaan
            ]) }}" class="btn btn-sm btn-success">
                <i class="bi bi-pencil-square"></i> Lanjutkan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Tombol Selanjutnya -->
    <div class="text-end">
        <button class="btn text-white px-4 py-2" style="background-color:#003366;" 
                data-bs-toggle="modal" data-bs-target="#modalPertanyaan">
            Selanjutnya
        </button>
    </div>
</div>

<!-- Modal Timer -->
<div class="modal fade" id="modalPertanyaan" tabindex="-1" aria-labelledby="modalPertanyaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 350px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalPertanyaanLabel">Atur Timer</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="GET" action="{{ route('pertanyaan.pg.kelompok', ['id_skema' => $skema->id_skema]) }}">
                <div class="modal-body pt-2">
                    <!-- Timer -->
                    <label for="timer" class="fw-bold small mt-3">Timer (menit)</label>
                    <input type="number" name="timer" id="timer" class="form-control" 
                           min="1" max="180" value="30" required>
                </div>

                <input type="hidden" name="jenis_pertanyaan" value="pilihan_ganda">

                <div class="modal-footer border-0">
                    <button type="submit" class="btn w-100 text-white" 
                            style="background-color:#003366; font-weight:bold;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection