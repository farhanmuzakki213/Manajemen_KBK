<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportPengurus_kbk implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data_pengurus_kbk = DB::table('pengurus_kbk')
            ->join('jenis_kbk', 'pengurus_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->join('jabatan_kbk', 'pengurus_kbk.jabatan_kbk_id', '=', 'jabatan_kbk.id_jabatan_kbk')
            ->join('dosen', 'pengurus_kbk.dosen_id', '=', 'dosen.id_dosen')
            ->select(
                'jenis_kbk.jenis_kbk',
                'jabatan_kbk.jabatan',
                'dosen.nama_dosen',
                'pengurus_kbk.status_pengurus_kbk')

            ->orderBy('id_pengurus')
            ->get()
            ->map(function ($item) {
                $item->status_pengurus_kbk = $item->status_pengurus_kbk == 0 ? 'Tidak Aktif' : 'Aktif';
                return $item;
            });
        return $data_pengurus_kbk;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'jenis_kbk',
            'jabatan',
            'nama_dosen',
            'status_pengurus_kbk'
        ];
    }
}
