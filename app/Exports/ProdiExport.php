<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdiExport implements FromCollection, WithHeadings
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
                'Nama' => $item->nama, // Pastikan ada kolom 'nama_negara' di model Negara
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Program Studi',
        ];
    }
}
