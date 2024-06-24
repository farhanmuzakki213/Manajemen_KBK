<?php

namespace App\Http\Controllers\Admin;

use App\Models\Matkul;
use Illuminate\Http\Request;
use App\Exports\ExportMatkul;
use App\Http\Controllers\Controller;
use App\Imports\ImportMatkul;
use App\Models\Kurikulum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


class MatkulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_matkul = Matkul::with('r_kurikulum')
            ->orderByDesc('id_matkul')
            ->get();
        return view('admin.content.admin.Matkul', compact('data_matkul'));
    }

    public function export_excel(){
        return Excel::download(new ExportMatkul, "Matkul.xlsx");
    }

    public function import(Request $request){
        Excel::import(new ImportMatkul, $request->file('file'));
        return redirect('matkul');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_kurikulum = Kurikulum::all();
        // $data_smt_thnakd = DB::table('smt_thnakd')->get();
        //dd('$data_kurikulum');
        return view('admin.content.admin.form.matkul_form', compact('data_kurikulum'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_matkul' => 'required',
            'kode_matkul' => 'required',
            'nama_matkul' => 'required',
            'tp' => 'required',
            'jam' => 'required',
            'sks' => 'required',
            'sks_teori' => 'required',
            'sks_praktek' => 'required',
            'jam_teori' => 'required',
            'jam_praktek' => 'required',
            'semester' => 'required',
            'kurikulum' => 'required',
            // 'smt_thnakd' => 'required',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_matkul' => $request->id_matkul,
            'kode_matkul' => $request->kode_matkul,
            'nama_matkul' => $request->nama_matkul,
            'TP' => $request->tp,
            'jam' => $request->jam,
            'sks' => $request->sks,
            'sks_teori' => $request->sks_teori,
            'sks_praktek' => $request->sks_praktek,
            'jam_teori' => $request->jam_teori,
            'jam_praktek' => $request->jam_praktek,
            'semester' => $request->semester,
            'kurikulum_id' => $request->kurikulum,
            // 'smt_thnakd_id' => $request->smt_thnakd,
        ];
        Matkul::create($data);
        return redirect()->route('matkul');
        //dd($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_kurikulum = Kurikulum::all();
        // $data_smt_thnakd = DB::table('smt_thnakd')->get();
        //dd('$data_kurikulum');
        //dd($data_smt_thnakd);
        $data_matkul = Matkul::where('id_matkul', $id)->first();

        //dd($data_matkul);
        return view('admin.content.admin.form.matkul_edit', compact('data_matkul', 'data_kurikulum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_matkul' => 'required',
            'kode_matkul' => 'required',
            'nama_matkul' => 'required',
            'tp' => 'required',
            'jam' => 'required',
            'sks' => 'required',
            'sks_teori' => 'required',
            'sks_praktek' => 'required',
            'jam_teori' => 'required',
            'jam_praktek' => 'required',
            'semester' => 'required',
            'kurikulum' => 'required',
            // 'smt_thnakd' => 'required',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_matkul' => $request->id_matkul,
            'kode_matkul' => $request->kode_matkul,
            'nama_matkul' => $request->nama_matkul,
            'TP' => $request->tp,
            'jam' => $request->jam,
            'sks' => $request->sks,
            'sks_teori' => $request->sks_teori,
            'sks_praktek' => $request->sks_praktek,
            'jam_teori' => $request->jam_teori,
            'jam_praktek' => $request->jam_praktek,
            'semester' => $request->semester,
            'kurikulum_id' => $request->kurikulum,
            // 'smt_thnakd_id' => $request->smt_thnakd,
        ];
        Matkul::where('id_matkul', $id)->update($data);
        return redirect()->route('matkul');
        //dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_matkul = Matkul::where('id_matkul', $id)->first();

        if ($data_matkul) {
            Matkul::where('id_matkul', $id)->delete();
        }
        return redirect()->route('matkul');

        //dd($data_matkul);
    }
    public function storeAPI(Request $request)
    {
        DB::beginTransaction();
        try {
            $differences = json_decode($request->differences, true);
            //dd($differences);
            foreach ($differences as $data) {
                $data_create =[
                    'id_matkul' => $data['id_matakuliah'],
                    'kode_matkul' => $data['kode_matakuliah'],
                    'nama_matkul' => $data['nama_matakuliah'],
                    'TP' => $data['TP'],
                    'sks' => $data['sks'],
                    'jam' => $data['jam'],
                    'sks_teori' => $data['sks_teori'],
                    'sks_praktek' => $data['jam_praktek'],
                    'jam_teori' => $data['jam_teori'],
                    'jam_praktek' => $data['jam_praktek'],
                    'semester' => $data['semester'],
                    'kurikulum_id' => $data['id_kurikulum'],
                ];
                //dd($data_create);
                Matkul::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
        return redirect()->route('matkul')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=matakuliah&file=index');

            if ($response->successful()) {
                // Mengambil data dari database berdasarkan urutan descending id_kurikulum
                $dataBase_matkul = Matkul::orderByDesc('id_matkul')->pluck('kode_matkul')->toArray();
                //dd($dataBase_matkul);
                $data = $response->json();
                $dataAPI_matkul = $data['list'];
                $differencesArray = collect($dataAPI_matkul)->reject(function ($item) use ($dataBase_matkul) {
                    return in_array($item['kode_matakuliah'], $dataBase_matkul);
                })->all();
                //dd($differencesArray);
                debug($dataBase_matkul);
                debug($dataAPI_matkul);
                debug($differencesArray);

                return view('admin.content.admin.DataAPI.matkulAPI', ['data_matkul' => $dataAPI_matkul, 'differences' => $differencesArray]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.matkulAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.matkulAPI')->with('error', 'Exception occurred');
        }
    }
}

    
