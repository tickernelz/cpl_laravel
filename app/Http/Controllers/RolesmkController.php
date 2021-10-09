<?php

namespace App\Http\Controllers;

use App\Models\DosenAdmin;
use App\Models\MataKuliah;
use App\Models\Rolesmk;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Crypt;
use Illuminate\Http\Request;

class RolesmkController extends Controller
{
    public function index()
    {
        $judul = 'Kelola Koordinator MK';
        $parent = 'Koordinator MK';
        $judulform = 'Cari Data Koordinator MK';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();

        return view('rolesmk.index', [
            'ta' => $ta,
            'mk' => $mk,
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
        $judul = 'Kelola Koordinator MK';
        $parent = 'Koordinator MK';
        $subparent = 'Cari';
        $judulform = 'Cari Data Koordinator MK';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();

        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $id_kelas = Crypt::decrypt($request->kelas);
        $getDosen = Rolesmk::with('dosen_admin')
            ->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")
            ->get();
        $arraydosen = $getDosen->pluck('dosen_admin_id')->toArray();
        $getDosenselain = DosenAdmin::whereNotIn('id', $arraydosen)->get();
        return view('rolesmk.cari', [
            'getDosenselain' => $getDosenselain,
            'getDosen' => $getDosen,
            'ta' => $ta,
            'mk' => $mk,
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
            'subparent' => $subparent,
        ]);
    }

    public function store(Request $request)
    {
        $id_ta = $request->id_ta;
        $id_mk = $request->id_mk;
        $id_dosen = $request->id_dosen;
        $id_kelas = $request->id_kelas;
        $semester = $request->semester;
        $status = 'koordinator';

        $tambah = Rolesmk::Create(
            [
                'tahun_ajaran_id' => $id_ta,
                'mata_kuliah_id' => $id_mk,
                'dosen_admin_id' => $id_dosen,
                'kelas' => $id_kelas,
                'semester' => $semester,
                'status' => $status,
            ]
        );
        return Response()->json($tambah);
    }

    public function hapus(Request $request)
    {
        $id = $request->id;
        $hapus = Rolesmk::find($id)->delete();
        return Response()->json($hapus);
    }
}
