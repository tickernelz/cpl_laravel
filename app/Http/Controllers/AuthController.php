<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('home');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];
        $remember_me = $request->has('remember');

        Auth::attempt($data, $remember_me);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('home');
        } else { // false
            Session::flash('error', 'Username atau password salah');

            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif

        return redirect()->route('login');
    }
}
