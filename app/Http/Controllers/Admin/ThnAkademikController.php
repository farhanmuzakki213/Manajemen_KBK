<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThnAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ThnAkademikController extends Controller
{
    public function __construct() {
        $this->middleware('permission:admin-view ThnAkademik', ['only' => ['index']]);
        $this->middleware('permission:admin-sinkronData ThnAkademik', ['only' => ['storeAPI', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_thnakd = ThnAkademik::orderByDesc('id_smt_thnakd')->get();
        return view('admin.content.admin.thnakademik', compact('data_thnakd'));
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
                $data_ThnAkademik = ThnAkademik::where('id_smt_thnakd', $data['id_smt_thnakd'])->first();
                //dd($data_dosen);
                if ($data_ThnAkademik) {
                    $data_ThnAkademik->delete();
                }
            }
            foreach ($differences_api as $data) {
                $data_create =[
                    'id_smt_thnakd' => $data['id_smt_thn_akd'],
                    'kode_smt_thnakd' => $data['kode_smt_thnakd'],
                    'smt_thnakd' => $data['smt_thn_akd'],
                    'status_smt_thnakd' => $data['status'],
                ];
                //dd($data_create);
                ThnAkademik::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyinkronkan data: ' . $e->getMessage());
        }
        return redirect()->route('thnakademik')->with('success', 'Data berhasil disinkronkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=jurusan&file=thn_ta');

            if ($response->successful()) {
                // Mengambil data dari database berdasarkan urutan descending id_ThnAkademik
                $dataBase_ThnAkademik = ThnAkademik::orderByDesc('id_smt_thnakd')->pluck('smt_thnakd')->toArray();
                
                // Mengambil data dari respons API
                $data = $response->json();
                $dataAPI_ThnAkademik = $data['list'];
                foreach ($dataAPI_ThnAkademik as &$item) {
                    $item['smt_thn_akd'] = str_replace('\/', '/', $item['smt_thn_akd']);
                }
                foreach ($dataAPI_ThnAkademik as &$item) {
                    // Replace backslashes
                    $item['smt_thn_akd'] = str_replace('\/', '/', $item['smt_thn_akd']);
                    
                    // Extract year and semester type
                    $year = substr($item['smt_thn_akd'], 0, 4);
                    $semester_type = substr($item['smt_thn_akd'], -5);
                    
                    // Determine the numeric semester type
                    $numeric_semester_type = ($semester_type === 'Genap') ? '2' : '1';
                    
                    // Create the new formatted string
                    $item['kode_smt_thnakd'] = $year . $numeric_semester_type;
                }
                //dd($dataAPI_ThnAkademik);

                // Mencari data yang ada di API tapi tidak ada di database
                $differencesArray = collect($dataAPI_ThnAkademik)->reject(function ($item) use ($dataBase_ThnAkademik) {
                    return in_array($item['smt_thn_akd'], $dataBase_ThnAkademik);
                })->all();

                // Mencari data yang ada di database tapi tidak ada di API
                $differencesArrayDatabase = collect($dataBase_ThnAkademik)->reject(function ($smt_thnakd) use ($dataAPI_ThnAkademik) {
                    return in_array($smt_thnakd, array_column($dataAPI_ThnAkademik, 'smt_thn_akd'));
                })->all();

                // Data yang berbeda dari database dalam format array asosiatif
                $differencesArrayDatabaseFormatted = ThnAkademik::whereIn('smt_thnakd', $differencesArrayDatabase)->get()->toArray();

                debug($dataBase_ThnAkademik);
                debug($dataAPI_ThnAkademik);
                debug($differencesArray);
                debug($differencesArrayDatabase);
                debug($differencesArrayDatabaseFormatted);

                return view('admin.content.admin.DataAPI.thnakdAPI', [
                    'data_ThnAkademik' => $dataAPI_ThnAkademik,
                    'differences_api' => $differencesArray,
                    'differences_db' => $differencesArrayDatabaseFormatted
                ]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.thnakdAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.thnakdAPI')->with('error', 'Exception occurred');
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
