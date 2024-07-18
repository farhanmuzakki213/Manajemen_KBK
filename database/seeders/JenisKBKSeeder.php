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
            [2, 'Network, Security and Infrastructure', ''],
            [3, 'Design, Animation, and Multimedia', ''],
            [4, 'Artificial Intelligence', ''],
            [5, 'Software Technology and Management', '']
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
