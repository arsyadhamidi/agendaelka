<?php

namespace App\Http\Controllers\Dosen;

use App\Exports\SeminarExport;
use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Seminar;
use App\Models\Tahun;
use Maatwebsite\Excel\Facades\Excel;

class DosenSeminarController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('dosen.seminar.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('dosen.seminar.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function seminar($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $semianrs = Seminar::where('tahun_id', $id)->latest()->get();
        return view('dosen.seminar.seminar', [
            'tahuns' => $tahuns,
            'seminars' => $semianrs,
        ]);
    }

    public function generateexcel($id)
    {
        $query = Seminar::where('tahun_id', $id);
        $data = $query->orderBy('id', 'desc')->get();

        return Excel::download(new SeminarExport($data), 'data-seminar.xlsx');
    }
}
