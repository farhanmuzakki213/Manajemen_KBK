<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rep_RPS extends Model
{
    use HasFactory;
    protected $fillable = ['id_rep_rps', 'smt_thnakd_id', 'dosen_id', 'matkul_id', 'file'];
    protected $table = 'rep_rps';
    public $timestamps = true;
}
