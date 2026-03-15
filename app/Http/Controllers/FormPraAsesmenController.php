<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use App\Models\Asesi;
use App\Models\DokumenPersyaratan;
use App\Models\PenyesuaianWajar; // tambahkan
use Illuminate\Support\Facades\DB;

class FormPraAsesmenController extends Controller
{
    public function index()
    {
        // Ambil data asesi yang sedang login
        $asesi = Asesi::where('user_id', Auth::id())->first();

        // Inisialisasi default variabel agar tidak undefined
        $permohonan = null;
        $asesmenMandiri = null;
        $dokumenTidakMemenuhi = collect();
        $penyesuaianWajar = null; // tambahkan
        $persetujuan = null;       // tambahkan

        if ($asesi) {
            // Ambil permohonan terbaru
            $permohonan = $asesi->permohonan()->latest('created_at')->first();

            if ($permohonan) {
                // Muat relasi persetujuan (jika ada)
                $permohonan->load('persetujuan');
                $persetujuan = $permohonan->persetujuan;

                // Ambil data asesmen mandiri
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

                // Ambil data penyesuaian wajar berdasarkan id_permohonan
                $penyesuaianWajar = PenyesuaianWajar::where('id_permohonan', $permohonan->id_permohonan)->first();

                // Jika permohonan ditolak, ambil dokumen yang tidak memenuhi
                if ($permohonan->status === 'Ditolak') {
                    $dokumenTidakMemenuhi = DokumenPersyaratan::with('jenisDokumen')
                        ->where('id_permohonan', $permohonan->id_permohonan)
                        ->where('memenuhi_syarat', false)
                        ->get();
                }
            }
        }

        // Kembalikan ke view dengan semua variabel
        return view('form_pra_assesmen', compact(
            'permohonan',
            'asesmenMandiri',
            'dokumenTidakMemenuhi',
            'penyesuaianWajar',
            'persetujuan'
        ));
    }
}