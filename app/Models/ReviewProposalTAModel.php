<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProposalTAModel extends Model
{
    use HasFactory;
    protected $fillable = ['id_penugasan','proposal_ta_id', 'reviewer_satu', 'reviewer_dua', 'status_review_proposal', 'status_final_proposal', 'catatan', 'tanggal_penugasan', 'tanggal_review'];
    protected $table = 'review_proposal_ta';
    public $timestamps = false;

    protected $primaryKey = 'id_penugasan';
    public $incrementing = false;
}
