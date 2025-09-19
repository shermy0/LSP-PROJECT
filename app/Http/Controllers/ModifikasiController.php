<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;


class ModifikasiController extends Controller
{
public function index($skema_id)
{
    $skema = Skema::findOrFail($skema_id);
    return view('form_perencanaan.form_mapa_01.mapa01_modifikasi', compact('skema'));
}

}
