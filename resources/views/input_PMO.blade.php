@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold text-dark mb-3">Input Pertanyaan PMO</h4>

    <form action="{{ route('pmo.pertanyaan.pmo.store', $id_pmo) }}" method="POST">
        @csrf

        <!-- Pilih Unit Kompetensi -->
        <div class="mb-3">
            <label for="unit" class="form-label fw-bold">Pilih Unit Kompetensi (kategori)</label>
            <select name="unit_ids[]" id="unit" class="form-select" multiple required>
                @foreach($unitList as $unit)
                    <option value="{{ $unit->id_unit }}">
                        {{ $unit->kode_unit }} – {{ $unit->nama_unit }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Kamu bisa memilih lebih dari satu unit.</small>
        </div>

        <!-- Soal / Pertanyaan -->
        <div class="mb-3">
            <label for="pertanyaan" class="form-label fw-bold">Pertanyaan</label>
            <textarea name="pertanyaan" id="pertanyaan" class="form-control" rows="3" required></textarea>
        </div>

        <!-- Kunci Jawaban -->
        <div class="mb-3">
            <label for="kunci_jawaban" class="form-label fw-bold">Kunci Jawaban</label>
            <textarea name="kunci_jawaban" id="kunci_jawaban" class="form-control" rows="2" required></textarea>
        </div>

        <!-- Tombol Simpan -->
        <div class="text-end mt-4">
            <button type="submit" class="btn text-white px-4 py-2" style="background-color:#041562;">
                Simpan Pertanyaan
            </button>
        </div>
    </form>
</div>
@endsection
