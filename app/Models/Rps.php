<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rps extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun_id', 'id');
    }

    public function matkul()
    {
        return $this->belongsTo(Matkul::class, 'matkul_id', 'id');
    }
}
