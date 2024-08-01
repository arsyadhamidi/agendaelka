<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Akademik;
use App\Models\BahanAjar;
use App\Models\Dosen;
use App\Models\JadwalPengajaran;
use App\Models\Level;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Rps;
use App\Models\Seminar;
use App\Models\Tahun;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $prodis = Prodi::count();
        $tahuns = Tahun::count();
        $mahasiswas = Mahasiswa::count();
        $dosens = Dosen::count();
        $jadwals = JadwalPengajaran::count();
        $bahans = BahanAjar::count();
        $rps = Rps::count();
        $akademiks = Akademik::count();
        $seminars = Seminar::count();
        $rapats = Seminar::count();
        $users = User::count();
        $levels = Level::count();
        return view('admin.dashboard.index', [
            'prodis' => $prodis,
            'tahuns' => $tahuns,
            'mahasiswas' => $mahasiswas,
            'dosens' => $dosens,
            'jadwals' => $jadwals,
            'bahans' => $bahans,
            'rps' => $rps,
            'akademiks' => $akademiks,
            'seminars' => $seminars,
            'rapats' => $rapats,
            'users' => $users,
            'levels' => $levels,
        ]);
    }
}
