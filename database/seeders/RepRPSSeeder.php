<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RepRPSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $RepRPSData = [

            [1, 1, 40, 13, '', '2022-06-07', '2022-06-08'],
            [2, 1, 50, 14, '', '2022-06-12', '2022-06-13'],
            [3, 1, 46, 13, '', '2022-06-07', '2022-06-08'],
            [4, 1, 52, 14, '', '2022-06-12', '2022-06-13'],
            [5, 2, 40, 13, '', '2023-06-07', '2023-06-08'],
            [6, 2, 50, 14, '', '2023-06-12', '2023-06-13'],
            [7, 2, 46, 13, '', '2023-06-07', '2023-06-08'],
            [8, 2, 52, 14, '', '2023-06-12', '2023-06-13'],
            [9, 3, 40, 13, '', '2024-01-30', '2024-01-30'],
            [10, 3, 52, 14, '', '2024-02-28', '2024-02-28'], 

            [11, 1, 85, 26, '', '2022-06-07', '2022-06-08'],
            [12, 1, 66, 27, '', '2022-06-12', '2022-06-13'],
            [13, 1, 85, 26, '', '2022-06-07', '2022-06-08'],
            [14, 1, 66, 27, '', '2022-06-12', '2022-06-13'],
            [15, 2, 85, 26, '', '2023-06-07', '2023-06-08'],
            [16, 3, 66, 26, '', '2024-01-30', '2024-01-30'],
            [17, 3, 85, 27, '', '2024-02-28', '2024-02-28'],
            [18, 3, 66, 26, '', '2024-01-30', '2024-01-30'],
            [19, 3, 85, 27, '', '2024-02-28', '2024-02-28'], 

            [20, 2, 13, 28, '', '2023-06-07', '2023-06-08'],
            [21, 2, 14, 29, '', '2023-06-12', '2023-06-13'],
            [22, 2, 13, 28, '', '2023-06-07', '2023-06-08'],
            [23, 2, 14, 29, '', '2023-06-12', '2023-06-13'],
            [24, 3, 13, 28, '', '2024-01-30', '2024-01-30'],
            [25, 3, 14, 29, '', '2024-02-28', '2024-02-28'],
            [26, 3, 13, 28, '', '2024-01-30', '2024-01-30'],
            [27, 3, 14, 29, '', '2024-02-28', '2024-02-28'], 
        ];

        foreach ($RepRPSData as $data) {
            $prefix = 'RRPS';
            $nextNumber = $this->getNextNumber($prefix);
            DB::table('rep_rps')->insert([
                'id_rep_rps' => $prefix . $nextNumber,
                'smt_thnakd_id' => $data[1],
                'dosen_id' => $data[2],
                'matkul_id' => $data[3],
                'file' => $data[4],
                'created_at' => $data[5],
                'updated_at' => $data[6]
            ]);
        }
    }

    private function getNextNumber($prefix)
    {
        // Ambil ID terakhir dengan prefix yang sama
        $lastEntry = DB::table('rep_rps')
            ->where('id_rep_rps', 'like', $prefix . '%')
            ->orderBy('id_rep_rps', 'desc')
            ->first();

        // Jika tidak ada entri sebelumnya, kembalikan angka pertama
        if (!$lastEntry) {
            return 1;
        }

        // Ambil angka terakhir dari ID terakhir dan tambahkan 1
        $lastNumber = intval(substr($lastEntry->id_rep_rps, strlen($prefix)));
        return $lastNumber + 1;
    }
}
