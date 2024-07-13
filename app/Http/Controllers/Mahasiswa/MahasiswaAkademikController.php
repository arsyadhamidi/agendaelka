<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Akademik;
use App\Models\Tahun;
use Illuminate\Support\Facades\Auth;

class MahasiswaAkademikController extends Controller
{
    public function index()
    {
        $akademiks = Akademik::where('mahasiswa_id', Auth::user()->mahasiswa_id)
            ->latest()
            ->get();
        return view('mahasiswa.akademik.index', [
            'akademiks' => $akademiks,
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
