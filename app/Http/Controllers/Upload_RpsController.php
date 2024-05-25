<?php

namespace App\Http\Controllers;

use App\Models\Rep_RPS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Upload_RpsController extends Controller
{
    public function index()
    {
        $data_rps = DB::table('rep_rps')
            ->join('smt_thnakd', 'rep_rps.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            // ->join('ver_rps', 'rep_rps.ver_rps_id', '=', 'ver_rps.id_ver_rps')
            ->join('matkul', 'rep_rps.matkul_id', '=', 'matkul.id_matkul')
            ->join('dosen', 'rep_rps.dosen_id', '=', 'dosen.id_dosen')
            ->select('rep_rps.*', 'dosen.*','matkul.*','smt_thnakd.*')
            // ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->orderByDesc('id_rep_rps')
            ->get();
            //dd($data_rps);
        return view('admin.content.upload_rps', compact('data_rps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextNumber = $this->getNextNumber('RRPS');
        $data_thnakd = DB::table('smt_thnakd')->get();
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();
        // $data_ver_rps = DB::table('ver_rps')->get();
        debug(compact('data_thnakd', 'data_dosen', 'data_matkul', 'nextNumber'));
        return view('admin.content.form.upload_rps_form', compact('data_thnakd', 'data_dosen', 'data_matkul', 'nextNumber'));
    }

    private function getNextNumber($prefix)
    {
        // Ambil ID terakhir dengan prefix yang sama
        $lastEntry = DB::table('rep_rps')
            ->where('id_rep_rps', 'like', $prefix . '%')
            ->orderBy('id_rep_rps', 'desc')
            ->first();

        // Jika tidak ada entri sebelumnya, kembalikan angka pertama
        if (!$lastEntry) {
            return 1;
        }

        // Ambil angka terakhir dari ID terakhir dan tambahkan 1
        $lastNumber = intval(substr($lastEntry->id_rep_rps, strlen($prefix)));
        return $lastNumber + 1;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id_rep_rps' => 'required',
        'smt_thnakd' => 'required',
        'nama_dosen' => 'required',
        'nama_matkul' => 'required',
        'upload_file' => 'required|mimes:pdf',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withInput()->withErrors($validator);
    }

    if ($request->hasFile('upload_file')) {
        $file = $request->file('upload_file');
        $filename = $file->getClientOriginalName();
        $path = 'public/uploads/rps_files/';
        $file->storeAs($path, $filename);

        $data = [
            'id_rep_rps' => $request->id_rep_rps,
            'smt_thnakd_id' => $request->smt_thnakd,
            'dosen_id' => $request->nama_dosen,
            'matkul_id' => $request->nama_matkul,
            'file' => $filename,
        ];

        Rep_RPS::create($data);
        return redirect()->route('upload_rps')->with('success', 'Data berhasil disimpan.');
    } else {
        return redirect()->back()->withInput()->withErrors(['upload_file' => 'File harus diunggah.']);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_thnakd = DB::table('smt_thnakd')->get();
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();
        // $data_ver_rps = DB::table('ver_rps')->get();

        return view('admin.content.upload_form.rps', compact('data_thnakd', 'data_dosen', 'data_matkul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_thnakd = DB::table('smt_thnakd')->get();
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();

        $data_rps = Rep_RPS::where('id_rep_rps', $id)->first();
        debug(compact('data_thnakd', 'data_dosen', 'data_matkul', 'data_rps'));
        return view('admin.content.form.upload_rps_edit', compact('data_thnakd', 'data_dosen', 'data_matkul', 'data_rps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_rep_rps' => 'required',
            'smt_thnakd' => 'required',
            'nama_dosen' => 'required',
            'nama_matkul' => 'required',
            'upload_file' => 'sometimes|required|mimes:pdf', // sometimes agar validasi hanya berlaku saat file diunggah
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $id_rep_rps = Rep_RPS::where('id_rep_rps', $id);
        $data = [
            'id_rep_rps' => $request->id_rep_rps,
            'smt_thnakd_id' => $request->smt_thnakd,
            'dosen_id' => $request->nama_dosen,
            'matkul_id' => $request->nama_matkul,
        ];

        // Jika file baru diunggah, hapus file lama dan simpan file baru
        if ($request->hasFile('upload_file')) {
            
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/rps_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya
            /* // Hapus file lama jika ada
            if ($oldFilePath) {
                Storage::delete($oldFilePath);
            } */
            
            $data['file'] = $filename;
        }
        
        /* dd($request->all()); */
        $id_rep_rps->update($data);
        return redirect()->route('upload_rps')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_rep_rps = Rep_RPS::where('id_rep_rps', $id)->first();

        // Menghapus file terkait jika ada
        if ($data_rep_rps->file) {
            Storage::delete($data_rep_rps->file);
        }

        // Menghapus data dari basis data
        if ($data_rep_rps) {
            Rep_RPS::where('id_rep_rps', $id)->delete();
        }

        return redirect()->route('upload_rps')->with('success', 'Data berhasil dihapus.');

        //dd($data_matkul);
    }
}
