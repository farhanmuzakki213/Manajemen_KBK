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
            ['Programming', ''],
            ['IT Infrastruktur', ''],
            ['Networking', ''],
            ['CAIT', '']
        ];

        foreach ($JenisData as $data) {
            DB::table('jenis_kbk')->insert([
                'jenis_kbk' => $data[0],
                'deskripsi' => $data[1]
            ]);
        }
    }
}
