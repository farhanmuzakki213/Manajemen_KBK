<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\ProposalTAModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ReviewProposalTAModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function example(){
        return view('admin.content.example');
    }

    public function RepProposalTA()
    {
        $data_rep_proposal = ProposalTAModel::with('r_mahasiswa', 'r_pembimbing_satu', 'r_pembimbing_dua', 'r_jenis_kbk')
            ->orderByDesc('id_proposal_ta')
            ->get();

        return view('admin.content.admin.rep_proposal_ta', compact('data_rep_proposal'));
    }

    public function storeAPI(Request $request)
    {
        DB::beginTransaction();
        try {
            $differences = json_decode($request->differences, true);
            //dd($differences);
            $file_default = 'none';
            $jenis_kbk_default = 5;
            foreach ($differences as $data) {
                $nextNumber = $this->getCariNomor();
                $data_mahasiswa = Mahasiswa::where('nim', $data['nim'])->pluck('id_mahasiswa')->first();
                debug($data_mahasiswa);
                $data_pembimbing_satu = Dosen::where('nidn', $data['pembimbing_satu_nidn'])->pluck('id_dosen')->first();
                debug($data_pembimbing_satu);
                $data_pembimbing_dua = Dosen::where('nidn', $data['pembimbing_dua_nidn'])->pluck('id_dosen')->first();
                debug($data_pembimbing_dua);
                $data_create =[
                    'id_proposal_ta' => $nextNumber,  
                    'mahasiswa_id' => $data_mahasiswa,
                    'judul' => $data['judul'],
                    'file_proposal' => $file_default,
                    'pembimbing_satu' => $data_pembimbing_satu,
                    'pembimbing_dua' => $data_pembimbing_dua,
                    'jenis_kbk_id' => $jenis_kbk_default,
                ];
                //dd($data_create);
                ProposalTAModel::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
        return redirect()->route('mahasiswa')->with('success', 'Data berhasil ditambahkan.');
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_proposal_ta  = ProposalTAModel::pluck('id_proposal_ta')->toArray();
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_proposal_ta )) {
                return $i;
                break;
            }
        }
        return $i;
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=mahasiswa&file=proposal');

            if ($response->successful()) {
                $dataBase_proposalta = ProposalTAModel::with('r_mahasiswa')->get()->pluck('r_mahasiswa.nim')->toArray();
                //dd($dataBase_mahasiswa);
                $data = $response->json();
                $dataAPI_proposalta = $data['list'];
                $differencesArray = collect($dataAPI_proposalta)->reject(function ($item) use ($dataBase_proposalta) {
                    return in_array($item['nim'], $dataBase_proposalta);
                })->all();
                //dd($differencesArray);
                debug($dataBase_proposalta);
                debug($dataAPI_proposalta);
                debug($differencesArray);

                return view('admin.content.admin.DataAPI.proposaltaAPI', ['data_proposalta' => $dataAPI_proposalta, 'differences' => $differencesArray]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.proposaltaAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.proposaltaAPI')->with('error', 'Exception occurred');
        }
    }

}
