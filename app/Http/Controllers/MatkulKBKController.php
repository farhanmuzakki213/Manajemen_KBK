<?php

namespace App\Http\Controllers;

use App\Models\MatkulKBK;
use Illuminate\Http\Request;
use App\Exports\ExportMatkul;
use App\Imports\ImportMatkul;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


class MatkulKBKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_matkul_kbk = DB::table('matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->select('matkul_kbk.*', 'kurikulum.*','jenis_kbk.*','matkul.*')
            ->orderByDesc('id_matkul_kbk')
            ->get();
            //dd($data_matkul_kbk);
        return view('admin.content.matkul_kbk', compact('data_matkul_kbk'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_kurikulum = DB::table('kurikulum')->get();
        $data_matkul = DB::table('matkul')->get();
        $data_jenis_kbk = DB::table('jenis_kbk')->get();

        //dd(compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk'));

        return view('admin.content.form.matkul_kbk_form', compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_matkul_kbk' => 'required',
            'nama_matkul' => 'required',
            'jenis_kbk' => 'required',
            'kurikulum' => 'required',

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
    $data_kurikulum = DB::table('kurikulum')->get();

    return view('admin.content.Matkul', compact('data_matkul', 'data_kurikulum'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id){

    
    $data_kurikulum = DB::table('kurikulum')->get();
    $data_matkul = DB::table('matkul')->get();
    $data_jenis_kbk = DB::table('jenis_kbk')->get();
    
    $data_matkul_kbk = MatkulKBK::where('id_matkul_kbk', $id)->first();
        //dd(compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk'));

        return view('admin.content.form.matkul_kbk_edit', compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk', 'data_matkul_kbk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_matkul_kbk' => 'required',
            'nama_matkul' => 'required',
            'jenis_kbk' => 'required',
            'kurikulum' => 'required',

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
}
