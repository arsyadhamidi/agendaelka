<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\BahanAjar;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DosenBahanAjarController extends Controller
{
    public function index()
    {
        $bahans = BahanAjar::latest()->get();
        return view('dosen.bahan-ajar.index', [
            'bahans' => $bahans,
        ]);
    }

    public function create()
    {
        $prodis = Prodi::latest()->get();
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::latest()->get();

        return view('dosen.bahan-ajar.create', [
            'prodis' => $prodis,
            'mahasiswas' => $mahasiswas,
            'dosens' => $dosens,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'semester' => 'required',
            'tahun' => 'required',
            'bahan_ajar' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'tahun.required' => 'Tahun wajib diisi',
            'bahan_ajar.required' => 'Bahan Ajar wajib diisi',
            'bahan_ajar.mimes' => 'Bahan Ajar harus memiliki format PDF',
            'bahan_ajar.max' => 'Bahan Ajar maksimal 2 MB',
        ]);

        $validated['dosen_id'] = Auth::user()->dosen_id;

        if ($request->file('bahan_ajar')) {
            $validated['bahan_ajar'] = $request->file('bahan_ajar')->store('bahan_ajar');
        }

        BahanAjar::create($validated);

        return redirect('dosen-bahanajar')->with('success', 'Selamat ! Anda berhasil menambahkan data!');
    }

    public function edit($id)
    {
        $prodis = Prodi::latest()->get();
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::latest()->get();
        $bahans = BahanAjar::where('id', $id)->first();

        return view('dosen.bahan-ajar.edit', [
            'prodis' => $prodis,
            'mahasiswas' => $mahasiswas,
            'dosens' => $dosens,
            'bahans' => $bahans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'semester' => 'required',
            'tahun' => 'required',
            'bahan_ajar' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'tahun.required' => 'Tahun wajib diisi',
            'bahan_ajar.required' => 'Bahan Ajar wajib diisi',
            'bahan_ajar.mimes' => 'Bahan Ajar harus memiliki format PDF',
            'bahan_ajar.max' => 'Bahan Ajar maksimal 2 MB',
        ]);

        $validated['dosen_id'] = Auth::user()->dosen_id;
        $bahans = BahanAjar::where('id', $id)->first();

        if ($request->file('bahan_ajar')) {
            if ($bahans->bahan_ajar) {
                Storage::delete($bahans->bahan_ajar);
            }
            $validated['bahan_ajar'] = $request->file('bahan_ajar')->store('bahan_ajar');
        } else {
            $validated['bahan_ajar'] = $bahans->bahan_ajar;
        }

        $bahans->update($validated);

        return redirect('dosen-bahanajar')->with('success', 'Selamat ! Anda berhasil memperbaharui data!');
    }

    public function destroy($id)
    {
        $bahans = BahanAjar::where('id', $id)->first();
        $bahans->delete();

        return redirect('dosen-bahanajar')->with('success', 'Selamat ! Anda berhasil menghapus data!');
    }
}
