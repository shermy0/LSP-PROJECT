<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use App\Models\Asesi;
use App\Models\DokumenPersyaratan;
use App\Models\PenyesuaianWajar;
use App\Models\BandingAsesmen; // tambahkan
use Illuminate\Support\Facades\DB;

class FormPraAsesmenController extends Controller
{
    public function index()
    {
        $asesi = Asesi::where('user_id', Auth::id())->first();

        $permohonan = null;
        $asesmenMandiri = null;
        $dokumenTidakMemenuhi = collect();
        $penyesuaianWajar = null;
        $persetujuan = null;
        $banding = null; // tambahkan

        if ($asesi) {
            $permohonan = $asesi->permohonan()->latest('created_at')->first();

            if ($permohonan) {
                $permohonan->load('persetujuan');
                $persetujuan = $permohonan->persetujuan;

                $asesmenMandiri = DB::table('asesmen_mandiri_master as amm')
                    ->leftJoin('asesmen_mandiri_persetujuan as amp', 'amm.id_asesmen_mandiri', '=', 'amp.id_asesmen_mandiri')
                    ->select(
                        'amm.*',
                        'amm.rekomendasi',
                        'amp.status_persetujuan',
                        'amp.catatan',
                        'amp.tgl_ttd_asesor',
                        'amp.tgl_ttd_asesi',
                        'amp.ttd_asesor',
                        'amp.ttd_asesi'
                    )
                    ->where('amm.id_permohonan', $permohonan->id_permohonan)
                    ->where('amm.id_asesi', $asesi->id_asesi)
                    ->first();

                $penyesuaianWajar = PenyesuaianWajar::where('id_permohonan', $permohonan->id_permohonan)->first();

                // Ambil data banding jika ada
                $banding = BandingAsesmen::where('id_permohonan', $permohonan->id_permohonan)->first();

                if ($permohonan->status === 'Ditolak') {
                    $dokumenTidakMemenuhi = DokumenPersyaratan::with('jenisDokumen')
                        ->where('id_permohonan', $permohonan->id_permohonan)
                        ->where('memenuhi_syarat', false)
                        ->get();
                }
            }
        }

        return view('form_pra_assesmen', compact(
            'permohonan',
            'asesmenMandiri',
            'dokumenTidakMemenuhi',
            'penyesuaianWajar',
            'persetujuan',
            'banding' // kirim ke view
        ));
    }
}