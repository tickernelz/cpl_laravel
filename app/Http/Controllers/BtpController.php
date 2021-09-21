<?php

namespace App\Http\Controllers;

use App\Models\Btp;
use App\Models\Cpmk;
use App\Models\DosenAdmin;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Crypt;
use Illuminate\Http\Request;

class BtpController extends Controller
{
    public function index()
    {
        $ta = TahunAjaran::get();
        $mk = MataKuliah::get();
        $cpmk = Cpmk::get();
        $da = DosenAdmin::get();

        return view('btp', [
            'ta' => $ta,
            'mk' => $mk,
            'cpmk' => $cpmk,
            'da' => $da,
        ]);
    }

    public function cari(Request $request)
    {
        $ta = TahunAjaran::get();
        $mk = MataKuliah::get();
        $cpmk = Cpmk::get();
        $da = DosenAdmin::get();
        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $cpmk_mk = Cpmk::with('mata_kuliah')->where('mata_kuliah_id', $id_mk)->get();
        $tampil = Btp::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'dosen_admin'
        )->whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'"
        )->get();
        $sum_bobot = $tampil->sum('bobot');

        return view('aksi.btp_cari', [
            'data' => $tampil,
            'total_bobot' => $sum_bobot,
            'ta' => $ta,
            'cpmk' => $cpmk,
            'cpmk_mk' => $cpmk_mk,
            'mk' => $mk,
            'da' => $da,
            'id_ta' => $id_ta,
            'id_sem' => $id_sem,
            'id_mk' => $id_mk,
        ]);
    }

    public function store(Request $request)
    {
        $id_ta = $request->id_ta;
        $id_mk = $request->id_mk;
        $id_cpmk = $request->id_cpmk;
        $id_dosen = $request->id_dosen;
        $teknik = $request->teknik;
        $semester = $request->semester;
        $kategori = $request->kategori;
        $bobot = $request->bobot;
        $btp = Btp::Create(
            [
                'tahun_ajaran_id' => $id_ta,
                'mata_kuliah_id' => $id_mk,
                'cpmk_id' => $id_cpmk,
                'dosen_admin_id' => $id_dosen,
                'nama' => $teknik,
                'semester' => $semester,
                'kategori' => $kategori,
                'bobot' => $bobot,
            ]
        );
        return Response()->json($btp);
    }

    public function hapus(Request $request)
    {
        $id = $request->id;
        $hapus = Btp::find($id)->delete();

        return Response()->json($hapus);
    }
}
