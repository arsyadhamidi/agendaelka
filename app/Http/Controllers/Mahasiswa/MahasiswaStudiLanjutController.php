<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\StudiLanjut;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaStudiLanjutController extends Controller
{
    public function index()
    {
        $studis = StudiLanjut::where('users_id', Auth::user()->id)->latest()->get();
        return view('mahasiswa.studi-lanjut.index', [
            'studis' => $studis,
        ]);
    }

    public function create()
    {
        $prodis = Prodi::latest()->get();
        $tahuns = Tahun::latest()->get();
        return view('mahasiswa.studi-lanjut.create', [
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
            'pendidikan' => 'required',
            'universitas' => 'required',
            'berkas' => 'required|mimes:pdf',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'nama.required' => 'Nama Lengkap wajib diisi',
            'pendidikan.required' => 'Pendidikan wajib diisi',
            'universitas.required' => 'Universitas wajib diisi',
            'berkas.required' => 'Berkas wajib diisi',
            'berkas.mimes' => 'Berkas harus wajib memiliki format PDF',
        ]);

        $validated['users_id'] = Auth::user()->id;

        if ($request->file('berkas')) {
            $validated['berkas'] = $request->file('berkas')->store('berkas');
        } else {
            $validated['berkas'] = null;
        }

        StudiLanjut::create($validated);

        return redirect()->route('mahasiswa-studilanjut.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $prodis = Prodi::latest()->get();
        $tahuns = Tahun::latest()->get();
        $studis = StudiLanjut::where('id', $id)->first();
        return view('mahasiswa.studi-lanjut.edit', [
            'prodis' => $prodis,
            'tahuns' => $tahuns,
            'studis' => $studis,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'nama' => 'required',
            'pendidikan' => 'required',
            'universitas' => 'required',
            'berkas' => 'required|mimes:pdf',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'nama.required' => 'Nama Lengkap wajib diisi',
            'pendidikan.required' => 'Pendidikan wajib diisi',
            'universitas.required' => 'Universitas wajib diisi',
            'berkas.required' => 'Berkas wajib diisi',
            'berkas.mimes' => 'Berkas harus wajib memiliki format PDF',
        ]);

        $validated['users_id'] = Auth::user()->id;

        $studis = StudiLanjut::where('id', $id)->first();
        if ($request->file('berkas')) {
            if ($studis->berkas) {
                Storage::delete($studis->berkas);
            }
            $validated['berkas'] = $request->file('berkas')->store('berkas');
        } else {
            $validated['berkas'] = $studis->berkas;
        }

        $studis->update($validated);

        return redirect()->route('mahasiswa-studilanjut.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $studis = StudiLanjut::where('id', $id)->first();
        if ($studis->berkas) {
            Storage::delete($studis->berkas);
        }

        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }

    public function getTahun($prodiId)
    {
        $tahuns = Tahun::where('prodi_id', $prodiId)->get();
        return response()->json(['tahuns' => $tahuns]);
    }
}
