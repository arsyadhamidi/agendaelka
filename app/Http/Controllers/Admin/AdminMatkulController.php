<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matkul;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;

class AdminMatkulController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.matkul.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('admin.matkul.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function matkul($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $matkuls = Matkul::where('tahun_id', $id)->latest()->get();
        return view('admin.matkul.matkul', [
            'tahuns' => $tahuns,
            'matkuls' => $matkuls,
        ]);
    }

    public function create($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        return view('admin.matkul.create', [
            'tahuns' => $tahuns,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'matkul' => 'required',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'matkul.required' => 'Mata Kuliah wajib diisi',
        ]);

        Matkul::create($validated);

        return redirect()->route('data-matkul.matkul', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $matkuls = Matkul::where('id', $id)->first();
        return view('admin.matkul.edit', [
            'matkuls' => $matkuls,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'matkul' => 'required',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'matkul.required' => 'Mata Kuliah wajib diisi',
        ]);

        Matkul::where('id', $id)->update($validated);

        return redirect()->route('data-matkul.matkul', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $matkuls = Matkul::where('id', $id)->first();
        $matkuls->delete();
        
        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
