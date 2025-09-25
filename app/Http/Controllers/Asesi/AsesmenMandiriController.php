<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request)
    {
        $user = Auth::user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        $permohonan = DB::table('permohonan')
            ->where('id_asesi', $asesi->id_asesi)
            ->latest('id_permohonan')
            ->first();

        if (!$permohonan) {
            return redirect()->route('asesi.permohonan.form1')
                ->with('error', 'Anda belum mengajukan permohonan.');
        }

        $asesmen = DB::table('asesmen_mandiri_master')
            ->where('id_permohonan', $permohonan->id_permohonan)
            ->first();

        if (!$asesmen) {
            $idAsesmen = DB::table('asesmen_mandiri_master')->insertGetId([
                'id_permohonan' => $permohonan->id_permohonan,
                'id_asesi'      => $asesi->id_asesi,
                'id_asesor'     => null,
                'rekomendasi'   => null,
            ]);
        } else {
            $idAsesmen = $asesmen->id_asesmen_mandiri;
        }

        $jawabanKuk = $request->input('kuk', []);
        $dokumenKuk = $request->input('bukti', []);

        foreach ($jawabanKuk as $id_kuk => $status) {
            DB::table('asesmen_mandiri_jawaban')->updateOrInsert(
                [
                    'id_asesmen_mandiri' => $idAsesmen,
                    'id_kuk'             => $id_kuk,
                ],
                [
                    'status'     => $status,
                    'id_dokumen' => $dokumenKuk[$id_kuk] ?? null,
                ]
            );
        }

        return redirect()->route('asesi.asesmen_mandiri.form3')
            ->with('success', 'Jawaban berhasil disimpan.');
    }

    public function form3()
    {
        return view('asesi.asesmen_mandiri.form3');
    }

    public function storeTTD(Request $request)
    {
        $user = Auth::user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        $asesmen = DB::table('asesmen_mandiri_master')
            ->where('id_asesi', $asesi->id_asesi)
            ->latest('id_asesmen_mandiri')
            ->first();

        if (!$asesmen) {
            return redirect()->back()->with('error', 'Data asesmen mandiri belum ada.');
        }

        $data = $request->ttd_asesi;
        $image = str_replace('data:image/png;base64,', '', $data);
        $image = str_replace(' ', '+', $image);
        $imageName = 'ttd_asesi_' . time() . '.png';

        Storage::disk('public')->put('ttd/' . $imageName, base64_decode($image));

        DB::table('asesmen_mandiri_persetujuan')->updateOrInsert(
            ['id_asesmen_mandiri' => $asesmen->id_asesmen_mandiri],
            [
                'tgl_ttd_asesi' => $request->tgl_ttd_asesi,
                'ttd_asesi'     => 'ttd/' . $imageName,
            ]
        );

        return redirect()->route('asesi.asesmen_mandiri.form4')
            ->with('success', 'Tanda tangan berhasil disimpan.');
    }
}
