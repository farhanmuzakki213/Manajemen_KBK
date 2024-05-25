<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rep_Soal_UASController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_rep_soal_uas = DB::table('ver_uas')
        ->join('dosen', 'ver_uas.dosen_id', '=', 'dosen.id_dosen')
        ->join('rep_uas', 'ver_uas.rep_uas_id', '=', 'rep_uas.id_rep_uas')
        ->join('matkul', 'rep_uas.matkul_id', '=', 'matkul.id_matkul')
        ->join('smt_thnakd', 'rep_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
        ->select('ver_uas.*', 'ver_uas.*', 'rep_uas.*', 'dosen.*', 'matkul.*', 'smt_thnakd.*')
        ->where('smt_thnakd.status_smt_thnakd', '=', '1')
        ->orderByDesc('id_ver_uas')
        ->get();
        debug($data_rep_soal_uas);
        return view('admin.content.Rep_Soal_UAS', compact('data_rep_soal_uas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('admin.content.uas');
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
