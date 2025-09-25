@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/profileasesor.css') }}">

<div class="container-profile profile-edit">
    <header class="header-profile">
        <div class="icon"></div>
        <h1>Edit Profil Asesor</h1>
        <div class="line"></div>
        <p>Perbarui informasi profil Anda - AsesKom</p>
    </header>

    <div class="profile-section">
        <!-- Kartu kiri -->
        <div class="card-left">
            <div class="avatar"></div>
            <h2>{{ $user->name }}</h2>
            <p class="role">{{ $user->role ?? 'Assessor' }}</p>
        </div>

        <!-- Form Edit di Kartu kanan -->
        <div class="card-right">
            <h3>Edit Informasi Pribadi</h3>
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="location">Lokasi</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $user->location ?? '') }}">
                </div>

                <div class="button-group">
                    <button type="submit" class="edit-btn">Update</button>
                    <a href="{{ route('profile.show') }}" class="back-btn">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
