@extends('admin.layout.master')
@section('title', 'Data Tahun | Agenda Elka')
@section('menuDataMaster', 'active')
@section('menuDataTahun', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    Data Prodi
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 4%; text-align:center">No.</th>
                                <th style="text-align:center">Program Studi</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prodis as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('data-tahun.tahun', $data->id) }}"
                                            class="btn btn-sm btn-outline-info">
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
