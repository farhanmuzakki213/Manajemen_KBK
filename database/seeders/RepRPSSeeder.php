<?php

namespace Database\Seeders;

use App\Models\Rep_RPS;
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
        ];

        foreach ($RepRPSData as $data) {
            $nextNumber = $this->getCariNomor();
            DB::table('rep_rps')->insert([
                'id_rep_rps' =>  $nextNumber ,
                'smt_thnakd_id' => $data[1],
                'dosen_id' => $data[2],
                'matkul_id' => $data[3],
                'file' => $data[4],
                'created_at' => $data[5],
                'updated_at' => $data[6]
            ]);
        }
    }

    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_rep_rps = Rep_RPS::pluck('id_rep_rps')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_rep_rps)) {
                return $i;
                break;
            }
        }
        return $i;
    }
    
}
