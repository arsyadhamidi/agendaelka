@extends('admin.layout.master')
@section('title', 'Data Penelitian | Agenda Elka')
@section('menuDosenNonAkademik', 'active')
@section('menuDosenPenelitian', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('dosen-penelitian.update', $penelitians->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('dosen-penelitian.index') }}" class="btn btn-primary">
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
                                                {{ old('prodi_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama ?? '' }}
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
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $penelitians->nama ?? '') }}" placeholder="Masukan nama">
                                    @error('nama')
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
                                        value="{{ old('tanggal', $penelitians->tanggal ?? '') }}">
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
                                        value="{{ old('judul', $penelitians->judul ?? '') }}" placeholder="Masukan judul">
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
                                        value="{{ old('lokasi', $penelitians->lokasi ?? '') }}"
                                        placeholder="Masukan lokasi">
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
                                    <label>File Penelitian</label>
                                    <input type="file" name="file_penelitian"
                                        class="form-control @error('file_penelitian') is-invalid @enderror">
                                    @error('file_penelitian')
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
                        url: '/get-tahun/' + prodiId,
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
