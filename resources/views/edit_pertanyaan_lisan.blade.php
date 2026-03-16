@extends('master')

@section('konten')
<div class="container mt-4">

    <div class="mb-4">
        <h4 class="fw-bold" style="color:#041562;">Edit Pertanyaan Lisan</h4>
        <p class="text-muted mb-0">Perbarui data pertanyaan di bawah ini.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('lisan.update', $pertanyaan->id_pertanyaan) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="id_skema" value="{{ $pertanyaan->id_skema }}">

        {{-- Isi Pertanyaan --}}
        <div class="mb-3">
            <label for="isi_pertanyaan" class="form-label fw-semibold">Isi Pertanyaan</label>
            <textarea name="isi_pertanyaan" id="isi_pertanyaan" rows="4"
                      class="form-control @error('isi_pertanyaan') is-invalid @enderror"
                      required>{{ old('isi_pertanyaan', $pertanyaan->isi_pertanyaan) }}</textarea>
            @error('isi_pertanyaan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kunci Jawaban --}}
        <div class="mb-4">
            <label for="kunci_jawaban" class="form-label fw-semibold">
                Kunci Jawaban <span class="text-muted fw-normal">(opsional)</span>
            </label>
            <textarea name="kunci_jawaban" id="kunci_jawaban" rows="3"
                      class="form-control">{{ old('kunci_jawaban', $pertanyaan->kunci_jawaban) }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn text-white fw-bold px-4"
                    style="background-color:#041562;">
                <i class="bi bi-save me-1"></i> Update
            </button>
            <a href="{{ route('lisan.crud', $pertanyaan->id_skema) }}"
               class="btn btn-secondary fw-bold px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection