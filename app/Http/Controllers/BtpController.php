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
        $tampil = Btp::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'dosen_admin'
        )->whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'"
        )->get();

        return view('aksi.btp_cari', [
            'data' => $tampil,
            'ta' => $ta,
            'cpmk' => $cpmk,
            'mk' => $mk,
            'da' => $da,
            'id_ta' => $id_ta,
            'id_sem' => $id_sem,
            'id_mk' => $id_mk,
        ]);
    }
}
