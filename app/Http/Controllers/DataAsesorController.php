<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class DataAsesorController extends Controller

{
    public function admin(Request $request)
{
    $query = Asesor::query();

    // 🔍 Pencarian nama atau NIP
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('nama_asesor', 'like', '%' . $request->search . '%')
              ->orWhere('nip', 'like', '%' . $request->search . '%');
        });
    }

    // 📌 Filter bidang keahlian
    if ($request->filled('bidang') && $request->bidang != 'Semua') {
        $query->where('bidang_keahlian', $request->bidang);
    }

    $asesor = $query->get();
    $total = Asesor::count();

    // ambil daftar bidang unik untuk dropdown
    $listBidang = Asesor::select('bidang_keahlian')->distinct()->pluck('bidang_keahlian');

    return view('admin.dataasesor', compact('asesor', 'total', 'listBidang'));
}

    //tambah asesor
    public function store(Request $request)
    {
    $request->validate([
        'nama_asesor' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'nip' => 'nullable|string|max:50',
        'bidang_keahlian' => 'required|string',
        'no_registrasi' => 'nullable|string|max:100',
        'password' => 'required|min:6',
    ]);

    // 1. Buat user baru
    $user = User::create([
        'name' => $request->nama_asesor,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'asesor', // pastikan di tabel users ada kolom role
    ]);

    // 2. Buat data asesor
    Asesor::create([
        'user_id' => $user->id,
        'nama_asesor' => $request->nama_asesor,
        'nip' => $request->nip,
        'email' => $request->email,
        'bidang_keahlian' => $request->bidang_keahlian,
        'no_registrasi' => $request->no_registrasi,
    ]);

    return redirect()->route('admin.dataasesor')->with('success', 'Asesor berhasil ditambahkan!');

}
}