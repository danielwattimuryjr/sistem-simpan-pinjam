<x-app-layout>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Nasabah</h1>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Nasabah</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route ('nasabah.edit', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ $user->name }}" />
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ $user->email }}" />
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nomor Induk Kependudukan</label>
                            <input type="text"
                                class="form-control @error('nomor_induk_kependudukan') is-invalid @enderror"
                                name="nomor_induk_kependudukan" value="{{ $user->profile->nomor_induk_kependudukan }}"
                                minlength="10" maxlength="20" />
                            @error('nomor_induk_kependudukan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nomor Rekening</label>
                            <input type="text" class="form-control @error('nomor_rekening') is-invalid @enderror"
                                name="nomor_rekening" value="{{ $user->profile->nomor_rekening }}" minlength="5"
                                maxlength="25" />
                            @error('nomor_rekening')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                <option value="" disabled {{ $user->profile->jenis_kelamin ? '' : 'selected' }}>-- PILIH
                                    JENIS
                                    KELAMIN --</option>
                                <option value="l" {{ $user->profile->jenis_kelamin=='l' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="p" {{ $user->profile->jenis_kelamin=='p' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat"
                                class="form-control @error('alamat') is-invalid @enderror">{{ $user->profile->alamat }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kecamatan</label>
                            <input type="text" class="form-control @error('kecamatan') is-invalid @enderror"
                                name="kecamatan" value="{{ $user->profile->kecamatan }}">
                            @error('kecamatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kabupaten</label>
                            <input type="text" class="form-control @error('kabupaten') is-invalid @enderror"
                                name="kabupaten" value="{{ $user->profile->kabupaten }}">
                            @error('kabupaten')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Provinsi</label>
                            <input type="text" class="form-control @error('provinsi') is-invalid @enderror"
                                name="provinsi" value="{{ $user->profile->provinsi }}">
                            @error('provinsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <input type="submit" value="Update" class="btn btn-warning">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>