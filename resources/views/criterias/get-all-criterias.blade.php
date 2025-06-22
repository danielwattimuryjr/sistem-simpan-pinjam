<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kriteria Penilaian</h1>

        <a href="{{ route('criterias.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Tambah Faktor Penilaian
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
                        <table class="table table-bordered" id="collapsibleDataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <td>#</td>
                                    <td>Nama Kriteria</td>
                                    <td>Kategori</td>
                                    <td>Bobot</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($criterias as $index => $criteria)
                                <tr data-scores='@json($criteria->scores)' data-id="{{ $criteria->id }}">
                                    <td class="details-control"></td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $criteria->name }}</td>
                                    <td>
                                        @if ($criteria->category === 'benefit')
                                        Benefit
                                        @elseif ($criteria->category === 'cost')
                                        Cost
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>{{ $criteria->weight }}</td>
                                    <td>
                                        <div class="d-flex flex-row align-items-center">
                                            <a href="{{ route('criterias.edit', $criteria) }}"
                                                class="btn btn-warning btn-sm mr-2">
                                                <i class="fas fa-edit fa-sm"></i>
                                            </a>

                                            <form method="POST" action="{{ route('criterias.destroy', $criteria) }}">
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
        <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="/vendor/datatables/dataTables.bootstrap4.min.js">
        </script>

        <!-- Page level custom scripts -->
        <script src="/js/datatables-demo.js"></script>
    </x-slot>

    <x-slot name="styles">
        <!-- Custom styles for this page -->
        <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <style>
            td.details-control {
                cursor: pointer;
                background: url('https://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            }
            tr.shown td.details-control {
                background: url('https://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
            }
        </style>
    </x-slot>
</x-app-layout>