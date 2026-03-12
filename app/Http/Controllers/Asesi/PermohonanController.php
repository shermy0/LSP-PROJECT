<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\TujuanAsesmen;
use App\Models\Permohonan;
use App\Models\DokumenPersyaratan;
use Throwable;

class PermohonanController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | FORM 1 (DATA DIRI)
    |--------------------------------------------------------------------------
    */

    public function form1()
    {
        $user = Auth::user();

        $tuk = DB::table('tuk')->first();

        $asesi = DB::table('asesi')
            ->where('user_id', $user->id)
            ->first();

        return view('asesi.permohonan.form1', compact(
            'tuk',
            'asesi'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | FORM 2 (PERMOHONAN + DOKUMEN)
    |--------------------------------------------------------------------------
    */

    public function form2()
    {
        $user = Auth::user();

        $asesi = DB::table('asesi')
            ->where('user_id', $user->id)
            ->first();

        $skema = DB::table('skema_sertifikasi')->get();

        $jenisDokumen = DB::table('jenis_dokumen')->get();

        $tujuanAsesmen = TujuanAsesmen::all();

        $permohonan = null;

        $existingDocs = collect();

        if ($asesi) {

            $permohonan = Permohonan::where('id_asesi', $asesi->id_asesi)
                ->latest('id_permohonan')
                ->first();

            if ($permohonan) {

                $existingDocs = DokumenPersyaratan::where('id_permohonan', $permohonan->id_permohonan)
                    ->get()
                    ->keyBy('id_jenis_dokumen');
            }
        }

        return view(
            'asesi.permohonan.form2',
            compact(
                'skema',
                'asesi',
                'jenisDokumen',
                'tujuanAsesmen',
                'permohonan',
                'existingDocs'
            )
        );
    }



    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA DIRI ASESI
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nik' => 'nullable|string|max:255',
            'nama_lengkap' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'kebangsaan' => 'nullable|string|max:100',

            'alamat_rumah' => 'nullable|string',
            'kode_pos_rumah' => 'nullable|string|max:10',
            'telepon_rumah' => 'nullable|string|max:50',
            'telepon_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',

            'kualifikasi_pendidikan' => 'nullable|string|max:255',
            'nama_institusi' => 'nullable|string|max:255',

            'jabatan' => 'nullable|string|max:255',
            'alamat_kantor' => 'nullable|string',
            'kode_pos_kantor' => 'nullable|string|max:10',

            'telepon_kantor' => ['nullable','string','max:50','regex:/^([-+()0-9\s]+|-)$/'],
            'fax_kantor' => ['nullable','string','max:50','regex:/^([-+()0-9\s]+|-)$/'],
            'email_kantor' => 'nullable|email|max:255',
        ]);

        $validated['user_id'] = $user->id;

        $asesi = DB::table('asesi')
            ->where('user_id', $user->id)
            ->first();

        if ($asesi) {
            DB::table('asesi')
                ->where('user_id', $user->id)
                ->update([
                    ...$validated,
                    'updated_at' => now()
                ]);
        } else {
            DB::table('asesi')
                ->insert([
                    ...$validated,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }

        return redirect()
            ->route('asesi.permohonan.form2')
            ->with('success', 'Data pribadi berhasil disimpan.');
    }



    /*
    |--------------------------------------------------------------------------
    | API DETAIL SKEMA
    |--------------------------------------------------------------------------
    */

    public function getSkema($id)
    {
        $skema = DB::table('skema_sertifikasi')
            ->where('id_skema', $id)
            ->select(
                'id_skema',
                'nama_skema',
                'kode_skema',
                'jenjang',
                'deskripsi'
            )
            ->first();

        if (!$skema) {
            return response()->json([
                'error' => 'Skema tidak ditemukan'
            ], 404);
        }

        $units = DB::table('unit_kompetensi')
            ->where('id_skema', $id)
            ->select(
                'kode_unit',
                'judul_unit',
                'standar_kompetensi'
            )
            ->get();

        return response()->json([
            'skema' => $skema,
            'units' => $units
        ]);
    }



    /*
    |--------------------------------------------------------------------------
    | SIMPAN PERMOHONAN + DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function storeDokumen(Request $request)
    {
        $request->validate([
            'id_skema'  => 'required|exists:skema_sertifikasi,id_skema',
            'tujuan_id' => 'required|exists:tujuan_asesmen,id_tujuan',
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal'   => 'required|date',
            'ttd_asesi' => 'required|string',
        ]);

        $user = Auth::user();

        $asesi = DB::table('asesi')
            ->where('user_id', $user->id)
            ->first();

        if (!$asesi) {
            return redirect()
                ->route('asesi.permohonan.form1')
                ->with('error', 'Lengkapi data pribadi terlebih dahulu.');
        }

        DB::beginTransaction();

        try {
            // Cek permohonan terakhir
            $permohonan = Permohonan::where('id_asesi', $asesi->id_asesi)
                ->latest('id_permohonan')
                ->first();

            if (!$permohonan) {
                // Belum pernah mengajukan → buat baru
                $permohonan = Permohonan::create([
                    'id_asesi'       => $asesi->id_asesi,
                    'id_skema'       => $request->id_skema,
                    'id_tujuan'      => $request->tujuan_id,
                    'tgl_permohonan' => now()->toDateString(),
                    'status'         => 'Diajukan',
                    'catatan'        => null
                ]);
            } else {
                // Sudah pernah mengajukan → update data yang ada (termasuk jika status Ditolak)
                $permohonan->update([
                    'id_skema'       => $request->id_skema,
                    'id_tujuan'      => $request->tujuan_id,
                    'tgl_permohonan' => now()->toDateString(),
                    'status'         => 'Diajukan'   // kembalikan ke Diajukan
                ]);
            }

            $idPermohonan = $permohonan->id_permohonan;

            // Handle remove dokumen
            $removeFlags = $request->input('remove_dokumen', []);
            foreach ($removeFlags as $jenisId => $flag) {
                if ($flag != 1) continue;

                $doc = DokumenPersyaratan::where('id_permohonan', $idPermohonan)
                    ->where('id_jenis_dokumen', $jenisId)
                    ->first();

                if ($doc) {
                    if ($doc->path_file) {
                        Storage::disk('public')->delete($doc->path_file);
                    }

                    $doc->update([
                        'nama_file' => null,
                        'path_file' => null,
                        'ada' => false,
                        'memenuhi_syarat' => false,
                        'catatan' => null
                    ]);
                }
            }

            // Handle upload file
            $uploadedFiles = $request->file('dokumen', []);
            foreach ($uploadedFiles as $jenisId => $file) {
                if (!$file) continue;

                $existing = DokumenPersyaratan::where('id_permohonan', $idPermohonan)
                    ->where('id_jenis_dokumen', $jenisId)
                    ->first();

                if ($existing && $existing->path_file) {
                    Storage::disk('public')->delete($existing->path_file);
                }

                $path = $file->store("dokumen/" . $asesi->id_asesi, 'public');

                DokumenPersyaratan::updateOrCreate(
                    [
                        'id_permohonan' => $idPermohonan,
                        'id_jenis_dokumen' => $jenisId
                    ],
                    [
                        'nama_file' => $file->getClientOriginalName(),
                        'path_file' => $path,
                        'ada' => true,
                        'memenuhi_syarat' => false,
                        'catatan' => null
                    ]
                );
            }

            // Simpan TTD Asesi
            $ttdBase64 = $request->ttd_asesi;

            if (preg_match('/^data:image\/(png|jpeg);base64,/', $ttdBase64)) {
                $ttdData = base64_decode(substr($ttdBase64, strpos($ttdBase64, ',') + 1));
                $fileName = "ttd/asesi_" . $asesi->id_asesi . "_" . time() . ".png";
                Storage::disk('public')->put($fileName, $ttdData);

                DB::table('permohonan_persetujuan')
                    ->updateOrInsert(
                        ['id_permohonan' => $idPermohonan],
                        [
                            'tgl_ttd_asesi' => $request->tanggal,
                            'ttd_asesi' => $fileName,
                            'updated_at' => now()
                        ]
                    );
            }

            DB::commit();

            return redirect()
                ->route('form_pra_assesmen')
                ->with('success', 'Data permohonan berhasil disimpan.');

        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}