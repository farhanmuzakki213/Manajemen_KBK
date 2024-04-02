<?php

namespace App\Http\Controllers;

use App\Models\JenisKbk;
use Illuminate\Http\Request;
use App\Exports\ExportJenisKbk;
use App\Imports\ImportJenisKbk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class JenisKbkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_jenis_kbk = DB::table('jenis_kbk')
            ->orderByDesc('id_jenis_kbk')
            ->get();
        return view('admin.content.jenis_kbk', compact('data_jenis_kbk'));
    }

    public function export_excel(){
        return Excel::download(new ExportJenisKbk, "Datakbk.xlsx");
    }

    public function import(Request $request){
        Excel::import(new ImportJenisKbk, $request->file('file'));
        return redirect('data_kbk');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.content.form.jenis_kbk_form');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_kbk' => 'required',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'jenis_kbk' => $request->jenis_kbk,
            'deskripsi' => $request->deskripsi,
        ];
        JenisKbk::create($data);
        return redirect()->route('jenis_kbk');
        //dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_jenis_kbk = JenisKbk::where('id_jenis_kbk', $id)->first();
        //dd($data_jenis_kbk);
        return view('admin.content.form.jenis_kbk_edit', compact('data_jenis_kbk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_kbk' => 'required',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'jenis_kbk' => $request->jenis_kbk,
            'deskripsi' => $request->deskripsi,
        ];
        JenisKbk::where('id_jenis_kbk', $id)->update($data);
        return redirect()->route('jenis_kbk');
        //dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_jenis_kbk = JenisKbk::where('id_jenis_kbk', $id)->first();

        if ($data_jenis_kbk) {
            JenisKbk::where('id_jenis_kbk', $id)->delete();
        }
        return redirect()->route('jenis_kbk');

        //dd($data_jenis_kbk);
    }
}
