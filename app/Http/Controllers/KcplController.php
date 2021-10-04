<?php

namespace App\Http\Controllers;

use App\Models\kcpl;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Crypt;
use Illuminate\Http\Request;

class KcplController extends Controller
{
    public function index()
    {
        $judul = 'Kelola Ketercapaian CPL';
        $parent = 'Ketercapaian CPL';
        $judulform = 'Cari Data Ketercapaian CPL';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();
        $mhs = Mahasiswa::orderBy('nim')->get();

        return view('kcpl.index', [
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
        $judul = 'Kelola Ketercapaian CPL';
        $parent = 'Ketercapaian CPL';
        $subparent = 'Cari';
        $judulform = 'Cari Data Ketercapaian CPL';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();
        $mhs = Mahasiswa::orderBy('nim')->get();

        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $id_mhs = Crypt::decrypt($request->mhs);
        $id_kelas = Crypt::decrypt($request->kelas);
        if ($id_mhs === 'semua') {
            $getMhs = kcpl::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")->groupBy('mahasiswa_id')->get();
            $getUpdated = kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")->orderBy('updated_at', 'desc')->first();
            $getKolom = kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")->select('kode_cpl')->groupBy('kode_cpl')->get();
            $kcpl = kcpl::class;
            return view('kcpl.cari', [
                'getmhs' => $getMhs,
                'getkolom' => $getKolom,
                'getUpdated' => $getUpdated,
                'kcpl' => $kcpl,
                'ta' => $ta,
                'mk' => $mk,
                'mhs' => $mhs,
                'judul' => $judul,
                'judulform' => $judulform,
                'parent' => $parent,
                'subparent' => $subparent,
            ]);
        }
        $getMhs = kcpl::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs' AND kelas = '$id_kelas'")->groupBy('mahasiswa_id')->get();
        $getKolom = kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs' AND kelas = '$id_kelas'")->select('kode_cpl')->groupBy('kode_cpmk')->get();
        $getUpdated = kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")->orderBy('updated_at', 'desc')->first();
        $getNilai = kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs' AND kelas = '$id_kelas'")->select('*', DB::raw('AVG(nilai_cpl) average'))->groupBy('kode_cpl')->get();

        return view('kcpl.cari', [
            'getmhs' => $getMhs,
            'getkolom' => $getKolom,
            'getnilai' => $getNilai,
            'getUpdated' => $getUpdated,
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
