<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalTAModel extends Model
{
    use HasFactory; 
    protected $fillable = ['id_proposal_ta','mahasiswa_id', 'judul', 'status_proposal_ta', 'file_proposal', 'pembimbing_satu', 'pembimbing_dua'];
    protected $table = 'proposal_ta';
    public $timestamps = false;

    protected $primaryKey = 'id_propsal_ta';
    public $incrementing = false;

    public function r_mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id','id_mahasiswa');
    }

    public function r_pembimbing_satu()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_satu', 'id_dosen');
    }

    public function r_pembimbing_dua()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_dua', 'id_dosen');
    }
}
