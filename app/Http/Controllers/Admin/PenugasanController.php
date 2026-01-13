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

        $asesiQuery = Asesi::with('asesor')
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
        $asesors = Asesor::orderBy('nama_asesor')->get();

        // Hitung jumlah asesi yang sudah ditugaskan per asesor
        $assignedCounts = Asesi::select('asesor_id', DB::raw('count(*) as total'))
            ->groupBy('asesor_id')
            ->pluck('total','asesor_id') // key = asesor_id, value = total
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

        try {
            DB::transaction(function () use ($id, $asesorId) {
                // Lock the asesor row to reduce race (not strictly necessary but helps)
                DB::table('asesor')->where('id_asesor', $asesorId)->lockForUpdate()->first();

                // Count asesi assigned to calon asesor, excluding the current asesi (so reassign to same asesor allowed)
                $countAssigned = DB::table('asesi')
                    ->where('asesor_id', $asesorId)
                    ->where('id_asesi', '<>', $id)
                    ->lockForUpdate()
                    ->count();

                if ($countAssigned >= 10) {
                    // throw to rollback transaction and handle below
                    throw new \RuntimeException('Asesor sudah mencapai batas maksimal (10 asesi). Silakan pilih asesor lain.');
                }

                // Simpan penugasan
                $asesi = Asesi::findOrFail($id);
                $asesi->asesor_id = $asesorId;
                $asesi->save();
            });
        } catch (\Throwable $e) {
            // Kembalikan ke halaman index dengan pesan error
            return redirect()->route('admin.penugasan.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.penugasan.index')
            ->with('success', 'Asesor berhasil ditugaskan ke asesi.');
    }
}
