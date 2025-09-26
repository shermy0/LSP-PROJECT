@extends('master')

@section('konten')

<div class="container mt-4">
    <h1 class="fw-bold">Form Perencanaan - {{ $skema->nama_skema }}</h1>
    <div class="text-center">
        <h5 class="center-underline">
            Sistem Manajemen Asesmen Siswa - AsesKom
        </h5>
    </div>
    <div class="accordion mt-4" id="formAccordion">
        <!-- Item 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header">
            <a href="{{ route('form.mapa01') }}" class="text-decoration-none text-dark">
                <i class="fa-solid fa-stop me-2"></i> FR.MAPA.01 - MERENCANAKAN AKTIVITAS DAN PROSES ASESMEN
            </a>
            </h2>
        </div>

        <!-- Item 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <a href="{{ route('mapa02.show') }}" class="text-decoration-none text-dark">
                    <i class="fa-solid fa-stop me-2"></i> FR.MAPA.02 - PETA INSTRUMEN ASESMEN HASIL PENDEKATAN ASESMEN DAN PERENCANAAN ASESMEN
                </a>
            </h2>
        </div>

        <!-- Item 3 -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <a href="{{ route('laporan') }}" class="text-decoration-none text-dark">
                    <i class="fa-solid fa-stop me-2"></i> FR.AK.06 - LAPORAN ASESMEN
                </a>
            </h2>
        </div>

        <!-- Item 4 -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <a href="{{ route('ninjau_asesemen') }}" class="text-decoration-none text-dark">
                    <i class="fa-solid fa-stop me-2"></i> FR.AK.06 - MENINJAU PROSES ASESMEN
                </a>
            </h2>
        </div>
    </div>

    <!-- Item 5 sebagai dropdown -->
    <div class="mt-4 w-100">
        <div class="dropdown w-100">
            <a class="btn dropdown-toggle w-100 text-start custom-dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-stop me-2"></i>FR.VA - MEMBERIKAN KONTRIBUSI DALAM VALIDASI ASESMEN
            </a>
            <ul class="dropdown-menu w-100 custom-dropdown-menu">
                <li><a href="{{ route('fr_va', 'sebelum') }}" class="dropdown-item">FR.VA - Sebelum Asesmen</a></li>
                <li><a href="{{ route('fr_va', 'saat') }}" class="dropdown-item">FR.VA - Pada Saat Asesmen</a></li>
                <li><a href="{{ route('fr_va', 'sesudah') }}" class="dropdown-item">FR.VA - Setelah Asesmen</a></li>
            </ul>
        </div>
    </div>
    <br>
</div>
@endsection