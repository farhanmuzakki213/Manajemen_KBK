<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProposalTaDetailPivot extends Model
{
    use HasFactory;
    protected $fillable = ['penugasan_id','dosen', 'status_review_proposal', 'tanggal_review'];
    protected $table = 'review_proposal_ta_detail_pivot';
    public $timestamps = false;

    public function p_reviewProposal()
    {
        return $this->belongsTo(ReviewProposalTAModel::class, 'penugasan_id', 'id_penugasan');
    }
}
