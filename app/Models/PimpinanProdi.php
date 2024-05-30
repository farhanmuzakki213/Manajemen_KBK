<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PimpinanProdi extends Model
{
    use HasFactory;
    protected $fillable = ['id_pimpinan_prodi','jabatan_pimpinan_id','prodi_id','dosen_id','periode', 'status_pimpinan_prodi'];
    protected $table = 'pimpinan_prodi';
    public $timestamps = false;
}
