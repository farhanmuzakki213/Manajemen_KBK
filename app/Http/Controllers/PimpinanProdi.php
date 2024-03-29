<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PimpinanProdi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pimpinan_prodi = DB::table('pimpinan_prodi')
            ->join('prodi', 'pimpinan_prodi.prodi_id', '=', 'prodi.id_prodi')
            ->join('dosen', 'pimpinan_prodi.dosen_id', '=', 'dosen.id_dosen')
            ->join('jabatan_pimpinan', 'pimpinan_prodi.jabatan_pimpinan_id', '=', 'jabatan_pimpinan.id_jabatan_pimpinan')
            ->select('pimpinan_prodi.*', 'prodi.prodi', 'dosen.nama_dosen', 'jabatan_pimpinan.jabatan_pimpinan')
            ->orderByDesc('id_pimpinan_prodi')
            ->get();
        return view('admin.content.pimpinanprodi', compact('data_pimpinan_prodi'));
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
