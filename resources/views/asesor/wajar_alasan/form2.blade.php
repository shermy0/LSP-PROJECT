@extends('master')

@section('title', 'Form Asesor - Asesmen')

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
                        Formulir ini digunakan oleh asesor untuk menilai kebutuhan penyesuaian asesmen asesi sesuai kondisi dan karakteristik individu.
                    </div>
                </div>
                <div class="panduan-item">
                    <div class="panduan-number">2</div>
                    <div class="panduan-text">Asesor harus memastikan pilihan yang dicentang sesuai hasil observasi dan diskusi dengan asesi.</div>
                </div>
                <div class="panduan-item">
                    <div class="panduan-number">3</div>
                    <div class="panduan-text">Beri tanda √ pada kolom pilihan yang relevan, baik Ya/Tidak maupun kotak ‘□’ keterangan.</div>
                </div>
                <div class="panduan-item">
                    <div class="panduan-number">4</div>
                    <div class="panduan-text">Gunakan keterangan tambahan jika diperlukan untuk memperjelas penyesuaian asesmen.</div>
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

        <!-- Tombol Pilih Semua -->
        <label class="potensi-item">
            <input type="checkbox" name="potensi[]" value="1" class="potensi-check">
            <span class="potensi-text">Hasil pelatihan / pendidikan dengan kurikulum sesuai standar kompetensi.</span>
        </label>
        <label class="potensi-item">
            <input type="checkbox" name="potensi[]" value="2" class="potensi-check">
            <span class="potensi-text">Hasil pelatihan dengan kurikulum belum berbasis kompetensi.</span>
        </label>
        <label class="potensi-item">
            <input type="checkbox" name="potensi[]" value="3" class="potensi-check">
            <span class="potensi-text">Pekerja berpengalaman dari industri berbasis standar kompetensi.</span>
        </label>
        <label class="potensi-item">
            <input type="checkbox" name="potensi[]" value="4" class="potensi-check">
            <span class="potensi-text">Pekerja berpengalaman dari industri belum berbasis kompetensi.</span>
        </label>
        <label class="potensi-item">
            <input type="checkbox" name="potensi[]" value="5" class="potensi-check">
            <span class="potensi-text">Pelatihan mandiri / otodidak.</span>
        </label>
    </div>
</div>


