<?php

namespace App\Http\Controllers;

use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Crypt;
use Illuminate\Http\Request;

class KRSController extends Controller
{
    public function index()
    {
        // Nilai tetap
        $judul = 'Kelola KRS';
        $parent = 'KRS';
        $judulform = 'Cari Data KRS';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();
        $mhs = Mahasiswa::orderBy('nim')->get();

        return view('krs.index', [
            'ta' => $ta,
            'mk' => $mk,
            'mhs' => $mhs,
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
        ]);
    }

    public function cari(Request $request)
    {
        // Nilai tetap
        $judul = 'Kelola KRS';
        $parent = 'KRS';
        $subparent = 'Cari';
        $judulform = 'Cari Data KRS';

        // Ambil Data
        $ta = TahunAjaran::orderBy('tahun')->get();
        $mhs = Mahasiswa::orderBy('nim')->get();
        $mk = MataKuliah::orderBy('nama')->get();

        // Get Request
        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mhs = Crypt::decrypt($request->nim);
        $nama_mhs = Mahasiswa::where('id', $id_mhs)->value('nama');
        $ada_mhs = Mahasiswa::where('id', $id_mhs)->get();
        $tampil = KRS::with(
            'mahasiswa', 'tahun_ajaran', 'mata_kuliah'
        )->whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mahasiswa_id = '$id_mhs' AND semester = '$id_sem'"
        )->get();
        $arraymk = $tampil->pluck('mata_kuliah_id')->toArray();
        if (isset($tampil)) {
            $tampilselain = MataKuliah::whereNotIn('id', $arraymk)->get();
        } else {
            $tampilselain = MataKuliah::get();
        }
        if (count($ada_mhs) > 0) {
            return view(
                'krs.cari',
                [
                    'data' => $tampil,
                    'dataselain' => $tampilselain,
                    'ta' => $ta,
                    'mhs' => $mhs,
                    'mk' => $mk,
                    'id_ta' => $id_ta,
                    'id_sem' => $id_sem,
                    'id_mhs' => $id_mhs,
                    'nama_mhs' => $nama_mhs,
                    'judul' => $judul,
                    'judulform' => $judulform,
                    'parent' => $parent,
                    'subparent' => $subparent,
                ]
            );
        }
        return redirect()->route('krs')->with('error', 'Data tidak ditemukan!.');
    }

    public function store(Request $request)
    {
        $mkId = $request->id_mk;
        $nim = $request->id_mhs;
        $krs = KRS::Create(
            [
                'mata_kuliah_id' => $mkId,
                'mahasiswa_id' => $nim,
                'tahun_ajaran_id' => $request->id_ta,
                'semester' => $request->sem,
            ]
        );

        return Response()->json($krs);
    }


    public function hapus(Request $request)
    {
        $krsId = $request->id;
        $hapus = KRS::find($krsId)->delete();

        return Response()->json($hapus);
    }
}
