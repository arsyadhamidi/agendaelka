@extends('admin.layout.master')
@section('title', 'Mata Kuliah | Agenda Elka')
@section('menuDataMaster', 'active')
@section('menuDataMatkul', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-matkul.update', $matkuls->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-matkul.matkul', $matkuls->tahun_id) }}" class="btn btn-primary">
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
                                        value="{{ $matkuls->prodi_id ?? '-' }}" hidden>
                                    <input type="text" class="form-control" value="{{ $matkuls->prodi->nama ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <input type="text" name="tahun_id" class="form-control"
                                        value="{{ $matkuls->tahun_id ?? '-' }}" hidden>
                                    <input type="text" class="form-control" value="{{ $matkuls->tahun->tahun ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Mata Kuliah</label>
                                    <input type="text" name="matkul"
                                        class="form-control @error('matkul') is-invalid @enderror"
                                        value="{{ old('matkul', $matkuls->matkul ?? '-') }}"
                                        placeholder="Masukan mata kuliah">
                                    @error('matkul')
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
