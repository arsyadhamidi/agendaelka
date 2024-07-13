<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Rapat;

class DosenRapatController extends Controller
{
    public function index()
    {
        $rapats = Rapat::latest()->get();
        return view('dosen.rapat.index', [
            'rapats' => $rapats,
        ]);
    }
}
