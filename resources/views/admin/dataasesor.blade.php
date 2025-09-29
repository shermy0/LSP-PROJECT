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


{{-- Modal Tambah Asesor --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.asesor.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Asesor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          
          <div class="mb-3">
            <label class="form-label">Nama Asesor</label>
            <input type="text" name="nama_asesor" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" name="nip" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Bidang Keahlian</label>
            <select name="bidang_keahlian" class="form-select" required>
              @foreach($listBidang as $b)
                <option value="{{ $b }}">{{ $b }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">No Registrasi</label>
            <input type="text" name="no_registrasi" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Statistik + Tombol Tambah --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    {{-- Statistik --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-3 p-3 mb-0">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <h4 class="mb-0 text-primary">{{ $total }}</h4>
                    <small class="text-muted">Total Asesor</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah --}}
    <div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Asesor
        </button>
    </div>
</div>



 <form action="{{ route('admin.dataasesor') }}" method="GET" class="d-flex mb-3">
    <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari...">
    <select name="bidang" class="form-select me-2" style="max-width: 280px;">
    <option value="Semua">Semua Bidang</option>
    @foreach($listBidang as $b)
        <option value="{{ $b }}" {{ request('bidang') == $b ? 'selected' : '' }}>
            {{ $b }}
        </option>
    @endforeach
</select>
    <button class="btn btn-primary me-2">Filter</button>
    <a href="{{ route('admin.dataasesor') }}" class="btn btn-secondary"><i class="fas fa-sync-alt"></i></a>
</form>

  {{-- Tabel Data Asesor --}}
<div class="table-responsive mt-3">
  <table class="table table-bordered table-striped align-middle text-center">
    <thead class="table-primary">
      <tr>
        <th>No</th>
        <th>Nama Asesor</th>
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
