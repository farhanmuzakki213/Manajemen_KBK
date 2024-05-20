<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurus_kbk extends Model
{
    use HasFactory;
    protected $fillable = ['id_pengurus','jenis_kbk_id', 'dosen_id', 'jabatan_kbk_id','status_pengurus_kbk'];
    protected $table = 'pengurus_kbk';
    public $timestamps = false;
}
