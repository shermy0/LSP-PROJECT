@extends('master')

@section('konten')
<div class="container mt-4">
    <h4>Edit Pertanyaan PMO</h4>

    <form action="{{ route('pmo.pertanyaan.update', $pertanyaan->id_pmo_pertanyaan) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Pilih Unit --}}
        <div class="mb-3">
            <label for="id_unit" class="form-label">Unit</label>
            <select name="id_unit" id="id_unit" class="form-select" required>
                @foreach($unitList as $unit)
                    <option value="{{ $unit->id_unit }}" {{ $pertanyaan->id_unit == $unit->id_unit ? 'selected' : '' }}>
                        {{ $unit->kode_unit }} - {{ $unit->judul_unit }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Pertanyaan --}}
        <div class="mb-3">
            <label for="pertanyaan" class="form-label">Pertanyaan</label>
            <textarea name="pertanyaan" id="pertanyaan" rows="3" class="form-control" required>{{ $pertanyaan->pertanyaan }}</textarea>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="deskripsi_pertanyaan" class="form-label">Deskripsi (opsional)</label>
            <textarea name="deskripsi_pertanyaan" id="deskripsi_pertanyaan" rows="2" class="form-control">{{ $pertanyaan->deskripsi_pertanyaan }}</textarea>
        </div>

        {{-- Hidden untuk id_pmo --}}
        <input type="hidden" name="id_pmo" value="{{ $pmo->id_pmo }}">

        <button type="submit" class="btn btn-success">Update</button>
       <a href="{{ route('pmo.crud', $pmo->id_pmo) }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
