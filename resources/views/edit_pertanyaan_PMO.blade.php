@extends('master')

@section('konten')
<div class="container mt-4">

    <div class="mb-4">
        <h4 class="fw-bold" style="color:#041562;">Edit Pertanyaan PMO</h4>
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

    <form action="{{ route('pmo.pertanyaan.update', $pertanyaan->id_pmo_pertanyaan) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Unit Kompetensi (multi-select, kirim sebagai array) --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Unit Kompetensi</label>
            @php
                // id_unit disimpan sebagai JSON string, decode dulu
                $selectedUnits = [];
                if (!empty($pertanyaan->id_unit)) {
                    $decoded = json_decode($pertanyaan->id_unit, true);
                    $selectedUnits = is_array($decoded) ? $decoded : [$decoded];
                }
            @endphp
            <div class="border rounded-3 p-3" style="max-height:220px; overflow-y:auto; background:#fafafa;">
                @foreach($unitList as $unit)
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox"
                               name="id_unit[]"
                               value="{{ $unit->id_unit }}"
                               id="unit_{{ $unit->id_unit }}"
                               {{ in_array($unit->id_unit, array_map('strval', $selectedUnits)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="unit_{{ $unit->id_unit }}">
                            <span class="badge me-1" style="background-color:#041562; font-size:0.75rem;">
                                {{ $unit->kode_unit }}
                            </span>
                            {{ $unit->judul_unit }}
                        </label>
                    </div>
                @endforeach
            </div>
            <small class="text-muted">Boleh pilih lebih dari satu unit.</small>
        </div>

        {{-- Pertanyaan --}}
        <div class="mb-3">
            <label for="pertanyaan" class="form-label fw-semibold">Pertanyaan</label>
            <textarea name="pertanyaan" id="pertanyaan" rows="3"
                      class="form-control @error('pertanyaan') is-invalid @enderror"
                      required>{{ old('pertanyaan', $pertanyaan->pertanyaan) }}</textarea>
            @error('pertanyaan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label for="deskripsi_pertanyaan" class="form-label fw-semibold">
                Deskripsi <span class="text-muted fw-normal">(opsional)</span>
            </label>
            <textarea name="deskripsi_pertanyaan" id="deskripsi_pertanyaan" rows="2"
                      class="form-control">{{ old('deskripsi_pertanyaan', $pertanyaan->deskripsi_pertanyaan) }}</textarea>
        </div>

        {{-- Hidden id_pmo --}}
        <input type="hidden" name="id_pmo" value="{{ $pmo->id_pmo }}">

        <div class="d-flex gap-2">
            <button type="submit" class="btn text-white fw-bold px-4"
                    style="background-color:#041562;">
                <i class="bi bi-save me-1"></i> Update
            </button>
            <a href="{{ route('pmo.crud', $pmo->id_pmo) }}"
               class="btn btn-secondary fw-bold px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection