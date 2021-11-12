<?php

namespace App\Http\Controllers;

use App\Models\Cpl;
use Illuminate\Http\Request;
use Validator;

class CPLController extends Controller
{
    public function index()
    {
        // Nilai tetap
        $judul = 'Kelola CPL';
        $parent = 'CPL';

        $tampil = Cpl::get();

        return view('cpl.index', [
            'cpl' => $tampil,
            'judul' => $judul,
            'parent' => $parent,
        ]);
    }

    public function tambahindex()
    {
        // Nilai tetap
        $judul = 'Tambah CPL';
        $judulform = 'Form Tambah CPL';
        $parent = 'CPL';
        $subparent = 'Tambah';

        return view('cpl.tambah', [
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
            'subparent' => $subparent,
        ]);
    }

    public function editindex(int $id)
    {
        // Nilai tetap
        $judul = 'Edit CPL';
        $parent = 'CPL';
        $subparent = 'Edit';

        $tampil = Cpl::find($id);

        return view('cpl.edit', [
            'judul' => $judul,
            'parent' => $parent,
            'subparent' => $subparent,
            'cpl' => $tampil,
        ]);
    }

    public function tambah(Request $request)
    {
        $rules = [
            'kode_cpl' => 'required|string|unique:cpls',
            'nama_cpl' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $cpl = new Cpl();
        $cpl->kode_cpl = $request->input('kode_cpl');
        $cpl->nama_cpl = $request->input('nama_cpl');
        $cpl->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }

    public function edit(Request $request, int $id)
    {
        $cpl = Cpl::firstWhere('id', $id);

        $rules = [
            'kode_cpl' => 'required|string|unique:cpls,kode_cpl,'.$cpl->id,
            'nama_cpl' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $cpl->kode_cpl = $request->input('kode_cpl');
        $cpl->nama_cpl = $request->input('nama_cpl');
        $cpl->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function hapus(int $id)
    {
        Cpl::find($id)->delete();

        return redirect()->route('cpl');
    }
}
