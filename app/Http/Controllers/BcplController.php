<?php

namespace App\Http\Controllers;

use App\Models\Bobotcpl;
use App\Models\Btp;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\DosenAdmin;
use App\Models\kcpl;
use App\Models\MataKuliah;
use App\Models\Rolesmk;
use App\Models\TahunAjaran;
use Auth;
use Crypt;
use Illuminate\Http\Request;

class BcplController extends Controller
{
    public function index()
    {
        $judul = 'Kelola Bobot CPL';
        $parent = 'Bobot CPL';
        $judulform = 'Cari Data Bobot CPL';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();

        return view('bcpl.index', [
            'ta' => $ta,
            'mk' => $mk,
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
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
        $id_kelas = Crypt::decrypt($request->id_kelas);
        $cpmk = $request->cpmk;
        $tampil = Btp::whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND cpmk_id = '$cpmk' AND kelas = '$id_kelas'"
        )->get();

        return Response()->json($tampil);
    }

    public function cari(Request $request)
    {
        // Nilai tetap
        $judul = 'Kelola Bobot CPL';
        $parent = 'Bobot CPL';
        $subparent = 'Cari';
        $judulform = 'Cari Data Bobot CPL';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();
        $cpmk = Cpmk::orderBy('kode_cpmk')->get();
        $cpl = Cpl::orderBy('kode_cpl')->get();
        $btp = Btp::orderBy('nama')->get();
        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $id_kelas = Crypt::decrypt($request->kelas);
        $id_user = Auth::user()->id;
        $cekstatus = Auth::user()->status;
        $dosenadmin = DosenAdmin::with('user')->where('id', $id_user)->first();
        $id_dosen = $dosenadmin->id;
        $getDosen = Rolesmk::with('dosen_admin')
            ->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas' AND dosen_admin_id = '$id_dosen' AND status = 'koordinator'")
            ->first();
        if(isset($getDosen) || $cekstatus === 'Admin')
        {
            $cpmk_mk = Cpmk::with('mata_kuliah')->where('mata_kuliah_id', $id_mk)->get();
            $tampil = Bobotcpl::with(
                'tahun_ajaran',
                'mata_kuliah',
                'cpmk',
                'cpl',
                'btp'
            )->whereRaw(
                "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'"
            )->get();
            $sum_bobot = $tampil->sum('bobot_cpl');

            return view('bcpl.cari', [
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
                'judul' => $judul,
                'judulform' => $judulform,
                'parent' => $parent,
                'subparent' => $subparent,
            ]);
        }
        return redirect()->route('bcpl')->with('error', 'Maaf anda bukan dosen koordinator!');
    }

    public function store(Request $request)
    {
        $id_ta = $request->id_ta;
        $id_mk = $request->id_mk;
        $id_kelas =$request->id_kelas;
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
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$semester' AND kelas = '$id_kelas'"
        )->get();
        $sum_bobot = $tampil->sum('bobot_cpl') + $bobot;
        if ($id_btp !== '0' && isset($id_btp) && $sum_bobot <= 100.1) {
            $bcpl = Bobotcpl::Create(
                [
                    'tahun_ajaran_id' => $id_ta,
                    'mata_kuliah_id' => $id_mk,
                    'cpmk_id' => $id_cpmk,
                    'cpl_id' => $id_cpl,
                    'btp_id' => $id_btp,
                    'semester' => $semester,
                    'kelas' => $id_kelas,
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
        $id_kelas =$request->id_kelas;
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
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$semester' AND kelas = '$id_kelas'"
        )->get();
        $sum_bobot = $tampil->whereNotIn('id', [$id])->sum('bobot_cpl') + $bobot;
        if ($id_btp !== '0' && isset($id_btp) && $sum_bobot <= 100.1) {
           $btp = Bobotcpl::find($id);
           $btp->tahun_ajaran_id = $id_ta;
           $btp->mata_kuliah_id = $id_mk;
           $btp->cpmk_id = $id_cpmk;
           $btp->cpl_id = $id_cpl;
           $btp->btp_id = $id_btp;
           $btp->semester = (string)$semester;
           $btp->kelas = (string)$id_kelas;
           $btp->bobot_cpl = $bobot;
           $save = $btp->save();

           return Response()->json($save);
       }

        return back()->with('error', 'Bobot Yang Ditambahkan Melebihi 100.');
    }

    public function hapus(Request $request)
    {
        $id_bcpl= $request->id;
        $hapus_bcpl = Bobotcpl::find($id_bcpl)->delete();
        $hapus_kcpl = kcpl::where('bobotcpl_id', $id_bcpl)->get();
        foreach ($hapus_kcpl as $li)
        {
            $li->delete();
        }

        return Response()->json([$hapus_bcpl, $hapus_kcpl]);
    }
}
