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
        <a href="{{ route('asesmen') }}" class="btn btn-back">Kembali</a>
        <a href="{{ route('asesmen3') }}" class="btn btn-next" >Simpan dan Lanjut</a>
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
