<?php

namespace App\Http\Controllers;

use App\Models\Ver_UAS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class Ver_Soal_UASController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_ver_soal_uas = DB::table('ver_uas')
            ->join('dosen', 'ver_uas.dosen_id', '=', 'dosen.id_dosen')
            ->join('rep_uas', 'ver_uas.rep_uas_id', '=', 'rep_uas.id_rep_uas')
            ->join('matkul', 'rep_uas.matkul_id', '=', 'matkul.id_matkul')
            ->join('smt_thnakd', 'rep_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select('ver_uas.*', 'ver_uas.*', 'rep_uas.*', 'dosen.*', 'matkul.*', 'smt_thnakd.*')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->orderByDesc('id_ver_uas')
            ->get();
        debug($data_ver_soal_uas);
        return view('admin.content.Ver_Soal_Uas', compact('data_ver_soal_uas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextNumber = $this->getNextNumber();
        $data_dosen = DB::table('dosen')->get();
        $data_rep_uas = DB::table('rep_uas')
            ->join('matkul', 'rep_uas.matkul_id', '=', 'matkul.id_matkul')
            ->select('rep_uas.*',  'matkul.*')
            ->orderByDesc('id_rep_uas')
            ->get();
        debug(compact('data_dosen', 'data_rep_uas', 'nextNumber'));
        return view('admin.content.form.ver_soal_uas_form', compact('data_dosen', 'data_rep_uas', 'nextNumber'));
    }

    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_ver_uas = Ver_UAS::pluck('id_ver_uas')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
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
            'nama_matkul' => 'required',
            'nama_dosen' => 'required',
            'upload_file' => 'nullable|mimes:pdf', // File tidak wajib diunggah
            'status_ver_soal_uas' => 'nullable',
            'catatan' => 'nullable',
            'date' => 'required|date',
        ]);

        // Aturan validasi untuk catatan menjadi opsional
        $validator->sometimes('catatan', 'nullable', function ($input) {
            return !$input->hasFile('upload_file'); // Catatan hanya opsional jika file tidak diunggah
        });

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Memastikan file telah diunggah sebelum menyimpannya
        $filename = '';
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/ver_soal_uas_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya
        }

        // Menyimpan catatan hanya jika diisi
        $catatan = $request->filled('catatan') ? $request->catatan : null;
        $status_ver_uas = $request->filled('status_ver_uas') ? $request->status_ver_uas : null;

        $data = [
            'id_ver_uas' => $request->id_ver_uas,
            'rep_uas_id' => $request->nama_matkul,
            'dosen_id' => $request->nama_dosen,
            'tanggal_diverifikasi' => $request->date,
        ];

        // Hanya menambahkan field 'file' jika file diunggah
        if ($filename !== '') {
            $data['file_verifikasi'] = $filename;
        }
        if ($status_ver_uas !== null) {
            $data['status_ver_uas'] = $status_ver_uas;
        }

        // Hanya menambahkan field 'catatan' jika diisi
        if ($catatan !== null) {
            $data['catatan'] = $catatan;
        }

        Ver_UAS::create($data);
        return redirect()->route('ver_soal_uas')->with('success', 'Data berhasil disimpan.');


        //dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_dosen = DB::table('dosen')->get();
        $data_matkul = DB::table('matkul')->get();

        return view('admin.content.form.ver_soal_uas', compact('data_dosen', 'data_matkul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_dosen = DB::table('dosen')->get();

        $data_ver_soal_uas = Ver_uas::where('id_ver_uas', $id)->first();
        $data_rep_uas = DB::table('rep_uas')
            ->join('matkul', 'rep_uas.matkul_id', '=', 'matkul.id_matkul')
            ->select('rep_uas.*',  'matkul.*')
            ->orderByDesc('id_rep_uas')
            ->get();
        //dd(compact('data_dosen', 'data_matkul', 'data_ver_uas'));
        debug(compact('data_dosen', 'data_rep_uas', 'data_ver_soal_uas'));
        return view('admin.content.form.ver_soal_uas_edit', compact('data_dosen', 'data_rep_uas', 'data_ver_soal_uas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_ver_uas' => 'required',
            'nama_matkul' => 'required',
            'nama_dosen' => 'required',
            'upload_file' => 'nullable|mimes:pdf', // File tidak wajib diunggah
            'status' => 'nullable',
            'catatan' => 'nullable',
            'date' => 'required|date',
        ]);

        // Aturan validasi untuk catatan menjadi opsional
        $validator->sometimes('catatan', 'nullable', function ($input) {
            return !$input->hasFile('upload_file'); // Catatan hanya opsional jika file tidak diunggah
        });

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Mendapatkan data lama
        $oldData = Ver_UAS::find($id);

        // Memeriksa apakah ada file lama
        if ($oldData->file !== null && $request->hasFile('upload_file')) {
            // Hapus file lama dari storage
            Storage::delete('public/uploads/ver_soal_uas_files/' . $oldData->file);
        }

        // Memastikan file telah diunggah sebelum menyimpannya
        $filename = null;
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/ver_soal_uas_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya
        }

        // Menyimpan catatan hanya jika diisi
        $catatan = $request->filled('catatan') ? $request->catatan : null;
        $status = $request->filled('status') ? $request->status : null;

        $data = [
            'id_ver_uas' => $request->id_ver_uas,
            'rep_uas_id' => $request->nama_matkul,
            'dosen_id' => $request->nama_dosen,
            'tanggal_diverifikasi' => $request->date,
        ];

        // Hanya menambahkan field 'file' jika file diunggah
        if ($filename !== null) {
            $data['file_verifikasi'] = $filename;
        }

        // Hanya menambahkan field 'status_ver_soal_uas' jika diisi
        if ($status !== null) {
            $data['status_ver_uas'] = $status;
        }

        // Hanya menambahkan field 'catatan' jika diisi
        if ($catatan !== null) {
            $data['catatan'] = $catatan;
        }


        //dd($request->all());
        Ver_UAS::where('id_ver_uas', $id)->update($data);
        return redirect()->route('ver_soal_uas')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_ver_soal_uas = Ver_UAS::where('id_ver_uas', $id)->first();

        // Menghapus file terkait jika ada
        if ($data_ver_soal_uas && $data_ver_soal_uas->file) {
            Storage::delete('public/uploads/ver__soal_uas_files/' . $data_ver_soal_uas->file);
        }

        // Menghapus data dari basis data jika ada
        if ($data_ver_soal_uas) {
            $data_ver_soal_uas->delete();
        }

        return redirect()->route('ver_soal_uas')->with('success', 'Data berhasil dihapus.');


        //dd($data_matkul);
    }
}
