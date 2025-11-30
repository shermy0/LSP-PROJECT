@extends('master')

@section('konten')
<div class="container mt-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formasesmen') }}" class="text-primary">Form Asesmen</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.IA.03</li>
        </ol>
    </nav>

    <!-- Header Judul -->
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark">FR.IA.03 – Pertanyaan Mendukung Observasi</h4>
        <p class="text-muted mb-1">Skema Sertifikasi Kompetensi</p>

        <div class="d-inline-block mb-2">
            <button class="btn" style="background-color:#041562; color:#fff;" type="button">
                {{ strtoupper($skema->nama_skema) }}
            </button>
        </div>

        <p class="text-muted">{{ $skema->kode_skema ?? 'N/A' }}</p>
    </div>

    <!-- Panduan -->
    <div class="card shadow-sm mb-5 border-0">
        <div class="card-header" style="background-color:#f0f6ff; color:#333; font-weight:bold;">
            Panduan Bagi Asesor
        </div>
        <div class="card-body">
            <ol class="list-group list-group-numbered">
                <li class="list-group-item border-0 ps-0">Formulir ini diisi sebelum, saat, atau setelah asesmen observasi.</li>
                <li class="list-group-item border-0 ps-0">Pertanyaan harus relevan dengan dimensi kompetensi dan tugas praktik.</li>
                <li class="list-group-item border-0 ps-0">Saat pra-demonstrasi, pertanyaan bisa terkait K3, SOP, atau catatan.</li>
            </ol>
        </div>
    </div>

    <!-- Daftar pembuatan pertanyaan -->
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
                                <td>{{ $pembuatan->timescap ? \Carbon\Carbon::parse($pembuatan->timescap)->format('d-m-Y H:i') : '-' }}</td>
                                <td>
                                    <a href="{{ route('pertanyaan.pmo.kelompok', [
                                        'id_skema' => $skema->id_skema,
                                        'id_pembuatan' => $pembuatan->id_pembuatan_pertanyaan
                                    ]) }}" class="btn btn-sm btn-primary">
                                        Lanjutkan
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Tombol Selanjutnya -->
    <div class="text-end">
        <button class="btn text-white px-4 py-2" style="background-color:#041562;" 
                data-bs-toggle="modal" data-bs-target="#modalPilihan">
            Selanjutnya
        </button>
    </div>

</div>

<!-- Modal Pilihan -->
<div class="modal fade" id="modalPilihan" tabindex="-1" aria-labelledby="modalPilihanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 350px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalPilihanLabel">Pilih Aksi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
              @php
                $pembuatanPMO = $pembuatanList->firstWhere('jenis_pertanyaan', 'pmo');
              @endphp

                <a href="{{ $pembuatanPMO 
                    ? route('pertanyaan.pmo.kelompok', ['id_skema' => $skema->id_skema, 'id_pembuatan' => $pembuatanPMO->id_pembuatan_pertanyaan])
                    : route('pertanyaan.pmo.kelompok', ['id_skema' => $skema->id_skema])
                    }}?timer={{ request('timer') ?? 30 }}" 
                    class="btn w-100 mb-2 text-white fw-bold" 
                    style="background-color:#041562;">
                        Input Soal
                </a>

                <!-- Jawaban Asesi PMO -->
                @php
                $pembuatanPMO = $pembuatanList->firstWhere('jenis_pertanyaan', 'pmo');
                @endphp

                @if($pembuatanPMO)
                    <a href="{{ route('jawaban.pmo', [
                        'id_skema' => $skema->id_skema,
                        'id_pembuatan' => $pembuatanPMO->id_pembuatan_pertanyaan
                    ]) }}" 
                    class="btn w-100 fw-bold" 
                    style="background-color:#f1f1f1; color:#333;">
                        Input Jawaban
                    </a>
                @else
                    <button class="btn w-100 fw-bold" style="background-color:#f1f1f1; color:#333;" disabled>
                        Belum ada pertanyaan PMO
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Timer -->
<div class="modal fade" id="modalTimer" tabindex="-1" aria-labelledby="modalTimerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 350px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalTimerLabel">Atur Timer</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

          <form method="GET" action="{{ route('pertanyaan.pmo.kelompok', ['id_skema' => $skema->id_skema]) }}">
                <div class="modal-body pt-2">
                    <label for="timer" class="fw-bold small mt-3">Timer (menit)</label>
                    <input type="number" name="timer" id="timer" class="form-control" min="1" max="180" value="30" required>
                </div>

                <input type="hidden" name="id_pembuatan" value="{{ $pembuatanList->first()->id_pembuatan_pertanyaan ?? '' }}">

                <div class="modal-footer border-0">
                    <button type="submit" class="btn w-100 text-white fw-bold" style="background-color:#041562;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
