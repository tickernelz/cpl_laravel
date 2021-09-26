<?php

namespace App\Http\Controllers;

use App\Models\DosenAdmin;
use Auth;

class BackendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getNama()
    {
        $user = Auth::user(); // returns an instance of the authenticated user...
        $id = $user->id;
        $dosenadmin = DosenAdmin::with('user')->where('id', $id)->first();
        return $dosenadmin->nama;
    }

}
