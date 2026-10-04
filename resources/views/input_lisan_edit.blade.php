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

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('lisan.crud', $pertanyaan->id_skema) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="button" class="btn btn-success" onclick="konfirmasiEdit()">
                <i class="bi bi-save"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function konfirmasiEdit() {
    Swal.fire({
        icon: 'question',
        title: 'Simpan perubahan?',
        text: 'Perubahan pada pertanyaan lisan akan disimpan.',
        showCancelButton: true,
        confirmButtonText: 'Ya, simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#041562',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formEditPertanyaan').submit();
        }
    });
}

</script>
@endsection
