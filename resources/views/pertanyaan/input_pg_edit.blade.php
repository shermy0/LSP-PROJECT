@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Edit Pertanyaan Pilihan Ganda</h4>

    <form action="{{ route('pertanyaan.pg.update', $pertanyaan->id_pertanyaan) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          id="formPGEdit">
        @csrf
        @method('PUT')

        <input type="hidden" name="id_skema" value="{{ $pertanyaan->id_skema }}">
        <input type="hidden" name="id_kelompok" value="{{ $pertanyaan->id_kelompok }}">

        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="fw-bold mb-0">Edit Pertanyaan</h5>
            </div>
            <div class="card-body">
                <!-- Isi Pertanyaan -->
                <div class="mb-3">
                    <label class="form-label">Isi Pertanyaan</label>
                    <textarea name="isi_pertanyaan" class="form-control" rows="3" required>{{ old('isi_pertanyaan', $pertanyaan->isi_pertanyaan) }}</textarea>
                </div>

                <!-- File Pendukung -->
                <div class="mb-3">
                    <label class="form-label">File Pendukung Pertanyaan (opsional)</label>
                    @if($pertanyaan->file_path)
                        <div class="mb-2">
                            <strong>File saat ini:</strong>
                            <a href="{{ asset('storage/' . $pertanyaan->file_path) }}" target="_blank" class="ms-2">Lihat File</a>
                            <br>
                            <small class="text-muted">
                                <input type="checkbox" name="hapus_file" id="hapus_file">
                                <label for="hapus_file">Hapus file saat ini</label>
                            </small>
                        </div>
                    @endif
                    <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.docx,.mp3,.mp4">
                </div>

                <!-- Opsi Jawaban -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Opsi Jawaban</label>
                    @foreach (['A','B','C','D','E'] as $j => $kode)
                        @php
                            $opsi = $pertanyaan->opsiJawaban->where('kode_opsi', $kode)->first();
                            $jenis = $opsi ? (str_contains($opsi->isi_opsi, 'uploads/opsi_jawaban') ? 'gambar' : 'text') : 'text';
                            $nilai = $opsi ? $opsi->isi_opsi : '';
                            $isBenar = $opsi ? $opsi->benar : false;
                        @endphp

                        <div class="opsi-item mb-3 p-3 border rounded">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <span class="badge bg-primary fs-6">Opsi {{ $kode }}</span>
                                    @if($isBenar)
                                        <span class="badge bg-success ms-1">Kunci</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <select name="jenis_opsi[{{ $j }}]" class="form-select jenis-opsi" data-opsi="{{ $j }}">
                                        <option value="text" {{ $jenis == 'text' ? 'selected' : '' }}>Teks</option>
                                        <option value="gambar" {{ $jenis == 'gambar' ? 'selected' : '' }}>Gambar</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <div class="opsi-text {{ $jenis == 'gambar' ? 'd-none' : '' }}">
                                        <input type="text" name="opsi_text[{{ $j }}]" class="form-control" 
                                               value="{{ $jenis == 'text' ? $nilai : '' }}"
                                               placeholder="Isi teks untuk opsi {{ $kode }}">
                                    </div>
                                    <div class="opsi-gambar {{ $jenis == 'text' ? 'd-none' : '' }}">
                                        <input type="file" name="opsi_gambar[{{ $j }}]" 
                                               class="form-control opsi-gambar-input" 
                                               accept=".jpg,.jpeg,.png" data-opsi="{{ $j }}">
                                        @if($jenis == 'gambar' && $nilai)
                                            <input type="hidden" name="opsi_gambar_lama[{{ $j }}]" value="{{ $nilai }}">
                                            <div class="image-preview mt-2">
                                                <p class="mb-1"><small>Gambar saat ini:</small></p>
                                                <img src="{{ asset('storage/' . $nilai) }}" class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                        @else
                                            <div class="image-preview mt-2 d-none">
                                                <img src="" class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Kunci Jawaban -->
                <div class="mb-3">
                    <label class="form-label">Kunci Jawaban</label>
                    <select name="kunci_jawaban" class="form-select" required>
                        <option value="">-- Pilih Kunci Jawaban --</option>
                        @foreach (['A','B','C','D','E'] as $kode)
                            @php
                                $opsi = $pertanyaan->opsiJawaban->where('kode_opsi', $kode)->first();
                                $isSelected = ($pertanyaan->kunci_jawaban == $kode);
                            @endphp
                            <option value="{{ $kode }}" {{ $isSelected ? 'selected' : '' }}>
                                {{ $kode }} @if($opsi && $isSelected) - {{ str_contains($opsi->isi_opsi,'uploads/opsi_jawaban') ? '[Gambar]' : $opsi->isi_opsi }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Update Pertanyaan</button>
            <a href="{{ route('pg.crud', ['id_skema' => $pertanyaan->id_skema, 'id_kelompok' => $pertanyaan->id_kelompok]) }}" 
               class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<style>
.opsi-item { background-color: #f8f9fa; transition: all 0.3s ease; }
.opsi-item:hover { background-color: #e9ecef; }
.image-preview img { max-width: 100%; height: auto; }
.badge.bg-success { font-size: 0.7em; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function toggleJenisOpsi(selectElement) {
        const opsiItem = selectElement.closest('.opsi-item');
        const jenis = selectElement.value;
        const opsiText = opsiItem.querySelector('.opsi-text');
        const opsiGambar = opsiItem.querySelector('.opsi-gambar');

        if (jenis === 'text') {
            opsiText.classList.remove('d-none');
            opsiGambar.classList.add('d-none');
        } else {
            opsiText.classList.add('d-none');
            opsiGambar.classList.remove('d-none');
        }
    }

    document.querySelectorAll('.jenis-opsi').forEach(select => {
        toggleJenisOpsi(select);
        select.addEventListener('change', function() { toggleJenisOpsi(this); });
    });

    document.querySelectorAll('.opsi-gambar-input').forEach(input => {
        input.addEventListener('change', function() {
            const preview = input.closest('.opsi-gambar').querySelector('.image-preview');
            const img = preview.querySelector('img');
            const hiddenInput = input.closest('.opsi-gambar').querySelector('input[type="hidden"]');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('d-none');
                    if(hiddenInput) hiddenInput.value = ''; // reset opsi lama jika diganti
                }
                reader.readAsDataURL(input.files[0]);
            } else if(hiddenInput?.value){
                img.src = "{{ asset('storage/') }}/" + hiddenInput.value;
                preview.classList.remove('d-none');
            } else {
                img.src = '';
                preview.classList.add('d-none');
            }
        });
    });
});
</script>
@endsection
