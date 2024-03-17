<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\ThnAkademikController;
use App\Http\Controllers\ProfileController;
use Illuminate\Routing\Route as RoutingRoute;
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
    return view('frontend.master');
});

// Admin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
    Route::get('/example', [AdminController::class, 'example'])->name('example');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});



// Jurusan
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/jurusan', [JurusanController::class, 'index'])->middleware(['auth', 'verified'])->name('jurusan');
});


// Prodi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/prodi', [ProdiController::class, 'index'])->middleware(['auth', 'verified'])->name('prodi');
});


// Tahun Akademik
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/thnakademik', [ThnAkademikController::class, 'index'])->middleware(['auth', 'verified'])->name('thnakademik');
});

// Dosen
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dosen', [DosenController::class, 'index'])->name('dosen');
    Route::post('/dosen', [DosenController::class, 'store']);
});

// Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
