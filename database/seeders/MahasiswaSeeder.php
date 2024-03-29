<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $MahasiswaData = [
            ['Arif Kurniawan', '2211083020', 'L', '7', '3', '1'],
            ['Dzaky Rahmat Nurwahid', '2211083024', 'L', '7', '3', '1'],
            ['Farhan Muzakki', '2211083025', 'L', '7', '3', '1'],
            ['Jazila Valisya Luthfia', '2211082016', 'P', '7', '3', '1'],
            ["Nurhadi Sa'bani", '2211081021', 'L', '7', '3', '1']
        ];

        foreach ($MahasiswaData as $data) {
            DB::table('mahasiswa')->insert([
                'nama' => $data[0],
                'nim' => $data[1],
                'gender' => $data[2],
                'jurusan_id' => $data[3],
                'prodi_id' => $data[4],
                'status' => $data[5]
            ]);
        }
    }
}
