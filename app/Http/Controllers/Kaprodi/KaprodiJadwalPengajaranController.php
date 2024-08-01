<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\JadwalPengajaran;

class KaprodiJadwalPengajaranController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPengajaran::latest()->get();
        return view('kaprodi.jadwal-pengajaran.index', [
            'jadwals' => $jadwals,
        ]);
    }
}
