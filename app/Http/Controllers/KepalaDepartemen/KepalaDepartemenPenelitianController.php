<?php

namespace App\Http\Controllers\KepalaDepartemen;

use App\Exports\PenelitianExport;
use App\Http\Controllers\Controller;
use App\Models\Penelitian;
use App\Models\Prodi;
use App\Models\Tahun;
use Maatwebsite\Excel\Facades\Excel;

class KepalaDepartemenPenelitianController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kepala-departemen.penelitian.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kepala-departemen.penelitian.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function penelitian($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $penelitians = Penelitian::where('tahun_id', $id)->latest()->get();
        return view('kepala-departemen.penelitian.penelitian', [
            'penelitians' => $penelitians,
            'tahuns' => $tahuns,
        ]);
    }

    public function generateexcel($id)
    {
        $query = Penelitian::where('tahun_id', $id);
        $data = $query->orderBy('id', 'desc')->get();

        return Excel::download(new PenelitianExport($data), 'data-penelitian.xlsx');
    }
}
