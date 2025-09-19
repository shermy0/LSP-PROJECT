@extends('master')

@section('konten')
<div class="container mt-4">
    <h1 class="fw-bold">Form Asesmen</h1>
    <div class="text-center">
        <h5 class="center-underline">
            Sistem Manajemen Asesmen Siswa - AsesKom
        </h5>
    </div>

    <div class="accordion mt-4" id="formAccordion">
        @foreach($skema as $s)
        <div class="accordion-item">
            <h2 class="accordion-header">
                <a href="{{ route('formasesmen.pertanyaanDemonstrasi', ['id_skema' => $skema->id_skema]) }}" 
   class="text-dark text-decoration-none">
    <i class="fa-solid fa-stop me-2"></i> Tugas Praktik Demonstrasi
</a>

            </h2>
        </div>
        @endforeach
    </div>
</div>
@endsection
