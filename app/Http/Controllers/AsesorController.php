<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asesor;

class AsesorController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->get('q', '');
        $asesor = Asesor::where('nama_asesor', 'like', "%{$q}%")
                        ->get(['id_asesor', 'nama_asesor']);
        return response()->json($asesor);
    }
}
