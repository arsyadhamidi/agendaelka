<?php

namespace App\Http\Controllers\Kaprodi;

use App\Models\Rps;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KaprodiRpsController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kaprodi.rps.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $prodis = Prodi::where('id', $id)->first();
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kaprodi.rps.tahun', [
            'prodis' => $prodis,
            'tahuns' => $tahuns,
        ]);
    }

    public function rps($id)
    {
        $rps = Rps::where('tahun_id', $id)->latest()->get();
        $tahuns = Tahun::where('id', $id)->first();
        return view('kaprodi.rps.rps', [
            'rps' => $rps,
            'tahuns' => $tahuns,
        ]);
    }
}
