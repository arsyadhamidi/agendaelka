<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProdiExport;
use App\Http\Controllers\Controller;
use App\Imports\ProdiImport;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.prodi.index', [
            'prodis' => $prodis,
        ]);
    }

    public function generateexcel()
    {
        $query = Prodi::query();
        $data = $query->orderBy('id', 'desc')->get();

        return Excel::download(new ProdiExport($data), 'data-prodi.xlsx');
    }

    public function importexcel(Request $request)
    {
        // Validasi file yang diunggah
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ], [
            'file.required' => 'File wajib diisi',
            'file.mimes' => 'File harus memiliki format xls atau xlsx',
        ]);

        // Ambil file dari request
        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();

        // Pindahkan file ke direktori 'DataProdi'
        $file->move(public_path('DataProdi'), $namaFile);

        // Impor file Excel menggunakan kelas ProdiImport
        Excel::import(new ProdiImport, public_path('DataProdi/' . $namaFile));

        // Redirect ke route 'data-prodi' dengan pesan sukses
        return redirect()->route('data-prodi.index')->with('success', 'Selamat! Anda berhasil mengimport data prodi.');
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
