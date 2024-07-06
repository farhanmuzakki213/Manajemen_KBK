<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dosen;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DosenPengampuMatkul;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportDosenPengampuMatkul;
use App\Models\Kelas;
use App\Models\MatkulKBK;
use App\Models\ThnAkademik;
use Illuminate\Support\Facades\Validator;

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


    public function export_excel()
    {
        return Excel::download(new ExportDosenPengampuMatkul, "Matkul_Ampu.xlsx");
    }


    public function create()
    {
        $data_kelas = Kelas::all();
        $data_matkul_kbk = MatkulKBK::all();
        $data_dosen = Dosen::all();
        $data_smt = ThnAkademik::all();
        $data_matkul = DosenPengampuMatkul::all();
        $nextNumber = $this->getCariNomor();

        // debug($data_matkul->toArray());

        // debug($nextNumber);

        return view('admin.content.admin.form.DosenPengampuMatkul_form', compact('data_matkul', 'data_kelas', 'data_matkul_kbk', 'data_dosen', 'data_smt', 'nextNumber'));
    }


    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'id_dosen_matkul' => 'required',
    //         'nama_dosen' => 'required|unique:dosen_matkul,dosen_id',
    //         'smt_thnakd' => 'required',
    //     ], [
    //         'nama_dosen.unique' => 'Nama dosen sudah ada di dalam tabel.',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withInput()->withErrors($validator);
    //     }

    //     $data = [
    //         'id_dosen_matkul' => $request->id_dosen_matkul,
    //         'dosen_id' => $request->nama_dosen,
    //         'smt_thnakd_id' => $request->smt_thnakd,
    //     ];

    //     DosenPengampuMatkul::create($data);

    //     return redirect()->route('DosenPengampuMatkul');

    //     //dd($request->all());
    // }


    public function store(Request $request)
    {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'id_dosen_matkul' => 'required',
                'nama_dosen' => 'required|unique:dosen_matkul,dosen_id',
                'smt_thnakd' => 'required',
                'mata_kuliah_dosen' => 'required|array',
                'kelas' => 'required|array',
            ], [
                'nama_dosen.unique' => 'Nama dosen sudah ada di dalam tabel.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

           
            $data = [
                'id_dosen_matkul' => $request->id_dosen_matkul,
                'dosen_id' => $request->nama_dosen,
                'smt_thnakd_id' => $request->smt_thnakd,
            ];

            DB::beginTransaction();
            try {
            DosenPengampuMatkul::create($data);

           
            $dosenMatkulId = $request->id_dosen_matkul;
            // dd($dosenMatkulId);
         
            foreach ($request->mata_kuliah_dosen as $matkulKbk) {
                foreach ($request->kelas as $kelas) {
                    
                    DB::table('dosen_matkul_detail_pivot')->insert([
                        'dosen_matkul_id' => $dosenMatkulId, 
                        'matkul_kbk_id' => $matkulKbk,
                        'kelas_id' => $kelas
                    ]);
                }
            }


            DB::commit();

            return redirect()->route('DosenPengampuMatkul')->with('success', 'Data berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->route('DosenPengampuMatkul')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_kelas = Kelas::all();
        $data_matkul_kbk = MatkulKBK::all();
        $data_dosen = Dosen::all();
        $data_smt = ThnAkademik::all();
        $data_matkul = DosenPengampuMatkul::all();

        

        return view('admin.content.admin.DosenPengampuMatkul', compact('data_dosen', 'data_smt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_kelas = Kelas::all();
        debug($data_kelas->toArray());
        $data_matkul_kbk = MatkulKBK::all();
        debug($data_matkul_kbk->toArray());
        $data_dosen = Dosen::all();
        debug($data_dosen->toArray());
        $data_smt = ThnAkademik::all();
        debug($data_smt->toArray());
        $data_dosen_pengampu = DosenPengampuMatkul::with(['p_matkulKbk', 'p_kelas', 'r_dosen'])
        ->orderByDesc('id_dosen_matkul')
        ->get()
    ->map(function ($item) {
            return [
                'nidn' => $item->r_dosen->nidn,
                'kode_matakuliah' => $item->p_matkulKbk->first()->r_matkul->kode_matkul ?? null,
                'kode_kelas' => $item->p_kelas->first()->kode_kelas ?? null
            ];
        })
        ->toArray();
        debug($data_dosen_pengampu);


        $data_dosen_pengampu = DosenPengampuMatkul::where('id_dosen_matkul', $id)->first();
        //dd(compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk'));

        return view('admin.content.admin.form.DosenPengampuMatkul_edit', compact('data_dosen', 'data_smt', 'data_dosen_pengampu', 'data_kelas', 'data_matkul_kbk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'id_dosen_matkul' => 'required',
        'nama_dosen' => 'required|unique:dosen_matkul,dosen_id,' . $id . ',id_dosen_matkul',
        'smt_thnakd' => 'required',
        'mata_kuliah_dosen' => 'required|array',
        'kelas' => 'required|array',
    ], [
        'nama_dosen.unique' => 'Nama dosen sudah ada di dalam tabel.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withInput()->withErrors($validator);
    }

    DB::beginTransaction();
    try {
        // Update data dosen pengampu matkul
        $data = [
            'dosen_id' => $request->nama_dosen,
            'smt_thnakd_id' => $request->smt_thnakd,
        ];

        $dosenPengampu = DosenPengampuMatkul::findOrFail($id);
        $dosenPengampu->update($data);

        // Hapus data kelas yang terkait dengan dosen pengampu ini
        $dosenPengampu->p_kelas()->detach();

        // Tambahkan kembali data kelas yang baru dipilih
        foreach ($request->mata_kuliah_dosen as $matkulKbk) {
            foreach ($request->kelas as $kelas) {
                DB::table('dosen_matkul_detail_pivot')->insert([
                    'dosen_matkul_id' => $id, // Menggunakan $id yang diterima dari parameter
                    'matkul_kbk_id' => $matkulKbk,
                    'kelas_id' => $kelas
                ]);
            }
        }

        DB::commit();

        return redirect()->route('DosenPengampuMatkul')->with('success', 'Data berhasil diupdate.');
    } catch (\Throwable $e) {
        DB::rollback();
        return redirect()->route('DosenPengampuMatkul')->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
    }
}



    
    public function delete(string $id)
    {
        $data_dosen_pengampu = DosenPengampuMatkul::where('id_dosen_matkul', $id)->first();

        if ($data_dosen_pengampu) {
            $data_dosen_pengampu->delete();
        }
        return redirect()->route('DosenPengampuMatkul');
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_dosen_matkul = DosenPengampuMatkul::pluck('id_dosen_matkul')->toArray();

        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_dosen_matkul)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
