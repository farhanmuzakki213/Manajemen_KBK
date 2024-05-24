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
            ->join('dosen', 'ver_rps.dosen_id', '=', 'dosen.id_dosen')
            ->join('rep_rps', 'ver_rps.rep_rps_id', '=', 'rep_rps.id_rep_rps')
            ->join('matkul', 'rep_rps.matkul_id', '=', 'matkul.id_matkul')
            ->join('smt_thnakd', 'rep_rps.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select('ver_rps.*', 'ver_rps.*', 'rep_rps.*', 'dosen.*', 'matkul.*', 'smt_thnakd.*')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->orderByDesc('id_ver_rps')
            ->get();
        debug($data_ver_rps);
        return view('admin.content.Ver_RPS', compact('data_ver_rps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextNumber = $this->getNextNumber('VRPS');
        $data_dosen = DB::table('dosen')->get();
        $data_rep_rps = DB::table('rep_rps')
            ->join('matkul', 'rep_rps.matkul_id', '=', 'matkul.id_matkul')
            ->select('rep_rps.*',  'matkul.*')
            ->orderByDesc('id_rep_rps')
            ->get();
        debug(compact('data_dosen', 'data_rep_rps', 'nextNumber'));
        return view('admin.content.form.ver_rps_form', compact('data_dosen', 'data_rep_rps', 'nextNumber'));
    }

    private function getNextNumber($prefix)
    {
        // Ambil ID terakhir dengan prefix yang sama
        $lastEntry = DB::table('ver_rps')
            ->where('id_ver_rps', 'like', $prefix . '%')
            ->orderBy('id_ver_rps', 'desc')
            ->first();

        // Jika tidak ada entri sebelumnya, kembalikan angka pertama
        if (!$lastEntry) {
            return 1;
        }

        // Ambil angka terakhir dari ID terakhir dan tambahkan 1
        $lastNumber = intval(substr($lastEntry->id_ver_rps, strlen($prefix)));
        return $lastNumber + 1;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_ver_rps' => 'required',
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

        // Memastikan file telah diunggah sebelum menyimpannya
        $filename = '';
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/ver_rps_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya
        }

        // Menyimpan catatan hanya jika diisi
        $catatan = $request->filled('catatan') ? $request->catatan : null;
        $status = $request->filled('status') ? $request->status : null;

        $data = [
            'id_ver_rps' => $request->id_ver_rps,
            'rep_rps_id' => $request->nama_matkul,
            'dosen_id' => $request->nama_dosen,
            'tanggal_diverifikasi' => $request->date,
        ];

        // Hanya menambahkan field 'file' jika file diunggah
        if ($filename !== '') {
            $data['file_verifikasi'] = $filename;
        }
        if ($status !== null) {
            $data['status_ver_rps'] = $status;
        }

        // Hanya menambahkan field 'catatan' jika diisi
        if ($catatan !== null) {
            $data['catatan'] = $catatan;
        }

        Ver_RPS::create($data);
        return redirect()->route('ver_rps')->with('success', 'Data berhasil disimpan.');


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

        $data_ver_rps = Ver_RPS::where('id_ver_rps', $id)->first();
        $data_rep_rps = DB::table('rep_rps')
            ->join('matkul', 'rep_rps.matkul_id', '=', 'matkul.id_matkul')
            ->select('rep_rps.*',  'matkul.*')
            ->orderByDesc('id_rep_rps')
            ->get();
        //dd(compact('data_dosen', 'data_matkul', 'data_ver_rps'));
        debug(compact('data_dosen', 'data_rep_rps', 'data_ver_rps'));
        return view('admin.content.form.ver_rps_edit', compact('data_dosen', 'data_rep_rps', 'data_ver_rps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_ver_rps' => 'required',
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
        $oldData = Ver_RPS::find($id);

        // Memeriksa apakah ada file lama
        if ($oldData->file_verifikasi !== null && $request->hasFile('upload_file')) {
            // Hapus file lama dari storage
            Storage::delete('public/uploads/ver_rps_files/' . $oldData->file_verifikasi);
        }

        // Memastikan file telah diunggah sebelum menyimpannya
        $filename = null;
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/ver_rps_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya
        }

        // Menyimpan catatan hanya jika diisi
        $catatan = $request->filled('catatan') ? $request->catatan : null;
        $status = $request->filled('status') ? $request->status : null;

        $data = [
            'id_ver_rps' => $request->id_ver_rps,
            'rep_rps_id' => $request->nama_matkul,
            'dosen_id' => $request->nama_dosen,
            'tanggal_diverifikasi' => $request->date,
        ];

        // Hanya menambahkan field 'file' jika file diunggah
        if ($filename !== null) {
            $data['file_verifikasi'] = $filename;
        }

        // Hanya menambahkan field 'status_ver_rps' jika diisi
        if ($status !== null) {
            $data['status_ver_rps'] = $status;
        }

        // Hanya menambahkan field 'catatan' jika diisi
        if ($catatan !== null) {
            $data['catatan'] = $catatan;
        }


        //dd($request->all());
        Ver_RPS::where('id_ver_rps', $id)->update($data);
        return redirect()->route('ver_rps')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_ver_rps = Ver_RPS::where('id_ver_rps', $id)->first();

        // Menghapus file terkait jika ada
        if ($data_ver_rps && $data_ver_rps->file_verifikasi) {
            Storage::delete('public/uploads/ver_rps_files/' . $data_ver_rps->file_verifikasi);
        }

        // Menghapus data dari basis data jika ada
        if ($data_ver_rps) {
            $data_ver_rps->delete();
        }

        return redirect()->route('ver_rps')->with('success', 'Data berhasil dihapus.');


        //dd($data_matkul);
    }
}
