<?php

/* Admin */
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\ThnAkademikController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\KurikulumController;
use App\Http\Controllers\Admin\PimpinanJurusanController;
use App\Http\Controllers\Admin\MatkulController;
use App\Http\Controllers\Admin\Pengurus_kbkController;
use App\Http\Controllers\Admin\DosenKBKController;
use App\Http\Controllers\Admin\DosenPengampuMatkulController;
use App\Http\Controllers\Admin\JenisKbkController;
use App\Http\Controllers\Admin\MatkulKBKController;
use App\Http\Controllers\Admin\PimpinanProdiController;
/* Dosen Pengampu */
use App\Http\Controllers\DosenPengampu\DosenMatkulController;
/* Pimpinan Jurusan */
use App\Http\Controllers\PimpinanJurusan\KajurController;
/* Pimpinan Prodi */
use App\Http\Controllers\PimpinanProdi\Rep_Soal_UASController;
use App\Http\Controllers\PimpinanProdi\Rep_RPSController;
use App\Http\Controllers\PimpinanProdi\Berita_Ver_UASController;
use App\Http\Controllers\PimpinanProdi\HasilFinalProposalTAController;
/* Pengurus KBK */
use App\Http\Controllers\PengurusKbk\PenugasanReviewController;
use App\Http\Controllers\PengurusKbk\Ver_RPSController;
use App\Http\Controllers\PengurusKbk\Ver_Soal_UASController;
/* Dosen KBK */
use App\Http\Controllers\DosenKbk\ReviewProposalTAController;
/* Landing Page */
use App\Http\Controllers\LandingPage\LandingPageController;
/* End */
use App\Http\Controllers\ExampleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
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



Route::group(['middleware' => ['role:super-admin']], function () {
    Route::resource('permissions', App\Http\Controllers\SuperAdmin\PermissionController::class);
    Route::delete('permissions/{permissionId}/delete', [App\Http\Controllers\SuperAdmin\PermissionController::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\SuperAdmin\RoleController::class);
    Route::delete('roles/{roleId}/delete', [App\Http\Controllers\SuperAdmin\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\SuperAdmin\RoleController::class, 'addPermissionsToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\SuperAdmin\RoleController::class, 'givePermissionsToRole']);

    Route::resource('users', App\Http\Controllers\SuperAdmin\UserController::class);
    Route::delete('users/{userId}/delete', [App\Http\Controllers\SuperAdmin\UserController::class, 'destroy']);
});

Route::get('/', [LandingPageController::class, 'index']);

// Detail Berita
Route::get('/berita/{id_berita}', [LandingPageController::class, 'detail']);


Route::get('/dashboard', function () {
    return view('admin.content.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
/* Route::get('/contoh', [ExampleController::class, 'create']); */

/* ---Admin Start--- */
Route::group(['middleware' => ['role:admin']], function () {
    // Admin
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/repositori_proposal_ta', [AdminController::class, 'RepProposalTA'])->name('rep_proposal_ta');
        Route::get('/example', [AdminController::class, 'example'])->name('example');
    });

    // Mahasiswa
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->middleware(['auth', 'verified'])->name('mahasiswa');
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

    // Kurikulum
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/kurikulum', [KurikulumController::class, 'index'])->middleware(['auth', 'verified'])->name('kurikulum');
    });

    // Dosen Pengampu Matkul
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/DosenPengampuMatkul', [DosenPengampuMatkulController::class, 'index'])->middleware(['auth', 'verified'])->name('DosenPengampuMatkul');
        Route::get('/DosenPengampuMatkul/export/excel', [DosenPengampuMatkulController::class, 'export_excel'])->name('DosenPengampuMatkul.export');
    });

    // Pimpinan Jurusan
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/pimpinamjurusan', [PimpinanJurusanController::class, 'index'])->middleware(['auth', 'verified'])->name('pimpinanjurusan');
    });

    // Pimpinan Prodi
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/pimpinamprodi', [PimpinanProdiController::class, 'index'])->middleware(['auth', 'verified'])->name('pimpinanprodi');
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

    //Dosen KBK
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dosen_kbk', [DosenKBKController::class, 'index'])->middleware(['auth', 'verified'])->name('dosen_kbk');
        Route::post('/dosen_kbk/store', [DosenKBKController::class, 'store'])->middleware(['auth', 'verified'])->name('dosen_kbk.store');
        Route::get('/dosen_kbk/create', [DosenKBKController::class, 'create'])->middleware(['auth', 'verified'])->name('dosen_kbk.create');
        Route::get('/dosen_kbk/edit/{id}', [DosenKBKController::class, 'edit'])->middleware(['auth', 'verified'])->name('dosen_kbk.edit');
        Route::put('/dosen_kbk/update/{id}', [DosenKBKController::class, 'update'])->middleware(['auth', 'verified'])->name('dosen_kbk.update');
        Route::delete('/dosen_kbk/delete/{id}', [DosenKBKController::class, 'delete'])->middleware(['auth', 'verified'])->name('dosen_kbk.delete');
        Route::get('/dosen_kbk/export/excel', [DosenKBKController::class, 'export_excel'])->name('dosen_kbk.export');
        Route::post('/dosen_kbk/import', [DosenKBKController::class, 'import'])->name('dosen_kbk.import');
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
});
/* Admin End */

// Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';




/* ---Kepala Prodi Start--- */
Route::group(['middleware' => ['role:pimpinan-prodi']], function () {
    // Repositori RPS
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/repositori_rps', [Rep_RPSController::class, 'index'])->middleware(['auth', 'verified'])->name('rep_rps');
        Route::post('/repositori_rps/store', [Rep_RPSController::class, 'store'])->middleware(['auth', 'verified'])->name('rep_rps.store');
        Route::get('/repositori_rps/create', [Rep_RPSController::class, 'create'])->middleware(['auth', 'verified'])->name('rep_rps.create');
    });

    // Repositori Soal_UAS
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/repositori_soal_uas', [Rep_Soal_UASController::class, 'index'])->middleware(['auth', 'verified'])->name('rep_soal_uas');
        Route::post('/repositori_soal_uas/store', [Rep_Soal_UASController::class, 'store'])->middleware(['auth', 'verified'])->name('rep_soal_uas.store');
    });

    // HasilReviewProposalTA
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/hasil_review_proposal_ta', [HasilFinalProposalTAController::class, 'index'])->middleware(['auth', 'verified'])->name('hasil_review_proposal_ta');
        Route::get('/hasil_review_proposal_ta/edit/{id}', [HasilFinalProposalTAController::class, 'edit'])->middleware(['auth', 'verified'])->name('hasil_review_proposal_ta.edit');
        Route::put('/hasil_review_proposal_ta/update/{id}', [HasilFinalProposalTAController::class, 'update'])->middleware(['auth', 'verified'])->name('hasil_review_proposal_ta.update');
        Route::get('/hasil_review_proposal_ta/export/excel', [HasilFinalProposalTAController::class, 'export_excel'])->name('hasil_review_proposal_ta.export');
    });

    // Berita Acara Verifikasi Soal_UAS
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/Berita_Acara_verifikasi_soal_uas', [Berita_Ver_UASController::class, 'index'])->middleware(['auth', 'verified'])->name('berita_ver_uas');
    });
});

/* ---Kepala Prodi end */

