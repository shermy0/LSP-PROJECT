<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asesi;
use App\Models\Asesor;
use Illuminate\Support\Facades\DB;

class PenugasanController extends Controller
{
    /**
     * Halaman daftar asesi + modal penugasan asesor
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $asesiQuery = Asesi::with(['asesor', 'jurusan'])
            ->addSelect([
                'skema_pilihan' => DB::table('permohonan')
                    ->join('skema_sertifikasi', 'permohonan.id_skema', '=', 'skema_sertifikasi.id_skema')
                    ->whereColumn('permohonan.id_asesi', 'asesi.id_asesi')
                    ->latest('permohonan.id_permohonan')
                    ->select('skema_sertifikasi.nama_skema')
                    ->limit(1)
            ])
            ->orderBy('updated_at', 'desc');

        if ($q) {
            $asesiQuery->where(function ($w) use ($q) {
                $w->where('nama_lengkap', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $asesi = $asesiQuery->paginate(12)->withQueryString();

        // Ambil daftar asesor
        $asesors = Asesor::with('skemas')->orderBy('nama_asesor')->get();

        // Hitung jumlah asesi yang sudah ditugaskan per asesor
        $assignedCounts = Asesi::select('asesor_id', DB::raw('count(*) as total'))
            ->groupBy('asesor_id')
            ->pluck('total', 'asesor_id')
            ->toArray();

        $totalNotAssigned = Asesi::whereNull('asesor_id')->count();

        return view('admin.penugasan.index', compact(
            'asesi',
            'asesors',
            'assignedCounts',
            'totalNotAssigned',
            'q'
        ));
    }

    /**
     * Update penugasan via modal (PUT)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'asesor_id' => 'required|integer|exists:asesor,id_asesor',
        ]);

        $asesorId = (int) $request->input('asesor_id');

        DB::beginTransaction();
        try {
            // Ambil data asesi dengan jurusan dan permohonan terbaru
            $asesi = Asesi::with('jurusan')->findOrFail($id);

            // Ambil skema pilihan asesi dari permohonan terbaru
            $permohonan = DB::table('permohonan')
                ->where('id_asesi', $id)
                ->latest('id_permohonan')
                ->first();

            $skemaAsesi = null;
            if ($permohonan) {
                // Perbaikan: gunakan where karena primary key bukan 'id'
                $skemaAsesi = DB::table('skema_sertifikasi')
                    ->where('id_skema', $permohonan->id_skema)
                    ->first();
            }

            // Ambil data asesor dengan skema yang diampu
            $asesor = Asesor::with('skemas')->findOrFail($asesorId);

            // Validasi kecocokan skema/jurusan
            if ($skemaAsesi) {
                // Asesi sudah punya skema -> asesor harus mengampu skema yang sama
                if (!$asesor->skemas->contains('id_skema', $skemaAsesi->id_skema)) {
                    throw new \Exception('Asesor tidak memiliki skema yang sesuai dengan skema pilihan asesi.');
                }
            } else {
                // Asesi belum punya skema -> cocokkan berdasarkan jurusan
                if (!$asesi->jurusan_id || !$asesor->id_jurusan || $asesi->jurusan_id != $asesor->id_jurusan) {
                    throw new \Exception('Jurusan asesi dan asesor tidak sama, dan asesi belum memilih skema.');
                }
            }

            // Cek batas maksimal asesi per asesor (10)
            $countAssigned = DB::table('asesi')
                ->where('asesor_id', $asesorId)
                ->where('id_asesi', '<>', $id)
                ->lockForUpdate()
                ->count();

            if ($countAssigned >= 10) {
                throw new \Exception('Asesor sudah mencapai batas maksimal (10 asesi).');
            }

            // Simpan penugasan
            $asesi->asesor_id = $asesorId;
            $asesi->save();

            DB::commit();

            return redirect()->route('admin.penugasan.index')
                ->with('success', 'Asesor berhasil ditugaskan ke asesi.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('admin.penugasan.index')
                ->with('error', $e->getMessage());
        }
    }
}