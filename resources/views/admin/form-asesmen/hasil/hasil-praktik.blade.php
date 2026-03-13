@extends('master')

@section('konten')

<style>
    .tbl-header {
        background: #0d47a1 !important;
        color: white !important;
        font-weight: 600;
        text-align: center;
    }

    .badge-scheme {
        background: #0d47a1;
        color: white;
        padding: 6px 15px;
        border-radius: 6px;
        font-size: .8rem;
        font-weight: 600;
        letter-spacing: .5px;
    }

    /* konsisten dengan PG & ESAI */
    .section-title {
        background: #e7f0fb;
        border-left: 6px solid #0d47a1;
        padding: 10px 14px;
        font-weight: 600;
        margin: 25px 0 15px;
        border-radius: 6px;
        color: #0d47a1;
    }

    .table td {
        vertical-align: middle;
    }

    .signature-box {
        height: 80px;
        border: 1px dashed #0d47a1;
        border-radius: 6px;
        margin-top: 8px;
    }

    .signature-area{
    height:90px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.signature-img{
    max-height:70px;
}

.signature-box{
    width:180px;
    height:70px;
    border:1px dashed #0d47a1;
    border-radius:6px;
}

.signature-label{
    margin-top:5px;
    font-size:.85rem;
    color:#555;
}
</style>

<div class="container mt-4">

    {{-- ================= JUDUL ================= --}}
    <div class="text-center mb-4">
        <h4 class="fw-bold">FR.IA.08 – Hasil Praktik Demonstrasi</h4>
        <p class="text-muted">Skema Sertifikasi Kompetensi</p>

        <span class="badge-scheme">
            {{ strtoupper($skema->nama_skema ?? 'NAMA SKEMA DUMMY') }}
        </span>
    </div>

    {{-- ================= INFORMASI UMUM ================= --}}
<div class="section-title">Informasi Umum</div>
<table class="table table-bordered">
<tr>
<th class="tbl-header" width="25%">Skema Sertifikasi</th>
<td>{{ $judulSkema }}</td>

<th class="tbl-header" width="15%">Judul</th>
<td>{{ $nomorSertifikat }}</td>
</tr>

<tr>
<th class="tbl-header">TUK</th>
<td>-</td>

<th class="tbl-header">Nomor</th>
<td>{{ $nomorSertifikat }}</td>
</tr>

<tr>
<th class="tbl-header">Nama Asesor</th>
<td>{{ $namaTTD }}</td>

<th class="tbl-header">Waktu</th>
<td>{{ $waktuPenilaian }}</td>
</tr>

<tr>
<th class="tbl-header">Nama Asesi</th>
<td>{{ $asesi->name ?? '-' }}</td>

<th class="tbl-header">Tanggal</th>
<td>{{ $tanggalTTD }}</td>
</tr>
</table>

        {{-- ================= DAFTAR TUGAS PRAKTIK ================= --}}
<div class="section-title text-center">Daftar Tugas Demonstrasi</div>

<table class="table table-bordered">
    <thead class="tbl-header">
        <tr>
            <th width="5%">No</th>
            <th width="30%">Tugas / Pertanyaan</th>
            <th width="20%">Deskripsi</th>
            <th width="25%">Jawaban Asesi</th>
            <th width="20%">Lampiran Jawaban</th>
        </tr>
    </thead>

    <tbody>
@foreach($demonstrasi as $index => $tugas)
<tr>
    <td class="text-center">{{ $index + 1 }}</td>

    <td>
        <strong>{{ $tugas->isi_pertanyaan_demonstrasi }}</strong> {{-- sebelumnya $tugas->pertanyaan --}}
    </td>

    <td>
        {{ $tugas->deskripsi_pertanyaan }} {{-- sebelumnya $tugas->deskripsi --}}
    </td>

    <td>
        @php
            // Cari jawaban asesi sesuai id_tugas
            $jawaban = $jawabanAsesi->firstWhere('id_pertanyaan', $tugas->id_tugas);
        @endphp

        {{-- tampilkan jawaban --}}
        {{ $jawaban->jawaban_text ?? '-' }}
    </td>
</tr>
@endforeach
    </tbody>
</table>

{{-- ================= TANDA TANGAN ================= --}}
<div class="section-title text-center">Tanda Tangan</div>

<table class="table table-bordered text-center">
<tr>

<td width="50%" style="padding:25px">
    
    <strong>Asesi</strong><br>
    Nama : {{ $asesi->name ?? '-' }}<br>
    Tanggal : {{ $tanggalTTD }}

    <div class="signature-area mt-3">
        @if($ttdAsesi)
            <img src="{{ $ttdAsesi }}" class="signature-img">
        @else
            <div class="signature-box"></div>
        @endif
    </div>

    <div class="signature-label">Tanda tangan</div>

</td>

<td width="50%" style="padding:25px">

    <strong>Asesor</strong><br>
    Nama : {{ $namaTTD }}<br>
    No. Reg : {{ $asesor->no_registrasi ?? '-' }}<br>
    Tanggal : {{ $tanggalTTD }}

    <div class="signature-area mt-3">
        @if($ttdAsesor)
            <img src="{{ $ttdAsesor }}" class="signature-img">
        @else
            <div class="signature-box"></div>
        @endif
    </div>

    <div class="signature-label">Tanda tangan</div>

</td>

</tr>
</table>

{{-- ================= DOWNLOAD PDF ================= --}}
<div class="text-end mt-3">
<a href="{{ route('admin.formasesmen.hasil.pdf', ['skemaId'=>$skema->id_skema, 'asesiId'=>$asesi->id_asesi, 'tipe'=>$tipe]) }}" class="btn btn-danger">
    <i class="bi bi-file-earmark-pdf"></i> Download PDF
</a>
</div>

    </div>
</div>

@endsection
