@extends('admin.layout.master')
@section('title', 'Data Tahun | Agenda Elka')
@section('menuDataMaster', 'active')
@section('menuDataTahun', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-tahun.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-tahun.tahun', $prodis->id) }}" class="btn btn-primary">
                            <i class="bx bx-left-arrow-alt"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-save"></i>
                            Simpan Data
                        </button>
                    </div>
                    <div class="card-body">
                        {{-- Prodi ID --}}
                        <input type="text" name="prodi_id" class="form-control" value="{{ $prodis->id }}" hidden>
                        {{-- Prodi ID --}}
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
