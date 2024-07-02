<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Akademik;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class KaprodiAkademikController extends Controller
{
    public function index()
    {
        $dosens = Dosen::latest()->get();
        return view('kaprodi.akademik.index', [
            'dosens' => $dosens,
        ]);
    }

    public function akademik($id)
    {
        $dosens = Dosen::where('id', $id)->first();
        $akademiks = Akademik::where('dosen_id', $id)->latest()->get();

        return view('kaprodi.akademik.akademik', [
            'dosens' => $dosens,
            'akademiks' => $akademiks,
        ]);
    }

    public function create($id)
    {
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::where('id', $id)->first();

        return view('kaprodi.akademik.create', [
            'dosens' => $dosens,
            'mahasiswas' => $mahasiswas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required',
            'mahasiswa_id' => 'required',
            'tahun' => 'required',
        ]);

        Akademik::create($validated);

        return redirect('kaprodi-akademik/akademik/' . $request->dosen_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $mahasiswas = Mahasiswa::latest()->get();
        $dosens = Dosen::latest()->get();
        $akademiks = Akademik::where('id', $id)->first();

        return view('kaprodi.akademik.edit', [
            'dosens' => $dosens,
            'mahasiswas' => $mahasiswas,
            'akademiks' => $akademiks,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'dosen_id' => 'required',
            'mahasiswa_id' => 'required',
            'tahun' => 'required',
        ]);

        Akademik::where('id', $id)->update($validated);

        return redirect('kaprodi-akademik/akademik/' . $request->dosen_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $akademiks = Akademik::where('id', $id)->first();
        $akademiks->delete();

        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
