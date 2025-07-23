<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            History Peminjaman
        </h1>

        <div>
            <div class="btn-group">
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-file-csv"></i> CSV
                </a>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">History Data Pinjaman</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                  <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Batch</th>
                        <th>Nama</th>
                        <th>Rekening</th>
                        <th>Pendapatan</th>
                        <th>Jaminan</th>
                        <th>Jumlah Pinjaman</th>
                        <th>Nilai WP</th>
                        <th>Normalized</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $rank => $eval)
                        @php
                            $loan = $eval->loan;
                            $user = $loan->user;
                            $profile = $user->profile;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $eval->batch_number }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $profile?->nomor_rekening ?? '-' }}</td>
                            <td>{{ number_format($loan->pendapatan) }}</td>
                            <td>{{ number_format($loan->jaminan) }}</td>
                            <td>{{ number_format($loan->jumlah_pinjaman) }}</td>
                            <td>{{ number_format($eval->nilai_wp, 6) }}</td>
                            <td>{{ $eval->normalized_wp ? number_format($eval->normalized_wp, 6) : '-' }}</td>
                            <td>
                                @switch($loan->status)
                                    @case('approved')
                                        <span class="badge badge-success">Disetujui</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge badge-danger">Ditolak</span>
                                        @break
                                    @case('canceled')
                                        <span class="badge badge-warning">Dibatalkan</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">Menunggu</span>
                                @endswitch
                            </td>
                            <td>
                              <div class="btn-group">
                                <a href="{{ route('pinjaman.export.one', ['evaluationId' => $eval->id, 'type' => 'xlsx']) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-file-excel"></i> Excel
                                </a>
                                <a href="{{ route('pinjaman.export.one', ['evaluationId' => $eval->id, 'type' => 'csv']) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-csv"></i> CSV
                                </a>
                                <a href="{{ route('pinjaman.export.one', ['evaluationId' => $eval->id, 'type' => 'pdf']) }}" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
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