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

    <!-- Tombol Masukkan Pertanyaan -->
    <div class="text-end">
        <button class="btn text-white px-4 py-2" style="background-color:#003366;" data-bs-toggle="modal" data-bs-target="#modalPertanyaan">
            Selanjutnya
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPertanyaan" tabindex="-1" aria-labelledby="modalPertanyaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 350px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalPertanyaanLabel">Atur Timer</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- PERBAIKAN: Arahkan ke route PG yang benar --}}
            <form method="GET" action="{{ route('pertanyaan.pg.kelompok', $skema->id_skema) }}">
                @csrf
                <div class="modal-body pt-2">
                    <!-- Timer -->
                    <label for="timer" class="fw-bold small mt-3">Timer (menit)</label>
                    <input type="number" name="timer" id="timer" class="form-control" min="1" value="30" required>
                    <small class="text-muted">Waktu pengerjaan untuk seluruh soal pilihan ganda</small>
                </div>

                <div class="modal-footer border-0">
                    <button type="submit" class="btn w-100 text-white" style="background-color:#003366; font-weight:bold;">
                        Lanjutkan ke Kelompok Pekerjaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function redirectToForm() {
    let timer = document.getElementById('timer').value;
    let id_skema = "{{ $skema->id_skema }}";

    if(timer < 1 || timer > 180) {
        alert("Timer harus antara 1 - 180 menit");
        return;
    }

    // PERBAIKAN: Redirect ke route PG
    window.location.href = "{{ route('pertanyaan.pg.kelompok', $skema->id_skema) }}?timer=" + timer;
}
</script>
@endsection