@extends('admin.layout.master')
@section('title', 'Data Publikasi | Agenda Elka')
@section('menuKaprodiNonAkademik', 'active')
@section('menuKaprodiStudiLanjut', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    Data Program Studi
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center">No</th>
                                <th style="text-align:center">Prodi</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prodis as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('kaprodi-studilanjut.tahun', $data->id) }}"
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
