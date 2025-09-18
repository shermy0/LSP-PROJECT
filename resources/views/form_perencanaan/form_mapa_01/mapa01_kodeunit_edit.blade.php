@extends('master')
@section('konten')

<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">

<div class="card-box">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01') }}">FR.MAPA.01</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01.kodeunit', $skema->id_skema) }}">Rencana Asesmen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Unit</li>
        </ol>
    </nav>
</div>

<div class="container">
    <div class="card p-3">
        <h6 class="judul-header">Edit Kode Unit</h6>

        <form action="{{ route('form.mapa01.updateunit', [$skema->id_skema, $hasil->id_hasil]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Kode Unit</label>
                    <select id="kode_unit" name="kode_unit" class="form-control">
                        @foreach($units as $unit)
                            <option value="{{ $unit->id_unit }}" 
                                {{ $hasil->id_unit == $unit->id_unit ? 'selected' : '' }}>
                                {{ $unit->kode_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Judul Unit</label>
                    <select id="judul_unit" name="judul_unit" class="form-control">
                        @foreach($units as $unit)
                            <option value="{{ $unit->id_unit }}" 
                                {{ $hasil->id_unit == $unit->id_unit ? 'selected' : '' }}>
                                {{ $unit->judul_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Bukti-Bukti</label>
                <textarea class="form-control" name="bukti">{{ $hasil->catatan }}</textarea>
            </div>

            <div class="mb-3">
                <label>Jenis Bukti</label><br>
                @foreach ($jenisBukti as $bukti)
                    <label>
                        <input type="checkbox" class="form-check-input me-2" 
                               name="jenis_bukti[]" value="{{ $bukti->id_jenis_bukti }}"
                               {{ $hasil->bukti->pluck('id_jenis_bukti')->contains($bukti->id_jenis_bukti) ? 'checked' : '' }}>
                        {{ $bukti->nama_bukti }}
                    </label><br>
                @endforeach
            </div>

            <div class="mb-3">
                <label>Metode dan Perangkat Asesmen</label><br>
                @foreach ($perangkat as $p)
                    <label>
                        <input type="checkbox" class="form-check-input me-2" 
                               name="metode[]" value="{{ $p->id_perangkat }}"
                               {{ $hasil->perangkat->pluck('id_perangkat')->contains($p->id_perangkat) ? 'checked' : '' }}>
                        {{ $p->jenisBukti->nama_bukti ?? '' }} ({{ $p->catatan_penerapan }})
                    </label><br>
                @endforeach
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('form.mapa01.kodeunit', $skema->id_skema) }}" class="btn btn-secondary">Kembali</a>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    const kodeUnitSelect = document.getElementById('kode_unit');
    const judulUnitSelect = document.getElementById('judul_unit');

    kodeUnitSelect.addEventListener('change', function() {
        judulUnitSelect.value = this.value;
    });
    judulUnitSelect.addEventListener('change', function() {
        kodeUnitSelect.value = this.value;
    });
</script>

@endsection
