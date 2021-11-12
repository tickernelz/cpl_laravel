<?php

namespace App\Http\Controllers;

use App\Models\Bobotcpl;
use App\Models\Btp;
use App\Models\Cpmk;
use App\Models\DosenAdmin;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\Rolesmk;
use App\Models\TahunAjaran;
use Auth;
use Crypt;
use Illuminate\Http\Request;

class BtpController extends Controller
{
    public function index()
    {
        $judul = 'Kelola Bobot Teknik Penilaian';
        $parent = 'Bobot Teknik Penilaian';
        $judulform = 'Cari Data Bobot Teknik Penilaian';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();

        return view('btp.index', [
            'ta' => $ta,
            'mk' => $mk,
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
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
        // Nilai tetap
        $judul = 'Kelola Bobot Teknik Penilaian';
        $parent = 'Bobot Teknik Penilaian';
        $subparent = 'Cari';
        $judulform = 'Cari Data Bobot Teknik Penilaian';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();
        $cpmk = Cpmk::orderBy('nama_cpmk')->get();
        $da = DosenAdmin::whereHas('user', function ($query) {
            return $query->whereRaw("status = 'Dosen'");
        })->orderBy('nama')->get();
        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $id_kelas = Crypt::decrypt($request->kelas);
        $id_user = Auth::user()->id;
        $cekstatus = Auth::user()->status;
        $id_dosen = DosenAdmin::with('user')->firstWhere('id', $id_user)->id;
        $getDosen = Rolesmk::with('dosen_admin')->firstWhere([
            ['tahun_ajaran_id' => $id_ta],
            ['mata_kuliah_id' => $id_mk],
            ['semester' => $id_sem],
            ['kelas' => $id_kelas],
            ['dosen_admin_id' => $id_dosen],
            ['status' => 'koordinator'],
        ]);
        if (isset($getDosen) || $cekstatus === 'Admin') {
            $cpmk_mk = Cpmk::with('mata_kuliah')->where('mata_kuliah_id', $id_mk)->get();
            $tampil = Btp::with(
                'tahun_ajaran',
                'mata_kuliah',
                'cpmk',
                'dosen_admin'
            )->where([
                ['tahun_ajaran_id' => $id_ta],
                ['mata_kuliah_id' => $id_mk],
                ['semester' => $id_sem],
                ['kelas' => $id_kelas],
            ])->get();
            $sum_bobot = $tampil->sum('bobot');

            return view('btp.cari', [
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
                'judul' => $judul,
                'judulform' => $judulform,
                'parent' => $parent,
                'subparent' => $subparent,
            ]);
        }

        return redirect()->route('btp')->with('error', 'Maaf anda bukan dosen koordinator!');
    }

    public function store(Request $request)
    {
        $id_ta = $request->id_ta;
        $id_mk = $request->id_mk;
        $id_cpmk = $request->id_cpmk;
        $id_dosen = $request->id_dosen;
        $id_kelas = $request->kelas;
        $teknik = $request->teknik;
        $semester = $request->semester;
        $kategori = $request->kategori;
        $bobot = $request->bobot;
        $tampil = Btp::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'dosen_admin'
        )->where([
            ['tahun_ajaran_id' => $id_ta],
            ['mata_kuliah_id' => $id_mk],
            ['semester' => $semester],
            ['kelas' => $id_kelas],
        ])->get();
        $sum_bobot = $tampil->sum('bobot') + $bobot;
        if ($sum_bobot <= 100.1) {
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
        $id_kelas = $request->kelas;
        $teknik = $request->teknik;
        $semester = $request->semester;
        $kategori = $request->kategori;
        $bobot = $request->bobot;
        $tampil = Btp::with(
            'tahun_ajaran',
            'mata_kuliah',
            'cpmk',
            'dosen_admin'
        )->where([
            ['tahun_ajaran_id' => $id_ta],
            ['mata_kuliah_id' => $id_mk],
            ['semester' => $semester],
            ['kelas' => $id_kelas],
        ])->get();
        $sum_bobot = $tampil->whereNotIn('id', [$id])->sum('bobot') + $bobot;
        if ($sum_bobot <= 100.1) {
            $btp = Btp::find($id);
            $btp->tahun_ajaran_id = $id_ta;
            $btp->mata_kuliah_id = $id_mk;
            $btp->cpmk_id = $id_cpmk;
            $btp->dosen_admin_id = $id_dosen;
            $btp->nama = (string) $teknik;
            $btp->semester = (string) $semester;
            $btp->kategori = (string) $kategori;
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
            $hapus_btp = Btp::find($id)->delete();
            $hapus_nilai = Nilai::where('btp_id')->get();
            foreach ($hapus_nilai as $li) {
                $li->delete();
            }

            return Response()->json([$hapus_btp, $hapus_nilai]);
        }

        return response()->json(['error' => 'Data yang ingin dihapus masih digunakan!'], 409);
    }
}
