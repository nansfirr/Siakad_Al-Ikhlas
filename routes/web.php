<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboard,
    KelasController,
    SiswaController,
    PenggunaController,
    AspekPerkembanganController,
    IndikatorPenilaianController,
    KatagoriKegiatanController,
    ItemKegiatanController,
    PengaturanSekolahController
};
use App\Http\Controllers\Guru\{
    DashboardController as GuruDashboard,
    PresensiController,
    PenilaianController,
    KegiatanController,
    AntropometriController,
    RefleksiController,
    RaportController,
    LaporanController as GuruLaporan
};
use App\Http\Controllers\Kepsek\{
    DashboardController as KepsekDashboard,
    LaporanController as KepsekLaporan
};

// ==========================
// ROOT
// ==========================
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/' . auth()->user()->role . '/dashboard');
    }
    return redirect()->route('login');
});

// ==========================
// AUTH
// ==========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================
// ADMIN
// ==========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::resource('kelas', KelasController::class);
        Route::resource('siswa', SiswaController::class);
        Route::resource('pengguna', PenggunaController::class);

        // Master Data
        Route::resource('aspek', AspekPerkembanganController::class);
        Route::resource('indikator', IndikatorPenilaianController::class);
        Route::resource('katagori', KatagoriKegiatanController::class);
        Route::resource('item', ItemKegiatanController::class);

        Route::get('/pengaturan', [PengaturanSekolahController::class, 'index'])
    ->name('pengaturan.index');
    
        Route::post('/pengaturan', [PengaturanSekolahController::class, 'update'])
    ->name('pengaturan.update');
    });

// ==========================
// GURU
// ==========================
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

        Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');

        // Presensi
        Route::controller(PresensiController::class)->group(function () {
            Route::get('/presensi', 'index')->name('presensi.index');
            Route::post('/presensi', 'store')->name('presensi.store');
        });

        // Penilaian
        Route::controller(PenilaianController::class)->group(function () {
            Route::get('/penilaian', 'index')->name('penilaian.index');
            Route::get('/penilaian/{siswa}', 'show')->name('penilaian.show');
            Route::post('/penilaian/{siswa}', 'store')->name('penilaian.store');
        });

        // Kegiatan
        Route::controller(KegiatanController::class)->group(function () {
            Route::get('/kegiatan', 'index')->name('kegiatan.index');
            Route::get('/kegiatan/{siswa}', 'show')->name('kegiatan.show');
            Route::post('/kegiatan/{siswa}', 'store')->name('kegiatan.store');
        });

        // Antropometri
        Route::controller(AntropometriController::class)->group(function () {
            Route::get('/antropometri', 'index')->name('antropometri.index');
            Route::post('/antropometri', 'store')->name('antropometri.store');
        });

        // Refleksi
        Route::controller(RefleksiController::class)->group(function () {
            Route::get('/refleksi', 'index')->name('refleksi.index');
            Route::post('/refleksi', 'store')->name('refleksi.store');
        });

        // ==========================
// RAPORT
// ==========================

Route::controller(RaportController::class)->group(function () {

    // daftar siswa
    Route::get('/raport', 'index')
        ->name('raport.index');

    // preview html
    Route::get('/raport/{siswa}', 'show')
        ->name('raport.show');

    // pdf
    Route::get('/raport/{siswa}/pdf', 'pdf')
        ->name('raport.pdf');

    // cetak semua
    Route::get('/raport/cetak-semua', 'cetakSemua')
        ->name('raport.cetakSemua');

});

        // Laporan
        Route::controller(GuruLaporan::class)->group(function () {
            Route::get('/laporan', 'index')->name('laporan.index');
            Route::get('/laporan/export-pdf', 'exportPdf')->name('laporan.exportPdf');
        });
    });

// ==========================
// KEPALA SEKOLAH
// ==========================
Route::middleware(['auth', 'role:kepsek'])
    ->prefix('kepsek')
    ->name('kepsek.')
    ->group(function () {

        Route::get('/dashboard', [KepsekDashboard::class, 'index'])->name('dashboard');

        Route::controller(KepsekLaporan::class)->group(function () {
            Route::get('/laporan-perkembangan', 'perkembangan')->name('laporan.perkembangan');
            Route::get('/laporan-presensi', 'presensi')->name('laporan.presensi');
        });
    });