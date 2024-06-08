<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PimpinanJurusan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pimpinan_jurusan = DB::table('pimpinan_jurusan')
            ->join('jurusan', 'pimpinan_jurusan.jurusan_id', '=', 'jurusan.id_jurusan')
            ->join('dosen', 'pimpinan_jurusan.dosen_id', '=', 'dosen.id_dosen')
            ->join('jabatan_pimpinan', 'pimpinan_jurusan.jabatan_pimpinan_id', '=', 'jabatan_pimpinan.id_jabatan_pimpinan')
            ->select('pimpinan_jurusan.id_pimpinan_jurusan', 'pimpinan_jurusan.periode', 'pimpinan_jurusan.status_pimpinan_jurusan', 'jurusan.jurusan', 'dosen.nama_dosen', 'jabatan_pimpinan.jabatan_pimpinan')
            ->orderByDesc('id_pimpinan_jurusan')
            ->get();
        return view('admin.content.admin.pimpinanjurusan', compact('data_pimpinan_jurusan'));
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
