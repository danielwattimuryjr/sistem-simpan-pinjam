@php
    $background = null;
@endphp
<x-app-layout :background="Auth::user()->hasRole('admin') ? $background : null">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Selamat datang, {{ Auth::user()->name }}! 👋</h1>
    </div>

    @if (Auth::user()->hasRole('nasabah'))
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center">VISI</h5>
                    <ol>
                        <li class="mb-2">Membangun dan mengembangkan ekomomi umat dengan konsep dasar atau landasan sesuai syariah Islam</li>
                        <li>Menanamkan pemahaman bahwa konsep syariah adalah konsep yang mudah, murah dan maslaha.</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center">MISI</h5>
                    <ol>
                        <li class="mb-2">Menciptakan Wata’awun ‘Alal Birri Wat Taqwa yaitu tolong menolong lewat ekonomi umat.</li>
                        <li>Memberantas riba.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>