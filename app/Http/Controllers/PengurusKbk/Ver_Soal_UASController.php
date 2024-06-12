<?php

namespace App\Http\Controllers\PengurusKbk;

use App\Models\Dosen;
use App\Models\Ver_UAS;
use App\Models\RepRpsUas;
use App\Models\VerRpsUas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
        $data_ver_soal_uas = VerRpsUas:: with('r_dosen', 'r_rep_rps_uas.r_smt_thnakd')
        ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
            $query->where('status_smt_thnakd', '=', '1'); 
        })
        ->orderByDesc('id_ver_rps_uas')
        ->get();

        $data_rep_soal_uas = RepRpsUas:: with('r_dosen', 'r_matkulKbk', 'r_smt_thnakd')
        ->whereHas('r_smt_thnakd', function ($query) {
            $query->where('status_smt_thnakd', '=', '1'); 
        })
        ->orderByDesc('id_rep_rps_uas')
        ->get();
        debug($data_rep_soal_uas);
        return view('admin.content.pengurusKbk.Ver_Soal_UAS', compact('data_ver_soal_uas', 'data_rep_soal_uas'));
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

        $nextNumber = $this->getCariNomor();
        $data_dosen = DB::table('dosen')->get();
        $data_dosen = Dosen::all();
        $data_rep_soal_uas = RepRpsUas::where('type', '=', '0')
            ->orderByDesc('id_rep_rps_uas')
            ->get();
        debug(compact('data_dosen', 'data_rep_soal_uas', 'nextNumber'));
        return view('admin.content.pengurusKbk.form.ver_soal_uas_form', compact('data_dosen', 'data_rep_soal_uas', 'nextNumber'));
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
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_ver_uas' => 'required',
            'id_rep_uas' => 'required',
            'nama_dosen' => 'required',
            'upload_file' => 'nullable|mimes:pdf',
            'status' => 'nullable|in:0,1', // Status hanya bisa 0 atau 1
            'saran' => 'nullable|in:0,1,2,3', // Saran hanya bisa 0, 1, atau 2
            'catatan' => 'nullable|string',
            'date' => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    
        // Mengatur nilai default jika status tidak diisi
        $status = $request->input('status', '0'); // Default to '0' (Tidak Diverifikasi)
        $saran = '0'; // Default to '0' (Tidak Layak Dipakai)
        $catatan = 'Soal UAS Belum Diverifikasi';
    
        // Memperbarui catatan berdasarkan saran yang dipilih jika status diverifikasi (1)
        if ($status == '1') {
            if (!$request->filled('saran')) {
                return redirect()->back()->withInput()->withErrors(['saran' => 'Silakan pilih saran jika status diverifikasi dipilih.']);
            }
    
            // Ubah catatan berdasarkan saran yang dipilih
            switch ($saran) {
                case '3':
                    $catatan = 'Soal layak dipakai';
                    break;
                case '2':
                    // Tidak ada perubahan, catatan harus diisi oleh pengguna
                    break;
                case '1':
                    $catatan = 'Soal tidak layak dipakai';
                    break;
                case '0':
                default:
                    $catatan = 'Soal Belum Diverifikasi';
                    break;
            }
        }
    
        // Mengatur nama file jika ada file yang diunggah
        $filename = '';
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName();
            $path = 'public/uploads/uas/ver_files/';
            $file->storeAs($path, $filename);
        }
    
        // Menyiapkan data untuk disimpan
        $data = [
            'id_ver_uas' => $request->id_ver_uas,
            'rep_uas_id' => $request->id_rep_uas,
            'dosen_id' => $request->nama_dosen,
            'status_ver_uas' => $status, // Pastikan ini adalah string yang sesuai dengan ENUM
            'saran' => $saran,
            'catatan' => $catatan,
            'tanggal_diverifikasi' => $request->date,
        ];
    
        if ($filename !== '') {
            $data['file_verifikasi'] = $filename;
        }
    
        // Menyimpan data ke database
        VerRpsUas::create($data);
    
        return redirect()->route('ver_soal_uas')->with('success', 'Data berhasil disimpan.');
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
    
        $data_ver_soal_uas = VerRpsUas::where('id_ver_rps_uas', $id)->first();
        $data_rep_soal_uas = RepRpsUas::with('r_dosen', 'r_matkulKbk', 'r_smt_thnakd')
            ->where('rep_rps_uas.id_rep_uas', $data_ver_soal_uas->rep_rps_uas_id)  // Perbaiki query untuk mengambil data rep_rps yang sesuai  // Karena ini seharusnya satu record
            ->orderByDesc('id_rep_uas')
            ->get();

            debug(compact('data_dosen', 'data_rep_soal_uas', 'data_ver_soal_uas'));
        return view('admin.content.pengurusKbk.form.ver_soal_uas_edit', compact('data_dosen', 'data_rep_soal_uas', 'data_ver_soal_uas'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_ver_uas' => 'required',
            'id_rep_uas' => 'required',
            'nama_dosen' => 'required',
            'upload_file' => 'nullable|mimes:pdf', // File tidak wajib diunggah
            'status' => 'nullable',
            'saran' => 'nullable',
            'date' => 'required|date',
        ]);

         // Aturan validasi untuk catatan menjadi opsional
         $validator->sometimes('saran', 'nullable', function ($input) {
            return !$input->hasFile('upload_file'); // Catatan hanya opsional jika file tidak diunggah
        });

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        
        // Mendapatkan data lama
        $oldData = VerRpsUas::find($id);

        // Memeriksa apakah ada file lama
        if ($oldData->file_verifikasi !== null && $request->hasFile('upload_file')) {
            // Hapus file lama dari storage
            Storage::delete('public/uploads/uas/ver_files/' . $oldData->file_verifikasi);
        }

        // Memastikan file telah diunggah sebelum menyimpannya
        $filename = null;
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/uas/ver_files/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya
        }

        // Menyimpan catatan hanya jika diisi
        $status = $request->filled('status') ? $request->status : null;
        $saran = $request->filled('saran') ? $request->saran : null;
        $catatan = $request->filled('catatan') ? $request->catatan : null;
        

        $data = [
            'id_ver_uas' => $request->id_ver_uas,
            'rep_uas_id' => $request->id_rep_uas,
            'dosen_id' => $request->nama_dosen,
            'tanggal_diverifikasi' => $request->date,
        ];

        // Hanya menambahkan field 'file' jika file diunggah
        if ($filename !== null) {
            $data['file_verifikasi'] = $filename;
        }

        // Hanya menambahkan field 'status_ver_rps' jika diisi
        if ($status !== null) {
            $data['status_ver_uas'] = $status;
        }

        // Hanya menambahkan field 'catatan' jika diisi
        if ($saran !== null) {
            $data['saran'] = $saran;
        }
        if ($catatan !== null) {
            $data['catatan'] = $catatan;
        }


        //dd($request->all());
        VerRpsUas::where('id_ver_uas', $id)->update($data);
        return redirect()->route('ver_soal_uas')->with('success', 'Data berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_ver_soal_uas = VerRpsUas::where('id_ver_uas', $id)->first();

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
