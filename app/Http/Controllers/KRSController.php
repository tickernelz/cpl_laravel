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
        $ta = TahunAjaran::orderBy('tahun', 'asc')->get();
        $mk = MataKuliah::get();

        return view(
            'krs',
            [
                'ta' => $ta,
                'mk' => $mk,
            ]
        );
    }

    //end index()

    public function carimhs(Request $request)
    {
        $res = Mahasiswa::select('nim')
            ->where('nim', 'LIKE', "%{$request->term}%")
            ->get();

        return response()->json($res);
    }

    public function cari(Request $request)
    {
        $ta = TahunAjaran::orderBy('tahun', 'asc')->get();
        $mhs = Mahasiswa::get();
        $mk = TahunAjaran::orderBy('nama', 'asc')->get();
        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $nim = $request->nim;
        $id_mhs = Mahasiswa::where('nim', $nim)->value('id');
        $nama_mhs = Mahasiswa::where('nim', $nim)->value('nama');
        $ada_mhs = Mahasiswa::where('nim', $nim)->get();
        $tampil = KRS::with('mahasiswa', 'tahun_ajaran', 'mata_kuliah')->whereRaw("tahun_ajaran_id = '$id_ta' AND mahasiswa_id = '$id_mhs' AND semester = '$id_sem'")->get();
        $arraymk = $tampil->pluck('mata_kuliah_id')->toArray();
        if (isset($tampil)) {
            $tampilselain = MataKuliah::whereNotIn('id', $arraymk)->get();
        } else {
            $tampilselain = MataKuliah::get();
        }
        if (count($ada_mhs) > 0) {
            return view(
                'aksi.krs_cari',
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
                ]
            );
        }

        return redirect()->route('krs')->with('error', 'Data tidak ditemukan!.');
    }

    //end cari()

    public function store(Request $request)
    {
        $mkId = $request->id_mk;
        $nim = $request->id_mhs;
        $id_mhs = Mahasiswa::where('nim', $nim)->value('id');
        $krs = KRS::Create(
            [
                'mata_kuliah_id' => $mkId,
                'mahasiswa_id' => $id_mhs,
                'tahun_ajaran_id' => $request->id_ta,
                'semester' => $request->sem,
            ]
        );

        return Response()->json($krs);
    }

    //end store()

    public function hapus(Request $request)
    {
        $krsId = $request->id;
        $hapus = KRS::find($krsId)->delete();

        return Response()->json($hapus);
    }

    //end hapus()
}//end class
