@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">

        <div class="card mapa-card">
    <!-- Breadcrumb -->
         <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">FR.MAPA.01</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.MAPA 01. Merencanakan Aktivitas dan Proses</h3>
        <p class="text-muted">Peninjauan Proses Asesmen</p>
    </div>

<!-- Dropdown skema -->
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

<!-- Form input -->
<div class="row g-3">
    <div class="col-md-6">
        <div class="mapa-box">
            <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
            <div class="jenis-skema">
                <input type="radio" id="kkni" name="skema" class="form-check-input me-2">
                <label for="kkni">KKNI</label>
                <input type="radio" id="okupasi" name="skema" class="form-check-input me-2">
                <label for="okupasi">Okupasi</label>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mapa-box">
            <label for="nomorSkema" class="fw-semibold d-block mb-2">Nomor</label>
            <input type="text" id="nomorSkema" class="form-control" placeholder="Nomor Skema">
        </div>
    </div>
</div>

    <!-- Menentukan Pendekatan Asesmen -->
<div class="mapa-section">
    <div class="card mapa-card">
                <div class="judul-header">Menentukan Pendekatan Asesmen</div>

            <div class="mapa-subsection">
                <div class="mapa-subsection-header">Asesi</div>
                <div class="mapa-options">
                    <div>
                        <input type="checkbox" id="asesi1" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2">
                        <label for="asesi1">Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi</label>
                    </div>
                    <div>
                        <input type="checkbox" id="asesi2" name="asesi[]" value="Pelatihan dengan kurikulum belum berbasis kompetensi" class="form-check-input me-2">
                        <label for="asesi2">Hasil pelatihan dan / atau pendidikan, dimana kurikulum belum berbasis kompetensi</label>
                    </div>
                    <div>
                        <input type="checkbox" id="asesi3" name="asesi[]" value="Pekerja berpengalaman kompeten" class="form-check-input me-2">
                        <label for="asesi3">Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi</label>
                    </div>
                    <div>
                        <input type="checkbox" id="asesi4" name="asesi[]" value="Pekerja berpengalaman belum kompeten" class="form-check-input me-2">
                        <label for="asesi4">Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya belum berbasis kompetensi</label>
                    </div>
                    <div>
                        <input type="checkbox" id="asesi5" name="asesi[]" value="Belajar mandiri/otodidak" class="form-check-input me-2">
                        <label for="asesi5">Pelatihan / belajar mandiri atau otodidak.</label>
                    </div>
            </div>
        <!-- Tujuan Asesmen -->
<div class="mapa-section">
    <div class="mapa-subsection-header">Tujuan Asesmen</div>
    <div class="mapa-options" id="tujuan-asesmen-list">
        <div>
            <input type="checkbox" id="sertifikasi" name="tujuan[]" value="Sertifikasi" class="form-check-input me-2">
            <label for="sertifikasi">Sertifikasi</label>
        </div>
        <div>
            <input type="checkbox" id="pkt" name="tujuan[]" value="Pengakuan Kompetensi Terkini (PKT)" class="form-check-input me-2">
            <label for="pkt">Pengakuan Kompetensi Terkini (PKT)</label>
        </div>
        <div>
            <input type="checkbox" id="rpl" name="tujuan[]" value="Rekognisi Pembelajaran Lampau (RPL)" class="form-check-input me-2">
            <label for="rpl">Rekognisi Pembelajaran Lampau (RPL)</label>
        </div>
    </div>
    <button type="button" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#modalTambahTujuan">
        + Tambah opsi tujuan lainnya
    </button>
</div>

<!-- Modal Tambah Opsi -->
<div class="modal fade" id="modalTambahTujuan" tabindex="-1" aria-labelledby="modalTambahTujuanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalTambahTujuanLabel">Tambah Tujuan Asesmen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="tujuanBaru" class="form-label">Nama Tujuan Asesmen</label>
        <input type="text" id="tujuanBaru" class="form-control" placeholder="Contoh: Uji Kompetensi Khusus">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="simpanTujuan">Simpan</button>
      </div>
    </div>
  </div>
</div>


