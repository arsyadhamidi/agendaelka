@extends('admin.layout.master')
@section('title', 'Data Akademik | Agenda Elka')
@section('menuKaprodiAkademik', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    Data Akademik Dosen
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center">No</th>
                                <th style="text-align:center">NIP</th>
                                <th style="text-align:center">Nama</th>
                                <th style="text-align:center">TTL</th>
                                <th style="text-align:center">JK</th>
                                <th style="text-align:center">Telp</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dosens as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nip ?? '-' }}</td>
                                    <td>{{ $data->nama ?? '-' }}</td>
                                    <td>{{ $data->tmp_lahir ?? '-' }} / {{ $data->tgl_lahir ?? '-' }}</td>
                                    <td>{{ $data->jk ?? '-' }}</td>
                                    <td>{{ $data->telp ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('kaprodi-akademik.akademik', $data->id) }}"
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
