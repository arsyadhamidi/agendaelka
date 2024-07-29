<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Publikasi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPublikasiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.publikasi.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('admin.publikasi.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function publikasi($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $publikasis = Publikasi::where('tahun_id', $id)->latest()->get();
        return view('admin.publikasi.publikasi', [
            'publikasis' => $publikasis,
            'tahuns' => $tahuns,
        ]);
    }

    public function create($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $dosens = Dosen::where('prodi_id', $tahuns->prodi_id)->latest()->get();
        return view('admin.publikasi.create', [
            'dosens' => $dosens,
            'tahuns' => $tahuns,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'dosen_id' => 'required',
            'judul' => 'required',
            'sinta' => 'required',
            'file_publikasi' => 'required|mimes:pdf|max:2048',
        ], [
            'dosen_id.required' => 'Dosen wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'sinta.required' => 'Sinta wajib diisi',
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

        return redirect()->route('data-publikasi.publikasi', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
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
            'judul' => 'required',
            'sinta' => 'required',
            'file_publikasi' => 'required|mimes:pdf|max:2048',
        ], [
            'dosen_id.required' => 'Dosen wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'sinta.required' => 'Sinta wajib diisi',
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

        return redirect()->route('data-publikasi.publikasi', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $publikasis = Publikasi::find($id);
        if ($publikasis->file_publikasi) {
            Storage::delete('file_publikasi');
        }
        $publikasis->delete();
        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
