<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Kurikulum extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_kurikulum = DB::table('kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select('kurikulum.*', 'prodi.prodi')
            ->orderByDesc('id_kurikulum')
            ->get();
        return view('admin.content.admin.Kurikulum', compact('data_kurikulum'));
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
