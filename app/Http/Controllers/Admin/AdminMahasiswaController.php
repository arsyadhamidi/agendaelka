<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMahasiswaController extends Controller
{
    public function index()
    {
        $prodis = Prodi::latest()->get();
        return view('admin.mahasiswa.index', [
            'prodis' => $prodis,
        ]);
    }

    public function mahasiswa($id)
    {
        $prodis = Prodi::where('id', $id)->first();
        $mahasiswas = Mahasiswa::where('prodi_id', $id)->latest()->get();
        return view('admin.mahasiswa.mahasiswa', [
            'mahasiswas' => $mahasiswas,
            'prodis' => $prodis,
        ]);
    }

    public function create($id)
    {
        $prodis = Prodi::where('id', $id)->first();
        return view('admin.mahasiswa.create', [
            'prodis' => $prodis,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required',
            'tahun' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'email' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'foto_mahasiswa' => 'required|mimes:png,jpeg,jpg|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah tersedia',
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tahun.required' => 'Tahun Angkatan wajib diisi',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jk.required' => 'Jenis Kelamin wajib diisi',
            'email.required' => 'Alamat Email wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'alamat.required' => 'Alamat Domisili wajib diisi',
            'foto_mahasiswa.required' => 'Foto Mahasiswa wajib diisi',
            'foto_mahasiswa.mimes' => 'Foto Mahasiswa harus memiliki format PNG, JPG, atau JPEG',
            'foto_mahasiswa.max' => 'Foto Mahasiswa maksimal 2 MB',
        ]);

        if ($request->file('foto_mahasiswa')) {
            $validated['foto_mahasiswa'] = $request->file('foto_mahasiswa')->store('foto_mahasiswa');
        }

        $users = User::where('username', $request->nim)->first();

        if (!empty($users)) {
            return back()->with('error', 'Username sudah tersedia');
        }

        $mahasiswas = Mahasiswa::create($validated);

        User::create([
            'name' => $request->nama ?? '-',
            'username' => $request->nim ?? '-',
            'password' => bcrypt('12345678'),
            'level_id' => '6',
            'telp' => $request->telp ?? '-',
            'mahasiswa_id' => $mahasiswas->id,
        ]);

        return redirect()->route('data-mahasiswa.mahasiswa', $request->prodi_id)->with('success', 'Selamat! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $mahasiswas = Mahasiswa::where('id', $id)->first();
        return view('admin.mahasiswa.edit', [
            'mahasiswas' => $mahasiswas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prodi_id' => 'required',
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required',
            'tahun' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'email' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'foto_mahasiswa' => 'required|mimes:png,jpeg,jpg|max:2048',
        ], [
            'prodi_id.required' => 'Program Studi wajib diisi',
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah tersedia',
            'nama.required' => 'Nama Lengkap wajib diisi',
            'tahun.required' => 'Tahun Angkatan wajib diisi',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jk.required' => 'Jenis Kelamin wajib diisi',
            'email.required' => 'Alamat Email wajib diisi',
            'telp.required' => 'Nomor Telepon wajib diisi',
            'alamat.required' => 'Alamat Domisili wajib diisi',
            'foto_mahasiswa.required' => 'Foto Mahasiswa wajib diisi',
            'foto_mahasiswa.mimes' => 'Foto Mahasiswa harus memiliki format PNG, JPG, atau JPEG',
            'foto_mahasiswa.max' => 'Foto Mahasiswa maksimal 2 MB',
        ]);

        $mahasiswas = Mahasiswa::where('id', $id)->first();
        if ($request->file('foto_mahasiswa')) {
            if ($mahasiswas->foto_mahasiswa) {
                Storage::delete($mahasiswas->foto_mahasiswa);
            }
            $validated['foto_mahasiswa'] = $request->file('foto_mahasiswa')->store('foto_mahasiswa');
        } else {
            $validated['foto_mahasiswa'] = $mahasiswas->foto_mahasiswa;
        }

        $mahasiswas->update($validated);

        return redirect()->route('data-mahasiswa.mahasiswa', $request->prodi_id)->with('success', 'Selamat! Anda berhasil memperbaharui data');
    }

    public function destroy($id)
    {
        $users = User::where('mahasiswa_id', $id)->first();
        $users->delete();
        $mahasiswas = Mahasiswa::where('id', $id)->first();
        $mahasiswas->delete();

        return back()->with('success', 'Selamat! Anda berhasil menghapus data');
    }
}