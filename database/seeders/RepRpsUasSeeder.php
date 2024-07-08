<?php

namespace Database\Seeders;

use App\Models\RepRpsUas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RepRpsUasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $RepRPSData = [
            [3, 1, 1,  '0', '', '2024-05-23', '2024-06-01'],
            [3, 1, 1,  '1', '', '2024-05-23', '2024-06-01'],
            [3, 1, 2,  '0', '', '2024-05-23', '2024-06-01'],
            [3, 1, 2,  '1', '', '2024-05-23', '2024-06-01'],
            [3, 2, 3,  '0', '', '2024-05-23', '2024-06-01'],
            [3, 2, 4,  '1', '', '2024-05-23', '2024-06-01'],
            [3, 3, 5,  '0', '', '2024-05-23', '2024-06-01'],
            [3, 3, 5,  '1', '', '2024-05-23', '2024-06-01'],
            [3, 3, 6,  '0', '', '2024-05-23', '2024-06-01'],
            [3, 3, 6,  '1', '', '2024-05-23', '2024-06-01'],
            [3, 4, 8,  '0', '', '2024-05-23', '2024-06-01'],
            [3, 4, 8,  '1', '', '2024-05-23', '2024-06-01'],
            [3, 4, 9,  '0', '', '2024-05-23', '2024-06-01'],
            [3, 4, 9,  '1', '', '2024-05-23', '2024-06-01'],
            [3, 5, 10, '0', '', '2024-05-23', '2024-06-01'],
            [3, 5, 10, '1', '', '2024-05-23', '2024-06-01'],
            [3, 5, 11, '1', '', '2024-05-23', '2024-06-01'],
            [3, 6, 12, '0', '', '2024-05-23', '2024-06-01'],
            [3, 6, 12, '1', '', '2024-05-23', '2024-06-01'],
            [3, 6, 13, '0', '', '2024-05-23', '2024-06-01'],
            [3, 6, 13, '1', '', '2024-05-23', '2024-06-01'],
            [3, 7, 14, '0', '', '2024-05-23', '2024-06-01'],
            [3, 7, 14, '1', '', '2024-05-23', '2024-06-01'],
            [3, 7, 15, '0', '', '2024-05-23', '2024-06-01'],
            [3, 7, 15, '1', '', '2024-05-23', '2024-06-01'],
            [3, 8, 16, '0', '', '2024-05-23', '2024-06-01'],
            [3, 8, 16, '1', '', '2024-05-23', '2024-06-01'],
        ];

        foreach ($RepRPSData as $data) {
            $nextNumber = $this->getCariNomor();
            DB::table('rep_rps_uas')->insert([
                'id_rep_rps_uas' =>  $nextNumber ,
                'smt_thnakd_id' => $data[0],
                'dosen_matkul_id' => $data[1],
                'matkul_kbk_id' => $data[2],
                'type' => $data[3],
                'file' => $data[4],
                'created_at' => $data[5],
                'updated_at' => $data[6]
            ]);
        }
    }

    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_rep_rps_uas = RepRpsUas::pluck('id_rep_rps_uas')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_rep_rps_uas)) {
                return $i;
                break;
            }
        }
        return $i;
    }
    
}
