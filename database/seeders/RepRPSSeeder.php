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
            [1, 3, 40, 13, '', '2024-01-30', '2024-01-30'],
            [2, 3, 50, 14, '', '2024-02-28', '2024-02-28']
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
