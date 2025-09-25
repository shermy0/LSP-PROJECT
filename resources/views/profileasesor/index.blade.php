@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/profileasesor.css') }}">

<div class="container-profile profile-index">
    <header class="header-profile">
        <div class="icon"></div>
        <h1>Profile Asesor</h1>
        <div class="line"></div>
        <p>Kelola informasi profil dan kredensial profesional Anda - AsesKom</p>
    </header>

    <div class="profile-section">
        <!-- Kartu kiri -->
        <div class="card-left">
            <div class="avatar"></div>
            <h2>{{ $user->name }}</h2>
            <p class="role">{{ $user->role ?? 'Assessor' }}</p>
        </div>

        <!-- Kartu kanan -->
        <div class="card-right">
            <h3>Informasi Pribadi</h3>
            <div class="info">
                <p><span>Nama Lengkap</span> {{ $user->name }}</p>
                <p><span>Email</span> {{ $user->email }}</p>
                <p><span>Nomor Telepon</span> {{ $user->phone ?? '-' }}</p>
                <p><span>Anggota Sejak</span> {{ $user->created_at->translatedFormat('F Y') }}</p>
                <p><span>Lokasi</span> {{ $user->location ?? '-' }}</p>
            </div>
            <a href="{{ route('profileasesor.edit') }}" class="edit-btn">Edit</a>
        </div>
    </div>
</div>
@endsection
