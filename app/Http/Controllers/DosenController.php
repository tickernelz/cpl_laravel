<?php

namespace App\Http\Controllers;

use App\Models\DosenAdmin;

class DosenController extends Controller
{
    public function index()
    {
        $tampil = DosenAdmin::whereHas('user', function ($query) {
            return $query->whereRaw("status IN ('Dosen Koordinator','Dosen Pengampu')");
        })->get();

        return view('dosen', ['dosen' => $tampil]);
    }
}
