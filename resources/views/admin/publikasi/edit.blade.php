@extends('admin.layout.master')
@section('title', 'Data Publikasi | Agenda Elka')
@section('menuDataNonAkademik', 'active')
@section('menuDataPublikasi', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-publikasi.update', $publikasis->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-publikasi.publikasi', $publikasis->tahun_id) }}" class="btn btn-primary">
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
                                        value="{{ $publikasis->prodi_id }}" hidden>
                                    <input type="text" class="form-control" value="{{ $publikasis->prodi->nama ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <input type="text" name="tahun_id" class="form-control"
                                        value="{{ $publikasis->tahun_id }}" hidden>
                                    <input type="text" class="form-control"
                                        value="{{ $publikasis->tahun->tahun ?? '-' }}" readonly>
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
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror"
                                id="selectedStatus">
                                <option value="" selected>Pilih Status</option>
                                <option value="Dosen" {{ $publikasis->status == 'Dosen' ? 'selected' : '' }}>
                                    Dosen
                                </option>
                                <option value="Mahasiswa" {{ $publikasis->status == 'Mahasiswa' ? 'selected' : '' }}>
                                    Mahasiswa</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
            $('#selectedDosen').select2({
                theme: 'bootstrap4',
            });
            $('#selectedStatus').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
