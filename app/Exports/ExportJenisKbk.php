<?php

namespace App\Exports;

use App\Models\JenisKbk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ExportJenisKbk implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data_jenis_kbk = DB::table('jenis_kbk')
            ->orderBy('id_jenis_kbk')
            ->get();
        return $data_jenis_kbk;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'id_jenis_kbk',
            'jenis_kbk',
            'deskripsi'
        ];
    }
}