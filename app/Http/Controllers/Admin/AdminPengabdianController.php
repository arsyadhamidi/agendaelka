<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Pengabdian;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPengabdianController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.pengabdian.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('admin.pengabdian.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function pengabdian($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $pengabdians = Pengabdian::where('tahun_id', $id)->latest()->get();
        return view('admin.pengabdian.pengabdian', [
            'pengabdians' => $pengabdians,
            'tahuns' => $tahuns,
        ]);
    }

    public function create($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $dosens = Dosen::where('prodi_id', $tahuns->prodi_id)->latest()->get();
        return view('admin.pengabdian.create', [
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
            'tanggal' => 'required',
            'judul' => 'required',
            'lokasi' => 'required',
            'file_pengabdian' => 'required|mimes:pdf|max:2048',
        ], [
            'dosen_id.required' => 'Dosen wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'file_pengabdian.required' => 'File Pengabdian Masyarakat wajib diisi',
            'file_pengabdian.mimes' => 'File Pengabdian Masyarakat harus memiliki format PDF',
            'file_pengabdian.max' => 'File Pengabdian Masyarakat maksimal 2 MB',
        ]);

        if ($request->file('file_pengabdian')) {
            $validated['file_pengabdian'] = $request->file('file_pengabdian')->store('file_pengabdian');
        } else {
            $validated['file_pengabdian'] = null;
        }

        Pengabdian::create($validated);

        return redirect()->route('data-pengabdian.pengabdian', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $dosens = Dosen::latest()->get();
        $pengabdians = Pengabdian::where('id', $id)->first();
        return view('admin.pengabdian.edit', [
            'dosens' => $dosens,
            'pengabdians' => $pengabdians,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'dosen_id' => 'required',
            'tanggal' => 'required',
            'judul' => 'required',
            'lokasi' => 'required',
            'file_pengabdian' => 'required|mimes:pdf|max:2048',
        ], [
            'dosen_id.required' => 'Dosen wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'file_pengabdian.required' => 'File Pengabdian Masyarakat wajib diisi',
            'file_pengabdian.mimes' => 'File Pengabdian Masyarakat harus memiliki format PDF',
            'file_pengabdian.max' => 'File Pengabdian Masyarakat maksimal 2 MB',
        ]);

        $pengabdians = Pengabdian::where('id', $id)->first();
        if ($request->file('file_pengabdian')) {
            if ($pengabdians->file_pengabdian) {
                Storage::delete('file_pengabdian');
            }
            $validated['file_pengabdian'] = $request->file('file_pengabdian')->store('file_pengabdian');
        } else {
            $validated['file_pengabdian'] = $pengabdians->file_pengabdian;
        }

        $pengabdians->update($validated);

        return redirect()->route('data-pengabdian.pengabdian', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $pengabdians = Pengabdian::find($id);
        if ($pengabdians->file_pengabdian) {
            Storage::delete('file_pengabdian');
        }
        $pengabdians->delete();
        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
