<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Pengabdian;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DosenPengabdianController extends Controller
{
    public function index()
    {
        $pengabdians = Pengabdian::where('users_id', Auth::user()->id)->latest()->get();
        return view('dosen.pengabdian.index', [
            'pengabdians' => $pengabdians,
        ]);
    }

    public function create()
    {
        $prodis = Prodi::latest()->get();
        $tahuns = Tahun::latest()->get();
        return view('dosen.pengabdian.create', [
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
            'tanggal' => 'required',
            'judul' => 'required',
            'lokasi' => 'required',
            'file_pengabdian' => 'required|mimes:pdf|max:2048',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'file_pengabdian.required' => 'File Pengabdian Masyarakat wajib diisi',
            'file_pengabdian.mimes' => 'File Pengabdian Masyarakat harus memiliki format PDF',
            'file_pengabdian.max' => 'File Pengabdian Masyarakat maksimal 2 MB',
        ]);

        $validated['users_id'] = Auth::user()->id;
        $validated['status'] = 'Dosen';

        if ($request->file('file_pengabdian')) {
            $validated['file_pengabdian'] = $request->file('file_pengabdian')->store('file_pengabdian');
        } else {
            $validated['file_pengabdian'] = null;
        }

        Pengabdian::create($validated);

        return redirect()->route('dosen-pengabdian.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $prodis = Prodi::latest()->get();
        $tahuns = Tahun::latest()->get();
        $pengabdians = Pengabdian::where('id', $id)->first();
        return view('dosen.pengabdian.edit', [
            'prodis' => $prodis,
            'tahuns' => $tahuns,
            'pengabdians' => $pengabdians,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'nama' => 'required',
            'tanggal' => 'required',
            'judul' => 'required',
            'lokasi' => 'required',
            'file_pengabdian' => 'required|mimes:pdf|max:2048',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'file_pengabdian.required' => 'File Pengabdian Masyarakat wajib diisi',
            'file_pengabdian.mimes' => 'File Pengabdian Masyarakat harus memiliki format PDF',
            'file_pengabdian.max' => 'File Pengabdian Masyarakat maksimal 2 MB',
        ]);

        $validated['users_id'] = Auth::user()->id;
        $validated['status'] = 'Dosen';

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

        return redirect()->route('dosen-pengabdian.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
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

    public function getTahun($prodiId)
    {
        $tahuns = Tahun::where('prodi_id', $prodiId)->get();
        return response()->json(['tahuns' => $tahuns]);
    }
}
