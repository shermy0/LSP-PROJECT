<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Data TUK
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

    public function update(Request $request, $id_permohonan)
    {
        // validasi input
        $request->validate([
            'status_permohonan' => 'required|in:Diterima,Ditolak',
            'catatan' => 'nullable|string',
            'syarat' => 'array',
            'ttd_admin' => 'nullable|string', // base64 image
            'tanggal_admin' => 'nullable|date'
        ]);

        // ambil id_admin berdasarkan user yang login
        $adminId = DB::table('admin')
            ->where('user_id', Auth::id())
            ->value('id_admin');

        // 1. Update permohonan
        DB::table('permohonan')
            ->where('id_permohonan', $id_permohonan)
            ->update([
                'status'     => $request->status_permohonan,
                'catatan'    => $request->catatan,
                'id_admin'   => $adminId,
                'updated_at' => now(),
            ]);

        // 2. Update dokumen persyaratan
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

        // 3. Update persetujuan (tanda tangan admin)
        if ($request->filled('ttd_admin')) {
            $img = $request->ttd_admin;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileName = 'ttd_admin_' . time() . '.png';
            $filePath = 'tanda_tangan/' . $fileName;

            // simpan ke storage
            \Storage::disk('public')->put($filePath, base64_decode($img));

            DB::table('permohonan_persetujuan')
                ->updateOrInsert(
                    ['id_permohonan' => $id_permohonan],
                    [
                        'tgl_ttd_admin' => $request->tanggal_admin ?? now(),
                        'ttd_admin'     => $filePath,
                        'updated_at'    => now(),
                    ]
                );
        }

        return redirect()->route('admin.permohonan.index')
            ->with('success', 'Permohonan berhasil diperbarui.');
    }
}
