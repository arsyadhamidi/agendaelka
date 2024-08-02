<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Publikasi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaPublikasiController extends Controller
{
    public function index()
    {
        $publikasis = Publikasi::where('users_id', Auth::user()->id)->latest()->get();
        return view('mahasiswa.publikasi.index', [
            'publikasis' => $publikasis,
        ]);
    }

    public function create()
    {
        $prodis = Prodi::latest()->get();
        $tahuns = Tahun::latest()->get();
        return view('mahasiswa.publikasi.create', [
            'prodis' => $prodis,
            'tahuns' => $tahuns,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'nama' => 'required',
            'judul' => 'required',
            'sinta' => 'required',
            'file_publikasi' => 'required|mimes:pdf|max:2048',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'sinta.required' => 'Sinta wajib diisi',
            'file_publikasi.required' => 'File Penelitian wajib diisi',
            'file_publikasi.mimes' => 'File Penelitian harus memiliki format PDF',
            'file_publikasi.max' => 'File Penelitian maksimal 2 MB',
        ]);

        $validated['users_id'] = Auth::user()->id;
        $validated['status'] = 'Mahasiswa';

        if ($request->file('file_publikasi')) {
            $validated['file_publikasi'] = $request->file('file_publikasi')->store('file_publikasi');
        } else {
            $validated['file_publikasi'] = null;
        }

        Publikasi::create($validated);

        return redirect()->route('mahasiswa-publikasi.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $prodis = Prodi::latest()->get();
        $tahuns = Tahun::latest()->get();
        $publikasis = Publikasi::where('id', $id)->first();
        return view('mahasiswa.publikasi.edit', [
            'prodis' => $prodis,
            'tahuns' => $tahuns,
            'publikasis' => $publikasis,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'nama' => 'required',
            'judul' => 'required',
            'sinta' => 'required',
            'file_publikasi' => 'required|mimes:pdf|max:2048',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'sinta.required' => 'Sinta wajib diisi',
            'file_publikasi.required' => 'File Penelitian wajib diisi',
            'file_publikasi.mimes' => 'File Penelitian harus memiliki format PDF',
            'file_publikasi.max' => 'File Penelitian maksimal 2 MB',
        ]);

        $validated['users_id'] = Auth::user()->id;
        $validated['status'] = 'Mahasiswa';

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

        return redirect()->route('mahasiswa-publikasi.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
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

    public function getTahun($prodiId)
    {
        $tahuns = Tahun::where('prodi_id', $prodiId)->get();
        return response()->json(['tahuns' => $tahuns]);
    }
}