/* Dosen Pengampu Start*/
Route::group(['middleware' => ['role:dosen-pengampu']], function () {
    // Dosen Matkul
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/Daftar_Matakuliah', [DosenMatkulController::class, 'index'])->middleware(['auth', 'verified'])->name('dosen_matkul');
        //Upload_RPS
        Route::post('/upload_rps/store', [DosenMatkulController::class, 'store_rps'])->middleware(['auth', 'verified'])->name('upload_rps.store');
        Route::get('/upload_rps/create/{id_matkul}', [DosenMatkulController::class, 'create_rps'])->middleware(['auth', 'verified'])->name('upload_rps.create');
        Route::get('/upload_rps/edit/{id}', [DosenMatkulController::class, 'edit_rps'])->middleware(['auth', 'verified'])->name('upload_rps.edit');
        Route::put('/upload_rps/update/{id}', [DosenMatkulController::class, 'update_rps'])->middleware(['auth', 'verified'])->name('upload_rps.update');
        Route::delete('/upload_rps/delete/{id}', [DosenMatkulController::class, 'delete_rps'])->middleware(['auth', 'verified'])->name('upload_rps.delete');
        //Upload_UAS
        Route::post('/upload_soal_uas/store', [DosenMatkulController::class, 'store_uas'])->middleware(['auth', 'verified'])->name('upload_soal_uas.store');
        Route::get('/upload_soal_uas/create/{id_matkul}', [DosenMatkulController::class, 'create_uas'])->middleware(['auth', 'verified'])->name('upload_soal_uas.create');
        Route::get('/upload_soal_uas/edit/{id}', [DosenMatkulController::class, 'edit_uas'])->middleware(['auth', 'verified'])->name('upload_soal_uas.edit');
        Route::put('/upload_soal_uas/update/{id}', [DosenMatkulController::class, 'update_uas'])->middleware(['auth', 'verified'])->name('upload_soal_uas.update');
        Route::delete('/upload_soal_uas/delete/{id}', [DosenMatkulController::class, 'delete_uas'])->middleware(['auth', 'verified'])->name('upload_soal_uas.delete');
    });
});

/* ---Dosen Pengampu End--- */


/* ---Dosen KBK Start--- */
Route::group(['middleware' => ['role:dosen-kbk']], function () {
    // ReviewProposalTA
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/review_proposal_ta', [ReviewProposalTAController::class, 'index'])->middleware(['auth', 'verified'])->name('review_proposal_ta');
        Route::post('/review_proposal_ta/store', [ReviewProposalTAController::class, 'store'])->middleware(['auth', 'verified'])->name('review_proposal_ta.store');
        Route::get('/review_proposal_ta/create', [ReviewProposalTAController::class, 'create'])->middleware(['auth', 'verified'])->name('review_proposal_ta.create');
        Route::get('/review_proposal_ta/edit/{id}', [ReviewProposalTAController::class, 'edit'])->middleware(['auth', 'verified'])->name('review_proposal_ta.edit');
        Route::put('/review_proposal_ta/update/{id}', [ReviewProposalTAController::class, 'update'])->middleware(['auth', 'verified'])->name('review_proposal_ta.update');
        Route::delete('/review_proposal_ta/delete/{id}', [ReviewProposalTAController::class, 'delete'])->middleware(['auth', 'verified'])->name('review_proposal_ta.delete');
    });
});

/* ---Dosen KBK End--- */



