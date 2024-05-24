<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerUASSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $VerUASData = [
    //         [1, 1, 357, '', '0', '', '2023-12-25'],
    //         [2, 2, 220, '', '0', '', '2024-02-12'],
    //     ];

    //     foreach ($VerUASData as $data) {
    //         DB::table('ver_uas')->insert([
    //             'id_ver_uas' => $data[0],
    //             'rep_uas_id' => $data[1],
    //             'dosen_id' => $data[2],
    //             'file' => $data[3],
    //             'status_ver_uas' => $data[4],
    //             'catatan' => $data[5],
    //             'tanggal_diverifikasi' => $data[6]
    //         ]);
    //     }
    // }
    public function run(): void
    {
        $VerUASData = [
            [1, 1, 357, '', '0', '', '2023-12-25'],
            [2, 2, 220, '', '0', '', '2024-02-12'],
        ];

        foreach ($VerUASData as $data) {
            $prefix = 'VUAS';
            $nextNumber = $this->getNextNumber($prefix);

            DB::table('ver_uas')->insert([
                'id_ver_uas' => $prefix . $nextNumber,
                'rep_uas_id' => $data[1],
                'dosen_id' => $data[2],
                'file_verifikasi'=> $data[3],
                'status_ver_uas' => $data[4],
                'catatan' => $data[5],
                'tanggal_diverifikasi' => $data[6]
            ]);
        }
    }

    private function getNextNumber($prefix)
    {
        // Ambil ID terakhir dengan prefix yang sama
        $lastEntry = DB::table('ver_uas')
            ->where('id_ver_uas', 'like', $prefix . '%')
            ->orderBy('id_ver_uas', 'desc')
            ->first();

        // Jika tidak ada entri sebelumnya, kembalikan angka pertama
        if (!$lastEntry) {
            return 1;
        }

        // Ambil angka terakhir dari ID terakhir dan tambahkan 1
        $lastNumber = intval(substr($lastEntry->id_ver_uas, strlen($prefix)));
        return $lastNumber + 1;
    }
}
