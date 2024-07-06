<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dosen;
use App\Models\DosenKBK;
use App\Models\JenisKbk;
use Illuminate\Http\Request;
use App\Exports\ExportDosenKBK;
use App\Imports\ImportDosenKBK;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DosenKBKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_dosen_kbk = DosenKBK::with(['r_jenis_kbk', 'r_dosen'])->orderByDesc('id_dosen_kbk')->get();

        return view('admin.content.admin.dosen_kbk', compact('data_dosen_kbk'));

    }

    public function export_excel(){
        return Excel::download(new ExportDosenKBK, "Dosen KBK.xlsx");
    }

  

    public function import(Request $request)
    {
        try {
            Excel::import(new ImportDosenKBK, $request->file('file'));
            return redirect('dosen_kbk')->with('success', 'Data berhasil diimpor.');
        } catch (ValidationException $e) {
            $errorMessages = $e->errors()['duplicate_data'] ?? [];
            return redirect()->back()->withErrors(['error' => $errorMessages]);
        } catch (\Exception $e) {
            Log::error('General Exception: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_dosen = Dosen::all();
        $data_jenis_kbk = JenisKbk::all();
        $nextNumber = $this->getCariNomor();

        return view('admin.content.admin.form.dosen_kbk_form', compact('data_dosen', 'data_jenis_kbk', 'nextNumber'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen_kbk' => 'required',
            'jenis_kbk' => 'required',
            'nama_dosen' => 'required|unique:dosen_kbk,dosen_id'
        ], [
            'nama_dosen.unique' => 'Nama dosen sudah ada di dalam tabel.',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_dosen_kbk' => $request->id_dosen_kbk,
            'jenis_kbk_id' => $request->jenis_kbk,
            'dosen_id' => $request->nama_dosen
        ];
        DosenKBK::create($data);
        return redirect()->route('dosen_kbk');
        //dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_dosen = Dosen::all();
        $data_jenis_kbk = JenisKbk::all();
    
        $detail_dosen_kbk = DosenKBK::where('id_dosen_kbk', $id)->first();
        
        return view('admin.content.admin.dosen_kbk', compact('data_dosen', 'data_jenis_kbk', 'detail_dosen_kbk'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        
        $data_dosen = Dosen::all();
        $data_jenis_kbk = JenisKbk::all();

        //dd(compact('data_dosen', 'data_jabatan_kbk', 'data_jenis_kbk'));


        $data_dosen_kbk = DosenKBK::where('id_dosen_kbk', $id)->first();
        //dd($data_pengurus_kbk);

        return view('admin.content.admin.form.dosen_kbk_edit', compact('data_dosen', 'data_jenis_kbk', 'data_dosen_kbk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen_kbk' => 'required',
            'jenis_kbk' => 'required',
            'nama_dosen' => 'required|unique:dosen_kbk,dosen_id,'. $id .',id_dosen_kbk',
        ], [
            'nama_dosen.unique' => 'Nama dosen sudah ada di dalam tabel.',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_dosen_kbk' => $request->id_dosen_kbk,
            'jenis_kbk_id' => $request->jenis_kbk,
            'dosen_id' => $request->nama_dosen
        ];
        $DosenKBK = DosenKBK::where('id_dosen_kbk', $id)->first();
        if($DosenKBK){
            $DosenKBK->update($data);
        }
        return redirect()->route('dosen_kbk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, string $id)
    {
        $data_dosen_kbk = DosenKBK::where('id_dosen_kbk', $id)->first();

        if ($data_dosen_kbk) {
            $data_dosen_kbk->delete();
        }
        return redirect()->route('dosen_kbk');

        //dd($data_pengurus_kbk);
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_dosen_kbk = DosenKbk::pluck('id_dosen_kbk')->toArray();

        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_dosen_kbk)) {
                return $i;
                break;
            }
        }
        return $i;
    }

}