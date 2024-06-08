<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProposalTaDetailPivot extends Model
{
    use HasFactory;
    public function p_reviewProposal()
    {
        return $this->belongsTo(ReviewProposalTAModel::class, 'penugasan_id', 'id_penugasan');
    }
}
