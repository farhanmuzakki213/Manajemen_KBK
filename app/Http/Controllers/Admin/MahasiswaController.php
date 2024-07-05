<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mahasiswa;
use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_mahasiswa = Mahasiswa::with('r_prodi', 'r_jurusan')
            ->orderByDesc('id_mahasiswa')
            ->get();
        return view('admin.content.admin.mahasiswa', compact('data_mahasiswa'));
    }

    public function storeAPI(Request $request)
    {
        DB::beginTransaction();
        try {
            $differences_api = json_decode($request->differences_api, true);
            $differences_db = json_decode($request->differences_db, true);
            //dd($differences_api, $differences_db);
            foreach ($differences_db as $data) {
                $data_mahasiswa = Mahasiswa::where('id_mahasiswa', $data['id_mahasiswa'])->first();
                //dd($data_kurikulum);
                if ($data_mahasiswa) {
                    $data_mahasiswa->delete();
                }
            }
            $gender_default = 'gender';
            foreach ($differences_api as $data) {
                $nextNumber = $this->getCariNomor();
                $data_jurusan = Jurusan::where('kode_jurusan', $data['kode_jurusan'])->pluck('id_jurusan')->first();
                debug($data_jurusan);
                $data_prodi = Prodi::where('kode_prodi', $data['kode_prodi'])->pluck('id_prodi')->first();
                debug($data_prodi);
                $data_create =[
                    'id_mahasiswa' => $nextNumber,  
                    'nim' => $data['nim'],
                    'nama' => $data['nama'],
                    'jurusan_id' => $data_jurusan,
                    'prodi_id' => $data_prodi,
                    'gender' => $data['gender'] ? : $gender_default,
                ];
                //dd($data_create);
                Mahasiswa::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyinkronkan data: ' . $e->getMessage());
        }
        return redirect()->route('mahasiswa')->with('success', 'Data berhasil disinkronkan.');
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_mahasiswa  = Mahasiswa::pluck('id_mahasiswa')->toArray();
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_mahasiswa )) {
                return $i;
                break;
            }
        }
        return $i;
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=mahasiswa&file=index');

            if ($response->successful()) {
                // Mengambil data dari database berdasarkan urutan descending id_mahasiswa
                $dataBase_mahasiswa = Mahasiswa::orderByDesc('id_mahasiswa')->pluck('nim')->toArray();
                
                // Mengambil data dari respons API
                $data = $response->json();
                $dataAPI_mahasiswa = $data['list'];

                // Mencari data yang ada di API tapi tidak ada di database
                $differencesArray = collect($dataAPI_mahasiswa)->reject(function ($item) use ($dataBase_mahasiswa) {
                    return in_array($item['nim'], $dataBase_mahasiswa);
                })->all();

                // Mencari data yang ada di database tapi tidak ada di API
                $differencesArrayDatabase = collect($dataBase_mahasiswa)->reject(function ($nim) use ($dataAPI_mahasiswa) {
                    return in_array($nim, array_column($dataAPI_mahasiswa, 'nim'));
                })->all();

                // Data yang berbeda dari database dalam format array asosiatif
                $differencesArrayDatabaseFormatted = Mahasiswa::with('r_jurusan', 'r_prodi')->whereIn('nim', $differencesArrayDatabase)->get()->toArray();

                debug($dataBase_mahasiswa);
                debug($dataAPI_mahasiswa);
                debug($differencesArray);
                debug($differencesArrayDatabaseFormatted);

                return view('admin.content.admin.DataAPI.mahasiswaAPI', [
                    'data_mahasiswa' => $dataAPI_mahasiswa,
                    'differences_api' => $differencesArray,
                    'differences_db' => $differencesArrayDatabaseFormatted
                ]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.mahasiswaAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.mahasiswaAPI')->with('error', 'Exception occurred');
        }
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
}
