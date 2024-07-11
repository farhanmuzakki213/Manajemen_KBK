<?php

namespace App\Http\Controllers\DosenPengampu;

use App\Http\Controllers\Controller;
use App\Models\DosenPengampuMatkul;
use App\Models\Matkul;
use App\Models\MatkulKBK;
use App\Models\RepRpsUas;
use App\Models\VerRpsUas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DosenMatkulController extends Controller
{
    public function __construct() {
        $this->middleware('permission:dosenMatkul-dashboard', ['only' => ['dashboard_pengampu', 'getDosen']]);
        $this->middleware('permission:dosenMatkul-view DosenMatkul', ['only' => ['index', 'getDosen']]);
        $this->middleware('permission:dosenMatkul-create RepRps', ['only' => ['create_rps', 'store_rps', 'getCariNomor', 'getDosen']]);
        $this->middleware('permission:dosenMatkul-update RepRps', ['only' => ['edit_rps', 'update_rps']]);
        $this->middleware('permission:dosenMatkul-delete RepRps', ['only' => ['delete_rps']]);
        $this->middleware('permission:dosenMatkul-create RepUas', ['only' => ['create_uas', 'store_uas', 'getCariNomor', 'getDosen']]);
        $this->middleware('permission:dosenMatkul-update RepUas', ['only' => ['edit_uas', 'update_uas']]);
        $this->middleware('permission:dosenMatkul-delete RepUas', ['only' => ['delete_uas']]);
    }
    /**
     * Display a listing of the resource.
     */
    /* Daftar Matakuliah */

    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $dosen_pengampu = DosenPengampuMatkul::whereHas('r_dosen', function ($query) use ($user, $user_email) {
            $query->where('nama_dosen', $user)
                ->where('email', $user_email);
        })->first();
        return $dosen_pengampu;
    }

    public function index()
    {
        $dosen_pengampu = $this->getDosen();
        $data_matkul = $dosen_pengampu ? $dosen_pengampu->p_matkulKbk->unique('id_matkul_kbk')->pluck('r_matkul.nama_matkul', 'id_matkul_kbk') : collect();
        debug($data_matkul);
        //dd($data_matkul);
        $data_uas = RepRpsUas::with('r_dosen_matkul', 'r_matkulKbk', 'r_smt_thnakd')
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1');
            })
            ->whereHas('r_dosen_matkul', function ($query) use ($dosen_pengampu) {
                $query->where('dosen_id', $dosen_pengampu->dosen_id);
            })
            ->where('type', '=', '1')
            ->orderByDesc('id_rep_rps_uas')
            ->get();
        debug($data_uas);

        $data_rps = RepRpsUas::with('r_dosen_matkul', 'r_matkulKbk', 'r_smt_thnakd')
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1');
            })
            ->whereHas('r_dosen_matkul', function ($query) use ($dosen_pengampu) {
                $query->where('dosen_id', $dosen_pengampu->dosen_id);
            })
            ->where('type', '=', '0')
            ->orderByDesc('id_rep_rps_uas')
            ->get();
        debug($data_rps);
        return view('admin.content.dosenPengampu.dosen_matkul', compact('data_matkul', 'dosen_pengampu', 'data_uas', 'data_rps'));
    }




    public function dashboard_pengampu()
    {
        $dosen_pengampu = $this->getDosen();
        if (!$dosen_pengampu) {
            return redirect()->route('dashboard_pengampu')->withErrors('Dosen pengampu tidak ditemukan.');
        }
    
        $data_matkul = $dosen_pengampu->p_matkulKbk->unique('id_matkul_kbk')->pluck('r_matkul.nama_matkul', 'id_matkul_kbk');
    
        // Count RPS uploads
        $banyak_pengunggahan_rps = RepRpsUas::where('type', '=', '0')
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '1');
            })
            ->whereHas('r_dosen_matkul', function ($query) use ($dosen_pengampu) {
                $query->where('dosen_id', $dosen_pengampu->dosen_id);
            })
            ->count();
    
        // Count RPS verifications
        $banyak_verifikasi_rps = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($dosen_pengampu) {
            $query->where('type', '=', '0')
                ->whereHas('r_dosen_matkul', function ($query) use ($dosen_pengampu) {
                    $query->where('dosen_id', $dosen_pengampu->dosen_id);
                });
        })
            ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '1');
            })
            ->count();
    
        // Count UAS uploads
        $banyak_pengunggahan_uas = RepRpsUas::where('type', '=', '1')
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '1');
            })
            ->whereHas('r_dosen_matkul', function ($query) use ($dosen_pengampu) {
                $query->where('dosen_id', $dosen_pengampu->dosen_id);
            })
            ->count();
    
        // Count UAS verifications
        $banyak_verifikasi_uas = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($dosen_pengampu) {
            $query->where('type', '=', '1')
                ->whereHas('r_dosen_matkul', function ($query) use ($dosen_pengampu) {
                    $query->where('dosen_id', $dosen_pengampu->dosen_id);
                });
        })
            ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '1');
            })
            ->count();
    
        // Calculate percentages
        $total_rps = $banyak_pengunggahan_rps + $banyak_verifikasi_rps;
        $percentUploadedRPS = $total_rps > 0 ? ($banyak_pengunggahan_rps / $total_rps) * 100 : 0;
        $percentVerifiedRPS = $total_rps > 0 ? ($banyak_verifikasi_rps / $total_rps) * 100 : 0;
        // $percentVerifiedRPS = $banyak_pengunggahan_rps > 0 ? ($banyak_verifikasi_rps / $banyak_pengunggahan_rps) * 100 : 0;
        // $percentUploadedRPS = 100 - $percentVerifiedRPS;
    
        $total_uas = $banyak_pengunggahan_uas + $banyak_verifikasi_uas;
        $percentUploadedUAS = $total_uas > 0 ? ($banyak_pengunggahan_uas / $total_uas) * 100 : 0;
        $percentVerifiedUAS = $total_uas > 0 ? ($banyak_verifikasi_uas / $total_uas) * 100 : 0;
        // $percentVerifiedUAS = $banyak_pengunggahan_uas > 0 ? ($banyak_verifikasi_uas / $banyak_pengunggahan_uas) * 100 : 0;
        // $percentUploadedUAS = 100 - $percentVerifiedUAS;
        
        debug($banyak_pengunggahan_rps);
        debug($percentVerifiedRPS);
        debug($percentUploadedRPS);
        return view('admin.content.dosenPengampu.dashboard_pengampu', compact(
            'data_matkul',
            'dosen_pengampu',
            'percentUploadedRPS', 'percentVerifiedRPS',
            'percentUploadedUAS', 'percentVerifiedUAS',
            'banyak_pengunggahan_rps', 'banyak_verifikasi_rps',
            'banyak_pengunggahan_uas', 'banyak_verifikasi_uas'
        ));
    }
    



    //     public function dashboard()
    // {
    //     $dosen_pengampu = $this->getDosen();
    //     if (!$dosen_pengampu) {
    //         return redirect()->route('dashboard_pengampu')->withErrors('Dosen pengampu tidak ditemukan.');
    //     }

    //     $data_matkul = $dosen_pengampu->p_matkulKbk->unique('id_matkul_kbk')->pluck('r_matkul.nama_matkul', 'id_matkul_kbk');

    //     // Count RPS uploads
    //     $banyak_pengunggahan_rps = RepRpsUas::where('type', 0)
    //         ->whereHas('r_smt_thnakd', function ($query) {
    //             $query->where('status_smt_thnakd', '1');
    //         })
    //         ->whereHas('r_dosen_matkul', function ($query) use ($dosen_pengampu) {
    //             $query->where('dosen_id', $dosen_pengampu->dosen_id);
    //         })
    //         ->count();

    //     // Count RPS verifications
    //     $banyak_verifikasi_rps = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($dosen_pengampu) {
    //         $query->where('type', 0)
    //             ->whereHas('r_dosen_matkul', function ($query) use ($dosen_pengampu) {
    //                 $query->where('dosen_id', $dosen_pengampu->dosen_id);
    //             });
    //     })
    //     ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
    //         $query->where('status_smt_thnakd', '1');
    //     })
    //     ->count();

    //     // Count UAS uploads
    //     $banyak_pengunggahan_uas = RepRpsUas::where('type', 1)
    //         ->whereHas('r_smt_thnakd', function ($query) {
    //             $query->where('status_smt_thnakd', '1');
    //         })
    //         ->whereHas('r_dosen_matkul', function ($query) use ($dosen_pengampu) {
    //             $query->where('dosen_id', $dosen_pengampu->dosen_id);
    //         })
    //         ->count();

    //     // Count UAS verifications
    //     $banyak_verifikasi_uas = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($dosen_pengampu) {
    //         $query->where('type', 1)
    //             ->whereHas('r_dosen_matkul', function ($query) use ($dosen_pengampu) {
    //                 $query->where('dosen_id', $dosen_pengampu->dosen_id);
    //             });
    //     })
    //     ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
    //         $query->where('status_smt_thnakd', '1');
    //     })
    //     ->count();

    //     // Calculate percentages
    //     $total_rps = $banyak_pengunggahan_rps + $banyak_verifikasi_rps;
    //     $percentUploadedRps = $total_rps > 0 ? ($banyak_pengunggahan_rps / $total_rps) * 100 : 0;
    //     $percentVerifiedRps = $total_rps > 0 ? ($banyak_verifikasi_rps / $total_rps) * 100 : 0;

    //     $total_uas = $banyak_pengunggahan_uas + $banyak_verifikasi_uas;
    //     $percentUploadedUas = $total_uas > 0 ? ($banyak_pengunggahan_uas / $total_uas) * 100 : 0;
    //     $percentVerifiedUas = $total_uas > 0 ? ($banyak_verifikasi_uas / $total_uas) * 100 : 0;

    //     return view('admin.content.dashboard', compact(
    //         'data_matkul',
    //         'dosen_pengampu',
    //         'banyak_pengunggahan_rps',
    //         'banyak_verifikasi_rps',
    //         'percentUploadedRps',
    //         'percentVerifiedRps',
    //         'banyak_pengunggahan_uas',
    //         'banyak_verifikasi_uas',
    //         'percentUploadedUas',
    //         'percentVerifiedUas'
    //     ));
    // }



    /**
     * Show the form for creating a new resource.
     */
    public function show($dosen_matkul_id, $matkul_kbk_id)
    {
        // Retrieve the dosen_matkul and related details by the given parameters
        $dosenMatkul = DosenPengampuMatkul::with(['p_matkulKbk.r_matkul', 'p_kelas', 'r_dosen', 'r_smt_thnakd'])
            ->where('id_dosen_matkul', $dosen_matkul_id) // Ganti $dosen_matkul_id dengan $id_dosen_matkul sesuai dengan yang didefinisikan
            ->whereHas('p_matkulKbk', function ($query) use ($matkul_kbk_id) {
                $query->where('matkul_kbk_id', $matkul_kbk_id);
            })
            ->firstOrFail();


        debug($dosenMatkul);
        return view('dosen_matkul.show', compact('dosenMatkul'));
    }



    /* Upload_RPS */
    /**
     * Show the form for creating a new resource.
     */
    public function create_rps($id_matkul)
    {
        $nextNumber = $this->getCariNomor();
        $data_thnakd = DB::table('smt_thnakd')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->select('smt_thnakd.*')
            ->first();
        $id_smt_thnakd = $data_thnakd->id_smt_thnakd;
        $data_matkul = MatkulKBK::findOrFail($id_matkul);
        $dosen_pengampu = $this->getDosen();
        $id_matkul_kbk = $data_matkul->id_matkul_kbk;
        $id_dosen_matkul = $dosen_pengampu->id_dosen_matkul;
        /* debug(compact('data_thnakd', 'data_dosen', 'data_matkul', 'nextNumber')); */
        //dd($id_matkul, $dosen_pengampu, $id_smt_thnakd);
        return view('admin.content.dosenPengampu.form.upload_rps_form', compact('id_smt_thnakd', 'id_dosen_matkul', 'id_matkul_kbk', 'nextNumber'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store_rps(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_rep_rps' => 'required',
            'id_smt_thnakd' => 'required',
            'id_dosen_matkul' => 'required',
            'id_matkul' => 'required',
            'type' => 'required',
            'upload_file' => 'required|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName();
            $path = 'public/uploads/rps/repositori_files/';
            $file->storeAs($path, $filename);

            $data = [
                'id_rep_rps_uas' => $request->id_rep_rps,
                'smt_thnakd_id' => $request->id_smt_thnakd,
                'dosen_matkul_id' => $request->id_dosen_matkul,
                'matkul_kbk_id' => $request->id_matkul,
                'type' => $request->type,
                'file' => $filename,
            ];

            RepRpsUas::create($data);
            return redirect()->route('dosen_matkul')->with('success', 'Data berhasil disimpan.');
        } else {
            return redirect()->back()->withInput()->withErrors(['upload_file' => 'File harus diunggah.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_rps(string $id)
    {
        $data_rps = RepRpsUas::where('id_rep_rps_uas', $id)->first();
        //debug(compact('data_thnakd', 'data_dosen', 'data_matkul', 'data_rps'));
        //dd($data_rps);
        return view('admin.content.dosenPengampu.form.upload_rps_edit', compact('data_rps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_rps(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_smt_thnakd' => 'required',
            'id_dosen' => 'required',
            'id_matkul' => 'required',
            'upload_file' => 'sometimes|required|mimes:pdf', // sometimes agar validasi hanya berlaku saat file diunggah
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data = [
            'smt_thnakd_id' => $request->id_smt_thnakd,
            'dosen_matkul_id' => $request->id_dosen,
            'matkul_kbk_id' => $request->id_matkul,
        ];

        $oldData = RepRpsUas::where('id_rep_rps_uas', $id)->first();;
        //debug($oldData->file);
        // Memeriksa apakah ada file lama
        if ($oldData->file !== null && $request->hasFile('upload_file')) {
            // Hapus file lama dari storage
            Storage::delete('public/uploads/rps/repositori_files/' . $oldData->file);
        }
        $filename = null;
        // Jika file baru diunggah, hapus file lama dan simpan file baru
        if ($request->hasFile('upload_file')) {

            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/rps/repositori_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya

            $data['file'] = $filename;
        }

        //dd($request->all());
        $RepRpsUas = RepRpsUas::find($id);

        if ($RepRpsUas) {
            $RepRpsUas->update($data);
        }
        return redirect()->route('dosen_matkul')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_rps(string $id)
    {
        $data_rep_rps = RepRpsUas::where('id_rep_rps_uas', $id)->first();

        // Menghapus file terkait jika ada
        if ($data_rep_rps && $data_rep_rps->file) {
            Storage::delete('public/uploads/rps/repositori_files/' . $data_rep_rps->file);
        }

        // Menghapus data dari basis data
        if ($data_rep_rps) {
            $data_rep_rps->delete();
        }

        return redirect()->route('dosen_matkul')->with('success', 'Data berhasil dihapus.');

        //dd($data_matkul);
    }
    /**
     * Show the form for creating a new resource.
     */
    /* Upload_UAS */
    public function create_uas($id_matkul)
    {
        $nextNumber = $this->getCariNomor();
        $data_thnakd = DB::table('smt_thnakd')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->select('smt_thnakd.*')
            ->first();
        $id_smt_thnakd = $data_thnakd->id_smt_thnakd;
        $data_matkul = MatkulKBK::findOrFail($id_matkul);
        $dosen_pengampu = $this->getDosen();
        $id_matkul_kbk = $data_matkul->id_matkul_kbk;
        $id_dosen_matkul = $dosen_pengampu->id_dosen_matkul;
        return view('admin.content.dosenPengampu.form.upload_uas_form', compact('id_smt_thnakd', 'id_dosen_matkul', 'id_matkul_kbk', 'nextNumber'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store_uas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_rep_uas' => 'required',
            'id_smt_thnakd' => 'required',
            'id_dosen' => 'required',
            'id_matkul' => 'required',
            'type' => 'required',
            'upload_file' => 'required|mimes:pdf',
        ]);
        //dd($request->all());
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName();
            $path = 'public/uploads/uas/repositori_files/';
            $file->storeAs($path, $filename);

            $data = [
                'id_rep_rps_uas' => $request->id_rep_uas,
                'smt_thnakd_id' => $request->id_smt_thnakd,
                'dosen_matkul_id' => $request->id_dosen,
                'matkul_kbk_id' => $request->id_matkul,
                'type' => $request->type,
                'file' => $filename,
            ];

            RepRpsUas::create($data);
            return redirect()->route('dosen_matkul')->with('success', 'Data berhasil disimpan.');
        } else {
            return redirect()->back()->withInput()->withErrors(['upload_file' => 'File harus diunggah.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_uas(string $id)
    {
        $data_uas = RepRpsUas::where('id_rep_rps_uas', $id)->first();
        //dd($data_uas);
        return view('admin.content.dosenPengampu.form.upload_uas_edit', compact('data_uas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_uas(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_smt_thnakd' => 'required',
            'id_dosen' => 'required',
            'id_matkul' => 'required',
            'upload_file' => 'sometimes|required|mimes:pdf', // sometimes agar validasi hanya berlaku saat file diunggah
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data = [
            'smt_thnakd_id' => $request->id_smt_thnakd,
            'dosen_matkul_id' => $request->id_dosen,
            'matkul_kbk_id' => $request->id_matkul,
        ];

        $oldData = RepRpsUas::where('id_rep_rps_uas', $id)->first();;
        //debug($oldData->file);
        // Memeriksa apakah ada file lama
        if ($oldData->file !== null && $request->hasFile('upload_file')) {
            // Hapus file lama dari storage
            Storage::delete('public/uploads/uas/repositori_files/' . $oldData->file);
        }
        $filename = null;
        // Jika file baru diunggah, hapus file lama dan simpan file baru
        if ($request->hasFile('upload_file')) {

            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/uas/repositori_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya

            $data['file'] = $filename;
        }

        //dd($request->all());
        $RepRpsUas = RepRpsUas::find($id);

        if ($RepRpsUas) {
            $RepRpsUas->update($data);
        }
        return redirect()->route('dosen_matkul')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_uas(string $id)
    {
        $data_rep_uas = RepRpsUas::find($id);

        // Menghapus file terkait jika ada
        if ($data_rep_uas && $data_rep_uas->file) {
            Storage::delete('public/uploads/uas/repositori_files/' . $data_rep_uas->file);
        }

        // Menghapus data dari basis data
        if ($data_rep_uas) {
            $data_rep_uas->delete();
        }

        return redirect()->route('dosen_matkul')->with('success', 'Data berhasil dihapus.');

        //dd($data_matkul);
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_rep_rps_uas = RepRpsUas::pluck('id_rep_rps_uas')->toArray();
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_rep_rps_uas)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
