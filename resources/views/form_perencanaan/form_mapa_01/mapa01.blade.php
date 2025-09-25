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
        data-jenjang="{{ $skema->jenjang }}"
        data-standar="{{ $skema->unitKompetensi->pluck('standar_kompetensi')->first() }}">
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
            <label><input type="checkbox" id="123" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Bukti untuk mendukung asesmen</label>
            <label><input type="checkbox" id="124" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Aktivitas kerja di tempat kerja Asesi</label>
            <label><input type="checkbox" id="125" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Kegiatan Pembelajaran</label>
        </div>
    </div>

    <!-- Pelaksana -->
    <div class="form-group">
        <label class="form-label">Siapa yang melakukan asesmen / RPL</label>
        <div class="mapa-options-konteks">
            <label><input type="checkbox" id="126" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Lembaga Sertifikasi</label>
            <label><input type="checkbox" id="127" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Organisasi Pelatihan</label>
            <label><input type="checkbox" id="128" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2"> Asesor Perusahaan</label>
        </div>
    </div>
</div>
</div>

<div class="mapa-subsection-header">Konfirmasi dengan Orang Lain yang Relevan</div>
<div class="mapa-options">
    <div>
        <input type="checkbox" id="relevan1" name="orang_relevan[]" value="Manajer sertifikasi LSP P1 SMKN 11 Bandung" class="form-check-input me-2">
        <label for="relevan1">Manajer sertifikasi LSP P1 SMKN 11 Bandung</label>
    </div>
    <div>
        <input type="checkbox" id="relevan2" name="orang_relevan[]" value="Master Asesor / Master Trainer / Lead Asesor Kompetensi" class="form-check-input me-2">
        <label for="relevan2">Master Asesor / Master Trainer / Lead Asesor Kompetensi</label>
    </div>
    <div>
        <input type="checkbox" id="relevan3" name="orang_relevan[]" value="Manajer Pelatihan Lembaga Training terakreditasi / Lembaga Training Terdaftar" class="form-check-input me-2">
        <label for="relevan3">Manajer Pelatihan Lembaga Training terakreditasi / Lembaga Training Terdaftar</label>
    </div>
    <div>
        <input type="checkbox" id="relevan4" name="orang_relevan[]" value="Manajer atau supervisor di tempat kerja" class="form-check-input me-2">
        <label for="relevan4">Manajer atau supervisor di tempat kerja</label>
    </div>
</div>


            
<div class="mapa-subsection-header">Standar Industri atau Tempat Kerja</div>
<div class="mapa-options">
{{-- Standar Kompetensi --}}
<div>
    <input type="checkbox" id="129" name="asesi[]" 
           value="Standar Kompetensi" 
           class="form-check-input me-2"
           checked disabled>
    <label for="asesi1">Standar Kompetensi:</label>

<input type="text" id="input-asesi1" name="standar_kompetensi" 
       class="form-control mt-2" 
value=""
       readonly>

</div>


    {{-- Kriteria asesmen dari kurikulum pelatihan --}}
