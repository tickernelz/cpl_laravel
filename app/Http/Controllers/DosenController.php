<?php

namespace App\Http\Controllers;

use App\Models\DosenAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class DosenController extends Controller
{
    public function index()
    {
        // Nilai tetap
        $judul = 'Kelola Dosen';
        $parent = 'Dosen';

        $tampil = DosenAdmin::whereHas('user', function ($query) {
            return $query->whereRaw("status IN ('Dosen Koordinator','Dosen Pengampu')");
        })->get();

        return view('dosen.index', [
            'dosen' => $tampil,
            'judul' => $judul,
            'parent' => $parent,
        ]);
    }

    public function tambahindex()
    {
        // Nilai tetap
        $judul = 'Tambah Dosen';
        $judulform = 'Form Tambah Dosen';
        $parent = 'Dosen';
        $subparent = 'Tambah';

        return view('dosen.tambah', [
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
            'subparent' => $subparent,
        ]);
    }

    public function editindex(int $id)
    {
        // Nilai tetap
        $judul = 'Edit Dosen';
        $parent = 'Dosen';
        $subparent = 'Edit';

        $user = DosenAdmin::with('user')->find($id);

        return view('dosen.edit', [
            'judul' => $judul,
            'parent' => $parent,
            'subparent' => $subparent,
            'dosen' => $user
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
        $user->status = $request->input('status');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        $status = $request->input('status');
        if ($status === 'Dosen Koordinator') {
            $user->assignRole('dosen_koordinator');
        } elseif ($status === 'Dosen Pengampu') {
            $user->assignRole('dosen_pengampu');
        }

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
        $cekpassword = $dosenadmin->user->password;
        if ($cekpassword !== $request->input('password')) {
            $dosenadmin->user->password = bcrypt($request->input('password'));
        } else {
            //do nothing
        }
        $dosenadmin->user->status = $request->input('status');
        $dosenadmin->user->save();
        $dosenadmin->save();
        $status = $request->input('status');
        if ($status === 'Dosen Koordinator') {
            User::find($id)->assignRole('dosen_koordinator');
        } elseif ($status === 'Dosen Pengampu') {
            User::find($id)->assignRole('dosen_pengampu');
        }

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function hapus(int $id)
    {
        DosenAdmin::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('dosen');
    }
}
