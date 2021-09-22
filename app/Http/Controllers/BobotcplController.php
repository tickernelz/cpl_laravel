<?php

namespace App\Http\Controllers;

use App\Models\Bobotcpl;
use App\Models\Btp;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Crypt;
use Illuminate\Http\Request;

class BobotcplController extends Controller
{
    public function index()
    {
        $ta = TahunAjaran::get();
        $mk = MataKuliah::get();
        $cpmk = Cpmk::get();
        $cpl = Cpl::get();

        return view('bcpl', [
            'ta' => $ta,
            'mk' => $mk,
            'cpmk' => $cpmk,
            'cpl' => $cpl,
        ]);
    }

    public function get(Request $request)
    {
        $id = $request->id;
        $data = Bobotcpl::whereId($id)->get();
        return Response()->json($data);
    }

    public function cekTeknik(Request $request)
    {
        $id_ta = Crypt::decrypt($request->id_ta);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->id_mk);
        $cpmk = $request->cpmk;
        $tampil = Btp::whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND cpmk_id = '$cpmk'"
        )->get();
        return Response()->json($tampil);
    }

    public function cari(Request $request)
    {
        $ta = TahunAjaran::get();
        $mk = MataKuliah::get();
        $cpmk = Cpmk::get();
        $cpl = Cpl::get();
        $btp = Btp::get();
        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $cpmk_mk = Cpmk::with('mata_kuliah')->where('mata_kuliah_id', $id_mk)->get();
        $tampil = Bobotcpl::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'cpl',
            'btp'
        )->whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'"
        )->get();
        $sum_bobot = $tampil->sum('bobot_cpl');

        return view('aksi.bcpl_cari', [
            'data' => $tampil,
            'total_bobot' => $sum_bobot,
            'ta' => $ta,
            'cpmk' => $cpmk,
            'cpmk_mk' => $cpmk_mk,
            'mk' => $mk,
            'id_ta' => $id_ta,
            'id_sem' => $id_sem,
            'id_mk' => $id_mk,
            'cpl' => $cpl,
            'btp' => $btp,
        ]);
    }

    public function store(Request $request)
    {
        $id_ta = $request->id_ta;
        $id_mk = $request->id_mk;
        $id_cpmk = $request->id_cpmk;
        $id_cpl = $request->id_cpl;
        $id_btp = $request->id_btp;
        $semester = $request->semester;
        $bobot = $request->bobot;
        $tampil = Bobotcpl::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'cpl',
            'btp'
        )->whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$semester'"
        )->get();
        $sum_bobot = $tampil->sum('bobot_cpl') + $bobot;
        if ($sum_bobot <= 100) {
            $bcpl = Bobotcpl::Create(
                [
                    'tahun_ajaran_id' => $id_ta,
                    'mata_kuliah_id' => $id_mk,
                    'cpmk_id' => $id_cpmk,
                    'cpl_id' => $id_cpl,
                    'btp_id' => $id_btp,
                    'semester' => $semester,
                    'bobot_cpl' => $bobot,
                ]
            );
            return Response()->json($bcpl);
        }
        return back()->with('error', 'Bobot Yang Ditambahkan Melebihi 100.');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $id_ta = $request->id_ta;
        $id_mk = $request->id_mk;
        $id_cpmk = $request->id_cpmk;
        $id_cpl = $request->id_cpl;
        $id_btp = $request->id_btp;
        $semester = $request->semester;
        $bobot = $request->bobot;
        $tampil = Bobotcpl::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'cpl',
            'btp'
        )->whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$semester'"
        )->get();
        $sum_bobot = $tampil->whereNotIn('id', [$id])->sum('bobot_cpl') + $bobot;
        if ($sum_bobot <= 100) {
            $btp = Bobotcpl::find($id);
            $btp->tahun_ajaran_id = $id_ta;
            $btp->mata_kuliah_id = $id_mk;
            $btp->cpmk_id = $id_cpmk;
            $btp->cpl_id = $id_cpl;
            $btp->btp_id = $id_btp;
            $btp->semester = (string)$semester;
            $btp->bobot_cpl = $bobot;
            $save = $btp->save();
            return Response()->json($save);
        }
        return back()->with('error', 'Bobot Yang Ditambahkan Melebihi 100.');
    }

    public function hapus(Request $request)
    {
        $id = $request->id;
        $hapus = Bobotcpl::find($id)->delete();

        return Response()->json($hapus);
    }
}
