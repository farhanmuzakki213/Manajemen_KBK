<?php

namespace App\Imports;

use App\Models\Matkul;
use App\Models\Kurikulum;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\Events\TransactionBeginning;

class ImportMatkul implements ToCollection, WithHeadingRow
{


    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            $errors = [];
            $successCount = 0;

            foreach ($rows as $row) {
                Log::info('Processing row: ', $row->toArray());
                
                $kurikulum = Kurikulum::where('nama_kurikulum', $row['nama_kurikulum'])->first();
                $nextNumber = $this->getCariNomor();
                
                if (Matkul::where('kode_matkul', $row['kode_matkul'])->exists()) {
                    $errors[] = 'Matkul dengan kode ' . $row['kode_matkul'] . ' sudah ada.';
                    Log::info('Duplicate detected for kode_matkul: ' . $row['kode_matkul']);
                    continue;
                }

                Matkul::create([
                    'id_matkul' => $nextNumber,
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
                    'kurikulum_id' => $kurikulum ? $kurikulum->id_kurikulum : null
                ]);

                Log::info('Inserted matkul with kode_matkul: ' . $row['kode_matkul']);
                $successCount++;
            }

            if (!empty($errors)) {
                DB::commit(); // Commit valid inserts before throwing exception
                throw ValidationException::withMessages(['duplicate_data' => $errors]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in collection method: ' . $e->getMessage());
            throw $e;
        }
    }


    public function headingRow(): int
    {
        return 1;
    }

    public function getCariNomor()
    {
        $id_matkul = Matkul::pluck('id_matkul')->toArray();

        for ($i = 1;; $i++) {

            if (!in_array($i, $id_matkul)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
