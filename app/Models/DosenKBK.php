<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenKBK extends Model
{
    use HasFactory;
    protected $fillable = ['id_dosen_kbk','jenis_kbk_id', 'dosen_id'];
    protected $table = 'dosen_kbk';
    public $timestamps = false;
}
