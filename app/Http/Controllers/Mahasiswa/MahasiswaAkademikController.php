<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Akademik;
use App\Models\Dosen;
use App\Models\Prodi;

class MahasiswaAkademikController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('mahasiswa.akademik.index', [
            'prodis' => $prodis,
        ]);
    }

    public function dosen($id)
    {
        $dosens = Dosen::where('prodi_id', $id)->latest()->get();
        return view('mahasiswa.akademik.dosen', [
            'dosens' => $dosens,
        ]);
    }

    public function akademik($id)
    {
        $dosens = Dosen::where('id', $id)->first();
        $akademiks = Akademik::where('prodi_id', $dosens->prodi_id)
            ->where('dosen_id', $dosens->id)
            ->latest()
            ->get();
        return view('mahasiswa.akademik.akademik', [
            'akademiks' => $akademiks,
            'dosens' => $dosens,
        ]);
    }
}
