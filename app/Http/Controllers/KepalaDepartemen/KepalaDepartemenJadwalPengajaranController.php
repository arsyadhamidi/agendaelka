<?php

namespace App\Http\Controllers\KepalaDepartemen;

use App\Http\Controllers\Controller;
use App\Models\JadwalPengajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KepalaDepartemenJadwalPengajaranController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPengajaran::latest()->get();
        return view('kepala-departemen.jadwal-pengajaran.index', [
            'jadwals' => $jadwals,
        ]);
    }

    public function create()
    {
        return view('kepala-departemen.jadwal-pengajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'jadwal_pengajaran' => 'required|mimes:pdf|max:2048',
        ], [
            'tahun.required' => 'Tahun wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'jadwal_pengajaran.required' => 'Jadwal Pengajaran wajib diisi',
            'jadwal_pengajaran.mimes' => 'Jadwal Pengajaran harus memiliki format PDF',
            'jadwal_pengajaran.max' => 'Jadwal Pengajaran maksimal',
        ]);

        if ($request->file('jadwal_pengajaran')) {
            $validated['jadwal_pengajaran'] = $request->file('jadwal_pengajaran')->store('jadwal_pengajaran');
        }

        JadwalPengajaran::create($validated);

        return redirect('kepala-jadwalpengajaran')->with('success', 'Selamat ! Anda berhasil menambahkan data!');
    }

    public function edit($id)
    {
        $jadwal = JadwalPengajaran::where('id', $id)->first();
        return view('kepala-departemen.jadwal-pengajaran.edit', [
            'jadwals' => $jadwal,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'jadwal_pengajaran' => 'required|mimes:pdf|max:2048',
        ], [
            'tahun.required' => 'Tahun wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'jadwal_pengajaran.required' => 'Jadwal Pengajaran wajib diisi',
            'jadwal_pengajaran.mimes' => 'Jadwal Pengajaran harus memiliki format PDF',
            'jadwal_pengajaran.max' => 'Jadwal Pengajaran maksimal',
        ]);

        $jadwals = JadwalPengajaran::where('id', $id)->first();

        if ($request->file('jadwal_pengajaran')) {
            if ($jadwals->jadwal_pengajaran) {
                Storage::delete($jadwals->jadwal_pengajaran);
            }
            $validated['jadwal_pengajaran'] = $request->file('jadwal_pengajaran')->store('jadwal_pengajaran');
        } else {
            $validated['jadwal_pengajaran'] = $jadwals->jadwal_pengajaran;
        }

        $jadwals->update($validated);

        return redirect('kepala-jadwalpengajaran')->with('success', 'Selamat ! Anda berhasil memperbaharui data!');
    }

    public function destroy($id)
    {
        $jadwals = JadwalPengajaran::where('id', $id)->first();
        $jadwals->delete();

        return redirect('kepala-jadwalpengajaran')->with('success', 'Selamat ! Anda berhasil menghapus data!');
    }
}
