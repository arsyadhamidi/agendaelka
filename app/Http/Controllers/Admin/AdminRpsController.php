<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Rps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRpsController extends Controller
{
    public function index()
    {
        $rps = Rps::latest()->get();
        return view('admin.rps.index', [
            'rps' => $rps,
        ]);
    }

    public function create()
    {
        $prodis = Prodi::latest()->get();
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::latest()->get();

        return view('admin.rps.create', [
            'prodis' => $prodis,
            'mahasiswas' => $mahasiswas,
            'dosens' => $dosens,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'dosen_id' => 'required',
            'semester' => 'required',
            'tahun' => 'required',
            'file_rps' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'dosen_id.required' => 'Dosen wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'tahun.required' => 'Tahun wajib diisi',
            'file_rps.required' => 'File Rps wajib diisi',
            'file_rps.mimes' => 'File Rps harus memiliki format PDF',
            'file_rps.max' => 'File Rps maksimal 2 MB',
        ]);

        if ($request->file('file_rps')) {
            $validated['file_rps'] = $request->file('file_rps')->store('file_rps');
        }

        Rps::create($validated);

        return redirect('data-rps')->with('success', 'Selamat ! Anda berhasil menambahkan data!');
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
            'dosen_id' => 'required',
            'semester' => 'required',
            'tahun' => 'required',
            'file_rps' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'dosen_id.required' => 'Dosen wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'tahun.required' => 'Tahun wajib diisi',
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

        return redirect('data-rps')->with('success', 'Selamat ! Anda berhasil memperbaharui data!');
    }

    public function destroy($id)
    {
        $rps = Rps::where('id', $id)->first();
        $rps->delete();

        return redirect('data-rps')->with('success', 'Selamat ! Anda berhasil menghapus data!');
    }
}