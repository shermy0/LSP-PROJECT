@extends('layouts.master')

@section('title', 'Asesmen Mandiri')

@section('content')
<body>
    <div class="container">
        <!-- Unit Kompetensi 1 -->
        <div class="unit-header">
            <h3>Unit Kompetensi 5</h3>
            <h3>Kode Unit :  J.59MTM00.029.1<br>
               Judul Unit : Mendistribusikan Asset Multimedia</h3>
        </div>

        <div class="question-box">
            <div class="question-title">1. Mengkonfirmasi prosedur distribusi asset</div>
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
                                <div class="elemen-item">1.1 Jadwal untuk tenggang waktu dikonfirmasi dengan personil yang relevan.</div>
                                <div class="elemen-item">1.2 Berkas dan mengindeks dokumen formal diajukan sesuai dengan prosedur proyek atau perusahaan yang disepakati.</div>
                                <div class="elemen-item">1.3 Skrip file dan indeks disetujui sesuai dengan prosedur proyek atau perusahaan.</div>
                            </div>
                        </td>
                        <td><input type="radio" name="q9" value="K"></td>
                        <td><input type="radio" name="q9" value="BK"></td>
                        <td>
                            <label class="upload-btn">
                                Pilih
                                <input type="file" name="bukti_q9" style="display: none;" onchange="handleFileUpload(event, 'preview_q9')">

                                <script src="{{ asset('assets/js/asesmen.js') }}"></script>
                            </label>
                            <div class="preview-box"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="question-box">
            <div class="question-title">2. Memastikan distributsi asset standar industri</div>
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
                                <div class="elemen-item">2.1 Aset media dalam sistem repositori sistem yang mapan diarsipkan sesuai dengan praktik industri.</div>
                                <div class="elemen-item">2.2 Distribusi yang tepat oleh personil yang relevan ke dokumen formal dan asset media dipastikan yang dikembangkan dalam proyek.</div>
                                <div class="elemen-item">2.3 keefektifan sistem manajemen asset media dan perhatikan bidang-bidang dievaluasi untuk perbaikan di masa depan.</div>
                            </div>
                        </td>
                        <td><input type="radio" name="q10" value="K"></td>
                        <td><input type="radio" name="q10" value="BK"></td>
                        <td>
                            <label class="upload-btn">
                                Pilih
                                <input type="file" name="bukti_q10" style="display: none;" onchange="handleFileUpload(event, 'preview_q10')">

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
        <div class="card-new">
        <p class="card-title-new">Rekomendasi Asesor</p>
            <label class="option-new">
                <input type="radio" name="kompeten" value="ya"> Asesi dapat melanjutkan ke asesmen berikutnya
            </label>
            <label class="option">
                <input type="radio" name="kompeten" value="tidak"> Asesi tidak dapat melanjutkan ke asesmen berikutnya
            </label>
        </div>
    </div>

<div class="ttd-container">
  <div class="ttd-header">Tanda Tangan Asesor</div>
  <div class="ttd-signature-section">

    <!-- Card Asesi -->
    <div class="ttd-card">
      <div class="ttd-card-title">Asesi</div>
      <form>
        <label for="nama-asesi2" class="ttd-label">Nama Lengkap</label>
        <input type="text" id="nama-asesi2" class="ttd-input" placeholder="Masukkan nama lengkap asesi">

        <label for="tanggal-asesi2" class="ttd-label">Tanggal</label>
        <input type="date" id="tanggal-asesi2" class="ttd-input">

        <label for="ttd-asesi2" class="ttd-label">Tanda Tangan</label>
        <canvas id="ttd-asesi2" class="ttd-canvas"></canvas>

        <div class="ttd-btns">
          <button type="button" class="ttd-btn ttd-clear" onclick="clearCanvas('ttd-asesi2')">Hapus</button>
          <button type="button" class="ttd-btn ttd-download" onclick="downloadTTD('ttd-asesi2','nama-asesi2','tanggal-asesi2')">Unduh</button>
        </div>
      </form>
    </div>

    <!-- Card Asesor -->
    <div class="ttd-card">
      <div class="ttd-card-title">Asesor</div>
      <form>
        <label for="nama-asesor" class="ttd-label">Nama Lengkap</label>
        <input type="text" id="nama-asesor" class="ttd-input" placeholder="Masukkan nama lengkap asesor">

        <label for="tanggal-asesor" class="ttd-label">Tanggal</label>
        <input type="date" id="tanggal-asesor" class="ttd-input">

        <label for="ttd-asesor" class="ttd-label">Tanda Tangan</label>
        <canvas id="ttd-asesor" class="ttd-canvas"></canvas>

        <div class="ttd-btns">
          <button type="button" class="ttd-btn ttd-clear" onclick="clearCanvas('ttd-asesor')">Hapus</button>
          <button type="button" class="ttd-btn ttd-download" onclick="downloadTTD('ttd-asesor','nama-asesor','tanggal-asesor')">Unduh</button>
        </div>
      </form>
    </div>

  </div>
