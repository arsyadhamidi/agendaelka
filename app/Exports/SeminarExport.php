<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SeminarExport implements FromCollection, WithHeadings
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
                'prodi_id' => $item->prodi->nama,
                'tahun_id' => $item->tahun->tahun,
                'dosen_id' => $item->dosen->nama,
                'mahasiswa_id' => $item->mahasiswa->nama,
                'penelaah1_id' => $item->penelaah1->nama,
                'penelaah2_id' => $item->penelaah2->nama,
                'judul' => $item->judul,
                'tgl_seminar' => $item->tgl_seminar,
                'tgl_ujian' => $item->tgl_ujian,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Program Studi',
            'Tahun',
            'Dosen',
            'Mahasiswa',
            'Penelaah 1',
            'Penelaah 2',
            'Judul',
            'Tanggal Seminar',
            'Tanggal Ujian',
        ];
    }
}
