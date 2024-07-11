<?php

namespace App\Imports;

use App\Models\JenisKbk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportJenisKbk implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {


            JenisKbk::create([
                'jenis_kbk' => $row['jenis_kbk'],
                'deskripsi' => $row['deskripsi'],
            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
} 