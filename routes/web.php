<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BcplController;
use App\Http\Controllers\BtpController;
use App\Http\Controllers\CPLController;
use App\Http\Controllers\CPMKController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DpnaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KcplController;
use App\Http\Controllers\KcpmkController;
use App\Http\Controllers\KRSController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\TahunAjaranController;
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

Route::get('/', [AuthController::class, 'showFormLogin']);
Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);

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
        Route::get('ta/tambah/', [TahunAjaranController::class, 'tambahindex'])->name('tambahta');
        Route::post('ta/tambah/post', [TahunAjaranController::class, 'tambah'])->name('form-tambah-ta');
        Route::get('ta/hapus/{id}', [TahunAjaranController::class, 'hapus']);
        Route::get('ta/edit/{id}', [TahunAjaranController::class, 'editindex']);
        Route::post('ta/edit/{id}/post', [TahunAjaranController::class, 'edit']);
        // Mata Kuliah
        Route::get('mk', [MataKuliahController::class, 'index'])->name('mk');
        Route::get('mk/tambah/', [MataKuliahController::class, 'tambahindex'])->name('tambahmk');
        Route::post('mk/tambah/post', [MataKuliahController::class, 'tambah'])->name('form-tambah-mk');
        Route::get('mk/hapus/{id}', [MataKuliahController::class, 'hapus']);
        Route::get('mk/edit/{id}', [MataKuliahController::class, 'editindex']);
        Route::post('mk/edit/{id}/post', [MataKuliahController::class, 'edit']);
        // Mata Kuliah
        Route::get('krs', [KRSController::class, 'index'])->name('krs');
        Route::get('krs/cari', [KRSController::class, 'cari'])->name('krscari');
        Route::post('tambah-krs', [KRSController::class, 'store']);
        Route::post('hapus-krs', [KRSController::class, 'hapus']);
        // CPL
        Route::get('cpl', [CPLController::class, 'index'])->name('cpl');
        Route::get('cpl/tambah/', [CPLController::class, 'tambahindex'])->name('tambahcpl');
        Route::post('cpl/tambah/post', [CPLController::class, 'tambah'])->name('form-tambah-cpl');
        Route::get('cpl/hapus/{id}', [CPLController::class, 'hapus']);
        Route::get('cpl/edit/{id}', [CPLController::class, 'editindex']);
        Route::post('cpl/edit/{id}/post', [CPLController::class, 'edit']);
    });
    Route::group(['middleware' => ['role:admin|dosen_koordinator']], function () {
        // CPMK
        Route::get('cpmk', [CPMKController::class, 'index'])->name('cpmk');
        Route::get('cpmk/tambah/', [CPMKController::class, 'tambahindex'])->name('tambahcpmk');
        Route::post('cpmk/tambah/post', [CPMKController::class, 'tambah'])->name('form-tambah-cpmk');
        Route::get('cpmk/hapus/{id}', [CPMKController::class, 'hapus']);
        Route::get('cpmk/edit/{id}', [CPMKController::class, 'editindex']);
        Route::post('cpmk/edit/{id}/post', [CPMKController::class, 'edit']);
        // Bobot Teknik Penilaian
        Route::get('btp', [BtpController::class, 'index'])->name('btp');
        Route::get('btp/cari', [BtpController::class, 'cari'])->name('btpcari');
        Route::post('tambah-btp', [BtpController::class, 'store']);
        Route::get('get-btp', [BtpController::class, 'getBtp']);
        Route::post('edit-btp', [BtpController::class, 'edit']);
        Route::post('hapus-btp', [BtpController::class, 'hapus']);
        // Bobot CPL
        Route::get('bcpl', [BcplController::class, 'index'])->name('bcpl');
        Route::get('bcpl/cari', [BcplController::class, 'cari'])->name('bcplcari');
        Route::post('tambah-bcpl', [BcplController::class, 'store']);
        Route::get('get-bcpl', [BcplController::class, 'get']);
        Route::get('cek-teknik', [BcplController::class, 'cekTeknik']);
        Route::post('edit-bcpl', [BcplController::class, 'edit']);
        Route::post('hapus-bcpl', [BcplController::class, 'hapus']);
        // Ketercapaian CPMK
        Route::get('kcpmk', [KcpmkController::class, 'index'])->name('kcpmk');
        Route::get('kcpmk/cari', [KcpmkController::class, 'cari'])->name('kcpmkcari');
        Route::get('kcpmk-cetak', [KcpmkController::class, 'downloadPDF'])->name('kcpmk-cetak');
        // Ketercapaian CPL
        Route::get('kcpl', [KcplController::class, 'index'])->name('kcpl');
        Route::get('kcpl/cari', [KcplController::class, 'cari'])->name('kcplcari');
        Route::get('kcpl-cetak', [KcplController::class, 'downloadPDF'])->name('kcpl-cetak');
        // DPNA
        Route::get('dpna', [DpnaController::class, 'index'])->name('dpna');
        Route::get('dpna/cari', [DpnaController::class, 'cari'])->name('dpnacari');
        Route::get('dpna-cetak', [DpnaController::class, 'downloadPDF'])->name('dpna-cetak');
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
