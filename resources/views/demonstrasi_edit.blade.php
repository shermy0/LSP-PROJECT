@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Edit Tugas Demonstrasi</h4>

    <form id="formEditDemonstrasi" 
          action="{{ route('demonstrasi.update', $tugas->id_tugas) }}" 
          method="POST">
        @csrf
        @method('PUT')

        <!-- Hidden: foreign key -->
        <input type="hidden" name="id_demonstrasi" value="{{ $tugas->id_demonstrasi }}">

        <!-- Nama Tugas -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold">Nama Tugas</h6>
                <input type="text" name="nama_tugas" class="form-control mb-2" 
                       value="{{ old('nama_tugas', $tugas->nama_tugas) }}" required>

                <h6 class="fw-bold mt-3">Deskripsi Pertanyaan</h6>
                <textarea name="deskripsi_pertanyaan" class="form-control" rows="3" required>{{ old('deskripsi_pertanyaan', $tugas->deskripsi_pertanyaan) }}</textarea>
            </div>
        </div>

        <!-- Tombol -->
        <button type="button" class="btn btn-success" onclick="konfirmasiEdit()">Simpan Perubahan</button>
        <a href="{{ route('demonstrasi.crud', $tugas->id_demonstrasi) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
function konfirmasiEdit() {
    if (confirm("Apakah anda yakin ingin menyimpan perubahan?")) {
        document.getElementById('formEditDemonstrasi').submit();
    }
}
</script>
@endsection
