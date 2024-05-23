<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProposalTAModel extends Model
{
    use HasFactory;
    protected $fillable = ['id_penugasan','proposal_ta_id', 'dosen_id', 'status_review_proposal', 'catatan', 'tanggal_penugasan', 'tanggal_review'];
    protected $table = 'review_proposal_ta';
    public $timestamps = true;
}
