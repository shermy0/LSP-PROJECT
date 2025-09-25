@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/fria05aAdmin.css') }}">

<div class="form-asesmen-header">
    <p class="breadcrumb">Form Asesmen ></p>
    <div class="icon-box"></div>
    <h1 class="main-title">FR.IA.05.C. LEMBAR JAWABAN PILIHAN GANDA</h1>
    <p class="sub-title">Kunci Jawaban untuk Tes Tertulis Pilihan Ganda</p>
    <div class="skema-box">
        <span class="skema-text">ANSWER KEY FORM</span>
    </div>
</div>

{{-- ================= FORM BIODATA ================= --}}
<div class="section-box">
    <div class="form-group">
        <label for="no_form">No.Form</label>
        <input type="text" class="form-control" name="no_form" value="{{ $no_form ?? '' }}" readonly>
    </div>

    <div class="form-group">
        <label for="judul_skema">Judul Skema Sertifikasi</label>
        <input type="text" class="form-control" name="judul_skema" value="{{ $judul_skema ?? '' }}" readonly>
    </div>

    <div class="form-group">
        <label for="nama_asesor">Nama Asesor</label>
        <input type="text" class="form-control" name="nama_asesor" value="{{ $nama_asesor ?? '' }}" readonly>
    </div>

    <div class="form-group">
        <label for="nama_asesi">Nama Asesi</label>
        <input type="text" class="form-control" name="nama_asesi" value="{{ $nama_asesi ?? '' }}" readonly>
    </div>

    <div class="form-group">
        <label for="tanggal_asesmen">Tanggal Asesmen</label>
        <input type="date" class="form-control" name="tanggal_asesmen" value="{{ $tanggal_asesmen ?? '' }}" readonly>
    </div>

    <div class="form-group">
        <label for="tuk">TUK (Tempat Uji Kompetensi)</label>
        <input type="text" class="form-control" name="tuk" value="SMKN 11 Bandung" readonly>
    </div>
</div>

{{-- ================= BAGIAN PERTANYAAN ================= --}}
<div class="section-box">
<div class="header">
    <div class="header-strip"></div>
    <h2 class="header-title">Pertanyaan Asesmen</h2>
