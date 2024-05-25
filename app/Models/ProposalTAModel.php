<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalTAModel extends Model
{
    use HasFactory; 
    protected $fillable = ['id_propsal_ta','mahasiswa_id', 'judul', 'status_proposal_ta', 'file_proposal', 'pembimbing_satu', 'pembimbing_dua'];
    protected $table = 'proposal_ta';
    public $timestamps = false;

    protected $primaryKey = 'id_propsal_ta';
    public $incrementing = false;
}