</div>


               

  <script src="{{ asset('assets/js/asesmen.js') }}"></script>

    <!-- Tombol Aksi -->
    <div class="container button-group">
        <a href="{{ route('verifasesmencss') }}" class="btn-back">Kembali</a>
        <a href="#" class="btn-next" >Simpan dan Lanjut</a>
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

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap');

body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f6f8fc;
    margin: 0;
    padding: 0;
}

/* Container */
.container {
    max-width: 800px;
    margin: 20px auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

/* Unit Header */
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

/* Question Box */
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
table th:nth-child(1), table td:nth-child(1) { width: 5%; }
table th:nth-child(2), table td:nth-child(2) { width: 60%; text-align: left; }
table th:nth-child(3), table td:nth-child(3),
table th:nth-child(4), table td:nth-child(4) { width: 10%; }
table th:nth-child(5), table td:nth-child(5) { width: 15%; }

/* Upload & Preview */
.upload-btn {
    background: #f3f4f6;
    border: 1px solid #ccc;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    display: inline-block;
    color: #333;
}
.upload-btn input[type="file"] { display: none; }
.preview-box img {
    width: 80px;
    border-radius: 4px;
    border: 1px solid #ddd;
    margin-top: 5px;
}
.preview-box p {
    font-size: 13px;
    font-weight: bold;
    color: #444;
    margin-bottom: 4px;
    word-break: break-all;
}

/* Elemen List */
.elemen-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.elemen-item {
    display: flex;
    text-align: left;
}

/* Rekomendasi Card */
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
.option-new, .option {
  display: block;
  margin: 5px 0;
  font-size: 14px;
  color: #444;
}
input[type="radio"] { margin-right: 8px; }

/* Tanda Tangan */
.ttd-container {
  max-width: 1350px;
  margin: 20px auto;
  padding: 0 15px;
}
.ttd-header {
  background: #eaf2ff;
  border-left: 6px solid #0284C7;
  padding: 10px;
  border-radius: 6px;
  font-weight: bold;
  margin-bottom: 20px;
}
.ttd-signature-section {
  display: flex;
  justify-content: center;
  gap: 20px;
  flex-wrap: wrap;
}
.ttd-card {
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  padding: 20px;
  width: 350px;
  margin: 20px auto;
}
.ttd-card-title {
  font-weight: bold;
  margin-bottom: 12px;
}
.ttd-label { display: block; margin: 10px 0 5px; font-size: 14px; font-weight: bold; }
.ttd-input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 6px;
  margin-bottom: 10px;
  width: 100%;
}
.ttd-canvas {
  border: 1px solid #999;
  border-radius: 6px;
  width: 100%;
  height: 150px;
  cursor: crosshair;
}
.ttd-btns {
  display: flex;
  justify-content: space-between;
  margin-top: 10px;
}
.ttd-btn {
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
}
.ttd-clear { background: #ff4d4d; color: white; }
.ttd-download { background: #1d4ed8; color: white; }

/* Tombol */
.btn-next {
    background: #0a1f55;
    color: #fff;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
}
.btn-next:hover { background-color: #163ea3; }
.btn-back {
    background-color: #e63946;
    color: white;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
}
.btn-back:hover { background-color: #b82e38; }
.button-group {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}
.button-group .btn { min-width: 140px; text-align: center; }

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0;
    width: 100%; height: 100%;
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
    top: 20px; right: 35px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}


</style>
@endsection