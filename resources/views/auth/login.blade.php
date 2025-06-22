<x-guest-layout>
    <div class="container-fluid p-0">
        <div class="row no-gutters login-section">
            <!-- KIRI - FORM -->
            <div class="col-md-6 form-container">
                <form class="w-75" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h2 class="mb-4 text-center">Login</h2>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukkan kata sandi">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success btn-block">Masuk</button>
                    <p class="mt-3 text-center">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                </form>
            </div>

            <div class="col-md-6 image-section d-none d-md-block" style="background-image: url('/img/auth.jpg');">
                <div class="overlay"></div>

                <div class="overlay-text">
                    <h1>Selamat Datang di Aplikasi Koperasi BMT Al-Muqrin!</h1>
                    <p>Menjalani ukhuwah, menjaga amanah</p>
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
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100%;
                padding: 0;
            }
            .image-section {
                position: relative;
                background-size: cover;
                background-position: center;
                height: 100%;
                width: 100%;
                object-fit: cover;
                color: white;
            }
            .overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.6); /* overlay gelap */
            }
            .overlay-text {
                position: absolute;
                top: 50%;
                left: 10%;
                z-index: 2;
                transform: translateY(-50%)
            }
        </style>
    </x-slot>
</x-guest-layout>
