<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\BahanAjar;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DosenBahanAjarController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('dosen.bahan-ajar.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('dosen.bahan-ajar.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function bahanajar($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $bahans = BahanAjar::where('dosen_id', Auth::user()->dosen_id)->where('tahun_id', $id)->latest()->get();
        return view('dosen.bahan-ajar.bahan-ajar', [
            'bahans' => $bahans,
            'tahuns' => $tahuns,
        ]);
    }

    public function create($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $prodis = Prodi::latest()->get();
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::latest()->get();

        return view('dosen.bahan-ajar.create', [
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
            'semester' => 'required',
            'bahan_ajar' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'bahan_ajar.required' => 'Bahan Ajar wajib diisi',
            'bahan_ajar.mimes' => 'Bahan Ajar harus memiliki format PDF',
            'bahan_ajar.max' => 'Bahan Ajar maksimal 2 MB',
        ]);

        $validated['dosen_id'] = Auth::user()->dosen_id;

        if ($request->file('bahan_ajar')) {
            $validated['bahan_ajar'] = $request->file('bahan_ajar')->store('bahan_ajar');
        }

        BahanAjar::create($validated);

        return redirect()->route('dosen-bahanajar.bahanajar', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil menambahkan data!');
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
            'tahun_id' => 'required',
            'semester' => 'required',
            'bahan_ajar' => 'required|mimes:pdf|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'semester.required' => 'Semester wajib diisi',
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

        return redirect()->route('dosen-bahanajar.bahanajar', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data!');
    }

    public function destroy($id)
    {
        $bahans = BahanAjar::where('id', $id)->first();
        $bahans->delete();

        return redirect('dosen-bahanajar')->with('success', 'Selamat ! Anda berhasil menghapus data!');
    }
}
