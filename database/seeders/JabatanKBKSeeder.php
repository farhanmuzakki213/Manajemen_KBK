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
            [1, 'Ketua KBK', ''],
            [2, 'Sekretaris KBK', '']
        ];

        foreach ($JabData as $data) {
            DB::table('jabatan_kbk')->insert([
                'id_jabatan_kbk' => $data[0],
                'jabatan' => $data[1],
                'deskripsi' => $data[2]
            ]);
        }
    }
}
