<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    public function form1()
    {
        $user = auth()->user();

        $tuk = DB::table('tuk')->first();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        return view('asesi.permohonan.form1', compact('tuk', 'asesi'));
    }

    public function form2()
    {
        $user = auth()->user();
        $skema = DB::table('skema_sertifikasi')->get();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();
        $jenisDokumen = DB::table('jenis_dokumen')->get();

        return view('asesi.permohonan.form2', compact('skema', 'asesi', 'jenisDokumen'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nik' => 'nullable|string|max:255',
            'nama_lengkap' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'pendidikan_terakhir' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = $user->id;

        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        if ($asesi) {
            $toUpdate = array_filter($validated, fn($v) => $v !== null && $v !== '');
            DB::table('asesi')->where('user_id', $user->id)
                ->update($toUpdate + ['updated_at' => now()]);
        } else {
            $validated['created_at'] = now();
            $validated['updated_at'] = now();
            DB::table('asesi')->insert($validated);
        }

        return redirect()->route('asesi.permohonan.form2')->with('success', 'Data berhasil disimpan');
    }

    public function getSkema($id)
    {
        $skema = DB::table('skema_sertifikasi')
            ->where('id_skema', $id)
            ->select('id_skema', 'nama_skema', 'kode_skema', 'judul_skema', 'deskripsi')
            ->first();

        $units = DB::table('unit_kompetensi')
            ->where('id_skema', $id)
            ->select('kode_unit', 'judul_unit', 'standar_kompetensi')
            ->get();

        return response()->json([
            'skema' => $skema,
            'units' => $units,
        ]);
    }

    public function storeDokumen(Request $request)
    {
        $request->validate([
            'id_skema' => 'required|exists:skema_sertifikasi,id_skema',
            'tujuan_asesmen' => 'required|string',
            'dokumen.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
            'ttd_asesi' => 'nullable|string', // base64 dari canvas
        ]);

        $user = auth()->user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        if (!$asesi) {
            return redirect()->route('asesi.permohonan.form1')
                ->with('error', 'Lengkapi data pribadi terlebih dahulu.');
        }

        // buat permohonan baru jika belum ada
        $permohonan = DB::table('permohonan')
            ->where('id_asesi', $asesi->id_asesi)
            ->latest('id_permohonan')
            ->first();

        if (!$permohonan) {
            $idPermohonan = DB::table('permohonan')->insertGetId([
                'id_asesi' => $asesi->id_asesi,
                'id_skema' => $request->id_skema,
                'tujuan_asesmen' => $request->tujuan_asesmen,
                'tgl_permohonan' => now(),
                'status' => 'Diajukan',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $idPermohonan = $permohonan->id_permohonan;
        }

        // simpan dokumen persyaratan (hanya kalau ada file)
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $idJenis => $file) {
                if (!$file) {
                    continue;
                }

                $path = $file->store("dokumen/{$asesi->id_asesi}", 'public');

                DB::table('dokumen_persyaratan')->updateOrInsert(
                    [
                        'id_permohonan' => $idPermohonan,
                        'id_jenis_dokumen' => $idJenis,
                    ],
                    [
                        'ada' => 1,
                        'memenuhi_syarat' => 0,
                        'file_path' => $path,
                        'updated_at' => now(),
                        // created_at hanya jika baru insert
                        'created_at' => DB::raw('COALESCE(created_at, NOW())'),
                    ]
                );
            }
        }

        // === SIMPAN TANDA TANGAN ASES I ===
        $ttdPath = null;
        if ($request->filled('ttd_asesi') && preg_match('/^data:image\/png;base64,/', $request->ttd_asesi)) {
            $ttdBase64 = substr($request->ttd_asesi, strpos($request->ttd_asesi, ',') + 1);
            $ttdData = base64_decode($ttdBase64);
            $fileName = "ttd/asesi_{$asesi->id_asesi}_" . time() . ".png";

            // hapus tanda tangan lama kalau ada
            $oldTTD = DB::table('permohonan_persetujuan')
                ->where('id_permohonan', $idPermohonan)
                ->value('ttd_asesi');

            if ($oldTTD && Storage::disk('public')->exists($oldTTD)) {
                Storage::disk('public')->delete($oldTTD);
            }

            Storage::disk('public')->put($fileName, $ttdData);
            $ttdPath = $fileName;
        }

        // update atau insert tanda tangan
        DB::table('permohonan_persetujuan')->updateOrInsert(
            ['id_permohonan' => $idPermohonan],
            [
                'tgl_ttd_asesi' => $request->tanggal,
                // hanya update ttd kalau ada file baru
                'ttd_asesi' => $ttdPath ?? DB::raw('ttd_asesi'),
                'updated_at' => now(),
                'created_at' => DB::raw('COALESCE(created_at, NOW())'),
            ]
        );

        return redirect()->route('asesi.permohonan.form2')
            ->with('success', 'Dokumen & tanda tangan berhasil disimpan.');
    }
}
