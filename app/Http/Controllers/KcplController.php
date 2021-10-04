<?php

namespace App\Http\Controllers;

use App\Models\DosenAdmin;
use App\Models\kcpl;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Crypt;
use DB;
use Illuminate\Http\Request;
use PDF;

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
        $getKolom = kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs' AND kelas = '$id_kelas'")->select('kode_cpl')->groupBy('kode_cpl')->get();
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

    public function downloadPDF(Request $request)
    {
        // GET
        $id_ta = Crypt::decrypt($request->tahun_ajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $id_mhs = Crypt::decrypt($request->mhs);
        $id_kelas = Crypt::decrypt($request->kelas);
        $getKolom = kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")->select('kode_cpl')->groupBy('kode_cpl')->get();

        // Variabel
        $mata_kuliah = MataKuliah::whereId($id_mk)->first();
        $getmhs = kcpl::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")->groupBy('mahasiswa_id')->get();
        $jumlah_mhs = $getmhs->count();
        $jumlah_sks = MataKuliah::whereId($id_mk)->value('sks');
        $semester = MataKuliah::whereId($id_mk)->value('semester');
        $ruang = $id_kelas;
        $dosen = DosenAdmin::whereHas('btp', function ($query) use ($id_kelas, $id_mk, $id_sem, $id_ta) {
            return $query->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'");
        })->get();

        // TCPDF

        //Header
        PDF::setHeaderCallback(function($pdf){
            $pdf->Image(asset('media/photos/UPR.jpg'),10, 10, 25, 25);
            $pdf->SetFont('Times','B',11.5);
            $pdf->Ln(10);
            $pdf->MultiCell(290, 4, "KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI ", 0, 'C');
            $pdf->MultiCell(290, 4, "UNIVERSITAS PALANGKA RAYA", 0, 'C');
            $pdf->MultiCell(290, 4, "FAKULTAS TEKNIK", 0, 'C');
            $pdf->Ln(1);
            $pdf->SetFont('Times','',8);
            $pdf->MultiCell(290, 3, "Alamat : Kampus UPR Tunjung Nyaho Jalan Yos Sudarso Kotak Pos 2/PLKUP Palangka Raya 73112 Kalimantan Tengah - INDONESIA", 0, 'C');
            $pdf->MultiCell(290, 3, "Telepon/Fax: +62 536-3226487 ; laman: www.upr.ac.id E-Mail: fakultas_teknik@eng.upr.ac.id", 0, 'C');
            $pdf->Line(10, 38, 285, 38);
        });

        // Isi
        PDF::Addpage('L', 'A4');
        PDF::SetY(40);
        PDF::SetFont('Times', 'B', 11.5);
        PDF::MultiCell(260, 8, "KETERCAPAIAN CAPAIAN PEMBELAJARAN LULUSAN (CPL)", 0, 'C');

        PDF::SetFont('Times', '', 9);
        PDF::SetY(50);
        PDF::Cell(28, 5, 'Mata Kuliah ', 0, 0, 'L');
        PDF::Cell(3, 5, ':', 0, 0, 'L');
        PDF::SetFont('Times', 'B', 9);
        PDF::Cell(172, 5, "".(strtoupper($mata_kuliah->nama))." (".(strtoupper($mata_kuliah->kode)).")", 0, 1, 'L');

        PDF::SetFont('Times', '', 9);
        PDF::Cell(28, 5, 'Jumlah SKS ', 0, 0, 'L');
        PDF::Cell(3, 5, ':', 0, 0, 'L');
        PDF::Cell(172, 5, $jumlah_sks, 0, 1, 'L');

        PDF::Cell(28, 5, 'Ruang/Kelas ', 0, 0, 'L');
        PDF::Cell(3, 5, ':', 0, 0, 'L');
        PDF::Cell(172, 5, $ruang, 0, 1, 'L');

        PDF::Cell(28, 5, 'Jumlah Mahasiswa ', 0, 0, 'L');
        PDF::Cell(3, 5, ':', 0, 0, 'L');
        PDF::Cell(172, 5, $jumlah_mhs, 0, 1, 'L');

        PDF::Cell(28, 5, 'Dosen ', 0, 0, 'L');
        PDF::Cell(3, 5, ':', 0, 0, 'L');
        foreach ($dosen as $li => $value)
        {
            if (($li + 1) > 4)
            {
                PDF::SetY(70);
                PDF::SetX(160);
                PDF::Cell(3, 5, "" . ($li + 1).".", 0, 0, 'L');
                PDF::Cell(172, 5, "".($value->nama)." (".($value->nip).")", 0, 1, 'L');
            } else {
                PDF::SetX(41);
                PDF::Cell(3, 5, "" . ($li + 1).".", 0, 0, 'L');
                PDF::Cell(172, 5, "".($value->nama)." (".($value->nip).")", 0, 1, 'L');
            }
        }
        PDF::SetY(50);
        PDF::SetX(180);
        PDF::Cell(25, 5, 'Jurusan ', 0, 0, 'L');
        PDF::Cell(3, 5, ':', 0, 0, 'L');
        PDF::Cell(172, 5, 'TEKNIK INFORMATIKA', 0, 1, 'L');

        PDF::SetX(180);
        PDF::Cell(25, 5, 'Jenjang ', 0, 0, 'L');
        PDF::Cell(3, 5, ':', 0, 0, 'L');
        PDF::Cell(172, 5, 'S1 TEKNIK INFORMATIKA', 0, 1, 'L');

        PDF::SetX(180);
        PDF::Cell(25, 5, 'Semester ', 0, 0, 'L');
        PDF::Cell(3, 5, ':', 0, 0, 'L');
        PDF::Cell(172, 5, $semester, 0, 1, 'L');

        PDF::SetY(95);
        PDF::SetX(10);
        PDF::SetFont('Times', 'B', 11);
        PDF::Cell(10, 16, 'No', 1, 0, 'C');
        PDF::Cell(35, 16, 'NIM', 1, 0, 'C');
        PDF::Cell(50, 16, 'NAMA MAHASISWA', 1, 0, 'C');
        PDF::Cell(184, 8, 'KETERCAPAIAN CAPAIAN PEMBELAJARAN LULUSAN (CPL)', 1, 0, 'C');
        PDF::SetY(103);
        PDF::SetX(105);
        foreach($getKolom->sortBy('kode_cpl', SORT_NATURAL) as $li)
        {
            PDF::Cell(23, 8, $li->kode_cpl, 1, 0, 'C');
        }

        PDF::SetFont('Times', '', 11);
        PDF::SetY(111);
        foreach($getmhs as $li => $value) {
            PDF::SetX(10);
            PDF::Cell(10, 7, $li+1, 1, 0, 'C');
            PDF::Cell(35, 7, $value->mahasiswa->nim, 1, 0, 'C');
            PDF::Cell(50, 7, $value->mahasiswa->nama, 1, 0, 'C');
            foreach($getKolom->sortBy('kode_cpl', SORT_NATURAL) as $lii)
            {
                foreach(kcpl::where([
                    ['mahasiswa_id', '=', $value->mahasiswa->id],
                    ['tahun_ajaran_id', '=', $id_ta],
                    ['mata_kuliah_id', '=', $id_mk],
                    ['semester', '=', $id_sem],
                    ['kode_cpl', '=', $lii->kode_cpl],])
                            ->select('*',DB::raw('SUM(bobot_cpl) jumlah_bobot'),DB::raw('SUM(nilai_cpl) jumlah_nilai'))
                            ->groupBy('kode_cpl')->get()->sortBy('kode_cpl', SORT_NATURAL) as $liii)
                {
                    if(round(($liii->jumlah_nilai / $liii->jumlah_bobot), 2) < 60){
                        PDF::SetTextColor(198, 40, 40);
                        PDF::Cell(23, 7,  round(($liii->jumlah_nilai / $liii->jumlah_bobot), 2), 1, 0, 'C');
                        PDF::SetTextColor(0, 0, 0);
                    } else {
                        PDF::Cell(23, 7,  round(($liii->jumlah_nilai / $liii->jumlah_bobot), 2), 1, 0, 'C');
                    }

                }
            }
            PDF::Ln();
        }
        PDF::SetTitle("KETERCAPAIAN CPL-".(strtoupper($mata_kuliah->nama))."-KELAS(".($id_kelas).")");
        $nama_file = 'KETERCAPAIAN CPL-'.(strtoupper($mata_kuliah->nama)).'-KELAS('.($id_kelas).').pdf';
        PDF::Output(storage_path('app').'/public/'.$nama_file, 'F');
        return response()->file(storage_path('app').'/public/'.$nama_file);
    }
}
