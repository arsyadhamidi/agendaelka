<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudiLanjut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminStudiLanjutController extends Controller
{
    public function index()
    {
        $studis = StudiLanjut::latest()->get();
        return view('admin.studi-lanjut.index', [
            'studis' => $studis,
        ]);
    }

    public function create()
    {
        return view('admin.studi-lanjut.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'pendidikan' => 'required',
            'universitas' => 'required',
            'tahun' => 'required',
            'berkas' => 'required|mimes:pdf',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi',
            'pendidikan.required' => 'Pendidikan wajib diisi',
            'universitas.required' => 'Universitas wajib diisi',
            'tahun.required' => 'Tahun wajib diisi',
            'berkas.required' => 'Berkas wajib diisi',
            'berkas.mimes' => 'Berkas harus wajib memiliki format PDF',
        ]);

        if ($request->file('berkas')) {
            $validated['berkas'] = $request->file('berkas')->store('berkas');
        } else {
            $validated['berkas'] = null;
        }

        StudiLanjut::create($validated);

        return redirect()->route('data-studilanjut.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $studis = StudiLanjut::where('id', $id)->first();
        return view('admin.studi-lanjut.edit', [
            'studis' => $studis,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'pendidikan' => 'required',
            'universitas' => 'required',
            'tahun' => 'required',
            'berkas' => 'required|mimes:pdf',
        ], [
            'nama.required' => 'Nama Lengkap wajib diisi',
            'pendidikan.required' => 'Pendidikan wajib diisi',
            'universitas.required' => 'Universitas wajib diisi',
            'tahun.required' => 'Tahun wajib diisi',
            'berkas.required' => 'Berkas wajib diisi',
            'berkas.mimes' => 'Berkas harus wajib memiliki format PDF',
        ]);

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

        return redirect()->route('data-studilanjut.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $studis = StudiLanjut::where('id', $id)->first();
        if ($studis->berkas) {
            Storage::delete($studis->berkas);
        }

        return redirect()->route('data-studilanjut.index')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
