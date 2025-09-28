@extends('master')

@section('title', 'Pilih Asesor')

@section('konten')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Pilih Asesor untuk Asesi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.pilih_asesor.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-5">
                <label class="form-label">Pilih Asesi</label>
                    <select name="asesi_id" class="form-select" required>
                          @foreach($asesis as $a)
                             <option value="{{ $a->id_asesi }}">{{ $a->nama_lengkap }}</option>
                         @endforeach
                    </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Pilih Asesor</label>
                <select name="asesor_id" class="form-select" required>
                    @foreach($asesors as $b)
                        <option value="{{ $b->id_asesor }}">{{ $b->nama_asesor }} - {{ $b->bidang_keahlian }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Simpan</button>
            </div>
        </div>
    </form>

    <h4 class="mt-5">Daftar Asesi & Asesor</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama Asesi</th>
                <th>Asesor yang Ditugaskan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asesis as $a)
                <tr>
                    <td>{{ $a->nama_lengkap }}</td>
                    <td>
                        @if($a->asesor)
                            <span class="badge bg-info">{{ $a->asesor->nama_asesor }}</span>
                        @else
                            <span class="text-muted">Belum ada asesor</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
