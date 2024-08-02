<?php

namespace App\Http\Controllers\Kaprodi;

use App\Models\Prodi;
use App\Models\Tahun;
use App\Models\StudiLanjut;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KaprodiStudiLanjutController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kaprodi.studi-lanjut.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kaprodi.studi-lanjut.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function studilanjut($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $studis = StudiLanjut::with('tahun')->where('tahun_id', $id)->latest()->get();
        return view('kaprodi.studi-lanjut.studi', [
            'studis' => $studis,
            'tahuns' => $tahuns,
        ]);
    }
}
