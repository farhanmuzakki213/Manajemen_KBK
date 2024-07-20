<?php

namespace App\Http\Controllers\PengurusKbk;

use App\Models\Prodi;
use App\Models\VerRpsUas;
use App\Models\Pengurus_kbk;
use Illuminate\Http\Request;
use App\Models\PimpinanProdi;
use App\Models\VerBeritaAcara;
use App\Models\PimpinanJurusan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\BeritaAcara\beritaAcaraCreate;
use App\Http\Requests\Auth\BeritaAcara\beritaAcaraUpdate;
use App\Models\ThnAkademik;
use App\Models\VerBeritaAcaraDetail;
use Carbon\Carbon;
use ZipArchive;

class VerBeritaAcaraUasController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengurusKbk-view BeritaAcaraUas', ['only' => ['index', 'getDosen']]);
        $this->middleware('permission:pengurusKbk-download BeritaAcaraUas', ['only' => ['download_pdf', 'getDosen']]);
        $this->middleware('permission:pengurusKbk-create BeritaAcaraUas', ['only' => ['create', 'store', 'getCariNomor', 'getDosen']]);
        $this->middleware('permission:pengurusKbk-update BeritaAcaraUas', ['only' => ['edit', 'update', 'getDosen']]);
        $this->middleware('permission:pengurusKbk-delete BeritaAcaraUas', ['only' => ['delete']]);
    }
    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $pengurus_kbk = Pengurus_kbk::whereHas('r_dosen', function ($query) use ($user, $user_email) {
            $query->where('nama_dosen', $user)
                ->where('email', $user_email);
        })->first();
        return $pengurus_kbk;
    }

    public function index(Request $request)
    {
        $pengurus_kbk = $this->getDosen();

        // Retrieve selected prodi ID from request
        $selectedProdiId = $request->input('prodi_id');

        // Get all Prodi for the dropdown
        $prodiList = Prodi::where('jurusan_id', 7)->get();

        // Filtered VerRpsUas data
        $data_ver_rps = VerRpsUas::with([
            'r_pengurus',
            'r_pengurus.r_dosen',
            'r_rep_rps_uas.r_dosen_matkul.r_dosen',
            'r_rep_rps_uas.r_smt_thnakd',
            'r_rep_rps_uas.r_matkulKbk.r_matkul',
            'p_HasilVerifUas'
        ])
            ->whereHas('r_rep_rps_uas', function ($query) use ($pengurus_kbk, $selectedProdiId) {
                $query->whereHas('r_matkulKbk', function ($nestedQuery) use ($pengurus_kbk, $selectedProdiId) {
                    $nestedQuery->where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id)
                        ->whereHas('r_matkul.r_kurikulum.r_prodi', function ($subnestedQuery) use ($selectedProdiId) {
                            if ($selectedProdiId) {
                                $subnestedQuery->where('prodi_id', $selectedProdiId); // Filter by prodi
                            }
                        });
                })

                    ->whereHas('r_smt_thnakd', function ($nestedQuery) {
                        $nestedQuery->where('status_smt_thnakd', '=', '1');
                    })
                    ->where('type', '=', '1'); // Filter by type here
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();
        debug($data_ver_rps->toArray());
        $data_berita_acara = VerBeritaAcara::whereHas('p_ver_rps_uas.r_rep_rps_uas.r_matkulKbk', function ($query) use ($pengurus_kbk) {
            $query->where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id);
        })
            ->with([
                'p_ver_rps_uas.r_rep_rps_uas.r_matkulKbk.r_matkul',
                'p_ver_rps_uas.r_pengurus.r_dosen',
                'r_pimpinan_prodi.r_prodi',
                'r_pimpinan_jurusan.r_jurusan',
                'r_jenis_kbk',
            ])
            ->where('type', '=', '1')
            ->get();
        foreach ($data_ver_rps as $data) {
            $dataVerUas = [
                'p_HasilVerifUas' => $data->toArray(),
                'pengurus_kbk' => $pengurus_kbk->toArray(),
            ];
        }
        debug($dataVerUas);
        debug($data_berita_acara->toArray());
        return view('admin.content.pengurusKbk.VerBeritaAcaraUas', compact('data_ver_rps', 'data_berita_acara', 'prodiList', 'selectedProdiId'));
    }


    public function download_pdf(Request $request)
    {
        $pengurus_kbk = $this->getDosen();
        $prodiList = Prodi::where('jurusan_id', $pengurus_kbk->r_dosen->jurusan_id)->get();

        $selectedProdiId = $request->input('prodi_id');

        if (!$selectedProdiId) {
            return redirect()->route('upload_uas_berita_acara')->with('error', 'Silahkan pilih prodi yang ingin di cetak');
        }

        $selectedProdi = Prodi::find($selectedProdiId);
        $kajur = PimpinanJurusan::where('jurusan_id', $pengurus_kbk->r_dosen->jurusan_id)->first();
        $kaprodi = PimpinanProdi::where('prodi_id', $selectedProdiId)->first();

        $semester = ThnAkademik::where('status_smt_thnakd', '=', '1')->first();

        DB::beginTransaction();
        try {
            $data_ver_rps = VerRpsUas::with([
                'r_pengurus',
                'r_pengurus.r_dosen',
                'r_rep_rps_uas.r_dosen_matkul.r_dosen',
                'r_rep_rps_uas.r_smt_thnakd',
                'r_rep_rps_uas.r_matkulKbk.r_matkul',
                'p_HasilVerifUas'
            ])
                ->whereHas('r_rep_rps_uas', function ($query) use ($pengurus_kbk, $selectedProdiId) {
                    $query->whereHas('r_matkulKbk', function ($nestedQuery) use ($pengurus_kbk) {
                        $nestedQuery->where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id);
                    })
                        ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($selectedProdiId) {
                            $query->where('prodi_id', '=', $selectedProdiId);
                        })
                        ->whereHas('r_smt_thnakd', function ($nestedQuery) {
                            $nestedQuery->where('status_smt_thnakd', '=', '1');
                        })
                        ->where('type', '=', '1');
                })
                ->orderByDesc('id_ver_rps_uas')
                ->get();

            if ($data_ver_rps->isEmpty()) {
                return redirect()->route('upload_uas_berita_acara')->with('error', 'Data verifikasi uas pada prodi ini tidak ada');
            }

            // Mengambil semua id_ver_rps_uas
            $ver_rps_uas_ids = $data_ver_rps->pluck('id_ver_rps_uas')->toArray();

            // Memeriksa apakah ada id_ver_rps_uas yang sudah ada di VerBeritaAcaraDetail
            $existing_ver_rps_uas_ids = VerBeritaAcaraDetail::whereIn('ver_rps_uas_id', $ver_rps_uas_ids)->pluck('ver_rps_uas_id')->toArray();

            // Filter hanya id_ver_rps_uas yang belum ada di VerBeritaAcaraDetail
            $ver_rps_uas_to_process = array_diff($ver_rps_uas_ids, $existing_ver_rps_uas_ids);

            if (empty($ver_rps_uas_to_process)) {
                return redirect()->route('upload_uas_berita_acara')->with('error', 'Semua data verifikasi RPS pada prodi ini sudah diproses');
            }

            $verBeritaAcara = VerBeritaAcara::create([
                'kajur' => $kajur->id_pimpinan_jurusan,
                'kaprodi' => $kaprodi->id_pimpinan_prodi,
                'jenis_kbk_id' => $pengurus_kbk->jenis_kbk_id,
                'type' => '1',
                'tanggal_upload' => Carbon::now(),
            ]);
            //dd($verBeritaAcara);
            foreach ($ver_rps_uas_to_process as $ver_rps_uas_id) {
                $verBeritaAcara->p_ver_rps_uas()->attach($ver_rps_uas_id);
            }
            DB::commit();
        } catch (\Throwable) {
            DB::rollback();
            return redirect()->route('upload_uas_berita_acara')->with('error', 'Berita Acara Gagal di Upload.');
        }
        $dataBeritaAcara = [
            'data_ver_rps' => $data_ver_rps,
            'selectedProdi' => $selectedProdi,
            'prodiList' => $prodiList,
            'kaprodi' => $kaprodi,
            'semester' => $semester,
            'kajur' => $kajur,
            'pengurus_kbk' => $pengurus_kbk,
        ];

        // Buat PDF pertama
        $pdf1 = Pdf::loadView('admin.content.pengurusKbk.pdf.berita_acara_uas', $dataBeritaAcara);
        $pdf1->setPaper('A4', 'potrait');
        $pdf1Path = storage_path('app/public/Berita_Acara_UAS.pdf');
        $pdf1->save($pdf1Path);

        // Buat file ZIP
        $zip = new ZipArchive;
        $zipFileName = 'BeritaAcara&VerifSoalUjian.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($pdf1Path, 'Berita_Acara_UAS.pdf');

            // Buat PDF kedua dan seterusnya
            $i = 1;
            foreach ($data_ver_rps as $data) {
                $dataVerUas = [
                    'p_HasilVerifUas' => $data,
                    'selectedProdi' => $selectedProdi,
                    'prodiList' => $prodiList,
                    'kaprodi' => $kaprodi,
                    'semester' => $semester,
                    'kajur' => $kajur,
                    'pengurus_kbk' => $pengurus_kbk,
                ];

                $pdfPath = storage_path('app/public/Verif_Soal_UAS_' . $i . '.pdf');
                $pdf = Pdf::loadView('admin.content.pengurusKbk.pdf.verif_soal_uas', $dataVerUas);
                $pdf->save($pdfPath);

                $zip->addFile($pdfPath, 'Verif_Soal_UAS_' . $i . '.pdf');
                $i++;
            }

            $zip->close();

            // Hapus file PDF sementara setelah menambahkan ke ZIP
            unlink($pdf1Path);
            for ($j = 1; $j < $i; $j++) {
                unlink(storage_path('app/public/Verif_Soal_UAS_' . $j . '.pdf'));
            }

            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Could not create zip file'], 500);
        }
        // return $pdf->stream('Berita_Acara_UAS.pdf');
        // return $pdf->stream('Verif_Soal_UAS.pdf');
    }

    public function edit(string $id)
    {
        $data_berita_acara = VerBeritaAcara::find($id);
        return view('admin.content.pengurusKbk.form.ver_uas_berita_acara_edit', compact('data_berita_acara'));
    }

    public function update(beritaAcaraUpdate $request, VerBeritaAcara $beritaAcara)
    {
        DB::beginTransaction();
        try {
            // Handle file upload
            if ($request->hasFile('file_berita_acara')) {
                // Hapus file lama jika ada
                if ($beritaAcara->file_berita_acara) {
                    Storage::delete('public/uploads/rps/berita_acara/' . $beritaAcara->file_berita_acara);
                }

                // Simpan file baru
                $file = $request->file('file_berita_acara');
                $filename = $file->getClientOriginalName();
                $path = 'public/uploads/rps/berita_acara/';
                $file->storeAs($path, $filename);

                $beritaAcara->update([
                    'id_berita_acara' => $request->id_berita_acara,
                    'tanggal_upload' => $request->tanggal_upload,
                    'file_berita_acara' => $filename
                ]);
                if ($request->status_kaprodi == '2') {
                    $beritaAcara->update([
                        'Status_dari_kaprodi' => '3',
                        'tanggal_disetujui_kaprodi' => $request->tanggal_upload,
                    ]);
                }
                if ($request->status_kajur == '2') {
                    $beritaAcara->update([
                        'Status_dari_kajur' => '1',
                        'tanggal_diketahui_kajur' => $request->tanggal_upload,
                    ]);
                }
                if ($request->status_kaprodi == '1') {
                    $beritaAcara->update([
                        'Status_dari_kaprodi' => '0',
                        'tanggal_disetujui_kaprodi' => null,
                    ]);
                }
                if ($request->status_kajur == '1') {
                    $beritaAcara->update([
                        'Status_dari_kajur' => '0',
                        'tanggal_diketahui_kajur' => null,
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable) {
            DB::rollback();
            return redirect()->route('upload_uas_berita_acara')->with('error', 'Berita Acara Gagal di Update.');
        }

        return redirect()->route('upload_uas_berita_acara')->with('success', 'Berita Acara Berhasil di Update.');
    }


    public function delete(string $id)
    {

        $data_berita_acara_rps = VerBeritaAcara::where('id_berita_acara', $id)->first();

        if (!is_null($data_berita_acara_rps->file_berita_acara)) {
            Storage::delete('public/uploads/uas/berita_acara/' . $data_berita_acara_rps->file_berita_acara);
        }

        // Menghapus data dari basis data jika ada
        if ($data_berita_acara_rps) {
            $data_berita_acara_rps->delete();
        }

        return redirect()->route('upload_uas_berita_acara')->with('success', 'Data berhasil dihapus.');


        //dd($data_matkul);
    }
}
