<?php

namespace App\Http\Controllers\PengurusKbk;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\RepRpsUas;
use App\Models\Ver_RPS;
use App\Models\VerRpsUas;
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
        $data_ver_rps = VerRpsUas:: with('r_dosen', 'r_rep_rps_uas.r_smt_thnakd')
            ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1'); 
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();

        $data_rep_rps = RepRpsUas:: with('r_dosen', 'r_matkulKbk', 'r_smt_thnakd')
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1'); 
            })
            ->orderByDesc('id_rep_rps_uas')
            ->get();
        debug($data_ver_rps);
        return view('admin.content.pengurusKbk.Ver_RPS', compact('data_ver_rps', 'data_rep_rps'));
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
            return redirect()->route('ver_rps')->with('error', 'Data sudah diambil.');
        }

        $nextNumber = $this->getCariNomor();
        $data_dosen = Dosen::all();
        $data_rep_rps = RepRpsUas::where('type', '=', '0')
            ->orderByDesc('id_rep_rps_uas')
            ->get();
        debug(compact('data_dosen', 'data_rep_rps', 'nextNumber'));
        return view('admin.content.pengurusKbk.form.ver_rps_form', compact('data_dosen', 'data_rep_rps', 'nextNumber'));
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_ver_rps = VerRpsUas::pluck('id_ver_rps_uas')->toArray();

        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_ver_rps)) {
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
            'id_ver_rps' => 'required',
            'id_rep_rps' => 'required',
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

            $path = 'public/uploads/rps/ver_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya
        }

        // Menyimpan catatan hanya jika diisi
        $catatan = $request->filled('catatan') ? $request->catatan : null;
        $status = $request->filled('status') ? $request->status : null;

        $data = [
            'id_ver_rps_uas' => $request->id_ver_rps,
            'rep_rps_uas_id' => $request->id_rep_rps,
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

        VerRpsUas::create($data);
        return redirect()->route('ver_rps')->with('success', 'Data berhasil disimpan.');


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
        $data_dosen = Dosen::all();
    
        $data_ver_rps = VerRpsUas::where('id_ver_rps_uas', $id)->first();
        $data_rep_rps = RepRpsUas::with('r_dosen', 'r_matkulKbk', 'r_smt_thnakd')
            ->where('rep_rps_uas.id_rep_uas', $data_ver_rps->rep_rps_uas_id)  // Perbaiki query untuk mengambil data rep_rps yang sesuai
            ->first();  // Karena ini seharusnya satu record
    
        return view('admin.content.pengurusKbk.form.ver_rps_edit', compact('data_dosen', 'data_rep_rps', 'data_ver_rps'));
    }
    
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_ver_rps' => 'required',
            'id_rep_rps' => 'required',
            'nama_dosen' => 'required',
            'upload_file' => 'nullable|mimes:pdf', // File tidak wajib diunggah
            'status' => 'nullable',
            'catatan' => 'nullable',
            'date' => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    
        // Mendapatkan data lama
        $oldData = VerRpsUas::find($id);
    
        // Memeriksa apakah ada file lama dan file baru diunggah
        if ($oldData->file_verifikasi && $request->hasFile('upload_file')) {
            // Hapus file lama dari storage
            Storage::delete('public/uploads/rps/ver_files/' . $oldData->file_verifikasi);
        }
    
        // Menyimpan file baru jika diunggah
        $filename = null;
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = time() . '_' . $file->getClientOriginalName(); // Menambahkan timestamp untuk menghindari duplikasi nama
            $path = 'public/uploads/rps/ver_files/';
            $file->storeAs($path, $filename);
        }
    
        // Menyiapkan data untuk diupdate
        $data = [
            'rep_rps_id' => $request->id_rep_rps,
            'dosen_id' => $request->nama_dosen,
            'tanggal_diverifikasi' => $request->date,
        ];
    
        // Hanya menambahkan field 'file_verifikasi' jika file baru diunggah
        if ($filename !== null) {
            $data['file_verifikasi'] = $filename;
        }
    
        // Menambahkan field 'status_ver_rps' dan 'catatan' jika diisi
        if ($request->filled('status')) {
            $data['status_ver_rps'] = $request->status;
        }
    
        if ($request->filled('catatan')) {
            $data['catatan'] = $request->catatan;
        }
    
        // Update data
        VerRpsUas::where('id_ver_rps', $id)->update($data);
        return redirect()->route('ver_rps')->with('success', 'Data berhasil diperbarui.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_ver_rps = VerRpsUas::where('id_ver_rps_uas', $id)->first();

        // Menghapus file terkait jika ada
        if ($data_ver_rps && $data_ver_rps->file_verifikasi) {
            Storage::delete('public/uploads/rps/ver_files/' . $data_ver_rps->file_verifikasi);
        }

        // Menghapus data dari basis data jika ada
        if ($data_ver_rps) {
            $data_ver_rps->delete();
        }

        return redirect()->route('ver_rps')->with('success', 'Data berhasil dihapus.');


        //dd($data_matkul);
    }
}
