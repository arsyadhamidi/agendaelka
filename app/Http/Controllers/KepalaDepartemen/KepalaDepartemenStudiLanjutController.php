<?php

namespace App\Http\Controllers\KepalaDepartemen;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\StudiLanjut;
use App\Models\Tahun;

class KepalaDepartemenStudiLanjutController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kepala-departemen.studi-lanjut.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kepala-departemen.studi-lanjut.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function studilanjut($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $studis = StudiLanjut::with('tahun')->where('tahun_id', $id)->latest()->get();
        return view('kepala-departemen.studi-lanjut.studi', [
            'studis' => $studis,
            'tahuns' => $tahuns,
        ]);
    }
}
