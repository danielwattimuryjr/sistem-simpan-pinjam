<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
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

    <x-nav-item :href="route('pinjaman.index')" :active="request()->routeIs('pinjaman.*')">
        <i class="fas fa-fw fa-hand-holding-usd"></i>
        <span>Pinjaman</span>
    </x-nav-item>

    @if (Auth::user()->hasRole('admin'))
        <!-- Heading -->
        <div class="sidebar-heading">
            Settings
        </div>

        <x-nav-item :href="route('criterias.index')" :active="request()->routeIs('criterias.*')">
            <i class="fas fa-fw fa-users"></i>
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