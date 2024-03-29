<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Matkul extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_matkul = DB::table('matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->select('matkul.*', 'kurikulum.nama_kurikulum')
            ->orderByDesc('id_matkul')
            ->get();
        return view('admin.content.Matkul', compact('data_matkul'));
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
