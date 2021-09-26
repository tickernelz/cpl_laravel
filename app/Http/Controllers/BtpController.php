<?php

namespace App\Http\Controllers;

use App\Models\Bobotcpl;
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
        $ta = TahunAjaran::orderBy('tahun', 'asc')->get();
        $mk = MataKuliah::orderBy('nama', 'asc')->get();

        return view('btp', [
            'ta' => $ta,
            'mk' => $mk,
        ]);
    }

    public function getBtp(Request $request)
    {
        $id_btp = $request->id;
        $databtp = Btp::whereId($id_btp)->get();
        return Response()->json($databtp);
    }

    public function cari(Request $request)
    {
        $ta = TahunAjaran::orderBy('tahun', 'asc')->get();
        $mk = MataKuliah::orderBy('nama', 'asc')->get();
        $cpmk = Cpmk::orderBy('nama_cpmk', 'asc')->get();
        $da = DosenAdmin::orderBy('nama', 'asc')->get();
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
        $tampil = Btp::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'dosen_admin'
        )->whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$semester'"
        )->get();
        $sum_bobot = $tampil->sum('bobot') + $bobot;
        if ($sum_bobot <= 100) {
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
        return back()->with('error', 'Bobot Yang Ditambahkan Melebihi 100.');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $id_ta = $request->id_ta;
        $id_mk = $request->id_mk;
        $id_cpmk = $request->id_cpmk;
        $id_dosen = $request->id_dosen;
        $teknik = $request->teknik;
        $semester = $request->semester;
        $kategori = $request->kategori;
        $bobot = $request->bobot;
        $tampil = Btp::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'dosen_admin'
        )->whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$semester'"
        )->get();
        $sum_bobot = $tampil->whereNotIn('id', [$id])->sum('bobot') + $bobot;
        if ($sum_bobot <= 100) {
            $btp = Btp::find($id);
            $btp->tahun_ajaran_id = $id_ta;
            $btp->mata_kuliah_id = $id_mk;
            $btp->cpmk_id = $id_cpmk;
            $btp->dosen_admin_id = $id_dosen;
            $btp->nama = (string)$teknik;
            $btp->semester = (string)$semester;
            $btp->kategori = (string)$kategori;
            $btp->bobot = $bobot;
            $save = $btp->save();
            return Response()->json($save);
        }
        return back()->with('error', 'Bobot Yang Ditambahkan Melebihi 100!');
    }

    public function hapus(Request $request)
    {
        $id = $request->id;
        $cek = Bobotcpl::where('btp_id', $id)->count();
        if ($cek === 0) {
            $hapus = Btp::find($id)->delete();
            return Response()->json($hapus);
        }
        return response()->json(['error' => 'Data yang ingin dihapus masih digunakan!'], 409);
    }
}
