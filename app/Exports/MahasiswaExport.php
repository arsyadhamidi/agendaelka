<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MahasiswaExport implements FromCollection, WithHeadings
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
                'nim' => $item->nim,
                'nama' => $item->nama,
                'tmp_lahir' => $item->tmp_lahir,
                'tgl_lahir' => $item->tgl_lahir,
                'jk' => $item->jk,
                'email' => $item->email,
                'telp' => $item->telp,
                'alamat' => $item->alamat,
                'prodi_id' => $item->prodi->nama, // Pastikan ada kolom 'nama_negara' di model Negara
                'tahun_id' => $item->tahun->tahun, // Pastikan ada kolom 'nama_negara' di model Negara
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'NIM',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Email',
            'Telepon',
            'Alamat',
            'Program Studi',
            'Tahun',
        ];
    }
}
