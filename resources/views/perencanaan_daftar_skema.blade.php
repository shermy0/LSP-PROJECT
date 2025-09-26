@extends('master')

@section('konten')
<div class="container mt-4">
    <h1 class="fw-bold">Daftar Skema - Form Perencanaan</h1>
    <div class="text-center">
        <h5 class="center-underline">
            Sistem Manajemen Asesmen Siswa - AsesKom
        </h5>
    </div>

    <div class="accordion mt-4" id="formAccordion">
        @foreach($skema as $s)
            <div class="accordion-item mb-2">
                <a href="{{ route('formperencanaan.show', ['id_skema' => $s->id_skema]) }}" 
                   class="accordion-header d-block p-3 border rounded text-dark text-decoration-none">
                    <i class="fa-solid fa-stop me-2"></i> {{ strtoupper($s->nama_skema) }}
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection