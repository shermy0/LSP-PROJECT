@extends('master')

@section('konten')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta Asesmen</title>
    <link rel="stylesheet" href="{{ asset('assets/css/datapesertauji.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="container">
    <h1>Data Peserta Asesmen</h1>

  
    <!-- Stat Card -->
    <div class="card-container">
        <div class="card blue">
            <div class="card-icon"><i class="fa-solid fa-users"></i></div>
            <p class="label">TOTAL PESERTA</p>
            <h2>{{ $totalPeserta }}</h2>
            <p class="growth">+12.5% Bulan ini</p>
        </div>

        <div class="card green">
            <div class="card-icon"><i class="fa-solid fa-check-circle"></i></div>
            <p class="label">Lengkap</p>
            <h2>{{ $pesertaLengkap }}</h2>
            <p class="growth">+12.5% Bulan ini</p>
        </div>

        <div class="card yellow">
            <div class="card-icon"><i class="fa-solid fa-clock"></i></div>
            <p class="label">Belum Lengkap</p>
            <h2>{{ $pesertaBelumLengkap }}</h2>
            <p class="growth">+12.5% Bulan ini</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('datapesertauji') }}">
            <input type="text" class="search-box" name="search" placeholder="Cari nama..." value="{{ request('search') }}">

            <select name="kelas" class="filter-select">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                @endforeach
            </select>

            <select name="status" class="filter-select">
                <option value="">-- Pilih Status --</option>
                <option value="lengkap" {{ request('status') == 'lengkap' ? 'selected' : '' }}>Lengkap</option>
                <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Lengkap</option>
            </select>

            <button type="submit" class="btn-filter">Filter</button>
        </form>
    </div>

    <!-- Table -->
    <div class="table-container">
        <div class="table-header">
            <h3>Daftar Peserta Asesmen</h3>
            <p>Kelola data peserta dengan sistem profesional</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA SISWA</th>
                    <th>NIS</th>
                    <th>KELAS</th>
                    <th>SKEMA SERTIFIKASI</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peserta as $index => $p)
                <tr>
                    <td>{{ $peserta->firstItem() + $index }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->nis }}</td>
                    <td>{{ $p->kelas }}</td>
                    <td>{{ $p->skema }}</td>
                    <td>
                        @if($p->status == 'Lengkap')
                            <span class="status-lengkap">{{ $p->status }}</span>
                        @else
                            <span class="status-belum">{{ $p->status }}</span>
                        @endif
                    </td>
                    <td><a href="{{ route('peserta.show', $p->id) }}" class="detail-link">Detail</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $peserta->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection