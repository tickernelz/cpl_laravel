<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Validator;

class MahasiswaController extends Controller
{
    public function index()
    {
        // Nilai tetap
        $judul = 'Kelola Mahasiswa';
        $parent = 'Mahasiswa';

        $tampil = Mahasiswa::get();

        return view('mahasiswa.index', [
            'mahasiswa' => $tampil,
            'judul' => $judul,
            'parent' => $parent,
        ]);
    }

    public function tambahindex()
    {
        // Nilai tetap
        $judul = 'Tambah Mahasiswa';
        $judulform = 'Form Tambah Mahasiswa';
        $parent = 'Mahasiswa';
        $subparent = 'Tambah';

        return view('mahasiswa.tambah', [
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
            'subparent' => $subparent,
        ]);
    }

    public function editindex(int $id)
    {
        // Nilai tetap
        $judul = 'Edit Mahasiswa';
        $parent = 'Mahasiswa';
        $subparent = 'Edit';

        $tampil = Mahasiswa::find($id);

        return view('mahasiswa.edit', [
            'judul' => $judul,
            'parent' => $parent,
            'subparent' => $subparent,
            'mahasiswa' => $tampil
        ]);
    }

    public function tambah(Request $request)
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

    public function edit(Request $request, int $id)
    {
        $nimori = $request->input('nim-ori');
        $nimedit = $request->input('nim');

        $rules1 = [
            'nim' => 'required|string',
            'nama' => 'required|string',
            'angkatan' => 'required|integer',
        ];

        $rules2 = [
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

        if ($nimori === $nimedit) {
            $validator = Validator::make($request->all(), $rules1, $messages);

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
        $validator = Validator::make($request->all(), $rules2, $messages);

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

    public function hapus(int $id)
    {
        Mahasiswa::find($id)->delete();

        return redirect()->route('mhs');
    }
}
