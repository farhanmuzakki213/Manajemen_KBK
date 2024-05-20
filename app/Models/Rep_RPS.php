<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rep_RPS extends Model
{
    use HasFactory;
    protected $fillable = ['smt_thnakd','ver_rps_id','matkul_id','file','create_at','update_at'];
    protected $table = 'rep_rps';
    public $timestamps = true;
}
