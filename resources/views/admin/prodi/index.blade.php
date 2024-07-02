@extends('admin.layout.master')
@section('title', 'Data Program Studi | Agenda Elka')
@section('menuDataMaster', 'active')
@section('menuDataProdi', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    Data Jurusan
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center">No.</th>
                                <th style="text-align:center">Kode Jurusan</th>
                                <th style="text-align:center">Nama Jurusan</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jurusans as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->kode ?? '-' }}</td>
                                    <td>{{ $data->nama ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('data-prodi.indexprodi', $data->id) }}"
                                            class="btn btn-sm btn-primary">
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
