<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenPengampuMatkul extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_dosen_pengampu = DB::table('dosen_matkul')
            ->join('dosen', 'dosen_matkul.dosen_id', '=', 'dosen.id_dosen')
            ->join('matkul', 'dosen_matkul.matkul_id', '=', 'matkul.id_matkul')
            ->join('kelas', 'dosen_matkul.kelas_id', '=', 'kelas.id_kelas')
            ->join('smt_thnakd', 'dosen_matkul.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select('dosen_matkul.*', 'dosen.nama_dosen', 'matkul.nama_matkul', 'kelas.nama_kelas', 'smt_thnakd.smt_thnakd')
            ->orderByDesc('id_dosen_matkul')
            ->get();
        return view('admin.content.DosenPengampuMatkul', compact('data_dosen_pengampu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
