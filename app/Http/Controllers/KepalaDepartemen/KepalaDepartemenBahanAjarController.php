<?php

namespace App\Http\Controllers\KepalaDepartemen;

use App\Http\Controllers\Controller;
use App\Models\BahanAjar;
use App\Models\Prodi;
use App\Models\Tahun;

class KepalaDepartemenBahanAjarController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kepala-departemen.bahan-ajar.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kepala-departemen.bahan-ajar.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function bahanajar($id)
    {
        $bahans = BahanAjar::where('tahun_id', $id)->latest()->get();
        $tahuns = Tahun::where('id', $id)->first();
        return view('kepala-departemen.bahan-ajar.bahan-ajar', [
            'bahans' => $bahans,
            'tahuns' => $tahuns,
        ]);
    }
}
