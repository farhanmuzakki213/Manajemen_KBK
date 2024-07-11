<?php

/* Admin */
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\MatkulController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\DosenKBKController;
use App\Http\Controllers\Admin\JenisKbkController;
use App\Http\Controllers\Admin\KurikulumController;
use App\Http\Controllers\Admin\MahasiswaController;
/* Dosen Pengampu */
use App\Http\Controllers\Admin\MatkulKBKController;
/* Pimpinan Jurusan */
use App\Http\Controllers\Admin\ThnAkademikController;
use App\Http\Controllers\Admin\Pengurus_kbkController;
use App\Http\Controllers\DosenKbk\dosen_kbkController;
/* Pimpinan Prodi */
use App\Http\Controllers\Admin\PimpinanProdiController;
use App\Http\Controllers\PengurusKbk\Ver_RPSController;
use App\Http\Controllers\Admin\PimpinanJurusanController;
use App\Http\Controllers\PimpinanJurusan\KajurController;
use App\Http\Controllers\PimpinanProdi\kaprodiController;
/* Pengurus KBK */
use App\Http\Controllers\PimpinanProdi\Rep_RPSController;
use App\Http\Controllers\LandingPage\LandingPageController;
use App\Http\Controllers\PengurusKbk\PengurusKbkController;
use App\Http\Controllers\PengurusKbk\Ver_Soal_UASController;
use App\Http\Controllers\Admin\DosenPengampuMatkulController;
use App\Http\Controllers\DosenKbk\ReviewProposalTAController;
/* Dosen KBK */
use App\Http\Controllers\DosenPengampu\DosenMatkulController;
/* Landing Page */
use App\Http\Controllers\PimpinanProdi\Rep_Soal_UASController;
/* End */
use App\Http\Controllers\PengurusKbk\PenugasanReviewController;
use App\Http\Controllers\PimpinanProdi\Berita_Ver_RPSController;
use App\Http\Controllers\PimpinanProdi\Berita_Ver_UASController;
use App\Http\Controllers\PengurusKbk\VerBeritaAcaraRpsController;
use App\Http\Controllers\PengurusKbk\VerBeritaAcaraUasController;
use App\Http\Controllers\PimpinanProdi\HasilFinalProposalTAController;
use App\Http\Controllers\PimpinanJurusan\Berita_Ver_RPS_KajurController;
use App\Http\Controllers\PimpinanJurusan\Berita_Ver_UAS_KajurController;
use App\Http\Controllers\UserProfileController;

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



