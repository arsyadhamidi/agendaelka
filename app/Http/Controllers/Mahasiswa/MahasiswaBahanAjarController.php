<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BahanAjar;
use App\Models\Prodi;
use App\Models\Tahun;

class MahasiswaBahanAjarController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('mahasiswa.bahan-ajar.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('mahasiswa.bahan-ajar.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function bahanajar($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->first();
        $bahans = BahanAjar::where('tahun_id', $tahuns->id)
            ->latest()
            ->get();
        return view('mahasiswa.bahan-ajar.bahan-ajar', [
            'bahans' => $bahans,
            'tahuns' => $tahuns,
        ]);
    }
}
