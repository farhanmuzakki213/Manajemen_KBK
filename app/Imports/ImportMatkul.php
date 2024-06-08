<?php

namespace App\Imports;

use App\Models\Matkul;
use App\Models\Kurikulum;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportMatkul implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $kurikulum = Kurikulum::where('nama_kurikulum', $row['nama_kurikulum'])->first();

            Matkul::create([
                'kode_matkul' => $row['kode_matkul'],
                'nama_matkul' => $row['nama_matkul'],
                'tp' => $row['tp'],
                'sks' => $row['sks'],
                'jam' => $row['jam'],
                'sks_teori' => $row['sks_teori'],
                'sks_praktek' => $row['sks_praktek'],
                'jam_teori' => $row['jam_teori'],
                'jam_praktek' => $row['jam_praktek'],
                'semester' => $row['semester'],
                'kurikulum_id' => $kurikulum['id_kurikulum']
            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
} 