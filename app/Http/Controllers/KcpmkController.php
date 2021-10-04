<?php

namespace App\Http\Controllers;

use App\Models\DosenAdmin;
use App\Models\kcpmk;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use Crypt;
use DB;
use Illuminate\Http\Request;

class KcpmkController extends Controller
{
    protected $pdf;

    public function __construct(\App\Models\PDFModel $pdf)
    {
        $this->pdf = $pdf;
    }

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
        $id_kelas = Crypt::decrypt($request->kelas);
        if ($id_mhs === 'semua') {
            $getMhs = kcpmk::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")->groupBy('mahasiswa_id')->get();
            $getKolom = kcpmk::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")->select('kode_cpmk')->groupBy('kode_cpmk')->get();
            $kcpmk = kcpmk::class;
            return view('kcpmk.cari', [
                'getmhs' => $getMhs,
                'getkolom' => $getKolom,
                'kcpmk' => $kcpmk,
                'ta' => $ta,
                'mk' => $mk,
                'mhs' => $mhs,
                'judul' => $judul,
                'judulform' => $judulform,
                'parent' => $parent,
                'subparent' => $subparent,
            ]);
        }
        $getMhs = kcpmk::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs' AND kelas = '$id_kelas'")->groupBy('mahasiswa_id')->get();
        $getKolom = kcpmk::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs' AND kelas = '$id_kelas'")->select('kode_cpmk')->groupBy('kode_cpmk')->get();
        $getNilai = kcpmk::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs' AND kelas = '$id_kelas'")->select('*', DB::raw('AVG(nilai_kcpmk) average'))->groupBy('kode_cpmk')->get();

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

