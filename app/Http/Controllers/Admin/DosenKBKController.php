<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportDosenKBK;
use App\Http\Controllers\Controller;
use App\Imports\ImportDosenKBK;
use App\Models\DosenKBK;
use App\Models\Dosen;
use App\Models\JenisKbk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DosenKBKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_dosen_kbk = DosenKBK::with(['r_jenis_kbk', 'r_dosen'])->orderByDesc('id_dosen_kbk')->get();

        return view('admin.content.admin.dosen_kbk', compact('data_dosen_kbk'));

    }

    public function export_excel(){
        return Excel::download(new ExportDosenKBK, "Dosen KBK.xlsx");
    }

    public function import(Request $request){
        Excel::import(new ImportDosenKBK, $request->file('file'));
        return redirect('dosen_kbk');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_dosen = Dosen::all();
        $data_jenis_kbk = JenisKbk::all();

        return view('admin.content.admin.form.dosen_kbk_form', compact('data_dosen', 'data_jenis_kbk'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen_kbk' => 'required',
            'jenis_kbk' => 'required',
            'nama_dosen' => 'required'

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_dosen_kbk' => $request->id_dosen_kbk,
            'jenis_kbk_id' => $request->jenis_kbk,
            'dosen_id' => $request->nama_dosen
        ];
        DosenKBK::create($data);
        return redirect()->route('dosen_kbk');
        //dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_dosen = Dosen::all();
        $data_jenis_kbk = JenisKbk::all();
    
        $detail_dosen_kbk = DosenKBK::where('id_dosen_kbk', $id)->first();
        
        return view('admin.content.admin.dosen_kbk', compact('data_dosen', 'data_jenis_kbk', 'detail_dosen_kbk'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $data_dosen = Dosen::all();
        $data_jenis_kbk = JenisKbk::all();

        //dd(compact('data_dosen', 'data_jabatan_kbk', 'data_jenis_kbk'));


        $data_dosen_kbk = DosenKBK::where('id_dosen_kbk', $id)->first();
        //dd($data_pengurus_kbk);

        return view('admin.content.admin.form.dosen_kbk_edit', compact('data_dosen', 'data_jenis_kbk', 'data_dosen_kbk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen_kbk' => 'required',
            'jenis_kbk' => 'required',
            'nama_dosen' => 'required'

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_dosen_kbk' => $request->id_dosen_kbk,
            'jenis_kbk_id' => $request->jenis_kbk,
            'dosen_id' => $request->nama_dosen
        ];
        DosenKBK::where('id_dosen_kbk', $id)->update($data);
        return redirect()->route('dosen_kbk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, string $id)
    {
        $data_dosen_kbk = DosenKBK::where('id_dosen_kbk', $id)->first();

        if ($data_dosen_kbk) {
            DosenKBK::where('id_dosen_kbk', $id)->delete();
        }
        return redirect()->route('dosen_kbk');

        //dd($data_pengurus_kbk);
    }
}