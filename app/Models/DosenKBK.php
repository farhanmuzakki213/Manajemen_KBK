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
    protected $primaryKey = 'id_dosen_kbk';

    public function jenis_kbk(){
        return $this->belongsTo(JenisKbk::class, 'jenis_kbk_id','id_jenis_kbk');
    }

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }
}
