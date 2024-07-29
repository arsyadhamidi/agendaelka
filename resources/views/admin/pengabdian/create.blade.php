@extends('admin.layout.master')
@section('title', 'Data Pengabdian | Agenda Elka')
@section('menuDataNonAkademik', 'active')
@section('menuDataPengabdian', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-pengabdian.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-pengabdian.pengabdian', $tahuns->id) }}" class="btn btn-primary">
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
                                    <label>Pilih Dosen</label>
                                    <select name="dosen_id" class="form-control @error('dosen_id') is-invalid @enderror"
                                        id="selectedDosen">
                                        <option value="" selected>Pilih Dosen</option>
                                        @foreach ($dosens as $data)
                                            <option value="{{ $data->id }}" {{ old('dosen_id') == $data->id }}>
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
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal"
                                        class="form-control @error('tanggal') is-invalid @enderror"
                                        value="{{ old('tanggal', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                    @error('tanggal')
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
                                    <input type="text" name="judul"
                                        class="form-control @error('judul') is-invalid @enderror"
                                        value="{{ old('judul') }}" placeholder="Masukan judul">
                                    @error('judul')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Lokasi</label>
                                    <input type="text" name="lokasi"
                                        class="form-control @error('lokasi') is-invalid @enderror"
                                        value="{{ old('lokasi') }}" placeholder="Masukan lokasi">
                                    @error('lokasi')
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
                                    <label>File Pegabdian</label>
                                    <input type="file" name="file_pengabdian"
                                        class="form-control @error('file_pengabdian') is-invalid @enderror">
                                    @error('file_pengabdian')
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
            $('#selectedDosen').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
