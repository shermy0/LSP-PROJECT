<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan; // Tambahkan ini
use App\Models\Asesi;   // Tambahkan ini
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* ===============================
       LOGIN
    =============================== */
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'asesor':
                    return redirect()->route('asesor.dashboard');
                case 'asesi':
                    return redirect()->route('asesi.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['login' => 'Role pengguna tidak dikenali.']);
            }
        }

        return back()->withErrors(['login' => 'Email atau password salah'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar dari sistem.');
    }


    /* ===============================
       REGISTER (ASESI)
    =============================== */
    public function showRegister()
    {
        // Ambil data jurusan yang aktif untuk ditampilkan di dropdown
        $jurusan = Jurusan::where('status', 'aktif')->get();
        
        return view('auth.register', compact('jurusan'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6|confirmed',
            'jurusan_id'   => 'required|exists:jurusan,id_jurusan',
        ]);

        // Buat user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'asesi', // otomatis jadi asesi
        ]);

        // Buat data asesi dengan jurusan_id
        Asesi::create([
            'user_id'     => $user->id,
            'jurusan_id'  => $request->jurusan_id,
            'nama_lengkap' => $request->name,
            'email'       => $request->email,
            // Kolom lain bisa diisi null atau default value
        ]);

        // Login otomatis setelah registrasi (opsional)
        // Auth::login($user);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}