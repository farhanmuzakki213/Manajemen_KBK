<?php

namespace Database\Seeders;

use App\Models\Pengurus_kbk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengurusKBKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $PengurusData = [
            [1, 52, 1, '1'],
            [1, 132, 2, '1'],
            [2, 13, 1, '1'],
            [2, 354, 2, '1'],
            [3, 359, 1, '1'],
            [3, 360, 2, '1'],
            [4, 160, 1, '1'],
            [4, 277, 2, '1'],
            [5, 292, 1, '1'],
            [5, 355, 2, '1'],
        ];

        foreach ($PengurusData as $data) {
            $nextNumber = $this->getCariNomor();
            DB::table('pengurus_kbk')->insert([
                'id_pengurus' => $nextNumber,
                'jenis_kbk_id' => $data[0],
                'dosen_id' => $data[1],
                'jabatan_kbk_id' => $data[2],
                'status_pengurus_kbk' => $data[3]
            ]);
        }
    }

    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_pengurus = Pengurus_kbk::pluck('id_pengurus')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_pengurus)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
