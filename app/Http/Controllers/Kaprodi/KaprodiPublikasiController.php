<?php

namespace App\Http\Controllers\Kaprodi;

use App\Models\Prodi;
use App\Models\Tahun;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use App\Exports\PublikasiExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class KaprodiPublikasiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kaprodi.publikasi.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kaprodi.publikasi.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function publikasi($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $publikasis = Publikasi::where('tahun_id', $id)->latest()->get();
        return view('kaprodi.publikasi.publikasi', [
            'publikasis' => $publikasis,
            'tahuns' => $tahuns,
        ]);
    }
    public function generateexcel($id)
    {
        $query = Publikasi::where('tahun_id', $id);
        $data = $query->orderBy('id', 'desc')->get();

        return Excel::download(new PublikasiExport($data), 'data-publikasi.xlsx');
    }
}
