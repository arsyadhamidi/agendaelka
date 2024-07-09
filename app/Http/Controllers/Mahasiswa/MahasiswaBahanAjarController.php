<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BahanAjar;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class MahasiswaBahanAjarController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::where('id', Auth::user()->mahasiswa_id)->first();
        $bahans = BahanAjar::where('prodi_id', $mahasiswas->prodi_id)
            ->where('tahun_id', $mahasiswas->tahun_id)
            ->latest()
            ->get();
        return view('mahasiswa.bahan-ajar.index', [
            'bahans' => $bahans,
        ]);
    }
}
