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
            $differences = json_decode($request->differences, true);
            //dd($differences);
            $gender_default = 'gender';
            foreach ($differences as $data) {
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
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
        return redirect()->route('mahasiswa')->with('success', 'Data berhasil ditambahkan.');
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
                $dataBase_mahasiswa = Mahasiswa::orderByDesc('id_mahasiswa')->pluck('nim')->toArray();
                //dd($dataBase_mahasiswa);
                $data = $response->json();
                $dataAPI_mahasiswa = $data['list'];
                $differencesArray = collect($dataAPI_mahasiswa)->reject(function ($item) use ($dataBase_mahasiswa) {
                    return in_array($item['nim'], $dataBase_mahasiswa);
                })->all();
                //dd($differencesArray);
                debug($dataBase_mahasiswa);
                debug($dataAPI_mahasiswa);
                debug($differencesArray);

                return view('admin.content.admin.DataAPI.mahasiswaAPI', ['data_mahasiswa' => $dataAPI_mahasiswa, 'differences' => $differencesArray]);
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