<div class="mapa-section">
    <div class="mapa-subsection-header">Konteks Asesmen</div>
        <div class="konteks-section">
    <!-- Lingkungan -->
    <div class="form-group">
        <label class="form-label">Lingkungan</label>
        <div class="mapa-options-konteks radio">
            <label> <input type="radio" id="aa" name="aa" class="form-check-input"> Tempat kerja nyata</label>
            <label> <input type="radio" id="dd" name="aa" class="form-check-input"> Tempat kerja simulasi</label>
        </div>
    </div>

    <!-- Peluang -->
    <div class="form-group radio">
        <label class="form-label">Peluang untuk mengumpulkan bukti dalam sejumlah situasi</label>
        <div class="mapa-options-konteks">
            <label><input type="radio" id="bb" name="bb" class="form-check-input">  Tersedia</label>
            <label><input type="radio" id="cc" name="bb" class="form-check-input"> Terbatas</label>
        </div>
    </div>

    <!-- Hubungan -->
    <div class="form-group">
        <label class="form-label">Hubungan antara standarkompetensi dan:</label>
        <div class="mapa-options-konteks">
            <label><input type="checkbox" id="asesi1" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Bukti untuk mendukung asesmen</label>
            <label><input type="checkbox" id="asesi1" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Aktivitas kerja di tempat kerja Asesi</label>
            <label><input type="checkbox" id="asesi1" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Kegiatan Pembelajaran</label>
        </div>
    </div>

    <!-- Pelaksana -->
    <div class="form-group">
        <label class="form-label">Siapa yang melakukan asesmen / RPL</label>
        <div class="mapa-options-konteks">
            <label><input type="checkbox" id="asesi1" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Lembaga Sertifikasi</label>
            <label><input type="checkbox" id="asesi1" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Organisasi Pelatihan</label>
            <label><input type="checkbox" id="asesi1" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Asesor Perusahaan</label>
        </div>
    </div>
</div>
</div>

                <div class="mapa-subsection-header">Konfirmasi dengan Orang Lain yang Relevan</div>
                <div class="mapa-options">
                    <div>
                        <input type="checkbox" id="asesi1" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2">
                        <label for="asesi1">Manajer sertifikasi LSP P1 SMKN 11 Bandungi</label>
                    </div>
                    <div>
                        <input type="checkbox" id="asesi2" name="asesi[]" value="Pelatihan dengan kurikulum belum berbasis kompetensi" class="form-check-input me-2">
                        <label for="asesi2">Master Asesor / Master Trainer / Lead Asesor Kompetensi</label>
                    </div>
                    <div>
                        <input type="checkbox" id="asesi3" name="asesi[]" value="Pekerja berpengalaman kompeten" class="form-check-input me-2">
                        <label for="asesi3">Manajer Pelatihan Lembaga Training terakreditasi / Lembaga Training Terdaftar</label>
                    </div>
                    <div>
                        <input type="checkbox" id="asesi4" name="asesi[]" value="Pekerja berpengalaman belum kompeten" class="form-check-input me-2">
                        <label for="asesi4">Manajer atau supervisor ditempat kerja</label>
                    </div>
            </div>

            
<div class="mapa-subsection-header">Standar Industri atau Tempat Kerja</div>
<div class="mapa-options">
    {{-- Standar Kompetensi --}}
    <div>
        <input type="checkbox" id="asesi1" name="asesi[]" 
               value="Standar Kompetensi" class="form-check-input me-2 toggle-input"
               data-target="input-asesi1">
        <label for="asesi1">Standar Kompetensi:</label>
        <input type="text" id="input-asesi1" name="standar_kompetensi" 
               class="form-control mt-2" placeholder="Isi standar kompetensi"
               disabled style="display:none;">
    </div>

    {{-- Kriteria asesmen dari kurikulum pelatihan --}}
    <div>
        <input type="checkbox" id="asesi2" name="asesi[]" 
               value="Kriteria asesmen" class="form-check-input me-2">
        <label for="asesi2">Kriteria asesmen dari kurikulum pelatihan</label>
    </div>

    {{-- Spesifikasi Kinerja Perusahaan --}}
    <div>
        <input type="checkbox" id="asesi3" name="asesi[]" 
               value="Spesifikasi Kinerja" class="form-check-input me-2">
        <label for="asesi3">Spesifikasi kinerja suatu perusahaan atau industri</label>
    </div>

    {{-- Spesifikasi Produk --}}
    <div>
        <input type="checkbox" id="asesi4" name="asesi[]" 
               value="Spesifikasi Produk" class="form-check-input me-2 toggle-input"
               data-target="input-asesi4">
        <label for="asesi4">Spesifikasi Produk:</label>
        <input type="text" id="input-asesi4" name="spesifikasi_produk" 
               class="form-control mt-2" placeholder="Isi spesifikasi produk"
               disabled style="display:none;">
    </div>

    {{-- Pedoman Khusus --}}
    <div>
        <input type="checkbox" id="asesi5" name="asesi[]" 
               value="Pedoman Khusus" class="form-check-input me-2 toggle-input"
               data-target="input-asesi5">
        <label for="asesi5">Pedoman Khusus:</label>
        <input type="text" id="input-asesi5" name="pedoman_khusus" 
               class="form-control mt-2" placeholder="Isi pedoman khusus"
               disabled style="display:none;">
    </div>
</div>


        </div>
    </div>
</div>


