<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudiLanjutExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Map data to include country name
        return $this->data->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'prodi_id' => $item->prodi->nama,
                'pendidikan' => $item->pendidikan,
                'universitas' => $item->universitas,
                'tahun_id' => $item->tahun->tahun,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap',
            'Program Studi',
            'Pendidikan',
            'Universitas',
            'Tahun',
        ];
    }
}
