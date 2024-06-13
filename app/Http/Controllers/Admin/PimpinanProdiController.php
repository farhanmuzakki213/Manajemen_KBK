<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PimpinanProdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PimpinanProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pimpinan_prodi = PimpinanProdi::with('r_dosen', 'r_prodi', 'r_jabatan_pimpinan')
            ->orderByDesc('id_pimpinan_prodi')
            ->get();
        return view('admin.content.admin.pimpinanprodi', compact('data_pimpinan_prodi'));
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
