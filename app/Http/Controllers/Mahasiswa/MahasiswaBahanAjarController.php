<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BahanAjar;

class MahasiswaBahanAjarController extends Controller
{
    public function index()
    {
        $bahans = BahanAjar::latest()->get();
        return view('mahasiswa.bahan-ajar.index', [
            'bahans' => $bahans,
        ]);
    }
}