<form action="{{ route('form.mapa01.simpanDasarAsesmen', $skema->id_skema) }}" method="POST">
    @csrf
    <input type="hidden" name="skema_id" id="form_skema_id" value="{{ $skema->id_skema }}">

    <div>
        <input type="checkbox" name="kriteria_asesmen" value="1" 
            {{ $skema->dasarAsesmen && $skema->dasarAsesmen->kriteria_asesmen ? 'checked' : '' }}>
        <label>Kriteria asesmen dari kurikulum pelatihan</label>
    </div>

    <div>
        <input type="checkbox" name="spesifikasi_kinerja" value="1" 
            {{ $skema->dasarAsesmen && $skema->dasarAsesmen->spesifikasi_kinerja ? 'checked' : '' }}>
        <label>Spesifikasi kinerja suatu perusahaan atau industri</label>
    </div>

    <div>
        <input type="checkbox" name="spesifikasi_produk_toggle" class="toggle-input" data-target="input-asesi4">
        <label>Spesifikasi Produk:</label>
        <input type="text" id="input-asesi4" name="spesifikasi_produk" 
               class="form-control mt-2" 
               value="{{ $skema->dasarAsesmen->spesifikasi_produk ?? '' }}" 
               style="{{ $skema->dasarAsesmen && $skema->dasarAsesmen->spesifikasi_produk ? '' : 'display:none;' }}">
    </div>

    <div>
        <input type="checkbox" name="pedoman_khusus_toggle" class="toggle-input" data-target="input-asesi5">
        <label>Pedoman Khusus:</label>
        <input type="text" id="input-asesi5" name="pedoman_khusus" 
               class="form-control mt-2" 
               value="{{ $skema->dasarAsesmen->pedoman_khusus ?? '' }}" 
               style="{{ $skema->dasarAsesmen && $skema->dasarAsesmen->pedoman_khusus ? '' : 'display:none;' }}">
    </div>

    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>

        
    </div>
</div>


</div>
<!-- Simpan dan Lanjut -->
<form id="simpan-lanjut-form" action="" method="POST" class="simpan-form">
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan dan Lanjut</span>
    </button>
</form>


