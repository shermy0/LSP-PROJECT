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
    
<div class="ttd-container">
  <div class="ttd-header">Tanda Tangan Asesi</div>
  <div class="ttd-card">
    <div class="ttd-card-title">Asesi</div>
    <form>
      <label for="nama-asesi" class="ttd-label">Nama Lengkap</label>
      <input type="text" id="nama-asesi" class="ttd-input" placeholder="Masukkan nama lengkap asesi">

      <label for="tanggal-asesi" class="ttd-label">Tanggal</label>
      <input type="date" id="tanggal-asesi" class="ttd-input">

      <label for="ttd-asesi" class="ttd-label">Tanda Tangan</label>
      <canvas id="ttd-asesi" class="ttd-canvas"></canvas>

      <div class="ttd-btns">
        <button type="button" class="ttd-btn ttd-clear" onclick="clearCanvas('ttd-asesi')">Hapus</button>
        <button type="button" class="ttd-btn ttd-download" onclick="downloadTTD('ttd-asesi','nama-asesi','tanggal-asesi')">Unduh</button>
      </div>
    </form>
  </div>
</div>

  <script src="{{ asset('assets/js/asesmen.js') }}"></script>

    <!-- Tombol Aksi -->
    <div class="container button-group">
        <a href="{{ route('asesmen2') }}" class="btn-back">Kembali</a>
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
