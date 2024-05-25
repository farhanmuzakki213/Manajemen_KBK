<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JenisKBKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $JenisData = [
            [1, 'Programming', ''],
            [2, 'IT Infrastruktur', ''],
            [3, 'Networking and Cybersec', ''],
            [4, 'CAIT', ''],
            [5, 'SOFTAM', '']
        ];

        foreach ($JenisData as $data) {
            DB::table('jenis_kbk')->insert([
                'id_jenis_kbk' => $data[0],
                'jenis_kbk' => $data[1],
                'deskripsi' => $data[2]
            ]);
        }
    }
}
