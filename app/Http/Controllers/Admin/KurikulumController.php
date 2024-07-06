<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kurikulum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KurikulumController extends Controller
{
    public function __construct() {
        $this->middleware('permission:admin-view Kurikulum', ['only' => ['index']]);
        $this->middleware('permission:admin-sinkronData Kurikulum', ['only' => ['store', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_kurikulum = Kurikulum::with('r_prodi')
            ->orderByDesc('id_kurikulum')
            ->get();
        return view('admin.content.admin.Kurikulum', compact('data_kurikulum'));
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
        DB::beginTransaction();
        try {
            $differences_api = json_decode($request->differences_api, true);
            $differences_db = json_decode($request->differences_db, true);
            //dd($differences_api, $differences_db);
            foreach ($differences_db as $data) {
                $data_kurikulum = Kurikulum::where('id_kurikulum', $data['id_kurikulum'])->first();
                //dd($data_kurikulum);
                if ($data_kurikulum) {
                    $data_kurikulum->delete();
                }
            }
            foreach ($differences_api as $data) {
                // Simpan data ke dalam tabel 'kurikulums'
                $data_create =[
                    'id_kurikulum' => $data['id_kurikulum'],
                    'kode_kurikulum' => $data['kode_kurikulum'],
                    'nama_kurikulum' => $data['nama_kurikulum'],
                    'tahun' => $data['tahun'],
                    'prodi_id' => $data['id_prodi'],
                    'status_kurikulum' => $data['status'],
                ];
                //dd($data_create);
                Kurikulum::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyinkronkan data: ' . $e->getMessage());
        }
        return redirect()->route('kurikulum')->with('success', 'Data berhasil disinkronkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=matakuliah&file=kurikulum');

            if ($response->successful()) {
                // Mengambil data dari database berdasarkan urutan descending id_kurikulum
                $dataBase_kurikulum = Kurikulum::orderByDesc('id_kurikulum')->pluck('kode_kurikulum')->toArray();
                
                // Mengambil data dari respons API
                $data = $response->json();
                $dataAPI_kurikulum = $data['list'];

                // Mencari data yang ada di API tapi tidak ada di database
                $differencesArray = collect($dataAPI_kurikulum)->reject(function ($item) use ($dataBase_kurikulum) {
                    return in_array($item['kode_kurikulum'], $dataBase_kurikulum);
                })->all();

                // Mencari data yang ada di database tapi tidak ada di API
                $differencesArrayDatabase = collect($dataBase_kurikulum)->reject(function ($kode_kurikulum) use ($dataAPI_kurikulum) {
                    return in_array($kode_kurikulum, array_column($dataAPI_kurikulum, 'kode_kurikulum'));
                })->all();

                // Data yang berbeda dari database dalam format array asosiatif
                $differencesArrayDatabaseFormatted = Kurikulum::whereIn('kode_kurikulum', $differencesArrayDatabase)->get()->toArray();

                debug($dataBase_kurikulum);
                debug($dataAPI_kurikulum);
                debug($differencesArray);
                debug($differencesArrayDatabaseFormatted);

                return view('admin.content.admin.DataAPI.kurikulumAPI', [
                    'data_kurikulum' => $dataAPI_kurikulum,
                    'differences_api' => $differencesArray,
                    'differences_db' => $differencesArrayDatabaseFormatted
                ]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.kurikulumAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.kurikulumAPI')->with('error', 'Exception occurred');
        }
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
