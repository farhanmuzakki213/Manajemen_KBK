<?php

namespace App\Http\Controllers;

use App\Models\Matkul;
use Illuminate\Http\Request;
use App\Exports\ExportMatkul;
use App\Imports\ImportMatkul;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


class MatkulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_matkul = DB::table('matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('smt_thnakd', 'matkul.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select('matkul.*', 'kurikulum.*', 'smt_thnakd.*')
            ->orderByDesc('id_matkul')
            ->get();
        return view('admin.content.Matkul', compact('data_matkul'));
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
        $data_kurikulum = DB::table('kurikulum')->get();
        $data_smt_thnakd = DB::table('smt_thnakd')->get();
        //dd('$data_kurikulum');
        return view('admin.content.form.matkul_form', compact('data_kurikulum', 'data_smt_thnakd'));
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
            'smt_thnakd' => 'required',

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
            'smt_thnakd_id' => $request->smt_thnakd,
        ];
        Matkul::create($data);
        return redirect()->route('matkul');
        //dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $data_matkul = Matkul::findOrFail($id);
    $data_kurikulum = DB::table('kurikulum')->get();
    $data_smt_thnakd = DB::table('smt_thnakd')->get();
    //dd($data_smt_thnakd);
    return view('admin.content.Matkul', compact('data_matkul', 'data_kurikulum', 'data_smt_thnakd'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_kurikulum = DB::table('kurikulum')->get();
        $data_smt_thnakd = DB::table('smt_thnakd')->get();
        //dd('$data_kurikulum');
        //dd($data_smt_thnakd);
        $data_matkul = Matkul::where('id_matkul', $id)->first();

        //dd($data_matkul);
        return view('admin.content.form.matkul_edit', compact('data_matkul', 'data_kurikulum', 'data_smt_thnakd'));
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
            'smt_thnakd' => 'required',

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
            'smt_thnakd_id' => $request->smt_thnakd,
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
}
