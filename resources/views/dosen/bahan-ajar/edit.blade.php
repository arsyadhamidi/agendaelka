@extends('admin.layout.master')
@section('title', 'Bahan Ajar | Agenda Elka')
@section('menuDataBahanAjar', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('dosen-bahanajar.update', $bahans->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('dosen-bahanajar.bahanajar', $bahans->tahun_id) }}" class="btn btn-primary">
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
                                    <label>Semester</label>
                                    <input type="number" name="semester"
                                        class="form-control @error('semester') is-invalid @enderror"
                                        value="{{ old('semester', $bahans->semester) }}" placeholder="Masukan semester">
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
            $('#selectedDosen').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
