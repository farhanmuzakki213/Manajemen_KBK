<?php

use Database\Seeders\BeritaSeeder;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DosenPengampuMatkul;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\Kurikulum;
use App\Http\Controllers\Matkul;
use App\Http\Controllers\ThnAkademikController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pengurus_kbkController;
use App\Http\Controllers\PimpinanJurusan;
use App\Http\Controllers\PimpinanProdi;
use Illuminate\Routing\Route as RoutingRoute;

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


Route::get('/contoh', [BeritaController::class, 'index']);



Route::get('/dashboard', function () {
    return view('admin.content.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
    Route::get('/example', [AdminController::class, 'example'])->name('example');
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

// Pengurus_KBK
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pengurus_kbk', [Pengurus_kbkController::class, 'index'])->middleware(['auth', 'verified'])->name('pengurus_kbk');
    Route::post('/pengurus_kbk/store', [Pengurus_kbkController::class, 'store'])->middleware(['auth', 'verified'])->name('pengurus_kbk.store');
    Route::get('/pengurus_kbk/create', [Pengurus_kbkController::class, 'create'])->middleware(['auth', 'verified'])->name('pengurus_kbk.create');
    Route::get('/pengurus_kbk/edit/{id}', [Pengurus_kbkController::class, 'edit'])->middleware(['auth', 'verified'])->name('pengurus_kbk.edit');
    Route::put('/pengurus_kbk/update/{id}', [Pengurus_kbkController::class, 'update'])->middleware(['auth', 'verified'])->name('pengurus_kbk.update');
    Route::delete('/pengurus_kbk/delete/{id}', [Pengurus_kbkController::class, 'delete'])->middleware(['auth', 'verified'])->name('pengurus_kbk.delete');
});

// Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Dosen Pengampu Matkul
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/DosenPengampuMatkul', [DosenPengampuMatkul::class, 'index'])->middleware(['auth', 'verified'])->name('DosenPengampuMatkul');
});

// Kurikulum
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kurikulum', [Kurikulum::class, 'index'])->middleware(['auth', 'verified'])->name('kurikulum');
});

// Matkul
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/matkul', [Matkul::class, 'index'])->middleware(['auth', 'verified'])->name('matkul');
});

// Pimpinan Jurusan
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pimpinamjurusan', [PimpinanJurusan::class, 'index'])->middleware(['auth', 'verified'])->name('pimpinanjurusan');
});

// Pimpinan Prodi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pimpinamprodi', [PimpinanProdi::class, 'index'])->middleware(['auth', 'verified'])->name('pimpinanprodi');
});