@extends('admin.layout.master')
@section('title', 'Seminar / Ujian | Agenda Elka')
@section('menuMahasiswaSeminar', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('mahasiswa-seminar.update', $seminars->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('mahasiswa-seminar.index') }}" class="btn btn-primary">
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
                                    <label>Program Studi</label>
                                    <input type="text" class="form-control" value="{{ $seminars->prodi->nama ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <input type="text" class="form-control" value="{{ $seminars->tahun->tahun ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Mahasiswa</label>
                                    <input type="text" class="form-control"
                                        value="{{ $seminars->mahasiswa->nama ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Dosen Pembimbing</label>
                                    <input type="text" class="form-control" value="{{ $seminars->dosen->nama ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Penelaah 1</label>
                                    <input type="text" class="form-control"
                                        value="{{ $seminars->penelaah1->nama ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Penelaah 2</label>
                                    <input type="text" class="form-control"
                                        value="{{ $seminars->penelaah2->nama ?? '-' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tanggal Seminar</label>
                                    <input type="date" name="tgl_seminar"
                                        class="form-control @error('tgl_seminar') is-invalid @enderror"
                                        value="{{ old('tgl_seminar', $seminars->tgl_seminar) }}" readonly>
                                    @error('tgl_seminar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tanggal Ujian</label>
                                    <input type="date" name="tgl_ujian"
                                        class="form-control @error('tgl_ujian') is-invalid @enderror"
                                        value="{{ old('tgl_ujian', $seminars->tgl_ujian) }}" readonly>
                                    @error('tgl_ujian')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Judul</label>
                                    <textarea name="judul" class="form-control @error('judul') is-invalid @enderror" rows="5"
                                        placeholder="Masukan judul" readonly>{{ old('judul', $seminars->judul) }}</textarea>
                                    @error('judul')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Upload File Seminar</label>
                                    <input type="file" name="file_seminar"
                                        class="form-control @error('file_seminar') is-invalid @enderror">
                                    @error('file_seminar')
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
