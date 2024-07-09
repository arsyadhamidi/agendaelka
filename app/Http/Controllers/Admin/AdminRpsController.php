<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Matkul;
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
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
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
        $tahuns = Tahun::where('id', $id)->first();
        $prodis = Prodi::latest()->get();
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::where('prodi_id', $tahuns->prodi_id)->latest()->get();
        $matkuls = Matkul::where('prodi_id', $tahuns->prodi_id)->where('tahun_id', $tahuns->id)->latest()->get();

        return view('admin.rps.create', [
            'prodis' => $prodis,
            'mahasiswas' => $mahasiswas,
            'dosens' => $dosens,
            'tahuns' => $tahuns,
            'matkuls' => $matkuls,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'dosen_id' => 'required',
            'matkul_id' => 'required',
            'semester' => 'required',
            'file_rps' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'dosen_id.required' => 'Dosen wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'matkul_id.required' => 'Mata Kuliah wajib diisi',
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
        $rps = Rps::where('id', $id)->first();
        $prodis = Prodi::latest()->get();
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::where('prodi_id', $rps->prodi_id)->latest()->get();
        $matkuls = Matkul::where('prodi_id', $rps->prodi_id)->where('tahun_id', $rps->tahun_id)->latest()->get();

        return view('admin.rps.edit', [
            'prodis' => $prodis,
            'mahasiswas' => $mahasiswas,
            'dosens' => $dosens,
            'rps' => $rps,
            'matkuls' => $matkuls,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'dosen_id' => 'required',
            'matkul_id' => 'required',
            'semester' => 'required',
            'file_rps' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'dosen_id.required' => 'Dosen wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'matkul_id.required' => 'Mata Kuliah wajib diisi',
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
