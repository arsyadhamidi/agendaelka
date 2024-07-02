<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Models\JadwalPengajaran;
use App\Http\Controllers\Controller;

class MahasiswaJadwalPengajaranController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPengajaran::latest()->get();
        return view('mahasiswa.jadwal-pengajaran.index', [
            'jadwals' => $jadwals,
        ]);
    }
}
