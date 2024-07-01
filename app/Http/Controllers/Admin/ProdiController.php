<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Prodi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_prodi = Prodi::with('r_jurusan')->orderByDesc('id_prodi')->get();

        return view('admin.content.admin.prodi', compact('data_prodi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function storeAPI(Request $request)
    {
        DB::beginTransaction();
        try {
            $differences_api = json_decode($request->differences_api, true);
            $differences_db = json_decode($request->differences_db, true);
            //dd($differences_api, $differences_db);
            foreach ($differences_db as $data) {
                $data_prodi = Prodi::where('id_prodi', $data['id_prodi'])->first();
                //dd($data_dosen);
                if ($data_prodi) {
                    Prodi::where('id_prodi', $data['id_prodi'])->delete();
                }
            }
            foreach ($differences_api as $data) {
                $data_create =[
                    'id_prodi' => $data['id_prodi'],
                    'kode_prodi' => $data['kode_prodi'],
                    'prodi' => $data['prodi'],
                    'jurusan_id' => $data['id_jurusan'],
                    'jenjang' => $data['id_jenjang'],
                ];
                //dd($data_create);
                Prodi::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyinkronkan data: ' . $e->getMessage());
        }
        return redirect()->route('prodi')->with('success', 'Data berhasil disinkronkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=jurusan&file=prodi');

            if ($response->successful()) {
                // Mengambil data dari database berdasarkan urutan descending id_prodi
                $dataBase_prodi = Prodi::orderByDesc('id_prodi')->pluck('kode_prodi')->toArray();
                
                // Mengambil data dari respons API
                $data = $response->json();
                $dataAPI_prodi = $data['list'];

                // Mencari data yang ada di API tapi tidak ada di database
                $differencesArray = collect($dataAPI_prodi)->reject(function ($item) use ($dataBase_prodi) {
                    return in_array($item['kode_prodi'], $dataBase_prodi);
                })->all();

                // Mencari data yang ada di database tapi tidak ada di API
                $differencesArrayDatabase = collect($dataBase_prodi)->reject(function ($kode_prodi) use ($dataAPI_prodi) {
                    return in_array($kode_prodi, array_column($dataAPI_prodi, 'kode_prodi'));
                })->all();

                // Data yang berbeda dari database dalam format array asosiatif
                $differencesArrayDatabaseFormatted = Prodi::with('r_jurusan')->whereIn('kode_prodi', $differencesArrayDatabase)->get()->toArray();

                debug($dataBase_prodi);
                debug($dataAPI_prodi);
                debug($differencesArray);
                debug($differencesArrayDatabaseFormatted);

                return view('admin.content.admin.DataAPI.prodiAPI', [
                    'data_prodi' => $dataAPI_prodi,
                    'differences_api' => $differencesArray,
                    'differences_db' => $differencesArrayDatabaseFormatted
                ]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.prodiAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.prodiAPI')->with('error', 'Exception occurred');
        }
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
