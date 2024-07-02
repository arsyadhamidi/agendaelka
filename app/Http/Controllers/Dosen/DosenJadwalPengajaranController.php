<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalPengajaran;

class DosenJadwalPengajaranController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPengajaran::latest()->get();
        return view('dosen.jadwal-pengajaran.index', [
            'jadwals' => $jadwals,
        ]);
    }
}
