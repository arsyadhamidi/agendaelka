<?php

namespace App\Http\Controllers\KepalaDepartemen;

use App\Http\Controllers\Controller;
use App\Models\Rapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KepalaDepartemenRapatController extends Controller
{
    public function index()
    {
        $rapats = Rapat::latest()->get();
        return view('kepala-departemen.rapat.index', [
            'rapats' => $rapats,
        ]);
    }

    public function create()
    {
        return view('kepala-departemen.rapat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'kegiatan' => 'required',
            'waktu' => 'required',
            'lokasi' => 'required',
            'berkas' => 'required|mimes:pdf|max:2048',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'kegiatan.required' => 'Kegiatan wajib diisi',
            'waktu.required' => 'Waktu wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'berkas.required' => 'berkas wajib diisi',
            'berkas.max' => 'berkas harus maksimal 2 MB',
        ]);

        if ($request->file('berkas')) {
            $validated['berkas'] = $request->file('berkas')->store('berkas');
        } else {
            $validated['berkas'] = null;
        }

        Rapat::create($validated);

        return redirect('/kepala-rapat')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $rapats = Rapat::find($id);
        return view('kepala-departemen.rapat.edit', [
            'rapats' => $rapats,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required',
            'kegiatan' => 'required',
            'waktu' => 'required',
            'lokasi' => 'required',
            'berkas' => 'required|mimes:pdf|max:2048',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'kegiatan.required' => 'Kegiatan wajib diisi',
            'waktu.required' => 'Waktu wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'berkas.required' => 'berkas wajib diisi',
            'berkas.mimes' => 'berkas harus memiliki format PDF',
            'berkas.max' => 'berkas harus maksimal 2 MB',
        ]);

        $rapats = Rapat::where('id', $id)->first();
        if ($request->file('berkas')) {
            if ($rapats->berkas) {
                Storage::delete($rapats->berkas);
            }
            $validated['berkas'] = $request->file('berkas')->store('berkas');
        } else {
            $validated['berkas'] = $rapats->berkas;
        }

        Rapat::where('id', $id)->update($validated);

        return redirect('/kepala-rapat')->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $rapats = Rapat::find($id);
        $rapats->delete();
        return redirect('/kepala-rapat')->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