</div>

    @php
        $jawabanAsesi = $jawabanAsesi ?? [
            1 => 'c',
            2 => 'a',
            3 => 'b'
        ];
    @endphp

    {{-- 1. Pertanyaan --}}
    <div class="pertanyaan-box">
        <p><strong>1. Pertanyaan</strong></p>
        <p class="teks-pertanyaan">Ibu kota negara Indonesia adalah …</p>
        <div class="pilihan-jawaban">
            <label><input type="radio" name="jawaban[1]" value="a" {{ ($jawabanAsesi[1] ?? '')=='a' ? 'checked' : '' }} disabled><span>a. Surabaya</span></label>
            <label><input type="radio" name="jawaban[1]" value="b" {{ ($jawabanAsesi[1] ?? '')=='b' ? 'checked' : '' }} disabled><span>b. Bandung</span></label>
            <label><input type="radio" name="jawaban[1]" value="c" {{ ($jawabanAsesi[1] ?? '')=='c' ? 'checked' : '' }} disabled><span>c. Jakarta</span></label>
            <label><input type="radio" name="jawaban[1]" value="d" {{ ($jawabanAsesi[1] ?? '')=='d' ? 'checked' : '' }} disabled><span>d. Medan</span></label>
            <label><input type="radio" name="jawaban[1]" value="e" {{ ($jawabanAsesi[1] ?? '')=='e' ? 'checked' : '' }} disabled><span>e. Maleber</span></label>
        </div>
    </div>

    {{-- 2. Pertanyaan --}}
    <div class="pertanyaan-box">
        <p><strong>2. Pertanyaan</strong></p>
        <p class="teks-pertanyaan">Warna primer yang termasuk di bawah ini adalah …</p>
        <div class="pilihan-jawaban">
            <label><input type="radio" name="jawaban[2]" value="a" {{ ($jawabanAsesi[2] ?? '')=='a' ? 'checked' : '' }} disabled><span>a. Hijau</span></label>
            <label><input type="radio" name="jawaban[2]" value="b" {{ ($jawabanAsesi[2] ?? '')=='b' ? 'checked' : '' }} disabled><span>b. Ungu</span></label>
            <label><input type="radio" name="jawaban[2]" value="c" {{ ($jawabanAsesi[2] ?? '')=='c' ? 'checked' : '' }} disabled><span>c. Merah</span></label>
            <label><input type="radio" name="jawaban[2]" value="d" {{ ($jawabanAsesi[2] ?? '')=='d' ? 'checked' : '' }} disabled><span>d. Pink</span></label>
            <label><input type="radio" name="jawaban[2]" value="e" {{ ($jawabanAsesi[2] ?? '')=='e' ? 'checked' : '' }} disabled><span>e. Hitam</span></label>
        </div>
    </div>

    {{-- 3. Pertanyaan --}}
    <div class="pertanyaan-box">
        <p><strong>3. Pertanyaan</strong></p>
        <p class="teks-pertanyaan">Hewan yang termasuk jenis mamalia adalah …</p>
        <div class="pilihan-jawaban">
            <label><input type="radio" name="jawaban[3]" value="a" {{ ($jawabanAsesi[3] ?? '')=='a' ? 'checked' : '' }} disabled><span>a. Ayam</span></label>
            <label><input type="radio" name="jawaban[3]" value="b" {{ ($jawabanAsesi[3] ?? '')=='b' ? 'checked' : '' }} disabled><span>b. Kucing</span></label>
            <label><input type="radio" name="jawaban[3]" value="c" {{ ($jawabanAsesi[3] ?? '')=='c' ? 'checked' : '' }} disabled><span>c. Ikan</span></label>
            <label><input type="radio" name="jawaban[3]" value="d" {{ ($jawabanAsesi[3] ?? '')=='d' ? 'checked' : '' }} disabled><span>d. Katak</span></label>
            <label><input type="radio" name="jawaban[3]" value="e" {{ ($jawabanAsesi[3] ?? '')=='e' ? 'checked' : '' }} disabled><span>e. Kuda</span></label>
        </div>
    </div>

</div>
</div>

{{-- ================= PENYUSUN & VALIDATOR ================= --}}
<div class="section-box">
    <div class="header">
        <div class="header-strip"></div>
        <h2 class="header-title">Penyusun dan Validator</h2>
    </div>

    <table class="table-penyusun">
        <thead>
            <tr>
                <th>STATUS</th>
                <th>No.</th>
                <th>NAMA</th>
                <th>NOMOR MET</th>
                <th>TANDA TANGAN DAN TANGGAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>PENYUSUN</td>
                <td>1</td>
                <td>Mohamad Ismail</td>
                <td>MET.000.011727 2016</td>
                <td>-</td>
            </tr>
            <tr>
                <td>PENYUSUN</td>
                <td>2</td>
                <td>Zimzim Al Amin Syahidi</td>
                <td>MET.000.011730 2016</td>
                <td>-</td>
            </tr>
            <tr>
                <td>VALIDATOR</td>
                <td>3</td>
                <td>Nama Validator 1</td>
                <td>-</td>
                <td>-</td>
            </tr>
            <tr>
                <td>VALIDATOR</td>
                <td>4</td>
                <td>Nama Validator 2</td>
                <td>-</td>
                <td>-</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- ================= ACTION BUTTON ================= --}}
<div class="button-group">
    <form action="{{ route('unduh.fria05a') }}" method="POST" id="downloadForm">
        @csrf
        <button type="submit" class="btn-unduh">Unduh</button>
    </form>
</div>
@endsection