Route::group(['middleware' => ['role:superAdmin']], function () {
    Route::resource('permissions', App\Http\Controllers\SuperAdmin\PermissionController::class);
    Route::delete('permissions/{permissionId}/delete', [App\Http\Controllers\SuperAdmin\PermissionController::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\SuperAdmin\RoleController::class);
    Route::delete('roles/{roleId}/delete', [App\Http\Controllers\SuperAdmin\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\SuperAdmin\RoleController::class, 'addPermissionsToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\SuperAdmin\RoleController::class, 'givePermissionsToRole']);

    Route::resource('users', App\Http\Controllers\SuperAdmin\UserController::class);
    Route::delete('users/{userId}/delete', [App\Http\Controllers\SuperAdmin\UserController::class, 'destroy']);

    Route::resource('logs/', App\Http\Controllers\SuperAdmin\LogController::class);
});

Route::get('/', [LandingPageController::class, 'index']);

// Detail Berita
Route::get('/detail_berita/{id}', [LandingPageController::class, 'detail']);


Route::get('/profile', function () {
    return view('admin.content.profile');
})->middleware(['auth', 'verified'])->name('profile');

Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
/* Route::get('/contoh', [ExampleController::class, 'create']); */

/* ---Admin Start--- */
Route::group(['middleware' => ['role:admin']], function () {
    // Admin
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard_admin', [AdminController::class, 'dashboard_admin'])->middleware(['auth', 'verified'])->name('dashboard_admin');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/repositori_proposal_ta', [AdminController::class, 'RepProposalTA'])->name('rep_proposal_ta');
        Route::get('/repositori_proposal_ta/dataAPI', [AdminController::class, 'show'])->middleware(['auth', 'verified'])->name('rep_proposal_ta.show');
        Route::post('/repositori_proposal_ta/storeAPI', [AdminController::class, 'storeAPI'])->middleware(['auth', 'verified'])->name('rep_proposal_ta.storeAPI');
    });

    // Mahasiswa
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->middleware(['auth', 'verified'])->name('mahasiswa');
        Route::get('/mahasiswa/dataAPI', [MahasiswaController::class, 'show'])->middleware(['auth', 'verified'])->name('mahasiswa.show');
        Route::post('/mahasiswa/storeAPI', [MahasiswaController::class, 'storeAPI'])->middleware(['auth', 'verified'])->name('mahasiswa.storeAPI');
    });

    // Jurusan
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/jurusan', [JurusanController::class, 'index'])->middleware(['auth', 'verified'])->name('jurusan');
        Route::get('/jurusan/dataAPI', [JurusanController::class, 'show'])->middleware(['auth', 'verified'])->name('jurusan.show');
        Route::post('/jurusan/store', [JurusanController::class, 'store'])->middleware(['auth', 'verified'])->name('jurusan.store');
    });


    // Prodi
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/prodi', [ProdiController::class, 'index'])->middleware(['auth', 'verified'])->name('prodi');
        Route::get('/prodi/dataAPI', [ProdiController::class, 'show'])->middleware(['auth', 'verified'])->name('prodi.show');
        Route::post('/prodi/storeAPI', [ProdiController::class, 'storeAPI'])->middleware(['auth', 'verified'])->name('prodi.storeAPI');
    });


    // Tahun Akademik
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/thnakademik', [ThnAkademikController::class, 'index'])->middleware(['auth', 'verified'])->name('thnakademik');
        Route::get('/thnakademik/dataAPI', [ThnAkademikController::class, 'show'])->middleware(['auth', 'verified'])->name('thnakademik.show');
        Route::post('/thnakademik/storeAPI', [ThnAkademikController::class, 'store'])->middleware(['auth', 'verified'])->name('thnakademik.store');
    });

    // Dosen
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dosen/dataAPI', [DosenController::class, 'show'])->middleware(['auth', 'verified'])->name('dosen.show');
        Route::post('/dosen/storeAPI', [DosenController::class, 'storeAPI'])->middleware(['auth', 'verified'])->name('dosen.storeAPI');
        Route::get('/dosen', [DosenController::class, 'index'])->middleware(['auth', 'verified'])->name('dosen');
        Route::post('/dosen/store', [DosenController::class, 'store'])->middleware(['auth', 'verified'])->name('dosen.store');
        Route::get('/dosen/create', [DosenController::class, 'create'])->middleware(['auth', 'verified'])->name('dosen.create');
        Route::get('/dosen/edit/{id}', [DosenController::class, 'edit'])->middleware(['auth', 'verified'])->name('dosen.edit');
        Route::put('/dosen/update/{id}', [DosenController::class, 'update'])->middleware(['auth', 'verified'])->name('dosen.update');
        Route::delete('/dosen/delete/{id}', [DosenController::class, 'delete'])->middleware(['auth', 'verified'])->name('dosen.delete');
    });

    // Kurikulum
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/kurikulum', [KurikulumController::class, 'index'])->middleware(['auth', 'verified'])->name('kurikulum');
        Route::get('/kurikulum/dataAPI', [KurikulumController::class, 'show'])->middleware(['auth', 'verified'])->name('kurikulum.show');
        Route::post('/kurikulum/store', [KurikulumController::class, 'store'])->middleware(['auth', 'verified'])->name('kurikulum.store');
    });

    // Dosen Pengampu Matkul
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/DosenPengampuMatkul', [DosenPengampuMatkulController::class, 'index'])->middleware(['auth', 'verified'])->name('DosenPengampuMatkul');
        Route::post('/DosenPengampuMatkul', [DosenPengampuMatkulController::class, 'store'])->middleware(['auth', 'verified'])->name('DosenPengampuMatkul.store');
        Route::get('/DosenPengampuMatkul/export/excel', [DosenPengampuMatkulController::class, 'export_excel'])->name('DosenPengampuMatkul.export');
        Route::get('/DosenPengampuMatkul/create', [DosenPengampuMatkulController::class, 'create'])->middleware(['auth', 'verified'])->name('DosenPengampuMatkul.create');
        Route::get('/DosenPengampuMatkul/edit/{id}', [DosenPengampuMatkulController::class, 'edit'])->middleware(['auth', 'verified'])->name('DosenPengampuMatkul.edit');
        Route::put('/DosenPengampuMatkul/update/{id}', [DosenPengampuMatkulController::class, 'update'])->middleware(['auth', 'verified'])->name('DosenPengampuMatkul.update');
        Route::delete('/DosenPengampuMatkul/delete/{id}', [DosenPengampuMatkulController::class, 'delete'])->middleware(['auth', 'verified'])->name('DosenPengampuMatkul.delete');
        Route::get('/DosenPengampuMatkul/dataAPI', [DosenPengampuMatkulController::class, 'show'])->middleware(['auth', 'verified'])->name('DosenPengampuMatkul.show');
        Route::post('/DosenPengampuMatkul/storeAPI', [DosenPengampuMatkulController::class, 'storeAPI'])->middleware(['auth', 'verified'])->name('DosenPengampuMatkul.storeAPI');
    });

    // Pimpinan Jurusan
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/pimpinamjurusan', [PimpinanJurusanController::class, 'index'])->middleware(['auth', 'verified'])->name('pimpinanjurusan');
        Route::get('/pimpinamjurusan/dataAPI', [PimpinanJurusanController::class, 'show'])->middleware(['auth', 'verified'])->name('pimpinanjurusan.show');
        Route::post('/pimpinamjurusan/storeAPI', [PimpinanJurusanController::class, 'storeAPI'])->middleware(['auth', 'verified'])->name('pimpinanjurusan.storeAPI');
    });

    // Pimpinan Prodi
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/pimpinamprodi', [PimpinanProdiController::class, 'index'])->middleware(['auth', 'verified'])->name('pimpinanprodi');
        Route::get('/pimpinamprodi/dataAPI', [PimpinanProdiController::class, 'show'])->middleware(['auth', 'verified'])->name('pimpinanprodi.show');
        Route::post('/pimpinamprodi/storeAPI', [PimpinanProdiController::class, 'storeAPI'])->middleware(['auth', 'verified'])->name('pimpinanprodi.storeAPI');
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
        // Route::get('/matkul/show/{id}', [MatkulController::class, 'show'])->middleware(['auth', 'verified'])->name('matkul.show');
        Route::delete('/matkul/delete/{id}', [MatkulController::class, 'delete'])->middleware(['auth', 'verified'])->name('matkul.delete');
        Route::get('/matkul/export/excel', [MatkulController::class, 'export_excel'])->name('matkul.export');
        Route::post('/matkul/import', [MatkulController::class, 'import'])->name('matkul.import');
        Route::get('/matkul/dataAPI', [MatkulController::class, 'show'])->middleware(['auth', 'verified'])->name('matkul.show');
        Route::post('/matkul/storeAPI', [MatkulController::class, 'storeAPI'])->middleware(['auth', 'verified'])->name('matkul.storeAPI');
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

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/reset', [UserProfileController::class, 'resetProfilePicture'])->name('profile.reset');
    Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password/update', [UserProfileController::class, 'updatePassword'])->name('password.updatePassword');
});

