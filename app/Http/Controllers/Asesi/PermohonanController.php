<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\TujuanAsesmen;
use Throwable;

class PermohonanController extends Controller
{
    /**
     * FR.APL.01 - Bagian 1
     */
    public function form1()
    {
        $user = Auth::user();
        $tuk = DB::table('tuk')->first();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        return view('asesi.permohonan.form1', compact('tuk', 'asesi'));
    }

    /**
     * FR.APL.01 - Bagian 2
     */
    public function form2()
    {
        $user = Auth::user();
        $skema = DB::table('skema_sertifikasi')->get();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();
        $jenisDokumen = DB::table('jenis_dokumen')->get();
        $tujuanAsesmen = TujuanAsesmen::all();

        return view('asesi.permohonan.form2', compact('skema', 'asesi', 'jenisDokumen', 'tujuanAsesmen'));
    }

    /**
     * Simpan data pribadi asesi (Bagian 1)
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nik'                    => 'nullable|string|max:255',
            'nama_lengkap'           => 'nullable|string|max:255',
            'tempat_lahir'           => 'nullable|string|max:255',
            'tgl_lahir'              => 'nullable|date',
            'jenis_kelamin'          => 'nullable|in:L,P',
            'kebangsaan'             => 'nullable|string|max:100',
            'alamat_rumah'           => 'nullable|string',
            'kode_pos_rumah'         => 'nullable|string|max:10',
            'telepon_rumah'          => 'nullable|string|max:50',
            'telepon_hp'             => 'nullable|string|max:50',
            'email'                  => 'nullable|email|max:255',
            'kualifikasi_pendidikan' => 'nullable|string|max:255',
            'nama_institusi'         => 'nullable|string|max:255',
            'jabatan'                => 'nullable|string|max:255',
            'alamat_kantor'          => 'nullable|string',
            'kode_pos_kantor'        => 'nullable|string|max:10',
            'telepon_kantor'         => 'nullable|string|max:50',
            'fax_kantor'             => 'nullable|string|max:50',
            'email_kantor'           => 'nullable|email|max:255',
        ]);

        $validated['user_id'] = $user->id;

        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        if ($asesi) {
            DB::table('asesi')->where('user_id', $user->id)->update([
                ...$validated,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('asesi')->insert([
                ...$validated,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('asesi.permohonan.form2')->with('success', 'Data pribadi berhasil disimpan.');
    }

    /**
     * API: Ambil detail skema + unit kompetensi
     */
    public function getSkema($id)
    {
        $skema = DB::table('skema_sertifikasi')
            ->where('id_skema', $id)
            ->select('id_skema', 'nama_skema', 'kode_skema', 'deskripsi')
            ->first();

        if (!$skema) {
            return response()->json(['error' => 'Skema tidak ditemukan'], 404);
        }

        $units = DB::table('unit_kompetensi')
            ->where('id_skema', $id)
            ->select('kode_unit', 'judul_unit', 'standar_kompetensi')
            ->get();

        return response()->json(['skema' => $skema, 'units' => $units]);
    }

    /**
     * Simpan permohonan sertifikasi (dokumen + tanda tangan)
     */
    public function storeDokumen(Request $request)
    {
        $request->validate([
            'skema_id'  => 'required|exists:skema_sertifikasi,id_skema',
            'tujuan_id' => 'required|exists:tujuan_asesmen,id_tujuan',
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal'   => 'required|date',
            'ttd_asesi' => 'required|string',
        ]);

        $user = Auth::user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        if (!$asesi) {
            return redirect()->route('asesi.permohonan.form1')
                ->with('error', 'Lengkapi data pribadi terlebih dahulu.');
        }

        DB::beginTransaction();

        try {
            // ✅ Buat atau update permohonan
            $permohonan = DB::table('permohonan')
                ->where('asesi_id', $asesi->id_asesi)
                ->latest('id_permohonan')
                ->first();

            if (!$permohonan || $permohonan->status === 'Ditolak') {
                $idPermohonan = DB::table('permohonan')->insertGetId([
                    'asesi_id'       => $asesi->id_asesi,
                    'skema_id'       => $request->skema_id,
                    'id_tujuan'      => $request->tujuan_id,
                    'tgl_permohonan' => now(),
                    'status'         => 'Diajukan',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            } else {
                $idPermohonan = $permohonan->id_permohonan;
                DB::table('permohonan')->where('id_permohonan', $idPermohonan)->update([
                    'skema_id'       => $request->skema_id,
                    'id_tujuan'      => $request->tujuan_id,
                    'tgl_permohonan' => now(),
                    'status'         => 'Diajukan',
                    'updated_at'     => now(),
                ]);
            }

            // ✅ Simpan dokumen
            $dokumenFiles = $request->file('dokumen', []);
            foreach ($dokumenFiles as $jenisId => $file) {
                $path = $file ? $file->store("dokumen/{$asesi->id_asesi}", 'public') : null;

                DB::table('dokumen_persyaratan')->updateOrInsert(
                    [
                        'permohonan_id'    => $idPermohonan,
                        'jenis_dokumen_id' => $jenisId,
                    ],
                    [
                        'nama_file'       => $file ? $file->getClientOriginalName() : null,
                        'path_file'       => $path,
                        'ada'             => $file ? 1 : 0,
                        'memenuhi_syarat' => 0,
                        'updated_at'      => now(),
                        'created_at'      => now(),
                    ]
                );
            }

            // ✅ Simpan tanda tangan digital
            $ttdBase64 = $request->ttd_asesi;
            if (preg_match('/^data:image\/(png|jpeg);base64,/', $ttdBase64)) {
                $ttdData = base64_decode(substr($ttdBase64, strpos($ttdBase64, ',') + 1));
                $fileName = "ttd/asesi_{$asesi->id_asesi}_" . time() . ".png";
                Storage::disk('public')->put($fileName, $ttdData);

                DB::table('permohonan_persetujuan')->updateOrInsert(
                    ['id_permohonan' => $idPermohonan],
                    [
                        'tgl_ttd_asesi' => $request->tanggal,
                        'ttd_asesi'     => $fileName,
                        'updated_at'    => now(),
                        'created_at'    => now(),
                    ]
                );
            }

            DB::commit();

            return redirect()->route('form_pra_assesmen')->with('success', 'Data permohonan berhasil disimpan.');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
