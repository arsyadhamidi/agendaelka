<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Pengabdian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPengabdianController extends Controller
{
    public function index()
    {
        $pengabdians = Pengabdian::latest()->get();
        return view('admin.pengabdian.index', [
            'pengabdians' => $pengabdians,
        ]);
    }

    public function create()
    {
        $dosens = Dosen::latest()->get();
        return view('admin.pengabdian.create', [
            'dosens' => $dosens,
        ]);
    }

    public function store(Request $request)
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

        if ($request->file('file_pengabdian')) {
            $validated['file_pengabdian'] = $request->file('file_pengabdian')->store('file_pengabdian');
        } else {
            $validated['file_pengabdian'] = null;
        }

        Pengabdian::create($validated);

        return redirect()->route('data-pengabdian.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
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

        return redirect()->route('data-pengabdian.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $pengabdians = Pengabdian::find($id);
        if ($pengabdians->file_pengabdian) {
            Storage::delete('file_pengabdian');
        }
        $pengabdians->delete();
        return redirect()->route('data-pengabdian.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
