@extends('layouts.master')

@section('title', 'Asesmen Mandiri')

@section('content')
<body>
    <div class="container">
        <!-- Unit Kompetensi 1 -->
        <div class="unit-header">
            <h3>Unit Kompetensi 3</h3>
            <h3>Kode Unit :  J.59MTM00.027.1<br>
               Judul Unit : Mengumpulkan Asset Multimedia</h3>
        </div>

        <div class="question-box">
            <div class="question-title">1. Menyusun teknis pengelolaan konten</div>
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
                                <div class="elemen-item">1.1 Personil pengelola asset dikonfirmasi.</div>
                                <div class="elemen-item">1.2 Sistem penamaan file yang berdasarkan standar konvensi dan protocol.</div>
                                <div class="elemen-item">1.3 Sumber & review penyimpanan dan sistem backup ditetapkan.</div>
                            </div>
                        </td>
                        <td><input type="radio" name="q5" value="K"></td>
                        <td><input type="radio" name="q5" value="BK"></td>
                        <td>
                            <label class="upload-btn">
                                Pilih
                                <input type="file" name="bukti_q5" style="display: none;" onchange="handleFileUpload(event, 'preview_q5')">

                                <script src="{{ asset('assets/js/asesmen.js') }}"></script>
                            </label>
                            <div class="preview-box"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="question-box">
            <div class="question-title">2. Membuat strategi pencarian</div>
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
                                <div class="elemen-item">2.1 Pencarian dokumen dan asset media diatur.</div>
                                <div class="elemen-item">2.2 Konvensi untuk mencatat kemajuan dan lokasi asset media ditetapkan.</div>
                                <div class="elemen-item">2.3 Strategi pencarian dan pencatatan asset media dikembangkan.</div>
                                <div class="elemen-item">2.4 Sistem pengelolaan asset media disosialisaikan ke anggota tim saat sistem diterapkan.</div>
                            </div>
                        </td>
                        <td><input type="radio" name="q6" value="K"></td>
                        <td><input type="radio" name="q6" value="BK"></td>
                        <td>
                            <label class="upload-btn">
                                Pilih
                                <input type="file" name="bukti_q6" style="display: none;" onchange="handleFileUpload(event, 'preview_q6')">

                                <script src="{{ asset('assets/js/asesmen.js') }}"></script>
                            </label>
                            <div class="preview-box"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <!-- Unit Kompetensi 2 -->
        <div class="unit-header">
            <h3>Unit Kompetensi 4</h3>
            <h3>Kode Unit : J.59MTM00.028.1<br>
               Judul Unit : Membuat Data based Multimedia</h3>
        </div>

        <div class="question-box">
            <div class="question-title">1. Membuat basis data perangkat multimedia</div>
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
                                <div class="elemen-item">1.1 Sumber asset media sesuai prosedur didokumentasikan.</div>
                                <div class="elemen-item">1.2 Rincian dari berbagai output didokumentasikan sesuai informasi teknis, hak cipta dan perizinan.</div>
                                <div class="elemen-item">1.3 Persyaratan pengarsipan ditentukan.</div>
                            </div>
                        </td>
                        <td><input type="radio" name="q7" value="K"></td>
                        <td><input type="radio" name="q7" value="BK"></td>
                        <td>
                            <label class="upload-btn">
                                Pilih
                                <input type="file" name="bukti_q7" style="display: none;" onchange="handleFileUpload(event, 'preview_q7')">

                                <script src="{{ asset('assets/js/asesmen.js') }}"></script>
                            </label>
                            <div class="preview-box"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="question-box">
            <div class="question-title">2. Menyelesaikan masalah yang dihadapi</div>
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
                                <div class="elemen-item">2.1 Asset media dan informasi dicatat sesuai dengan sistem yang sudah mapan.</div>
                                <div class="elemen-item">2.2 Status produk, prototype dan asset media diindentifikasi.</div>
                                <div class="elemen-item">2.3 Menanggapi dan menyelesaikan permasalahan yang dihadapi saat sistem diimplementasikan.</div>
                            </div>
                        </td>
                        <td><input type="radio" name="q8" value="K"></td>
                        <td><input type="radio" name="q8" value="BK"></td>
                        <td>
                            <label class="upload-btn">
                                Pilih
                                <input type="file" name="bukti_q8" style="display: none;" onchange="handleFileUpload(event, 'preview_q8')">

                                <script src="{{ asset('assets/js/asesmen.js') }}"></script>
                            </label>
                            <div class="preview-box"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="container button-group">
        <a href="{{ route('asesmencss') }}" class="btn-back">Kembali</a>
        <a href="{{ route('asesmen3css') }}" class="btn-next" >Simpan dan Lanjut</a>
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
</body>
</html>
@endsection

<script>
    function handleFileUpload(event) {
    const file = event.target.files[0];
    const previewBox = event.target.closest("td").querySelector(".preview-box");

    // Kosongkan dulu isi preview
    previewBox.innerHTML = "";

    if (file) {
        // Buat elemen nama file
        const fileName = document.createElement("p");
        fileName.textContent = file.name;
        fileName.classList.add("file-name");
        previewBox.appendChild(fileName);

        // Kalau file gambar, tampilkan thumbnail img
        if (file.type.startsWith("image/")) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.classList.add("thumbnail");
            previewBox.appendChild(img);

            // Klik thumbnail untuk buka modal
            img.addEventListener("click", () => openImageModal(img.src));
        }
    }
}

// Fungsi buka modal
function openImageModal(src) {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");

    modal.style.display = "flex";
    modalImg.src = src;
}

// Fungsi tutup modal
function closeImageModal() {
    document.getElementById("imageModal").style.display = "none";
}

function handleFileUpload(event) {
    const file = event.target.files[0];
    if (file) {
        showAlert("File terpilih: " + file.name, "info");
    }
}
</script>

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap');

body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f6f8fc;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

/* Header Unit */
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

/* Box Pertanyaan */
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

/* Table */
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
table th:nth-child(1),
table td:nth-child(1) { width: 5%; }
table th:nth-child(2),
table td:nth-child(2) { width: 60%; text-align: left; }
table th:nth-child(3),
table td:nth-child(3),
table th:nth-child(4),
table td:nth-child(4) { width: 10%; }
table th:nth-child(5),
table td:nth-child(5) { width: 15%; }

/* Upload */
.upload-btn {
    background: #f3f4f6;
    border: 1px solid #ccc;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    color: #333;
    display: inline-block;
}
.upload-btn input[type="file"] { display: none; }
.preview-box img {
    width: 80px;
    height: auto;
    border-radius: 4px;
    border: 1px solid #ddd;
    margin-top: 5px;
}

/* Elemen List */
.elemen-list {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 6px;
}
.elemen-item {
    text-align: left;
}

/* Button Group */
.button-group {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}
.btn-next, .btn-back {
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    text-align: center;
}
.btn-next {
    background: #0a1f55;
    color: #fff;
}
.btn-next:hover { background-color: #163ea3; }
.btn-back {
    background-color: #e63946;
    color: white;
}
.btn-back:hover { background-color: #b82e38; }

/* Modal Preview */
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

</style>
@endsection
