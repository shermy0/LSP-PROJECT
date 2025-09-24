@extends('master')

@section('title', 'Form Asesmen')

@section('konten')
<div class="container-fluid mt-4 mb-5">
    <div class="bg-white border rounded-3 shadow-sm p-4">

        <!-- Panduan Bagi Asesor -->
        <div class="asesmen-card">
            <div class="asesmen-header">
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
                        Berilah tanda √ Ya atau Tidak pada tanda ** sesuai pilihan, jika jawaban Ya selanjutnya pada kolom keterangan berilah tanda √ di kotak ‘□’.
                    </div>
                </div>
            </div>
        </div>

        <!-- Potensi Asesi -->
        <div class="asesmen-card">
            <div class="asesmen-header">
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


<!-- Modal -->
<div class="modal fade" id="warningModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title fw-bold">Peringatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p><strong>Harap memilih salah satu jawaban, "Ya" atau "Tidak".</strong></p>
        <p>❌ Mohon tidak memilih kedua opsi secara bersamaan.</p>
        <p>✅ Sistem hanya mengizinkan satu pilihan yang sah.</p>
        <p>Pastikan jawaban yang Anda pilih sesuai dengan kondisi asesmen.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
      </div>
    </div>
  </div>
</div>

        <!-- Instrumen Asesmen -->
        <div class="asesmen-card mb-4">
            <div class="asesmen-header">
                <span class="header-line"></span>
                <h5>Instrumen Asesmen</h5>
            </div>
            <div class="asesmen-body p-0">
                <table class="table table-bordered asesmen-table mb-0">
                    <thead class="text-center align-middle bg-primary text-white">
                        <tr>
                            <th style="width:40px;">No</th>
                            <th style="width:250px;">Mengidentifikasi Persyaratan Modifikasi Asesmen</th>
                            <th style="width:160px;">Diperlukan Penyesuaian</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Baris 1 -->
                        <tr>
                            <td class="text-center">1</td>
                            <td>Keterbatasan akses terhadap persyaratan bahasa, literasi, numerasi.</td>
                            <td class="text-center align-middle">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q1" id="q1ya">
                                    <label class="form-check-label" for="q1ya">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q1" id="q1tidak">
                                    <label class="form-check-label" for="q1tidak">Tidak</label>
                                </div>
                            </td>
                            <td>
                                <div><input type="checkbox"> Memerlukan dukungan pembaca, penerjemah, penulis, isyarat</div>
                                <div><input type="checkbox"> Menggunakan hasil produk</div>
                                <div><input type="checkbox"> Menggunakan ceklis observasi</div>
                                <div><input type="checkbox"> Menggunakan daftar instruksi lisan</div>
                            </td>
                        </tr>

                        <!-- Baris 2 -->
                        <tr>
                            <td class="text-center">2</td>
                            <td>Penyediaan dukungan pembaca, penerjemah, penulis.</td>
                            <td class="text-center align-middle">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q2" id="q2ya">
                                    <label class="form-check-label" for="q2ya">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q2" id="q2tidak">
                                    <label class="form-check-label" for="q2tidak">Tidak</label>
                                </div>
                            </td>
                            <td>
                                <div><input type="checkbox"> Menggunakan pertanyaan lisan dengan pendamping</div>
                                <div><input type="checkbox"> Menggunakan gambar untuk memperjelas pertanyaan</div>
                                <div><input type="checkbox"> Menggunakan bahasa sederhana</div>
                            </td>
                        </tr>

                        <!-- Baris 3 -->
                        <tr>
                            <td class="text-center">3</td>
                            <td>Penggunaan teknologi adaptif atau peralatan khusus (tidak dapat menggunakan teknologi adaptif, komputer dan printer, peralatan digital, dll).</td>
                            <td class="text-center align-middle">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q3" id="q3ya">
                                    <label class="form-check-label" for="q3ya">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q3" id="q3tidak">
                                    <label class="form-check-label" for="q3tidak">Tidak</label>
                                </div>
                            </td>
                            <td>
                                <div><input type="checkbox"> Ceklis observasi/tes tertulis</div>
                                <div><input type="checkbox"> Pertanyaan lisan</div>
                                <div><input type="checkbox"> Pertanyaan tertulis</div>
                                <div><input type="checkbox"> Pertanyaan wawancara</div>
                                <div><input type="checkbox"> Daftar instruksi lisan/tertulis</div>
                                <div><input type="checkbox"> Ceklis verifikasi produk</div>
                                <div><input type="checkbox"> Menggunakan dukungan operator komputer</div>
                            </td>
                        </tr>

                        <!-- Baris 4 -->
                        <tr>
                            <td class="text-center">4</td>
                            <td>Pelaksanaan asesmen secara fleksibel karena alasan kesehatan atau kepentingan pengobatan.</td>
                            <td class="text-center align-middle">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q4" id="q4ya">
                                    <label class="form-check-label" for="q4ya">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q4" id="q4tidak">
                                    <label class="form-check-label" for="q4tidak">Tidak</label>
                                </div>
                            </td>
                            <td>
                                <div><input type="checkbox"> Menggunakan jadwal fleksibel</div>
                                <div><input type="checkbox"> Menggunakan instrumen asesmen alternatif</div>
                                <div><input type="checkbox"> Menggunakan waktu tambahan</div>
                                <div><input type="checkbox"> Menggunakan metode asesmen khusus untuk kebutuhan tertentu</div>
                            </td>
                        </tr>

                        <!-- Baris 5 -->
                        <tr>
                            <td class="text-center">5</td>
                            <td>Penyesuaian tempat fisik/lingkungan asesmen.</td>
                            <td class="text-center align-middle">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q5" id="q5ya">
                                    <label class="form-check-label" for="q5ya">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="q5" id="q5tidak">
                                    <label class="form-check-label" for="q5tidak">Tidak</label>
                                </div>
                            </td>
                            <td>
                                <div><input type="checkbox"> Menggunakan pertanyaan lisan</div>
                                <div><input type="checkbox"> Menggunakan pertanyaan wawancara</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<!-- Tombol Selanjutnya -->
