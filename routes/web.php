<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndustriController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\JurnalAdminController;
use App\Http\Controllers\JurnalIndustriController;
use App\Http\Controllers\JurnalSiswaController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PklController;
use App\Http\Controllers\SekolahController;

Route::get('/', function () {
    return view('welcome');
});

// Route login
Route::get('/login', [LoginController::class, 'showLoginForm']) ->name('viewlogin');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logoutsekolah', [LoginController::class, 'logoutsekolah'])->name('logout-sekolah');
Route::post('/logoutindustri', [LoginController::class, 'logoutindustri'])->name('logout-industri');

Route::get('register', function () {
    return view('auth.register');  // Menampilkan halaman registrasi
})->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');

/* -------------------------------------------------------------------------- */
/*                                  INDUSTRI                                  */
/* -------------------------------------------------------------------------- */
Route::middleware(['auth:industri'])->group(function () {

Route::get('/dashboard-industri', [IndustriController::class, 'dashboard'])->name('industri.dashboard');

Route::get('/kelola-kehadiran', [IndustriController::class, 'kehadiran'])->name('kelola-kehadiran');
Route::get('/kehadiran/{userId}/detail', [IndustriController::class, 'detail'])->name('kehadiran.detail');
Route::post('/kehadiran/update/{userId}', [IndustriController::class, 'update'])->name('kehadiran.update');
Route::get('/kehadiran/edit/{id}', [IndustriController::class, 'edit'])->name('kehadiran.edit');
Route::get('/kehadiran/{userId}', [IndustriController::class, 'cetakkehadiranuser'])->name('kehadiran.pdf');

Route::get('/update-industri', [IndustriController::class, 'updateIndustri'])->name('update-industri');


Route::get('/profile-industri', [IndustriController::class, 'showProfile'])->name('profile-industri');
Route::get('/update-industri', [IndustriController::class, 'editProfile'])->name('update-industri');
Route::post('/update-industri', [IndustriController::class, 'updateProfile'])->name('update-industri.save');

Route::get('lihat-detail', [IndustriController::class, 'lihatdetail'])->name('lihat-detail');


Route::prefix('sekolah')->name('sekolah.')->group(function () {
    Route::get('', [SekolahController::class, 'index'])->name('index');
    Route::post('/{id}/update-status', [SekolahController::class, 'updateStatusSekolah'])->name('updateStatus');
    Route::get('/show/{id}', [IndustriController::class, 'showpkl'])->name('show');
    Route::get('/detail-siswa/{id}', [SekolahController::class, 'detailSiswa'])->name('detail-siswa');
    Route::post('/update-status-siswa', [IndustriController::class, 'updateStatusSiswa'])->name('update-status-siswa');
    Route::delete('/delete/{id}', [SekolahController::class, 'destroy'])->name('delete');
});

Route::prefix('penilaian')->name('penilaian.')->group(function () {
    Route::get('/', [IndustriController::class, 'indexpenilaian'])->name('index'); // Menampilkan daftar penilaian
    Route::get('/create', [IndustriController::class, 'create'])->name('create'); // Form tambah penilaian
    Route::post('/', [IndustriController::class, 'store'])->name('store'); // Menyimpan penilaian baru
    Route::get('/{id}', [IndustriController::class, 'show'])->name('show'); // Menampilkan detail penilaian
    Route::delete('/{id}', [IndustriController::class, 'destroy'])->name('destroy'); // Menghapus penilaian
    Route::get('/{id}/cetak', [IndustriController::class, 'cetakPdf'])->name('cetak.pdf'); // Cetak penilaian ke PDF
});
// Route::prefix('penilaian')->name('penilaian.')->group(function () {
//     Route::get('/', [IndustriController::class, 'indexpenilaian'])->name('index');
//     Route::get('/create', [IndustriController::class, 'create'])->name('create');
//     Route::post('/', [IndustriController::class, 'store'])->name('store');
//     Route::delete('/{id}', [IndustriController::class, 'destroy'])->name('destroy');
//     Route::get('/{id}', [IndustriController::class, 'show'])->name('show');
//     Route::get('/penilaian/{id}/cetak-pdf', [IndustriController::class, 'cetakPdf'])->name('cetak.pdf');
// });

Route::prefix('jurnal-industri')->name('jurnal-industri.')->group(function () {
    Route::get('', [JurnalIndustriController::class, 'index'])->name('index');
    Route::get('/detail/{id}', [JurnalIndustriController::class, 'show'])->name('detail');
});

});

/* -------------------------------------------------------------------------- */
/*                                  END INDUSTRI                              */
/* -------------------------------------------------------------------------- */


