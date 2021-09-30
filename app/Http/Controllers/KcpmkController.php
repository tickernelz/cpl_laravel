<?php

namespace App\Http\Controllers;

use App\Models\kcpmk;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Crypt;
use DB;
use Illuminate\Http\Request;

class KcpmkController extends Controller
{
    public function index()
    {
        $judul = 'Kelola Ketercapaian CPMK';
        $parent = 'Ketercapaian CPMK';
        $judulform = 'Cari Data Ketercapaian CPMK';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();
        $mhs = Mahasiswa::orderBy('nim')->get();

        return view('kcpmk.index', [
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
        $judul = 'Kelola Ketercapaian CPMK';
        $parent = 'Ketercapaian CPMK';
        $subparent = 'Cari';
        $judulform = 'Cari Data Ketercapaian CPMK';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();
        $mhs = Mahasiswa::orderBy('nim')->get();
        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $id_mhs = Crypt::decrypt($request->mhs);
        $getMhs = kcpmk::with('mahasiswa')->where('mahasiswa_id', $id_mhs)->groupBy('mahasiswa_id')->get();
        $getKolom = kcpmk::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->select('kode_cpmk')->groupBy('kode_cpmk')->get();
        $getNilai = kcpmk::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->select('*',DB::raw('AVG(nilai_kcpmk) average'))->groupBy('kode_cpmk')->get();

        return view('kcpmk.cari', [
            'getmhs' => $getMhs,
            'getkolom' => $getKolom,
            'getnilai' => $getNilai,
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