<!-- Instrumen Asesmen -->
<div class="asesmen-card mb-4">
    <div class="asesmen-header">
        <span class="header-line"></span>
        <h5>Instrumen Asesmen (Asesor)</h5>
    </div>
    <div class="asesmen-body p-0">
        <table class="table table-bordered asesmen-table mb-0">
            <thead class="text-center align-middle bg-primary text-white">
                <tr>
                    <th style="width:40px;">No</th>
                    <th style="width:250px;">Mengidentifikasi Kebutuhan Penyesuaian</th>
                    <th style="width:160px;">Perlu Penyesuaian?</th>
                    <th>Keterangan Asesor</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh Baris 1 -->
                <tr>
                    <td class="text-center">1</td>
                    <td>Keterbatasan akses bahasa, literasi, numerasi.</td>
                    <td class="text-center align-middle">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pilihan-radio" type="radio" name="q1" id="q1ya" value="ya" data-target="ket1">
                            <label class="form-check-label fw-bold" for="q1ya">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pilihan-radio" type="radio" name="q1" id="q1tidak" value="tidak" data-target="ket1">
                            <label class="form-check-label fw-bold" for="q1tidak">Tidak</label>
                        </div>
                    </td>
                    <td id="ket1">
                        <div><input type="checkbox" disabled> Dukungan pembaca/penerjemah/penulis</div>
                        <div><input type="checkbox" disabled> Instruksi lisan</div>
                        <div><input type="checkbox" disabled> Observasi langsung</div>
                    </td>
                </tr>
                <!-- Baris 2 -->
                <tr>
                    <td class="text-center">2</td>
                    <td>Kondisi kesehatan yang mempengaruhi asesmen.</td>
                    <td class="text-center align-middle">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pilihan-radio" type="radio" name="q2" id="q2ya" value="ya" data-target="ket2">
                            <label class="form-check-label fw-bold" for="q2ya">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pilihan-radio" type="radio" name="q2" id="q2tidak" value="tidak" data-target="ket2">
                            <label class="form-check-label fw-bold" for="q2tidak">Tidak</label>
                        </div>
                    </td>
                    <td id="ket2">
                        <div><input type="checkbox" disabled> Waktu tambahan</div>
                        <div><input type="checkbox" disabled> Jadwal fleksibel</div>
                        <div><input type="checkbox" disabled> Instrumen alternatif</div>
                    </td>
                </tr>
                <!-- Baris 3 -->
                <tr>
                    <td class="text-center">3</td>
                    <td>Keterbatasan sarana/lingkungan asesmen.</td>
                    <td class="text-center align-middle">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pilihan-radio" type="radio" name="q3" id="q3ya" value="ya" data-target="ket3">
                            <label class="form-check-label fw-bold" for="q3ya">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pilihan-radio" type="radio" name="q3" id="q3tidak" value="tidak" data-target="ket3">
                            <label class="form-check-label fw-bold" for="q3tidak">Tidak</label>
                        </div>
                    </td>
                    <td id="ket3">
                        <div><input type="checkbox" disabled> Tempat asesmen disesuaikan</div>
                        <div><input type="checkbox" disabled> Metode wawancara</div>
                        <div><input type="checkbox" disabled> Pertanyaan lisan</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


    </div>

    <!-- Tombol Selanjutnya -->
    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('asesor.wajar_alasan.form3') }}" class="btn btn-primary px-4">
            Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
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
.panduan-item { display:flex; align-items:flex-start; margin-bottom:10px; }
.panduan-number {
    background:#2874c9; color:#fff; border-radius:50%;
    width:24px; height:24px; text-align:center; line-height:24px;
    margin-right:12px; font-size:12px; font-weight:600;
}
.panduan-text { font-size:13px; line-height:1.6; }
.potensi-item {
    display:flex; align-items:flex-start; gap:10px;
    padding:12px 15px; border-bottom:1px solid #ddd;
    font-size:14px; line-height:1.4;
}
.potensi-item:last-child { border-bottom:none; }
/* Checkbox bulat */
.potensi-item input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #2874c9;
    border-radius: 50%; /* bikin bulat */
    outline: none;
    cursor: pointer;
    position: relative;
    margin-top: 2px;
}

.potensi-item input[type="checkbox"]:checked {
    background-color: #2874c9;
    border-color: #2874c9;
}

.potensi-item input[type="checkbox"]:checked::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 8px;
    height: 8px;
    background: #fff;
    border-radius: 50%;
}

/* Tambahan khusus untuk bagian Instrumen Asesmen */

/* Radio tombol lebih tebal */
.asesmen-table .form-check-input[type="radio"] {
    width: 20px;
    height: 20px;
    border: 3px solid #2874c9;
    cursor: pointer;
}

/* Checkbox bulat di keterangan instrumen */
.asesmen-table td input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #2874c9;
    border-radius: 50%;
    outline: none;
    cursor: pointer;
    position: relative;
    margin-right: 6px;
}

.asesmen-table td input[type="checkbox"]:checked {
    background-color: #2874c9;
    border-color: #2874c9;
}

.asesmen-table td input[type="checkbox"]:checked::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 8px;
    height: 8px;
    background: #fff;
    border-radius: 50%;
}

.asesmen-table td input[type="checkbox"]:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

</style>

<script>
document.querySelectorAll('.pilihan-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        let target = document.getElementById(this.dataset.target);
        let checkboxes = target.querySelectorAll('input[type="checkbox"]');
        
        if (this.value === 'ya') {
            checkboxes.forEach(cb => cb.disabled = false);
        } else {
            checkboxes.forEach(cb => {
                cb.disabled = true;
                cb.checked = false; // reset kalau pilih Tidak
            });
        }
    });
});
</script>

@endsection
