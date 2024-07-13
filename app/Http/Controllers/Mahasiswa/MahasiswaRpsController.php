<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Rps;
use App\Models\Tahun;
use Illuminate\Support\Facades\Auth;

class MahasiswaRpsController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::where('id', Auth::user()->mahasiswa_id)->first();
        $rps = Rps::where('prodi_id', $mahasiswa->prodi_id)
            ->latest()
            ->get();
        return view('mahasiswa.rps.index', [
            'rps' => $rps,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('mahasiswa.rps.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function rps($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $rps = Rps::where('tahun_id', $tahuns->id)
            ->latest()
            ->get();
        return view('mahasiswa.rps.rps', [
            'rps' => $rps,
            'tahuns' => $tahuns,
        ]);
    }
}
