@extends('master')
@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan') }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.MAPA.02</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">
            FR.MAPA.02 – PETA INSTRUMEN ASESSMEN HASIL PENDEKATAN ASESMEN DAN PERENCANAAN ASESMEN
        </h3>
    </div>

    <!-- Skema -->
    <div class="skema-container">
        <div class="skema-group">
            <span class="skema-label">SKEMA:</span>
            <select name="skema_id" id="skema_id" class="skema-select">
                <option value="">-- Pilih Skema --</option>
                @foreach($skemas as $skema)
                    <option value="{{ $skema->id_skema }}"
                            data-kode="{{ $skema->kode_skema }}"
                            data-jenjang="{{ $skema->jenjang }}">
                        {{ $skema->nama_skema }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Form -->
    <form>
        <div class="row g-3 mb-4">
            <!-- Skema Sertifikasi -->
            <div class="col-md-6">
                <div class="card-field">
                    <label class="form-label">Skema Sertifikasi</label>
                    <div class="d-flex gap-3 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="skema" id="skema1" value="KKNI">
                            <label class="form-check-label" for="skema1">KKNI</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="skema" id="skema2" value="Okupasi">
                            <label class="form-check-label" for="skema2">Okupasi</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nomor -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="nomor" class="form-label">Nomor</label>
                    <input type="text" class="form-control" id="nomor" placeholder="Nomor Skema" readonly>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Judul -->
<div class="card-box">
    <div class="judul-header">Kelompok Pekerjaan 1 </div>
    <div class="table-responsive mt-4">
        <table class="table table-bordered custom-table">
            <thead class="table-title">
                <tr>
                    <th rowspan="2" class="text-center align-middle">No</th>
                    <th rowspan="2" class="text-center align-middle">Kode Unit</th>
                    <th rowspan="2" class="text-center align-middle">Judul Unit</th>
                </tr>
            </thead>
            <tbody id="unit-kompetensi-body">
                <!-- Data unit akan muncul otomatis via JS -->
            </tbody>
        </table>
    </div>
</div>

<!-- Instrumen Asesmen -->
<form action="{{ route('instrumen.simpanPotensi') }}" method="POST">
    @csrf
    <div class="card-box">
        <div class="judul-header">Instrumen Asesmen</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th rowspan="2" class="text-center align-middle">No</th>
                        <th rowspan="2" class="text-center align-middle">Instrumen Asesi</th>
                        <th colspan="5" class="text-center">Potensi Asesi</th>
                    </tr>
                    <tr>
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instrumen as $i => $item)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>
                                <strong>{{ $item->kode_instrumen ?? '' }}</strong>
                                - {{ $item->nama_instrumen ?? 'Nama instrumen belum ada' }}
                                <br><small class="text-muted">({{ $item->jenis_instrumen ?? '-' }})</small>
                            </td>
                            @for($j=1; $j<=5; $j++)
                                <td class="text-center">
                                    <input type="radio" name="potensi[{{ $item->id_instrumen }}]" 
                                           value="{{ $j }}" 
                                           {{ $item->potensi_asesi == $j ? 'checked' : '' }}>
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
<div class="card-box">
    <div class="judul-box">
        <div class="judul-header">Penjelasan</div>
        <ol class="judul-list">
            <li>Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi.</li>
            <li>Hasil pelatihan dan / atau pendidikan, dimana kurikulum belum berbasis kompetensi.</li>
            <li>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi.</li>
            <li>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya belum berbasis kompetensi.</li>
            <li>Pelatihan / belajar mandiri atau otodidak</li>
        </ol>
    </div>
</div>

<!-- Simpan dan Lanjut -->
<form id="simpan-lanjut-form" action="{{ route('mapa02_asesor') }}" method="POST" class="simpan-form">
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan dan Lanjut</span>
    </button>
</form>

<script>
    document.getElementById('skema_id').addEventListener('change', function() {
    localStorage.setItem('selectedSkemaId', this.value);
        let selected = this.options[this.selectedIndex];
        let kode = selected.getAttribute('data-kode');
        let jenjang = selected.getAttribute('data-jenjang');

        // biar bisa isi nomor otomatis
        document.getElementById('nomor').value = kode || '';

        // pilih radio otomatis sesuai skemanya
        if (jenjang) {
            if (jenjang.toLowerCase().includes("kkni")) {
                document.getElementById('skema1').checked = true;
            } else if (jenjang.toLowerCase().includes("okupasi")) {
                document.getElementById('skema2').checked = true;
            }
        }
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const skemaId = {{ $skema->id_skema ?? 'null' }}; // pastikan $skema dikirim ke view
    if (skemaId) {
        fetch(`/mapa02/skema/${skemaId}/instrumen`)
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById("instrumen-body");
                tbody.innerHTML = "";
                data.forEach((instrumen, i) => {
                    let row = `<tr>
                        <td class="text-center">${i+1}</td>
                        <td>${instrumen.kode_instrumen} - ${instrumen.nama_instrumen}</td>`;
                    for (let j = 1; j <= 5; j++) {
                        row += `<td class="text-center">
                                    <input type="radio" name="potensi[${instrumen.id_instrumen}]" value="${j}">
                                </td>`;
                    }
                    row += `</tr>`;
                    tbody.innerHTML += row;
                });
            });
    }
});
</script>

<script>
const skemaData = @json($skemas);
const skemaId = {{ $skemaId ?? 'null' }};

document.getElementById('skema_id').addEventListener('change', function() {
    let selectedId = this.value;
    let tbody = document.getElementById('unit-kompetensi-body');
    tbody.innerHTML = '';

    if (selectedId) {
        let selectedSkema = skemaData.find(s => s.id_skema == selectedId);

        if (selectedSkema && selectedSkema.units.length > 0) {
            selectedSkema.units.forEach((unit, index) => {
                let row = `
                    <tr>
                        <td class="text-center">${index+1}</td>
                        <td>${unit.kode_unit}</td>
                        <td>${unit.judul_unit}</td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        } else {
            tbody.innerHTML = `<tr><td colspan="3" class="text-center">Tidak ada unit kompetensi</td></tr>`;
        }
    }
});
</script>
@endsection