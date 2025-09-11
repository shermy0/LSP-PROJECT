<?php

<<<<<<< HEAD
=======
// app/Http/Controllers/AuthController.php
>>>>>>> 611046b1ace2ff58f20fcef5931dc36ff0f9e60d
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller

{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
<<<<<<< HEAD
            // Ambil user yang sedang login
            $user = Auth::user();

            // Cek role dan redirect
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'asesor') {
                return redirect()->route('asesor.dashboard');
            } elseif ($user->role === 'asesi') {
                return redirect()->route('asesi.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors('Role tidak dikenali.');
            }
        }

        // Kalau gagal login
        return back()->withErrors(['login' => 'Email atau password salah']);
=======
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.admin');
            } elseif ($user->role === 'asesor') {
                return redirect()->route('formperencanaan');
            } else {
                return redirect()->route('dashboard.asesi');
            }
        }

        return back()->with('error', 'Email atau password salah');
>>>>>>> 611046b1ace2ff58f20fcef5931dc36ff0f9e60d
    }

    public function showRegisterRole()
    {
        return view('auth.register-role');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,asesor,asesi',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login');
    }

   public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

        return redirect('/login');
    }

}
