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
        abort_if(!$asesorId, 403, 'Data asesor untuk akun ini tidak ditemukan.');
              
        // Query peserta uji yang hanya dimiliki asesor ini
        $query = Asesi::with(['asesor', 'jurusan'])
            ->where('asesor_id', $asesorId);

        // Filter nama
        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'LIKE', '%' . $request->search . '%');
        }

        // Ambil data peserta + pagination
        $peserta = $query->paginate(10)->withQueryString();
        return view('datapesertauji', compact('peserta'));
    }

    // Detail peserta
    public function show($id)
    {
        $userId = Auth::id(); // dari tabel users
        $asesorId = Asesor::where('user_id', $userId)->value('id_asesor');
        abort_if(!$asesorId, 403, 'Data asesor untuk akun ini tidak ditemukan.');

        $peserta = Asesi::with(['asesor', 'jurusan'])
            ->where('asesor_id', $asesorId) // Hanya peserta milik asesor ini
            ->findOrFail($id);

        return view('detailpesertauji', compact('peserta'));
    }
}
