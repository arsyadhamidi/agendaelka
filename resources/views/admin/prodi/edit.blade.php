@extends('admin.layout.master')
@section('title', 'Data Program Studi | Agenda Elka')
@section('menuDataMaster', 'active')
@section('menuDataProdi', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-prodi.update', $prodis->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-prodi.index') }}" class="btn btn-primary">
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
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Masukan program studi" value="{{ old('nama', $prodis->nama ?? '-') }}">
                                    @error('nama')
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
