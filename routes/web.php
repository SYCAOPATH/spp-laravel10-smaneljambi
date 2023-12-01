<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudKelasController;
use App\Http\Controllers\CrudPetugasController;
use App\Http\Controllers\CrudSppController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\EntriTransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::guard('siswa')->check() || Auth::guard('petugas')->check()) {
        return redirect('/homepage');
    }
    return view('pages.login');
})->name('login');

Route::post('/proses_login', [AuthController::class, 'proses_login'])->name('proses_login');

// Siswa Routes
Route::middleware(['auth:siswa,petugas'])->group(function () {
    // Your siswa-specific routes go here
    Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage');
    Route::get('/histori-bayar', [HomepageController::class, 'historiBayar'])->name('histori-bayar');
    Route::get('logout',[AuthController::class, 'logout'])->name('logout');
    Route::get('/user-setting', [HomepageController::class, 'userSetting'])->name('user-setting');
    Route::post('/user-setting', [HomepageController::class, 'userUpdateSetting'])->name('user-setting-post');
    Route::post('/petugas-setting', [HomepageController::class, 'petugasUpdateSetting'])->name('petugas-setting-post');

});

Route::middleware(['auth:petugas'])->group(function () {
    Route::get('/data-siswa', [AdminController::class, 'viewDataSiswa'])->name('crud-data-siswa');
    Route::get('/data-siswa/{id}', [AdminController::class, 'editDataSiswa'])->name('edit-siswa');
    Route::post('/data-siswa', [AdminController::class, 'updateDataSiswa'])->name('update-data-siswa');
    Route::delete('/data-siswa/{id}', [AdminController::class, 'softDeleteDataSiswa'])->name('softdelete-data-siswa');
    Route::get('/crate-data-siswa', [AdminController::class, 'createDataSiswa'])->name('create-data-siswa');
    Route::post('/crate-data-siswa', [AdminController::class, 'insertDataSiswa'])->name('insert-data-siswa');

    //actualy you can short this code with : Route::resource('data-siswa', App\Http\Controllers\AdminController::class);

    Route::get('/data-petugas', [CrudPetugasController::class, 'viewDataPetugas'])->name('crud-data-petugas');
    Route::get('/data-petugas/{id}', [CrudPetugasController::class, 'editDataPetugas'])->name('edit-petugas');
    Route::post('/data-petugas', [CrudPetugasController::class, 'updateDataPetugas'])->name('update-data-petugas');
    Route::delete('/data-petugas/{id}', [CrudPetugasController::class, 'hardDeleteDataPetugas'])->name('harddelete-data-petugas');
    Route::get('/crate-data-petugas', [CrudPetugasController::class, 'createDataPetugas'])->name('create-data-petugas');
    Route::post('/crate-data-petugas', [CrudPetugasController::class, 'insertDataPetugas'])->name('insert-data-petugas');


    Route::get('/data-kelas', [CrudKelasController::class, 'viewDataKelas'])->name('crud-data-kelas');
    Route::get('/data-kelas/{id}', [CrudKelasController::class, 'editDataKelas'])->name('edit-kelas');
    Route::post('/data-kelas', [CrudKelasController::class, 'updateDataKelas'])->name('update-data-kelas');
    Route::delete('/data-kelas/{id}', [CrudKelasController::class, 'hardDeleteDataKelas'])->name('harddelete-data-kelas');
    Route::get('/crate-data-kelas', [CrudKelasController::class, 'createDataKelas'])->name('create-data-kelas');
    Route::post('/crate-data-kelas', [CrudKelasController::class, 'insertDataKelas'])->name('insert-data-kelas');


    Route::get('/data-spp', [CrudSppController::class, 'viewDataSpp'])->name('crud-data-spp');
    Route::get('/data-spp/{id}', [CrudSppController::class, 'editDataSpp'])->name('edit-spp');
    Route::post('/data-spp', [CrudSppController::class, 'updateDataSpp'])->name('update-data-spp');
    Route::delete('/data-spp/{id}', [CrudSppController::class, 'hardDeleteDataSpp'])->name('harddelete-data-spp');
    Route::get('/crate-data-spp', [CrudSppController::class, 'createDataSpp'])->name('create-data-spp');
    Route::post('/crate-data-spp', [CrudSppController::class, 'insertDataSpp'])->name('insert-data-spp');


    Route::get('/data-transaksi', [EntriTransaksiController::class, 'createTransaksi'])->name('create-data-transaksi');
    Route::post('/data-transaksi', [EntriTransaksiController::class, 'cekDataSiswa'])->name('cek-data-siswa');
    Route::post('/data-transaksi-insert', [EntriTransaksiController::class, 'insertSingleTransaksi'])->name('create-single-data-transaksi');

    Route::get('/generate-laporan', [AdminController::class, 'generateLaporan'])->name('generate-laporan');
});