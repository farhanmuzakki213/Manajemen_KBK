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
            [1, 311],
            [1, 351],
            [1, 85],
            [1, 212],
            [1, 14],
            [1, 310],
            [1, 357],
            [1, 358],
            [1, 356],
            [1, 361],
            [1, 364],

            [2, 352],
            [2, 312],
            [2, 46],
            [2, 121],
            [2, 223],
            [2, 109],
            [2, 40],
            [2, 103],

            [3, 258],

            [4, 122],
            [4, 50],
            [4, 206],
            [4, 91],
            [4, 66],
            [4, 116],
            [4, 363],

            [5, 220],
            [5, 198],
            [5, 289],
            [5, 353],
            [5, 127],
            [5, 362],
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
