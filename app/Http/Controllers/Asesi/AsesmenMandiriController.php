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
            ->join('skema_sertifikasi', 'permohonan.skema_id', '=', 'skema_sertifikasi.id_skema')
            ->where('permohonan.asesi_id', $asesi->id_asesi)
            ->select(
                'permohonan.id_permohonan',
                'permohonan.skema_id',
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
            ->join('skema_sertifikasi', 'permohonan.skema_id', '=', 'skema_sertifikasi.id_skema')
            ->where('permohonan.asesi_id', $asesi->id_asesi ?? 0)
            ->select(
                'permohonan.id_permohonan',
                'permohonan.skema_id',
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
            ->where('id_skema', $permohonan->skema_id)
            ->get();

        $elemen = DB::table('elemen_kompetensi')
            ->whereIn('id_unit', $units->pluck('id_unit')->toArray())
            ->select('id_elemen', 'id_unit', 'nama_elemen as judul_elemen')
            ->get();

        $kuk = DB::table('kuk')
            ->whereIn('id_elemen', $elemen->pluck('id_elemen')->toArray())
            ->get();

        // <-- Perbaikan utama: pakai nama kolom yang benar path_file & nama_file
        $dokumen = DB::table('dokumen_persyaratan')
            ->join('jenis_dokumen', 'dokumen_persyaratan.jenis_dokumen_id', '=', 'jenis_dokumen.id_jenis_dokumen')
            ->where('dokumen_persyaratan.permohonan_id', $permohonan->id_permohonan)
            ->whereIn('dokumen_persyaratan.jenis_dokumen_id', [1, 2])
            ->select(
                'dokumen_persyaratan.id_dokumen',
                'dokumen_persyaratan.path_file as file_path',
                'dokumen_persyaratan.nama_file',
                'jenis_dokumen.nama_dokumen as nama_jenis'
            )
            ->get();

        $asesmen = DB::table('asesmen_mandiri_master')
            ->where('id_permohonan', $permohonan->id_permohonan)
            ->first();

        $jawaban = [];
        if ($asesmen) {
            $jawaban = DB::table('asesmen_mandiri_jawaban')
                ->where('id_asesmen_mandiri', $asesmen->id_asesmen_mandiri)
                ->get()
                ->keyBy('id_kuk');
        }

        return view(
            'asesi.asesmen_mandiri.form2',
            compact('permohonan', 'units', 'elemen', 'kuk', 'dokumen', 'jawaban')
        );
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        $permohonan = DB::table('permohonan')
            ->where('asesi_id', $asesi->id_asesi)
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
                'id_asesi' => $asesi->id_asesi,
                'id_asesor' => null,
                'rekomendasi' => null,
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
                    'id_kuk' => $id_kuk,
                ],
                [
                    'status' => $status,
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
        $image = str_replace(['data:image/png;base64,', ' '], ['', '+'], $data);
        $imageName = 'ttd_asesi_' . time() . '.png';

        Storage::disk('public')->put('ttd/' . $imageName, base64_decode($image));

        DB::table('asesmen_mandiri_persetujuan')->updateOrInsert(
            ['id_asesmen_mandiri' => $asesmen->id_asesmen_mandiri],
            [
                'tgl_ttd_asesi' => $request->tgl_ttd_asesi,
                'ttd_asesi' => 'ttd/' . $imageName,
            ]
        );

        return redirect()->route('form_pra_assesmen')
            ->with('success', 'Tanda tangan berhasil disimpan.');
    }
}