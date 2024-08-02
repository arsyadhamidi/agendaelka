<?php

namespace App\Http\Controllers\Kaprodi;

use App\Models\Prodi;
use App\Models\Tahun;
use App\Models\Penelitian;
use Illuminate\Http\Request;
use App\Exports\PenelitianExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class KaprodiPenelitianController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kaprodi.penelitian.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kaprodi.penelitian.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function penelitian($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $penelitians = Penelitian::where('tahun_id', $id)->latest()->get();
        return view('kaprodi.penelitian.penelitian', [
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
