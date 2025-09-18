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
            <a href="{{ route('index') }}" class="btn-back">Kembali</a>
            <a href="{{ route('asesmen2') }}" class="btn-next">Simpan dan Lanjut</a>
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
