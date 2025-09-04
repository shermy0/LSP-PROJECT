<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect langsung ke dashboard sesuai role
        if ($user->role == 'admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($user->role == 'asesor') {
            return redirect()->route('dashboard.asesor');
        } elseif ($user->role == 'asesi') {
            return redirect()->route('dashboard.asesi');
        }

        abort(403, 'Role tidak dikenali');
    }

    public function admin()
    {
        $totalAsesi  = DB::table('asesi')->count();
        $totalAsesor = DB::table('asesor')->count();
        $totalAdmin  = DB::table('admin')->count();

        $menus = [
            ['name' => 'Dashboard', 'route' => route('dashboard.admin'), 'icon' => 'fas fa-home'],
            ['name' => 'Data Peserta Uji', 'route' => '#', 'icon' => 'fas fa-users'],
        ];

        return view('dashboard.admin', compact('menus', 'totalAsesi', 'totalAsesor', 'totalAdmin'));
    }

    public function asesi()
    {
        $menus = [
            ['name' => 'Dashboard', 'route' => route('dashboard.asesi'), 'icon' => 'fas fa-home'],
            ['name' => 'Form Perencanaan', 'route' => route('formperencanaan'), 'icon' => 'fas fa-edit'],
        ];

        return view('asesi.dashboard', compact('menus'));
    }

    public function asesor()
    {
        $menus = [
            ['name' => 'Dashboard', 'route' => route('dashboard.asesor'), 'icon' => 'fas fa-home'],
            ['name' => 'Form Perencanaan', 'route' => route('formperencanaan'), 'icon' => 'fas fa-file-alt'],
        ];

        return view('asesor.dashboard', compact('menus'));
    }
}
