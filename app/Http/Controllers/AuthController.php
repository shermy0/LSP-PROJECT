<?php

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
<<<<<<< HEAD
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
>>>>>>> 4d5eaa9f1287169d8c46f6ecf08760c0f5063c7d
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
