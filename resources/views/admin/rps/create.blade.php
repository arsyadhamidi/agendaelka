@extends('admin.layout.master')
@section('title', 'Rps | Agenda Elka')
@section('menuDataPengajaran', 'active')
@section('menuDataRps', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-rps.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="text" name="prodi_id" class="form-control"
                                        value="{{ $tahuns->prodi_id }}" hidden>
                                    <input type="text" class="form-control" value="{{ $tahuns->prodi->nama ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <input type="text" name="tahun_id" class="form-control" value="{{ $tahuns->id }}"
                                        hidden>
                                    <input type="text" class="form-control" value="{{ $tahuns->tahun ?? '-' }}" readonly>
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
                                                value="{{ $data->id }}"{{ old('dosen_id') == $data->id ? 'selected' : '' }}>
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
                                    <input type="number" name="semester"
                                        class="form-control @error('semester') is-invalid @enderror"
                                        value="{{ old('semester') }}" placeholder="Masukan semester">
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
            $('#selectedDosen').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
