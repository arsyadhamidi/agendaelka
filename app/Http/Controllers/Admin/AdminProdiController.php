<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Http\Request;

class AdminProdiController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::latest()->get();
        return view('admin.prodi.index', [
            'jurusans' => $jurusans,
        ]);
    }

    public function indexprodi($id)
    {
        return view('admin.prodi.prodi', [
            'prodis' => Prodi::where('jurusan_id', $id)->latest()->get(),
            'jurusans' => Jurusan::find($id),
        ]);
    }

    public function create($id)
    {
        return view('admin.prodi.create', [
            'jurusans' => Jurusan::find($id),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama Program Studi wajib diisi',
        ]);

        $validated['jurusan_id'] = $request->jurusan_id;

        Prodi::create($validated);

        return redirect('data-prodi/index_prodi/' . $request->jurusan_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
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

        $validated['jurusan_id'] = $request->jurusan_id;

        Prodi::where('id', $id)->update($validated);

        return redirect('data-prodi/index_prodi/' . $request->jurusan_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $prodis = Prodi::findOrFail($id);
        $prodis->delete();

        return redirect('data-prodi')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
