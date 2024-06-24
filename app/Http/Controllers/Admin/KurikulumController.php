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
            $differences = json_decode($request->differences, true);
            //dd($differences);
            foreach ($differences as $data) {
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
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
        return redirect()->route('kurikulum')->with('success', 'Data berhasil ditambahkan.');
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
                // Memfilter data API yang tidak ada di database
                $differencesArray = collect($dataAPI_kurikulum)->reject(function ($item) use ($dataBase_kurikulum) {
                    return in_array($item['kode_kurikulum'], $dataBase_kurikulum);
                })->all();
                debug($dataBase_kurikulum);
                debug($dataAPI_kurikulum);
                //debug($differencesArray);

                return view('admin.content.admin.DataAPI.kurikulumAPI', ['data_kurikulum' => $dataAPI_kurikulum, 'differences' => $differencesArray]);
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
