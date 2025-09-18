<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Form1AdminController extends Controller
{
    /**
     * Tampilkan daftar semua Form1 (FR.APL.01) yang sudah diisi Asesi.
     */
    public function index()
    {
        $asesi = DB::table('asesi')
            ->select(
                'id_asesi',
                'nama_lengkap',
                'nik',
                'email',
                'telepon',
                'updated_at'
            )
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.permohonan.index', compact('asesi'));
    }

    public function show($id_asesi)
    {
        $asesi = DB::table('asesi')->where('id_asesi', $id_asesi)->first();
        if (!$asesi) {
            abort(404, 'Data Asesi tidak ditemukan');
        }

        $permohonan = DB::table('permohonan')
            ->where('id_asesi', $id_asesi)
            ->orderBy('tgl_permohonan', 'desc')
            ->first();

        if (!$permohonan) {
            return view('admin.permohonan.no-permohonan', compact('asesi'));
        }

        $skema = null;
        $units = collect();

        if ($permohonan->id_skema) {
            $skema = DB::table('skema_sertifikasi')
                ->where('id_skema', $permohonan->id_skema)
                ->first();

            $units = DB::table('unit_kompetensi')
                ->join('skema_unit', 'unit_kompetensi.id_unit', '=', 'skema_unit.unit_id')
                ->where('skema_unit.skema_id', $permohonan->id_skema)
                ->select('unit_kompetensi.kode_unit', 'unit_kompetensi.judul_unit', 'unit_kompetensi.standar_kompetensi')
                ->get();
        }

        $tuk = DB::table('tuk')->first();

        return view('admin.permohonan.show', compact('asesi', 'permohonan', 'skema', 'units', 'tuk'));
    }


}
