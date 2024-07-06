<?php

namespace App\Imports;

use App\Models\Matkul;
use App\Models\JenisKbk;
use App\Models\Kurikulum;
use App\Models\MatkulKBK;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;

class ImportMatkulKBK implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            $errors = [];
            $successCount = 0;

            foreach ($rows as $row) {
                Log::info('Processing row: ', $row->toArray());

              
                $matkul = Matkul::where('kode_matkul', $row['kode_matkul'])->first();
                $jenis_kbk = JenisKbk::where('jenis_kbk', $row['jenis_kbk'])->first();
                $kurikulum = Kurikulum::where('nama_kurikulum', $row['nama_kurikulum'])->first();
                $nextNumber = $this->getCariNomor();


            
                if (MatkulKBK::whereHas('r_matkul', function ($query) use ($row) {
                    $query->where('kode_matkul', $row['kode_matkul']);
                })->exists()) {
                    $errors[] = 'Matkul dengan kode ' . $row['kode_matkul'] . ' sudah ada.';
                    Log::info('Duplicate detected for kode_matkul: ' . $row['kode_matkul']);
                    continue;
                }
                

                // Buat entri baru
                MatkulKBK::create([
                    'id_matkul_kbk' => $nextNumber,
                    'matkul_id' => $matkul? $matkul->id_matkul : null,
                    'jenis_kbk_id' => $jenis_kbk? $jenis_kbk->id_jenis_kbk : null,
                    'kurikulum_id' => $kurikulum ? $kurikulum->id_kurikulum : null
                ]);

                Log::info('Inserted matkul with kode_matkul: ' . $row['kode_matkul']);
                $successCount++;
            }

            if (!empty($errors)) {
                DB::commit();
                throw ValidationException::withMessages(['duplicate_data' => $errors]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in collection method: ' . $e->getMessage() . ' at line ' . $e->getLine() . ' in file ' . $e->getFile());
            throw $e;
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function getCariNomor()
    {
        $id_matkul_kbk = MatkulKBK::pluck('id_matkul_kbk')->toArray();

        for ($i = 1;; $i++) {
            if (!in_array($i, $id_matkul_kbk)) {
                return $i;
            }
        }
    }
}
