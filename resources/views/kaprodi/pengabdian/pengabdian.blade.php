@extends('admin.layout.master')
@section('title', 'Data Pengabdian | Agenda Elka')
@section('menuKaprodiNonAkademik', 'active')
@section('menuKaprodiPengabdian', 'active')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header d-flex align-content-center justify-content-between">
                    <div class="form-group">
                        <a href="{{ route('kaprodi-pengabdian.tahun', $tahuns->prodi_id) }}" class="btn btn-primary">
                            <i class="bx bx-left-arrow-alt"></i>
                            Kembali
                        </a>
                    </div>
                    <a href="{{ route('kaprodi-pengabdian.generateexcel', $tahuns->id) }}" class="btn btn-success"
                        target="_blank">
                        <i class="bx bx-download"></i>
                        Download Excel
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center">No.</th>
                                <th style="text-align:center">Nama</th>
                                <th style="text-align:center">Prodi</th>
                                <th style="text-align:center">Judul</th>
                                <th style="text-align:center">Tanggal</th>
                                <th style="text-align:center">Lokasi</th>
                                <th style="text-align:center">Tahun</th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Berkas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengabdians as $data)
                                <tr>
                                    <td>{{ $loop->iteration ?? '-' }}</td>
                                    <td>{{ $data->nama ?? '-' }}</td>
                                    <td>{{ $data->prodi->nama ?? '-' }}</td>
                                    <td>{{ $data->judul ?? '-' }}</td>
                                    <td>{{ $data->tanggal ?? '-' }}</td>
                                    <td>{{ $data->lokasi ?? '-' }}</td>
                                    <td>{{ $data->tahun->tahun ?? '-' }}</td>
                                    <td>{{ $data->status ?? '-' }}</td>
                                    <td>
                                        @if (!empty($data->file_pengabdian))
                                            <a href="{{ asset('storage/' . $data->file_pengabdian) }}"
                                                class="btn btn-primary">
                                                <i class="bx bx-download"></i>
                                                Download
                                            </a>
                                        @else
                                            -
                                        @endif
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
                title: 'Hapus Data Pengabdian ?',
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
