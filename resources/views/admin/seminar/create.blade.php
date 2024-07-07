@extends('admin.layout.master')
@section('title', 'Seminar / Ujian | Agenda Elka')
@section('menuDataSeminar', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-seminar.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-seminar.seminar', $tahuns->id) }}" class="btn btn-primary">
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
                                    <label>Mahasiswa</label>
                                    <select name="mahasiswa_id"
                                        class="form-control @error('mahasiswa_id') is-invalid @enderror"
                                        id="selectedMahasiswa">
                                        <option value="" selected>Pilih Mahasiswa</option>
                                        @foreach ($mahasiswas as $mahasiswa)
                                            <option value="{{ $mahasiswa->id }}"
                                                {{ old('mahasiswa_id') == $mahasiswa->id ? 'selected' : '' }}>
                                                {{ $mahasiswa->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('mahasiswa_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
                                    <label>Tahun Lulus</label>
                                    <input type="number" name="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror"
                                        value="{{ old('tahun') }}" placeholder="Masukan tahun">
                                    @error('tahun')
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
        });
    </script>
@endpush