require __DIR__ . '/auth.php';




/* ---Kepala Prodi Start--- */
Route::group(['middleware' => ['role:pimpinanProdi']], function () {
    // Repositori RPS
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard_kaprodi', [kaprodiController::class, 'dashboard_kaprodi'])->middleware(['auth', 'verified'])->name('dashboard_kaprodi');
            Route::get('/grafik_rps_prodi', [kaprodiController::class, 'grafik_rps'])->middleware(['auth', 'verified'])->name('grafik_rps_prodi');
            Route::get('/grafik_uas_prodi', [kaprodiController::class, 'grafik_uas'])->middleware(['auth', 'verified'])->name('grafik_uas_prodi');
    });

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
        Route::get('/Berita_Acara_verifikasi_soal_uas/{id}', [Berita_Ver_UASController::class, 'edit'])->middleware(['auth', 'verified'])->name('berita_ver_uas.edit');
        Route::put('/Berita_Acara_verifikasi_soal_uas/{id}', [Berita_Ver_UASController::class, 'update'])->middleware(['auth', 'verified'])->name('berita_ver_uas.update');
    });

    // Berita Acara Verifikasi RPS
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/Berita_Acara_verifikasi_rps', [Berita_Ver_RPSController::class, 'index'])->middleware(['auth', 'verified'])->name('berita_ver_rps');
        Route::get('/Berita_Acara_verifikasi_rps/{id}', [Berita_Ver_RPSController::class, 'edit'])->middleware(['auth', 'verified'])->name('berita_ver_rps.edit');
        Route::put('/Berita_Acara_verifikasi_rps/{id}', [Berita_Ver_RPSController::class, 'update'])->middleware(['auth', 'verified'])->name('berita_ver_rps.update');
    });
});

