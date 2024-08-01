<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudiLanjutExport;
use App\Models\Prodi;
use App\Models\Tahun;
use App\Models\StudiLanjut;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class AdminStudiLanjutController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.studi-lanjut.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('admin.studi-lanjut.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function studilanjut($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $studis = StudiLanjut::with('tahun')->where('tahun_id', $id)->latest()->get();
        return view('admin.studi-lanjut.studi', [
            'studis' => $studis,
            'tahuns' => $tahuns,
        ]);
    }

    public function generateexcel($id)
    {
        $query = StudiLanjut::where('tahun_id', $id);
        $data = $query->orderBy('id', 'desc')->get();

        return Excel::download(new StudiLanjutExport($data), 'data-studilanjut.xlsx');
    }

    public function create($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        return view('admin.studi-lanjut.create', [
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

        if ($request->file('berkas')) {
            $validated['berkas'] = $request->file('berkas')->store('berkas');
        } else {
            $validated['berkas'] = null;
        }

        StudiLanjut::create($validated);

        return redirect()->route('data-studilanjut.studilanjut', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
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

        return redirect()->route('data-studilanjut.studilanjut', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $studis = StudiLanjut::where('id', $id)->first();
        if ($studis->berkas) {
            Storage::delete($studis->berkas);
        }

        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
