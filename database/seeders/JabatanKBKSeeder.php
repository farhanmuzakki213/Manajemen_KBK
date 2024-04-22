<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JabatanKBKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $JabData = [
            ['Ketua KBK', ''],
            ['Sekretaris KBK', ''],
            ['Anggota KBK', ''],
        ];

        foreach ($JabData as $data) {
            DB::table('jabatan_kbk')->insert([
                'jabatan' => $data[0],
                'deskripsi' => $data[1]
            ]);
        }
    }
}