/* ---Penurus KBK Start--- */
Route::group(['middleware' => ['role:pengurus-kbk']], function () {
    // Penugasan Reviewer Proposal TA
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/PenugasanReview', [PenugasanReviewController::class, 'index'])->middleware(['auth', 'verified'])->name('PenugasanReview');
        Route::post('/PenugasanReview/store', [PenugasanReviewController::class, 'store'])->middleware(['auth', 'verified'])->name('PenugasanReview.store');
        Route::get('/PenugasanReview/create', [PenugasanReviewController::class, 'create'])->middleware(['auth', 'verified'])->name('PenugasanReview.create');
        Route::get('/PenugasanReview/edit/{id}', [PenugasanReviewController::class, 'edit'])->middleware(['auth', 'verified'])->name('PenugasanReview.edit');
        Route::put('/PenugasanReview/update/{id}', [PenugasanReviewController::class, 'update'])->middleware(['auth', 'verified'])->name('PenugasanReview.update');
        Route::delete('/PenugasanReview/delete/{id}', [PenugasanReviewController::class, 'delete'])->middleware(['auth', 'verified'])->name('PenugasanReview.delete');
    });

    // Hasil Review Proposal TA
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/HasilReview', [PenugasanReviewController::class, 'hasil'])->middleware(['auth', 'verified'])->name('HasilReview');
    });

    // Verifikasi RPS
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/verifikasi_rps', [Ver_RPSController::class, 'index'])->middleware(['auth', 'verified'])->name('ver_rps');
        Route::post('/verifikasi_rps/store', [Ver_RPSController::class, 'store'])->middleware(['auth', 'verified'])->name('ver_rps.store');
        Route::get('/verifikasi_rps/create/{id}', [Ver_RPSController::class, 'create'])->middleware(['auth', 'verified'])->name('ver_rps.create');
        Route::get('/verifikasi_rps/edit/{id}', [Ver_RPSController::class, 'edit'])->middleware(['auth', 'verified'])->name('ver_rps.edit');
        Route::put('/verifikasi_rps/update/{id}', [Ver_RPSController::class, 'update'])->middleware(['auth', 'verified'])->name('ver_rps.update');
        Route::get('/verifikasi_rps/show/{id}', [Ver_RPSController::class, 'show'])->middleware(['auth', 'verified'])->name('ver_rps.show');
        Route::delete('/verifikasi_rps/delete/{id}', [Ver_RPSController::class, 'delete'])->middleware(['auth', 'verified'])->name('ver_rps.delete');
    });

    // Verifikasi Soal_UAS
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/verifikasi_soal_uas', [Ver_Soal_UASController::class, 'index'])->middleware(['auth', 'verified'])->name('ver_soal_uas');
        Route::post('/verifikasi_soal_uas/store', [Ver_Soal_UASController::class, 'store'])->middleware(['auth', 'verified'])->name('ver_soal_uas.store');
        Route::get('/verifikasi_soal_uas/create/{id}', [Ver_Soal_UASController::class, 'create'])->middleware(['auth', 'verified'])->name('ver_soal_uas.create');
        Route::get('/verifikasi_soal_uas/edit/{id}', [Ver_Soal_UASController::class, 'edit'])->middleware(['auth', 'verified'])->name('ver_soal_uas.edit');
        Route::put('/verifikasi_soal_uas/update/{id}', [Ver_Soal_UASController::class, 'update'])->middleware(['auth', 'verified'])->name('ver_soal_uas.update');
        Route::get('/verifikasi_soal_uas/show/{id}', [Ver_Soal_UASController::class, 'show'])->middleware(['auth', 'verified'])->name('ver_soal_uas.show');
        Route::delete('/verifikasi_soal_uas/delete/{id}', [Ver_Soal_UASController::class, 'delete'])->middleware(['auth', 'verified'])->name('ver_soal_uas.delete');
    });
});

/* ---Penurus KBK End--- */



/* ---Kepala Jurusan Start--- */
Route::group(['middleware' => ['role:pimpinan-jurusan']], function () {
    // Kepala Jurusan
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/repositori_rps_jurusan', [KajurController::class, 'RepRPSJurusan'])->middleware(['auth', 'verified'])->name('rep_rps_jurusan');
        Route::get('/repositori_soal_uas_jurusan', [KajurController::class, 'RepSoalUASJurusan'])->middleware(['auth', 'verified'])->name('rep_soal_uas_jurusan');
        Route::get('/repositori_proposal_ta_jurusan', [KajurController::class, 'RepProposalTAJurusan'])->middleware(['auth', 'verified'])->name('rep_proposal_ta_jurusan');
        Route::get('/grafik_rps', [KajurController::class, 'grafik_rps'])->middleware(['auth', 'verified'])->name('grafik_rps');
        Route::get('/grafik_uas', [KajurController::class, 'grafik_uas'])->middleware(['auth', 'verified'])->name('grafik_uas');
        Route::get('/grafik_proposal', [KajurController::class, 'grafik_proposal'])->middleware(['auth', 'verified'])->name('grafik_proposal');
    });
});

/* ---Kepala Jurusan End--- */
