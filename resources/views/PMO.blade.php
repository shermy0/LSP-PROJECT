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
                <li class="list-group-item border-0 ps-0">
                    Formulir ini diisi sebelum, saat, atau setelah asesmen observasi.
                </li>
                <li class="list-group-item border-0 ps-0">
                    Pertanyaan harus relevan dengan dimensi kompetensi dan tugas praktik.
                </li>
                <li class="list-group-item border-0 ps-0">
                    Saat pre-demo, pertanyaan bisa terkait K3, SOP, atau persiapan alat.
                </li>
                <li class="list-group-item border-0 ps-0">
                    Jika KUK sudah diamati, tidak perlu ditanyakan ulang, cukup beri catatan.
                </li>
                <li class="list-group-item border-0 ps-0">
                    Jika perlu konfirmasi, boleh tambahkan pertanyaan baru yang relevan.
                </li>
                <li class="list-group-item border-0 ps-0">
                    Tanggapan asesi wajib ditulis di kolom tanggapan.
                </li>
            </ol>
        </div>
    </div>

    <!-- Tombol Masukkan Pertanyaan -->
    <div class="text-end">
        <button class="btn text-white px-4 py-2" style="background-color:#041562;" data-bs-toggle="modal" data-bs-target="#modalPMO">
            Selanjutnya
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPMO" tabindex="-1" aria-labelledby="modalPMOLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalPMOLabel">Atur Pertanyaan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Arahkan ke CRUD PMO --}}
            <form method="GET" action="{{ route('pmo.create') }}">
                <div class="modal-body pt-2">
                    <!-- Input Jumlah Pertanyaan -->
                    <label for="jumlah" class="fw-bold small mt-2">Jumlah Pertanyaan</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" max="20" value="5" required>

                    <!-- Timer -->
                    <label for="timer" class="fw-bold small mt-3">Timer (menit)</label>
                    <input type="number" name="timer" id="timer" class="form-control" min="1" max="180" value="60" required>
                </div>

                <div class="modal-footer border-0">
                    <button type="submit" class="btn w-100 text-white" style="background-color:#041562; font-weight:bold;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function redirectToPMO() {
    let jumlah = document.getElementById('jumlah').value;
    let timer = document.getElementById('timer').value;
    let id_skema = "{{ $skema->id_skema }}";

    if(jumlah < 1 || jumlah > 20) {
        alert("Jumlah pertanyaan harus antara 1-20");
        return;
    }
    if(timer < 1 || timer > 180) {
        alert("Timer harus antara 1 - 180 menit");
        return;
    }

    window.location.href = "{{ route('pmo.create') }}?jumlah=" + jumlah + "&id_skema=" + id_skema + "&timer=" + timer;
}
</script>
@endsection
