<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use App\Models\PersetujuanAsesmen;
use App\Models\PersetujuanAsesmenBukti;
use App\Models\Bukti;
use App\Models\Tuk;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\MasterJenisBukti;


class KerahasiaanController extends Controller
{
    // App\Http\Controllers\KerahasiaanController.php

public function create()
{
    $persetujuan = PersetujuanAsesmen::with(['skema','asesi','asesor','tuk'])->first();
    $tuk = TUK::all();
    $asesi = Asesi::all();
    $masterBukti = MasterJenisBukti::all();

    return view('asesor.kerahasiaan.kerahasiaan', compact('persetujuan','tuk','asesi','masterBukti'));
}

    public function kerahasiaanAsesi()
{
    $asesi = Asesi::where('user_id', Auth::id())->first();

    if (!$asesi) {
        return redirect()->back()->with('error', 'Data Asesi tidak ditemukan.');
    }

    $persetujuan = PersetujuanAsesmen::with(['buktiDipilih', 'skema', 'tuk', 'asesor'])
        ->where('id_asesi', $asesi->id_asesi)
        ->first();

    return view('asesi.kerahasiaan.kerahasiaan', compact('persetujuan'));
}

public function store(Request $request)
{
    $persetujuan = PersetujuanAsesmen::create([
        'id_asesi' => $request->asesi,
        'id_asesor' => Auth::user()->asesor->id_asesor,
        // isi field lain
    ]);

    // simpan bukti yang dipilih asesor
    $persetujuan->buktiDipilih()->attach($request->bukti, ['dipilih' => 1]);

    return redirect()->back()->with('success', 'Form tersimpan');
}

public function uploadBukti(Request $request)
{
    $asesi = Asesi::where('user_id', Auth::id())->first();
    $persetujuan = PersetujuanAsesmen::where('id_asesi', $asesi->id_asesi)->first();

    if (!$persetujuan) {
        return back()->with('error', 'Persetujuan tidak ditemukan');
    }

    if ($request->hasFile('bukti_file')) {
        foreach ($request->file('bukti_file') as $idJenisBukti => $file) {
            if ($file) {
                $path = $file->store('uploads/bukti', 'public');

                PersetujuanAsesmenBukti::updateOrCreate(
                    [
                        'id_persetujuan' => $persetujuan->id_persetujuan,
                        'id_jenis_bukti' => $idJenisBukti,
                    ],
                    [
                        'file_path' => $path,
                        'dipilih' => 1,
                    ]
                );
            }
        }
    }

    return back()->with('success', 'Bukti berhasil diupload!');
}

}