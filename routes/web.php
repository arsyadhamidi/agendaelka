<?php

use App\Http\Controllers\Admin\AdminAkademikController;
use App\Http\Controllers\Admin\AdminBahanAjarController;
use App\Http\Controllers\Admin\AdminDosenController;
use App\Http\Controllers\Admin\AdminJadwalPengajaranController;
use App\Http\Controllers\Admin\AdminLevelController;
use App\Http\Controllers\Admin\AdminMahasiswaController;
use App\Http\Controllers\Admin\AdminMatkulController;
use App\Http\Controllers\Admin\AdminPenelitianController;
use App\Http\Controllers\Admin\AdminPengabdianController;
use App\Http\Controllers\Admin\AdminProdiController;
use App\Http\Controllers\Admin\AdminPublikasiController;
use App\Http\Controllers\Admin\AdminRapatController;
use App\Http\Controllers\Admin\AdminRpsController;
use App\Http\Controllers\Admin\AdminSeminarController;
use App\Http\Controllers\Admin\AdminStudiLanjutController;
use App\Http\Controllers\Admin\AdminTahunController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RecoverPasswordController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dosen\DosenAkademikController;
use App\Http\Controllers\Dosen\DosenBahanAjarController;
use App\Http\Controllers\Dosen\DosenJadwalPengajaranController;
use App\Http\Controllers\Dosen\DosenPenelitianController;
use App\Http\Controllers\Dosen\DosenPengabdianController;
use App\Http\Controllers\Dosen\DosenPublikasiController;
use App\Http\Controllers\Dosen\DosenRapatController;
use App\Http\Controllers\Dosen\DosenRpsController;
use App\Http\Controllers\Dosen\DosenSeminarController;
use App\Http\Controllers\Dosen\DosenStudiLanjutController;
use App\Http\Controllers\Kaprodi\KaprodiAkademikController;
use App\Http\Controllers\Kaprodi\KaprodiBahanAjarController;
use App\Http\Controllers\Kaprodi\KaprodiJadwalPengajaranController;
use App\Http\Controllers\Kaprodi\KaprodiPenelitianController;
use App\Http\Controllers\Kaprodi\KaprodiPengabdianController;
use App\Http\Controllers\Kaprodi\KaprodiPublikasiController;
use App\Http\Controllers\Kaprodi\KaprodiRapatController;
use App\Http\Controllers\Kaprodi\KaprodiRpsController;
use App\Http\Controllers\Kaprodi\KaprodiSeminarController;
use App\Http\Controllers\Kaprodi\KaprodiStudiLanjutController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenAkademikController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenBahanAjarController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenJadwalPengajaranController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenPenelitianController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenPengabdianController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenPublikasiController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenRapatController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenRpsController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenSeminarController;
use App\Http\Controllers\KepalaDepartemen\KepalaDepartemenStudiLanjutController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Mahasiswa\MahasiswaAkademikController;
use App\Http\Controllers\Mahasiswa\MahasiswaBahanAjarController;
use App\Http\Controllers\Mahasiswa\MahasiswaJadwalPengajaranController;
use App\Http\Controllers\Mahasiswa\MahasiswaPenelitianController;
use App\Http\Controllers\Mahasiswa\MahasiswaPengabdianController;
use App\Http\Controllers\Mahasiswa\MahasiswaPublikasiController;
use App\Http\Controllers\Mahasiswa\MahasiswaRpsController;
use App\Http\Controllers\Mahasiswa\MahasiswaSeminarController;
use App\Http\Controllers\Mahasiswa\MahasiswaStudiLanjutController;
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

//  Landing
Route::get('/', [LandingController::class, 'index']);

