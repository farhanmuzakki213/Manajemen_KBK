<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\JenisKbk;
use App\Models\JabatanKbk;
use App\Models\Pengurus_kbk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportPengurusKbk implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $jenis_kbk = JenisKbk::where('jenis_kbk', $row['jenis_kbk'])->first();
            $jabatan_kbk = JabatanKbk::where('jabatan', $row['jabatan'])->first();
            $dosen = Dosen::where('nama_dosen', $row['nama_dosen'])->first();
            

            Pengurus_kbk::create([
                'jenis_kbk_id' => $jenis_kbk['id_jenis_kbk'],
                'jabatan_kbk_id' => $jabatan_kbk['id_jabatan_kbk'],
                'dosen_id' => $dosen['id_dosen'],
                'status' => $row['status']
            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
} 