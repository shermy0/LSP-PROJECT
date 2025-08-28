@extends('master')

@section('konten')
<div class="container mt-4">
    <h1 class="fw-bold">Form Perencanaan</h1>
    <div class="text-center">
        <h5 class="center-underline">
            Sistem Manajemen Asesmen Siswa - AsesKom
        </h5>
    </div>

    <div class="accordion mt-4" id="formAccordion">
        <!-- Item 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <i class="fa-solid fa-stop me-2"></i> FR.MAPA.01 - MERENCANAKAN AKTIVITAS DAN PROSES ASESMEN
            </h2>
        </div>

        <!-- Item 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <i class="fa-solid fa-stop me-2"></i> FR.MAPA.02 - PETA INSTRUMEN ASESMEN HASIL PENDEKATAN ASESMEN DAN PERENCANAAN ASESMEN
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
            <a class="btn dropdown-toggle w-100 text-start custom-dropdown" href="#" id="dropdown5" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-stop me-2"></i> FR.VA - MEMBERIKAN KONTRIBUSI DALAM VALIDASI ASESMEN
            </a>
            <ul class="dropdown-menu w-100 custom-dropdown-menu" aria-labelledby="dropdown5">
                <li><a class="dropdown-item" href="/fr-va-sebelum">FR.VA - SEBELUM ASESMEN</a></li>
                <li><a class="dropdown-item" href="/fr-va-saat">FR.VA - PADA SAAT ASESMEN</a></li>
                <li><a class="dropdown-item" href="/fr-va-setelah">FR.VA - SETELAH ASESMEN</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
