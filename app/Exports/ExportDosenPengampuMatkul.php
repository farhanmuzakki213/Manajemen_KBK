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
            ->join('dosen', 'dosen_matkul.dosen_id', '=', 'dosen.id_dosen')
            ->join('matkul', 'dosen_matkul.matkul_id', '=', 'matkul.id_matkul')
            ->join('kelas', 'dosen_matkul.kelas_id', '=', 'kelas.id_kelas')
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
            'id_dosen_matkul',
            'nama_dosen',
            'nama_matkul',
            'nama_kelas',
            'smt_thnakd'
        ];
    }
}