<script>
document.addEventListener("DOMContentLoaded", function() {

    // =========================
    // Inisialisasi data dari localStorage
    // =========================
function loadDariLocal() {
    let data = localStorage.getItem("mapa01Data");
    if (!data) return;
    data = JSON.parse(data);

    if (data.skema_id) {
        document.getElementById('skema_id').value = data.skema_id;
    }

    if (data.nomorSkema) document.getElementById('nomorSkema').value = data.nomorSkema;

    if (data.skema) {
        let radio = document.getElementById(data.skema);
        if (radio) radio.checked = true;
    }

    // checkbox asesi
    if (data.asesi) {
        document.querySelectorAll('input[name="asesi[]"]').forEach(cb => {
            if (data.asesi.includes(cb.value)) cb.checked = true;
        });
    }

    // checkbox tujuan
    if (data.tujuan) {
        document.querySelectorAll('input[name="tujuan[]"]').forEach(cb => {
            if (data.tujuan.includes(cb.value)) cb.checked = true;
        });
    }

    // 🔥 trigger ulang supaya standar_kompetensi otomatis muncul
    if (data.skema_id) {
        document.getElementById('skema_id').dispatchEvent(new Event('change'));
    }
}



    loadDariLocal();

    // =========================
    // Simpan data ke localStorage
    // =========================
    function simpanKeLocal() {
        let data = {};
        data.skema_id = document.getElementById('skema_id').value;
        data.nomorSkema = document.getElementById('nomorSkema').value;

        let skemaRadio = document.querySelector('input[name="skema"]:checked');
        data.skema = skemaRadio ? skemaRadio.id : null;

        data.asesi = [];
        document.querySelectorAll('input[name="asesi[]"]:checked').forEach(cb => data.asesi.push(cb.value));

        data.tujuan = [];
        document.querySelectorAll('input[name="tujuan[]"]:checked').forEach(cb => data.tujuan.push(cb.value));

        localStorage.setItem("mapa01Data", JSON.stringify(data));
    }

    document.addEventListener("input", simpanKeLocal);
    document.addEventListener("change", simpanKeLocal);

    // =========================
    // Pilih skema otomatis
    // =========================
document.getElementById('skema_id').addEventListener('change', function() {
    let selectedSkemaId = this.value;
    
    // update hidden input di form dasar asesmen
    document.getElementById('form_skema_id').value = selectedSkemaId;

    let selected = this.options[this.selectedIndex];
    let kode = selected.getAttribute('data-kode');
    let jenjang = selected.getAttribute('data-jenjang');
    let standar = selected.getAttribute('data-standar');

    document.getElementById('input-asesi1').value = standar || '';
    document.getElementById('nomorSkema').value = kode || '';

    if (jenjang) {
        if (jenjang.toLowerCase().includes("kkni")) document.getElementById('kkni').checked = true;
        else if (jenjang.toLowerCase().includes("okupasi")) document.getElementById('okupasi').checked = true;
    }

    simpanKeLocal();
});


    // =========================
    // Simpan & lanjut
    // =========================
    document.getElementById('simpan-lanjut-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const skemaId = document.getElementById('skema_id').value;
        if (!skemaId) { alert("Silakan pilih skema terlebih dahulu"); return; }

        let tujuan = [];
        document.querySelectorAll('input[name="tujuan[]"]:checked').forEach(cb => tujuan.push(cb.value));
        if (tujuan.length === 0) { alert("Silakan pilih minimal 1 tujuan asesmen"); return; }

        fetch("{{ route('mapa01.simpanTujuan') }}", {
            method: "POST",
            headers: { 
                "Content-Type": "application/json", 
                "X-CSRF-TOKEN": "{{ csrf_token() }}" 
            },
            body: JSON.stringify({ skema_id: skemaId, tujuan: tujuan })
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                console.error("Response bukan JSON:", text);
                throw new Error("HTTP error " + res.status);
            }
            return res.json();
        })
        .then(data => {
            if(data.status === 'success') {
                window.location.href = "/form-perencanaan/mapa01/kode-unit/" + skemaId;
            } else {
                alert("Gagal menyimpan tujuan");
            }
        })
        .catch(err => { console.error(err); alert("Terjadi kesalahan, coba lagi"); });
    });

    // =========================
    // Tambah opsi tujuan baru
    // =========================
    document.getElementById('simpanTujuan').addEventListener('click', function() {
        const input = document.getElementById('tujuanBaru');
        const value = input.value.trim();
        const skemaId = document.getElementById('skema_id').value;

        if(!skemaId) { alert("Silakan pilih skema terlebih dahulu"); return; }
        if(value === "") return;

        // Buat ID unik
        const id = 'tujuan-' + Date.now();

        // Tambahkan ke DOM
        const container = document.getElementById('tujuan-asesmen-list');
        const div = document.createElement('div');
        div.classList.add("d-flex","align-items-center","mb-2","tujuan-custom");
        div.innerHTML = `
            <input type="checkbox" id="${id}" name="tujuan[]" value="${value}" class="form-check-input me-2" checked>
            <label for="${id}" class="me-2 flex-grow-1">${value}</label>
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash-fill"></i></button>
        `;
        container.appendChild(div);

        // Event hapus
        div.querySelector(".btn-delete").addEventListener("click", function(){ div.remove(); simpanKeLocal(); });

        // Simpan ke database
        fetch("{{ route('mapa01.simpanTujuan') }}", {
            method: "POST",
            headers: { 
                "Content-Type": "application/json", 
                "X-CSRF-TOKEN": "{{ csrf_token() }}" 
            },
            body: JSON.stringify({ skema_id: skemaId, tujuan: [value] })
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                console.error("Response bukan JSON:", text);
                throw new Error("HTTP error " + res.status);
            }
            return res.json();
        })
        .then(data => { 
            if(data.status !== 'success') alert("Gagal menyimpan tujuan baru"); 
        })
        .catch(err => { console.error(err); alert("Terjadi kesalahan saat menyimpan tujuan baru"); });

        // Simpan ke localStorage
        simpanKeLocal();

        // Reset input dan tutup modal
        input.value = "";
        var modal = bootstrap.Modal.getInstance(document.getElementById('modalTambahTujuan'));
        modal.hide();
    });

    // =========================
    // Toggle input tambahan
    // =========================
    document.querySelectorAll(".toggle-input").forEach(function(checkbox) {
        checkbox.addEventListener("change", function() {
            const targetId = this.dataset.target;
            const targetInput = document.getElementById(targetId);
            if(this.checked) { targetInput.style.display="block"; targetInput.disabled=false; }
            else { targetInput.style.display="none"; targetInput.disabled=true; targetInput.value=""; }
        });
    });

});
</script>



@endsection
