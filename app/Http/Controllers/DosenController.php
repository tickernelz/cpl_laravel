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
            return $query->whereRaw("status IN ('Dosen')");
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
        $user->status = 'Dosen';
        $user->password = bcrypt($request->input('password'));
        $user->save();
        $user->assignRole('dosen');

        $dosenadmin = new DosenAdmin;
        $dosenadmin->nip = $request->input('nip');
        $dosenadmin->nama = $request->input('nama');
        $dosenadmin->user()->associate($user);
        $dosenadmin->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }

    public function edit(Request $request, int $id)
    {
        $nipori = $request->input('nip-ori');
        $nipedit = $request->input('nip');
        $usernameori = $request->input('username-ori');
        $usernameedit = $request->input('username');
        $passori = $request->input('password-ori');
        $passedit = $request->input('password');

        $rules1 = [
            'nip' => 'required|integer',
            'nama' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
        ];

        $rules2 = [
            'nip' => 'required|integer|unique:dosen_admins',
            'nama' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string',
        ];

        $rules3 = [
            'nip' => 'required|integer|unique:dosen_admins',
            'nama' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
        ];

        $rules4 = [
            'nip' => 'required|integer',
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

        if ($nipori === $nipedit && $usernameori === $usernameedit) {
            return $this->extracted($request, $rules1, $messages, $id, $passori, $passedit);
        }

        if ($nipori === $nipedit) {
            return $this->extracted($request, $rules4, $messages, $id, $passori, $passedit);
        }

        if ($usernameori === $usernameedit) {
            return $this->extracted($request, $rules3, $messages, $id, $passori, $passedit);
        }

        return $this->extracted($request, $rules2, $messages, $id, $passori, $passedit);

    }

    public function hapus(int $id)
    {
        DosenAdmin::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('dosen');
    }

    /**
     * @param Request $request
     * @param array $rules1
     * @param array $messages
     * @param int $id
     * @param $passori
     * @param $passedit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function extracted(Request $request, array $rules1, array $messages, int $id, $passori, $passedit): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), $rules1, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $dosenadmin = DosenAdmin::with('user')->where('id', $id)->first();
        $dosenadmin->nip = $request->input('nip');
        $dosenadmin->nama = $request->input('nama');
        $dosenadmin->user->username = $request->input('username');
        if ($passori !== $passedit) {
            $dosenadmin->user->password = bcrypt($request->input('password'));
        }
        $dosenadmin->user->save();
        $dosenadmin->save();
        User::find($id)->assignRole('dosen');

        return back()->with('success', 'Data Berhasil Diubah!.');
    }
}
