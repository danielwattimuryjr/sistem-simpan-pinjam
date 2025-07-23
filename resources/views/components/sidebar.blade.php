<!-- Sidebar -->
<ul class="navbar-nav sidebar bg-gradient-primary sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="/logo.jpeg" alt="Logo" width="50">
        </div>
        <div class="sidebar-brand-text mx-3">BMT Al-Muqrin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <x-nav-item :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </x-nav-item>


    @if (Auth::user()->hasRole('admin'))
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Data Master
        </div>

        <x-nav-item :href="route('nasabah.index')" :active="request()->routeIs('nasabah.*')">
            <i class="fas fa-fw fa-users"></i>
            <span>Nasabah</span>
        </x-nav-item>
    @endif

    @if (Auth::user()->hasRole('nasabah'))
        <x-nav-item :href="route('pinjaman.create')" :active="request()->routeIs('pinjaman.create')">
            <i class="fas fa-fw fa-hand-holding-usd"></i>
            <span>Permohonan</span>
        </x-nav-item>
    @endif

    <x-nav-item :href="route('pinjaman.index')" :active="request()->routeIs('pinjaman.*') && !request()->routeIs('pinjaman.create') && !request()->routeIs('pinjaman.history')">
        @if (Auth::user()->hasRole('nasabah'))
            <i class="fas fa-fw fa-history"></i>
            <span>History</span>        
        @else
            <i class="fas fa-fw fa-hand-holding-usd"></i>
            <span>Pembiayaan</span>
        @endif
    </x-nav-item>

    @if (Auth::user()->hasRole('admin'))
        <x-nav-item :href="route('pinjaman.history')" :active="request()->routeIs('pinjaman.history')">
            <i class="fas fa-fw fa-history"></i>
            <span>History Pembiayaan</span>
        </x-nav-item>

        <!-- Heading -->
        <div class="sidebar-heading">
            Settings
        </div>

        <x-nav-item :href="route('criterias.index')" :active="request()->routeIs('criterias.*')">
            <i class="fas fa-fw fa-sliders-h"></i>
            <span>Kriteria</span>
        </x-nav-item>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->