<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Rps;
use Illuminate\Support\Facades\Auth;

class MahasiswaRpsController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::where('id', Auth::user()->mahasiswa_id)->first();
        $rps = Rps::where('prodi_id', $mahasiswas->prodi_id)
            ->where('tahun_id', $mahasiswas->tahun_id)
            ->latest()
            ->get();
        return view('mahasiswa.rps.index', [
            'rps' => $rps,
        ]);
    }
}
