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
        $parent = 'Admin';

        $tampil = DosenAdmin::whereHas('user', function ($query) {
            return $query->whereRaw("status IN ('Admin')");
        })->get();

        return view('admin.index', [
            'admin' => $tampil,
            'judul' => $judul,
            'parent' => $parent,
        ]);
    }

    public function tambahindex()
    {
        // Nilai tetap
        $judul = 'Tambah Admin';
        $parent = 'Admin';
        $subparent = 'Tambah';

        return view('admin.tambah', [
            'judul' => $judul,
            'parent' => $parent,
            'subparent' => $subparent,
        ]);
    }

    public function editindex(int $id)
    {
        // Nilai tetap
        $judul = 'Edit Admin';
        $parent = 'Admin';
        $subparent = 'Edit';

        $user = DosenAdmin::with('user')->find($id);

        return view('admin.edit', [
            'judul' => $judul,
            'parent' => $parent,
            'subparent' => $subparent,
            'admin' => $user
        ]);
    }

    public function tambah(Request $request)
    {
        $rules = [
            'nip' => 'required|integer|unique:dosen_admins',
            'nama' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string',
        ];

        $messages = [
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP harus beda dari yang lain',
            'nip.integer' => 'NIP harus berupa angka',
            'nama.required' => 'Nama wajib diisi',
            'nama.string' => 'Nama tidak valid',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username harus beda dari yang lain',
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

    public function edit(Request $request, int $id)
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

        $dosenadmin = DosenAdmin::with('user')->where('id', $id)->first();
        $dosenadmin->nip = $request->input('nip');
        $dosenadmin->nama = $request->input('nama');
        $dosenadmin->user->username = $request->input('username');
        $dosenadmin->user->password = bcrypt($request->input('password'));
        $dosenadmin->user->save();
        $dosenadmin->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function hapus(int $id)
    {
        DosenAdmin::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('admin');
    }
}
