<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            @if (Auth::user()->hasRole('admin'))
            Data Pengajuan Pinjaman
            @else
            Data Peminjaman Pengguna
            @endif
        </h1>

        @if (Auth::user()->hasRole('nasabah'))
        <a href="{{ route('pinjaman.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Ajukan Pinjaman
        </a>
        @endif
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Data Pinjaman</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Nama Nasabah</td>
                                    <td>Nomor Rekening</td>
                                    <td>Pendapatan</td>
                                    <td>Jumlah Tanggungan</td>
                                    <td>Jaminan</td>
                                    <td>Jumlah Pinjaman</td>
                                    <td>Status</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loans as $index => $loan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $loan->user->name }}</td>
                                    <td>{{ $loan->user->profile->nomor_rekening}}</td>
                                    <td>{{ $loan->pendapatan }}</td>
                                    <td>{{ $loan->jumlah_tanggungan }}</td>
                                    <td>{{ $loan->jaminan }}</td>
                                    <td>{{ $loan->jumlah_pinjaman }}</td>
                                    <td>
                                        @if($loan->status === 'approved')
                                        <span class="text-success font-italic">Disetujui</span>
                                        @elseif($loan->status === 'rejected')
                                        <span class="text-danger font-italic">Ditolak</span>
                                        @elseif($loan->status === 'canceled')
                                        <span class="text-danger font-italic">Dibatalkan</span>
                                        @else
                                        <span class="text-secondary font-italic">Menunggu Persetujuan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (Auth::user()->hasRole('admin'))
                                        <div class="d-flex flex-row align-items-center">
                                            <a href="{{ route('pinjaman.edit', $loan) }}"
                                                class="btn btn-warning btn-sm mr-2">
                                                <i class="fas fa-edit fa-sm"></i>
                                            </a>

                                            <form method="POST" action="{{ route('pinjaman.destroy', $loan) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash fa-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @else
                                        @if($loan->status === 'pending')
                                        <form method="POST" action="{{ route('pinjaman.cancel', $loan) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-ban fa-sm"></i>
                                            </button>
                                        </form>
                                        @endif
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
    </div>

    <x-slot name="scripts">
        <!-- Page level plugins -->
        <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="/vendor/datatables/dataTables.bootstrap4.min.js">
        </script>

        <!-- Page level custom scripts -->
        <script src="/js/datatables-demo.js"></script>
    </x-slot>

    <x-slot name="styles">
        <!-- Custom styles for this page -->
        <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    </x-slot>
</x-app-layout>