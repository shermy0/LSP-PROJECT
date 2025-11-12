<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asesi;
use App\Models\Asesor;
use Illuminate\Support\Facades\Auth;

class DataPesertaUjiController extends Controller
{
    // Tampilkan semua peserta
    public function index(Request $request)
    {
        $userId = Auth::id(); // dari tabel users
        $asesorId = Asesor::where('user_id', $userId)->value('id_asesor');
              
        // Query peserta uji yang hanya dimiliki asesor ini
        $query = Asesi::with('asesor')
            ->where('asesor_id', $asesorId);

        // Filter nama
        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'LIKE', '%' . $request->search . '%');
        }

        // Filter kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        // Ambil data peserta + pagination
        $peserta = $query->paginate(10)->withQueryString();

        // Ambil daftar kelas unik hanya untuk asesor ini
        $kelasList = Asesi::where('asesor_id', $asesorId)
            ->whereNotNull('kelas')
            ->select('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('datapesertauji', compact('peserta', 'kelasList'));
    }

    // Detail peserta
    public function show($id)
    {
        $userId = Auth::id(); // dari tabel users
        $asesorId = Asesor::where('user_id', $userId)->value('id_asesor');

        $peserta = Asesi::with('asesor')
            ->where('asesor_id', $asesorId) // Hanya peserta milik asesor ini
            ->findOrFail($id);

        return view('detailpesertauji', compact('peserta'));
    }
}