/* ---Kepala Prodi end */

/* Dosen Pengampu Start*/
Route::group(['middleware' => ['role:dosenMatkul']], function () {
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
        /* Route::get('/dosen_matkul_notifikasi_uas/{dosen_matkul_id}/{matkul_kbk_id}', [DosenMatkulController::class, 'show_uas'])
            ->name('notifikasi_uas.show'); */
        Route::get('/dosen_matkul_notifikasi/{dosen_matkul_id}/{matkul_kbk_id}', [DosenMatkulController::class, 'show'])->name('notifikasi.show');
        Route::get('/dashboard_pengampu', [DosenMatkulController::class, 'dashboard_pengampu'])->middleware(['auth', 'verified'])->name('dashboard_pengampu');
        // Route::get('/api/prodi-data/{prodiId}', [ProdiController::class, 'getProdiData']);

    });
});

/* ---Dosen Pengampu End--- */


/* ---Dosen KBK Start--- */
Route::group(['middleware' => ['role:dosenKbk']], function () {
    // ReviewProposalTA
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard_dosenKbk', [dosen_kbkController::class, 'dashboard_dosenKbk'])->middleware(['auth', 'verified'])->name('dashboard_dosenKbk');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/review_proposal_ta', [ReviewProposalTAController::class, 'index'])->middleware(['auth', 'verified'])->name('review_proposal_ta');
        Route::post('/review_proposal_ta/store', [ReviewProposalTAController::class, 'store'])->middleware(['auth', 'verified'])->name('review_proposal_ta.store');
        Route::get('/review_proposal_ta/create/{id}/{dosen}', [ReviewProposalTAController::class, 'create'])->middleware(['auth', 'verified'])->name('review_proposal_ta.create');
        Route::get('/review_proposal_ta/edit/{id}/{dosen}', [ReviewProposalTAController::class, 'edit'])->middleware(['auth', 'verified'])->name('review_proposal_ta.edit');
        Route::put('/review_proposal_ta/update/{id}', [ReviewProposalTAController::class, 'update'])->middleware(['auth', 'verified'])->name('review_proposal_ta.update');
        Route::delete('/review_proposal_ta/delete/{id}/{dosen}', [ReviewProposalTAController::class, 'delete'])->middleware(['auth', 'verified'])->name('review_proposal_ta.delete');
        Route::get('/dosen_kbk_notifikasi/{id_penugasan}', [ReviewProposalTAController::class, 'show'])->name('dosen_kbk_notifikasi.show');
    });
});

