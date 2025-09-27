<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use App\Models\Asesi;
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

        if ($asesi) {
            // ambil permohonan terbaru untuk asesi ini
            $permohonan = Permohonan::where('id_asesi', $asesi->id_asesi)
                ->latest('created_at')
                ->first();

            // cek apakah sudah ada asesmen mandiri untuk permohonan ini
            if ($permohonan) {
                $asesmenMandiri = DB::table('asesmen_mandiri_master')
                    ->where('id_permohonan', $permohonan->id_permohonan)
                    ->where('id_asesi', $permohonan->id_asesi)
                    ->first();
            }
        }

        return view('asesi.form_pra_asesmen', compact('permohonan', 'asesmenMandiri'));
    }
}
