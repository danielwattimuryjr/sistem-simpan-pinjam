<x-app-layout>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Kriteria</h1>
    </div>

    <div class="row">
        <div class="col">
            <form action="{{ route ('criterias.update', $criteria) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Form Kriteria</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Kriteria</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ $criteria->name }}" />
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category" class="form-control @error('category') is-invalid @enderror">
                                <option value="" disabled {{ $criteria->category  ? '' : 'selected' }}>-- PILIH KATEGORI --
                                </option>
                                <option value="benefit" {{ $criteria->category =='benefit' ? 'selected' : '' }}>Benefit
                                </option>
                                <option value="cost" {{ $criteria->category =='cost' ? 'selected' : '' }}>Cost</option>
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Bobot</label>
                            <input type="text" class="form-control @error('weight') is-invalid @enderror" name="weight"
                                value="{{ $criteria->weight }}" />
                            @error('weight')
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
                                @foreach ($criteria->scores as $i => $score)
                                <tr>
                                    <td>
                                        <input
                                            type="number"
                                            step="any"
                                            name="scores[{{ $i + 1 }}][batas_bawah]"
                                            class="form-control @error("scores." . ($i + 1) . ".batas_bawah") is-invalid @enderror"
                                            value="{{ old("scores." . ($i + 1) . ".batas_bawah", $score->batas_bawah) }}">
                                        @error("scores." . ($i + 1) . ".batas_bawah")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input
                                            type="number"
                                            step="any"
                                            name="scores[{{ $i + 1 }}][skor]"
                                            class="form-control @error("scores." . ($i + 1) . ".skor") is-invalid @enderror"
                                            value="{{ old("scores." . ($i + 1) . ".skor", $score->score) }}">
                                        @error("scores." . ($i + 1) . ".skor")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                @endforeach
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
</x-app-layout>