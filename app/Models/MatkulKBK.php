<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatkulKBK extends Model
{
    use HasFactory;
    protected $fillable = ['id_matkul_kbk','matkul_id','jenis_kbk_id','kurikulum_id'];
    protected $table = 'matkul_kbk';
    public $timestamps = false;
}
