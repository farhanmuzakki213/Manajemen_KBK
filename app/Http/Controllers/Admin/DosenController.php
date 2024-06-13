<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_dosen = Dosen::with('r_jurusan', 'r_prodi')
            ->orderByDesc('id_dosen')
            ->get();
        return view('admin.content.admin.dosen', compact('data_dosen'));
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
        $data = [
            'nama_dosen'=>$request->nama_dosen,
            'nidn'=>$request->nidn,
            'nip'=>$request->nip,
            'gender'=>$request->gender,
            'jurusan'=>$request->jurusan,
            'prodi'=>$request->prodi,
            'image'=>$request->image,
            'status'=>$request->status

        ];

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_dosen = Dosen::with(['r_jurusan', 'r_prodi'])->findOrFail($id);
        $data_jurusan = Jurusan::all();
        $data_prodi = Prodi::all();
    
        return view('admin.content.Dosen', compact('data_dosen', 'data_jurusan', 'data_prodi'));
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
