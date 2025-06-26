<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            @if (Auth::user()->hasRole('admin'))
                Data Ranking Pinjaman Berdasarkan WP
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
            @if(Auth::user()->hasRole('admin'))
                {{-- BATCH AKTIF --}}
                @if($activeBatches->isNotEmpty())
                    <h5 class="mb-3 font-weight-bold text-primary">Batch Aktif</h5>
                    @include('pinjaman.partials.evaluation-accordion', [
                        'groupedEvaluations' => $activeBatches,
                        'accordionIdPrefix' => 'aktif',
                    ])
                @endif

                {{-- RIWAYAT --}}
                @if($archivedBatches->isNotEmpty())
                    <h5 class="mt-5 mb-3 font-weight-bold text-secondary">Riwayat Evaluasi</h5>
                    @include('pinjaman.partials.evaluation-accordion', [
                        'groupedEvaluations' => $archivedBatches,
                        'accordionIdPrefix' => 'arsip',
                    ])
                @endif
            @else
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Tabel Data Pinjaman Anda</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pendapatan</th>
                                        <th>Tanggungan</th>
                                        <th>Jaminan</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loans as $loan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ number_format($loan->pendapatan) }}</td>
                                        <td>{{ $loan->jumlah_tanggungan }}</td>
                                        <td>{{ number_format($loan->jaminan) }}</td>
                                        <td>{{ number_format($loan->jumlah_pinjaman) }}</td>
                                        <td>
                                            @switch($loan->status)
                                                @case('approved') <span class="text-success font-italic">Disetujui</span> @break
                                                @case('rejected') <span class="text-danger font-italic">Ditolak</span> @break
                                                @case('canceled') <span class="text-danger font-italic">Dibatalkan</span> @break
                                                @default <span class="text-secondary font-italic">Menunggu</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
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