<?php

namespace Database\Seeders;

use App\Models\Ver_UAS;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerUASSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $VerUASData = [
            [1, 1, 292, '', '1', '1', '', '2023-12-25'],
            [2, 2, 292, '', '0', '0', '', '2024-02-12'],
            [3, 3, 292, '', '1', '1', '', '2024-02-12'],
            [4, 4, 292, '', '1', '1', '', '2024-02-12'],
            [5, 5, 292, '', '1', '0', '', '2024-02-12']
        ];

        foreach ($VerUASData as $data) {
            $nextNumber = $this->getCariNomor();

            DB::table('ver_uas')->insert([
                'id_ver_uas' => $nextNumber,
                'rep_uas_id' => $data[1],
                'dosen_id' => $data[2],
                'file_verifikasi'=> $data[3],
                'status_ver_uas' => $data[4],
                'saran' => $data[5],
                'catatan' => $data[6],
                'tanggal_diverifikasi' => $data[7]
            ]);
        }
    }

    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_ver_uas = Ver_UAS::pluck('id_ver_uas')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_ver_uas)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
