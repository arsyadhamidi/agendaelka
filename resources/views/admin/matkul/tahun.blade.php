@extends('admin.layout.master')
@section('title', 'Mata Kuliah | Agenda Elka')
@section('menuDataMaster', 'active')
@section('menuDataMatkul', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('data-matkul.index') }}" class="btn btn-primary">
                        <i class="bx bx-left-arrow-alt"></i>
                        Kembali
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 4%; text-align:center">No.</th>
                                <th style="text-align:center">Program Studi</th>
                                <th style="text-align:center">Tahun</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tahuns as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->prodi->nama ?? '-' }}</td>
                                    <td>{{ $data->tahun ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('data-matkul.matkul', $data->id) }}"
                                            class="btn btn-sm btn-outline-info mx-2">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
