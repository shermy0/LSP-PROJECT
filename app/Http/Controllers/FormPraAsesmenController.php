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
        // ✅ Ambil data asesi yang sedang login
        $asesi = Asesi::where('user_id', Auth::id())->first();

        // Inisialisasi default variabel agar tidak undefined
        $permohonan = null;
        $asesmenMandiri = null;
        $dokumenTidakMemenuhi = collect();

        if ($asesi) {
            // ✅ Ambil permohonan terbaru berdasarkan relasi atau langsung query
            $permohonan = $asesi->permohonan()->latest('created_at')->first();

            if ($permohonan) {
                // ✅ Ambil data asesmen mandiri (join master + persetujuan)
                $asesmenMandiri = DB::table('asesmen_mandiri_master as amm')
                    ->leftJoin('asesmen_mandiri_persetujuan as amp', 'amm.id_asesmen_mandiri', '=', 'amp.id_asesmen_mandiri')
                    ->select(
                        'amm.*',
                        'amm.rekomendasi',               // hasil verifikasi asesor
                        'amp.status_persetujuan',        // tanda tangan asesmen mandiri
                        'amp.catatan',
                        'amp.tgl_ttd_asesor',
                        'amp.tgl_ttd_asesi',
                        'amp.ttd_asesor',
                        'amp.ttd_asesi'
                    )
                    ->where('amm.permohonan_id', $permohonan->id_permohonan)
                    ->where('amm.asesi_id', $asesi->id_asesi)
                    ->first();

                // ✅ Jika permohonan ditolak, ambil dokumen yang tidak memenuhi
                if ($permohonan->status === 'Ditolak') {
                    $dokumenTidakMemenuhi = DokumenPersyaratan::with('jenis')
                        ->where('permohonan_id', $permohonan->id_permohonan)
                        ->where('memenuhi_syarat', false)
                        ->get();
                }
            }
        }

        // ✅ Kembalikan ke view
        return view('form_pra_assesmen', compact(
            'permohonan',
            'asesmenMandiri',
            'dokumenTidakMemenuhi'
        ));
    }
}