    public function downloadPDF(Request $request)
    {
        // GET
        $id_ta = Crypt::decrypt($request->tahun_ajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $id_mhs = Crypt::decrypt($request->mhs);
        $id_kelas = Crypt::decrypt($request->kelas);
        $getKolom = kcpmk::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")->select('kode_cpmk')->groupBy('kode_cpmk')->get();

        // Variabel
        $mata_kuliah = MataKuliah::whereId($id_mk)->first();
        $getmhs = kcpmk::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'")->groupBy('mahasiswa_id')->get();
        $jumlah_mhs = $getmhs->count();
        $jumlah_sks = MataKuliah::whereId($id_mk)->value('sks');
        $semester = MataKuliah::whereId($id_mk)->value('semester');
        $ruang = $id_kelas;
        $dosen = DosenAdmin::whereHas('btp', function ($query) use ($id_kelas, $id_mk, $id_sem, $id_ta) {
            return $query->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND kelas = '$id_kelas'");
        })->get();

        // Generate
        $this->pdf->Addpage('L', 'A4');
        $this->pdf->SetY(40);
        $this->pdf->SetFont('Times', 'B', 11.5);
        $this->pdf->MultiCell(260, 8, "KETERCAPAIAN CAPAIAN PEMBELAJARAN MATA KULIAH (CPMK)", 0, 'C');

        $this->pdf->SetFont('Times', '', 9);
        $this->pdf->SetY(50);
        $this->pdf->Cell(28, 5, 'Mata Kuliah ', 0, 0, 'L');
        $this->pdf->Cell(3, 5, ':', 0, 0, 'L');
        $this->pdf->SetFont('Times', 'B', 9);
        $this->pdf->Cell(172, 5, "".(strtoupper($mata_kuliah->nama))." (".(strtoupper($mata_kuliah->kode)).")", 0, 1, 'L');

        $this->pdf->SetFont('Times', '', 9);
        $this->pdf->Cell(28, 5, 'Jumlah SKS ', 0, 0, 'L');
        $this->pdf->Cell(3, 5, ':', 0, 0, 'L');
        $this->pdf->Cell(172, 5, $jumlah_sks, 0, 1, 'L');

        $this->pdf->Cell(28, 5, 'Ruang/Kelas ', 0, 0, 'L');
        $this->pdf->Cell(3, 5, ':', 0, 0, 'L');
        $this->pdf->Cell(172, 5, $ruang, 0, 1, 'L');

        $this->pdf->Cell(28, 5, 'Jumlah Mahasiswa ', 0, 0, 'L');
        $this->pdf->Cell(3, 5, ':', 0, 0, 'L');
        $this->pdf->Cell(172, 5, $jumlah_mhs, 0, 1, 'L');

        $this->pdf->Cell(28, 5, 'Dosen ', 0, 0, 'L');
        $this->pdf->Cell(3, 5, ':', 0, 0, 'L');
        foreach ($dosen as $li => $value)
        {
            if (($li + 1) > 4)
            {
                $this->pdf->SetY(70);
                $this->pdf->SetX(160);
                $this->pdf->Cell(3, 5, "" . ($li + 1).".", 0, 0, 'L');
                $this->pdf->Cell(172, 5, "".($value->nama)." (".($value->nip).")", 0, 1, 'L');
            } else {
                $this->pdf->SetX(41);
                $this->pdf->Cell(3, 5, "" . ($li + 1).".", 0, 0, 'L');
                $this->pdf->Cell(172, 5, "".($value->nama)." (".($value->nip).")", 0, 1, 'L');
            }
        }
        $this->pdf->SetY(50);
        $this->pdf->SetX(180);
        $this->pdf->Cell(25, 5, 'Jurusan ', 0, 0, 'L');
        $this->pdf->Cell(3, 5, ':', 0, 0, 'L');
        $this->pdf->Cell(172, 5, 'TEKNIK INFORMATIKA', 0, 1, 'L');

        $this->pdf->SetX(180);
        $this->pdf->Cell(25, 5, 'Jenjang ', 0, 0, 'L');
        $this->pdf->Cell(3, 5, ':', 0, 0, 'L');
        $this->pdf->Cell(172, 5, 'S1 TEKNIK INFORMATIKA', 0, 1, 'L');

        $this->pdf->SetX(180);
        $this->pdf->Cell(25, 5, 'Semester ', 0, 0, 'L');
        $this->pdf->Cell(3, 5, ':', 0, 0, 'L');
        $this->pdf->Cell(172, 5, $semester, 0, 1, 'L');

        $this->pdf->SetY(95);
        $this->pdf->SetX(10);
        $this->pdf->SetFont('Times', 'B', 11);
        $this->pdf->Cell(10, 16, 'No', 1, 0, 'C');
        $this->pdf->Cell(35, 16, 'NIM', 1, 0, 'C');
        $this->pdf->Cell(50, 16, 'NAMA MAHASISWA', 1, 0, 'C');
        $this->pdf->Cell(180, 8, 'KETERCAPAIAN CAPAIAN PEMBELAJARAN MATA KULIAH (CPMK)', 1, 0, 'C');
        $this->pdf->SetY(103);
        $this->pdf->SetX(105);
        foreach($getKolom->sortBy('kode_cpmk', SORT_NATURAL) as $li)
        {
            $this->pdf->Cell(18, 8, $li->kode_cpmk, 1, 0, 'C');
        }

        $this->pdf->SetFont('Times', '', 11);
        $this->pdf->SetY(111);
        foreach($getmhs as $li => $value) {
            $this->pdf->SetX(10);
            $this->pdf->Cell(10, 7, $li+1, 1, 0, 'C');
            $this->pdf->Cell(35, 7, $value->mahasiswa->nim, 1, 0, 'C');
            $this->pdf->Cell(50, 7, $value->mahasiswa->nama, 1, 0, 'C');
            foreach(kcpmk::where([
                ['mahasiswa_id', '=', $value->mahasiswa->id],
                ['tahun_ajaran_id', '=', $id_ta],
                ['mata_kuliah_id', '=', $id_mk],
                ['semester', '=', $id_sem],])
                         ->select('*',DB::raw('AVG(nilai_kcpmk) average'))
                         ->groupBy('kode_cpmk')->get()->sortBy('kode_cpmk', SORT_NATURAL) as $lii)
            {
                if($lii->average < 60){
                    $this->pdf->SetTextColor(198, 40, 40);
                    $this->pdf->Cell(18, 7,  $lii->average, 1, 0, 'C');
                    $this->pdf->SetTextColor(0, 0, 0);
                } else {
                    $this->pdf->Cell(18, 7,  $lii->average, 1, 0, 'C');
                }

            }
            $this->pdf->Ln();
        }
        $this->pdf->SetTitle("KETERCAPAIAN CPMK-".(strtoupper($mata_kuliah->nama))."-KELAS(".($id_kelas).")");
        return $this->pdf->Output('D',"KETERCAPAIAN CPMK-".(strtoupper($mata_kuliah->nama))."-KELAS(".($id_kelas).").pdf");
    }
}
