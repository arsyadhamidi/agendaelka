<?php

namespace App\Http\Controllers\Kaprodi;

use App\Models\Prodi;
use App\Models\Tahun;
use App\Models\Pengabdian;
use Illuminate\Http\Request;
use App\Exports\PengabdianExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class KaprodiPengabdianController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kaprodi.pengabdian.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kaprodi.pengabdian.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function pengabdian($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $pengabdians = Pengabdian::where('tahun_id', $id)->latest()->get();
        return view('kaprodi.pengabdian.pengabdian', [
            'pengabdians' => $pengabdians,
            'tahuns' => $tahuns,
        ]);
    }

    public function generateexcel($id)
    {
        $query = Pengabdian::where('tahun_id', $id);
        $data = $query->orderBy('id', 'desc')->get();

        return Excel::download(new PengabdianExport($data), 'data-pengabdian.xlsx');
    }
}
