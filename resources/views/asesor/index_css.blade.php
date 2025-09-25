@extends('layouts.master')

@section('title', 'Asesmen Mandiri')

@section('content')
<div class="container">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span>Form Asesmen &gt; <strong>FR.APL.02</strong></span>
    </div>

    <!-- Logo -->
    <div class="logo-box">
        <div class="logo"></div>
        <h2>Verifikasi Asesmen Mandiri</h2>
    </div>

    <!-- Form -->
    <div class="form-wrapper">
        <div class="form-box">
            <label for="judul">Judul</label>
            <select id="judul">
                <option>Pilih Judul</option>
                <option>Desain Multimedia</option>
                <option>Pengembangan Web</option>
            </select>
            <div class="error-message"></div>
        </div>

        <div class="form-box">
            <label for="nomor">Nomor</label>
            <input type="text" id="nomor" placeholder="Masukkan Nomor">
        </div>

        <div class="form-box">
            <label for="skema">Skema Sertifikasi</label>
            <select id="skema">
                <option>Pilih Skema</option>
                <option>Multimedia</option>
                <option>Web Development</option>
            </select>
            <div class="error-message"></div>
        </div>
    </div>
</div>

<div class="container">
            <!-- Unit Kompetensi 1 -->
            <div class="unit-header">
                <h3>Unit Kompetensi 1</h3>
                <h3>Kode Unit : J.58MT00.01.01<br>
                Judul Unit : Menterjemahkan Arah Visual ke Dalam Langkah Kerja</h3>
            </div>

            <div class="question-box">
                <div class="question-title">1. Mengidentifikasi elemen desain</div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Elemen</th>
                            <th>K</th>
                            <th>BK</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="elemen-list">
                                    <div class="elemen-item">1.1 Elemen-elemen desain diidentifikasi.</div>
                                    <div class="elemen-item">1.2 Langkah kerja setiap kebutuhan elemen desain ditetapkan.</div>
                                </div>
                            </td>
                            <td><input type="radio" name="q1" value="K"></td>
                            <td><input type="radio" name="q1" value="BK"></td>
                            <td>
                                <label class="upload-btn">
                                    Pilih
                                    <input type="file" name="bukti_q1" style="display: none;" onchange="handleFileUpload(event, 'preview_q1')">
                                </label>
                                <div class="preview-box"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="question-box">
                <div class="question-title">2. Merencanakan proses produksi aset visual multimedia</div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Elemen</th>
                            <th>K</th>
                            <th>BK</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2</td>
                            <td>
                                <div class="elemen-list">
                                    <div class="elemen-item">2.1 Prosedur pengerjaan aset visual diidentifikasi.</div>
                                    <div class="elemen-item">2.2 Kebutuhan aset visual multimedia diidentifikasi.</div>
                                </div>
                            </td>
                            <td><input type="radio" name="q2" value="K"></td>
                            <td><input type="radio" name="q2" value="BK"></td>
                            <td>
                                <label class="upload-btn">
                                    Pilih
                                    <input type="file" name="bukti_q2" style="display: none;" onchange="handleFileUpload(event, 'preview_q2')">
                                </label>
                                <div class="preview-box"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-new">
                <p class="card-title-new">Apakah Asesi Menyatakan Kompeten?</p>
                <label class="option-new">
                    <input type="radio" name="kompeten" value="ya"> Ya
                </label>
                <label class="option">
                    <input type="radio" name="kompeten" value="tidak"> Tidak
                </label>
            </div>

            <div class="card-new">
                <p class="card-title-new">Apakah bukti yang di lampirkan valid?</p>
                <label class="option-new">
                    <input type="radio" name="valid" value="ya"> Ya
                </label>
                <label class="option">
                    <input type="radio" name="valid" value="tidak"> Tidak
                </label>
            </div>

        </div>

        <div class="container">
            <!-- Unit Kompetensi 2 -->
            <div class="unit-header">
                <h3>Unit Kompetensi 2</h3>
                <h3>Kode Unit : J.58MT00.01.11<br>
                Judul Unit : Membuat Aset Visual Berdasarkan Langkah Kerja yang Telah Ditetapkan</h3>
            </div>

            <div class="question-box">
                <div class="question-title">1. Memproduksi aset visual multimedia</div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Elemen</th>
                            <th>K</th>
                            <th>BK</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="elemen-list">
                                    <div class="elemen-item">1.1 Prosedur pengerjaan aset visual teridentifikasi.</div>
                                    <div class="elemen-item">1.2 Aset visual multimedia diproduksi.</div>
                                    <div class="elemen-item">1.3 Penyimpanan aset secara berkala dilakukan.</div>
                                </div>
                            </td>
                            <td><input type="radio" name="q3" value="K"></td>
                            <td><input type="radio" name="q3" value="BK"></td>
                            <td>
                                <label class="upload-btn">
                                    Pilih
                                    <input type="file" name="bukti_q3" style="display: none;" onchange="handleFileUpload(event, 'preview_q3')">
                                </label>
                                <div class="preview-box"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            

            <div class="question-box">
                <div class="question-title">2. Mereview hasil desain</div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Elemen</th>
                            <th>K</th>
                            <th>BK</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2</td>
                            <td>
                                <div class="elemen-list">
                                    <div class="elemen-item">2.1 Hasil kerja dievaluasi secara berkala.</div>
                                    <div class="elemen-item">2.2 Tuntutan perbaikan visual dipersiapkan.</div>
                                    <div class="elemen-item">2.3 Proses perbaikan dilakukan.</div>
                                </div>
                            </td>
                            <td><input type="radio" name="q4" value="K"></td>
                            <td><input type="radio" name="q4" value="BK"></td>
                            <td>
                                <label class="upload-btn">
                                    Pilih
                                    <input type="file" name="bukti_q4" style="display: none;" onchange="handleFileUpload(event, 'preview_q4')">
                                </label>
                                <div class="preview-box"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-new">
                <p class="card-title-new">Apakah Asesi Menyatakan Kompeten?</p>
                <label class="option-new">
                    <input type="radio" name="kompeten" value="ya"> Ya
                </label>
                <label class="option">
                    <input type="radio" name="kompeten" value="tidak"> Tidak
                </label>
            </div>

            <div class="card-new">
                <p class="card-title-new">Apakah bukti yang di lampirkan valid?</p>
                <label class="option-new">
                    <input type="radio" name="valid" value="ya"> Ya
                </label>
                <label class="option">
                    <input type="radio" name="valid" value="tidak"> Tidak
                </label>
             </div>

        </div>

    <div class="button-box">
        <a href="{{ route('verifasesmencss') }}" class="btn-next" id="btnNext">Selanjutnya</a>
    </div>

     <div id="imageModal" class="modal">
        <span class="close" onclick="closeImageModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("collapsed");
            document.getElementById("content").style.marginLeft =
                document.getElementById("sidebar").classList.contains("collapsed") ? "70px" : "240px";
        }
    </script>

    <script src="{{ asset('assets/js/asesmen.js') }}"></script>
