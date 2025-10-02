@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">

<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Daftar Skema</a></li>
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">FR.MAPA.01</li>
        </ol>
    </nav>
</div>

@php
    $ttd = DB::table('penyusun_persetujuan')
        ->where('id_skema', $skema->id_skema)
        ->where('id_asesor', $asesor_terpilih)
        ->where('role','asesor')
        ->first();
@endphp

<form action="{{ route('form_perencanaan.laporan_asesmen.laporan_asesor.store', $skema->id_skema) }}" method="POST" id="laporan-asesmen-form">
    @csrf
    <div class="mapa-card">
        <h5>Asesor</h5>

        <div class="col-md-12 mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $ttd->catatan ?? '') }}</textarea>
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Nama Asesor</label>
            <input type="text" class="form-control" 
                   value="{{ optional($asesors->firstWhere('id_asesor', $asesor_terpilih))->nama_asesor }}" 
                   readonly>
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Nomor Registrasi</label>
            <input type="text" class="form-control" value="{{ $no_registrasi_terpilih }}" readonly>
        </div>

        <input type="hidden" name="asesor_id" value="{{ $asesor_terpilih }}">
        <input type="hidden" name="tanda_tangan" id="tanda_tangan" value="{{ old('tanda_tangan', $ttd->tanda_tangan ?? '') }}">

        <div class="col-md-12 mb-3">
            <label class="form-label">Tanggal Asesmen</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Tanda Tangan</label>
            <canvas id="signature-preview" class="signature-preview" style="border:1px solid #ccc; width:100%; height:200px;"></canvas>
            <button type="button" id="clear-signature" class="btn btn-sm btn-outline-danger mt-2">Hapus Tanda Tangan</button>
        </div>

        @if($ttd && $ttd->tanda_tangan)
        <div class="mt-2">
            <a href="{{ route('form_perencanaan.laporan_asesmen.ttd.download', $ttd->id) }}" class="btn btn-sm btn-primary">Download TTD</a>
            <button type="button" class="btn btn-sm btn-danger" onclick="hapusTtd({{ $ttd->id }})">Hapus TTD</button>
        </div>
        @endif
    </div>

    <button type="submit" class="simpan-btn mt-3"><span>Simpan</span></button>
</form>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("signature-preview");
    const signaturePad = new SignaturePad(canvas);
    const hiddenInput = document.getElementById("tanda_tangan");

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);

        // Tampilkan TTD lama jika ada
        if(hiddenInput.value) {
            signaturePad.fromDataURL(hiddenInput.value);
        }
    }

    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();

    document.getElementById("clear-signature").addEventListener("click", () => {
        signaturePad.clear();
        hiddenInput.value = '';
    });

    document.getElementById("laporan-asesmen-form").addEventListener("submit", () => {
        if(!signaturePad.isEmpty()) {
            hiddenInput.value = signaturePad.toDataURL();
        }
    });
});

// Hapus TTD lama via AJAX
function hapusTtd(id){
    if(!confirm('Yakin ingin menghapus TTD?')) return;

    fetch(`/laporan_asesor/ttd/${id}`, {
        method: 'DELETE',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
    }).then(res => res.json()).then(res => {
        if(res.success) location.reload();
        else alert(res.message || 'Gagal menghapus TTD');
    });
}
</script>
@endsection
