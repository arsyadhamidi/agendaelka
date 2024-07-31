<?php

namespace App\Http\Controllers\KepalaDepartemen;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Rps;
use App\Models\Tahun;

class KepalaDepartemenRpsController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kepala-departemen.rps.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $prodis = Prodi::where('id', $id)->first();
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kepala-departemen.rps.tahun', [
            'prodis' => $prodis,
            'tahuns' => $tahuns,
        ]);
    }

    public function rps($id)
    {
        $rps = Rps::where('tahun_id', $id)->latest()->get();
        $tahuns = Tahun::where('id', $id)->first();
        return view('kepala-departemen.rps.rps', [
            'rps' => $rps,
            'tahuns' => $tahuns,
        ]);
    }
}
