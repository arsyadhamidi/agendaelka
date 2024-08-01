@extends('admin.layout.master')
@section('title', 'Seminar / Ujian | Agenda Elka')
@section('menuMahasiswaSeminar', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('mahasiswa-seminar.store') }}" method="POST">
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
                                    <select name="prodi_id" class="form-control @error('prodi_id') is-invalid @enderror"
                                        id="selectedProdi">
                                        <option value="" selected>Pilih Progam Studi</option>
                                        @foreach ($prodis as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('prodi_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('prodi_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <select name="tahun_id" class="form-control @error('tahun_id') is-invalid @enderror"
                                        id="selectedTahun">
                                        <option value="" selected>Pilih Tahun</option>
                                        @foreach ($tahuns as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('tahun_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->tahun ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('tahun_id')
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
                                    <label>Mahasiswa</label>
                                    <input type="text" name="mahasiswa_id" class="form-control"
                                        value="{{ $mahasiswas->id }}" hidden>
                                    <input type="text" class="form-control" value="{{ $mahasiswas->nama ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Dosen Pembimbing</label>
                                    <select name="dosen_id" class="form-control @error('dosen_id') is-invalid @enderror"
                                        id="selectedDosen">
                                        <option value="" selected>Pilih Dosen Pembimbing</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('dosen_id')
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
                                    <label>Penelaah 1</label>
                                    <select name="penelaah1_id"
                                        class="form-control @error('penelaah1_id') is-invalid @enderror"
                                        id="selectedPenelaah1">
                                        <option value="" selected>Pilih Penelaah 1</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ old('penelaah1_id') == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('penelaah1_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Penelaah 2</label>
                                    <select name="penelaah2_id"
                                        class="form-control @error('penelaah2_id') is-invalid @enderror"
                                        id="selectedPenelaah2">
                                        <option value="" selected>Pilih Penelaah 2</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ old('penelaah2_id') == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('penelaah2_id')
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
                                    <label>Tanggal Seminar</label>
                                    <input type="date" name="tgl_seminar"
                                        class="form-control @error('tgl_seminar') is-invalid @enderror"
                                        value="{{ old('tgl_seminar', \Carbon\Carbon::now()->format('Y-m-d')) }}">
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
                                        value="{{ old('tgl_ujian', \Carbon\Carbon::now()->format('Y-m-d')) }}">
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
                                        placeholder="Masukan judul">{{ old('judul') }}</textarea>
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
                                    <label>File Seminar</label>
                                    <input name="file_seminar"
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
@push('custom-script')
    <script>
        $(document).ready(function() {
            $('#selectedMahasiswa').select2({
                theme: 'bootstrap4',
            });
            $('#selectedDosen').select2({
                theme: 'bootstrap4',
            });
            $('#selectedPenelaah1').select2({
                theme: 'bootstrap4',
            });
            $('#selectedPenelaah2').select2({
                theme: 'bootstrap4',
            });
            $('#selectedProdi').select2({
                theme: 'bootstrap4',
            });
            $('#selectedTahun').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
