<?php

namespace App\Http\Controllers\KepalaDepartemen;

use App\Models\Prodi;
use App\Models\Tahun;
use App\Models\Seminar;
use Illuminate\Http\Request;
use App\Exports\SeminarExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class KepalaDepartemenSeminarController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kepala-departemen.seminar.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kepala-departemen.seminar.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function seminar($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $semianrs = Seminar::where('tahun_id', $id)->latest()->get();
        return view('kepala-departemen.seminar.seminar', [
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
