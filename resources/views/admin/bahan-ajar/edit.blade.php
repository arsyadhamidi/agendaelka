@extends('admin.layout.master')
@section('title', 'Bahan Ajar | Agenda Elka')
@section('menuDataPengajaran', 'active')
@section('menuDataBahanAjar', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-bahanajar.update', $bahans->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-bahanajar.bahanajar', $bahans->tahun_id) }}" class="btn btn-primary">
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
                                        value="{{ $bahans->prodi_id }}" hidden>
                                    <input type="text" class="form-control" value="{{ $bahans->prodi->nama ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <input type="text" name="tahun_id" class="form-control"
                                        value="{{ $bahans->tahun_id }}" hidden>
                                    <input type="text" class="form-control" value="{{ $bahans->tahun->tahun ?? '-' }}"
                                        readonly>
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
                                                value="{{ $data->id }}"{{ $bahans->dosen_id == $data->id ? 'selected' : '' }}>
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
                                <div class="mb-3">
                                    <label>Semester</label>
                                    <select name="semester" class="form-control @error('semester') is-invalid @enderror"
                                        id="selectedSemester">
                                        <option value="" selected>Pilih Semester</option>
                                        <option value="Ganjil" {{ $bahans->semester == 'Ganjil' ? 'selected' : '' }}>
                                            Ganjil
                                        </option>
                                        <option value="Genap" {{ $bahans->semester == 'Genap' ? 'selected' : '' }}>Genap
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
                                                value="{{ $data->id }}"{{ $bahans->matkul_id == $data->id ? 'selected' : '' }}>
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
                                    <label>Upload Bahan Ajar</label>
                                    <input type="file" name="bahan_ajar"
                                        class="form-control @error('bahan_ajar') is-invalid @enderror">
                                    @error('bahan_ajar')
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
        });
    </script>
@endpush
