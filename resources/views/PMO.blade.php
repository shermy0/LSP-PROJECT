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

    @php
        $pmoRecord        = \App\Models\PMO::where('id_skema', $skema->id_skema)->latest('id_pmo')->first();
        $semuaPembuatan   = $pembuatanList->sortByDesc('id_pembuatan_pertanyaan');
        $pembuatanTerbaru = $semuaPembuatan->first();
    @endphp

    <!-- Daftar Set Pertanyaan PMO -->
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background-color:#f9fbff; font-weight:bold;">
            Daftar Set Pertanyaan PMO
        </div>
        <div class="card-body">
            @if($semuaPembuatan->isEmpty())
                <p class="text-muted">Belum ada pembuatan pertanyaan untuk skema ini.</p>
            @else
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Timer</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($semuaPembuatan as $p)
                        <tr>
                            <td>{{ $p->id_pembuatan_pertanyaan }}</td>
                            <td>{{ $p->judul ?? 'Set PMO #' . $p->id_pembuatan_pertanyaan }}</td>
                            <td>{{ $p->timer }} menit</td>
                            <td>{{ $p->timescap ? \Carbon\Carbon::parse($p->timescap)->format('d-m-Y H:i') : '-' }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('pertanyaan.pmo.kelompok', [
                                    'id_skema'     => $skema->id_skema,
                                    'id_pembuatan' => $p->id_pembuatan_pertanyaan,
                                    'id_pmo'       => $pmoRecord->id_pmo ?? '',
                                    'timer'        => $p->timer,
                                ]) }}" class="btn btn-sm btn-primary">
                                    Lanjutkan
                                </a>
                                @if($pmoRecord)
                                <a href="{{ route('pmo.crud', [
                                        'id_pmo'       => $pmoRecord->id_pmo,
                                        'id_pembuatan' => $p->id_pembuatan_pertanyaan,
                                    ]) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    Lihat
                                </a>
                                @endif
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

<!-- ===== Modal Pilihan ===== -->
<div class="modal fade" id="modalPilihan" tabindex="-1" aria-labelledby="modalPilihanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 350px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalPilihanLabel">Pilih Aksi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                {{-- Buat Set Baru → buka modal timer dulu --}}
                <button type="button"
                    class="btn w-100 mb-2 text-white fw-bold"
                    style="background-color:#041562;"
                    data-bs-dismiss="modal"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTimerPMO">
                    + Buat Set Pertanyaan Baru
                </button>

                {{-- Input Jawaban pakai set terbaru --}}
                @if($pembuatanTerbaru)
                    <a href="{{ route('jawaban.pmo', [
                        'id_skema'     => $skema->id_skema,
                        'id_pembuatan' => $pembuatanTerbaru->id_pembuatan_pertanyaan
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

<!-- ===== Modal Atur Timer & Judul PMO ===== -->
<div class="modal fade" id="modalTimerPMO" tabindex="-1" aria-labelledby="modalTimerPMOLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalTimerPMOLabel">Atur Timer & Judul</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Pembuatan Pertanyaan</label>
                    <input type="text" id="inputJudulPMO" class="form-control"
                           placeholder="Contoh: PMO Skema A Batch 1">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Timer (menit)</label>
                    <input type="number" id="inputTimerPMO" class="form-control" value="30" min="1">
                </div>
                <button type="button" class="btn w-100 text-white fw-bold"
                        style="background-color:#041562;"
                        onclick="lanjutBuatSetPMO()">
                    Buat Baru
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function lanjutBuatSetPMO() {
    const judul = document.getElementById('inputJudulPMO').value.trim();
    const timer = document.getElementById('inputTimerPMO').value || 30;
    const idSkema = {{ $skema->id_skema }};
    const idPmo   = {{ $pmoRecord->id_pmo ?? 'null' }};

    let url = `{{ route('pertanyaan.pmo.kelompok', ['id_skema' => $skema->id_skema]) }}?baru=1&timer=${timer}`;
    if (judul) url += `&judul=${encodeURIComponent(judul)}`;
    if (idPmo) url += `&id_pmo=${idPmo}`;

    window.location.href = url;
}
</script>

@endsection