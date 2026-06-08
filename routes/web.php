<?php

use App\Http\Controllers\LowonganController;
use App\Http\Controllers\MhsController;
use App\Http\Controllers\DepartController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\DospemController;
use App\Http\Controllers\SpvController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplyController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// =====================================================================
// PUBLIC
// =====================================================================
Route::get('/', [LowonganController::class, 'AllLowongan']);
Route::get('/permit', fn() => view('v_redirect'))->name('permit');

// =====================================================================
// AUTH — semua user login
// =====================================================================
Route::group(['middleware' => 'auth'], function () {
    Route::resource('profile', ProfileController::class);
    Route::get('detail/{id}', [ApplyController::class, 'detail'])->name('detail.show');

    // API Wilayah (dropdown cascading profil mitra)
    Route::get('api/wilayah/provinsi',  [WilayahController::class, 'provinsi'])->name('api.wilayah.provinsi');
    Route::get('api/wilayah/kabupaten', [WilayahController::class, 'kabupaten'])->name('api.wilayah.kabupaten');
    Route::get('api/wilayah/kecamatan', [WilayahController::class, 'kecamatan'])->name('api.wilayah.kecamatan');

    // ===================================================================
    // PROJECT — satu route set untuk SPV, Dosen, dan Mahasiswa
    // Otorisasi dilakukan di dalam ProjectController
    // ===================================================================
    Route::group(['middleware' => 'profile_complete'], function () {
        // CRUD Project (SPV only untuk create/edit/delete)
        Route::get('project',              [ProjectController::class, 'index'])->name('project.index');
        Route::get('project/create',       [ProjectController::class, 'create'])->name('project.create');
        Route::post('project',             [ProjectController::class, 'store'])->name('project.store');
        Route::get('project/{id}',         [ProjectController::class, 'show'])->name('project.show');
        Route::get('project/{id}/edit',    [ProjectController::class, 'edit'])->name('project.edit');
        Route::put('project/{id}',         [ProjectController::class, 'update'])->name('project.update');
        Route::delete('project/{id}',      [ProjectController::class, 'destroy'])->name('project.destroy');

        // Logbook dalam project (Mahasiswa CRUD, SPV beri catatan)
        Route::get('project/{pid}/logbook/create',           [ProjectController::class, 'logbookCreate'])->name('project.logbook.create');
        Route::post('project/{pid}/logbook',                 [ProjectController::class, 'logbookStore'])->name('project.logbook.store');
        Route::get('project/{pid}/logbook/{lid}/edit',       [ProjectController::class, 'logbookEdit'])->name('project.logbook.edit');
        Route::put('project/{pid}/logbook/{lid}',            [ProjectController::class, 'logbookUpdate'])->name('project.logbook.update');
        Route::delete('project/{pid}/logbook/{lid}',         [ProjectController::class, 'logbookDestroy'])->name('project.logbook.destroy');
        Route::post('project/{pid}/logbook/{lid}/catatan',   [ProjectController::class, 'logbookCatatan'])->name('project.logbook.catatan');
        Route::get('project/{pid}/logbook/cetak',            [ProjectController::class, 'printLogbook'])->name('project.logbook.print');

        // Bimbingan dalam project (Mahasiswa submit, Dosen beri feedback)
        Route::get('project/{pid}/bimbingan/create',         [ProjectController::class, 'bimbinganCreate'])->name('project.bimbingan.create');
        Route::post('project/{pid}/bimbingan',               [ProjectController::class, 'bimbinganStore'])->name('project.bimbingan.store');
        Route::get('project/{pid}/bimbingan/{bid}/edit',     [ProjectController::class, 'bimbinganEdit'])->name('project.bimbingan.edit');
        Route::put('project/{pid}/bimbingan/{bid}',          [ProjectController::class, 'bimbinganUpdate'])->name('project.bimbingan.update');
        Route::delete('project/{pid}/bimbingan/{bid}',       [ProjectController::class, 'bimbinganDestroy'])->name('project.bimbingan.destroy');
        Route::post('project/{pid}/bimbingan/{bid}/feedback',[ProjectController::class, 'bimbinganFeedback'])->name('project.bimbingan.feedback');
    });
});

