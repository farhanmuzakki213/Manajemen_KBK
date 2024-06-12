<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportDosenPengampuMatkul;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DosenPengampuMatkul;
use App\Models\Matkul;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DosenPengampuMatkulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_dosen_pengampu = DosenPengampuMatkul::with(['p_matkulKbk.r_matkul', 'p_kelas', 'r_dosen', 'r_smt_thnakd']) 
            ->orderByDesc('id_dosen_matkul')
            ->get();
        return view('admin.content.admin.DosenPengampuMatkul', compact('data_dosen_pengampu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function export_excel(){
        return Excel::download(new ExportDosenPengampuMatkul, "Matkul_Ampu.xlsx");
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
