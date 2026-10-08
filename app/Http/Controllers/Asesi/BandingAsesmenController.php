<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Asesi;
use App\Models\BandingAsesmen;
use App\Models\BandingAsesmenPersetujuan;
use App\Models\Permohonan;
use App\Models\PenyesuaianWajar;

class BandingAsesmenController extends Controller
{
    /**
     * Daftar banding milik asesi.
     */
    public function index()
    {
        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();
        $bandings = BandingAsesmen::with('permohonan.skema', 'persetujuan')
                    ->where('id_asesi', $asesi->id_asesi)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('asesi.banding_asesmen.index', compact('bandings'));
    }

    /**
     * Form pengajuan banding untuk permohonan tertentu.
     */
    public function create($id_permohonan)
    {
        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();

        // Ambil permohonan milik asesi ini yang sudah memiliki persetujuan selesai
        // Serta muat relasi skema, asesi, dan asesor (melalui asesi)
        $permohonan = Permohonan::with(['skema', 'asesi.asesor.user'])
                        ->where('id_asesi', $asesi->id_asesi)
                        ->where('id_permohonan', $id_permohonan)
                        ->whereHas('persetujuan', function($q) {
                            $q->where('status', 'selesai');
                        })
                        ->first();

        if (!$permohonan) {
            return redirect()->route('form_pra_assesmen')
                ->with('error', 'Permohonan tidak ditemukan atau persetujuan belum selesai.');
        }

        // Cek apakah penyesuaian wajar sudah selesai
        $penyesuaianWajar = PenyesuaianWajar::where('id_permohonan', $permohonan->id_permohonan)
                            ->where('status', 'selesai')
                            ->first();

        if (!$penyesuaianWajar) {
            return redirect()->route('form_pra_assesmen')
                ->with('error', 'Banding hanya dapat diajukan setelah penyesuaian wajar selesai.');
        }

        // Cek apakah sudah ada banding untuk permohonan ini
        $existing = BandingAsesmen::where('id_permohonan', $permohonan->id_permohonan)->exists();
        if ($existing) {
            return redirect()->route('form_pra_assesmen')
                ->with('error', 'Anda sudah mengajukan banding untuk permohonan ini.');
        }

        return view('asesi.banding_asesmen.create', compact('permohonan'));
    }

    /**
     * Simpan banding baru beserta tanda tangan.
     */
    public function store(Request $request)
    {
        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'id_permohonan'        => 'required|exists:permohonan,id_permohonan',
            'tgl_asesmen'          => 'required|date',
            'banding_dijelaskan'   => 'required|in:Ya,Tidak',
            'diskusi_dengan_asesor' => 'required|in:Ya,Tidak',
            'libatkan_orang_lain'  => 'required|in:Ya,Tidak',
            'alasan_banding'       => 'required|string',
            'ttd_asesi'            => 'required|string',
            'tgl_ttd_asesi'        => 'required|date',
        ]);

        // Validasi ulang kelayakan permohonan
        $permohonan = Permohonan::where('id_permohonan', $request->id_permohonan)
                        ->where('id_asesi', $asesi->id_asesi)
                        ->whereHas('persetujuan', function($q) {
                            $q->where('status', 'selesai');
                        })
                        ->first();

        if (!$permohonan) {
            return back()->with('error', 'Permohonan tidak valid.')->withInput();
        }

        $penyesuaianWajar = PenyesuaianWajar::where('id_permohonan', $permohonan->id_permohonan)
                            ->where('status', 'selesai')
                            ->first();

        if (!$penyesuaianWajar) {
            return back()->with('error', 'Penyesuaian wajar belum selesai.')->withInput();
        }

        $existing = BandingAsesmen::where('id_permohonan', $permohonan->id_permohonan)->exists();
        if ($existing) {
            return back()->with('error', 'Banding sudah diajukan sebelumnya.')->withInput();
        }

        DB::beginTransaction();
        try {
            // Simpan data banding
            $banding = BandingAsesmen::create([
                'id_asesi'             => $asesi->id_asesi,
                'id_permohonan'        => $permohonan->id_permohonan,
                'id_skema'             => $permohonan->id_skema,
                'tgl_asesmen'          => $request->tgl_asesmen,
                'banding_dijelaskan'   => $request->banding_dijelaskan,
                'diskusi_dengan_asesor' => $request->diskusi_dengan_asesor,
                'libatkan_orang_lain'  => $request->libatkan_orang_lain,
                'alasan_banding'       => $request->alasan_banding,
                'tgl_banding'          => now()->toDateString(),
            ]);

            // Simpan tanda tangan
            $ttdPath = $this->saveSignature($request->ttd_asesi, 'asesi');
            BandingAsesmenPersetujuan::create([
                'id_banding'    => $banding->id_banding,
                'tgl_ttd_asesi' => $request->tgl_ttd_asesi,
                'ttd_asesi'     => $ttdPath,
            ]);

            DB::commit();

            return redirect()->route('asesi.banding_asesmen.show', $banding->id_banding)
                ->with('success', 'Banding berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengajukan banding: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Detail banding.
     */
    public function show($id)
    {
        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();
        $banding = BandingAsesmen::with(['permohonan.skema', 'persetujuan'])
                    ->where('id_asesi', $asesi->id_asesi)
                    ->findOrFail($id);

        return view('asesi.banding_asesmen.show', compact('banding'));
    }

    /**
     * Simpan base64 signature ke file.
     */
    private function saveSignature($base64, $prefix)
    {
        $image = str_replace('data:image/png;base64,', '', $base64);
        $image = str_replace(' ', '+', $image);
        $fileName = $prefix . '_' . time() . '.png';
        Storage::disk('public')->put('ttd/' . $fileName, base64_decode($image));
        return 'ttd/' . $fileName;
    }
}