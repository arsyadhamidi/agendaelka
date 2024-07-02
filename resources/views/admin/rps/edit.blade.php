@extends('admin.layout.master')
@section('title', 'Rps | Agenda Elka')
@section('menuDataRps', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-rps.update', $rps->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-rps.index') }}" class="btn btn-primary">
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
                                        <option value="" selected>Pilih Program Studi</option>
                                        @foreach ($prodis as $data)
                                            <option
                                                value="{{ $data->id }}"{{ $rps->prodi_id == $data->id ? 'selected' : '' }}>
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
                                    <label>Mahasiswa</label>
                                    <select name="mahasiswa_id"
                                        class="form-control @error('mahasiswa_id') is-invalid @enderror"
                                        id="selectedMahasiswa">
                                        <option value="" selected>Pilih Mahasiswa</option>
                                        @foreach ($mahasiswas as $data)
                                            <option
                                                value="{{ $data->id }}"{{ $rps->mahasiswa_id == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('mahasiswa_id')
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
                                    <label>Dosen</label>
                                    <select name="dosen_id" class="form-control @error('dosen_id') is-invalid @enderror"
                                        id="selectedDosen">
                                        <option value="" selected>Pilih Dosen</option>
                                        @foreach ($dosens as $data)
                                            <option
                                                value="{{ $data->id }}"{{ $rps->dosen_id == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('dosen_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="mb-3">
                                            <label>Semester</label>
                                            <input type="number" name="semester"
                                                class="form-control @error('semester') is-invalid @enderror"
                                                value="{{ old('semester', $rps->semester) }}"
                                                placeholder="Masukan semester">
                                            @error('semester')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="mb-3">
                                            <label>Tahun</label>
                                            <input type="number" name="tahun"
                                                class="form-control @error('tahun') is-invalid @enderror"
                                                value="{{ old('tahun', $rps->tahun) }}" placeholder="Masukan tahun">
                                            @error('tahun')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Upload File Rps</label>
                                    <input type="file" name="file_rps"
                                        class="form-control @error('file_rps') is-invalid @enderror">
                                    @error('file_rps')
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
            $('#selectedProdi').select2({
                theme: 'bootstrap4',
            });
            $('#selectedMahasiswa').select2({
                theme: 'bootstrap4',
            });
            $('#selectedDosen').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
