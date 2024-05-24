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
            [1, 1, 357, '', '0', '', '2023-12-25'],
            [2, 2, 220, '', '0', '', '2024-02-12'],
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
