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
                <a href="{{ Auth::user()->role === 'admin' 
                    ? route('admin.mapa01.admin', ['id_skema' => $skema->id_skema]) 
                    : route('form.mapa01', ['id_skema' => $skema->id_skema]) }}" 
                    class="text-decoration-none text-dark">
                    <i class="fa-solid fa-stop me-2"></i> FR.MAPA.01 - MERENCANAKAN AKTIVITAS DAN PROSES ASESMEN
                </a>
            </h2>
        </div>

                <!-- Item 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <a href="{{ Auth::user()->role === 'admin' 
                    ? route('admin.mapa02.admin', ['id_skema' => $skema->id_skema]) 
                    : route('form.mapa02', ['id_skema' => $skema->id_skema]) }}" 
                    class="text-decoration-none text-dark">
                    <i class="fa-solid fa-stop me-2"></i> FR.MAPA.02 - PETA INSTRUMEN ASESMEN HASIL PENDEKATAN ASESMEN DAN PERENCANAAN ASESMEN
                </a>
            </h2>
        </div>

        <!-- Item 2 -->
        {{-- <div class="accordion-item">
            <h2 class="accordion-header">
                <a href="{{ route('form.mapa02', ['id_skema' => $skema->id_skema]) }}" 
                   class="text-decoration-none text-dark">
                    <i class="fa-solid fa-stop me-2"></i> FR.MAPA.02 - PETA INSTRUMEN ASESMEN HASIL PENDEKATAN ASESMEN DAN PERENCANAAN ASESMEN
                </a>
            </h2>
        </div> --}}

        <!-- Item 3 -->
<div class="accordion-item">
    <h2 class="accordion-header d-flex align-items-center justify-content-between">
        
<a href="{{ Auth::user()->role === 'admin' 
            ? route('admin.laporan.admin', $skema->id_skema)
            : ($laporanBisaDibuka ? route('laporan.show', $skema->id_skema) : '#') }}"
   class="text-decoration-none text-dark {{ (!$laporanBisaDibuka && Auth::user()->role !== 'admin') ? 'disabled-link' : '' }}">
    <i class="fa-solid fa-stop me-2"></i> FR.AK.05 - LAPORAN ASESMEN
</a>

        @if(!$laporanBisaDibuka)
            <span class="badge bg-secondary">DISABLED</span>
        @endif
    </h2>
</div>


<!-- Item 4 -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <a href="{{ route('form_perencanaan.ninjau_asesmen', $skema->id_skema) }}" class="text-decoration-none text-dark">
                    <i class="fa-solid fa-stop me-2"></i> FR.AK.06 - MENINJAU PROSES ASESMEN
                </a>
            </h2>
        </div>
    </div>

<!-- Item 5 sebagai dropdown FR.VA -->
<div class="mt-4 w-100">
        <div class="dropdown w-100">
            <a class="btn dropdown-toggle w-100 text-start custom-dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-stop me-2"></i> FR.VA - MEMBERIKAN KONTRIBUSI DALAM VALIDASI ASESMEN
            </a>

            @php
                $sebelumFilled = DB::table('proses_validasi')
                    ->where('skema_id', $skema->id_skema)
                    ->where('periode', 'sebelum')
                    ->exists();

                $saatFilled = DB::table('proses_validasi')
                    ->where('skema_id', $skema->id_skema)
                    ->where('periode', 'saat')
                    ->exists();

                $sesudahFilled = DB::table('proses_validasi')
                    ->where('skema_id', $skema->id_skema)
                    ->where('periode', 'sesudah')
                    ->exists();
            @endphp

            <ul class="dropdown-menu w-100 custom-dropdown-menu">
                @if (auth()->check() && auth()->user()->role === 'admin')
                    <li>
                        <a href="{{ $sebelumFilled ? route('form_perencanaan.fr_va_pdf', ['periode' => 'sebelum', 'skema_id' => $skema->id_skema]) : '#' }}" 
                        class="dropdown-item {{ !$sebelumFilled ? 'disabled' : '' }}">
                            FR.VA - Sebelum Asesmen (Download)
                        </a>
                    </li>
                    <li>
                        <a href="{{ $sebelumFilled && $saatFilled ? route('form_perencanaan.fr_va_pdf', ['periode' => 'saat', 'skema_id' => $skema->id_skema]) : '#' }}" 
                        class="dropdown-item {{ !$sebelumFilled ? 'disabled' : '' }} {{ !$saatFilled && $sebelumFilled ? 'disabled' : '' }}">
                            FR.VA - Saat Asesmen (Download)
                        </a>
                    </li>
                    <li>
                        <a href="{{ $saatFilled && $sesudahFilled ? route('form_perencanaan.fr_va_pdf', ['periode' => 'sesudah', 'skema_id' => $skema->id_skema]) : '#' }}" 
                        class="dropdown-item {{ !$saatFilled ? 'disabled' : '' }} {{ !$sesudahFilled && $saatFilled ? 'disabled' : '' }}">
                            FR.VA - Sesudah Asesmen (Download)
                        </a>
                    </li>
                @elseif (auth()->check() && auth()->user()->role === 'asesor')
                    <li>
                        <a href="{{ route('form_perencanaan.fr_va', ['periode' => 'sebelum', 'skema_id' => $skema->id_skema]) }}" class="dropdown-item">
                            FR.VA - Sebelum Asesmen
                        </a>
                    </li>
                    <li>
                        <a href="{{ $sebelumFilled ? route('form_perencanaan.fr_va', ['periode' => 'saat', 'skema_id' => $skema->id_skema]) : '#' }}" 
                        class="dropdown-item {{ !$sebelumFilled ? 'disabled' : '' }}">
                            FR.VA - Saat Asesmen
                        </a>
                    </li>
                    <li>
                        <a href="{{ $saatFilled ? route('form_perencanaan.fr_va', ['periode' => 'sesudah', 'skema_id' => $skema->id_skema]) : '#' }}" 
                        class="dropdown-item {{ !$saatFilled ? 'disabled' : '' }}">
                            FR.VA - Sesudah Asesmen
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <br>
</div>

@if(!$laporanBisaDibuka && count($jenisKurang) > 0)
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const disabledLinks = document.querySelectorAll('a.disabled-link');

    disabledLinks.forEach(laporanLink => {
        laporanLink.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'FR.AK.05 Tidak Bisa Dibuka',
                html: `Jenis pertanyaan berikut belum dibuat:<br><ul>
                    @foreach($jenisKurang as $jenis)
                        <li>{{ ucfirst(str_replace('_', ' ', $jenis)) }}</li>
                    @endforeach
                    </ul>`,
                confirmButtonText: 'OK'
            });
        });
    });
});
</script>
@endif
@endsection
