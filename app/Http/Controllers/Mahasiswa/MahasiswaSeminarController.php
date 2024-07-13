<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaSeminarController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::where('id', Auth::user()->mahasiswa_id)->first();
        $seminars = Seminar::where('mahasiswa_id', $mahasiswas->id)
            ->where('prodi_id', $mahasiswas->prodi_id)
            ->where('tahun_id', $mahasiswas->tahun_id)
            ->latest()
            ->get();
        return view('mahasiswa.seminar.index', [
            'seminars' => $seminars,
        ]);
    }

    public function balas($id)
    {
        $seminars = Seminar::where('id', $id)->first();
        return view('mahasiswa.seminar.balas', [
            'seminars' => $seminars,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'file_seminar' => 'required|mimes:pdf|max:2048',
        ], [
            'file_seminar.required' => 'File Seminar wajib diisi',
            'file_seminar.mimes' => 'File Seminar harus memiliki format PDF',
            'file_seminar.max' => 'File Seminar maksimal 2 MB',
        ]);

        if ($request->file('file_seminar')) {
            $validated['file_seminar'] = $request->file('file_seminar')->store('file_seminar');
        }

        Seminar::where('id', $id)->update($validated);

        return redirect()->route('mahasiswa-seminar.index')->with('success', 'Selamat ! Anda berhasil menambahkan file seminar');
    }
}
