<x-app-layout>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengajuan Pinjaman</h1>
    </div>

    <div class="row">
        <div class="col">
            <form action="{{ route ('pinjaman.store') }}" method="POST">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Form Permohonan Pinjaman</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Total Pendapatan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Rp.
                                    </span>
                                </div>
                                <input type="text" class="form-control @error('pendapatan') is-invalid @enderror"
                                    name="pendapatan" value="{{ old('pendapatan') }}" />
                                @error('pendapatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jumlah Tanggungan</label>
                            <input type="text" class="form-control @error('jumlah_tanggungan') is-invalid @enderror"
                                name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan') }}" />
                            @error('jumlah_tanggungan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Total Jaminan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Rp.
                                    </span>
                                </div>
                                <input type="text" class="form-control @error('jaminan') is-invalid @enderror"
                                    name="jaminan" value="{{ old('jaminan') }}" />
                                @error('jaminan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jumlah Pinjaman</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Rp.
                                    </span>
                                </div>
                                <input type="text" class="form-control @error('jumlah_pinjaman') is-invalid @enderror"
                                    name="jumlah_pinjaman" value="{{ old('jumlah_pinjaman') }}" />
                                @error('jumlah_pinjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <input type="submit" value="Simpan" class="btn btn-primary">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>