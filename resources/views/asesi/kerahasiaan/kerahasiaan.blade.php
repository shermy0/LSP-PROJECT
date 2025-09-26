@extends('master')

@section('konten')
<div class="container">
    <h4 class="text-center fw-bold mb-4">KERAHASIAAN ASESI - UPLOAD BUKTI</h4>

    @if($persetujuan)
        <div class="mb-3 p-3 bg-light rounded">
            <p>Halo <strong>{{ $persetujuan->asesi->nama_lengkap ?? 'Asesi' }}</strong>, 
            silakan upload bukti sesuai yang sudah dipilih oleh Asesor kamu.</p>
        </div>

        <form action="{{ route('asesi.uploadBukti') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Skema & Okupasi -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Skema Sertifikasi</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->skema->nama_skema ?? '' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Okupasi</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->skema->jenjang ?? '' }}" readonly>
                </div>
                  <div class="col-md-6">
        <label class="form-label">Nama Asesi</label>
        <input type="text" class="form-control readonly-input"
               value="{{ Auth::user()->name }}" readonly>
    </div>
    <div class="col-md-6">
        <label class="form-label">Nama Asesor</label>
        <input type="text" class="form-control readonly-input"
               value="{{ $persetujuan?->asesor?->nama_asesor ?? 'Belum ditentukan' }}" readonly>
    </div>
            </div>

            <!-- Daftar bukti -->
            <table class="table table-bordered">
    <thead class="table-primary text-center">
        <tr>
            <th style="width: 50px;">No</th>
            <th>Bukti Yang Harus Dikumpulkan</th>
            <th>Upload File</th>
        </tr>
    </thead>
    <tbody>
    @foreach($persetujuan->buktiDipilih as $bukti)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $bukti->nama_bukti }}</td>
        <td>
            <input type="file" name="bukti_file[{{ $bukti->id_jenis_bukti }}]" class="form-control">
        </td>
    </tr>
@endforeach

</tbody>

</table>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Kirim Bukti</button>
            </div>
        </form>
    @else
        <div class="alert alert-warning">
            Belum ada persetujuan asesmen untuk akun kamu.
        </div>
    @endif
</div>
@endsection
