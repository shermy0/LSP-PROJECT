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
<li class="breadcrumb-item">
    @isset($skema)
        <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
    @else
        <span>Form Perencanaan</span>
    @endisset
</li>
            <li class="breadcrumb-item active" aria-current="page">FR.MAPA.01</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.AK.05 – LAPORAN ASESMEN</h3>
    </div>

    <!-- skema -->
    <div class="skema-container">
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
                        value="KKNI"
                        @if($skema->jenjang == 'KKNI') checked @endif disabled>
                    <label for="kkni">KKNI</label>

                    <input type="radio" id="okupasi" name="skema" class="form-check-input me-2"
                        value="Okupasi"
                        @if($skema->jenjang == 'Okupasi') checked @endif disabled>
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

        <!-- Nama Asesor -->
        <div class="col-md-6">
            <div class="mapa-box">
                <label for="namaAsesor" class="form-label">Nama Asesor</label>
                <select class="form-control" id="namaAsesor" name="asesor_id">
                    <option value="">-- Pilih Asesor --</option>
                    @foreach($asesors as $asesor)
                        <option value="{{ $asesor->id_asesor }}" data-no="{{ $asesor->no_registrasi }}">
                            {{ $asesor->nama_asesor }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Tanggal Asesmen -->
        <div class="col-md-6">
            <div class="mapa-box">
                <label for="tanggalAsesmen" class="form-label">Tanggal Asesmen</label>
                <input type="date" class="form-control" id="tanggalAsesmen">
            </div>
        </div>
    </div>

    <!-- TUK -->
    <div class="col-12 text-center mt-3">
                    <div class="mapa-box">
        <label class="form-label fw-semibold d-block mb-2">TUK (Tempat Uji Kompetensi) SMKN 11 Bandung:</label>
        <div class="d-flex justify-content-center gap-4">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tuk" id="tukSewaktu" value="Sewaktu" disabled>
                <label class="form-check-label" for="tukSewaktu">Sewaktu</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tuk" id="tukTempatKerja" value="Tempat Kerja" disabled>
                <label class="form-check-label" for="tukTempatKerja">Tempat Kerja</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tuk" id="tukMandiri" value="Mandiri" checked>
                <label class="form-check-label" for="tukMandiri">Mandiri</label>
            </div>
        </div>
    </div>
    </div>
</div>

<form id="simpan-lanjut-form" action="{{ route('laporan_asesor.store') }}" method="POST" class="simpan-form mt-4">
    @csrf

<!-- Data Asesi -->
    <div class="card mapa-card">
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
                        <td colspan="5">Silakan pilih asesor terlebih dahulu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Catatan Asesmen -->
    <!-- hidden input supaya data ikut terkirim -->
    <input type="hidden" name="asesor_id" id="asesor_id_hidden">
    <input type="hidden" name="skema_id" id="skema_id_hidden" value="{{ $skema->id_skema }}">
    <input type="hidden" name="no_registrasi" id="no_registrasi_hidden">

    <div class="card mapa-card">
        <div class="judul-box">
            <div class="judul-header">Catatan Asesmen</div>

            <div class="box">
                <div class="box-header">Aspek Negatif dan Positif dalam Asesmen</div>
                <textarea name="aspek_positif_negatif" class="box-input" rows="3" placeholder="Masukkan teks"></textarea>
            </div>

            <div class="box">
                <div class="box-header">Pencatatan Penolakan Hasil Asesmen</div>
                <textarea name="penolakan" class="box-input" rows="3" placeholder="Masukkan teks"></textarea>
            </div>

            <div class="box">
                <div class="box-header">Saran Perbaikan : (Asesor/Personil Terkait)</div>
                <textarea name="saran_perbaikan" class="box-input" rows="3" placeholder="Masukkan teks"></textarea>
            </div>
        </div>
    </div>

    <button type="submit" class="simpan-btn mt-3">
        <span>Simpan dan Lanjut</span>
    </button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const asesorSelect   = document.getElementById('namaAsesor');
    const asesiTableBody = document.getElementById('asesiTableBody');
    const asesorIdHidden = document.getElementById('asesor_id_hidden');
    const noRegHidden    = document.getElementById('no_registrasi_hidden');

    asesorSelect.addEventListener('change', function () {
        const asesorId = this.value;
        const noReg    = this.selectedOptions[0]?.dataset.no ?? '';

        asesorIdHidden.value = asesorId;
        noRegHidden.value    = noReg;

        if (asesorId) {
            const url = `{{ url('form-perencanaan/laporan/'.$skema->id_skema.'/asesi') }}/${asesorId}`;
            
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    asesiTableBody.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach((asesi, index) => {
                            // bikin dropdown option dari unit_kompetensi
                            let unitOptions = '';
                            @foreach($skema->unitKompetensi as $unit)
                                unitOptions += `<option value="{{ $unit->id_unit }}">{{ $unit->kode_unit }} - {{ $unit->judul_unit }}</option>`;
                            @endforeach

                            asesiTableBody.innerHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${asesi.nama_lengkap}</td>
                                    <td>
                                        <input type="radio" name="rekomendasi_${asesi.id_asesi}" value="K"
                                            onchange="toggleKeterangan(${asesi.id_asesi}, false)">
                                    </td>
                                    <td>
                                        <input type="radio" name="rekomendasi_${asesi.id_asesi}" value="BK"
                                            onchange="toggleKeterangan(${asesi.id_asesi}, true)">
                                    </td>
                                    <td>
                                        <select name="keterangan_${asesi.id_asesi}" id="keterangan_${asesi.id_asesi}" class="form-control" disabled>
                                            <option value="">-- Pilih Unit --</option>
                                            ${unitOptions}
                                        </select>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        asesiTableBody.innerHTML = `
                            <tr><td colspan="5">Tidak ada asesi untuk asesor ini</td></tr>
                        `;
                    }
                })
                .catch(() => {
                    asesiTableBody.innerHTML = `
                        <tr><td colspan="5">Gagal memuat data asesi</td></tr>
                    `;
                });
        } else {
            asesiTableBody.innerHTML = `
                <tr><td colspan="5">Silakan pilih asesor terlebih dahulu</td></tr>
            `;
        }
    });
});

// fungsi untuk toggle keterangan
function toggleKeterangan(asesiId, enable) {
    const selectEl = document.getElementById(`keterangan_${asesiId}`);
    if (enable) {
        selectEl.disabled = false;
    } else {
        selectEl.value = '';
        selectEl.disabled = true;
    }
}
</script>
@endsection