<?php

namespace App\Imports;

use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToModel;

class ProdiImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Prodi([
            'nama' => $row['1'],
        ]);
    }
}
