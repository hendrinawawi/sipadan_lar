<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BisnisController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

//Login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'store'])->name('login.store');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.create');

//reset Password
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


//Admin BTI - BAKU
Route::middleware(['auth'])->group(function () {
    // Semua route di sini hanya bisa diakses oleh user login

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Noperkiraan
    Route::get('/noperki', [AdminController::class, 'noperki'])->name('admin.noperkiraan');
    Route::get('/tambahnoperki', [AdminController::class, 'tambahnoperki'])->name('admin.tambahnoperki');
    Route::post('/perkiraan/simpan', [AdminController::class, 'storeperkiraan'])->name('perkiraan.store');
    Route::get('/get-prodi/{id_fakultas}', [AdminController::class, 'getProdi']);
    Route::get('/get-subkategori1/{id_subkat}', [AdminController::class, 'getSubKategori1']);

    // Kas
    Route::get('/kas/{jenis}', [AdminController::class, 'kas'])->name('admin.kas');
    Route::post('/kassimpan', [AdminController::class, 'simpankas'])->name('admin.kasimpan');
    Route::get('/kas/edit/{id}', [AdminController::class, 'editKas'])->name('admin.editKas');
    Route::put('/kas/update/{id}', [AdminController::class, 'updateKas'])->name('admin.updateKas');
    Route::delete('/kas/hapus/{id}/{jenis}', [AdminController::class, 'hapusKas'])->name('admin.hapusKas');
    Route::get('/kasawaltop', [AdminController::class, 'kasawaltop'])->name('admin.kasawal');
    Route::post('/kasawal/proses', [AdminController::class, 'kasproses'])->name('kas.proses');
    Route::put('/kas/updateawal', [AdminController::class, 'updatekasawal'])->name('kasawal.update');
    Route::get('/kasbaku/{bulan?}/{tahun?}', [AdminController::class, 'saldoKas'])->name('saldo.kas');

    // Pengajuan
    Route::get('/datapengajuan', [AdminController::class, 'datapengajuan'])->name('data.pengajuan');
    Route::get('/buatpengajuan', [AdminController::class, 'buatpengajuan'])->name('buat.pengajuan');
    Route::post('/pengajuankirim', [BisnisController::class, 'pengajuankirim'])->name('kirim.pengajuan');
    Route::get('/historiajuan', [AdminController::class, 'historiajuan'])->name('histori.pengajuan');
    Route::get('/riwayatpengajuan/{id_pengajuan}', [AdminController::class, 'riwayatPengajuan'])->name('riwayat.pengajuan');
    Route::get('/timeline/{id}', [AdminController::class, 'timeline'])->name('pengajuan.timeline');

    // Bisnis
    Route::post('/tolak-pengajuan', [BisnisController::class, 'tolakPengajuan']);
    Route::post('/revisi-pengajuan', [BisnisController::class, 'revisiPengajuan']);
    Route::post('/ajukan-ka-baku', [BisnisController::class, 'ajukanKeKaBaku']);
    Route::post('/acc-pengajuan', [BisnisController::class, 'accPengajuan']);
    Route::post('/simpan-catatan', [BisnisController::class, 'simpanCatatan']);
    Route::post('/otorisasi-pengajuan', [BisnisController::class, 'otorisasiPengajuan']);
    Route::post('/konfirmasi-transfer', [BisnisController::class, 'konfirmasiTransfer']);
    Route::post('/input-kas', [BisnisController::class, 'inputKeKas'])->name('input.kas');
    Route::get('/multipengajuan', [BisnisController::class, 'multi'])->name('pengajuan.multi');
    Route::post('/multipengajuan', [BisnisController::class, 'storeMulti'])->name('pengajuan.multiajuankirim');

    // Rekening
    Route::post('/daftarrekening', [AdminController::class, 'daftarrekening'])->name('daftar.rekening');
    Route::get('/datarekening', [AdminController::class, 'datarekening'])->name('data.rekening');
    Route::put('/rekening/update-status', [AdminController::class, 'updateRekeningStatus'])->name('admin.updateRekeningStatus');

    // Laporan
    Route::get('/kasperiode', [LaporanController::class, 'kasperiode'])->name('kas.periode');
    Route::post('/kasperiode', [LaporanController::class, 'kasperiode'])->name('kas.filterperiode');
    Route::get('/kasbakukampus', [LaporanController::class, 'kascabangbaku'])->name('kas.cabangbybaku');
    Route::get('/kas/kampus/{id}', [LaporanController::class, 'kaskampuscek'])->name('kas.kampuscek');
    Route::post('/kas/kampus/{id}', [LaporanController::class, 'kaskampuscek'])->name('kas.cabangfilter');
});

//User
