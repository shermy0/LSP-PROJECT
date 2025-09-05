<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Menu otomatis berdasarkan role
        $menus = [];
        if ($user->role == 'admin') {
            $menus = [
                ['name' => 'Dashboard', 'route' => route('dashboard.admin'), 'icon' => 'fas fa-home'],
                ['name' => 'Data Peserta Uji', 'route' => '#', 'icon' => 'fas fa-users'],
            ];
        } elseif ($user->role == 'asesor') {
            $menus = [
                ['name' => 'Form Perencanaan', 'route' => route('formperencanaan'), 'icon' => 'fas fa-file-alt'],
            ];
        } elseif ($user->role == 'asesi') {
            $menus = [
                ['name' => 'Dashboard', 'route' => route('dashboard.asesi'), 'icon' => 'fas fa-home'],
                ['name' => 'Form Perencanaan', 'route' => route('formperencanaan'), 'icon' => 'fas fa-edit'],
            ];
        }

        return view('dashboard', compact('menus'));
    }

    public function admin()
    {
        $totalAsesi  = DB::table('asesi')->count();
        $totalAsesor = DB::table('asesor')->count();
        $totalAdmin  = DB::table('admin')->count();

        return view('dashboard.admin', compact('totalAsesi', 'totalAsesor', 'totalAdmin'));
    }

    public function asesi()
    {
        return view('asesi.dashboard');
    }

    public function asesor()
    {
        return view('formperencanaan'); // resources/views/formperencanaan.blade.php
    }

}
