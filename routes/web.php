<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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
        Route::get('admin/tambah/', [Tambah::class, 'indexadmin'])->name('tambahadmin');
        Route::post('admin/tambah/post', [Tambah::class, 'admin']);
        Route::get('admin/hapus/{id}', [Hapus::class, 'admin']);
        Route::get('admin/edit/{id}', [Edit::class, 'indexadmin']);
        Route::post('admin/edit/{id}/post', [Edit::class, 'admin']);
        // Dosen
        Route::get('dosen', [DosenController::class, 'index'])->name('dosen');
        Route::get('dosen/tambah/', [Tambah::class, 'indexdosen'])->name('tambahdosen');
        Route::post('dosen/tambah/post', [Tambah::class, 'dosen']);
        Route::get('dosen/hapus/{id}', [Hapus::class, 'dosen']);
        Route::get('dosen/edit/{id}', [Edit::class, 'indexdosen']);
        Route::post('dosen/edit/{id}/post', [Edit::class, 'dosen']);
        // Mahasiswa
        Route::get('mhs', [MahasiswaController::class, 'index'])->name('mhs');
        Route::get('mhs/tambah/', [Tambah::class, 'indexmhs'])->name('tambahmhs');
        Route::post('mhs/tambah/post', [Tambah::class, 'mhs']);
        Route::get('mhs/hapus/{id}', [Hapus::class, 'mhs']);
        Route::get('mhs/edit/{id}', [Edit::class, 'indexmhs']);
        Route::post('mhs/edit/{id}/post', [Edit::class, 'mhs']);
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
        Route::post('hapus-btp', [BtpController::class, 'hapus']);
    });
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
