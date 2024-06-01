<?php

namespace App\Http\Controllers\DosenPengampu;

use App\Http\Controllers\Controller;
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
            ->select('rep_rps.id_rep_rps', 'rep_rps.file', 'dosen.nama_dosen','matkul.nama_matkul','matkul.semester', 'smt_thnakd.smt_thnakd')
            //->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->orderByDesc('id_rep_rps')
            ->get();
            //dd($data_rps);
        return view('admin.content.dosenPengampu.upload_rps', compact('data_rps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextNumber = $this->getCariNomor();
        $data_thnakd = DB::table('smt_thnakd')
        ->where('smt_thnakd.status_smt_thnakd', '=', '1')
        ->select('smt_thnakd.*')
        ->get();
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();
        // $data_ver_rps = DB::table('ver_rps')->get();
        debug(compact('data_thnakd', 'data_dosen', 'data_matkul', 'nextNumber'));
        return view('admin.content.dosenPengampu.form.upload_rps_form', compact('data_thnakd', 'data_dosen', 'data_matkul', 'nextNumber'));
    }

    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_rep_rps = Rep_RPS::pluck('id_rep_rps')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_rep_rps)) {
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
        'id_rep_rps' => 'required',
        'id_smt_thnakd' => 'required',
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
        $path = 'public/uploads/rps/repositori_files/';
        $file->storeAs($path, $filename);

        $data = [
            'id_rep_rps' => $request->id_rep_rps,
            'smt_thnakd_id' => $request->id_smt_thnakd,
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

        return view('admin.content.dosenPengampu.upload_rps', compact('data_thnakd', 'data_dosen', 'data_matkul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_thnakd = DB::table('smt_thnakd')
        ->where('smt_thnakd.status_smt_thnakd', '=', '1')
        ->select('smt_thnakd.*')
        ->get();
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();

        $data_rps = Rep_RPS::where('id_rep_rps', $id)->first();
        debug(compact('data_thnakd', 'data_dosen', 'data_matkul', 'data_rps'));
        return view('admin.content.dosenPengampu.form.upload_rps_edit', compact('data_thnakd', 'data_dosen', 'data_matkul', 'data_rps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_rep_rps' => 'required',
            'id_smt_thnakd' => 'required',
            'nama_dosen' => 'required',
            'nama_matkul' => 'required',
            'upload_file' => 'sometimes|required|mimes:pdf', // sometimes agar validasi hanya berlaku saat file diunggah
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data = [
            'id_rep_rps' => $request->id_rep_rps,
            'smt_thnakd_id' => $request->id_smt_thnakd,
            'dosen_id' => $request->nama_dosen,
            'matkul_id' => $request->nama_matkul,
        ];

        $oldData = Rep_RPS::where('id_rep_rps', $id)->first();;
        debug($oldData->file);
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
        Rep_RPS::where('id_rep_rps', $id)->update($data);
        return redirect()->route('upload_rps')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_rep_rps = Rep_RPS::where('id_rep_rps', $id)->first();

        // Menghapus file terkait jika ada
        if ($data_rep_rps && $data_rep_rps->file) {
            Storage::delete('public/uploads/rps/repositori_files/' . $data_rep_rps->file);
        }

        // Menghapus data dari basis data
        if ($data_rep_rps) {
            Rep_RPS::where('id_rep_rps', $id)->delete();
        }

        return redirect()->route('upload_rps')->with('success', 'Data berhasil dihapus.');

        //dd($data_matkul);
    }
}
