<?php

namespace App\Http\Controllers\PengurusKbk;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\BeritaAcara\beritaAcaraCreate;
use App\Http\Requests\Auth\BeritaAcara\beritaAcaraUpdate;
use App\Models\Pengurus_kbk;
use App\Models\PimpinanJurusan;
use App\Models\PimpinanProdi;
use App\Models\VerBeritaAcara;
use App\Models\VerRpsUas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VerBeritaAcaraUasController extends Controller
{
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

    public function index()
    {
        $pengurus_kbk = $this->getDosen();
        debug($pengurus_kbk->toArray());
        $data_ver_rps = VerRpsUas::with([
            'r_pengurus',
            'r_pengurus.r_dosen',
            'r_rep_rps_uas',
            'r_rep_rps_uas.r_smt_thnakd',
            'r_rep_rps_uas.r_matkulKbk'
        ])
            ->where(function ($query) use ($pengurus_kbk) {
                $query->whereHas('r_rep_rps_uas', function ($subQuery) use ($pengurus_kbk) {
                    $subQuery->whereHas('r_matkulKbk', function ($nestedQuery) use ($pengurus_kbk) {
                        $nestedQuery->where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id);
                    })
                        ->whereHas('r_smt_thnakd', function ($nestedQuery) {
                            $nestedQuery->where('status_smt_thnakd', '=', '1');
                        })
                        ->where('type', '=', '1');
                });
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();

        debug($data_ver_rps);
        $data_berita_acara = VerBeritaAcara::whereHas('p_ver_rps_uas', function ($query) use ($pengurus_kbk) {
            $query->where('pengurus_id', $pengurus_kbk->id_pengurus);
        })->with([
            'p_ver_rps_uas.r_rep_rps_uas.r_matkulKbk.r_matkul',
            'p_ver_rps_uas.r_pengurus.r_dosen',
            'r_pimpinan_prodi.r_prodi',
            'r_pimpinan_jurusan.r_jurusan',
            'r_jenis_kbk',
        ])
            ->where('type', '=', '1')
            ->get();

        debug($data_berita_acara->toArray());
        return view('admin.content.pengurusKbk.VerBeritaAcaraUas', compact('data_ver_rps', 'data_berita_acara'));
    }
    public function create()
    {
        $pengurus_kbk = $this->getDosen();
        debug($pengurus_kbk->toArray());
        $nextNumber = $this->getCariNomor();
        $data_ver_rps = VerRpsUas::with([
            'r_pengurus',
            'r_pengurus.r_dosen',
            'r_rep_rps_uas',
            'r_rep_rps_uas.r_dosen_matkul.p_kelas',
            'r_rep_rps_uas.r_smt_thnakd',
            'r_rep_rps_uas.r_matkulKbk.r_matkul'
        ])
            ->where(function ($query) use ($pengurus_kbk) {
                $query->whereHas('r_rep_rps_uas', function ($subQuery) use ($pengurus_kbk) {
                    $subQuery->whereHas('r_matkulKbk', function ($nestedQuery) use ($pengurus_kbk) {
                        $nestedQuery->where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id);
                    })
                        ->whereHas('r_smt_thnakd', function ($nestedQuery) {
                            $nestedQuery->where('status_smt_thnakd', '=', '1');
                        })
                        ->where('type', '=', '1');
                });
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get()
            ->map(function ($item) {
                return [
                    'kode_matkul' => $item->r_rep_rps_uas->r_matkulKbk->r_matkul->kode_matkul,
                    'nama_matkul' => $item->r_rep_rps_uas->r_matkulKbk->r_matkul->nama_matkul,
                    'prodi_id' => optional(optional(optional($item->r_rep_rps_uas)->r_dosen_matkul)->p_kelas->first())->prodi_id,
                    'jurusan_id' => optional(optional(optional($item->r_rep_rps_uas)->r_dosen_matkul)->p_kelas->first())->r_prodi->jurusan_id,
                    'id_ver_rps_uas' => $item->id_ver_rps_uas,
                ];
            });
        $prodiId = isset($data_ver_rps[0]['prodi_id']) ? $data_ver_rps[0]['prodi_id'] : null;
        $jurusanId = isset($data_ver_rps[0]['jurusan_id']) ? $data_ver_rps[0]['jurusan_id'] : null;

        $kajur = PimpinanJurusan::where('jurusan_id', $jurusanId)->pluck('id_pimpinan_jurusan')->first();
        $kaprodi = PimpinanProdi::where('prodi_id', $prodiId)->pluck('id_pimpinan_prodi')->first();


        debug($data_ver_rps->toArray(), $kajur, $kaprodi);
        return view('admin.content.pengurusKbk.form.ver_uas_berita_acara_form', compact('data_ver_rps', 'pengurus_kbk', 'nextNumber', 'kajur', 'kaprodi'));
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_berita_acara = VerBeritaAcara::pluck('id_berita_acara')->toArray();

        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_berita_acara)) {
                return $i;
                break;
            }
        }
        return $i;
    }

    public function store(beritaAcaraCreate $request)
    {
        DB::beginTransaction();
        try {
            if ($request->hasFile('file_berita_acara')) {
                $file = $request->file('file_berita_acara');
                $filename = $file->getClientOriginalName();
                $path = 'public/uploads/uas/berita_acara/';
                $file->storeAs($path, $filename);

                $verBeritaAcara = VerBeritaAcara::create([
                    'id_berita_acara' => $request->id_berita_acara,
                    'kajur' => $request->kajur,
                    'kaprodi' => $request->prodi,
                    'jenis_kbk_id' => $request->jenis_kbk_id,
                    'type' => $request->type,
                    'file_berita_acara' => $filename,
                    'tanggal_upload' => $request->tanggal_upload,
                ]);

                foreach ($request->ver_rps_uas_ids as $ver_rps_uas_id) {
                    $verBeritaAcara->p_ver_rps_uas()->attach($ver_rps_uas_id);
                }
            } else {
                return redirect()->back()->withInput()->withErrors(['file_berita_acara' => 'File harus diunggah.']);
            }

            DB::commit();
        } catch (\Throwable) {
            DB::rollback();
            return redirect()->route('upload_uas_berita_acara')->with('error', 'Berita Acara Gagal di Upload.');
        }
        return redirect()->route('upload_uas_berita_acara')->with('success', 'Berita Acara Berhasil di Upload.');
    }

    public function edit(string $id)
    {
        $pengurus_kbk = $this->getDosen();
        debug($pengurus_kbk->toArray());
        $data_berita_acara = VerBeritaAcara::find($id);
        debug($data_berita_acara->toArray());
        $data_matkul = VerRpsUas::with([
            'r_pengurus',
            'r_pengurus.r_dosen',
            'r_rep_rps_uas',
            'r_rep_rps_uas.r_dosen_matkul.p_kelas',
            'r_rep_rps_uas.r_smt_thnakd',
            'r_rep_rps_uas.r_matkulKbk.r_matkul'
        ])
            ->where(function ($query) use ($pengurus_kbk) {
                $query->whereHas('r_rep_rps_uas', function ($subQuery) use ($pengurus_kbk) {
                    $subQuery->whereHas('r_matkulKbk', function ($nestedQuery) use ($pengurus_kbk) {
                        $nestedQuery->where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id);
                    })
                        ->whereHas('r_smt_thnakd', function ($nestedQuery) {
                            $nestedQuery->where('status_smt_thnakd', '=', '1');
                        })
                        ->where('type', '=', '1');
                });
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get()
            ->map(function ($item) {
                return [
                    'kode_matkul' => $item->r_rep_rps_uas->r_matkulKbk->r_matkul->kode_matkul,
                    'nama_matkul' => $item->r_rep_rps_uas->r_matkulKbk->r_matkul->nama_matkul,
                    'prodi_id' => optional(optional(optional($item->r_rep_rps_uas)->r_dosen_matkul)->p_kelas->first())->prodi_id,
                    'jurusan_id' => optional(optional(optional($item->r_rep_rps_uas)->r_dosen_matkul)->p_kelas->first())->r_prodi->jurusan_id,
                    'id_ver_rps_uas' => $item->id_ver_rps_uas,
                ];
            });
        debug($data_matkul->toArray());
        return view('admin.content.pengurusKbk.form.ver_uas_berita_acara_edit', compact('data_matkul', 'data_berita_acara'));
    }

    public function update(beritaAcaraUpdate $request, VerBeritaAcara $beritaAcara)
    {
        DB::beginTransaction();
        try {
            // Update data utama VerBeritaAcara
            $beritaAcara->update([
                'id_berita_acara' => $request->id_berita_acara,
                'tanggal_upload' => $request->tanggal_upload,
            ]);

            // Update hubungan many-to-many dengan ver_rps_uas_ids
            $beritaAcara->p_ver_rps_uas()->sync($request->ver_rps_uas_ids);

            // Handle file upload
            if ($request->hasFile('file_berita_acara')) {
                // Hapus file lama jika ada
                if ($beritaAcara->file_berita_acara) {
                    Storage::delete('public/uploads/uas/berita_acara/' . $beritaAcara->file_berita_acara);
                }

                // Simpan file baru
                $file = $request->file('file_berita_acara');
                $filename = $file->getClientOriginalName();
                $path = 'public/uploads/uas/berita_acara/';
                $file->storeAs($path, $filename);

                // Update nama file di database
                $beritaAcara->update(['file_berita_acara' => $filename]);
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

        // Menghapus file terkait jika ada
        if ($data_berita_acara_rps && $data_berita_acara_rps->file_berita_acara) {
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