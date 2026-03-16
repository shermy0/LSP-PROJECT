@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Edit Pertanyaan Lisan</h4>

    <form id="formEditPertanyaan" 
          action="{{ route('lisan.update', $pertanyaan->id_pertanyaan) }}" 
          method="POST">
        @csrf
        @method('PUT')

        <!-- Skema tetap -->
        <input type="hidden" name="id_skema" value="{{ $pertanyaan->id_skema }}">
        <input type="hidden" name="id_asesor" value="{{ $pertanyaan->id_asesor }}">

        <!-- Pertanyaan -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold">Pertanyaan</h6>
                <textarea name="isi_pertanyaan" class="form-control mb-2" required>{{ old('isi_pertanyaan', $pertanyaan->isi_pertanyaan) }}</textarea>

                <h6 class="fw-bold mt-3">Kunci Jawaban</h6>
                <input type="text" name="kunci_jawaban" class="form-control"
                    value="{{ old('kunci_jawaban', $pertanyaan->kunci_jawaban) }}" placeholder="Kunci jawaban">
            </div>
        </div>

        <button type="button" class="btn btn-success" onclick="konfirmasiEdit()">Simpan Perubahan</button>
        <button type="button" class="btn btn-secondary" onclick="stayHere()">Batal</button>
    </form>
</div>

<script>
function konfirmasiEdit() {
    if (confirm("Apakah anda yakin ingin menyimpan perubahan?")) {
        document.getElementById('formEditPertanyaan').submit();
    }
}

function stayHere() {
    alert("Edit dibatalkan. Anda tetap di halaman ini.");
}
</script>
@endsection
