<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
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
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/noperki', [AdminController::class, 'noperki'])->name('admin.noperkiraan');
    Route::get('/kas/{jenis}', [AdminController::class, 'kas'])->name('admin.kas');
    Route::get('/kas/edit/{id}', [AdminController::class, 'editKas'])->name('admin.editKas');
    Route::put('/kas/update/{id}', [AdminController::class, 'updateKas'])->name('admin.updateKas');
    Route::delete('/kas/hapus/{id}/{jenis}', [AdminController::class, 'hapusKas'])->name('admin.hapusKas');
});

//User
