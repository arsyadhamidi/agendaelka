<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Exports\SeminarExport;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Seminar;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaSeminarController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::where('id', Auth::user()->mahasiswa_id)->first();
        $semianrs = Seminar::where('mahasiswa_id', $mahasiswas->id)->latest()->get();
        return view('mahasiswa.seminar.index', [
            'seminars' => $semianrs,
        ]);
    }

    public function generateexcel()
    {
        $query = Seminar::query();
        $data = $query->orderBy('id', 'desc')->get();

        return Excel::download(new SeminarExport($data), 'mahasiswa-seminar.xlsx');
    }

    public function create()
    {
        $mahasiswas = Mahasiswa::where('id', Auth::user()->mahasiswa_id)->first();
        $tahuns = Tahun::latest()->get();
        $dosens = Dosen::latest()->get();
        $prodis = Prodi::latest()->get();
        return view('mahasiswa.seminar.create', [
            'tahuns' => $tahuns,
            'dosens' => $dosens,
            'prodis' => $prodis,
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

        if ($request->file('file_seminar')) {
            $validated['file_seminar'] = $request->file('file_seminar')->store('file_seminar');
        } else {
            $validated['file_seminar'] = null;
        }

        Seminar::create($validated);

        return redirect()->route('mahasiswa-seminar.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $seminars = Seminar::where('id', $id)->first();
        $mahasiswas = Mahasiswa::where('id', Auth::user()->mahasiswa_id)->first();
        $tahuns = Tahun::latest()->get();
        $dosens = Dosen::latest()->get();
        $prodis = Prodi::latest()->get();
        return view('mahasiswa.seminar.edit', [
            'tahuns' => $tahuns,
            'dosens' => $dosens,
            'prodis' => $prodis,
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

        $seminars = Seminar::where('id', $id)->first();

        if ($request->file('file_seminar')) {
            if ($seminars->file_seminar) {
                Storage::delete($seminars->file_seminar);
            }
            $validated['file_seminar'] = $request->file('file_seminar')->store('file_seminar');
        } else {
            $validated['file_seminar'] = $seminars->file_seminar;
        }

        Seminar::where('id', $id)->update($validated);

        return redirect()->route('mahasiswa-seminar.seminar', $request->tahun_id)->with('success', 'Selamat ! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $seminar = Seminar::where('id', $id)->first();
        if ($seminar->file_seminar) {
            Storage::delete($seminar->file_seminar);
        }
        $seminar->delete();

        return back()->with('success', 'Selamat ! Anda berhasil menghapus data');
    }
}
