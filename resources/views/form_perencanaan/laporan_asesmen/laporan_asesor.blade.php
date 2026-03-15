@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="card-box">
    <!-- Breadcrumb -->
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Daftar Skema</a></li>
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a></li>
<li class="breadcrumb-item active">
    <a href="{{ route('laporan.show', $skema->id_skema) }}">FR.AK.05</a>
</li>
            <li class="breadcrumb-item active" aria-current="page">Catatan & Tanda Tangan Asesor</li>
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
<button type="button" class="btn btn-sm btn-danger"
    onclick="hapusTtd({{ $ttd->id }}, '{{ route('form_perencanaan.laporan_asesmen.ttd.delete', $ttd->id) }}')">
    Hapus TTD
</button>
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

        if(hiddenInput.value){
            try{
                signaturePad.fromDataURL(hiddenInput.value);
            }catch(e){
                console.error("Gagal load TTD lama:", e);
            }
        }
    }

    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();

    document.getElementById("clear-signature").addEventListener("click", () => {
        signaturePad.clear();
        hiddenInput.value = '';
    });

    // SweetAlert simpan + reload
    document.getElementById("laporan-asesmen-form").addEventListener("submit", function(e){
        e.preventDefault();

        // Simpan TTD ke hidden input
        if(!signaturePad.isEmpty()){
            hiddenInput.value = signaturePad.toDataURL();
        }

        Swal.fire({
            title: "Berhasil!",
            text: "Tanda tangan dan catatan berhasil disimpan.",
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Tetap di Halaman",
            cancelButtonText: "Ke Form Perencanaan"
        }).then((result) => {
            if(result.isConfirmed){
                e.target.submit();
            } else {
                window.location.href = "{{ route('formperencanaan.show', $skema->id_skema) }}";
            }
        });
    });
});

function hapusTtd(id, url) {
    Swal.fire({
        title: 'Yakin ingin menghapus TTD?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if(result.isConfirmed){
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                if(res.success){
                    Swal.fire('Terhapus!', res.message, 'success').then(()=>{
                        // reload halaman tapi tetap di asesor saat ini
                        const currentAsesor = "{{ $asesor_terpilih }}";
                        window.location.href = "{{ route('form_perencanaan.laporan_asesmen.laporan_asesor', $skema->id_skema) }}?asesor_id=" + currentAsesor;
                    });
                } else {
                    Swal.fire('Gagal!', res.message, 'error');
                }
            })
            .catch(err=>{
                Swal.fire('Gagal!', 'Terjadi kesalahan server.', 'error');
                console.error(err);
            });
        }
    });
}
</script>
@endsection
