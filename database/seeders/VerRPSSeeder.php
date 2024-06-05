<?php

namespace Database\Seeders;

use App\Models\Ver_RPS;
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

        ];

        foreach ($VerRPSData as $data) {
            $nextNumber = $this->getCariNomor();

            DB::table('ver_rps')->insert([
                'id_ver_rps' => $nextNumber,
                'rep_rps_id' => $data[1],
                'dosen_id' => $data[2],
                'file_verifikasi'=> $data[3],
                'status_ver_rps' => $data[4],
                'catatan' => $data[5],
                'tanggal_diverifikasi' => $data[6]
            ]);
        }
    }

    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_ver_rps = Ver_RPS::pluck('id_ver_rps')->toArray();
    
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
