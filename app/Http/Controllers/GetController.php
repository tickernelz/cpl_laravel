<?php

namespace App\Http\Controllers;

use App\Models\DosenAdmin;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getUsername()
    {
        $user = Auth::user(); // returns an instance of the authenticated user...
        $username = $user->username;

        return $username;
    }

    public static function getNama()
    {
        $user = Auth::user(); // returns an instance of the authenticated user...
        $id = $user->id;
        $dosenadmin = DosenAdmin::with('user')->where('id', $id)->first();
        $nama = $dosenadmin->nama;

        return $nama;
    }

    public static function getRoles()
    {
        $user = Auth::user(); // returns an instance of the authenticated user...
        $roles = $user->getRoleNames()->implode('');

        return $roles;
    }
}
