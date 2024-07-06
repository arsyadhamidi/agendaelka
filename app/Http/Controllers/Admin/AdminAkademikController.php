<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akademik;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;

class AdminAkademikController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.akademik.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('admin.akademik.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function akademik($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $akademiks = Akademik::where('tahun_id', $id)->latest()->get();

        return view('admin.akademik.akademik', [
            'tahuns' => $tahuns,
            'akademiks' => $akademiks,
        ]);
    }

    public function create($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $mahasiswas = Mahasiswa::where('prodi_id', $tahuns->prodi_id)
            ->where('id', $tahuns->id)
            ->latest()
            ->get();
        $dosens = Dosen::where('prodi_id', $tahuns->prodi_id)->latest()->get();

        return view('admin.akademik.create', [
            'tahuns' => $tahuns,
            'mahasiswas' => $mahasiswas,
            'dosens' => $dosens,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required',
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'mahasiswa_id' => 'required',
        ]);

        Akademik::create($validated);

        return redirect('data-akademik/akademik/' . $request->tahun_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $akademiks = Akademik::where('id', $id)->first();
        $mahasiswas = Mahasiswa::where('prodi_id', $akademiks->prodi_id)
            ->where('tahun_id', $akademiks->tahun_id)
            ->latest()
            ->get();
        $dosens = Dosen::where('prodi_id', $akademiks->prodi_id)->latest()->get();

        return view('admin.akademik.edit', [
            'dosens' => $dosens,
            'mahasiswas' => $mahasiswas,
            'akademiks' => $akademiks,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'dosen_id' => 'required',
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'mahasiswa_id' => 'required',
        ]);

        Akademik::where('id', $id)->update($validated);

        return redirect('data-akademik/akademik/' . $request->tahun_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $akademiks = Akademik::where('id', $id)->first();
        $akademiks->delete();

        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
