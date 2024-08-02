@extends('admin.layout.master')
@section('title', 'Data Publikasi | Agenda Elka')
@section('menuMahasiswaNonAkademik', 'active')
@section('menuMahasiswaPublikasi', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('mahasiswa-publikasi.update', $publikasis->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('mahasiswa-publikasi.index') }}" class="btn btn-primary">
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
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $publikasis->nama ?? '-') }}" placeholder="Masukan nama">
                                    @error('nama')
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
                                    <label>Judul Publikasi Ilmiah</label>
                                    <input type="text" name="judul"
                                        class="form-control @error('judul') is-invalid @enderror"
                                        value="{{ old('judul', $publikasis->judul ?? '-') }}" placeholder="Masukan judul">
                                    @error('judul')
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
                                    <label>Sinta</label>
                                    <input type="text" name="sinta"
                                        class="form-control @error('sinta') is-invalid @enderror"
                                        value="{{ old('sinta', $publikasis->sinta ?? '-') }}" placeholder="Masukan sinta">
                                    @error('sinta')
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
                                    <label>File Publikasi</label>
                                    <input type="file" name="file_publikasi"
                                        class="form-control @error('file_publikasi') is-invalid @enderror">
                                    @error('file_publikasi')
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
                        url: '/mahasiswa-publikasi/tahun/' + prodiId,
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
