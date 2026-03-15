<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BandingAsesmen;
use Barryvdh\DomPDF\Facade\Pdf; // tambahkan ini

class BandingAsesmenController extends Controller
{
    /**
     * Menampilkan daftar semua banding.
     */
    public function index()
    {
        $bandings = BandingAsesmen::with([
            'permohonan.skema',
            'asesi.user',
            'persetujuan'
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('admin.banding_asesmen.index', compact('bandings'));
    }

    /**
     * Menampilkan detail banding tertentu.
     */
    public function show($id)
    {
        $banding = BandingAsesmen::with([
            'permohonan.skema',
            'permohonan.asesi.asesor.user', // asesor melalui asesi
            'asesi.user',
            'persetujuan'
        ])->findOrFail($id);

        return view('admin.banding_asesmen.show', compact('banding'));
    }

    /**
     * Download PDF banding.
     */
    public function downloadPdf($id)
{
    $banding = BandingAsesmen::with([
        'permohonan.skema',
        'permohonan.asesi.asesor.user',
        'asesi.user',
        'persetujuan'
    ])->findOrFail($id);

    // Pastikan view yang dipanggil adalah untuk banding, bukan penyesuaian
    $pdf = Pdf::loadView('admin.banding_asesmen.pdf', compact('banding'));
    return $pdf->download('FR.AK.04_Banding_'.$banding->id_banding.'.pdf');
}
}