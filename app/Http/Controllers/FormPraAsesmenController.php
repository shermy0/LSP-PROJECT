<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use App\Models\Asesi;
use App\Models\DokumenPersyaratan; // pastikan model ini ada
use Illuminate\Support\Facades\DB;

class FormPraAsesmenController extends Controller
{
    public function index()
    {
        // cari data asesi berdasarkan user yang login
        $asesi = Asesi::where('user_id', Auth::id())->first();

        // default nilai
        $permohonan = null;
        $asesmenMandiri = null;
        $dokumenTidakMemenuhi = collect(); // default kosong

        if ($asesi) {
            // ambil permohonan terbaru untuk asesi ini
            $permohonan = Permohonan::where('id_asesi', $asesi->id_asesi)
                ->latest('created_at')
                ->first();

            if ($permohonan) {
                // cek apakah sudah ada asesmen mandiri untuk permohonan ini
                $asesmenMandiri = DB::table('asesmen_mandiri_master')
                    ->where('id_permohonan', $permohonan->id_permohonan)
                    ->where('id_asesi', $permohonan->id_asesi)
                    ->first();

                // kalau status permohonan ditolak, ambil dokumen yang tidak memenuhi syarat
                if ($permohonan->status === 'Ditolak') {
                    $dokumenTidakMemenuhi = DokumenPersyaratan::with('jenis')
                        ->where('id_permohonan', $permohonan->id_permohonan)
                        ->where('memenuhi_syarat', 0)
                        ->get();
                }
            }
        }

        return view('form_pra_assesmen', compact(
            'permohonan',
            'asesmenMandiri',
            'dokumenTidakMemenuhi'
        ));
    }
}
