<?php

namespace App\Http\Controllers;

use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $ta = TahunAjaran::get();
        $mk = MataKuliah::get();
        $cpmk = Cpmk::get();
        $cpl = Cpl::get();

        return view('nilai', [
            'ta' => $ta,
            'mk' => $mk,
            'cpmk' => $cpmk,
            'cpl' => $cpl,
        ]);
    }

    public function cari(Request $request)
    {

    }
}
