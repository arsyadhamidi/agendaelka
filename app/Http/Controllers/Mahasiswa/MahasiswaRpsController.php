<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Rps;
use App\Models\Tahun;

class MahasiswaRpsController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('mahasiswa.rps.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('mahasiswa.rps.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function rps($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $rps = Rps::where('tahun_id', $tahuns->id)
            ->latest()
            ->get();
        return view('mahasiswa.rps.rps', [
            'rps' => $rps,
            'tahuns' => $tahuns,
        ]);
    }
}
