<?php

namespace App\Imports;

use App\Models\Matkul;
use App\Models\Kurikulum;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;

class ImportMatkul implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $errors = [];
        $successCount = 0;

        foreach ($rows as $row) {
            $kurikulum = Kurikulum::where('nama_kurikulum', $row['nama_kurikulum'])->first();

            // Check if the Matkul already exists
            if (Matkul::where('kode_matkul', $row['kode_matkul'])->exists()) {
                $errors[] = 'Matkul dengan kode ' . $row['kode_matkul'] . ' sudah ada.';
                continue; // Skip this row and move to the next one
            }

            // Create new Matkul only if it doesn't already exist
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
                'kurikulum_id' => $kurikulum ? $kurikulum->id_kurikulum : null // Handle if kurikulum not found
            ]);

            $successCount++;
        }

        if (!empty($errors)) {
            throw new ValidationException('Import failed', collect(['duplicate_data' => $errors]));
        }

        return $successCount;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
