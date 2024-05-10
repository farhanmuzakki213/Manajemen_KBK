<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DosenPengampuMatkul;
use App\Http\Controllers\JenisKbkController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\Kurikulum;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\MatkulKBKController;
use App\Http\Controllers\ThnAkademikController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pengurus_kbkController;
use App\Http\Controllers\PimpinanJurusan;
use App\Http\Controllers\PimpinanProdi;
use App\Http\Controllers\RPSController;
use App\Http\Controllers\Soal_UASController;
use App\Models\Pengurus_kbk;
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

Route::get('/', [LandingPageController::class, 'index']);


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
    Route::get('/dosen/show/{id}', [DosenController::class, 'show'])->middleware(['auth', 'verified'])->name('dosen.show');
});

// Pengurus_KBK
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pengurus_kbk', [Pengurus_kbkController::class, 'index'])->middleware(['auth', 'verified'])->name('pengurus_kbk');
    Route::post('/pengurus_kbk/store', [Pengurus_kbkController::class, 'store'])->middleware(['auth', 'verified'])->name('pengurus_kbk.store');
    Route::get('/pengurus_kbk/create', [Pengurus_kbkController::class, 'create'])->middleware(['auth', 'verified'])->name('pengurus_kbk.create');
    Route::get('/pengurus_kbk/edit/{id}', [Pengurus_kbkController::class, 'edit'])->middleware(['auth', 'verified'])->name('pengurus_kbk.edit');
    Route::put('/pengurus_kbk/update/{id}', [Pengurus_kbkController::class, 'update'])->middleware(['auth', 'verified'])->name('pengurus_kbk.update');
    Route::delete('/pengurus_kbk/delete/{id}', [Pengurus_kbkController::class, 'delete'])->middleware(['auth', 'verified'])->name('pengurus_kbk.delete');
    Route::get('/pengurus_kbk/export/excel', [Pengurus_kbkController::class, 'export_excel'])->name('pengurus_kbk.export');
    Route::post('/pengurus_kbk/import', [Pengurus_kbkController::class, 'import'])->name('pengurus_kbk.import');
});

// Jenis KBK
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/data_kbk', [JenisKbkController::class, 'index'])->middleware(['auth', 'verified'])->name('jenis_kbk');
    Route::post('/data_kbk/store', [JenisKbkController::class, 'store'])->middleware(['auth', 'verified'])->name('jenis_kbk.store');
    Route::get('/data_kbk/create', [JenisKbkController::class, 'create'])->middleware(['auth', 'verified'])->name('jenis_kbk.create');
    Route::get('/data_kbk/edit/{id}', [JenisKbkController::class, 'edit'])->middleware(['auth', 'verified'])->name('jenis_kbk.edit');
    Route::put('/data_kbk/update/{id}', [JenisKbkController::class, 'update'])->middleware(['auth', 'verified'])->name('jenis_kbk.update');
    Route::delete('/data_kbk/delete/{id}', [JenisKbkController::class, 'delete'])->middleware(['auth', 'verified'])->name('jenis_kbk.delete');
    Route::get('/data_kbk/export/excel', [JenisKbkController::class, 'export_excel'])->name('jenis_kbk.export');
    Route::post('/data_kbk/import', [JenisKbkController::class, 'import'])->name('jenis_kbk.import');
});

// Matkul
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/matkul', [MatkulController::class, 'index'])->middleware(['auth', 'verified'])->name('matkul');
    Route::post('/matkul/store', [MatkulController::class, 'store'])->middleware(['auth', 'verified'])->name('matkul.store');
    Route::get('/matkul/create', [MatkulController::class, 'create'])->middleware(['auth', 'verified'])->name('matkul.create');
    Route::get('/matkul/edit/{id}', [MatkulController::class, 'edit'])->middleware(['auth', 'verified'])->name('matkul.edit');
    Route::put('/matkul/update/{id}', [MatkulController::class, 'update'])->middleware(['auth', 'verified'])->name('matkul.update');
    Route::get('/matkul/show/{id}', [MatkulController::class, 'show'])->middleware(['auth', 'verified'])->name('matkul.show');
    Route::delete('/matkul/delete/{id}', [MatkulController::class, 'delete'])->middleware(['auth', 'verified'])->name('matkul.delete');
    Route::get('/matkul/export/excel', [MatkulController::class, 'export_excel'])->name('matkul.export');
    Route::post('/matkul/import', [MatkulController::class, 'import'])->name('matkul.import');
});

// Matkul_KBK
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/matkul-kbk', [MatkulKBKController::class, 'index'])->middleware(['auth', 'verified'])->name('matkul_kbk');
    Route::post('/matkul-kbk/store', [MatkulKBKController::class, 'store'])->middleware(['auth', 'verified'])->name('matkul_kbk.store');
    Route::get('/matkul-kbk/create', [MatkulKBKController::class, 'create'])->middleware(['auth', 'verified'])->name('matkul_kbk.create');
    Route::get('/matkul-kbk/edit/{id}', [MatkulKBKController::class, 'edit'])->middleware(['auth', 'verified'])->name('matkul_kbk.edit');
    Route::put('/matkul-kbk/update/{id}', [MatkulKBKController::class, 'update'])->middleware(['auth', 'verified'])->name('matkul_kbk.update');
    Route::get('/matkul-kbk/show/{id}', [MatkulKBKController::class, 'show'])->middleware(['auth', 'verified'])->name('matkul_kbk.show');
    Route::delete('/matkul-kbk/delete/{id}', [MatkulKBKController::class, 'delete'])->middleware(['auth', 'verified'])->name('matkul_kbk.delete');
    Route::get('/matkul-kbk/export/excel', [MatkulKBKController::class, 'export_excel'])->name('matkul_kbk.export');
    Route::post('/matkul-kbk/import', [MatkulKBKController::class, 'import'])->name('matkul_kbk.import');
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
    Route::get('/DosenPengampuMatkul/export/excel', [DosenPengampuMatkul::class, 'export_excel'])->name('DosenPengampuMatkul.export');
});

// Kurikulum
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kurikulum', [Kurikulum::class, 'index'])->middleware(['auth', 'verified'])->name('kurikulum');
});

// Pimpinan Jurusan
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pimpinamjurusan', [PimpinanJurusan::class, 'index'])->middleware(['auth', 'verified'])->name('pimpinanjurusan');
});

// Pimpinan Prodi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pimpinamprodi', [PimpinanProdi::class, 'index'])->middleware(['auth', 'verified'])->name('pimpinanprodi');
});

// RPS
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/rps', [RPSController::class, 'index'])->middleware(['auth', 'verified'])->name('rps');
});

// Soal_UAS
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/soal_uas', [Soal_UASController::class, 'index'])->middleware(['auth', 'verified'])->name('soal_uas');
});
