<?php

namespace App\Http\Controllers;

use App\Models\Btp;
use App\Models\DosenAdmin;
use App\Models\Kcpl;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Rolesmk;
use App\Models\TahunAjaran;
use Auth;
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
        $angkatan = Mahasiswa::orderBy('nim')->pluck('angkatan');

        return view('Kcpl.index', [
            'ta' => $ta,
            'mk' => $mk,
            'mhs' => $mhs,
            'angkatan' => $angkatan,
            'judul' => $judul,
            'judulform' => $judulform,
            'parent' => $parent,
        ]);
    }

    public function editkolom(Request $request)
    {
        $nama_kolom = $request->get('nama_kolom');
        $urutan = $request->get('urutan');

        $maxkolom = count($nama_kolom);

        for ($x = 0; $x < $maxkolom; $x++) {
            $nama_kolom_array = $nama_kolom[$x];
            $urutan_array = $urutan[$x];
            $getKolom = Kcpl::whereRaw("kode_cpl = '$nama_kolom_array'")->get();
            foreach ($getKolom as $li) {
                $id = $li->id;
                $li::where('id', $id)->update([
                    'urutan' => $urutan_array,
                ]);
            }
        }

        return Response()->json($getKolom);
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
        $angkatan = Mahasiswa::orderBy('nim')->pluck('angkatan');

        $id_ta = Crypt::decrypt($request->tahunajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $id_mhs = Crypt::decrypt($request->mhs);
        $id_angkatan = Crypt::decrypt($request->angkatan);

        $id_user = Auth::user()->id;
        $cekstatus = Auth::user()->status;
        $id_dosen = DosenAdmin::with('user')->where('id', $id_user)->first()->id;
        $getDosen = Rolesmk::with('dosen_admin')
            ->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND dosen_admin_id = '$id_dosen' AND status = 'koordinator'")
            ->first();
        $getDosenPengampu = Btp::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND dosen_admin_id = '$id_dosen'")
            ->first();
        if (isset($getDosen) || isset($getDosenPengampu) || $cekstatus === 'Admin') {
            if ($id_mhs === 'semua') {
                if ($id_mk === 'semua') {
                    if ($id_angkatan === 'semua') {
                        $getMhs = Kcpl::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem'")->groupBy('mahasiswa_id')->get();
                    } else {
                        $getMhs = Kcpl::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($id_angkatan) {
                            return $query->where('angkatan', $id_angkatan);
                        })->whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem'")->groupBy('mahasiswa_id')->get();
                    }
                    $getUpdated = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem'")->orderBy('updated_at', 'desc')->first();
                    $getKolom = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem'")->select(['kode_cpl', 'urutan'])->groupBy('kode_cpl')->get();
                    $getMatkul = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem'")->select('mata_kuliah_id')->groupBy('mata_kuliah_id')->get();
                    $Kcpl = Kcpl::class;

                    return view('Kcpl.cari', [
                        'getMatkul' => $getMatkul,
                        'getmhs' => $getMhs,
                        'getkolom' => $getKolom,
                        'getUpdated' => $getUpdated,
                        'Kcpl' => $Kcpl,
                        'ta' => $ta,
                        'mk' => $mk,
                        'mhs' => $mhs,
                        'angkatan' => $angkatan,
                        'judul' => $judul,
                        'judulform' => $judulform,
                        'parent' => $parent,
                        'subparent' => $subparent,
                    ]);
                }
                if ($id_angkatan === 'semua') {
                    $getMhs = Kcpl::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'")->groupBy('mahasiswa_id')->get();
                } else {
                    $getMhs = Kcpl::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($id_angkatan) {
                        return $query->where('angkatan', $id_angkatan);
                    })->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'")->groupBy('mahasiswa_id')->get();
                }
                $getUpdated = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'")->orderBy('updated_at', 'desc')->first();
                $getKolom = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'")->select(['kode_cpl', 'urutan'])->groupBy('kode_cpl')->get();
                $Kcpl = Kcpl::class;

                return view('Kcpl.cari', [
                    'getmhs' => $getMhs,
                    'getkolom' => $getKolom,
                    'getUpdated' => $getUpdated,
                    'Kcpl' => $Kcpl,
                    'ta' => $ta,
                    'mk' => $mk,
                    'mhs' => $mhs,
                    'angkatan' => $angkatan,
                    'judul' => $judul,
                    'judulform' => $judulform,
                    'parent' => $parent,
                    'subparent' => $subparent,
                ]);
            }
            if ($id_mk === 'semua') {
                if ($id_angkatan === 'semua') {
                    $getMhs = Kcpl::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->groupBy('mahasiswa_id')->get();
                } else {
                    $getMhs = Kcpl::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($id_angkatan) {
                        return $query->where('angkatan', $id_angkatan);
                    })->whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->groupBy('mahasiswa_id')->get();
                }
                $getUpdated = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->orderBy('updated_at', 'desc')->first();
                $getKolom = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->select(['kode_cpl', 'urutan'])->groupBy('kode_cpl')->get();
                $getMatkul = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem'")->select('mata_kuliah_id')->groupBy('mata_kuliah_id')->get();
                $Kcpl = Kcpl::class;

                return view('Kcpl.cari', [
                    'getMatkul' => $getMatkul,
                    'getmhs' => $getMhs,
                    'getkolom' => $getKolom,
                    'Kcpl' => $Kcpl,
                    'getUpdated' => $getUpdated,
                    'ta' => $ta,
                    'mk' => $mk,
                    'mhs' => $mhs,
                    'angkatan' => $angkatan,
                    'judul' => $judul,
                    'judulform' => $judulform,
                    'parent' => $parent,
                    'subparent' => $subparent,
                ]);
            }
            if ($id_angkatan === 'semua') {
                $getMhs = Kcpl::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->groupBy('mahasiswa_id')->get();
            } else {
                $getMhs = Kcpl::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($id_angkatan) {
                    return $query->where('angkatan', $id_angkatan);
                })->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->groupBy('mahasiswa_id')->get();
            }
            $getUpdated = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->orderBy('updated_at', 'desc')->first();
            $getKolom = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->select(['kode_cpl', 'urutan'])->groupBy('kode_cpl')->get();
            $Kcpl = Kcpl::class;

            return view('Kcpl.cari', [
                'getmhs' => $getMhs,
                'getkolom' => $getKolom,
                'Kcpl' => $Kcpl,
                'getUpdated' => $getUpdated,
                'ta' => $ta,
                'mk' => $mk,
                'mhs' => $mhs,
                'angkatan' => $angkatan,
                'judul' => $judul,
                'judulform' => $judulform,
                'parent' => $parent,
                'subparent' => $subparent,
            ]);
        }

        return redirect()->route('Kcpl')->with('error', 'Maaf anda bukan dosen koordinator!');
    }

    public function downloadPDF(Request $request)
    {
        // GET
        $id_ta = Crypt::decrypt($request->tahun_ajaran);
        $id_sem = Crypt::decrypt($request->semester);
        $id_mk = Crypt::decrypt($request->mk);
        $id_mhs = Crypt::decrypt($request->mhs);
        $id_angkatan = Crypt::decrypt($request->angkatan);
        if ($id_mk !== 'semua') {
            $getKolom = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'")->groupBy('kode_cpl')->get();
        } else {
            $getKolom = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem'")->select(['kode_cpl', 'urutan'])->groupBy('kode_cpl')->get();
        }

        // Semester
        if ($id_sem === '1') {
            $get_semester = 'Ganjil';
        } else {
            $get_semester = 'Genap';
        }

        // Variabel
        $tahun_ajaran = TahunAjaran::firstWhere('id', $id_ta)->tahun;
        $tahun_ajaran_filtered = strtolower(preg_replace('/[\W\s\/]+/', '-', $tahun_ajaran));
        $mata_kuliah = MataKuliah::whereId($id_mk)->first();
        if ($id_mk !== 'semua') {
            $getmhs = Kcpl::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'")->groupBy('mahasiswa_id')->get();
        } elseif ($id_angkatan !== 'semua') {
            $getmhs = Kcpl::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($id_angkatan) {
                return $query->where('angkatan', $id_angkatan);
            })->whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem'")->groupBy('mahasiswa_id')->get();
        } elseif ($id_mhs !== 'semua') {
            $getmhs = Kcpl::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem' AND mahasiswa_id = '$id_mhs'")->groupBy('mahasiswa_id')->get();
        } else {
            $getmhs = Kcpl::with('mahasiswa')->whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem'")->groupBy('mahasiswa_id')->get();
        }
        $jumlah_mhs = $getmhs->count();
        $jumlah_sks = MataKuliah::whereId($id_mk)->value('sks');
        $semester = MataKuliah::whereId($id_mk)->value('semester');
        $dosen = DosenAdmin::whereHas('btp', function ($query) use ($id_mk, $id_sem, $id_ta) {
            return $query->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem'");
        })->get();

        $dosenkoor = Rolesmk::with('dosen_admin')
            ->whereRaw("tahun_ajaran_id = '$id_ta' AND mata_kuliah_id = '$id_mk' AND semester = '$id_sem' AND status = 'koordinator'")
            ->first();

        // Hitung Rata Semua CPL
        function hitungrata($id_ta, $id_sem, $mahasiswa, $kodecpl, $total_cpl)
        {
            $matkul = Kcpl::whereRaw("tahun_ajaran_id = '$id_ta' AND semester = '$id_sem'")->select('mata_kuliah_id')->groupBy('mata_kuliah_id')->get();
            $total_cpl_matkul = count($total_cpl);
            $rata = [];
            foreach ($matkul as $li) {
                $get_Kcpl = Kcpl::where([
                    ['mahasiswa_id', '=', $mahasiswa],
                    ['tahun_ajaran_id', '=', $id_ta],
                    ['mata_kuliah_id', '=', $li->mata_kuliah_id],
                    ['semester', '=', $id_sem],
                    ['kode_cpl', '=', $kodecpl], ])
                    ->select('*', DB::raw('SUM(bobot_cpl) jumlah_bobot'), DB::raw('SUM(nilai_cpl) jumlah_nilai'))
                    ->groupBy('kode_cpl')->get();
                foreach ($get_Kcpl->sortBy('urutan', SORT_NATURAL) as $Kcpl1) {
                    $rata[] = round(($Kcpl1->jumlah_nilai / $Kcpl1->jumlah_bobot), 2);
                }
            }
            if (count($total_cpl)) {
                return round((array_sum($rata) / $total_cpl_matkul), 2);
            } else {
                return null;
            }
        }

        // TCPDF

        //Header
        PDF::setHeaderCallback(function ($pdf) {
            $pdf->Image(asset('media/photos/UPR.jpg'), 10, 10, 25, 25);
            $pdf->SetFont('Times', 'B', 11.5);
            $pdf->Ln(10);
            $pdf->MultiCell(290, 4, 'KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI ', 0, 'C');
            $pdf->MultiCell(290, 4, 'UNIVERSITAS PALANGKA RAYA', 0, 'C');
            $pdf->MultiCell(290, 4, 'FAKULTAS TEKNIK', 0, 'C');
            $pdf->Ln(1);
            $pdf->SetFont('arialn', '', 8);
            $pdf->MultiCell(290, 3, 'Alamat : Kampus UPR Tunjung Nyaho Jalan Yos Sudarso Kotak Pos 2/PLKUP Palangka Raya 73112 Kalimantan Tengah - INDONESIA', 0, 'C');
            $pdf->MultiCell(290, 3, 'Telepon/Fax: +62 536-3226487 ; laman: www.upr.ac.id E-Mail: fakultas_teknik@eng.upr.ac.id', 0, 'C');
            $pdf->Line(10, 38, 285, 38);
        });

        // Footer
        PDF::setFooterCallback(function ($pdf) {
            // Position at 15 mm from bottom
            $pdf->SetY(-15);
            // Set font
            $pdf->SetFont('ariali', '', 8);
            // Page number
            $pdf->Cell(0, 10, 'Halaman '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });

        // Isi
        PDF::Addpage('L', 'A4');
        PDF::SetY(40);
        PDF::SetFont('Times', 'B', 11.5);
        PDF::MultiCell(260, 8, 'KETERCAPAIAN CAPAIAN PEMBELAJARAN LULUSAN (CPL)', 0, 'C');

        // Detail Mata Kuliah
        PDF::SetFont('Times', '', 9);
        if ($id_mk !== 'semua') {
            PDF::SetY(50);
            PDF::Cell(28, 5, 'Mata Kuliah ', 0, 0, 'L');
            PDF::Cell(3, 5, ':', 0, 0, 'L');
            PDF::SetFont('Times', 'B', 9);
            PDF::Cell(172, 5, ''.(strtoupper($mata_kuliah->nama)).' ('.(strtoupper($mata_kuliah->kode)).')', 0, 1, 'L');

            PDF::SetFont('Times', '', 9);
            PDF::Cell(28, 5, 'Jumlah SKS ', 0, 0, 'L');
            PDF::Cell(3, 5, ':', 0, 0, 'L');
            PDF::Cell(172, 5, $jumlah_sks, 0, 1, 'L');

            PDF::Cell(28, 5, 'Ruang/Kelas ', 0, 0, 'L');
            PDF::Cell(3, 5, ':', 0, 0, 'L');
            PDF::Cell(172, 5, $mata_kuliah->kelas, 0, 1, 'L');

            PDF::Cell(28, 5, 'Jumlah Mahasiswa ', 0, 0, 'L');
            PDF::Cell(3, 5, ':', 0, 0, 'L');
            PDF::Cell(172, 5, $jumlah_mhs, 0, 1, 'L');

            PDF::Cell(28, 5, 'Dosen ', 0, 0, 'L');
            PDF::Cell(3, 5, ':', 0, 0, 'L');
            PDF::SetX(41);
            PDF::Cell(3, 5, ''.'1'.'.', 0, 0, 'L');
            if (isset($dosenkoor)) {
                PDF::Cell(172, 5, ''.($dosenkoor->dosen_admin->nama).' ('.($dosenkoor->dosen_admin->nip).')', 0, 1, 'L');
            } else {
                return redirect()->back()->with('error', 'Dosen koor tidak ditemukan!');
            }
            $no = 2;
            foreach ($dosen as $li => $value) {
                if ($value->nama === $dosenkoor->dosen_admin->nama) {
                    continue;
                }
                if ($no > 4) {
                    PDF::SetY(70);
                    PDF::SetX(160);
                } else {
                    PDF::SetX(41);
                }
                PDF::Cell(3, 5, ''.$no.'.', 0, 0, 'L');
                PDF::Cell(172, 5, ''.($value->nama).' ('.($value->nip).')', 0, 1, 'L');
                $no++;
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
        } else {
            PDF::SetY(50);
            PDF::Cell(28, 5, 'Mata Kuliah ', 0, 0, 'L');
            PDF::Cell(3, 5, ':', 0, 0, 'L');
            PDF::SetFont('Times', 'B', 9);
            PDF::Cell(172, 5, 'Semua', 0, 1, 'L');

            PDF::SetFont('Times', '', 9);
            PDF::Cell(28, 5, 'Jumlah SKS ', 0, 0, 'L');
            PDF::Cell(3, 5, ':', 0, 0, 'L');
            PDF::Cell(172, 5, '-', 0, 1, 'L');

            PDF::Cell(28, 5, 'Ruang/Kelas ', 0, 0, 'L');
            PDF::Cell(3, 5, ':', 0, 0, 'L');
            PDF::Cell(172, 5, '-', 0, 1, 'L');

            PDF::Cell(28, 5, 'Jumlah Mahasiswa ', 0, 0, 'L');
            PDF::Cell(3, 5, ':', 0, 0, 'L');
            PDF::Cell(172, 5, $jumlah_mhs, 0, 1, 'L');

            PDF::Cell(28, 5, 'Dosen ', 0, 0, 'L');
            PDF::Cell(3, 5, ':', 0, 0, 'L');
            PDF::Cell(172, 5, '-', 0, 1, 'L');

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
            PDF::Cell(172, 5, '-', 0, 1, 'L');
        }

        PDF::SetY(95);
        PDF::SetX(10);
        PDF::SetFont('Times', 'B', 11);
        PDF::Cell(10, 16, 'No', 1, 0, 'C');
        PDF::Cell(35, 16, 'NIM', 1, 0, 'C');
        PDF::Cell(50, 16, 'NAMA MAHASISWA', 1, 0, 'C');
        PDF::Cell(184, 8, 'KETERCAPAIAN CAPAIAN PEMBELAJARAN LULUSAN (CPL)', 1, 0, 'C');
        PDF::SetY(103);
        PDF::SetX(105);
        foreach ($getKolom->sortBy('urutan', SORT_NATURAL) as $li => $value) {
            PDF::Cell(23, 8, $value->kode_cpl, 1, 0, 'C');
        }
        $jumlah_kolom = count($getKolom);
        if ($jumlah_kolom < 8) {
            $sisa_kolom = 8 - $jumlah_kolom;
            for ($x = 0; $x < $sisa_kolom; $x++) {
                PDF::Cell(23, 8, '', 1, 0, 'C');
            }
        }

        PDF::SetFont('Times', '', 11);
        PDF::SetY(111);
        foreach ($getmhs as $li => $value) {
            PDF::SetX(10);
            PDF::Cell(10, 7, $li + 1, 1, 0, 'C');
            PDF::Cell(35, 7, $value->mahasiswa->nim, 1, 0, 'C');
            PDF::Cell(50, 7, $value->mahasiswa->nama, 1, 0, 'C');

            foreach ($getKolom->sortBy('urutan', SORT_NATURAL) as $lii) {
                if ($id_mk !== 'semua') {
                    foreach (Kcpl::where([
                        ['mahasiswa_id', '=', $value->mahasiswa->id],
                        ['tahun_ajaran_id', '=', $id_ta],
                        ['mata_kuliah_id', '=', $id_mk],
                        ['semester', '=', $id_sem],
                        ['kode_cpl', '=', $lii->kode_cpl], ])
                                 ->select('*', DB::raw('SUM(bobot_cpl) jumlah_bobot'), DB::raw('SUM(nilai_cpl) jumlah_nilai'))
                                 ->groupBy('kode_cpl')->get()->sortBy('urutan', SORT_NATURAL) as $liii) {
                        if (round(($liii->jumlah_nilai / $liii->jumlah_bobot), 2) < 60) {
                            PDF::SetTextColor(198, 40, 40);
                            PDF::Cell(23, 7, round(($liii->jumlah_nilai / $liii->jumlah_bobot), 2), 1, 0, 'C');
                            PDF::SetTextColor(0, 0, 0);
                        } else {
                            PDF::Cell(23, 7, round(($liii->jumlah_nilai / $liii->jumlah_bobot), 2), 1, 0, 'C');
                        }
                    }
                } else {
                    $total_cpl = Kcpl::where([
                        ['mahasiswa_id', '=', $value->mahasiswa->id],
                        ['tahun_ajaran_id', '=', $id_ta],
                        ['semester', '=', $id_sem],
                        ['kode_cpl', '=', $lii->kode_cpl], ])
                        ->groupBy('mata_kuliah_id')
                        ->get();
                    $hitungrata = hitungrata($id_ta, $id_sem, $value->mahasiswa->id, $lii->kode_cpl, $total_cpl);
                    foreach (Kcpl::where([
                        ['mahasiswa_id', '=', $value->mahasiswa->id],
                        ['tahun_ajaran_id', '=', $id_ta],
                        ['semester', '=', $id_sem],
                        ['kode_cpl', '=', $lii->kode_cpl], ])
                                 ->select('*', DB::raw('SUM(bobot_cpl) jumlah_bobot'), DB::raw('SUM(nilai_cpl) jumlah_nilai'))
                                 ->groupBy('kode_cpl')->get()->sortBy('urutan', SORT_NATURAL) as $liii) {
                        if (round(($hitungrata), 2) < 60) {
                            PDF::SetTextColor(198, 40, 40);
                            PDF::Cell(23, 7, round(($hitungrata), 2), 1, 0, 'C');
                            PDF::SetTextColor(0, 0, 0);
                        } else {
                            PDF::Cell(23, 7, round(($hitungrata), 2), 1, 0, 'C');
                        }
                    }
                }
            }
            if ($jumlah_kolom < 8) {
                $sisa_kolom = 8 - $jumlah_kolom;
                for ($x = 0; $x < $sisa_kolom; $x++) {
                    PDF::SetFillColor(211, 211, 211);
                    PDF::Cell(23, 7, '', 1, 0, 'C', 1);
                    PDF::SetFillColor(255, 255, 255);
                }
            }
            PDF::Ln();
        }
        PDF::Ln(10);
        PDF::SetFont('Times', '', 10);
        PDF::SetX(220);
        PDF::Cell(25, 5, 'Palangka Raya, '.Carbon::now()->isoFormat('D MMMM Y'), 0, 0, 'L');
        PDF::Ln();
        if ($id_mk !== 'semua') {
            PDF::SetX(220);
            PDF::Cell(25, 5, 'Dosen,', 0, 0, 'L');
            PDF::Ln(25);
            PDF::SetX(220);
            PDF::Cell(25, 5, $dosenkoor->dosen_admin->nama, 0, 0, 'L');
            PDF::Ln();
            PDF::SetX(220);
            PDF::Cell(25, 5, $dosenkoor->dosen_admin->nip, 0, 0, 'L');
        }
        if ($id_mk !== 'semua') {
            PDF::SetTitle('KETERCAPAIAN CPL-'.(strtoupper($mata_kuliah->nama)).'-KELAS('.($mata_kuliah->kelas).')');
            $nama_file = 'KETERCAPAIAN CPL-'.(strtoupper($mata_kuliah->nama)).'-KELAS('.($mata_kuliah->kelas).').pdf';
        } else {
            PDF::SetTitle('KETERCAPAIAN CPL-'.($tahun_ajaran_filtered).'-'.($get_semester));
            $nama_file = 'KETERCAPAIAN_CPL-'.($tahun_ajaran_filtered).'-'.($get_semester).'.pdf';
        }
        PDF::Output(public_path('file').'/'.$nama_file, 'F');

        return response()->file(public_path('file').'/'.$nama_file);
    }
}
