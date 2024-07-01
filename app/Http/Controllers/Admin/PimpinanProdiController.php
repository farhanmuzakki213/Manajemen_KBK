<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\PimpinanProdi;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PimpinanProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pimpinan_prodi = PimpinanProdi::with('r_dosen', 'r_prodi', 'r_jabatan_pimpinan')
            ->orderByDesc('id_pimpinan_prodi')
            ->get();
        return view('admin.content.admin.pimpinanprodi', compact('data_pimpinan_prodi'));
    }

    public function storeAPI(Request $request)
    {
        DB::beginTransaction();
        try {
            $differences_api = json_decode($request->differences_api, true);
            $differences_db = json_decode($request->differences_db, true);
            //dd($differences_api, $differences_db);
            foreach ($differences_db as $data) {
                $data_pimpinanprodi = PimpinanProdi::where('id_pimpinan_prodi', $data['id_pimpinan_prodi'])->first();
                //dd($data_kurikulum);
                if ($data_pimpinanprodi) {
                    PimpinanProdi::where('id_pimpinan_prodi', $data['id_pimpinan_prodi'])->delete();
                }
            }
            $jabatan_pimpinan_id = 3;
            foreach ($differences_api as $data) {
                $nextNumber = $this->getCariNomor();
                $data_prodi = Prodi::where('kode_prodi', $data['kode_prodi'])->pluck('id_prodi')->first();
                debug($data_prodi);
                $data_dosen = Dosen::where('nidn', $data['nidn'])->pluck('id_dosen')->first();
                debug($data_dosen);
                $data_create =[
                    'id_pimpinan_prodi' => $nextNumber,
                    'jabatan_pimpinan_id' => $jabatan_pimpinan_id,
                    'prodi_id' => $data_prodi,
                    'dosen_id' => $data_dosen ,
                    'periode' => $data['periode'],
                    'status_pimpinan_prodi' => $data['status'],
                ];
                //dd($data_create);
                PimpinanProdi::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyinkronkan data: ' . $e->getMessage());
        }
        return redirect()->route('pimpinanprodi')->with('success', 'Data berhasil disinkronkan.');
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_pimpinan_prodi = PimpinanProdi::pluck('id_pimpinan_prodi')->toArray();
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_pimpinan_prodi)) {
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
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=jurusan&file=kaprodi');

            if ($response->successful()) {
                // Mengambil data dari database berdasarkan urutan descending id_pimpinanprodi
                $dataBase_pimpinanprodi = PimpinanProdi::with('r_dosen')->get()->pluck('r_dosen.nidn')->toArray();
                //dd($dataBase_pimpinanprodi);
                // Mengambil data dari respons API
                $data = $response->json();
                $dataAPI_pimpinanprodi = $data['list'];

                // Mencari data yang ada di API tapi tidak ada di database
                $differencesArray = collect($dataAPI_pimpinanprodi)->reject(function ($item) use ($dataBase_pimpinanprodi) {
                    return in_array($item['nidn'], $dataBase_pimpinanprodi);
                })->all();

                // Mencari data yang ada di database tapi tidak ada di API
                $differencesArrayDatabase = collect($dataBase_pimpinanprodi)->reject(function ($nidn) use ($dataAPI_pimpinanprodi) {
                    return in_array($nidn, array_column($dataAPI_pimpinanprodi, 'nidn'));
                })->all();

                // Data yang berbeda dari database dalam format array asosiatif
                $differencesArrayDatabaseFormatted = PimpinanProdi::whereHas('r_dosen', function($query) use ($differencesArrayDatabase) {
                    $query->whereIn('nidn', $differencesArrayDatabase);
                })->with('r_dosen', 'r_prodi')->get()->toArray();
                

                debug($dataBase_pimpinanprodi);
                debug($dataAPI_pimpinanprodi);
                debug($differencesArray);
                debug($differencesArrayDatabaseFormatted);

                return view('admin.content.admin.DataAPI.pimpinanprodiAPI', [
                    'data_pimpinanprodi' => $dataAPI_pimpinanprodi,
                    'differences_api' => $differencesArray,
                    'differences_db' => $differencesArrayDatabaseFormatted
                ]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.pimpinanprodiAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.pimpinanprodiAPI')->with('error', 'Exception occurred');
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
