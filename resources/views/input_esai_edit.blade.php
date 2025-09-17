@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Edit Pertanyaan Esai</h4>

    <form id="formEditPertanyaan" action="{{ route('pertanyaan.esai.update', $pertanyaan->id_pertanyaan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Skema tetap -->
        <input type="hidden" name="id_skema" value="{{ $pertanyaan->id_skema }}">
        <input type="hidden" name="id_asesor" value="{{ $pertanyaan->id_asesor }}">

        <!-- Pertanyaan yang mau diedit -->
        <div class="card mb-3 shadow-sm pertanyaan-item">
            <div class="card-body">
                <h6 class="fw-bold">Pertanyaan</h6>

                {{-- File lama --}}
                @if($pertanyaan->file_path)
                    <p><strong>Lampiran sebelumnya:</strong> 
                        <a href="{{ asset('storage/'.$pertanyaan->file_path) }}" target="_blank">Lihat File</a>
                    </p>

                    {{-- Preview gambar kalau jpg/png --}}
                    @if(in_array($pertanyaan->file_type, ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/'.$pertanyaan->file_path) }}" alt="Lampiran Pertanyaan" class="img-fluid mb-2" style="max-width:200px;">
                    @endif
                @endif

                {{-- Upload file baru --}}
                <input type="file" name="file" class="form-control mb-2"
                    accept=".jpg,.jpeg,.png,.pdf,.docx,.mp3,.mp4">
                <small class="text-muted">Kosongkan jika tidak ingin ganti file</small>

                {{-- Isi pertanyaan --}}
                <textarea name="isi_pertanyaan" class="form-control mb-2" required>{{ old('isi_pertanyaan', $pertanyaan->isi_pertanyaan) }}</textarea>

                {{-- Kunci jawaban --}}
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
    let konfirmasi = confirm("Apakah anda sudah yakin ingin menyimpan perubahan?");
    if (konfirmasi) {
        document.getElementById('formEditPertanyaan').submit();
    }
}

// tombol batal → tidak pindah halaman, hanya kasih alert
function stayHere() {
    alert("Edit dibatalkan. Anda tetap di halaman ini.");
}
</script>
@endsection
