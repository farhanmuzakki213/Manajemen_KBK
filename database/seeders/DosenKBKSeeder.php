<?php

namespace Database\Seeders;

use App\Models\DosenKBK;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DosenKBKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $DosenKBKData = [
            [1, 13],
            [1, 14],
            [1, 40],
            [1, 46],
            [1, 50],
            [1, 52],
            [1, 66],
            [2, 85],
            [2, 91],
            [2, 103],
            [2, 109],
            [2, 116],
            [2, 121],
            [2, 122],
            [3, 127],
            [3, 132],
            [3, 160],
            [3, 198],
            [3, 206],
            [3, 212],
            [4, 220],
            [4, 223],
            [4, 258],
            [4, 277],
            [4, 289],
            [4, 292],
            [5, 310],
            [5, 311],
            [5, 312],
            [5, 351],
            [5, 352],
            [5, 353],
            [5, 354],
        ];

        foreach ($DosenKBKData as $data) {
            $nextNumber = $this->getCariNomor();
            DB::table('dosen_kbk')->insert([
                'id_dosen_kbk' => $nextNumber,
                'jenis_kbk_id' => $data[0],
                'dosen_id' => $data[1]
            ]);
        }
    }

    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_dosen_kbk = DosenKBK::pluck('id_dosen_kbk')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_dosen_kbk)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
