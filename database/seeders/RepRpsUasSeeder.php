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
            [3, 3, 6, '0', '', '2024-05-23', '2024-06-01'],
            [3, 3, 6, '1', '', '2024-05-23', '2024-06-01']
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
