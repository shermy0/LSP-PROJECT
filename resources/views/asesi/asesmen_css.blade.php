@extends('layouts.master')

@section('title', 'Asesmen Mandiri')

@section('content')
<body>
    <!-- Konten utama -->
    
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
        </div>

        <!-- Tombol Aksi -->
        <div class="container button-group">
            <a href="{{ route('indexcss') }}" class="btn-back">Kembali</a>
            <a href="{{ route('asesmen2css') }}" class="btn-next">Simpan dan Lanjut</a>
        </div>

        <!-- Modal Preview -->
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
