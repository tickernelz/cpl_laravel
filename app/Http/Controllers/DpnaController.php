<?php

namespace App\Http\Controllers;

use App\Models\Btp;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Crypt;
use DB;
use Illuminate\Http\Request;

class DpnaController extends Controller
{
    public function index()
    {
        $judul = 'Kelola DPNA';
        $parent = 'DPNA';
        $judulform = 'Cari Data DPNA';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();
        $mhs = Mahasiswa::orderBy('nim')->get();

        return view('dpna.index', [
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
        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');
        // Nilai tetap
        $judul = 'Kelola DPNA';
        $parent = 'DPNA';
        $subparent = 'Cari';
        $judulform = 'Cari Data DPNA';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();
        $mhs = Mahasiswa::orderBy('nim')->get();

        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $id_mhs = Crypt::decrypt($request->mhs);
        $id_kelas = Crypt::decrypt($request->kelas);
        $getnilaitugas = Nilai::whereHas('btp', function ($q) use ($id_kelas, $id_sem, $id_mk, $id_ta) {
            $q->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas' AND kategori = '1'");
        })->get();
        $getnilaiuts = Nilai::whereHas('btp', function ($q) use ($id_kelas, $id_sem, $id_mk, $id_ta) {
            $q->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas' AND kategori = '2'");
        })->get();
        $getnilaiuas = Nilai::whereHas('btp', function ($q) use ($id_kelas, $id_sem, $id_mk, $id_ta) {
            $q->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas' AND kategori = '3'");
        })->get();
        $getbobottugas = Btp::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas' AND kategori = '1'")->select(DB::raw('SUM(bobot) jumlah_bobot'))->groupBy('kategori')->value('jumlah_bobot');
        $getbobotuts = Btp::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas' AND kategori = '2'")->select(DB::raw('SUM(bobot) jumlah_bobot'))->groupBy('kategori')->value('jumlah_bobot');
        $getbobotuas = Btp::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas' AND kategori = '3'")->select(DB::raw('SUM(bobot) jumlah_bobot'))->groupBy('kategori')->value('jumlah_bobot');
        if ($id_mhs === 'semua') {
            $getMhs = KRS::with('mahasiswa')->whereRaw(
                "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'"
            )->get();
            return view('dpna.cari', [
                'getmhs' => $getMhs,
                'getnilaiuts' => $getnilaiuts,
                'getnilaitugas' => $getnilaitugas,
                'getnilaiuas' => $getnilaiuas,
                'getbobottugas' => $getbobottugas,
                'getbobotuts' => $getbobotuts,
                'getbobotuas' => $getbobotuas,
                'ta' => $ta,
                'mk' => $mk,
                'mhs' => $mhs,
                'judul' => $judul,
                'judulform' => $judulform,
                'parent' => $parent,
                'subparent' => $subparent,
            ]);
        }
        $getMhs = KRS::with('mahasiswa')->whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'"
        )->groupBy('mahasiswa_id')->get();

        return view('dpna.cari', [
            'getmhs' => $getMhs,
            'getnilaiuts' => $getnilaiuts,
            'getnilaitugas' => $getnilaitugas,
            'getnilaiuas' => $getnilaiuas,
            'getbobottugas' => $getbobottugas,
            'getbobotuts' => $getbobotuts,
            'getbobotuas' => $getbobotuas,
            'ta' => $ta,
            'mk' => $mk,
            'mhs' => $mhs,
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
            'subparent' => $subparent,
        ]);
    }
}
