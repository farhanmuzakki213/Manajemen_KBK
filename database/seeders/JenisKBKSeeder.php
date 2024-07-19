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
            [1, 'Programming', 'Center Of Programing'],
            [2, 'IT Infrastructure', 'Center Of IT Infrastructure'],
            [3, 'NCS', 'Center Of Networking and Cyber Security'],
            [4, 'CAIT', 'Center Of Artificial Intelligence Technology'],
            [5, 'SOFTAM', 'Center Of Software Technology and Management']
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
