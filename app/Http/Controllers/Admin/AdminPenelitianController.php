<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Penelitian;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPenelitianController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.penelitian.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('admin.penelitian.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function penelitian($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $penelitians = Penelitian::where('tahun_id', $id)->latest()->get();
        return view('admin.penelitian.penelitian', [
            'penelitians' => $penelitians,
            'tahuns' => $tahuns,
        ]);
    }

    public function create($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $dosens = Dosen::where('prodi_id', $tahuns->prodi_id)->latest()->get();
        return view('admin.penelitian.create', [
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
            'status' => 'required',
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

        if ($request->file('file_penelitian')) {
            $validated['file_penelitian'] = $request->file('file_penelitian')->store('file_penelitian');
        } else {
            $validated['file_penelitian'] = null;
        }

        Penelitian::create($validated);

        return redirect()->route('data-penelitian.penelitian', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $dosens = Dosen::latest()->get();
        $penelitians = Penelitian::where('id', $id)->first();
        return view('admin.penelitian.edit', [
            'dosens' => $dosens,
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
            'status' => 'required',
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

        return redirect()->route('data-penelitian.penelitian', $penelitians->tahun_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
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
}
