@extends('admin.layout.master')
@section('title', 'Data Publikasi | Agenda Elka')
@section('menuMahasiswaNonAkademik', 'active')
@section('menuMahasiswaStudiLanjut', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('mahasiswa-studilanjut.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('mahasiswa-studilanjut.index') }}" class="btn btn-primary">
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
                                    <select name="prodi_id" class="form-control @error('prodi_id') is-invalid @enderror"
                                        id="selectedProdi">
                                        <option value="" selected>Pilih Program Studi</option>
                                        @foreach ($prodis as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('prodi_id') == $data->id ? 'selected' : '' }}>{{ $data->nama ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('prodi_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <select name="tahun_id" class="form-control @error('tahun_id') is-invalid @enderror"
                                        id="selectedTahun">
                                        <option value="" selected>Pilih Tahun</option>
                                    </select>
                                    @error('tahun_id')
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
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                        placeholder="Masukan nama">
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
                                        <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1
                                        </option>
                                        <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>
                                            S2</option>
                                        <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>
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
                                        value="{{ old('universitas') }}" placeholder="Masukan universitas">
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
            $('#selectedProdi').select2({
                theme: 'bootstrap4',
            });
            $('#selectedTahun').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#selectedProdi').on('change', function() {
                var prodiId = $(this).val();

                // Clear the Tahun dropdown
                $('#selectedTahun').empty().append('<option value="" selected>Pilih Tahun</option>');

                if (prodiId) {
                    // Fetch Tahun options from the server
                    $.ajax({
                        url: '/mahasiswa-studilanjut/tahun/' + prodiId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.tahuns) {
                                response.tahuns.forEach(function(tahun) {
                                    $('#selectedTahun').append('<option value="' + tahun
                                        .id + '">' + tahun.tahun + '</option>');
                                });
                            }
                        },
                        error: function() {
                            alert('Error fetching Tahun data.');
                        }
                    });
                }
            });
        });
    </script>
@endpush
