<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Validator;

class TahunAjaranController extends Controller
{
    public function index()
    {
        // Nilai tetap
        $judul = 'Kelola Tahun Ajaran';
        $parent = 'Tahun Ajaran';

        $tampil = TahunAjaran::get();

        return view('tahunajaran.index', [
            'tahunajaran' => $tampil,
            'judul' => $judul,
            'parent' => $parent,
        ]);
    }

    public function tambahindex()
    {
        // Nilai tetap
        $judul = 'Tambah Tahun Ajaran';
        $judulform = 'Form Tambah Tahun Ajaran';
        $parent = 'Tahun Ajaran';
        $subparent = 'Tambah';

        return view('tahunajaran.tambah', [
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
            'subparent' => $subparent,
        ]);
    }

    public function editindex(int $id)
    {
        // Nilai tetap
        $judul = 'Edit Tahun Ajaran';
        $parent = 'Tahun Ajaran';
        $subparent = 'Edit';

        $tampil = TahunAjaran::find($id);

        return view('tahunajaran.edit', [
            'judul' => $judul,
            'parent' => $parent,
            'subparent' => $subparent,
            'tahunajaran' => $tampil
        ]);
    }

    public function tambah(Request $request)
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

    public function edit(Request $request, int $id)
    {
        $taori = $request->input('ta-ori');
        $taedit = $request->input('tahun');

        $rules1 = [
            'tahun' => 'required|string',
        ];

        $rules2 = [
            'tahun' => 'required|string|unique:tahun_ajarans',
        ];

        $messages = [
            'tahun.required' => 'Tahun Ajaran wajib diisi',
            'tahun.unique' => 'Tahun Ajaran harus beda dari yang lain',
            'tahun.string' => 'Tahun Ajaran tidak valid',
        ];

        if ($taori === $taedit) {
            $validator = Validator::make($request->all(), $rules1, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            $ta = TahunAjaran::where('id', $id)->first();
            $ta->tahun = $request->input('tahun');
            $ta->save();

            return back()->with('success', 'Data Berhasil Diubah!.');
        }
        $validator = Validator::make($request->all(), $rules2, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $ta = TahunAjaran::where('id', $id)->first();
        $ta->tahun = $request->input('tahun');
        $ta->save();

        return back()->with('success', 'Data Berhasil Diubah!.');
    }

    public function hapus(int $id)
    {
        TahunAjaran::find($id)->delete();

        return redirect()->route('ta');
    }
}
