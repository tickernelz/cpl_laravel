<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function getNama()
    {
        $user = Auth::user(); // returns an instance of the authenticated user...
        $id = $user->id;
        $dosenadmin = DosenAdmin::with('user')->where('id', $id)->first();
        $nama = $dosenadmin->nama;

        return $nama;
    }
}
