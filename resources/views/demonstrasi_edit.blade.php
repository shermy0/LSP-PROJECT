@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.06 – Edit Tugas Demonstrasi</h4>

    {{-- Form Update --}}
    <form id="formEditDemonstrasi" 
          action="{{ route('demonstrasi.update', $tugas->id_tugas_demonstrasi) }}" 
          method="POST">
        @csrf
        @method('PUT')

        <!-- Hidden -->
        <input type="hidden" name="id_skema" value="{{ $tugas->id_skema }}">
        <input type="hidden" name="id_kelompok" value="{{ $tugas->id_kelompok }}">

        <!-- Pertanyaan -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold">Pertanyaan Demonstrasi</h6>
                <textarea name="isi_pertanyaan_demonstrasi" 
                          class="form-control mb-2" required>{{ old('isi_pertanyaan_demonstrasi', $tugas->isi_pertanyaan_demonstrasi) }}</textarea>

                <h6 class="fw-bold mt-3">Deskripsi Pertanyaan (Opsional)</h6>
                <textarea name="deskripsi_pertanyaan" 
                          class="form-control mb-2">{{ old('deskripsi_pertanyaan', $tugas->deskripsi_pertanyaan) }}</textarea>

                <h6 class="fw-bold mt-3">Kunci Jawaban (Opsional)</h6>
                <input type="text" name="kunci_jawaban" class="form-control"
                       value="{{ old('kunci_jawaban', $tugas->kunci_jawaban) }}" 
                       placeholder="Kunci jawaban">

                <h6 class="fw-bold mt-3">Jenis Pertanyaan</h6>
                <select name="file_type" class="form-control">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="text"   {{ $tugas->file_type == 'text' ? 'selected' : '' }}>Teks</option>
                    <option value="file"   {{ $tugas->file_type == 'file' ? 'selected' : '' }}>File Dokumen</option>
                    <option value="video"  {{ $tugas->file_type == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="audio"  {{ $tugas->file_type == 'audio' ? 'selected' : '' }}>Audio</option>
                    <option value="gambar" {{ $tugas->file_type == 'gambar' ? 'selected' : '' }}>Gambar</option>
                </select>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success" onclick="konfirmasiEdit()">Simpan Perubahan</button>
            
            {{-- Form Delete --}}
            <form id="formDeleteDemonstrasi" 
                  action="{{ route('demonstrasi.destroy', $tugas->id_tugas_demonstrasi) }}" 
                  method="POST" 
                  onsubmit="return confirm('Yakin ingin menghapus tugas ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus Tugas</button>
            </form>

            <button type="button" class="btn btn-secondary" onclick="stayHere()">Batal</button>
        </div>
    </form>
</div>

<script>
function konfirmasiEdit() {
    if (confirm("Apakah anda yakin ingin menyimpan perubahan?")) {
        document.getElementById('formEditDemonstrasi').submit();
    }
}

function stayHere() {
    alert("Edit dibatalkan. Anda tetap di halaman ini.");
}
</script>
@endsection
