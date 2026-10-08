@extends('master')
@section('title', 'Dashboard')
@section('konten')
<div class="container-fluid px-4 py-4">
    <h1>Selamat Datang, {{ Auth::user()->name }}</h1>
</div>
@endsection