<?php

namespace App\Http\Controllers;

use App\Models\Bobotcpl;
use App\Models\Btp;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\DosenAdmin;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use App\Models\User;

class Hapus extends Controller
{
    public function admin($id)
    {
        DosenAdmin::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('admin');
    }

    public function dosen($id)
    {
        $user = new User;
        $dosenadmin = new DosenAdmin;
        DosenAdmin::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('dosen');
    }

    public function mhs($id)
    {
        Mahasiswa::find($id)->delete();

        return redirect()->route('mhs');
    }

    public function ta($id)
    {
        TahunAjaran::find($id)->delete();

        return redirect()->route('ta');
    }

    public function mk($id)
    {
        MataKuliah::find($id)->delete();

        return redirect()->route('mk');
    }

    public function cpl($id)
    {
        Cpl::find($id)->delete();

        return redirect()->route('cpl');
    }

    public function cpmk($id)
    {
        $cek_btp = Btp::where('cpmk_id', $id)->count();
        $cek_bcpl = Bobotcpl::where('cpmk_id', $id)->count();
        if ($cek_btp === 0 || $cek_bcpl === 0) {
            Cpmk::find($id)->delete();
            return redirect()->route('cpmk');
        }
        return response()->json(['error' => 'Data yang ingin dihapus masih digunakan!'], 409);
    }
}