// =====================================================================
// DEPARTEMEN
// =====================================================================
Route::group(['middleware' => ['is_depart', 'profile_complete']], function () {
    Route::get('depart/home', [DepartController::class, 'departHome'])->name('depart.home');
    Route::resource('users', UserController::class);
    Route::get('depart/mahasiswa', [DepartController::class, 'listMhs'])->name('depart.mhs');
    Route::get('depart/mahasiswa/{id}', [DepartController::class, 'detailMhs'])->name('depart.detailMhs');
    Route::get('depart/lowongan', [LowonganController::class, 'index'])->name('depart.lowongan');
    Route::get('depart/pengajuan', [ApplyController::class, 'listPengajuan'])->name('pengajuan.index');
    Route::get('depart/pengajuan/{id}', [ApplyController::class, 'pengajuan'])->name('pengajuan.edit');
    Route::post('depart/pengajuan/{id}', [ApplyController::class, 'updateDospem'])->name('pengajuan.dospem');
});

// =====================================================================
// MITRA
// =====================================================================
Route::group(['middleware' => ['is_mitra', 'profile_complete']], function () {
    Route::get('mitra/home', [MitraController::class, 'mitraHome'])->name('mitra.home');
    Route::resource('lowongan', LowonganController::class);
    Route::get('mitra/pendaftar', [ApplyController::class, 'listPendaftar'])->name('pendaftar.index');
    Route::get('mitra/pendaftar/{id}', [ApplyController::class, 'pendaftar'])->name('pendaftar.edit');
    Route::get('mitra/approve/{id}', [ApplyController::class, 'approve'])->name('pendaftar.approve');
    Route::get('mitra/reject/{id}', [ApplyController::class, 'reject'])->name('pendaftar.reject');
    Route::post('mitra/pendaftar/{id}', [ApplyController::class, 'approval'])->name('pendaftar.approval');
    Route::get('mitra/magang', [ApplyController::class, 'listMagang'])->name('magang.index');
    Route::get('mitra/magang/{id}', [ApplyController::class, 'detailMagang'])->name('magang.show');
    Route::post('mitra/magang/{id}', [ApplyController::class, 'end'])->name('pendaftar.end');
});

// =====================================================================
// DOSEN PEMBIMBING
// =====================================================================
Route::group(['middleware' => ['is_dospem', 'profile_complete']], function () {
    Route::get('dosen/home', [DospemController::class, 'dospemHome'])->name('dospem.home');
});

// =====================================================================
// SUPERVISOR
// =====================================================================
Route::group(['middleware' => ['is_supervisor', 'profile_complete']], function () {
    Route::get('supervisor/home', [SpvController::class, 'supervisorHome'])->name('supervisor.home');
    Route::get('supervisor/penilaian', [ApplyController::class, 'penilaian'])->name('spv.penilaian');
    Route::post('supervisor/penilaian/{id}', [ApplyController::class, 'score'])->name('spv.score');
});

// =====================================================================
// MAHASISWA
// =====================================================================
Route::group(['middleware' => ['is_mahasiswa', 'profile_complete']], function () {
    Route::get('mahasiswa/home', [MhsController::class, 'mahasiswaHome'])->name('mahasiswa.home');
    Route::get('mahasiswa/apply/{id}', [ApplyController::class, 'apply'])->name('lowongan.apply');
    Route::post('mahasiswa/apply', [ApplyController::class, 'store'])->name('apply.store');
    Route::get('mahasiswa/diajukan', [ApplyController::class, 'diajukan'])->name('lowongan.diajukan');
    Route::get('/redirect', fn() => view('mhs.redirect'))->name('redirect');
});

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
