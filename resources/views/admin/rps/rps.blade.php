@extends('admin.layout.master')
@section('title', 'Rps | Agenda Elka')
@section('menuDataPengajaran', 'active')
@section('menuDataRps', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('data-rps.tahun', $tahuns->prodi_id) }}" class="btn btn-primary">
                        <i class="bx bx-left-arrow-alt"></i>
                        Kembali
                    </a>
                    <a href="{{ route('data-rps.create', $tahuns->id) }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i>
                        Tambahkan Data Rps
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center">No.</th>
                                <th style="text-align:center">Bahan</th>
                                <th style="text-align:center">Dosen</th>
                                <th style="text-align:center">Semester</th>
                                <th style="text-align:center">Tahun</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rps as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $data->file_rps) }}" class="btn btn-info"
                                            target="_blank">
                                            <i class="bx bx-download"></i>
                                            Download
                                        </a>
                                    </td>
                                    <td>{{ $data->dosen->nama ?? '-' }}</td>
                                    <td>{{ $data->semester ?? '-' }}</td>
                                    <td>{{ $data->tahun->tahun ?? '-' }}</td>
                                    <td>
                                        <form action="{{ route('data-rps.destroy', $data->id) }}" method="POST"
                                            class="d-flex flex-wrap">
                                            @csrf
                                            <a href="{{ route('data-rps.edit', $data->id) }}"
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
                title: 'Hapus Data Rps?',
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
