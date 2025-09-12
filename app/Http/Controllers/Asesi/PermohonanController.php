<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // ambil data asesi untuk ditampilkan
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        return view('asesi.permohonan.form2', compact('skema', 'asesi'));
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
        $validated['updated_at'] = now();

        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        if ($asesi) {
            // hanya update field yang diisi
            $toUpdate = array_filter($validated, fn($v) => $v !== null && $v !== '');
            DB::table('asesi')
                ->where('user_id', $user->id)
                ->update($toUpdate + ['updated_at' => now()]);
        } else {
            $validated['created_at'] = now();
            DB::table('asesi')->insert($validated);
        }

        return redirect()->route('asesi.permohonan.form2')
            ->with('success', 'Data berhasil disimpan');
    }

    /**
     * API untuk mengambil detail skema & unit kompetensi (dipanggil via AJAX di form2).
     */
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

}
