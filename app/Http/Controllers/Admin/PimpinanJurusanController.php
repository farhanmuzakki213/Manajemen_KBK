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
            $differences = json_decode($request->differences, true);
            //dd($differences);
            foreach ($differences as $data) {
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
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
        return redirect()->route('pimpinanjurusan')->with('success', 'Data berhasil ditambahkan.');
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
                // Mengambil data dari database berdasarkan urutan descending id_kurikulum
                $dataBase_pimpinanjurusan = PimpinanJurusan::with('r_dosen')->get()->pluck('r_dosen.nidn')->toArray();
                //dd($dataBase_pimpinanprodi);
                $data = $response->json();
                $dataAPI_pimpinanjurusan = $data['list'];
                $differencesArray = collect($dataAPI_pimpinanjurusan)->reject(function ($item) use ($dataBase_pimpinanjurusan) {
                    return in_array($item['nidn'], $dataBase_pimpinanjurusan);
                })->all();
                //dd($dataBase_pimpinanprodi);
                debug($dataBase_pimpinanjurusan);
                debug($dataAPI_pimpinanjurusan);
                debug($differencesArray);

                return view('admin.content.admin.DataAPI.pimpinanjurusanAPI', ['data_pimpinanjurusan' => $dataAPI_pimpinanjurusan, 'differences' => $differencesArray]);
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
