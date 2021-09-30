<?php

namespace App\Http\Controllers;

use App\Models\Btp;
use App\Models\DosenAdmin;
use App\Models\kcpmk;
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
        $getTeknik = Btp::with('cpmk')->whereRaw(
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
        $id_ta = Crypt::decrypt($request->tahun_ajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mata_kuliah);

        $id_cpmk = $request->get('cpmk_id');
        $kode_cpmk = $request->get('kode_cpmk');
        $id_mhs = $request->get('mahasiswa_id');
        $id_btp = $request->get('btp_id');
        $nilaiori = $request->get('nilai-ori');
        $nilai = $request->get('nilai');

        $maxidmhs = count($id_mhs);

        for ($x = 0; $x < $maxidmhs; $x ++)
        {
            $btpbymhs = $id_btp[$x];
            $maxidbtp = count($btpbymhs);
            for ($y = 0; $y < $maxidbtp; $y ++)
            {
                $id_mhs_array = $id_mhs[$x];
                $id_cpmk_array = $id_cpmk[$x][$y];
                $kode_cpmk_array = $kode_cpmk[$x][$y];
                $id_btp_array = $id_btp[$x][$y];
                $nilai_array = $nilai[$x][$y];
                $nilaiori_array = $nilaiori[$x][$y];

                // Nilai
                $cek_nilai = Nilai::where([
                    ['mahasiswa_id', '=', $id_mhs_array],
                    ['btp_id', '=', $id_btp_array],
                    ['nilai', '=', $nilaiori_array],
                ])->first();

                if (!is_null($cek_nilai)) {
                    $cek_nilai->update([
                        'nilai' => $nilai_array,
                    ]);

                } else {
                    Nilai::create([
                        'mahasiswa_id' => $id_mhs_array,
                        'btp_id' => $id_btp_array,
                        'nilai' => $nilai_array,
                    ]);
                }

                // Ketercapaian CPMK
                $cek_kcpmk = kcpmk::where([
                    ['tahun_ajaran_id', '=', $id_ta],
                    ['btp_id', '=', $id_btp_array],
                    ['mahasiswa_id', '=', $id_mhs_array],
                    ['mata_kuliah_id', '=', $id_mk],
                    ['cpmk_id', '=', $id_cpmk_array],
                    ['kode_cpmk', '=', $kode_cpmk_array],
                    ['semester', '=', $id_sem],
                    ['nilai_kcpmk', '=', $nilaiori_array],
                ])->first();

                if(!is_null($cek_kcpmk)) {
                    $cek_kcpmk->update([
                        'nilai_kcpmk' => $nilai_array,
                    ]);
                } else {
                    kcpmk::create([
                        'tahun_ajaran_id' => $id_ta,
                        'btp_id' => $id_btp_array,
                        'mahasiswa_id' => $id_mhs_array,
                        'mata_kuliah_id' => $id_mk,
                        'cpmk_id' => $id_cpmk_array,
                        'kode_cpmk' => $kode_cpmk_array,
                        'semester' => $id_sem,
                        'nilai_kcpmk' => $nilai_array,
                    ]);
                }
            }
        }
        return back()->with('success', 'Data Berhasil Ditambahkan!.');
    }
}
