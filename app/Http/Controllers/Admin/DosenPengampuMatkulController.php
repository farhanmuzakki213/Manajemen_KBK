<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dosen;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DosenPengampuMatkul;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportDosenPengampuMatkul;
use App\Models\Kelas;
use App\Models\MatkulKBK;
use App\Models\ThnAkademik;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DosenPengampuMatkulController extends Controller
{
    public function __construct() {
        $this->middleware('permission:admin-view DosenMatkul', ['only' => ['index']]);
        $this->middleware('permission:admin-create DosenMatkul', ['only' => ['create', 'store', 'getCariNomor']]);
        $this->middleware('permission:admin-update DosenMatkul', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-delete DosenMatkul', ['only' => ['delete']]);
        $this->middleware('permission:admin-sinkronData DosenMatkul', ['only' => ['storeAPI', 'show', 'getCariNomor']]);
        $this->middleware('permission:admin-export DosenMatkul', ['only' => ['export_excel']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_dosen_pengampu = DosenPengampuMatkul::with(['p_matkulKbk.r_matkul', 'p_kelas', 'r_dosen', 'r_smt_thnakd'])
            ->orderByDesc('id_dosen_matkul')
            ->get();
        return view('admin.content.admin.DosenPengampuMatkul', compact('data_dosen_pengampu'));
    }

    /**
     * Show the form for creating a new resource.
     */


    public function export_excel()
    {
        return Excel::download(new ExportDosenPengampuMatkul, "Matkul_Ampu.xlsx");
    }


    public function create()
    {
        $data_dosen = Dosen::all();
        $data_smt = ThnAkademik::all();
        $nextNumber = $this->getCariNomor();

        // debug($nextNumber);

        return view('admin.content.admin.form.DosenPengampuMatkul_form', compact('data_dosen', 'data_smt', 'nextNumber'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen_matkul' => 'required',
            'nama_dosen' => 'required|unique:dosen_matkul,dosen_id',
            'smt_thnakd' => 'required',
        ], [
            'nama_dosen.unique' => 'Nama dosen sudah ada di dalam tabel.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = [
            'id_dosen_matkul' => $request->id_dosen_matkul,
            'dosen_id' => $request->nama_dosen,
            'smt_thnakd_id' => $request->smt_thnakd,
        ];

        DosenPengampuMatkul::create($data);

        return redirect()->route('DosenPengampuMatkul');

        //dd($request->all());
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_dosen = Dosen::all();
        $data_smt = ThnAkademik::all();

        $data_dosen_pengampu = DosenPengampuMatkul::where('id_dosen_matkul', $id)->first();
        //dd(compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk'));

        return view('admin.content.admin.form.DosenPengampuMatkul_edit', compact('data_dosen', 'data_smt', 'data_dosen_pengampu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen_matkul' => 'required',
            'nama_dosen' => 'required|unique:dosen_matkul,dosen_id,' . $id . ',id_dosen_matkul',
            'smt_thnakd' => 'required',
        ], [
            'nama_dosen.unique' => 'Nama dosen sudah ada di dalam tabel.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = [
            'id_dosen_matkul' => $request->id_dosen_matkul,
            'dosen_id' => $request->nama_dosen,
            'smt_thnakd_id' => $request->smt_thnakd,
        ];

        $DosenPengampuMatkul = DosenPengampuMatkul::where('id_dosen_matkul', $id)->first();
        if ($DosenPengampuMatkul) {
            $DosenPengampuMatkul->update($data);
        }
        return redirect()->route('DosenPengampuMatkul');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_dosen_pengampu = DosenPengampuMatkul::where('id_dosen_matkul', $id)->first();

        if ($data_dosen_pengampu) {
            $data_dosen_pengampu->delete();
        }
        return redirect()->route('DosenPengampuMatkul');
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_dosen_matkul = DosenPengampuMatkul::pluck('id_dosen_matkul')->toArray();

        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_dosen_matkul)) {
                return $i;
                break;
            }
        }
        return $i;
    }

    public function storeAPI(Request $request)
    {
        DB::beginTransaction();
        try {
            $differences_api = json_decode($request->differences_api, true);
            $differences_db = json_decode($request->differences_db, true);
            //dd($differences_api, $differences_db);
            foreach ($differences_db as $data) {
                $data_dosen_matkul = DosenPengampuMatkul::where('id_dosen_matkul', $data['id_dosen_matkul'])->first();
                //dd($data_kurikulum);
                if ($data_dosen_matkul) {
                    $data_dosen_matkul->delete();
                }
            }
            foreach ($differences_api as $data) {
                $data_dosen = Dosen::where('nidn', $data['nidn'])->first();
                $data_dosen_matkul = DosenPengampuMatkul::whereHas('r_dosen', function($query) use ($data) {
                    $query->where('nidn', $data['nidn']);
                })->first();
                $data_smt_thnakd = ThnAkademik::where('smt_thnakd', $data['smt_thn_akd'])->first();
                $data_matkul_kbk = MatkulKBK::whereHas('r_matkul', function($query) use ($data) {
                    $query->where('kode_matkul', $data['kode_matakuliah']);
                })->first();
                
                $data_kelas = Kelas::where('kode_kelas', $data['kode_kelas'])->first();
                $nextNumber = $this->getCariNomor();
                //dd($data_dosen);
                $data_create = [
                    'id_dosen_matkul' => $nextNumber,
                    'dosen_id' => $data_dosen->id_dosen,
                    'smt_thnakd_id' => $data_smt_thnakd->id_smt_thnakd,
                ];
                DosenPengampuMatkul::create($data_create);
                $data_detail = [
                    'dosen_matkul_id' => $data_dosen_matkul->id_dosen_matkul,
                    'matkul_kbk_id' => $data_matkul_kbk->id_matkul_kbk,
                    'kelas_id' => $data_kelas->id_kelas,
                ];
                
                DB::table('dosen_matkul_detail_pivot')->insert($data_detail);
                
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyinkronkan data: ' . $e->getMessage());
        }
        return redirect()->route('DosenPengampuMatkul')->with('success', 'Data berhasil disinkronkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=dosen&file=matakuliah');

            if ($response->successful()) {
                // Mengambil data dari database

                $dataBase_dosen_matkul = DosenPengampuMatkul::with(['p_matkulKbk', 'p_kelas', 'r_dosen'])
                    ->orderByDesc('id_dosen_matkul')
                    ->get()
                ->map(function ($item) {
                        return [
                            'nidn' => $item->r_dosen->nidn,
                            'kode_matakuliah' => $item->p_matkulKbk->first()->r_matkul->kode_matkul ?? null,
                            'kode_kelas' => $item->p_kelas->first()->kode_kelas ?? null
                        ];
                    })
                    ->toArray();

                // Mengambil data dari respons API
                $data = $response->json();
                $dataAPI_dosen_matkul = $data['list'];

                // Perbandingan data
                $differencesArray = collect($dataAPI_dosen_matkul)->reject(function ($item) use ($dataBase_dosen_matkul) {
                    return collect($dataBase_dosen_matkul)->contains(function ($dbItem) use ($item) {
                        return $dbItem['nidn'] === $item['nidn'] &&
                            $dbItem['kode_matakuliah'] === $item['kode_matakuliah'] &&
                            $dbItem['kode_kelas'] === $item['kode_kelas'];
                    });
                })->all();

                $differencesArrayDatabase = collect($dataBase_dosen_matkul)->reject(function ($dbItem) use ($dataAPI_dosen_matkul) {
                    return collect($dataAPI_dosen_matkul)->contains(function ($item) use ($dbItem) {
                        return $dbItem['nidn'] === $item['nidn'] &&
                            $dbItem['kode_matakuliah'] === $item['kode_matakuliah'] &&
                            $dbItem['kode_kelas'] === $item['kode_kelas'];
                    });
                })->all();

                // Data yang berbeda dari database dalam format array asosiatif
                $differencesArrayDatabaseFormatted = DosenPengampuMatkul::whereHas('r_dosen', function ($query) use ($differencesArrayDatabase) {
                    $query->whereIn('nidn', array_column($differencesArrayDatabase, 'nidn'));
                })
                    ->whereHas('p_matkulKbk.r_matkul', function ($query) use ($differencesArrayDatabase) {
                        $query->whereIn('kode_matkul', array_column($differencesArrayDatabase, 'kode_matakuliah'));
                    })
                    ->whereHas('p_kelas', function ($query) use ($differencesArrayDatabase) {
                        $query->whereIn('kode_kelas', array_column($differencesArrayDatabase, 'kode_kelas'));
                    })
                    ->with('r_dosen', 'p_kelas', 'p_matkulKbk.r_matkul', 'r_smt_thnakd')
                    ->get()
                    ->toArray();

                debug($dataBase_dosen_matkul);
                debug($dataAPI_dosen_matkul);
                debug($differencesArray);
                debug($differencesArrayDatabaseFormatted);

                return view('admin.content.admin.DataAPI.dosenmatkulAPI', [
                    'data_dosen_matkul' => $dataAPI_dosen_matkul,
                    'differences_api' => $differencesArray,
                    'differences_db' => $differencesArrayDatabaseFormatted
                ]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.dosenmatkulAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.dosenmatkulAPI')->with('error', 'Exception occurred');
        }
    }
}
