<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="/logo.jpeg">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    @vite(['resources/css/sb-admin-2.min.css', 'resources/js/sb-admin-2.min.js'])

    @isset ($styles)
    {{ $styles }}
    @endisset
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <x-sidebar />

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <x-topbar />

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    {{ $slot }}
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <x-footer />

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a class="btn btn-primary" :href="route('logout')" onclick="event.preventDefault();
                                                                    this.closest('form').submit();">Logout</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Sweetalert2 JavaScript-->
    <script src="/vendor/sweet-alert/sweetalert2.js"></script>
    @if (session('success'))
    <script>
        Swal.fire({
                icon: 'success',
                title: 'Success',
                text: @json(session('success')),
            });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
                icon: 'error',
                title: 'Error',
                text: @json(session('error')),
            });
    </script>
    @endif

    @isset ($scripts)
    {{ $scripts }}
    @endisset
</body>

</html>