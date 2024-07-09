@extends('admin.layout.master')
@section('title', 'Seminar / Ujian | Agenda Elka')
@section('menuDataSeminar', 'active')
@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('data-seminar.tahun', $tahuns->prodi_id) }}" class="btn btn-primary">
                        <i class="bx bx-left-arrow-alt"></i>
                        Kembali
                    </a>
                    <a href="{{ route('data-seminar.create', $tahuns->id) }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i>
                        Tambahkan Data Seminar
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 4%; text-align:center">No.</th>
                                <th style="text-align:center">Mahasiswa</th>
                                <th style="text-align:center">Judul</th>
                                <th style="text-align:center">Pembimbing</th>
                                <th style="text-align:center">Penelaah 1</th>
                                <th style="text-align:center">Penelaah 2</th>
                                <th style="text-align:center">Seminar</th>
                                <th style="text-align:center">Ujian</th>
                                <th style="text-align:center">Berkas</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($seminars as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->mahasiswa->nama ?? '-' }}</td>
                                    <td>{{ $data->judul ?? '-' }}</td>
                                    <td>{{ $data->dosen->nama ?? '-' }}</td>
                                    <td>{{ $data->penelaah1->nama ?? '-' }}</td>
                                    <td>{{ $data->penelaah2->nama ?? '-' }}</td>
                                    <td>{{ $data->tgl_seminar ?? '-' }}</td>
                                    <td>{{ $data->tgl_ujian ?? '-' }}</td>
                                    <td>
                                        @if (!empty($data->file_seminar))
                                            <a href="{{ asset('storage/' . $data->file_seminar) }}"
                                                class="btn btn-primary">
                                                <i class="bx bx-download"></i>
                                                Download
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('data-seminar.destroy', $data->id) }}" method="POST"
                                            class="d-flex flex-wrap">
                                            @csrf
                                            <a href="{{ route('data-seminar.edit', $data->id) }}"
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
                title: 'Hapus Data Seminar?',
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
