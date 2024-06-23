<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_jurusan = Jurusan::orderByDesc('id_jurusan')->get();
        return view('admin.content.admin.jurusan', compact('data_jurusan'));
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
                // Simpan data ke dalam tabel 'jurusans'
                $data_create =[
                    'id_jurusan' => $data['id_jurusan'],
                    'kode_jurusan' => $data['kode_jurusan'],
                    'jurusan' => $data['jurusan'],
                ];
                //dd($data_create);
                Jurusan::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
        return redirect()->route('jurusan')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=jurusan&file=jurusan');

            if ($response->successful()) {
                // Mengambil data dari database berdasarkan urutan descending id_jurusan
                $dataBase_jurusan = Jurusan::orderByDesc('id_jurusan')->pluck('kode_jurusan')->toArray();

                // Mengambil data dari respons API
                $data = $response->json();
                $dataAPI_jurusan = $data['list'];

                // Memfilter data API yang tidak ada di database
                $differencesArray = collect($dataAPI_jurusan)->reject(function ($item) use ($dataBase_jurusan) {
                    return in_array($item['kode_jurusan'], $dataBase_jurusan);
                })->all();

                debug($dataBase_jurusan);
                debug($dataAPI_jurusan);
                debug($differencesArray);

                return view('admin.content.admin.DataAPI.jurusanAPI', ['data_jurusan' => $dataAPI_jurusan, 'differences' => $differencesArray]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.jurusanAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.jurusanAPI')->with('error', 'Exception occurred');
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
    public function update(Request $request)
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
