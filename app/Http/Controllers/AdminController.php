<?php

namespace App\Http\Controllers;

use App\Models\DosenAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    public function index()
    {
        // Nilai tetap
        $judul = 'Kelola Admin';
        $active = 'Admin';
        $parent = 'Admin & Dosen';

        $tampil = DosenAdmin::whereHas('user', function ($query) {
            return $query->whereRaw("status IN ('Admin')");
        })->get();

        return view('admin.index', [
            'admin' => $tampil,
            'judul' => $judul,
            'active' => $active,
            'parent' => $parent,
        ]);
    }

    public function tambah(Request $request)
    {
        $rules = [
            'nip' => 'required|integer',
            'nama' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
        ];

        $messages = [
            'nip.required' => 'NIP wajib diisi',
            'nip.integer' => 'NIP harus berupa angka',
            'nama.required' => 'Nama wajib diisi',
            'nama.string' => 'Nama tidak valid',
            'username.required' => 'Username wajib diisi',
            'username.string' => 'Username tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa string',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->username = $request->input('username');
        $user->status = 'Admin';
        $user->password = bcrypt($request->input('password'));
        $user->save();
        $user->assignRole('admin');

        $dosenadmin = new DosenAdmin;
        $dosenadmin->nip = $request->input('nip');
        $dosenadmin->nama = $request->input('nama');
        $dosenadmin->user()->associate($user);
        $dosenadmin->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }
}
