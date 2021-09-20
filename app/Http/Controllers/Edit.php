<?php

namespace App\Http\Controllers;

use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\DosenAdmin;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class Edit extends Controller
{
    public function indexadmin($id)
    {
        $user = DosenAdmin::with('user')->find($id);

        return view('aksi.admin_edit', ['admin' => $user]);
    }

    public function indexdosen($id)
    {
        $user = DosenAdmin::with('user')->find($id);

        return view('aksi.dosen_edit', ['dosen' => $user]);
    }

    public function indexmhs($id)
    {
        $tampil = Mahasiswa::find($id);

        return view('aksi.mhs_edit', ['mahasiswa' => $tampil]);
    }

    public function indexta($id)
    {
        $tampil = TahunAjaran::find($id);

        return view('aksi.ta_edit', ['ta' => $tampil]);
    }

    public function indexmk($id)
    {
        $tampil = MataKuliah::find($id);

        return view('aksi.mk_edit', ['mk' => $tampil]);
    }

    public function indexcpl($id)
    {
        $tampil = Cpl::find($id);

        return view('aksi.cpl_edit', ['cpl' => $tampil]);
    }

    public function indexcpmk($id)
    {
        $mk = MataKuliah::get();
        $tampil = Cpmk::find($id);

        return view('aksi.cpmk_edit', [
            'cpmk' => $tampil,
            'mk' => $mk,
        ]);
    }

    public function admin(Request $request, $id)
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

        $dosenadmin = DosenAdmin::with('user')->where('id', $id)->first();
        $dosenadmin->nip = $request->input('nip');
        $dosenadmin->nama = $request->input('nama');
        $dosenadmin->user->username = $request->input('username');
        $dosenadmin->user->password = bcrypt($request->input('password'));
        $dosenadmin->user->save();
        $dosenadmin->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function dosen(Request $request, $id)
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

    public function mhs(Request $request, $id)
    {
        $rules = [
            'nim' => 'required|string',
            'nama' => 'required|string',
            'angkatan' => 'required|integer',
        ];

        $messages = [
            'nim.required' => 'NIM wajib diisi',
            'nim.string' => 'NIM tidak valid',
            'nama.required' => 'Nama wajib diisi',
            'nama.string' => 'Nama tidak valid',
            'angkatan.required' => 'Angkatan wajib diisi',
            'angkatan.integer' => 'Angkatan harus berupa angka',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $mhs = Mahasiswa::where('id', $id)->first();
        $mhs->nim = $request->input('nim');
        $mhs->nama = $request->input('nama');
        $mhs->angkatan = $request->input('angkatan');
        $mhs->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function ta(Request $request, $id)
    {
        $rules = [
            'tahun' => 'required|string|unique:tahun_ajarans',
        ];

        $messages = [
            'tahun.required' => 'Tahun Ajaran wajib diisi',
            'tahun.unique' => 'Tahun Ajaran harus beda dari yang lain',
            'tahun.string' => 'Tahun Ajaran tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $ta = TahunAjaran::where('id', $id)->first();
        $ta->tahun = $request->input('tahun');
        $ta->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function mk(Request $request, $id)
    {
        $rules = [
            'kode' => 'required|string',
            'nama' => 'required|string',
        ];

        $messages = [
            'kode.required' => 'Kode Mata Kuliah wajib diisi',
            'kode.string' => 'Kode Mata Kuliah tidak valid',
            'nama.required' => 'Nama Mata Kuliah wajib diisi',
            'nama.string' => 'Nama Mata Kuliah tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $mk = MataKuliah::where('id', $id)->first();
        $mk->kode = $request->input('kode');
        $mk->nama = $request->input('nama');
        $mk->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function cpl(Request $request, $id)
    {
        $rules = [
            'kode_cpl' => 'required|string',
            'nama_cpl' => 'required|string',
        ];

        $messages = [
            'kode_cpl.required' => 'Kode CPL wajib diisi',
            'kode_cpl.string' => 'Kode CPL tidak valid',
            'nama_cpl.required' => 'Nama CPL wajib diisi',
            'nama_cpl.string' => 'Nama CPL tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $cpl = Cpl::where('id', $id)->first();
        $cpl->kode_cpl = $request->input('kode_cpl');
        $cpl->nama_cpl = $request->input('nama_cpl');
        $cpl->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function cpmk(Request $request, $id)
    {
        $rules = [
            'kode_cpmk' => 'required|string',
            'nama_cpmk' => 'required|string',
        ];

        $messages = [
            'kode_cpmk.required' => 'Kode CPMK wajib diisi',
            'kode_cpmk.string' => 'Kode CPMK Kuliah tidak valid',
            'nama_cpmk.required' => 'Nama CPMK wajib diisi',
            'nama_cpmk.string' => 'Nama CPMK tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $cpmk = Cpmk::where('id', $id)->first();
        $cpmk->mata_kuliah_id = $request->input('mata_kuliah');
        $cpmk->kode_cpmk = $request->input('kode_cpmk');
        $cpmk->nama_cpmk = $request->input('nama_cpmk');
        $cpmk->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }
}
