@extends('admin.layout.master')
@section('title', 'Data Publikasi | Agenda Elka')
@section('menuDataNonAkademik', 'active')
@section('menuDataStudiLanjut', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-studilanjut.update', $studis->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-studilanjut.studilanjut', $studis->tahun_id) }}" class="btn btn-primary">
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
                                        value="{{ $studis->prodi_id }}" hidden>
                                    <input type="text" class="form-control" value="{{ $studis->prodi->nama ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <input type="text" name="tahun_id" class="form-control"
                                        value="{{ $studis->tahun_id }}" hidden>
                                    <input type="text" class="form-control" value="{{ $studis->tahun->tahun ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $studis->nama ?? '') }}" placeholder="Masukan nama">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Pendidikan</label>
                                    <select name="pendidikan" class="form-control @error('pendidikan') is-invalid @enderror"
                                        id="selectedPendidikan">
                                        <option value="" selected>Pilih Pendidikan</option>
                                        <option value="S1" {{ $studis->pendidikan == 'S1' ? 'selected' : '' }}>S1
                                        </option>
                                        <option value="S2" {{ $studis->pendidikan == 'S2' ? 'selected' : '' }}>
                                            S2</option>
                                        <option value="S3" {{ $studis->pendidikan == 'S3' ? 'selected' : '' }}>
                                            S3</option>
                                    </select>
                                    @error('pendidikan')
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
                                    <label>Universitas</label>
                                    <input type="text" name="universitas"
                                        class="form-control @error('universitas') is-invalid @enderror"
                                        value="{{ old('universitas', $studis->universitas ?? '') }}"
                                        placeholder="Masukan universitas">
                                    @error('universitas')
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
                                    <label>Berkas</label>
                                    <input type="file" name="berkas"
                                        class="form-control @error('berkas') is-invalid @enderror">
                                    @error('berkas')
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
            $('#selectedPendidikan').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
