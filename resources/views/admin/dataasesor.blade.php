@extends('master')

@section('title', 'Data Asesor')

@section('konten')
<div class="container py-4">

  {{-- Header --}}
  <div class="text-center mb-4">
    <div class="d-flex justify-content-center align-items-center mb-2">
      <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
        <i class="fas fa-users"></i>
      </div>
    </div>
    <h2 class="fw-bold">Data Asesor</h2>
    <p class="text-muted">Sistem Manajemen Asesor - AsesKom</p>
  </div>

 {{-- Statistik --}}
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card shadow-sm border-0 rounded-3 p-3">
        <div class="d-flex align-items-center">
          <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
            <i class="fas fa-user-tie"></i>
          </div>
          <div>
            <h4 class="mb-0 text-primary">15</h4>
            <small class="text-muted">Total Asesor</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-0 rounded-3 p-3">
        <div class="d-flex align-items-center">
          <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
            <i class="fas fa-check-circle"></i>
          </div>
          <div>
            <h4 class="mb-0 text-success">12</h4>
            <small class="text-muted">Aktif</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-0 rounded-3 p-3">
        <div class="d-flex align-items-center">
          <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
            <i class="fas fa-pause-circle"></i>
          </div>
          <div>
            <h4 class="mb-0 text-warning">3</h4>
            <small class="text-muted">Nonaktif</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Filter Section --}}
  <div class="filter-section d-flex align-items-center mb-3">
    <input type="text" class="form-control search-input me-2" placeholder="Cari...">
    <select class="form-select me-2" style="max-width: 180px;">
      <option>Semua Status</option>
      <option>Aktif</option>
      <option>Nonaktif</option>
    </select>
    <select class="form-select me-2" style="max-width: 180px;">
      <option>Semua Bidang</option>
      <option>Teknik Informatika</option>
      <option>Teknik Mesin</option>
    </select>
    <button class="btn btn-primary me-2">Filter</button>
    <button class="btn btn-secondary"><i class="fas fa-sync-alt"></i></button>
  </div>

  {{-- Tabel Data Asesor --}}
<div class="table-responsive mt-3">
  <table class="table table-bordered table-striped align-middle text-center">
    <thead class="table-primary">
      <tr>
        <th>No</th>
        <th>Nama Asesor</th>
        <th>NIP</th>
        <th>Bidang Keahlian</th>
        <th>Sertifikasi</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($asesor as $key => $a)
        <tr>
          <td>{{ $key+1 }}</td>
          <td class="text-start fw-bold">{{ $a->nama_asesor }}</td>
          <td>{{ $a->nip }}</td>
          <td><span class="badge bg-info text-dark">{{ $a->bidang_keahlian }}</span></td>
          <td>
            @if($a->sertifikasi == 'Lengkap')
              <span class="badge bg-success">Lengkap</span>
            @else
              <span class="badge bg-warning">Belum Lengkap</span>
            @endif
          </td>
          <td>
            @if($a->status == 'Aktif')
              <span class="badge bg-success">Aktif</span>
            @else
              <span class="badge bg-danger">Nonaktif</span>
            @endif
          </td>
          <td>
            <a href="#" class="btn btn-sm btn-primary">Detail</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7">Tidak ada data asesor</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

</div>
@endsection