/* -------------------------------------------------------------------------- */
/*                                  SEKOLAH                                   */
/* -------------------------------------------------------------------------- */
Route::middleware(['auth:sekolah'])->group(function () {
Route::get('/dashboard-admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('kehadiran-siswapkl', [AdminController::class, 'index'])->name('kehadiran-siswapkl');

Route::get('pengajuan-siswa', [SiswaController::class, 'index'])->name('pengajuan-siswa');
Route::get('tambah-siswa', [SiswaController::class, 'create'])->name('tambah-siswa');
Route::get('tambah-data', [SiswaController::class, 'tambah'])->name('pengajuan.tambah');
Route::get('pengajuan-lihat', [SiswaController::class, 'lihat'])->name('pengajuan.lihat');

Route::post('pengajuan-siswa', [SiswaController::class, 'store'])->name('pengajuan-siswa.store');
Route::delete('hapus-siswa/{id}', [SiswaController::class, 'destroy'])->name('hapus-siswa');

Route::prefix('pkl')->name('pkl.')->group(function () {
    Route::get('', [PklController::class, 'index'])->name('index');
    Route::get('/create', [PklController::class, 'create'])->name('create');
    Route::post('/store', [PklController::class, 'store'])->name('store');
    Route::get('/detail/{id}', [PklController::class, 'detail'])->name('detail');
});

Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
    Route::get('list-siswa/{id_pkl}', [PengajuanController::class, 'index'])->name('index');
    Route::get('/create/{id_pkl}', [PengajuanController::class, 'create'])->name('create');
    Route::post('/store/{id_pkl}', [PengajuanController::class, 'store'])->name('store');
    Route::delete('/delete/{id}', [PengajuanController::class, 'destroy'])->name('delete');
});
Route::get('pengajuan-index', [AdminController::class, 'pengajuanindex'])->name('pengajuan-index');
Route::get('lihat-siswa', [AdminController::class, 'lihatsiswa'])->name('lihat-siswa');


Route::prefix('jurnal-admin')->name('jurnal-admin.')->group(function () {
    Route::get('', [JurnalAdminController::class, 'index'])->name('index');
    Route::get('/detail/{id}', [JurnalAdminController::class, 'show'])->name('detail');
});

Route::get('/unduh-penilaian/{id}', [AdminController::class, 'downloadpenilaian'])->name('penilaiansiswa.unduh');
Route::get('/unduh-kehadiran/{userId}', [AdminController::class, 'kehadiransekolah'])->name('kehadiransiswa.unduh');

Route::get('/data-siswa', [AdminController::class, 'dataSiswa'])->name('data-siswa');
Route::get('/cetak-sertifikat-siswa/{id}', [AdminController::class, 'cetakSertifikatSiswa'])->name('cetak-sertifikat-siswa');
Route::get('/laporan', [AdminController::class, 'indexlaporan'])->name('pages-admin.data-siswa');
Route::get('/laporan/download/{id}', [AdminController::class, 'downloadLaporan'])->name('download-laporan');


Route::get('/profile-admin', [AdminController::class, 'showProfileSekolah'])->name('profile-admin');
Route::get('/profile/edit', [AdminController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [AdminController::class, 'update'])->name('profile.update');

});

/* -------------------------------------------------------------------------- */
/*                                    END SEKOLAH                             */
/* -------------------------------------------------------------------------- */


/* -------------------------------------------------------------------------- */
/*                                    SISWA/USER                              */
/* -------------------------------------------------------------------------- */
Route::middleware(['auth:web'])->group(function () {

Route::get('/dashboard-user', [UserController::class, 'dashboard'])->name('user.dashboard');

Route::prefix('jurnal-siswa')->name('jurnal-siswa.')->group(function () {
    Route::get('', [JurnalSiswaController::class, 'index'])->name('index');
    Route::get('/create', [JurnalSiswaController::class, 'create'])->name('create');
    Route::post('/store', [JurnalSiswaController::class, 'store'])->name('store');
    Route::get('/{id}', [JurnalSiswaController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [JurnalSiswaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [JurnalSiswaController::class, 'update'])->name('update');
    Route::delete('/{id}', [JurnalSiswaController::class, 'destroy'])->name('destroy');
    Route::post('/upload/{id}', [JurnalSiswaController::class, 'uploadLaporan'])->name('upload');
    Route::get('/api/jumlah-laporan', [JurnalSiswaController::class, 'getJumlahLaporan']);
});

Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran');
Route::get('edit/{id}', [KehadiranController::class, 'edit'])->name('edit'); // Halaman edit kehadiran
Route::post('update/{id}', [KehadiranController::class, 'update'])->name('updatekehadiran'); // Update data kehadiran
Route::get('/rekap-kehadiran', [KehadiranController::class, 'rekapkehadiran'])->name('rekap.kehadiran');

Route::post('/laporan-pkl', [LaporanController::class, 'store'])->name('laporan.store');

Route::get('/riwayat-absensi', [KehadiranController::class, 'index'])->name('riwayat-absensi');
Route::post('/kehadiran', [KehadiranController::class, 'store'])->name('kehadiran.store');
Route::post('/absen-masuk', [KehadiranController::class, 'absenMasuk'])->name('kehadiran.absen-masuk');
Route::post('/absen-keluar', [KehadiranController::class, 'absenKeluar'])->name('kehadiran.absen-keluar');

Route::get('/penilaian-user', [PenilaianController::class, 'showuser'])->name('penilaian.show.user');

Route::get('/profile', [UserController::class, 'showprofilsiswa'])->name('profilesiswa');

Route::post('/upload-foto-izin', [KehadiranController::class, 'uploadFotoIzin'])->name('uploadFotoIzin');
Route::get('/unduh-rekap', [KehadiranController::class, 'downloadRekap'])->name('downloadRekap');

Route::get('/laporan-pkl', [UserController::class, 'laporanpkl'])->name('laporan-pkl');

Route::get('/cetak-sertifikat/{id}', [UserController::class, 'cetakSertifikat'])->name('cetak-sertifikat');
});
/* -------------------------------------------------------------------------- */
/*                                   END SISWA/USER                           */
/* -------------------------------------------------------------------------- */


// Route::get('/riwayat-absensi', [KehadiranController::class, 'index'])->name('riwayat-absensi');

// Route untuk mengganti kata sandi
// Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
