<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerRPSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $VerRPSData = [

            [1, 'RRPS1', 357, '', '1', '', '2022-07-10'],
            [2, 'RRPS2', 220, '', '0', '', '2022-07-10'],
            [3, 'RRPS6', 220, '', '1', '', '2023-07-10'],
            [4, 'RRPS9', 357, '', '1', '', '2024-02-20'],

        ];

        foreach ($VerRPSData as $data) {
            $prefix = 'VRPS';
            $nextNumber = $this->getNextNumber($prefix);

            DB::table('ver_rps')->insert([
                'id_ver_rps' => $prefix . $nextNumber,
                'rep_rps_id' => $data[1],
                'dosen_id' => $data[2],
                'file_verifikasi'=> $data[3],
                'status_ver_rps' => $data[4],
                'catatan' => $data[5],
                'tanggal_diverifikasi' => $data[6]
            ]);
        }
    }

    private function getNextNumber($prefix)
    {
        // Ambil ID terakhir dengan prefix yang sama
        $lastEntry = DB::table('ver_rps')
            ->where('id_ver_rps', 'like', $prefix . '%')
            ->orderBy('id_ver_rps', 'desc')
            ->first();

        // Jika tidak ada entri sebelumnya, kembalikan angka pertama
        if (!$lastEntry) {
            return 1;
        }

        // Ambil angka terakhir dari ID terakhir dan tambahkan 1
        $lastNumber = intval(substr($lastEntry->id_ver_rps, strlen($prefix)));
        return $lastNumber + 1;
    }
}
