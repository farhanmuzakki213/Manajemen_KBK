<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\JabatanPimpinan;
use App\Models\Jurusan;
use App\Models\PimpinanJurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PimpinanJurusanController extends Controller
{
    public function __construct() {
        $this->middleware('permission:admin-view PimpinanJurusan', ['only' => ['index']]);
        $this->middleware('permission:admin-sinkronData PimpinanJurusan', ['only' => ['storeAPI', 'show', 'getCariNomor']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pimpinan_jurusan = PimpinanJurusan::with('r_dosen', 'r_jurusan', 'r_jabatan_pimpinan')
            ->orderByDesc('id_pimpinan_jurusan')
            ->get();
        return view('admin.content.admin.pimpinanjurusan', compact('data_pimpinan_jurusan'));
    }

    public function storeAPI(Request $request)
    {
        DB::beginTransaction();
        try {
            $differences_api = json_decode($request->differences_api, true);
            $differences_db = json_decode($request->differences_db, true);
            //dd($differences_api, $differences_db);
            foreach ($differences_db as $data) {
                $data_pimpinanjurusan = PimpinanJurusan::where('id_pimpinan_jurusan', $data['id_pimpinan_jurusan'])->first();
                //dd($data_kurikulum);
                if ($data_pimpinanjurusan) {
                    $data_pimpinanjurusan->delete();
                }
            }
            foreach ($differences_api as $data) {
                $nextNumber = $this->getCariNomor();
                $data_jurusan = Jurusan::where('kode_jurusan', $data['kode_jurusan'])->pluck('id_jurusan')->first();
                debug($data_jurusan);
                $data_dosen = Dosen::where('nidn', $data['nidn'])->pluck('id_dosen')->first();
                debug($data_dosen);
                $data_jabatan_pimpinan = JabatanPimpinan::where('jabatan_pimpinan', $data['jabatan_pimpinan'])->pluck('id_jabatan_pimpinan')->first();
                debug($data_jabatan_pimpinan);
                $data_create =[
                    'id_pimpinan_jurusan' => $nextNumber,
                    'jabatan_pimpinan_id' => $data_jabatan_pimpinan,
                    'jurusan_id' => $data_jurusan,
                    'dosen_id' => $data_dosen ,
                    'periode' => $data['periode'],
                    'status_pimpinan_jurusan' => $data['status'],
                ];
                //dd($data_create);
                PimpinanJurusan::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyinkronkan data: ' . $e->getMessage());
        }
        return redirect()->route('pimpinanjurusan')->with('success', 'Data berhasil disinkronkan.');
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_pimpinan_jurusan = PimpinanJurusan::pluck('id_pimpinan_jurusan')->toArray();
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_pimpinan_jurusan)) {
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
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=jurusan&file=pimpinan');

            if ($response->successful()) {
                // Mengambil data dari database berdasarkan urutan descending id_pimpinanjurusan
                $dataBase_pimpinanjurusan = PimpinanJurusan::with('r_dosen')->get()->pluck('r_dosen.nidn')->toArray();
                //dd($dataBase_pimpinanjurusan);
                // Mengambil data dari respons API
                $data = $response->json();
                $dataAPI_pimpinanjurusan = $data['list'];

                // Mencari data yang ada di API tapi tidak ada di database
                $differencesArray = collect($dataAPI_pimpinanjurusan)->reject(function ($item) use ($dataBase_pimpinanjurusan) {
                    return in_array($item['nidn'], $dataBase_pimpinanjurusan);
                })->all();

                // Mencari data yang ada di database tapi tidak ada di API
                $differencesArrayDatabase = collect($dataBase_pimpinanjurusan)->reject(function ($nidn) use ($dataAPI_pimpinanjurusan) {
                    return in_array($nidn, array_column($dataAPI_pimpinanjurusan, 'nidn'));
                })->all();

                // Data yang berbeda dari database dalam format array asosiatif
                $differencesArrayDatabaseFormatted = PimpinanJurusan::whereHas('r_dosen', function($query) use ($differencesArrayDatabase) {
                    $query->whereIn('nidn', $differencesArrayDatabase);
                })->with('r_dosen', 'r_jurusan')->get()->toArray();
                

                debug($dataBase_pimpinanjurusan);
                debug($dataAPI_pimpinanjurusan);
                debug($differencesArray);
                debug($differencesArrayDatabaseFormatted);

                return view('admin.content.admin.DataAPI.pimpinanjurusanAPI', [
                    'data_pimpinanjurusan' => $dataAPI_pimpinanjurusan,
                    'differences_api' => $differencesArray,
                    'differences_db' => $differencesArrayDatabaseFormatted
                ]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.pimpinanjurusanAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.pimpinanjurusanAPI')->with('error', 'Exception occurred');
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
