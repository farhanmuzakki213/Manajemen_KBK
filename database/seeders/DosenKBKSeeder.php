<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DosenKBKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $DosenKBKData = [
            [1, 2, 358],
            [2, 1, 359]
        ];

        foreach ($DosenKBKData as $data) {
            DB::table('dosen_kbk')->insert([
                'id_dosen_kbk' => $data[0],
                'jenis_kbk_id' => $data[1],
                'dosen_id' => $data[2]
            ]);
        }
    }
}
