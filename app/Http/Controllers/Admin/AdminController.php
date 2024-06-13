<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ReviewProposalTAModel;

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
        $data_rep_proposal = ReviewProposalTAModel::with('proposal_ta', 'reviewer_satu_dosen', 'reviewer_dua_dosen', 'p_reviewDetail')
            ->orderByDesc('id_penugasan')
            ->get();

        return view('admin.content.admin.rep_proposal_ta', compact('data_rep_proposal'));
    }

}
