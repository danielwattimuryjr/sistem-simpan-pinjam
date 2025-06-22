<x-guest-layout>
    <div class="container-fluid p-0">
        <div class="row no-gutters login-section">
            <div class="col-md-6 bg-white form-container">
                <form class="w-100" style="max-width: 500px; margin: 0 auto;" method="POST" action="{{ route('register') }}">
                    @csrf
                    <h2 class="form-title">Daftar Akun</h2>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" />
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" />
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" />
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nomor Induk Kependudukan</label>
                        <input type="text"
                            class="form-control @error('nomor_induk_kependudukan') is-invalid @enderror"
                            name="nomor_induk_kependudukan" value="{{ old('nomor_induk_kependudukan') }}"
                            minlength="10" maxlength="20" />
                        @error('nomor_induk_kependudukan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nomor Rekening</label>
                        <input type="text" class="form-control @error('nomor_rekening') is-invalid @enderror"
                            name="nomor_rekening" value="{{ old('nomor_rekening') }}" minlength="5"
                            maxlength="25" />
                        @error('nomor_rekening')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                            class="form-control @error('jenis_kelamin') is-invalid @enderror">
                            <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>-- PILIH JENIS
                                KELAMIN --</option>
                            <option value="l" {{ old('jenis_kelamin')=='l' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="p" {{ old('jenis_kelamin')=='p' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat"
                            class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kecamatan</label>
                        <input type="text" class="form-control @error('kecamatan') is-invalid @enderror"
                            name="kecamatan" value="{{ old('kecamatan') }}">
                        @error('kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kabupaten</label>
                        <input type="text" class="form-control @error('kabupaten') is-invalid @enderror"
                            name="kabupaten" value="{{ old('kabupaten') }}">
                        @error('kabupaten')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Provinsi</label>
                        <input type="text" class="form-control @error('provinsi') is-invalid @enderror"
                            name="provinsi" value="{{ old('provinsi') }}">
                        @error('provinsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success btn-block">Daftar</button>
                    <p class="mt-3 text-center">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                </form>
            </div>

            <div class="col-md-6 image-section d-none d-md-block"
                style="background-image: url('/img/auth.jpg');">
                <div class="overlay"></div>
                <div class="overlay-text">
                    <h1>Gabung Sekarang</h1>
                    <p>Buat akunmu dan nikmati semua fitur kami!</p>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="styles">
        <style>
            html, body {
                margin: 0;
                padding: 0;
                height: 100%;
            }

            .login-section {
                height: 100vh;
                margin: 0;
            }

            .form-container {
                height: 100vh;
                overflow-y: auto;
                padding: 2rem;
            }
            .image-section {
                position: relative;
                height: 100%;
                width: 100%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
            .overlay {
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                background-color: rgba(0, 0, 0, 0.6);
            }
            .overlay-text {
                position: absolute;
                top: 50%;
                left: 10%;
                z-index: 2;
                color: white;
                transform: translateY(-50%)
            }

            .form-title {
                text-align: center;
                margin-bottom: 2rem;
            }
        </style>
    </x-slot>
</x-guest-layout>
