@extends('admin.layout.master')
@section('title', 'Jadwal Pengajaran | Agenda Elka')
@section('menuJadwalPengajaran', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('kepala-jadwalpengajaran.update', $jadwals->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('kepala-jadwalpengajaran.index') }}" class="btn btn-primary">
                            <i class="bx bx-left-arrow-alt"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-save"></i>
                            Simpan Data
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <input type="number" name="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror"
                                        value="{{ old('tahun', $jadwals->tahun) }}" placeholder="Masukan tahun">
                                    @error('tahun')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Semester</label>
                                    <input type="number" name="semester"
                                        class="form-control @error('semester') is-invalid @enderror"
                                        value="{{ old('semester', $jadwals->semester) }}" placeholder="Masukan semester">
                                    @error('semester')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Berkas Jadwal Pengajaran</label>
                                    <input type="file" name="jadwal_pengajaran"
                                        class="form-control @error('jadwal_pengajaran') is-invalid @enderror">
                                    @error('jadwal_pengajaran')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
