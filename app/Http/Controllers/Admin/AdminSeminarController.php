<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SeminarExport;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Seminar;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminSeminarController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.seminar.index', [
            'prodis' => $prodis,
        ]);
    }

    public function tahun($id)
    {
        $tahuns = Tahun::where('prodi_id', $id)->latest()->get();
        return view('admin.seminar.tahun', [
            'tahuns' => $tahuns,
        ]);
    }

    public function seminar($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $semianrs = Seminar::where('tahun_id', $id)->latest()->get();
        return view('admin.seminar.seminar', [
            'tahuns' => $tahuns,
            'seminars' => $semianrs,
        ]);
    }

    public function generateexcel($id)
    {
        $query = Seminar::where('tahun_id', $id);
        $data = $query->orderBy('id', 'desc')->get();

        return Excel::download(new SeminarExport($data), 'data-seminar.xlsx');
    }

    public function create($id)
    {
        $tahuns = Tahun::where('id', $id)->first();
        $dosens = Dosen::where('prodi_id', $tahuns->prodi_id)->latest()->get();
        $mahasiswas = Mahasiswa::where('prodi_id', $tahuns->prodi_id)
            ->where('tahun_id', $tahuns->id)
            ->latest()
            ->get();
        return view('admin.seminar.create', [
            'tahuns' => $tahuns,
            'dosens' => $dosens,
            'mahasiswas' => $mahasiswas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'dosen_id' => 'required',
            'mahasiswa_id' => 'required',
            'penelaah1_id' => 'required',
            'penelaah2_id' => 'required',
            'judul' => 'required',
            'tgl_seminar' => 'required',
            'tgl_ujian' => 'required',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'dosen_id.required' => 'Dosen wajib diisi',
            'mahasiswa_id.required' => 'Mahasiswa wajib diisi',
            'penelaah1_id.required' => 'Penelaah 1 wajib diisi',
            'penelaah2_id.required' => 'Penelaah 2 wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'tgl_seminar.required' => 'Tanggal Seminar wajib diisi',
            'tgl_ujian.required' => 'Tanggal Ujian wajib diisi',
        ]);

        Seminar::create($validated);

        return redirect()->route('data-seminar.seminar', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $seminars = Seminar::where('id', $id)->first();
        $dosens = Dosen::where('prodi_id', $seminars->prodi_id)->latest()->get();
        $mahasiswas = Mahasiswa::where('prodi_id', $seminars->prodi_id)
            ->where('tahun_id', $seminars->id)
            ->latest()
            ->get();
        return view('admin.seminar.edit', [
            'dosens' => $dosens,
            'mahasiswas' => $mahasiswas,
            'seminars' => $seminars,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'tahun_id' => 'required',
            'dosen_id' => 'required',
            'mahasiswa_id' => 'required',
            'penelaah1_id' => 'required',
            'penelaah2_id' => 'required',
            'judul' => 'required',
            'tgl_seminar' => 'required',
            'tgl_ujian' => 'required',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'tahun_id.required' => 'Tahun wajib diisi',
            'dosen_id.required' => 'Dosen wajib diisi',
            'mahasiswa_id.required' => 'Mahasiswa wajib diisi',
            'penelaah1_id.required' => 'Penelaah 1 wajib diisi',
            'penelaah2_id.required' => 'Penelaah 2 wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'tgl_seminar.required' => 'Tanggal Seminar wajib diisi',
            'tgl_ujian.required' => 'Tanggal Ujian wajib diisi',
        ]);

        Seminar::where('id', $id)->update($validated);

        return redirect()->route('data-seminar.seminar', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $seminar = Seminar::where('id', $id)->first();
        $seminar->delete();

        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
