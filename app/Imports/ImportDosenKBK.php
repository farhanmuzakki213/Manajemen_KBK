<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\DosenKBK;
use App\Models\JenisKbk;
use App\Models\JabatanKbk;
use App\Models\Pengurus_kbk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportDosenKBK implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $jenis_kbk = JenisKbk::where('jenis_kbk', $row['jenis_kbk'])->first();
            $dosen = Dosen::where('nama_dosen', $row['nama_dosen'])->first();
            

            DosenKBK::create([
                'jenis_kbk_id' => $jenis_kbk['id_jenis_kbk'],
                'dosen_id' => $dosen['id_dosen'],
            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
} 