<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndexController;
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

Route::any('/', [IndexController::class, 'index'])->name('index');
Route::any('/about', [IndexController::class, 'about'])->name('about');
Route::any('/login', [LoginController::class, 'login'])->name('login');
Route::any('/proses_login', [LoginController::class, 'prosesLogin'])->name('prosesLogin');
Route::any('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::any('/home', [AdminController::class, 'index'])->name('admin.index');
        Route::any('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::any('/update_profile', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');

        Route::any('/jabatan', [AdminController::class, 'jabatan'])->name('admin.jabatan');
        Route::any('/addJabatan', [AdminController::class, 'addJabatan'])->name('admin.addJabatan');
        Route::any('/updateJabatan', [AdminController::class, 'updateJabatan'])->name('admin.updateJabatan');
        Route::any('/deleteJabatan/{id}', [AdminController::class, 'deleteJabatan'])->name('admin.deleteJabatan');

        Route::any('/pegawai', [AdminController::class, 'pegawai'])->name('admin.pegawai');
        Route::any('/addPegawai', [AdminController::class, 'addPegawai'])->name('admin.addPegawai');
        Route::any('/updatePegawai', [AdminController::class, 'updatePegawai'])->name('admin.updatePegawai');
        Route::any('/deletePegawai/{id}', [AdminController::class, 'deletePegawai'])->name('admin.deletePegawai');

        Route::any('/absen', [AdminController::class, 'absen'])->name('admin.absen');
        Route::any('/lokasi', [AdminController::class, 'lokasi'])->name('admin.lokasi');
        Route::any('/updateLokasi', [AdminController::class, 'updateLokasi'])->name('admin.updateLokasi');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('pegawai')->middleware(['pegawai'])->group(function () {
        Route::any('/home', [UserController::class, 'index'])->name('pegawai.index');
        Route::any('/profile', [UserController::class, 'profile'])->name('pegawai.profile');
        Route::any('/update_profile', [UserController::class, 'updateProfile'])->name('pegawai.updateProfile');

        Route::any('/absen', [UserController::class, 'absen'])->name('pegawai.absen');
        Route::any('/addAbsen', [UserController::class, 'addAbsen'])->name('pegawai.addAbsen');

        Route::any('/history', [UserController::class, 'history'])->name('pegawai.history');
    });
});
