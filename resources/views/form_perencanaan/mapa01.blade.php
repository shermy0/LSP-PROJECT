@extends('master')

@section('konten')
<div class="container mt-4">

    <!-- Breadcrumb -->
    <div class="mb-3 text-secondary">
        <small>
            <span class="text-muted">Form Perencanaan</span> > <span class="fw-semibold">FR.MAPA.01</span>
        </small>
    </div>

    <!-- Card utama -->
    <div class="card shadow-sm rounded-4 p-4 border-0">
        <div class="text-center mb-4">
            <!-- Kotak logo -->
            <div class="mx-auto mb-3" style="width: 50px; height: 50px; background-color:#001f60; border-radius:6px;"></div>
            
            <!-- Judul besar -->
            <h4 class="fw-bold">FR.MAPA.01 – MERENCANAKAN AKTIVITAS DAN PROSES ASESMEN</h4>
        </div>

        <!-- Dropdown skema -->
        <div class="text-center mb-4">
            <span class="fw-semibold">SKEMA:</span>
            <select class="form-select d-inline-block w-auto fw-bold text-primary bg-primary-subtle border-0 rounded-3 ms-2">
                <option selected>JUNIOR OPERATOR DESAIN GRAFIS</option>
                <option>Skema Lain</option>
            </select>
        </div>

        <!-- Form input -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 border rounded-3">
                    <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
                    <div>
                        <input type="radio" id="kkni" name="skema" class="form-check-input me-2">
                        <label for="kkni">KKNI</label>
                        <input type="radio" id="okupasi" name="skema" class="form-check-input me-2" checked>
                        <label for="okupasi">Okupasi</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 border rounded-3">
                    <label for="nomorSkema" class="fw-semibold d-block mb-2">Nomor</label>
                    <input type="text" id="nomorSkema" class="form-control" placeholder="Nomor Skema">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
