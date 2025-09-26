@extends('master')

@section('konten')
<div class="container">
    <form action="{{ route('asesmen.store') }}" method="POST">
        @csrf

        <h4 class="text-center fw-bold mb-4">PERSETUJUAN ASESMEN DAN KERAHASIAAN</h4>

        <div class="mb-3 p-3 bg-light rounded">
            <p>Persetujuan Asesmen ini untuk menjamin bahwa Asesi telah diberi arahan secara rinci tentang perencanaan dan proses asesmen.</p>
        </div>

        <!-- Skema & Okupasi -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Skema Sertifikasi</label>
                <input type="text" class="form-control" name="skema" value="{{ $data->skema }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Okupasi</label>
                <input type="text" class="form-control" name="okupasi" value="{{ $data->okupasi }}" readonly>
            </div>
        </div>

        <!-- No & Tempat Uji Kompetensi -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nomor</label>
                <input type="text" class="form-control" name="nomor" value="{{ $data->nomor }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tempat Uji Kompetensi</label>
                <input type="text" class="form-control" name="tempat_uji" value="{{ $data->tempat_uji }}" readonly>
            </div>
        </div>

        <!-- Nama Asesi & Asesor -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nama Asesi</label>
                <input type="text" class="form-control" name="nama_asesi" value="{{ $data->nama_asesi }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nama Asesor</label>
                <input type="text" class="form-control" name="nama_asesor" value="{{ $data->nama_asesor }}" readonly>
            </div>
        </div>

        <!-- Bukti yang dikumpulkan -->
        <div class="mb-3">
            <label class="form-label">Bukti yang Dikumpulkan</label>
            <div class="list-group">
                @foreach($bukti as $key => $item)
                    <div class="list-group-item">
                        <input type="checkbox" name="bukti[]" value="{{ $item->id }}">
                        {{ $item->nama_bukti }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tanggal & Waktu -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Waktu</label>
                <input type="time" name="waktu" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">TUK</label>
                <select name="tuk" class="form-control">
                    @foreach($tuk as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_tuk }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Pernyataan -->
        <div class="mb-3 p-3 border rounded">
            <strong>Asesi :</strong>
            <p>Dengan ini saya telah mendapatkan penjelasan terkait hak dan prosedur banding dalam asesmen ini.</p>
        </div>

        <div class="mb-3 p-3 border rounded">
            <strong>Asesor :</strong>
            <p>Menjelaskan bahwa hasil pekerjaan yang saya peroleh karena asesmen adalah asli dan pekerjaan saya sendiri, serta bukti tersebut autentik.</p>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Simpan Form</button>
        </div>
    </form>
</div>
@endsection
