<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Asesor;
use App\Models\Permohonan;
use App\Models\PenyesuaianWajar;
use App\Models\PenyesuaianWajarPotensi;
use App\Models\PenyesuaianWajarItem;
use App\Models\PenyesuaianWajarKeteranganItem;
use App\Models\PenyesuaianWajarPersetujuan;

class PenyesuaianWajarController extends Controller
{
    /**
     * Daftar permohonan yang memiliki persetujuan selesai dan asesi ditugaskan ke asesor.
     */
    public function index()
    {
        $asesor = Asesor::where('user_id', Auth::id())->firstOrFail();

        $permohonan = Permohonan::whereHas('asesi', function ($q) use ($asesor) {
                $q->where('asesor_id', $asesor->id_asesor);
            })
            ->whereHas('persetujuan', function ($q) {
                $q->where('status', 'selesai');
            })
            ->with(['asesi', 'skema', 'persetujuan'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        // Tambahkan informasi apakah sudah ada penyesuaian wajar untuk permohonan ini
        foreach ($permohonan as $p) {
            $p->penyesuaian = PenyesuaianWajar::where('id_permohonan', $p->id_permohonan)->first();
        }

        return view('asesor.penyesuaian_wajar.index', compact('permohonan'));
    }

    /**
     * Form buat penyesuaian wajar untuk permohonan tertentu.
     */
    public function create($id_permohonan)
    {
        $permohonan = Permohonan::with(['asesi', 'skema', 'persetujuan.tuk'])->findOrFail($id_permohonan);
        $asesor = Asesor::where('user_id', Auth::id())->firstOrFail();

        // Pastikan asesor yang login adalah asesor yang ditugaskan
        if ($permohonan->asesi->asesor_id != $asesor->id_asesor) {
            abort(403);
        }

        // Cek apakah sudah ada penyesuaian untuk permohonan ini
        $existing = PenyesuaianWajar::where('id_permohonan', $id_permohonan)->first();
        if ($existing) {
            return redirect()->route('asesor.penyesuaian_wajar.show', $existing->id_penyesuaian)
                ->with('info', 'Penyesuaian wajar sudah ada.');
        }

        return view('asesor.penyesuaian_wajar.create', compact('permohonan'));
    }

    /**
     * Menyimpan data penyesuaian wajar (langsung dikirim ke asesi).
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_permohonan'       => 'required|exists:permohonan,id_permohonan',
            'acuan_pembanding'    => 'nullable|string',
            'metode_asesmen'      => 'nullable|string',
            'instrumen_asesmen'   => 'nullable|string',
            'potensi'             => 'nullable|array',
            'items'               => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $permohonan = Permohonan::findOrFail($request->id_permohonan);
            $asesor = Asesor::where('user_id', Auth::id())->firstOrFail();

            // Simpan data utama
            $penyesuaian = PenyesuaianWajar::create([
                'id_permohonan'     => $request->id_permohonan,
                'id_asesi'          => $permohonan->id_asesi,
                'id_asesor'         => $asesor->id_asesor,
                'acuan_pembanding'  => $request->acuan_pembanding,
                'metode_asesmen'    => $request->metode_asesmen,
                'instrumen_asesmen' => $request->instrumen_asesmen,
                'status'            => 'draf', // sementara draf dulu
            ]);

            // Simpan potensi
            if ($request->has('potensi')) {
                foreach ($request->potensi as $potensiText => $dipilih) {
                    if ($dipilih == "1") {
                        PenyesuaianWajarPotensi::create([
                            'id_penyesuaian' => $penyesuaian->id_penyesuaian,
                            'teks_potensi'   => $potensiText,
                            'dipilih'        => true,
                        ]);
                    }
                }
            }

            // Simpan item (1-8)
            if ($request->has('items')) {
                foreach ($request->items as $nomor => $itemData) {
                    if (isset($itemData['dipilih']) && $itemData['dipilih'] == "1") {
                        $item = PenyesuaianWajarItem::create([
                            'id_penyesuaian' => $penyesuaian->id_penyesuaian,
                            'nomor_item'     => (int) $nomor,
                            'dipilih'        => true,
                        ]);

                        if (isset($itemData['keterangan']) && is_array($itemData['keterangan'])) {
                            foreach ($itemData['keterangan'] as $keterangan) {
                                PenyesuaianWajarKeteranganItem::create([
                                    'id_item'     => $item->id_item,
                                    'keterangan'  => $keterangan,
                                    'is_lainnya'  => false,
                                ]);
                            }
                        }

                        if (!empty($itemData['keterangan_lain'])) {
                            PenyesuaianWajarKeteranganItem::create([
                                'id_item'     => $item->id_item,
                                'keterangan'  => $itemData['keterangan_lain'],
                                'is_lainnya'  => true,
                            ]);
                        }
                    }
                }
            }

            // Setelah semua data tersimpan, ubah status menjadi menunggu asesi
            $penyesuaian->update(['status' => 'menunggu_asesi']);

            DB::commit();

            return redirect()->route('asesor.penyesuaian_wajar.show', $penyesuaian->id_penyesuaian)
                ->with('success', 'Penyesuaian wajar berhasil disimpan dan dikirim ke asesi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail penyesuaian wajar.
     */
    public function show($id)
    {
        $penyesuaian = PenyesuaianWajar::with([
            'permohonan.skema',
            'permohonan.persetujuan.tuk',
            'asesi',
            'asesor',
            'potensi',
            'items.keteranganItems',
            'persetujuan'
        ])->findOrFail($id);

        $user = Auth::user();
        $role = $user->role;

        // Otorisasi
        if ($role === 'asesor') {
            $asesor = Asesor::where('user_id', $user->id)->firstOrFail();
            if ($penyesuaian->id_asesor != $asesor->id_asesor) {
                abort(403);
            }
        } elseif ($role === 'asesi') {
            $asesi = DB::table('asesi')->where('user_id', $user->id)->first();
            if ($penyesuaian->id_asesi != $asesi->id_asesi) {
                abort(403);
            }
        } else {
            abort(403);
        }

        return view($role . '.penyesuaian_wajar.show', compact('penyesuaian'));
    }

    /**
     * Update data penyesuaian (hanya jika status draf dan role asesor).
     */
    public function update(Request $request, $id)
    {
        $penyesuaian = PenyesuaianWajar::findOrFail($id);
        $asesor = Asesor::where('user_id', Auth::id())->firstOrFail();

        if ($penyesuaian->id_asesor != $asesor->id_asesor || $penyesuaian->status !== 'draf') {
            abort(403);
        }

        $request->validate([
            'acuan_pembanding'    => 'nullable|string',
            'metode_asesmen'      => 'nullable|string',
            'instrumen_asesmen'   => 'nullable|string',
            'potensi'             => 'nullable|array',
            'items'               => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            // Update data utama
            $penyesuaian->update([
                'acuan_pembanding'  => $request->acuan_pembanding,
                'metode_asesmen'    => $request->metode_asesmen,
                'instrumen_asesmen' => $request->instrumen_asesmen,
            ]);

            // Update potensi: hapus lama, buat baru
            $penyesuaian->potensi()->delete();
            if ($request->has('potensi')) {
                foreach ($request->potensi as $potensiText => $dipilih) {
                    if ($dipilih == "1") {
                        PenyesuaianWajarPotensi::create([
                            'id_penyesuaian' => $penyesuaian->id_penyesuaian,
                            'teks_potensi'   => $potensiText,
                            'dipilih'        => true,
                        ]);
                    }
                }
            }

            // Update items: hapus lama
            $penyesuaian->items()->delete();
            if ($request->has('items')) {
                foreach ($request->items as $nomor => $itemData) {
                    if (isset($itemData['dipilih']) && $itemData['dipilih'] == "1") {
                        $item = PenyesuaianWajarItem::create([
                            'id_penyesuaian' => $penyesuaian->id_penyesuaian,
                            'nomor_item'     => (int) $nomor,
                            'dipilih'        => true,
                        ]);

                        if (isset($itemData['keterangan']) && is_array($itemData['keterangan'])) {
                            foreach ($itemData['keterangan'] as $keterangan) {
                                PenyesuaianWajarKeteranganItem::create([
                                    'id_item'     => $item->id_item,
                                    'keterangan'  => $keterangan,
                                    'is_lainnya'  => false,
                                ]);
                            }
                        }

                        if (!empty($itemData['keterangan_lain'])) {
                            PenyesuaianWajarKeteranganItem::create([
                                'id_item'     => $item->id_item,
                                'keterangan'  => $itemData['keterangan_lain'],
                                'is_lainnya'  => true,
                            ]);
                        }
                    }
                }
            }

            // Setelah update, ubah status menjadi menunggu asesi
            $penyesuaian->update(['status' => 'menunggu_asesi']);

            DB::commit();

            return redirect()->route('asesor.penyesuaian_wajar.show', $penyesuaian->id_penyesuaian)
                ->with('success', 'Penyesuaian wajar berhasil diperbarui dan dikirim ke asesi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Form edit penyesuaian wajar (hanya jika status draf).
     */
    public function edit($id)
    {
        $penyesuaian = PenyesuaianWajar::with([
            'permohonan.skema',
            'permohonan.persetujuan.tuk',
            'asesi',
            'potensi',
            'items.keteranganItems'
        ])->findOrFail($id);

        $asesor = Asesor::where('user_id', Auth::id())->firstOrFail();

        // Pastikan asesor yang login adalah pemilik
        if ($penyesuaian->id_asesor != $asesor->id_asesor) {
            abort(403);
        }

        // Pastikan status masih draf
        if ($penyesuaian->status !== 'draf') {
            return redirect()->route('asesor.penyesuaian_wajar.show', $id)
                ->with('error', 'Tidak dapat mengedit karena sudah tidak dalam status draf.');
        }

        $permohonan = $penyesuaian->permohonan;

        return view('asesor.penyesuaian_wajar.edit', compact('penyesuaian', 'permohonan'));
    }

    /**
     * Menyimpan tanda tangan asesor (setelah asesi menandatangani).
     */
    public function storeSignature(Request $request, $id)
    {
        $penyesuaian = PenyesuaianWajar::findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'asesor') {
            if ($penyesuaian->status !== 'menunggu_asesor') {
                return back()->with('error', 'Tidak dapat menandatangani pada status ini.');
            }
            $asesor = Asesor::where('user_id', $user->id)->firstOrFail();
            if ($penyesuaian->id_asesor != $asesor->id_asesor) {
                abort(403);
            }

            $request->validate([
                'ttd_asesor'    => 'required|string',
                'tgl_ttd_asesor' => 'required|date',
            ]);

            $ttdPath = $this->saveSignature($request->ttd_asesor, 'asesor');
            PenyesuaianWajarPersetujuan::updateOrCreate(
                ['id_penyesuaian' => $id],
                [
                    'tgl_ttd_asesor' => $request->tgl_ttd_asesor,
                    'ttd_asesor'     => $ttdPath,
                ]
            );
            $penyesuaian->update(['status' => 'selesai']);

            return redirect()->route('asesor.penyesuaian_wajar.show', $id)
                ->with('success', 'Tanda tangan asesor berhasil disimpan.');
        }

        abort(403);
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