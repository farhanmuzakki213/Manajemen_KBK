<?php

namespace App\Http\Controllers\DosenKbk;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\DosenKBK;
use App\Models\Mahasiswa;
use App\Models\ProposalTAModel;
use App\Models\ReviewProposalTaDetailPivot;
use App\Models\ReviewProposalTAModel;
use Barryvdh\Debugbar\Facades\Debugbar as FacadesDebugbar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReviewProposalTAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $dosen_kbk = DosenKBK::whereHas('r_dosen', function ($query) use ($user, $user_email) {
            $query->where('nama_dosen', $user)
                ->where('email', $user_email);
        })->first();
        return $dosen_kbk;
    }



    public function index()
    {
        $dosen_kbk = $this->getDosen();
        // debug($dosen_kbk);

        $data_review_proposal_ta = ReviewProposalTAModel::where(function ($query) use ($dosen_kbk) {
            $query->where('reviewer_satu', $dosen_kbk->id_dosen_kbk)
                ->orWhere('reviewer_dua', $dosen_kbk->id_dosen_kbk);
        })->with('proposal_ta.r_mahasiswa', 'p_reviewDetail')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();

        debug($data_review_proposal_ta->toArray());


        $id_penugasan_array = $data_review_proposal_ta->pluck('id_penugasan')->toArray();

        // debug($id_penugasan_array);

        // Ambil penugasan hanya untuk dosen yang terpilih sebagai reviewer pada tabel review
        $data_review_proposal_ta_detail = ReviewProposalTaDetailPivot::whereHas('p_reviewProposal', function ($query) use ($dosen_kbk) {
            $query->where(function ($query) use ($dosen_kbk) {
                $query->where('reviewer_satu', $dosen_kbk->id_dosen_kbk)
                    ->orWhere('reviewer_dua', $dosen_kbk->id_dosen_kbk);
            });
        })->with('p_reviewProposal.proposal_ta.r_mahasiswa')
            ->whereIn('penugasan_id', $id_penugasan_array)
            ->orderByDesc('review_proposal_ta_detail_pivot.penugasan_id')
            ->get();

        // debug($data_review_proposal_ta_detail->toArray());

        $id_penugasan_detail = $data_review_proposal_ta_detail->pluck('penugasan_id')->toArray();
        debug($id_penugasan_detail);


        // Mengambil reviewer_satu dan reviewer_dua dari setiap item di $data_review_proposal_ta_detail
        $reviewer_data = $data_review_proposal_ta_detail->map(function ($item) use ($dosen_kbk) {
            // Inisialisasi reviewer sebagai null
            $reviewer = null;

            // Cek apakah dosen_kbk adalah reviewer_satu
            if ($item->p_reviewProposal->reviewer_satu == $dosen_kbk->id_dosen_kbk) {
                $reviewer = '1';
            }

            // Cek apakah dosen_kbk adalah reviewer_dua
            if ($item->p_reviewProposal->reviewer_dua == $dosen_kbk->id_dosen_kbk) {
                $reviewer = '2';
            }

            // Kembalikan objek baru hanya dengan atribut penugasan_id dan reviewer
            return (object)[
                'penugasan_id' => $item->penugasan_id,
                'dosen' => $reviewer
            ];
        })
            ->filter(function ($item) {
                // Hanya kembalikan item di mana reviewer (dosen) bukan null
                return !is_null($item->dosen);
            });

            debug($reviewer_data->toArray());

         


        $data_proposal_ta = ProposalTAModel::orderByDesc('id_proposal_ta')->get();


        $dosen_values = $reviewer_data->pluck('dosen')->toArray(); // Ambil nilai dosen dan ubah menjadi array

        // debug($dosen_values);
        
        $dosen_value = $reviewer_data->pluck('dosen')->first();
        
        debug($dosen_value);

        $data_detail = $data_review_proposal_ta_detail->filter(function ($item) use ($dosen_values) {
            return in_array($item->dosen, $dosen_values);
        });

        // debug($data_detail->toArray());

        // Ambil review proposal TA hanya untuk dosen yang terpilih sebagai reviewer pada tabel penugasan


        return view('admin.content.dosenKbk.review_proposal_ta', compact('data_detail', 'id_penugasan_detail', 'data_proposal_ta', 'data_review_proposal_ta'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        // Cek apakah penugasan sudah ada
        $cek_data = ReviewProposalTaDetailPivot::where('penugasan_id', $id)->first();

        if ($cek_data) {
            // Jika sudah ada, kembalikan ke halaman dengan pesan error
            return redirect()->route('PenugasanReview')->with('error', 'Data sudah diambil.');
        }

        $nextNumber = $this->getCariNomor();
        $dosen_kbk = $this->getDosen();
        $data_dosen_kbk = DosenKBK::where('jenis_kbk_id', $dosen_kbk->jenis_kbk_id)->get();

        $penugasan_id = $id;

        $data_review_proposal_ta = ReviewProposalTAModel::where(function ($query) use ($dosen_kbk) {
            $query->where('reviewer_satu', $dosen_kbk->id_dosen_kbk)
                ->orWhere('reviewer_dua', $dosen_kbk->id_dosen_kbk);
        })->with('proposal_ta.r_mahasiswa', 'p_reviewDetail')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();

        // debug($data_review_proposal_ta->toArray());

        $reviewer_data = $data_review_proposal_ta->map(function ($item) use ($dosen_kbk, $penugasan_id) {
            // Inisialisasi reviewer sebagai null
            $reviewer = null;

            // Cek apakah dosen_kbk adalah reviewer_satu dan id_penugasan cocok
            if ($item->reviewer_satu == $dosen_kbk->id_dosen_kbk && $item->id_penugasan == $penugasan_id) {
                $reviewer = 'reviewer_satu';
            }

            // Cek apakah dosen_kbk adalah reviewer_dua dan id_penugasan cocok
            if ($item->reviewer_dua == $dosen_kbk->id_dosen_kbk && $item->id_penugasan == $penugasan_id) {
                $reviewer = 'reviewer_dua';
            }

            // Tambahkan peran reviewer ke setiap item
            $item->reviewer_role = $reviewer;
            return $item;
        })
            ->filter(function ($item) {
                // Hanya kembalikan item di mana reviewer_role bukan null
                return !is_null($item->reviewer_role);
            });

        debug($reviewer_data->toArray());



        return view('admin.content.dosenKbk.form.review_proposal_ta_form', compact('data_dosen_kbk', 'reviewer_data', 'penugasan_id', 'nextNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penugasan_id' => 'required',
            'reviewer' => 'required',
            'status' => 'required',
            'catatan' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }



        // Buat entri baru di ReviewProposalTAModel
        $data = [
            'penugasan_id' => $request->penugasan_id, // Auto-generate jika tidak diberikan
            'dosen' => $request->reviewer,
            'status_review_proposal' => $request->status,
            'catatan' => $request->catatan,
            'tanggal_review' => $request->date,
        ];

        ReviewProposalTaDetailPivot::create($data);

        // Set pesan keberhasilan
        return redirect()->route('review_proposal_ta')->with('success', 'Data berhasil dibuat');
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'penugasan_id' => 'required',
    //         'catatan' => 'nullable|string',
    //         'date' => 'required|date',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withInput()->withErrors($validator);
    //     }

    //     try {
    //         DB::beginTransaction();

    //         // Ambil penugasan_id dari request
    //         $penugasan_id = $request->penugasan_id;

    //         // Loop untuk setiap reviewer yang ada
    //         foreach ($request->reviewer as $reviewer) {
    //             $statusKey = 'status_' . $reviewer;

    //             // Simpan data sesuai dengan reviewer yang aktif
    //             $data = [
    //                 'penugasan_id' => $penugasan_id,
    //                 'dosen' => $reviewer,
    //                 'status_review_proposal' => $request->input($statusKey),
    //                 'catatan' => $request->catatan,
    //                 'tanggal_review' => $request->date,
    //             ];

    //             // Simpan data
    //             ReviewProposalTaDetailPivot::create($data);
    //         }

    //         DB::commit();

    //         return redirect()->route('review_proposal_ta')->with('success', 'Data berhasil disimpan');
    //     } catch (\Exception $e) {
    //         DB::rollback();

    //         return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan data. ' . $e->getMessage()]);
    //     }
    // }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_dosen = Dosen::all();
        $data_mahasiswa = Mahasiswa::all();
        $data_proposal_ta = ProposalTAModel::all();
        return view('admin.content.dosenKbk.review_proposal_ta', compact('data_dosen', 'data_proposal_ta', 'data_mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_dosen = Dosen::all();
        $data_review_proposal_ta_detail = ReviewProposalTaDetailPivot::with('p_reviewProposal.reviewer_dua_dosen.r_dosen', 'p_reviewProposal.reviewer_satu_dosen.r_dosen')->where('penugasan_id', $id)
            ->first();
        /* ->join('dosen as dosen_satu', 'review_proposal_ta.reviewer_satu', '=', 'dosen_satu.id_dosen')
            ->join('dosen as dosen_dua', 'review_proposal_ta.reviewer_dua', '=', 'dosen_dua.id_dosen')
            ->select('review_proposal_ta.*', 'dosen_satu.nama_dosen as reviewer_satu_nama', 'dosen_dua.nama_dosen as reviewer_dua_nama')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            */
        debug(compact('data_dosen', 'data_review_proposal_ta_detail'));
        return view('admin.content.dosenKbk.form.review_proposal_ta_edit', compact('data_dosen', 'data_review_proposal_ta_detail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'penugasan_id' => 'required',
            'reviewer' => 'required',
            'status' => 'required',
            'catatan',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data = [
            'penugasan_id' => $request->penugasan_id,
            'dosen' => $request->reviewer,
            'status_review_proposal' => $request->status,
            'catatan' => $request->catatan,
            'tanggal_review' => $request->date,
        ];
        //dd($request->all());
        ReviewProposalTaDetailPivot::where('penugasan_id', $id)->update($data);
        return redirect()->route('review_proposal_ta')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete(string $id, string $dosen)
    {
        $reviewer = ReviewProposalTaDetailPivot::where('penugasan_id', $id)
            ->where('dosen', $dosen)
            ->first();

        if ($reviewer) {
            $reviewer->delete();
            Session::flash('success', 'Data berhasil dihapus');
        } else {
            Session::flash('error', 'Data tidak ditemukan');
        }

        return redirect()->route('review_proposal_ta');
        // dd($reviewer);
    }



    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $penugasan_id = ReviewProposalTaDetailPivot::pluck('penugasan_id')->toArray();

        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $penugasan_id)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
