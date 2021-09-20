<?php

namespace App\Http\Controllers;

use App\Models\DosenAdmin;

class AdminController extends Controller
{
    public function index()
    {
        $tampil = DosenAdmin::whereHas('user', function ($query) {
            return $query->whereRaw("status IN ('Admin')");
        })->get();

        return view('admin', ['admin' => $tampil]);
    }
}
