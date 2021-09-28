<?php

namespace App\Http\Controllers;

use App\Models\Btp;
use App\Models\DosenAdmin;
use App\Models\KRS;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\TahunAjaran;
use Auth;
use Crypt;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $judul = 'Kelola Nilai';
        $parent = 'Nilai';
        $judulform = 'Cari Data Nilai';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();

        return view('nilai.index', [
            'ta' => $ta,
            'mk' => $mk,
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
        ]);
    }

    public function cari(Request $request)
    {
        // Nilai tetap
        $judul = 'Kelola Nilai';
        $parent = 'Nilai';
        $subparent = 'Cari';
        $judulform = 'Cari Data Nilai';

        $ta = TahunAjaran::orderBy('tahun')->get();
        $mk = MataKuliah::orderBy('nama')->get();
        $id_user = Auth::user()->id; // returns an instance of the authenticated user...
        $dosenadmin = DosenAdmin::with('user')->where('id', $id_user)->first();
        $id_dosen = $dosenadmin->id;
        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $getMhs = KRS::with('mahasiswa')->whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'"
        )->get();
        $getTeknik = Btp::whereRaw(
            "tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'
            AND dosen_admin_id = '$id_dosen'"
        )->get();

        return view('nilai.cari', [
            'ta' => $ta,
            'mk' => $mk,
            'mhs' => $getMhs,
            'teknik' => $getTeknik,
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
            'subparent' => $subparent,
        ]);
    }

    public function store(Request $request)
    {
        $id_mhs = $request->mahasiswa_id;
        $id_btp = $request->btp_id;
        $nilai = $request->nilai;
        $cek = Nilai::where([
            ['mahasiswa_id', '=', $id_mhs],
            ['btp_id', '=', $id_btp],
        ])->first();

        if (!is_null($cek)) {
            $cek->update([
                'nilai' => $nilai,
            ]);

            return back()->with('success', 'Data Berhasil Diperbarui!.');
        }
        Nilai::create([
            'mahasiswa_id' => $id_mhs,
            'btp_id' => $id_btp,
            'nilai' => $nilai,
        ]);

        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }
}
