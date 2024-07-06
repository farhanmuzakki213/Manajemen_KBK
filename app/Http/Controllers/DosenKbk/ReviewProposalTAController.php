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
    public function __construct() {
        $this->middleware('permission:dosenKbk-view ReviewProposalTA', ['only' => ['index', 'getDosen']]);
        $this->middleware('permission:dosenKbk-create ReviewProposalTA', ['only' => ['create', 'store', 'getCariNomor', 'getDosen']]);
        $this->middleware('permission:dosenKbk-update ReviewProposalTA', ['only' => ['edit', 'update', 'getDosen']]);
        $this->middleware('permission:dosenKbk-delete ReviewProposalTA', ['only' => ['delete']]);
    }
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
        /* debug($dosen_kbk); */
        $data_review_proposal_ta = ReviewProposalTAModel::where(function ($query) use ($dosen_kbk) {
            $query->where('reviewer_satu', $dosen_kbk->id_dosen_kbk)
                ->orWhere('reviewer_dua', $dosen_kbk->id_dosen_kbk);
        })->with('proposal_ta.r_mahasiswa', 'p_reviewDetail')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();

        debug($data_review_proposal_ta->toArray());

        $reviewer_data = $data_review_proposal_ta->map(function ($item) use ($dosen_kbk) {
            $reviewer = null;
        
            // Determine the reviewer role
            if ($item->reviewer_satu == $dosen_kbk->id_dosen_kbk) {
                $reviewer = '1';
            } elseif ($item->reviewer_dua == $dosen_kbk->id_dosen_kbk) {
                $reviewer = '2';
            }
        
            // Extract 'dosen' from 'p_reviewDetail', default to null if empty
            $dosen_review = $item->p_reviewDetail->isNotEmpty() ? $item->p_reviewDetail->first()->dosen : null;
        
            // Prepare data object based on whether 'dosen_review' is null or not
            $dataObject = (object) [
                'id_penugasan' => $item->id_penugasan,
                'reviewer_satu' => $item->reviewer_satu_dosen->id_dosen_kbk,
                'reviewer_dua' => $item->reviewer_dua_dosen->id_dosen_kbk,
                'tanggal_penugasan' => $item->tanggal_penugasan,
                'pembimbing_satu' => $item->proposal_ta->r_pembimbing_satu->nama_dosen,
                'pembimbing_dua' => $item->proposal_ta->r_pembimbing_dua->nama_dosen,
                'judul' => $item->proposal_ta->judul,
                'jenis_kbk_id' => $item->proposal_ta->jenis_kbk_id,
                'nama' => $item->proposal_ta->r_mahasiswa->nama,
                'nim' => $item->proposal_ta->r_mahasiswa->nim,
                'prodi_id' => $item->proposal_ta->r_mahasiswa->prodi_id,
                'dosen_r' => $reviewer
            ];
        
            // Add 'dosen' to data object if 'dosen_review' is not null
            if ($dosen_review !== null) {
                $dataObject->dosen = $dosen_review;
            }
        
            return $dataObject;
        });
        
        

        debug($reviewer_data->toArray());
        // Ambil penugasan hanya untuk dosen yang terpilih sebagai reviewer pada tabel review
        $data_review_proposal_ta_detail = ReviewProposalTaDetailPivot::whereHas('p_reviewProposal', function ($query) use ($dosen_kbk) {
            $query->where(function ($query) use ($dosen_kbk) {
                $query->where('reviewer_satu', $dosen_kbk->id_dosen_kbk)
                    ->orWhere('reviewer_dua', $dosen_kbk->id_dosen_kbk);
            });
        })->with([
            'p_reviewProposal.proposal_ta.r_mahasiswa',
            'p_reviewProposal.proposal_ta.r_pembimbing_satu',
            'p_reviewProposal.proposal_ta.r_pembimbing_dua',
            'p_reviewProposal.p_reviewDetail',
            'p_reviewProposal.reviewer_satu_dosen',
            'p_reviewProposal.reviewer_dua_dosen'
        ])
            ->orderByDesc('penugasan_id')
            ->get();

        debug($data_review_proposal_ta_detail->toArray());

        $reviewer_data_detail = $data_review_proposal_ta_detail->map(function ($detail) use ($dosen_kbk) {
            $item = $detail;
            $reviewer = null;

            // Determine the reviewer role
            if ($item->p_reviewProposal->reviewer_satu == $dosen_kbk->id_dosen_kbk) {
                $reviewer = '1';
            } elseif ($item->p_reviewProposal->reviewer_dua == $dosen_kbk->id_dosen_kbk) {
                $reviewer = '2';
            }

            // Return the desired attributes in a new object
            return (object) [
                'penugasan_id' => $item->penugasan_id,
                'reviewer_satu' => $item->p_reviewProposal->reviewer_satu_dosen->id_dosen_kbk,
                'reviewer_dua' => $item->p_reviewProposal->reviewer_dua_dosen->id_dosen_kbk,
                'tanggal_penugasan' => $item->p_reviewProposal->tanggal_penugasan,
                'pembimbing_satu' => $item->p_reviewProposal->proposal_ta->r_pembimbing_satu->nama_dosen,
                'pembimbing_dua' => $item->p_reviewProposal->proposal_ta->r_pembimbing_dua->nama_dosen,
                'judul' => $item->p_reviewProposal->proposal_ta->judul,
                'jenis_kbk_id' => $item->p_reviewProposal->proposal_ta->jenis_kbk_id,
                'nama' => $item->p_reviewProposal->proposal_ta->r_mahasiswa->nama,
                'nim' => $item->p_reviewProposal->proposal_ta->r_mahasiswa->nim,
                'prodi_id' => $item->p_reviewProposal->proposal_ta->r_mahasiswa->prodi_id,
                'dosen' => $item->dosen,
                'tanggal_review' => $item->tanggal_review,
                'status_review_proposal' => $item->status_review_proposal,
                'catatan' => $item->catatan,
                'dosen_r' => $reviewer
            ];
        });   
        // $penugasan_ids sekarang berisi semua penugasan_id dari $reviewer_data_detail


        debug($reviewer_data_detail->toArray());
        return view('admin.content.dosenKbk.review_proposal_ta', compact('reviewer_data_detail', 'reviewer_data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id, string $dosen)
    {
        $nextNumber = $this->getCariNomor();
        $dosen_kbk = $this->getDosen();
        $data_dosen_kbk = DosenKBK::where('jenis_kbk_id', $dosen_kbk->jenis_kbk_id)->get();

        $penugasan_id = $id;
        $dosen_review = $dosen;
        debug($dosen_review);

        return view('admin.content.dosenKbk.form.review_proposal_ta_form', compact('data_dosen_kbk', 'dosen_review', 'penugasan_id', 'nextNumber'));
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
            'date' => 'required|date_format:Y-m-d H:i:s',
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
    public function edit(string $id, string $dosen)
    {
        $penugasan_id = $id;
        $dosen_review = $dosen;
        $data_dosen = ReviewProposalTaDetailPivot::where('penugasan_id', $id)->where('dosen', $dosen)->first();
        debug($dosen_review);
        return view('admin.content.dosenKbk.form.review_proposal_ta_edit', compact('data_dosen', 'dosen_review', 'penugasan_id'));
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
            'catatan' => 'required',
            'date' => 'required|date_format:Y-m-d H:i:s',
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
        $reviewData = ReviewProposalTaDetailPivot::where('penugasan_id', $id)->where('dosen', $request->reviewer)->first();

        if ($reviewData) {
            $reviewData->update($data);
        }
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
