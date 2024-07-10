<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Akademik;
use App\Models\Prodi;
use App\Models\Tahun;

class MahasiswaAkademikController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('mahasiswa.akademik.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('mahasiswa.akademik.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function akademik($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $akademiks = Akademik::where('tahun_id', $tahuns->id)
            ->latest()
            ->get();
        return view('mahasiswa.akademik.akademik', [
            'akademiks' => $akademiks,
            'tahuns' => $tahuns,
        ]);
    }
}
