@extends('master')

@section('konten')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #041562;
        --primary-light: #0a2a9e;
        --primary-glow: rgba(4, 21, 98, 0.10);
        --accent-gold: #e8b84b;
        --text-main: #0d1b4b;
        --text-muted: #6b7fb5;
    }

    body, .container {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .pilih-wrapper {
        min-height: 100vh;
        background: linear-gradient(160deg, #eef2ff 0%, #f8faff 50%, #e8eeff 100%);
        padding: 3.5rem 0 5rem;
        position: relative;
        overflow: hidden;
    }

    .pilih-wrapper::before {
        content: '';
        position: absolute;
        top: -140px; right: -140px;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(4,21,98,0.07) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .pilih-wrapper::after {
        content: '';
        position: absolute;
        bottom: -100px; left: -100px;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(4,21,98,0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .header-badge {
        display: inline-block;
        background: var(--primary-glow);
        color: var(--primary);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 50px;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(4,21,98,0.18);
    }

    .page-header h2 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.25rem;
        line-height: 1.25;
    }

    .page-header p {
        color: var(--text-muted);
        font-size: 0.92rem;
        font-weight: 500;
        margin: 0;
    }

    .header-divider {
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--accent-gold));
        border-radius: 4px;
        margin-top: 1rem;
    }

    .alert-custom {
        background: rgba(220,38,38,0.07);
        border: 1.5px solid rgba(220,38,38,0.2);
        border-radius: 12px;
        color: #b91c1c;
        font-size: 0.88rem;
        font-weight: 600;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.5rem;
        max-width: 680px;
    }

    /* Form Card */
    .form-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid rgba(4,21,98,0.08);
        box-shadow: 0 4px 24px rgba(4,21,98,0.07);
        overflow: hidden;
        animation: fadeUp 0.45s ease both;
        max-width: 680px;
    }

    .form-card-header {
        background: var(--primary);
        padding: 1.25rem 1.75rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-card-header .header-icon {
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #fff;
        flex-shrink: 0;
    }

    .form-card-header h5 {
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        margin: 0 0 2px;
    }

    .form-card-header span {
        color: rgba(255,255,255,0.6);
        font-size: 0.78rem;
    }

    .form-card-body {
        padding: 1.5rem 1.75rem 2rem;
    }

    /* Search box */
    .search-wrap {
        position: relative;
        margin-bottom: 1rem;
    }

    .search-wrap i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.9rem;
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        padding: 10px 14px 10px 36px;
        border-radius: 10px;
        border: 1.5px solid rgba(4,21,98,0.12);
        background: #f5f7ff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.88rem;
        color: var(--text-main);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(4,21,98,0.08);
        background: #fff;
    }

    .search-input::placeholder { color: var(--text-muted); }

    /* Asesi List */
    .asesi-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 380px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .asesi-list::-webkit-scrollbar { width: 5px; }
    .asesi-list::-webkit-scrollbar-track { background: #f0f4ff; border-radius: 99px; }
    .asesi-list::-webkit-scrollbar-thumb { background: rgba(4,21,98,0.2); border-radius: 99px; }

    /* Hidden radio, styled label */
    .asesi-radio { display: none; }

    .asesi-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 13px 16px;
        border-radius: 12px;
        border: 1.5px solid rgba(4,21,98,0.08);
        background: #f8faff;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .asesi-item:hover {
        border-color: rgba(4,21,98,0.25);
        background: #eef2ff;
    }

    .asesi-radio:checked + .asesi-item {
        border-color: var(--primary);
        background: rgba(4,21,98,0.06);
        box-shadow: 0 0 0 3px rgba(4,21,98,0.08);
    }

    .asesi-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--primary-glow);
        border: 1.5px solid rgba(4,21,98,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: var(--primary);
        flex-shrink: 0;
        transition: background 0.2s;
    }

    .asesi-radio:checked + .asesi-item .asesi-avatar {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    .asesi-info { flex: 1; min-width: 0; }

    .asesi-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--text-main);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .asesi-nik {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-top: 2px;
    }

    .asesi-check {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid rgba(4,21,98,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s;
    }

    .asesi-radio:checked + .asesi-item .asesi-check {
        background: var(--primary);
        border-color: var(--primary);
    }

    .asesi-radio:checked + .asesi-item .asesi-check::after {
        content: '';
        width: 8px;
        height: 8px;
        background: #fff;
        border-radius: 50%;
    }

    .empty-search {
        text-align: center;
        padding: 2rem 0;
        color: var(--text-muted);
        font-size: 0.85rem;
        font-style: italic;
        display: none;
    }

    /* Submit */
    .btn-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px 28px;
        border-radius: 12px;
        background: var(--primary);
        color: #fff;
        font-weight: 700;
        font-size: 0.92rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: none;
        box-shadow: 0 4px 18px rgba(4,21,98,0.25);
        cursor: pointer;
        transition: all 0.25s ease;
        margin-top: 1.25rem;
    }

    .btn-submit:hover {
        background: var(--primary-light);
        box-shadow: 0 6px 24px rgba(4,21,98,0.35);
        transform: translateY(-2px);
    }

    .btn-submit:disabled {
        opacity: 0.45;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-submit i { transition: transform 0.2s ease; }
    .btn-submit:hover:not(:disabled) i { transform: translateX(3px); }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>


    <div class="container">
        <center>
        <div class="page-header">
            <span class="header-badge">Form Observasi</span>
            <h2>Pilih Asesi</h2>
            <p>Skema: <strong>{{ $skema->nama_skema }}</strong></p>
            <div class="header-divider"></div>
        </div>

        @if(session('error'))
            <div class="alert-custom">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
                <button type="button" onclick="this.parentElement.remove()"
                        style="margin-left:auto;background:none;border:none;color:#b91c1c;cursor:pointer;font-size:1rem;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        <div class="form-card">
            <div class="form-card-header">
                <div class="header-icon">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div>
                    <h5>Pilih Asesi</h5>
                    <span>{{ count($asesi) }} asesi tersedia</span>
                </div>
            </div>

            <div class="form-card-body">
                <form method="GET" action="{{ route('ceklisobservasi.index') }}">
                    <input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">

                    {{-- Search --}}
                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text"
                               id="searchAsesi"
                               class="search-input"
                               placeholder="Cari nama asesi"
                               autocomplete="off">
                    </div>

                    {{-- List --}}
                    <div class="asesi-list" id="asesiList">
                        @foreach($asesi as $a)
                            <div class="asesi-list-item" data-name="{{ strtolower($a->nama_lengkap) }}" data-nik="{{ $a->nik }}">
                                <input class="asesi-radio"
                                       type="radio"
                                       name="id_asesi"
                                       id="asesi_{{ $a->id_asesi }}"
                                       value="{{ $a->id_asesi }}"
                                       required
                                       onchange="document.getElementById('btnLanjut').disabled = false;">
                                <label class="asesi-item" for="asesi_{{ $a->id_asesi }}">
                                    <div class="asesi-avatar">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div class="asesi-info">
                                        <div class="asesi-name">{{ $a->nama_lengkap }}</div>
                                        <div class="asesi-nik">NIK: {{ $a->nik }}</div>
                                    </div>
                                    <div class="asesi-check"></div>
                                </label>
                            </div>
                        @endforeach

                        <div class="empty-search" id="emptySearch">
                            <i class="bi bi-search" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>
                            Tidak ada asesi yang cocok.
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="btnLanjut" disabled>
                        Lanjut ke Form Observasi <i class="bi bi-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
        </center>
    </div>
</div>

<script>
document.getElementById('searchAsesi').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    const items = document.querySelectorAll('.asesi-list-item');
    let found = 0;

    items.forEach(item => {
        const name = item.dataset.name;
        const match = name.includes(q);
        item.style.display = match ? '' : 'none';
        if (match) found++;
    });

    document.getElementById('emptySearch').style.display = found === 0 ? 'block' : 'none';
});
</script>

@endsection