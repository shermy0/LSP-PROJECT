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

    .asesi-wrapper {
        min-height: 100vh;
        background: linear-gradient(160deg, #eef2ff 0%, #f8faff 50%, #e8eeff 100%);
        padding: 3.5rem 0 5rem;
        position: relative;
        overflow: hidden;
    }

    .asesi-wrapper::before {
        content: '';
        position: absolute;
        top: -140px; right: -140px;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(4,21,98,0.07) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .asesi-wrapper::after {
        content: '';
        position: absolute;
        bottom: -100px; left: -100px;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(4,21,98,0.05) 0%, transparent 70%);
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
    }

    .btn-back:hover {
        background: var(--primary);
        color: #fff;
        transform: translateX(-3px);
    }

    /* Page Header */
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

    /* Table Card */
    .table-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid rgba(4,21,98,0.08);
        box-shadow: 0 4px 24px rgba(4,21,98,0.07);
        overflow: hidden;
        animation: fadeUp 0.45s ease both;
    }

    .table-card-header {
        background: var(--primary);
        padding: 1.25rem 1.75rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-card-header .header-icon {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #fff;
        flex-shrink: 0;
    }

    .table-card-header h5 {
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
        line-height: 1.3;
    }

    .table-card-header span {
        color: rgba(255,255,255,0.65);
        font-size: 0.78rem;
        font-weight: 500;
    }

    /* Table */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    .custom-table thead tr {
        background: #f5f7ff;
        border-bottom: 2px solid rgba(4,21,98,0.08);
    }

    .custom-table thead th {
        padding: 13px 18px;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--text-muted);
        white-space: nowrap;
    }

    .custom-table tbody tr {
        border-bottom: 1px solid rgba(4,21,98,0.06);
        transition: background 0.18s ease;
    }

    .custom-table tbody tr:last-child {
        border-bottom: none;
    }

    .custom-table tbody tr:hover {
        background: #f5f7ff;
    }

    .custom-table tbody td {
        padding: 14px 18px;
        color: var(--text-main);
        vertical-align: middle;
    }

    .row-number {
        width: 36px;
        height: 36px;
        background: var(--primary-glow);
        color: var(--primary);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .asesi-name {
        font-weight: 600;
        color: var(--text-main);
    }

    /* Status badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .status-selesai {
        background: rgba(22, 163, 74, 0.1);
        color: #15803d;
        border: 1px solid rgba(22,163,74,0.2);
    }

    .status-belum {
        background: rgba(217, 119, 6, 0.1);
        color: #b45309;
        border: 1px solid rgba(217,119,6,0.2);
    }

    /* Progress pill */
    .progress-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.85rem;
    }

    .progress-pill .progress-bar-wrap {
        width: 70px;
        height: 6px;
        background: rgba(4,21,98,0.1);
        border-radius: 99px;
        overflow: hidden;
    }

    .progress-pill .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), #1a3fbf);
        border-radius: 99px;
        transition: width 0.4s ease;
    }

    /* Action button */
    .btn-lihat {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.8rem;
        text-decoration: none;
        background: var(--primary);
        color: #fff;
        border: none;
        box-shadow: 0 3px 12px rgba(4,21,98,0.2);
        transition: all 0.22s ease;
        white-space: nowrap;
    }

    .btn-lihat:hover {
        background: var(--primary-light);
        color: #fff;
        box-shadow: 0 5px 18px rgba(4,21,98,0.3);
        transform: translateY(-1px);
    }

    .no-jawaban {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--text-muted);
        font-size: 0.82rem;
        font-style: italic;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-glow);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: var(--primary);
        margin: 0 auto 1.5rem;
    }

    .empty-state h5 {
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.4rem;
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .review-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        width:32px;
        height:32px;
        border-radius:8px;
        background:#dcfce7;
        color:#15803d;
        font-size:16px;
        margin-left:6px;
    }

    .review-belum{
        background:#fee2e2;
        color:#b91c1c;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

    <div class="container">

        <div class="mb-4">
            <a href="{{ route('asesor.skema.jenis', $id_skema) }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <center>
        <div class="page-header">
            <span class="header-badge">Daftar Asesi</span>
            <h2>{{ $skema->nama_skema }}</h2>
            <p>Jenis Asesmen: <strong>{{ ucwords(str_replace('_',' ',$jenisDb)) }}</strong></p>
            <div class="header-divider"></div>
        </div>
        </center>

        <div class="table-card">
            <div class="table-card-header">
                <div class="header-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h5>Data Asesi</h5>
                    <span>{{ count($dataAsesi) }} asesi terdaftar</span>
                </div>
            </div>

            @if(count($dataAsesi) > 0)
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Asesi</th>
                                <th>Status Asesmen</th>
                                <th>Jawaban / Soal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataAsesi as $item)
                                <tr>
                                    <td>
                                        <div class="row-number">{{ $loop->iteration }}</div>
                                    </td>
                                    <td>
                                        <span class="asesi-name">{{ $item['nama'] }}</span>
                                    </td>
                                    <td>
                                        @if($item['status'] == 'selesai')
                                            <span class="status-badge status-selesai">
                                                <i class="bi bi-check-circle-fill"></i> Selesai
                                            </span>
                                        @else
                                            <span class="status-badge status-belum">
                                                <i class="bi bi-clock-fill"></i> Belum Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $pct = $item['jumlah_pertanyaan'] > 0
                                                ? ($item['jumlah_jawaban'] / $item['jumlah_pertanyaan']) * 100
                                                : 0;
                                        @endphp
                                        <div class="progress-pill">
                                            <div class="progress-bar-wrap">
                                                <div class="progress-bar-fill" style="width: {{ $pct }}%"></div>
                                            </div>
                                            {{ $item['jumlah_jawaban'] }} / {{ $item['jumlah_pertanyaan'] }}
                                        </div>
                                    </td>
                                    <td style="display:flex;align-items:center;gap:6px;">
                                        @if($item['jumlah_jawaban'] > 0)
                                            <a href="{{ route('asesor.skema.jenis.asesi.jawaban', [$id_skema, $jenis, $item['id_asesi']]) }}" class="btn-lihat">
                                                <i class="bi bi-eye"></i> Lihat Jawaban
                                            </a>
                                            @if($item['reviewed'])
                                                <span class="review-badge" title="Sudah direview asesor">
                                                    <i class="bi bi-check-lg"></i>
                                                </span>
                                            @else
                                                <span class="review-badge review-belum" title="Belum direview">
                                                    <i class="bi bi-x-lg"></i>
                                                </span>
                                            @endif
                                        @else
                                            <span class="no-jawaban">
                                                <i class="bi bi-dash-circle"></i> Belum ada jawaban
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-person-x"></i>
                    </div>
                    <h5>Tidak Ada Asesi</h5>
                    <p>Tidak ada asesi yang terdaftar di bawah Anda untuk skema ini.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection