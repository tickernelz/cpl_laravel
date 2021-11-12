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
        $judulform = 'Form Tambah Dosen';
        $parent = 'Admin';
        $subparent = 'Tambah';

        return view('admin.tambah', [
            'judul' => $judul,
            'judulform' => $judulform,
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

        $validator = Validator::make($request->all(), $rules);

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
        $data = DosenAdmin::with('user')->where('id', $id)->first();

        $rules = [
            'nip' => 'required|integer|unique:dosen_admins,nip,'.$data->id,
            'nama' => 'required|string',
            'username' => 'required|string|unique:users,username,'.$data->user->id,
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data->nip = $request->input('nip');
        $data->nama = $request->input('nama');
        $data->user->username = $request->input('username');
        if ($data->user->password !== $request->input('password')) {
            $data->user->password = bcrypt($request->input('password'));
        }
        $data->user->save();
        $data->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function hapus(int $id)
    {
        DosenAdmin::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('admin');
    }
}
