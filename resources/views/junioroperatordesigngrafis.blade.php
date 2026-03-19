@extends('master')

@section('konten')
<div class="container mt-4">
    <h1 class="fw-bold">Form Asesmen</h1>
    <div class="text-center mb-3">
        <h5 class="center-underline">
            JUNIOR TECHNICAL SUPPORT - AsesKom
        </h5>
    </div>

    <div class="accordion mt-4" id="formAccordion">
        <!-- Item 1 - Pertanyaan Pilihan Ganda -->
        <div class="accordion-item mb-2" 
            onclick="window.location='{{ route('formasesmen.pertanyaanPG', ['id_skema' => $skema->id_skema]) }}';"
            style="cursor: pointer;">
            <h2 class="accordion-header p-3 border rounded">
                <i class="fa-solid fa-stop me-2"></i> Pertanyaan Pilihan Ganda
            </h2>
        </div>

        <!-- Item 2 - Pertanyaan Esai -->
        <div class="accordion-item mb-2">
            <a href="{{ route('formasesmen.pertanyaanEsai', ['id_skema' => $skema->id_skema]) }}" 
               class="accordion-header d-block p-3 border rounded text-dark text-decoration-none">
                <i class="fa-solid fa-stop me-2"></i> Pertanyaan Esai
            </a>
            </h2>
        </div>

        <!-- Item 3 -->
        <div class="accordion-item mb-2" 
            onclick="window.location='{{ route('formasesmen.pertanyaanLisan', ['id_skema' => $skema->id_skema]) }}';"
            style="cursor: pointer;">
                <h2 class="accordion-header p-3 border rounded">
                    <i class="fa-solid fa-stop me-2"></i> Pertanyaan Lisan
                </h2>
        </div>

        <!-- Item 4 - Tugas Praktik Demonstrasi -->
        <div class="accordion-item mb-3">
            <h2 class="accordion-header p-3 border rounded">
                <a href="{{ route('formasesmen.pertanyaanDemonstrasi', ['id_skema' => $skema->id_skema]) }}" 
                   class="text-dark text-decoration-none">
                    <i class="fa-solid fa-stop me-2"></i> Tugas Praktik Demonstrasi
                </a>
            </h2>
        </div>

        <!-- Dropdown Penilaian Asesmen -->
        <div class="dropdown w-100 mt-2">
            <button class="btn btn-light border w-100 text-start d-flex align-items-center justify-content-between" 
                    type="button" 
                    id="dropdownMenuButton" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false">
                <span><i class="fa-solid fa-stop me-2"></i> Penilaian Asesmen</span>
                <i class="fa-solid fa-chevron-down"></i>
            </button>
            <ul class="dropdown-menu w-100 shadow-sm" aria-labelledby="dropdownMenuButton">
                <li>
    <a class="dropdown-item"
                       href="{{ route('ceklisobservasi.index', ['id_skema' => $skema->id_skema]) }}">
                        CEKLIS OBSERVASI
                    </a>
            </li>
                <li>
                    <!-- Direct ke view PMO.blade.php -->
                    <li>
                      <a class="dropdown-item"
                       href="{{ route('formasesmen.pmo', ['id_skema' => $skema->id_skema]) }}">
                        Pertanyaan PMO
                    </a>
                     </li>
                <li>
                    <a class="dropdown-item">
                        Penjelasan Proyek
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>
@endsection