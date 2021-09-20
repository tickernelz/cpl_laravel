<?php

namespace App\Http\Controllers;

use App\Models\Cpl;

class CplController extends Controller
{
    public function index()
    {
        $tampil = Cpl::get();

        return view('cpl', ['cpl' => $tampil]);
    }
}
