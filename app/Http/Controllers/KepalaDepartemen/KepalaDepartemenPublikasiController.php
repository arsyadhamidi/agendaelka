<?php

namespace App\Http\Controllers\KepalaDepartemen;

use App\Exports\PublikasiExport;
use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Publikasi;
use App\Models\Tahun;
use Maatwebsite\Excel\Facades\Excel;

class KepalaDepartemenPublikasiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kepala-departemen.publikasi.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kepala-departemen.publikasi.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function publikasi($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $publikasis = Publikasi::where('tahun_id', $id)->latest()->get();
        return view('kepala-departemen.publikasi.publikasi', [
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
