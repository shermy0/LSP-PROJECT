<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Asesi;
use App\Models\PersetujuanAsesmen;

class PersetujuanAsesmenController extends Controller
{
    /**
     * Daftar persetujuan yang perlu ditandatangani oleh asesi.
     */
    public function index()
    {
        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();

        $persetujuan = PersetujuanAsesmen::with(['permohonan.skema', 'asesor'])
            ->where('id_asesi', $asesi->id_asesi)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('asesi.persetujuan_asesmen.index', compact('persetujuan'));
    }

    /**
     * Menampilkan detail persetujuan untuk asesi (sama dengan show asesor, tapi view berbeda).
     */
    public function show($id)
    {
        $persetujuan = PersetujuanAsesmen::with([
            'permohonan.skema',
            'asesor',
            'buktiTerpilih.jenisBukti',
            'ttd'
        ])->findOrFail($id);

        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();
        if ($persetujuan->id_asesi != $asesi->id_asesi) {
            abort(403);
        }

        return view('asesi.persetujuan_asesmen.show', compact('persetujuan'));
    }
}