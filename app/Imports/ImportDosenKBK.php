<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\DosenKBK;
use App\Models\JenisKbk;
use App\Models\JabatanKbk;
use App\Models\Pengurus_kbk;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;

class ImportDosenKBK implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            $errors = [];
            $successCount = 0;

            foreach ($rows as $row) {
                Log::info('Processing row: ', $row->toArray());

              
                $jenis_kbk = JenisKbk::where('jenis_kbk', $row['jenis_kbk'])->first();
                $dosen = Dosen::where('nama_dosen', $row['nama_dosen'])->first();
                $nextNumber = $this->getCariNomor();
               


            
                if (DosenKBK::whereHas('r_dosen', function ($query) use ($row) {
                    $query->where('nama_dosen', $row['nama_dosen']);
                })->exists()) {
                    $errors[] = 'Dosen dengan nama ' . $row['nama_dosen'] . ' sudah ada.';
                    Log::info('Duplicate detected for kode_matkul: ' . $row['nama_dosen']);
                    continue;
                }
                

                // Buat entri baru
                DosenKBK::create([
                    'id_dosen_kbk' => $nextNumber,
                    'jenis_kbk_id' => $jenis_kbk ? $jenis_kbk->id_jenis_kbk : null,
                    'dosen_id' => $dosen ? $dosen->id_dosen : null
                ]);

                Log::info('Inserted dosen with nama_dosen: ' . $row['nama_dosen']);
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
        $id_dosen_kbk = DosenKBK::pluck('id_dosen_kbk')->toArray();

        for ($i = 1;; $i++) {
            if (!in_array($i, $id_dosen_kbk)) {
                return $i;
            }
        }
    }
}