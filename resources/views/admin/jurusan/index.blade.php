@extends('admin.layout.master')
@section('title', 'Data Jurusan | Agenda Elka')
@section('menuDataMaster', 'active')
@section('menuDataJurusan', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('data-jurusan.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i>
                        Tambahkan Data Jurusan
                    </a>
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
                                        <form action="{{ route('data-jurusan.destroy', $data->id) }}" method="POST"
                                            class="d-flex flex-wrap">
                                            @csrf
                                            <a href="{{ route('data-jurusan.edit', $data->id) }}"
                                                class="btn btn-sm btn-outline-info mx-2">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" id="hapusData">
                                                <i class="bx bx-trash-alt"></i>
                                            </button>
                                        </form>
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
    <script>
        // Mendengarkan acara klik tombol hapus
        $(document).on('click', '#hapusData', function(event) {
            event.preventDefault(); // Mencegah perilaku default tombol

            // Ambil URL aksi penghapusan dari atribut 'action' formulir
            var deleteUrl = $(this).closest('form').attr('action');

            // Tampilkan SweetAlert saat tombol di klik
            Swal.fire({
                icon: 'question',
                title: 'Hapus Data Jurusan?',
                text: 'Apakah anda yakin untuk menghapus data ini?',
                showCancelButton: true, // Tampilkan tombol batal
                confirmButtonText: 'Ya',
                confirmButtonColor: '#28a745', // Warna hijau untuk tombol konfirmasi
                cancelButtonText: 'Tidak',
                cancelButtonColor: '#dc3545' // Warna merah untuk tombol pembatalan
            }).then((result) => {
                // Lanjutkan jika pengguna mengkonfirmasi penghapusan
                if (result.isConfirmed) {
                    // Kirim permintaan AJAX DELETE ke URL penghapusan
                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}" // Kirim token CSRF untuk keamanan
                        },
                        success: function(response) {
                            // Tampilkan pesan sukses jika penghapusan berhasil
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data successfully deleted.',
                                showConfirmButton: false,
                                timer: 1500 // Durasi pesan success (dalam milidetik)
                            });

                            // Refresh halaman setelah pesan sukses ditampilkan
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        },
                        error: function(xhr, status, error) {
                            // Tampilkan pesan error jika penghapusan gagal
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                showConfirmButton: false,
                                timer: 1500 // Durasi pesan error (dalam milidetik)
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
