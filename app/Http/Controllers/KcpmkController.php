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
        if($id_mhs === 'semua'){
            $getMhs = kcpmk::with('mahasiswa')->groupBy('mahasiswa_id')->get();
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
        $getMhs = kcpmk::with('mahasiswa')->where('mahasiswa_id', $id_mhs)->groupBy('mahasiswa_id')->get();
        $getKolom = kcpmk::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs' AND kelas = '$id_kelas'")->select('kode_cpmk')->groupBy('kode_cpmk')->get();
        $getNilai = kcpmk::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs' AND kelas = '$id_kelas'")->select('*',DB::raw('AVG(nilai_kcpmk) average'))->groupBy('kode_cpmk')->get();

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
        // Variabel
        $mata_kuliah = 'Metode Penelitian';
        $jumlah_mhs = '40';
        $jumlah_sks = '3';
        $ruang = 'A';

        // Generate
        $this->pdf->Addpage('L', 'A4');
        $this->pdf->SetY(40);
        $this->pdf->SetFont('Times','B',11.5);
        $this->pdf->MultiCell(260, 8, "KETERCAPAIAN CAPAIAN PEMBELAJARAN MATA KULIAH (CPMK)", 0, 'C');

        $this->pdf->SetFont('Times','',9);
        $this->pdf->SetY(50);
        $this->pdf->Cell(28, 5, 'Mata Kuliah ', 0, 0, 'L');
        $this->pdf->Cell(3, 5, ':', 0, 0, 'L');
        $this->pdf->Cell(172, 5, $mata_kuliah, 0, 1, 'L');

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
        $this->pdf->Cell(172, 5, '', 0, 1, 'L');

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
        $this->pdf->Cell(172, 5, '', 0, 1, 'L');
        $this->pdf->Output();
    }
}
