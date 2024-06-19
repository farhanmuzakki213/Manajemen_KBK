<?php

namespace App\Http\Controllers\PengurusKbk;

use App\Models\Dosen;
use App\Models\Ver_UAS;
use App\Models\RepRpsUas;
use App\Models\VerRpsUas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DosenPengampuMatkul;
use App\Models\Pengurus_kbk;
use App\Models\User;
use App\Notifications\VerifikasiUas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class Ver_Soal_UASController extends Controller
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengurus_kbk = $this->getDosen();
        debug($pengurus_kbk);
        $data_ver_uas = VerRpsUas::with([
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
        debug($data_ver_uas);
        $data_matkul_kbk = DosenPengampuMatkul::with([
            'p_matkulKbk.r_matkul', 'p_kelas', 'r_dosen', 'r_smt_thnakd', 'p_matkulKbk'
        ])
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1');
            })
            ->whereHas('p_matkulKbk', function ($query) use ($pengurus_kbk) {
                $query->where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id);
            })
            ->orderByDesc('id_dosen_matkul')
            ->get();
        /* debug($data_matkul_kbk); */
        $data_array = $data_matkul_kbk->flatMap(function ($item) use ($pengurus_kbk) {
            if ($item->p_matkulKbk->where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id)->first()) {
                return $item->p_matkulKbk->where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id)->map(function ($matkulKbk) use ($item) {
                    return [
                        'nama_dosen' => $item->r_dosen->nama_dosen,
                        'smt_thnakd' => $item->r_smt_thnakd->smt_thnakd,
                        'kode_matkul' => optional($matkulKbk->r_matkul)->kode_matkul,
                        'semester' => optional($matkulKbk->r_matkul)->semester,
                    ];
                });
            } else {
                return [];
            }
        })->toArray();

        /* debug($data_array); */
        $data_rep_uas = RepRpsUas::with('r_dosen_matkul', 'r_dosen_matkul.r_dosen', 'r_matkulKbk', 'r_smt_thnakd')
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1');
            })
            ->whereHas('r_matkulKbk', function ($query) use ($pengurus_kbk) {
                $query->where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id);
            })
            ->where('type', '=', '1')
            ->orderByDesc('id_rep_rps_uas')
            ->get();
        /* debug($data_rep_uas); */
        $data_array_formatted = collect($data_array)->map(function ($item) {
            return [
                'nama_dosen' => $item['nama_dosen'],
                'smt_thnakd' => $item['smt_thnakd'],
                'kode_matkul' => $item['kode_matkul'],
                'semester' => $item['semester'],
            ];
        });
        $data_array_gabungan = $data_array_formatted->map(function ($item) use ($data_rep_uas) {
            $matched_data = $data_rep_uas->first(function ($data_rep_uas_item) use ($item) {
                return $item['nama_dosen'] == optional($data_rep_uas_item->r_dosen_matkul)->r_dosen->nama_dosen
                    && $item['smt_thnakd'] == optional($data_rep_uas_item->r_smt_thnakd)->smt_thnakd
                    && $item['kode_matkul'] == optional(optional($data_rep_uas_item->r_matkulKbk)->r_matkul)->kode_matkul
                    && $item['semester'] == optional(optional($data_rep_uas_item->r_matkulKbk)->r_matkul)->semester;
            });
            return [
                'nama_dosen' => $item['nama_dosen'],
                'kode_matkul' => $item['kode_matkul'],
                'smt_thnakd' => $item['smt_thnakd'],
                'semester' => $item['semester'],
                'id_rep_rps_uas' => $matched_data ? $matched_data->id_rep_rps_uas : null,
                'file' => $matched_data ? $matched_data->file : null,
            ];
        });
        $result = $data_array_gabungan->toArray();
        debug($result);
        return view('admin.content.pengurusKbk.Ver_Soal_UAS', compact('result', 'data_ver_uas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        // Cek apakah rep_rps_id sudah ada di tabel ver_rps
        $cek_data = VerRpsUas::where('rep_rps_uas_id', $id)->first();

        if ($cek_data) {
            // Jika sudah ada, kembalikan ke halaman verifikasi_rps dengan pesan error
            return redirect()->route('ver_soal_uas')->with('error', 'Data sudah diambil.');
        }

        $pengurus_kbk = $this->getDosen();
        debug($pengurus_kbk);
        $nextNumber = $this->getCariNomor();
        $data_dosen = $pengurus_kbk->id_pengurus;
        $rep_id = $id;
        $data_rep_soal_uas = RepRpsUas::where('type', '=', '1')
            ->orderByDesc('id_rep_rps_uas')
            ->get();
        debug(compact('data_dosen', 'data_rep_soal_uas', 'nextNumber'));
        return view('admin.content.pengurusKbk.form.ver_soal_uas_form', compact('data_dosen', 'data_rep_soal_uas', 'nextNumber', 'rep_id'));
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_ver_uas = VerRpsUas::pluck('id_ver_rps_uas')->toArray();

        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_ver_uas)) {
                return $i;
                break;
            }
        }
        return $i;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_ver_uas' => 'required',
            'id_rep_uas' => 'required',
            'id_pengurus_kbk' => 'required',
            'rekomendasi' => 'required',
            'saran' => 'nullable',
            'date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = [
            'id_ver_rps_uas' => $request->id_ver_uas,
            'rep_rps_uas_id' => $request->id_rep_uas,
            'pengurus_id' => $request->id_pengurus_kbk,
            'rekomendasi' => $request->rekomendasi,
            'saran' => $request->filled('saran') ? $request->saran : 'Tidak ada',
            'tanggal_diverifikasi' => $request->date,
        ];
        DB::beginTransaction();
        try{
            VerRpsUas::create($data);
            $repRpsUas = RepRpsUas::with('r_dosen_matkul.r_dosen', 'r_dosen_matkul.p_matkulKbk')->where('id_rep_rps_uas', $request->id_rep_uas)->first();
            $verRpsUas = VerRpsUas::with('r_pengurus.r_dosen')->where('id_ver_rps_uas', $request->id_ver_uas)->first();
            $dosenMatkul = User::where('name', $repRpsUas->r_dosen_matkul->r_dosen->nama_dosen)
            ->where('email', $repRpsUas->r_dosen_matkul->r_dosen->email)->first();

            if ($dosenMatkul) {
                Notification::send($dosenMatkul, new VerifikasiUas($repRpsUas, $verRpsUas));
            }
            DB::commit();
        } catch (\Throwable){
            DB::rollback();
            return redirect()->route('ver_soal_uas')->with('error', 'Gagal menyimpan data verifikasi.');
        }
        debug(compact('dosenMatkul', 'verRpsUas', 'repRpsUas'));
        return redirect()->route('ver_soal_uas')->with('success', 'Data berhasil disimpan.');
        //dd($request->all());
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_ver_soal_uas = VerRpsUas::where('id_ver_rps_uas', $id)->first();
            debug(compact( 'data_ver_soal_uas'));
        return view('admin.content.pengurusKbk.form.ver_soal_uas_edit', compact('data_ver_soal_uas'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_ver_uas' => 'required',
            'rep_rps_uas_id' => 'required',
            'rekomendasi' => 'required',
            'saran' => 'nullable',
            'date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data = [
            'id_ver_rps_uas' => $request->id_ver_uas,
            'rep_rps_uas_id' => $request->rep_rps_uas_id,
            'rekomendasi' => $request->rekomendasi,
            'saran' => $request->filled('saran') ? $request->saran : 'Tidak ada',
            'tanggal_diverifikasi' => $request->date,
        ];
        DB::beginTransaction();
        try{
            VerRpsUas::where('id_ver_rps_uas', $id)->update($data);
            $repRpsUas = RepRpsUas::with('r_dosen_matkul.r_dosen', 'r_dosen_matkul.p_matkulKbk')->where('id_rep_rps_uas', $request->rep_rps_uas_id)->first();
            $verRpsUas = VerRpsUas::with('r_pengurus.r_dosen')->where('id_ver_rps_uas', $request->id_ver_uas)->first();
            $dosenMatkul = User::where('name', $repRpsUas->r_dosen_matkul->r_dosen->nama_dosen)
            ->where('email', $repRpsUas->r_dosen_matkul->r_dosen->email)->first();

            if ($dosenMatkul) {
                Notification::send($dosenMatkul, new VerifikasiUas($repRpsUas, $verRpsUas));
            }
            DB::commit();
        } catch (\Throwable){
            DB::rollback();
            return redirect()->route('ver_soal_uas')->with('error', 'Gagal menyimpan data verifikasi.');
        }

        return redirect()->route('ver_soal_uas')->with('success', 'Data berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_ver_soal_uas = VerRpsUas::where('id_ver_rps_uas', $id)->first();

        // Menghapus file terkait jika ada
        if ($data_ver_soal_uas && $data_ver_soal_uas->file_verifikasi) {
            Storage::delete('public/uploads/uas/ver_files/' . $data_ver_soal_uas->file_verifikasi);
        }

        // Menghapus data dari basis data jika ada
        if ($data_ver_soal_uas) {
            $data_ver_soal_uas->delete();
        }

        return redirect()->route('ver_soal_uas')->with('success', 'Data berhasil dihapus.');


        //dd($data_matkul);
    }
}
