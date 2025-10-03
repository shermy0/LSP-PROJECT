@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.index') }}">Daftar Skema</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01', ['id_skema' => $skema->id_skema]) }}">FR.MAPA.01</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01.kodeunit', $skema->id_skema) }}">Rencana Asesmen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Persyaratan</li>
        </ol>
    </nav>
</div>

<div class="container mt-3">
    <div class="judul-header">Mengidentifikasi Persyaratan Modifikasi dan Kontekstualisasi:
</div>
<form action="{{ route('form.mapa01.modifikasi.store', ['skema_id' => $skema->id_skema]) }}" method="POST">
    @csrf

    <!-- 3.1 a -->
    <div class="mb-3 p-3 border rounded bg-light">
    <div class="mapa-subsection-header">3.1 a. Karakteristik Kandidat:</div>
        <div class="d-flex gap-3 my-2">
            <label>
                <input type="radio" name="karakteristik_kandidat" value="Tidak Ada" class="toggle-textarea form-check-input me-2" data-target="#karakteristik_text"
                    {{ (isset($modifikasi) && $modifikasi->karakteristik_kandidat == 'Tidak Ada') ? 'checked' : '' }}>
                Tidak Ada
            </label>
            <label>
                <input type="radio" name="karakteristik_kandidat" value="Ada" class="toggle-textarea form-check-input me-2" data-target="#karakteristik_text"
                    {{ (isset($modifikasi) && $modifikasi->karakteristik_kandidat == 'Ada') ? 'checked' : '' }}>
                Ada
            </label>
        </div>
        <textarea id="karakteristik_text" name="karakteristik_text" class="form-control mt-2"
            {{ (isset($modifikasi) && $modifikasi->karakteristik_kandidat == 'Ada') ? '' : 'disabled' }}>
            {{ $modifikasi->karakteristik_keterangan ?? '' }}
        </textarea>
    </div>

    <!-- 3.1 b -->
    <div class="mb-3 p-3 border rounded bg-light">
    <div class="mapa-subsection-header">3.1 b. Kebutuhan kontekstualisasi terkait tempat kerja:</div>
        <div class="d-flex gap-3 my-2">
            <label>
                <input type="radio" name="kebutuhan_kontekstual" value="Tidak Ada" class="toggle-textarea form-check-input me-2" data-target="#kontekstual_text"
                    {{ (isset($modifikasi) && $modifikasi->kebutuhan_tempat_kerja == 'Tidak Ada') ? 'checked' : '' }}>
                Tidak Ada
            </label>
            <label>
                <input type="radio" name="kebutuhan_kontekstual" value="Ada" class="toggle-textarea form-check-input me-2" data-target="#kontekstual_text"
                    {{ (isset($modifikasi) && $modifikasi->kebutuhan_tempat_kerja == 'Ada') ? 'checked' : '' }}>
                Ada
            </label>
        </div>
        <textarea id="kontekstual_text" name="kontekstual_text" class="form-control mt-2"
            {{ (isset($modifikasi) && $modifikasi->kebutuhan_tempat_kerja == 'Ada') ? '' : 'disabled' }}>
            {{ $modifikasi->kebutuhan_keterangan ?? '' }}
        </textarea>
    </div>

    <!-- 3.2 -->
    <div class="mb-3 p-3 border rounded bg-light">
    <div class="mapa-subsection-header">3.2 Saran yang diberikan oleh paket pelatihan atau pengembang pelatihan</div>
        <div class="d-flex gap-3 my-2">
            <label>
                <input type="radio" name="saran_pelatihan" value="Tidak Ada" class="toggle-textarea form-check-input me-2" data-target="#saran_text"
                    {{ (isset($modifikasi) && $modifikasi->saran_pelatihan == 'Tidak Ada') ? 'checked' : '' }}>
                Tidak Ada
            </label>
            <label>
                <input type="radio" name="saran_pelatihan" value="Ada" class="toggle-textarea form-check-input me-2" data-target="#saran_text"
                    {{ (isset($modifikasi) && $modifikasi->saran_pelatihan == 'Ada') ? 'checked' : '' }}>
                Ada
            </label>
        </div>
        <textarea id="saran_text" name="saran_text" class="form-control mt-2"
            {{ (isset($modifikasi) && $modifikasi->saran_pelatihan == 'Ada') ? '' : 'disabled' }}>
            {{ $modifikasi->saran_keterangan ?? '' }}
        </textarea>
    </div>

    <!-- 3.3 -->
    <div class="mb-3 p-3 border rounded bg-light">
    <div class="mapa-subsection-header">3.3. Penyesuaian perangkat asesmen terkait kebutuhan kontekstualisasi</div>
        <div class="d-flex gap-3 my-2">
            <label>
                <input type="radio" name="penyesuaian_asesmen" value="Tidak Ada" class="toggle-textarea form-check-input me-2" data-target="#penyesuaian_text"
                    {{ (isset($modifikasi) && $modifikasi->penyesuaian_asesmen == 'Tidak Ada') ? 'checked' : '' }}>
                Tidak Ada
            </label>
            <label>
                <input type="radio" name="penyesuaian_asesmen" value="Ada" class="toggle-textarea form-check-input me-2" data-target="#penyesuaian_text"
                    {{ (isset($modifikasi) && $modifikasi->penyesuaian_asesmen == 'Ada') ? 'checked' : '' }}>
                Ada
            </label>
        </div>
        <textarea id="penyesuaian_text" name="penyesuaian_text" class="form-control mt-2"
            {{ (isset($modifikasi) && $modifikasi->penyesuaian_asesmen == 'Ada') ? '' : 'disabled' }}>
            {{ $modifikasi->penyesuaian_keterangan ?? '' }}
        </textarea>
    </div>

    <!-- 3.4 -->
    <div class="mb-3 p-3 border rounded bg-light">
    <div class="mapa-subsection-header">3.4. Peluang untuk kegiatan asesmen terintegrasi dan mencatat setiap perubahan yang diperlukan untuk alat asesmen</div>
        <div class="d-flex gap-3 my-2">
            <label>
                <input type="radio" name="peluang_asesmen" value="Tidak Ada" class="toggle-textarea form-check-input me-2" data-target="#peluang_text"
                    {{ (isset($modifikasi) && $modifikasi->peluang_asesmen == 'Tidak Ada') ? 'checked' : '' }}>
                Tidak Ada
            </label>
            <label>
                <input type="radio" name="peluang_asesmen" value="Ada" class="toggle-textarea form-check-input me-2" data-target="#peluang_text"
                    {{ (isset($modifikasi) && $modifikasi->peluang_asesmen == 'Ada') ? 'checked' : '' }}>
                Ada
            </label>
        </div>
        <textarea id="peluang_text" name="peluang_text" class="form-control mt-2"
            {{ (isset($modifikasi) && $modifikasi->peluang_asesmen == 'Ada') ? '' : 'disabled' }}>
            {{ $modifikasi->peluang_keterangan ?? '' }}
        </textarea>
    </div>

    <!-- Tombol -->
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('form.mapa01.kodeunit', ['skema_id' => $skema->id_skema]) }}" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="simpan-btn">
        <span>Simpan dan Lanjut</span>
    </button>
    </div>

</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('input.toggle-textarea').on('change', function () {
        let target = $(this).data('target');
        if ($(this).val().toLowerCase() === 'ada') {
            $(target).prop('disabled', false);
        } else {
            $(target).prop('disabled', true).val('');
        }
    });
});
</script>

@endsection