//  Login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/reload-captcha', [LoginController::class, 'reloadcaptcha'])->name('reload-captcha');
Route::post('/login-action', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/login-logout', [LoginController::class, 'logout'])->name('login.logout');

// Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password.index');
Route::post('/forgot-password/store', [ForgotPasswordController::class, 'store'])->name('forgot-password.store');

// Recorver Password
Route::get('/recover-password', [RecoverPasswordController::class, 'index'])->name('recover-password.index')->middleware('auth');
Route::post('/recover-password/store', [RecoverPasswordController::class, 'store'])->name('recover-password.store');

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
    Route::group(['middleware' => [CekLevel::class . ':1,2']], function () {

        // Studi Lanjut
        Route::get('/data-studilanjut', [AdminStudiLanjutController::class, 'index'])->name('data-studilanjut.index');
        Route::get('/data-studilanjut/tahun/{id}', [AdminStudiLanjutController::class, 'tahun'])->name('data-studilanjut.tahun');
        Route::get('/data-studilanjut/generateexcel/{id}', [AdminStudiLanjutController::class, 'generateexcel'])->name('data-studilanjut.generateexcel');
        Route::get('/data-studilanjut/studilanjut/{id}', [AdminStudiLanjutController::class, 'studilanjut'])->name('data-studilanjut.studilanjut');
        Route::get('/data-studilanjut/create/{id}', [AdminStudiLanjutController::class, 'create'])->name('data-studilanjut.create');
        Route::get('/data-studilanjut/edit/{id}', [AdminStudiLanjutController::class, 'edit'])->name('data-studilanjut.edit');
        Route::post('/data-studilanjut/store', [AdminStudiLanjutController::class, 'store'])->name('data-studilanjut.store');
        Route::post('/data-studilanjut/update/{id}', [AdminStudiLanjutController::class, 'update'])->name('data-studilanjut.update');
        Route::post('/data-studilanjut/destroy/{id}', [AdminStudiLanjutController::class, 'destroy'])->name('data-studilanjut.destroy');

        // Data Publikasi Ilmiah
        Route::get('/data-publikasi', [AdminPublikasiController::class, 'index'])->name('data-publikasi.index');
        Route::get('/data-publikasi/tahun/{id}', [AdminPublikasiController::class, 'tahun'])->name('data-publikasi.tahun');
        Route::get('/data-publikasi/generateexcel/{id}', [AdminPublikasiController::class, 'generateexcel'])->name('data-publikasi.generateexcel');
        Route::get('/data-publikasi/publikasi/{id}', [AdminPublikasiController::class, 'publikasi'])->name('data-publikasi.publikasi');
        Route::get('/data-publikasi/create/{id}', [AdminPublikasiController::class, 'create'])->name('data-publikasi.create');
        Route::get('/data-publikasi/edit/{id}', [AdminPublikasiController::class, 'edit'])->name('data-publikasi.edit');
        Route::post('/data-publikasi/store', [AdminPublikasiController::class, 'store'])->name('data-publikasi.store');
        Route::post('/data-publikasi/update/{id}', [AdminPublikasiController::class, 'update'])->name('data-publikasi.update');
        Route::post('/data-publikasi/destroy/{id}', [AdminPublikasiController::class, 'destroy'])->name('data-publikasi.destroy');

        // Data Pengabdian
        Route::get('/data-pengabdian', [AdminPengabdianController::class, 'index'])->name('data-pengabdian.index');
        Route::get('/data-pengabdian/tahun/{id}', [AdminPengabdianController::class, 'tahun'])->name('data-pengabdian.tahun');
        Route::get('/data-pengabdian/generateexcel/{id}', [AdminPengabdianController::class, 'generateexcel'])->name('data-pengabdian.generateexcel');
        Route::get('/data-pengabdian/pengabdian/{id}', [AdminPengabdianController::class, 'pengabdian'])->name('data-pengabdian.pengabdian');
        Route::get('/data-pengabdian/create/{id}', [AdminPengabdianController::class, 'create'])->name('data-pengabdian.create');
        Route::get('/data-pengabdian/edit/{id}', [AdminPengabdianController::class, 'edit'])->name('data-pengabdian.edit');
        Route::post('/data-pengabdian/store', [AdminPengabdianController::class, 'store'])->name('data-pengabdian.store');
        Route::post('/data-pengabdian/update/{id}', [AdminPengabdianController::class, 'update'])->name('data-pengabdian.update');
        Route::post('/data-pengabdian/destroy/{id}', [AdminPengabdianController::class, 'destroy'])->name('data-pengabdian.destroy');

        // Data Penelitian
        Route::get('/data-penelitian', [AdminPenelitianController::class, 'index'])->name('data-penelitian.index');
        Route::get('/data-penelitian/tahun/{id}', [AdminPenelitianController::class, 'tahun'])->name('data-penelitian.tahun');
        Route::get('/data-penelitian/generateexcel/{id}', [AdminPenelitianController::class, 'generateexcel'])->name('data-penelitian.generateexcel');
        Route::get('/data-penelitian/penelitian/{id}', [AdminPenelitianController::class, 'penelitian'])->name('data-penelitian.penelitian');
        Route::get('/data-penelitian/create/{id}', [AdminPenelitianController::class, 'create'])->name('data-penelitian.create');
        Route::get('/data-penelitian/edit/{id}', [AdminPenelitianController::class, 'edit'])->name('data-penelitian.edit');
        Route::post('/data-penelitian/store', [AdminPenelitianController::class, 'store'])->name('data-penelitian.store');
        Route::post('/data-penelitian/update/{id}', [AdminPenelitianController::class, 'update'])->name('data-penelitian.update');
        Route::post('/data-penelitian/destroy/{id}', [AdminPenelitianController::class, 'destroy'])->name('data-penelitian.destroy');

        // Data Rapat
        Route::get('/data-rapat', [AdminRapatController::class, 'index'])->name('data-rapat.index');
        Route::get('/data-rapat/create', [AdminRapatController::class, 'create'])->name('data-rapat.create');
        Route::get('/data-rapat/edit/{id}', [AdminRapatController::class, 'edit'])->name('data-rapat.edit');
        Route::post('/data-rapat/store', [AdminRapatController::class, 'store'])->name('data-rapat.store');
        Route::post('/data-rapat/update/{id}', [AdminRapatController::class, 'update'])->name('data-rapat.update');
        Route::post('/data-rapat/destroy/{id}', [AdminRapatController::class, 'destroy'])->name('data-rapat.destroy');

        // Matkul
        Route::get('/data-matkul', [AdminMatkulController::class, 'index'])->name('data-matkul.index');
        Route::get('/data-matkul/tahun/{id}', [AdminMatkulController::class, 'tahun'])->name('data-matkul.tahun');
        Route::get('/data-matkul/create/{id}', [AdminMatkulController::class, 'create'])->name('data-matkul.create');
        Route::get('/data-matkul/edit/{id}', [AdminMatkulController::class, 'edit'])->name('data-matkul.edit');
        Route::get('/data-matkul/matkul/{id}', [AdminMatkulController::class, 'matkul'])->name('data-matkul.matkul');
        Route::post('/data-matkul/store', [AdminMatkulController::class, 'store'])->name('data-matkul.store');
        Route::post('/data-matkul/update/{id}', [AdminMatkulController::class, 'update'])->name('data-matkul.update');
        Route::post('/data-matkul/destroy/{id}', [AdminMatkulController::class, 'destroy'])->name('data-matkul.destroy');

        // Seminar
        Route::get('/data-seminar', [AdminSeminarController::class, 'index'])->name('data-seminar.index');
        Route::get('/data-seminar/tahun/{id}', [AdminSeminarController::class, 'tahun'])->name('data-seminar.tahun');
        Route::get('/data-seminar/generateexcel/{id}', [AdminSeminarController::class, 'generateexcel'])->name('data-seminar.generateexcel');
        Route::get('/data-seminar/seminar/{id}', [AdminSeminarController::class, 'seminar'])->name('data-seminar.seminar');
        Route::get('/data-seminar/create/{id}', [AdminSeminarController::class, 'create'])->name('data-seminar.create');
        Route::get('/data-seminar/edit/{id}', [AdminSeminarController::class, 'edit'])->name('data-seminar.edit');
        Route::post('/data-seminar/store', [AdminSeminarController::class, 'store'])->name('data-seminar.store');
        Route::post('/data-seminar/update/{id}', [AdminSeminarController::class, 'update'])->name('data-seminar.update');
        Route::post('/data-seminar/destroy/{id}', [AdminSeminarController::class, 'destroy'])->name('data-seminar.destroy');

        // Data Tahun
        Route::get('/data-tahun', [AdminTahunController::class, 'index'])->name('data-tahun.index');
        Route::get('/data-tahun/tahun/{id}', [AdminTahunController::class, 'tahun'])->name('data-tahun.tahun');
        Route::get('/data-tahun/create/{id}', [AdminTahunController::class, 'create'])->name('data-tahun.create');
        Route::get('/data-tahun/edit/{id}', [AdminTahunController::class, 'edit'])->name('data-tahun.edit');
        Route::post('/data-tahun/store', [AdminTahunController::class, 'store'])->name('data-tahun.store');
        Route::post('/data-tahun/update/{id}', [AdminTahunController::class, 'update'])->name('data-tahun.update');
        Route::post('/data-tahun/destroy/{id}', [AdminTahunController::class, 'destroy'])->name('data-tahun.destroy');

        // Data Akademik
        Route::get('/data-akademik', [AdminAkademikController::class, 'index'])->name('data-akademik.index');
        Route::get('/data-akademik/tahun/{id}', [AdminAkademikController::class, 'tahun'])->name('data-akademik.tahun');
        Route::get('/data-akademik/create/{id}', [AdminAkademikController::class, 'create'])->name('data-akademik.create');
        Route::get('/data-akademik/akademik/{id}', [AdminAkademikController::class, 'akademik'])->name('data-akademik.akademik');
        Route::get('/data-akademik/edit/{id}', [AdminAkademikController::class, 'edit'])->name('data-akademik.edit');
        Route::post('/data-akademik/store', [AdminAkademikController::class, 'store'])->name('data-akademik.store');
        Route::post('/data-akademik/update/{id}', [AdminAkademikController::class, 'update'])->name('data-akademik.update');
        Route::post('/data-akademik/destroy/{id}', [AdminAkademikController::class, 'destroy'])->name('data-akademik.destroy');

        // Rps
        Route::get('/data-rps', [AdminRpsController::class, 'index'])->name('data-rps.index');
        Route::get('/data-rps/tahun/{id}', [AdminRpsController::class, 'tahun'])->name('data-rps.tahun');
        Route::get('/data-rps/rps/{id}', [AdminRpsController::class, 'rps'])->name('data-rps.rps');
        Route::get('/data-rps/create/{id}', [AdminRpsController::class, 'create'])->name('data-rps.create');
        Route::get('/data-rps/edit/{id}', [AdminRpsController::class, 'edit'])->name('data-rps.edit');
        Route::post('/data-rps/store', [AdminRpsController::class, 'store'])->name('data-rps.store');
        Route::post('/data-rps/update/{id}', [AdminRpsController::class, 'update'])->name('data-rps.update');
        Route::post('/data-rps/destroy/{id}', [AdminRpsController::class, 'destroy'])->name('data-rps.destroy');

        // Bahan Ajar
        Route::get('/data-bahanajar', [AdminBahanAjarController::class, 'index'])->name('data-bahanajar.index');
        Route::get('/data-bahanajar/create/{id}', [AdminBahanAjarController::class, 'create'])->name('data-bahanajar.create');
        Route::get('/data-bahanajar/tahun/{id}', [AdminBahanAjarController::class, 'tahun'])->name('data-bahanajar.tahun');
        Route::get('/data-bahanajar/bahanajar/{id}', [AdminBahanAjarController::class, 'bahanajar'])->name('data-bahanajar.bahanajar');
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
        Route::get('/data-dosen/generateexcel/{id}', [AdminDosenController::class, 'generateexcel'])->name('data-dosen.generateexcel');
        Route::get('/data-dosen/prodi/{id}', [AdminDosenController::class, 'prodi'])->name('data-dosen.prodi');
        Route::get('/data-dosen/dosen/{id}', [AdminDosenController::class, 'dosen'])->name('data-dosen.dosen');
        Route::get('/data-dosen/create/{id}', [AdminDosenController::class, 'create'])->name('data-dosen.create');
        Route::get('/data-dosen/edit/{id}', [AdminDosenController::class, 'edit'])->name('data-dosen.edit');
        Route::post('/data-dosen/store', [AdminDosenController::class, 'store'])->name('data-dosen.store');
        Route::post('/data-dosen/update/{id}', [AdminDosenController::class, 'update'])->name('data-dosen.update');
        Route::post('/data-dosen/destroy/{id}', [AdminDosenController::class, 'destroy'])->name('data-dosen.destroy');

        // Mahasiswa
        Route::get('/data-mahasiswa', [AdminMahasiswaController::class, 'index'])->name('data-mahasiswa.index');
        Route::get('/data-mahasiswa/generateexcel/{id}', [AdminMahasiswaController::class, 'generateexcel'])->name('data-mahasiswa.generateexcel');
        Route::get('/data-mahasiswa/tahun/{id}', [AdminMahasiswaController::class, 'tahun'])->name('data-mahasiswa.tahun');
        Route::get('/data-mahasiswa/mahasiswa/{id}', [AdminMahasiswaController::class, 'mahasiswa'])->name('data-mahasiswa.mahasiswa');
        Route::get('/data-mahasiswa/create/{id}', [AdminMahasiswaController::class, 'create'])->name('data-mahasiswa.create');
        Route::get('/data-mahasiswa/edit/{id}', [AdminMahasiswaController::class, 'edit'])->name('data-mahasiswa.edit');
        Route::post('/data-mahasiswa/store', [AdminMahasiswaController::class, 'store'])->name('data-mahasiswa.store');
        Route::post('/data-mahasiswa/update/{id}', [AdminMahasiswaController::class, 'update'])->name('data-mahasiswa.update');
        Route::post('/data-mahasiswa/destroy/{id}', [AdminMahasiswaController::class, 'destroy'])->name('data-mahasiswa.destroy');

        // Data Prodi
        Route::get('/data-prodi', [AdminProdiController::class, 'index'])->name('data-prodi.index');
        Route::get('/data-prodi/generateexcel', [AdminProdiController::class, 'generateexcel'])->name('data-prodi.generateexcel');
        Route::post('/data-prodi/importexcel', [AdminProdiController::class, 'importexcel'])->name('data-prodi.importexcel');
        Route::get('/data-prodi/create', [AdminProdiController::class, 'create'])->name('data-prodi.create');
        Route::get('/data-prodi/edit/{id}', [AdminProdiController::class, 'edit'])->name('data-prodi.edit');
        Route::post('/data-prodi/store', [AdminProdiController::class, 'store'])->name('data-prodi.store');
        Route::post('/data-prodi/update/{id}', [AdminProdiController::class, 'update'])->name('data-prodi.update');
        Route::post('/data-prodi/destroy/{id}', [AdminProdiController::class, 'destroy'])->name('data-prodi.destroy');

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

        // Studi Lanjut
        Route::get('/kepala-studilanjut', [KepalaDepartemenStudiLanjutController::class, 'index'])->name('kepala-studilanjut.index');
        Route::get('/kepala-studilanjut/tahun/{id}', [KepalaDepartemenStudiLanjutController::class, 'tahun'])->name('kepala-studilanjut.tahun');
        Route::get('/kepala-studilanjut/generateexcel/{id}', [KepalaDepartemenStudiLanjutController::class, 'generateexcel'])->name('kepala-studilanjut.generateexcel');
        Route::get('/kepala-studilanjut/studilanjut/{id}', [KepalaDepartemenStudiLanjutController::class, 'studilanjut'])->name('kepala-studilanjut.studilanjut');

        // Data Publikasi Ilmiah
        Route::get('/kepala-publikasi', [KepalaDepartemenPublikasiController::class, 'index'])->name('kepala-publikasi.index');
        Route::get('/kepala-publikasi/tahun/{id}', [KepalaDepartemenPublikasiController::class, 'tahun'])->name('kepala-publikasi.tahun');
        Route::get('/kepala-publikasi/generateexcel/{id}', [KepalaDepartemenPublikasiController::class, 'generateexcel'])->name('kepala-publikasi.generateexcel');
        Route::get('/kepala-publikasi/publikasi/{id}', [KepalaDepartemenPublikasiController::class, 'publikasi'])->name('kepala-publikasi.publikasi');

        // Data Pengabdian
        Route::get('/kepala-pengabdian', [KepalaDepartemenPengabdianController::class, 'index'])->name('kepala-pengabdian.index');
        Route::get('/kepala-pengabdian/tahun/{id}', [KepalaDepartemenPengabdianController::class, 'tahun'])->name('kepala-pengabdian.tahun');
        Route::get('/kepala-pengabdian/generateexcel/{id}', [KepalaDepartemenPengabdianController::class, 'generateexcel'])->name('kepala-pengabdian.generateexcel');
        Route::get('/kepala-pengabdian/pengabdian/{id}', [KepalaDepartemenPengabdianController::class, 'pengabdian'])->name('kepala-pengabdian.pengabdian');

        // Data Penelitian
        Route::get('/kepala-penelitian', [KepalaDepartemenPenelitianController::class, 'index'])->name('kepala-penelitian.index');
        Route::get('/kepala-penelitian/tahun/{id}', [KepalaDepartemenPenelitianController::class, 'tahun'])->name('kepala-penelitian.tahun');
        Route::get('/kepala-penelitian/generateexcel/{id}', [KepalaDepartemenPenelitianController::class, 'generateexcel'])->name('kepala-penelitian.generateexcel');
        Route::get('/kepala-penelitian/penelitian/{id}', [KepalaDepartemenPenelitianController::class, 'penelitian'])->name('kepala-penelitian.penelitian');

        // Seminar
        Route::get('/kepala-seminar', [KepalaDepartemenSeminarController::class, 'index'])->name('kepala-seminar.index');
        Route::get('/kepala-seminar/tahun/{id}', [KepalaDepartemenSeminarController::class, 'tahun'])->name('kepala-seminar.tahun');
        Route::get('/kepala-seminar/generateexcel/{id}', [KepalaDepartemenSeminarController::class, 'generateexcel'])->name('kepala-seminar.generateexcel');
        Route::get('/kepala-seminar/seminar/{id}', [KepalaDepartemenSeminarController::class, 'seminar'])->name('kepala-seminar.seminar');

        // Data Akademik
        Route::get('/kepala-akademik', [KepalaDepartemenAkademikController::class, 'index'])->name('kepala-akademik.index');
        Route::get('/kepala-akademik/tahun/{id}', [KepalaDepartemenAkademikController::class, 'tahun'])->name('kepala-akademik.tahun');
        Route::get('/kepala-akademik/akademik/{id}', [KepalaDepartemenAkademikController::class, 'akademik'])->name('kepala-akademik.akademik');

        // Rps
        Route::get('/kepala-rps', [KepalaDepartemenRpsController::class, 'index'])->name('kepala-rps.index');
        Route::get('/kepala-rps/tahun/{id}', [KepalaDepartemenRpsController::class, 'tahun'])->name('kepala-rps.tahun');
        Route::get('/kepala-rps/rps/{id}', [KepalaDepartemenRpsController::class, 'rps'])->name('kepala-rps.rps');

        // Bahan Ajar
        Route::get('/kepala-bahanajar', [KepalaDepartemenBahanAjarController::class, 'index'])->name('kepala-bahanajar.index');
        Route::get('/kepala-bahanajar/create/{id}', [KepalaDepartemenBahanAjarController::class, 'create'])->name('kepala-bahanajar.create');
        Route::get('/kepala-bahanajar/tahun/{id}', [KepalaDepartemenBahanAjarController::class, 'tahun'])->name('kepala-bahanajar.tahun');
        Route::get('/kepala-bahanajar/bahanajar/{id}', [KepalaDepartemenBahanAjarController::class, 'bahanajar'])->name('kepala-bahanajar.bahanajar');

        // Data Rapat
        Route::get('/kepala-rapat', [KepalaDepartemenRapatController::class, 'index'])->name('kepala-rapat.index');
        Route::get('/kepala-rapat/create', [KepalaDepartemenRapatController::class, 'create'])->name('kepala-rapat.create');
        Route::get('/kepala-rapat/edit/{id}', [KepalaDepartemenRapatController::class, 'edit'])->name('kepala-rapat.edit');
        Route::post('/kepala-rapat/store', [KepalaDepartemenRapatController::class, 'store'])->name('kepala-rapat.store');
        Route::post('/kepala-rapat/update/{id}', [KepalaDepartemenRapatController::class, 'update'])->name('kepala-rapat.update');
        Route::post('/kepala-rapat/destroy/{id}', [KepalaDepartemenRapatController::class, 'destroy'])->name('kepala-rapat.destroy');

        // Jadwal Pengajaran
        Route::get('/kepala-jadwalpengajaran', [KepalaDepartemenJadwalPengajaranController::class, 'index'])->name('kepala-jadwalpengajaran.index');
        Route::get('/kepala-jadwalpengajaran/create', [KepalaDepartemenJadwalPengajaranController::class, 'create'])->name('kepala-jadwalpengajaran.create');
        Route::get('/kepala-jadwalpengajaran/edit/{id}', [KepalaDepartemenJadwalPengajaranController::class, 'edit'])->name('kepala-jadwalpengajaran.edit');
        Route::post('/kepala-jadwalpengajaran/store', [KepalaDepartemenJadwalPengajaranController::class, 'store'])->name('kepala-jadwalpengajaran.store');
        Route::post('/kepala-jadwalpengajaran/update/{id}', [KepalaDepartemenJadwalPengajaranController::class, 'update'])->name('kepala-jadwalpengajaran.update');
        Route::post('/kepala-jadwalpengajaran/destroy/{id}', [KepalaDepartemenJadwalPengajaranController::class, 'destroy'])->name('kepala-jadwalpengajaran.destroy');
    });

    // Kaprodi
    Route::group(['middleware' => [CekLevel::class . ':4']], function () {

        // Studi Lanjut
        Route::get('/kaprodi-studilanjut', [KaprodiStudiLanjutController::class, 'index'])->name('kaprodi-studilanjut.index');
        Route::get('/kaprodi-studilanjut/tahun/{id}', [KaprodiStudiLanjutController::class, 'tahun'])->name('kaprodi-studilanjut.tahun');
        Route::get('/kaprodi-studilanjut/generateexcel/{id}', [KaprodiStudiLanjutController::class, 'generateexcel'])->name('kaprodi-studilanjut.generateexcel');
        Route::get('/kaprodi-studilanjut/studilanjut/{id}', [KaprodiStudiLanjutController::class, 'studilanjut'])->name('kaprodi-studilanjut.studilanjut');

        // Data Publikasi Ilmiah
        Route::get('/kaprodi-publikasi', [KaprodiPublikasiController::class, 'index'])->name('kaprodi-publikasi.index');
        Route::get('/kaprodi-publikasi/tahun/{id}', [KaprodiPublikasiController::class, 'tahun'])->name('kaprodi-publikasi.tahun');
        Route::get('/kaprodi-publikasi/generateexcel/{id}', [KaprodiPublikasiController::class, 'generateexcel'])->name('kaprodi-publikasi.generateexcel');
        Route::get('/kaprodi-publikasi/publikasi/{id}', [KaprodiPublikasiController::class, 'publikasi'])->name('kaprodi-publikasi.publikasi');

        // Data Pengabdian
        Route::get('/kaprodi-pengabdian', [KaprodiPengabdianController::class, 'index'])->name('kaprodi-pengabdian.index');
        Route::get('/kaprodi-pengabdian/tahun/{id}', [KaprodiPengabdianController::class, 'tahun'])->name('kaprodi-pengabdian.tahun');
        Route::get('/kaprodi-pengabdian/generateexcel/{id}', [KaprodiPengabdianController::class, 'generateexcel'])->name('kaprodi-pengabdian.generateexcel');
        Route::get('/kaprodi-pengabdian/penelitian/{id}', [KaprodiPengabdianController::class, 'pengabdian'])->name('kaprodi-pengabdian.pengabdian');

        // Data Penelitian
        Route::get('/kaprodi-penelitian', [KaprodiPenelitianController::class, 'index'])->name('kaprodi-penelitian.index');
        Route::get('/kaprodi-penelitian/tahun/{id}', [KaprodiPenelitianController::class, 'tahun'])->name('kaprodi-penelitian.tahun');
        Route::get('/kaprodi-penelitian/generateexcel/{id}', [KaprodiPenelitianController::class, 'generateexcel'])->name('kaprodi-penelitian.generateexcel');
        Route::get('/kaprodi-penelitian/penelitian/{id}', [KaprodiPenelitianController::class, 'penelitian'])->name('kaprodi-penelitian.penelitian');

        // Seminar
        Route::get('/kaprodi-seminar', [KaprodiSeminarController::class, 'index'])->name('kaprodi-seminar.index');
        Route::get('/kaprodi-seminar/tahun/{id}', [KaprodiSeminarController::class, 'tahun'])->name('kaprodi-seminar.tahun');
        Route::get('/kaprodi-seminar/generateexcel/{id}', [KaprodiSeminarController::class, 'generateexcel'])->name('kaprodi-seminar.generateexcel');
        Route::get('/kaprodi-seminar/seminar/{id}', [KaprodiSeminarController::class, 'seminar'])->name('kaprodi-seminar.seminar');
        Route::get('/kaprodi-seminar/create/{id}', [KaprodiSeminarController::class, 'create'])->name('kaprodi-seminar.create');
        Route::get('/kaprodi-seminar/edit/{id}', [KaprodiSeminarController::class, 'edit'])->name('kaprodi-seminar.edit');
        Route::post('/kaprodi-seminar/store', [KaprodiSeminarController::class, 'store'])->name('kaprodi-seminar.store');
        Route::post('/kaprodi-seminar/update/{id}', [KaprodiSeminarController::class, 'update'])->name('kaprodi-seminar.update');
        Route::post('/kaprodi-seminar/destroy/{id}', [KaprodiSeminarController::class, 'destroy'])->name('kaprodi-seminar.destroy');

        // Rps
        Route::get('/kaprodi-rps', [KaprodiRpsController::class, 'index'])->name('kaprodi-rps.index');
        Route::get('/kaprodi-rps/tahun/{id}', [KaprodiRpsController::class, 'tahun'])->name('kaprodi-rps.tahun');
        Route::get('/kaprodi-rps/rps/{id}', [KaprodiRpsController::class, 'rps'])->name('kaprodi-rps.rps');

        // Bahan Ajar
        Route::get('/kaprodi-bahanajar', [KaprodiBahanAjarController::class, 'index'])->name('kaprodi-bahanajar.index');
        Route::get('/kaprodi-bahanajar/tahun/{id}', [KaprodiBahanAjarController::class, 'tahun'])->name('kaprodi-bahanajar.tahun');
        Route::get('/kaprodi-bahanajar/bahanajar/{id}', [KaprodiBahanAjarController::class, 'bahanajar'])->name('kaprodi-bahanajar.bahanajar');

        // Jadwal Pengajaran
        Route::get('/kaprodi-jadwalpengajaran', [KaprodiJadwalPengajaranController::class, 'index'])->name('kaprodi-jadwalpengajaran.index');

        // Data Rapat
        Route::get('/kaprodi-rapat', [KaprodiRapatController::class, 'index'])->name('kaprodi-rapat.index');
        Route::get('/kaprodi-rapat/create', [KaprodiRapatController::class, 'create'])->name('kaprodi-rapat.create');
        Route::get('/kaprodi-rapat/edit/{id}', [KaprodiRapatController::class, 'edit'])->name('kaprodi-rapat.edit');
        Route::post('/kaprodi-rapat/store', [KaprodiRapatController::class, 'store'])->name('kaprodi-rapat.store');
        Route::post('/kaprodi-rapat/update/{id}', [KaprodiRapatController::class, 'update'])->name('kaprodi-rapat.update');
        Route::post('/kaprodi-rapat/destroy/{id}', [KaprodiRapatController::class, 'destroy'])->name('kaprodi-rapat.destroy');

        // Data Akademik
        Route::get('/kaprodi-akademik', [KaprodiAkademikController::class, 'index'])->name('kaprodi-akademik.index');
        Route::get('/kaprodi-akademik/tahun/{id}', [KaprodiAkademikController::class, 'tahun'])->name('kaprodi-akademik.tahun');
        Route::get('/kaprodi-akademik/create/{id}', [KaprodiAkademikController::class, 'create'])->name('kaprodi-akademik.create');
        Route::get('/kaprodi-akademik/akademik/{id}', [KaprodiAkademikController::class, 'akademik'])->name('kaprodi-akademik.akademik');
        Route::get('/kaprodi-akademik/edit/{id}', [KaprodiAkademikController::class, 'edit'])->name('kaprodi-akademik.edit');
        Route::post('/kaprodi-akademik/store', [KaprodiAkademikController::class, 'store'])->name('kaprodi-akademik.store');
        Route::post('/kaprodi-akademik/update/{id}', [KaprodiAkademikController::class, 'update'])->name('kaprodi-akademik.update');
        Route::post('/kaprodi-akademik/destroy/{id}', [KaprodiAkademikController::class, 'destroy'])->name('kaprodi-akademik.destroy');
    });

    // Dosen
    Route::group(['middleware' => [CekLevel::class . ':5']], function () {

        // Data Studi Lanjut
        Route::get('/dosen-studilanjut', [DosenStudiLanjutController::class, 'index'])->name('dosen-studilanjut.index');
        Route::get('/dosen-studilanjut/create', [DosenStudiLanjutController::class, 'create'])->name('dosen-studilanjut.create');
        Route::get('/dosen-studilanjut/edit/{id}', [DosenStudiLanjutController::class, 'edit'])->name('dosen-studilanjut.edit');
        Route::post('/dosen-studilanjut/store', [DosenStudiLanjutController::class, 'store'])->name('dosen-studilanjut.store');
        Route::post('/dosen-studilanjut/update/{id}', [DosenStudiLanjutController::class, 'update'])->name('dosen-studilanjut.update');
        Route::post('/dosen-studilanjut/destroy/{id}', [DosenStudiLanjutController::class, 'destroy'])->name('dosen-studilanjut.destroy');
        Route::get('/dosen-studilanjut/tahun/{prodiId}', [DosenStudiLanjutController::class, 'getTahun']);

        // Data Publikasi
        Route::get('/dosen-publikasi', [DosenPublikasiController::class, 'index'])->name('dosen-publikasi.index');
        Route::get('/dosen-publikasi/create', [DosenPublikasiController::class, 'create'])->name('dosen-publikasi.create');
        Route::get('/dosen-publikasi/edit/{id}', [DosenPublikasiController::class, 'edit'])->name('dosen-publikasi.edit');
        Route::post('/dosen-publikasi/store', [DosenPublikasiController::class, 'store'])->name('dosen-publikasi.store');
        Route::post('/dosen-publikasi/update/{id}', [DosenPublikasiController::class, 'update'])->name('dosen-publikasi.update');
        Route::post('/dosen-publikasi/destroy/{id}', [DosenPublikasiController::class, 'destroy'])->name('dosen-publikasi.destroy');
        Route::get('/dosen-publikasi/tahun/{prodiId}', [DosenPublikasiController::class, 'getTahun']);

        // Data Pengabdian
        Route::get('/dosen-pengabdian', [DosenPengabdianController::class, 'index'])->name('dosen-pengabdian.index');
        Route::get('/dosen-pengabdian/create', [DosenPengabdianController::class, 'create'])->name('dosen-pengabdian.create');
        Route::get('/dosen-pengabdian/edit/{id}', [DosenPengabdianController::class, 'edit'])->name('dosen-pengabdian.edit');
        Route::post('/dosen-pengabdian/store', [DosenPengabdianController::class, 'store'])->name('dosen-pengabdian.store');
        Route::post('/dosen-pengabdian/update/{id}', [DosenPengabdianController::class, 'update'])->name('dosen-pengabdian.update');
        Route::post('/dosen-pengabdian/destroy/{id}', [DosenPengabdianController::class, 'destroy'])->name('dosen-pengabdian.destroy');
        Route::get('/dosen-pengabdian/tahun/{prodiId}', [DosenPengabdianController::class, 'getTahun']);

        // Data Penelitian
        Route::get('/dosen-penelitian', [DosenPenelitianController::class, 'index'])->name('dosen-penelitian.index');
        Route::get('/dosen-penelitian/create', [DosenPenelitianController::class, 'create'])->name('dosen-penelitian.create');
        Route::get('/dosen-penelitian/edit/{id}', [DosenPenelitianController::class, 'edit'])->name('dosen-penelitian.edit');
        Route::post('/dosen-penelitian/store', [DosenPenelitianController::class, 'store'])->name('dosen-penelitian.store');
        Route::post('/dosen-penelitian/update/{id}', [DosenPenelitianController::class, 'update'])->name('dosen-penelitian.update');
        Route::post('/dosen-penelitian/destroy/{id}', [DosenPenelitianController::class, 'destroy'])->name('dosen-penelitian.destroy');
        Route::get('/dosen-penelitian/tahun/{prodiId}', [DosenPenelitianController::class, 'getTahun']);

        // Seminar
        Route::get('/dosen-seminar', [DosenSeminarController::class, 'index'])->name('dosen-seminar.index');
        Route::get('/dosen-seminar/tahun/{id}', [DosenSeminarController::class, 'tahun'])->name('dosen-seminar.tahun');
        Route::get('/dosen-seminar/generateexcel/{id}', [DosenSeminarController::class, 'generateexcel'])->name('dosen-seminar.generateexcel');
        Route::get('/dosen-seminar/seminar/{id}', [DosenSeminarController::class, 'seminar'])->name('dosen-seminar.seminar');

        // Data Akademik
        Route::get('/dosen-akademik', [DosenAkademikController::class, 'index'])->name('dosen-akademik.index');
        Route::get('/dosen-akademik/tahun/{id}', [DosenAkademikController::class, 'tahun'])->name('dosen-akademik.tahun');
        Route::get('/dosen-akademik/create/{id}', [DosenAkademikController::class, 'create'])->name('dosen-akademik.create');
        Route::get('/dosen-akademik/akademik/{id}', [DosenAkademikController::class, 'akademik'])->name('dosen-akademik.akademik');

        // Data Rapat
        Route::get('/dosen-rapat', [DosenRapatController::class, 'index'])->name('dosen-rapat.index');

        // Rps
        Route::get('/dosen-rps', [DosenRpsController::class, 'index'])->name('dosen-rps.index');
        Route::get('/dosen-rps/create', [DosenRpsController::class, 'create'])->name('dosen-rps.create');
        Route::get('/dosen-rps/tahun/{id}', [DosenRpsController::class, 'tahun'])->name('dosen-rps.tahun');
        Route::get('/dosen-rps/rps/{id}', [DosenRpsController::class, 'rps'])->name('dosen-rps.rps');
        Route::get('/dosen-rps/edit/{id}', [DosenRpsController::class, 'edit'])->name('dosen-rps.edit');
        Route::post('/dosen-rps/store', [DosenRpsController::class, 'store'])->name('dosen-rps.store');
        Route::post('/dosen-rps/update/{id}', [DosenRpsController::class, 'update'])->name('dosen-rps.update');
        Route::post('/dosen-rps/destroy/{id}', [DosenRpsController::class, 'destroy'])->name('dosen-rps.destroy');
        // Bahan Ajar
        Route::get('/dosen-bahanajar', [DosenBahanAjarController::class, 'index'])->name('dosen-bahanajar.index');
        Route::get('/dosen-bahanajar/create', [DosenBahanAjarController::class, 'create'])->name('dosen-bahanajar.create');
        Route::get('/dosen-bahanajar/tahun/{id}', [DosenBahanAjarController::class, 'tahun'])->name('dosen-bahanajar.tahun');
        Route::get('/dosen-bahanajar/bahanajar/{id}', [DosenBahanAjarController::class, 'bahanajar'])->name('dosen-bahanajar.bahanajar');
        Route::get('/dosen-bahanajar/edit/{id}', [DosenBahanAjarController::class, 'edit'])->name('dosen-bahanajar.edit');
        Route::post('/dosen-bahanajar/store', [DosenBahanAjarController::class, 'store'])->name('dosen-bahanajar.store');
        Route::post('/dosen-bahanajar/update/{id}', [DosenBahanAjarController::class, 'update'])->name('dosen-bahanajar.update');
        Route::post('/dosen-bahanajar/destroy/{id}', [DosenBahanAjarController::class, 'destroy'])->name('dosen-bahanajar.destroy');

        // Jadwal Pengajaran
        Route::get('/dosen-jadwalpengajaran', [DosenJadwalPengajaranController::class, 'index'])->name('dosen-jadwalpengajaran.index');
    });

    // Mahasiswa
    Route::group(['middleware' => [CekLevel::class . ':6']], function () {

        // Data Studi Lanjut
        Route::get('/mahasiswa-studilanjut', [MahasiswaStudiLanjutController::class, 'index'])->name('mahasiswa-studilanjut.index');
        Route::get('/mahasiswa-studilanjut/create', [MahasiswaStudiLanjutController::class, 'create'])->name('mahasiswa-studilanjut.create');
        Route::get('/mahasiswa-studilanjut/edit/{id}', [MahasiswaStudiLanjutController::class, 'edit'])->name('mahasiswa-studilanjut.edit');
        Route::post('/mahasiswa-studilanjut/store', [MahasiswaStudiLanjutController::class, 'store'])->name('mahasiswa-studilanjut.store');
        Route::post('/mahasiswa-studilanjut/update/{id}', [MahasiswaStudiLanjutController::class, 'update'])->name('mahasiswa-studilanjut.update');
        Route::post('/mahasiswa-studilanjut/destroy/{id}', [MahasiswaStudiLanjutController::class, 'destroy'])->name('mahasiswa-studilanjut.destroy');
        Route::get('/mahasiswa-studilanjut/tahun/{prodiId}', [MahasiswaStudiLanjutController::class, 'getTahun']);

        // Data Publikasi
        Route::get('/mahasiswa-publikasi', [MahasiswaPublikasiController::class, 'index'])->name('mahasiswa-publikasi.index');
        Route::get('/mahasiswa-publikasi/create', [MahasiswaPublikasiController::class, 'create'])->name('mahasiswa-publikasi.create');
        Route::get('/mahasiswa-publikasi/edit/{id}', [MahasiswaPublikasiController::class, 'edit'])->name('mahasiswa-publikasi.edit');
        Route::post('/mahasiswa-publikasi/store', [MahasiswaPublikasiController::class, 'store'])->name('mahasiswa-publikasi.store');
        Route::post('/mahasiswa-publikasi/update/{id}', [MahasiswaPublikasiController::class, 'update'])->name('mahasiswa-publikasi.update');
        Route::post('/mahasiswa-publikasi/destroy/{id}', [MahasiswaPublikasiController::class, 'destroy'])->name('mahasiswa-publikasi.destroy');
        Route::get('/mahasiswa-publikasi/tahun/{prodiId}', [MahasiswaPublikasiController::class, 'getTahun']);

        // Data Pengabdian
        Route::get('/mahasiswa-pengabdian', [MahasiswaPengabdianController::class, 'index'])->name('mahasiswa-pengabdian.index');
        Route::get('/mahasiswa-pengabdian/create', [MahasiswaPengabdianController::class, 'create'])->name('mahasiswa-pengabdian.create');
        Route::get('/mahasiswa-pengabdian/edit/{id}', [MahasiswaPengabdianController::class, 'edit'])->name('mahasiswa-pengabdian.edit');
        Route::post('/mahasiswa-pengabdian/store', [MahasiswaPengabdianController::class, 'store'])->name('mahasiswa-pengabdian.store');
        Route::post('/mahasiswa-pengabdian/update/{id}', [MahasiswaPengabdianController::class, 'update'])->name('mahasiswa-pengabdian.update');
        Route::post('/mahasiswa-pengabdian/destroy/{id}', [MahasiswaPengabdianController::class, 'destroy'])->name('mahasiswa-pengabdian.destroy');
        Route::get('/mahasiswa-pengabdian/tahun/{prodiId}', [MahasiswaPengabdianController::class, 'getTahun']);

        // Data Penelitian
        Route::get('/mahasiswa-penelitian', [MahasiswaPenelitianController::class, 'index'])->name('mahasiswa-penelitian.index');
        Route::get('/mahasiswa-penelitian/create', [MahasiswaPenelitianController::class, 'create'])->name('mahasiswa-penelitian.create');
        Route::get('/mahasiswa-penelitian/edit/{id}', [MahasiswaPenelitianController::class, 'edit'])->name('mahasiswa-penelitian.edit');
        Route::post('/mahasiswa-penelitian/store', [MahasiswaPenelitianController::class, 'store'])->name('mahasiswa-penelitian.store');
        Route::post('/mahasiswa-penelitian/update/{id}', [MahasiswaPenelitianController::class, 'update'])->name('mahasiswa-penelitian.update');
        Route::post('/mahasiswa-penelitian/destroy/{id}', [MahasiswaPenelitianController::class, 'destroy'])->name('mahasiswa-penelitian.destroy');
        Route::get('/mahasiswa-penelitian/tahun/{prodiId}', [MahasiswaPenelitianController::class, 'getTahun']);

        // Seminar
        Route::get('/mahasiswa-seminar', [MahasiswaSeminarController::class, 'index'])->name('mahasiswa-seminar.index');
        Route::get('/mahasiswa-seminar/generateexcel', [MahasiswaSeminarController::class, 'generateexcel'])->name('mahasiswa-seminar.generateexcel');
        Route::get('/mahasiswa-seminar/create', [MahasiswaSeminarController::class, 'create'])->name('mahasiswa-seminar.create');
        Route::get('/mahasiswa-seminar/edit/{id}', [MahasiswaSeminarController::class, 'edit'])->name('mahasiswa-seminar.edit');
        Route::post('/mahasiswa-seminar/store', [MahasiswaSeminarController::class, 'store'])->name('mahasiswa-seminar.store');
        Route::post('/mahasiswa-seminar/update/{id}', [MahasiswaSeminarController::class, 'update'])->name('mahasiswa-seminar.update');
        Route::post('/mahasiswa-seminar/destroy/{id}', [MahasiswaSeminarController::class, 'destroy'])->name('mahasiswa-seminar.destroy');

        // Akademik
        Route::get('/mahasiswa-akademik', [MahasiswaAkademikController::class, 'index'])->name('mahasiswa-akademik.index');
        Route::get('/mahasiswa-akademik/tahun/{id}', [MahasiswaAkademikController::class, 'tahun'])->name('mahasiswa-akademik.tahun');
        Route::get('/mahasiswa-akademik/akademik/{id}', [MahasiswaAkademikController::class, 'akademik'])->name('mahasiswa-akademik.akademik');

        // Seminar
        Route::get('mahasiswa-seminar', [MahasiswaSeminarController::class, 'index'])->name('mahasiswa-seminar.index');
        Route::get('mahasiswa-seminar/balas/{id}', [MahasiswaSeminarController::class, 'balas'])->name('mahasiswa-seminar.balas');
        Route::post('mahasiswa-seminar/update/{id}', [MahasiswaSeminarController::class, 'update'])->name('mahasiswa-seminar.update');

        // Mahasiswa
        Route::get('/mahasiswa-rps', [MahasiswaRpsController::class, 'index'])->name('mahasiswa-rps.index');
        Route::get('/mahasiswa-rps/tahun/{id}', [MahasiswaRpsController::class, 'tahun'])->name('mahasiswa-rps.tahun');
        Route::get('/mahasiswa-rps/rps/{id}', [MahasiswaRpsController::class, 'rps'])->name('mahasiswa-rps.rps');

        // Bahan Ajar
        Route::get('/mahasiswa-bahanajar', [MahasiswaBahanAjarController::class, 'index'])->name('mahasiswa-bahanajar.index');
        Route::get('/mahasiswa-bahanajar/tahun/{id}', [MahasiswaBahanAjarController::class, 'tahun'])->name('mahasiswa-bahanajar.tahun');
        Route::get('/mahasiswa-bahanajar/bahanajar/{id}', [MahasiswaBahanAjarController::class, 'bahanajar'])->name('mahasiswa-bahanajar.bahanajar');
        // Jadwal Pengajaran
        Route::get('/mahasiswa-jadwalpengajaran', [MahasiswaJadwalPengajaranController::class, 'index'])->name('mahasiswa-jadwalpengajaran.index');
    });
});
