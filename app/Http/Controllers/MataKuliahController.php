<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;

class MataKuliahController extends Controller
{
    public function index()
    {
        $tampil = MataKuliah::get();

        return view('matakuliah', ['mk' => $tampil]);
    }
}
