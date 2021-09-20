<?php

namespace App\Http\Controllers;

use App\Models\Cpmk;

class CpmkController extends Controller
{
    public function index()
    {
        $tampil = Cpmk::with('mata_kuliah')->get();
        //$tampil->pluck('mata_kuliah.nama')->toArray();
        return view('cpmk', ['cpmk' => $tampil]);
    }
}
