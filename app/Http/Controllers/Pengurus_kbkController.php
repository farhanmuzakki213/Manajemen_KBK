<?php

namespace App\Http\Controllers;

use App\Models\Pengurus_kbk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Pengurus_kbkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pengurus_kbk = DB::table('pengurus_kbk')
            ->join('jenis_kbk', 'pengurus_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->join('jabatan_kbk', 'pengurus_kbk.jabatan_kbk_id', '=', 'jabatan_kbk.id_jabatan_kbk')
            ->join('dosen', 'pengurus_kbk.dosen_id', '=', 'dosen.id_dosen')
            ->select('pengurus_kbk.*', 'jenis_kbk.jenis_kbk', 'jabatan_kbk.jabatan', 'dosen.nama_dosen')
            ->orderByDesc('id_pengurus')
            ->get();
        return view('admin.content.pengurus_kbk', compact('data_pengurus_kbk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_dosen = DB::table('dosen')->get();
        $data_jabatan_kbk = DB::table('jabatan_kbk')->get();
        $data_jenis_kbk = DB::table('jenis_kbk')->get();

        //dd(compact('data_dosen', 'data_jabatan_kbk', 'data_jenis_kbk'));

        return view('admin.content.form.pengurus_kbk_form', compact('data_dosen', 'data_jabatan_kbk', 'data_jenis_kbk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_kbk' => 'required',
            'nama_dosen' => 'required',
            'jabatan' => 'required',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'jenis_kbk_id' => $request->jenis_kbk,
            'dosen_id' => $request->nama_dosen,
            'jabatan_kbk_id' => $request->jabatan,
        ];
        pengurus_kbk::create($data);
        return redirect()->route('pengurus_kbk');
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
    public function edit(Request $request, string $id)
    {
        $data_dosen = DB::table('dosen')->get();
        $data_jabatan_kbk = DB::table('jabatan_kbk')->get();
        $data_jenis_kbk = DB::table('jenis_kbk')->get();

        //dd(compact('data_dosen', 'data_jabatan_kbk', 'data_jenis_kbk'));


        $data_pengurus_kbk = pengurus_kbk::where('id_pengurus', $id)->first();
        //dd($data_pengurus_kbk);

        return view('admin.content.form.pengurus_kbk_edit', compact('data_dosen', 'data_jabatan_kbk', 'data_jenis_kbk', 'data_pengurus_kbk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_kbk' => 'required',
            'nama_dosen' => 'required',
            'jabatan' => 'required',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'jenis_kbk_id' => $request->jenis_kbk,
            'dosen_id' => $request->nama_dosen,
            'jabatan_kbk_id' => $request->jabatan,
        ];
        pengurus_kbk::where('id_pengurus', $id)->update($data);
        return redirect()->route('pengurus_kbk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, string $id)
    {
        $data_pengurus_kbk = pengurus_kbk::where('id_pengurus', $id)->first();

        if ($data_pengurus_kbk) {
            pengurus_kbk::where('id_pengurus', $id)->delete();
        }
        return redirect()->route('pengurus_kbk');

        //dd($data_pengurus_kbk);
    }
}
