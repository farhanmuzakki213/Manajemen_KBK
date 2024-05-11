<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ver_RPS extends Model
{
    protected $fillable = [
        'id_ver_rps',
        'dosen_id',
        'file',
        'status_ver_rps',
        'catatan',
        'tanggal_diverifikasi',
    ];

    public static $rules = [
        'id_ver_rps' => 'required',
        'dosen_id' => 'required',
        'file' => 'required|file', // Validasi file
        'status_ver_rps' => 'required',
        'catatan' => 'required',
        'tanggal_diverifikasi' => 'required|date', // Validasi tanggal
    ];

    protected $table = 'ver_rps';
    public $timestamps = false;

    public static function validate($data)
    {
        return validator($data, static::$rules);
    }
}
