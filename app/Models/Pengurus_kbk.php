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
    protected $primaryKey = 'id_pengurus';

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }

    public function jenis_kbk(){
        return $this->belongsTo(JenisKbk::class, 'jenis_kbk_id','id_jenis_kbk');
    }

    public function jabatan_kbk(){
        return $this->belongsTo(JabatanKbk::class, 'jabatan_kbk_id','id_jabatan_kbk');
    }    
}
