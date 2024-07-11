<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDosenPengampuMatkul implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data_dosen_pengampu = DB::table('dosen_matkul')
            ->join('dosen_matkul_detail_pivot', 'dosen_matkul_detail_pivot.dosen_matkul_id', '=', 'dosen_matkul.id_dosen_matkul')
            ->join('dosen', 'dosen_matkul.dosen_id', '=', 'dosen.id_dosen')
            ->join('matkul_kbk', 'dosen_matkul_detail_pivot.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kelas', 'dosen_matkul_detail_pivot.kelas_id', '=', 'kelas.id_kelas')
            ->join('smt_thnakd', 'dosen_matkul.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(
                'dosen.nama_dosen', 
                'matkul.nama_matkul', 
                'kelas.nama_kelas', 
                'smt_thnakd.smt_thnakd')
            ->orderBy('id_dosen_matkul')
            ->get();

            return $data_dosen_pengampu;
    }

    public function headings(): array
    {
        return [
            'nama_dosen',
            'nama_matkul',
            'nama_kelas',
            'smt_thnakd'
        ];
    }
}
