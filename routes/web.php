<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BobotcplController;
use App\Http\Controllers\BtpController;
use App\Http\Controllers\CplController;
use App\Http\Controllers\CpmkController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\Edit;
use App\Http\Controllers\Hapus;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KRSController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\Tambah;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'showFormLogin'])->name('login');
Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post(
    '/cek',
    function () {
        return view('validation.cek');
    }
);

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => ['role:admin']], function () {
        // Admin
        Route::get('admin', [AdminController::class, 'index'])->name('admin');
        Route::get('admin/tambah/', [AdminController::class, 'tambahindex'])->name('tambahadmin');
        Route::post('admin/tambah/post', [AdminController::class, 'tambah'])->name('form-tambah-admin');
        Route::get('admin/hapus/{id}', [AdminController::class, 'hapus']);
        Route::get('admin/edit/{id}', [AdminController::class, 'editindex']);
        Route::post('admin/edit/{id}/post', [AdminController::class, 'edit']);
        // Dosen
        Route::get('dosen', [DosenController::class, 'index'])->name('dosen');
        Route::get('dosen/tambah/', [DosenController::class, 'tambahindex'])->name('tambahdosen');
        Route::post('dosen/tambah/post', [DosenController::class, 'tambah'])->name('form-tambah-dosen');
        Route::get('dosen/hapus/{id}', [DosenController::class, 'hapus']);
        Route::get('dosen/edit/{id}', [DosenController::class, 'editindex']);
        Route::post('dosen/edit/{id}/post', [DosenController::class, 'edit']);
        // Mahasiswa
        Route::get('mhs', [MahasiswaController::class, 'index'])->name('mhs');
        Route::get('mhs/tambah/', [MahasiswaController::class, 'tambahindex'])->name('tambahmhs');
        Route::post('mhs/tambah/post', [MahasiswaController::class, 'tambah'])->name('form-tambah-mahasiswa');
        Route::get('mhs/hapus/{id}', [MahasiswaController::class, 'hapus']);
        Route::get('mhs/edit/{id}', [MahasiswaController::class, 'editindex']);
        Route::post('mhs/edit/{id}/post', [MahasiswaController::class, 'edit']);
        // Tahun Ajaran
        Route::get('ta', [TahunAjaranController::class, 'index'])->name('ta');
        Route::get('ta/tambah/', [Tambah::class, 'indexta'])->name('tambahta');
        Route::post('ta/tambah/post', [Tambah::class, 'ta']);
        Route::get('ta/hapus/{id}', [Hapus::class, 'ta']);
        Route::get('ta/edit/{id}', [Edit::class, 'indexta']);
        Route::post('ta/edit/{id}/post', [Edit::class, 'ta']);
        // Mata Kuliah
        Route::get('mk', [MataKuliahController::class, 'index'])->name('mk');
        Route::get('mk/tambah/', [Tambah::class, 'indexmk'])->name('tambahmk');
        Route::post('mk/tambah/post', [Tambah::class, 'mk']);
        Route::get('mk/hapus/{id}', [Hapus::class, 'mk']);
        Route::get('mk/edit/{id}', [Edit::class, 'indexmk']);
        Route::post('mk/edit/{id}/post', [Edit::class, 'mk']);
        // Mata Kuliah
        Route::get('krs', [KRSController::class, 'index'])->name('krs');
        Route::get('carimhs', [KRSController::class, 'carimhs'])->name('carimhs');
        Route::get('krs/cari', [KRSController::class, 'cari'])->name('krscari');
        Route::post('tambah-krs', [KRSController::class, 'store']);
        Route::post('hapus-krs', [KRSController::class, 'hapus']);
        // CPL
        Route::get('cpl', [CplController::class, 'index'])->name('cpl');
        Route::get('cpl/tambah/', [Tambah::class, 'indexcpl'])->name('tambahcpl');
        Route::post('cpl/tambah/post', [Tambah::class, 'cpl']);
        Route::get('cpl/hapus/{id}', [Hapus::class, 'cpl']);
        Route::get('cpl/edit/{id}', [Edit::class, 'indexcpl']);
        Route::post('cpl/edit/{id}/post', [Edit::class, 'cpl']);
    });
    Route::group(['middleware' => ['role:admin|dosen_koordinator']], function () {
        // CPMK
        Route::get('cpmk', [CpmkController::class, 'index'])->name('cpmk');
        Route::get('cpmk/tambah/', [Tambah::class, 'indexcpmk'])->name('tambahcpmk');
        Route::post('cpmk/tambah/post', [Tambah::class, 'cpmk']);
        Route::get('cpmk/hapus/{id}', [Hapus::class, 'cpmk']);
        Route::get('cpmk/edit/{id}', [Edit::class, 'indexcpmk']);
        Route::post('cpmk/edit/{id}/post', [Edit::class, 'cpmk']);
        // Bobot Teknik Penilaian
        Route::get('btp', [BtpController::class, 'index'])->name('btp');
        Route::get('btp/cari', [BtpController::class, 'cari'])->name('btpcari');
        Route::post('tambah-btp', [BtpController::class, 'store']);
        Route::get('get-btp', [BtpController::class, 'getBtp']);
        Route::post('edit-btp', [BtpController::class, 'edit']);
        Route::post('hapus-btp', [BtpController::class, 'hapus']);
        // Bobot CPL
        Route::get('bcpl', [BobotcplController::class, 'index'])->name('bcpl');
        Route::get('bcpl/cari', [BobotcplController::class, 'cari'])->name('bcplcari');
        Route::post('tambah-bcpl', [BobotcplController::class, 'store']);
        Route::get('get-bcpl', [BobotcplController::class, 'get']);
        Route::get('cek-teknik', [BobotcplController::class, 'cekTeknik']);
        Route::post('edit-bcpl', [BobotcplController::class, 'edit']);
        Route::post('hapus-bcpl', [BobotcplController::class, 'hapus']);
    });
    Route::group(['middleware' => ['role:admin|dosen_koordinator|dosen_pengampu']], function () {
        // Nilai
        Route::get('nilai', [NilaiController::class, 'index'])->name('nilai');
        Route::get('nilai/cari', [NilaiController::class, 'cari'])->name('nilaicari');
        Route::post('nilai-post', [NilaiController::class, 'store']);
    });
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
