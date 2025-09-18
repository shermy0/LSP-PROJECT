@extends('master')
@section('konten')

<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">

<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01') }}">FR.MAPA.01</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01.kodeunit', $skema->id_skema) }}">Rencana Asesmen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Unit</li>
        </ol>
    </nav>
</div>
<div class="container">

    <div class="card p-3">
        <h6 class="judul-header">Kelompok Pekerjaan 1</h6>

<form id="formUnit" action="{{ route('form.mapa01.simpanunit', [$skema->id_skema, $kelompok_id]) }}" method="POST">
    @csrf
        <div class="row mb-3">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="">Kode Unit</label>
                    <select id="kode_unit" name="kode_unit" class="form-control">
                        <option value="">-- Pilih Kode Unit --</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id_unit }}" data-judul="{{ $unit->judul_unit }}">
                                {{ $unit->kode_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Judul Unit</label>
                    <select id="judul_unit" name="judul_unit" class="form-control">
                        <option value="">-- Pilih Judul Unit --</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id_unit }}" data-kode="{{ $unit->kode_unit }}">
                                {{ $unit->judul_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Bukti-Bukti</label>
                <textarea class="form-control" name="bukti" id="bukti"></textarea>
            </div>

{{-- Jenis Bukti --}}
<div class="mb-3">
    <label>Jenis Bukti</label><br>
    @foreach ($jenisBukti as $bukti)
        <label>
            <input type="checkbox" class="form-check-input me-2" name="jenis_bukti[]" value="{{ $bukti->id_jenis_bukti }}">
            {{ $bukti->nama_bukti }}
        </label><br>
    @endforeach
</div>

{{-- Metode & Perangkat Asesmen --}}
<div class="mb-3">
    <label>Metode dan Perangkat Asesmen</label><br>
@foreach ($perangkat as $p)
    <label>
        <input type="checkbox" class="form-check-input me-2" name="metode[]" value="{{ $p->id_perangkat }}">
        {{ $p->jenisBukti->nama_bukti ?? '' }} ({{ $p->catatan_penerapan }})
    </label><br>
@endforeach

</div>

    </div>
    
</div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('form.mapa01.kodeunit', $skema->id_skema) }}" class="btn btn-secondary">Kembali</a>
                <button class="btn btn-primary" type="submit">Simpan Unit</button>
            </div>
        </form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const kodeUnitSelect = document.getElementById('kode_unit');
    const judulUnitSelect = document.getElementById('judul_unit');

    // sinkronisasi dropdown
    kodeUnitSelect.addEventListener('change', function() {
        const selectedId = this.value;
        judulUnitSelect.value = selectedId;
    });
    judulUnitSelect.addEventListener('change', function() {
        const selectedId = this.value;
        kodeUnitSelect.value = selectedId;
    });

    // VALIDASI FORM
    document.getElementById("formUnit").addEventListener("submit", function(e) {
        let kode = kodeUnitSelect.value.trim();
        let judul = judulUnitSelect.value.trim();
        let bukti = document.getElementById("bukti").value.trim();
        let jenisBukti = document.querySelectorAll('input[name="jenis_bukti[]"]:checked');
        let metode = document.querySelectorAll('input[name="metode[]"]:checked');

        if(kode === "" || judul === "" || bukti === "" || jenisBukti.length === 0 || metode.length === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Form belum lengkap!',
                text: 'Pastikan semua field wajib diisi dan checkbox dipilih minimal satu.',
                confirmButtonText: 'OK'
            });
        }
    });
</script>

@endsection
