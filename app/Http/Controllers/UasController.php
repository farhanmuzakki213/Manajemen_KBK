<?php

namespace App\Http\Controllers;

use App\Models\Rep_UAS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UasController extends Controller
{
    

    public function index()
    {
        $data_uas = DB::table('rep_uas')
            ->join('smt_thnakd', 'rep_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            // ->join('ver_uas', 'rep_uas.ver_uas_id', '=', 'ver_uas.id_ver_uas')
            ->join('matkul', 'rep_uas.matkul_id', '=', 'matkul.id_matkul')
            ->join('dosen', 'rep_uas.dosen_id', '=', 'dosen.id_dosen')
            ->select('rep_uas.*', 'dosen.*','matkul.*','smt_thnakd.*')
            // ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->orderByDesc('id_rep_uas')
            ->get();
            //dd($data_uas);
        return view('admin.content.uas', compact('data_uas'));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_thnakd = DB::table('smt_thnakd')->get();
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();
        // $data_ver_uas = DB::table('ver_uas')->get();

        return view('admin.content.form.uas_form', compact('data_thnakd', 'data_dosen', 'data_matkul'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id_rep_uas' => 'required',
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
        $path = 'public/uploads/soal_uas_files/';
        $file->storeAs($path, $filename);

        $data = [
            'id_rep_uas' => $request->id_rep_uas,
            'smt_thnakd_id' => $request->smt_thnakd,
            'dosen_id' => $request->nama_dosen,
            'matkul_id' => $request->nama_matkul,
            'file' => $filename,
        ];

        Rep_UAS::create($data);
        return redirect()->route('soal_uas')->with('success', 'Data berhasil disimpan.');
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
        // $data_ver_uas = DB::table('ver_uas')->get();

        return view('admin.content.form.uas', compact('data_thnakd', 'data_dosen', 'data_matkul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_thnakd = DB::table('smt_thnakd')->get();
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();

        $data_uas = Rep_UAS::where('id_rep_uas', $id)->first();
        //dd(compact('data_dosen', 'data_matkul', 'data_ver_uas'));
        return view('admin.content.form.uas_edit', compact('data_thnakd', 'data_dosen', 'data_matkul', 'data_uas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_rep_uas' => 'required',
            'smt_thnakd' => 'required',
            'nama_dosen' => 'required',
            'nama_matkul' => 'required',
            'upload_file' => 'sometimes|required|mimes:pdf', // sometimes agar validasi hanya berlaku saat file diunggah
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $id_rep_uas = Rep_UAS::where('id_rep_uas', $id);
        $data = [
            'id_rep_uas' => $request->id_rep_uas,
            'smt_thnakd_id' => $request->smt_thnakd,
            'dosen_id' => $request->nama_dosen,
            'matkul_id' => $request->nama_matkul,
        ];

        // Jika file baru diunggah, hapus file lama dan simpan file baru
        if ($request->hasFile('upload_file')) {
            
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/soal_uas_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya
            /* // Hapus file lama jika ada
            if ($oldFilePath) {
                Storage::delete($oldFilePath);
            } */
            
            $data['file'] = $filename;
        }
        
        /* dd($request->all()); */
        $id_rep_uas->update($data);
        return redirect()->route('soal_uas')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_rep_uas = Rep_UAS::where('id_rep_uas', $id)->first();

        // Menghapus file terkait jika ada
        if ($data_rep_uas->file) {
            Storage::delete($data_rep_uas->file);
        }

        // Menghapus data dari basis data
        if ($data_rep_uas) {
            Rep_UAS::where('id_rep_uas', $id)->delete();
        }

        return redirect()->route('soal_uas')->with('success', 'Data berhasil dihapus.');

        //dd($data_matkul);
    }

}
