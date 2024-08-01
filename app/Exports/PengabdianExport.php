<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengabdianExport implements FromCollection, WithHeadings
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
                'judul' => $item->judul,
                'tanggal' => $item->tanggal,
                'lokasi' => $item->lokasi,
                'tahun' => $item->tahun->tahun,
                'status' => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap',
            'Program Studi',
            'Judul',
            'Tanggal',
            'Loaksi',
            'Tahun',
            'Status',
        ];
    }
}
