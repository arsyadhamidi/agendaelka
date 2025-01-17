<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\Prodi;
use App\Models\Rps;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DosenRpsController extends Controller
{
    public function index()
    {
        $rps = Rps::where('dosen_id', Auth::user()->dosen_id)->latest()->get();
        return view('dosen.rps.index', [
            'rps' => $rps,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('dosen.rps.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function rps($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $rps = Rps::where('dosen_id', Auth::user()->dosen_id)->where('tahun_id', $id)->latest()->get();
        return view('dosen.rps.rps', [
            'rps' => $rps,
            'tahuns' => $tahuns,
        ]);
    }

    public function create()
    {
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::where('id', Auth::user()->dosen_id)->first();
        $prodis = Prodi::where('id', $dosens->prodi_id)->first();
        $tahuns = Tahun::where('prodi_id', $prodis->id)->latest()->get();
        $matkuls = Matkul::where('prodi_id', $prodis->id)->latest()->get();

        return view('dosen.rps.create', [
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
            'matkul_id' => 'required',
            'semester' => 'required',
            'file_rps' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'matkul_id.required' => 'Mata Kuliah wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'file_rps.required' => 'File Rps wajib diisi',
            'file_rps.mimes' => 'File Rps harus memiliki format PDF',
            'file_rps.max' => 'File Rps maksimal 2 MB',
        ]);

        $validated['dosen_id'] = Auth::user()->dosen_id;
        if ($request->file('file_rps')) {
            $validated['file_rps'] = $request->file('file_rps')->store('file_rps');
        }

        Rps::create($validated);

        return redirect()->route('dosen-rps.index')->with('success', 'Selamat ! Anda berhasil menambahkan data!');
    }

    public function edit($id)
    {
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::where('id', Auth::user()->dosen_id)->first();
        $prodis = Prodi::where('id', $dosens->prodi_id)->first();
        $tahuns = Tahun::where('prodi_id', $prodis->id)->latest()->get();
        $matkuls = Matkul::where('prodi_id', $prodis->id)->latest()->get();
        $rps = Rps::where('id', $id)->first();

        return view('dosen.rps.edit', [
            'prodis' => $prodis,
            'mahasiswas' => $mahasiswas,
            'dosens' => $dosens,
            'rps' => $rps,
            'tahuns' => $tahuns,
            'matkuls' => $matkuls,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'matkul_id' => 'required',
            'semester' => 'required',
            'file_rps' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'matkul_id.required' => 'Mata Kuliah wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'file_rps.required' => 'File Rps wajib diisi',
            'file_rps.mimes' => 'File Rps harus memiliki format PDF',
            'file_rps.max' => 'File Rps maksimal 2 MB',
        ]);

        $validated['dosen_id'] = Auth::user()->dosen_id;
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

        return redirect()->route('dosen-rps.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data!');
    }

    public function destroy($id)
    {
        $rps = Rps::where('id', $id)->first();
        $rps->delete();

        return back()->with('success', 'Selamat ! Anda berhasil menghapus data!');
    }
}
