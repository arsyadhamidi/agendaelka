@extends('admin.layout.master')
@section('title', 'Data Akademik | Agenda Elka')
@section('menuKaprodiAkademik', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('kaprodi-akademik.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('kaprodi-akademik.akademik', $dosens->id) }}" class="btn btn-primary">
                            <i class="bx bx-left-arrow-alt"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-save"></i>
                            Simpan Data
                        </button>
                    </div>
                    <div class="card-body">
                        <input type="text" name="dosen_id" class="form-control" value="{{ $dosens->id }}" hidden>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Mahasiswa</label>
                                    <select name="mahasiswa_id"
                                        class="form-control @error('mahasiswa_id') is-invalid @enderror"
                                        id="selectedMahasiswa">
                                        <option value="" selected>Pilih Mahasiswa</option>
                                        @foreach ($mahasiswas as $data)
                                            <option value="{{ $data->id }}">
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
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <input type="text" name="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror"
                                        value="{{ old('tahun') }}" placeholder="Masukan Tahun">
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
        });
    </script>
@endpush
