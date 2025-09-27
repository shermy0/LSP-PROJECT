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
    <!-- Item 1 -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <a href="{{ route('formasesmen.juniortechnicalsupport') }}" class="text-dark text-decoration-none d-block"">
                <i class="fa-solid fa-stop me-2"></i> JUNIOR TECHNICAL SUPPORT
            </a>
        </h2>
    </div>

    <!-- Item 2 -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <a href="{{ route('formasesmen.pemogramanjunior') }}" class="text-dark text-decoration-none d-block"">
                <i class="fa-solid fa-stop me-2"></i> PEMOGRAMAN JUNIOR
            </a>
        </h2>
    </div>

    <!-- Item 3 -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <a href="{{ route('formasesmen.officeadministative') }}" class="text-dark text-decoration-none d-block"">
                <i class="fa-solid fa-stop me-2"></i> OFFICE ADMINISTRATIVE
            </a>
        </h2>
    </div>

    <!-- Item 4 -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <a href="{{ route('formasesmen.junioroperatordesigngrafis') }}" class="text-dark text-decoration-none d-block"">
                <i class="fa-solid fa-stop me-2"></i> JUNIOR OPERATOR DESIGN GRAFIS
            </a>
        </h2>
    </div>

    <!-- Item 5 -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <a href="{{ route('formasesmen.pramuniaga') }}" class="text-dark text-decoration-none d-block">
                <i class="fa-solid fa-stop me-2"></i> PRAMUNIAGA
            </a>
        </h2>
    </div>

    <!-- Item 6 -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <a href="{{ route('formasesmen.akuntansikeuanganII') }}" class="text-dark text-decoration-none d-block"">
                <i class="fa-solid fa-stop me-2"></i> KKNI LEVEL II AKUNTANSI DAN KEUANGAN
            </a>
        </h2>
    </div>
</div>


</div>
@endsection