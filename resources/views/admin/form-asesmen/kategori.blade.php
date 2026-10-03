@extends('master')

@section('konten')

<style>
.container {
    max-width: 1100px !important; /* dari 850 → 1100 */
    padding-left: 10px !important;
    padding-right: 10px !important;
    margin-left: auto !important;
    margin-right: auto !important;
}
.accordion-item {
    border: none !important;
    background: transparent !important;
    box-shadow: none !important;

    margin-bottom: -20px !important;  /* DARI 16px → 10px */
    padding: 0 !important;           /* HILANGKAN PADDING BAWAAN */
}

/* Tombol utama */
.accordion-button {
    padding: 10px 18px !important;   /* lebih kecil */
    font-size: 16px !important;
    background: #fff !important;
    border-radius: 14px !important;
    height: 48px !important;         /* HEIGHT FIXED */
    display: flex;
    align-items: center;
    border: 1px solid #e5e7eb !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.04) !important;
}


.accordion-button:hover {
    background: #f9fafb !important;
}

.accordion-button:not(.collapsed) {
    background: #fff !important;
    color: #000 !important;
    border: 1px solid #d4d4d4 !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05) !important;
}

.accordion-button:focus {
    border: 1px solid #d0d0d0 !important;
    box-shadow: none !important;
}

/* ========================= */
/*      SUBMENU DROPDOWN     */
/* ========================= */
.submenu-box {
    padding: 15px !important;
    background: #fff !important;
}

.submenu-item {
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 10px;
    border: 1px solid #e5e7eb;
    background: #fafafa;
    font-size: 15px;
    cursor: pointer;
    transition: 0.15s;
}

.submenu-item:hover {
    background: #f0f0f0;
}

/* PANAH CUSTOM */
.accordion-button .arrow {
    margin-left: auto;
    transition: transform 0.25s ease-in-out;
    font-size: 16px;
    opacity: 0.6;
    font-size: 22px;      /* <--- DIBESARIN */
    font-weight: 700;  
}

/* Rotate saat open */
.accordion-button:not(.collapsed) .arrow {
    transform: rotate(90deg);
    opacity: 1;
}

.title-sub span {
    display: inline-block;
    position: relative;
    padding-bottom: 4px;
    font-size: 22px;
    font-weight: 600;
}

.title-sub span::after {
    content: "";
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 0;
    width: 300px;          /* panjang garis */
    height: 3px;           /* tebal garis */
    background: #0ea5e9;   /* biru */
    border-radius: 3px;
}

</style>


<div class="container mt-4">

    <h1 class="fw-bold text-center">Form Asesmen</h1>
<h4 class="title-sub text-center mt-2">
    <span>{{ strtoupper($skema->nama_skema) }} – AsesKom</span>
</h4>

    <div class="accordion mt-4" id="accordionExample">

        {{-- PILIHAN GANDA --}}
        <div class="accordion-item mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed"
                    onclick="window.location.href='{{ route('admin.formasesmen.asesi',['skemaId'=>$skema->id_skema,'tipe'=>'pg']) }}'">
                    <i class="fa-solid fa-stop me-2"></i> Pertanyaan Pilihan Ganda
                </button>
            </h2>
        </div>

        {{-- ESAI --}}
        <div class="accordion-item mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed"
                    onclick="window.location.href='{{ route('admin.formasesmen.asesi',['skemaId'=>$skema->id_skema,'tipe'=>'esai']) }}'">
                    <i class="fa-solid fa-stop me-2"></i> Pertanyaan Esai
                </button>
            </h2>
        </div>

        {{-- LISAN --}}
        <div class="accordion-item mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed"
                    onclick="window.location.href='{{ route('admin.formasesmen.asesi',['skemaId'=>$skema->id_skema,'tipe'=>'lisan']) }}'">
                    <i class="fa-solid fa-stop me-2"></i> Pertanyaan Lisan
                </button>
            </h2>
        </div>

        {{-- PRAKTIK --}}
        <div class="accordion-item mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed"
                    onclick="window.location.href='{{ route('admin.formasesmen.asesi',['skemaId'=>$skema->id_skema,'tipe'=>'praktik']) }}'">
                    <i class="fa-solid fa-stop me-2"></i> Tugas Praktik Demonstrasi
                </button>
            </h2>
        </div>

        {{-- PENILAIAN ASESMEN (DROPDOWN) --}}
<div class="accordion-item mb-3">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#dropdownPenilaian">
            <i class="fa-solid fa-stop me-2"></i> Penilaian Asesmen
            <span class="arrow">›</span>
        </button>
    </h2>

    <div id="dropdownPenilaian" class="accordion-collapse collapse">
        <div class="submenu-box accordion-body">

            <div class="submenu-item"
                onclick="window.location.href='{{ route('admin.formasesmen.asesi',['skemaId'=>$skema->id_skema,'tipe'=>'observasi']) }}'">
                CEKLIS OBSERVASI
            </div>

            <div class="submenu-item"
                onclick="window.location.href='{{ route('admin.formasesmen.asesi',['skemaId'=>$skema->id_skema,'tipe'=>'pmo']) }}'">
                Pertanyaan PMO
            </div>

            <div class="submenu-item"
                onclick="window.location.href='{{ route('admin.formasesmen.asesi',['skemaId'=>$skema->id_skema,'tipe'=>'proyek']) }}'">
                Penjelasan Proyek
            </div>

        </div>
    </div>
</div>

    </div>
</div>

@endsection
