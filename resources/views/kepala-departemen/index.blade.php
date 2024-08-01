<div class="row">
    <div class="col-lg mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat Datang {{ Auth()->user()->name ?? '-' }}! 🎉</h5>
                        <p class="mb-4">
                            Selamat datang di Dashboard Anda, di mana segala sesuatu menjadi lebih mudah dan
                            terorganisir. Dashboard Anda siap membantu! Lihatlah data terbaru dan kelola aktivitas Anda
                            dengan efisien
                        </p>

                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('admin/assets/img/illustrations/man-with-laptop-light.png') }}"
                            height="140" alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #9FA1FF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Program Studi</h4>
                        <h2>{{ $prodis ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-graduation" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #29CCEF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Data Tahun</h4>
                        <h2>{{ $tahuns ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-calendar" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #9FA1FF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Mahasiswa</h4>
                        <h2>{{ $mahasiswas ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-user" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #9FA1FF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Data Dosen</h4>
                        <h2>{{ $dosens ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-user-badge" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #29CCEF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Jadwal</h4>
                        <h2>{{ $jadwals ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-timer" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #9FA1FF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Bahan Ajar</h4>
                        <h2>{{ $bahans ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-user" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #9FA1FF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Data RPS</h4>
                        <h2>{{ $rps ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-file" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #29CCEF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Akademik</h4>
                        <h2>{{ $akademiks ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-purchase-tag" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #9FA1FF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Seminar</h4>
                        <h2>{{ $seminars ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-message-dots" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #9FA1FF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Data Rapat</h4>
                        <h2>{{ $rapats ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-folder" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #29CCEF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Users</h4>
                        <h2>{{ $users ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-user" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card" style="border-left: 4px solid #9FA1FF">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Autentiaksi</h4>
                        <h2>{{ $levels ?? '0' }}</h2>
                    </div>
                    <div class="col-lg text-end align-content-center">
                        <i class="bx bxs-log-in-circle" style="font-size: 50px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
