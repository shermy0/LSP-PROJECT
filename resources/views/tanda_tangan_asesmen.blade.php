@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold text-center mb-4">FR.IA.07 – DPL – Tanda Tangan Pembuatan Asesmen</h4>
    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form TTD --}}
    <div class="card shadow p-4">
        <form action="{{ route('tanda.tangan.asesmen.simpan', [$id_skema, $id_pembuatan_pertanyaan]) }}" method="POST">
            @csrf

            <input type="hidden" name="id_pembuatan_pertanyaan" value="{{ $pembuatan_pertanyaan->id_pembuatan_pertanyaan }}">
            <input type="hidden" name="id_asesor" value="{{ $asesorLogin->id_asesor }}">
            <input type="hidden" name="ttd_asesor" id="ttd_asesor">

            <div class="row">
                {{-- Kiri: Nama & Nomor MET --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Asesor</label>
                        <input type="text" class="form-control" value="{{ $asesorLogin->nama_asesor }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal</label>
                        <input type="date" 
                               name="tgl_ttd_asesor" 
                               class="form-control" 
                               value="{{ date('Y-m-d') }}" 
                               readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor MET</label>
                        <input type="text" class="form-control" value="{{ $asesorLogin->no_registrasi }}" readonly>
                    </div>
                </div>

                {{-- Kanan: Tanda tangan --}}
                <div class="col-md-6 text-center">
                    <label class="form-label fw-bold">Tanda Tangan</label>
                    <canvas id="signature-pad" class="border rounded bg-light d-block mx-auto" width="300" height="150"></canvas>
                    <button type="button" class="btn btn-secondary btn-sm mt-2" id="clear">Hapus</button>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary" onclick="saveSignature()">Simpan TTD</button>
            </div>
        </form>
    </div>

    {{-- Daftar asesor yang sudah tanda tangan --}}
    <div class="card shadow p-4 mt-4">
        <h5 class="mb-3">Asesor yang sudah tanda tangan</h5>

        @if($asesorSudahTTD->isEmpty())
            <p class="text-muted">Belum ada tanda tangan.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal TTD</th>
                        <th>Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asesorSudahTTD as $a)
                        <tr>
                            <td>{{ $a->nama_asesor }}</td>
                            <td>{{ $a->tgl_ttd_asesor }}</td>
                            <td>
                                @if($a->ttd_asesor)
                                    <img src="{{ asset('storage/ttd/'.$a->ttd_asesor) }}" alt="TTD" style="height:50px;">
                                @else
                                    <span class="text-muted">Belum ada</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- JS Signature Pad --}}
<script>
    let canvas = document.getElementById('signature-pad');
    let ctx = canvas.getContext('2d');
    let drawing = false;

    ctx.fillStyle = "#fff";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    canvas.addEventListener('mousedown', () => { drawing = true; });
    canvas.addEventListener('mouseup', () => { drawing = false; ctx.beginPath(); });
    canvas.addEventListener('mousemove', draw);

    function draw(event) {
        if (!drawing) return;
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';
        ctx.lineTo(event.offsetX, event.offsetY);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(event.offsetX, event.offsetY);
    }

    document.getElementById('clear').addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = "#fff";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    });

    function isCanvasBlank(cnv) {
        const blank = document.createElement('canvas');
        blank.width = cnv.width;
        blank.height = cnv.height;
        let blankCtx = blank.getContext('2d');
        blankCtx.fillStyle = "#fff";
        blankCtx.fillRect(0, 0, blank.width, blank.height);
        return cnv.toDataURL() === blank.toDataURL();
    }

    function saveSignature() {
        if (isCanvasBlank(canvas)) {
            alert("Tanda tangan tidak boleh kosong!");
            event.preventDefault();
            return false;
        }
        let dataURL = canvas.toDataURL('image/png');
        document.getElementById('ttd_asesor').value = dataURL;
    }
</script>
{{-- Kembali (kiri bawah) --}}
@php
    $pmoRec  = \App\Models\PMO::where('id_skema', $skema->id_skema)->latest('id_pmo')->first();
    $backUrl = route('pertanyaan.pmo.kelompok', ['id_skema' => $skema->id_skema])
             . '?id_pembuatan=' . $id_pembuatan_pertanyaan
             . '&id_pmo=' . ($pmoRec->id_pmo ?? '')
             . '&timer=' . ($pembuatan_pertanyaan->timer ?? 30);
@endphp
<a href="{{ $backUrl }}"
   style="position:fixed; bottom:20px; left:260px; z-index:9999;
          background-color:#041562; color:#fff; border:none;
          border-radius:50px; padding:10px 18px;
          font-weight:600; font-size:0.85rem;
          box-shadow:0 4px 12px rgba(0,0,0,0.2);
          display:flex; align-items:center; gap:6px;
          text-decoration:none; transition:opacity 0.2s;"
   onmouseover="this.style.opacity='0.85'"
   onmouseout="this.style.opacity='1'">
    <i class="bi bi-arrow-left"></i> Kembali
</a>
@endsection