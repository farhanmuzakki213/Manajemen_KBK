<?php

namespace App\Http\Controllers;

use App\Models\Ver_RPS;
use App\Models\Ver_RPSModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Ver_RPSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_ver_rps = DB::table('ver_rps')
            ->join('matkul', 'ver_rps.matkul_id', '=', 'matkul.id_matkul')
            ->join('dosen', 'ver_rps.dosen_id', '=', 'dosen.id_dosen')
            ->join('smt_thnakd', 'matkul.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select('ver_rps.*', 'dosen.*', 'matkul.*', 'smt_thnakd.*')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->orderByDesc('id_ver_rps')
            ->get();
        //dd($data_rps);
        return view('admin.content.Ver_RPS', compact('data_ver_rps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();

        return view('admin.content.form.ver_rps_form', compact('data_dosen', 'data_matkul'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_ver_rps' => 'required',
            'nama_dosen' => 'required',
            'nama_matkul' => 'required',
            'upload_file' => 'required|mimes:pdf',
            'status' => 'required',
            'catatan' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Memastikan file telah diunggah sebelum menyimpannya
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/ver_rps_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya

            $data = [
                'id_ver_rps' => $request->id_ver_rps,
                'dosen_id' => $request->nama_dosen,
                'matkul_id' => $request->nama_matkul,
                'file' => $filename,
                'status_ver_rps' => $request->status,
                'catatan' => $request->catatan,
                'tanggal_diverifikasi' => $request->date,
            ];

            Ver_RPS::create($data);
            return redirect()->route('ver_rps')->with('success', 'Data berhasil disimpan.');
        } else {
            // Jika file tidak diunggah, kembalikan dengan pesan kesalahan
            return redirect()->back()->withInput()->withErrors(['upload_file' => 'File harus diunggah.']);
        }
        //dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();

        return view('admin.content.form.ver_rps', compact('data_dosen', 'data_matkul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();

        $data_ver_rps = Ver_RPS::where('id_ver_rps', $id)->first();
        //dd(compact('data_dosen', 'data_matkul', 'data_ver_rps'));
        return view('admin.content.form.ver_rps_edit', compact('data_dosen', 'data_matkul', 'data_ver_rps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_ver_rps' => 'required',
            'nama_dosen' => 'required',
            'nama_matkul' => 'required',
            'upload_file' => 'sometimes|required|mimes:pdf', // sometimes agar validasi hanya berlaku saat file diunggah
            'status' => 'required',
            'catatan' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $id_ver_rps = Ver_RPS::where('id_ver_rps', $id);
        $data = [
            'id_ver_rps' => $request->id_ver_rps,
            'dosen_id' => $request->nama_dosen,
            'matkul_id' => $request->nama_matkul,
            'status_ver_rps' => $request->status,
            'catatan' => $request->catatan,
            'tanggal_diverifikasi' => $request->date,
        ];

        // Jika file baru diunggah, hapus file lama dan simpan file baru
        if ($request->hasFile('upload_file')) {
            
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/ver_rps_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya
            /* // Hapus file lama jika ada
            if ($oldFilePath) {
                Storage::delete($oldFilePath);
            } */
            
            $data['file'] = $filename;
        }
        
        /* dd($request->all()); */
        $id_ver_rps->update($data);
        return redirect()->route('ver_rps')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_ver_rps = Ver_RPS::where('id_ver_rps', $id)->first();

        // Menghapus file terkait jika ada
        if ($data_ver_rps->file) {
            Storage::delete($data_ver_rps->file);
        }

        // Menghapus data dari basis data
        if ($data_ver_rps) {
            Ver_RPS::where('id_ver_rps', $id)->delete();
        }

        return redirect()->route('ver_rps')->with('success', 'Data berhasil dihapus.');

        //dd($data_matkul);
    }
}
