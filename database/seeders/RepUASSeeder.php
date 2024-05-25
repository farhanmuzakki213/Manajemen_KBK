<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RepUASSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $RepUASData = [
            [1, 3, 40, 13, '', '2024-01-30', '2024-01-30'],
            [2, 3, 50, 14, '', '2024-02-28', '2024-02-28'],
            [3, 3, 91, 19, '', '2024-02-28', '2024-02-28'],
            [4, 3, 353, 18, '', '2024-02-28', '2024-02-28'],
            [5, 2, 311, 22, '', '2024-02-28', '2024-02-28'],
        ];

        foreach ($RepUASData as $data) {
            $prefix = 'RUAS';
            $nextNumber = $this->getNextNumber($prefix);
            DB::table('rep_uas')->insert([
                'id_rep_uas' => $prefix . $nextNumber,
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
        $lastEntry = DB::table('rep_uas')
            ->where('id_rep_uas', 'like', $prefix . '%')
            ->orderBy('id_rep_uas', 'desc')
            ->first();

        // Jika tidak ada entri sebelumnya, kembalikan angka pertama
        if (!$lastEntry) {
            return 1;
        }

        // Ambil angka terakhir dari ID terakhir dan tambahkan 1
        $lastNumber = intval(substr($lastEntry->id_rep_uas, strlen($prefix)));
        return $lastNumber + 1;
    }
}
