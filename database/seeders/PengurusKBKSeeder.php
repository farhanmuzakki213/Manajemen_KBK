<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengurusKBKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $PengurusData = [
            [2, 3, 1, '1'],
            [1, 6, 1, '1']
        ];

        foreach ($PengurusData as $data) {
            DB::table('pengurus_kbk')->insert([
                'jenis_kbk_id' => $data[0],
                'dosen_id' => $data[1],
                'jabatan_kbk_id' => $data[2],
                'status' => $data[3]
            ]);
        }
    }
}
