@extends('master')

@section('konten')

<style>

.asesi-card{
    border:1px solid #eee;
    transition:0.2s;
    cursor:pointer;
}

.asesi-card:hover{
    transform:scale(1.01);
}

.asesi-selesai{
    background:#e8f7ee;
    border:1px solid #22c55e !important;
}

.status-hijau{
    color:#16a34a;
    font-weight:600;
    font-size:13px;
    display:flex;
    align-items:center;
    gap:5px;
}

.icon-hijau{
    color:#22c55e;
    font-size:18px;
}

.avatar-hijau{
    background:#22c55e !important;
}

</style>


<div class="container mt-4">

    {{-- Header --}}
    <div class="text-center mb-4">
        <h4 class="fw-bold" style="color:#041562;">Pilih Asesi</h4>
        <p class="text-muted mb-0">{{ $skema->nama_skema ?? '—' }}</p>
        <small class="text-muted">
            Set: <strong>{{ $pembuatan->judul ?? 'Set #' . $pembuatan->id_pembuatan_pertanyaan }}</strong>
            &nbsp;|&nbsp; Kelompok: <strong>{{ $kelompok->nama_kelompok ?? '—' }}</strong>
        </small>
    </div>


    {{-- Search --}}
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text" style="background-color:#041562; border-color:#041562;">
                <i class="bi bi-search text-white"></i>
            </span>
            <input type="text" id="searchAsesi" class="form-control"
                placeholder="Cari nama asesi..." oninput="filterAsesi()">
        </div>
    </div>


    {{-- LIST ASESI --}}
    <div class="row g-3" id="asesiList">

        @foreach($asesiDiAsesor as $asesi)

        <div class="col-md-6 col-lg-4 asesi-item"
            data-nama="{{ strtolower($asesi->nama_lengkap) }}">

            <div class="card shadow-sm rounded-4 h-100 asesi-card 
                {{ $asesi->sudah_input ? 'asesi-selesai' : '' }}"

                data-id="{{ $asesi->id_asesi }}"
                data-nama-asesi="{{ $asesi->nama_lengkap }}">

                <div class="card-body px-4 py-3 d-flex align-items-center gap-3">


                    {{-- Avatar --}}
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold text-white
                        {{ $asesi->sudah_input ? 'avatar-hijau' : '' }}"
                        style="width:44px;height:44px;font-size:1rem;background-color:#041562;">

                        {{ strtoupper(substr($asesi->nama_lengkap,0,1)) }}

                    </div>


                    {{-- Info --}}
                    <div class="flex-grow-1 overflow-hidden">

                        <p class="fw-bold mb-0 text-truncate"
                        style="color:#041562;font-size:0.9rem;">

                            {{ $asesi->nama_lengkap }}

                        </p>

                        @if($asesi->sudah_input)

                        <div class="status-hijau">
                            <i class="bi bi-check-circle-fill"></i>
                            Sudah diinput
                        </div>

                        @else

                        <small class="text-muted">
                            <i class="bi bi-person"></i>
                            Asesi
                        </small>

                        @endif

                    </div>


                    {{-- Icon kanan --}}
                    @if($asesi->sudah_input)

                    <i class="bi bi-check-circle-fill icon-hijau"></i>

                    @else

                    <i class="bi bi-arrow-right" style="color:#041562;"></i>

                    @endif

                </div>
            </div>

        </div>

        @endforeach

    </div>


    <div style="height:80px;"></div>

</div>


{{-- tombol kembali --}}
<a href="{{ route('pmo.hasil.kelompok', ['id_skema'=>$skema->id_skema]) }}"
style="position:fixed;bottom:20px;left:260px;
background:#6c757d;color:white;
border-radius:40px;padding:10px 18px;
font-weight:600;text-decoration:none;">

<i class="bi bi-arrow-left"></i> Kembali

</a>


<script>

document.addEventListener('DOMContentLoaded',function(){

const idSkema={{$skema->id_skema}};
const idPembuatan={{$pembuatan->id_pembuatan_pertanyaan}};
const idKelompok={{$kelompok->id_kelompok ?? 0}};

document.querySelectorAll('.asesi-card').forEach(function(card){

const idAsesi = card.dataset.id;
const nama = card.dataset.namaAsesi;
const sudahInput = card.classList.contains('asesi-selesai');

/* jika sudah diinput */
if(sudahInput){

card.addEventListener('click',function(){

Swal.fire({
icon:'info',
title:'Sudah diinput',
text:`Jawaban untuk ${nama} sudah diinput dan tidak bisa dibuka kembali.`,
confirmButtonText:'OK'
});

});

return;
}

/* jika belum diinput */
card.addEventListener('click',function(){

Swal.fire({
title:'Konfirmasi',
html:`Lanjutkan input jawaban untuk <b>${nama}</b>?`,
icon:'question',
showCancelButton:true,
confirmButtonText:'Ya',
cancelButtonText:'Batal'

}).then(result=>{

if(result.isConfirmed){

window.location.href=
`{{url('/pmo/hasil')}}/${idSkema}/${idPembuatan}/${idKelompok}/${idAsesi}`;

}

});

});

});

});


function filterAsesi(){

const keyword=document.getElementById('searchAsesi').value.toLowerCase();
const items=document.querySelectorAll('.asesi-item');

items.forEach(item=>{

const nama=item.dataset.nama;

if(nama.includes(keyword)){
item.style.display='';
}else{
item.style.display='none';
}

});

}

</script>
@endsection