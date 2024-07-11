<?php

namespace Database\Seeders;

use App\Models\DosenPengampuMatkul;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DosenMatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosenMatkulData = [
            [13, 3],
            [14, 3],
            [40, 3],
            [46, 3],
            [50, 3],
            [52, 3],
            [66, 3],
            [85, 3],
            [91, 3],
            [103, 3],
            [109, 3],
            [116, 3],
            [121, 3],
            [122, 3],
            [127, 3],
            [132, 3],
            [160, 3],
            [198, 3],
            [206, 3],
            [212, 3],
            [220, 3],
            [223, 3],
            [258, 3],
            [277, 3],
            [289, 3],
            [292, 3],
            [310, 3],
            [311, 3],
            [312, 3],
            [351, 3],
            [352, 3],
            [353, 3],
            [354, 3],
            [355, 3],
            [356, 3],
            [357, 3],
            [358, 3],
            [359, 3],
            [360, 3],
            [361, 3],
            [362, 3],
            [363, 3],
            [364, 3],
        ];

        foreach ($dosenMatkulData as $data) {
            $nextNumber = $this->getCariNomor();
            DB::table('dosen_matkul')->insert([
                'id_dosen_matkul' => $nextNumber,
                'dosen_id' => $data[0],
                'smt_thnakd_id' => $data[1]
            ]);
        }
    }
    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_dosen_matkul = DosenPengampuMatkul::pluck('id_dosen_matkul')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_dosen_matkul)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