</div>
<!-- Simpan dan Lanjut -->
<form id="simpan-lanjut-form" action="" method="GET" class="simpan-form">
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan dan Lanjut</span>
    </button>
</form>

<script>
document.getElementById('skema_id').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];
    let kode = selected.getAttribute('data-kode');
    let jenjang = selected.getAttribute('data-jenjang');

    // isi nomor otomatis dari kode_skema
    document.getElementById('nomorSkema').value = kode || '';

    // pilih radio otomatis sesuai jenjang
    if (jenjang) {
        if (jenjang.toLowerCase().includes("kkni")) {
            document.getElementById('kkni').checked = true;
        } else if (jenjang.toLowerCase().includes("okupasi")) {
            document.getElementById('okupasi').checked = true;
        }
    }
});

// fungsi untuk simpan data ke localStorage
function simpanKeLocal() {
    let data = {};

    // ambil nilai select skema
    data.skema_id = document.getElementById('skema_id').value;
    data.nomorSkema = document.getElementById('nomorSkema').value;

    // ambil radio skema
    let skemaRadio = document.querySelector('input[name="skema"]:checked');
    data.skema = skemaRadio ? skemaRadio.id : null;

    // ambil checkbox asesi
    data.asesi = [];
    document.querySelectorAll('input[name="asesi[]"]:checked').forEach(cb => {
        data.asesi.push(cb.value);
    });

    // ambil tujuan asesmen
    data.tujuan = [];
    document.querySelectorAll('input[name="tujuan[]"]:checked').forEach(cb => {
        data.tujuan.push(cb.value);
    });

    localStorage.setItem("mapa01Data", JSON.stringify(data));
}

// fungsi untuk load data dari localStorage
function loadDariLocal() {
    let data = localStorage.getItem("mapa01Data");
    if (!data) return;
    data = JSON.parse(data);

    // isi kembali select
    if (data.skema_id) {
        document.getElementById('skema_id').value = data.skema_id;
    }

    // isi kembali nomor
    if (data.nomorSkema) {
        document.getElementById('nomorSkema').value = data.nomorSkema;
    }

    // radio skema
    if (data.skema) {
        let radio = document.getElementById(data.skema);
        if (radio) radio.checked = true;
    }

    // checkbox asesi
    if (data.asesi) {
        document.querySelectorAll('input[name="asesi[]"]').forEach(cb => {
            if (data.asesi.includes(cb.value)) {
                cb.checked = true;
            }
        });
    }

    // tujuan asesmen
    if (data.tujuan) {
        document.querySelectorAll('input[name="tujuan[]"]').forEach(cb => {
            if (data.tujuan.includes(cb.value)) {
                cb.checked = true;
            }
        });
    }
}

// simpan otomatis setiap ada perubahan input
document.addEventListener("input", simpanKeLocal);
document.addEventListener("change", simpanKeLocal);

// load data ketika halaman dibuka
document.addEventListener("DOMContentLoaded", loadDariLocal);

    document.getElementById('simpan-lanjut-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const skemaId = document.getElementById('skema_id').value;
    if (skemaId) {
        window.location.href = "/form-perencanaan/mapa01/kode-unit/" + skemaId;
    } else {
        alert("Silakan pilih skema terlebih dahulu");
    }
});
     document.getElementById('skema_id').addEventListener('change', function() {
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
document.getElementById('simpanTujuan').addEventListener('click', function() {
    let input = document.getElementById('tujuanBaru');
    let value = input.value.trim();

    if(value !== "") {
        // Buat ID unik biar gak bentrok
        let id = 'tujuan-' + Date.now();

        // Tambahkan ke list
        let container = document.getElementById('tujuan-asesmen-list');
        
        let div = document.createElement('div');
        div.classList.add("d-flex", "align-items-center", "mb-2", "tujuan-custom");
        div.innerHTML = `
            <input type="checkbox" id="${id}" name="tujuan[]" value="${value}" class="form-check-input me-2" checked>
            <label for="${id}" class="me-2 flex-grow-1">${value}</label>
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash-fill"></i></button>
        `;
        container.appendChild(div);

        // Event hapus hanya utk opsi user
        div.querySelector(".btn-delete").addEventListener("click", function(){
            div.remove();
        });

        // Reset input
        input.value = "";

        // Tutup modal
        var modal = bootstrap.Modal.getInstance(document.getElementById('modalTambahTujuan'));
        modal.hide();
    }
});
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".toggle-input").forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                const targetId = this.dataset.target;
                const targetInput = document.getElementById(targetId);
                if (this.checked) {
                    targetInput.style.display = "block";
                    targetInput.disabled = false;
                } else {
                    targetInput.style.display = "none";
                    targetInput.disabled = true;
                    targetInput.value = ""; // reset isi kalau di-uncheck
                }
            });
        });
    });

</script>

@endsection
