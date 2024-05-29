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
            [1, 2, 40, 1, '1'],
            [2, 1, 52, 1, '1']
        ];

        foreach ($PengurusData as $data) {
            DB::table('pengurus_kbk')->insert([
                'id_pengurus' => $data[0],
                'jenis_kbk_id' => $data[1],
                'dosen_id' => $data[2],
                'jabatan_kbk_id' => $data[3],
                'status_pengurus_kbk' => $data[4]
            ]);
        }
    }
}
