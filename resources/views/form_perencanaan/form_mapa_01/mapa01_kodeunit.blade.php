@extends('master')
@section('konten')
    <div class="card mapa-card">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan') }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('form.mapa01') }}">FR.MAPA.01</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Komentar Asesor & Tanda Tangan
            </li>
        </ol>
    </nav>
    </div>
@endsection