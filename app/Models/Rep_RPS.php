<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rep_RPS extends Model
{
    use HasFactory;
    protected $fillable = ['id_rep_rps', 'smt_thnakd_id', 'dosen_id', 'matkul_id', 'file'];

    public static $rules = [
        'id_rep_rps' => 'required',
        'smt_thnakd_id' => 'required',
        'dosen_id' => 'required',
        'matkul_id' => 'required',
        'file' => 'required|file', // Validasi file
    ];

    protected $table = 'rep_rps';
    public $incrementing = false;
    protected $primaryKey = 'id_ver_rps';
    public $timestamps = true;

    public static function validate($data)
    {
        return validator($data, static::$rules);
    }
    
}
