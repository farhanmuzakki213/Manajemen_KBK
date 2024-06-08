<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportDosenKBK implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data_dosen_kbk = DB::table('dosen_kbk')
            ->join('jenis_kbk', 'dosen_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->join('dosen', 'dosen_kbk.dosen_id', '=', 'dosen.id_dosen')
            ->select(
                'jenis_kbk.jenis_kbk',
                'dosen.nama_dosen')

            ->orderBy('id_dosen_kbk')
            ->get();
        return $data_dosen_kbk;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'jenis_kbk',
            'nama_dosen',
        ];
    }
}
