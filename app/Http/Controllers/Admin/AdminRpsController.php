<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Rps;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRpsController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.rps.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $prodis = Prodi::where('id', $id)->first();
        $tahuns = Tahun::latest()->get();
        return view('admin.rps.tahun', [
            'prodis' => $prodis,
            'tahuns' => $tahuns,
        ]);
    }

    public function rps($id)
    {
        $rps = Rps::where('tahun_id', $id)->latest()->get();
        $tahuns = Tahun::where('id', $id)->first();
        return view('admin.rps.rps', [
            'rps' => $rps,
            'tahuns' => $tahuns,
        ]);
    }

    public function create($id)
    {
        $prodis = Prodi::latest()->get();
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::latest()->get();
        $tahuns = Tahun::where('id', $id)->first();

        return view('admin.rps.create', [
            'prodis' => $prodis,
            'mahasiswas' => $mahasiswas,
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
            'semester' => 'required',
            'file_rps' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'dosen_id.required' => 'Dosen wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'file_rps.required' => 'File Rps wajib diisi',
            'file_rps.mimes' => 'File Rps harus memiliki format PDF',
            'file_rps.max' => 'File Rps maksimal 2 MB',
        ]);

        if ($request->file('file_rps')) {
            $validated['file_rps'] = $request->file('file_rps')->store('file_rps');
        }

        Rps::create($validated);

        return redirect()->route('data-rps.rps', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil menambahkan data!');
    }

    public function edit($id)
    {
        $prodis = Prodi::latest()->get();
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::latest()->get();
        $rps = Rps::where('id', $id)->first();

        return view('admin.rps.edit', [
            'prodis' => $prodis,
            'mahasiswas' => $mahasiswas,
            'dosens' => $dosens,
            'rps' => $rps,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'dosen_id' => 'required',
            'semester' => 'required',
            'file_rps' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'dosen_id.required' => 'Dosen wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'file_rps.required' => 'File Rps wajib diisi',
            'file_rps.mimes' => 'File Rps harus memiliki format PDF',
            'file_rps.max' => 'File Rps maksimal 2 MB',
        ]);

        $rps = Rps::where('id', $id)->first();

        if ($request->file('file_rps')) {
            if ($rps->file_rps) {
                Storage::delete($rps->file_rps);
            }
            $validated['file_rps'] = $request->file('file_rps')->store('file_rps');
        } else {
            $validated['file_rps'] = $rps->file_rps;
        }

        $rps->update($validated);

        return redirect()->route('data-rps.rps', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data!');
    }

    public function destroy($id)
    {
        $rps = Rps::where('id', $id)->first();
        $rps->delete();

        return back()->with('success', 'Selamat ! Anda berhasil menghapus data!');
    }
}
