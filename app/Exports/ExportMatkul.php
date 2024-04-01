<?php

namespace App\Exports;

use App\Models\Matkul;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportMatkul implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data_matkul = Matkul::join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->select(
                'matkul.kode_matkul',
                'matkul.nama_matkul',
                'matkul.TP',
                'matkul.sks',
                'matkul.jam',
                'matkul.sks_teori',
                'matkul.sks_praktek',
                'matkul.jam_teori',
                'matkul.jam_praktek',
                'matkul.semester', 
                'kurikulum.nama_kurikulum')
            ->orderBy('id_matkul')
            ->get();

        return $data_matkul;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'kode matkul',
            'nama_matkul',
            'TP',
            'sks',
            'jam',
            'sks_teori',
            'sks_praktek',
            'jam_teori',
            'jam_praktek',
            'semester',
            'nama_kurikulum'
            
        ];
    }
}
