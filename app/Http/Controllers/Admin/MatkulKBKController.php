<?php

namespace App\Http\Controllers\Admin;

use App\Models\Matkul;
use App\Models\JenisKbk;
use App\Models\Kurikulum;
use App\Models\MatkulKBK;
use Illuminate\Http\Request;
use App\Exports\ExportMatkul;
use App\Imports\ImportMatkul;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportMatakuliahKBK;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


class MatkulKBKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_matkul_kbk = MatkulKBK::with('r_kurikulum', 'r_jenis_kbk', 'r_matkul', 'p_dosenPengampuMatkul')
            ->orderByDesc('id_matkul_kbk')
            ->get();
            //dd($data_matkul_kbk);
        return view('admin.content.admin.matkul_kbk', compact('data_matkul_kbk'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_kurikulum = Kurikulum::all();
        $data_matkul = Matkul::all();
        $data_jenis_kbk = JenisKbk::all();
        $nextNumber = $this->getCariNomor();

        //dd(compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk'));

        return view('admin.content.admin.form.matkul_kbk_form', compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk', 'nextNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_matkul_kbk' => 'required',
            'nama_matkul' => 'required|unique:matkul_kbk,matkul_id',
            'jenis_kbk' => 'required',
            'kurikulum' => 'required',
        ], [
            'nama_matkul.unique' => 'Matkul sudah ada di dalam tabel.',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_matkul_kbk' => $request->id_matkul_kbk,
            'matkul_id' => $request->nama_matkul,
            'jenis_kbk_id' => $request->jenis_kbk,
            'kurikulum_id' => $request->kurikulum,
        ];
        MatkulKBK::create($data);
        return redirect()->route('matkul_kbk');
        //dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $data_matkul = MatkulKBK::findOrFail($id);
    $data_kurikulum = Kurikulum::all();

    return view('admin.content.admin.Matkul', compact('data_matkul', 'data_kurikulum'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id){

    
        $data_kurikulum = Kurikulum::all();
        $data_matkul = Matkul::all();
        $data_jenis_kbk = JenisKbk::all();

        $data_matkul_kbk = MatkulKBK::where('id_matkul_kbk', $id)->first();
        //dd(compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk'));

        return view('admin.content.admin.form.matkul_kbk_edit', compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk', 'data_matkul_kbk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_matkul_kbk' => 'required',
            'nama_matkul' => 'required|unique:matkul_kbk,matkul_id,'. $id .',id_matkul_kbk',
            'jenis_kbk' => 'required',
            'kurikulum' => 'required',
        ], [
            'nama_matkul.unique' => 'Matkul sudah ada di dalam tabel.',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_matkul_kbk' => $request->id_matkul_kbk,
            'matkul_id' => $request->nama_matkul,
            'jenis_kbk_id' => $request->jenis_kbk,
            'kurikulum_id' => $request->kurikulum,
        ];
        MatkulKBK::where('id_matkul_kbk', $id)->update($data);
        return redirect()->route('matkul_kbk');
        //dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_matkul = MatkulKBK::where('id_matkul_kbk', $id)->first();

        if ($data_matkul) {
            MatkulKBK::where('id_matkul_kbk', $id)->delete();
        }
        return redirect()->route('matkul_kbk');

        //dd($data_matkul);
    }

    public function export_excel(){
        return Excel::download(new ExportMatakuliahKBK, "Matakuliah KBK.xlsx");
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_matkul_kbk = MatkulKBK::pluck('id_matkul_kbk')->toArray();

        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_matkul_kbk)) {
                return $i;
                break;
            }
        }
        return $i;
    }

}
