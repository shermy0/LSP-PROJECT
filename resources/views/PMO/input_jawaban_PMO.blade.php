@extends('master')
@section('konten')
<div class="container mt-4">

    {{-- Header --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h5 class="fw-bold mb-1" style="color:#041562;">
                    <i class="bi bi-clipboard2-check me-2"></i>Pertanyaan Mendukung Observasi (PMO)
                </h5>
                <h6 class="fw-semibold text-muted mb-2">{{ $skema->nama_skema }}</h6>
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-1">
                    <span class="badge rounded-pill px-3 py-2" style="background-color:#e8edf8; color:#041562; font-size:0.8rem;">
                        <i class="bi bi-collection me-1"></i>{{ $pembuatan->judul ?? 'Set #'.$pembuatan->id_pembuatan_pertanyaan }}
                    </span>
                    <span class="badge rounded-pill px-3 py-2" style="background-color:#e8edf8; color:#041562; font-size:0.8rem;">
                        <i class="bi bi-briefcase me-1"></i>{{ $kelompok->nama_kelompok ?? '—' }}
                    </span>
                    <span class="badge rounded-pill px-3 py-2" style="background-color:#e8edf8; color:#041562; font-size:0.8rem;">
                        <i class="bi bi-person me-1"></i>{{ $asesi->nama_lengkap ?? '—' }}
                    </span>
                    <span class="badge rounded-pill px-3 py-2" style="background-color:#e8edf8; color:#041562; font-size:0.8rem;">
                        <i class="bi bi-clock me-1"></i>{{ $pembuatan->timer ?? 30 }} menit
                    </span>
                </div>
            </div>

            <hr class="mb-2">

            {{-- Timer --}}
            <div class="text-center pt-2">
                <div class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill"
                     style="background-color:#f4f6fb;">
                    <i class="bi bi-hourglass-split" style="color:#041562;"></i>
                    <span class="fw-bold fs-5" id="timer" style="color:#041562;">
                        {{ str_pad($pembuatan->timer ?? 30, 2, '0', STR_PAD_LEFT) }}:00
                    </span>
                    <small class="text-muted">sisa waktu</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form id="form-jawaban"
          action="{{ route('jawaban.pmo.simpan', [$skema->id_skema, $pembuatan->id_pembuatan_pertanyaan, $asesi->id_asesi]) }}"
          method="POST"
          onsubmit="return validateAndSaveSignature()">
        @csrf
        <input type="hidden" name="ttd_asesor" id="ttd_asesor_data">
        <input type="hidden" name="tgl_ttd_asesor" id="tgl_ttd_asesor_data">

        {{-- Tabel Pertanyaan --}}
        <div id="soal-wrapper">

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                <table class="table table-bordered mb-0" style="font-size:0.9rem;">
                    <thead style="position:sticky; top:0; z-index:10;">
                        <tr style="background-color:#041562;">
                            <th class="text-white py-2 px-3" rowspan="2" style="width:76%; vertical-align:middle;">Pertanyaan</th>
                            <th class="text-white text-center py-2" colspan="2" style="width:24%;">Pencapaian</th>
                        </tr>
                        <tr style="background-color:#041562;">
                            <th class="text-white text-center py-2" style="width:12%;">Ya</th>
                            <th class="text-white text-center py-2" style="width:12%;">Tdk</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($pertanyaan as $i => $p)
                        @php
                            $unitIds = json_decode($p->id_unit, true) ?? [];
                            $units   = $unitList->whereIn('id_unit', $unitIds);
                        @endphp

                        {{-- Baris Pertanyaan --}}
                        <tr>
                            <td class="px-3 py-3">
                                <div class="d-flex gap-2">
                                    <span class="fw-bold flex-shrink-0" style="color:#041562; min-width:24px;">{{ $i + 1 }}.</span>
                                    <div class="flex-grow-1">
                                        {{-- Deskripsi = teks merah (konteks/aspek kritis) --}}
                                        @if($p->deskripsi_pertanyaan)
                                        <p class="mb-2 fst-italic fw-semibold" style="color:#c0392b; font-size:0.88rem;">
                                            {{ $p->deskripsi_pertanyaan }}
                                        </p>
                                        @endif

                                        {{-- Unit kompetensi badge --}}
                                        @if($units->count())
                                        <div class="mb-2">
                                            @foreach($units as $unit)
                                                <span class="badge me-1 mb-1" style="background-color:#e8edf8; color:#041562; font-size:0.75rem;">
                                                    {{ $unit->kode_unit }}
                                                </span>
                                            @endforeach
                                        </div>
                                        @endif

                                        {{-- Pertanyaan utama --}}
                                        <p class="mb-0" style="color:#222; font-size:0.92rem;">
                                            {{ $p->pertanyaan }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            {{-- Radio Ya --}}
                            <td class="text-center align-middle" style="background-color:#f8fff9;">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <small class="fw-bold" style="color:#041562; font-size:0.75rem;">Ya</small>
                                    <input type="radio"
                                           name="pencapaian[{{ $p->id_pmo_pertanyaan }}]"
                                           value="Ya"
                                           class="form-check-input"
                                           style="width:22px; height:22px; cursor:pointer; accent-color:#041562;"
                                           {{ ($p->pencapaian ?? '') === 'Ya' ? 'checked' : '' }}>
                                </div>
                            </td>
                            {{-- Radio Tdk --}}
                            <td class="text-center align-middle" style="background-color:#fff8f8;">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <small class="fw-bold" style="color:#dc3545; font-size:0.75rem;">Tdk</small>
                                    <input type="radio"
                                           name="pencapaian[{{ $p->id_pmo_pertanyaan }}]"
                                           value="Tidak"
                                           class="form-check-input"
                                           style="width:22px; height:22px; cursor:pointer; accent-color:#dc3545;"
                                           {{ ($p->pencapaian ?? '') === 'Tidak' ? 'checked' : '' }}>
                                </div>
                            </td>

                        {{-- Baris Tanggapan --}}
                        <tr style="background-color:#fafbff;">
                            <td colspan="3" class="px-3 py-2">
                                <div class="fw-semibold mb-1" style="color:#041562; font-size:0.83rem;">
                                    <i class="bi bi-chat-left-text me-1"></i>Tanggapan:
                                </div>
                                <textarea name="jawaban[{{ $p->id_pmo_pertanyaan }}]"
                                          class="form-control rounded-3"
                                          rows="3"
                                          placeholder="Tuliskan tanggapan asesi di sini..."
                                          style="border-color:#d0d7e8; font-size:0.9rem; resize:vertical;">{{ old('jawaban.'.$p->id_pmo_pertanyaan, $p->tanggapan ?? '') }}</textarea>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada pertanyaan untuk kelompok ini.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <div style="height:80px;"></div>
        </div>

        {{-- ===== TANDA TANGAN ASESOR ===== --}}
        <div class="mt-4 border rounded-4 p-4 bg-light" id="signature-section" style="display:none;">
            <div class="mb-3 p-3 rounded-3" style="background:#e8edf8; border-left:5px solid #041562;">
                <span class="fw-bold" style="color:#041562; font-size:1.1rem;">
                    <i class="bi bi-pen me-2"></i>Tanda Tangan Asesor
                </span>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4" style="max-width:500px; margin:0 auto;">
                <div class="fw-bold mb-3 pb-2 border-bottom" style="color:#333;">Asesor</div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Asesor</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->name ?? '-' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" id="tanggal-asesor" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanda Tangan</label>
                    <canvas id="ttd-asesor" width="400" height="150"
                            style="border:1px solid #999; border-radius:6px; width:100%; background:#fff; cursor:crosshair; display:block;"></canvas>
                </div>
                <button type="button" class="btn btn-danger w-100" onclick="clearCanvas()">
                    <i class="bi bi-eraser me-1"></i> Hapus Tanda Tangan
                </button>
            </div>

            <div class="mt-4 text-center d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-success px-4 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-check-lg me-1"></i> Simpan Jawaban
                </button>
                <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" id="backToSoalBtn">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Soal
                </button>
            </div>
        </div>

    </form>

    {{-- Fixed buttons --}}
    <a href="{{ route('pmo.hasil.kelompok', ['id_skema' => $skema->id_skema]) }}"
       id="btn-kembali"
       style="position:fixed; bottom:20px; left:260px; z-index:9999;
              background-color:#6c757d; color:#fff; border:none;
              border-radius:50px; padding:10px 18px;
              font-weight:600; font-size:0.85rem;
              box-shadow:0 4px 12px rgba(0,0,0,0.2);
              display:flex; align-items:center; gap:6px;
              text-decoration:none; transition:opacity 0.2s;"
       onmouseover="this.style.opacity='0.85'"
       onmouseout="this.style.opacity='1'">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    @if($pertanyaan->count())
    <button type="button" id="btn-ke-ttd"
            onclick="showTTDSection()"
            style="position:fixed; bottom:20px; right:20px; z-index:9999;
                   background-color:#041562; color:#fff; border:none;
                   border-radius:50px; padding:10px 22px;
                   font-weight:600; font-size:0.85rem;
                   box-shadow:0 4px 12px rgba(0,0,0,0.2);
                   display:flex; align-items:center; gap:6px;
                   cursor:pointer; transition:opacity 0.2s;"
            onmouseover="this.style.opacity='0.85'"
            onmouseout="this.style.opacity='1'">
        <i class="bi bi-pen"></i> Ke Tanda Tangan
    </button>
    @endif

</div>

<script>
// =========================================================
// Timer
// =========================================================
let totalDetik = {{ $pembuatan->timer ?? 30 }} * 60;
let sudahSubmit = false;

function updateTimer() {
    if (sudahSubmit) return;
    const menit = Math.floor(totalDetik / 60);
    const detik = totalDetik % 60;
    const el = document.getElementById('timer');
    el.textContent = String(menit).padStart(2, '0') + ':' + String(detik).padStart(2, '0');
    if (totalDetik <= 60) el.style.color = '#dc3545';
    if (totalDetik <= 0) {
        sudahSubmit = true;
        Swal.fire({
            title: '⏰ Waktu Habis!',
            text: 'Jawaban akan disimpan otomatis.',
            icon: 'warning',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            allowOutsideClick: false,
        }).then(() => {
            saveSignature();
            document.getElementById('form-jawaban').submit();
        });
        return;
    }
    totalDetik--;
}
setInterval(updateTimer, 1000);
updateTimer();

// =========================================================
// Show/Hide TTD Section
// =========================================================
function showTTDSection() {
    document.getElementById('soal-wrapper').style.display = 'none';
    document.getElementById('signature-section').style.display = '';
    const btnKembali = document.getElementById('btn-kembali'); if(btnKembali) btnKembali.style.display = 'none';
    document.getElementById('btn-ke-ttd').style.display = 'none';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('backToSoalBtn').addEventListener('click', function () {
        document.getElementById('signature-section').style.display = 'none';
        document.getElementById('soal-wrapper').style.display = '';
        const btnKembali = document.getElementById('btn-kembali'); if(btnKembali) btnKembali.style.display = 'flex';
        document.getElementById('btn-ke-ttd').style.display = 'flex';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});

// =========================================================
// Tanda Tangan Canvas
// =========================================================
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('ttd-asesor');
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';
    let isDrawing = false, lastX = 0, lastY = 0;

    function getPos(e) {
        const r = canvas.getBoundingClientRect();
        const scaleX = canvas.width / r.width;
        const scaleY = canvas.height / r.height;
        return {
            x: (e.clientX - r.left) * scaleX,
            y: (e.clientY - r.top) * scaleY
        };
    }

    function startDrawing(e) { isDrawing = true; const p = getPos(e); lastX = p.x; lastY = p.y; }
    function draw(e) {
        if (!isDrawing) return;
        const p = getPos(e);
        ctx.beginPath(); ctx.moveTo(lastX, lastY); ctx.lineTo(p.x, p.y); ctx.stroke();
        lastX = p.x; lastY = p.y;
    }
    function stopDrawing() { isDrawing = false; }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    canvas.addEventListener('touchstart', e => { e.preventDefault(); startDrawing(e.touches[0]); }, { passive: false });
    canvas.addEventListener('touchmove',  e => { e.preventDefault(); draw(e.touches[0]); }, { passive: false });
    canvas.addEventListener('touchend',   e => { e.preventDefault(); stopDrawing(); });
});

function clearCanvas() {
    const canvas = document.getElementById('ttd-asesor');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}

function saveSignature() {
    const canvas = document.getElementById('ttd-asesor');
    const blank = document.createElement('canvas');
    blank.width = canvas.width; blank.height = canvas.height;
    if (canvas.toDataURL() !== blank.toDataURL()) {
        // Buat canvas kecil
        const small = document.createElement('canvas');
        small.width = 200;
        small.height = 100;
        const ctx = small.getContext('2d');
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, small.width, small.height);
        ctx.drawImage(canvas, 0, 0, 200, 100);

        // Simpan sebagai JPEG quality 0.4
        document.getElementById('ttd_asesor_data').value = small.toDataURL('image/jpeg', 0.4);
        document.getElementById('tgl_ttd_asesor_data').value = document.getElementById('tanggal-asesor').value;
    }
}

function validateAndSaveSignature() {
    const canvas = document.getElementById('ttd-asesor');
    const blank = document.createElement('canvas');
    blank.width = canvas.width; blank.height = canvas.height;

    if (canvas.toDataURL() === blank.toDataURL()) {
        Swal.fire({
            title: 'Tanda Tangan Belum Diisi!',
            text: 'Asesor harus tanda tangan sebelum menyimpan.',
            icon: 'warning',
            confirmButtonText: 'OK',
            confirmButtonColor: '#041562'
        });
        return false;
    }
    saveSignature(); // fungsi saveSignature sudah kompres
    return true;
}
</script>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.querySelector(".toggle-btn");
    if (sidebar) sidebar.style.display = "none";
    if (toggleBtn) toggleBtn.style.display = "none";
    const mainContent = document.getElementById("main-content");
    if (mainContent) {
        mainContent.style.marginLeft = "0";
        mainContent.style.width = "100%";
    }
});
</script>
@endpush

@endsection