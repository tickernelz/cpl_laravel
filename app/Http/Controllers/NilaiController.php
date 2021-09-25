<?php

namespace App\Http\Controllers;

use App\Models\Btp;
use App\Models\DosenAdmin;
use App\Models\KRS;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\TahunAjaran;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $ta = TahunAjaran::get();
        $mk = MataKuliah::get();

        return view('nilai', [
            'ta' => $ta,
            'mk' => $mk,
        ]);
    }

    public function cari(Request $request)
    {
        $ta = TahunAjaran::get();
        $mk = MataKuliah::get();
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

        return view('aksi.nilai_cari', [
            'ta' => $ta,
            'mk' => $mk,
            'mhs' => $getMhs,
            'teknik' => $getTeknik,
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
                'nilai' => $nilai
            ]);
            return back()->with('success', 'Data Berhasil Diperbarui!.');
        }
        Nilai::create([
            'mahasiswa_id' => $id_mhs,
            'btp_id' => $id_btp,
            'nilai' => $nilai
        ]);
        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }
}
