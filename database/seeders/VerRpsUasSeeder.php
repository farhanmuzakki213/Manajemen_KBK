<?php

namespace Database\Seeders;

use App\Models\Ver_RPS;
use App\Models\VerRpsUas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerRpsUasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $VerRPSData = [
        ];

        foreach ($VerRPSData as $data) {
            $nextNumber = $this->getCariNomor();

            DB::table('ver_rps_uas')->insert([
                'id_ver_rps_uas' => $nextNumber,
                'rep_rps_uas_id' => $data[0],
                'pengurus_id' => $data[1],
                'rekomendasi'=> $data[2],
                'saran' => $data[3],
                'tanggal_diverifikasi' => $data[4]
            ]);
        }
    }

    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_ver_rps = VerRpsUas::pluck('id_ver_rps_uas')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_ver_rps)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
