@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Input Pertanyaan Pilihan Ganda</h4>
    <p class="text-muted">Jumlah soal yang dipilih: {{ $jumlah }}</p>

    <form action="{{ route('pertanyaan.pg.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">
        <input type="hidden" name="id_kelompok" value="{{ $kelompok->id_kelompok }}">
        <input type="hidden" name="id_pembuatan_pertanyaan" value="{{ $id_pembuatan_pertanyaan }}">
        <input type="hidden" name="timer" value="{{ $timer }}">

        @for ($i = 0; $i < $jumlah; $i++)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold">Pertanyaan {{ $i + 1 }}</h5>

                    <div class="mb-3">
                        <label class="form-label">Isi Pertanyaan</label>
                        <textarea name="isi_pertanyaan[{{ $i }}]" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Pendukung (opsional)</label>
                        <input type="file" name="file[{{ $i }}]" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.docx,.mp3,.mp4">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Opsi Jawaban</label>
                        <div class="row">
                            @foreach (['A','B','C','D','E'] as $j => $kode)
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text">{{ $kode }}</span>
                                        <input type="text" name="opsi[{{ $i }}][]" class="form-control" placeholder="Isi opsi {{ $kode }}" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kunci Jawaban</label>
                        <select name="kunci_jawaban[{{ $i }}]" class="form-select" required>
                            <option value="">-- Pilih Kunci Jawaban --</option>
                            @foreach (['A','B','C','D','E'] as $kode)
                                <option value="{{ $kode }}">{{ $kode }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endfor

        <button type="submit" class="btn btn-primary">Simpan Semua Pertanyaan</button>
    </form>
</div>
@endsection
