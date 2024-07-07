<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun_id', 'id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }

    public function penelaah1()
    {
        return $this->belongsTo(Dosen::class, 'penelaah1_id', 'id');
    }

    public function penelaah2()
    {
        return $this->belongsTo(Dosen::class, 'penelaah2_id', 'id');
    }
}
