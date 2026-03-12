@extends('master')

@section('konten')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #041562;
        --primary-light: #0a2a9e;
        --primary-glow: rgba(4, 21, 98, 0.15);
        --accent-gold: #e8b84b;
        --accent-green: #1a9e6e;
        --accent-amber: #d97706;
        --surface: #f0f4ff;
        --card-bg: #ffffff;
        --text-main: #0d1b4b;
        --text-muted: #6b7fb5;
    }

    body, .container {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .container{
        margin: 50px auto;
    }

    .asesmen-wrapper {
        min-height: 100vh;
        background: linear-gradient(160deg, #eef2ff 0%, #f8faff 50%, #e8eeff 100%);
        padding: 3rem 0 5rem;
        position: relative;
        overflow: hidden;
    }

    .asesmen-wrapper::before {
        content: '';
        position: absolute;
        top: -120px;
        right: -120px;
        width: 420px;
        height: 420px;
        background: radial-gradient(circle, rgba(4,21,98,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .asesmen-wrapper::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(4,21,98,0.06) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        border: 2px solid var(--primary);
        color: var(--primary);
        background: transparent;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.25s ease;
        letter-spacing: 0.3px;
    }

    .btn-back:hover {
        background: var(--primary);
        color: #fff;
        transform: translateX(-3px);
    }

    /* Header Section */
    .page-header {
        text-align: center;
        margin-bottom: 3.5rem;
        position: relative;
    }

    .header-badge {
        display: inline-block;
        background: var(--primary-glow);
        color: var(--primary);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 1rem;
        border: 1px solid rgba(4,21,98,0.2);
    }

    .page-header h2 {
        font-size: 2.1rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.6rem;
        line-height: 1.2;
    }

    .page-header p {
        color: var(--text-muted);
        font-size: 1rem;
        font-weight: 500;
    }

    .header-divider {
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--accent-gold));
        border-radius: 4px;
        margin: 1.2rem auto 0;
    }

    /* Cards */
    .asesmen-card {
        background: var(--card-bg);
        border-radius: 20px;
        border: 1.5px solid rgba(4,21,98,0.08);
        box-shadow: 0 4px 24px rgba(4,21,98,0.07);
        padding: 2.5rem 2rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .asesmen-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        border-radius: 20px 20px 0 0;
        transition: height 0.3s ease;
    }

    .card-pg::before  { background: linear-gradient(90deg, var(--primary), #1a3fbf); }
    .card-esai::before { background: linear-gradient(90deg, var(--accent-green), #0d7a56); }
    .card-lisan::before { background: linear-gradient(90deg, var(--accent-amber), #b45309); }

    .asesmen-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(4,21,98,0.13);
        border-color: rgba(4,21,98,0.18);
    }

    .asesmen-card:hover::before {
        height: 6px;
    }

    /* Icon wrapper */
    .icon-wrap {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        transition: transform 0.3s ease;
    }

    .asesmen-card:hover .icon-wrap {
        transform: scale(1.1) rotate(-3deg);
    }

    .icon-pg    { background: rgba(4,21,98,0.08);    color: var(--primary); }
    .icon-esai  { background: rgba(26,158,110,0.10); color: var(--accent-green); }
    .icon-lisan { background: rgba(217,119,6,0.10);  color: var(--accent-amber); }

    .card-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }

    .card-desc {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 1.8rem;
        line-height: 1.5;
    }

    /* CTA Buttons */
    .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 26px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.88rem;
        text-decoration: none;
        letter-spacing: 0.3px;
        transition: all 0.25s ease;
        border: none;
    }

    .btn-cta-pg {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 4px 16px rgba(4,21,98,0.25);
    }

    .btn-cta-pg:hover {
        background: var(--primary-light);
        color: #fff;
        box-shadow: 0 6px 20px rgba(4,21,98,0.35);
        transform: translateY(-1px);
    }

    .btn-cta-esai {
        background: var(--accent-green);
        color: #fff;
        box-shadow: 0 4px 16px rgba(26,158,110,0.25);
    }

    .btn-cta-esai:hover {
        background: #0d7a56;
        color: #fff;
        box-shadow: 0 6px 20px rgba(26,158,110,0.35);
        transform: translateY(-1px);
    }

    .btn-cta-lisan {
        background: var(--accent-amber);
        color: #fff;
        box-shadow: 0 4px 16px rgba(217,119,6,0.25);
    }

    .btn-cta-lisan:hover {
        background: #b45309;
        color: #fff;
        box-shadow: 0 6px 20px rgba(217,119,6,0.35);
        transform: translateY(-1px);
    }

    /* Stagger animation */
    .col-card {
        animation: fadeUp 0.5s ease both;
    }
    .col-card:nth-child(1) { animation-delay: 0.1s; }
    .col-card:nth-child(2) { animation-delay: 0.22s; }
    .col-card:nth-child(3) { animation-delay: 0.34s; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>


    <div class="container">

        <div class="mb-4">
            <a href="{{ route('asesor.skema.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <center>
        <div class="page-header">
            <span class="header-badge">Asesmen Kompetensi</span>
            <h2>{{ $skema->nama_skema }}</h2>
            <p>Pilih jenis asesmen yang ingin diperiksa.</p>
            <div class="header-divider"></div>
        </div>
        </center>

        <div class="row justify-content-center g-4">

            <div class="col-md-4 col-sm-6 col-card">
                <div class="asesmen-card card-pg">
                    <div class="icon-wrap icon-pg">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div class="card-title">Pilihan Ganda</div>
                    <div class="card-desc">Asesmen berbasis soal pilihan ganda dengan penilaian otomatis.</div>
                    <a href="{{ route('asesor.skema.jenis.asesi', [$skema->id_skema, 'pilihan_ganda']) }}" class="btn-cta btn-cta-pg">
                        Lihat Asesi <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-card">
                <div class="asesmen-card card-esai">
                    <div class="icon-wrap icon-esai">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div class="card-title">Esai</div>
                    <div class="card-desc">Asesmen berbasis jawaban tertulis yang dinilai secara kualitatif.</div>
                    <a href="{{ route('asesor.skema.jenis.asesi', [$skema->id_skema, 'esai']) }}" class="btn-cta btn-cta-esai">
                        Lihat Asesi <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-card">
                <div class="asesmen-card card-lisan">
                    <div class="icon-wrap icon-lisan">
                        <i class="bi bi-person-video3"></i>
                    </div>
                    <div class="card-title">Lisan</div>
                    <div class="card-desc">Asesmen berbasis wawancara atau presentasi secara langsung.</div>
                    <a href="{{ route('asesor.skema.jenis.asesi', [$skema->id_skema, 'lisan']) }}" class="btn-cta btn-cta-lisan">
                        Lihat Asesi <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection