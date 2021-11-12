<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Validator;

class MataKuliahController extends Controller
{
    public function index()
    {
        // Nilai tetap
        $judul = 'Kelola Mata Kuliah';
        $parent = 'Mata Kuliah';

        $tampil = MataKuliah::get();

        return view('matakuliah.index', [
            'matakuliah' => $tampil,
            'judul' => $judul,
            'parent' => $parent,
        ]);
    }

    public function tambahindex()
    {
        // Nilai tetap
        $judul = 'Tambah Mata Kuliah';
        $judulform = 'Form Tambah Mata Kuliah';
        $parent = 'Mata Kuliah';
        $subparent = 'Tambah';

        return view('matakuliah.tambah', [
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
            'subparent' => $subparent,
        ]);
    }

    public function editindex(int $id)
    {
        // Nilai tetap
        $judul = 'Edit Mata Kuliah';
        $parent = 'Mata Kuliah';
        $subparent = 'Edit';

        $tampil = MataKuliah::find($id);

        return view('matakuliah.edit', [
            'judul' => $judul,
            'parent' => $parent,
            'subparent' => $subparent,
            'matakuliah' => $tampil,
        ]);
    }

    public function tambah(Request $request)
    {
        $rules = [
            'kode' => 'required|string|unique:mata_kuliahs',
            'nama' => 'required|string',
            'sks' => 'required|integer',
            'semester' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $mk = new MataKuliah();
        $mk->kode = $request->input('kode');
        $mk->nama = $request->input('nama');
        $mk->sks = $request->input('sks');
        $mk->semester = $request->input('semester');
        $mk->save();

        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }

    public function edit(Request $request, int $id)
    {
        $mk = MataKuliah::firstWhere('id', $id);

        $rules = [
            'kode' => 'required|string|unique:mata_kuliahs,kode,' . $mk->id,
            'nama' => 'required|string',
            'sks' => 'required|integer',
            'semester' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $mk = MataKuliah::where('id', $id)->first();
        $mk->kode = $request->input('kode');
        $mk->nama = $request->input('nama');
        $mk->sks = $request->input('sks');
        $mk->semester = $request->input('semester');
        $mk->save();

        return back()->with('success', 'Data Berhasil Diubah!');
    }

    public function hapus(int $id)
    {
        MataKuliah::find($id)->delete();

        return redirect()->route('mk');
    }
}
