<?php

use App\Http\Controllers\Admin\AdminAkademikController;
use App\Http\Controllers\Admin\AdminBahanAjarController;
use App\Http\Controllers\Admin\AdminDosenController;
use App\Http\Controllers\Admin\AdminJadwalPengajaranController;
use App\Http\Controllers\Admin\AdminJurusanController;
use App\Http\Controllers\Admin\AdminLevelController;
use App\Http\Controllers\Admin\AdminMahasiswaController;
use App\Http\Controllers\Admin\AdminProdiController;
use App\Http\Controllers\Admin\AdminRpsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dosen\DosenBahanAjarController;
use App\Http\Controllers\Dosen\DosenJadwalPengajaranController;
use App\Http\Controllers\Dosen\DosenRpsController;
use App\Http\Controllers\Kaprodi\KaprodiAkademikController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenJadwalPengajaranController;
use App\Http\Controllers\Mahasiswa\MahasiswaBahanAjarController;
use App\Http\Controllers\Mahasiswa\MahasiswaJadwalPengajaranController;
use App\Http\Controllers\Mahasiswa\MahasiswaRpsController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Middleware\CekLevel;
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

//  Login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login-action', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/login-logout', [LoginController::class, 'logout'])->name('login.logout');

Route::group(['middleware' => ['auth', 'verified']], function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Setting
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/updateprofile', [SettingController::class, 'updateprofile'])->name('setting.updateprofile');
    Route::post('/setting/updateusername', [SettingController::class, 'updateusername'])->name('setting.updateusername');
    Route::post('/setting/updatepassword', [SettingController::class, 'updatepassword'])->name('setting.updatepassword');
    Route::post('/setting/updategambar', [SettingController::class, 'updategambar'])->name('setting.updategambar');
    Route::post('/setting/hapusgambar', [SettingController::class, 'hapusgambar'])->name('setting.hapusgambar');

    // Admin
    Route::group(['middleware' => [CekLevel::class . ':1']], function () {

        // Data Akademik
        Route::get('/data-akademik', [AdminAkademikController::class, 'index'])->name('data-akademik.index');
        Route::get('/data-akademik/create/{id}', [AdminAkademikController::class, 'create'])->name('data-akademik.create');
        Route::get('/data-akademik/akademik/{id}', [AdminAkademikController::class, 'akademik'])->name('data-akademik.akademik');
        Route::get('/data-akademik/edit/{id}', [AdminAkademikController::class, 'edit'])->name('data-akademik.edit');
        Route::post('/data-akademik/store', [AdminAkademikController::class, 'store'])->name('data-akademik.store');
        Route::post('/data-akademik/update/{id}', [AdminAkademikController::class, 'update'])->name('data-akademik.update');
        Route::post('/data-akademik/destroy/{id}', [AdminAkademikController::class, 'destroy'])->name('data-akademik.destroy');

        // Rps
        Route::get('/data-rps', [AdminRpsController::class, 'index'])->name('data-rps.index');
        Route::get('/data-rps/create', [AdminRpsController::class, 'create'])->name('data-rps.create');
        Route::get('/data-rps/edit/{id}', [AdminRpsController::class, 'edit'])->name('data-rps.edit');
        Route::post('/data-rps/store', [AdminRpsController::class, 'store'])->name('data-rps.store');
        Route::post('/data-rps/update/{id}', [AdminRpsController::class, 'update'])->name('data-rps.update');
        Route::post('/data-rps/destroy/{id}', [AdminRpsController::class, 'destroy'])->name('data-rps.destroy');

        // Bahan Ajar
        Route::get('/data-bahanajar', [AdminBahanAjarController::class, 'index'])->name('data-bahanajar.index');
        Route::get('/data-bahanajar/create', [AdminBahanAjarController::class, 'create'])->name('data-bahanajar.create');
        Route::get('/data-bahanajar/edit/{id}', [AdminBahanAjarController::class, 'edit'])->name('data-bahanajar.edit');
        Route::post('/data-bahanajar/store', [AdminBahanAjarController::class, 'store'])->name('data-bahanajar.store');
        Route::post('/data-bahanajar/update/{id}', [AdminBahanAjarController::class, 'update'])->name('data-bahanajar.update');
        Route::post('/data-bahanajar/destroy/{id}', [AdminBahanAjarController::class, 'destroy'])->name('data-bahanajar.destroy');

        // Jadwal Pengajaran
        Route::get('/data-jadwalpengajaran', [AdminJadwalPengajaranController::class, 'index'])->name('data-jadwalpengajaran.index');
        Route::get('/data-jadwalpengajaran/create', [AdminJadwalPengajaranController::class, 'create'])->name('data-jadwalpengajaran.create');
        Route::get('/data-jadwalpengajaran/edit/{id}', [AdminJadwalPengajaranController::class, 'edit'])->name('data-jadwalpengajaran.edit');
        Route::post('/data-jadwalpengajaran/store', [AdminJadwalPengajaranController::class, 'store'])->name('data-jadwalpengajaran.store');
        Route::post('/data-jadwalpengajaran/update/{id}', [AdminJadwalPengajaranController::class, 'update'])->name('data-jadwalpengajaran.update');
        Route::post('/data-jadwalpengajaran/destroy/{id}', [AdminJadwalPengajaranController::class, 'destroy'])->name('data-jadwalpengajaran.destroy');

        // Dosen
        Route::get('/data-dosen', [AdminDosenController::class, 'index'])->name('data-dosen.index');
        Route::get('/data-dosen/prodi/{id}', [AdminDosenController::class, 'prodi'])->name('data-dosen.prodi');
        Route::get('/data-dosen/dosen/{id}', [AdminDosenController::class, 'dosen'])->name('data-dosen.dosen');
        Route::get('/data-dosen/create/{id}', [AdminDosenController::class, 'create'])->name('data-dosen.create');
        Route::get('/data-dosen/edit/{id}', [AdminDosenController::class, 'edit'])->name('data-dosen.edit');
        Route::post('/data-dosen/store', [AdminDosenController::class, 'store'])->name('data-dosen.store');
        Route::post('/data-dosen/update/{id}', [AdminDosenController::class, 'update'])->name('data-dosen.update');
        Route::post('/data-dosen/destroy/{id}', [AdminDosenController::class, 'destroy'])->name('data-dosen.destroy');

        // Mahasiswa
        Route::get('/data-mahasiswa', [AdminMahasiswaController::class, 'index'])->name('data-mahasiswa.index');
        Route::get('/data-mahasiswa/prodi/{id}', [AdminMahasiswaController::class, 'prodi'])->name('data-mahasiswa.prodi');
        Route::get('/data-mahasiswa/mahasiswa/{id}', [AdminMahasiswaController::class, 'mahasiswa'])->name('data-mahasiswa.mahasiswa');
        Route::get('/data-mahasiswa/create/{id}', [AdminMahasiswaController::class, 'create'])->name('data-mahasiswa.create');
        Route::get('/data-mahasiswa/edit/{id}', [AdminMahasiswaController::class, 'edit'])->name('data-mahasiswa.edit');
        Route::post('/data-mahasiswa/store', [AdminMahasiswaController::class, 'store'])->name('data-mahasiswa.store');
        Route::post('/data-mahasiswa/update/{id}', [AdminMahasiswaController::class, 'update'])->name('data-mahasiswa.update');
        Route::post('/data-mahasiswa/destroy/{id}', [AdminMahasiswaController::class, 'destroy'])->name('data-mahasiswa.destroy');

        // Data Prodi
        Route::get('/data-prodi', [AdminProdiController::class, 'index'])->name('data-prodi.index');
        Route::get('/data-prodi/index_prodi/{id}', [AdminProdiController::class, 'indexprodi'])->name('data-prodi.indexprodi');
        Route::get('/data-prodi/tambah_prodi/{id}', [AdminProdiController::class, 'create'])->name('data-prodi.tambahprodi');
        Route::get('/data-prodi/edit_prodi/{id}', [AdminProdiController::class, 'edit'])->name('data-prodi.editprodi');
        Route::post('/data-prodi/store', [AdminProdiController::class, 'store'])->name('data-prodi.store');
        Route::post('/data-prodi/update/{id}', [AdminProdiController::class, 'update'])->name('data-prodi.update');
        Route::post('/data-prodi/destroy/{id}', [AdminProdiController::class, 'destroy'])->name('data-prodi.destroy');

        // Data Jurusan
        Route::get('/data-jurusan', [AdminJurusanController::class, 'index'])->name('data-jurusan.index');
        Route::get('/data-jurusan/create', [AdminJurusanController::class, 'create'])->name('data-jurusan.create');
        Route::get('/data-jurusan/edit/{id}', [AdminJurusanController::class, 'edit'])->name('data-jurusan.edit');
        Route::post('/data-jurusan/store', [AdminJurusanController::class, 'store'])->name('data-jurusan.store');
        Route::post('/data-jurusan/update/{id}', [AdminJurusanController::class, 'update'])->name('data-jurusan.update');
        Route::post('/data-jurusan/destroy/{id}', [AdminJurusanController::class, 'destroy'])->name('data-jurusan.destroy');

        // Data User
        Route::get('/data-user', [AdminUserController::class, 'index'])->name('data-user.index');
        Route::get('/data-user/create', [AdminUserController::class, 'create'])->name('data-user.create');
        Route::get('/data-user/edit/{id}', [AdminUserController::class, 'edit'])->name('data-user.edit');
        Route::post('/data-user/store', [AdminUserController::class, 'store'])->name('data-user.store');
        Route::post('/data-user/update/{id}', [AdminUserController::class, 'update'])->name('data-user.update');
        Route::post('/data-user/destroy/{id}', [AdminUserController::class, 'destroy'])->name('data-user.destroy');

        // Level
        Route::get('/data-level', [AdminLevelController::class, 'index'])->name('data-level.index');
        Route::get('/data-level/create', [AdminLevelController::class, 'create'])->name('data-level.create');
        Route::get('/data-level/edit/{id}', [AdminLevelController::class, 'edit'])->name('data-level.edit');
        Route::post('/data-level/store', [AdminLevelController::class, 'store'])->name('data-level.store');
        Route::post('/data-level/update/{id}', [AdminLevelController::class, 'update'])->name('data-level.update');
        Route::post('/data-level/destroy/{id}', [AdminLevelController::class, 'destroy'])->name('data-level.destroy');
    });

    // Kepala Departemen
    Route::group(['middleware' => [CekLevel::class . ':3']], function () {
        Route::get('/kepala-jadwalpengajaran', [KepalaDepartemenJadwalPengajaranController::class, 'index'])->name('kepala-jadwalpengajaran.index');
        Route::get('/kepala-jadwalpengajaran/create', [KepalaDepartemenJadwalPengajaranController::class, 'create'])->name('kepala-jadwalpengajaran.create');
        Route::get('/kepala-jadwalpengajaran/edit/{id}', [KepalaDepartemenJadwalPengajaranController::class, 'edit'])->name('kepala-jadwalpengajaran.edit');
        Route::post('/kepala-jadwalpengajaran/store', [KepalaDepartemenJadwalPengajaranController::class, 'store'])->name('kepala-jadwalpengajaran.store');
        Route::post('/kepala-jadwalpengajaran/update/{id}', [KepalaDepartemenJadwalPengajaranController::class, 'update'])->name('kepala-jadwalpengajaran.update');
        Route::post('/kepala-jadwalpengajaran/destroy/{id}', [KepalaDepartemenJadwalPengajaranController::class, 'destroy'])->name('kepala-jadwalpengajaran.destroy');
    });

    // Kaprodi
    Route::group(['middleware' => [CekLevel::class . ':4']], function () {
        // Data Akademik
        Route::get('/kaprodi-akademik', [KaprodiAkademikController::class, 'index'])->name('kaprodi-akademik.index');
        Route::get('/kaprodi-akademik/create/{id}', [KaprodiAkademikController::class, 'create'])->name('kaprodi-akademik.create');
        Route::get('/kaprodi-akademik/akademik/{id}', [KaprodiAkademikController::class, 'akademik'])->name('kaprodi-akademik.akademik');
        Route::get('/kaprodi-akademik/edit/{id}', [KaprodiAkademikController::class, 'edit'])->name('kaprodi-akademik.edit');
        Route::post('/kaprodi-akademik/store', [KaprodiAkademikController::class, 'store'])->name('kaprodi-akademik.store');
        Route::post('/kaprodi-akademik/update/{id}', [KaprodiAkademikController::class, 'update'])->name('kaprodi-akademik.update');
        Route::post('/kaprodi-akademik/destroy/{id}', [KaprodiAkademikController::class, 'destroy'])->name('kaprodi-akademik.destroy');
    });
    // Dosen
    Route::group(['middleware' => [CekLevel::class . ':5']], function () {
        // Rps
        Route::get('/dosen-rps', [DosenRpsController::class, 'index'])->name('dosen-rps.index');
        Route::get('/dosen-rps/create', [DosenRpsController::class, 'create'])->name('dosen-rps.create');
        Route::get('/dosen-rps/edit/{id}', [DosenRpsController::class, 'edit'])->name('dosen-rps.edit');
        Route::post('/dosen-rps/store', [DosenRpsController::class, 'store'])->name('dosen-rps.store');
        Route::post('/dosen-rps/update/{id}', [DosenRpsController::class, 'update'])->name('dosen-rps.update');
        Route::post('/dosen-rps/destroy/{id}', [DosenRpsController::class, 'destroy'])->name('dosen-rps.destroy');
        // Bahan Ajar
        Route::get('/dosen-bahanajar', [DosenBahanAjarController::class, 'index'])->name('dosen-bahanajar.index');
        Route::get('/dosen-bahanajar/create', [DosenBahanAjarController::class, 'create'])->name('dosen-bahanajar.create');
        Route::get('/dosen-bahanajar/edit/{id}', [DosenBahanAjarController::class, 'edit'])->name('dosen-bahanajar.edit');
        Route::post('/dosen-bahanajar/store', [DosenBahanAjarController::class, 'store'])->name('dosen-bahanajar.store');
        Route::post('/dosen-bahanajar/update/{id}', [DosenBahanAjarController::class, 'update'])->name('dosen-bahanajar.update');
        Route::post('/dosen-bahanajar/destroy/{id}', [DosenBahanAjarController::class, 'destroy'])->name('dosen-bahanajar.destroy');

        // Jadwal Pengajaran
        Route::get('/dosen-jadwalpengajaran', [DosenJadwalPengajaranController::class, 'index'])->name('dosen-jadwalpengajaran.index');
    });

    // Mahasiswa
    Route::group(['middleware' => [CekLevel::class . ':6']], function () {
        // Mahasiswa
        Route::get('/mahasiswa-rps', [MahasiswaRpsController::class, 'index'])->name('mahasiswa-rps.index');
        // Bahan Ajar
        Route::get('/mahasiswa-bahanajar', [MahasiswaBahanAjarController::class, 'index'])->name('mahasiswa-bahanajar.index');
        // Jadwal Pengajaran
        Route::get('/mahasiswa-jadwalpengajaran', [MahasiswaJadwalPengajaranController::class, 'index'])->name('mahasiswa-jadwalpengajaran.index');
    });
});
