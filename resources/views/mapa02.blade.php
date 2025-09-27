@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">
    <div class="card mapa-card">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.index') }}">Daftar Skema</a>
            </li>
            @if(isset($skema))
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.MAPA.02</li>
            @endif
        </ol>
    </nav>

    <div class="container mt-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <div class="mapa-logo"></div>
            <h3 class="fw-bold">FR.MAPA.02 – PETA INSTRUMEN ASESSMEN</h3>
            <p class="text-muted">Peninjauan Proses Asesmen</p>
        </div>

        @if(isset($skema))
        <!-- Skema Info -->
        <div class="skema-container mb-4">
            <div class="skema-group">
                <span class="skema-label">SKEMA:</span>
                <span class="skema-select">{{ $skema->nama_skema }}</span>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="mapa-box">
                    <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
                    <div class="jenis-skema">
                        <input type="radio" id="kkni" name="skema" class="form-check-input me-2"
                               value="KKNI" @if($skema->jenjang == 'KKNI') checked @endif disabled>
                        <label for="kkni">KKNI</label>

                        <input type="radio" id="okupasi" name="skema" class="form-check-input me-2"
                               value="Okupasi" @if($skema->jenjang == 'Okupasi') checked @endif disabled>
                        <label for="okupasi">Okupasi</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mapa-box">
                    <label class="fw-semibold d-block mb-2">Nomor Skema</label>
                    <input type="text" class="form-control" value="{{ $skema->kode_skema }}" readonly>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Kelompok Pekerjaan (AJAX dinamis) -->
<div id="kelompok-container"></div>

<!-- Instrumen Asesmen -->
<form action="{{ route('mapa02.simpanInstrumen') }}" method="POST">
    @csrf
    <div class="card-box mt-4">
        <div class="judul-header">Instrumen Asesmen</div>
        <div class="table-responsive mt-3">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th rowspan="2" class="text-center align-middle">No</th>
                        <th rowspan="2" class="text-center align-middle">Instrumen Asesi</th>
                        <th colspan="5" class="text-center">Potensi Asesi</th>
                    </tr>
                    <tr>
                        @for($p=1; $p<=5; $p++)
                        <th class="text-center">{{ $p }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @forelse($instrumen as $i => $item)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>
                        <td>
                            <strong>{{ $item->kode_instrumen ?? '-' }}</strong>
                            - {{ $item->nama_instrumen ?? 'Nama instrumen belum ada' }}
                        </td>
                        @for($j=1; $j<=5; $j++)
                        <td class="text-center">
                            <input type="radio" name="potensi[{{ $item->id_instrumen }}]" value="{{ $j }}">
                        </td>
                        @endfor
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada instrumen untuk skema ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<!-- Penjelasan -->
<div class="card-box mt-4">
    <div class="judul-header">Penjelasan</div>
    <ol class="judul-list">
        <li>Hasil pelatihan dan/atau pendidikan yang telusur terhadap standar kompetensi.</li>
        <li>Kurikulum belum berbasis kompetensi.</li>
        <li>Pekerja berpengalaman yang sesuai standar kompetensi.</li>
        <li>Pekerja berpengalaman yang belum berbasis kompetensi.</li>
        <li>Pelatihan / belajar mandiri atau otodidak.</li>
    </ol>
</div>

<!-- Simpan dan Lanjut -->
<form id="simpan-lanjut-form" action="#" method="POST" class="mt-3">
    @csrf
    <button type="submit" class="btn btn-success">
        Simpan dan Lanjut
    </button>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const skemaId = {{ $skema->id_skema ?? 'null' }};
    if (!skemaId) return;

    // Ambil kelompok pekerjaan (AJAX)
    fetch(`/mapa02/skema/${skemaId}/units`)
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('kelompok-container');
            container.innerHTML = '';
            if (data.length) {
                let html = `
                    <div class="card-box mt-4">
                        <div class="judul-header">Unit Kompetensi</div>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered custom-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Kode Unit</th>
                                        <th class="text-center">Judul Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                `;
                data.forEach((unit, i) => {
                    html += `
                        <tr>
                            <td class="text-center">${i+1}</td>
                            <td>${unit.kode_unit}</td>
                            <td>${unit.judul_unit}</td>
                        </tr>`;
                });
                html += `</tbody></table></div></div>`;
                container.innerHTML = html;
            } else {
                container.innerHTML = `<div class="card-box mt-4"><div class="judul-header">Belum ada unit kompetensi</div></div>`;
            }
        });
});
</script>
@endsection
