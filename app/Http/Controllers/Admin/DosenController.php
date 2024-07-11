<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct() {
        $this->middleware('permission:admin-view Dosen', ['only' => ['index']]);
        $this->middleware('permission:admin-create Dosen', ['only' => ['create', 'store', 'getCariNomor']]);
        $this->middleware('permission:admin-update Dosen', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-sinkronData Dosen', ['only' => ['storeAPI', 'show', 'getCariNomor']]);
        $this->middleware('permission:admin-delete Dosen', ['only' => ['delete']]);
    }

    public function index()
    {
        $data_dosen = Dosen::with('r_jurusan', 'r_prodi')
            ->orderByDesc('id_dosen')
            ->get();
        return view('admin.content.admin.dosen', compact('data_dosen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_jurusan = Jurusan::all();
        $data_prodi = Prodi::all();

        return view('admin.content.admin.form.dosen_form', compact('data_jurusan', 'data_prodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen' => 'required',
            'nama_dosen' => 'required',
            'nidn' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'jurusan_id' => 'required',
            'prodi_id' => 'required',
            'email' => 'required',
            'password' => 'required',
            'image' => 'required',
            'status_dosen' => 'required',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_dosen' => $request->id_dosen,
            'nama_dosen' => $request->nama_dosen,
            'nidn' => $request->nidn,
            'nip' => $request->nip,
            'gender' => $request->gender,
            'jurusan_id' => $request->jurusan,
            'prodi_id' => $request->prodi,
            'email' => $request->email,
            'password' => $request->password,
            'image' => $request->image,
            'status_dosen' => $request->status_dosen,
        ];
        Dosen::create($data);
        return redirect()->route('dosen');
    }

    public function edit(string $id)
    {
        $data_jurusan = Jurusan::all();
        $data_prodi = Prodi::all();

        $data_dosen = Dosen::where('id_dosen', $id)->first();
        //dd(compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk'));

        return view('admin.content.admin.form.dosen_edit', compact('data_jurusan', 'data_prodi', 'data_dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen' => 'required',
            'nama_dosen' => 'required',
            'nidn' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'jurusan_id' => 'required',
            'prodi_id' => 'required',
            'email' => 'required',
            'password' => 'required',
            'image' => 'required',
            'status_dosen' => 'required',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_dosen' => $request->id_dosen,
            'nama_dosen' => $request->nama_dosen,
            'nidn' => $request->nidn,
            'nip' => $request->nip,
            'gender' => $request->gender,
            'jurusan_id' => $request->jurusan,
            'prodi_id' => $request->prodi,
            'email' => $request->email,
            'password' => $request->password,
            'image' => $request->image,
            'status_dosen' => $request->status_dosen,
        ];
        $dosen = Dosen::where('id_dosen', $id)->first();
        if($dosen){
            $dosen->update($data);
        }
        return redirect()->route('dosen');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_dosen = Dosen::where('id_dosen', $id)->first();

        if ($data_dosen) {
            $data_dosen->delete();
        }
        return redirect()->route('dosen');
    }

    public function storeAPI(Request $request)
    {
        DB::beginTransaction();
        try {
            $differences_api = json_decode($request->differences_api, true);
            $differences_db = json_decode($request->differences_db, true);
            //dd($differences_api, $differences_db);
            foreach ($differences_db as $data) {
                $data_dosen = Dosen::where('id_dosen', $data['id_dosen'])->first();
                //dd($data_dosen);
                if ($data_dosen) {
                    $data_dosen->delete();
                }
            }
            foreach ($differences_api as $data) {
                $nextNumber = $this->getCariNomor();
                $data_jurusan = Jurusan::where('kode_jurusan', $data['kode_jurusan'])->pluck('id_jurusan')->first();
                debug($data_jurusan);
                $data_prodi = Prodi::where('kode_prodi', $data['kode_prodi'])->pluck('id_prodi')->first();
                debug($data_prodi);
                $data_create = [
                    'id_dosen' => $nextNumber,
                    'nama_dosen' => $data['nama'],
                    'nidn' => $data['nidn'],
                    'nip' => $data['nip'],
                    'gender' => $data['gender'],
                    'jurusan_id' => $data_jurusan,
                    'prodi_id' => $data_prodi,
                    'email' => $data['email'],
                    'password' => Hash::make('12345678'),
                ];
                //dd($data_create);
                Dosen::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyinkronkan data: ' . $e->getMessage());
        }
        return redirect()->route('dosen')->with('success', 'Data berhasil disinkronkan.');
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_dosen = Dosen::pluck('id_dosen')->toArray();
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_dosen)) {
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
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=dosen&file=index');
            if ($response->successful()) {
                // Mengambil data dari database berdasarkan urutan descending id_dosen
                $dataBase_dosen = Dosen::orderByDesc('id_dosen')->pluck('nidn')->toArray();
                $data = $response->json();
                $dataAPI_dosen = $data['list'];

                // Mencari data yang ada di API tapi tidak ada di database
                $differencesArray = collect($dataAPI_dosen)->reject(function ($item) use ($dataBase_dosen) {
                    return in_array($item['nidn'], $dataBase_dosen);
                })->all();

                // Mencari data yang ada di database tapi tidak ada di API
                $differencesArrayDatabase = collect($dataBase_dosen)->reject(function ($nidn) use ($dataAPI_dosen) {
                    return in_array($nidn, array_column($dataAPI_dosen, 'nidn'));
                })->all();

                // Data yang berbeda dari database dalam format array asosiatif
                $differencesArrayDatabaseFormatted = Dosen::with('r_jurusan', 'r_prodi')->whereIn('nidn', $differencesArrayDatabase)->get()->toArray();

                debug($dataBase_dosen);
                debug($dataAPI_dosen);
                debug($differencesArray);
                debug($differencesArrayDatabaseFormatted);

                return view('admin.content.admin.DataAPI.dosenAPI', [
                    'data_dosen' => $dataAPI_dosen,
                    'differences_api' => $differencesArray,
                    'differences_db' => $differencesArrayDatabaseFormatted
                ]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.dosenAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.dosenAPI')->with('error', 'Exception occurred');
        }
    }
}
