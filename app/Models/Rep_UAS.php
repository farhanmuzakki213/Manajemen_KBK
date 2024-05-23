<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rep_UAS extends Model
{
    
    use HasFactory;
    protected $fillable = ['id_rep_uas', 'smt_thnakd_id', 'dosen_id', 'matkul_id', 'file'];

    public static $rules = [
        'id_rep_uas' => 'required',
        'smt_thnakd_id' => 'required',
        'dosen_id' => 'required',
        'matkul_id' => 'required',
        'file' => 'required|file', // Validasi file
    ];

    protected $table = 'rep_uas';
    public $timestamps = true;

    public static function validate($data)
    {
        return validator($data, static::$rules);
    }

}
