@extends('master')
@section('konten')
        <div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01') }}">FR.MAPA.01</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01.kodeunit', $skema->id_skema) }}">Rencana Asesmen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Unit</li>
        </ol>
    </nav>
</div>

<div class="container mt-3">

    <form action="" method="POST">
        @csrf

        <!-- 3.1 a -->
        <div class="mb-3 p-3 border rounded bg-light">
            <label class="fw-bold">3.1 a. Karakteristik Kandidat:</label>
            <div class="d-flex gap-3 my-2">
                <label><input type="radio" name="karakteristik_kandidat" value="Tidak Ada" class="toggle-textarea" data-target="#karakteristik_text"> Tidak Ada</label>
                <label><input type="radio" name="karakteristik_kandidat" value="Ada" class="toggle-textarea" data-target="#karakteristik_text"> Ada</label>
            </div>
            <textarea id="karakteristik_text" name="karakteristik_text" class="form-control mt-2" disabled></textarea>
        </div>

        <!-- 3.1 b -->
        <div class="mb-3 p-3 border rounded bg-light">
            <label class="fw-bold">3.1 b. Kebutuhan kontekstualisasi terkait tempat kerja:</label>
            <div class="d-flex gap-3 my-2">
                <label><input type="radio" name="kebutuhan_kontekstual" value="Tidak Ada" class="toggle-textarea" data-target="#kontekstual_text"> Tidak Ada</label>
                <label><input type="radio" name="kebutuhan_kontekstual" value="Ada" class="toggle-textarea" data-target="#kontekstual_text"> Ada</label>
            </div>
            <textarea id="kontekstual_text" name="kontekstual_text" class="form-control mt-2" disabled></textarea>
        </div>

        <!-- 3.2 -->
        <div class="mb-3 p-3 border rounded bg-light">
            <label class="fw-bold">3.2 Saran yang diberikan oleh paket pelatihan atau pengembang pelatihan:</label>
            <div class="d-flex gap-3 my-2">
                <label><input type="radio" name="saran_pelatihan" value="Tidak Ada" class="toggle-textarea" data-target="#saran_text"> Tidak Ada</label>
                <label><input type="radio" name="saran_pelatihan" value="Ada" class="toggle-textarea" data-target="#saran_text"> Ada</label>
            </div>
            <textarea id="saran_text" name="saran_text" class="form-control mt-2" disabled></textarea>
        </div>

        <!-- 3.3 -->
        <div class="mb-3 p-3 border rounded bg-light">
            <label class="fw-bold">3.3 Penyesuaian perangkat asesmen terkait kebutuhan kontekstualisasi:</label>
            <div class="d-flex gap-3 my-2">
                <label><input type="radio" name="penyesuaian_asesmen" value="Tidak Ada" class="toggle-textarea" data-target="#penyesuaian_text"> Tidak Ada</label>
                <label><input type="radio" name="penyesuaian_asesmen" value="Ada" class="toggle-textarea" data-target="#penyesuaian_text"> Ada</label>
            </div>
            <textarea id="penyesuaian_text" name="penyesuaian_text" class="form-control mt-2" disabled></textarea>
        </div>

        <!-- 3.4 -->
        <div class="mb-3 p-3 border rounded bg-light">
            <label class="fw-bold">3.4 Peluang untuk kegiatan asesmen terintegrasi:</label>
            <div class="d-flex gap-3 my-2">
                <label><input type="radio" name="peluang_asesmen" value="Tidak Ada" class="toggle-textarea" data-target="#peluang_text"> Tidak Ada</label>
                <label><input type="radio" name="peluang_asesmen" value="Ada" class="toggle-textarea" data-target="#peluang_text"> Ada</label>
            </div>
            <textarea id="peluang_text" name="peluang_text" class="form-control mt-2" disabled></textarea>
        </div>

        <!-- Tombol -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('form.mapa01') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('form.mapa01.konfirmasi', ['skema_id' => $skema->id_skema]) }}" class="btn btn-primary">Simpan dan Lanjut</a>
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
