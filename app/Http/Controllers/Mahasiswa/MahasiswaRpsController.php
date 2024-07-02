<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Rps;

class MahasiswaRpsController extends Controller
{
    public function index()
    {
        $rps = Rps::latest()->get();
        return view('mahasiswa.rps.index', [
            'rps' => $rps,
        ]);
    }
}
