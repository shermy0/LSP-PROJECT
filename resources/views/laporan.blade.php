@extends('master')

@section('konten')
    <div class="card mapa-card">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.index') }}">Daftar Skema</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.VA.K</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.AK.05 – LAPORAN ASESMEN</h3>
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

            <!-- Nama Asesor -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="namaAsesor" class="form-label">Nama Asesor</label>
                    <select class="form-control" id="namaAsesor" name="asesor_id">
                        <option value="">-- Pilih Asesor --</option>
                    </select>
                </div>
            </div>

            <!-- Tanggal Asesmen -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="tanggalAsesmen" class="form-label">Tanggal Asesmen</label>
                    <input type="date" class="form-control" id="tanggalAsesmen">
                </div>
            </div>
        </div>

        <!-- TUK -->
        <div class="col-12 text-center">
            <label class="form-label fw-semibold d-block mb-2">TUK (Tempat Uji Kompetensi) SMKN 11 Bandung:</label>
            <div class="d-flex justify-content-center gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tuk" id="tukSewaktu" value="Sewaktu">
                    <label class="form-check-label" for="tukSewaktu">Sewaktu</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tuk" id="tukTempatKerja" value="Tempat Kerja">
                    <label class="form-check-label" for="tukTempatKerja">Tempat Kerja</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tuk" id="tukMandiri" value="Mandiri">
                    <label class="form-check-label" for="tukMandiri">Mandiri</label>
                </div>
            </div>
        </div>
        <br>
    </form>
</div>

<!-- Data Asesi -->
<div class="card-box">
    <div class="judul-box">
        <div class="judul-header">Data Asesi</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table text-center align-middle">
                <thead class="table-title">
                    <tr>
                        <th rowspan="2" class="text-center align-middle">No</th>
                        <th rowspan="2" class="text-center align-middle">Nama Asesi</th>
                        <th colspan="2" class="text-center">Rekomendasi</th>
                        <th rowspan="2" class="text-center align-middle">Keterangan</th>
                    </tr>
                    <tr>
                        <th class="text-center">K</th>
                        <th class="text-center">BK</th>
                    </tr>
                </thead>
                <tbody id="asesiTableBody">
                    <tr>
                        <td colspan="5">Silakan pilih skema dan asesor terlebih dahulu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="simpan-lanjut-form" action="{{ route('laporan_asesor') }}" method="POST" class="simpan-form">
    @csrf
    <input type="hidden" name="asesor_id" id="asesor_id_hidden" value="{{ $asesor->id ?? '' }}">
    <input type="hidden" name="skema_id" id="skema_id_hidden" value="{{ $skema->id ?? '' }}">
    <input type="hidden" name="no_registrasi" id="no_registrasi_hidden" value="{{ $no_registrasi ?? '' }}">

    <div class="box">
        <div class="box-header">Aspek Negatif dan Positif dalam Asesmen</div>
        <textarea name="aspek_positif_negatif" class="box-input" rows="3"></textarea>
    </div>

    <div class="box">
        <div class="box-header">Pencatatan Penolakan Hasil Asesmen</div>
        <textarea name="penolakan" class="box-input" rows="3"></textarea>
    </div>

    <div class="box">
        <div class="box-header">Saran Perbaikan : (Asesor/Personil Terkait)</div>
        <textarea name="saran_perbaikan" class="box-input" rows="3"></textarea>
    </div>

    <button type="submit" class="simpan-btn">
        <span>Simpan dan Lanjut</span>
    </button>
</form>


<script>
    // Saat ganti skema
    document.getElementById('skema_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        let kode = selected.getAttribute('data-kode');
        let jenjang = selected.getAttribute('data-jenjang');

        // isi nomor otomatis
        document.getElementById('nomor').value = kode || '';

        // pilih radio otomatis
        if (jenjang) {
            if (jenjang.toLowerCase().includes("kkni")) {
                document.getElementById('skema1').checked = true;
            } else if (jenjang.toLowerCase().includes("okupasi")) {
                document.getElementById('skema2').checked = true;
            }
        }

        // ambil asesor sesuai skema via AJAX
        let skemaId = this.value;
        if (skemaId) {
            fetch(`/get-asesor/${skemaId}`)
                .then(res => res.json())
                .then(data => {
                    let select = document.getElementById('namaAsesor');
                    select.innerHTML = '<option value="">-- Pilih Asesor --</option>';
                    data.forEach(a => {
                        let opt = document.createElement('option');
                        opt.value = a.id_asesor;
                        opt.textContent = a.nama_asesor;
                        opt.setAttribute('data-noreg', a.no_registrasi);
                        select.appendChild(opt);
                    });
                });
        }
    });
