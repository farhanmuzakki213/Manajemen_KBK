<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PimpinanJurusan extends Model
{
    use HasFactory;
    protected $fillable = ['id_pimpinan_jurusan','jabatan_pimpinan_id','jurusan_id','dosen_id','periode', 'status_pimpinan_jurusan'];
    protected $table = 'pimpinan_jurusan';
    public $timestamps = false;
}
