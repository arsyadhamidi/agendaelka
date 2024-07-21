<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPublikasiController extends Controller
{
    public function index()
    {
        $publikasis = Publikasi::latest()->get();
        return view('admin.publikasi.index', [
            'publikasis' => $publikasis,
        ]);
    }

    public function create()
    {
        $dosens = Dosen::latest()->get();
        return view('admin.publikasi.create', [
            'dosens' => $dosens,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required',
            'lokasi' => 'required',
            'file_publikasi' => 'required|mimes:pdf|max:2048',
        ], [
            'dosen_id.required' => 'Dosen wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'file_publikasi.required' => 'File Penelitian wajib diisi',
            'file_publikasi.mimes' => 'File Penelitian harus memiliki format PDF',
            'file_publikasi.max' => 'File Penelitian maksimal 2 MB',
        ]);

        if ($request->file('file_publikasi')) {
            $validated['file_publikasi'] = $request->file('file_publikasi')->store('file_publikasi');
        } else {
            $validated['file_publikasi'] = null;
        }

        Publikasi::create($validated);

        return redirect()->route('data-publikasi.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $dosens = Dosen::latest()->get();
        $publikasis = Publikasi::where('id', $id)->first();
        return view('admin.publikasi.edit', [
            'dosens' => $dosens,
            'publikasis' => $publikasis,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'dosen_id' => 'required',
            'lokasi' => 'required',
            'file_publikasi' => 'required|mimes:pdf|max:2048',
        ], [
            'dosen_id.required' => 'Dosen wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'file_publikasi.required' => 'File Penelitian wajib diisi',
            'file_publikasi.mimes' => 'File Penelitian harus memiliki format PDF',
            'file_publikasi.max' => 'File Penelitian maksimal 2 MB',
        ]);

        $publikasis = Publikasi::where('id', $id)->first();
        if ($request->file('file_publikasi')) {
            if ($publikasis->file_publikasi) {
                Storage::delete('file_publikasi');
            }
            $validated['file_publikasi'] = $request->file('file_publikasi')->store('file_publikasi');
        } else {
            $validated['file_publikasi'] = $publikasis->file_publikasi;
        }

        $publikasis->update($validated);

        return redirect()->route('data-publikasi.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $publikasis = Publikasi::find($id);
        if ($publikasis->file_publikasi) {
            Storage::delete('file_publikasi');
        }
        $publikasis->delete();
        return redirect()->route('data-publikasi.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
