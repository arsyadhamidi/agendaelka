<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;

class AdminTahunController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.tahun.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        $prodis = Prodi::where('id', $id)->first();
        return view('admin.tahun.tahun', [
            'tahuns' => $tahuns,
            'prodis' => $prodis,
        ]);
    }

    public function create($id)
    {
        $prodis = Prodi::where('id', $id)->first();
        return view('admin.tahun.create', [
            'prodis' => $prodis,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun' => 'required',
        ], [
            'tahun.required' => 'Tahun wajib diisi',
        ]);

        Tahun::create($validated);

        return redirect()->route('data-tahun.tahun', $request->prodi_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        return view('admin.tahun.edit', [
            'tahuns' => $tahuns,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun' => 'required',
        ], [
            'tahun.required' => 'Tahun wajib diisi',
        ]);

        Tahun::where('id', $id)->update($validated);

        return redirect()->route('data-tahun.tahun', $request->prodi_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $tahuns->delete();

        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }

}
