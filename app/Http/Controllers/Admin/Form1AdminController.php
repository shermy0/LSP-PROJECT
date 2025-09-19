<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Form1AdminController extends Controller
{
    public function index()
    {
        $asesi = DB::table('asesi')
            ->select('id_asesi', 'nama_lengkap', 'nik', 'email', 'telepon', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.permohonan.index', compact('asesi'));
    }

    public function show($id_asesi)
    {
        // Data Asesi
        $asesi = DB::table('asesi')->where('id_asesi', $id_asesi)->first();
        if (!$asesi) {
            abort(404, 'Data Asesi tidak ditemukan');
        }

        // Permohonan terbaru
        $permohonan = DB::table('permohonan')
            ->where('id_asesi', $id_asesi)
            ->orderBy('tgl_permohonan', 'desc')
            ->first();

        if (!$permohonan) {
            return view('admin.permohonan.no-permohonan', compact('asesi'));
        }

        // Skema & unit
        $skema = null;
        $units = collect();
        if ($permohonan->id_skema) {
            $skema = DB::table('skema_sertifikasi')
                ->where('id_skema', $permohonan->id_skema)
                ->first();

            $units = DB::table('unit_kompetensi')
                ->where('id_skema', $permohonan->id_skema)
                ->select('kode_unit', 'judul_unit', 'standar_kompetensi')
                ->get();
        }

        // Data TUK (pekerjaan/institusi)
        $tuk = null;
        if (isset($permohonan->id_tuk)) {
            $tuk = DB::table('tuk')->where('id_tuk', $permohonan->id_tuk)->first();
        } else {
            $tuk = DB::table('tuk')->first(); // fallback
        }

        // Dokumen persyaratan
        $dokumen = DB::table('dokumen_persyaratan')
            ->join('jenis_dokumen', 'dokumen_persyaratan.id_jenis_dokumen', '=', 'jenis_dokumen.id_jenis_dokumen')
            ->where('dokumen_persyaratan.id_permohonan', $permohonan->id_permohonan)
            ->select(
                'dokumen_persyaratan.id_dokumen',
                'dokumen_persyaratan.file_path',
                'jenis_dokumen.nama_jenis as jenis'
            )
            ->get();

        // Persetujuan
        $persetujuan = DB::table('permohonan_persetujuan')
            ->where('id_permohonan', $permohonan->id_permohonan)
            ->first();

        return view('admin.permohonan.show', compact(
            'asesi',
            'permohonan',
            'skema',
            'units',
            'dokumen',
            'persetujuan',
            'tuk'
        ));
    }
}
