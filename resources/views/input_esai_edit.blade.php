@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Edit Pertanyaan Esai</h4>

    <form id="formEditPertanyaan" 
          action="{{ route('pertanyaan.esai.update', $pertanyaan->id_pertanyaan) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="id_skema" value="{{ $pertanyaan->id_skema }}">
        <input type="hidden" name="id_asesor" value="{{ $pertanyaan->id_asesor }}">

        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold">Pertanyaan</h6>

                {{-- File lama --}}
                @if($pertanyaan->file_path)
                    <p><strong>Lampiran sebelumnya:</strong>
                        <a href="{{ asset('storage/'.$pertanyaan->file_path) }}" target="_blank">Lihat File</a>
                    </p>
                    @if(in_array($pertanyaan->file_type, ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/'.$pertanyaan->file_path) }}" 
                             class="img-fluid mb-2" style="max-width:200px;">
                    @endif
                @endif

                {{-- Upload file baru --}}
                <div class="mb-3">
                    <label class="form-label">Ganti File (opsional)</label>
                    <input type="file" name="file" class="form-control"
                           accept=".jpg,.jpeg,.png,.pdf,.docx,.mp3,.mp4">
                    <small class="text-muted">Kosongkan jika tidak ingin ganti file</small>
                </div>

                {{-- Isi pertanyaan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Isi Pertanyaan <span class="text-danger">*</span></label>
                    <textarea name="isi_pertanyaan" class="form-control" rows="4" required>{{ old('isi_pertanyaan', $pertanyaan->isi_pertanyaan) }}</textarea>
                </div>

                {{-- Kunci jawaban --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kunci Jawaban</label>
                    <input type="text" name="kunci_jawaban" class="form-control"
                           value="{{ old('kunci_jawaban', $pertanyaan->kunci_jawaban) }}"
                           placeholder="Kunci jawaban">
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success" onclick="konfirmasiEdit()">
                <i class="fa fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
function konfirmasiEdit() {
    if (confirm("Apakah anda sudah yakin ingin menyimpan perubahan?")) {
        document.getElementById('formEditPertanyaan').submit();
    }
}
</script>
@endsection