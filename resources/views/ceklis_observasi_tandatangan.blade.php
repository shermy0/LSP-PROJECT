@extends('master')

@section('konten')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #041562;
        --primary-light: #0a2a9e;
        --primary-glow: rgba(4, 21, 98, 0.10);
        --accent-gold: #e8b84b;
        --text-main: #0d1b4b;
        --text-muted: #6b7fb5;
    }

    body, .container {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .ttd-wrapper {
        min-height: 100vh;
        background: linear-gradient(160deg, #eef2ff 0%, #f8faff 50%, #e8eeff 100%);
        padding: 3.5rem 0 5rem;
        position: relative;
        overflow: hidden;
    }

    .ttd-wrapper::before {
        content: '';
        position: absolute;
        top: -140px; right: -140px;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(4,21,98,0.07) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Page Header */
    .page-header { margin-bottom: 2rem; }

    .header-badge {
        display: inline-block;
        background: var(--primary-glow);
        color: var(--primary);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 50px;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(4,21,98,0.18);
    }

    .page-header h2 {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.2rem;
        line-height: 1.25;
    }

    .page-header p {
        color: var(--text-muted);
        font-size: 0.88rem;
        font-weight: 500;
        margin: 0;
    }

    .header-divider {
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--accent-gold));
        border-radius: 4px;
        margin-top: 1rem;
    }

    /* Section Card */
    .section-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid rgba(4,21,98,0.08);
        box-shadow: 0 4px 24px rgba(4,21,98,0.07);
        overflow: hidden;
        margin-bottom: 1.5rem;
        animation: fadeUp 0.45s ease both;
    }

    .section-card-header {
        background: var(--primary);
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-card-header .hicon {
        width: 38px;
        height: 38px;
        background: rgba(255,255,255,0.15);
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #fff;
        flex-shrink: 0;
    }

    .section-card-header h6 {
        color: #fff;
        font-weight: 700;
        font-size: 0.92rem;
        margin: 0;
    }

    .section-card-body { padding: 1.5rem; }

    /* Info table */
    .info-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    .info-table tr { border-bottom: 1px solid rgba(4,21,98,0.07); }
    .info-table tr:last-child { border-bottom: none; }

    .info-table th {
        padding: 10px 14px;
        font-weight: 700;
        color: var(--text-muted);
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        width: 35%;
        background: #f5f7ff;
    }

    .info-table td {
        padding: 10px 14px;
        color: var(--text-main);
        font-weight: 600;
    }

    /* Observasi table */
    .obs-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.82rem;
        border: 1px solid rgba(4,21,98,0.1);
    }

    .obs-table th,
    .obs-table td {
        border: 1px solid rgba(4,21,98,0.1);
        padding: 9px 12px;
        vertical-align: middle;
    }

    .obs-table thead th {
        background: var(--primary);
        color: #fff;
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 0.3px;
        text-align: center;
    }

    .obs-table tbody tr:nth-child(even) { background: #f8faff; }
    .obs-table tbody tr:hover { background: #eef2ff; }

    /* Badges */
    .badge-custom {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.73rem;
        font-weight: 700;
    }

    .badge-ya {
        background: rgba(22,163,74,0.1);
        color: #15803d;
        border: 1px solid rgba(22,163,74,0.25);
    }

    .badge-tidak {
        background: rgba(220,38,38,0.08);
        color: #b91c1c;
        border: 1px solid rgba(220,38,38,0.2);
    }

    .badge-kompeten {
        background: rgba(22,163,74,0.1);
        color: #15803d;
        border: 1px solid rgba(22,163,74,0.25);
        padding: 5px 14px;
        font-size: 0.8rem;
    }

    .badge-belum {
        background: rgba(220,38,38,0.08);
        color: #b91c1c;
        border: 1px solid rgba(220,38,38,0.2);
        padding: 5px 14px;
        font-size: 0.8rem;
    }

    .badge-neutral {
        background: rgba(107,127,181,0.1);
        color: var(--text-muted);
        border: 1px solid rgba(107,127,181,0.2);
    }

    /* Umpan balik box */
    .text-box {
        background: #f5f7ff;
        border: 1.5px solid rgba(4,21,98,0.1);
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 0.88rem;
        color: var(--text-main);
        font-weight: 500;
        min-height: 48px;
    }

    .field-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 6px;
        display: block;
    }

    /* Signature */
    .field-input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1.5px solid rgba(4,21,98,0.12);
        background: #f5f7ff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-main);
    }

    #ttd-asesi {
        display: block;
        width: 100%;
        max-width: 520px;
        height: 160px;
        border: 2px dashed rgba(4,21,98,0.2);
        border-radius: 12px;
        background: #fafbff;
        cursor: crosshair;
    }

    .btn-clear {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 8px;
        border: 1.5px solid rgba(217,119,6,0.4);
        background: rgba(217,119,6,0.07);
        color: #b45309;
        font-size: 0.8rem;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 10px;
    }

    .btn-clear:hover {
        background: rgba(217,119,6,0.15);
        border-color: rgba(217,119,6,0.6);
    }

    /* Action buttons */
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        border-radius: 12px;
        background: #15803d;
        color: #fff;
        font-weight: 700;
        font-size: 0.92rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: none;
        box-shadow: 0 4px 18px rgba(22,163,74,0.25);
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-submit:hover {
        background: #0d7a56;
        box-shadow: 0 6px 24px rgba(22,163,74,0.35);
        transform: translateY(-2px);
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 22px;
        border-radius: 12px;
        border: 2px solid var(--primary);
        color: var(--primary);
        background: transparent;
        font-weight: 700;
        font-size: 0.88rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-back:hover {
        background: var(--primary);
        color: #fff;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
    <div class="container">

    <center>
        <div class="page-header">
            <span class="header-badge">Ceklis Observasi</span>
            <h2>Tanda Tangan Asesi</h2>
            <p>Periksa hasil observasi dan berikan tanda tangan persetujuan.</p>
            <div class="header-divider"></div>
        </div>
        </center>

        {{-- IDENTITAS --}}
        <div class="section-card" style="animation-delay:0.05s">
            <div class="section-card-header">
                <div class="hicon"><i class="bi bi-person-badge-fill"></i></div>
                <h6>Identitas</h6>
            </div>
            <div class="section-card-body" style="padding:0;">
                <table class="info-table">
                    <tr>
                        <th>Nama Lengkap Asesi</th>
                        <td>{{ $observasi->asesi->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <th>Skema Sertifikasi</th>
                        <td>{{ $observasi->skema->nama_skema }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Observasi</th>
                        <td>
                            @if($observasi->persetujuan && $observasi->persetujuan->tgl_ttd_asesor)
                                {{ \Carbon\Carbon::parse($observasi->persetujuan->tgl_ttd_asesor)->format('d-m-Y') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Asesor</th>
                        <td>{{ $observasi->asesor->nama ?? auth()->user()->name }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- TABEL HASIL OBSERVASI --}}
        <div class="section-card" style="animation-delay:0.1s">
            <div class="section-card-header">
                <div class="hicon"><i class="bi bi-table"></i></div>
                <h6>Rincian Penilaian Observasi</h6>
            </div>
            <div class="section-card-body">
                <div class="table-responsive">
                    <table class="obs-table">
                        <thead>
                            <tr>
                                <th>Unit Kompetensi</th>
                                <th>Elemen</th>
                                <th>KUK</th>
                                <th>Standar Industri</th>
                                <th>Pencapaian</th>
                                <th>Penilaian Lanjut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($observasi->items as $item)
                            <tr>
                                <td>{{ $item->unit->judul_unit ?? 'Unit #'.$item->id_unit }}</td>
                                <td>{{ $item->elemen->nama_elemen ?? 'Elemen #'.$item->id_elemen }}</td>
                                <td>{{ $item->kuk->deskripsi_kuk ?? 'KUK #'.$item->id_kuk }}</td>
                                <td>{{ $item->standar_industri ?? '-' }}</td>
                                <td style="text-align:center;">
                                    @if($item->pencapaian == 'Ya')
                                        <span class="badge-custom badge-ya"><i class="bi bi-check-circle-fill"></i> Ya</span>
                                    @elseif($item->pencapaian == 'Tidak')
                                        <span class="badge-custom badge-tidak"><i class="bi bi-x-circle-fill"></i> Tidak</span>
                                    @else
                                        <span class="badge-custom badge-neutral">-</span>
                                    @endif
                                </td>
                                <td>{{ $item->penilaian_lanjut ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align:center; color:var(--text-muted); font-style:italic; padding:2rem;">
                                    Tidak ada data observasi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- UMPAN BALIK & REKOMENDASI --}}
        <div class="section-card" style="animation-delay:0.15s">
            <div class="section-card-header">
                <div class="hicon"><i class="bi bi-chat-left-text-fill"></i></div>
                <h6>Umpan Balik & Rekomendasi Asesor</h6>
            </div>
            <div class="section-card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="field-label">Umpan Balik</label>
                        <div class="text-box">{{ $observasi->umpan_balik ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="field-label">Rekomendasi</label>
                        <div class="text-box" style="display:flex; align-items:center;">
                            @if($observasi->rekomendasi == 'Kompeten')
                                <span class="badge-custom badge-kompeten"><i class="bi bi-check-circle-fill"></i> Kompeten</span>
                            @elseif($observasi->rekomendasi == 'Belum Kompeten')
                                <span class="badge-custom badge-belum"><i class="bi bi-x-circle-fill"></i> Belum Kompeten</span>
                            @else
                                {{ $observasi->rekomendasi ?? '-' }}
                            @endif
                        </div>
                    </div>

                    @if($observasi->rekomendasi_rincian)
                    <div class="col-12">
                        <label class="field-label">Rincian Rekomendasi</label>
                        <div class="text-box">{{ $observasi->rekomendasi_rincian }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- FORM TANDA TANGAN ASESI --}}
        <form method="POST" action="{{ route('ceklisobservasi.storeTandatangan') }}" id="formTtd" onsubmit="return validateAndSaveSignature()">
            @csrf
            <input type="hidden" name="id_observasi" value="{{ $observasi->id_observasi }}">
            <input type="hidden" name="tgl_ttd_asesi" id="tgl_ttd_asesi" value="{{ now()->toDateString() }}">
            <input type="hidden" name="ttd_asesi" id="ttd_asesi">

            <div class="section-card" style="animation-delay:0.2s">
                <div class="section-card-header">
                    <div class="hicon"><i class="bi bi-pen-fill"></i></div>
                    <h6>Tanda Tangan Asesi</h6>
                </div>
                <div class="section-card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="field-label">Nama Lengkap</label>
                            <input type="text" class="field-input" value="{{ $observasi->asesi->nama_lengkap }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="field-label">Tanggal</label>
                            <input type="date" id="tanggal-asesi" class="field-input" value="{{ date('Y-m-d') }}" readonly>
                        </div>
                    </div>

                    <center>
                    <label class="field-label">Tanda Tangan</label>
                    <canvas id="ttd-asesi"></canvas>
                    <br>
                    <button type="button" class="btn-clear" onclick="clearCanvas()">
                        <i class="bi bi-eraser-fill"></i> Hapus Tanda Tangan
                    </button>
                    </center>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center gap-3 mt-2">
                <button type="submit" class="btn-submit">
                    <i class="bi bi-check-circle-fill"></i> Kirim Tanda Tangan
                </button>
            </div>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');

    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#041562';

    let isDrawing = false;
    let lastX = 0, lastY = 0;

    function getPosFromEvent(e) {
        const rect = canvas.getBoundingClientRect();
        if (e.touches && e.touches.length > 0) {
            return { x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top };
        }
        return { x: e.clientX - rect.left, y: e.clientY - rect.top };
    }

    function startDrawing(e) {
        e.preventDefault();
        const pos = getPosFromEvent(e);
        isDrawing = true;
        lastX = pos.x; lastY = pos.y;
    }

    function draw(e) {
        if (!isDrawing) return;
        e.preventDefault();
        const pos = getPosFromEvent(e);
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        lastX = pos.x; lastY = pos.y;
    }

    function stopDrawing(e) {
        if (!isDrawing) return;
        e && e.preventDefault();
        isDrawing = false;
    }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);
    canvas.addEventListener('touchstart', startDrawing, { passive: false });
    canvas.addEventListener('touchmove', draw, { passive: false });
    canvas.addEventListener('touchend', stopDrawing, { passive: false });

    window.clearCanvas = function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    };

    function isCanvasBlank() {
        const blank = document.createElement('canvas');
        blank.width = canvas.width;
        blank.height = canvas.height;
        const bctx = blank.getContext('2d');
        bctx.fillStyle = '#ffffff';
        bctx.fillRect(0, 0, blank.width, blank.height);
        return canvas.toDataURL() === blank.toDataURL();
    }

    window.validateAndSaveSignature = function () {
        if (isCanvasBlank()) {
            Swal.fire({
                icon: 'warning',
                title: 'Tanda Tangan Belum Diisi!',
                text: 'Silakan isi tanda tangan sebelum mengirim.',
                confirmButtonColor: '#041562'
            });
            return false;
        }
        document.getElementById('ttd_asesi').value = canvas.toDataURL('image/png');
        document.getElementById('tgl_ttd_asesi').value = document.getElementById('tanggal-asesi').value;
        return true;
    };
});
</script>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
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