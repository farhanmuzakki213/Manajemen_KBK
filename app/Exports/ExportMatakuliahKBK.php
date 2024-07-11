<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportMatakuliahKBK implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data_matkul_kbk = DB::table('matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->select(
                'matkul.kode_matkul',
                'jenis_kbk.jenis_kbk',
                'matkul.semester',
                'kurikulum.nama_kurikulum')

            ->orderBy('id_matkul_kbk')
            ->get();
        return $data_matkul_kbk;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'kode_matkul',
            'jenis_kbk',
            'semester',
            'nama_kurikulum'
        ];
    }
}
