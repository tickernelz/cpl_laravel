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

class Tambah extends Controller
{
    public function indexadmin()
    {
        return view('aksi.admin_tambah');
    }

    public function indexdosen()
    {
        return view('aksi.dosen_tambah');
    }

    public function indexmhs()
    {
        return view('aksi.mhs_tambah');
    }

    public function indexta()
    {
        return view('aksi.ta_tambah');
    }

    public function indexmk()
    {
        return view('aksi.mk_tambah');
    }

    public function indexcpl()
    {
        return view('aksi.cpl_tambah');
    }

    public function indexcpmk()
    {
        $mk = MataKuliah::orderBy('nama', 'asc')->get();

        return view('aksi.cpmk_tambah', [
            'mk' => $mk,
        ]);
    }

    public function admin(Request $request)
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

    public function dosen(Request $request)
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

    public function mhs(Request $request)
    {
        $rules = [
            'nim' => 'required|string|unique:mahasiswas',
            'nama' => 'required|string',
            'angkatan' => 'required|integer',
        ];

        $messages = [
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM harus beda dari yang lain',
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

        $mhs = new Mahasiswa();
        $mhs->nim = $request->input('nim');
        $mhs->nama = $request->input('nama');
        $mhs->angkatan = $request->input('angkatan');
        $mhs->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }

    public function ta(Request $request)
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

        $ta = new TahunAjaran();
        $ta->tahun = $request->input('tahun');
        $ta->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }

    public function mk(Request $request)
    {
        $rules = [
            'kode' => 'required|string|unique:mata_kuliahs',
            'nama' => 'required|string',
        ];

        $messages = [
            'kode.required' => 'Kode Mata Kuliah wajib diisi',
            'kode.unique' => 'Kode Mata Kuliah harus beda dari yang lain',
            'kode.string' => 'Kode Mata Kuliah tidak valid',
            'nama.required' => 'Nama Mata Kuliah wajib diisi',
            'nama.string' => 'Nama Mata Kuliah tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $mk = new MataKuliah();
        $mk->kode = $request->input('kode');
        $mk->nama = $request->input('nama');
        $mk->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }

    public function cpl(Request $request)
    {
        $rules = [
            'kode_cpl' => 'required|string|unique:cpls',
            'nama_cpl' => 'required|string',
        ];

        $messages = [
            'kode_cpl.required' => 'Kode Mata Kuliah wajib diisi',
            'kode_cpl.unique' => 'Kode Mata Kuliah harus beda dari yang lain',
            'kode_cpl.string' => 'Kode Mata Kuliah tidak valid',
            'nama_cpl.required' => 'Nama Mata Kuliah wajib diisi',
            'nama_cpl.string' => 'Nama Mata Kuliah tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $cpl = new Cpl();
        $cpl->kode_cpl = $request->input('kode_cpl');
        $cpl->nama_cpl = $request->input('nama_cpl');
        $cpl->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }

    public function cpmk(Request $request)
    {
        $rules = [
            'kode_cpmk' => 'required|string',
            'nama_cpmk' => 'required|string',
        ];

        $messages = [
            'kode_cpmk.required' => 'Kode CPMK wajib diisi',
            'kode_cpmk.string' => 'Kode CPMK tidak valid',
            'nama_cpmk.required' => 'Nama CPMK wajib diisi',
            'nama_cpmk.string' => 'Nama CPMK tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $cpmk = new Cpmk();
        $cpmk->mata_kuliah_id = $request->input('mata_kuliah');
        $cpmk->kode_cpmk = $request->input('kode_cpmk');
        $cpmk->nama_cpmk = $request->input('nama_cpmk');
        $cpmk->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }
}
