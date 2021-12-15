<?php

namespace App\Http\Controllers;

use App\Models\Bobotcpl;
use App\Models\Btp;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\DosenAdmin;
use App\Models\Kcpl;
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
        $cpmk = $request->cpmk;
        $tampil = Btp::where([
            ['tahun_ajaran_id', '=', $id_ta],
            ['mata_kuliah_id', '=', $id_mk],
            ['semester', '=', $id_sem],
            ['cpmk_id', '=', $cpmk],
        ])->get();

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
        $id_user = Auth::user()->id;
        $cekstatus = Auth::user()->status;
        $id_dosen = DosenAdmin::with('user')->firstWhere('id', $id_user)->id;
        $getDosen = Rolesmk::with('dosen_admin')->firstWhere([
            ['tahun_ajaran_id', '=', $id_ta],
            ['mata_kuliah_id', '=', $id_mk],
            ['semester', '=', $id_sem],
            ['dosen_admin_id', '=', $id_dosen],
            ['status', '=', 'koordinator'],
        ]);
        if (isset($getDosen) || $cekstatus === 'Admin') {
            $cpmk_mk = Cpmk::with('mata_kuliah')->where('mata_kuliah_id', $id_mk)->get();
            $tampil = Bobotcpl::with(
                'tahun_ajaran',
                'mata_kuliah',
                'cpmk',
                'cpl',
                'btp'
            )->where([
                ['tahun_ajaran_id', '=', $id_ta],
                ['mata_kuliah_id', '=', $id_mk],
                ['semester', '=', $id_sem],
            ])->get();
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
        )->where([
            ['tahun_ajaran_id', '=', $id_ta],
            ['mata_kuliah_id', '=', $id_mk],
            ['semester', '=', $semester],
        ])->get();
        $cek = Bobotcpl::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'cpl',
            'btp'
        )->firstWhere([
            ['tahun_ajaran_id', '=', $id_ta],
            ['mata_kuliah_id', '=', $id_mk],
            ['semester', '=', $semester],
            ['cpmk_id', '=', $id_cpmk],
            ['cpl_id', '=', $id_cpl],
            ['btp_id', '=', $id_btp],
        ]);
        $sum_bobot = $tampil->sum('bobot_cpl') + $bobot;
        if ($id_btp !== '0' && isset($id_btp) && is_null($cek) && $sum_bobot <= 100.1) {
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
        $id_cpmk_ori = $request->id_cpmk_ori;
        $id_cpmk = $request->id_cpmk;
        $id_cpl_ori = $request->id_cpl_ori;
        $id_cpl = $request->id_cpl;
        $id_btp_ori = $request->id_btp_ori;
        $id_btp = $request->id_btp;
        $semester = $request->semester;
        $bobot = $request->bobot;
        $tampil = Bobotcpl::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'cpl',
            'btp'
        )->where([
            ['tahun_ajaran_id', '=', $id_ta],
            ['mata_kuliah_id', '=', $id_mk],
            ['semester', '=', $semester],
        ])->get();

        if ($id_cpmk_ori !== $id_cpmk || $id_cpl_ori !== $id_cpl || $id_btp_ori !== $id_btp)
        {
            $cek = Bobotcpl::with(
                'tahun_ajaran',
                'mata_kuliah',
                'cpmk',
                'cpl',
                'btp'
            )->firstWhere([
                ['tahun_ajaran_id', '=', $id_ta],
                ['mata_kuliah_id', '=', $id_mk],
                ['semester', '=', $semester],
                ['cpmk_id', '=', $id_cpmk],
                ['cpl_id', '=', $id_cpl],
                ['btp_id', '=', $id_btp],
            ]);
        } else {
            $cek = null;
        }

        $sum_bobot = $tampil->whereNotIn('id', [$id])->sum('bobot_cpl') + $bobot;
        if ($id_btp !== '0' && isset($id_btp) && is_null($cek) &&  $sum_bobot <= 100.1) {
            $btp = Bobotcpl::with('cpl')->firstWhere('id', $id);
            $Kcpl = Kcpl::firstWhere([
                ['tahun_ajaran_id', '=', $id_ta],
                ['mata_kuliah_id', '=', $id_mk],
                ['semester', '=', $semester],
                ['bobotcpl_id', '=', $id],
            ]);
            $btp->tahun_ajaran_id = $id_ta;
            $btp->mata_kuliah_id = $id_mk;
            $btp->cpmk_id = $id_cpmk;
            $btp->cpl_id = $id_cpl;
            $btp->btp_id = $id_btp;
            $btp->semester = (string) $semester;
            $btp->bobot_cpl = $bobot;
            $btp->save();
            $btp1 = Bobotcpl::with('cpl')->firstWhere('id', $id);
            if (isset($Kcpl))
            {
                $Kcpl->cpl_id = $id_cpl;
                $Kcpl->kode_cpl = $btp1->cpl->kode_cpl;
                $Kcpl->save();
            }

            return Response()->json();
        }

        return back()->with('error', 'Bobot Yang Ditambahkan Melebihi 100.');
    }

    public function hapus(Request $request)
    {
        $id_bcpl = $request->id;
        $hapus_bcpl = Bobotcpl::find($id_bcpl)->delete();
        $hapus_Kcpl = Kcpl::where('bobotcpl_id', $id_bcpl)->get();
        foreach ($hapus_Kcpl as $li) {
            $li->delete();
        }

        return Response()->json([$hapus_bcpl, $hapus_Kcpl]);
    }
}
