<x-app-layout>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kriteria</h1>
    </div>

    <div class="row">
        <div class="col">
            <form action="{{ route ('criterias.store') }}" method="POST">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Form Kriteria</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Kriteria</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" />
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category" class="form-control @error('category') is-invalid @enderror">
                                <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- PILIH KATEGORI --
                                </option>
                                <option value="benefit" {{ old('category')=='benefit' ? 'selected' : '' }}>Benefit
                                </option>
                                <option value="cost" {{ old('category')=='cost' ? 'selected' : '' }}>Cost</option>
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Bobot</label>
                            <input type="text" class="form-control @error('weight') is-invalid @enderror" name="weight"
                                value="{{ old('weight') }}" />
                            @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Table Reference</label>
                            <select name="table_reference" id="table-reference" class="form-control @error('table_reference') is-invalid @enderror">
                                <option value="">-- PILIH TABLE --</option>
                            </select>
                            @error('table_reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="column">Kolom</label>
                            <select name="column_reference" id="column-reference" class="form-control @error('column_reference') is-invalid @enderror" disabled>
                                <option value="">-- PILIH KOLOM --</option>
                            </select>
                            @error('column_reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Form Skor Kriteria</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Batas Bawah</th>
                                    <th>Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= 5; $i++)
                                <tr>
                                    <td>
                                        <input type="number" step="any"
                                            name="scores[{{ $i }}][batas_bawah]"
                                            class="form-control @error("scores.$i.batas_bawah") is-invalid @enderror"
                                            value="{{ old("scores.$i.batas_bawah") ?? 0 }}">
                                        @error("scores.$i.batas_bawah")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" step="any"
                                            name="scores[{{ $i }}][skor]"
                                            class="form-control @error("scores.$i.skor") is-invalid @enderror"
                                            value="{{ old("scores.$i.skor", $i) }}">
                                        @error("scores.$i.skor")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <input type="submit" value="Simpan" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(document).ready(function () {
                const $tableSelect = $('#table-reference');
                const $columnSelect = $('#column-reference');

                $.get('/schema/tables', function (tables) {
                    tables.forEach(function (table) {
                        $tableSelect.append(`<option value="${table}">${table}</option>`);
                    });
                });

                $tableSelect.on('change', function () {
                    const selectedTable = $(this).val();
                    $columnSelect.prop('disabled', true).html('<option value="">-- Pilih Kolom --</option>');

                    if (!selectedTable) return;

                    // Fetch columns
                    $.get(`/schema/columns/${selectedTable}`, function (columns) {
                        $columnSelect.prop('disabled', false);
                        columns.forEach(function (col) {
                            $columnSelect.append(`<option value="${col}">${col}</option>`);
                        });
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>