/* ---Dosen KBK End--- */



/* ---Pengurus KBK Start--- */
Route::group(['middleware' => ['role:pengurusKbk']], function () {
    // Penugasan Reviewer Proposal TA
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard_pengurus', [PengurusKbkController::class, 'dashboard_pengurus'])->middleware(['auth', 'verified'])->name('dashboard_pengurus');
        Route::get('/grafik_rps_pengurus', [PengurusKbkController::class, 'grafik_rps'])->middleware(['auth', 'verified'])->name('grafik_rps_pengurus');
        Route::get('/grafik_uas_pengurus', [PengurusKbkController::class, 'grafik_uas'])->middleware(['auth', 'verified'])->name('grafik_uas_pengurus');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/PenugasanReview', [PenugasanReviewController::class, 'index'])->middleware(['auth', 'verified'])->name('PenugasanReview');
        Route::post('/PenugasanReview/store', [PenugasanReviewController::class, 'store'])->middleware(['auth', 'verified'])->name('PenugasanReview.store');
        Route::get('/PenugasanReview/create/{id}', [PenugasanReviewController::class, 'create'])->middleware(['auth', 'verified'])->name('PenugasanReview.create');
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

    // Verifikasi Berita Acara RPS
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/upload_rps_berita_acara', [VerBeritaAcaraRpsController::class, 'index'])->middleware(['auth', 'verified'])->name('upload_rps_berita_acara');
        Route::post('/upload_rps_berita_acara/store', [VerBeritaAcaraRpsController::class, 'store'])->middleware(['auth', 'verified'])->name('upload_rps_berita_acara.store');
        Route::get('/upload_rps_berita_acara/create', [VerBeritaAcaraRpsController::class, 'create'])->middleware(['auth', 'verified'])->name('upload_rps_berita_acara.create');
        Route::get('/upload_rps_berita_acara/edit/{id}', [VerBeritaAcaraRpsController::class, 'edit'])->middleware(['auth', 'verified'])->name('upload_rps_berita_acara.edit');
        Route::patch('/upload_rps_berita_acara/update/{beritaAcara}', [VerBeritaAcaraRpsController::class, 'update'])->middleware(['auth', 'verified'])->name('upload_rps_berita_acara.update');
        Route::get('/upload_rps_berita_acara/show/{id}', [VerBeritaAcaraRpsController::class, 'show'])->middleware(['auth', 'verified'])->name('upload_rps_berita_acara.show');
        Route::delete('/upload_rps_berita_acara/delete/{id}', [VerBeritaAcaraRpsController::class, 'delete'])->middleware(['auth', 'verified'])->name('upload_rps_berita_acara.delete');
        Route::get('/cetak_rps_berita_acara/download/pdf', [VerBeritaAcaraRpsController::class, 'download_pdf'])->middleware(['auth', 'verified'])->name('cetak_rps_berita_acara.download');
    });

    // Verifikasi Berita Acara Soal_UAS
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/upload_uas_berita_acara', [VerBeritaAcaraUasController::class, 'index'])->middleware(['auth', 'verified'])->name('upload_uas_berita_acara');
        Route::post('/upload_uas_berita_acara/store', [VerBeritaAcaraUasController::class, 'store'])->middleware(['auth', 'verified'])->name('upload_uas_berita_acara.store');
        Route::get('/upload_uas_berita_acara/create', [VerBeritaAcaraUasController::class, 'create'])->middleware(['auth', 'verified'])->name('upload_uas_berita_acara.create');
        Route::get('/upload_uas_berita_acara/edit/{id}', [VerBeritaAcaraUasController::class, 'edit'])->middleware(['auth', 'verified'])->name('upload_uas_berita_acara.edit');
        Route::patch('/upload_uas_berita_acara/update/{beritaAcara}', [VerBeritaAcaraUasController::class, 'update'])->middleware(['auth', 'verified'])->name('upload_uas_berita_acara.update');
        Route::get('/upload_uas_berita_acara/show/{id}', [VerBeritaAcaraUasController::class, 'show'])->middleware(['auth', 'verified'])->name('upload_uas_berita_acara.show');
        Route::delete('/upload_uas_berita_acara/delete/{id}', [VerBeritaAcaraUasController::class, 'delete'])->middleware(['auth', 'verified'])->name('upload_uas_berita_acara.delete');
        Route::get('/cetak_uas_berita_acara/download/pdf', [VerBeritaAcaraUasController::class, 'download_pdf'])->middleware(['auth', 'verified'])->name('cetak_uas_berita_acara.download');
    });
});

