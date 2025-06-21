<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Nasabah</h1>

        <a href="{{ route('nasabah.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Tambah Data
        </a>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Data Nasabah</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Nama</td>
                                    <td>NIK</td>
                                    <td>No. Rek</td>
                                    <td>Jenis Kelamin</td>
                                    <td>Alamat</td>
                                    <td>Kecamatan</td>
                                    <td>Kabupaten</td>
                                    <td>Provinsi</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->profile->nomor_induk_kependudukan }}</td>
                                    <td>{{ $user->profile->nomor_rekening }}</td>
                                    <td>
                                        @if ($user->profile->jenis_kelamin === 'l')
                                        Laki-laki
                                        @elseif ($user->profile->jenis_kelamin === 'p')
                                        Perempuan
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>{{ $user->profile->alamat }}</td>
                                    <td>{{ $user->profile->kecamatan }}</td>
                                    <td>{{ $user->profile->kabupaten }}</td>
                                    <td>{{ $user->profile->provinsi }}</td>
                                    <td>
                                        <div class="d-flex flex-row align-items-center">
                                            <a href="{{ route('nasabah.edit', $user) }}"
                                                class="btn btn-warning btn-sm mr-2">
                                                <i class="fas fa-edit fa-sm"></i>
                                            </a>

                                            <form method="POST" action="{{ route('nasabah.destroy', $user) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash fa-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <!-- Page level plugins -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js">
        </script>

        <!-- Page level custom scripts -->
        <script src="js/datatables-demo.js"></script>
    </x-slot>

    <x-slot name="styles">
        <!-- Custom styles for this page -->
        <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    </x-slot>
</x-app-layout>