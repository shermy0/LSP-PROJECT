<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Form1AdminController extends Controller
{
    public function index()
    {
        // ✅ Ambil hanya Asesi yang punya permohonan berstatus "Diajukan"
        $asesi = DB::table('asesi')
            ->join('permohonan', 'permohonan.asesi_id', '=', 'asesi.id_asesi')
            ->where('permohonan.status', 'Diajukan')
            ->select(
                'asesi.id_asesi',
                'asesi.nama_lengkap',
                'asesi.nik',
                'asesi.email',
                'asesi.telepon_hp as telepon',
                'permohonan.updated_at'
            )
            ->orderBy('permohonan.updated_at', 'desc')
            ->paginate(10); // ✅ ganti dari get()

        return view('admin.permohonan.index', compact('asesi'));
    }

    public function show($id_asesi)
    {
        // ✅ Data Asesi
        $asesi = DB::table('asesi')->where('id_asesi', $id_asesi)->first();
        if (!$asesi) {
            abort(404, 'Data Asesi tidak ditemukan');
        }

        // ✅ Ambil permohonan terbaru + join tujuan_asesmen agar field tujuan_asesmen ada
        $permohonan = DB::table('permohonan')
            ->leftJoin('tujuan_asesmen', 'permohonan.id_tujuan', '=', 'tujuan_asesmen.id_tujuan')
            ->where('permohonan.asesi_id', $id_asesi)
            ->select(
                'permohonan.*',
                'tujuan_asesmen.nama_tujuan as tujuan_asesmen'
            )
            ->orderBy('permohonan.tgl_permohonan', 'desc')
            ->first();

        if (!$permohonan) {
            return view('admin.permohonan.no-permohonan', compact('asesi'));
        }

        // ✅ Data Skema & Unit Kompetensi
        $skema = null;
        $units = collect();

        if (!empty($permohonan->skema_id)) {
            $skema = DB::table('skema_sertifikasi')
                ->where('id_skema', $permohonan->skema_id)
                ->first();

            $units = DB::table('unit_kompetensi')
                ->where('id_skema', $permohonan->skema_id)
                ->select('kode_unit', 'judul_unit', 'standar_kompetensi')
                ->get();
        }

        // ✅ Data TUK
        $tuk = null;
        if (!empty($permohonan->id_tuk)) {
            $tuk = DB::table('tuk')->where('id_tuk', $permohonan->id_tuk)->first();
        } else {
            $tuk = DB::table('tuk')->first(); // fallback
        }

        // ✅ Dokumen Persyaratan (join jenis_dokumen)
        $dokumen = DB::table('dokumen_persyaratan')
            ->join('jenis_dokumen', 'dokumen_persyaratan.jenis_dokumen_id', '=', 'jenis_dokumen.id_jenis_dokumen')
            ->where('dokumen_persyaratan.permohonan_id', $permohonan->id_permohonan)
            ->select(
                'dokumen_persyaratan.id_dokumen',
                'dokumen_persyaratan.path_file',
                'jenis_dokumen.nama_dokumen as jenis'
            )
            ->get();

        // ✅ Persetujuan
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

    public function update(Request $request, $id_permohonan)
    {
        $request->validate([
            'status_permohonan' => 'required|in:Diterima,Ditolak',
            'catatan' => 'nullable|string',
            'syarat' => 'array',
            'ttd_admin' => 'nullable|string',
            'tanggal_admin' => 'nullable|date'
        ]);

        // ✅ Ambil ID admin berdasarkan user login
        $adminId = DB::table('admin')
            ->where('user_id', Auth::id())
            ->value('id_admin');

        // ✅ Update permohonan (pakai kolom admin_id)
        DB::table('permohonan')
            ->where('id_permohonan', $id_permohonan)
            ->update([
                'status' => $request->status_permohonan,
                'catatan' => $request->catatan,
                'admin_id' => $adminId,
                'updated_at' => now(),
            ]);

        // ✅ Update dokumen persyaratan
        if ($request->has('syarat')) {
            foreach ($request->syarat as $id_dokumen => $val) {
                DB::table('dokumen_persyaratan')
                    ->where('id_dokumen', $id_dokumen)
                    ->update([
                        'memenuhi_syarat' => $val === 'Ya' ? 1 : 0,
                        'updated_at' => now(),
                    ]);
            }
        }

        // ✅ Simpan tanda tangan admin
        if ($request->filled('ttd_admin')) {
            $img = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->ttd_admin);
            $fileName = 'ttd_admin_' . time() . '.png';
            $filePath = 'tanda_tangan/' . $fileName;

            Storage::disk('public')->put($filePath, base64_decode($img));

            DB::table('permohonan_persetujuan')
                ->updateOrInsert(
                    ['id_permohonan' => $id_permohonan],
                    [
                        'tgl_ttd_admin' => $request->tanggal_admin ?? now(),
                        'ttd_admin' => $filePath,
                        'updated_at' => now(),
                    ]
                );
        }

        return redirect()->route('admin.permohonan.index')
            ->with('success', 'Permohonan berhasil diperbarui.');
    }
}
