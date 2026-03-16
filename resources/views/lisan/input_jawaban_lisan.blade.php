@extends('master')
@section('konten')
<div class="container mt-4">

    {{-- Header --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h5 class="fw-bold mb-1" style="color:#041562;">
                    <i class="bi bi-mic me-2"></i>Pertanyaan Lisan (FR.IA.07)
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
            <div class="text-center pt-2">
                <div class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill" style="background-color:#f4f6fb;">
                    <i class="bi bi-hourglass-split" style="color:#041562;"></i>
                    <span class="fw-bold fs-5" id="timer" style="color:#041562;">
                        {{ str_pad($pembuatan->timer ?? 30, 2, '0', STR_PAD_LEFT) }}:00
                    </span>
                    <small class="text-muted">sisa waktu</small>
                </div>
            </div>
        </div>
    </div>

    <form id="form-jawaban"
          action="{{ route('lisan.simpan.jawaban', [$skema->id_skema, $pembuatan->id_pembuatan_pertanyaan, $asesi->id_asesi]) }}"
          method="POST"
          onsubmit="return validateAndSaveSignature()">
        @csrf
        <input type="hidden" name="ttd_asesor" id="ttd_asesor_data">
        <input type="hidden" name="tgl_ttd_asesor" id="tgl_ttd_asesor_data">
        <input type="hidden" name="umpan_balik" id="umpan_balik_final">

        <div id="soal-wrapper">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                <table class="table table-bordered mb-0" style="font-size:0.9rem;">
                    <thead style="position:sticky; top:0; z-index:10;">
                        <tr style="background-color:#041562;">
                            <th class="text-white py-2 px-3" rowspan="2" style="width:76%; vertical-align:middle;">Pertanyaan</th>
                            <th class="text-black text-center py-2" colspan="2" style="width:24%;">Pencapaian</th>
                        </tr>
                        <tr style="background-color:#041562;">
                            <th class="text-green text-center py-2" style="width:12%;">Ya</th>
                            <th class="text-red text-center py-2" style="width:12%;">Tidak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pertanyaan as $i => $p)
                        @php $jawabanAsesi = $p->jawabanAsesmen->first(); @endphp
                        <tr>
                            <td class="px-3 py-3">
                                <div class="d-flex gap-2">
                                    <span class="fw-bold flex-shrink-0" style="color:#041562; min-width:24px;">{{ $i + 1 }}.</span>
                                    <div class="flex-grow-1">
                                        @if($p->kunci_jawaban)
                                        <p class="mb-2 fst-italic fw-semibold" style="color:#c0392b; font-size:0.88rem;">
                                            Kunci: {{ $p->kunci_jawaban }}
                                        </p>
                                        @endif
                                        <p class="mb-0" style="color:#222; font-size:0.92rem;">{{ $p->isi_pertanyaan }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center align-middle" style="background-color:#f8fff9;">
                                <input type="radio" name="pencapaian[{{ $p->id_pertanyaan }}]" value="1"
                                       class="form-check-input" style="width:22px; height:22px; cursor:pointer; accent-color:#041562;"
                                       {{ ($jawabanAsesi->pencapaian ?? '') == '1' ? 'checked' : '' }}>
                            </td>
                            <td class="text-center align-middle" style="background-color:#fff8f8;">
                                <input type="radio" name="pencapaian[{{ $p->id_pertanyaan }}]" value="0"
                                       class="form-check-input" style="width:22px; height:22px; cursor:pointer; accent-color:#dc3545;"
                                       {{ $jawabanAsesi && ($jawabanAsesi->pencapaian ?? '') == '0' ? 'checked' : '' }}>
                            </td>
                        </tr>
                        <tr style="background-color:#fafbff;">
                            <td colspan="3" class="px-3 py-2">
                                <div class="fw-semibold mb-1" style="color:#041562; font-size:0.83rem;">
                                    <i class="bi bi-chat-left-text me-1"></i>Jawaban Asesi:
                                </div>
                                <textarea name="jawaban[{{ $p->id_pertanyaan }}]"
                                          class="form-control rounded-3" rows="3"
                                          placeholder="Tuliskan jawaban asesi di sini..."
                                          style="border-color:#d0d7e8; font-size:0.9rem; resize:vertical;">{{ old('jawaban.'.$p->id_pertanyaan, $jawabanAsesi->jawaban_text ?? '') }}</textarea>
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

        {{-- Tanda Tangan --}}
        <div class="mt-4 border rounded-4 p-4 bg-light" id="signature-section" style="display:none;">
            <div class="mb-3 p-3 rounded-3" style="background:#e8edf8; border-left:5px solid #041562;">
                <span class="fw-bold" style="color:#041562; font-size:1.1rem;">
                    <i class="bi bi-pen me-2"></i>Tanda Tangan Asesor
                </span>
            </div>

            <div class="row g-4 mt-1">

                {{-- Kiri: Umpan Balik --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <div class="fw-bold mb-3 pb-2 border-bottom" style="color:#333;">
                            <i class="bi bi-chat-square-text me-2" style="color:#041562;"></i>Umpan Balik untuk Asesi
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:0.9rem;">
                                Unit kompetensi / elemen / KUK yang belum tercapai:
                            </label>
                            <textarea id="unit_belum_tercapai" class="form-control rounded-3" rows="3"
                                      placeholder="Contoh: Unit X, Elemen Y, KUK Z..."
                                      style="border-color:#d0d7e8; font-size:0.9rem; resize:vertical;"></textarea>
                        </div>
                        <hr>
                        <div class="mb-1">
                            <label class="form-label fw-semibold" style="font-size:0.9rem;">Umpan balik untuk asesi:</label>
                            <textarea id="umpan_balik_input" class="form-control rounded-3" rows="4"
                                      placeholder="Tuliskan umpan balik untuk asesi..."
                                      style="border-color:#d0d7e8; font-size:0.9rem; resize:vertical;"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Kanan: TTD Asesor --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <div class="fw-bold mb-3 pb-2 border-bottom" style="color:#333;">
                            <i class="bi bi-pen me-2" style="color:#041562;"></i>Asesor
                        </div>
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
                </div>

            </div>{{-- end row --}}

            <div class="mt-4 text-center d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-success px-4 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-check-lg me-1"></i> Simpan Jawaban
                </button>
                <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill fw-semibold" id="backToSoalBtn">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Soal
                </button>
            </div>
        </div>{{-- end signature-section --}}

    </form>

    @if($pertanyaan->count())
    <button type="button" id="btn-ke-ttd" onclick="showTTDSection()"
            style="position:fixed; bottom:20px; right:20px; z-index:9999;
                   background-color:#041562; color:#fff; border:none; border-radius:50px; padding:10px 22px;
                   font-weight:600; font-size:0.85rem; box-shadow:0 4px 12px rgba(0,0,0,0.2);
                   display:flex; align-items:center; gap:6px; cursor:pointer; transition:opacity 0.2s;"
            onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
        <i class="bi bi-pen"></i> Ke Tanda Tangan
    </button>
    @endif

</div>

<script>
const timerKey = 'lisanTimer_{{ $pembuatan->id_pembuatan_pertanyaan }}_{{ $asesi->id_asesi }}';
const savedTimer = sessionStorage.getItem(timerKey);
let totalDetik = (savedTimer !== null && !isNaN(parseInt(savedTimer)))
                 ? parseInt(savedTimer)
                 : {{ ($pembuatan->timer ?? 30) * 60 }};
let sudahSubmit = false;

function updateTimer() {
    if (sudahSubmit) return;
    const menit = Math.floor(totalDetik / 60);
    const detik = totalDetik % 60;
    const el = document.getElementById('timer');
    el.textContent = String(menit).padStart(2, '0') + ':' + String(detik).padStart(2, '0');
    if (totalDetik <= 60) el.style.color = '#dc3545';
    if (totalDetik <= 0) {
        sessionStorage.removeItem(timerKey);
        sudahSubmit = true;
        Swal.fire({
            title: '⏰ Waktu Habis!',
            text: 'Silakan tanda tangan asesor sebelum menyimpan.',
            icon: 'warning',
            confirmButtonText: 'OK, Tanda Tangan',
            confirmButtonColor: '#041562',
            allowOutsideClick: false
        }).then(() => {
            showTTDSection();
            const backBtn = document.getElementById('backToSoalBtn');
            if (backBtn) backBtn.style.display = 'none';
        });
        return;
    }
    sessionStorage.setItem(timerKey, totalDetik);
    totalDetik--;
}
setInterval(updateTimer, 1000);
updateTimer();

function showTTDSection() {
    document.getElementById('soal-wrapper').style.display = 'none';
    document.getElementById('signature-section').style.display = '';
    const btnKeTTD = document.getElementById('btn-ke-ttd');
    if (btnKeTTD) btnKeTTD.style.display = 'none';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('backToSoalBtn').addEventListener('click', function () {
        document.getElementById('signature-section').style.display = 'none';
        document.getElementById('soal-wrapper').style.display = '';
        const btnKeTTD = document.getElementById('btn-ke-ttd');
        if (btnKeTTD) btnKeTTD.style.display = 'flex';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    const canvas = document.getElementById('ttd-asesor');
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.lineWidth = 2; ctx.lineCap = 'round'; ctx.strokeStyle = '#000';
    let isDrawing = false, lastX = 0, lastY = 0;

    function getPos(e) {
        const r = canvas.getBoundingClientRect();
        return { x: (e.clientX - r.left) * (canvas.width / r.width), y: (e.clientY - r.top) * (canvas.height / r.height) };
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
    ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, canvas.width, canvas.height);
}

function saveSignature() {
    const canvas = document.getElementById('ttd-asesor');
    const blank = document.createElement('canvas');
    blank.width = canvas.width; blank.height = canvas.height;
    if (canvas.toDataURL() !== blank.toDataURL()) {
        const small = document.createElement('canvas');
        small.width = 200; small.height = 100;
        const ctx = small.getContext('2d');
        ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, small.width, small.height);
        ctx.drawImage(canvas, 0, 0, 200, 100);
        document.getElementById('ttd_asesor_data').value = small.toDataURL('image/jpeg', 0.4);
        document.getElementById('tgl_ttd_asesor_data').value = document.getElementById('tanggal-asesor').value;
    }

    const unit = document.getElementById('unit_belum_tercapai').value.trim();
    const umpan = document.getElementById('umpan_balik_input').value.trim();
    let gabungan = '';
    if (unit) gabungan += 'Unit/Elemen/KUK belum tercapai: ' + unit;
    if (unit && umpan) gabungan += '\n\n';
    if (umpan) gabungan += 'Umpan balik: ' + umpan;
    document.getElementById('umpan_balik_final').value = gabungan;
}

function validateAndSaveSignature() {
    const canvas = document.getElementById('ttd-asesor');
    const blank = document.createElement('canvas');
    blank.width = canvas.width; blank.height = canvas.height;
    if (canvas.toDataURL() === blank.toDataURL()) {
        Swal.fire({ title: 'Tanda Tangan Belum Diisi!', text: 'Asesor harus tanda tangan sebelum menyimpan.',
            icon: 'warning', confirmButtonText: 'OK', confirmButtonColor: '#041562' });
        return false;
    }
    saveSignature();
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
    if (mainContent) { mainContent.style.marginLeft = "0"; mainContent.style.width = "100%"; }
});
</script>
@endpush

@endsection