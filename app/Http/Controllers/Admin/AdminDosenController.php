<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDosenController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::latest()->get();
        return view('admin.dosen.index', [
            'jurusans' => $jurusans,
        ]);
    }

    public function prodi($id)
    {
        $prodis = Prodi::where('id', $id)->latest()->get();
        return view('admin.dosen.prodi', [
            'prodis' => $prodis,
        ]);
    }

    public function dosen($id)
    {
        $prodis = Prodi::where('id', $id)->first();
        $dosens = Dosen::where('prodi_id', $id)->latest()->get();
        return view('admin.dosen.dosen', [
            'dosens' => $dosens,
            'prodis' => $prodis,
        ]);
    }

    public function create($id)
    {
        $prodis = Prodi::where('id', $id)->first();
        $jurusans = Jurusan::where('id', $prodis->jurusan_id)->first();
        return view('admin.dosen.create', [
            'jurusans' => $jurusans,
            'prodis' => $prodis,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'prodi_id' => 'required',
            'nip' => 'required|unique:dosens,nip',
            'nama' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'email' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'foto_dosen' => 'required|mimes:png,jpeg,jpg|max:2048',
        ], [
            'jurusan_id.required' => 'Jurusan wajib diisi',
            'prodi_id.required' => 'Program Studi wajib diisi',
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah tersedia',
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jk.required' => 'Jenis Kelamin wajib diisi',
            'email.required' => 'Alamat Email wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'alamat.required' => 'Alamat Domisili wajib diisi',
            'foto_dosen.required' => 'Foto Dosen wajib diisi',
            'foto_dosen.mimes' => 'Foto Dosen harus memiliki format PNG, JPG, atau JPEG',
            'foto_dosen.max' => 'Foto Dosen maksimal 2 MB',
        ]);

        if ($request->file('foto_dosen')) {
            $validated['foto_dosen'] = $request->file('foto_dosen')->store('foto_dosen');
        }

        $users = User::where('username', $request->nip)->first();

        if (!empty($users)) {
            return back()->with('error', 'Username sudah tersedia');
        }

        $dosens = Dosen::create($validated);

        User::create([
            'name' => $request->nama ?? '-',
            'username' => $request->nip ?? '-',
            'password' => bcrypt('12345678'),
            'level_id' => '5',
            'telp' => $request->telp ?? '-',
            'dosen_id' => $dosens->id,
        ]);

        return redirect()->route('data-dosen.dosen', $request->prodi_id)->with('success', 'Selamat! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $dosens = Dosen::where('id', $id)->first();
        return view('admin.dosen.edit', [
            'dosens' => $dosens,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'prodi_id' => 'required',
            'nip' => 'required|unique:dosens,nip',
            'nama' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'email' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'foto_dosen' => 'required|mimes:png,jpeg,jpg|max:2048',
        ], [
            'jurusan_id.required' => 'Jurusan wajib diisi',
            'prodi_id.required' => 'Program Studi wajib diisi',
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah tersedia',
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jk.required' => 'Jenis Kelamin wajib diisi',
            'email.required' => 'Alamat Email wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'alamat.required' => 'Alamat Domisili wajib diisi',
            'foto_dosen.required' => 'Foto Dosen wajib diisi',
            'foto_dosen.mimes' => 'Foto Dosen harus memiliki format PNG, JPG, atau JPEG',
            'foto_dosen.max' => 'Foto Dosen maksimal 2 MB',
        ]);

        $dosens = Dosen::where('id', $id)->first();
        if ($request->file('foto_dosen')) {
            if ($dosens->foto_dosen) {
                Storage::delete($dosens->foto_dosen);
            }
            $validated['foto_dosen'] = $request->file('foto_dosen')->store('foto_dosen');
        } else {
            $validated['foto_dosen'] = $dosens->foto_dosen;
        }

        $dosens->update($validated);

        return redirect()->route('data-dosen.dosen', $request->prodi_id)->with('success', 'Selamat! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $users = User::where('dosen_id', $id)->first();
        $users->delete();
        $dosens = Dosen::where('id', $id)->first();
        $dosens->delete();

        return back()->with('success', 'Selamat! Anda berhasil menghapus data');
    }
}
