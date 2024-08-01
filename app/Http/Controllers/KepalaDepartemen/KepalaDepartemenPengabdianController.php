<?php

namespace App\Http\Controllers\KepalaDepartemen;

use App\Exports\PengabdianExport;
use App\Http\Controllers\Controller;
use App\Models\Pengabdian;
use App\Models\Prodi;
use App\Models\Tahun;
use Maatwebsite\Excel\Facades\Excel;

class KepalaDepartemenPengabdianController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('kepala-departemen.pengabdian.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('kepala-departemen.pengabdian.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function pengabdian($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $pengabdians = Pengabdian::where('tahun_id', $id)->latest()->get();
        return view('kepala-departemen.pengabdian.pengabdian', [
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
