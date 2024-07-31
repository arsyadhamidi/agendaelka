@extends('admin.layout.master')
@section('title', 'Rps | Agenda Elka')
@section('menuDosenPengajaran', 'active')
@section('menuDosenRps', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('dosen-rps.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('dosen-rps.index') }}" class="btn btn-primary">
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
                                    <input type="text" name="prodi_id" class="form-control"
                                        value="{{ $dosens->prodi_id }}" hidden>
                                    <input type="text" class="form-control" value="{{ $dosens->prodi->nama ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <select name="tahun_id" class="form-control @error('tahun_id') is-invalid @enderror"
                                        id="selectedTahun">
                                        <option value="" selected>Pilih Tahun</option>
                                        @foreach ($tahuns as $tahun)
                                            <option value="{{ $tahun->id }}"
                                                {{ old('tahun_id') == $tahun->id ? 'selected' : '' }}>
                                                {{ $tahun->tahun ?? '-' }}</option>
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
                                    <label>Semester</label>
                                    <select name="semester" class="form-control @error('semester') is-invalid @enderror"
                                        id="selectedSemester">
                                        <option value="" selected>Pilih Semester</option>
                                        <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil
                                        </option>
                                        <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap
                                        </option>
                                    </select>
                                    @error('semester')
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
                                    <label>Mata Kuliah</label>
                                    <select name="matkul_id" class="form-control @error('matkul_id') is-invalid @enderror"
                                        id="selectedMatkul">
                                        <option value="" selected>Pilih Mata Kuliah</option>
                                        @foreach ($matkuls as $data)
                                            <option
                                                value="{{ $data->id }}"{{ old('matkul_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->matkul ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('matkul_id')
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
            $('#selectedSemester').select2({
                theme: 'bootstrap4',
            });
            $('#selectedMatkul').select2({
                theme: 'bootstrap4',
            });
            $('#selectedTahun').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
