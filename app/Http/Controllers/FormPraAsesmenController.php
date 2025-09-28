<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use App\Models\Asesi;
use App\Models\DokumenPersyaratan;
use Illuminate\Support\Facades\DB;

class FormPraAsesmenController extends Controller
{
    public function index()
    {
        $asesi = Asesi::where('user_id', Auth::id())->first();

        $permohonan = null;
        $asesmenMandiri = null;
        $dokumenTidakMemenuhi = collect();

        if ($asesi) {
            $permohonan = Permohonan::where('id_asesi', $asesi->id_asesi)
                ->latest('created_at')
                ->first();

            if ($permohonan) {
                // join master + persetujuan
                $asesmenMandiri = DB::table('asesmen_mandiri_master as amm')
                    ->leftJoin('asesmen_mandiri_persetujuan as amp', 'amm.id_asesmen_mandiri', '=', 'amp.id_asesmen_mandiri')
                    ->select(
                        'amm.*',
                        'amm.rekomendasi',               // hasil verifikasi asesor (dapat/tidak)
                        'amp.status_persetujuan',        // status tanda tangan (menunggu/diterima/ditolak)
                        'amp.catatan',
                        'amp.tgl_ttd_asesor',
                        'amp.tgl_ttd_asesi',
                        'amp.ttd_asesor',
                        'amp.ttd_asesi'
                    )
                    ->where('amm.id_permohonan', $permohonan->id_permohonan)
                    ->where('amm.id_asesi', $permohonan->id_asesi)
                    ->first();

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
