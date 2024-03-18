<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurusan')->insert([
            [
                'kode_jurusan' => 'AN',
                'jurusan' => 'Administrasi Niaga',
            ],
            [
                'kode_jurusan' => 'AK',
                'jurusan' => 'Akuntansi',
            ],
            [
                'kode_jurusan' => 'BI',
                'jurusan' => 'Bahasa Inggris',
            ],
            [
                'kode_jurusan' => 'EE',
                'jurusan' => 'Teknik Elektro',
            ],
            [
                'kode_jurusan' => 'ME',
                'jurusan' => 'Teknik Mesin',
            ],
            [
                'kode_jurusan' => 'SP',
                'jurusan' => 'Teknik Sipil',
            ],
            [
                'kode_jurusan' => 'TI',
                'jurusan' => 'Teknologi Informasi',
            ]
        ]);
    }
}
