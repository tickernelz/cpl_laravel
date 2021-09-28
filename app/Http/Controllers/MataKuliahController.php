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
            'matakuliah' => $tampil
        ]);
    }

    public function tambah(Request $request)
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

    public function edit(Request $request, int $id)
    {
        $mkori = $request->input('kode-ori');
        $mkedit = $request->input('kode');

        $rules1 = [
            'kode' => 'required|string',
            'nama' => 'required|string',
        ];

        $rules2 = [
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

        if ($mkori === $mkedit) {
            $validator = Validator::make($request->all(), $rules1, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            $mk = MataKuliah::where('id', $id)->first();
            $mk->kode = $request->input('kode');
            $mk->nama = $request->input('nama');
            $mk->save();

            return back()->with('success', 'Data Berhasil Diubah!.');
        }
        $validator = Validator::make($request->all(), $rules2, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $mk = MataKuliah::where('id', $id)->first();
        $mk->kode = $request->input('kode');
        $mk->nama = $request->input('nama');
        $mk->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function hapus(int $id)
    {
        MataKuliah::find($id)->delete();

        return redirect()->route('mk');
    }
}
