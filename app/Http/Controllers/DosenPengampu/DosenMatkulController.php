<?php

namespace App\Http\Controllers\DosenPengampu;

use App\Http\Controllers\Controller;
use App\Models\DosenPengampuMatkul;
use App\Models\Matkul;
use App\Models\MatkulKBK;
use App\Models\RepRpsUas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DosenMatkulController extends Controller
{
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


        $data_uas = DB::table('rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('dosen', 'rep_rps_uas.dosen_id', '=', 'dosen.id_dosen')
            ->select('rep_rps_uas.id_rep_rps_uas', 'rep_rps_uas.file', 'dosen.nama_dosen', 'matkul.nama_matkul', 'matkul.semester', 'smt_thnakd.smt_thnakd')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->where('rep_rps_uas.type', '=', '1')
            ->orderByDesc('id_rep_rps_uas')
            ->get();

        $data_rps = DB::table('rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('dosen', 'rep_rps_uas.dosen_id', '=', 'dosen.id_dosen')
            ->select('rep_rps_uas.id_rep_rps_uas', 'rep_rps_uas.file', 'dosen.nama_dosen', 'matkul.nama_matkul', 'matkul.semester', 'smt_thnakd.smt_thnakd')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->where('rep_rps_uas.type', '=', '0')
            ->where('dosen_id', $dosen_pengampu->dosen_id)
            ->orderByDesc('id_rep_rps_uas')
            ->get();
        //dd($data_matkul, $dosen_pengampu);
        return view('admin.content.dosenPengampu.dosen_matkul', compact('data_matkul', 'dosen_pengampu', 'data_uas', 'data_rps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
        $id_dosen_matkul = $dosen_pengampu->dosen_id;
        /* debug(compact('data_thnakd', 'data_dosen', 'data_matkul', 'nextNumber')); */
        //dd($id_matkul, $id_dosen_matkul, $id_smt_thnakd);
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
            'id_dosen' => 'required',
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
                'dosen_id' => $request->id_dosen,
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
            'dosen_id' => $request->id_dosen,
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
        RepRpsUas::where('id_rep_rps_uas', $id)->update($data);
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
            RepRpsUas::where('id_rep_rps_uas', $id)->delete();
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
        $data_matkul = Matkul::findOrFail($id_matkul);
        $dosen_pengampu = $this->getDosen();
        $id_matkul = $data_matkul->id_matkul;
        $id_dosen_matkul = $dosen_pengampu->dosen_id;

        return view('admin.content.dosenPengampu.form.upload_uas_form', compact('id_smt_thnakd', 'id_dosen_matkul', 'id_matkul', 'nextNumber'));
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
            'upload_file' => 'required|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName();
            $path = 'public/uploads/uas/repositori_files/';
            $file->storeAs($path, $filename);

            $data = [
                'id_rep_uas' => $request->id_rep_uas,
                'smt_thnakd_id' => $request->id_smt_thnakd,
                'dosen_id' => $request->id_dosen,
                'matkul_id' => $request->id_matkul,
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
        $data_uas = RepRpsUas::where('id_rep_uas', $id)->first();
        //dd(compact('data_dosen', 'data_matkul', 'data_ver_uas'));
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
            'dosen_id' => $request->id_dosen,
            'matkul_id' => $request->id_matkul,
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

        /* dd($request->all()); */
        RepRpsUas::where('id_rep_rps_uas', $id)->update($data);
        return redirect()->route('dosen_matkul')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_uas(string $id)
    {
        $data_rep_uas = RepRpsUas::where('id_rep_rps_uas', $id)->first();

        // Menghapus file terkait jika ada
        if ($data_rep_uas && $data_rep_uas->file) {
            Storage::delete('public/uploads/uas/repositori_files/' . $data_rep_uas->file);
        }

        // Menghapus data dari basis data
        if ($data_rep_uas) {
            RepRpsUas::where('id_rep_rps_uas', $id)->delete();
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