/* ---Penurus KBK End--- */



/* ---Kepala Jurusan Start--- */
Route::group(['middleware' => ['role:pimpinanJurusan']], function () {
    // Kepala Jurusan
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/repositori_rps_jurusan', [KajurController::class, 'RepRPSJurusan'])->middleware(['auth', 'verified'])->name('rep_rps_jurusan');
        Route::get('/repositori_soal_uas_jurusan', [KajurController::class, 'RepSoalUASJurusan'])->middleware(['auth', 'verified'])->name('rep_soal_uas_jurusan');
        Route::get('/repositori_proposal_ta_jurusan', [KajurController::class, 'RepProposalTAJurusan'])->middleware(['auth', 'verified'])->name('rep_proposal_ta_jurusan');
        Route::get('/grafik_rps', [KajurController::class, 'grafik_rps'])->middleware(['auth', 'verified'])->name('grafik_rps');
        Route::get('/grafik_uas', [KajurController::class, 'grafik_uas'])->middleware(['auth', 'verified'])->name('grafik_uas');
        Route::get('/grafik_proposal', [KajurController::class, 'grafik_proposal'])->middleware(['auth', 'verified'])->name('grafik_proposal');
        Route::get('/dashboard_pimpinan', [KajurController::class, 'dashboard_pimpinan'])->middleware(['auth', 'verified'])->name('dashboard_pimpinan');
    });

    // Berita Acara Verifikasi Soal_UAS Kajur
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/Kajur_Berita_Acara_soal_uas', [Berita_Ver_UAS_KajurController::class, 'index'])->middleware(['auth', 'verified'])->name('kajur_berita_ver_uas');
        Route::get('/Kajur_Berita_Acara_soal_uas/{id}', [Berita_Ver_UAS_KajurController::class, 'edit'])->middleware(['auth', 'verified'])->name('kajur_berita_ver_uas.edit');
        Route::put('/Kajur_Berita_Acara_soal_uas/{id}', [Berita_Ver_UAS_KajurController::class, 'update'])->middleware(['auth', 'verified'])->name('kajur_berita_ver_uas.update');
    });

    // Berita Acara Verifikasi RPS Kajur
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/Kajur_Berita_Acara_rps', [Berita_Ver_RPS_KajurController::class, 'index'])->middleware(['auth', 'verified'])->name('kajur_berita_ver_rps');
        Route::get('/Kajur_Berita_Acara_rps/{id}', [Berita_Ver_RPS_KajurController::class, 'edit'])->middleware(['auth', 'verified'])->name('kajur_berita_ver_rps.edit');
        Route::put('/Kajur_Berita_Acara_rps/{id}', [Berita_Ver_RPS_KajurController::class, 'update'])->middleware(['auth', 'verified'])->name('kajur_berita_ver_rps.update');
    });
});

/* ---Kepala Jurusan End--- */
