<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsesmenMandiriController extends Controller
{
    public function form1()
    {
        $user = Auth::user();

        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();
        if (!$asesi) {
            return redirect()->route('asesi.permohonan.form1')
                ->with('error', 'Data asesi tidak ditemukan, lengkapi permohonan terlebih dahulu.');
        }

        $permohonan = DB::table('permohonan')
            ->join('skema_sertifikasi', 'permohonan.id_skema', '=', 'skema_sertifikasi.id_skema')
            ->where('permohonan.id_asesi', $asesi->id_asesi)
            ->select(
                'permohonan.id_permohonan',
                'permohonan.id_skema',
                'skema_sertifikasi.nama_skema as skema',
                'skema_sertifikasi.kode_skema',
                'skema_sertifikasi.judul_skema'
            )
            ->latest('permohonan.id_permohonan')
            ->first();

        return view('asesi.asesmen_mandiri.form1', compact('permohonan'));
    }

    public function form2()
    {
        $user = Auth::user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        $permohonan = DB::table('permohonan')
            ->join('skema_sertifikasi', 'permohonan.id_skema', '=', 'skema_sertifikasi.id_skema')
            ->where('id_asesi', $asesi->id_asesi ?? 0)
            ->select(
                'permohonan.id_permohonan',
                'permohonan.id_skema',
                'skema_sertifikasi.nama_skema',
                'skema_sertifikasi.kode_skema',
                'skema_sertifikasi.judul_skema'
            )
            ->latest('id_permohonan')
            ->first();

        if (!$permohonan) {
            return redirect()->route('asesi.permohonan.form1')
                ->with('error', 'Anda belum mengajukan permohonan.');
        }

        // unit + elemen + kuk
        $units = DB::table('unit_kompetensi')
            ->where('id_skema', $permohonan->id_skema)
            ->get();

        $elemen = DB::table('elemen_kompetensi')
            ->whereIn('id_unit', $units->pluck('id_unit'))
            ->select('id_elemen', 'id_unit', 'nama_elemen as judul_elemen')
            ->get();

        $kuk = DB::table('kuk')
            ->whereIn('id_elemen', $elemen->pluck('id_elemen'))
            ->get();

        // dokumen yang sudah diupload, filter hanya jenis 1 & 2
        $dokumen = DB::table('dokumen_persyaratan')
            ->join('jenis_dokumen', 'dokumen_persyaratan.id_jenis_dokumen', '=', 'jenis_dokumen.id_jenis_dokumen')
            ->where('dokumen_persyaratan.id_permohonan', $permohonan->id_permohonan)
            ->whereIn('dokumen_persyaratan.id_jenis_dokumen', [1, 2])
            ->select(
                'dokumen_persyaratan.id_dokumen',
                'dokumen_persyaratan.file_path',
                'jenis_dokumen.nama_jenis'
            )
            ->get();

        return view('asesi.asesmen_mandiri.form2', compact('permohonan', 'units', 'elemen', 'kuk', 'dokumen'));
    }

    public function form3()
    {
        return view('asesi.asesmen_mandiri.form3');
    }

    public function form4()
    {
        return view('asesi.asesmen_mandiri.form4');
    }
}
