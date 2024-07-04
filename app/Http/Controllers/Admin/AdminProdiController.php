<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class AdminProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.prodi.index', [
            'prodis' => $prodis,
        ]);
    }

    public function create()
    {
        return view('admin.prodi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama Program Studi wajib diisi',
        ]);

        Prodi::create($validated);

        return redirect('data-prodi')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        return view('admin.prodi.edit', [
            'prodis' => Prodi::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama Program Studi wajib diisi',
        ]);

        Prodi::where('id', $id)->update($validated);

        return redirect('data-prodi')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $prodis = Prodi::findOrFail($id);
        $prodis->delete();

        return redirect('data-prodi')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
