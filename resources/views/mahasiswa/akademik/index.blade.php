@extends('admin.layout.master')
@section('title', 'Akademik | Agenda Elka')
@section('menuMahasiswaAkademik', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    List Data Akademik
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align:center">No.</th>
                                    <th style="text-align:center">Dosen</th>
                                    <th style="text-align:center">Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($akademiks as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->dosen->nama ?? '-' }}</td>
                                        <td>{{ $data->mahasiswa->nama ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('custom-script')
        <script>
            $(document).ready(function() {
                @if (Session::has('success'))
                    toastr.success("{{ Session::get('success') }}");
                @endif

                @if (Session::has('error'))
                    toastr.error("{{ Session::get('error') }}");
                @endif
            });
        </script>
    @endpush
