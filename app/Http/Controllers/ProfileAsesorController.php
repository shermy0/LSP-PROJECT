<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileAsesorController extends Controller
{
    public function show()
    {
        $user = Auth::user(); // ambil data user yang login
        return view('profileasesor.index', compact('user')); 
        // Pastikan file view: resources/views/profileasesor/index.blade.php
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profileasesor.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
