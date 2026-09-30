@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">

<div class="container mt-4">
    {{-- ========================================= --}}
    {{-- BAGIAN 1: HEADER & INFORMASI SKEMA --}}
    {{-- ========================================= --}}
    @include('partials.mapa01.header')

    {{-- ========================================= --}}
    {{-- BAGIAN 2: PENDEKATAN ASESMEN --}}
    {{-- ========================================= --}}
    @include('partials.mapa01.pendekatan')

    {{-- ========================================= --}}
    {{-- BAGIAN 3: KONTEKS ASESMEN --}}
    {{-- ========================================= --}}
    @include('partials.mapa01.konteks')

    {{-- ========================================= --}}
    {{-- BAGIAN 4: PERSYARATAN & MODIFIKASI --}}
    {{-- ========================================= --}}
    @include('partials.mapa01.modifikasi')
</div>

@endsection
