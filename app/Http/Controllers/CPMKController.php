<?php

namespace App\Http\Controllers;

use App\Models\Bobotcpl;
use App\Models\Btp;
use App\Models\Cpmk;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Validator;

class CPMKController extends Controller
{
    public function index()
    {
        // Nilai tetap
        $judul = 'Kelola CPMK';
        $parent = 'CPMK';

        $tampil = Cpmk::with('mata_kuliah')->get();

        return view('cpmk.index', [
            'cpmk' => $tampil,
            'judul' => $judul,
            'parent' => $parent,
        ]);
    }

    public function tambahindex()
    {
        // Nilai tetap
        $judul = 'Tambah CPMK';
        $judulform = 'Form Tambah CPMK';
        $parent = 'CPMK';
        $subparent = 'Tambah';

        $mk = MataKuliah::orderBy('nama')->get();

        return view('cpmk.tambah', [
            'mk' => $mk,
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
            'subparent' => $subparent,
        ]);
    }

    public function editindex(int $id)
    {
        // Nilai tetap
        $judul = 'Edit CPMK';
        $parent = 'CPMK';
        $subparent = 'Edit';

        $mk = MataKuliah::get();
        $cpmk = Cpmk::find($id);

        return view('cpmk.edit', [
            'judul' => $judul,
            'parent' => $parent,
            'subparent' => $subparent,
            'cpmk' => $cpmk,
            'mk' => $mk
        ]);
    }

    public function tambah(Request $request)
    {
        $id_mk = $request->input('mata_kuliah');
        $kode_cpmk = $request->input('kode_cpmk');
        $cek_ada = Cpmk::where([
            ['mata_kuliah_id', '=', $id_mk],
            ['kode_cpmk', '=', $kode_cpmk]
        ])->count();

        if ($cek_ada !== 0)
        {
            return back()->with('error', 'Mata Kuliah Dengan Kode CPMK Yang Dimasukkan Sudah Ada!');
        }

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

    public function edit(Request $request, int $id)
    {
        $id_mk_ori = $request->input('mata_kuliah-ori');
        $kode_cpmk_ori = $request->input('kode_cpmk-ori');
        $id_mk = $request->input('mata_kuliah');
        $kode_cpmk = $request->input('kode_cpmk');
        $cek_ada = Cpmk::where([
            ['mata_kuliah_id', '=', $id_mk],
            ['kode_cpmk', '=', (string)$kode_cpmk]
        ])->count();

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

        if ($id_mk_ori !== $id_mk || $kode_cpmk_ori !== $kode_cpmk)
        {
            if ($cek_ada !== 0)
            {
                return back()->with('error', 'Mata Kuliah Dengan Kode CPMK Yang Dimasukkan Sudah Ada!');
            }
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

    public function hapus(int $id)
    {
        $cek_btp = Btp::where('cpmk_id', $id)->count();
        $cek_bcpl = Bobotcpl::where('cpmk_id', $id)->count();
        if ($cek_btp === 0 || $cek_bcpl === 0) {
            Cpmk::find($id)->delete();

            return redirect()->route('cpmk');
        }

        return back()->with('error', 'Data yang ingin dihapus masih digunakan!');
    }
}