@endsection

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap');

/* ========================== */
/* Body & Container           */
/* ========================== */
body {
    font-family: 'Poppins', sans-serif;
    background: #fff;
    margin: 0;
    padding: 20px;
    color: #333;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

/* ========================== */
/* Breadcrumb & Logo          */
/* ========================== */
.breadcrumb {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.logo-box {
    text-align: center;
    margin-bottom: 20px;
}

.logo {
    width: 50px;
    height: 50px;
    background: #1d4ed8;
    border-radius: 8px;
    margin: auto;
}

.logo-box h2 {
    margin-top: 10px;
    font-size: 18px;
    font-weight: 600;
}

/* ========================== */
/* Form Styling               */
/* ========================== */
.form-wrapper {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}

.form-box {
    margin-bottom: 20px;
}

.form-box label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    font-size: 14px;
    color: #334155;
}

.form-box input, .form-box select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
}

/* ========================== */
/* Unit Header & Question Box */
/* ========================== */
.unit-header {
    background: #eef5ff;
    border-left: 5px solid #0284C7;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
}

.unit-header h3 {
    margin: 0;
    color: #2B2B2B;
    font-size: 16px;
}

.question-box {
    border: 1px solid #ccc;
    border-radius: 6px;
    margin: 15px 0;
    padding: 10px;
}

.question-title {
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 10px 0;
    table-layout: fixed;
}

table th, table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
    vertical-align: middle;
}

table th:nth-child(1), table td:nth-child(1) { width: 5%; }
table th:nth-child(2), table td:nth-child(2) { width: 60%; text-align: left; }
table th:nth-child(3), table td:nth-child(3), 
table th:nth-child(4), table td:nth-child(4) { width: 10%; }
table th:nth-child(5), table td:nth-child(5) { width: 15%; }

/* Elemen List */
.elemen-list {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 6px;
}

.elemen-item {
    display: flex;
    align-items: flex-start;
    text-align: left;
}

/* ========================== */
/* Upload Button & Preview    */
/* ========================== */
.upload-btn {
    background: #f3f4f6;
    border: 1px solid #ccc;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    display: inline-block;
    color: #333;
}

.upload-btn input[type="file"] {
    display: none;
}

.preview-box .file-name {
    font-size: 13px;
    font-weight: bold;
    color: #444;
    margin-bottom: 4px;
    word-break: break-all;
}

.preview-box .thumbnail {
    max-width: 100px;
    max-height: 100px;
    border-radius: 6px;
    border: 1px solid #ddd;
    padding: 4px;
    cursor: pointer;
    transition: 0.3s;
}

.preview-box .thumbnail:hover {
    opacity: 0.8;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.8);
    justify-content: center;
    align-items: center;
}

.modal-content {
    max-width: 90%;
    max-height: 90%;
    border-radius: 8px;
}

.close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

/* ========================== */
/* Card New & Radio Buttons   */
/* ========================== */
.card-new {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px 20px;
    margin-bottom: 20px;
}

.card-title-new {
    font-size: 14px;
    margin-bottom: 10px;
    color: #000;
}

.option-new {
    display: block;
    margin: 5px 0;
    font-size: 14px;
    color: #444;
}

input[type="radio"] {
    margin-right: 8px;
}

/* ========================== */
/* Button Box                 */
/* ========================== */
.button-box {
    text-align: right;
}

.btn-next {
    background: #0a1f55;
    color: #fff;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
}

/* ========================== */
/* Error & Success State      */
/* ========================== */
.input-error {
    border: 2px solid #e74c3c !important;
    background-color: #fdecea;
    animation: shake 0.3s ease-in-out;
}

.input-success {
    border: 2px solid #2ecc71 !important;
    background-color: #e9f9f0;
}

@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
    100% { transform: translateX(0); }
}

.error-message {
    font-size: 0.9rem;
    color: #e74c3c;
    margin-top: 5px;
    display: none;
}

.error-message.show {
    display: block;
}

</style>
@endsection