</script>
<script>
    // saat pilih Asesor
    document.getElementById('namaAsesor').addEventListener('change', function() {
        let asesorId = this.value;
        let noreg = this.options[this.selectedIndex].getAttribute('data-noreg');
        let skemaId = document.getElementById('skema_id').value;

        // isi hidden input biar kebawa ke laporan_asesor
        document.getElementById('asesor_id_hidden').value = asesorId;
        document.getElementById('skema_id_hidden').value = skemaId;
        document.getElementById('no_registrasi_hidden').value = noreg; // <--- penting
    });
</script>
<script>
    // Saat ganti asesor, ambil asesi
    document.getElementById('namaAsesor').addEventListener('change', function() {
        let asesorId = this.value;
        let skemaId = document.getElementById('skema_id').value;

        if (skemaId && asesorId) {
            fetch(`/get-asesi/${skemaId}/${asesorId}`)
                .then(res => res.json())
                .then(data => {
                    let tbody = document.getElementById("asesiTableBody");
                    tbody.innerHTML = ""; // kosongkan isi lama

                    if (data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="5">Tidak ada Asesi</td></tr>`;
                        return;
                    }

                    data.forEach((asesi, index) => {
                        let tr = document.createElement("tr");
                        tr.innerHTML = `
                            <td>${index+1}</td>
                            <td>
                                <input type="text" 
                                       name="nama[${index+1}]" 
                                       class="form-control" 
                                       value="${asesi.nama_lengkap}" readonly>
                            </td>
                            <td>
                                <input type="radio" name="rekomendasi[${index+1}][]" value="K">
                            </td>
                            <td>
                                <input type="radio" name="rekomendasi[${index+1}][]" value="BK">
                            </td>
                            <td>
                                <select name="keterangan[${index+1}]" class="form-control unit-select">
                                    <option value="">-- Pilih Kode & Judul Unit --</option>
                                </select>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                });
        }
    });
</script>
<script>
const skemaData = @json($skemas);

function populateUnitSelects(skemaId) {
    let selectedSkema = skemaData.find(s => s.id_skema == skemaId);
    let options = '<option value="">-- Pilih Kode & Judul Unit --</option>';

    if (selectedSkema && selectedSkema.units && selectedSkema.units.length > 0) {
        selectedSkema.units.forEach(unit => {
            options += `<option value="${unit.kode_unit}">
                           ${unit.kode_unit} - ${unit.judul_unit}
                        </option>`;
        });
    } else {
        options += `<option value="">Tidak ada unit kompetensi</option>`;
    }

    document.querySelectorAll('.unit-select').forEach(select => {
        select.innerHTML = options;
    });
}

// Saat pilih Asesor → tampilkan asesi + isi unit kompetensi
document.getElementById('namaAsesor').addEventListener('change', function() {
    let asesorId = this.value;
    let skemaId = document.getElementById('skema_id').value;

    if (skemaId && asesorId) {
        fetch(`/get-asesi/${skemaId}/${asesorId}`)
            .then(res => res.json())
            .then(data => {
                let tbody = document.getElementById("asesiTableBody");
                tbody.innerHTML = "";

                if (data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="5">Tidak ada Asesi</td></tr>`;
                    return;
                }

                data.forEach((asesi, index) => {
                    let tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${index+1}</td>
                        <td>
                            <input type="text" 
                                   name="nama[${index+1}]" 
                                   class="form-control" 
                                   value="${asesi.nama_lengkap}" readonly>
                        </td>
                        <td><input type="radio" name="rekomendasi[${index+1}][]" value="K"></td>
                        <td><input type="radio" name="rekomendasi[${index+1}][]" value="BK"></td>
                        <td>
                            <select name="keterangan[${index+1}]" class="form-control unit-select">
                                <option value="">-- Pilih Kode & Judul Unit --</option>
                            </select>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });

                // setelah table asesi dibuat, isi dropdown unit sesuai skema
                populateUnitSelects(skemaId);
            });
    }
});
</script>
@endsection
