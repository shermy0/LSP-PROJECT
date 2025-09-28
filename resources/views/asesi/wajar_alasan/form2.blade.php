@extends('master')

@section('title', 'Form Asesmen')

@section('konten')
<div class="container-fluid my-5">
    <div class="bg-white border rounded-3 shadow-sm p-5">

        <!-- ================== Panduan Bagi Asesor ================== -->
        <div class="asesmen-card mb-5">
            <div class="asesmen-header mb-3">
                <span class="header-line"></span>
                <h5>Panduan Bagi Asesor</h5>
            </div>
            <div class="asesmen-body">
                <div class="panduan-item">
                    <div class="panduan-number">1</div>
                    <div class="panduan-text">
                        Formulir ini dapat digunakan (sebelum pra asesmen, saat pelaksanaan pra asesmen, setelah pra asesmen)*
                        jika ada asesi yang mempunyai keterbatasan sesuai karakteristik yang dimilikinya sehingga diperlukan penyesuaian yang wajar...
                    </div>
                </div>
                <div class="panduan-item">
                    <div class="panduan-number">2</div>
                    <div class="panduan-text">Coretlah pada tanda * yang tidak sesuai.</div>
                </div>
                <div class="panduan-item">
                    <div class="panduan-number">3</div>
                    <div class="panduan-text">Berilah tanda √ pada kotak ‘□’ pada kolom potensi asesi.</div>
                </div>
                <div class="panduan-item">
                    <div class="panduan-number">4</div>
                    <div class="panduan-text">
                        Berilah tanda √ Ya atau Tidak pada tanda ** sesuai pilihan,
                        jika jawaban Ya selanjutnya pada kolom keterangan berilah tanda √ di kotak ‘□’.
                    </div>
                </div>
            </div>
        </div>
        <!-- ================== END Panduan Bagi Asesor ================== -->


        <!-- ================== Potensi Asesi ================== -->
        <div class="asesmen-card mb-5">
            <div class="asesmen-header mb-3">
                <span class="header-line"></span>
                <h5>Potensi Asesi</h5>
            </div>
            <div class="asesmen-body">
                <label class="potensi-item">
                    <input type="checkbox" name="potensi[]" value="1">
                    <span class="potensi-text">Hasil pelatihan / pendidikan dengan kurikulum sesuai standar kompetensi.</span>
                </label>
                <label class="potensi-item">
                    <input type="checkbox" name="potensi[]" value="2">
                    <span class="potensi-text">Hasil pelatihan dengan kurikulum belum berbasis kompetensi.</span>
                </label>
                <label class="potensi-item">
                    <input type="checkbox" name="potensi[]" value="3">
                    <span class="potensi-text">Pekerja berpengalaman dari industri berbasis standar kompetensi.</span>
                </label>
                <label class="potensi-item">
                    <input type="checkbox" name="potensi[]" value="4">
                    <span class="potensi-text">Pekerja berpengalaman dari industri belum berbasis kompetensi.</span>
                </label>
                <label class="potensi-item">
                    <input type="checkbox" name="potensi[]" value="5">
                    <span class="potensi-text">Pelatihan mandiri / otodidak.</span>
                </label>
            </div>
        </div>
        <!-- ================== END Potensi Asesi ================== -->

        <!-- ================== Instrumen Asesmen ================== -->
        <div class="asesmen-card mb-5">
            <div class="asesmen-header mb-3">
                <span class="header-line"></span>
                <h5>Instrumen Asesmen</h5>
            </div>

            <div class="asesmen-body">
                <div class="table-responsive">
                    <table class="table table-bordered asesmen-table mb-0 align-middle">
                        
                        <!-- ===== Table Header ===== -->
                        <thead class="text-center align-middle" style="background:#0a2c82; color:#fff;">
                            <tr>
                                <th rowspan="2" style="width:40px; vertical-align: middle;">No</th>
                                <th rowspan="2" style="width:320px; vertical-align: middle; text-align:left; padding-left:18px;">
                                    Mengidentifikasi Persyaratan Modifikasi Asesmen
                                </th>
                                <th colspan="2" style="width:160px;">Diperlukan Penyesuaian</th>
                                <th rowspan="2" style="vertical-align: middle; width:360px;">Keterangan</th>
                            </tr>
                            <tr style="background:#0a2c82; color:#fff;">
                                <th style="width:80px;">Ya</th>
                                <th style="width:80px;">Tidak</th>
                            </tr>
                        </thead>
                        <!-- ===== END Table Header ===== -->


                        <!-- ===== Table Body ===== -->
                        <tbody>

                            <!-- ===== Baris 1 ===== -->
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-start">Keterbatasan akses terhadap persyaratan bahasa, literasi, numerasi.</td>

                                <!-- Radio -->
                                <td class="text-center align-middle">
                                    <input type="radio" class="form-check-input" name="q1" id="q1ya" value="ya">
                                </td>
                                <td class="text-center align-middle">
                                    <input type="radio" class="form-check-input" name="q1" id="q1tidak" value="tidak">
                                </td>

                                <!-- Keterangan -->
                                <td class="text-start">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_1[]" id="ket_1_duk" value="dukungan">
                                        <label class="form-check-label" for="ket_1_duk">Memerlukan dukungan pembaca, penerjemah, pelayan, penulis.</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_1[]" id="ket_1_verbal" value="verbal">
                                        <label class="form-check-label" for="ket_1_verbal">Melakukan asesmen verbal (pertanyaan lisan/wawancara) dilengkapi gambar atau bentuk visual.</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_1[]" id="ket_1_hasil" value="hasil">
                                        <label class="form-check-label" for="ket_1_hasil">Menggunakan hasil produksi.</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_1[]" id="ket_1_ceklis" value="ceklis">
                                        <label class="form-check-label" for="ket_1_ceklis">Menggunakan ceklis observasi/demonstrasi.</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_1[]" id="ket_1_instr" value="instruksi">
                                        <label class="form-check-label" for="ket_1_instr">Menggunakan daftar instruksi terstruktur.</label>
                                    </div>

                                    <!-- Custom -->
                                    <div class="d-flex align-items-start mt-2">
                                        <input type="checkbox" class="form-check-input me-2 mt-1" id="ket_1_lain_checkbox">
                                        <textarea class="form-control form-control-sm keterangan-input"
                                                  id="ket_1_lain" name="ket_1_lain" rows="1"
                                                  placeholder="Tulis keterangan lain..." disabled></textarea>
                                    </div>
                                </td>
                            </tr>

                            <!-- ===== Baris 2 ===== -->
                            <tr>
                                <td class="text-center">2</td>
                                <td class="text-start">Penyediaan dukungan pembaca, penerjemah, penulis.</td>

                                <!-- Radio -->
                                <td class="text-center align-middle">
                                    <input type="radio" class="form-check-input" name="q2" id="q2ya" value="ya">
                                </td>
                                <td class="text-center align-middle">
                                    <input type="radio" class="form-check-input" name="q2" id="q2tidak" value="tidak">
                                </td>

                                <!-- Keterangan -->
                                <td class="text-start">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_2[]" id="ket_2_lisan" value="lisan">
                                        <label class="form-check-label" for="ket_2_lisan">Menggunakan pertanyaan lisan dengan pendamping</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_2[]" id="ket_2_gambar" value="gambar">
                                        <label class="form-check-label" for="ket_2_gambar">Menggunakan gambar untuk memperjelas pertanyaan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_2[]" id="ket_2_sederhana" value="sederhana">
                                        <label class="form-check-label" for="ket_2_sederhana">Menggunakan bahasa sederhana</label>
                                    </div>

                                    <!-- Custom -->
                                    <div class="d-flex align-items-start mt-2">
                                        <input type="checkbox" class="form-check-input me-2 mt-1" id="ket_2_lain_checkbox">
                                        <textarea class="form-control form-control-sm keterangan-input"
                                                  id="ket_2_lain" name="ket_2_lain" rows="1"
                                                  placeholder="Tulis keterangan lain..." disabled></textarea>
                                    </div>
                                </td>
                            </tr>

                            <!-- ===== Baris 3 ===== -->
                            <tr>
                                <td class="text-center">3</td>
                                <td class="text-start">Penggunaan teknologi adaptif atau peralatan khusus...</td>

                                <!-- Radio -->
                                <td class="text-center align-middle">
                                    <input type="radio" class="form-check-input" name="q3" id="q3ya" value="ya">
                                </td>
                                <td class="text-center align-middle">
                                    <input type="radio" class="form-check-input" name="q3" id="q3tidak" value="tidak">
                                </td>

                                <!-- Keterangan -->
                                <td class="text-start">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_3[]" id="ket_3_ceklis" value="ceklis">
                                        <label class="form-check-label" for="ket_3_ceklis">Ceklis observasi/tes tertulis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_3[]" id="ket_3_lisan" value="lisan">
                                        <label class="form-check-label" for="ket_3_lisan">Pertanyaan lisan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_3[]" id="ket_3_tertulis" value="tertulis">
                                        <label class="form-check-label" for="ket_3_tertulis">Pertanyaan tertulis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_3[]" id="ket_3_wawancara" value="wawancara">
                                        <label class="form-check-label" for="ket_3_wawancara">Pertanyaan wawancara</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_3[]" id="ket_3_instr" value="instr">
                                        <label class="form-check-label" for="ket_3_instr">Daftar instruksi lisan/tertulis</label>
                                    </div>

                                    <!-- Custom -->
                                    <div class="d-flex align-items-start mt-2">
                                        <input type="checkbox" class="form-check-input me-2 mt-1" id="ket_3_lain_checkbox">
                                        <textarea class="form-control form-control-sm keterangan-input"
                                                  id="ket_3_lain" name="ket_3_lain" rows="1"
                                                  placeholder="Tulis keterangan lain..." disabled></textarea>
                                    </div>
                                </td>
                            </tr>

                            <!-- ===== Baris 4 ===== -->
                            <tr>
                                <td class="text-center">4</td>
                                <td class="text-start">Pelaksanaan asesmen secara fleksibel karena alasan kesehatan...</td>

                                <!-- Radio -->
                                <td class="text-center align-middle">
                                    <input type="radio" class="form-check-input" name="q4" id="q4ya" value="ya">
                                </td>
                                <td class="text-center align-middle">
                                    <input type="radio" class="form-check-input" name="q4" id="q4tidak" value="tidak">
                                </td>

                                <!-- Keterangan -->
                                <td class="text-start">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_4[]" id="ket_4_jadwal" value="jadwal">
                                        <label class="form-check-label" for="ket_4_jadwal">Menggunakan jadwal fleksibel</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_4[]" id="ket_4_alt" value="alt">
                                        <label class="form-check-label" for="ket_4_alt">Menggunakan instrumen asesmen alternatif</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_4[]" id="ket_4_waktu" value="waktu">
                                        <label class="form-check-label" for="ket_4_waktu">Menggunakan waktu tambahan</label>
                                    </div>

                                    <!-- Custom -->
                                    <div class="d-flex align-items-start mt-2">
                                        <input type="checkbox" class="form-check-input me-2 mt-1" id="ket_4_lain_checkbox">
                                        <textarea class="form-control form-control-sm keterangan-input"
                                                  id="ket_4_lain" name="ket_4_lain" rows="1"
                                                  placeholder="Tulis keterangan lain..." disabled></textarea>
                                    </div>
                                </td>
                            </tr>

                            <!-- ===== Baris 5 ===== -->
                            <tr>
                                <td class="text-center">5</td>
                                <td class="text-start">Penyesuaian tempat fisik/lingkungan asesmen.</td>

                                <!-- Radio -->
                                <td class="text-center align-middle">
                                    <input type="radio" class="form-check-input" name="q5" id="q5ya" value="ya">
                                </td>
                                <td class="text-center align-middle">
                                    <input type="radio" class="form-check-input" name="q5" id="q5tidak" value="tidak">
                                </td>

                                <!-- Keterangan -->
                                <td class="text-start">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_5[]" id="ket_5_lisan" value="lisan">
                                        <label class="form-check-label" for="ket_5_lisan">Menggunakan pertanyaan lisan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ket_5[]" id="ket_5_wawancara" value="wawancara">
                                        <label class="form-check-label" for="ket_5_wawancara">Menggunakan pertanyaan wawancara</label>
                                    </div>

                                    <!-- Custom -->
                                    <div class="d-flex align-items-start mt-2">
                                        <input type="checkbox" class="form-check-input me-2 mt-1" id="ket_5_lain_checkbox">
                                        <textarea class="form-control form-control-sm keterangan-input"
                                                  id="ket_5_lain" name="ket_5_lain" rows="1"
                                                  placeholder="Tulis keterangan lain..." disabled></textarea>
                                    </div>
                                </td>
                            </tr>
                                        <!-- ===== Table Body ===== -->
                <tbody>
                    {{-- === Baris 1 s/d 5 === --}}
                    {{-- isi pertanyaanmu tetap sama --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- ================== END Instrumen Asesmen ================== -->


<!-- ================== Tombol Navigasi ================== -->
<div class="d-flex justify-content-between mt-3">
    <!-- Tombol Kembali -->
    <a href="{{ route('asesi.wajar_alasan.form1') }}" class="btn btn-back px-4">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>

    <!-- Tombol Selanjutnya -->
    <a href="{{ route('asesi.wajar_alasan.form3') }}" class="btn btn-primary px-4">
        Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
    </a>
</div>

<!-- CSS Khusus -->
<style>
/* ================================
   📦 Container & Card
================================ */
.container-fluid { 
    max-width: 90% !important; 
}
.asesmen-card {
    border: 1px solid #d1d1d1;
    border-radius: 10px;
    background: #fff;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* ================================
   🎯 Header
================================ */
.potensi-header {
    background: #07258a !important; /* biru tua */
    color: #fff;
}
.potensi-header h5 {
    color: #fff !important;
}

.asesmen-header {
    background: #eaf1ff;
    padding: 10px 16px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    position: relative;
    display: flex;
    align-items: center;
}
.asesmen-header h5 {
    margin: 0 0 0 10px;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

/* 👉 Garis kiri header (gradasi seperti form 3) */
.header-line {
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 6px;
    background: linear-gradient(to bottom, #0a2c82, #0066cc);
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

/* ================================
   📑 Body & Item
================================ */
.asesmen-body { 
    padding: 16px 20px; 
}
.panduan-item { 
    display:flex; 
    align-items:flex-start; 
    margin-bottom:10px; 
}
.panduan-text { 
    font-size:13px; 
    line-height:1.6; 
}

/* Nomor bulat pada panduan */
.panduan-number {
    background: linear-gradient(135deg, #2874c9, #1e56a0);
    color: #fff;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    text-align: center;
    line-height: 32px;
    margin-right: 12px;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    flex-shrink: 0;
}

/* Item potensi */
.potensi-item {
    display:flex; 
    align-items:flex-start; 
    gap:10px;
    padding:12px 15px; 
    border-bottom:1px solid #ddd;
    font-size:14px; 
    line-height:1.4;
}
.potensi-item:last-child { border-bottom:none; }
.potensi-text { flex:1; color:#333; }

/* ================================
   📊 Tabel
================================ */
.asesmen-table thead th {
    background-color: #0b2c61; 
    color: #fff;
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    font-size: 13px;
    border: 1px solid #fff;
}
.asesmen-table thead th:first-child {
    border-top-left-radius: 8px;
}
.asesmen-table thead th:last-child {
    border-top-right-radius: 8px;
}

/* ================================
   ✅ Checkbox & Radio
================================ */
/* Checkbox kotak default (Ya/Tidak) */
.form-check-input {
    border: 2px solid #2874c9 !important;
    width: 18px;
    height: 18px;
    cursor: pointer;
}
.form-check-input:checked {
    background-color: #2874c9 !important;
    border-color: #2874c9 !important;
}

/* Checkbox bulat untuk keterangan */
.asesmen-body input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #2874c9;
    border-radius: 50%; /* bulat */
    cursor: pointer;
    display: inline-block;
    position: relative;
    margin-right: 8px;
}
.asesmen-body input[type="checkbox"]:checked {
    background-color: #2874c9;
}
.asesmen-body input[type="checkbox"]:checked::after {
    content: "";
    position: absolute;
    top: 4px; left: 4px;
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #fff;
}
.asesmen-body input[type="checkbox"]:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

/* ================================
   🔘 Tombol
================================ */
.btn-primary {
    background-color: #07258a !important;
    border: none;
    font-weight: 600;
    border-radius: 8px;
    padding: 10px 20px;
    transition: all 0.3s ease;
}
.btn-primary:hover {
    background-color: #041a5f !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
}
.btn-primary:active {
    transform: translateY(0);
    box-shadow: none;
}
.btn-back {
    background-color: #e63946; /* merah */
    color: #fff !important;
    font-weight: 600;
    border-radius: 8px;
    padding: 10px 20px;
    transition: all 0.3s ease;
    text-decoration: none;
}
.btn-back:hover {
    background-color: #c92c3c;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
}
.btn-back:active {
    transform: translateY(0);
    box-shadow: none;
}
/* ================================
   📐 Tambahan CSS Form 2
================================ */
/* Spacing antar container utama */
.card-custom,
.card-outer {
    margin-bottom: 30px; /* kasih jarak antar container */
}

/* Spacing antar elemen di dalam form */
.mb-3 {
    margin-bottom: 20px !important; /* jarak antar field lebih lega */
}

/* Card dalam tanda tangan */
.card-inner {
    margin-bottom: 25px; /* beri jarak tambahan biar tidak nempel bawah */
    padding: 18px;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // === 1. Kontrol Ya/Tidak -> aktifkan/disable checkbox & textarea ===
    document.querySelectorAll("tbody tr").forEach(function(row) {
        const yesRadio   = row.querySelector('input[type="radio"][id$="ya"]');
        const noRadio    = row.querySelector('input[type="radio"][id$="tidak"]');
        const checkboxes = row.querySelectorAll('td:last-child input[type="checkbox"]');
        const textInputs = row.querySelectorAll('td:last-child .keterangan-input');

        function updateCheckboxState() {
            if (yesRadio && yesRadio.checked) {
                checkboxes.forEach(cb => cb.disabled = false);
                textInputs.forEach(txt => {
                    txt.disabled = false;
                    // Trigger auto-resize saat aktif
                    txt.style.height = "auto";
                    txt.style.height = txt.scrollHeight + "px";
                });
            } else {
                checkboxes.forEach(cb => {
                    cb.disabled = true;
                    cb.checked = false;
                });
                textInputs.forEach(txt => {
                    txt.value = "";
                    txt.disabled = true;
                    txt.style.height = "auto"; // reset tinggi
                });
            }
        }

        if (yesRadio && noRadio) {
            yesRadio.addEventListener("change", updateCheckboxState);
            noRadio.addEventListener("change", updateCheckboxState);
        }

        // Set default pas load
        updateCheckboxState();
    });

    // === 2. Auto-resize textarea keterangan ===
    document.querySelectorAll(".keterangan-input").forEach(function (textarea) {
        textarea.addEventListener("input", function () {
            this.style.height = "auto";      
            this.style.height = this.scrollHeight + "px"; 
        });
    });
});

</script>
@endsection