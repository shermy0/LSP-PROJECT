@extends('master')

@section('konten')
<div class="container py-4">
    <h3 class="fw-bold text-center mb-2">FR.IA.06 – Tanda Tangan Asesor</h3>
    <p class="text-muted text-center mb-4">Tugas Praktik Demonstrasi · {{ $skema->nama_skema }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card shadow-sm p-4">
        <form id="formTtdDemonstrasi" method="POST"
              action="{{ route('demonstrasi.ttd.store', [$skema->id_skema, $demonstrasi->id_demonstrasi]) }}">
            @csrf
            <input type="hidden" name="ttd_asesor" id="ttd_asesor">
            <input type="hidden" name="tgl_ttd_asesor" value="{{ now()->toDateString() }}">
            <input type="hidden" name="id_kelompok" value="{{ $id_kelompok }}">

            <div class="row g-4 align-items-start">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Asesor</label>
                        <input class="form-control" value="{{ $asesor->nama_asesor }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal</label>
                        <input class="form-control" value="{{ now()->format('d/m/Y') }}" readonly>
                    </div>
                    <div>
                        <label class="form-label fw-bold">Nomor MET</label>
                        <input class="form-control" value="{{ $asesor->no_registrasi ?? '-' }}" readonly>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <label class="form-label fw-bold d-block">Tanda Tangan</label>
                    <canvas id="signaturePad" width="500" height="200"
                            class="border rounded bg-white w-100" style="touch-action:none; max-width:500px"></canvas>
                    <div>
                        <button type="button" id="clearSignature" class="btn btn-outline-secondary btn-sm mt-2">Hapus</button>
                    </div>
                    @if($tandaTangan?->ttd_asesor)
                        <div class="mt-3">
                            <div class="small text-muted mb-1">Tanda tangan tersimpan</div>
                            <img src="{{ asset('storage/ttd/'.$tandaTangan->ttd_asesor) }}" alt="Tanda tangan asesor" style="max-height:80px">
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-center gap-2 mt-4">
                <a href="{{ route('formasesmen.show', $skema->id_skema) }}" class="btn btn-outline-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan TTD</button>
            </div>
        </form>
    </div>
</div>

<script>
(() => {
    const canvas = document.getElementById('signaturePad');
    const ctx = canvas.getContext('2d');
    const form = document.getElementById('formTtdDemonstrasi');
    let drawing = false;
    let hasSignature = false;

    function point(event) {
        const rect = canvas.getBoundingClientRect();
        return {
            x: (event.clientX - rect.left) * canvas.width / rect.width,
            y: (event.clientY - rect.top) * canvas.height / rect.height,
        };
    }

    canvas.addEventListener('pointerdown', event => {
        drawing = true;
        canvas.setPointerCapture(event.pointerId);
        const p = point(event);
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
    });
    canvas.addEventListener('pointermove', event => {
        if (!drawing) return;
        const p = point(event);
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#111';
        ctx.lineTo(p.x, p.y);
        ctx.stroke();
        hasSignature = true;
    });
    ['pointerup', 'pointercancel'].forEach(name => canvas.addEventListener(name, () => drawing = false));

    document.getElementById('clearSignature').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hasSignature = false;
    });

    form.addEventListener('submit', event => {
        if (!hasSignature) {
            event.preventDefault();
            alert('Tanda tangan belum diisi.');
            return;
        }
        document.getElementById('ttd_asesor').value = canvas.toDataURL('image/png');
    });
})();
</script>
@endsection
