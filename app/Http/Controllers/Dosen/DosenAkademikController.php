<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Akademik;
use App\Models\Prodi;
use App\Models\Tahun;

class DosenAkademikController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('dosen.akademik.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('dosen.akademik.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function akademik($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $akademiks = Akademik::where('tahun_id', $id)->latest()->get();

        return view('dosen.akademik.akademik', [
            'tahuns' => $tahuns,
            'akademiks' => $akademiks,
        ]);
    }
}
