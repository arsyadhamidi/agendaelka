<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Penelitian;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaPenelitianController extends Controller
{
    public function index()
    {
        $penelitians = Penelitian::where('users_id', Auth::user()->id)->latest()->get();
        return view('mahasiswa.penelitian.index', [
            'penelitians' => $penelitians,
        ]);
    }

    public function create()
    {
        $prodis = Prodi::latest()->get();
        $tahuns = Tahun::latest()->get();
        $dosens = Dosen::latest()->get();
        return view('mahasiswa.penelitian.create', [
            'prodis' => $prodis,
            'dosens' => $dosens,
            'tahuns' => $tahuns,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'nama' => 'required',
            'tanggal' => 'required',
            'judul' => 'required',
            'lokasi' => 'required',
            'file_penelitian' => 'required|mimes:pdf|max:2048',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'file_penelitian.required' => 'File Penelitian wajib diisi',
            'file_penelitian.mimes' => 'File Penelitian harus memiliki format PDF',
            'file_penelitian.max' => 'File Penelitian maksimal 2 MB',
        ]);

        $validated['users_id'] = Auth::user()->id;
        $validated['status'] = 'Mahasiswa';

        if ($request->file('file_penelitian')) {
            $validated['file_penelitian'] = $request->file('file_penelitian')->store('file_penelitian');
        } else {
            $validated['file_penelitian'] = null;
        }

        Penelitian::create($validated);

        return redirect()->route('mahasiswa-penelitian.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $dosens = Dosen::latest()->get();
        $prodis = Prodi::latest()->get();
        $tahuns = Tahun::latest()->get();
        $penelitians = Penelitian::where('id', $id)->first();
        return view('mahasiswa.penelitian.edit', [
            'prodis' => $prodis,
            'dosens' => $dosens,
            'tahuns' => $tahuns,
            'penelitians' => $penelitians,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required',
            'judul' => 'required',
            'lokasi' => 'required',
            'file_penelitian' => 'required|mimes:pdf|max:2048',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'status.required' => 'Status wajib diisi',
            'file_penelitian.required' => 'File Penelitian wajib diisi',
            'file_penelitian.mimes' => 'File Penelitian harus memiliki format PDF',
            'file_penelitian.max' => 'File Penelitian maksimal 2 MB',
        ]);

        $validated['users_id'] = Auth::user()->id;
        $validated['status'] = 'Mahasiswa';

        $penelitians = Penelitian::where('id', $id)->first();
        if ($request->file('file_penelitian')) {
            if ($penelitians->file_penelitian) {
                Storage::delete('file_penelitian');
            }
            $validated['file_penelitian'] = $request->file('file_penelitian')->store('file_penelitian');
        } else {
            $validated['file_penelitian'] = $penelitians->file_penelitian;
        }

        $penelitians->update($validated);

        return redirect()->route('mahasiswa-penelitian.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $penelitians = Penelitian::find($id);
        if ($penelitians->file_penelitian) {
            Storage::delete('file_penelitian');
        }
        $penelitians->delete();
        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }

    public function getTahun($prodiId)
    {
        $tahuns = Tahun::where('prodi_id', $prodiId)->get();
        return response()->json(['tahuns' => $tahuns]);
    }
}