<div class="d-flex justify-content-end mt-3">
  <a href="{{ route('asesi.wajar_alasan.form3') }}" class="btn btn-primary px-4">
    Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
  </a>
</div>


<!-- CSS Khusus -->
<style>
.container-fluid { max-width: 90% !important; }
.asesmen-card {
    border: 1px solid #d1d1d1;
    border-radius: 10px;
    background: #fff;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* Header Potensi Asesi */
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

.header-line {
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 5px;
    background: #2874c9;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}
.asesmen-header h5 {
    margin: 0 0 0 10px;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}
.asesmen-body { padding: 16px 20px; }
.panduan-item { 
    display:flex; 
    align-items:flex-start; 
    margin-bottom:10px; 
}

.panduan-number {
    background: linear-gradient(135deg, #2874c9, #1e56a0); /* gradasi biru */
    color:#fff; 
    border-radius:50%;
    width:28px; 
    height:28px; 
    text-align:center; 
    line-height:28px;
    margin-right:12px; 
    font-size:13px; 
    font-weight:600;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2); /* biar mirip timbul */
}

.panduan-text { 
    font-size:13px; 
    line-height:1.6; 
}


.potensi-item {
    display:flex; align-items:flex-start; gap:10px;
    padding:12px 15px; border-bottom:1px solid #ddd;
    font-size:14px; line-height:1.4;
}
.potensi-item:last-child { border-bottom:none; }
.potensi-item input[type="checkbox"] {
    width:18px; height:18px;
    cursor:pointer; margin-top:2px;
}
.potensi-text { flex:1; color:#333; }
.asesmen-table thead th {
    background-color: #0b2c61; /* biru tua */
    color: #fff;
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    font-size: 13px;
    border: 1px solid #fff; /* garis pemisah putih antar kolom */
}

/* rounded di ujung kiri-kanan */
.asesmen-table thead th:first-child {
    border-top-left-radius: 8px;
}
.asesmen-table thead th:last-child {
    border-top-right-radius: 8px;
}


/* >>> Tambahan CSS baru <<< */

/* Pertebal tombol Ya/Tidak */
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
    border-radius: 50%; /* jadi bulat */
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
    top: 4px;
    left: 4px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #fff;
}
.asesmen-body input[type="checkbox"]:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

/* Popup Overlay */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

/* Box */
.modal-box {
    background: #fff;
    border-radius: 10px;
    width: 420px;
    max-width: 90%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    overflow: hidden;
}

/* Header */
.modal-header {
    background: #d32f2f;
    color: white;
    padding: 12px 18px;
    display: flex;
    align-items: center;
}
.modal-header h5 {
    margin: 0;
    font-weight: 600;
}
.icon-box {
    background: white;
    color: #d32f2f;
    font-size: 20px;
    padding: 6px 10px;
    border-radius: 6px;
    margin-right: 10px;
}

/* Body */
.modal-body {
    padding: 18px;
    font-size: 14px;
    color: #333;
}

/* Footer */
.modal-footer {
    padding: 12px 18px;
    text-align: right;
}
.btn-ok {
    background: #041562;
    color: white;
    border: none;
    padding: 8px 18px;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-ok:hover {
    background: #06268f;
}

/* Tombol Selanjutnya */
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


</style>


<script>
// JS untuk kontrol Ya/Tidak -> aktifkan/disable checkbox
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll("tbody tr").forEach(function(row) {
        const yesRadio = row.querySelector('input[type="radio"][id$="ya"]');
        const noRadio  = row.querySelector('input[type="radio"][id$="tidak"]');
        const checkboxes = row.querySelectorAll('td:last-child input[type="checkbox"]');

        function updateCheckboxState() {
            if (yesRadio.checked) {
                checkboxes.forEach(cb => cb.disabled = false);
            } else {
                checkboxes.forEach(cb => {
                    cb.disabled = true;
                    cb.checked = false; // reset kalau pilih Tidak
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
});

document.addEventListener("DOMContentLoaded", function() {
    // Flag supaya popup hanya sekali muncul
    if (!localStorage.getItem("popupShown")) {
        let warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
        warningModal.show();
        localStorage.setItem("popupShown", "true"); // tandai sudah ditampilkan
    }
});
</script>
@endsection