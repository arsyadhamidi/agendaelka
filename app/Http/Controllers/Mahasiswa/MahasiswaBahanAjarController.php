<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BahanAjar;
use App\Models\Mahasiswa;
use App\Models\Tahun;
use Illuminate\Support\Facades\Auth;

class MahasiswaBahanAjarController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::where('id', Auth::user()->mahasiswa_id)->first();
        $bahans = BahanAjar::where('prodi_id', $mahasiswa->prodi_id)
            ->latest()
            ->get();
        return view('mahasiswa.bahan-ajar.index', [
            'bahans' => $bahans,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('mahasiswa.bahan-ajar.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function bahanajar($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $bahans = BahanAjar::where('tahun_id', $tahuns->id)
            ->latest()
            ->get();
        return view('mahasiswa.bahan-ajar.bahan-ajar', [
            'bahans' => $bahans,
            'tahuns' => $tahuns,
        ]);
    }
}
