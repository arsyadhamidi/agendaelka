@extends('admin.layout.master')
@section('title', 'Data Akademik | Agenda Elka')
@section('menuDataAkademik', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-akademik.update', $akademiks->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-akademik.akademik', $akademiks->tahun_id) }}" class="btn btn-primary">
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
                                        value="{{ $akademiks->prodi_id }}" hidden>
                                    <input type="text" class="form-control" value="{{ $akademiks->prodi->nama ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <input type="text" name="tahun_id" class="form-control" value="{{ $akademiks->id }}"
                                        hidden>
                                    <input type="text" class="form-control" value="{{ $akademiks->tahun->tahun ?? '-' }}"
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
                                            <option value="{{ $data->id }}"
                                                {{ $akademiks->dosen_id == $data->id ? 'selected' : '' }}>
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
                                    <label>Mahasiswa</label>
                                    <select name="mahasiswa_id"
                                        class="form-control @error('mahasiswa_id') is-invalid @enderror"
                                        id="selectedMahasiswa">
                                        <option value="" selected>Pilih Mahasiswa</option>
                                        @foreach ($mahasiswas as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $akademiks->mahasiswa_id == $data->id ? 'selected' : '' }}>
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
            $('#selectedMahasiswa').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
